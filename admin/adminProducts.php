<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Producten</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminProducts.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<!-- MAIN -->
<div class="main">
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
    <!-- CONTENT -->
    <main class="content">
        <div class="products-heading">
            <div>
                <h1>Producten</h1>
                <p id="productCount">— producten in totaal</p>
            </div>
            <button class="btn-new-product" id="newProductBtn">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M6 12H18M12 6V18" stroke="var(--white)" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"></path>
                    </g>
                </svg>
                Nieuw product
            </button>
        </div>

        <div class="products-toolbar">
            <div class="search-input">
                <i class="ti ti-search"></i>
                <input type="text" id="productSearch" placeholder="Zoek producten...">
            </div>
            <button class="btn-filter" id="filterBtn">
                <i class="ti ti-filter"></i>
                Filter
                <i class="ti ti-chevron-down"></i>
            </button>
        </div>

        <div class="products-table-wrapper">
            <table class="products-table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Categorie</th>
                    <th>Prijs</th>
                    <th>Voorraad</th>
                    <th>Status</th>
                    <th class="col-actions"></th>
                </tr>
                </thead>
                <tbody id="productsTableBody">
                <!-- Rows injected by adminProducts.js -->
                </tbody>
            </table>
        </div>
    </main>
</div>

<script src="/admin/js/adminProducts.js"></script>
</body>
</html>