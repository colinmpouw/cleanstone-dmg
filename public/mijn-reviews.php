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
    <title>Mijn Reviews — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/sidebarAccount.css">
    <link rel="stylesheet" href="/public/css/mijn-reviews.css">
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<div class="account-layout">

    <?php require_once __DIR__ . '/../component/sidebarAccount.php'; ?>

    <main class="reviews-main">

        <div class="reviews-header">
            <h1>Mijn reviews</h1>
            <p id="review-count">Laden...</p>
        </div>
        <div class="review-list" id="review-list"></div>

    </main>

</div>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<script src="/public/js/AiChat.js"></script>
<script src="/public/js/mijn-reviews.js"></script>
</body>
</html>