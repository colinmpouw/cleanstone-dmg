let cartData = [];
let discountData = null;
let currentStep = 1;
let selectedShipping = { label: 'PostNL Standaard', price: 5.95 };
let savedAddresses = [];
let selectedAddressId = null; // null means "new address" is being used
const FREE_SHIPPING_THRESHOLD = 50;

function getShippingCost(subtotal, selectedShipping) {
    if (subtotal >= FREE_SHIPPING_THRESHOLD) {
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

/* ── Address loading ─────────────────────────────────── */
async function loadAddresses() {
    try {
        const response = await fetch('/api/get_all_addresses');
        const result = await response.json();

        if (!result.success) return;

        savedAddresses = result.data;
        renderAddressPicker();
    } catch (error) {
        console.error(error);
    }
}

function renderAddressPicker() {
    const container = document.getElementById('saved-addresses');
    container.innerHTML = '';

    savedAddresses.forEach(addr => {
        const label = document.createElement('label');
        label.className = 'shipping-option';
        if (addr.invoice_address === 1 || addr.invoice_address === '1') {
            label.classList.add('selected');
            selectedAddressId = addr.id;
        }

        const radio = document.createElement('input');
        radio.type = 'radio';
        radio.name = 'address-choice';
        radio.value = addr.id;
        if (selectedAddressId === addr.id) radio.checked = true;

        const info = document.createElement('div');
        info.className = 'ship-info';

        const name = document.createElement('span');
        name.className = 'ship-name';
        name.textContent = `${addr.first_name} ${addr.last_name}`;

        const sub = document.createElement('span');
        sub.className = 'ship-sub';
        sub.textContent = `${addr.street} ${addr.house_number}, ${addr.postal_code} ${addr.city}`;

        info.append(name, sub);
        label.append(radio, info);
        container.appendChild(label);

        label.addEventListener('click', () => {
            document.querySelectorAll('#saved-addresses .shipping-option, #new-address-toggle')
                .forEach(o => o.classList.remove('selected'));
            label.classList.add('selected');
            radio.checked = true;
            selectedAddressId = addr.id;
            document.getElementById('new-address-form').style.display = 'none';
        });
    });

    // If no saved addresses at all, force the new-address form open
    if (savedAddresses.length === 0) {
        selectedAddressId = null;
        document.getElementById('new-address-toggle').style.display = 'none';
        document.getElementById('new-address-form').style.display = 'block';
    }
}

document.getElementById('new-address-toggle').addEventListener('click', () => {
    document.querySelectorAll('#saved-addresses .shipping-option, #new-address-toggle')
        .forEach(o => o.classList.remove('selected'));
    document.getElementById('new-address-toggle').classList.add('selected');
    document.getElementById('radio-new-address').checked = true;
    selectedAddressId = null;
    document.getElementById('new-address-form').style.display = 'block';
});

/* ── Step 1 validation ──────────────────────────────── */
document.getElementById('btn-to-2').addEventListener('click', async () => {
    const errorEl = document.getElementById('error-1');


    if (selectedAddressId !== null) {
        errorEl.textContent = '';
        goTo(2);
    }

    const emailInput = document.getElementById('email');
    const telefoonInput = document.getElementById('telefoon');

    if (!emailInput.value.trim() || !telefoonInput.value.trim()) {
        errorEl.textContent = 'Vul uw e-mailadres en telefoonnummer in.';
        return;
    }

    if (selectedAddressId === null) {
        const fields = ['voornaam', 'achternaam', 'straat', 'huisnummer', 'postcode', 'plaats'];
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

        if (!valid) {
            errorEl.textContent = 'Vul alle verplichte velden in.';
            return;
        }

        // Save the new address before continuing
        try {
            const res = await fetch('/api/add_address', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    first_name: document.getElementById('voornaam').value,
                    last_name: document.getElementById('achternaam').value,
                    street: document.getElementById('straat').value,
                    house_number: document.getElementById('huisnummer').value,
                    postal_code: document.getElementById('postcode').value,
                    city: document.getElementById('plaats').value,
                    country: 'Nederland',
                    phone: telefoonInput.value,
                    email: emailInput.value,
                    invoice_address: document.getElementById('set-as-default').checked ? 1 : 0
                })
            });
            const data = await res.json();
            if (data.success) {
                selectedAddressId = data.data.id;
            } else {
                errorEl.textContent = data.message || 'Kon adres niet opslaan.';
                return;
            }
        } catch (err) {
            console.error(err);
            errorEl.textContent = 'Kon adres niet opslaan.';
            return;
        }
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
        address_id: selectedAddressId,
        shipping: selectedShipping.label,
        payment: payment,
        discount: discountData.code
    };

    console.log('Order data:', orderData);

    fetch('/api/place_order', {
        method: 'POST',
        body: JSON.stringify(orderData),
        headers: {'Content-Type': 'application/json'}
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) window.location.href = '/bedankt';
        });
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
                input.style.border = '2px solid var(--green)';
                discountData = data.data;
            } else {
                input.style.border = '2px solid red';
                discountData = null;
            }

            updateSummary(cartData);
        })
        .catch(err => console.error(err));
});
document.addEventListener('DOMContentLoaded', () => {
    loadCart();
    loadAddresses();
});