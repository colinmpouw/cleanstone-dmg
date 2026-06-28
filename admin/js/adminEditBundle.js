const REMOVE_ICON_SVG = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.3094 2.25002H13.6908C13.9072 2.24988 14.0957 2.24976 14.2737 2.27819C14.977 2.39049 15.5856 2.82915 15.9146 3.46084C15.9978 3.62073 16.0573 3.79961 16.1256 4.00494L16.2373 4.33984C16.2562 4.39653 16.2616 4.41258 16.2661 4.42522C16.4413 4.90933 16.8953 5.23659 17.4099 5.24964C17.4235 5.24998 17.44 5.25004 17.5001 5.25004H20.5001C20.9143 5.25004 21.2501 5.58582 21.2501 6.00004C21.2501 6.41425 20.9143 6.75004 20.5001 6.75004H3.5C3.08579 6.75004 2.75 6.41425 2.75 6.00004C2.75 5.58582 3.08579 5.25004 3.5 5.25004H6.50008C6.56013 5.25004 6.5767 5.24998 6.59023 5.24964C7.10488 5.23659 7.55891 4.90936 7.73402 4.42524C7.73863 4.41251 7.74392 4.39681 7.76291 4.33984L7.87452 4.00496C7.94281 3.79964 8.00233 3.62073 8.08559 3.46084C8.41453 2.82915 9.02313 2.39049 9.72643 2.27819C9.90445 2.24976 10.093 2.24988 10.3094 2.25002ZM9.00815 5.25004C9.05966 5.14902 9.10531 5.04404 9.14458 4.93548C9.1565 4.90251 9.1682 4.86742 9.18322 4.82234L9.28302 4.52292C9.37419 4.24941 9.39519 4.19363 9.41601 4.15364C9.52566 3.94307 9.72853 3.79686 9.96296 3.75942C10.0075 3.75231 10.067 3.75004 10.3553 3.75004H13.6448C13.9331 3.75004 13.9927 3.75231 14.0372 3.75942C14.2716 3.79686 14.4745 3.94307 14.5842 4.15364C14.605 4.19363 14.626 4.2494 14.7171 4.52292L14.8169 4.82216L14.8556 4.9355C14.8949 5.04405 14.9405 5.14902 14.992 5.25004H9.00815Z" fill="var(--red)"></path><path d="M5.91509 8.45015C5.88754 8.03685 5.53016 7.72415 5.11686 7.7517C4.70357 7.77925 4.39086 8.13663 4.41841 8.54993L4.88186 15.5017C4.96736 16.7844 5.03642 17.8205 5.19839 18.6336C5.36679 19.4789 5.65321 20.185 6.2448 20.7385C6.8364 21.2919 7.55995 21.5308 8.4146 21.6425C9.23662 21.7501 10.275 21.7501 11.5606 21.75H12.4395C13.7251 21.7501 14.7635 21.7501 15.5856 21.6425C16.4402 21.5308 17.1638 21.2919 17.7554 20.7385C18.347 20.185 18.6334 19.4789 18.8018 18.6336C18.9638 17.8206 19.0328 16.7844 19.1183 15.5017L19.5818 8.54993C19.6093 8.13663 19.2966 7.77925 18.8833 7.7517C18.47 7.72415 18.1126 8.03685 18.0851 8.45015L17.6251 15.3493C17.5353 16.6971 17.4713 17.6349 17.3307 18.3406C17.1943 19.025 17.004 19.3873 16.7306 19.6431C16.4572 19.8989 16.083 20.0647 15.391 20.1552C14.6776 20.2485 13.7376 20.25 12.3868 20.25H11.6134C10.2626 20.25 9.32255 20.2485 8.60915 20.1552C7.91715 20.0647 7.54299 19.8989 7.26958 19.6431C6.99617 19.3873 6.80583 19.025 6.66948 18.3406C6.52892 17.6349 6.46489 16.6971 6.37503 15.3493L5.91509 8.45015Z" fill="var(--red)"></path><path d="M9.42546 10.2538C9.83762 10.2125 10.2052 10.5133 10.2464 10.9254L10.7464 15.9254C10.7876 16.3376 10.4869 16.7051 10.0747 16.7463C9.66256 16.7875 9.29503 16.4868 9.25381 16.0747L8.75381 11.0747C8.7126 10.6625 9.01331 10.295 9.42546 10.2538Z" fill="var(--red)"></path><path d="M14.5747 10.2538C14.9869 10.295 15.2876 10.6625 15.2464 11.0747L14.7464 16.0747C14.7052 16.4868 14.3376 16.7875 13.9255 16.7463C13.5133 16.7051 13.2126 16.3376 13.2538 15.9254L13.7538 10.9254C13.795 10.5133 14.1626 10.2125 14.5747 10.2538Z" fill="var(--red)"></path></svg>`;

