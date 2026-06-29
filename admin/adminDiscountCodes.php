<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Kortingscodes</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminDiscountCodes.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="main">
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>

    <main class="content">

        <div class="korting-heading">
            <div>
                <h1>Kortingscodes</h1>
                <p id="discount-count">Laden...</p>
            </div>
            <button class="new-code-btn" id="btn-new-code">+ Nieuwe code</button>
        </div>

        <div class="discount-search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="search" id="discount-search" placeholder="Zoek op code...">
        </div>

        <div class="discount-table-wrap">
            <table class="discount-table">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Waarde</th>
                    <th>Min. bestelling</th>
                    <th>Gebruik</th>
                    <th>Geldig t/m</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="discount-tbody">
                <tr><td colspan="8" style="text-align:center;padding:32px;color:var(--rustic-taupe);">Laden...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- MODAL -->
        <div class="modal-overlay" id="discount-modal">
            <div class="discount-modal">
                <div class="modal-header">
                    <h2 id="modal-title">Nieuwe code</h2>
                    <button class="modal-close" onclick="closeModal()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                </div>
                <form id="discount-form" class="discount-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Code *</label>
                            <input type="text" id="f-code" placeholder="WELCOME10" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="f-status">
                                <option value="active">Actief</option>
                                <option value="inactive">Inactief</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Type *</label>
                            <select id="f-type">
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Vast bedrag</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Waarde *</label>
                            <input type="number" id="f-value" placeholder="10" step="0.01" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Min. bestelbedrag</label>
                            <input type="number" id="f-min" placeholder="50.00" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Max. korting</label>
                            <input type="number" id="f-max" placeholder="—" step="0.01">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Gebruikslimiet</label>
                        <input type="number" id="f-limit" placeholder="100">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Startdatum</label>
                            <input type="datetime-local" id="f-start">
                        </div>
                        <div class="form-group">
                            <label>Einddatum</label>
                            <input type="datetime-local" id="f-end">
                        </div>
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
<script src="/admin/js/adminDiscountCodes.js"></script>
</body>
</html>