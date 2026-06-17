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
    const el = document.getElementById('statGrid');
    el.innerHTML = '';

    Object.keys(stats).forEach(key => {
        const stat = stats[key];

        const div = document.createElement('div');
        div.className = 'stat-card';

        div.innerHTML = `
            <div>${key}</div>
            <h2>${key === 'revenue' ? formatEuro(stat.value) : stat.value}</h2>
            <small>${stat.delta}%</small>
        `;

        el.appendChild(div);
    });
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
                backgroundColor: '#B89C82'
            }]
        },
        options: {
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
        li.textContent = `${o.customer} - ${formatEuro(o.amount)}`;
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
        li.textContent = `${a.name} - ${a.subject}`;
        el.appendChild(li);
    });
}