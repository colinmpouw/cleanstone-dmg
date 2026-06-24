/* ==========================================================================
   adminOrders.js
   Admin orders list: skeleton loading, fetch orders, filter by status,
   search by order number/customer name, fade-in animations.
   ========================================================================== */

document.addEventListener('DOMContentLoaded', async () => {
    const tableBody = document.getElementById('ordersTableBody');
    const orderCountEl = document.getElementById('orderCount');
    const searchInput = document.getElementById('orderSearch');
    const statusFilters = document.querySelectorAll('.filter-btn');

    let allOrders = [];
    let activeStatusFilter = 'all';

    init();

    async function init() {
        renderSkeletons();

        allOrders = await loadOrders();
        renderTable(allOrders);

        // Filter button handlers
        statusFilters.forEach(btn => {
            btn.addEventListener('click', () => {
                statusFilters.forEach(b => b.classList.remove('filter-btn--active'));
                btn.classList.add('filter-btn--active');
                activeStatusFilter = btn.dataset.status;
                applyFiltersAndSearch();
            });
        });

        // Search handler
        searchInput.addEventListener('input', applyFiltersAndSearch);
    }

    /**
     * Shows placeholder rows shaped like real order rows while the
     * fetch is in flight, instead of a blank table.
     */
    function renderSkeletons(count = 8) {
        const skeletons = Array.from({ length: count }, createSkeletonRow);
        tableBody.replaceChildren(...skeletons);
    }

    function createSkeletonRow() {
        const tr = document.createElement('tr');
        tr.className = 'skeleton-row';

        // Order number
        const tdOrder = document.createElement('td');
        const orderLine = document.createElement('div');
        orderLine.className = 'skeleton-block skeleton-line skeleton-line--order';
        tdOrder.append(orderLine);

        // Customer info
        const tdCustomer = document.createElement('td');
        const custNameLine = document.createElement('div');
        custNameLine.className = 'skeleton-block skeleton-line skeleton-line--customer-name';
        const custEmailLine = document.createElement('div');
        custEmailLine.className = 'skeleton-block skeleton-line skeleton-line--customer-email';
        custEmailLine.style.marginTop = '0.3rem';
        tdCustomer.append(custNameLine, custEmailLine);

        // Date
        const tdDate = document.createElement('td');
        const dateLine = document.createElement('div');
        dateLine.className = 'skeleton-block skeleton-line skeleton-line--date';
        tdDate.append(dateLine);

        // Items
        const tdItems = document.createElement('td');
        const itemsLine = document.createElement('div');
        itemsLine.className = 'skeleton-block skeleton-line skeleton-line--items';
        tdItems.append(itemsLine);

        // Amount
        const tdAmount = document.createElement('td');
        const amountLine = document.createElement('div');
        amountLine.className = 'skeleton-block skeleton-line skeleton-line--amount';
        tdAmount.append(amountLine);

        // Status
        const tdStatus = document.createElement('td');
        const statusPill = document.createElement('div');
        statusPill.className = 'skeleton-block skeleton-pill';
        tdStatus.append(statusPill);

        // Actions
        const tdActions = document.createElement('td');
        tdActions.className = 'col-actions';

        tr.append(tdOrder, tdCustomer, tdDate, tdItems, tdAmount, tdStatus, tdActions);
        return tr;
    }

    /**
     * Loads orders from the API.
     * Assumes endpoint returns: { success, data: [...] }
     */
    async function loadOrders() {
        try {
            const res = await fetch('/api/admin/get_all_orders');
            if (!res.ok) {
                throw new Error(`Request failed with status ${res.status}`);
            }
            const payload = await res.json();

            if (!payload.success) {
                renderError(payload.message || 'Geen bestellingen gevonden');
                return [];
            }

            return payload.data || [];
        } catch (error) {
            console.error('Kon bestellingen niet laden:', error);
            renderError('Bestellingen konden niet worden geladen. Probeer het later opnieuw.');
            return [];
        }
    }

    function renderError(message) {
        const errorRow = document.createElement('tr');
        const errorCell = document.createElement('td');
        errorCell.colSpan = 7;
        errorCell.className = 'orders-empty';
        errorCell.textContent = message;
        errorRow.append(errorCell);
        tableBody.replaceChildren(errorRow);
    }

    function applyFiltersAndSearch() {
        let filtered = allOrders;

        // Apply status filter
        if (activeStatusFilter !== 'all') {
            filtered = filtered.filter(order =>
                normalizeStatus(order.status) === activeStatusFilter
            );
        }

        // Apply search
        const query = searchInput.value.trim().toLowerCase();
        if (query) {
            filtered = filtered.filter(order => {
                const orderNum = `#CS-${String(order.order_id).padStart(4, '0')}`.toLowerCase();
                const custName = `${order.shipping_first_name || ''} ${order.shipping_last_name || ''}`.toLowerCase();
                return orderNum.includes(query) || custName.includes(query);
            });
        }

        renderTable(filtered);
    }

    /**
     * Normalizes status to match filter button data attributes.
     * Maps API status values to filter keys.
     * API statuses: 'pending','paid','processing','shipped','completed','cancelled'
     */
    function normalizeStatus(apiStatus) {
        const statusMap = {
            'pending': 'verwerking',
            'processing': 'verwerking',
            'paid': 'betaald',
            'shipped': 'verzonden',
            'completed': 'geleverd',
            'cancelled': 'geannuleerd'
        };
        return statusMap[apiStatus?.toLowerCase()] || apiStatus?.toLowerCase();
    }

    function formatDate(dateStr) {
        if (!dateStr) return '—';
        const date = new Date(dateStr);
        return date.toLocaleDateString('nl-NL', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function formatPrice(price) {
        return `€ ${parseFloat(price).toFixed(2).replace('.', ',')}`;
    }

    function getStatusInfo(apiStatus) {
        const normalized = normalizeStatus(apiStatus);
        const statusMap = {
            'verwerking': { label: 'Verwerking', badgeClass: 'status-verwerking' },
            'betaald': { label: 'Betaald', badgeClass: 'status-betaald' },
            'verzonden': { label: 'Verzonden', badgeClass: 'status-verzonden' },
            'geleverd': { label: 'Geleverd', badgeClass: 'status-geleverd' },
            'geannuleerd': { label: 'Geannuleerd', badgeClass: 'status-geannuleerd' }
        };
        return statusMap[normalized] || { label: '—', badgeClass: '' };
    }

    function createOrderRow(order) {
        const statusInfo = getStatusInfo(order.status);

        const tr = document.createElement('tr');
        tr.className = 'order-row--enter';
        tr.dataset.orderId = order.order_id;

        // Order number
        const tdOrder = document.createElement('td');
        const orderNum = document.createElement('span');
        orderNum.className = 'order-number';
        orderNum.textContent = `#CS-${String(order.order_id).padStart(4, '0')}`;
        tdOrder.append(orderNum);

        // Customer info (from shipping address)
        const tdCustomer = document.createElement('td');
        const custNameEl = document.createElement('span');
        custNameEl.className = 'customer-name';
        const customerName = `${order.shipping_first_name || ''} ${order.shipping_last_name || ''}`.trim();
        custNameEl.textContent = customerName || '—';

        const custEmailEl = document.createElement('span');
        custEmailEl.className = 'customer-email';
        custEmailEl.textContent = order.email || '';

        tdCustomer.append(custNameEl, custEmailEl);

        // Date
        const tdDate = document.createElement('td');
        tdDate.textContent = formatDate(order.created_at);

        // Items count (sum of product quantities)
        const tdItems = document.createElement('td');
        const itemCount = order.products.reduce((sum, p) => sum + (p.quantity || 0), 0);
        tdItems.textContent = `${itemCount} ${itemCount === 1 ? 'product' : 'producten'}`;

        // Order amount
        const tdAmount = document.createElement('td');
        const amountSpan = document.createElement('span');
        amountSpan.className = 'order-amount';
        amountSpan.textContent = formatPrice(order.total_price);
        tdAmount.append(amountSpan);

        // Status badge
        const tdStatus = document.createElement('td');
        const badge = document.createElement('span');
        badge.className = `status-badge ${statusInfo.badgeClass}`;
        badge.textContent = statusInfo.label;
        tdStatus.append(badge);

        // View icon
        const tdActions = document.createElement('td');
        tdActions.className = 'col-actions';
        const viewBtn = document.createElement('button');
        viewBtn.className = 'action-icon';
        viewBtn.setAttribute('aria-label', 'Bestelling weergeven');
        const viewIcon = document.createElement('i');
        viewIcon.className = 'ti ti-eye';
        viewBtn.append(viewIcon);
        viewBtn.addEventListener('click', () => {
            window.location.href = `/admin/orders/${order.order_id}`;
        });
        tdActions.append(viewBtn);

        tr.append(tdOrder, tdCustomer, tdDate, tdItems, tdAmount, tdStatus, tdActions);
        return tr;
    }

    function renderTable(orders) {
        if (!orders.length) {
            const emptyRow = document.createElement('tr');
            const emptyCell = document.createElement('td');
            emptyCell.colSpan = 7;
            emptyCell.className = 'orders-empty';
            emptyCell.textContent = 'Geen bestellingen gevonden.';
            emptyRow.append(emptyCell);
            tableBody.replaceChildren(emptyRow);
        } else {
            const rows = orders.map(createOrderRow);
            tableBody.replaceChildren(...rows);

            // Stagger the fade-in slightly per row
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 40}ms`;
                row.addEventListener('animationend', () => {
                    row.classList.remove('order-row--enter');
                    row.style.animationDelay = '';
                }, { once: true });
            });
        }

        orderCountEl.textContent = `${allOrders.length} bestellingen in totaal`;
    }
});