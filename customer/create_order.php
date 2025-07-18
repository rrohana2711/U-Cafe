<?php
// DB connection
$host = 'localhost';
$db = 'u-cafe';
$user = 'root';
$pass = 'Khadijah_04';
$port = '3301'; // adjust based on your setup

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect POST data
$name = $_POST['customer_name'];
$phone = $_POST['customer_phone'];
$type = $_POST['order_type'];

// Insert new order
$stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, order_type, total_amount) VALUES (?, ?, ?, 0.00)");
$stmt->bind_param("sss", $name, $phone, $type);
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
