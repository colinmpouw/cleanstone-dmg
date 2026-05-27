<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/home.css">
    <title>Document</title>
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<main class="hero">
    <div class="container">
        <section class="hero-left">
            <div class="badge">Specialist in natuursteen onderhoud</div>
            <h1 class="hero-title">Uw steen,
                <span>perfect</span>
                onderhouden</h1>
            <p class="hero-sub">Premium onderhoudsmiddelen van topmerken als Lithofin, Akemi en Bellinzoni. Professionele kwaliteit voor uw natuursteen, terras en aanrechtblad.</p>

            <div class="hero-cta">
                <a class="btn btn-primary" href="#">Shop Bundels</a>
                <a class="btn btn-outline" href="#">Gratis Advies</a>
            </div>

            <ul class="stats">
                <li>
                    <strong>15.000+</strong>
                    <span>Tevreden klanten</span>
                </li>
                <li>
                    <strong>4.8/5</strong>
                    <span>Gemiddelde review</span>
                </li>
            </ul>
        </section>

        <aside class="hero-right">
            <div class="ba-card">
                <div class="ba-labels"><span class="before">Voor</span><span class="after">Na</span></div>
                <div class="ba-wrap" id="baWrap">
                    <img class="ba-image before-img" src="https://images.unsplash.com/photo-1549880338-65ddcdfd017b?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&s=3bdc4b7b6d9d4a0f9d5bbd3b7b1e0bfc" alt="before">
                    <div class="after-overlay" id="afterOverlay">
                        <img class="ba-image after-img" src="https://images.unsplash.com/photo-1519710164239-da123dc03ef4?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&s=5a6e2b0b0c1a5f8e8f5c2d6b3a9f8d4c" alt="after">
                    </div>
                    <div class="ba-slider" id="baSlider" aria-hidden="true"><span></span></div>
                </div>

                <div class="floating-badge">
                    <div class="check">✓</div>
                    <div class="fb-text"><strong>Gratis verzending</strong><small>Vanaf €50</small></div>
                </div>
                <div class="ba-caption">Voor &amp; Na Resultaat</div>
            </div>
        </aside>
    </div>
    <div class="scroll-hint">↓</div>
</main>

<section class="features">
    <div class="section-inner">
        <article class="feature-card">
            <div class="feature-icon">🚚</div>
            <h3>Gratis verzending</h3>
            <p>Vanaf €50 binnen Nederland.</p>
        </article>
        <article class="feature-card">
            <div class="feature-icon">🔄</div>
            <h3>30 dagen retourrecht</h3>
            <p>Niet tevreden? Geld terug.</p>
        </article>
        <article class="feature-card">
            <div class="feature-icon">🎧</div>
            <h3>Deskundig advies</h3>
            <p>Direct hulp van onze specialisten.</p>
        </article>
        <article class="feature-card">
            <div class="feature-icon">🏅</div>
            <h3>Premium merken</h3>
            <p>Lithofin, Akemi, Bellinzoni &amp; meer.</p>
        </article>
    </div>
</section>

