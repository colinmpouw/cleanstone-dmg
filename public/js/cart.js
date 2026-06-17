async function loadCart() {
    try {
        const response = await fetch('/api/get_all_cart_item');
        const result = await response.json();

        const cartContainer = document.querySelector('.cart-items');
        cartContainer.innerHTML = '';
        if (!result.success) {
            console.error(result.message);
            return;
        }
        const data = result.data;
        data.forEach(item => {
            const cartItem = createCartItem(item);
            cartContainer.appendChild(cartItem);
        });

        // Toevoegen van de "Verder winkelen" link
        const backLink = document.createElement('a');
        backLink.href = "#";
        backLink.className = "back";
        backLink.textContent = "← Verder winkelen";

        cartContainer.appendChild(backLink);

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
        img.src = item.image;
        imageDiv.appendChild(img);
    }

    const infoText = document.createElement('div');

    const brand = document.createElement('p');
    brand.textContent = item.brand;

    const name = document.createElement('h3');
    name.textContent = item.name;

    const price = document.createElement('p');
    price.textContent = `€${item.price.toFixed(2)}`;

    infoText.append(brand, name, price);
    productInfo.append(imageDiv, infoText);

    // ✅ actions
    const actions = document.createElement('div');
    actions.className = 'product-actions';

    // ✅ DELETE BUTTON
    const deleteBtn = document.createElement('button');
    deleteBtn.innerHTML=`
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2.5 5H17.5" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15.8333 5V16.6667C15.8333 17.5 15 18.3333 14.1666 18.3333H5.83329C4.99996 18.3333 4.16663 17.5 4.16663 16.6667V5" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6.66663 4.99935V3.33268C6.66663 2.49935 7.49996 1.66602 8.33329 1.66602H11.6666C12.5 1.66602 13.3333 2.49935 13.3333 3.33268V4.99935" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.33337 9.16602V14.166" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M11.6666 9.16602V14.166" stroke="#FB2C36" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

    `
    deleteBtn.className='delete';

    deleteBtn.addEventListener('click', async () => {
        try {
            await fetch(`/api/remove_from_cart/${item.id}`, {
                method: 'DELETE'
            });

            cartItem.remove(); // remove from UI
        } catch (err) {
            console.error('删除失败', err);
        }
    });

    // ✅ QUANTITY
    const quantity = document.createElement('div');
    quantity.className = 'quantity';


    const minus = document.createElement('button');
    minus.textContent = '-';

    const qty = document.createElement('span');
    qty.textContent = item.quantity;

    const plus = document.createElement('button');
    plus.textContent = '+';

    // ✅ total price
    const totalPrice = document.createElement('p');
    let currentQty = item.quantity;

    function updateTotal() {
        totalPrice.textContent = `€${(currentQty * item.price).toFixed(2)}`;
    }

    updateTotal();

    // ✅ UPDATE API
    async function updateQuantityOnServer() {
        try {
            await fetch('/api/change_cart_quantity', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: item.id,
                    quantity: currentQty
                })
            });
        } catch (err) {
            console.error('更新数量失败', err);
        }
    }

    // ➕ PLUS
    plus.addEventListener('click', async () => {
        currentQty++;
        qty.textContent = currentQty;
        loadCart();
        updateTotal();
        await updateQuantityOnServer();
    });

    // ➖ MINUS
    minus.addEventListener('click', async () => {
        if (currentQty > 1) {
            currentQty--;
            qty.textContent = currentQty;
            loadCart();
            updateTotal();
            await updateQuantityOnServer();
        }
    });

    quantity.append(minus, qty, plus);
    actions.append(deleteBtn, quantity, totalPrice);

    cartItem.append(productInfo, actions);

    return cartItem;
}

document.addEventListener('DOMContentLoaded', loadCart);