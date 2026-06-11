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
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                Specialist in natuursteen onderhoud
            </div>

            <h1 class="hero__title">
                Uw steen,<br>
                <span>perfect<br>onderhouden</span>
            </h1>

            <p class="hero__desc">
                Premium onderhoudsmiddelen van topmerken als Lithofin, Akemi en Bellinzoni. Professionele kwaliteit voor
                uw natuursteen, terras en aanrechtblad.
            </p>

            <div class="hero__buttons">
                <a href="/bundels" class="btn-primary">Shop Bundels &nbsp;→</a>
                <a href="/advies" class="btn-outline">Gratis Advies</a>
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
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                             fill="currentColor">
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
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                         stroke-linejoin="round">
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
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
             stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <polyline points="19 12 12 19 5 12"/>
        </svg>
    </div>
</section>

<section class="show_all_badges">

    <div class="all_badges">

        <div class="badge">
            <div class="badge_icon">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.6667 24V8.00004C18.6667 7.2928 18.3857 6.61452 17.8856 6.11442C17.3855 5.61433 16.7073 5.33337 16 5.33337H5.33335C4.62611 5.33337 3.94783 5.61433 3.44774 6.11442C2.94764 6.61452 2.66669 7.2928 2.66669 8.00004V22.6667C2.66669 23.0203 2.80716 23.3595 3.05721 23.6095C3.30726 23.8596 3.6464 24 4.00002 24H6.66669"
                          stroke="#3A2B20" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20 24H12" stroke="#3A2B20" stroke-width="2.66667" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M25.3334 24H28C28.3536 24 28.6928 23.8595 28.9428 23.6094C29.1929 23.3594 29.3334 23.0202 29.3334 22.6666V17.8C29.3328 17.4974 29.2294 17.204 29.04 16.968L24.4 11.168C24.2753 11.0118 24.1171 10.8857 23.9371 10.7989C23.7571 10.7121 23.5599 10.6669 23.36 10.6666H18.6667"
                          stroke="#3A2B20" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22.6667 26.6667C24.1394 26.6667 25.3333 25.4728 25.3333 24C25.3333 22.5273 24.1394 21.3334 22.6667 21.3334C21.1939 21.3334 20 22.5273 20 24C20 25.4728 21.1939 26.6667 22.6667 26.6667Z"
                          stroke="#3A2B20" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.33335 26.6667C10.8061 26.6667 12 25.4728 12 24C12 22.5273 10.8061 21.3334 9.33335 21.3334C7.86059 21.3334 6.66669 22.5273 6.66669 24C6.66669 25.4728 7.86059 26.6667 9.33335 26.6667Z"
                          stroke="#3A2B20" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="badge_title"> Gratis verzending</div>
            <div class="small_text"> Vanaf €50 binnen Nederland</div>
        </div>

        <div class="badge">
            <div class="badge_icon">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M26.6666 17.3333C26.6666 23.9999 22 27.3333 16.4533 29.2666C16.1629 29.365 15.8474 29.3603 15.56 29.2533C9.99998 27.3333 5.33331 23.9999 5.33331 17.3333V7.99995C5.33331 7.64633 5.47379 7.30719 5.72384 7.05714C5.97389 6.80709 6.31302 6.66662 6.66665 6.66662C9.33331 6.66662 12.6666 5.06662 14.9866 3.03995C15.2691 2.79861 15.6285 2.66602 16 2.66602C16.3715 2.66602 16.7308 2.79861 17.0133 3.03995C19.3466 5.07995 22.6666 6.66662 25.3333 6.66662C25.6869 6.66662 26.0261 6.80709 26.2761 7.05714C26.5262 7.30719 26.6666 7.64633 26.6666 7.99995V17.3333Z"
                          stroke="#3A2B20" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="badge_title"> 30 dagen retourrecht</div>
            <div class="small_text"> Niet tevreden? Geld terug</div>
        </div>

        <div class="badge">
            <div class="badge_icon">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 18.6667H8C8.70724 18.6667 9.38552 18.9476 9.88562 19.4477C10.3857 19.9478 10.6667 20.6261 10.6667 21.3333V25.3333C10.6667 26.0406 10.3857 26.7189 9.88562 27.219C9.38552 27.719 8.70724 28 8 28H6.66667C5.95942 28 5.28115 27.719 4.78105 27.219C4.28095 26.7189 4 26.0406 4 25.3333V16C4 12.8174 5.26428 9.76516 7.51472 7.51472C9.76516 5.26428 12.8174 4 16 4C19.1826 4 22.2348 5.26428 24.4853 7.51472C26.7357 9.76516 28 12.8174 28 16V25.3333C28 26.0406 27.719 26.7189 27.219 27.219C26.7189 27.719 26.0406 28 25.3333 28H24C23.2928 28 22.6145 27.719 22.1144 27.219C21.6143 26.7189 21.3333 26.0406 21.3333 25.3333V21.3333C21.3333 20.6261 21.6143 19.9478 22.1144 19.4477C22.6145 18.9476 23.2928 18.6667 24 18.6667H28"
                          stroke="#3A2B20" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="badge_title"> Deskundig advies</div>
            <div class="small_text"> Direct hulp van specialisten</div>
        </div>

        <div class="badge">
            <div class="badge_icon">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.636 17.1866L22.656 28.5546C22.6787 28.6885 22.6599 28.8261 22.6022 28.949C22.5445 29.0719 22.4507 29.1742 22.3333 29.2424C22.2159 29.3105 22.0804 29.3412 21.9451 29.3303C21.8098 29.3193 21.681 29.2674 21.576 29.1813L16.8027 25.5986C16.5723 25.4265 16.2923 25.3335 16.0047 25.3335C15.7171 25.3335 15.4371 25.4265 15.2067 25.5986L10.4254 29.18C10.3205 29.2659 10.1919 29.3178 10.0567 29.3287C9.92154 29.3396 9.78626 29.3091 9.66892 29.2411C9.55157 29.1732 9.45774 29.0711 9.39993 28.9484C9.34212 28.8258 9.32308 28.6884 9.34537 28.5546L11.364 17.1866"
                          stroke="#3A2B20" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 18.6666C20.4183 18.6666 24 15.0849 24 10.6666C24 6.24835 20.4183 2.66663 16 2.66663C11.5817 2.66663 8 6.24835 8 10.6666C8 15.0849 11.5817 18.6666 16 18.6666Z"
                          stroke="#3A2B20" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="badge_title"> Premium merken</div>
            <div class="small_text"> Lithofin, Akemi, Bellinzoni</div>
        </div>

    </div>
