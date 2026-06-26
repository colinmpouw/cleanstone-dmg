const AVATAR_COLORS = [
    '#5B4A3F', '#7E6A52', '#4A6741', '#4A5F7E', '#7E4A4A',
    '#4A6B7E', '#6B4A7E', '#7E6B4A', '#3A5C4A', '#5C3A4A'
];

function avatarColor(name) {
    let hash = 0;
    for (const c of name) hash = c.charCodeAt(0) + ((hash << 5) - hash);
    return AVATAR_COLORS[Math.abs(hash) % AVATAR_COLORS.length];
}

function initials(name) {
    const parts = name.trim().split(' ').filter(Boolean);
    return ((parts[0]?.[0] ?? '') + (parts[1]?.[0] ?? '')).toUpperCase();
}

function formatDate(str) {
    if (!str) return '—';
    return new Date(str).toLocaleDateString('nl-NL', { day: 'numeric', month: 'long', year: 'numeric' });
}

function renderRows(users) {
    const list  = document.getElementById('usersList');
    const count = document.getElementById('userCount');

    count.textContent = `${users.length} geregistreerde gebruiker${users.length !== 1 ? 's' : ''}`;

    if (!users.length) {
        list.innerHTML = '<div class="users-empty">Geen gebruikers gevonden.</div>';
        return;
    }

    list.innerHTML = users.map(u => {
        const name    = u.username || u.name || 'Onbekend';
        const isAdmin = u.role === 'admin' || !!u.is_admin;
        const orders  = u.order_count ?? u.bestellingen ?? 0;

        return `
        <a class="user-row" href="/admin/gebruikers/${u.id}">
            <div class="user-avatar" style="background:${avatarColor(name)}">${initials(name)}</div>
            <div class="user-info">
                <div class="user-info__top">
                    <span class="user-name">${name}</span>
                    ${isAdmin ? '<span class="user-admin-badge">Admin</span>' : ''}
                </div>
                <span class="user-email">${u.email || ''}</span>
                <div class="user-meta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    ${formatDate(u.created_at)}
                    <span class="sep">·</span>
                    <span class="user-orders">${orders} bestelling${orders !== 1 ? 'en' : ''}</span>
                </div>
            </div>
            <svg class="user-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
        </a>`;
    }).join('');
}

let allUsers = [];

async function loadUsers() {
    try {
        const res  = await fetch('/api/admin/gebruikers');
        const data = await res.json();
        allUsers   = data.users ?? data ?? [];
        renderRows(allUsers);
    } catch {
        document.getElementById('usersList').innerHTML =
            '<div class="users-empty">Er is iets misgegaan bij het laden.</div>';
    }
}

// live search
document.getElementById('userSearch').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    if (!q) { renderRows(allUsers); return; }
    renderRows(allUsers.filter(u =>
        (u.username || u.name || '').toLowerCase().includes(q) ||
        (u.email || '').toLowerCase().includes(q)
    ));
});

loadUsers();