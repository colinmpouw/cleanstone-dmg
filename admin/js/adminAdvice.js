let allRequests = [];
let activeFilter = 'all';

async function loadAdviesAanvragen() {
    renderSkeletons();

    try {
        const res  = await fetch('/api/admin/adviesaanvragen');
        const data = await res.json();

        if (!data.success) return;

        allRequests = data.data;

        // counts
        document.getElementById('count-all').textContent            = data.total;
        document.getElementById('count-open').textContent           = data.counts.open || 0;
        document.getElementById('count-in_behandeling').textContent = data.counts.in_behandeling || 0;
        document.getElementById('count-gesloten').textContent       = data.counts.gesloten || 0;

        // header subtitle
        const nieuweCount = data.counts.open || 0;
        document.querySelector('.aanvragen-page__header p').textContent =
            nieuweCount > 0
                ? `${nieuweCount} nieuwe aanvra${nieuweCount === 1 ? 'ag' : 'gen'} wacht${nieuweCount === 1 ? '' : 'en'} op beantwoording`
                : 'Alle aanvragen zijn beantwoord';

        renderGrid(allRequests);

    } catch (err) {
        console.error(err);
    }
}

function renderSkeletons(count = 6) {
    const grid = document.getElementById('aanvragen-grid');
    grid.replaceChildren(...Array.from({ length: count }, createSkeletonCard));
}

function createSkeletonCard() {
    const card = document.createElement('div');
    card.className = 'aanvraag-card skeleton-card';
    card.innerHTML = `
        <div class="skeleton-block skeleton-card-img"></div>
        <div class="aanvraag-card__body">
            <div class="aanvraag-card__top">
                <div>
                    <div class="skeleton-block skeleton-card-name"></div>
                    <div class="skeleton-block skeleton-card-sub"></div>
                </div>
                <div class="skeleton-block skeleton-card-badge"></div>
            </div>
            <div>
                <div class="skeleton-block skeleton-card-text-1"></div>
                <div class="skeleton-block skeleton-card-text-2"></div>
                <div class="skeleton-block skeleton-card-text-3"></div>
            </div>
            <div class="aanvraag-card__footer">
                <div class="skeleton-block skeleton-card-date"></div>
                <div class="skeleton-block skeleton-card-btn"></div>
            </div>
        </div>
    `;
    return card;
}

function renderGrid(requests) {
    const grid = document.getElementById('aanvragen-grid');

    if (!requests.length) {
        grid.innerHTML = '<p>Geen aanvragen gevonden.</p>';
        return;
    }

    grid.innerHTML = '';

    requests.forEach((r, index) => {
        const card = document.createElement('div');
        card.className = 'aanvraag-card aanvraag-card--enter';

        const imgHTML = r.first_image
            ? `<img class="aanvraag-card__img" src="/uploads/advies/${r.first_image}" alt="foto">`
            : `<div class="aanvraag-card__no-img">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                </svg>
               </div>`;

        const badgeClass = r.status === 'open' ? 'nieuw'
            : r.status === 'in_behandeling' ? 'behandeling'
                : 'beantwoord';

        const badgeLabel = r.status === 'open' ? 'Nieuw'
            : r.status === 'in_behandeling' ? 'In behandeling'
                : 'Beantwoord';

        const btnClass = r.status === 'open' ? 'aanvraag-card__btn--primary' : 'aanvraag-card__btn--outline';
        const btnLabel = r.status === 'open' ? 'Beantwoord' : 'Bekijk';

        const date = new Date(r.created_at).toLocaleDateString('nl-NL', { day: 'numeric', month: 'short', year: 'numeric' });

        card.innerHTML = `
            ${imgHTML}
            <div class="aanvraag-card__body">
                <div class="aanvraag-card__top">
                    <div>
                        <div class="aanvraag-card__name">${r.username}</div>
                        <div class="aanvraag-card__sub">${r.stone_type || '—'} ${r.stone_location ? '· ' + r.stone_location : ''}</div>
                    </div>
                    <span class="aanvraag-badge aanvraag-badge--${badgeClass}">
                        ${badgeLabel}
                    </span>
                </div>
                <p class="aanvraag-card__desc">${r.message}</p>
                <div class="aanvraag-card__footer">
                    <span class="aanvraag-card__date">${date}</span>
                    <a href="/admin/advieschat/${r.id}" class="aanvraag-card__btn ${btnClass}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        ${btnLabel}
                    </a>
                </div>
            </div>
        `;

        card.style.animationDelay = `${index * 60}ms`;
        card.addEventListener('animationend', () => {
            card.classList.remove('aanvraag-card--enter');
            card.style.animationDelay = '';
        }, { once: true });

        grid.appendChild(card);
    });
}

// tabs filter
document.querySelectorAll('.aanvragen-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.aanvragen-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        activeFilter = tab.dataset.filter;

        const filtered = activeFilter === 'all'
            ? allRequests
            : allRequests.filter(r => r.status === activeFilter);

        renderGrid(filtered);
    });
});

document.addEventListener('DOMContentLoaded', loadAdviesAanvragen);