<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/404.css">
    <title>CleanStone -Betaald</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">

    <style>
        main img{
            max-width: 500px;
        }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<main>
    <img src="/public/assets/thankyou.png" alt="thank you">
    <h2>Heel erg bedankt, betaald succesvol</h2>
    <a href="/" class="home-link">Ga terug naar de homepage</a>
</main>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<script src="/public/js/AiChat.js"></script>
</body>
</html>