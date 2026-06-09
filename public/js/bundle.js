async function loadBundle() {

    try {
        const res = await fetch(`/api/find_bundle/${bundle_id}`);
        const data = await res.json();

        if (!data.success) {
            console.error('Bundle not found');
            return;
        }

        const bundle = data.data;

        // ✅ 转数组（关键）
        const products = Object.values(bundle.products);

        /* ───────── IMAGE ───────── */
        const img = document.getElementById('bundle-image');
        img.src = bundle.image || '';
        img.alt = bundle.name || '';

        /* ───────── BADGES ───────── */
        document.getElementById('badge-discount').textContent =
            bundle.bundle_tags?.[0] || '';

        document.getElementById('badge-bestseller').textContent =
            bundle.bundle_tags?.[1] || '';

        /* ───────── TITLE ───────── */
        document.getElementById('bundle-title').textContent = bundle.name;
        document.getElementById('bundle-subtitle').textContent =
            bundle.description || '';

        /* ───────── PRICE ───────── */
        document.getElementById('price-current').textContent =
            `€${bundle.price}`;

        if (bundle.original_price) {
            document.getElementById('price-original').textContent =
                `€${bundle.original_price}`;
        } else {
            document.getElementById('price-original').textContent = '';
        }

        if (bundle.savings) {
            document.getElementById('price-save').textContent =
                bundle.savings;
        } else {
            document.getElementById('price-save').textContent = '';
        }

        /* ───────── RATING ───────── */
        let ratings = products
            .map(p => parseFloat(p.rating))
            .filter(r => !isNaN(r));

        let avg = ratings.length
            ? ratings.reduce((a, b) => a + b, 0) / ratings.length
            : 0;

        document.getElementById('stars').innerHTML = renderStars(avg);
        document.getElementById('rating-text').textContent =
            `${avg.toFixed(1)} (${ratings.length} reviews)`;

        /* ───────── PAKKET（唯一 create ✅） ───────── */
        const list = document.querySelector('.package-list');
        list.innerHTML = '';

        products.forEach(p => {
            const li = document.createElement('li');

            // ✅ SVG icon 保留
            const icon = document.createElement('div');
            icon.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 9.1L10 11.6L18.3 3.3" stroke="#7E6A52" stroke-width="1.6"/>
                </svg>
            `;

            const link = document.createElement('a');

            // ✅ product detail link
            link.href = `/product/${p.product_id}/${slugify(p.product_name)}`;
            link.textContent = `${p.product_name} (${p.quantity}x)`;

            li.appendChild(icon.firstElementChild);
            li.appendChild(link);

            list.appendChild(li);
        });

        /* ───────── TAGS ───────── */
        const tagsWrap = document.querySelector('.suitable-tags');
        tagsWrap.innerHTML = '';

        const tagSet = new Set();

        products.forEach(p => {
            if (p.tags) {
                p.tags.forEach(t => tagSet.add(t.name));
            }
        });

        tagSet.forEach(tag => {
            const span = document.createElement('span');
            span.className = 'tag';
            span.textContent = tag;
            tagsWrap.appendChild(span);
        });

    } catch (err) {
        console.error(err);
    }
}

document.addEventListener('DOMContentLoaded', loadBundle);