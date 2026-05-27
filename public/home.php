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