let cartData = [];
let discountData = null;
const FREE_SHIPPING_THRESHOLD = 50;

function getShippingCost(subtotal) {
    return subtotal >= FREE_SHIPPING_THRESHOLD ? 0 : 5.95;
}

async function loadCart() {
    try {
        const response = await fetch('/api/get_all_cart_item');
        const result = await response.json();

        if (!result.success) return;

        cartData = result.data.map(item => ({
            ...item,
            name: item.bundle_id ? item.bundle_name : item.product_name,
            price: parseFloat(item.bundle_id ? item.bundle_price : item.product_price),
            image: item.bundle_id ? item.bundle_image : item.product_image
        }));

        const cartContainer = document.querySelector('.cart-items');
        cartContainer.innerHTML = '';

        cartData.forEach(item => {
            const cartItem = createCartItem(item);
            cartContainer.appendChild(cartItem);
        });

        updateSummary(cartData);

    } catch (error) {
        console.error(error);
    }
}

function createCartItem(item) {
    const cartItem = document.createElement('div');
    cartItem.className = 'cart-item';

    const productInfo = document.createElement('div');
    productInfo.className = 'product-info';

    const imageDiv = document.createElement('div');
    imageDiv.className = 'image';

    if (item.image) {
        const img = document.createElement('img');
        img.src = item.bundle_id
            ? `/uploads/bundles/${item.image}`
            : `/uploads/products/${item.image}`;
        img.alt = item.name;
        imageDiv.appendChild(img);
    }

    const infoText = document.createElement('div');

    if (item.brand && !item.bundle_id) {
        const brand = document.createElement('p');
        brand.className = 'brand';
        brand.textContent = item.brand;
        infoText.appendChild(brand);
    }

    const name = document.createElement('h3');
    name.textContent = item.name;
    infoText.appendChild(name);

    const price = document.createElement('p');
    price.className = 'unit-price';
    price.textContent = `€${item.price.toFixed(2)}`;
    infoText.appendChild(price);

    if (!item.bundle_id && item.stock <= 0) {
        const outOfStock = document.createElement('p');
        outOfStock.className = 'out-of-stock';
        outOfStock.textContent = 'Out of stock';
        infoText.appendChild(outOfStock);
    }

    productInfo.append(imageDiv, infoText);

    const actions = document.createElement('div');
    actions.className = 'product-actions';

    const deleteBtn = document.createElement('button');
    deleteBtn.className = 'delete';
    deleteBtn.innerHTML = `🗑`;

    deleteBtn.addEventListener('click', async () => {
        let itemId
        try {
            const res = await fetch(`/api/remove_from_cart`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    cart_item_id: item.cart_item_id,
                    bundle_id: item.bundle_id,
                    quantity: currentQty
                })
            });

            if (!res.ok) throw new Error();

            cartData = cartData.filter(i => i.cart_item_id !== item.cart_item_id);
            cartItem.remove();
            updateSummary(cartData);

        } catch (err) {
            console.error(err);
        }
    });

    const quantity = document.createElement('div');
    quantity.className = 'quantity';

    const minus = document.createElement('button');
    minus.textContent = '-';
    minus.type = 'button';

    const qty = document.createElement('span');
    qty.textContent = item.quantity;

    const plus = document.createElement('button');
    plus.textContent = '+';
    plus.type = 'button';

    const totalPrice = document.createElement('p');
    let currentQty = item.quantity;

    function updateTotal() {
        totalPrice.textContent = `€${(currentQty * item.price).toFixed(2)}`;
    }

    function refreshButtonStates() {
        minus.disabled = currentQty <= 1;
        if (!item.bundle_id) {
            plus.disabled = item.stock > 0 && currentQty >= item.stock;
        }
    }

    async function updateQuantityOnServer() {
        await fetch('/api/change_cart_quantity', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                cart_item_id: item.cart_item_id,
                bundle_id: item.bundle_id,
                quantity: currentQty
            })
        });
    }

    plus.addEventListener('click', async () => {
        currentQty++;
        qty.textContent = currentQty;
        item.quantity = currentQty;
        await updateQuantityOnServer();
        updateTotal();
        refreshButtonStates();
        updateSummary(cartData);


    });

    minus.addEventListener('click', async () => {
        if (currentQty > 1) {
            currentQty--;
            qty.textContent = currentQty;
            item.quantity = currentQty;

            updateTotal();
            refreshButtonStates();
            updateSummary(cartData);

            await updateQuantityOnServer();
        }
    });

    updateTotal();
    refreshButtonStates();

    quantity.append(minus, qty, plus);
    actions.append(deleteBtn, quantity, totalPrice);

    cartItem.append(productInfo, actions);

    return cartItem;
}

function updateSummary(cartData) {
    const receiptContainer = document.querySelector('.receipt-items');
    const discountContainer = document.querySelector('#discounted-value');

    receiptContainer.innerHTML = '';
    discountContainer.innerHTML = '';

    let subtotal = 0;

    cartData.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        const row = document.createElement('div');
        row.className = 'row';

        const name = document.createElement('span');
        name.textContent = `${item.name} x${item.quantity}`;

        const price = document.createElement('span');
        price.textContent = `€${itemTotal.toFixed(2)}`;

        row.append(name, price);
        receiptContainer.appendChild(row);
    });

    let discountAmount = 0;

    if (discountData) {
        const meetsMinOrder =
            !discountData.min_order_amount ||
            subtotal >= parseFloat(discountData.min_order_amount);

        if (meetsMinOrder) {
            if (discountData.type === 'percentage') {
                discountAmount = subtotal * (discountData.value / 100);

                if (discountData.max_discount) {
                    discountAmount = Math.min(
                        discountAmount,
                        parseFloat(discountData.max_discount)
                    );
                }
            } else {
                discountAmount = parseFloat(discountData.value);
            }

            const discountRow = document.createElement('div');
            discountRow.className = 'row discount-row';

            const discountName = document.createElement('span');
            discountName.textContent = `Discount (${discountData.code})`;

            const discountPrice = document.createElement('span');
            discountPrice.textContent = `-€${discountAmount.toFixed(2)}`;

            discountRow.append(discountName, discountPrice);
            discountContainer.appendChild(discountRow);
        }
    }

    const shippingCost = getShippingCost(subtotal);
    const total = (subtotal - discountAmount) + shippingCost;
    const btw = total * 21 / 121;

    document.querySelector('.subtotal-price').textContent = `€${subtotal.toFixed(2)}`;
    document.querySelector('.shipping-price').textContent = shippingCost === 0 ? 'GRATIS' : `€${shippingCost.toFixed(2)}`;
    document.querySelector('.btw-price').textContent = `€${btw.toFixed(2)}`;
    document.querySelector('.total-price').textContent = `€${total.toFixed(2)}`;

    const discountEl = document.querySelector('.discount-price');
    if (discountEl) {
        discountEl.textContent = `-€${discountAmount.toFixed(2)}`;
    }
}

document.querySelector('.discount').addEventListener('submit', (e) => {
    e.preventDefault();

    const input = document.querySelector('.discount input');

    const formData = new FormData();
    formData.append('discount', input.value);

    fetch('/api/check_discount', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                input.style.border = '2px solid green';
                discountData = data.data;
                console.log(discountData);
            } else {
                input.style.border = '2px solid red';
                discountData = null;
            }

            updateSummary(cartData);
        })
        .catch(err => console.error(err));
});

document.addEventListener('DOMContentLoaded', loadCart);