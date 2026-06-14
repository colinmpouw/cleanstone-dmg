<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adviesaanvraag — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/auth.css">
    <link rel="stylesheet" href="/public/css/show-advies.css">
    <link rel="stylesheet" href="/public/css/sidebarAccount.css">

</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<div class="account-layout">

    <?php require_once __DIR__ . '/../component/sidebarAccount.php'; ?>

    <!-- MAIN -->
    <main class="advies-main">

        <a href="account-overzicht.html" class="back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Terug naar overzicht
        </a>

        <!-- header -->
        <div class="aanvraag-header">
            <div class="aanvraag-header__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div class="aanvraag-header__info">
                <h2>Marmeren aanrechtblad vlekken</h2>
                <div class="aanvraag-header__meta">
                    <span>15 maart 2024 om 14:30</span>
                    <span class="status-pill">In behandeling</span>
                </div>
            </div>
        </div>

        <!-- detail -->
        <div class="aanvraag-detail">
            <h3>Uw aanvraag:</h3>
            <div class="detail-grid">
                <div class="detail-field">
                    <label>Type steen:</label>
                    <strong>Marmer</strong>
                </div>
                <div class="detail-field">
                    <label>Locatie:</label>
                    <strong>Aanrechtblad keuken</strong>
                </div>
            </div>
            <hr class="divider">
            <div class="detail-desc">
                <label>Beschrijving:</label>
                <p>Ik heb olievlekken op mijn marmeren aanrechtblad. Hoe kan ik deze het beste verwijderen zonder de steen te beschadigen?</p>
            </div>
            <div class="foto-count">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                2 foto(s) bijgevoegd
            </div>
        </div>

        <!-- chat -->
        <div class="chat-section">
            <h3>Gesprek met specialist</h3>

            <div class="chat-messages">
                <div class="msg msg--user">
                    <div class="msg__bubble">
                        Ik heb olievlekken op mijn marmeren aanrechtblad. Zie de foto's.
                        <div class="msg__attachment">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            2 foto's
                        </div>
                    </div>
                    <span class="msg__time">14:30</span>
                </div>
            </div>

            <div class="chat-input-row">
                <input class="chat-input" type="text" placeholder="Typ uw bericht...">
                <button class="chat-send">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
            <span class="chat-hint">Druk op Enter om te verzenden</span>
        </div>

    </main>
</div>
<?php require_once __DIR__ . '/../component/footer.php'; ?>

<script>
    // Enter to send
    document.querySelector('.chat-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && this.value.trim()) {
            const messages = document.querySelector('.chat-messages');
            const msg = document.createElement('div');
            msg.className = 'msg msg--user';
            const now = new Date();
            const time = now.getHours() + ':' + String(now.getMinutes()).padStart(2,'0');
            msg.innerHTML = `<div class="msg__bubble">${this.value}</div><span class="msg__time">${time}</span>`;
            messages.appendChild(msg);
            this.value = '';
            messages.scrollTop = messages.scrollHeight;
        }
    });
</script>


</body>
</html>