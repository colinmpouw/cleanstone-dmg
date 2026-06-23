<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Product bewerken</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">

    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminAddProduct.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<!-- MAIN -->
<div class="main">
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
    <!-- CONTENT -->
    <main class="content">
        <div class="edit-heading">
            <div class="edit-heading-left">
                <a href="/admin/producten" class="back-link" aria-label="Terug naar producten">
                    <i class="ti ti-arrow-left"></i>
                </a>
                <div>
                    <h1>Product toevoegen</h1>
                    <p>Nieuw product aanmaken</p>
                </div>
            </div>
            <div class="edit-heading-actions">
                <a href="/admin/producten" class="btn-cancel">Annuleren</a>
                <button class="btn-save" id="saveBtn">Opslaan</button>
            </div>
        </div>

        <form id="productForm" class="edit-grid">
            <!-- LEFT COLUMN -->
            <div class="edit-col-left">
                <div class="panel">
                    <div class="panel-header">
                        <h2>Productfoto's</h2>
                        <span id="photoCount" class="panel-header-meta">0 foto's</span>
                    </div>

                    <div class="photo-main" id="photoMain">
                        <span class="photo-main-badge">
                            <i class="ti ti-star-filled"></i>
                            Hoofdfoto
                        </span>
                        <img id="photoMainImg" src="" alt="" hidden>
                        <div class="photo-main-empty" id="photoMainEmpty">
                            <i class="ti ti-photo"></i>
                        </div>
                    </div>

                    <div class="photo-thumbs" id="photoThumbs">
                        <!-- Existing photo thumbnails injected by JS -->
                        <label class="photo-thumb photo-thumb--add" id="photoAddTile">
                            <i class="ti ti-plus"></i>
                            <input type="file" id="photoInput" accept="image/*" multiple hidden>
                        </label>
                    </div>
                </div>

                <div class="tips-box">
                    <h3>Tips voor productfoto's</h3>
                    <p>De eerste foto wordt de hoofdfoto. Gebruik vierkante beelden van minimaal 800×800px voor de beste weergave in de webshop.</p>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="edit-col-right">
                <div class="panel">
                    <h2>Basisinformatie</h2>

                    <div class="field">
                        <label for="productName">Productnaam</label>
                        <input type="text" id="productName" name="name" placeholder="Productnaam">
                    </div>

                    <div class="field">
                        <label for="productDescription">Beschrijving</label>
                        <textarea id="productDescription" name="description" rows="5" placeholder="Beschrijf het product..."></textarea>
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label for="productBrand">Merk</label>
                            <select id="productBrand" name="brand_id">
                                <option value="">Selecteer merk</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="productCategory">Categorie</label>
                            <select id="productCategory" name="category_id">
                                <option value="">Selecteer categorie</option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <label for="tagSearchInput">Tags</label>
                        <div class="tag-select" id="tagSelect">
                            <div class="tag-select-chips" id="tagChips">
                                <!-- Selected tag chips injected by JS -->
                            </div>
                            <input type="text" id="tagSearchInput" placeholder="Tag toevoegen...">
                            <div class="tag-select-dropdown" id="tagDropdown" hidden>
                                <!-- Available tag options injected by JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h2>Prijs</h2>

                    <div class="field-row">
                        <div class="field">
                            <label for="productPrice">Verkoopprijs (€)</label>
                            <input type="number" id="productPrice" name="price" step="0.01" min="0" placeholder="0.00">
                        </div>
                        <div class="field">
                            <label for="productComparePrice">
                                Vergelijkprijs (€) <span class="field-optional">optioneel</span>
                            </label>
                            <input type="number" id="productComparePrice" name="sale_price" step="0.01" min="0" placeholder="0.00">
                        </div>
                    </div>

                    <div class="discount-note" id="discountNote" hidden></div>
                </div>

                <div class="panel">
                    <h2>Voorraad &amp; status</h2>

                    <div class="field-row">
                        <div class="field">
                            <label for="productStock">Voorraad (stuks)</label>
                            <input type="number" id="productStock" name="stock" min="0" step="1" placeholder="0">
                        </div>
                        <div class="field">
                            <label for="productSku">SKU / Artikelnummer</label>
                            <input type="text" id="productSku" name="sku" placeholder="SKU">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<script src="/admin/js/adminAddProduct.js"></script>
</body>
</html>