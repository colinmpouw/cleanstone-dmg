/* ==========================================================================
   adminBundles.js
   Renders the admin Bundels card grid and wires up edit/delete actions.
   Uses createElement/replaceChildren throughout (no innerHTML).

   API shape confirmed from /api/get_all_bundels:
   {
     success: true,
     data: [
       {
         id, name, description, price, image, created_at,
         products: [
           { product_id, product_name, quantity, price, rating, tags: [{id, name}] }
         ],
         bundle_tags: ["..."]
       }
     ]
   }

   The API has no original_price, sales_count, or status field, so:
   - "Original price" / discount % are CALCULATED from the products
     (sum of quantity * price) vs the bundle's own price.
   - Sales count and status are intentionally omitted from the card
     rather than faked.
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('bundlesGrid');
    const bundleCountEl = document.getElementById('bundleCount');
    const newBundleBtn = document.getElementById('newBundleBtn');

    const PLACEHOLDER_IMAGE = '/uploads/bundles/placeholder.png';

    let allBundles = [];

    init();

    async function init() {
        renderSkeletons();

        allBundles = await loadBundles();
        renderGrid(allBundles);

        newBundleBtn.addEventListener('click', () => {
            window.location.href = '/admin/bundles/new';
        });
    }

    /**
     * Shows placeholder cards shaped like real bundle cards while the
     * fetch is in flight, instead of a blank grid.
     */
    function renderSkeletons(count = 4) {
        const skeletons = Array.from({ length: count }, createSkeletonCard);
        grid.replaceChildren(...skeletons);
    }

    function createSkeletonCard() {
        const card = document.createElement('div');
        card.className = 'bundle-card bundle-card--skeleton';

        const image = document.createElement('div');
        image.className = 'skeleton-block skeleton-image';

        const body = document.createElement('div');
        body.className = 'bundle-card-body';

        const title = document.createElement('div');
        title.className = 'skeleton-block skeleton-line skeleton-line--title';

        const price = document.createElement('div');
        price.className = 'skeleton-block skeleton-line skeleton-line--price';

        const footer = document.createElement('div');
        footer.className = 'skeleton-block skeleton-line skeleton-line--footer';

        body.append(title, price, footer);
        card.append(image, body);

        return card;
    }

    async function loadBundles() {
        let payload;

        try {
            const res = await fetch('/api/admin/get_all_bundels');
            if (!res.ok) {
                throw new Error(`Request failed with status ${res.status}`);
            }
            payload = await res.json();
        } catch (error) {
            console.error('Kon bundels niet laden:', error);
            renderError('Bundels konden niet worden geladen. Probeer het later opnieuw.');
            return [];
        }

        if (!payload.success) {
            renderError(payload.message || 'Geen bundels gevonden');
            return [];
        }

        return payload.data.map(mapBundle);
    }

    /**
     * Maps a raw bundle object to the shape used by the card.
     * Original price and discount % are derived from the products array,
     * since the API doesn't provide a separate "original price" field.
     */
    function mapBundle(raw) {
        const bundlePrice = parseFloat(raw.price) || 0;

        const productsTotal = raw.products.reduce((sum, p) => {
            const price = parseFloat(p.price) || 0;
            const qty = parseFloat(p.quantity) || 1;
            return sum + price * qty;
        }, 0);

        const hasDiscount = productsTotal > bundlePrice;
        const discountPercent = hasDiscount
            ? Math.round(((productsTotal - bundlePrice) / productsTotal) * 100)
            : null;

        return {
            id: raw.id,
            name: raw.name,
            description: raw.description ?? '',
            image: `/uploads/bundles/${raw.image}`, // already absolute/relative or null; no filename-prefixing needed per confirmed shape
            price: bundlePrice,
            originalPrice: hasDiscount ? productsTotal : null,
            discountPercent,
            productCount: raw.products.length
        };
    }

    function renderError(message) {
        const errorState = document.createElement('div');
        errorState.className = 'bundles-empty';
        errorState.textContent = message;
        grid.replaceChildren(errorState);
    }

    function formatPrice(price) {
        return `€ ${price.toFixed(2).replace('.', ',')}`;
    }

    function createBundleCard(bundle) {
        const card = document.createElement('div');
        card.className = 'bundle-card bundle-card--enter';
        card.dataset.bundleId = bundle.id;

        // Image or placeholder

            const img = document.createElement('img');
            img.className = 'bundle-card-image';
            img.src = bundle.image;
            img.alt = bundle.name;
            // Guard against infinite loop: fall back once, and only
            // if we're not already showing the placeholder.
            img.addEventListener('error', () => {
                if (img.src.endsWith(PLACEHOLDER_IMAGE)) return;
                img.src = PLACEHOLDER_IMAGE;
            }, { once: true });
            card.append(img);


        // Body
        const body = document.createElement('div');
        body.className = 'bundle-card-body';

        // Top row: name only (no status badge — not provided by the API)
        const top = document.createElement('div');
        top.className = 'bundle-card-top';

        const nameEl = document.createElement('h3');
        nameEl.className = 'bundle-card-name';
        nameEl.textContent = bundle.name;
        top.append(nameEl);

        // Price row
        const priceRow = document.createElement('div');
        priceRow.className = 'bundle-price-row';

        const currentPrice = document.createElement('span');
        currentPrice.className = 'bundle-price-current';
        currentPrice.textContent = formatPrice(bundle.price);
        priceRow.append(currentPrice);

        if (bundle.originalPrice !== null) {
            const originalPrice = document.createElement('span');
            originalPrice.className = 'bundle-price-original';
            originalPrice.textContent = formatPrice(bundle.originalPrice);
            priceRow.append(originalPrice);
        }

        if (bundle.discountPercent !== null) {
            const discount = document.createElement('span');
            discount.className = 'bundle-price-discount';
            discount.textContent = `-${bundle.discountPercent}%`;
            priceRow.append(discount);
        }

        // Footer: product count + actions (sales count omitted, not in API)
        const footer = document.createElement('div');
        footer.className = 'bundle-card-footer';

        const meta = document.createElement('span');
        meta.className = 'bundle-meta';
        meta.textContent = `${bundle.productCount} producten`;

        const actionsWrap = document.createElement('div');
        actionsWrap.className = 'row-actions';

        const editBtn = document.createElement('button');
        editBtn.className = 'action-icon action-edit';
        editBtn.setAttribute('aria-label', 'Bundel bewerken');
        const editIcon = document.createElement('i');
        editIcon.className = 'ti ti-pencil';
        editBtn.append(editIcon);
        editBtn.addEventListener('click', () => {
            window.location.href = `/admin/bundles/${bundle.id}/edit`;
        });

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'action-icon action-delete';
        deleteBtn.setAttribute('aria-label', 'Bundel verwijderen');
        const deleteIcon = document.createElement('i');
        deleteIcon.className = 'ti ti-trash';
        deleteBtn.append(deleteIcon);
        deleteBtn.addEventListener('click', () => handleDelete(bundle));

        actionsWrap.append(editBtn, deleteBtn);
        footer.append(meta, actionsWrap);

        body.append(top, priceRow, footer);
        card.append(body);

        return card;
    }

    function renderGrid(bundles) {
        if (!bundles.length) {
            const emptyState = document.createElement('div');
            emptyState.className = 'bundles-empty';
            emptyState.textContent = 'Geen bundels gevonden.';
            grid.replaceChildren(emptyState);
        } else {
            const cards = bundles.map(createBundleCard);
            grid.replaceChildren(...cards);

            // Stagger the fade-in slightly per card, then clean up the
            // animation class so it doesn't replay on later re-renders
            // (e.g. after a delete).
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 60}ms`;
                card.addEventListener('animationend', () => {
                    card.classList.remove('bundle-card--enter');
                    card.style.animationDelay = '';
                }, { once: true });
            });
        }

        bundleCountEl.textContent = `${allBundles.length} bundels in totaal`;
    }

    function handleDelete(bundle) {
        const confirmed = window.confirm(`Weet je zeker dat je "${bundle.name}" wilt verwijderen?`);
        if (!confirmed) return;

        // TODO: wire up real delete request, e.g.:
        // fetch(`/api/bundles/${bundle.id}`, { method: 'DELETE' })
        allBundles = allBundles.filter(b => b.id !== bundle.id);
        renderGrid(allBundles);
    }
});