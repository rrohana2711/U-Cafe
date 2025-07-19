<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Order ID not found.']);
    exit;
}

$order_id = $_SESSION['order_id'];
$cart = json_decode(file_get_contents("php://input"), true);

// DB connection
$host = 'localhost';
$db = 'u-cafe';
$user = 'root';
$pass = 'Khadijah_04';
$port = '3301';

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed']);
    exit;
}

$total = 0;

foreach ($cart as $item) {
    $name = $conn->real_escape_string($item['name']);
    $price = floatval($item['price']);
    $qty = intval($item['quantity']);
    $total += $price * $qty;

    // 🔍 Step 1: Get item_id from menu_items
    $query = "SELECT item_id FROM menu_items WHERE item_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($item_id);
    $stmt->fetch();
    $stmt->close();

    // ✅ Step 2: Insert into order_items
    if ($item_id) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, item_id, item_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdi", $order_id, $item_id, $name, $price, $qty);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error: Item name '$name' not found in menu_items.<br>";
    }
}


// Update total_amount in orders table
$stmt = $conn->prepare("UPDATE orders SET total_amount = ? WHERE order_id = ?");
$stmt->bind_param("di", $total, $order_id);
$stmt->execute();
$stmt->close();

$conn->close();

echo json_encode(['success' => true, 'message' => 'Order saved']);
?>
