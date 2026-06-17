<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Dashboard</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminDashboard.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<!-- MAIN -->
<div class="main">
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
    <!-- CONTENT -->
    <main class="content">

        <header class="page-header">
            <h1>Dashboard</h1>
            <p class="subtitle">Welkom terug — overzicht van vandaag</p>
        </header>

        <!-- Stat cards -->
        <section class="stat-grid" id="statGrid" aria-label="Kerncijfers">
            <div class="stat-card" id="revenue">
                <div class="stat-icon">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.5 5.25L10.125 11.625L6.375 7.875L1.5 12.75" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 5.25H16.5V9.75" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h2>€&nbsp;15.200,00</h2>
                <h4>Omzet deze maand</h4>
                <small>12%</small>
            </div>
            <div class="stat-card" id="orders">
                <div class="stat-icon">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_526_131)">
                            <path d="M6 16.5C6.41421 16.5 6.75 16.1642 6.75 15.75C6.75 15.3358 6.41421 15 6 15C5.58579 15 5.25 15.3358 5.25 15.75C5.25 16.1642 5.58579 16.5 6 16.5Z" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.25 16.5C14.6642 16.5 15 16.1642 15 15.75C15 15.3358 14.6642 15 14.25 15C13.8358 15 13.5 15.3358 13.5 15.75C13.5 16.1642 13.8358 16.5 14.25 16.5Z" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1.53748 1.53751H3.03748L5.03248 10.8525C5.10566 11.1937 5.29548 11.4986 5.56926 11.7149C5.84304 11.9312 6.18366 12.0453 6.53248 12.0375H13.8675C14.2089 12.037 14.5398 11.92 14.8057 11.7059C15.0717 11.4918 15.2566 11.1934 15.33 10.86L16.5675 5.28751H3.83998" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_526_131">
                                <rect width="18" height="18" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>

                </div>
                <h2>312</h2>
                <h4>Bestellingen</h4>
                <small>5%</small>
            </div>
            <div class="stat-card" id="active_products">
                <div class="stat-icon">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.25 16.2975C8.47803 16.4292 8.7367 16.4985 9 16.4985C9.2633 16.4985 9.52197 16.4292 9.75 16.2975L15 13.2975C15.2278 13.166 15.417 12.9769 15.5487 12.7491C15.6803 12.5214 15.7497 12.263 15.75 12V6C15.7497 5.73696 15.6803 5.47861 15.5487 5.25087C15.417 5.02314 15.2278 4.83402 15 4.7025L9.75 1.7025C9.52197 1.57085 9.2633 1.50154 9 1.50154C8.7367 1.50154 8.47803 1.57085 8.25 1.7025L3 4.7025C2.7722 4.83402 2.58299 5.02314 2.45135 5.25087C2.31971 5.47861 2.25027 5.73696 2.25 6V12C2.25027 12.263 2.31971 12.5214 2.45135 12.7491C2.58299 12.9769 2.7722 13.166 3 13.2975L8.25 16.2975Z" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 16.5V9" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2.46753 5.25L9.00003 9L15.5325 5.25" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.625 3.2025L12.375 7.065" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                </div>
                <h2>72</h2>
                <h4>Actieve producten</h4>
                <small>2%</small>
            </div>
            <div class="stat-card" id="advice_requests">
                <div class="stat-icon">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.75 11.25C15.75 11.6478 15.592 12.0294 15.3107 12.3107C15.0294 12.592 14.6478 12.75 14.25 12.75H5.25L2.25 15.75V3.75C2.25 3.35218 2.40804 2.97064 2.68934 2.68934C2.97064 2.40804 3.35218 2.25 3.75 2.25H14.25C14.6478 2.25 15.0294 2.40804 15.3107 2.68934C15.592 2.97064 15.75 3.35218 15.75 3.75V11.25Z" stroke="#3A2B20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h2>6</h2>
                <h4>Adviesaanvragen</h4>
                <small>-1%</small>
            </div>
        </section>


        <!-- Charts row -->
        <section class="charts-row">

            <!-- ✅ Revenue Chart (FIXED) -->
            <div class="card chart-card">
                <div class="card-head">
                    <div>
                        <h2>Omzet 2025</h2>
                        <p class="card-subtitle">Maandelijks overzicht</p>
                    </div>
                    <div class="total-value" id="revenueTotal">—</div>
                </div>

                <div class="chart-wrap">
                    <!-- ✅ CHANGE: svg → canvas -->
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- ✅ Category Chart (FIXED) -->
            <div class="card category-card">
                <div class="card-head">
                    <div>
                        <h2>Per categorie</h2>
                        <p class="card-subtitle">Bestellingen afgelopen maand</p>
                    </div>
                </div>

                <!-- ✅ CHANGE: div → canvas -->
                <div class="chart-wrap">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

        </section>

        <!-- Lists row -->
        <section class="lists-row">
            <div class="card list-card">
                <div class="card-head">
                    <h2>Recente bestellingen</h2>
                    <a href="/admin/bestellingen" class="link-action">Alles bekijken <span class="arrow">→</span></a>
                </div>
                <ul class="order-list" id="orderList">
                    <!-- populated by JS -->
                </ul>
            </div>

            <div class="card list-card">
                <div class="card-head">
                    <h2>Adviesaanvragen</h2>
                    <a href="/admin/adviesaanvragen" class="link-action">Alles <span class="arrow">→</span></a>
                </div>
                <ul class="advice-list" id="adviceList">
                    <!-- populated by JS -->
                </ul>
            </div>

        </section>

    </main>


</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/admin/js/adminDashboard.js" defer></script>
</body>
</html>