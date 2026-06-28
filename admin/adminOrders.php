<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Bestellingen</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
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
                    <th class="col-actions">Factuur</th>
                    <th class="col-actions">Bekijk</th>
                </tr>
                </thead>
                <tbody id="ordersTableBody">
                <!-- Rows injected by adminOrders.js -->
                </tbody>
            </table>
        </div>

        <!-- Order Detail Panel -->
        <div class="order-detail-overlay" id="orderDetailOverlay" hidden></div>
        <div class="order-detail-panel" id="orderDetailPanel" hidden>
            <div class="panel-header">
                <h2 id="detailOrderNumber">—</h2>
                <button class="panel-close" id="panelCloseBtn" aria-label="Sluiten">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M19.207 6.207a1 1 0 0 0-1.414-1.414L12 10.586 6.207 4.793a1 1 0 0 0-1.414 1.414L10.586 12l-5.793 5.793a1 1 0 1 0 1.414 1.414L12 13.414l5.793 5.793a1 1 0 0 0 1.414-1.414L13.414 12l5.793-5.793z"
                                  fill="var(--charcoal-clay)"></path>
                        </g>
                    </svg>
                </button>
            </div>

            <div class="panel-content">
                <p id="detailOrderDate" class="order-date">—</p>

                <!-- Customer info -->
                <section class="detail-section">
                    <h3>Klantgegevens</h3>
                    <div class="detail-group">
                        <div class="detail-label">Naam</div>
                        <div id="detailCustomerName" class="detail-value">—</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Email</div>
                        <div id="detailCustomerEmail" class="detail-value">—</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Adres</div>
                        <div id="detailCustomerAddress" class="detail-value">—</div>
                    </div>
                </section>

                <!-- Status update -->
                <section class="detail-section">
                    <h3>Status bijwerken</h3>
                    <select id="detailStatusSelect" class="detail-select">
                        <option value="pending">Verwerking</option>
                        <option value="paid">Betaald</option>
                        <option value="processing">Verwerking</option>
                        <option value="shipped">Verzonden</option>
                        <option value="completed">Geleverd</option>
                        <option value="cancelled">Geannuleerd</option>
                    </select>
                </section>

                <!-- Order items -->
                <section class="detail-section">
                    <h3>Orderdetails</h3>
                    <div id="detailOrderItems" class="detail-items">
                        <!-- Items injected by JS -->
                    </div>
                    <div class="detail-total">
                        <span>Totaal</span>
                        <span id="detailOrderTotal">€ 0,00</span>
                    </div>
                </section>
            </div>

            <button class="btn-save-status" id="saveStatusBtn">Status opslaan</button>
        </div>
    </main>

</div>

<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminOrders.js"></script>
</body>
</html>