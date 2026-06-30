let allCategories  = [];
let allTags        = [];
let editingCatId    = null;
let editingTagId    = null;

function toast(msg, type = 'success') {
    const t = document.createElement('div');
    t.className = `toast toast--${type}`;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 3000);
}

// ── TABS ──
document.querySelectorAll('.ct-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.ct-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const target = tab.dataset.tab;
        document.getElementById('panel-categories').style.display = target === 'categories' ? 'block' : 'none';
        document.getElementById('panel-tags').style.display       = target === 'tags' ? 'block' : 'none';
    });
});

/* ═══════════ CATEGORIES ═══════════ */

const catModal = document.getElementById('category-modal');

function openCategoryModal(cat = null) {
    editingCatId = cat ? cat.id : null;
    document.getElementById('cat-modal-title').textContent = cat ? 'Categorie bewerken' : 'Nieuwe categorie';
    document.getElementById('cat-name').value = cat?.name ?? '';
    document.getElementById('cat-slug').value = cat?.slug ?? '';

    // parent dropdown vullen (alleen hoofdcategorieën, exclusief zichzelf)
    const select = document.getElementById('cat-parent');
    select.innerHTML = '<option value="">— Geen (hoofdcategorie) —</option>';
    allCategories
        .filter(c => !c.parent_id && c.id !== editingCatId)
        .forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.name;
            select.appendChild(opt);
        });
    select.value = cat?.parent_id ?? '';

    catModal.classList.add('show');
}

function closeCategoryModal() {
    catModal.classList.remove('show');
    editingCatId = null;
}

catModal?.addEventListener('click', e => { if (e.target === catModal) closeCategoryModal(); });
document.getElementById('btn-new-category')?.addEventListener('click', () => openCategoryModal());

function renderCategorySkeletons(count = 4) {
    const container = document.getElementById('categories-tree');
    if (!container) return;
    container.innerHTML = Array.from({ length: count }, () => `
        <div class="ct-tree-group">
            <div class="ct-tree-item ct-tree-item--main">
                <span class="skeleton-block skeleton-line skel-cat-name"></span>
                <span class="skeleton-block skeleton-line skel-cat-slug"></span>
                <div class="ct-tree-actions" style="visibility:hidden">
                    <button class="action-btn"></button><button class="action-btn"></button>
                </div>
            </div>
            <div class="ct-tree-item ct-tree-item--child">
                <span class="ct-tree-dash">—</span>
                <span class="skeleton-block skeleton-line skel-cat-child"></span>
                <span class="skeleton-block skeleton-line skel-cat-slug"></span>
                <div class="ct-tree-actions" style="visibility:hidden">
                    <button class="action-btn"></button><button class="action-btn"></button>
                </div>
            </div>
        </div>`).join('');
}

async function loadCategories() {
    renderCategorySkeletons();
    try {
        const res  = await fetch('/api/admin/categories');
        const data = await res.json();
        allCategories = data.data ?? [];
        document.getElementById('cat-count').textContent = allCategories.length;
        renderCategoryTree(allCategories);
    } catch { toast('Categorieën laden mislukt', 'error'); }
}

function renderCategoryTree(categories) {
    const container = document.getElementById('categories-tree');
    const mainCats   = categories.filter(c => !c.parent_id);

    if (!mainCats.length) {
        container.innerHTML = '<p style="color:var(--rustic-taupe)">Geen categorieën gevonden.</p>';
        return;
    }

    container.innerHTML = mainCats.map(main => {
        const children = categories.filter(c => c.parent_id == main.id);
        const childrenHTML = children.map(child => `
            <div class="ct-tree-item ct-tree-item--child">
                <span class="ct-tree-dash">—</span>
                <span class="ct-tree-name">${child.name}</span>
                <span class="ct-tree-slug">${child.slug}</span>
                <div class="ct-tree-actions">
                    <button class="action-btn" onclick='openCategoryModal(${JSON.stringify(child)})'>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="action-btn action-btn--delete" onclick="deleteCategory(${child.id})">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    </button>
                </div>
            </div>`).join('');

        return `
        <div class="ct-tree-group">
            <div class="ct-tree-item ct-tree-item--main">
                <span class="ct-tree-name">${main.name}</span>
                <span class="ct-tree-slug">${main.slug}</span>
                <div class="ct-tree-actions">
                    <button class="action-btn" onclick='openCategoryModal(${JSON.stringify(main)})'>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="action-btn action-btn--delete" onclick="deleteCategory(${main.id})">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    </button>
                </div>
            </div>
            ${childrenHTML}
        </div>`;
    }).join('');
}

