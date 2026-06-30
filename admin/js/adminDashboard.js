const API = {
    stats: '/api/admin/dashboard/stats',
    revenue: '/api/admin/dashboard/revenue',
    categories: '/api/admin/dashboard/categories',
    orders: '/api/admin/dashboard/orders',
    advice: '/api/admin/dashboard/advice'
};

let revenueChart;
let categoryChart;

document.addEventListener('DOMContentLoaded', init);

function init() {
    showStatSkeletons();
    showChartSkeletons();
    showListSkeletons('orderList', 4);
    showListSkeletons('adviceList', 4);

    loadStats();
    loadRevenue();
    loadCategories();
    loadOrders();
    loadAdvice();
}

/* ── Skeleton helpers ── */

function showStatSkeletons() {
    ['revenue', 'orders', 'active_products', 'advice_requests'].forEach(id => {
        const card = document.getElementById(id);
        if (!card) return;
        const h2 = card.querySelector('h2');
        const small = card.querySelector('small');
        if (h2) h2.innerHTML = '<span class="skeleton-block skeleton-stat-value"></span>';
        if (small) small.innerHTML = '<span class="skeleton-block skeleton-stat-delta"></span>';
    });
}

function showChartSkeletons() {
    ['revenueChart', 'categoryChart'].forEach(canvasId => {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        const skel = document.createElement('div');
        skel.className = 'skeleton-block chart-skeleton';
        skel.dataset.for = canvasId;
        canvas.parentElement.appendChild(skel);
    });
}

function hideChartSkeleton(canvasId) {
    document.querySelector(`.chart-skeleton[data-for="${canvasId}"]`)?.remove();
}

function showListSkeletons(listId, count = 4) {
    const el = document.getElementById(listId);
    if (!el) return;
    el.innerHTML = Array.from({ length: count }, () => `
        <li class="dash-skel-item">
            <div class="dash-skel-left">
                <span class="skeleton-block skeleton-line dash-skel-title"></span>
                <span class="skeleton-block skeleton-line dash-skel-sub"></span>
            </div>
            <div class="dash-skel-right">
                <span class="skeleton-block skeleton-line dash-skel-value"></span>
                <span class="skeleton-block skeleton-pill dash-skel-badge"></span>
            </div>
        </li>`).join('');
}

/* ===================================================== */
/* FETCH                                                   */
/* ===================================================== */

async function fetchData(url) {
    const res = await fetch(url);
    if (!res.ok) throw new Error(`Error ${res.status}`);
    return res.json();
}

/* ===================================================== */
/* LOADERS                                                 */
/* ===================================================== */

async function loadStats() {
    try {
        const data = await fetchData(API.stats);
        renderStats(data);
    } catch (e) {
        console.error(e);
    }
}

async function loadRevenue() {
    try {
        const data = await fetchData(API.revenue);
        renderRevenueChart(data);
    } catch (e) {
        console.error(e);
    }
}

async function loadCategories() {
    try {
        const data = await fetchData(API.categories);
        renderCategoryChart(data);
    } catch (e) {
        console.error(e);
    }
}

async function loadOrders() {
    try {
        const data = await fetchData(API.orders);
        renderOrderList(data);
    } catch (e) {
        console.error(e);
    }
}

async function loadAdvice() {
    try {
        const data = await fetchData(API.advice);
        renderAdviceList(data);
    } catch (e) {
        console.error(e);
    }
}

/* ===================================================== */
/* HELPERS                                                 */
/* ===================================================== */

function formatEuro(value) {
    return new Intl.NumberFormat('nl-NL', {
        style: 'currency',
        currency: 'EUR'
    }).format(value);
}

function formatDate(dateString) {
    return new Intl.DateTimeFormat('nl-NL', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }).format(new Date(dateString));
}

/* ===================================================== */
/* STATS                                                   */
/* ===================================================== */

function renderStats(stats) {
    const upIcon = `<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_526_120)">
<path d="M11.9167 3.79167L7.31251 8.39584L4.60418 5.68751L1.08334 9.20834" stroke="#00A63E" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.66666 3.79167H11.9167V7.04167" stroke="#00A63E" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_526_120">
<rect width="13" height="13" fill="white"/>
</clipPath>
</defs>
</svg>`;

    const downIcon = `<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_526_167)">
<path d="M11.9167 9.20834L7.31254 4.60417L4.60421 7.31251L1.08337 3.79167" stroke="#FB2C36" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.66663 9.20833H11.9166V5.95833" stroke="#FB2C36" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_526_167">
<rect width="13" height="13" fill="white"/>
</clipPath>
</defs>
</svg>`;

    function renderDelta(small, delta) {
        small.style.display = 'flex';
        small.style.alignItems = 'center';
        small.style.gap = '4px';

        if (delta > 0) {
            small.style.color = '#00A63E';
            small.innerHTML = `${upIcon}<span>${delta}%</span>`;
        } else if (delta < 0) {
            small.style.color = '#FB2C36';
            small.innerHTML = `${downIcon}<span>${delta}%</span>`;
        } else {
            small.style.color = '#999';
            small.innerHTML = `<span>${delta}%</span>`;
        }
    }

    if (stats.revenue) {
        document.querySelector('#revenue h2').textContent = formatEuro(stats.revenue.value);
        renderDelta(document.querySelector('#revenue small'), stats.revenue.delta);
    }

    if (stats.orders) {
        document.querySelector('#orders h2').textContent = stats.orders.value;
        renderDelta(document.querySelector('#orders small'), stats.orders.delta);
    }

    if (stats.active_products) {
        document.querySelector('#active_products h2').textContent = stats.active_products.value;
        renderDelta(document.querySelector('#active_products small'), stats.active_products.delta);
    }

    if (stats.advice_requests) {
        document.querySelector('#advice_requests h2').textContent = stats.advice_requests.value;
        renderDelta(document.querySelector('#advice_requests small'), stats.advice_requests.delta);
    }
}

