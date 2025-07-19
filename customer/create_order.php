<?php
// DB connection
$host = 'localhost';
$db = 'u-cafe';
$user = 'root';
$pass = 'Khadijah_04';
$port = '3301';

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect POST data
$name = $_POST['customer_name'];
$phone = $_POST['customer_phone'];
$type = $_POST['order_type'];

// Generate unique order number
$result = $conn->query("SELECT order_number FROM orders ORDER BY order_id DESC LIMIT 1");

if ($result && $row = $result->fetch_assoc()) {
    // Extract numeric part (remove prefix if any)
    $lastOrderNumber = intval(substr($row['order_number'], -5));
    $newOrderNumber = str_pad($lastOrderNumber + 1, 5, '0', STR_PAD_LEFT);
} else {
    // First order
    $newOrderNumber = '00001';
}

// Step 2: Add prefix if needed
$order_number = 'ORD-' . $newOrderNumber;

// Insert new order with order_number
$stmt = $conn->prepare("INSERT INTO orders (order_number, customer_name, customer_phone, order_type, total_amount) VALUES (?, ?, ?, ?, 0.00)");
$stmt->bind_param("ssss", $order_number, $name, $phone, $type);
$stmt->execute();

// Get inserted order_id
$order_id = $conn->insert_id;
$stmt->close();
$conn->close();

// Store in session and redirect
session_start();
$_SESSION['order_id'] = $order_id;
$_SESSION['order_type'] = $type;
header("Location: menu.php");
exit();
?>