<section class="section products-section">
    <div class="section-head">
        <p class="eyebrow">Populaire producten</p>
        <h2>De meest verkochte producten van topmerken</h2>
    </div>
    <div class="product-grid">
        <article class="product-card">
            <span class="product-pill">Top seller</span>
            <div class="product-media"></div>
            <h3>Lithofin MN Allesreiniger</h3>
            <p class="product-meta">Lichtere vervuiling, dagelijks onderhoud</p>
            <div class="product-meta-row"><strong>€24.95</strong><span>⭐⭐⭐⭐☆</span></div>
            <button class="btn btn-primary">In winkelwagen</button>
        </article>
        <article class="product-card">
            <span class="product-pill">Top seller</span>
            <div class="product-media"></div>
            <h3>Akemi Marble Protector</h3>
            <p class="product-meta">Beschermt en onderhoudt natuursteen</p>
            <div class="product-meta-row"><strong>€39.95</strong><span>⭐⭐⭐⭐☆</span></div>
            <button class="btn btn-primary">In winkelwagen</button>
        </article>
        <article class="product-card">
            <span class="product-pill">Nieuw</span>
            <div class="product-media"></div>
            <h3>Bellinzoni Idea Stone</h3>
            <p class="product-meta">Voor dieptereiniging en glans.</p>
            <div class="product-meta-row"><strong>€29.95</strong><span>⭐⭐⭐⭐☆</span></div>
            <button class="btn btn-primary">In winkelwagen</button>
        </article>
        <article class="product-card">
            <span class="product-pill">Top seller</span>
            <div class="product-media"></div>
            <h3>Lithofin KF Intense Clean</h3>
            <p class="product-meta">Krachtige reiniging voor hardnekkig vuil.</p>
            <div class="product-meta-row"><strong>€34.95</strong><span>⭐⭐⭐⭐☆</span></div>
            <button class="btn btn-primary">In winkelwagen</button>
        </article>
    </div>
</section>

<section class="section bundles-section">
    <div class="section-head">
        <p class="eyebrow">Slimme bundels</p>
        <h2>Bespaar tijd en geld met onze zorgvuldig samengestelde pakketten</h2>
    </div>
    <div class="bundle-grid">
        <article class="bundle-card">
            <span class="bundle-tag">Populair</span>
            <h3>Aanrechtblad Starter</h3>
            <p>Compleet pakket voor dagelijks onderhoud.</p>
            <div class="rating">⭐⭐⭐⭐☆ <span>(324)</span></div>
            <div class="bundle-price"><strong>€89,95</strong> <small>incl. btw</small></div>
            <button class="btn btn-outline">Toevoegen aan winkelwagen</button>
        </article>
        <article class="bundle-card">
            <span class="bundle-tag">Meest gekozen</span>
            <h3>Terras Premium</h3>
            <p>Alles voor een schoon en veilig terras.</p>
            <div class="rating">⭐⭐⭐⭐⭐ <span>(456)</span></div>
            <div class="bundle-price"><strong>€129,95</strong> <small>incl. btw</small></div>
            <button class="btn btn-outline">Toevoegen aan winkelwagen</button>
        </article>
        <article class="bundle-card">
            <span class="bundle-tag">Top deal</span>
            <h3>Badkamer Care</h3>
            <p>Schone en krasvrije badkameroppervlakken.</p>
            <div class="rating">⭐⭐⭐⭐☆ <span>(297)</span></div>
            <div class="bundle-price"><strong>€69,95</strong> <small>incl. btw</small></div>
            <button class="btn btn-outline">Toevoegen aan winkelwagen</button>
        </article>
    </div>
</section>

<section class="brands-section">
    <div class="brand-panel">
        <p class="eyebrow light">Onze partners</p>
        <div class="brand-list">
            <span>Lithofin</span>
            <span>Akemi</span>
            <span>Bellinzoni</span>
            <span>Lantania</span>
        </div>
    </div>
    <div class="brand-logos">
        <span>Lithofin</span>
        <span>Akemi</span>
        <span>Bellinzoni</span>
        <span>Lantania</span>
    </div>
</section>

