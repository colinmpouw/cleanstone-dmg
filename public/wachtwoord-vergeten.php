<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wachtwoord vergeten — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/wachtwoord-vergeten.css">
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<main class="ww-page">
    <div class="ww-card">

        <!-- LOGO -->
        <div class="ww-logo">
            <a href="/home"><img src="/public/assets/logo-cleanstone.png" alt="CleanStone"></a>
        </div>

        <!-- STAP 1: Email -->
        <div id="stap-1">
            <div class="ww-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <h1>Wachtwoord vergeten</h1>
            <p class="ww-desc">Vul uw e-mailadres in om een verificatiecode te ontvangen.</p>

            <div id="stap-1-error" class="ww-error"></div>

            <div class="ww-group">
                <label for="reset-email">E-mailadres</label>
                <div class="ww-input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <input type="email" id="reset-email" placeholder="uw@email.nl">
                </div>
            </div>

            <button id="btn-send-code" class="ww-btn">
                Verstuur code
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
        </div>

        <!-- STAP 2: Code -->
        <div id="stap-2" style="display:none;">
            <div class="ww-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
            </div>
            <h1>Verificatiecode</h1>
            <p class="ww-desc">Voer de 6-cijferige code in die u per e-mail heeft ontvangen.</p>

            <div id="stap-2-error" class="ww-error"></div>

            <!-- 6 losse vakjes -->
            <div class="ww-code-row">
                <input class="code-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                <input class="code-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                <input class="code-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                <input class="code-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                <input class="code-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                <input class="code-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
            </div>

            <!-- hidden input voor JS -->
            <input type="text" id="reset-code" maxlength="6">

            <button id="btn-verify-code" class="ww-btn">
                Bevestig code
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>

            <button class="ww-back" onclick="goBack('stap-2','stap-1')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Terug
            </button>
        </div>

        <!-- STAP 3: Nieuw wachtwoord -->
        <div id="stap-3" style="display:none;">
            <div class="ww-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h1>Nieuw wachtwoord</h1>
            <p class="ww-desc">Kies een nieuw wachtwoord voor uw account.</p>

            <div id="stap-3-error" class="ww-error"></div>

            <div class="ww-group">
                <label for="reset-password">Nieuw wachtwoord</label>
                <div class="ww-input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="reset-password" placeholder="••••••••">
                    <button type="button" class="ww-toggle-pw" onclick="wwToggle('reset-password','eye-3')" tabindex="-1">
                        <svg id="eye-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="ww-group">
                <label for="reset-password-confirm">Herhaal wachtwoord</label>
                <div class="ww-input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="reset-password-confirm" placeholder="••••••••">
                    <button type="button" class="ww-toggle-pw" onclick="wwToggle('reset-password-confirm','eye-4')" tabindex="-1">
                        <svg id="eye-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <button id="btn-reset-password" class="ww-btn">
                Wachtwoord wijzigen
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
        </div>

        <!-- STAP 4: Succes -->
        <div id="stap-4" style="display:none;">
            <div class="ww-success-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h1>Gelukt!</h1>
            <p class="ww-desc">Uw wachtwoord is succesvol gewijzigd. U kunt nu inloggen met uw nieuwe wachtwoord.</p>
            <a href="/login" class="ww-login-link">
                Inloggen
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../component/footer.php'; ?>

<script src="/public/js/wachtwoord-vergeten.js"></script>
</body>
</html>