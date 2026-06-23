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
            window.location.href = '/admin/products/new';
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
            const res = await fetch('/api/get_all_products');
            if (!res.ok) {
                throw new Error(`Request failed with status ${res.status}`);
            }
            rawProducts = await res.json();
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
        const editIcon = document.createElement('i');
        editIcon.className = 'ti ti-pencil';
        editBtn.append(editIcon);
        editBtn.addEventListener('click', () => {
            window.location.href = `/admin/producten/${product.id}/edit`;
        });

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'action-icon action-delete';
        deleteBtn.setAttribute('aria-label', 'Product verwijderen');
        const deleteIcon = document.createElement('i');
        deleteIcon.className = 'ti ti-trash';
        deleteBtn.append(deleteIcon);
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
        const confirmed = window.confirm(`Weet je zeker dat je "${product.name}" wilt verwijderen?`);
        if (!confirmed) return;

        // TODO: wire up real delete request, e.g.:
        // fetch(`/api/products/${product.id}`, { method: 'DELETE' })
        allProducts = allProducts.filter(p => p.id !== product.id);
        renderTable(allProducts);
    }
});