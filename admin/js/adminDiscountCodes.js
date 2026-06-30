let allCodes  = [];
let editingId = null;

// ── Toast ──
function toast(msg, type = 'success') {
    const t = document.createElement('div');
    t.className = `toast toast--${type}`;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 3000);
}

// ── Modal ──
const modal = document.getElementById('discount-modal');

function openModal(code = null) {
    editingId = code ? code.id : null;
    document.getElementById('modal-title').textContent = code ? 'Code bewerken' : 'Nieuwe code';
    document.getElementById('f-code').value             = code?.code             ?? '';
    document.getElementById('f-type').value             = code?.type             ?? 'percentage';
    document.getElementById('f-value').value            = code?.value            ?? '';
    document.getElementById('f-min').value              = code?.min_order_amount ?? '';
    document.getElementById('f-max').value              = code?.max_discount     ?? '';
    document.getElementById('f-limit').value            = code?.usage_limit      ?? '';
    document.getElementById('f-start').value            = code?.start_date?.slice(0, 16) ?? '';
    document.getElementById('f-end').value              = code?.end_date?.slice(0, 16)   ?? '';
    document.getElementById('f-status').value           = code?.status           ?? 'active';
    modal.classList.add('show');
}

function closeModal() {
    modal.classList.remove('show');
    editingId = null;
}

modal?.addEventListener('click', e => { if (e.target === modal) closeModal(); });
document.getElementById('btn-new-code')?.addEventListener('click', () => openModal());

// ── Skeleton ──
function renderSkeletons(count = 6) {
    const tbody = document.getElementById('discount-tbody');
    const rows = Array.from({ length: count }, () => {
        const tr = document.createElement('tr');
        tr.className = 'skeleton-row';
        tr.innerHTML = `
            <td><div class="skeleton-block skeleton-line skel-dc-code"></div></td>
            <td><div class="skeleton-block skeleton-pill skel-dc-type"></div></td>
            <td><div class="skeleton-block skeleton-line skel-dc-value"></div></td>
            <td><div class="skeleton-block skeleton-line skel-dc-min"></div></td>
            <td><div class="skeleton-block skeleton-line skel-dc-usage"></div></td>
            <td><div class="skeleton-block skeleton-line skel-dc-date"></div></td>
            <td><div class="skeleton-block skeleton-pill skel-dc-status"></div></td>
            <td><div class="skeleton-block skeleton-line skel-dc-actions"></div></td>`;
        return tr;
    });
    tbody.replaceChildren(...rows);
}

// ── Load ──
async function loadCodes() {
    renderSkeletons();
    try {
        const res  = await fetch('/api/admin/discount-codes');
        const data = await res.json();
        allCodes   = data.data ?? [];
        document.getElementById('discount-count').textContent =
            `${allCodes.length} code${allCodes.length !== 1 ? 's' : ''}`;
        renderTable(allCodes);
    } catch {
        toast('Laden mislukt', 'error');
    }
}

function renderTable(codes) {
    const tbody = document.getElementById('discount-tbody');

    if (!codes.length) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;color:var(--rustic-taupe);padding:32px;">Geen codes gevonden.</td></tr>';
        return;
    }

    tbody.innerHTML = codes.map(c => {
        const isActive  = c.status === 'active';
        const valueStr  = c.type === 'percentage' ? `${c.value}%` : `€${parseFloat(c.value).toFixed(2)}`;
        const usageStr  = c.usage_limit ? `${c.used_count}/${c.usage_limit}` : `${c.used_count}/∞`;
        const endStr    = c.end_date ? new Date(c.end_date).toLocaleDateString('nl-NL') : '—';

        return `
        <tr>
            <td><span class="code-pill">${c.code}</span></td>
            <td><span class="type-badge type-badge--${c.type}">${c.type === 'percentage' ? 'Percentage' : 'Vast bedrag'}</span></td>
            <td>${valueStr}</td>
            <td>${c.min_order_amount ? '€' + parseFloat(c.min_order_amount).toFixed(2) : '—'}</td>
            <td>${usageStr}</td>
            <td>${endStr}</td>
            <td>
                <button class="status-toggle ${isActive ? 'status-toggle--active' : 'status-toggle--inactive'}"
                        onclick="toggleStatus(${c.id}, '${isActive ? 'inactive' : 'active'}')">
                    ${isActive ? 'Actief' : 'Inactief'}
                </button>
            </td>
            <td class="actions-cell">
                <button class="action-btn" onclick='editCode(${JSON.stringify(c)})'>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </button>
                <button class="action-btn action-btn--delete" onclick="deleteCode(${c.id})">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                </button>
            </td>
        </tr>`;
    }).join('');
}

function editCode(code) { openModal(code); }

// ── Save ──
document.getElementById('discount-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const payload = {
        code:             document.getElementById('f-code').value.trim(),
        type:             document.getElementById('f-type').value,
        value:            document.getElementById('f-value').value,
        min_order_amount: document.getElementById('f-min').value || null,
        max_discount:     document.getElementById('f-max').value || null,
        usage_limit:      document.getElementById('f-limit').value || null,
        start_date:       document.getElementById('f-start').value || null,
        end_date:         document.getElementById('f-end').value || null,
        status:           document.getElementById('f-status').value,
    };

    const url    = editingId ? `/api/admin/discount-codes/${editingId}` : '/api/admin/discount-codes';
    const method = editingId ? 'PUT' : 'POST';

    try {
        const res  = await fetch(url, { method, headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
        const data = await res.json();

        if (data.success) {
            toast(editingId ? 'Code bijgewerkt' : 'Code aangemaakt');
            closeModal();
            loadCodes();
        } else {
            toast(data.message || 'Opslaan mislukt', 'error');
        }
    } catch { toast('Er is iets misgegaan', 'error'); }
});

// ── Delete ──
async function deleteCode(id) {
    if (!confirm('Weet u zeker dat u deze code wilt verwijderen?')) return;
    try {
        const res  = await fetch(`/api/admin/discount-codes/${id}`, { method: 'DELETE' });
        const data = await res.json();
        if (data.success) { toast('Code verwijderd'); loadCodes(); }
        else toast('Verwijderen mislukt', 'error');
    } catch { toast('Er is iets misgegaan', 'error'); }
}

// ── Toggle status ──
async function toggleStatus(id, newStatus) {
    try {
        const res  = await fetch(`/api/admin/discount-codes/${id}/toggle`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ status: newStatus })
        });
        const data = await res.json();
        if (data.success) { toast(`Code ${newStatus === 'active' ? 'geactiveerd' : 'gedeactiveerd'}`); loadCodes(); }
        else toast('Wijzigen mislukt', 'error');
    } catch { toast('Er is iets misgegaan', 'error'); }
}

// ── Search ──
document.getElementById('discount-search')?.addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    if (!q) { renderTable(allCodes); return; }
    renderTable(allCodes.filter(c => c.code.toLowerCase().includes(q)));
});

loadCodes();