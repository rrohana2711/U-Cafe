<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_status'])) {
  $order_id = intval($_POST['order_id']);
  $new_status = $_POST['new_status'];
  $conn->query("UPDATE orders SET status = '$new_status' WHERE order_id = $order_id");
  header("Location: kitchen.php"); // refresh to reflect update
  exit();
}

function getOrdersByStatus($conn, $status) {
  $sql = "SELECT o.order_id, o.order_date, oi.item_name, oi.quantity 
          FROM orders o 
          JOIN order_items oi ON o.order_id = oi.order_id 
          WHERE o.status = '$status' 
          ORDER BY o.order_id DESC";

  $result = $conn->query($sql);
  $orders = [];

  while ($row = $result->fetch_assoc()) {
    $id = $row['order_id'];
    if (!isset($orders[$id])) {
      $orders[$id] = [
        'id' => $id,
        'time' => date('h:i A', strtotime($row['order_date'])),
        'items' => [],
        'status' => ucfirst($status)
      ];
    }
    $orders[$id]['items'][] = $row['item_name'] . ' x' . $row['quantity'];
  }

  return $orders;
}

$pendingOrders = getOrdersByStatus($conn, 'pending');
$preparingOrders = getOrdersByStatus($conn, 'preparing');
$readyOrders = getOrdersByStatus($conn, 'ready');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>U-Cafe Kitchen Dashboard</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f5f7fc;
      padding: 20px;
    }
    h1, h2 {
      text-align: center;
      color: #203C8A;
      margin-bottom: 0;
    }
    h2 { margin-bottom: 30px; }

    .section-container {
      display: flex;
      justify-content: space-between;
      gap: 20px;
    }
    .order-section {
      flex: 1;
      padding: 15px;
      background: #eaf0ff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(32, 60, 138, 0.05);
    }
    .section-title {
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      color: #203C8A;
      margin-bottom: 15px;
    }
    .order-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(32, 60, 138, 0.1);
      padding: 15px;
      margin-bottom: 20px;
      position: relative;
      transition: all 0.3s ease;
    }
    .order-header {
      font-weight: bold;
      font-size: 18px;
      color: #203C8A;
      margin-bottom: 10px;
      text-align: center;
    }
    .order-detail { margin: 6px 0; color: #2e3d61; }
    .item-line {
      display: flex;
      justify-content: space-between;
      font-size: 15px;
      font-weight: 600;
    }
    .menu-list {
      margin: 8px 0;
      padding-left: 20px;
    }
    .menu-list li {
      margin-bottom: 5px;
      font-size: 17px;
    }
    .status-line {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }
    button {
      padding: 6px 12px;
      border: none;
      border-radius: 6px;
      font-size: 13px;
      color: white;
      cursor: pointer;
    }
    .cook-btn { background-color: #203C8A; }
    .cook-btn:hover { background-color: #1b2f6e; }
    .done-btn { background-color: #415db2; }
    .done-btn:hover { background-color: #203C8A; }
    .final-done-btn { background-color: #2f854e; }
    .final-done-btn:hover { background-color: #25673e; }
    .status { font-weight: bold; color: #203C8A; }

    .fullscreen-icon {
      position: absolute;
      bottom: 12px;
      right: 12px;
      width: 26px;
      height: 26px;
      background: rgba(32, 60, 138, 0.05);
      border-radius: 6px;
      padding: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div style="text-align: center; margin-bottom: 10px;">
    <img src="utem.png" alt="UTeM Logo" style="max-width: 200px;" />
  </div>
  <h1>U-Cafe Ordering System</h1>
  <h2>Kitchen Dashboard</h2>

  <div class="section-container">
    <div class="order-section">
      <div class="section-title">Pending</div>
      <?php foreach ($pendingOrders as $order): ?>
        <div class="order-card">
          <div class="order-header">Order ID: <?= $order['id'] ?></div>
          <div class="order-detail">
            <div class="item-line">
              <span><strong>Items:</strong></span>
              <span><?= $order['time'] ?></span>
            </div>
            <ul class="menu-list">
              <?php foreach ($order['items'] as $item): ?>
                <li><?= $item ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="order-detail status-line">
            <strong>Status:</strong>
            <span class="status"><?= $order['status'] ?></span>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
              <input type="hidden" name="new_status" value="preparing">
              <button type="submit" name="update_status" class="cook-btn">Preparing</button>
            </form>
          </div>
          <img src="preview.png" class="fullscreen-icon" onclick="openFullscreen(this)" />
        </div>
      <?php endforeach; ?>
    </div>

    <div class="order-section">
      <div class="section-title">Preparing</div>
      <?php foreach ($preparingOrders as $order): ?>
        <div class="order-card">
          <div class="order-header">Order ID: <?= $order['id'] ?></div>
          <div class="order-detail">
            <div class="item-line">
              <span><strong>Items:</strong></span>
              <span><?= $order['time'] ?></span>
            </div>
            <ul class="menu-list">
              <?php foreach ($order['items'] as $item): ?>
                <li><?= $item ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="order-detail status-line">
            <strong>Status:</strong>
            <span class="status"><?= $order['status'] ?></span>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
              <input type="hidden" name="new_status" value="ready">
              <button type="submit" name="update_status" class="done-btn">Ready</button>
            </form>
          </div>
          <img src="preview.png" class="fullscreen-icon" onclick="openFullscreen(this)" />
        </div>
      <?php endforeach; ?>
    </div>

    <div class="order-section">
      <div class="section-title">Ready</div>
      <?php foreach ($readyOrders as $order): ?>
        <div class="order-card">
          <div class="order-header">Order ID: <?= $order['id'] ?></div>
          <div class="order-detail">
            <div class="item-line">
              <span><strong>Items:</strong></span>
              <span><?= $order['time'] ?></span>
            </div>
            <ul class="menu-list">
              <?php foreach ($order['items'] as $item): ?>
                <li><?= $item ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="order-detail status-line">
            <strong>Status:</strong>
            <span class="status"><?= $order['status'] ?></span>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
              <input type="hidden" name="new_status" value="completed">
              <button type="submit" name="update_status" class="final-done-btn">Done</button>
            </form>
          </div>
          <img src="preview.png" class="fullscreen-icon" onclick="openFullscreen(this)" />
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div id="fullscreenOverlay">
    <div class="fullscreen-content">
      <button onclick="closeFullscreen()" class="close-btn">×</button>
      <div id="fullscreenDetails"></div>
    </div>
  </div>

  <script>
    function openFullscreen(icon) {
      const card = icon.closest('.order-card');
      const header = card.querySelector(".order-header").innerHTML;
      const itemBlock = card.querySelector(".order-detail").innerHTML;
      const status = card.querySelector(".status").outerHTML;

      const html = `
        <h2>${header}</h2>
        <div>${itemBlock}</div>
        <p><strong>Status:</strong> ${status}</p>
      `;

      document.getElementById("fullscreenDetails").innerHTML = html;
      document.getElementById("fullscreenOverlay").style.display = "flex";
    }

    function closeFullscreen() {
      document.getElementById("fullscreenOverlay").style.display = "none";
    }
  </script>
</body>
</html>
