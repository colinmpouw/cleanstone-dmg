<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/auth.css">
    <link rel="stylesheet" href="/public/css/show-advies.css">
    <link rel="stylesheet" href="/public/css/sidebarAccount.css">
    <title>Cleanstone -Mijn Adviesaanvraag</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<div class="account-layout">

    <?php require_once __DIR__ . '/../component/sidebarAccount.php'; ?>

    <main class="advies-main">

        <a href="/account" class="back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Terug naar overzicht
        </a>

        <?php if (!empty($no_request)): ?>

            <div class="no-requests">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width:48px;height:48px;color:var(--creamy-taupe)"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <p>U heeft nog geen adviesaanvraag ingediend.</p>
                <a href="/advies" class="btn-primary">Advies aanvragen</a>
            </div>

        <?php else: ?>

            <!-- AANVRAAG HEADER -->
            <div class="aanvraag-header">
                <div class="aanvraag-header__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="aanvraag-header__info">
                    <h2 id="adv-title">Laden...</h2>
                    <div class="aanvraag-header__meta">
                        <span id="adv-date"></span>
                        <span id="adv-status" class="status-pill status-pill--behandeling"></span>
                    </div>
                </div>
                <button id="adv-delete" class="adv-delete-btn" title="Aanvraag verwijderen">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                    Verwijderen
                </button>
            </div>

            <!-- DETAIL CARD -->
            <div class="aanvraag-detail">
                <h3>Uw aanvraag</h3>
                <div class="detail-grid">
                    <div class="detail-field">
                        <label>Type steen</label>
                        <strong id="adv-stone-type">—</strong>
                    </div>
                    <div class="detail-field">
                        <label>Locatie</label>
                        <strong id="adv-stone-location">—</strong>
                    </div>
                </div>
                <hr class="divider">
                <div class="detail-desc">
                    <label>Beschrijving</label>
                    <p id="adv-message"></p>
                </div>
                <div class="foto-count">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span id="adv-foto-count">Laden...</span>
                </div>
            </div>

            <!-- CHAT -->
            <div class="chat-section">
                <h3>Gesprek met specialist</h3>
                <div class="chat-messages" id="chat-messages"></div>
                <div class="chat-input-row">
                    <input class="chat-input" id="chat-input" type="text" placeholder="Typ uw bericht...">
                    <button class="chat-send" id="chat-send">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </div>
                <span class="chat-hint">Druk op Enter om te verzenden</span>
            </div>

        <?php endif; ?>

    </main>
</div>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<script src="/public/js/AiChat.js"></script>
<script src="/public/js/show-advies.js"></script>
</body>
</html>