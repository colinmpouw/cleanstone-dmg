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
                    <div class="skeleton-line" style="height:70px;"></div>
                </div>
            </div>

            <div class="edit-col-right">
                <div class="panel">
                    <div class="skeleton-line" style="height:42px; margin-bottom:1rem;"></div>
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

                    <div class="photo-thumbs">
                        <label class="photo-thumb photo-thumb--add">
                            <i class="ti ti-plus"></i>
                            <input type="file" id="photoInput" hidden>
                        </label>
                    </div>
                </div>

                <div class="panel">
                    <h2>Tips</h2>
                    <p>Gebruik vierkante afbeeldingen (≥800×800px). De eerste foto wordt de hoofdfoto.</p>
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

                <!-- STOCK -->
                <div class="panel">
                    <h2>Voorraad & status</h2>

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

            </div>

        </form>

    </main>
</div>

<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminAddProduct.js"></script>

</body>
</html>
