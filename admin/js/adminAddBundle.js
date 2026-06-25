document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('bundleForm');
    const saveBtn = document.getElementById('saveBtn');

    let bundleProducts = [];
    let highlights = [];
    let selectedFile = null;

    // =========================
    // INIT
    // =========================
    try {
        initPhotoManager();
        initStatusButtons();
        renderProducts();
        renderHighlights();
        initPriceCalculation();

        saveBtn.addEventListener('click', handleSave);

    } catch (error) {
        console.error('Init error:', error);

        showAlert({
            type: 'error',
            title: 'Fout',
            message: 'Pagina laden mislukt'
        });
    }

    // =========================
    // PHOTO
    // =========================
    function initPhotoManager() {
        const input = document.getElementById('photoInput');
        const main = document.getElementById('photoMain');
        const img = document.getElementById('photoMainImg');
        const empty = document.getElementById('photoMainEmpty');

        main.addEventListener('click', () => input.click());

        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            selectedFile = file;

            const reader = new FileReader();
            reader.onload = (evt) => {
                img.src = evt.target.result;
                img.hidden = false;
                empty.hidden = true;
            };

            reader.readAsDataURL(file);
        });

        window.uploadBundlePhoto = async function (bundleId) {
            if (!selectedFile) return;

            const fd = new FormData();
            fd.append('photo', selectedFile);

            const res = await fetch(`/api/upload_bundle_photo/${bundleId}`, {
                method: 'POST',
                body: fd
            });

            if (!res.ok) throw new Error('Foto upload mislukt');
        };
    }

    // =========================
    // STATUS
    // =========================
    function initStatusButtons() {
        const buttons = document.querySelectorAll('.status-btn');
        const hiddenInput = document.getElementById('bundleStatus');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('status-btn--active'));
                btn.classList.add('status-btn--active');
                hiddenInput.value = btn.dataset.status;
            });
        });
    }

    // =========================
    // PRODUCTS
    // =========================
    function renderProducts() {
        const container = document.getElementById('bundleProductsList');
        container.replaceChildren();

        if (!bundleProducts.length) {
            const empty = document.createElement('p');
            empty.textContent = 'Geen producten';
            empty.style.textAlign = 'center';
            container.append(empty);
            return;
        }

        bundleProducts.forEach((product, index) => {
            const item = document.createElement('div');
            item.className = 'bundle-product-item';

            item.innerHTML = `
                <div class="bundle-product-info">
                    <p class="bundle-product-name">${product.product_name}</p>
                    <p class="bundle-product-price">€ ${product.price.toFixed(2)}</p>
                </div>

                <div class="bundle-product-qty">
                    <button type="button">-</button>
                    <input value="${product.quantity}">
                    <button type="button">+</button>
                </div>

                <button class="bundle-product-remove">✕</button>
            `;

            const [minus, plus] = item.querySelectorAll('.bundle-product-qty button');
            const input = item.querySelector('input');
            const remove = item.querySelector('.bundle-product-remove');

            minus.onclick = () => {
                if (product.quantity > 1) {
                    product.quantity--;
                    input.value = product.quantity;
                    updatePrices();
                }
            };

            plus.onclick = () => {
                product.quantity++;
                input.value = product.quantity;
                updatePrices();
            };

            remove.onclick = () => {
                bundleProducts.splice(index, 1);
                renderProducts();
                updatePrices();
            };

            container.append(item);
        });

        updatePrices();
    }

    // =========================
    // HIGHLIGHTS
    // =========================
    function renderHighlights() {
        const container = document.getElementById('bundleHighlightsList');
        container.replaceChildren();

        highlights.forEach((text, index) => {
            const item = document.createElement('div');
            item.className = 'bundle-highlight-item';

            item.innerHTML = `
                <i class="ti ti-check"></i>
                <input value="${text}">
                <button class="bundle-highlight-remove">✕</button>
            `;

            const input = item.querySelector('input');
            const remove = item.querySelector('button');

            input.oninput = () => highlights[index] = input.value;

            remove.onclick = () => {
                highlights.splice(index, 1);
                renderHighlights();
            };

            container.append(item);
        });
    }

    const addHighlightBtn = document.getElementById('addHighlightBtn');
    if (addHighlightBtn) {
        addHighlightBtn.onclick = () => {
            highlights.push('');
            renderHighlights();
        };
    }

    // =========================
    // PRICE
    // =========================
    function initPriceCalculation() {
        const priceInput = document.getElementById('bundlePrice');
        if (priceInput) {
            priceInput.addEventListener('input', updatePrices);
        }
    }

    function updatePrices() {
        const productValue = bundleProducts.reduce(
            (sum, p) => sum + (p.price * p.quantity), 0
        );

        const bundlePrice = parseFloat(
            document.getElementById('bundlePrice').value
        ) || 0;

        document.getElementById('productValueTotal').textContent =
            `€ ${productValue.toFixed(2)}`;

        document.getElementById('originalPriceTotal').textContent =
            `€ ${productValue.toFixed(2)}`;

        document.getElementById('bundlePriceTotal').textContent =
            `€ ${bundlePrice.toFixed(2)}`;
    }

    // =========================
    // SAVE
    // =========================
    async function handleSave() {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Opslaan...';

        try {
            const payload = {
                name: document.getElementById('bundleName').value,
                description: document.getElementById('bundleDescription').value,
                price: parseFloat(document.getElementById('bundlePrice').value) || 0,
                sku: document.getElementById('bundleSku').value,
                status: document.getElementById('bundleStatus').value,
                products: bundleProducts,
                highlights
            };

            const res = await fetch('/api/create_bundle', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error('Aanmaken mislukt');

            const json = await res.json();
            const bundleId = json.id;

            if (window.uploadBundlePhoto) {
                await window.uploadBundlePhoto(bundleId);
            }

            showAlert({
                type: 'success',
                title: 'Gelukt!',
                message: 'Bundel aangemaakt',
                buttons: [
                    {
                        text: 'Terug',
                        type: 'primary',
                        action: () => window.location.href = '/admin/bundels'
                    }
                ]
            });

        } catch (error) {
            console.error(error);

            showAlert({
                type: 'error',
                title: 'Fout',
                message: error.message
            });

            saveBtn.disabled = false;
            saveBtn.textContent = 'Opslaan';
        }
    }

});