/* ── SVG helpers ── */
const checkIconSVG = `
<svg class="check-icon" viewBox="0 0 16 16" fill="none">
  <path d="M14.5 8A6.5 6.5 0 1 1 8 1.5" stroke="#7E6A52" stroke-width="1.3"/>
  <path d="M6 7.3L8 9.3L14.6 2.6" stroke="#7E6A52" stroke-width="1.3"/>
</svg>`;

const arrowSVG = `
<svg viewBox="0 0 24 24" fill="none" stroke-width="2.5">
  <line x1="5" y1="12" x2="19" y2="12"/>
  <polyline points="12 5 19 12 12 19"/>
</svg>`;

const PLACEHOLDER_IMAGE = 'https://res.cloudinary.com/demo/image/upload/v1312461204/sample.jpg';

/* ── Star renderer ── */
// Note: these SVG strings are hardcoded constants (not user data), so
// using innerHTML here is safe — no XSS risk since nothing is user-controlled.
const STAR_FILLED = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81285 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4443 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" fill="#7E6A52" stroke="#7E6A52" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

const STAR_EMPTY = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81284 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4442 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" stroke="#D1D5DC" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

function renderStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        stars += i <= Math.round(rating) ? STAR_FILLED : STAR_EMPTY;
    }
    return stars;
}

/* ── Card generator ── */