</section>

<div class="full-bleed-divider" aria-hidden="true"></div>

<section class="popular_products">
    <div class="popular_header">
        <h1>Populaire producten</h1>
        <p>De meest verkochte producten van topmerken</p>
    </div>
    <div class="products-grid" id="top-products-container"></div>
    <div class="products-footer">
        <a href="/producten"><button class="view-products-btn">Bekijk alle producten</button></a>
    </div>
</section>

<section class="show_all_bundels">
    <div class="bundels_header">
        <h1>Slimme bundels</h1>
        <p>Bespaar tijd en geld met onze zorgvuldig samengestelde pakketten</p>
    </div>
    <div id="top-bundels-container" class="cards-grid"></div>
</section>

<section class="merken-section">

    <div class="merken-header">
        <h1>Premium merken</h1>
        <p>Wij werken samen met de beste fabrikanten in de branche</p>
    </div>

    <div class="merken-banner">
        <div class="merken-banner__label">
            <span>Onze partners</span>
            <div class="divider"></div>
            <span class="tag">Merken</span>
        </div>
        <div class="merken-logos" id="merken-logos"></div>
    </div>

    <div class="merken-labels" id="merken-labels"></div>  <!-- buiten de banner -->

</section>

<?php require_once __DIR__ . '/../component/footer.php'; ?>

<script src="/public/js/home.js"></script>
<!--<script src="/public/js/bundles.js"></script>-->
</body>
</html>