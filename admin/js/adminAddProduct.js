document.addEventListener('DOMContentLoaded', async () => {

    const form = document.getElementById('productForm');
    const saveBtn = document.getElementById('saveBtn');

    let selectedTags = [];

    // Main image: single file, separate from the gallery
    // { file, url } or null
    let mainImage = null;

    // Gallery state: array of { id, url, file }
    // Gallery images are always "extra" photos — the main image is tracked separately.
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
        const [categoriesRes, brandsRes, tagsRes] = await Promise.all([
            fetch('/api/admin/get_all_categories'),
            fetch('/api/admin/get_all_brands'),
            fetch('/api/admin/get_all_tags')
        ]);

        const categoriesJson = await categoriesRes.json();
        const brandsJson = await brandsRes.json();
        const tagsJson = await tagsRes.json();

        populateSelects(
            categoriesJson.data || [],
            brandsJson.data || []
        );

        initTagSelect(tagsJson.data || []);
        initMainImage();
        initGallery();
        initDiscount();
        initListEditors();

        saveBtn.addEventListener('click', handleSave);

    } catch (error) {
        console.error(error);

        showAlert({
            type: 'error',
            title: 'Fout',
            message: 'Data laden mislukt'
        });
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
    // TAG SELECT (multi-select dropdown — click to toggle, no typing)
    // =========================
    function initTagSelect(allTags) {
        const toggle = document.getElementById('tagSelectToggle');
        const dropdown = document.getElementById('tagDropdown');

        renderDropdown();

        toggle.addEventListener('click', () => {
            dropdown.hidden = !dropdown.hidden;
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.tag-select')) {
                dropdown.hidden = true;
            }
        });

        function renderDropdown() {
            dropdown.replaceChildren();

            if (!allTags.length) {
                const empty = document.createElement('p');
                empty.className = 'tag-option-empty';
                empty.textContent = 'Geen tags beschikbaar';
                dropdown.append(empty);
                return;
            }

            allTags.forEach(tag => {
                const isSelected = selectedTags.some(t => t.id === tag.id);

                const option = document.createElement('button');
                option.type = 'button';
                option.className = 'tag-option' + (isSelected ? ' is-selected' : '');

                const check = document.createElement('span');
                check.className = 'tag-option-check';
                check.innerHTML = isSelected ? '<i class="ti ti-check"></i>' : '';

                const label = document.createElement('span');
                label.textContent = tag.name;

                option.append(check, label);

                option.addEventListener('click', () => {
                    if (isSelected) {
                        selectedTags = selectedTags.filter(t => t.id !== tag.id);
                    } else {
                        selectedTags.push(tag);
                    }
                    renderTagChips();
                    renderDropdown();
                });

                dropdown.append(option);
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
    // MAIN IMAGE (separate slot from the gallery)
    // =========================
    function initMainImage() {
        const input = document.getElementById('photoInput');
        const mainImg = document.getElementById('photoMainImg');
        const mainEmpty = document.getElementById('photoMainEmpty');
        const mainSlot = document.getElementById('photoMain');

        renderMainImage();

        // Clicking the main photo area opens the file picker for the main image
        mainSlot.addEventListener('click', (e) => {
            if (e.target.closest('.photo-main-remove')) return;
            input.click();
        });

        input.addEventListener('change', (e) => {
            const file = e.target.files && e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (evt) => {
                mainImage = { file, url: evt.target.result };
                renderMainImage();
            };
            reader.readAsDataURL(file);

            input.value = ''; // allow re-selecting the same file later
        });

        function renderMainImage() {
            if (mainImage) {
                mainImg.src = mainImage.url;
                mainImg.hidden = false;
                mainEmpty.hidden = true;
            } else {
                mainImg.hidden = true;
                mainEmpty.hidden = false;
            }
        }
    }

    // =========================
    // PHOTO GALLERY (extra photos only — main image lives in its own slot)
    // =========================
    function initGallery() {
        const galleryInput = document.getElementById('galleryInput');
        const thumbsContainer = document.getElementById('photoThumbs');
        const addLabel = thumbsContainer.querySelector('.photo-thumb--add');

        galleryInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files || []);
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (evt) => {
                    gallery.push({
                        id: nextRowId(),
                        url: evt.target.result,
                        file
                    });
                    renderGallery();
                };
                reader.readAsDataURL(file);
            });
            galleryInput.value = ''; // allow re-selecting the same file later
        });

        renderGallery();

        function renderGallery() {
            const photoCount = document.getElementById('photoCount');

            photoCount.textContent = gallery.length === 1
                ? "1 foto's"
                : `${gallery.length} foto's`;

            // Rebuild thumbnail row, keep the "add" tile at the end
            Array.from(thumbsContainer.querySelectorAll('.photo-thumb:not(.photo-thumb--add)'))
                .forEach(el => el.remove());

            gallery.forEach(item => {
                const thumb = document.createElement('div');
                thumb.className = 'photo-thumb';

                const img = document.createElement('img');
                img.src = item.url;
                img.alt = '';
                thumb.append(img);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'photo-thumb-remove';
                removeBtn.innerHTML = '<i class="ti ti-x"></i>';
                removeBtn.addEventListener('click', () => {
                    gallery = gallery.filter(g => g.id !== item.id);
                    renderGallery();
                });

                thumb.append(removeBtn);

                thumbsContainer.insertBefore(thumb, addLabel);
            });
        }
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
    // SAVE — one request, product fields + main image + gallery files together
    // =========================
    async function handleSave() {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Opslaan...';

        try {
            const formData = new FormData(form);

            const fd = new FormData();
            fd.append('name', formData.get('name') || '');
            fd.append('short_description', formData.get('short_description') || '');
            fd.append('description', formData.get('description') || '');
            fd.append('price', parseFloat(formData.get('price')) || 0);
            fd.append('sale_price', formData.get('sale_price') ? parseFloat(formData.get('sale_price')) : '');
            fd.append('stock', parseInt(formData.get('stock')) || 0);
            fd.append('sku', formData.get('sku') || '');
            fd.append('brand_id', formData.get('brand_id') || '');
            fd.append('category_id', formData.get('category_id') || '');

            fd.append('tags', JSON.stringify(selectedTags.map(t => t.id)));

            fd.append('features', JSON.stringify(
                features.map(f => f.trim()).filter(Boolean)
            ));

            fd.append('specifications', JSON.stringify(
                specifications
                    .filter(s => s.name.trim() || s.value.trim())
                    .map(s => ({ name: s.name.trim(), value: s.value.trim() }))
            ));

            fd.append('instructions', JSON.stringify(
                instructions
                    .filter(i => i.instruction.trim())
                    .map(i => ({ step: i.step, instruction: i.instruction.trim() }))
            ));

            // Main image goes under its own field name
            if (mainImage && mainImage.file) {
                fd.append('main_image', mainImage.file);
            }

            // Gallery images all go under the same repeated field name
            gallery.forEach(item => {
                fd.append('gallery_images[]', item.file);
            });

            // Note: avg_rating / review_count are intentionally NOT included —
            // they're calculated by the DB view and never sent from this form.

            const res = await fetch(`/api/admin/create_product`, {
                method: 'POST',
                body: fd
            });

            if (!res.ok) throw new Error('Opslaan mislukt');

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