<?php
// $order is beschikbaar vanuit de controller
$subtotal = array_sum(array_map(fn($p) => $p['price'] * $p['quantity'], $order['products']));
$shipping = $order['delivery_price'] ?? 0;
$discount = $order['discount_amount'] ?? 0;
$total    = $order['total_price'];
$date     = date('d-m-Y', strtotime($order['created_at']));
$invoiceNr = 'INV-' . str_pad($order['id'], 5, '0', STR_PAD_LEFT);
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Factuur <?= $invoiceNr ?> — CleanStone</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 13px;
            color: #3A2B20;
            background: #fff;
            padding: 48px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* header */
        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 48px;
        }

        .inv-logo {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #3A2B20;
        }

        .inv-logo span { color: #7E6A52; }

        .inv-meta {
            text-align: right;
            line-height: 1.8;
        }

        .inv-meta strong {
            font-size: 18px;
            display: block;
            margin-bottom: 4px;
        }

        .inv-meta span { color: #7E6A52; }

        /* adres blok */
        .inv-addresses {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 32px;
        }

        .inv-address h4 {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #B89C82;
            margin-bottom: 8px;
        }

        .inv-address p { line-height: 1.8; }

        /* divider */
        hr {
            border: none;
            border-top: 1px solid #DACFB6;
            margin: 24px 0;
        }

        /* producten tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        thead th {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #B89C82;
            padding: 8px 0;
            border-bottom: 1px solid #DACFB6;
            text-align: left;
        }

        thead th:last-child { text-align: right; }

        tbody td {
            padding: 12px 0;
            border-bottom: 1px solid #F9F5ED;
            vertical-align: top;
        }

        tbody td:last-child { text-align: right; font-weight: 600; }

        .td-name { font-weight: 600; }
        .td-sku  { font-size: 11px; color: #7E6A52; margin-top: 2px; }

        /* totalen */
        .inv-totals {
            width: 260px;
            margin-left: auto;
        }

        .inv-totals-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            color: #7E6A52;
            font-size: 13px;
        }

        .inv-totals-row--total {
            font-size: 15px;
            font-weight: 700;
            color: #3A2B20;
            border-top: 1.5px solid #3A2B20;
            padding-top: 10px;
            margin-top: 6px;
        }

        /* footer */
        .inv-footer {
            margin-top: 60px;
            text-align: center;
            font-size: 11px;
            color: #B89C82;
            line-height: 1.8;
        }

        /* print knop */
        .print-btn {
            position: fixed;
            top: 24px;
            right: 24px;
            background: #3A2B20;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        @media print {
            .print-btn { display: none; }
            body { padding: 24px; }
        }
    </style>
</head>
<body>

<button class="print-btn" onclick="window.print()">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/>
    </svg>
    Afdrukken / Opslaan als PDF
</button>

<!-- HEADER -->
<div class="inv-header">
    <div class="inv-logo">Clean<span>Stone</span></div>
    <div class="inv-meta">
        <strong>Factuur</strong>
        <span>Factuurnummer: <?= $invoiceNr ?></span><br>
        <span>Datum: <?= $date ?></span><br>
        <span>Bestelling: #<?= $order['id'] ?></span>
    </div>
</div>

<!-- ADRESSEN -->
<div class="inv-addresses">
    <div class="inv-address">
        <h4>Van</h4>
        <p>
            <strong>CleanStone B.V.</strong><br>
            Steenstraat 1<br>
            1234 AB Amsterdam<br>
            info@cleanstone.nl<br>
            KVK: 12345678 · BTW: NL123456789B01
        </p>
    </div>
    <div class="inv-address">
        <h4>Aan</h4>
        <p>
            <strong><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></strong><br>
            <?= htmlspecialchars($order['street'] . ' ' . $order['house_number']) ?><br>
            <?= htmlspecialchars($order['postal_code'] . ' ' . $order['city']) ?><br>
            <?= htmlspecialchars($order['country'] ?? '') ?>
        </p>
    </div>
</div>

<hr>

<!-- PRODUCTEN -->
<table>
    <thead>
    <tr>
        <th style="width:50%">Product</th>
        <th>SKU</th>
        <th>Aantal</th>
        <th>Stukprijs</th>
        <th>Totaal</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($order['products'] as $p): ?>
        <tr>
            <td>
                <div class="td-name"><?= htmlspecialchars($p['name']) ?></div>
            </td>
            <td><span class="td-sku"><?= htmlspecialchars($p['sku'] ?? '—') ?></span></td>
            <td><?= $p['quantity'] ?>×</td>
            <td>€<?= number_format($p['price'], 2, ',', '.') ?></td>
            <td>€<?= number_format($p['price'] * $p['quantity'], 2, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- TOTALEN -->
<div class="inv-totals">
    <div class="inv-totals-row">
        <span>Subtotaal</span>
        <span>€<?= number_format($subtotal, 2, ',', '.') ?></span>
    </div>
    <?php if ($discount > 0): ?>
        <div class="inv-totals-row">
            <span>Korting</span>
            <span>−€<?= number_format($discount, 2, ',', '.') ?></span>
        </div>
    <?php endif; ?>
    <div class="inv-totals-row">
        <span>Verzendkosten</span>
        <span><?= $shipping > 0 ? '€' . number_format($shipping, 2, ',', '.') : 'Gratis' ?></span>
    </div>
    <div class="inv-totals-row inv-totals-row--total">
        <span>Totaal incl. BTW</span>
        <span>€<?= number_format($total, 2, ',', '.') ?></span>
    </div>
</div>

<hr>

<!-- FOOTER -->
<div class="inv-footer">
    CleanStone B.V. · Steenstraat 1, 1234 AB Amsterdam · info@cleanstone.nl<br>
    KVK: 12345678 · BTW: NL123456789B01 · IBAN: NL00 INGB 0000 0000 00
</div>

</body>
</html>