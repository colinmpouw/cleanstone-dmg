<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Advies</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminAdvice.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="main">
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>

<div class="aanvragen-page">

    <!-- PAGE HEADER -->
    <div class="aanvragen-page__header">
        <h1>Adviesaanvragen</h1>
        <p>2 nieuwe aanvragen wachten op beantwoording</p>
    </div>

    <!-- TABS -->
    <div class="aanvragen-tabs">
        <button class="aanvragen-tab active" data-filter="all">Alle <span id="count-all">0</span></button>
        <button class="aanvragen-tab" data-filter="open">Nieuw <span id="count-open">0</span></button>
        <button class="aanvragen-tab" data-filter="in_behandeling">In behandeling <span id="count-in_behandeling">0</span></button>
        <button class="aanvragen-tab" data-filter="gesloten">Beantwoord <span id="count-gesloten">0</span></button>
    </div>

    <!-- GRID -->
    <div class="aanvragen-grid" id="aanvragen-grid">
        <p>Laden...</p>
    </div>
</div>
</div>
<script src="/admin/js/adminAdvice.js"></script>

</body>
</html>