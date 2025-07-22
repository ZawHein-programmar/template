<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != "admin") {
    header("location:../home.php");
    exit;
}
require '../storage/db.php';
require '../storage/central_function.php';

// <?php
$invoiceNumber = '#AA345';
$date = '25/07/2026';
$clientName = 'Michael Lomion';
$items = [
    ['desc' => 'Strength Classes', 'qty' => 1, 'price' => 40],
    ['desc' => 'Protein Booster', 'qty' => 3, 'price' => 15],
];

$subtotal = 0;
foreach ($items as $item) {
    $subtotal += $item['qty'] * $item['price'];
}
$tax = $subtotal * 0.05;
$total = $subtotal + $tax;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gym Voucher</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: white;
        }

        .container {
            width: 800px;
            margin: auto;
            background: #000;
            overflow: hidden;
        }

        .header {
            background: url('./images/gymgirls.png') no-repeat right/contain;
            height: 200px;
            position: relative;
            color: white;
            padding: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 36px;
        }

        .header .details {
            position: absolute;
            bottom: 30px;
            left: 30px;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            border-left: 5px solid #b6ff00;
        }

        .header .details div {
            margin-bottom: 5px;
        }

        .section-title {
            background: #b6ff00;
            color: black;
            padding: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #b6ff00;
            color: black;
            padding: 12px;
            text-align: left;
        }

        td {
            background: #111;
            padding: 12px;
        }

        .summary {
            text-align: right;
            margin-top: 20px;
            padding: 20px;
        }

        .summary div {
            margin: 8px 0;
        }

        .total {
            background: #b6ff00;
            color: black;
            font-weight: bold;
            padding: 12px;
            display: inline-block;
            min-width: 200px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background: url('./images/footer.jpg') no-repeat center/cover;
            color: white;
            font-size: 13px;
        }

        .footer div {
            background: rgba(0, 0, 0, 0.7);
            padding: 15px;
            width: 48%;
        }

        .footer a {
            color: #b6ff00;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container p-5">
        <div class="header">
            <h1>INVOICE</h1>
            <div class="details">
                <div>Date: <?= $date ?></div>
                <div>Invoice Number: <span id="inv-nov"></span></div>
                <div>Charge for: <?= $clientName ?></div>
            </div>
        </div>

        <div class="section-title">Item Description</div>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>QTY.</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item['desc'] ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td>$<?= number_format($item['qty'] * $item['price'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="summary">
            <div>Subtotal: $<?= number_format($subtotal, 2) ?></div>
            <div>Tax (5%): $<?= number_format($tax, 2) ?></div>
            <div class="total">TOTAL: $<?= number_format($total, 2) ?></div>
        </div>

        <div class="footer">
            <!-- <div>
                <img src="" alt="">
            </div> -->
            <div>
                <strong>PAYMENT METHOD</strong><br>
                By Bank<br>
                BB33 00 1234EE
            </div>
            <div>
                <strong>TERMS AND CONDITIONS</strong><br>
                Lorem ipsum dolor sit amet, sed do eiusmod tempor incididunt ut labore magna aliqua.<br><br>
                <a href="https://www.yoursite.com">Visit our website www.yoursite.com</a>
            </div>
        </div>
    </div>
</body>

</html>