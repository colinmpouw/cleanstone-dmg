document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('productsTableBody');
    const productCountEl = document.getElementById('productCount');
    const searchInput = document.getElementById('productSearch');
    const newProductBtn = document.getElementById('newProductBtn');

    let allProducts = [];

    init();

    async function init() {
        renderSkeletons();

        allProducts = await loadProducts();
        renderTable(allProducts);

        searchInput.addEventListener('input', handleSearch);
        newProductBtn.addEventListener('click', () => {
            window.location.href = '/admin/producten/add';
        });
    }

    // Adjust if product images live somewhere else (e.g. an /uploads folder)
    const PRODUCT_IMAGE_BASE = '/uploads/products/';
    const PLACEHOLDER_IMAGE = '/public/assets/placeholder-product.png';

    /**
     * Loads products from the API and maps the API shape onto the
     * shape the table rendering expects.
     */
    async function loadProducts() {
        let rawProducts;

        try {
            const res = await fetch('/api/admin/get_all_products');
            if (!res.ok) {
                throw new Error(`Request failed with status ${res.status}`);
            }
            const json = await res.json();
            if (!json.success) throw new Error('Producten laden mislukt');
            rawProducts = json.data;
        } catch (error) {
            console.error('Kon producten niet laden:', error);
            renderError();
            return [];
        }

        return rawProducts.map(mapProduct);
    }

    /**
     * Maps a raw API product object to the shape used by the table.
     * Raw shape (from /api/get_all_products):
     * { id, slug, name, price, sale_price, stock, image,
     *   category_name, category_slug, brand_name, average_rating, review_count }
     */
    function mapProduct(raw) {
        const basePrice = parseFloat(raw.price);
        const salePrice = raw.sale_price !== null && raw.sale_price !== undefined
            ? parseFloat(raw.sale_price)
            : null;

        return {
            id: raw.id,
            slug: raw.slug,
            name: raw.name,
            brand: raw.brand_name ?? '',
            category: raw.category_name ?? '',
            price: salePrice !== null ? salePrice : basePrice,
            originalPrice: salePrice !== null ? basePrice : null,
            stock: Number(raw.stock),
            image: raw.image ? `${PRODUCT_IMAGE_BASE}${raw.image}` : PLACEHOLDER_IMAGE
        };
    }

    function renderError() {
        const errorRow = document.createElement('tr');
        const errorCell = document.createElement('td');
        errorCell.colSpan = 6;
        errorCell.className = 'products-empty';
        errorCell.textContent = 'Producten konden niet worden geladen. Probeer het later opnieuw.';
        errorRow.append(errorCell);
        tableBody.replaceChildren(errorRow);
    }

    /**
     * Shows placeholder rows shaped like real product rows while the
     * fetch is in flight, instead of a blank table.
     */
    function renderSkeletons(count = 6) {
        const skeletons = Array.from({ length: count }, createSkeletonRow);
        tableBody.replaceChildren(...skeletons);
    }

    function createSkeletonRow() {
        const tr = document.createElement('tr');
        tr.className = 'skeleton-row';

        // Product cell (thumb + name + brand)
        const tdProduct = document.createElement('td');
        const productCell = document.createElement('div');
        productCell.className = 'product-cell';

        const thumb = document.createElement('div');
        thumb.className = 'skeleton-block skeleton-thumb';

        const infoWrap = document.createElement('div');
        infoWrap.className = 'product-info';

        const nameLine = document.createElement('div');
        nameLine.className = 'skeleton-block skeleton-line skeleton-line--name';

        const brandLine = document.createElement('div');
        brandLine.className = 'skeleton-block skeleton-line skeleton-line--brand';

        infoWrap.append(nameLine, brandLine);
        productCell.append(thumb, infoWrap);
        tdProduct.append(productCell);

        // Category
        const tdCategory = document.createElement('td');
        const categoryLine = document.createElement('div');
        categoryLine.className = 'skeleton-block skeleton-line skeleton-line--category';
        tdCategory.append(categoryLine);

        // Price
        const tdPrice = document.createElement('td');
        const priceLine = document.createElement('div');
        priceLine.className = 'skeleton-block skeleton-line skeleton-line--price';
        tdPrice.append(priceLine);

        // Stock
        const tdStock = document.createElement('td');
        const stockLine = document.createElement('div');
        stockLine.className = 'skeleton-block skeleton-line skeleton-line--stock';
        tdStock.append(stockLine);

        // Status
        const tdStatus = document.createElement('td');
        const statusPill = document.createElement('div');
        statusPill.className = 'skeleton-block skeleton-pill';
        tdStatus.append(statusPill);

        // Actions (empty, just keeps column widths stable)
        const tdActions = document.createElement('td');
        tdActions.className = 'col-actions';

        tr.append(tdProduct, tdCategory, tdPrice, tdStock, tdStatus, tdActions);
        return tr;
    }

    function handleSearch() {
        const query = searchInput.value.trim().toLowerCase();

        if (!query) {
            renderTable(allProducts);
            return;
        }

        const filtered = allProducts.filter(product => {
            return product.name.toLowerCase().includes(query)
                || product.brand.toLowerCase().includes(query)
                || product.category.toLowerCase().includes(query);
        });

        renderTable(filtered);
    }

    function getStockStatus(stock) {
        if (stock === 0) {
            return { label: 'Uitverkocht', badgeClass: 'status-sold-out', stockClass: 'stock-out' };
        }
        if (stock <= 5) {
            return { label: 'Laag', badgeClass: 'status-low', stockClass: 'stock-low' };
        }
        return { label: 'Actief', badgeClass: 'status-active', stockClass: 'stock-ok' };
    }

    function formatPrice(price) {
        return `€ ${price.toFixed(2).replace('.', ',')}`;
    }

    function createProductRow(product) {
        const status = getStockStatus(product.stock);

        const tr = document.createElement('tr');
        tr.className = 'product-row--enter';
        tr.dataset.productId = product.id;

        // Product cell (thumbnail + name + brand)
        const tdProduct = document.createElement('td');
        const productCell = document.createElement('div');
        productCell.className = 'product-cell';

        const img = document.createElement('img');
        img.className = 'product-thumb';
        img.src = product.image;
        img.alt = product.name;
        // Guard against infinite loop: only fall back once, and only
        // if we're not already showing the placeholder.
        img.addEventListener('error', () => {
            if (img.src.endsWith(PLACEHOLDER_IMAGE)) return;
            img.src = PLACEHOLDER_IMAGE;
        }, { once: true });

        const infoWrap = document.createElement('div');
        infoWrap.className = 'product-info';

        const nameEl = document.createElement('span');
        nameEl.className = 'product-name';
        nameEl.textContent = product.name;

        const brandEl = document.createElement('span');
        brandEl.className = 'product-brand';
        brandEl.textContent = product.brand;

        infoWrap.append(nameEl, brandEl);
        productCell.append(img, infoWrap);
        tdProduct.append(productCell);

        // Category
        const tdCategory = document.createElement('td');
        tdCategory.className = 'product-category';
        tdCategory.textContent = product.category;

        // Price
        const tdPrice = document.createElement('td');
        const priceSpan = document.createElement('span');
        priceSpan.className = 'product-price';
        priceSpan.textContent = formatPrice(product.price);
        tdPrice.append(priceSpan);

        if (product.originalPrice !== null) {
            const originalSpan = document.createElement('span');
            originalSpan.className = 'product-price-original';
            originalSpan.textContent = formatPrice(product.originalPrice);
            tdPrice.append(originalSpan);
        }

        // Stock
        const tdStock = document.createElement('td');
        const stockSpan = document.createElement('span');
        stockSpan.className = `stock-value ${status.stockClass}`;
        stockSpan.textContent = `${product.stock} stuks`;
        tdStock.append(stockSpan);

        // Status badge
        const tdStatus = document.createElement('td');
        const badge = document.createElement('span');
        badge.className = `status-badge ${status.badgeClass}`;
        badge.textContent = status.label;
        tdStatus.append(badge);

        // Actions
        const tdActions = document.createElement('td');
        tdActions.className = 'col-actions';
        const actionsWrap = document.createElement('div');
        actionsWrap.className = 'row-actions';

        const editBtn = document.createElement('button');
        editBtn.className = 'action-icon action-edit';
        editBtn.setAttribute('aria-label', 'Product bewerken');

        editBtn.innerHTML=`
<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_526_896)">
<path d="M12.3515 3.97366C12.66 3.66533 12.8333 3.2471 12.8333 2.811C12.8334 2.37489 12.6602 1.95662 12.3518 1.64821C12.0435 1.33979 11.6253 1.1665 11.1892 1.16644C10.7531 1.16639 10.3348 1.33958 10.0264 1.64792L2.24121 9.43483C2.10577 9.56987 2.00561 9.73614 1.94954 9.919L1.17896 12.4577C1.16388 12.5081 1.16275 12.5617 1.17566 12.6127C1.18858 12.6638 1.21508 12.7104 1.25234 12.7476C1.2896 12.7848 1.33624 12.8112 1.3873 12.824C1.43837 12.8369 1.49195 12.8357 1.54238 12.8205L4.08163 12.0505C4.26431 11.9949 4.43056 11.8954 4.56579 11.7606L12.3515 3.97366Z" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_526_896">
<rect width="14" height="14" fill="white"/>
</clipPath>
</defs>
</svg>
`;
        editBtn.addEventListener('click', () => {
            window.location.href = `/admin/producten/${product.id}/edit`;
        });

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'action-icon action-delete';
        deleteBtn.setAttribute('aria-label', 'Product verwijderen');

        deleteBtn.innerHTML=`
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_526_899)">
<path d="M1.75 3.5H12.25" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M11.0834 3.5V11.6667C11.0834 12.25 10.5001 12.8333 9.91675 12.8333H4.08341C3.50008 12.8333 2.91675 12.25 2.91675 11.6667V3.5" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M4.66675 3.49999V2.33332C4.66675 1.74999 5.25008 1.16666 5.83341 1.16666H8.16675C8.75008 1.16666 9.33341 1.74999 9.33341 2.33332V3.49999" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.83325 6.41666V9.91666" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.16675 6.41666V9.91666" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_526_899">
<rect width="14" height="14" fill="white"/>
</clipPath>
</defs>
</svg>

        `
        deleteBtn.addEventListener('click', () => handleDelete(product));

        actionsWrap.append(editBtn, deleteBtn);
        tdActions.append(actionsWrap);

        tr.append(tdProduct, tdCategory, tdPrice, tdStock, tdStatus, tdActions);
        return tr;
    }

    function renderTable(products) {
        if (!products.length) {
            const emptyRow = document.createElement('tr');
            const emptyCell = document.createElement('td');
            emptyCell.colSpan = 6;
            emptyCell.className = 'products-empty';
            emptyCell.textContent = 'Geen producten gevonden.';
            emptyRow.append(emptyCell);
            tableBody.replaceChildren(emptyRow);
        } else {
            const rows = products.map(createProductRow);
            tableBody.replaceChildren(...rows);

            // Stagger the fade-in slightly per row, then clean up the
            // animation class so it doesn't replay on later re-renders
            // (e.g. after a delete or search filter).
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 40}ms`;
                row.addEventListener('animationend', () => {
                    row.classList.remove('product-row--enter');
                    row.style.animationDelay = '';
                }, { once: true });
            });
        }

        productCountEl.textContent = `${allProducts.length} producten in totaal`;
    }

    function handleDelete(product) {
        showAlert({
            type: 'warning',
            title: 'Verwijderen bevestigen',
            message: `Weet je zeker dat je "${product.name}" wilt verwijderen?`,
            buttons: [
                {
                    text: 'Verwijderen',
                    type: 'primary',
                    action: async () => {
                        try {
                            // TODO: wire up real delete request, e.g.:
                            // const res = await fetch(`/api/products/${product.id}`, { method: 'DELETE' });
                            // if (!res.ok) throw new Error('Delete failed');

                            allProducts = allProducts.filter(p => p.id !== product.id);
                            renderTable(allProducts);

                            showAlert({
                                type: 'success',
                                title: 'Verwijderd!',
                                message: `"${product.name}" is verwijderd.`
                            });
                        } catch (error) {
                            showAlert({
                                type: 'error',
                                title: 'Fout',
                                message: error.message
                            });
                        }
                    }
                },
                {
                    text: 'Annuleren',
                    type: 'secondary'
                }
            ]
        });
    }
});