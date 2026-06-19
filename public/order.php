<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/order.css">
    <title>CleanStone - Afrekenen</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<main>
    <h1>Afrekenen</h1>

    <!-- Stepper -->
    <div class="stepper">
        <div class="step active" data-step="1">
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <svg class="icon-check" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="step-label">Gegevens</span>
        </div>
        <div class="step-line" id="line-1"></div>
        <div class="step" data-step="2">
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                <svg class="icon-check" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="step-label">Verzending</span>
        </div>
        <div class="step-line" id="line-2"></div>
        <div class="step" data-step="3">
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                <svg class="icon-check" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="step-label">Betaling</span>
        </div>
    </div>

    <div class="checkout-layout">

        <!-- LEFT: Steps -->
        <div class="checkout-steps">

            <!-- Step 1: Gegevens -->
            <div class="checkout-card tab active" id="tab-1">
                <h2>Uw gegevens</h2>

                <div class="shipping-options" id="saved-addresses">
                    <!-- populated by JS: existing addresses as radio options -->
                </div>

                <label class="shipping-option" id="new-address-toggle">
                    <input type="radio" name="address-choice" value="new" id="radio-new-address">
                    <div class="ship-info">
                        <span class="ship-name">+ Nieuw adres toevoegen</span>
                    </div>
                </label>

                <div id="new-address-form" style="display:none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Voornaam *</label>
                            <input type="text" id="voornaam" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Achternaam *</label>
                            <input type="text" id="achternaam" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>E-mailadres *</label>
                        <input type="email" id="email" placeholder="">
                    </div>

                    <div class="form-group">
                        <label>Telefoon *</label>
                        <input type="tel" id="telefoon" placeholder="">
                    </div>

                    <h3 class="sub-heading">Bezorgadres</h3>

                    <div class="form-row">
                        <div class="form-group" style="flex: 2;">
                            <label>Straat *</label>
                            <input type="text" id="straat" placeholder="">
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label>Huisnummer *</label>
                            <input type="text" id="huisnummer" placeholder="">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Postcode *</label>
                            <input type="text" id="postcode" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Plaats *</label>
                            <input type="text" id="plaats" placeholder="">
                        </div>
                    </div>

                    <label class="set-default">
                        <input type="checkbox" id="set-as-default">
                        Maak dit mijn standaardadres
                    </label>
                </div>

                <div class="form-error" id="error-1"></div>
                <button class="btn-primary" id="btn-to-2">Verder naar verzending</button>
            </div>

            <!-- Step 2: Verzending -->
            <div class="checkout-card tab" id="tab-2">
                <h2>Verzendmethode</h2>

                <div class="shipping-options">
                    <label class="shipping-option selected">
                        <input type="radio" name="shipping" value="5.95" data-label="PostNL Standaard" checked>
                        <div class="ship-info">
                            <span class="ship-name">PostNL Standaard</span>
                            <span class="ship-sub">2–3 werkdagen</span>
                        </div>
                        <span class="ship-price">€5.95</span>
                    </label>

                    <label class="shipping-option">
                        <input type="radio" name="shipping" value="9.95" data-label="PostNL Express">
                        <div class="ship-info">
                            <span class="ship-name">PostNL Express</span>
                            <span class="ship-sub">1 werkdag</span>
                        </div>
                        <span class="ship-price">€9.95</span>
                    </label>

                    <label class="shipping-option">
                        <input type="radio" name="shipping" value="12.95" data-label="DHL Express">
                        <div class="ship-info">
                            <span class="ship-name">DHL Express</span>
                            <span class="ship-sub">Volgende dag</span>
                        </div>
                        <span class="ship-price">€12.95</span>
                    </label>
                </div>

                <div class="btn-row">
                    <button class="btn-outline" onclick="goTo(1)">Terug</button>
                    <button class="btn-primary" id="btn-to-3">Verder naar betaling</button>
                </div>
            </div>

            <!-- Step 3: Betaling -->
            <div class="checkout-card tab" id="tab-3">
                <h2>Betaling</h2>

                <div class="shipping-options">
                    <label class="shipping-option selected">
                        <input type="radio" name="payment" value="ideal" checked>
                        <div class="ship-info">
                            <span class="ship-name">iDEAL</span>
                        </div>
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="#CC0066"/><text x="5" y="22" font-size="13" font-weight="700" fill="white" font-family="sans-serif">iD</text></svg>
                    </label>

                    <label class="shipping-option">
                        <input type="radio" name="payment" value="creditcard">
                        <div class="ship-info">
                            <span class="ship-name">Creditcard</span>
                        </div>
                        <svg width="32" height="20" viewBox="0 0 32 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="20" rx="4" fill="#1A1F71"/><rect y="5" width="32" height="6" fill="#F7B600"/></svg>
                    </label>

                    <label class="shipping-option">
                        <input type="radio" name="payment" value="paypal">
                        <div class="ship-info">
                            <span class="ship-name">PayPal</span>
                        </div>
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="#003087"/><text x="4" y="22" font-size="11" font-weight="700" fill="#009CDE" font-family="sans-serif">Pay</text></svg>
                    </label>
                </div>

                <div class="btn-row">
                    <button class="btn-outline" onclick="goTo(2)">Terug</button>
                    <button class="btn-primary btn-green" id="btn-place-order">Bestelling plaatsen</button>
                </div>
            </div>

        </div>

        <!-- RIGHT: Summary -->
        <div class="summary">
            <h2>Overzicht</h2>

            <div class="receipt-items"></div>

            <div class="row">
                <span>Subtotaal</span>
                <span class="subtotal-price">€0.00</span>
            </div>

            <div class="row">
                <span>Verzendkosten</span>
                <span class="shipping-price free">GRATIS</span>
            </div>

            <div class="row">
                <span>Waarvan BTW (21%)</span>
                <span class="btw-price">€0.00</span>
            </div>

            <hr>
            <div id="discounted-value"></div>
            <div class="row total">
                <span>Totaal</span>
                <span class="total-price">€0.00</span>
            </div>

            <form class="discount">
                <input type="text" placeholder="Kortingscode">
                <button type="submit">Toepassen</button>
            </form>
        </div>


    </div>
</main>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<script src="/public/js/AiChat.js"></script>
<script src="/public/js/order.js"></script>
</body>
</html>