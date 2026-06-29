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

    // Gallery state: array of { id, url, file, isPrimary, isNew }
    // - existing images come from images[] (and the legacy `image` field)
    // - newly added photos get isNew: true and carry the raw File for upload
    let gallery = [];

    // List-editor state
    let features = [];      // array of strings
    let specifications = []; // array of { id, name, value }
    let instructions = [];   // array of { id, step, instruction }

    let rowIdCounter = 0;
    const nextRowId = () => `row_${Date.now()}_${rowIdCounter++}`;

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

        // The get_product endpoint returns the product directly (no envelope),
        // but fall back to `.data` in case that ever changes.
        product = productJson.data || productJson;

        // Build the <option> lists first, THEN populate the form — selects need
        // their options to exist before we can select one by value or by text.
        populateSelects(categoriesJson.data || [], brandsJson.data || []);
        populateForm(product);

        initTagSelect(tagsJson.data || []);
        initGallery(product.image, product.images || []);
        initDiscount();
        initListEditors();

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
        document.getElementById('productShortDescription').value = data.short_description || '';
        document.getElementById('productDescription').value = data.description || '';
        document.getElementById('productPrice').value = data.price || '';
        document.getElementById('productComparePrice').value = data.sale_price || '';
        document.getElementById('productStock').value = data.stock || '';
        document.getElementById('productSku').value = data.sku || '';

        // The product object has no category_id/brand_id — only nested
        // { name, slug } / { name, logo } objects. Match the <select>
        // by visible option text instead of by value/id.
        selectOptionByText('productCategory', data.category?.name);
        selectOptionByText('productBrand', data.brand?.name);

        selectedTags = data.tags || [];
        renderTagChips();

        // ✅ Read-only rating, calculated by the DB view — never editable.
        renderRating(data.avg_rating, data.review_count);

        // Dedupe + load list-editor state. The live product page shows each
        // feature/spec/instruction repeated 2-3x (a backend join fan-out) —
        // this is a frontend safety net so the edit form doesn't show or
        // re-save the duplicates.
        features = dedupeFeatures(data.features || []);
        specifications = dedupeSpecifications(data.specifications || []);
        instructions = dedupeInstructions(data.instructions || []);
    }

    function selectOptionByText(selectId, text) {
        const select = document.getElementById(selectId);
        if (!text) {
            select.value = ''; // falls back to the blank placeholder option
            return;
        }

        const match = Array.from(select.options).find(
            opt => opt.textContent.trim().toLowerCase() === text.trim().toLowerCase()
        );

        select.value = match ? match.value : '';
    }

    function renderRating(avgRating, reviewCount) {
        const starsEl = document.getElementById('ratingStars');
        const valueEl = document.getElementById('ratingValue');
        const countEl = document.getElementById('ratingCount');

        // avg_rating / review_count can be null (new product, zero reviews)
        const rating = parseFloat(avgRating) || 0;
        const count = parseInt(reviewCount) || 0;

        const fullStars = Math.round(rating);
        starsEl.textContent = '★'.repeat(fullStars) + '☆'.repeat(5 - fullStars);

        valueEl.textContent = rating > 0 ? rating.toFixed(1) : '—';
        countEl.textContent = count === 1 ? '(1 review)' : `(${count} reviews)`;
    }

    function populateSelects(categories, brands) {
        const categorySelect = document.getElementById('productCategory');
        const brandSelect = document.getElementById('productBrand');

        // Blank placeholder so a product with no brand/category doesn't
        // silently default to whichever option happens to be first.
        const blankCat = document.createElement('option');
        blankCat.value = '';
        blankCat.textContent = '— Kies een categorie —';
        categorySelect.append(blankCat);

        const blankBrand = document.createElement('option');
        blankBrand.value = '';
        blankBrand.textContent = '— Kies een merk —';
        brandSelect.append(blankBrand);

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
    // DEDUPE HELPERS (safety net for backend join fan-out)
    // =========================
    function dedupeFeatures(list) {
        const seen = new Set();
        const result = [];
        list.forEach(text => {
            const key = (text || '').trim().toLowerCase();
            if (!key || seen.has(key)) return;
            seen.add(key);
            result.push(text);
        });
        return result;
    }

    function dedupeSpecifications(list) {
        const seen = new Set();
        const result = [];
        list.forEach(spec => {
            const key = `${(spec.name || '').trim().toLowerCase()}::${(spec.value || '').trim().toLowerCase()}`;
            if (seen.has(key)) return;
            seen.add(key);
            result.push({ id: spec.id ?? nextRowId(), name: spec.name || '', value: spec.value || '' });
        });
        return result;
    }

    function dedupeInstructions(list) {
        const seen = new Set();
        const result = [];
        list.forEach(step => {
            const key = `${step.step}::${(step.instruction || '').trim().toLowerCase()}`;
            if (seen.has(key)) return;
            seen.add(key);
            result.push({ id: step.id ?? nextRowId(), step: step.step, instruction: step.instruction || '' });
        });
        // Keep step numbers in order regardless of how the backend returned them.
        result.sort((a, b) => (a.step || 0) - (b.step || 0));
        return result;
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
    // PHOTO GALLERY
    // Merges the legacy single `image` field with the `images[]` array into
    // one gallery list. Clicking a thumb makes it primary; × removes it.
    // New uploads are added to the same list (isNew: true) and uploaded on save.
    // =========================
    function initGallery(legacyImage, imagesArray) {
        const input = document.getElementById('photoInput');
        const thumbsContainer = document.getElementById('photoThumbs');
        const addLabel = thumbsContainer.querySelector('.photo-thumb--add');

        gallery = buildInitialGallery(legacyImage, imagesArray);

        input.addEventListener('change', (e) => {
            const files = Array.from(e.target.files || []);
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (evt) => {
                    gallery.push({
                        id: nextRowId(),
                        url: evt.target.result,
                        file,
                        isPrimary: gallery.length === 0, // first photo added becomes primary if gallery was empty
                        isNew: true
                    });
                    renderGallery();
                };
                reader.readAsDataURL(file);
            });
            input.value = ''; // allow re-selecting the same file later
        });

        renderGallery();

        function buildInitialGallery(legacyImage, imagesArray) {
            const items = [];

            // images[] entries can have either `image` (filename in /uploads/products/)
            // or `url` (already a full path) populated, per the sample data.
            imagesArray.forEach(img => {
                const src = img.url
                    ? (img.url.startsWith('/') ? img.url : `/uploads/products/${img.url}`)
                    : (img.image ? `/uploads/products/${img.image}` : null);

                if (!src) return;

                items.push({
                    id: img.id ?? nextRowId(),
                    url: src,
                    file: null,
                    isPrimary: !!img.is_primary,
                    isNew: false
                });
            });

            // If nothing in images[] is marked primary, but a legacy `image` field
            // exists, make sure that photo is represented and marked primary.
            if (legacyImage) {
                const legacySrc = legacyImage.startsWith('/uploads')
                    ? legacyImage
                    : `/uploads/products/${legacyImage}`;

                const alreadyPresent = items.some(item => item.url === legacySrc);
                if (!alreadyPresent) {
                    items.unshift({
                        id: nextRowId(),
                        url: legacySrc,
                        file: null,
                        isPrimary: true,
                        isNew: false
                    });
                }
            }

            if (items.length && !items.some(i => i.isPrimary)) {
                items[0].isPrimary = true;
            }

            return items;
        }

        function renderGallery() {
            // Update main photo display
            const mainImg = document.getElementById('photoMainImg');
            const mainEmpty = document.getElementById('photoMainEmpty');
            const photoCount = document.getElementById('photoCount');

            const primary = gallery.find(g => g.isPrimary) || gallery[0];

            if (primary) {
                mainImg.src = primary.url;
                mainImg.hidden = false;
                mainEmpty.hidden = true;
            } else {
                mainImg.hidden = true;
                mainEmpty.hidden = false;
            }

            photoCount.textContent = gallery.length === 1
                ? "1 foto's"
                : `${gallery.length} foto's`;

            // Rebuild thumbnail row, keep the "add" tile at the end
            Array.from(thumbsContainer.querySelectorAll('.photo-thumb:not(.photo-thumb--add)'))
                .forEach(el => el.remove());

            gallery.forEach(item => {
                const thumb = document.createElement('div');
                thumb.className = 'photo-thumb' + (item.isPrimary ? ' is-primary' : '');

                const img = document.createElement('img');
                img.src = item.url;
                img.alt = '';
                thumb.append(img);

                thumb.addEventListener('click', (e) => {
                    if (e.target.closest('.photo-thumb-remove')) return;
                    gallery.forEach(g => g.isPrimary = false);
                    item.isPrimary = true;
                    renderGallery();
                });

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'photo-thumb-remove';
                removeBtn.innerHTML = '<i class="ti ti-x"></i>';
                removeBtn.addEventListener('click', () => {
                    const wasPrimary = item.isPrimary;
                    gallery = gallery.filter(g => g.id !== item.id);
                    if (wasPrimary && gallery.length) {
                        gallery[0].isPrimary = true;
                    }
                    renderGallery();
                });
                thumb.append(removeBtn);

                thumbsContainer.insertBefore(thumb, addLabel);
            });
        }

        window.uploadGalleryPhotos = async function (productId) {
            const newItems = gallery.filter(g => g.isNew && g.file);
            for (const item of newItems) {
                const fd = new FormData();
                fd.append('photo', item.file);
                fd.append('is_primary', item.isPrimary ? '1' : '0');

                const res = await fetch(`/api/admin/upload_product_photo/${productId}`, {
                    method: 'POST',
                    body: fd
                });

                if (!res.ok) throw new Error('Foto upload mislukt');
            }
        };

        window.getRemovedImageIds = function () {
            // Existing (non-new) image ids that survived into the final gallery
            return gallery.filter(g => !g.isNew).map(g => g.id);
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
    // LIST EDITORS: features / specifications / instructions
    // =========================
    function initListEditors() {
        document.getElementById('addFeatureBtn').addEventListener('click', () => {
            features.push('');
            renderFeatures();
        });

        document.getElementById('addSpecBtn').addEventListener('click', () => {
            specifications.push({ id: nextRowId(), name: '', value: '' });
            renderSpecifications();
        });

        document.getElementById('addInstructionBtn').addEventListener('click', () => {
            const nextStep = instructions.length
                ? Math.max(...instructions.map(i => i.step || 0)) + 1
                : 1;
            instructions.push({ id: nextRowId(), step: nextStep, instruction: '' });
            renderInstructions();
        });

        renderFeatures();
        renderSpecifications();
        renderInstructions();
    }

    function renderFeatures() {
        const container = document.getElementById('featuresList');
        const count = document.getElementById('featuresCount');
        container.replaceChildren();

        count.textContent = features.length === 1 ? '1 item' : `${features.length} items`;

        if (!features.length) {
            const empty = document.createElement('p');
            empty.className = 'list-editor-empty';
            empty.textContent = 'Nog geen kenmerken toegevoegd.';
            container.append(empty);
            return;
        }

        features.forEach((text, index) => {
            const row = document.createElement('div');
            row.className = 'list-editor-row';

            const input = document.createElement('input');
            input.type = 'text';
            input.value = text;
            input.placeholder = 'Bijv. pH-neutraal en veilig voor natuursteen';
            input.addEventListener('input', () => {
                features[index] = input.value;
            });

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove-row';
            removeBtn.innerHTML = '<i class="ti ti-trash"></i>';
            removeBtn.addEventListener('click', () => {
                features.splice(index, 1);
                renderFeatures();
            });

            row.append(input, removeBtn);
            container.append(row);
        });
    }

    function renderSpecifications() {
        const container = document.getElementById('specsList');
        const count = document.getElementById('specsCount');
        container.replaceChildren();

        count.textContent = specifications.length === 1 ? '1 item' : `${specifications.length} items`;

        if (!specifications.length) {
            const empty = document.createElement('p');
            empty.className = 'list-editor-empty';
            empty.textContent = 'Nog geen specificaties toegevoegd.';
            container.append(empty);
            return;
        }

        specifications.forEach((spec, index) => {
            const row = document.createElement('div');
            row.className = 'list-editor-row';

            const nameInput = document.createElement('input');
            nameInput.type = 'text';
            nameInput.className = 'spec-name';
            nameInput.value = spec.name;
            nameInput.placeholder = 'Naam (bijv. Inhoud)';
            nameInput.addEventListener('input', () => {
                specifications[index].name = nameInput.value;
            });

            const valueInput = document.createElement('input');
            valueInput.type = 'text';
            valueInput.value = spec.value;
            valueInput.placeholder = 'Waarde (bijv. 1 liter)';
            valueInput.addEventListener('input', () => {
                specifications[index].value = valueInput.value;
            });

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove-row';
            removeBtn.innerHTML = '<i class="ti ti-trash"></i>';
            removeBtn.addEventListener('click', () => {
                specifications.splice(index, 1);
                renderSpecifications();
            });

            row.append(nameInput, valueInput, removeBtn);
            container.append(row);
        });
    }

    function renderInstructions() {
        const container = document.getElementById('instructionsList');
        const count = document.getElementById('instructionsCount');
        container.replaceChildren();

        count.textContent = instructions.length === 1 ? '1 stap' : `${instructions.length} stappen`;

        if (!instructions.length) {
            const empty = document.createElement('p');
            empty.className = 'list-editor-empty';
            empty.textContent = 'Nog geen instructies toegevoegd.';
            container.append(empty);
            return;
        }

        instructions.forEach((step, index) => {
            const row = document.createElement('div');
            row.className = 'list-editor-row';

            const stepInput = document.createElement('input');
            stepInput.type = 'number';
            stepInput.min = '1';
            stepInput.className = 'step-number-input';
            stepInput.value = step.step;
            stepInput.addEventListener('input', () => {
                instructions[index].step = parseInt(stepInput.value) || 1;
            });

            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.value = step.instruction;
            textInput.placeholder = 'Bijv. Verdun 10ml reiniger in 1 liter water';
            textInput.addEventListener('input', () => {
                instructions[index].instruction = textInput.value;
            });

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove-row';
            removeBtn.innerHTML = '<i class="ti ti-trash"></i>';
            removeBtn.addEventListener('click', () => {
                instructions.splice(index, 1);
                renderInstructions();
            });

            row.append(stepInput, textInput, removeBtn);
            container.append(row);
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
                short_description: formData.get('short_description'),
                description: formData.get('description'),
                price: parseFloat(formData.get('price')) || 0,
                sale_price: parseFloat(formData.get('sale_price')) || null,
                stock: parseInt(formData.get('stock')) || 0,
                sku: formData.get('sku'),
                brand_id: parseInt(formData.get('brand_id')) || null,
                category_id: parseInt(formData.get('category_id')) || null,
                tags: selectedTags.map(t => t.id),
                // Drop empty rows so blank add-row clicks don't get saved.
                features: features.map(f => f.trim()).filter(Boolean),
                specifications: specifications
                    .filter(s => s.name.trim() || s.value.trim())
                    .map(s => ({ name: s.name.trim(), value: s.value.trim() })),
                instructions: instructions
                    .filter(i => i.instruction.trim())
                    .map(i => ({ step: i.step, instruction: i.instruction.trim() })),
                kept_image_ids: window.getRemovedImageIds ? window.getRemovedImageIds() : [],
                primary_image_id: (gallery.find(g => g.isPrimary && !g.isNew) || {}).id || null
            };
            // Note: avg_rating / review_count are intentionally NOT included —
            // they're calculated by the DB view and never sent from this form.

            const res = await fetch(`/api/admin/update_product/${productId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error('Opslaan mislukt');

            if (window.uploadGalleryPhotos) {
                await window.uploadGalleryPhotos(productId);
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