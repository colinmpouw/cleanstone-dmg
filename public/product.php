<?php
if (!isset($product)) {
    http_response_code(404);
    require_once __DIR__ . '/../autoloader.php';
    header('Location: /');
    exit;
}

$price = $product['sale_price'] ?? $product['price'];
$originalPrice = $product['price'];
$discount = $product['sale_price'] ? round(100 - ($price / $originalPrice * 100)) : 0;
$averageRating = $rating['average_rating'] ?? 0;
$reviewCount = $rating['review_count'] ?? 0;
?>
<!doctype html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo htmlspecialchars($product['name']); ?> — Cleanstone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/product.css">
</head>

<body>
    <?php include __DIR__ . '/../component/header.php'; ?>

    <main class="product-detail-page">
        <div class="container product-layout">
            <!-- Back Link -->
            <div class="back-link">
                <a href="javascript:history.back()">← Terug naar producten</a>
            </div>

            <div class="product-content">
                <!-- Product Images -->
                <?php
    $defaultImage = $product['image'] ? '/public/assets/' . ltrim($product['image'], '/') : '/public/assets/placeholder.jpg';
    $mainImage = $defaultImage;
    if (!empty($images)) {
        $mainImage = '/public/assets/' . ltrim($images[0]['image'], '/');
    }
    ?>
    <div class="product-images">
        <div class="main-image-container">
            <img id="mainImage" src="<?php echo htmlspecialchars($mainImage); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="main-image">
            <?php if ($discount > 0): ?>
                <div class="discount-badge">-<?php echo $discount; ?>%</div>
            <?php endif; ?>
        </div>
        <div class="thumbnail-gallery">
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $index => $img): ?>
                    <div class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" onclick="changeImage(this)">
                        <img src="/public/assets/<?php echo htmlspecialchars($img['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="thumbnail active" onclick="changeImage(this)">
                    <img src="<?php echo htmlspecialchars($defaultImage); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
            <?php endif; ?>
        </div>
    </div>

                <!-- Product Info -->
                <div class="product-info">
                    <div class="product-header">
                        <div class="brand-category">
                            <?php if ($product['brand_name']): ?>
                                <span class="brand"><?php echo htmlspecialchars($product['brand_name']); ?></span>
                            <?php endif; ?>
                        </div>
                        <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                    </div>

                    <!-- Rating -->
                    <div class="rating-section">
                        <div class="stars">
                            <?php
                            $fullRating = floor($averageRating);
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < $fullRating) {
                                    echo '<span class="star filled">★</span>';
                                } else {
                                    echo '<span class="star">★</span>';
                                }
                            }
                            ?>
                        </div>
                        <span class="rating-text"><?php echo number_format($averageRating, 1, '.', ''); ?> (<?php echo $reviewCount; ?> reviews)</span>
                    </div>

                    <!-- Price -->
                    <div class="price-section">
                        <span class="current-price">€<?php echo number_format($price, 2, ',', '.'); ?></span>
                        <?php if ($discount > 0): ?>
                            <span class="original-price">€<?php echo number_format($originalPrice, 2, ',', '.'); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Description -->
                    <p class="product-description">
                        <?php echo htmlspecialchars($product['short_description'] ?? $product['description'] ?? 'Zachte en effectieve reiniging voor natuursteen, verwijdert vuil en vet zonder de beschermlaag aan te tasten.'); ?>
                    </p>

                    <!-- Important Characteristics -->
                    <?php if (!empty($features)): ?>
                        <div class="important-features">
                            <h3>Belangrijkste kenmerken:</h3>
                            <ul class="features-list">
                                <?php foreach ($features as $feature): ?>
                                    <li>
                                        <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <span><?php echo htmlspecialchars($feature['feature']); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Stock Status -->
                    <div class="stock-status">
                        <?php if ($product['stock'] > 0): ?>
                            <span class="in-stock">✓ In voorraad</span>
                        <?php else: ?>
                            <span class="out-of-stock">Niet beschikbaar</span>
                        <?php endif; ?>
                    </div>

                    <!-- Actions -->
                    <div class="product-actions">
                        <div class="quantity-selector">
                            <button class="qty-btn" onclick="decreaseQty()">−</button>
                            <input type="number" id="quantity" min="1" value="1" readonly>
                            <button class="qty-btn" onclick="increaseQty()">+</button>
                        </div>
                        <button class="btn btn-primary add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>)">
                            <svg class="cart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            In winkelwagen
                        </button>
                        <button class="btn btn-wishlist" onclick="toggleWishlist(<?php echo $product['id']; ?>)">
                            <svg class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Shipping & Returns Info -->
                    <div class="shipping-info">
                        <div class="info-item">
                            <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <div>
                                <strong>Gratis verzending</strong>
                                <p>Voor alle bestellingen</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2m0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8m.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
                            </svg>
                            <div>
                                <strong>30 dagen retour</strong>
                                <p>Geen vragen gesteld</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pre-Order Info -->
                    <div class="pre-order-info">
                        <svg class="info-checkmark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Op voorraad - Vandaag besteld, morgen in huis</span>
                    </div>
                </div>
            </div>

            <?php if (!empty($specifications) || !empty($instructions)): ?>
                <div class="product-panels">
                    <?php if (!empty($specifications)): ?>
                        <section class="product-section specifications-section">
                            <h2>Specificaties</h2>
                            <div class="specifications-grid">
                                <?php foreach ($specifications as $spec): ?>
                                    <div class="spec-item">
                                        <span class="spec-label"><?php echo htmlspecialchars($spec['name']); ?></span>
                                        <span class="spec-value"><?php echo htmlspecialchars($spec['value']); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php if (!empty($instructions)): ?>
                        <section class="product-section instructions-section">
                            <h2>Gebruiksinstructies</h2>
                            <div class="instructions-list">
                                <?php foreach ($instructions as $instruction): ?>
                                    <div class="instruction-item">
                                        <div class="step-number"><?php echo $instruction['step_number']; ?></div>
                                        <div class="step-text"><?php echo htmlspecialchars($instruction['instruction']); ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($reviews)): ?>
                <section class="product-section reviews-section">
                    <h2>Reviews</h2>
                    <div class="reviews-summary">
                        <span class="reviews-score"><?php echo number_format($averageRating, 1, '.', ''); ?> / 5</span>
                        <span class="reviews-count"><?php echo $reviewCount; ?> beoordelingen</span>
                    </div>
                    <div class="reviews-list">
                        <?php foreach ($reviews as $review): ?>
                            <article class="review-item">
                                <div class="review-header">
                                    <div class="review-stars">
                                        <?php
                                            $filledStars = (int) floor($review['rating'] ?? 0);
                                            for ($i = 0; $i < 5; $i++) {
                                                echo '<span class="star' . ($i < $filledStars ? ' filled' : '') . '">★</span>';
                                            }
                                        ?>
                                    </div>
                                    <div class="review-meta">
                                        <span class="review-author"><?php echo htmlspecialchars($review['author'] ?? 'Anoniem'); ?></span>
                                        <time datetime="<?php echo htmlspecialchars($review['created_at']); ?>"><?php echo date('d-m-Y', strtotime($review['created_at'])); ?></time>
                                    </div>
                                </div>
                                <p class="review-text"><?php echo htmlspecialchars($review['review']); ?></p>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../component/footer.php'; ?>

    <script src="/public/js/product.js"></script>
</body>

</html>
