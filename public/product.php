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
$reviewErrors = $reviewErrors ?? [];
$reviewOld = $reviewOld ?? ['rating' => '', 'review' => ''];
$reviewSuccess = $reviewSuccess ?? '';
$reviewFormOpen = !empty($reviewErrors) || !empty($reviewOld['rating']) || !empty($reviewOld['review']);
$reviewFormStyle = $reviewFormOpen ? 'display: block; margin-top: 1rem;' : 'display: none; margin-top: 1rem;';
$reviewToggleText = $reviewFormOpen ? 'Verberg reviewformulier' : 'Schrijf een review';
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
    $defaultImage = $product['image'] ? '/uploads/products/' . ltrim($product['image'], '/') : '/public/assets/placeholder.jpg';
    $mainImage = $defaultImage;
    if (!empty($images)) {
        $mainImage = '/uploads/products/' . ltrim($images[0]['image'], '/');
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
                    <?php $thumbnailImage = $img['image'] ? '/uploads/products/' . ltrim($img['image'], '/') : $defaultImage; ?>
                    <div class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" onclick="changeImage(this)">
                        <img src="<?php echo htmlspecialchars($thumbnailImage); ?>" alt="<?php echo htmlspecialchars($img['alt_text'] ?: $product['name']); ?>">
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
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= floor($averageRating)): ?>
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81285 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4443 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" fill="#7E6A52" stroke="#7E6A52" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <?php else: ?>
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81284 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4442 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" stroke="#D1D5DC" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <span class="rating-text"><?= number_format($averageRating, 1, '.', '') ?> (<?= $reviewCount ?> reviews)</span>
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

                <section class="product-section reviews-section">
                    <h2>Reviews</h2>
                    <div class="reviews-summary">
                        <span class="reviews-score"><?php echo number_format($averageRating, 1, '.', ''); ?> / 5</span>
                        <span class="reviews-count"><?php echo $reviewCount; ?> beoordelingen</span>
                    </div>

                    <div class="review-submit">
                        <?php if (!empty($reviewSuccess)): ?>
                            <div class="review-success"><?php echo htmlspecialchars($reviewSuccess); ?></div>
                        <?php endif; ?>

                        <?php if (!empty($reviewErrors)): ?>
                            <div class="review-errors">
                                <ul>
                                    <?php foreach ($reviewErrors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($_SESSION['user']['id'])): ?>
                            <button id="toggleReviewForm" class="btn btn-secondary">Schrijf een review</button>
                            <form id="reviewForm" action="/product/<?php echo htmlspecialchars($product['slug']); ?>/review" method="post" class="review-form" style="display: none; margin-top: 1rem;">
                                <label for="rating">Beoordeling</label>
                                <select id="rating" name="rating" required>
                                    <option value="">Kies...</option>
                                    <?php for ($star = 5; $star >= 1; $star--): ?>
                                        <option value="<?php echo $star; ?>" <?php echo isset($reviewOld['rating']) && (int)$reviewOld['rating'] === $star ? 'selected' : ''; ?>><?php echo $star; ?> sterren</option>
                                    <?php endfor; ?>
                                </select>

                                <label for="review">Uw review</label>
                                <textarea id="review" name="review" rows="4" required><?php echo htmlspecialchars($reviewOld['review']); ?></textarea>

                                <button type="submit" class="btn btn-primary">Plaats review</button>
                            </form>
                        <?php else: ?>
                            <p>U moet <a href="/login">inloggen</a> om een review te plaatsen.</p>
                        <?php endif; ?>
                    </div>

                    <div class="reviews-list">
                        <?php if (!empty($reviews)): ?>
                            <?php foreach ($reviews as $review): ?>
                                <article class="review-item">
                                    <div class="review-header">
                                        <div class="review-stars">
                                            <?php
                                            $filledStars = (int) floor($review['rating'] ?? 0);
                                            for ($i = 1; $i <= 5; $i++):
                                                ?>
                                                <?php if ($i <= $filledStars): ?>
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81285 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4442 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" fill="#7E6A52" stroke="#7E6A52" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <?php else: ?>
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81284 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4442 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" stroke="#D1D5DC" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="review-meta">
                                        <span class="review-author"><?php echo htmlspecialchars($review['author'] ?? 'Anoniem'); ?></span>
                                        <time datetime="<?php echo htmlspecialchars($review['created_at']); ?>"><?php echo date('d-m-Y', strtotime($review['created_at'])); ?></time>
                                    </div>
                                </div>
                                <p class="review-text"><?php echo htmlspecialchars($review['review']); ?></p>
                            </article>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <p>Er zijn nog geen reviews voor dit product. Wees de eerste om er een te schrijven.</p>
                        <?php endif; ?>
                    </div>
                </section>
        </div>
    </main>

    <?php include __DIR__ . '/../component/footer.php'; ?>
    <?php require_once __DIR__ . '/../component/aiChat.php'; ?>
    <script src="/public/js/AiChat.js"></script>
    <script src="/public/js/product.js"></script>
</body>

</html>
