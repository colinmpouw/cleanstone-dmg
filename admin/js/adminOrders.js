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
    let currentDetailOrder = null;

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

        // Detail panel handlers
        const panelCloseBtn = document.getElementById('panelCloseBtn');
        const orderDetailOverlay = document.getElementById('orderDetailOverlay');
        panelCloseBtn.addEventListener('click', closeDetailPanel);
        orderDetailOverlay.addEventListener('click', closeDetailPanel);
    }

    /**
     * Shows placeholder rows shaped like real order rows while the
     * fetch is in flight, instead of a blank table.
     */
    function renderSkeletons(count = 8) {
        const skeletons = Array.from({length: count}, createSkeletonRow);
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

        // Customer name
        const tdCustomer = document.createElement('td');
        const custNameLine = document.createElement('div');
        custNameLine.className = 'skeleton-block skeleton-line skeleton-line--customer-name';
        tdCustomer.append(custNameLine);

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
            'verwerking': {label: 'Verwerking', badgeClass: 'status-verwerking'},
            'betaald': {label: 'Betaald', badgeClass: 'status-betaald'},
            'verzonden': {label: 'Verzonden', badgeClass: 'status-verzonden'},
            'geleverd': {label: 'Geleverd', badgeClass: 'status-geleverd'},
            'geannuleerd': {label: 'Geannuleerd', badgeClass: 'status-geannuleerd'}
        };
        return statusMap[normalized] || {label: '—', badgeClass: ''};
    }

    function createOrderRow(order) {
        const statusInfo = getStatusInfo(order.status);

        const tr = document.createElement('tr');
        tr.className = 'order-row--enter';
        tr.dataset.orderId = order.order_id;

        // ✅ Order number
        const tdOrder = document.createElement('td');
        const orderNum = document.createElement('span');
        orderNum.className = 'order-number';
        orderNum.textContent = `#CS-${String(order.order_id).padStart(4, '0')}`;
        tdOrder.append(orderNum);

        // ✅ Customer info (name + email separated cleanly)
        const tdCustomer = document.createElement('td');

        const nameEl = document.createElement('div');
        nameEl.className = 'customer-name';

        const fullName = `${order.shipping_first_name || ''} ${order.shipping_last_name || ''}`.trim();
        nameEl.textContent = fullName || order.email || '—';

        const emailEl = document.createElement('div');
        emailEl.className = 'customer-email';
        emailEl.textContent = order.email || '';

        tdCustomer.append(nameEl, emailEl);

        // ✅ Date
        const tdDate = document.createElement('td');
        tdDate.textContent = formatDate(order.created_at);

        // ✅ Items count (products + bundles)
        const tdItems = document.createElement('td');

        const products = Array.isArray(order.products) ? order.products : [];
        const bundles = Array.isArray(order.bundles) ? order.bundles : [];

        const productCount = products.reduce(
            (sum, p) => sum + (Number(p.quantity) || 0),
            0
        );

        const bundleCount = bundles.reduce(
            (sum, b) => sum + (Number(b.quantity) || 0),
            0
        );

        let parts = [];
        if (productCount > 0) parts.push(`${productCount} producten`);
        if (bundleCount > 0) parts.push(`${bundleCount} bundels`);

        tdItems.textContent = parts.length ? parts.join(' + ') : '—';

        // ✅ Order amount
        const tdAmount = document.createElement('td');
        const amountSpan = document.createElement('span');
        amountSpan.className = 'order-amount';

        const price = parseFloat(order.total_price || 0);
        amountSpan.textContent = `${formatPrice(price)}`;

        tdAmount.append(amountSpan);

        // ✅ Status badge
        const tdStatus = document.createElement('td');
        const badge = document.createElement('span');
        badge.className = `status-badge ${statusInfo.badgeClass}`;
        badge.textContent = statusInfo.label;
        tdStatus.append(badge);

        // ✅ Actions (view button)


        const downloadActions = document.createElement('td');
        downloadActions.className = 'col-actions';

        const downloadtn = document.createElement('button');
        downloadtn.className = 'action-icon';
        downloadtn.setAttribute('aria-label', 'Bestelling weergeven');
        downloadtn.innerHTML = `
        
        <svg width="20" height="20"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 15C3 17.8284 3 19.2426 3.87868 20.1213C4.75736 21 6.17157 21 9 21H15C17.8284 21 19.2426 21 20.1213 20.1213C21 19.2426 21 17.8284 21 15" stroke="#7E6A52" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 3V16M12 16L16 11.625M12 16L8 11.625" stroke="#7E6A52" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
        
        `;

        downloadActions.appendChild(downloadtn);

        const tdActions = document.createElement('td');
        tdActions.className = 'col-actions';

        const viewBtn = document.createElement('button');
        viewBtn.className = 'action-icon';
        viewBtn.setAttribute('aria-label', 'Bestelling weergeven');

        viewBtn.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_526_1481)">
