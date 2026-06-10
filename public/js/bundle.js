/* ── Star renderer ── */
const STAR_FILLED = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81285 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4443 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" fill="#7E6A52" stroke="#7E6A52" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

const STAR_EMPTY = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81284 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4442 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" stroke="#D1D5DC" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
const checkIconSVG = `
<svg class="check-icon" viewBox="0 0 16 16" fill="none">
  <path d="M14.5 8A6.5 6.5 0 1 1 8 1.5" stroke="#7E6A52" stroke-width="1.3"/>
  <path d="M6 7.3L8 9.3L14.6 2.6" stroke="#7E6A52" stroke-width="1.3"/>
</svg>`;

function renderStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        stars += i <= Math.round(rating) ? STAR_FILLED : STAR_EMPTY;
    }
    return stars;
}

function slugify(text) {
    return text
        .toString()
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+|-+$/g, '');
}

async function loadBundle() {
    try {
        const res = await fetch(`/api/find_bundle/${bundle_id}`);
        const data = await res.json();

        if (!data.success) {
            console.error('Bundle not found');
            return;
        }

        const bundle = data.data;
        const products = Object.values(bundle.products);

        /* ───────── IMAGE ───────── */
        const img = document.getElementById('bundle-image');
        img.src = bundle.image || 'https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=900&q=80';
        img.alt = bundle.name || '';

        /* ───────── BADGES ───────── */
        const badgeDiscount = document.getElementById('badge-discount');
        const badgeBestseller = document.getElementById('badge-bestseller');

        badgeDiscount.textContent = bundle.bundle_tags?.[0] || '';
        badgeDiscount.style.display = bundle.bundle_tags?.[0] ? '' : 'none';

        badgeBestseller.textContent = bundle.bundle_tags?.[1] || '';
        badgeBestseller.style.display = bundle.bundle_tags?.[1] ? '' : 'none';

        /* ───────── TITLE ───────── */
        document.getElementById('bundle-title').textContent = bundle.name;
        document.getElementById('bundle-subtitle').textContent = bundle.description || '';

        /* ───────── PRICE ───────── */
        document.getElementById('price-current').textContent = `€${bundle.price}`;

        const priceOriginal = document.getElementById('price-original');
        priceOriginal.textContent = bundle.original_price ? `€${bundle.original_price}` : '';
        priceOriginal.style.display = bundle.original_price ? '' : 'none';

        const priceSave = document.getElementById('price-save');
        priceSave.textContent = bundle.savings || '';
        priceSave.style.display = bundle.savings ? '' : 'none';

        /* ───────── RATING ───────── */
        const ratings = products
            .map(p => parseFloat(p.rating))
            .filter(r => !isNaN(r));

        const avg = ratings.length
            ? ratings.reduce((a, b) => a + b, 0) / ratings.length
            : 0;

        document.getElementById('stars').innerHTML = renderStars(avg);
        document.getElementById('rating-text').textContent = ratings.length
            ? `${avg.toFixed(1)} (${ratings.length} reviews)`
            : 'Nog geen reviews';

        /* ───────── PAKKET ───────── */
        const list = document.getElementById('package-list');
        list.innerHTML = '';
        products.forEach(p => {
            const li = document.createElement('li');

            const iconWrap = document.createElement('div');
            iconWrap.innerHTML = checkIconSVG;


            const link = document.createElement('a');
            link.href = `/product/${p.product_id}/${slugify(p.product_name)}`;
            link.textContent = `${p.product_name} (${p.quantity}x)`;
            li.appendChild(iconWrap);
            li.appendChild(link);
            list.appendChild(li);
        });

        /* ───────── TAGS ───────── */
        const tagsWrap = document.getElementById('suitable-tags');
        tagsWrap.innerHTML = '';

        const tagSet = new Set();
        products.forEach(p => {
            if (p.tags) p.tags.forEach(t => tagSet.add(t.name));
        });

        if (tagSet.size > 0) {
            tagSet.forEach(tag => {
                const span = document.createElement('span');
                span.className = 'tag';
                span.textContent = tag;
                tagsWrap.appendChild(span);
            });
        } else {
            tagsWrap.style.display = 'none';
        }

    } catch (err) {
        console.error(err);
    }
}

document.addEventListener('DOMContentLoaded', loadBundle);