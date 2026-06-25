document.addEventListener('DOMContentLoaded', async () => {

    const form = document.getElementById('productForm');
    const skeleton = document.getElementById('productSkeleton');
    const saveBtn = document.getElementById('saveBtn');
    const subtitle = document.getElementById('productSubtitle');

    if (typeof productId === 'undefined') {
        showAlert({
            type: 'error',
            title: 'Fout',
            message: 'Product ID niet gevonden'
        });
        return;
    }

    let product = null;
    let selectedTags = [];
    let uploadedPhotos = [];

    // =========================
    // INIT LOAD
    // =========================
    try {
        const [productRes, categoriesRes, brandsRes, tagsRes] = await Promise.all([
            fetch(`/api/admin/get_product/${productId}`),
            fetch('/api/admin/get_all_categories'),
            fetch('/api/admin/get_all_brands'),
            fetch('/api/admin/get_all_tags')
        ]);

        if (!productRes.ok) throw new Error('Product laden mislukt');

        const productJson = await productRes.json();
        const categoriesJson = await categoriesRes.json();
        const brandsJson = await brandsRes.json();
        const tagsJson = await tagsRes.json();

        product = productJson.data?.[0] || productJson;

        populateForm(product);
        populateSelects(categoriesJson.data || [], brandsJson.data || []);
        initTagSelect(tagsJson.data || []);
        initPhotoManager(product.image);
        initDiscount();

        subtitle.textContent = product.name || '—';
        saveBtn.addEventListener('click', handleSave);

        // ✅ SHOW FORM / HIDE SKELETON
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
        document.getElementById('productName').value = data.name || '';
        document.getElementById('productDescription').value = data.description || '';
        document.getElementById('productPrice').value = data.price || '';
        document.getElementById('productComparePrice').value = data.sale_price || '';
        document.getElementById('productStock').value = data.stock || '';
        document.getElementById('productSku').value = data.sku || '';
        document.getElementById('productCategory').value = data.category_id || '';
        document.getElementById('productBrand').value = data.brand_id || '';

        selectedTags = data.tags || [];
        renderTagChips();
    }

    function populateSelects(categories, brands) {
        const categorySelect = document.getElementById('productCategory');
        const brandSelect = document.getElementById('productBrand');

        categories.forEach(cat => {
            const opt = document.createElement('option');
            opt.value = cat.id;
            opt.textContent = cat.name;
            categorySelect.append(opt);
        });

        brands.forEach(brand => {
            const opt = document.createElement('option');
            opt.value = brand.id;
            opt.textContent = brand.name;
            brandSelect.append(opt);
        });
    }

    // =========================
    // TAG SELECT (same system)
    // =========================
    function initTagSelect(allTags) {
        const input = document.getElementById('tagSearchInput');
        const dropdown = document.getElementById('tagDropdown');

        input.addEventListener('input', () => {
            const query = input.value.toLowerCase();

            const results = allTags.filter(tag =>
                !selectedTags.some(t => t.id === tag.id) &&
                tag.name.toLowerCase().includes(query)
            );

            renderDropdown(results);

            dropdown.hidden = !query || !results.length;
        });

        function renderDropdown(tags) {
            dropdown.replaceChildren();

            tags.forEach(tag => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'tag-option';
                btn.textContent = tag.name;

                btn.addEventListener('click', () => {
                    selectedTags.push(tag);
                    renderTagChips();
                    input.value = '';
                    dropdown.hidden = true;
                });

                dropdown.append(btn);
            });
        }
    }

    function renderTagChips() {
        const container = document.getElementById('tagChips');

        container.replaceChildren();

        selectedTags.forEach(tag => {
            const chip = document.createElement('div');
            chip.className = 'tag-chip';

            const text = document.createElement('span');
            text.textContent = tag.name;

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'tag-chip-remove';
            remove.innerHTML = '<i class="ti ti-x"></i>';

            remove.addEventListener('click', () => {
                selectedTags = selectedTags.filter(t => t.id !== tag.id);
                renderTagChips();
            });

            chip.append(text, remove);
            container.append(chip);
        });
    }

    // =========================
    // PHOTO (same as bundle simplified)
    // =========================
    function initPhotoManager(existingImage) {
        const input = document.getElementById('photoInput');
        const main = document.getElementById('photoMain');
        const img = document.getElementById('photoMainImg');
        const empty = document.getElementById('photoMainEmpty');

        let selectedFile = null;

        if (existingImage) {
            img.src = existingImage.startsWith('/uploads')
                ? existingImage
                : `/uploads/products/${existingImage}`;

            img.hidden = false;
            empty.hidden = true;
        }

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

        window.uploadProductPhoto = async function (productId) {
            if (!selectedFile) return;

            const fd = new FormData();
            fd.append('photo', selectedFile);

            const res = await fetch(`/api/upload_product_photo/${productId}`, {
                method: 'POST',
                body: fd
            });

            if (!res.ok) throw new Error('Foto upload mislukt');
        };
    }

    // =========================
    // DISCOUNT
    // =========================
    function initDiscount() {
        const price = document.getElementById('productPrice');
        const compare = document.getElementById('productComparePrice');
        const note = document.getElementById('discountNote');

        function update() {
            const p = parseFloat(price.value) || 0;
            const c = parseFloat(compare.value) || 0;

            if (c > p) {
                const percent = Math.round(((c - p) / c) * 100);
                note.textContent = `Korting: ${percent}%`;
                note.hidden = false;
            } else {
                note.hidden = true;
            }
        }

        price.addEventListener('input', update);
        compare.addEventListener('input', update);
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
                sale_price: parseFloat(formData.get('sale_price')) || null,
                stock: parseInt(formData.get('stock')) || 0,
                sku: formData.get('sku'),
                brand_id: parseInt(formData.get('brand_id')) || null,
                category_id: parseInt(formData.get('category_id')) || null,
                tags: selectedTags.map(t => t.id)
            };

            const res = await fetch(`/api/update_product/${productId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error('Opslaan mislukt');

            if (window.uploadProductPhoto) {
                await window.uploadProductPhoto(productId);
            }

            showAlert({
                type: 'success',
                title: 'Gelukt!',
                message: 'Product opgeslagen',
                buttons: [
                    {
                        text: 'Terug',
                        type: 'primary',
                        action: () => window.location.href = '/admin/producten'
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