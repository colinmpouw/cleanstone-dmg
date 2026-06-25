/* ==========================================================================
   adminBundleEdit.js
   Admin "Bundel bewerken" (edit bundle) page.
   ========================================================================== */

document.addEventListener('DOMContentLoaded', async () => {
    const form = document.getElementById('bundleForm');
    const saveBtn = document.getElementById('saveBtn');
    const bundleSubtitle = document.getElementById('bundleSubtitle');
    
    if (!bundleId) {
        showAlert({
            type: 'error',
            title: 'Fout',
            message: 'Bundel ID niet gevonden'
        });
        return;
    }

    let bundle = null;
    let selectedTags = [];
    let bundleProducts = [];
    let highlights = [];
    let uploadedPhotos = [];

    try {
        const res = await fetch(`/api/get_bundle/${bundleId}`);
        if (!res.ok) throw new Error('Bundel laden mislukt');

        bundle = await res.json();

        populateForm(bundle);
        initTagSelect();
        initPhotoManager(bundle.image);
        renderProducts();
        renderHighlights();
        bundleSubtitle.textContent = bundle.name || '—';

        saveBtn.addEventListener('click', handleSave);
    } catch (error) {
        console.error('Failed to load bundle:', error);
        showAlert({
            type: 'error',
            title: 'Fout',
            message: 'Kon bundel niet laden'
        });
    }

    function populateForm(data) {
        document.getElementById('bundleName').value = data.name || '';
        document.getElementById('bundleDescription').value = data.description || '';
        document.getElementById('bundlePrice').value = data.price || '';
        document.getElementById('bundleSku').value = data.sku || '';
        document.getElementById('bundleTagsInput').value = (data.bundle_tags || []).join(', ');

        bundleProducts = (data.products || []).map(p => ({
            product_id: p.product_id,
            product_name: p.product_name,
            quantity: p.quantity,
            price: p.price
        }));

        highlights = [];
        updatePriceSummary();
    }

    function initTagSelect() {
        const tagsInput = document.getElementById('tagSearchInput');
        const dropdown = document.getElementById('tagDropdown');
        const chips = document.getElementById('tagChips');

        tagsInput.addEventListener('input', () => {
            const query = tagsInput.value.toLowerCase();
            // For now, simple tag addition - expand with real tag list if needed
            if (query && query.length > 0) {
                dropdown.hidden = false;
            } else {
                dropdown.hidden = true;
            }
        });
    }

    function initPhotoManager(existingImage) {
        const photoInput = document.getElementById('photoInput');
        const photoMain = document.getElementById('photoMain');
        const photoMainImg = document.getElementById('photoMainImg');
        const photoMainEmpty = document.getElementById('photoMainEmpty');
        const photoThumbs = document.getElementById('photoThumbs');
        const photoAddTile = document.getElementById('photoAddTile');
        const photoCount = document.getElementById('photoCount');

        if (existingImage) {
            photoMainImg.src = existingImage;
            photoMainImg.hidden = false;
            photoMainEmpty.hidden = true;
        }

        photoInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files || []);
            uploadedPhotos.push(...files);

            files.forEach(file => {
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

    function renderProducts() {
        const container = document.getElementById('bundleProductsList');

        if (!bundleProducts.length) {
            container.innerHTML = '<p style="color: var(--warm-beige); text-align: center; padding: 1rem;">Geen producten toegevoegd</p>';
            return;
        }

        container.replaceChildren();
        bundleProducts.forEach((product, idx) => {
            const item = document.createElement('div');
            item.className = 'bundle-product-item';

            const info = document.createElement('div');
            info.className = 'bundle-product-info';

            const name = document.createElement('p');
            name.className = 'bundle-product-name';
            name.textContent = product.product_name;

            const price = document.createElement('p');
            price.className = 'bundle-product-price';
            price.textContent = `€ ${parseFloat(product.price).toFixed(2).replace('.', ',')}`;

            info.append(name, price);

            const qtyDiv = document.createElement('div');
            qtyDiv.className = 'bundle-product-qty';

            const minusBtn = document.createElement('button');
            minusBtn.type = 'button';
            minusBtn.textContent = '−';
            minusBtn.addEventListener('click', () => {
                if (product.quantity > 1) product.quantity--;
                qtyInput.value = product.quantity;
                updatePriceSummary();
            });

            const qtyInput = document.createElement('input');
            qtyInput.type = 'number';
            qtyInput.value = product.quantity;
            qtyInput.min = '1';
            qtyInput.addEventListener('change', () => {
                product.quantity = Math.max(1, parseInt(qtyInput.value) || 1);
                qtyInput.value = product.quantity;
                updatePriceSummary();
            });

            const plusBtn = document.createElement('button');
            plusBtn.type = 'button';
            plusBtn.textContent = '+';
            plusBtn.addEventListener('click', () => {
                product.quantity++;
                qtyInput.value = product.quantity;
                updatePriceSummary();
            });

            qtyDiv.append(minusBtn, qtyInput, plusBtn);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'bundle-product-remove';
            removeBtn.setAttribute('aria-label', 'Verwijderen');
            removeBtn.innerHTML = '<i class="ti ti-trash"></i>';
            removeBtn.addEventListener('click', () => {
                bundleProducts.splice(idx, 1);
                renderProducts();
                updatePriceSummary();
            });

            item.append(info, qtyDiv, removeBtn);
            container.append(item);
        });
    }

    function renderHighlights() {
        const container = document.getElementById('bundleHighlightsList');
        container.replaceChildren();

        highlights.forEach((highlight, idx) => {
            const item = document.createElement('div');
            item.className = 'bundle-highlight-item';

            const icon = document.createElement('i');
            icon.className = 'ti ti-check';

            const input = document.createElement('input');
            input.type = 'text';
            input.value = highlight;
            input.placeholder = 'Voeg hoogtepunt toe...';
            input.addEventListener('change', () => {
                highlights[idx] = input.value;
            });

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'bundle-highlight-remove';
            removeBtn.innerHTML = '<i class="ti ti-x"></i>';
            removeBtn.addEventListener('click', () => {
                highlights.splice(idx, 1);
                renderHighlights();
            });

            item.append(icon, input, removeBtn);
            container.append(item);
        });

        const addBtn = document.getElementById('addHighlightBtn');
        addBtn.addEventListener('click', (e) => {
            e.preventDefault();
            highlights.push('');
            renderHighlights();
        });
    }

    function updatePriceSummary() {
        const productValue = bundleProducts.reduce((sum, p) => sum + (parseFloat(p.price) * p.quantity), 0);
        const bundlePrice = parseFloat(document.getElementById('bundlePrice').value) || 0;
        const comparePrice = parseFloat(document.getElementById('bundleComparePrice').value) || 0;

        const originalPrice = comparePrice > 0 ? comparePrice : productValue;
        const savings = originalPrice - bundlePrice;
        const savingsPercent = originalPrice > 0 ? Math.round((savings / originalPrice) * 100) : 0;

        document.getElementById('productValueTotal').textContent = `€ ${productValue.toFixed(2).replace('.', ',')}`;
        document.getElementById('originalPriceTotal').textContent = `€ ${originalPrice.toFixed(2).replace('.', ',')}`;
        document.getElementById('bundlePriceTotal').textContent = `€ ${bundlePrice.toFixed(2).replace('.', ',')}`;

        const discountNote = document.getElementById('discountNote');
        if (savings > 0) {
            discountNote.textContent = `Korting: ${savingsPercent}% — besparen € ${savings.toFixed(2).replace('.', ',')}`;
            discountNote.hidden = false;
        } else {
            discountNote.hidden = true;
        }
    }

    document.getElementById('bundlePrice').addEventListener('change', updatePriceSummary);
    document.getElementById('bundleComparePrice').addEventListener('change', updatePriceSummary);

    async function handleSave() {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Opslaan...';

        try {
            const formData = new FormData(form);
            const tags = document.getElementById('bundleTagsInput').value
                .split(',')
                .map(t => t.trim())
                .filter(Boolean);

            const payload = {
                name: formData.get('name'),
                description: formData.get('description'),
                price: parseFloat(formData.get('price')) || 0,
                sku: formData.get('sku'),
                bundle_tags: tags,
                products: bundleProducts,
                highlights: highlights.filter(Boolean)
            };

            const res = await fetch(`/api/update_bundle/${bundleId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error('Opslaan mislukt');

            // Handle photo uploads if any
            if (uploadedPhotos.length > 0) {
                const photoFormData = new FormData();
                uploadedPhotos.forEach(file => {
                    photoFormData.append('photos', file);
                });

                const photoRes = await fetch(`/api/upload_bundle_photos/${bundleId}`, {
                    method: 'POST',
                    body: photoFormData
                });

                if (!photoRes.ok) throw new Error('Foto upload mislukt');
            }

            showAlert({
                type: 'success',
                title: 'Gelukt!',
                message: 'Bundel opgeslagen',
                buttons: [
                    {
                        text: 'Terug naar bundels',
                        type: 'primary',
                        action: () => {
                            window.location.href = '/admin/bundles';
                        }
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