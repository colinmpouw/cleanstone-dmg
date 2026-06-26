// Haal user ID uit URL: /admin/gebruikers/123
const userId = window.location.pathname.split('/').pop();

const AVATAR_COLORS = [
    '#5B4A3F','#7E6A52','#4A6741','#4A5F7E','#7E4A4A',
    '#4A6B7E','#6B4A7E','#7E6B4A','#3A5C4A','#5C3A4A'
];

function avatarColor(name) {
    let h = 0;
    for (const c of name) h = c.charCodeAt(0) + ((h << 5) - h);
    return AVATAR_COLORS[Math.abs(h) % AVATAR_COLORS.length];
}

function initials(name) {
    const p = name.trim().split(' ').filter(Boolean);
    return ((p[0]?.[0] ?? '') + (p[1]?.[0] ?? '')).toUpperCase();
}

function formatDate(str) {
    if (!str) return '—';
    return new Date(str).toLocaleDateString('nl-NL', { day: 'numeric', month: 'long', year: 'numeric' });
}

function starSVG(filled) {
    return filled
        ? `<svg viewBox="0 0 15 15" fill="#D4A843"><path d="M7.018.864 9.19 3.983l3.444.504-2.49 2.426.587 3.427-3.079-1.618-3.078 1.618.588-3.427L2.67 4.487l3.444-.504z" stroke="#D4A843" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"/></svg>`
        : `<svg viewBox="0 0 15 15" fill="none"><path d="M7.018.864 9.19 3.983l3.444.504-2.49 2.426.587 3.427-3.079-1.618-3.078 1.618.588-3.427L2.67 4.487l3.444-.504z" stroke="#D9CFC4" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
}

// ── LOAD USER ──
async function loadUser() {
    try {
        const res  = await fetch(`/api/admin/gebruikers/${userId}`);
        const data = await res.json();
        renderUser(data);
    } catch {
        document.querySelector('.content').innerHTML =
            '<p style="color:var(--rustic-taupe);padding:32px;">Gebruiker niet gevonden.</p>';
    }
}

function renderUser(u) {
    const name  = u.username || u.name || 'Onbekend';
    const role  = u.role === 'admin' || u.is_admin ? 'admin' : 'klant';
    const color = avatarColor(name);

    // avatar
    const av = document.getElementById('ud-avatar');
    av.textContent = initials(name);
    av.style.background = color;

    // profile info
    document.getElementById('ud-name').textContent  = name;
    document.getElementById('ud-email').textContent = u.email || '';
    document.getElementById('ud-since').textContent = 'Lid sinds ' + formatDate(u.created_at);

    const pill = document.getElementById('ud-role-pill');
    pill.textContent = role === 'admin' ? 'Admin' : 'Klant';

    // stats
    document.getElementById('stat-orders').textContent  = u.order_count  ?? u.bestellingen ?? 0;
    document.getElementById('stat-advies').textContent  = u.advies_count  ?? 0;
    document.getElementById('stat-reviews').textContent = u.review_count  ?? (u.reviews?.length ?? 0);

    // form
    document.getElementById('field-name').value    = name;
    document.getElementById('field-email').value   = u.email || '';
    document.getElementById('field-phone').value   = u.phone || u.telefoon || '';
    document.getElementById('field-created').value = formatDate(u.created_at);
    setRole(role);

    // reviews
    renderReviews(u.reviews || []);
}

// ── ROLE TOGGLE ──
function setRole(role) {
    document.getElementById('field-role').value = role;
    document.getElementById('role-klant').classList.toggle('active', role === 'klant');
    document.getElementById('role-admin').classList.toggle('active', role === 'admin');
}

document.querySelectorAll('.ud-role-btn').forEach(btn => {
    btn.addEventListener('click', () => setRole(btn.dataset.role));
});

// ── REVIEWS ──
function renderReviews(reviews) {
    const list  = document.getElementById('ud-reviews-list');
    const badge = document.getElementById('ud-review-count');
    badge.textContent = `${reviews.length} geplaatst`;

    if (!reviews.length) {
        list.innerHTML = '<p class="ud-empty">Geen reviews gevonden.</p>';
        return;
    }

    list.innerHTML = reviews.map(r => {
        const stars = Array.from({ length: 5 }, (_, i) => starSVG(i < r.rating)).join('');
        return `
        <div class="ud-review-item" data-id="${r.id}">
            <div class="ud-review-top">
                <div class="ud-review-stars-date">
                    <div class="ud-review-stars">${stars}</div>
                    <span class="ud-review-date">${formatDate(r.created_at)}</span>
                </div>
                <button class="ud-review-delete" onclick="deleteReview(${r.id}, this)" title="Verwijderen">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                </button>
            </div>
            ${r.product_name ? `<span class="ud-review-product">${r.product_name}</span>` : ''}
            ${r.title ? `<div class="ud-review-title">${r.title}</div>` : ''}
            <p class="ud-review-text">${r.review || r.content || ''}</p>
        </div>`;
    }).join('');
}

async function deleteReview(reviewId, btn) {
    if (!confirm('Review verwijderen?')) return;
    try {
        const res = await fetch(`/api/admin/reviews/${reviewId}`, { method: 'DELETE' });
        if (res.ok) {
            btn.closest('.ud-review-item').remove();
            const remaining = document.querySelectorAll('.ud-review-item').length;
            document.getElementById('ud-review-count').textContent = `${remaining} geplaatst`;
            document.getElementById('stat-reviews').textContent = remaining;
        }
    } catch { alert('Verwijderen mislukt.'); }
}

// ── SAVE FORM ──
document.getElementById('ud-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.querySelector('.ud-save-btn');
    btn.disabled = true;
    btn.textContent = 'Opslaan...';

    try {
        const res = await fetch(`/api/admin/gebruikers/${userId}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name:  document.getElementById('field-name').value,
                email: document.getElementById('field-email').value,
                phone: document.getElementById('field-phone').value,
                role:  document.getElementById('field-role').value,
            })
        });
        if (res.ok) {
            btn.textContent = '✓ Opgeslagen';
            setTimeout(() => { btn.disabled = false; btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Opslaan'; }, 2000);
        } else {
            btn.textContent = 'Fout bij opslaan';
            setTimeout(() => { btn.disabled = false; btn.textContent = 'Opslaan'; }, 2000);
        }
    } catch {
        btn.disabled = false;
        btn.textContent = 'Opslaan';
    }
});

loadUser();