<path d="M1.20284 6.79697C1.15423 6.92793 1.15423 7.072 1.20284 7.20297C1.67634 8.35105 2.48006 9.33269 3.51213 10.0234C4.54419 10.7142 5.75812 11.0829 7.00001 11.0829C8.2419 11.0829 9.45583 10.7142 10.4879 10.0234C11.52 9.33269 12.3237 8.35105 12.7972 7.20297C12.8458 7.072 12.8458 6.92793 12.7972 6.79697C12.3237 5.64888 11.52 4.66724 10.4879 3.97649C9.45583 3.28574 8.2419 2.91699 7.00001 2.91699C5.75812 2.91699 4.54419 3.28574 3.51213 3.97649C2.48006 4.66724 1.67634 5.64888 1.20284 6.79697Z" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M7 8.75C7.9665 8.75 8.75 7.9665 8.75 7C8.75 6.0335 7.9665 5.25 7 5.25C6.0335 5.25 5.25 6.0335 5.25 7C5.25 7.9665 6.0335 8.75 7 8.75Z" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_526_1481">
<rect width="14" height="14" fill="white"/>
</clipPath>
</defs>
</svg>

        `

        viewBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // ✅ prevents row click conflicts (important)
            openDetailPanel(order);
        });

        tdActions.append(viewBtn);

        // ✅ Optional: whole row clickable (better UX)
        tr.addEventListener('click', () => {
            openDetailPanel(order);
        });
        downloadtn.addEventListener('click', (e) => {
            e.stopPropagation();

            window.open(
                `/admin/bestellingen/${order.user_id}/factuur/${order.order_id}`,
                '_blank'
            );

        })
        // ✅ Append all cells
        tr.append(
            tdOrder,
            tdCustomer,
            tdDate,
            tdItems,
            tdAmount,
            tdStatus,
            downloadActions,
            tdActions
        );

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
                }, {once: true});
            });
        }

        orderCountEl.textContent = `${allOrders.length} bestellingen in totaal`;
    }

    function openDetailPanel(order) {
        currentDetailOrder = order;
        const panel = document.getElementById('orderDetailPanel');
        const overlay = document.getElementById('orderDetailOverlay');

        // Populate panel
        document.getElementById('detailOrderNumber').textContent = `#CS-${String(order.order_id).padStart(4, '0')}`;
        document.getElementById('detailOrderDate').textContent = formatDate(order.created_at);

        // Customer info
        const customerName = `${order.shipping_first_name || ''} ${order.shipping_last_name || ''}`.trim();
        document.getElementById('detailCustomerName').textContent = customerName || '—';
        document.getElementById('detailCustomerEmail').textContent = order.email || '—';

        // Address
        const address = [
            order.shipping_street,
            order.shipping_house_number,
            order.shipping_postal_code,
            order.shipping_city
        ].filter(Boolean).join(' ');
        document.getElementById('detailCustomerAddress').textContent = address || '—';

        // Set current status
        document.getElementById('detailStatusSelect').value = order.status;

        // Render items
        const itemsContainer = document.getElementById('detailOrderItems');
        itemsContainer.replaceChildren();

        const allItems = [];

        // Add products
        if (Array.isArray(order.products)) {
            order.products.forEach(product => {
                allItems.push({
                    name: product.name,
                    quantity: product.quantity,
                    price: product.price
                });
            });
        }

        // Add bundles
        if (Array.isArray(order.bundles)) {
            order.bundles.forEach(bundle => {
                allItems.push({
                    name: bundle.name,
                    quantity: bundle.quantity,
                    price: bundle.price
                });
            });
        }

        // Render all items
        allItems.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'detail-item';

            const nameSpan = document.createElement('span');
            nameSpan.className = 'detail-item-name';
            nameSpan.textContent = item.name;

            const qtySpan = document.createElement('span');
            qtySpan.className = 'detail-item-qty';
            qtySpan.textContent = `x${item.quantity}`;

            const priceSpan = document.createElement('span');
            priceSpan.className = 'detail-item-price';
            priceSpan.textContent = formatPrice(item.price);

            itemDiv.append(nameSpan, qtySpan, priceSpan);
            itemsContainer.append(itemDiv);
        });

        // Set total
        document.getElementById('detailOrderTotal').textContent = formatPrice(order.total_price);

        // Show panel
        overlay.hidden = false;
        panel.hidden = false;
    }

    function closeDetailPanel() {
        const panel = document.getElementById('orderDetailPanel');
        const overlay = document.getElementById('orderDetailOverlay');
        panel.hidden = true;
        overlay.hidden = true;
        currentDetailOrder = null;
    }


    document.getElementById('saveStatusBtn').addEventListener('click', () => {

        if (!currentDetailOrder) {
            return showAlert({
                type: 'error',
                title: 'Fout',
                message: 'Geen bestelling geselecteerd'
            });
        }

        const newStatus = document.getElementById('detailStatusSelect').value;

        fetch('/api/admin/orders/change_status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                order_id: currentDetailOrder.order_id,
                status: newStatus
            })
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Request failed');
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {

                    currentDetailOrder.status = newStatus;

                    const index = allOrders.findIndex(o => o.order_id == currentDetailOrder.order_id);
                    if (index !== -1) {
                        allOrders[index].status = newStatus;
                    }

                    applyFiltersAndSearch();

                    showAlert({
                        type: 'success',
                        title: 'Succes!',
                        message: `De status is gewijzigd`
                    });

                    closeDetailPanel(); // optional

                } else {
                    showAlert({
                        type: 'error',
                        title: 'Fout!',
                        message: `De status is niet gewijzigd`
                    });
                }
            })
            .catch(err => {
                console.error('Error:', err);
            });
    });



});
