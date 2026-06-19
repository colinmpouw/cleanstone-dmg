let cartData = [];
let discountData = null;
let currentStep = 1;
let selectedShipping = { label: 'PostNL Standaard', price: 5.95 };
const FREE_SHIPPING_THRESHOLD = 50;

function getShippingCost(subtotal, selectedShipping) {
    if (subtotal >= FREE_SHIPPING_THRESHOLD && selectedShipping.label === 'PostNL Standaard') {
        return 0;
    }
    return selectedShipping.price;
}
/* ── Step navigation ────────────────────────────────── */
function goTo(n) {
    document.getElementById('tab-' + currentStep).classList.remove('active');
    currentStep = n;
    document.getElementById('tab-' + n).classList.add('active');
    updateStepper();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateStepper() {
    document.querySelectorAll('.step').forEach(step => {
        const s = parseInt(step.dataset.step);
        step.classList.remove('active', 'done');
        if (s === currentStep) step.classList.add('active');
        if (s < currentStep) step.classList.add('done');
    });

    document.getElementById('line-1').classList.toggle('done', currentStep > 1);
    document.getElementById('line-2').classList.toggle('done', currentStep > 2);
}

/* ── Step 1 validation ──────────────────────────────── */
document.getElementById('btn-to-2').addEventListener('click', () => {
    const fields = ['voornaam', 'achternaam', 'email', 'telefoon', 'straat', 'postcode', 'plaats'];
    let valid = true;

    fields.forEach(id => {
        const input = document.getElementById(id);
        if (!input.value.trim()) {
            input.classList.add('invalid');
            valid = false;
        } else {
            input.classList.remove('invalid');
        }
    });

    const errorEl = document.getElementById('error-1');
    if (!valid) {
        errorEl.textContent = 'Vul alle verplichte velden in.';
        return;
    }
    errorEl.textContent = '';
    goTo(2);
});

/* ── Step 2 → 3 ─────────────────────────────────────── */
document.getElementById('btn-to-3').addEventListener('click', () => {
    goTo(3);
});

/* ── Shipping selection ──────────────────────────────── */
document.querySelectorAll('.shipping-options').forEach(group => {
    group.querySelectorAll('.shipping-option').forEach(option => {
        option.addEventListener('click', () => {
            group.querySelectorAll('.shipping-option').forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');

            const radio = option.querySelector('input[type="radio"]');
            if (radio && radio.name === 'shipping') {
                selectedShipping = {
                    label: radio.dataset.label,
                    price: parseFloat(radio.value)
                };
                updateSummary(cartData);
            }
        });
    });
});

/* ── Place order ─────────────────────────────────────── */
document.getElementById('btn-place-order').addEventListener('click', () => {
    const paymentEl = document.querySelector('input[name="payment"]:checked');
    const payment = paymentEl ? paymentEl.value : null;
    if (!payment) return;

    const orderData = {
        voornaam: document.getElementById('voornaam').value,
        achternaam: document.getElementById('achternaam').value,
        email: document.getElementById('email').value,
        telefoon: document.getElementById('telefoon').value,
        straat: document.getElementById('straat').value,
        postcode: document.getElementById('postcode').value,
        plaats: document.getElementById('plaats').value,
        shipping: selectedShipping,
        payment: payment,
        discount: discountData ? discountData.code : null
    };

    console.log('Order data:', orderData);

    // TODO: POST to /api/place_order
    // fetch('/api/place_order', { method: 'POST', body: JSON.stringify(orderData), headers: { 'Content-Type': 'application/json' } })
    //     .then(res => res.json())
    //     .then(data => { if (data.success) window.location.href = '/bedankt'; });
});

/* ── Cart loading (reuse from cart.js) ──────────────── */
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

        updateSummary(cartData);
    } catch (error) {
        console.error(error);
    }
}

/* ── Summary update ──────────────────────────────────── */
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

    const shippingCost = getShippingCost(subtotal, selectedShipping);
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


document.addEventListener('DOMContentLoaded', loadCart);