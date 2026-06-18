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



            <a href="#" class="back">← Verder winkelen</a>

        </div>

        <!-- RIGHT: SUMMARY -->
        <div class="summary">
            <h2>Overzicht</h2>

            <div class="receipt-items"></div>

            <div class="row">
                <span>Subtotaal</span>
                <span class="subtotal-price">€0.00</span>
            </div>

            <div class="row">
                <span>Verzendkosten</span>
                <span class="free">GRATIS</span>
            </div>

            <hr>

            <div class="row total">
                <span>Totaal</span>
                <span class="total-price">€0.00</span>
            </div>

            <div class="discount">
                <input type="text" placeholder="Kortingscode">
                <button>Toepassen</button>
            </div>

            <button class="checkout">Naar betalen →</button>

            <ul class="notes">
                <li><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99998 14.3996C9.69736 14.3996 11.3252 13.7253 12.5255 12.5251C13.7257 11.3249 14.4 9.69699 14.4 7.99961C14.4 6.30222 13.7257 4.67436 12.5255 3.47413C11.3252 2.27389 9.69736 1.59961 7.99998 1.59961C6.30259 1.59961 4.67473 2.27389 3.47449 3.47413C2.27426 4.67436 1.59998 6.30222 1.59998 7.99961C1.59998 9.69699 2.27426 11.3249 3.47449 12.5251C4.67473 13.7253 6.30259 14.3996 7.99998 14.3996ZM10.9656 6.96521C11.1113 6.81433 11.1919 6.61225 11.1901 6.40249C11.1883 6.19273 11.1042 5.99208 10.9558 5.84375C10.8075 5.69543 10.6069 5.61129 10.3971 5.60947C10.1873 5.60765 9.98526 5.68828 9.83438 5.83401L7.19998 8.46841L6.16558 7.43401C6.01469 7.28828 5.81261 7.20765 5.60285 7.20947C5.3931 7.21129 5.19245 7.29543 5.04412 7.44375C4.89579 7.59208 4.81166 7.79273 4.80984 8.00249C4.80801 8.21225 4.88865 8.41433 5.03438 8.56521L6.63438 10.1652C6.7844 10.3152 6.98784 10.3994 7.19998 10.3994C7.41211 10.3994 7.61555 10.3152 7.76558 10.1652L10.9656 6.96521Z" fill="#7E6A52"/>
                    </svg>
                    Veilig betalen</li>
                <li><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99998 14.3996C9.69736 14.3996 11.3252 13.7253 12.5255 12.5251C13.7257 11.3249 14.4 9.69699 14.4 7.99961C14.4 6.30222 13.7257 4.67436 12.5255 3.47413C11.3252 2.27389 9.69736 1.59961 7.99998 1.59961C6.30259 1.59961 4.67473 2.27389 3.47449 3.47413C2.27426 4.67436 1.59998 6.30222 1.59998 7.99961C1.59998 9.69699 2.27426 11.3249 3.47449 12.5251C4.67473 13.7253 6.30259 14.3996 7.99998 14.3996ZM10.9656 6.96521C11.1113 6.81433 11.1919 6.61225 11.1901 6.40249C11.1883 6.19273 11.1042 5.99208 10.9558 5.84375C10.8075 5.69543 10.6069 5.61129 10.3971 5.60947C10.1873 5.60765 9.98526 5.68828 9.83438 5.83401L7.19998 8.46841L6.16558 7.43401C6.01469 7.28828 5.81261 7.20765 5.60285 7.20947C5.3931 7.21129 5.19245 7.29543 5.04412 7.44375C4.89579 7.59208 4.81166 7.79273 4.80984 8.00249C4.80801 8.21225 4.88865 8.41433 5.03438 8.56521L6.63438 10.1652C6.7844 10.3152 6.98784 10.3994 7.19998 10.3994C7.41211 10.3994 7.61555 10.3152 7.76558 10.1652L10.9656 6.96521Z" fill="#7E6A52"/>
                    </svg>
                    30 dagen retourrecht</li>
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