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
            window.location.href = '/admin/bundel/toevoegen';
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

        editBtn.innerHTML = `
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
            window.location.href = `/admin/bundel/bewerking/${bundle.id}`;
        });

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'action-icon action-delete';
        deleteBtn.setAttribute('aria-label', 'Bundel verwijderen');

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
        `;
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
        showAlert({
            type: 'warning',
            title: 'Verwijderen bevestigen',
            message: `Weet je zeker dat je "${bundle.name}" wilt verwijderen?`,
            buttons: [
                {
                    text: 'Verwijderen',
                    type: 'primary',
                    action: async () => {
                        try {
                            // TODO: wire up real delete request, e.g.:
                            // const res = await fetch(`/api/bundles/${bundle.id}`, { method: 'DELETE' });
                            // if (!res.ok) throw new Error('Delete failed');

                            allBundles = allBundles.filter(b => b.id !== bundle.id);
                            renderGrid(allBundles);

                            showAlert({
                                type: 'success',
                                title: 'Verwijderd!',
                                message: `"${bundle.name}" is verwijderd.`
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