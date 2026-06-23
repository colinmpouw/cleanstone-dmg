<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Bundels</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminBundles.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<!-- MAIN -->
<div class="main">
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
    <!-- CONTENT -->
    <main class="content">
        <div class="bundles-heading">
            <div>
                <h1>Bundels</h1>
                <p id="bundleCount">— actieve bundels</p>
            </div>
            <button class="btn-new-bundle" id="newBundleBtn">
                <i class="ti ti-plus"></i>
                Nieuwe bundel
            </button>
        </div>

        <div class="bundles-grid" id="bundlesGrid">
            <!-- Cards injected by adminBundles.js -->
        </div>
    </main>
</div>

<script src="/admin/js/adminBundles.js"></script>
</body>
</html>