<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin - Kortingscodes</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminMerken.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="main">
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
<main class="content">
    <div class="merken-heading">
        <div>
            <h1>Merken</h1>
            <p id="merken-count">Laden...</p>
        </div>
        <button class="new-merk-btn" id="btn-new-merk">+ Nieuw merk</button>
    </div>

    <div class="merken-grid" id="merken-grid">
        <p style="color:var(--rustic-taupe)">Laden...</p>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay" id="merk-modal">
        <div class="merk-modal">
            <div class="modal-header">
                <h2 id="modal-title">Nieuw merk</h2>
                <button class="modal-close" onclick="closeModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="merk-form" class="merk-form">
                <div class="form-group">
                    <label>Naam *</label>
                    <input type="text" id="f-name" placeholder="Lithofin" required>
                </div>
                <div class="form-group">
                    <label>Beschrijving</label>
                    <input type="text" id="f-discription" placeholder="Marktleider in steenonderhoud">
                </div>
                <div class="form-group">
                    <label>Logo</label>
                    <div class="logo-upload-zone" id="logo-upload-zone">
                        <img id="logo-preview" src="" alt="" style="display:none; max-height:60px; object-fit:contain;">
                        <div id="logo-upload-placeholder">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            <span>Klik om logo te uploaden</span>
                        </div>
                        <input type="file" id="f-logo-file" accept="image/*" style="display:none;">
                    </div>
                    <input type="hidden" id="f-logo">
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel-btn" onclick="closeModal()">Annuleren</button>
                    <button type="submit" class="save-btn">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</main>
</div>

<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminMerken.js"></script>
</body>
</html>