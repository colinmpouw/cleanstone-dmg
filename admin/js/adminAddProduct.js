document.addEventListener('DOMContentLoaded', async () => {

    const form = document.getElementById('productForm');
    const skeleton = document.getElementById('productSkeleton');
    const saveBtn = document.getElementById('saveBtn');

    let selectedTags = [];
    let selectedFile = null;

    // =========================
    // INIT LOAD (NO PRODUCT FETCH)
    // =========================
    try {
        const [categoriesRes, brandsRes, tagsRes] = await Promise.all([
            fetch('/api/admin/get_all_categories'),
            fetch('/api/admin/get_all_brands'),
            fetch('/api/admin/get_all_tags')
        ]);

        const categoriesJson = await categoriesRes.json();
        const brandsJson = await brandsRes.json();
        const tagsJson = await tagsRes.json();

        populateSelects(categoriesJson.data || [], brandsJson.data || []);
        initTagSelect(tagsJson.data || []);
        initPhotoManager();
        initDiscount();

        // ✅ show form after load
        skeleton.hidden = true;
        form.hidden = false;

        saveBtn.addEventListener('click', handleSave);

    } catch (error) {
        console.error('Load error:', error);

        skeleton.hidden = true;

        showAlert({
            type: 'error',
            title: 'Fout',
            message: 'Data laden mislukt'
        });
    }

    // =========================
    // SELECTS
    // =========================
    function populateSelects(categories, brands) {
        const category = document.getElementById('productCategory');
        const brand = document.getElementById('productBrand');

        categories.forEach(cat => {
            const opt = document.createElement('option');
            opt.value = cat.id;
            opt.textContent = cat.name;
            category.append(opt);
        });

        brands.forEach(b => {
            const opt = document.createElement('option');
            opt.value = b.id;
            opt.textContent = b.name;
            brand.append(opt);
        });
    }

    // =========================
    // TAG SELECT (UNIFIED)
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

                btn.onclick = () => {
                    selectedTags.push(tag);
                    renderChips();
                    input.value = '';
                    dropdown.hidden = true;
                };

                dropdown.append(btn);
            });
        }

        function renderChips() {
            const container = document.getElementById('tagChips');
            container.replaceChildren();

            selectedTags.forEach(tag => {
                const chip = document.createElement('div');
                chip.className = 'tag-chip';

                const name = document.createElement('span');
                name.textContent = tag.name;

                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'tag-chip-remove';
                remove.innerHTML = '<i class="ti ti-x"></i>';

                remove.onclick = () => {
                    selectedTags = selectedTags.filter(t => t.id !== tag.id);
                    renderChips();
                };

                chip.append(name, remove);
                container.append(chip);
            });
        }
    }

    // =========================
    // PHOTO (SINGLE SYSTEM)
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

            const res = await fetch('/api/create_product', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error('Aanmaken mislukt');

            const json = await res.json();
            const productId = json.id;

            if (window.uploadProductPhoto) {
                await window.uploadProductPhoto(productId);
            }

            showAlert({
                type: 'success',
                title: 'Gelukt!',
                message: 'Product aangemaakt',
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
