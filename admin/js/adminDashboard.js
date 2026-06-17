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
    loadStats();
    loadRevenue();
    loadCategories();
    loadOrders();
    loadAdvice();
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

/* ===================================================== */
/* STATS                                                   */
/* ===================================================== */

function renderStats(stats) {
    const upIcon=`<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_526_120)">
<path d="M11.9167 3.79167L7.31251 8.39584L4.60418 5.68751L1.08334 9.20834" stroke="#00A63E" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.66666 3.79167H11.9167V7.04167" stroke="#00A63E" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_526_120">
<rect width="13" height="13" fill="white"/>
</clipPath>
</defs>
</svg>
`
    const downIcon=`<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_526_167)">
<path d="M11.9167 9.20834L7.31254 4.60417L4.60421 7.31251L1.08337 3.79167" stroke="#FB2C36" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.66663 9.20833H11.9166V5.95833" stroke="#FB2C36" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_526_167">
<rect width="13" height="13" fill="white"/>
</clipPath>
</defs>
</svg>
`
    if (stats.revenue) {
        document.querySelector('#revenue h2').textContent =
            formatEuro(stats.revenue.value);

        const small = document.querySelector('#revenue small');
        const delta = stats.revenue.delta;

        if (delta > 0) {
            small.style.color = '#00A63E'; // green
            small.innerHTML = `
            ${upIcon}
            <span>${delta}%</span>
        `;
        } else {
            small.style.color = '#FB2C36'; // red
            small.innerHTML = `
            ${downIcon}
            <span>${delta}%</span>
        `;
        }
    }

    if (stats.orders) {
        document.querySelector('#orders h2').textContent =
            stats.orders.value;

        const small = document.querySelector('#orders small');
        const delta = stats.orders.delta;

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

    if (stats.active_products) {
        document.querySelector('#active_products h2').textContent =
            stats.active_products.value;

        const small = document.querySelector('#active_products small');
        const delta = stats.active_products.delta;

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

    if (stats.advice_requests) {
        document.querySelector('#advice_requests h2').textContent =
            stats.advice_requests.value;

        const small = document.querySelector('#advice_requests small');
        const delta = stats.advice_requests.delta;

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
}
/* ===================================================== */
/* ✅ REVENUE CHART (Line)                                */
/* ===================================================== */

function renderRevenueChart(data) {
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

    document.getElementById('revenueTotal').textContent =
        formatEuro(data.total);
}

/* ===================================================== */
/* ✅ CATEGORY CHART (Bar)                                */
/* ===================================================== */

function renderCategoryChart(categories) {
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

    orders.forEach(o => {
        const li = document.createElement('li');

        // LEFT SIDE
        const left = document.createElement('div');
        left.className = 'order-left';

        const top = document.createElement('div');
        top.className = 'order-top';

        const strong = document.createElement('strong');
        strong.textContent = `#${o.id}`;

        const dot = document.createElement('span');
        dot.className = 'dot';
        dot.textContent = '·';

        const name = document.createElement('span');
        name.textContent = o.customer;

        top.appendChild(strong);
        top.appendChild(dot);
        top.appendChild(name);

        const date = document.createElement('div');
        date.className = 'order-date';
        date.textContent = o.date;

        left.appendChild(top);
        left.appendChild(date);

        // RIGHT SIDE
        const right = document.createElement('div');
        right.className = 'order-right';

        const price = document.createElement('span');
        price.className = 'order-price';
        price.textContent = formatEuro(o.amount);

        const span = document.createElement('span');
        span.className = 'order-btn';
        span.textContent = 'Verzonden';

        right.appendChild(price);
        right.appendChild(span);

        // APPEND ALL
        li.appendChild(left);
        li.appendChild(right);

        el.appendChild(li);
    });
}


/* ===================================================== */
/* ADVICE                                                  */
/* ===================================================== */

function renderAdviceList(items) {
    const el = document.getElementById('adviceList');
    el.innerHTML = '';

    items.forEach(a => {
        const li = document.createElement('li');

        // LEFT (name + subject + date)
        const left = document.createElement('div');
        left.className = 'advice-left';

        const name = document.createElement('div');
        name.className = 'advice-name';
        name.textContent = a.name;

        const subject = document.createElement('div');
        subject.className = 'advice-subject';
        subject.textContent = a.subject;

        const date = document.createElement('div');
        date.className = 'advice-date';
        date.textContent = a.date;

        left.appendChild(name);
        left.appendChild(subject);
        left.appendChild(date);

        // RIGHT (badge + extra info)
        const right = document.createElement('div');
        right.className = 'advice-right';

        const badge = document.createElement('span');
        badge.className = 'advice-badge';
        badge.textContent = 'Nieuw';

        const extra = document.createElement('div');
        extra.className = 'advice-extra';

        const icon = document.createElement('span');
        icon.className = 'eye-icon';
        icon.textContent = '👁'; // simple icon (replace with SVG if needed)

        const text = document.createElement('span');
        text.textContent = 'Foto bijgevoegd';

        extra.appendChild(icon);
        extra.appendChild(text);

        right.appendChild(badge);
        right.appendChild(extra);

        // APPEND
        li.appendChild(left);
        li.appendChild(right);

        el.appendChild(li);
    });
}
