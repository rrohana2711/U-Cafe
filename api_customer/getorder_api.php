<?php
session_start();
header('Content-Type: application/json');

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;
if (!$order_id) {
    echo json_encode(['error' => 'Order ID required']);
    exit;
}

$conn = new mysqli('localhost', 'root', 'Khadijah_04', 'u-cafe');
if ($conn->connect_error) {
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}

// Get order total
$order = $conn->query("SELECT * FROM orders WHERE order_id = $order_id")->fetch_assoc();
if (!$order) {
    echo json_encode(['error' => 'Order not found']);
    exit;
}

// Get items
$items_result = $conn->query("SELECT item_name, quantity FROM order_items WHERE order_id = $order_id");
$items = [];
while ($row = $items_result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode([
    'order_id' => $order_id,
    'total_amount' => $order['total_amount'],
    'items' => $items
]);

$conn->close();
?>
