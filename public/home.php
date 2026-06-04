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
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <title>CleanStone -Home</title>
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<section class="hero">
    <div class="hero__inner">

        <!-- LEFT -->
        <div class="hero__left">
            <div class="hero__badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                Specialist in natuursteen onderhoud
            </div>

            <h1 class="hero__title">
                Uw steen,<br>
                <span>perfect<br>onderhouden</span>
            </h1>

            <p class="hero__desc">
                Premium onderhoudsmiddelen van topmerken als Lithofin, Akemi en Bellinzoni. Professionele kwaliteit voor uw natuursteen, terras en aanrechtblad.
            </p>

            <div class="hero__buttons">
                <a href="#" class="btn-primary">Shop Bundels &nbsp;→</a>
                <a href="#" class="btn-outline">Gratis Advies</a>
            </div>

            <div class="hero__stats">
                <div>
                    <div class="stat__number">15.000+</div>
                    <div class="stat__label">Tevreden klanten</div>
                </div>
                <div>
                    <div class="stat__number">4.8/5</div>
                    <div class="stat__label">Gemiddelde review</div>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="hero__right">
            <div class="card-main">
                <!-- Before/After Slider -->
                <div class="slider-wrap" id="slider">
                    <div class="slider-bg"></div>
                    <div class="slider-fg" id="sliderFg"></div>
                    <div class="slider-divider" id="sliderLine"></div>
                    <div class="slider-handle" id="sliderHandle">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                            <path d="M280-280 80-480l200-200 56 56-103 104h494L624-624l56-56 200 200-200 200-56-56 103-104H233l103 104-56 56Z"/>
                        </svg>
                    </div>
                    <span class="label-voor">Voor</span>
                    <span class="label-na">Na</span>
                </div>

                <div class="card-footer">
                    <h3>Voor &amp; Na Resultaat</h3>
                    <p>Versleep de balk om het verschil te zien</p>
                </div>
            </div>

            <!-- Floating badge -->
            <div class="float-badge">
                <div class="float-badge__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <div class="float-badge__text">
                    <strong>Gratis verzending</strong>
                    <span>Vanaf €50</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Scroll indicator -->
    <div class="hero__scroll">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>
        </svg>
    </div>
</section>



<?php require_once __DIR__ . '/../component/footer.php'; ?>

<script src="/public/js/home.js"></script>
</body>
</html>