/* ===================================================== */
/* REVENUE CHART (Line)                                    */
/* ===================================================== */

function renderRevenueChart(data) {
    hideChartSkeleton('revenueChart');
    const ctx = document.getElementById('revenueChart').getContext('2d');

    if (revenueChart) revenueChart.destroy();

    const labels = data.points.map(p => p.label);
    const values = data.points.map(p => p.value);

    revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Omzet',
                data: values,
                borderColor: '#B89C82',
                backgroundColor: 'rgba(184,156,130,0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    ticks: {
                        callback: value => '€' + value / 1000 + 'k'
                    }
                }
            }
        }
    });

    document.getElementById('revenueTotal').textContent = formatEuro(data.total);
}

/* ===================================================== */
/* CATEGORY CHART (Bar)                                     */
/* ===================================================== */

function renderCategoryChart(categories) {
    hideChartSkeleton('categoryChart');
    const ctx = document.getElementById('categoryChart').getContext('2d');

    if (categoryChart) categoryChart.destroy();

    const labels = categories.map(c => c.label);
    const values = categories.map(c => c.value);

    categoryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: '#B89C82',
                borderRadius: 4,
                barPercentage: 0.5,
                categoryPercentage: 0.5
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
}

/* ===================================================== */
/* ORDERS                                                  */
/* ===================================================== */

function renderOrderList(orders) {
    const el = document.getElementById('orderList');
    el.innerHTML = '';

    if (!orders.length) {
        el.innerHTML = '<li>Geen bestellingen gevonden</li>';
        return;
    }

    const statusMap = {
        pending: 'In afwachting',
        paid: 'Betaald',
        processing: 'In behandeling',
        shipped: 'Verzonden',
        completed: 'Voltooid',
        cancelled: 'Geannuleerd'
    };

    orders.forEach(o => {
        const li = document.createElement('li');

        const left = document.createElement('div');
        left.className = 'order-left';

        const customer = document.createElement('div');
        customer.className = 'order-customer';
        customer.textContent = o.customer || 'Onbekend';

        const date = document.createElement('div');
        date.className = 'order-date';
        date.textContent = formatDate(o.date);

        left.append(customer, date);

        const right = document.createElement('div');
        right.className = 'order-right';

        const amount = document.createElement('div');
        amount.className = 'order-amount';
        amount.textContent = formatEuro(o.amount);

        const badge = document.createElement('span');
        badge.className = `order-badge order-badge-${o.status}`;
        badge.textContent = statusMap[o.status] || o.status;

        right.append(amount, badge);

        li.append(left, right);
        el.append(li);
    });
}

/* ===================================================== */
/* ADVICE                                                  */
/* ===================================================== */

function renderAdviceList(items) {
    const el = document.getElementById('adviceList');
    el.innerHTML = '';

    if (!items.length) {
        el.innerHTML = '<li>Geen adviesaanvragen gevonden</li>';
        return;
    }

    const statusMap = {
        open: 'Nieuw',
        in_behandeling: 'In behandeling',
        gesloten: 'Gesloten'
    };

    items.forEach(a => {
        const li = document.createElement('li');

        const left = document.createElement('div');
        left.className = 'advice-left';

        const name = document.createElement('div');
        name.className = 'advice-name';
        name.textContent = a.name;

        const subject = document.createElement('div');
        subject.className = 'advice-subject';
        subject.textContent = a.subject || '-';

        const date = document.createElement('div');
        date.className = 'advice-date';
        date.textContent = formatDate(a.date);

        left.append(name, subject, date);

        const right = document.createElement('div');
        right.className = 'advice-right';

        const badge = document.createElement('span');
        badge.className = 'advice-badge';
        badge.textContent = statusMap[a.status] || a.status;

        const extra = document.createElement('div');
        extra.className = 'advice-extra';

        if (a.has_photo) {
            const icon = document.createElement('span');
            icon.className = 'eye-icon';
            icon.textContent = '📷';

            const text = document.createElement('span');
            text.textContent = 'Foto bijgevoegd';

            extra.append(icon, text);
        } else {
            extra.textContent = 'Geen foto';
        }

        right.append(badge, extra);

        li.append(left, right);
        el.append(li);
    });
}