document.addEventListener('DOMContentLoaded', async () => {
    const form = document.getElementById('bundleForm');
    const skeleton = document.getElementById('bundleSkeleton');
    const saveBtn = document.getElementById('saveBtn');
    const bundleSubtitle = document.getElementById('bundleSubtitle');

    if (typeof bundleId === 'undefined') {
        showAlert({
            type: 'error',
            title: 'Fout',
            message: 'Bundel ID niet gevonden'
        });
        return;
    }

    let bundle = null;
    let bundleProducts = [];

    try {
        const res = await fetch(`/api/admin/get_bundle/${bundleId}`);
        if (!res.ok) throw new Error('Bundel laden mislukt');

        const json = await res.json();

        if (!json.success || !json.data || json.data.length === 0) {
            throw new Error('Geen bundle data gevonden');
        }

        bundle = json.data[0];

        populateForm(bundle);
        initPhotoManager(bundle.image);
        renderProducts();
        updatePriceOverview();

        bundleSubtitle.textContent = bundle.name || '—';
        saveBtn.addEventListener('click', handleSave);

        // swap skeleton out, real form in
        skeleton.hidden = true;
        form.hidden = false;

    } catch (error) {
        console.error('Load error:', error);
        skeleton.hidden = true;
        showAlert({
            type: 'error',
            title: 'Fout',
            message: error.message
        });
    }

    // =========================
    // FORM DATA
    // =========================
    function populateForm(data) {
        document.getElementById('bundleName').value = data.name || '';
        document.getElementById('bundleDescription').value = data.description || '';
        document.getElementById('bundlePrice').value = data.price || '';
        document.getElementById('bundleTagsInput').value = data.bundle_tag || '';

        // Each row from the API is one bundle+product join row, so the
        // product fields are collected per row into bundleProducts here.
        bundleProducts = (data.products || []).map(p => ({
            product_id: p.product_id,
            product_image: p.image || '',
            product_name: p.product_name,
            quantity: p.quantity,
            product_price: p.price
        }));
    }

    // =========================
    // PHOTO (SINGLE IMAGE)
    // =========================
    function initPhotoManager(existingImage) {
        const photoInput = document.getElementById('photoInput');
        const photoMain = document.getElementById('photoMain');
        const photoMainImg = document.getElementById('photoMainImg');
        const photoMainEmpty = document.getElementById('photoMainEmpty');

        let selectedFile = null;
        if (existingImage) {
            photoMainImg.src = existingImage.startsWith('http') || existingImage.startsWith('/uploads')
                ? existingImage
                : `/uploads/bundles/${existingImage}`;

            photoMainImg.hidden = false;
            photoMainEmpty.hidden = true;
        }

        // click to upload
        photoMain.addEventListener('click', () => {
            photoInput.click();
        });

        // choose file
        photoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            selectedFile = file;

            const reader = new FileReader();
            reader.onload = (evt) => {
                photoMainImg.src = evt.target.result;
                photoMainImg.hidden = false;
                photoMainEmpty.hidden = true;
            };

            reader.readAsDataURL(file);
        });

        // expose upload function
        window.uploadBundlePhoto = async function (bundleId) {
            if (!selectedFile) return;

            const formData = new FormData();
            formData.append('photo', selectedFile);

            const res = await fetch(`/api/upload_bundle_photo/${bundleId}`, {
                method: 'POST',
                body: formData
            });

            if (!res.ok) throw new Error('Foto upload mislukt');
        };
    }

    // Trusted, static SVG markup only — never used for user-supplied data.

    function createRemoveIcon() {
        const template = document.createElement('template');
        template.innerHTML = REMOVE_ICON_SVG;
        return template.content.firstChild;
    }

    // =========================
    // PRODUCTS
    // =========================
    function renderProducts() {
        const container = document.getElementById('bundleProductsList');

        container.replaceChildren();

        if (!bundleProducts.length) {
            const empty = document.createElement('p');
            empty.style.textAlign = 'center';
            empty.textContent = 'Geen producten';
            container.append(empty);
            return;
        }

        bundleProducts.forEach((product, idx) => {
            const item = document.createElement('div');
            item.className = 'bundle-product-item';

            const img = document.createElement('img');
            img.src = `/uploads/products/${product.product_image}`;
            img.alt = product.product_name;

            const info = document.createElement('div');
            info.className = 'bundle-product-info';

            const nameEl = document.createElement('p');
            nameEl.className = 'bundle-product-name';
            nameEl.textContent = product.product_name;

            const priceEl = document.createElement('p');
            priceEl.className = 'bundle-product-price';
            priceEl.textContent = `€ ${parseFloat(product.product_price).toFixed(2)}`;

            info.append(nameEl, priceEl);

            const qtyWrap = document.createElement('div');
            qtyWrap.className = 'bundle-product-qty';

            const minusBtn = document.createElement('button');
            minusBtn.type = 'button';
            minusBtn.textContent = '-';
            minusBtn.addEventListener('click', () => {
                if (product.quantity > 1) {
                    product.quantity--;
                    renderProducts();
                    updatePriceOverview();
                }
            });

            const qtyInput = document.createElement('input');
            qtyInput.type = 'text';
            qtyInput.value = product.quantity;
            qtyInput.readOnly = true;

            const plusBtn = document.createElement('button');
            plusBtn.type = 'button';
            plusBtn.textContent = '+';
            plusBtn.addEventListener('click', () => {
                product.quantity++;
                renderProducts();
                updatePriceOverview();
            });

            qtyWrap.append(minusBtn, qtyInput, plusBtn);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'bundle-product-remove';
            removeBtn.append(createRemoveIcon());
            removeBtn.addEventListener('click', () => {
                bundleProducts.splice(idx, 1);
                renderProducts();
                updatePriceOverview();
            });

            item.append(img, info, qtyWrap, removeBtn);
            container.append(item);
        });
    }

    // =========================
    // PRODUCT PICKER MODAL
    // =========================
    const productPickerOverlay = document.getElementById('productPickerOverlay');
    const productPickerList = document.getElementById('productPickerList');
    const productPickerSearch = document.getElementById('productPickerSearch');
    const addProductBtn = document.getElementById('addProductBtn');
    const productPickerClose = document.getElementById('productPickerClose');

    let allProducts = null; // cached after first load

    addProductBtn.addEventListener('click', openProductPicker);
    productPickerClose.addEventListener('click', closeProductPicker);
    productPickerOverlay.addEventListener('click', (e) => {
        if (e.target === productPickerOverlay) closeProductPicker();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !productPickerOverlay.hidden) closeProductPicker();
    });
    productPickerSearch.addEventListener('input', renderProductPicker);

    async function openProductPicker() {
        productPickerOverlay.hidden = false;
        productPickerSearch.value = '';
        productPickerSearch.focus();

        if (allProducts === null) {
            productPickerList.replaceChildren();
            const loading = document.createElement('p');
            loading.className = 'modal-list-empty';
            loading.textContent = 'Producten laden...';
            productPickerList.append(loading);

            try {
                const res = await fetch('/api/admin/get_all_products');
                if (!res.ok) throw new Error('Producten laden mislukt');

                const json = await res.json();
                allProducts = (json.success && Array.isArray(json.data)) ? json.data : [];
            } catch (error) {
                console.error('Product picker load error:', error);
                allProducts = [];
                showAlert({
                    type: 'error',
                    title: 'Fout',
                    message: 'Producten konden niet worden geladen'
                });
            }
        }

        renderProductPicker();
    }

    function closeProductPicker() {
        productPickerOverlay.hidden = true;
    }

    function renderProductPicker() {
        console.log(allProducts);
        if (allProducts === null) return;

        const query = productPickerSearch.value.trim().toLowerCase();
        const addedIds = new Set(bundleProducts.map(p => p.product_id));

        const results = allProducts.filter(product => {
            if (addedIds.has(product.id)) return false;
            if (!query) return true;

            const haystack = [product.name, product.sku, product.category_name]
                .filter(Boolean)
                .join(' ')
                .toLowerCase();

            return haystack.includes(query);
        });

        productPickerList.replaceChildren();

        if (!results.length) {
            const empty = document.createElement('p');
            empty.className = 'modal-list-empty';
            empty.textContent = 'Geen producten gevonden';
            productPickerList.append(empty);
            return;
        }

        results.forEach(product => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'modal-product-item';

            const img = document.createElement('img');
            img.src = `/uploads/products/${product.image}`;
            img.alt = product.name;

            const info = document.createElement('div');
            info.className = 'modal-product-info';

            const nameEl = document.createElement('p');
            nameEl.className = 'modal-product-name';
            nameEl.textContent = product.name;

            const metaEl = document.createElement('p');
            metaEl.className = 'modal-product-meta';
            metaEl.textContent = product.category_name || product.sku || '';

            info.append(nameEl, metaEl);

            const effectivePrice = product.sale_price ?? product.price;

            const priceEl = document.createElement('span');
            priceEl.className = 'modal-product-price';
            priceEl.textContent = `€ ${parseFloat(effectivePrice).toFixed(2)}`;

            item.append(img, info, priceEl);
            item.addEventListener('click', () => addProductToBundle(product));

            productPickerList.append(item);
        });
    }

    function addProductToBundle(product) {
        bundleProducts.push({
            product_id: product.id,
            product_image: product.image || '',
            product_name: product.name,
            quantity: 1,
            product_price: product.sale_price ?? product.price
        });

        renderProducts();
        updatePriceOverview();
        closeProductPicker();
    }

    // =========================
    // PRICE OVERVIEW
    // =========================
    function updatePriceOverview() {
        const productValueTotal = bundleProducts.reduce(
            (sum, p) => sum + (parseFloat(p.product_price) || 0) * (p.quantity || 1),
            0
        );
        const bundlePriceInput = parseFloat(document.getElementById('bundlePrice').value) || 0;

        document.getElementById('productValueTotal').textContent = formatPrice(productValueTotal);
        document.getElementById('originalPriceTotal').textContent = formatPrice(productValueTotal);
        document.getElementById('bundlePriceTotal').textContent = formatPrice(bundlePriceInput);

        const savingsText = document.getElementById('savingsText');
        const savings = productValueTotal - bundlePriceInput;

        if (productValueTotal > 0 && savings > 0) {
            const percent = Math.round((savings / productValueTotal) * 100);
            savingsText.textContent = `Klant bespaart ${formatPrice(savings)} (${percent}%)`;
        } else {
            savingsText.textContent = '—';
        }
    }

    function formatPrice(value) {
        return `€ ${value.toFixed(2)}`;
    }

    document.getElementById('bundlePrice').addEventListener('input', updatePriceOverview);

    // =========================
    // SAVE
    // =========================
    async function handleSave() {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Opslaan...';

        try {
            const formData = new FormData(form);

            const payload = {
                name: formData.get('name'),
                description: formData.get('description'),
                price: parseFloat(formData.get('price')) || 0,
                bundle_tag: formData.get('bundle_tags'),
                products: bundleProducts
            };

            const res = await fetch(`/api/update_bundle/${bundleId}`, {
                method: 'PUT',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error('Opslaan mislukt');

            if (window.uploadBundlePhoto) {
                await window.uploadBundlePhoto(bundleId);
            }

            showAlert({
                type: 'success',
                title: 'Gelukt!',
                message: 'Bundel opgeslagen',
                buttons: [
                    {
                        text: 'Terug',
                        type: 'primary',
                        action: () => window.location.href = '/admin/bundles'
                    }
                ]
            });

        } catch (error) {
            console.error('Save error:', error);

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