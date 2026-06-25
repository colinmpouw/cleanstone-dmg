<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin - Bundel bewerken</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminEditBundle.css">
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
                <a href="/admin/bundels" class="back-link" aria-label="Terug naar bundels">
                    <i class="ti ti-arrow-left"></i>
                </a>
                <div>
                    <h1>Bundel bewerken</h1>
                    <p id="bundleSubtitle">—</p>
                </div>
            </div>
            <div class="edit-heading-actions">
                <a href="/admin/bundels" class="btn-cancel">Annuleren</a>
                <button class="btn-save" id="saveBtn">Opslaan</button>
            </div>
        </div>

        <!-- SKELETON (shown while loading) -->
        <div class="edit-grid skeleton-grid" id="bundleSkeleton">
            <!-- LEFT COLUMN -->
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
                    <div class="skeleton-line" style="width: 40%; height: 18px; margin-bottom: 1.25rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 42px; margin-bottom: 1.25rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 42px;"></div>
                </div>

                <div class="panel">
                    <div class="skeleton-line" style="width: 50%; height: 18px; margin-bottom: 1.25rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 20px; margin-bottom: 0.75rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 20px; margin-bottom: 0.75rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 50px;"></div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="edit-col-right">
                <div class="panel">
                    <div class="skeleton-line" style="width: 35%; height: 18px; margin-bottom: 1.25rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 42px; margin-bottom: 1.25rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 110px; margin-bottom: 1.25rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 42px;"></div>
                </div>

                <div class="panel">
                    <div class="skeleton-line" style="width: 20%; height: 18px; margin-bottom: 1.25rem;"></div>
                    <div class="skeleton-field-row">
                        <div class="skeleton-line" style="height: 42px;"></div>
                        <div class="skeleton-line" style="height: 42px;"></div>
                    </div>
                </div>

                <div class="panel">
                    <div class="skeleton-line" style="width: 45%; height: 18px; margin-bottom: 1.25rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 70px; margin-bottom: 0.85rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 70px; margin-bottom: 0.85rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 70px;"></div>
                </div>

                <div class="panel">
                    <div class="skeleton-line" style="width: 30%; height: 18px; margin-bottom: 1.25rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 50px; margin-bottom: 0.85rem;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 50px;"></div>
                </div>
            </div>
        </div>

        <form id="bundleForm" class="edit-grid" hidden>
            <!-- LEFT COLUMN -->
            <div class="edit-col-left">
                <div class="panel">
                    <div class="panel-header">
                        <h2>Bundelfoto's</h2>
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

                <div class="panel">
                    <h2>Status &amp; identificatie</h2>

                    <div class="field">
                        <label>Status</label>
                        <div class="status-buttons">
                            <button type="button" class="status-btn status-btn--active" data-status="actief">Actief</button>
                            <button type="button" class="status-btn" data-status="concept">Concept</button>
                        </div>
                        <input type="hidden" id="bundleStatus" name="status" value="actief">
                    </div>

                    <div class="field">
                        <label for="bundleSku">SKU / Artikelnummer</label>
                        <input type="text" id="bundleSku" name="sku" placeholder="SKU">
                    </div>

                    <div class="field">
                        <label for="bundleTags">Tags</label>
                        <div class="tag-select" id="tagSelect">
                            <div class="tag-select-chips" id="tagChips">
                                <!-- Selected tags injected by JS -->
                            </div>
                            <input type="text" id="tagSearchInput" placeholder="Tag toevoegen...">
                            <div class="tag-select-dropdown" id="tagDropdown" hidden>
                                <!-- Available tags injected by JS -->
                            </div>
                        </div>
                    </div>
                </div>

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

            <!-- RIGHT COLUMN -->
            <div class="edit-col-right">
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
                        <label for="bundleTags">Tags</label>
                        <input type="text" id="bundleTagsInput" name="bundle_tags" placeholder="Tags gescheiden door komma's">
                    </div>
                </div>

                <div class="panel">
                    <h2>Prijs</h2>

                    <div class="field-row">
                        <div class="field">
                            <label for="bundlePrice">Bundelprijs (€)</label>
                            <input type="number" id="bundlePrice" name="price" step="0.01" min="0" placeholder="0.00">
                        </div>
                        <div class="field">
                            <label for="bundleComparePrice">
                                Originele waarde (€) <span class="field-optional">optioneel</span>
                            </label>
                            <input type="number" id="bundleComparePrice" name="compare_price" step="0.01" min="0" placeholder="0.00">
                        </div>
                    </div>

                    <div class="discount-note" id="discountNote" hidden></div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <h2>Producten in bundel</h2>
                        <button type="button" class="btn-add-product" id="addProductBtn">
                            <i class="ti ti-plus"></i>
                            Product toevoegen
                        </button>
                    </div>

                    <div id="bundleProductsList" class="bundle-products-list">
                        <!-- Products injected by JS -->
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <h2>Hoogtepunten</h2>
                        <button type="button" class="btn-add-highlight" id="addHighlightBtn">
                            <i class="ti ti-plus"></i>
                            Toevoegen
                        </button>
                    </div>

                    <div id="bundleHighlightsList" class="bundle-highlights-list">
                        <!-- Highlights injected by JS -->
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>
<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminEditBundle.js"></script>
</body>
</html>