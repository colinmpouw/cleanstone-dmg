<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Product toevoegen</title>

    <link rel="icon" href="/public/assets/logo_icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminAddProduct.css">
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

            <!-- LEFT -->
            <div class="edit-col-left">

                <!-- MAIN PHOTO -->
                <div class="panel">
                    <div class="panel-header">
                        <h2>Hoofdfoto</h2>
                    </div>

                    <div class="photo-main" id="photoMain">
                        <span class="photo-main-badge">
                            <i class="ti ti-star-filled"></i>
                            Hoofdfoto
                        </span>
                        <img id="photoMainImg" hidden>
                        <div class="photo-main-empty" id="photoMainEmpty">
                            <i class="ti ti-photo"></i>
                            <span>Klik om een hoofdfoto te kiezen</span>
                        </div>
                        <input type="file" id="photoInput" accept="image/*" hidden>
                    </div>
                </div>

                <!-- GALLERY -->
                <div class="panel">
                    <div class="panel-header">
                        <h2>Extra foto's</h2>
                        <span id="photoCount" class="panel-header-meta">0 foto's</span>
                    </div>

                    <div class="photo-thumbs" id="photoThumbs">
                        <label class="photo-thumb photo-thumb--add">
                            <i class="ti ti-plus"></i>
                            <input type="file" id="galleryInput" accept="image/*" multiple hidden>
                        </label>
                    </div>
                </div>

                <!-- RATING (read-only, calculated by DB view) -->
                <div class="panel">
                    <h2>Beoordeling</h2>
                    <div class="rating-display" id="ratingDisplay">
                        <span class="rating-display-stars" id="ratingStars" aria-hidden="true"></span>
                        <span class="rating-display-value" id="ratingValue">—</span>
                        <span class="rating-display-count" id="ratingCount">(0 reviews)</span>
                    </div>
                    <p class="rating-display-note">Wordt automatisch berekend op basis van klantreviews.</p>
                </div>

                <div class="panel">
                    <h2>Tips</h2>
                    <p>
                        Upload duidelijke vierkante foto's (minimaal 800×800 px).
                        De hoofdfoto wordt gebruikt op productpagina's en in productoverzichten,
                        de extra foto's verschijnen in de fotogalerij op de productpagina.
                    </p>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="edit-col-right">

                <!-- BASIS -->
                <div class="panel">
                    <h2>Basisinformatie</h2>

                    <div class="field">
                        <label>Naam</label>
                        <input type="text" name="name" id="productName">
                    </div>

                    <div class="field">
                        <label>Korte beschrijving</label>
                        <input type="text" name="short_description" id="productShortDescription">
                    </div>

                    <div class="field">
                        <label>Beschrijving</label>
                        <textarea name="description" id="productDescription"></textarea>
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label>Merk</label>
                            <select id="productBrand" name="brand_id"></select>
                        </div>

                        <div class="field">
                            <label>Categorie</label>
                            <select id="productCategory" name="category_id"></select>
                        </div>
                    </div>

                    <!-- TAGS -->
                    <div class="field">
                        <label>Tags</label>
                        <div class="tag-select">
                            <div class="tag-select-chips" id="tagChips"></div>
                            <button type="button" class="tag-select-toggle" id="tagSelectToggle">
                                <i class="ti ti-tag"></i>
                                Tags selecteren
                            </button>
                            <div class="tag-select-dropdown" id="tagDropdown" hidden></div>
                        </div>
                    </div>
                </div>

                <!-- PRIJS -->
                <div class="panel">
                    <h2>Prijs</h2>

                    <div class="field-row">
                        <div class="field">
                            <label>Prijs (€)</label>
                            <input type="number" name="price" id="productPrice">
                        </div>

                        <div class="field">
                            <label>Vergelijkprijs</label>
                            <input type="number" name="sale_price" id="productComparePrice">
                        </div>
                    </div>

                    <div class="discount-note" id="discountNote" hidden></div>
                </div>

                <!-- VOORRAAD -->
                <div class="panel">
                    <h2>Voorraad & Status</h2>

                    <div class="field-row">
                        <div class="field">
                            <label>Voorraad</label>
                            <input type="number" name="stock" id="productStock">
                        </div>

                        <div class="field">
                            <label>SKU</label>
                            <input type="text" name="sku" id="productSku">
                        </div>
                    </div>
                </div>

                <!-- FEATURES -->
                <div class="panel">
                    <div class="panel-header">
                        <h2>Belangrijkste kenmerken</h2>
                        <span id="featuresCount" class="panel-header-meta">0 items</span>
                    </div>

                    <div class="list-editor" id="featuresList"></div>

                    <button type="button" class="btn-add-row" id="addFeatureBtn">
                        <i class="ti ti-plus"></i>
                        Kenmerk toevoegen
                    </button>
                </div>

                <!-- SPECIFICATIONS -->
                <div class="panel">
                    <div class="panel-header">
                        <h2>Specificaties</h2>
                        <span id="specsCount" class="panel-header-meta">0 items</span>
                    </div>

                    <div class="list-editor list-editor--spec" id="specsList"></div>

                    <button type="button" class="btn-add-row" id="addSpecBtn">
                        <i class="ti ti-plus"></i>
                        Specificatie toevoegen
                    </button>
                </div>

                <!-- INSTRUCTIONS -->
                <div class="panel">
                    <div class="panel-header">
                        <h2>Gebruiksinstructies</h2>
                        <span id="instructionsCount" class="panel-header-meta">0 stappen</span>
                    </div>

                    <div class="list-editor list-editor--step" id="instructionsList"></div>

                    <button type="button" class="btn-add-row" id="addInstructionBtn">
                        <i class="ti ti-plus"></i>
                        Stap toevoegen
                    </button>
                </div>

            </div>
        </form>

    </main>
</div>

<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminAddProduct.js"></script>

</body>
</html>