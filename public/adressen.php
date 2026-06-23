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
    <title>adressen — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/sidebarAccount.css">
    <link rel="stylesheet" href="/public/css/adressen.css">
</head>

<div class="modal-overlay" id="addressModal">

    <div class="address-modal">

        <div class="modal-header">
            <h2 id="modal-title">Nieuw adres toevoegen</h2>
        </div>

        <form id="addr-form">
            <div class="form-row">
                <div class="form-group">
                    <label>Voornaam <span style="color:red">*</span></label>
                    <input type="text" id="addr-first-name" placeholder="Jan">
                </div>
                <div class="form-group">
                    <label>Achternaam <span style="color:red">*</span></label>
                    <input type="text" id="addr-last-name" placeholder="Jansen">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Straat <span style="color:red">*</span></label>
                    <input type="text" id="addr-street" placeholder="Hoofdstraat">
                </div>
                <div class="form-group">
                    <label>Huisnummer <span style="color:red">*</span></label>
                    <input type="text" id="addr-house-number" placeholder="12">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Postcode <span style="color:red">*</span></label>
                    <input type="text" id="addr-postal-code" placeholder="1234 AB">
                </div>
                <div class="form-group">
                    <label>Stad <span style="color:red">*</span></label>
                    <input type="text" id="addr-city" placeholder="Amsterdam">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Land <span style="color:red">*</span></label>
                    <input type="text" id="addr-country" placeholder="Nederland" value="Nederland">
                </div>
                <div class="form-group">
                    <label>Telefoonnummer <span style="color:red">*</span></label>
                    <input type="tel" id="addr-phone" placeholder="06 12345678">
                </div>
            </div>

            <div class="form-group">
                <label>E-mailadres <span style="color:red">*</span></label>
                <input type="email" id="addr-email" placeholder="uw@email.nl">
            </div>

            <label class="checkbox">
                <input type="checkbox" id="addr-default">
                Instellen als standaard bezorgadres
            </label>

            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeModal()">Annuleren</button>
                <button type="button" class="save-btn" id="save-address-btn">Toevoegen</button>
            </div>
        </form>

    </div>

</div>
<body>

<?php require_once __DIR__ . '/../component/header.php'; ?>

<div class="account-layout">

    <?php require_once __DIR__ . '/../component/sidebarAccount.php'; ?>

    <main class="addresses-main">

        <div class="addresses-header">
            <h1>Mijn adressen</h1>

            <button class="new-address-btn" id="openModal">
                + Nieuw adres
            </button>
        </div>

        <div class="addresses-container" id="addresses-container">
            <!-- dynamisch -->
        </div>

    </main>

</div>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>

<script src="/public/js/AiChat.js"></script>
<script src="/public/js/adressen.js"></script>

</body>
</html>