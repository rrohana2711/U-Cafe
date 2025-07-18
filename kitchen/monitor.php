<?php
include 'connect.php';

function getOrderIdsByStatus($conn, $status) {
  $sql = "SELECT order_id FROM orders WHERE status = '$status' ORDER BY order_id DESC";
  $result = $conn->query($sql);

  $orderIds = [];
  while ($row = $result->fetch_assoc()) {
    $orderIds[] = $row['order_id'];
  }

  return $orderIds;
}

$preparingOrders = getOrderIdsByStatus($conn, 'preparing');
$readyOrders = getOrderIdsByStatus($conn, 'ready');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>U-Cafe Order Monitor</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f5f7fc;
      color: #203C8A;
      padding: 20px;
    }
    h1 {
      text-align: center;
      font-size: 36px;
      margin-bottom: 30px;
      color: #203C8A;
    }
    .section-container {
      display: flex;
      justify-content: space-between;
      gap: 40px;
    }
    .order-section {
      flex: 1;
      background: #eaf0ff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(32, 60, 138, 0.1);
    }
    .section-title {
      text-align: center;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #203C8A;
    }
    .order-number {
      text-align: center;
      font-size: 48px;
      font-weight: bold;
      margin: 20px 0;
      color: #2e3d61;
    }
  </style>
</head>
<body>

  <div style="text-align: center; margin-bottom: 10px;">
    <img src="utem.png" alt="UTeM Logo" style="max-width: 200px;" />
  </div>
  <h1>Now Serving</h1>

  <div class="section-container">
    <div class="order-section">
      <div class="section-title">Preparing</div>
      <?php foreach ($preparingOrders as $id): ?>
        <div class="order-number">#<?= $id ?></div>
      <?php endforeach; ?>
    </div>

    <div class="order-section">
      <div class="section-title">Ready</div>
      <?php foreach ($readyOrders as $id): ?>
        <div class="order-number">#<?= $id ?></div>
      <?php endforeach; ?>
    </div>
  </div>

</body>
</html>
