document.addEventListener('DOMContentLoaded', async () => {
    // skeleton placeholders
    ['stat-orders', 'stat-advies', 'stat-messages'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.innerHTML = '<span class="stat-num-skeleton skeleton-block"></span>';
    });
    const list = document.getElementById('bestelling-list');
    if (list) {
        list.innerHTML = Array(3).fill(`
            <div class="bestelling-item-skeleton">
                <div class="skeleton-block" style="width:40px;height:40px;flex-shrink:0;border-radius:10px;"></div>
                <div style="flex:1;display:flex;flex-direction:column;gap:6px;">
                    <div class="skeleton-block" style="width:50%;height:13px;border-radius:6px;"></div>
                    <div class="skeleton-block" style="width:35%;height:11px;border-radius:6px;"></div>
                </div>
                <div class="skeleton-block" style="width:64px;height:22px;border-radius:20px;flex-shrink:0;"></div>
            </div>`).join('');
    }

    try {
        const res  = await fetch('/api/account/data');
        const data = await res.json();

        if (!data.success) return;

        const d = data.data;

        // stats
        document.getElementById('stat-orders').textContent   = d.order_count;
        document.getElementById('stat-advies').textContent   = d.advies ? 1 : 0;
        document.getElementById('stat-messages').textContent = d.message_count;

        // alert banner
        if (d.advies && d.advies.status !== 'gesloten') {
            const banner = document.getElementById('alert-banner');
            const title  = document.getElementById('alert-title');
            const btn    = document.getElementById('alert-btn');

            title.textContent = d.advies.status === 'open'
                ? 'Uw adviesaanvraag is ingediend'
                : 'Uw adviesaanvraag is in behandeling';

            btn.addEventListener('click', () => {
                location.href = '/show-advies/' + d.advies.id;
            });

            banner.style.display = 'block';
        }

        // recente bestellingen
        const list = document.getElementById('bestelling-list');
        list.innerHTML = '';

        if (!d.recent_orders.length) {
            list.innerHTML = '<p style="color: var(--rustic-taupe); font-size: 0.88rem;">U heeft nog geen bestellingen.</p>';
        } else {
            d.recent_orders.forEach(order => {
                const date = new Date(order.created_at).toLocaleDateString('nl-NL', {
                    day: 'numeric', month: 'short', year: 'numeric'
                });
                const price = parseFloat(order.total_price).toFixed(2).replace('.', ',');
                const status = order.status.charAt(0).toUpperCase() + order.status.slice(1);

                const item = document.createElement('div');
                item.className = 'bestelling-item';
                item.innerHTML = `
                    <div class="bestelling-item__img">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                    </div>
                    <div class="bestelling-item__info">
                        <strong>Bestelling #${order.id}</strong>
                        <span>${date} • €${price}</span>
                    </div>
                    <span class="status-badge">${status}</span>
                `;
                list.appendChild(item);
            });
        }

    } catch (err) {
        console.error(err);
    }
});