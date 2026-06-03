
/* ── SVG helpers ── */
const checkIconSVG = `
  <svg class="check-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip-check)">
      <path d="M14.534 6.66666C14.8385 8.16086 14.6215 9.71428 13.9192 11.0679C13.217 12.4214 12.0719 13.4934 10.675 14.1049C9.2781 14.7164 7.71376 14.8305 6.24287 14.4282C4.77199 14.026 3.48347 13.1316 2.59219 11.8943C1.70091 10.657 1.26075 9.15148 1.34511 7.62892C1.42948 6.10635 2.03326 4.65872 3.05577 3.52744C4.07829 2.39616 5.45773 1.64961 6.96405 1.4123C8.47037 1.17498 10.0125 1.46123 11.3333 2.22333" stroke="#7E6A52" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M6 7.33366L8 9.33366L14.6667 2.66699" stroke="#7E6A52" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
    </g>
    <defs>
      <clipPath id="clip-check"><rect width="16" height="16" fill="white"/></clipPath>
    </defs>
  </svg>`;

const arrowSVG = `
  <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <line x1="5" y1="12" x2="19" y2="12"/>
    <polyline points="12 5 19 12 12 19"/>
  </svg>`;

const halfGradientDef = `
  <svg width="0" height="0" style="position:absolute">
    <defs>
      <linearGradient id="half-gradient">
        <stop offset="50%" stop-color="#f5a623"/>
        <stop offset="50%" stop-color="#e0ddd8"/>
      </linearGradient>
    </defs>
  </svg>`;

/* ── Star renderer ── */
function renderStars(rating) {
    const starPath = `<polygon points="10,1 12.9,7 19.5,7.6 14.5,12 16.2,18.5 10,15 3.8,18.5 5.5,12 0.5,7.6 7.1,7"/>`;
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= Math.floor(rating)) {
            stars += `<svg class="star" viewBox="0 0 20 20">${starPath}</svg>`;
        } else if (i - rating < 1 && i - rating > 0) {
            stars += `<svg class="star star--half" viewBox="0 0 20 20">${starPath}</svg>`;
        } else {
            stars += `<svg class="star star--empty" viewBox="0 0 20 20">${starPath}</svg>`;
        }
    }
    return stars;
}

/* ── Card generator ── */
function createCardHTML(bundel) {

    /* ── Card ── */
    const card = document.createElement('div');
    card.className = 'bundels-card';

    /* ── Image wrap ── */
    const imageWrap = document.createElement('div');
    imageWrap.className = 'card__image-wrap';

    const img = document.createElement('img');
    img.src = bundel.image;
    img.alt = bundel.imageAlt;
    imageWrap.appendChild(img);

    if (bundel.discount) {
        const discountBadge = document.createElement('span');
        discountBadge.className = 'bundels-badge badge--discount';
        discountBadge.textContent = bundel.discount;
        imageWrap.appendChild(discountBadge);
    }

    if (bundel.bestseller) {
        const bestsellerBadge = document.createElement('span');
        bestsellerBadge.className = 'bundels-badge badge--bestseller';
        bestsellerBadge.textContent = 'Bestseller';
        imageWrap.appendChild(bestsellerBadge);
    }

    card.appendChild(imageWrap);

    /* ── Body ── */
    const body = document.createElement('div');
    body.className = 'card__body';

    /* Rating */
    const rating = document.createElement('div');
    rating.className = 'rating';

    const starsWrap = document.createElement('div');
    starsWrap.className = 'stars';
    starsWrap.innerHTML = renderStars(bundel.rating); // safe: only SVG polygons, no user data

    const reviewCount = document.createElement('span');
    reviewCount.className = 'rating__count';
    reviewCount.textContent = `(${bundel.reviewCount})`;

    rating.appendChild(starsWrap);
    rating.appendChild(reviewCount);
    body.appendChild(rating);

    /* Title */
    const title = document.createElement('h2');
    title.className = 'card__title';
    title.textContent = bundel.title;
    body.appendChild(title);

    /* Subtitle */
    const subtitle = document.createElement('p');
    subtitle.className = 'card__subtitle';
    subtitle.textContent = bundel.subtitle;
    body.appendChild(subtitle);

    /* Package box */
    const packageBox = document.createElement('div');
    packageBox.className = 'package-box';

    const packageLabel = document.createElement('p');
    packageLabel.className = 'package-box__label';
    packageLabel.textContent = 'Pakket bevat:';
    packageBox.appendChild(packageLabel);

    const packageList = document.createElement('ul');
    packageList.className = 'package-list';

    bundel.package.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = checkIconSVG; // static SVG, no user data
        const text = document.createTextNode(item);
        li.appendChild(text);
        packageList.appendChild(li);
    });

    packageBox.appendChild(packageList);
    body.appendChild(packageBox);

    /* Suitable for */
    const suitable = document.createElement('div');
    suitable.className = 'suitable';

    const suitableLabel = document.createElement('p');
    suitableLabel.className = 'suitable__label';
    suitableLabel.textContent = 'Geschikt voor:';
    suitable.appendChild(suitableLabel);

    const tagsWrap = document.createElement('div');
    tagsWrap.className = 'tags';

    bundel.suitableFor.forEach(t => {
        const tag = document.createElement('span');
        tag.className = 'tag';
        tag.textContent = t;
        tagsWrap.appendChild(tag);
    });

    suitable.appendChild(tagsWrap);
    body.appendChild(suitable);

    /* Price row */
    const priceRow = document.createElement('div');
    priceRow.className = 'price-row';

    const priceBlock = document.createElement('div');
    priceBlock.className = 'price-block';

    const priceCurrent = document.createElement('div');
    priceCurrent.className = 'price-current';
    priceCurrent.textContent = bundel.price;

    const priceOriginal = document.createElement('div');
    priceOriginal.className = 'price-original';
    priceOriginal.textContent = bundel.originalPrice;

    priceBlock.appendChild(priceCurrent);
    priceBlock.appendChild(priceOriginal);

    const savingsBadge = document.createElement('div');
    savingsBadge.className = 'savings-badge';
    savingsBadge.textContent = bundel.savings;

    priceRow.appendChild(priceBlock);
    priceRow.appendChild(savingsBadge);
    body.appendChild(priceRow);

    /* CTA button */
    const btn = document.createElement('button');
    btn.className = 'btn';
    btn.innerHTML = arrowSVG; // static SVG, no user data
    btn.prepend(document.createTextNode('Bekijk bundel '));
    btn.addEventListener('click', () => {
        location.href = "/bundel/" + bundel.id; // navigate to detail page
    });

    body.appendChild(btn);
    card.appendChild(body);

    return card; // returns a DOM node, not a string
}

/* ── Fetch & render ── */
async function loadBundels() {
    const container = document.getElementById('bundels-container');
    container.innerHTML = '<p>Laden...</p>';

    try {
        const res = await fetch('/api/get_all_bundels');
        const data = await res.json();

        container.innerHTML = '';
        data.forEach(bundel => container.appendChild(createCardHTML(bundel)));

    } catch (err) {
        console.error('Failed to load bundels:', err);
        container.innerHTML = '';
        const msg = document.createElement('p');
        msg.textContent = 'Er is iets misgegaan. Probeer het later opnieuw.';
        container.appendChild(msg);
    }
}

document.addEventListener('DOMContentLoaded', loadBundels);