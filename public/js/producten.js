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

/* ── Helpers ── */
function formatPrice(value) {
    if (typeof value === 'number') {
        return new Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(value);
    }
    return value;
}

const STAR_FILLED = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81285 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4443 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" fill="#7E6A52" stroke="#7E6A52" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

const STAR_EMPTY = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81284 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4442 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" stroke="#D1D5DC" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

function renderStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        stars += i <= Math.round(rating) ? STAR_FILLED : STAR_EMPTY;
    }
    return stars;
}

function filterProducts(products, searchValue, category, brand) {
    const search = searchValue.trim().toLowerCase();
    return products.filter(product => {
        const matchesSearch = !search || product.name.toLowerCase().includes(search) || (product.brand_name || '').toLowerCase().includes(search);
        const matchesCategory = category === 'all' || (product.category_slug || '').toLowerCase() === category.toLowerCase();
        const matchesBrand = brand === 'all' || (product.brand_name || '').toLowerCase() === brand.toLowerCase();
        return matchesSearch && matchesCategory && matchesBrand;
    });
}

function updateActiveLinks(links, key, value) {
    links.forEach(link => {
        if (link.dataset[key] === value) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

/* ── Card generator ── */
function createProductCardHTML(product) {
    const stockStatus = product.stock > 0 ? 'Op voorraad' : 'Uitverkocht';
    const priceText = formatPrice(product.price);
    const imageSrc = product.image ? `/uploads/products/${product.image}` : 'https://via.placeholder.com/360x240.png?text=Product';
    const imageAlt = product.imageAlt || product.name || 'Productafbeelding';
    const productUrl = `/product/${product.slug || product.id}`;

    const card = document.createElement('article');
    card.className = 'product-card';

    // Make the entire image section clickable
    const imageLink = document.createElement('a');
    imageLink.href = productUrl;
    imageLink.className = 'media-link';

    const imageWrap = document.createElement('div');
    imageWrap.className = 'media';

    const img = document.createElement('img');
    img.src = imageSrc;
    img.alt = imageAlt;
    imageWrap.appendChild(img);

    const badge = document.createElement('div');
    badge.className = `stock-badge ${product.stock > 0 ? 'stock-badge--in-stock' : 'stock-badge--out-of-stock'}`;
    badge.textContent = stockStatus;
    imageWrap.appendChild(badge);
    
    imageLink.appendChild(imageWrap);
    card.appendChild(imageLink);

    const body = document.createElement('div');
    body.className = 'meta';

    const brand = document.createElement('span');
    brand.className = 'product-brand';
    brand.textContent = product.brand_name || 'Onbekend';
    body.appendChild(brand);

    // Make the title a clickable link
    const titleLink = document.createElement('a');
    titleLink.href = productUrl;
    titleLink.className = 'product-title-link';
    titleLink.textContent = product.name;
    
    const title = document.createElement('h4');
    title.appendChild(titleLink);
    body.appendChild(title);

    const avg   = parseFloat(product.avg_rating) || 0;
    const count = parseInt(product.review_count) || 0;

    const rating = document.createElement('div');
    rating.className = 'rating';
    rating.innerHTML = `<span class="stars">${renderStars(avg)}</span><span class="rating-value">${avg > 0 ? avg.toFixed(1) + ' (' + count + ')' : 'Geen reviews'}</span>`;
    body.appendChild(rating);

    const price = document.createElement('div');
    price.className = 'price';
    price.textContent = priceText;
    body.appendChild(price);

    const btn = document.createElement('button');
    btn.className = product.stock > 0 ? 'btn-primary' : 'btn-disabled';
    btn.textContent = product.stock > 0 ? 'Bekijk Product' : 'Uitverkocht';
    if (product.stock > 0) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            // Navigate to product page
            window.location.href = productUrl;
        });
    }
    body.appendChild(btn);

    card.appendChild(body);
    return card;
}

/* ── Fetch & render ── */
async function loadProducts() {
    const grid = document.getElementById('products-grid');
    const count = document.getElementById('product-count');
    const searchInput = document.getElementById('product-search');
    const categoryLinks = Array.from(document.querySelectorAll('[data-category]'));
    const brandLinks = Array.from(document.querySelectorAll('[data-brand]'));

    if (!grid || !count || !searchInput) return;

    let products = [];
    let activeCategory = 'all';
    let activeBrand = 'all';
    let searchValue = '';

    function render(filteredProducts) {
        grid.innerHTML = '';
        count.textContent = `${filteredProducts.length} producten gevonden`;

        if (!filteredProducts.length) {
            grid.innerHTML = '<p>Geen producten gevonden.</p>';
            return;
        }

        filteredProducts.forEach(product => grid.appendChild(createProductCardHTML(product)));
    }

    function applyFilters() {
        const filtered = filterProducts(products, searchValue, activeCategory, activeBrand);
        render(filtered);
    }

    function setupFilterLinks(links, key, setter) {
        links.forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                const value = link.dataset[key] || 'all';
                setter(value);
                updateActiveLinks(links, key, value);
                applyFilters();
            });
        });
    }

    renderProductSkeletons(grid);

    try {
        const res = await fetch('/api/get_all_products');
        products = await res.json();

        if (!Array.isArray(products)) {
            throw new Error('Ongeldige serverrespons');
        }

        setupFilterLinks(categoryLinks, 'category', value => activeCategory = value);
        setupFilterLinks(brandLinks, 'brand', value => activeBrand = value);

        searchInput.addEventListener('input', event => {
            searchValue = event.target.value;
            applyFilters();
        });

        applyFilters();
    } catch (err) {
        console.error('Failed to load products:', err);
        grid.innerHTML = '<p>Er is iets misgegaan met het laden van de producten.</p>';
        count.textContent = '0 producten gevonden';
    }
}

function renderProductSkeletons(grid, count = 8) {
    grid.innerHTML = '';
    for (let i = 0; i < count; i++) {
        const card = document.createElement('article');
        card.className = 'product-card product-card--skeleton';
        card.innerHTML = `
            <div class="skeleton-block sk-media"></div>
            <div class="sk-meta-body">
                <div class="skeleton-block sk-line" style="width:42%;height:12px;margin-bottom:8px;border-radius:6px;"></div>
                <div class="skeleton-block sk-line" style="width:78%;height:16px;margin-bottom:8px;border-radius:6px;"></div>
                <div class="skeleton-block sk-line" style="width:55%;height:12px;margin-bottom:12px;border-radius:6px;"></div>
                <div class="skeleton-block sk-line" style="width:32%;height:18px;margin-bottom:16px;border-radius:6px;"></div>
                <div class="skeleton-block sk-btn"></div>
            </div>`;
        grid.appendChild(card);
    }
}

document.addEventListener('DOMContentLoaded', loadProducts);
