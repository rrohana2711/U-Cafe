<?php
session_start();

if (!isset($_SESSION['order_id'])) {
    die("Order ID not found.");
}

$order_id = $_SESSION['order_id'];
$cart = json_decode(file_get_contents("php://input"), true);

// DB connection (adjust this if needed)
$host = 'localhost';
$db = 'u-cafe';
$user = 'root';
$pass = 'Khadijah_04';
$port = '3301';

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$total = 0;

// Save each item to order_items table
foreach ($cart as $item) {
    $name = $conn->real_escape_string($item['name']);
    $price = floatval($item['price']);
    $qty = intval($item['quantity']);
    $total += $price * $qty;

    $stmt = $conn->prepare("INSERT INTO order_items (order_id, item_name, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $order_id, $name, $qty);
    $stmt->execute();
    $stmt->close();
}

// Update total_amount in orders table
$stmt = $conn->prepare("UPDATE orders SET total_amount = ? WHERE order_id = ?");
$stmt->bind_param("di", $total, $order_id);
$stmt->execute();
$stmt->close();

$conn->close();

echo json_encode(['success' => true, 'message' => 'Order saved.']);
?>