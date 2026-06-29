function renderOrders(orders) {
    const list = document.getElementById('order-list');

    if (!orders || orders.length === 0) {
        list.innerHTML = `
            <div class="orders-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
                <p>U heeft nog geen bestellingen geplaatst.</p>
                <a href="/producten">Bekijk onze producten</a>
            </div>`;
        return;
    }

    list.innerHTML = orders.map(order => {
        const badge = getBadge(order.status);
        const thumbs = (order.products || []).slice(0, 3).map(p => {
            const isBundle = p.sku === 'BUNDEL';
            const imgSrc = p.image
                ? (isBundle ? `/uploads/bundles/${p.image}` : `/uploads/products/${p.image}`)
                : '';
            return `<img class="order-thumb" src="${imgSrc}" alt="${p.name || ''}" onerror="this.outerHTML='<div class=\\'order-thumb order-thumb--placeholder\\'></div>'">`;
        }).join('');
        return `
        <a class="order-card" href="/account/bestellingen/${order.id}">
            <div class="order-card__top">
                <span class="order-card__id">#${order.order_number || order.id}</span>
                <div class="order-card__right">
                    ${badge}
                    <svg class="order-card__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </div>
            </div>
            <span class="order-card__date">${formatDate(order.created_at)}</span>
            <div class="order-card__products">
                ${thumbs}
                <span class="order-card__count">${order.product_count ?? order.products?.length ?? 0} producten</span>
            </div>
            <div class="order-card__footer">
                <span class="order-card__price">€ ${parseFloat(order.total_price).toFixed(2).replace('.', ',')}</span>
                <span class="order-card__btw">Incl. BTW</span>
            </div>
        </a>`;
    }).join('');
}

function getBadge(status) {
    const map = {
        'pending': {
            cls: 'verwerking',
            icon: '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
            label: 'In afwachting'
        },
        'paid': {cls: 'geleverd', icon: '<polyline points="20 6 9 17 4 12"/>', label: 'Betaald'},
        'processing': {
            cls: 'verwerking',
            icon: '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
            label: 'In verwerking'
        },
        'shipped': {cls: 'verzonden', icon: '<path d="M5 12h14M12 5l7 7-7 7"/>', label: 'Verzonden'},
        'completed': {cls: 'geleverd', icon: '<polyline points="20 6 9 17 4 12"/>', label: 'Geleverd'},
        'cancelled': {
            cls: 'geannuleerd',
            icon: '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
            label: 'Geannuleerd'
        },
    };
    const b = map[status] || {cls: 'verwerking', icon: '', label: status};
    return `<span class="order-badge order-badge--${b.cls}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">${b.icon}</svg>
        ${b.label}
    </span>`;
}

function formatDate(dateStr) {
    if (!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('nl-NL', {day: 'numeric', month: 'long', year: 'numeric'});
}

async function loadOrders() {
    const list = document.getElementById('order-list');
    if (list) {
        list.innerHTML = Array(4).fill(`
            <div class="order-card order-card--skeleton">
                <div class="order-card__top">
                    <div class="skeleton-block" style="width:70px;height:14px;border-radius:6px;"></div>
                    <div class="skeleton-block" style="width:100px;height:24px;border-radius:20px;"></div>
                </div>
                <div class="skeleton-block" style="width:140px;height:12px;border-radius:6px;margin-bottom:12px;"></div>
                <div style="display:flex;gap:8px;margin-bottom:12px;">
                    <div class="skeleton-block" style="width:52px;height:52px;border-radius:8px;flex-shrink:0;"></div>
                    <div class="skeleton-block" style="width:52px;height:52px;border-radius:8px;flex-shrink:0;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <div class="skeleton-block" style="width:80px;height:16px;border-radius:6px;"></div>
                    <div class="skeleton-block" style="width:50px;height:12px;border-radius:6px;"></div>
                </div>
            </div>`).join('');
    }
    try {
        const res = await fetch('/api/account/bestellingen');
        const data = await res.json();
        renderOrders(data.orders ?? []);
    } catch {
        document.getElementById('order-list').innerHTML =
            '<p style="color:var(--rustic-taupe);font-size:0.88rem;">Er is iets misgegaan bij het laden van uw bestellingen.</p>';
    }
}

loadOrders();