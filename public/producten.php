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
                    <p class="eyebrow">Onze selectie</p>
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
                        <li><a href="#">Reinigers</a></li>
                        <li><a href="#">Bescherming</a></li>
                        <li><a href="#">Intensieve reiniging</a></li>
                        <li><a href="#">Vlekverwijdering</a></li>
                        <li><a href="#">Onderhoud</a></li>
                    </ul>
                </div>
                <div class="filter-group">
                    <label>Merk</label>
                    <ul>
                        <li><a class="active" href="#">Alle merken</a></li>
                        <li><a href="#">Lithofin</a></li>
                        <li><a href="#">Akemi</a></li>
                        <li><a href="#">Bellinzoni</a></li>
                        <li><a href="#">Lantania</a></li>
                    </ul>
                </div>
            </aside>

            <div class="products-grid-wrapper">
                <div class="products-grid-intro">
                    <p>8 producten gevonden</p>
                </div>
                <section class="products-grid">
                <?php
                // Voorbeeldproducten; vervang met dynamische inhoud uit database/controller
                $items = [
                    ['brand' => 'Lithofin', 'title' => 'Lindha XL Oilssealer', 'price' => '€24.95', 'rating' => '4.8', 'reviews' => '158', 'stock' => 'Op voorraad'],
                    ['brand' => 'Akemi', 'title' => 'Akemi Marble Protector', 'price' => '€39.95', 'rating' => '4.9', 'reviews' => '234', 'stock' => 'Op voorraad'],
                    ['brand' => 'Bellinzoni', 'title' => 'Bellinzoni Idea Stone', 'price' => '€29.95', 'rating' => '4.7', 'reviews' => '189', 'stock' => 'Op voorraad'],
                    ['brand' => 'Lithofin', 'title' => 'Lithofin KF Intense Clean', 'price' => '€34.95', 'rating' => '4.9', 'reviews' => '298', 'stock' => 'Op voorraad'],
                    ['brand' => 'Lantania', 'title' => 'Lantania Natural Stone Sealer', 'price' => '€44.95', 'rating' => '4.8', 'reviews' => '167', 'stock' => 'Op voorraad'],
                    ['brand' => 'Akemi', 'title' => 'Akemi Anti-Drop', 'price' => '€27.95', 'rating' => '4.7', 'reviews' => '143', 'stock' => 'Uitverkocht'],
                    ['brand' => 'Lithofin', 'title' => 'Lithofin POLISH CREAM', 'price' => '€32.95', 'rating' => '4.9', 'reviews' => '412', 'stock' => 'Op voorraad'],
                    ['brand' => 'Bellinzoni', 'title' => 'Bellinzoni Cera Gel', 'price' => '€38.95', 'rating' => '4.8', 'reviews' => '198', 'stock' => 'Op voorraad'],
                ];

                foreach ($items as $i) { ?>
                    <article class="product-card">
                        <div class="media">
                            <div class="badge"><?php echo htmlspecialchars($i['stock']); ?></div>
                            <img src="https://via.placeholder.com/360x240.png?text=Product"
                                alt="<?php echo htmlspecialchars($i['title']); ?>">
                        </div>
                        <div class="meta">
                            <span class="product-brand"><?php echo htmlspecialchars($i['brand']); ?></span>
                            <h4><?php echo htmlspecialchars($i['title']); ?></h4>
                            <div class="rating">
                                <span class="stars">★★★★☆</span>
                                <span class="rating-value"><?php echo htmlspecialchars($i['reviews']); ?></span>
                            </div>
                            <div class="price"><?php echo htmlspecialchars($i['price']); ?></div>
                            <button class="<?php echo $i['stock'] === 'Uitverkocht' ? 'btn-disabled' : 'btn-primary'; ?>">
                                <?php echo $i['stock'] === 'Uitverkocht' ? 'Uitverkocht' : 'In winkelwagen'; ?>
                            </button>
                        </div>
                    </article>
                <?php } ?>
                </section>
            </div>
        </div>

        <?php include __DIR__ . '/../component/footer.php'; ?>

    </main>

</body>

</html>