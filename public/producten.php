<?php
if (!isset($products, $categories, $brands)) {
    require_once __DIR__ . '/../autoloader.php';
    require_once __DIR__ . '/../controllers/DatabaseController.php';

    $db = new controllers\DatabaseController();
    $categories = $db->read("SELECT id, name, slug FROM categories WHERE parent_id IS NULL ORDER BY name") ?: [];
    $brands = $db->read("SELECT id, name FROM brands ORDER BY name") ?: [];
}
?>
<!doctype html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cleanstone -Producten</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/producten.css">
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">

</head>

<body>
    <?php include __DIR__ . '/../component/header.php'; ?>

    <main class="products-page">
                <div class="page-title">
                    <h1>Alle Producten</h1>
                    <p class="hero-copy">Premium onderhoudsmiddelen voor natuursteen van de beste merken</p>
                </div>

        <div class="container products-layout">
            <aside class="filters">
                <h3>Filters</h3>
                <div class="filter-group">
                    <label>Zoeken</label>
                    <input id="product-search" type="search" placeholder="Zoek producten...">
                </div>
                <div class="filter-group">
                    <label>Categorie</label>
                    <ul>
                        <li><a class="active" href="#" data-category="all">Alle</a></li>
                        <?php foreach ($categories as $cat): ?>
                            <li><a href="#" data-category="<?php echo htmlspecialchars($cat['slug']); ?>"><?php echo htmlspecialchars($cat['name']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="filter-group">
                    <label>Merk</label>
                    <ul>
                        <li><a class="active" href="#" data-brand="all">Alle merken</a></li>
                        <?php foreach ($brands as $brand): ?>
                            <li><a href="#" data-brand="<?php echo htmlspecialchars($brand['name']); ?>"><?php echo htmlspecialchars($brand['name']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <div class="products-grid-wrapper">
                <div class="products-grid-intro">
                    <p id="product-count">Laden...</p>
                </div>
                <section id="products-grid" class="products-grid"></section>
            </div>
        </div>



    </main>

    <?php require_once __DIR__ . '/../component/aiChat.php'; ?>
    <?php include __DIR__ . '/../component/footer.php'; ?>
    <script src="/public/js/AiChat.js"></script>
    <script src="/public/js/producten.js"></script>
</body>

</html>