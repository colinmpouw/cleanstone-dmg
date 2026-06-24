document.addEventListener('DOMContentLoaded', async () => {
    const form = document.getElementById('productForm');
    const saveBtn = document.getElementById('saveBtn');

    let selectedTags = [];
    let uploadedPhotos = [];

    // ── Fetch categories, brands, tags (NO product fetch!) ──
    try {
        const [categoriesRes, brandsRes, tagsRes] = await Promise.all([
            fetch('/api/admin/get_all_categories'),
            fetch('/api/admin/get_all_brands'),
            fetch('/api/admin/get_all_tags')
        ]);

        const categories = await categoriesRes.json();
        const brands = await brandsRes.json();
        const tags = await tagsRes.json();

        populateSelects(categories.data || [], brands.data || []);
        initTagSelect(tags.data || []);
        initPhotoManager();

    } catch (error) {
        console.error(error);
        alert('Kon data niet laden');
        return;
    }

    // ── Save handler ──
    saveBtn.addEventListener('click', handleSave);

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

            // ✅ CREATE product FIRST
            const res = await fetch('/api/create_product', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error(`Create failed: ${res.status}`);

            const result = await res.json();
            const productId = result.id; // ✅ IMPORTANT

            // ✅ Upload photos AFTER creation
            if (uploadedPhotos.length > 0) {
                const photoForm = new FormData();

                uploadedPhotos.forEach(file => {
                    photoForm.append('photos', file);
                });

                const photoRes = await fetch(`/api/upload_product_photos/${productId}`, {
                    method: 'POST',
                    body: photoForm
                });

                if (!photoRes.ok) throw new Error('Photo upload failed');
            }

            alert('Product aangemaakt');
            window.location.href = '/admin/producten';

        } catch (error) {
            console.error(error);
            alert(`Fout: ${error.message}`);
            saveBtn.disabled = false;
            saveBtn.textContent = 'Opslaan';
        }
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

    // ✅ SAME tag system (without prefill)
    function initTagSelect(allTags) {
        const tagsInput = document.getElementById('tagSearchInput');
        const dropdown = document.getElementById('tagDropdown');
        const chips = document.getElementById('tagChips');

        tagsInput.addEventListener('input', () => {
            const query = tagsInput.value.toLowerCase();

            const available = allTags.filter(tag =>
                !selectedTags.some(st => st.id === tag.id) &&
                tag.name.toLowerCase().includes(query)
            );

            renderDropdown(available);
            dropdown.hidden = !available.length || !query;
        });

        function renderDropdown(options) {
            dropdown.replaceChildren();

            options.forEach(tag => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'tag-option';
                btn.textContent = tag.name;

                btn.addEventListener('click', () => {
                    selectedTags.push(tag);
                    renderChips();
                    tagsInput.value = '';
                    dropdown.hidden = true;
                });

                dropdown.append(btn);
            });
        }

        function renderChips() {
            chips.replaceChildren();

            selectedTags.forEach(tag => {
                const chip = document.createElement('div');
                chip.className = 'tag-chip';

                chip.innerHTML = `
                    <span>${tag.name}</span>
                    <button type="button" class="tag-chip-remove">×</button>
                `;

                chip.querySelector('button').onclick = () => {
                    selectedTags = selectedTags.filter(t => t.id !== tag.id);
                    renderChips();
                };

                chips.append(chip);
            });
        }
    }

    // ✅ SAME photo manager (but no existing image)
    function initPhotoManager() {
        const photoInput = document.getElementById('photoInput');
        const photoMainImg = document.getElementById('photoMainImg');
        const photoMainEmpty = document.getElementById('photoMainEmpty');
        const photoThumbs = document.getElementById('photoThumbs');
        const photoAddTile = document.getElementById('photoAddTile');
        const photoCount = document.getElementById('photoCount');

        photoInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files || []);
            uploadedPhotos.push(...files);

            files.forEach(file => {
                const reader = new FileReader();

                reader.onload = (evt) => {
                    const thumb = document.createElement('div');
                    thumb.className = 'photo-thumb';

                    thumb.innerHTML = `
                        <img src="${evt.target.result}">
                        <button type="button" class="photo-thumb-remove">X</button>
                    `;

                    thumb.querySelector('button').onclick = () => {
                        uploadedPhotos = uploadedPhotos.filter(f => f !== file);
                        thumb.remove();
                        updateCount();
                    };

                    thumb.onclick = () => {
                        photoMainImg.src = evt.target.result;
                        photoMainImg.hidden = false;
                        photoMainEmpty.hidden = true;
                    };

                    photoThumbs.insertBefore(thumb, photoAddTile);
                };

                reader.readAsDataURL(file);
            });

            updateCount();
            photoInput.value = '';
        });

        photoAddTile.onclick = () => photoInput.click();

        function updateCount() {
            photoCount.textContent = `${uploadedPhotos.length} foto's`;
        }
    }
});
