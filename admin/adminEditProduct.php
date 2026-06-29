<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin - Product bewerken</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminEditProduct.css">
</head>
<body>

<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="main">
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>

    <main class="content">

        <!-- HEADER -->
        <div class="edit-heading">
            <div class="edit-heading-left">
                <a href="/admin/producten" class="back-link">
                    <i class="ti ti-arrow-left"></i>
                </a>
                <div>
                    <h1>Product bewerken</h1>
                    <p id="productSubtitle">—</p>
                </div>
            </div>

            <div class="edit-heading-actions">
                <a href="/admin/producten" class="btn-cancel">Annuleren</a>
                <button class="btn-save" id="saveBtn">Opslaan</button>
            </div>
        </div>

        <!-- ✅ SKELETON -->
        <div class="edit-grid skeleton-grid" id="productSkeleton">
            <div class="edit-col-left">
                <div class="panel">
                    <div class="skeleton-photo-main"></div>
                    <div class="skeleton-thumbs">
                        <div class="skeleton-thumb"></div>
                        <div class="skeleton-thumb"></div>
                        <div class="skeleton-thumb"></div>
                        <div class="skeleton-thumb"></div>
                    </div>
                </div>

                <div class="panel">
                    <div class="skeleton-line" style="height: 70px;"></div>
                </div>
            </div>

            <div class="edit-col-right">
                <div class="panel">
                    <div class="skeleton-line" style="height: 42px; margin-bottom:1rem;"></div>
                    <div class="skeleton-line" style="height:110px; margin-bottom:1rem;"></div>
                    <div class="skeleton-line" style="height:42px;"></div>
                </div>

                <div class="panel">
                    <div class="skeleton-field-row">
                        <div class="skeleton-line" style="height:42px;"></div>
                        <div class="skeleton-line" style="height:42px;"></div>
                    </div>
                </div>

                <div class="panel">
                    <div class="skeleton-field-row">
                        <div class="skeleton-line" style="height:42px;"></div>
                        <div class="skeleton-line" style="height:42px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ FORM -->
        <form id="productForm" class="edit-grid" hidden>

            <!-- LEFT -->
            <div class="edit-col-left">

                <!-- PHOTO GALLERY -->
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
                        <img id="photoMainImg" hidden>
                        <div class="photo-main-empty" id="photoMainEmpty">
                            <i class="ti ti-photo"></i>
                        </div>
                    </div>

                    <!-- ✅ Gallery thumbnails: existing images[] + newly added uploads.
                         Click a thumb to make it primary; × removes it. -->
                    <div class="photo-thumbs" id="photoThumbs">
                        <label class="photo-thumb photo-thumb--add">
                            <i class="ti ti-plus"></i>
                            <input type="file" id="photoInput" accept="image/*" multiple hidden>
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
                    <p>Gebruik vierkante foto's (≥800×800px). Eerste foto is hoofdfoto.</p>
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

                    <!-- TAGS (your system) -->
                    <div class="field">
                        <label>Tags</label>
                        <div class="tag-select">
                            <div class="tag-select-chips" id="tagChips"></div>
                            <input type="text" id="tagSearchInput">
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

                <!-- ✅ FEATURES (Belangrijkste kenmerken) -->
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

                <!-- ✅ SPECIFICATIONS -->
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

                <!-- ✅ INSTRUCTIONS (Gebruiksinstructies) -->
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
<script src="/admin/js/adminEditProduct.js"></script>

</body>
</html>