<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Admin - Categorieën &amp; Tags</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminCategoriesTags.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="main">
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
    <main class="content">

        <div class="ct-heading">
            <h1>Categorieën &amp; Tags</h1>
            <p>Beheer productcategorieën en tags</p>
        </div>

        <!-- TABS -->
        <div class="ct-tabs">
            <button class="ct-tab active" data-tab="categories">Categorieën <span id="cat-count">0</span></button>
            <button class="ct-tab" data-tab="tags">Tags <span id="tag-count">0</span></button>
        </div>

        <!-- CATEGORIES PANEL -->
        <div class="ct-panel" id="panel-categories">
            <div class="ct-panel-header">
                <h2>Categorieën</h2>
                <button class="ct-new-btn" id="btn-new-category">+ Nieuwe categorie</button>
            </div>
            <div class="ct-tree" id="categories-tree">
                <p style="color:var(--rustic-taupe)">Laden...</p>
            </div>
        </div>

        <!-- TAGS PANEL -->
        <div class="ct-panel" id="panel-tags" style="display:none;">
            <div class="ct-panel-header">
                <h2>Tags</h2>
                <button class="ct-new-btn" id="btn-new-tag">+ Nieuwe tag</button>
            </div>
            <div class="ct-tags-grid" id="tags-grid">
                <p style="color:var(--rustic-taupe)">Laden...</p>
            </div>
        </div>

        <!-- CATEGORY MODAL -->
        <div class="modal-overlay" id="category-modal">
            <div class="ct-modal">
                <div class="modal-header">
                    <h2 id="cat-modal-title">Nieuwe categorie</h2>
                    <button class="modal-close" onclick="closeCategoryModal()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                <form id="category-form" class="ct-form">
                    <div class="form-group">
                        <label>Naam *</label>
                        <input type="text" id="cat-name" placeholder="Reinigen" required>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" id="cat-slug" placeholder="reinigen">
                    </div>
                    <div class="form-group">
                        <label>Hoofdcategorie</label>
                        <select id="cat-parent">
                            <option value="">— Geen (hoofdcategorie) —</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cancel-btn" onclick="closeCategoryModal()">Annuleren</button>
                        <button type="submit" class="save-btn">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- TAG MODAL -->
        <div class="modal-overlay" id="tag-modal">
            <div class="ct-modal ct-modal--small">
                <div class="modal-header">
                    <h2 id="tag-modal-title">Nieuwe tag</h2>
                    <button class="modal-close" onclick="closeTagModal()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                <form id="tag-form" class="ct-form">
                    <div class="form-group">
                        <label>Naam *</label>
                        <input type="text" id="tag-name" placeholder="cleaner" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cancel-btn" onclick="closeTagModal()">Annuleren</button>
                        <button type="submit" class="save-btn">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</div>

<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminCategoriesTags.js"></script>
</body>
</html>