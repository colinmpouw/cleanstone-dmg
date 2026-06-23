/* ==========================================================================
   adminProductEdit.js
   Admin "Product bewerken" (edit product) page. Fetches product data,
   populates form fields, manages photo uploads with previews, handles
   multi-select tags, calculates discounts, and saves via API.
   ========================================================================== */

document.addEventListener('DOMContentLoaded', async () => {
    const form = document.getElementById('productForm');
    const saveBtn = document.getElementById('saveBtn');
    const productSubtitle = document.getElementById('productSubtitle');

    // Get product ID from URL (e.g. /admin/products/123/edit)

    // if (!productId) {
    //     alert('Product ID not found in URL');
    //     return;
    // }

    let product = null;
    let selectedTags = [];
    let uploadedPhotos = [];

    // ── Fetch product + metadata ──
    try {
        const [productRes, categoriesRes, brandsRes, tagsRes] = await Promise.all([
            fetch(`/api/admin/get_product/${productId}`),
            fetch('/api/admin/get_all_categories'),
            fetch('/api/admin/get_all_brands'),
            fetch('/api/admin/get_all_tags')
        ]);

        if (!productRes.ok) throw new Error(`Product fetch failed: ${productRes.status}`);

        product = await productRes.json();
        const categories = await categoriesRes.json();
        const brands = await brandsRes.json();
        const tags = await tagsRes.json();

        populateSelects(categories.data || [], brands.data || []);
        populateForm(product);
        initTagSelect(tags.data || []);
        initPhotoManager(product.image);

        productSubtitle.textContent = product.name || '—';
    } catch (error) {
        console.error('Failed to load product:', error);
        alert('Kon product niet laden');
        return;
    }

    // ── Save button handler ──
    saveBtn.addEventListener('click', handleSave);

    // ── Handlers ──
    async function handleSave() {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Opslaan...';

        try {
            const formData = new FormData(form);
            const tags = selectedTags.map(t => t.id);

            const payload = {
                name: formData.get('name'),
                description: formData.get('description'),
                price: parseFloat(formData.get('price')) || 0,
                sale_price: parseFloat(formData.get('sale_price')) || null,
                stock: parseInt(formData.get('stock')) || 0,
                sku: formData.get('sku'),
                brand_id: parseInt(formData.get('brand_id')) || null,
                category_id: parseInt(formData.get('category_id')) || null,
                tags
            };

            // TODO: adjust endpoint if your API uses a different route
            const res = await fetch(`/api/update_product/${productId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error(`Save failed: ${res.status}`);

            // Handle photo uploads separately (multipart form data)
            if (uploadedPhotos.length > 0) {
                const photoFormData = new FormData();
                uploadedPhotos.forEach(file => {
                    photoFormData.append('photos', file);
                });

                const photoRes = await fetch(`/api/upload_product_photos/${productId}`, {
                    method: 'POST',
                    body: photoFormData
                });

                if (!photoRes.ok) throw new Error(`Photo upload failed: ${photoRes.status}`);
            }

            alert('Product opgeslagen');
            window.location.href = '/admin/products';
        } catch (error) {
            console.error('Save error:', error);
            alert(`Fout bij opslaan: ${error.message}`);
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

    function populateForm(data) {
        document.getElementById('productName').value = data.name || '';
        document.getElementById('productDescription').value = data.description || '';
        document.getElementById('productPrice').value = data.price || '';
        document.getElementById('productComparePrice').value = data.sale_price || '';
        document.getElementById('productStock').value = data.stock || '';
        document.getElementById('productSku').value = data.sku || '';
        document.getElementById('productCategory').value = data.category_id || '';
        document.getElementById('productBrand').value = data.brand_id || '';

        updateDiscountNote();
    }

    function initTagSelect(allTags) {
        const tagsInput = document.getElementById('tagSearchInput');
        const dropdown = document.getElementById('tagDropdown');
        const chips = document.getElementById('tagChips');

        // Pre-populate if the product has tags (if your API returns them)
        if (product.tags && Array.isArray(product.tags)) {
            selectedTags = product.tags;
            renderTagChips();
        }

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
            if (!options.length) {
                const empty = document.createElement('div');
                empty.className = 'tag-option-empty';
                empty.textContent = 'Geen tags gevonden';
                dropdown.append(empty);
                return;
            }

            options.forEach(tag => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'tag-option';
                btn.textContent = tag.name;
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    selectedTags.push(tag);
                    renderTagChips();
                    tagsInput.value = '';
                    dropdown.hidden = true;
                });
                dropdown.append(btn);
            });
        }

        function renderTagChips() {
            chips.replaceChildren();
            selectedTags.forEach(tag => {
                const chip = document.createElement('div');
                chip.className = 'tag-chip';

                const name = document.createElement('span');
                name.textContent = tag.name;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'tag-chip-remove';
                btn.setAttribute('aria-label', `${tag.name} verwijderen`);
                btn.innerHTML = '<i class="ti ti-x"></i>';
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    selectedTags = selectedTags.filter(st => st.id !== tag.id);
                    renderTagChips();
                });

                chip.append(name, btn);
                chips.append(chip);
            });
        }
    }

    function initPhotoManager(existingImage) {
        const photoInput = document.getElementById('photoInput');
        const photoMain = document.getElementById('photoMain');
        const photoMainImg = document.getElementById('photoMainImg');
        const photoMainEmpty = document.getElementById('photoMainEmpty');
        const photoThumbs = document.getElementById('photoThumbs');
        const photoAddTile = document.getElementById('photoAddTile');
        const photoCount = document.getElementById('photoCount');

        // Show existing main photo if it exists
        if (existingImage) {
            photoMainImg.src = existingImage;
            photoMainImg.hidden = false;
            photoMainEmpty.hidden = true;
        }

        photoInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files || []);
            uploadedPhotos.push(...files);

            files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = (evt) => {
                    const thumb = createPhotoThumb(evt.target.result, () => {
                        uploadedPhotos = uploadedPhotos.filter(f => f !== file);
                        renderPhotoThumbs();
                    });
                    photoThumbs.insertBefore(thumb, photoAddTile);
                };
                reader.readAsDataURL(file);
            });

            renderPhotoThumbs();
            photoInput.value = '';
        });

        photoAddTile.addEventListener('click', () => {
            photoInput.click();
        });

        function createPhotoThumb(src, onRemove) {
            const thumb = document.createElement('div');
            thumb.className = 'photo-thumb';

            const img = document.createElement('img');
            img.src = src;
            thumb.append(img);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'photo-thumb-remove';
            removeBtn.setAttribute('aria-label', 'Verwijderen');
            removeBtn.innerHTML = '<i class="ti ti-x"></i>';
            removeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                thumb.remove();
                onRemove();
            });
            thumb.append(removeBtn);

            thumb.addEventListener('click', () => {
                photoMainImg.src = src;
                photoMainImg.hidden = false;
                photoMainEmpty.hidden = true;
            });

            return thumb;
        }

        function renderPhotoThumbs() {
            photoCount.textContent = `${uploadedPhotos.length} foto's`;
        }
    }

    // ── Discount calculator ──
    function updateDiscountNote() {
        const priceInput = document.getElementById('productPrice');
        const comparePriceInput = document.getElementById('productComparePrice');
        const discountNote = document.getElementById('discountNote');

        priceInput.addEventListener('change', calculateDiscount);
        comparePriceInput.addEventListener('change', calculateDiscount);

        function calculateDiscount() {
            const price = parseFloat(priceInput.value) || 0;
            const comparePrice = parseFloat(comparePriceInput.value) || 0;

            if (comparePrice > price) {
                const percent = Math.round(((comparePrice - price) / comparePrice) * 100);
                discountNote.textContent = `Korting: ${percent}% — wordt weergegeven als kortingslabel`;
                discountNote.hidden = false;
            } else {
                discountNote.hidden = true;
            }
        }
    }
});