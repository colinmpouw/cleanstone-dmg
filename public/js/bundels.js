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

/* ── Star renderer ── */
function renderStars(rating) {
    const starPath = `<polygon points="10,1 12.9,7 19.5,7.6 14.5,12 16.2,18.5 10,15 3.8,18.5 5.5,12 0.5,7.6 7.1,7"/>`;

    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= Math.floor(rating)) {
            stars += `<svg class="star">${starPath}</svg>`;
        } else if (i - rating < 1 && i - rating > 0) {
            stars += `<svg class="star star--half">${starPath}</svg>`;
        } else {
            stars += `<svg class="star star--empty">${starPath}</svg>`;
        }
    }
    return stars;
}

/* ── Card generator ── */
function createCardHTML(bundel) {

    const card = document.createElement('div');
    card.className = 'card';

    /* ── Image ── */
    const imageWrap = document.createElement('div');
    imageWrap.className = 'card__image-wrap';

    const img = document.createElement('img');
    img.src = bundel.image || 'https://res.cloudinary.com/demo/image/upload/v1312461204/sample.jpg';
    img.alt = bundel.name || '';
    imageWrap.appendChild(img);

    /* ✅ badges */
    if (bundel.bundle_tags) {
        bundel.bundle_tags.forEach((tag, index) => {

            const span = document.createElement('span');
            span.className = 'badge';

            // ✅ 固定左右位置（很关键）
            if (index === 0) {
                span.classList.add('badge--discount');
            } else {
                span.classList.add('badge--bestseller');
            }

            span.textContent = tag;
            imageWrap.appendChild(span);
        });
    }

    card.appendChild(imageWrap);

    /* ── BODY ── */
    const body = document.createElement('div');
    body.className = 'card__body';

    /* ✅ rating */
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

    /* ✅ title */
    const title = document.createElement('h1');
    title.className = 'card__title';
    title.textContent = bundel.name || '';
    body.appendChild(title);

    /* ✅ subtitle */
    const subtitle = document.createElement('p');
    subtitle.className = 'card__subtitle';
    subtitle.textContent = bundel.description || '';
    body.appendChild(subtitle);

    /* ✅ package */
    const packageBox = document.createElement('div');
    packageBox.className = 'package-box';

    const label = document.createElement('p');
    label.className = 'package-box__label';
    label.textContent = 'Pakket bevat:';
    packageBox.appendChild(label);

    const list = document.createElement('ul');
    list.className = 'package-list';

    bundel.products.forEach(p => {
        const li = document.createElement('li');

        const iconWrapper = document.createElement('div');
        iconWrapper.innerHTML = checkIconSVG;
        li.appendChild(iconWrapper.firstElementChild);

        li.appendChild(
            document.createTextNode(`${p.product_name} (${p.quantity}x)`)
        );

        list.appendChild(li);
    });

    packageBox.appendChild(list);
    body.appendChild(packageBox);

    /* ✅ tags (geschikt voor) */
    const suitable = document.createElement('div');
    suitable.className = 'suitable';

    const suitableLabel = document.createElement('p');
    suitableLabel.className = 'suitable__label';
    suitableLabel.textContent = 'Geschikt voor:';
    suitable.appendChild(suitableLabel);

    const tagsWrap = document.createElement('div');
    tagsWrap.className = 'tags';

    const tagSet = new Set();
    bundel.products.forEach(p => {
        if (p.tags) {
            p.tags.forEach(t => tagSet.add(t.name));
        }
    });

    tagSet.forEach(t => {
        const span = document.createElement('span');
        span.className = 'tag';
        span.textContent = t;
        tagsWrap.appendChild(span);
    });

    suitable.appendChild(tagsWrap);
    body.appendChild(suitable);

    /* ✅ price */
    const priceRow = document.createElement('div');
    priceRow.className = 'price-row';

    const priceBlock = document.createElement('div');
    priceBlock.className = 'price-block';

    const current = document.createElement('div');
    current.className = 'price-current';
    current.textContent = `€${bundel.price}`;
    priceBlock.appendChild(current);

    // ✅ 可选原价（以后你可以算折扣）
    if (bundel.original_price) {
        const original = document.createElement('div');
        original.className = 'price-original';
        original.textContent = `€${bundel.original_price}`;
        priceBlock.appendChild(original);
    }

    priceRow.appendChild(priceBlock);

    body.appendChild(priceRow);

    /* ✅ button */
    const btn = document.createElement('button');
    btn.className = 'btn';
    btn.innerHTML = `Bekijk bundel ${arrowSVG}`;

    btn.addEventListener('click', () => {
        location.href = "/bundel/" + bundel.id;
    });

    body.appendChild(btn);

    card.appendChild(body);

    return card;
}

/* ── Fetch & render ── */
async function loadBundels() {
    const container = document.getElementById('bundels-container');
    container.innerHTML = '<p>Laden...</p>';

    try {
        const res = await fetch('/api/get_all_bundels');
        const data = await res.json();

        container.innerHTML = '';

        if (!data.success) {
            const msg = document.createElement('p');
            msg.textContent = data.message || 'Geen bundels gevonden';
            container.appendChild(msg);
            return;
        }


        data.data.forEach(bundel => {
            container.appendChild(createCardHTML(bundel));
        });

    } catch (err) {
        console.error('Failed to load bundels:', err);

        container.innerHTML = '';

        const msg = document.createElement('p');
        msg.textContent = 'Er is iets misgegaan. Probeer het later opnieuw.';
        container.appendChild(msg);
    }
}

document.addEventListener('DOMContentLoaded', loadBundels);