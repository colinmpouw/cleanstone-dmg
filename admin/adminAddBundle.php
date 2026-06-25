<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Bundel toevoegen</title>

    <link rel="icon" href="/public/assets/logo_icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminAddBundle.css">
</head>

<body>

<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="main">
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>

    <main class="content">

        <!-- HEADER -->
        <div class="edit-heading">
            <div class="edit-heading-left">
                <div>
                    <h1>Bundel toevoegen</h1>
                    <p>Nieuwe bundel aanmaken</p>
                </div>
            </div>

            <div class="edit-heading-actions">
                <a href="/admin/bundels" class="btn-cancel">Annuleren</a>
                <button class="btn-save" id="saveBtn">Opslaan</button>
            </div>
        </div>

        <!-- ✅ DIRECT FORM (no skeleton) -->
        <form id="bundleForm" class="edit-grid">

            <!-- LEFT -->
            <div class="edit-col-left">

                <!-- FOTO -->
                <div class="panel">
                    <div class="panel-header">
                        <h2>Bundelfoto</h2>
                        <span id="photoCount" class="panel-header-meta">1 foto</span>
                    </div>

                    <div class="photo-main" id="photoMain">
                    <span class="photo-main-badge">
                        <i class="ti ti-star-filled"></i> Hoofdfoto
                    </span>
                        <img id="photoMainImg" hidden>
                        <div class="photo-main-empty" id="photoMainEmpty">
                            <i class="ti ti-photo"></i>
                        </div>
                    </div>

                    <input type="file" id="photoInput" accept="image/*" hidden>
                </div>

                <!-- STATUS -->
                <div class="panel">
                    <h2>Status & identificatie</h2>

                    <div class="field">
                        <label>Status</label>
                        <div class="status-buttons">
                            <button type="button" class="status-btn status-btn--active" data-status="actief">Actief</button>
                            <button type="button" class="status-btn" data-status="concept">Concept</button>
                        </div>
                        <input type="hidden" id="bundleStatus" value="actief">
                    </div>

                    <div class="field">
                        <label>SKU</label>
                        <input type="text" id="bundleSku">
                    </div>
                </div>

                <!-- PRICE OVERVIEW -->
                <div class="panel">
                    <h2>Prijsoverzicht</h2>

                    <div class="price-overview">
                        <div class="price-row">
                            <span>Waarde producten</span>
                            <span id="productValueTotal">€ 0,00</span>
                        </div>
                        <div class="price-row">
                            <span>Origineel</span>
                            <span id="originalPriceTotal">€ 0,00</span>
                        </div>
                        <div class="price-row price-row--highlight">
                            <span>Bundelprijs</span>
                            <span id="bundlePriceTotal">€ 0,00</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="edit-col-right">

                <!-- BASIS -->
                <div class="panel">
                    <h2>Basisinformatie</h2>

                    <div class="field">
                        <label>Naam</label>
                        <input type="text" id="bundleName">
                    </div>

                    <div class="field">
                        <label>Beschrijving</label>
                        <textarea id="bundleDescription"></textarea>
                    </div>
                </div>

                <!-- PRIJS -->
                <div class="panel">
                    <h2>Prijs</h2>

                    <div class="field-row">
                        <div class="field">
                            <label>Bundelprijs</label>
                            <input type="number" id="bundlePrice">
                        </div>
                        <div class="field">
                            <label>Vergelijkprijs</label>
                            <input type="number" id="bundleComparePrice">
                        </div>
                    </div>
                </div>

                <!-- PRODUCTEN -->
                <div class="panel">
                    <div class="panel-header">
                        <h2>Producten</h2>
                        <button type="button" class="btn-add-product" id="addProductBtn">
                            <i class="ti ti-plus"></i> Toevoegen
                        </button>
                    </div>

                    <div id="bundleProductsList" class="bundle-products-list"></div>
                </div>

                <!-- HIGHLIGHTS -->
                <div class="panel">
                    <div class="panel-header">
                        <h2>Hoogtepunten</h2>
                        <button type="button" class="btn-add-highlight" id="addHighlightBtn">
                            <i class="ti ti-plus"></i> Toevoegen
                        </button>
                    </div>

                    <div id="bundleHighlightsList" class="bundle-highlights-list"></div>
                </div>

            </div>

        </form>

    </main>
</div>

<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminAddBundle.js"></script>

</body>
</html>
