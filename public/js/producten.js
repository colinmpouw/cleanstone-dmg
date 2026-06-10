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
    const imageSrc = product.image ? `/public/assets/${product.image}` : 'https://via.placeholder.com/360x240.png?text=Product';
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

    const rating = document.createElement('div');
    rating.className = 'rating';
    rating.innerHTML = `<span class="stars">${renderStars(product.rating || 4.5)}</span><span class="rating-value">${product.reviewCount || 158}</span>`;
    body.appendChild(rating);

    const price = document.createElement('div');
    price.className = 'price';
    price.textContent = priceText;
    body.appendChild(price);

    const btn = document.createElement('button');
    btn.className = product.stock > 0 ? 'btn-primary' : 'btn-disabled';
    btn.textContent = product.stock > 0 ? 'In winkelwagen' : 'Uitverkocht';
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

    grid.innerHTML = '<p>Laden...</p>';

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

document.addEventListener('DOMContentLoaded', loadProducts);
