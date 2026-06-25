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
    let highlights = [];

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
        document.getElementById('bundleSku').value = data.sku || '';

        document.getElementById('bundleTagsInput').value =
            (data.bundle_tags || [])
                .map(t => typeof t === 'object' ? t.name : t)
                .join(', ');

        bundleProducts = (data.products || []).map(p => ({
            product_id: p.product_id,
            product_name: p.product_name,
            quantity: p.quantity,
            price: p.price
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
            const div = document.createElement('div');

            const nameEl = document.createElement('strong');
            nameEl.textContent = product.product_name;

            const priceEl = document.createElement('div');
            priceEl.textContent = `€ ${parseFloat(product.price).toFixed(2)}`;

            const qtyEl = document.createElement('div');
            qtyEl.textContent = `Aantal: ${product.quantity}`;

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.textContent = 'Verwijder';
            removeBtn.addEventListener('click', () => {
                bundleProducts.splice(idx, 1);
                renderProducts();
            });

            div.append(nameEl, priceEl, qtyEl, removeBtn);
            container.append(div);
        });
    }

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
                sku: formData.get('sku'),
                products: bundleProducts,
                highlights
            };

            const res = await fetch(`/api/update_bundle/${bundleId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
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