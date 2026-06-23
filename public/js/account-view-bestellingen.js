// Haal het bestelling ID uit de URL: /account/bestellingen/123
const orderId = window.location.pathname.split('/').pop();

const STEPS = [
    { key: 'geplaatst',   label: 'Bestelling geplaatst' },
    { key: 'betaald',     label: 'Betaling ontvangen' },
    { key: 'verwerking',  label: 'In verwerking' },
    { key: 'verzonden',   label: 'Verzonden' },
    { key: 'bezorgd',     label: 'Bezorgd' },
];

const STATUS_ORDER = ['geplaatst', 'betaald', 'verwerking', 'verzonden', 'bezorgd'];

function getBadge(status) {
    const map = {
        'verzonden':     { cls: 'verzonden',   icon: '<path d="M5 12h14M12 5l7 7-7 7"/>',          label: 'Verzonden' },
        'bezorgd':       { cls: 'geleverd',    icon: '<polyline points="20 6 9 17 4 12"/>',          label: 'Geleverd' },
        'verwerking':    { cls: 'verwerking',  icon: '<circle cx="12" cy="12" r="10"/>',             label: 'In verwerking' },
        'geannuleerd':   { cls: 'geannuleerd', icon: '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>', label: 'Geannuleerd' },
    };
    const b = map[status] || { cls: 'verwerking', icon: '', label: status };
    return `<span class="order-badge order-badge--${b.cls}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">${b.icon}</svg>
        ${b.label}
    </span>`;
}

function formatDate(dateStr, withTime = false) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    const date = d.toLocaleDateString('nl-NL', { day: 'numeric', month: 'long', year: 'numeric' });
    if (!withTime) return date;
    const time = d.toLocaleTimeString('nl-NL', { hour: '2-digit', minute: '2-digit' });
    return `${d.getDate()} ${d.toLocaleString('nl-NL', { month: 'short' })} · ${time}`;
}

function fmt(amount) {
    return '€ ' + parseFloat(amount).toFixed(2).replace('.', ',');
}

function renderTimeline(order) {
    const currentIdx = STATUS_ORDER.indexOf(order.status);
    return STEPS.map((step, i) => {
        const done = i <= currentIdx;
        const timestamp = order.timestamps?.[step.key];
        const isPending = step.key === 'bezorgd' && !done;
        const subtext = isPending
            ? (order.expected_delivery ? `${order.expected_delivery} (verwacht)` : 'Verwacht')
            : (timestamp ? formatDate(timestamp, true) : '');

        return `
        <div class="timeline-step ${done ? 'timeline-step--done' : 'timeline-step--pending'}">
            <div class="timeline-dot">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div class="timeline-info">
                <strong>${step.label}</strong>
                ${subtext ? `<span>${subtext}</span>` : ''}
            </div>
        </div>`;
    }).join('');
}

function renderProducts(order) {
    const rows = (order.products || []).map(p => {
        const isBundle = p.sku === 'BUNDEL';
        const imgSrc = p.image
            ? (isBundle ? `/uploads/bundles/${p.image}` : `/uploads/products/${p.image}`)
            : '';

        return `
        <div class="product-row">
            <img class="product-thumb" src="${imgSrc}" alt="${p.name}"
                 onerror="this.src=''">
            <div class="product-info">
                <div class="product-info__name">${p.name}</div>
                <div class="product-info__meta">${isBundle ? 'Bundel' : (p.variant || '')} · ×${p.quantity || 1}</div>
            </div>
            <span class="product-price">${fmt(p.price * (p.quantity || 1))}</span>
        </div>`;
    }).join('');

    const subtotal = order.subtotal ?? order.total;
    const shipping = order.shipping ?? 0;
    const total    = order.total;

    return rows + `
        <div class="order-totals">
            <div class="totals-row"><span>Subtotaal</span><span>${fmt(subtotal)}</span></div>
            <div class="totals-row"><span>Verzendkosten</span><span>${shipping == 0 ? 'Gratis' : fmt(shipping)}</span></div>
            <div class="totals-row totals-row--total"><span>Totaal</span><span>${fmt(total)}</span></div>
        </div>`;
}

function render(order) {
    const main = document.getElementById('bestelling-main');
    main.innerHTML = `

        <!-- TOP BAR -->
        <div class="bestelling-topbar">
            <a href="/account/bestellingen" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
            <div class="bestelling-header">
                <h1>Bestelling <span>#${order.order_number || order.id}</span></h1>
                <span class="bestelling-header__date">${formatDate(order.created_at)}</span>
            </div>
            ${getBadge(order.status)}
        </div>

        <!-- VOORTGANG -->
        <div class="detail-card">
            <div class="detail-card__title">Voortgang</div>
            <div class="timeline">
                ${renderTimeline(order)}
            </div>
        </div>

        <!-- PRODUCTEN -->
        <div class="detail-card">
            <div class="detail-card__title">Producten (${order.products?.length ?? 0})</div>
            <div class="product-list">
                ${renderProducts(order)}
            </div>
        </div>

        <!-- BEZORGADRES -->
        <div class="detail-card">
            <div class="detail-card__title">Bezorgadres</div>
            <div class="address-row">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
                ${order.address || '—'}
            </div>
        </div>

        <!-- FACTUUR -->
        <a class="factuur-btn" href="/account/bestellingen/${order.id}/factuur" target="_blank">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Factuur
        </a>`;
}

async function load() {
    const main = document.getElementById('bestelling-main');
    try {
        const res  = await fetch(`/api/account/bestellingen/${orderId}`);
        const data = await res.json();
        if (data.error || !data.id) throw new Error();
        render(data);
    } catch {
        main.innerHTML = '<p style="color:var(--rustic-taupe);font-size:0.88rem;">Bestelling niet gevonden.</p>';
    }
}

load();