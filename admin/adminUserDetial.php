<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Gebruiker bewerken</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminUserDetail.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="main">
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>

    <main class="content">

        <!-- PAGE HEADING -->
        <div class="user-detail-heading">
            <a href="/admin/gebruikers" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </a>
            <h1>Gebruiker bewerken</h1>
        </div>

        <!-- PROFILE CARD -->
        <div class="ud-card" id="ud-profile-card">
            <div class="ud-avatar" id="ud-avatar"></div>
            <div class="ud-profile-info">
                <strong id="ud-name">Laden...</strong>
                <span id="ud-email"></span>
                <div class="ud-profile-meta">
                    <span class="ud-role-pill" id="ud-role-pill"></span>
                    <div class="ud-meta-date">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span id="ud-since"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- STATS ROW -->
        <div class="ud-stats" id="ud-stats">
            <div class="ud-stat">
                <span class="ud-stat__num" id="stat-orders">—</span>
                <span class="ud-stat__label">Bestellingen</span>
            </div>
            <div class="ud-stat">
                <span class="ud-stat__num" id="stat-advies">—</span>
                <span class="ud-stat__label">Adviesaanvragen</span>
            </div>
            <div class="ud-stat">
                <span class="ud-stat__num" id="stat-reviews">—</span>
                <span class="ud-stat__label">Reviews</span>
            </div>
        </div>

        <!-- EDIT FORM -->
        <div class="ud-card">
            <h2>Gegevens bewerken</h2>

            <form id="ud-form" class="ud-form">

                <div class="ud-field">
                    <label>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Naam
                    </label>
                    <input type="text" id="field-name" name="name" placeholder="Volledige naam">
                </div>

                <div class="ud-field">
                    <label>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        E-mailadres
                    </label>
                    <input type="email" id="field-email" name="email" placeholder="email@example.com">
                </div>

                <div class="ud-field">
                    <label>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.19 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 3.18 2 2 0 0 1 4.11 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Telefoonnummer
                    </label>
                    <input type="tel" id="field-phone" name="phone" placeholder="+31 6 12345678">
                </div>

                <div class="ud-field">
                    <label>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Rol
                    </label>
                    <div class="ud-role-toggle">
                        <button type="button" class="ud-role-btn active" id="role-klant" data-role="klant">Klant</button>
                        <button type="button" class="ud-role-btn" id="role-admin" data-role="admin">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>
                            Admin
                        </button>
                    </div>
                    <input type="hidden" id="field-role" name="role" value="klant">
                </div>

                <div class="ud-field">
                    <label>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Account aangemaakt
                    </label>
                    <input type="text" id="field-created" name="created_at" readonly class="ud-input--readonly">
                </div>

                <div class="ud-form-footer">
                    <button type="submit" class="ud-save-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Opslaan
                    </button>
                </div>
            </form>
        </div>

        <!-- REVIEWS -->
        <div class="ud-card" id="ud-reviews-card">
            <div class="ud-reviews-header">
                <h2>Reviews</h2>
                <span id="ud-review-count" class="ud-review-badge"></span>
            </div>
            <div class="ud-reviews-list" id="ud-reviews-list">
                <p class="ud-empty">Laden...</p>
            </div>
        </div>

    </main>
</div>

<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminUserDetail.js"></script>
</body>
</html>