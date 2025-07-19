<?php
session_start();

if (!isset($_SESSION['order_id'])) {
    die("Order ID not found.");
}

$order_id = $_SESSION['order_id'];

// Connect to database
$host = 'localhost';
$db = 'u-cafe';
$user = 'root';
$pass = 'Khadijah_04';
$port = '3301';

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get total amount and payment method (if you have it stored)
$queryOrder = $conn->prepare("SELECT total_amount, order_number FROM orders WHERE order_id = ?");
$queryOrder->bind_param("i", $order_id);
$queryOrder->execute();
$queryOrder->bind_result($total_amount, $order_number);
$queryOrder->fetch();
$queryOrder->close();



// Get order items
$items = [];
$queryItems = $conn->prepare("SELECT item_name, quantity FROM order_items WHERE order_id = ?");
$queryItems->bind_param("i", $order_id);
$queryItems->execute();
$result = $queryItems->get_result();
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
$queryItems->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Receipt</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f4f8;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
      color: #2c3e50;
      padding: 20px;
    }

    .receipt-box {
      width: 100%;
      max-width: 500px;
      border: 2px solid #c9d6e3;
      border-radius: 12px;
      padding: 24px 32px;
      background-color: #ffffff;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 28px;
      color: #3b5998;
    }

    .item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 16px;
      color: #34495e;
    }

    .total {
      font-weight: 600;
      border-top: 1px solid #b0bec5;
      margin-top: 20px;
      padding-top: 12px;
      font-size: 18px;
      color: #2c3e50;
    }

    .thank-you {
      text-align: center;
      margin-top: 30px;
      font-size: 18px;
      color: #2e7d32;
      font-weight: 500;
    }

    .redirect-msg {
      text-align: center;
      margin-top: 10px;
      font-size: 14px; 
      color: #607d8b;
    }
    .order-id {
      font-size: 22px;
      font-weight: 700;
      color: #203c8a;
      margin-bottom: 20px;
    }

  </style>
</head>
<body>
  <div class="receipt-box"> 
    <h2>🧾 Receipt</h2>
    <p class="order-id">ID: <?= htmlspecialchars($order_id) ?></p>
    <p class="order-id">Your Number: <?= htmlspecialchars($order_number) ?></p>
    <div id="receiptItems">
      <?php foreach ($items as $item): ?>
        <div class="item">
          <span><?= htmlspecialchars($item['item_name']) ?> x<?= $item['quantity'] ?></span>
          <!-- You could calculate and show price if you stored it -->
        </div>
      <?php endforeach; ?>
    </div>
    <div class="total">
      Total: RM <?= number_format($total_amount, 2) ?><br/>
      
      Kindly make your payment at the counter.
    </div>
    <div class="thank-you">Thank you for your order!</div>
    <div class="redirect-msg">You will be redirected shortly...</div>
  </div>

  <script>
    setTimeout(function() {
      window.location.href = "thankyou.php";
    }, 5000);
  </script>
</body>
</html>
