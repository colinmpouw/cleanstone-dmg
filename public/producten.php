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
        <section class="products-hero">
            <div class="container">
                <h1>Alle Producten</h1>
                <p class="sub">Premium onderhoudsproducten voor natuursteen van de beste merken</p>
            </div>
        </section>

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
                        <li><a href="#">Alle</a></li>
                        <li><a href="#">Reinigers</a></li>
                        <li><a href="#">Imprengers</a></li>
                        <li><a href="#">Beschermers</a></li>
                    </ul>
                </div>
            </aside>

            <section class="products-grid">
                <?php
                // Voorbeeldproducten; vervang met dynamische inhoud uit database/controller
                $items = [
                    ['title' => 'Lindha XL Oilssealer', 'price' => '€24.95'],
                    ['title' => 'Natural Marble Protector', 'price' => '€39.95'],
                    ['title' => 'Balticwood Klei Stone', 'price' => '€29.95'],
                    ['title' => 'Effektus XL Surface Clean', 'price' => '€34.95'],
                    ['title' => 'Lantana Natural Stone Sealer', 'price' => '€44.95'],
                    ['title' => 'Alessi Multi-Usage', 'price' => '€27.95'],
                ];

                foreach ($items as $i) { ?>
                    <article class="product-card">
                        <div class="media">
                            <div class="badge">Op voorraad</div>
                            <img src="https://via.placeholder.com/360x240.png?text=Product"
                                alt="<?php echo htmlspecialchars($i['title']); ?>">
                        </div>
                        <div class="meta">
                            <h4><?php echo htmlspecialchars($i['title']); ?></h4>
                            <div class="price"><?php echo htmlspecialchars($i['price']); ?></div>
                            <div class="actions">
                                <button class="btn-primary">In winkelwagen</button>
                                <button class="btn-ghost">Meer</button>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </section>
        </div>

        <?php include __DIR__ . '/../component/footer.php'; ?>

    </main>

</body>

</html>