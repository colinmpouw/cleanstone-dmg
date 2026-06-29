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
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/sidebarAccount.css">
    <link rel="stylesheet" href="/public/css/account-view-bestellingen.css">
    <title>Cleanstone -Bestelling view</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<div class="account-layout">

    <?php require_once __DIR__ . '/../component/sidebarAccount.php'; ?>

    <main class="bestelling-main" id="bestelling-main">
        <!-- Wordt gevuld door JS -->
        <p style="color:var(--rustic-taupe); font-size:0.88rem;">Laden...</p>
    </main>

</div>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<script src="/public/js/AiChat.js"></script>
<script src="/public/js/account-view-bestellingen.js"></script>
</body>
</html>