function createCardHTML(bundel) {

    const card = document.createElement('div');
    card.className = 'card card--enter';

    /* ── Image ── */
    const imageWrap = document.createElement('div');
    imageWrap.className = 'card__image-wrap';

    const img = document.createElement('img');
    img.src = `/uploads/bundles/${bundel.image}` || PLACEHOLDER_IMAGE;
    img.alt = bundel.name || '';
    // Guard against infinite loop: fall back once, and only if we're
    // not already showing the placeholder.
    img.addEventListener('error', () => {
        if (img.src === PLACEHOLDER_IMAGE) return;
        img.src = PLACEHOLDER_IMAGE;
    }, { once: true });
    imageWrap.appendChild(img);

    /* Bundle tags */
    if (bundel.bundle_tags) {
        const bundleTagContainer = document.createElement('div');
        bundleTagContainer.className = 'tag--bundle-container';
        imageWrap.appendChild(bundleTagContainer);

        bundel.bundle_tags.forEach(tag => {
            const span = document.createElement('span');
            span.className = 'tag--bundle';
            span.textContent = tag;
            bundleTagContainer.appendChild(span);
        });
    }

    card.appendChild(imageWrap);

    /* ── BODY ── */
    const body = document.createElement('div');
    body.className = 'card__body';

    /* Rating */
    let ratings = bundel.products
        .map(p => parseFloat(p.rating))
        .filter(r => !isNaN(r));

    let avgRating = ratings.length
        ? ratings.reduce((a, b) => a + b, 0) / ratings.length
        : 0;

    const rating = document.createElement('div');
    rating.className = 'rating';

    const stars = document.createElement('div');
    stars.className = 'stars';
    stars.innerHTML = renderStars(avgRating);

    const count = document.createElement('span');
    count.className = 'rating__count';
    count.textContent = `(${ratings.length || 0})`;

    rating.appendChild(stars);
    rating.appendChild(count);
    body.appendChild(rating);

    /* Title */
    const title = document.createElement('h1');
    title.className = 'card__title';
    title.textContent = bundel.name || '';
    body.appendChild(title);

    /* Subtitle */
    const subtitle = document.createElement('p');
    subtitle.className = 'card__subtitle';
    subtitle.textContent = bundel.description || '';
    body.appendChild(subtitle);

    /* Package contents + total */
    const packageBox = document.createElement('div');
    packageBox.className = 'package-box';

    const label = document.createElement('p');
    label.className = 'package-box__label';
    label.textContent = 'Pakket bevat:';

    const list = document.createElement('ul');
    list.className = 'package-list';

    let productTotal = 0;

    bundel.products.forEach(p => {

        const price = parseFloat(p.price) || 0;
        const qty = parseFloat(p.quantity) || 1;

        productTotal += price * qty;

        const li = document.createElement('li');

        const iconWrap = document.createElement('div');
        iconWrap.innerHTML = checkIconSVG;

        const link = document.createElement('a');
        link.href = `/product/${p.product_id}/${slugify(p.product_name)}`;
        link.textContent = `${p.product_name} (${p.quantity}x)`;

        li.appendChild(iconWrap.firstElementChild);
        li.appendChild(link);

        list.appendChild(li);
    });

    packageBox.appendChild(label);
    packageBox.appendChild(list);
    body.appendChild(packageBox);

    /* Suitable-for tags */
    const suitable = document.createElement('div');
    suitable.className = 'suitable';

    const suitableLabel = document.createElement('p');
    suitableLabel.className = 'suitable__label';
    suitableLabel.textContent = 'Geschikt voor:';

    const tagsWrap = document.createElement('div');
    tagsWrap.className = 'tags';

    const tagSet = new Set();

    bundel.products.forEach(p => {
        if (p.tags) {
            p.tags.forEach(t => tagSet.add(t.name));
        }
    });

    tagSet.forEach(tag => {
        const span = document.createElement('span');
        span.className = 'tag tag--product';
        span.textContent = tag;
        tagsWrap.appendChild(span);
    });

    suitable.appendChild(suitableLabel);
    suitable.appendChild(tagsWrap);
    body.appendChild(suitable);

    /* Price */
    const priceRow = document.createElement('div');
    priceRow.className = 'price-row';

    const priceBlock = document.createElement('div');
    priceBlock.className = 'price-block';

    const bundlePrice = parseFloat(bundel.price) || 0;
    const savings = productTotal - bundlePrice;

    /* Current (bundle) price */
    const current = document.createElement('div');
    current.className = 'price-current';
    current.textContent = `€${bundlePrice.toFixed(2)}`;
    priceBlock.appendChild(current);

    /* Original (sum of products) price, shown only when there's a discount */
    if (productTotal > bundlePrice) {
        const original = document.createElement('div');
        original.className = 'price-original';
        original.textContent = `€${productTotal.toFixed(2)}`;
        priceBlock.appendChild(original);
    }

    priceRow.appendChild(priceBlock);

    /* Savings badge (amount, no %) + discount badge (%, placed on image) */
    if (savings > 0) {
        const badge = document.createElement('div');
        badge.className = 'savings-badge';
        badge.textContent = `Bespaar €${savings.toFixed(2)}`;
        priceRow.appendChild(badge);

        const percent = Math.round((savings / productTotal) * 100);

        const discountBadge = document.createElement('span');
        discountBadge.className = 'badge badge--discount';
        discountBadge.textContent = `-${percent}%`;

        imageWrap.appendChild(discountBadge);
    }

    body.appendChild(priceRow);

    /* CTA button */
    const btn = document.createElement('button');
    btn.className = 'btn';
    btn.innerHTML = `Bekijk bundel ${arrowSVG}`;

    btn.addEventListener('click', () => {
        location.href = `/bundel/${bundel.id}/${slugify(bundel.name)}`;
    });

    body.appendChild(btn);

    card.appendChild(body);

    return card;
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

/* ── Skeleton loading state ── */
function createSkeletonCard() {
    const card = document.createElement('div');
    card.className = 'card card--skeleton';

    const imageWrap = document.createElement('div');
    imageWrap.className = 'card__image-wrap skeleton-block';

    const body = document.createElement('div');
    body.className = 'card__body';

    const titleLine = document.createElement('div');
    titleLine.className = 'skeleton-block skeleton-line skeleton-line--title';

    const subtitleLine = document.createElement('div');
    subtitleLine.className = 'skeleton-block skeleton-line skeleton-line--subtitle';

    const packageLine = document.createElement('div');
    packageLine.className = 'skeleton-block skeleton-line skeleton-line--package';

    const priceLine = document.createElement('div');
    priceLine.className = 'skeleton-block skeleton-line skeleton-line--price';

    body.append(titleLine, subtitleLine, packageLine, priceLine);
    card.append(imageWrap, body);

    return card;
}

function renderSkeletons(container, count = 3) {
    const skeletons = Array.from({ length: count }, createSkeletonCard);
    container.replaceChildren(...skeletons);
}

function renderMessage(container, text) {
    const msg = document.createElement('p');
    msg.className = 'bundels-message';
    msg.textContent = text;
    container.replaceChildren(msg);
}

/* ── Fetch & render ── */
async function loadBundles() {
    const container = document.getElementById('bundels-container');
    renderSkeletons(container);

    try {
        const res = await fetch('/api/get_all_bundels');
        const data = await res.json();

        if (!data.success) {
            renderMessage(container, data.message || 'Geen bundels gevonden');
            return;
        }

        if (!data.data.length) {
            renderMessage(container, 'Geen bundels gevonden');
            return;
        }

        const cards = data.data.map(createCardHTML);
        container.replaceChildren(...cards);

        // Stagger the fade-in slightly per card, then clean up the
        // animation class so it doesn't replay on later re-renders.
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 70}ms`;
            card.addEventListener('animationend', () => {
                card.classList.remove('card--enter');
                card.style.animationDelay = '';
            }, { once: true });
        });

    } catch (err) {
        console.error('Failed to load bundels:', err);
        renderMessage(container, 'Er is iets misgegaan. Probeer het later opnieuw.');
    }
}

document.addEventListener('DOMContentLoaded', loadBundles);