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
    <link rel="stylesheet" href="/public/css/bundle.css">
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <title>CleanStone -Bundel</title>
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<main>

    <a href="#" class="back-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Terug naar alle bundels
    </a>

    <!-- ✅ SKELETON -->
    <section class="product-section skeleton-section" id="bundleSkeleton">

        <div class="image-col">
            <div class="image-wrap">
                <div class="skeleton skeleton-image"></div>
            </div>
            <div class="trust-row">
                <div class="skeleton skeleton-trust"></div>
                <div class="skeleton skeleton-trust"></div>
                <div class="skeleton skeleton-trust"></div>
            </div>
        </div>

        <div class="info-col">
            <div class="skeleton skeleton-line" style="width: 140px; height: 18px;"></div>

            <div>
                <div class="skeleton skeleton-line" style="width: 70%; height: 34px; margin-bottom: 0.6rem;"></div>
                <div class="skeleton skeleton-line" style="width: 90%; height: 18px;"></div>
            </div>

            <div class="price-card">
                <div class="skeleton skeleton-line" style="width: 150px; height: 28px; margin-bottom: 0.75rem;"></div>
                <div class="skeleton skeleton-line" style="width: 100%; height: 48px;"></div>
            </div>

            <div class="package-card">
                <div class="skeleton skeleton-line" style="width: 160px; height: 20px; margin-bottom: 1rem;"></div>
                <div class="skeleton skeleton-line" style="width: 100%; height: 16px; margin-bottom: 0.6rem;"></div>
                <div class="skeleton skeleton-line" style="width: 85%; height: 16px; margin-bottom: 0.6rem;"></div>
                <div class="skeleton skeleton-line" style="width: 90%; height: 16px;"></div>
            </div>

            <div class="suitable-section">
                <div class="skeleton skeleton-line" style="width: 110px; height: 16px; margin-bottom: 0.6rem;"></div>
                <div style="display:flex; gap: 0.5rem;">
                    <div class="skeleton skeleton-tag"></div>
                    <div class="skeleton skeleton-tag"></div>
                    <div class="skeleton skeleton-tag"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ REAL CONTENT -->
    <section class="product-section" id="bundleContent" hidden>

        <!-- LEFT -->
        <div class="image-col">
            <div class="image-wrap">
                <img
                        id="bundle-image"
                        src="https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=900&q=80"
                        alt="Moderne keuken met marmeren aanrechtblad"
                />
                <span id="badge-discount" class="badge-discount">-18%</span>
                <span id="badge-bestseller" class="badge-bestseller"></span>
            </div>

            <div class="trust-row" id="trust-row">
                <div class="trust-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 18V6C14 5.46957 13.7893 4.96086 13.4142 4.58579C13.0391 4.21071 12.5304 4 12 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V17C2 17.2652 2.10536 17.5196 2.29289 17.7071C2.48043 17.8946 2.73478 18 3 18H5"
                              stroke="#7E6A52" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15 18H9" stroke="#7E6A52" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M19 18H21C21.2652 18 21.5196 17.8946 21.7071 17.7071C21.8946 17.5196 22 17.2652 22 17V13.35C21.9996 13.1231 21.922 12.903 21.78 12.726L18.3 8.376C18.2065 8.25888 18.0878 8.16428 17.9528 8.0992C17.8178 8.03412 17.6699 8.00021 17.52 8H14"
                              stroke="#7E6A52" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M17 20C18.1046 20 19 19.1046 19 18C19 16.8954 18.1046 16 17 16C15.8954 16 15 16.8954 15 18C15 19.1046 15.8954 20 17 20Z"
                              stroke="#7E6A52" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 20C8.10457 20 9 19.1046 9 18C9 16.8954 8.10457 16 7 16C5.89543 16 5 16.8954 5 18C5 19.1046 5.89543 20 7 20Z"
                              stroke="#7E6A52" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Gratis verzending
                </div>
                <div class="trust-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 13.0004C20 18.0004 16.5 20.5005 12.34 21.9505C12.1222 22.0243 11.8855 22.0207 11.67 21.9405C7.5 20.5005 4 18.0004 4 13.0004V6.00045C4 5.73523 4.10536 5.48088 4.29289 5.29334C4.48043 5.10581 4.73478 5.00045 5 5.00045C7 5.00045 9.5 3.80045 11.24 2.28045C11.4519 2.09945 11.7214 2 12 2C12.2786 2 12.5481 2.09945 12.76 2.28045C14.51 3.81045 17 5.00045 19 5.00045C19.2652 5.00045 19.5196 5.10581 19.7071 5.29334C19.8946 5.48088 20 5.73523 20 6.00045V13.0004Z"
                              stroke="#7E6A52" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    100% garantie
                </div>
                <div class="trust-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.93694 15.5002C9.84766 15.1542 9.66728 14.8384 9.41456 14.5856C9.16184 14.3329 8.84601 14.1525 8.49994 14.0632L2.36494 12.4812C2.26027 12.4515 2.16815 12.3885 2.10255 12.3017C2.03696 12.2149 2.00146 12.1091 2.00146 12.0002C2.00146 11.8914 2.03696 11.7856 2.10255 11.6988C2.16815 11.612 2.26027 11.549 2.36494 11.5192L8.49994 9.93625C8.84589 9.84706 9.16163 9.66682 9.41434 9.41429C9.66705 9.16175 9.84751 8.84614 9.93694 8.50025L11.5189 2.36525C11.5483 2.26017 11.6113 2.16759 11.6983 2.10164C11.7852 2.0357 11.8913 2 12.0004 2C12.1096 2 12.2157 2.0357 12.3026 2.10164C12.3896 2.16759 12.4525 2.26017 12.4819 2.36525L14.0629 8.50025C14.1522 8.84632 14.3326 9.16215 14.5853 9.41487C14.838 9.66759 15.1539 9.84797 15.4999 9.93725L21.6349 11.5182C21.7404 11.5473 21.8335 11.6103 21.8998 11.6973C21.9661 11.7844 22.002 11.8908 22.002 12.0002C22.002 12.1097 21.9661 12.2161 21.8998 12.3032C21.8335 12.3902 21.7404 12.4531 21.6349 12.4822L15.4999 14.0632C15.1539 14.1525 14.838 14.3329 14.5853 14.5856C14.3326 14.8384 14.1522 15.1542 14.0629 15.5002L12.4809 21.6353C12.4515 21.7403 12.3886 21.8329 12.3016 21.8989C12.2147 21.9648 12.1086 22.0005 11.9994 22.0005C11.8903 22.0005 11.7842 21.9648 11.6973 21.8989C11.6103 21.8329 11.5473 21.7403 11.5179 21.6353L9.93694 15.5002Z"
                              stroke="#7E6A52" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 3V7" stroke="#7E6A52" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M22 5H18" stroke="#7E6A52" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M4 17V19" stroke="#7E6A52" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M5 18H3" stroke="#7E6A52" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>

                    Premium kwaliteit
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="info-col">

            <div class="rating-row">
                <div class="stars" id="stars">

                </div>
                <span id="rating-text"></span>
            </div>

            <div>
                <h1 id="bundle-title" class="product-title">Aanrechtblad Starter</h1>
                <p id="bundle-subtitle" class="product-subtitle">Compleet pakket voor dagelijks onderhoud van uw
                    aanrechtblad</p>
            </div>

            <div class="price-card">
                <div class="price-row">
                    <div class="price-container">
                        <span id="price-current" class="price-current">€89.95</span>
                        <span id="price-original" class="price-original">€109.95</span>
                    </div>
                    <span id="price-save" class="badge-save">Bespaar €20</span>
                </div>
                <button class="btn-cart" id="btn-cart">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 22C8.55228 22 9 21.5523 9 21C9 20.4477 8.55228 20 8 20C7.44772 20 7 20.4477 7 21C7 21.5523 7.44772 22 8 22Z"
                              stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 22C19.5523 22 20 21.5523 20 21C20 20.4477 19.5523 20 19 20C18.4477 20 18 20.4477 18 21C18 21.5523 18.4477 22 19 22Z"
                              stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2.05005 2.0498H4.05005L6.71005 14.4698C6.80763 14.9247 7.06072 15.3313 7.42576 15.6197C7.7908 15.908 8.24495 16.0602 8.71005 16.0498H18.49C18.9452 16.0491 19.3865 15.8931 19.7411 15.6076C20.0956 15.3222 20.3422 14.9243 20.4401 14.4798L22.09 7.0498H5.12005"
                              stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    In winkelwagen
                </button>
            </div>

            <div class="package-card">
                <div class="package-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 21.7299C11.304 21.9054 11.6489 21.9979 12 21.9979C12.3511 21.9979 12.696 21.9054 13 21.7299L20 17.7299C20.3037 17.5545 20.556 17.3024 20.7315 16.9987C20.9071 16.6951 20.9996 16.3506 21 15.9999V7.9999C20.9996 7.64918 20.9071 7.30471 20.7315 7.00106C20.556 6.69742 20.3037 6.44526 20 6.2699L13 2.2699C12.696 2.09437 12.3511 2.00195 12 2.00195C11.6489 2.00195 11.304 2.09437 11 2.2699L4 6.2699C3.69626 6.44526 3.44398 6.69742 3.26846 7.00106C3.09294 7.30471 3.00036 7.64918 3 7.9999V15.9999C3.00036 16.3506 3.09294 16.6951 3.26846 16.9987C3.44398 17.3024 3.69626 17.5545 4 17.7299L11 21.7299Z"
                              stroke="#7E6A52" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 22V12" stroke="#7E6A52" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M3.29004 7L12 12L20.71 7" stroke="#7E6A52" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M7.5 4.26953L16.5 9.41953" stroke="#7E6A52" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>

                    Pakket bevat:
                </div>
                <ul class="package-list" id="package-list">

                </ul>
            </div>

            <div class="suitable-section">
                <p class="suitable-title">Geschikt voor:</p>
                <div class="suitable-tags" id="suitable-tags">
                    <span class="tag">Graniet</span>
                    <span class="tag">Marmer</span>
                    <span class="tag">Composiet</span>
                </div>
            </div>

        </div>
    </section>

    <div class="page-title" id="link-advies-container">

        <h1>Vragen over deze bundel?</h1>
        <p>Neem contact op met onze experts voor persoonlijk advies</p>
        <a href="/advies" id="advice-link">Gratis advies aanvragen</a>
        <a href="/contact"> Contact opnemen</a>

    </div>
    <h1 id="other-bundles">Andere bundels</h1>
    <section id="bundles-grid">

    </section>
</main>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<script src="/public/js/bundle.js"></script>
<script src="/public/js/AiChat.js"></script>

</body>
</html>