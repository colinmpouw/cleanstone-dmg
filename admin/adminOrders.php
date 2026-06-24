<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Bestellingen</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminOrders.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<!-- MAIN -->
<div class="main">
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
    <!-- CONTENT -->
    <main class="content">
        <div class="orders-heading">
            <div>
                <h1>Bestellingen</h1>
                <p id="orderCount">— bestellingen in totaal</p>
            </div>
            <button class="btn-export" aria-label="Exporteren">
                <i class="ti ti-download"></i>
                Exporteren
            </button>
        </div>

        <div class="orders-toolbar">
            <div class="status-filters" id="statusFilters">
                <button class="filter-btn filter-btn--active" data-status="all">Alle</button>
                <button class="filter-btn" data-status="verwerking">Verwerking</button>
                <button class="filter-btn" data-status="betaald">Betaald</button>
                <button class="filter-btn" data-status="verzonden">Verzonden</button>
                <button class="filter-btn" data-status="geleverd">Geleverd</button>
                <button class="filter-btn" data-status="geannuleerd">Geannuleerd</button>
            </div>

            <div class="search-input">
                <i class="ti ti-search"></i>
                <input type="text" id="orderSearch" placeholder="Zoek op naam of ordernummer...">
            </div>
        </div>

        <div class="orders-table-wrapper">
            <table class="orders-table">
                <thead>
                <tr>
                    <th>Order</th>
                    <th>Klant</th>
                    <th>Datum</th>
                    <th>Items</th>
                    <th>Bedrag</th>
                    <th>Status</th>
                    <th class="col-actions"></th>
                </tr>
                </thead>
                <tbody id="ordersTableBody">
                <!-- Rows injected by adminOrders.js -->
                </tbody>
            </table>
        </div>
    </main>

</div>

<script src="/admin/js/adminOrders.js"></script>
</body>
</html>