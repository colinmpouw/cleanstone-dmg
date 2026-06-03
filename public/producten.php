<?php
if (!isset($products, $categories, $brands)) {
    require_once __DIR__ . '/../autoloader.php';
    require_once __DIR__ . '/../controllers/DatabaseController.php';

    $db = new controllers\DatabaseController();

    $products = $db->read(
        "SELECT p.id, p.name, p.price, p.stock, b.name as brand_name FROM products p LEFT JOIN brands b ON p.brand_id = b.id ORDER BY p.id DESC"
    ) ?: [];

    $categories = $db->read("SELECT id, name, slug FROM categories WHERE parent_id IS NULL ORDER BY name") ?: [];
    $brands = $db->read("SELECT id, name FROM brands ORDER BY name") ?: [];
}
?>
<!doctype html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Alle Producten — Cleanstone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/producten.css">

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
                    <input type="search" placeholder="Zoek producten...">
                </div>
                <div class="filter-group">
                    <label>Categorie</label>
                    <ul>
                        <li><a class="active" href="#">Alle</a></li>
                        <?php foreach ($categories as $cat): ?>
                            <li><a href="#"><?php echo htmlspecialchars($cat['name']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="filter-group">
                    <label>Merk</label>
                    <ul>
                        <li><a class="active" href="#">Alle merken</a></li>
                        <?php foreach ($brands as $brand): ?>
                            <li><a href="#"><?php echo htmlspecialchars($brand['name']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <div class="products-grid-wrapper">
                <div class="products-grid-intro">
                    <p><?php echo count($products); ?> producten gevonden</p>
                </div>
                <section class="products-grid">
                <?php foreach ($products as $product): 
                    $stockStatus = (int)$product['stock'] > 0 ? 'Op voorraad' : 'Uitverkocht';
                    $formattedPrice = '€' . number_format($product['price'], 2, ',', '');
                ?>
                    <article class="product-card">
                        <div class="media">
                            <div class="badge"><?php echo htmlspecialchars($stockStatus); ?></div>
                            <img src="https://via.placeholder.com/360x240.png?text=Product"
                                alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <div class="meta">
                            <span class="product-brand"><?php echo htmlspecialchars($product['brand_name'] ?? 'Onbekend'); ?></span>
                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                            <div class="rating">
                                <span class="stars">★★★★☆</span>
                                <span class="rating-value">158</span>
                            </div>
                            <div class="price"><?php echo htmlspecialchars($formattedPrice); ?></div>
                            <button class="<?php echo $stockStatus === 'Uitverkocht' ? 'btn-disabled' : 'btn-primary'; ?>">
                                <?php echo $stockStatus === 'Uitverkocht' ? 'Uitverkocht' : 'In winkelwagen'; ?>
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
                </section>
            </div>
        </div>

        <?php include __DIR__ . '/../component/footer.php'; ?>

    </main>

</body>

</html>