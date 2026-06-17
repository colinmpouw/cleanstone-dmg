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
            <!-- populated by JS -->
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
                    <a href="#" class="link-action">Alles bekijken <span class="arrow">→</span></a>
                </div>
                <ul class="order-list" id="orderList">
                    <!-- populated by JS -->
                </ul>
            </div>

            <div class="card list-card">
                <div class="card-head">
                    <h2>Adviesaanvragen</h2>
                    <a href="#" class="link-action">Alles <span class="arrow">→</span></a>
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