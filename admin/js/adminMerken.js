let allMerken = [];
let editingId = null;

function toast(msg, type = 'success') {
    const t = document.createElement('div');
    t.className = `toast toast--${type}`;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 3000);
}

const modal = document.getElementById('merk-modal');

function openModal(merk = null) {
    editingId = merk ? merk.id : null;
    document.getElementById('modal-title').textContent = merk ? 'Merk bewerken' : 'Nieuw merk';
    document.getElementById('f-name').value        = merk?.name        ?? '';
    document.getElementById('f-discription').value = merk?.discription ?? '';
    document.getElementById('f-logo').value        = merk?.logo        ?? '';

    // logo preview
    const preview     = document.getElementById('logo-preview');
    const placeholder = document.getElementById('logo-upload-placeholder');
    if (merk?.logo) {
        preview.src          = `/uploads/brands/${merk.logo}`;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
    } else {
        preview.src          = '';
        preview.style.display = 'none';
        placeholder.style.display = 'flex';
    }

    modal.classList.add('show');
}

function closeModal() {
    modal.classList.remove('show');
    editingId = null;
}

modal?.addEventListener('click', e => { if (e.target === modal) closeModal(); });
document.getElementById('btn-new-merk')?.addEventListener('click', () => openModal());

function renderSkeletons(count = 6) {
    const grid = document.getElementById('merken-grid');
    grid.innerHTML = Array.from({ length: count }, () => `
        <div class="merk-card merk-card--skeleton">
            <div class="skeleton-block merk-skel-logo"></div>
            <div class="merk-card__info">
                <span class="skeleton-block skeleton-line merk-skel-name"></span>
                <span class="skeleton-block skeleton-line merk-skel-desc"></span>
                <span class="skeleton-block skeleton-line merk-skel-file"></span>
            </div>
        </div>`).join('');
}

async function loadMerken() {
    renderSkeletons();
    try {
        const res  = await fetch('/api/admin/merken');
        const data = await res.json();
        allMerken  = data.data ?? [];
        document.getElementById('merken-count').textContent =
            `${allMerken.length} merk${allMerken.length !== 1 ? 'en' : ''}`;
        renderGrid(allMerken);
    } catch {
        toast('Laden mislukt', 'error');
    }
}

// logo upload
document.getElementById('logo-upload-zone')?.addEventListener('click', () => {
    document.getElementById('f-logo-file').click();
});

document.getElementById('f-logo-file')?.addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('logo', file);

    try {
        const res  = await fetch('/api/admin/merken/upload-logo', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
            document.getElementById('f-logo').value = data.filename;
            const preview = document.getElementById('logo-preview');
            const placeholder = document.getElementById('logo-upload-placeholder');
            preview.src = `/uploads/brands/${data.filename}`;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            toast('Logo geüpload');
        } else {
            toast(data.message || 'Upload mislukt', 'error');
        }
    } catch {
        toast('Upload mislukt', 'error');
    }
});

function renderGrid(merken) {
    const grid = document.getElementById('merken-grid');

    if (!merken.length) {
        grid.innerHTML = '<p style="color:var(--rustic-taupe)">Geen merken gevonden.</p>';
        return;
    }

    grid.innerHTML = merken.map(m => {
        const logoSrc = m.logo ? `/uploads/brands/${m.logo}` : null;

        return `
        <div class="merk-card">
            <div class="merk-card__logo">
                ${logoSrc
            ? `<img src="${logoSrc}" alt="${m.name}" onerror="this.style.display='none'">`
            : `<span class="merk-card__initials">${m.name.charAt(0).toUpperCase()}</span>`
        }
            </div>
            <div class="merk-card__info">
                <strong>${m.name}</strong>
                <span>${m.discription || '—'}</span>
                <span class="merk-card__logo-file">${m.logo || 'Geen logo'}</span>
            </div>
            <div class="merk-card__actions">
                <button class="action-btn" onclick='openModal(${JSON.stringify(m)})'>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </button>
                <button class="action-btn action-btn--delete" onclick="deleteMerk(${m.id})">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                </button>
            </div>
        </div>`;
    }).join('');
}

document.getElementById('merk-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const payload = {
        name:        document.getElementById('f-name').value.trim(),
        discription: document.getElementById('f-discription').value.trim(),
        logo:        document.getElementById('f-logo').value.trim(),
    };

    const url    = editingId ? `/api/admin/merken/${editingId}` : '/api/admin/merken';
    const method = editingId ? 'PUT' : 'POST';

    try {
        const res  = await fetch(url, { method, headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
        const data = await res.json();

        if (data.success) {
            toast(editingId ? 'Merk bijgewerkt' : 'Merk aangemaakt');
            closeModal();
            loadMerken();
        } else {
            toast(data.message || 'Opslaan mislukt', 'error');
        }
    } catch { toast('Er is iets misgegaan', 'error'); }
});

async function deleteMerk(id) {
    if (!confirm('Weet u zeker dat u dit merk wilt verwijderen?')) return;
    try {
        const res  = await fetch(`/api/admin/merken/${id}`, { method: 'DELETE' });
        const data = await res.json();
        if (data.success) { toast('Merk verwijderd'); loadMerken(); }
        else toast('Verwijderen mislukt', 'error');
    } catch { toast('Er is iets misgegaan', 'error'); }
}

loadMerken();