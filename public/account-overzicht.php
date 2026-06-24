<?php
$user = $_SESSION['user'] ?? null;
if (!$user) {
    header('Location: /login');
    exit;
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mijn Account — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/auth.css">
    <link rel="stylesheet" href="/public/css/account-overzicht.css">
    <link rel="stylesheet" href="/public/css/sidebarAccount.css">
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<div class="account-layout">

    <?php require_once __DIR__ . '/../component/sidebarAccount.php'; ?>

    <!-- MAIN -->
    <main class="account-main">
        <h1>Mijn Account</h1>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-card__top">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    </svg>
                    <span class="stat-card__num" id="stat-orders">—</span>
                </div>
                <span class="stat-card__label">Bestellingen</span>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    <span class="stat-card__num" id="stat-advies">—</span>
                </div>
                <span class="stat-card__label">Adviesaanvraag</span>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span class="stat-card__num" id="stat-messages">—</span>
                </div>
                <span class="stat-card__label">Totaal berichten</span>
            </div>
        </div>

        <!-- Alert banner -->
        <div class="alert-banner" id="alert-banner" style="display:none;">
            <h2 id="alert-title"></h2>
            <p>Onze specialist bekijkt uw aanvraag. U ontvangt binnen 24 uur een reactie.</p>
            <button class="alert-banner__btn" id="alert-btn">Bekijk adviesaanvraag</button>
        </div>

        <!-- Recente bestellingen -->
        <div class="bestellingen-card">
            <h2>Recente bestellingen</h2>
            <div class="bestelling-list" id="bestelling-list">
                <p style="color: var(--rustic-taupe); font-size: 0.88rem;">Laden...</p>
            </div>
        </div>
    </main>

</div>
<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<script src="/public/js/AiChat.js"></script>
<script src="/public/js/account-overzicht.js"></script>
</body>
</html>