document.getElementById('category-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const payload = {
        name:      document.getElementById('cat-name').value.trim(),
        slug:      document.getElementById('cat-slug').value.trim(),
        parent_id: document.getElementById('cat-parent').value || null,
    };

    const url    = editingCatId ? `/api/admin/categories/${editingCatId}` : '/api/admin/categories';
    const method = editingCatId ? 'PUT' : 'POST';

    try {
        const res  = await fetch(url, { method, headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
        const data = await res.json();
        if (data.success) {
            toast(editingCatId ? 'Categorie bijgewerkt' : 'Categorie aangemaakt');
            closeCategoryModal();
            loadCategories();
        } else {
            toast(data.message || 'Opslaan mislukt', 'error');
        }
    } catch { toast('Er is iets misgegaan', 'error'); }
});

async function deleteCategory(id) {
    if (!confirm('Weet u zeker dat u deze categorie wilt verwijderen?')) return;
    try {
        const res  = await fetch(`/api/admin/categories/${id}`, { method: 'DELETE' });
        const data = await res.json();
        if (data.success) { toast('Categorie verwijderd'); loadCategories(); }
        else toast('Verwijderen mislukt', 'error');
    } catch { toast('Er is iets misgegaan', 'error'); }
}

/* ═══════════ TAGS ═══════════ */

const tagModal = document.getElementById('tag-modal');

function openTagModal(tag = null) {
    editingTagId = tag ? tag.id : null;
    document.getElementById('tag-modal-title').textContent = tag ? 'Tag bewerken' : 'Nieuwe tag';
    document.getElementById('tag-name').value = tag?.name ?? '';
    tagModal.classList.add('show');
}

function closeTagModal() {
    tagModal.classList.remove('show');
    editingTagId = null;
}

tagModal?.addEventListener('click', e => { if (e.target === tagModal) closeTagModal(); });
document.getElementById('btn-new-tag')?.addEventListener('click', () => openTagModal());

function renderTagSkeletons(count = 8) {
    const grid = document.getElementById('tags-grid');
    if (!grid) return;
    grid.innerHTML = Array.from({ length: count }, () =>
        `<div class="skeleton-block skeleton-pill skel-tag"></div>`).join('');
}

async function loadTags() {
    renderTagSkeletons();
    try {
        const res  = await fetch('/api/admin/tags');
        const data = await res.json();
        allTags = data.data ?? [];
        document.getElementById('tag-count').textContent = allTags.length;
        renderTagsGrid(allTags);
    } catch { toast('Tags laden mislukt', 'error'); }
}

function renderTagsGrid(tags) {
    const grid = document.getElementById('tags-grid');

    if (!tags.length) {
        grid.innerHTML = '<p style="color:var(--rustic-taupe)">Geen tags gevonden.</p>';
        return;
    }

    grid.innerHTML = tags.map(t => `
        <div class="ct-tag-chip">
            <span>${t.name}</span>
            <div class="ct-tag-actions">
                <button class="action-btn" onclick='openTagModal(${JSON.stringify(t)})'>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </button>
                <button class="action-btn action-btn--delete" onclick="deleteTag(${t.id})">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                </button>
            </div>
        </div>`).join('');
}

document.getElementById('tag-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const payload = { name: document.getElementById('tag-name').value.trim() };
    const url    = editingTagId ? `/api/admin/tags/${editingTagId}` : '/api/admin/tags';
    const method = editingTagId ? 'PUT' : 'POST';

    try {
        const res  = await fetch(url, { method, headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
        const data = await res.json();
        if (data.success) {
            toast(editingTagId ? 'Tag bijgewerkt' : 'Tag aangemaakt');
            closeTagModal();
            loadTags();
        } else {
            toast(data.message || 'Opslaan mislukt', 'error');
        }
    } catch { toast('Er is iets misgegaan', 'error'); }
});

async function deleteTag(id) {
    if (!confirm('Weet u zeker dat u deze tag wilt verwijderen?')) return;
    try {
        const res  = await fetch(`/api/admin/tags/${id}`, { method: 'DELETE' });
        const data = await res.json();
        if (data.success) { toast('Tag verwijderd'); loadTags(); }
        else toast('Verwijderen mislukt', 'error');
    } catch { toast('Er is iets misgegaan', 'error'); }
}

loadCategories();
loadTags();