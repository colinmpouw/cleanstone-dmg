<?php
require_once __DIR__ . '/../component/header.php';
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wachtwoord vergeten — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
</head>
<body>

<main>

    <!-- STAP 1: Email -->
    <div id="stap-1">
        <h1>Wachtwoord vergeten</h1>
        <p>Vul uw e-mailadres in om een verificatiecode te ontvangen.</p>

        <input type="email" id="reset-email" placeholder="uw@email.nl">
        <button id="btn-send-code">Verstuur code</button>
        <p id="stap-1-error" style="color:red; display:none;"></p>
    </div>

    <!-- STAP 2: Code -->
    <div id="stap-2" style="display:none;">
        <h1>Verificatiecode</h1>
        <p>Voer de 6-cijferige code in die u per e-mail heeft ontvangen.</p>

        <input type="text" id="reset-code" placeholder="123456" maxlength="6">
        <button id="btn-verify-code">Bevestig code</button>
        <p id="stap-2-error" style="color:red; display:none;"></p>
    </div>

    <!-- STAP 3: Nieuw wachtwoord -->
    <div id="stap-3" style="display:none;">
        <h1>Nieuw wachtwoord</h1>
        <p>Kies een nieuw wachtwoord voor uw account.</p>

        <input type="password" id="reset-password" placeholder="Nieuw wachtwoord">
        <input type="password" id="reset-password-confirm" placeholder="Herhaal wachtwoord">
        <button id="btn-reset-password">Wachtwoord wijzigen</button>
        <p id="stap-3-error" style="color:red; display:none;"></p>
    </div>

    <!-- STAP 4: Succes -->
    <div id="stap-4" style="display:none;">
        <h1>Gelukt!</h1>
        <p>Uw wachtwoord is succesvol gewijzigd.</p>
        <a href="/login">Inloggen</a>
    </div>

</main>

<?php require_once __DIR__ . '/../component/footer.php'; ?>

<script src="/public/js/wachtwoord-vergeten.js"></script>
</body>
</html>