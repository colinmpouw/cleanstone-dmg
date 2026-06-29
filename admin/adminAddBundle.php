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

        <!-- DIRECT FORM (no skeleton, nothing to fetch) -->
        <form id="bundleForm" class="edit-grid">

            <!-- LEFT -->
            <div class="edit-col-left">

                <!-- FOTO -->
                <div class="panel">
                    <h2>Bundelfoto</h2>

                    <div class="photo-main" id="photoMain">
                        <span class="photo-main-badge">
                            <i class="ti ti-star-filled"></i> Hoofdfoto
                        </span>
                        <img id="photoMainImg" src="" alt="" hidden>
                        <div class="photo-main-empty" id="photoMainEmpty">
                            <i class="ti ti-photo"></i>
                        </div>
                    </div>

                    <input type="file" id="photoInput" accept="image/*" hidden>
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
                            <span>Originele prijs</span>
                            <span id="originalPriceTotal">€ 0,00</span>
                        </div>
                        <div class="price-row price-row--highlight">
                            <span>Bundelprijs</span>
                            <span id="bundlePriceTotal">€ 0,00</span>
                        </div>
                        <div class="price-savings">
                            <span id="savingsText">—</span>
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
                        <label for="bundleName">Naam van de bundel</label>
                        <input type="text" id="bundleName" name="name" placeholder="Bundelnaam">
                    </div>

                    <div class="field">
                        <label for="bundleDescription">Beschrijving</label>
                        <textarea id="bundleDescription" name="description" rows="5" placeholder="Beschrijf de bundel..."></textarea>
                    </div>

                    <div class="field">
                        <label for="bundleTagsInput">Tag</label>
                        <input type="text" id="bundleTagsInput" name="bundle_tags" placeholder="Bijv. Keuken">
                    </div>
                </div>

                <!-- PRIJS -->
                <div class="panel">
                    <h2>Prijs</h2>

                    <div class="field">
                        <label for="bundlePrice">Bundelprijs (€)</label>
                        <input type="number" id="bundlePrice" name="price" step="0.01" min="0" placeholder="0.00">
                    </div>
                </div>

                <!-- PRODUCTEN -->
                <div class="panel">
                    <div class="panel-header">
                        <h2>Producten in bundel</h2>
                        <button type="button" class="btn-add-product" id="addProductBtn">
                            <i class="ti ti-plus"></i>
                            Product toevoegen
                        </button>
                    </div>

                    <div id="bundleProductsList" class="bundle-products-list"></div>
                </div>

            </div>

        </form>

        <!-- PRODUCT PICKER MODAL -->
        <div class="modal-overlay" id="productPickerOverlay" hidden>
            <div class="modal-box" id="productPickerModal" role="dialog" aria-modal="true" aria-labelledby="productPickerTitle">
                <div class="modal-header">
                    <h2 id="productPickerTitle">Product toevoegen</h2>
                    <button type="button" class="modal-close" id="productPickerClose" aria-label="Sluiten">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <div class="modal-search">
                    <i class="ti ti-search"></i>
                    <input type="text" id="productPickerSearch" placeholder="Zoek op naam, SKU of categorie...">
                </div>

                <div class="modal-list" id="productPickerList">
                    <!-- Product results injected by JS -->
                </div>
            </div>
        </div>

    </main>
</div>

<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminAddBundle.js"></script>

</body>
</html>