<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/cart.css">
    <title>CleanStone -Winkelwagen</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">

</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<main>
    <h1>Winkelwagen</h1>

    <div class="cart-layout">

        <!-- LEFT: PRODUCTS -->
        <div class="cart-items">

            <!-- Item -->
            <div class="cart-item">
                <div class="product-info">
                    <div class="image"></div>

                    <div>
                        <p class="brand">Lithofin</p>
                        <h3>Lithofin MN Allesreiniger</h3>
                        <p class="price">€24.95</p>
                    </div>
                </div>

                <div class="product-actions">
                    <button class="delete">🗑</button>

                    <div class="quantity">
                        <button>-</button>
                        <span>2</span>
                        <button>+</button>
                    </div>

                    <p class="total-price">€49.90</p>
                </div>
            </div>

            <!-- Item -->
            <div class="cart-item">
                <div class="product-info">
                    <div class="image"></div>

                    <div>
                        <p class="brand">Akemi</p>
                        <h3>Akemi Marble Protector</h3>
                        <p class="price">€39.95</p>
                    </div>
                </div>

                <div class="product-actions">
                    <button class="delete">🗑</button>

                    <div class="quantity">
                        <button>-</button>
                        <span>1</span>
                        <button>+</button>
                    </div>

                    <p class="total-price">€39.95</p>
                </div>
            </div>

            <a href="#" class="back">← Verder winkelen</a>

        </div>

        <!-- RIGHT: SUMMARY -->
        <div class="summary">
            <h2>Overzicht</h2>

            <div class="row">
                <span>Subtotaal</span>
                <span>€89.85</span>
            </div>

            <div class="row">
                <span>Verzendkosten</span>
                <span class="free">GRATIS</span>
            </div>

            <hr>

            <div class="row total">
                <span>Totaal</span>
                <span>€89.85</span>
            </div>

            <div class="discount">
                <input type="text" placeholder="Kortingscode">
                <button>Toepassen</button>
            </div>

            <button class="checkout">Naar betalen →</button>

            <ul class="notes">
                <li>✔ Veilig betalen</li>
                <li>✔ 30 dagen retourrecht</li>
            </ul>
        </div>

    </div>

</main>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<script src="/public/js/cart.js"></script>
<script src="/public/js/AiChat.js"></script>
</body>
</html>