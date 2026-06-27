<?php
// ✅ FIX: get first result
$order = $order[0];

// ✅ Calculations
$subtotal = array_sum(array_map(fn($p) => $p['price'] * $p['quantity'], $order['products']));
$shipping = (float) ($order['delivery_price'] ?? 0);
$discount = (float) ($order['discount_amount'] ?? 0);
$total    = (float) $order['total_price'];
$date     = date('d-m-Y', strtotime($order['created_at']));
$invoiceNr = 'INV-' . str_pad($order['order_id'], 5, '0', STR_PAD_LEFT);
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Factuur <?= $invoiceNr ?> — CleanStone</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: lightgray;
        }
        main{
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #3A2B20;
            padding: 40px;
            max-width: 800px;
            margin: auto;
            background: white;
            min-height: 100vh;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .logo {
            font-weight: bold;
            font-size: 20px;
        }
        .logo img{
            width: 120px;
        }

        .meta {
            text-align: right;
        }

        .addresses {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            border-bottom: 1px solid #ccc;
            text-align: left;
            padding: 8px 0;
            font-size: 12px;
        }

        td {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        td:last-child, th:last-child {
            text-align: right;
        }

        .totals {
            width: 250px;
            margin-left: auto;
        }

        .row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }

        .total {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 8px;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px;
            background: black;
            color: white;
            border: none;
            cursor: pointer;
        }

        @media print {
            .print-btn { display: none; }
        }
    </style>
</head>

<body>

<button class="print-btn" onclick="window.print()">Print / PDF</button>

<main>



<div class="header">
    <div class="logo">
        <img src="/public/assets/logo-cleanstone.png" alt="logo">
    </div>
    <div class="meta">
        <strong>Factuur</strong><br>
        Nr: <?= $invoiceNr ?><br>
        Datum: <?= $date ?><br>
        Bestelling: #<?= $order['order_id'] ?>
    </div>
</div>

<div class="addresses">
    <div>
        <strong>Van:</strong><br>
        CleanStone B.V.<br>
        Steenstraat 1<br>
        Amsterdam
    </div>

    <div>
        <strong>Aan:</strong><br>
        <?= htmlspecialchars($order['invoice_first_name'] . ' ' . $order['invoice_last_name']) ?><br>
        <?= htmlspecialchars($order['invoice_street'] . ' ' . $order['invoice_house_number']) ?><br>
        <?= htmlspecialchars($order['invoice_postal_code'] . ' ' . $order['invoice_city']) ?><br>
        <?= htmlspecialchars($order['invoice_country']) ?>
    </div>
</div>

<table>
    <thead>
    <tr>
        <th>Product</th>
        <th>Aantal</th>
        <th>Prijs</th>
        <th>Totaal</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($order['products'] as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= $p['quantity'] ?></td>
            <td>€<?= number_format($p['price'], 2, ',', '.') ?></td>
            <td>€<?= number_format($p['price'] * $p['quantity'], 2, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="totals">
    <div class="row">
        <span>Subtotaal</span>
        <span>€<?= number_format($subtotal, 2, ',', '.') ?></span>
    </div>

    <?php if ($discount > 0): ?>
        <div class="row">
            <span>Korting</span>
            <span>-€<?= number_format($discount, 2, ',', '.') ?></span>
        </div>
    <?php endif; ?>

    <div class="row">
        <span>Verzendkosten</span>
        <span><?= $shipping > 0 ? '€' . number_format($shipping, 2, ',', '.') : 'Gratis' ?></span>
    </div>

    <div class="row total">
        <span>Totaal</span>
        <span>€<?= number_format($total, 2, ',', '.') ?></span>
    </div>
</div>
</main>
</body>
</html>