<section class="section advice-section">
    <div class="advice-grid">
        <div class="advice-copy">
            <p class="eyebrow">Gratis expert advies</p>
            <h2>Twijfel je welk product het beste is voor jouw natuursteen?</h2>
            <p>Upload een foto van de situatie of het staaltje, dan helpen we je persoonlijk met een passend advies binnen 24 uur.</p>
            <ul class="advice-list">
                <li>Upload foto van uw steen</li>
                <li>Beschrijf het probleem</li>
                <li>Ontvang advies op maat</li>
                <li>Bestel direct het juiste product</li>
            </ul>
            <p class="advice-note">Tip: voeg duidelijke foto’s toe voor sneller advies.</p>
        </div>
        <div class="advice-card">
            <div class="upload-header">Upload uw foto</div>
            <div class="upload-dropzone">
                <div class="upload-icon">⬆️</div>
                <p>Sleep uw foto hierheen of klik om te uploaden</p>
                <small>JPG, PNG of HEIC tot 8MB</small>
            </div>
            <form class="advice-form">
                <label>Uw naam<input type="text" placeholder="Uw naam"></label>
                <label>E-mailadres<input type="email" placeholder="E-mailadres"></label>
                <label>Wat wil je weten of zorg je over?</label>
                <textarea rows="4" placeholder="Beschrijf uw vraag"></textarea>
                <button class="btn btn-primary">Verstuur adviesaanvraag</button>
            </form>
        </div>
    </div>
</section>

<section class="section testimonials-section">
    <div class="section-head">
        <p class="eyebrow">Wat onze klanten zeggen</p>
        <h2>Meer dan 15.000 tevreden klanten gingen u voor</h2>
    </div>
    <div class="testimonial-grid">
        <article class="testimonial-card">
            <p>“Al jaren vertrouwen we op de onderhoudsproducten van Cleanstone. Perfect resultaat met minimale inspanning.”</p>
            <div class="testimonial-meta"><strong>Marieke van de Berg</strong><span>Amsterdam</span></div>
        </article>
        <article class="testimonial-card">
            <p>“De service is snel en deskundig. Dankzij het advies heeft ons terras weer een mooie uitstraling.”</p>
            <div class="testimonial-meta"><strong>Pieter Janssen</strong><span>Utrecht</span></div>
        </article>
        <article class="testimonial-card">
            <p>“Snelle levering en een uitstekend product. De natuursteen in onze badkamer ziet er fantastisch uit.”</p>
            <div class="testimonial-meta"><strong>Sophie Vermeer</strong><span>Rotterdam</span></div>
        </article>
    </div>
    <div class="testimonial-summary">
        <div><strong>4.8/5</strong><span>Gemiddelde score</span></div>
        <div><strong>15.000+</strong><span>Reviews</span></div>
    </div>
</section>

<section class="newsletter-section">
    <div class="newsletter-card">
        <div class="newsletter-icon">🎁</div>
        <h2>Ontvang 10% korting</h2>
        <p>Schrijf u in voor onze nieuwsbrief en ontvang exclusieve aanbiedingen, producttips en het beste onderhoudsadvies.</p>
        <form class="newsletter-form">
            <input type="email" placeholder="Uw e-mailadres" aria-label="Uw e-mailadres">
            <button class="btn btn-primary">Inschrijven</button>
        </form>
        <small>Geen zorgen, 1x per week en u kunt altijd uitschrijven.</small>
    </div>
</section>

<?php require_once __DIR__ . '/../component/footer.php'; ?>

<script>
// Simple before-after slider
(function(){
    const wrap = document.getElementById('baWrap');
    const overlay = document.getElementById('afterOverlay');
    const slider = document.getElementById('baSlider');
    let dragging = false;

    function setPosition(x){
        const rect = wrap.getBoundingClientRect();
        let pos = Math.max(0, Math.min(1, (x - rect.left) / rect.width));
        overlay.style.width = (pos * 100) + '%';
        slider.style.left = (pos * 100) + '%';
    }

    slider.addEventListener('mousedown', ()=> dragging = true);
    window.addEventListener('mouseup', ()=> dragging = false);
    window.addEventListener('mousemove', (e)=> { if(dragging) setPosition(e.clientX); });

    // touch
    slider.addEventListener('touchstart', ()=> dragging = true);
    window.addEventListener('touchend', ()=> dragging = false);
    window.addEventListener('touchmove', (e)=> { if(dragging) setPosition(e.touches[0].clientX); });

    // init to 50%
    overlay.style.width = '50%';
    slider.style.left = '50%';
})();
</script>

</body>
</html>