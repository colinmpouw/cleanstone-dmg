<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin - Gebruikers</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminUsers.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<!-- MAIN -->
<div class="main">
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
    <!-- CONTENT -->
    <main class="content">

        <div class="users-heading">
            <div>
                <h1>Gebruikers</h1>
                <p id="userCount">Laden...</p>
            </div>
        </div>

        <div class="users-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="search" id="userSearch" placeholder="Zoek op naam of e-mail...">
        </div>

        <div class="users-list" id="usersList">
            <!-- Rows injected by adminUsers.js -->
        </div>

    </main>
</div>

<script src="/admin/js/adminMain.js"></script>
<script src="/admin/js/adminUsers.js"></script>
</body>
</html>