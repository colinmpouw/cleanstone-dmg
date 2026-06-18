let cartData = [];

async function loadCart() {
    try {
        const response = await fetch('/api/get_all_cart_item');
        const result = await response.json();

        if (!result.success) return;

        // normalize price to a number once, here, instead of everywhere else
        cartData = result.data.map(item => ({
            ...item,
            price: parseFloat(item.price)
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

    // ✅ product info
    const productInfo = document.createElement('div');
    productInfo.className = 'product-info';

    const imageDiv = document.createElement('div');
    imageDiv.className = 'image';

    if (item.image) {
        const img = document.createElement('img');
        img.src = `/uploads/products/${item.image}`;
        img.alt = item.name;
        imageDiv.appendChild(img);
    }

    const infoText = document.createElement('div');

    // brand can be null, so only render it if present
    if (item.brand) {
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

    if (item.stock <= 0) {
        const outOfStock = document.createElement('p');
        outOfStock.className = 'out-of-stock';
        outOfStock.textContent = 'Out of stock';
        infoText.appendChild(outOfStock);
    }

    productInfo.append(imageDiv, infoText);

    // ✅ actions
    const actions = document.createElement('div');
    actions.className = 'product-actions';

    // ✅ DELETE BUTTON
    const deleteBtn = document.createElement('button');
    deleteBtn.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.5 5H17.5" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M15.8333 5V16.6667C15.8333 17.5 15 18.3333 14.1666 18.3333H5.83329C4.99996 18.3333 4.16663 17.5 4.16663 16.6667V5" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6.66663 4.99935V3.33268C6.66663 2.49935 7.49996 1.66602 8.33329 1.66602H11.6666C12.5 1.66602 13.3333 2.49935 13.3333 3.33268V4.99935" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8.33337 9.16602V14.166" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M11.6666 9.16602V14.166" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    `;
    deleteBtn.className = 'delete';

    // ✅ DELETE
    deleteBtn.addEventListener('click', async () => {
        try {
            const res = await fetch(`/api/remove_from_cart/${item.cart_item_id}`, {
                method: 'DELETE'
            });

            if (!res.ok) throw new Error('Delete request failed');

            cartData = cartData.filter(i => i.cart_item_id !== item.cart_item_id);

            cartItem.remove();
            updateSummary(cartData);

        } catch (err) {
            console.error('Failed to remove item from cart', err);
        }
    });

    // ✅ QUANTITY
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

    // ✅ total price
    const totalPrice = document.createElement('p');
    let currentQty = item.quantity;

    function updateTotal() {
        totalPrice.textContent = `€${(currentQty * item.price).toFixed(2)}`;
    }

    function refreshButtonStates() {
        minus.disabled = currentQty <= 1;
        plus.disabled = item.stock > 0 && currentQty >= item.stock;
    }

    updateTotal();
    refreshButtonStates();

    // ✅ UPDATE API
    async function updateQuantityOnServer() {
        try {
            const form=FormData

            await fetch('/api/change_cart_quantity', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    cart_item_id: item.cart_item_id,
                    quantity: currentQty
                })
            });
        } catch (err) {
            console.error('Failed to update quantity', err);
        }
    }

    // ➕ PLUS
    plus.addEventListener('click', async () => {
        if (item.stock > 0 && currentQty >= item.stock) return;

        currentQty++;
        qty.textContent = currentQty;

        item.quantity = currentQty;
        updateTotal();
        refreshButtonStates();
        updateSummary(cartData);

        await updateQuantityOnServer();
    });

    // ➖ MINUS
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

    quantity.append(minus, qty, plus);
    actions.append(deleteBtn, quantity, totalPrice);

    cartItem.append(productInfo, actions);

    return cartItem;
}

function updateSummary(cartData) {
    const receiptContainer = document.querySelector('.receipt-items');
    receiptContainer.innerHTML = '';

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

        row.appendChild(name);
        row.appendChild(price);

        receiptContainer.appendChild(row);
    });

    document.querySelector('.subtotal-price').textContent = `€${subtotal.toFixed(2)}`;
    document.querySelector('.total-price').textContent = `€${subtotal.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', loadCart);