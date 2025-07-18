<?php
session_start();

if (!isset($_SESSION['order_id'])) {
    die("Order ID not found.");
}

$order_id = $_SESSION['order_id'];
$status = isset($_POST['status']) ? $_POST['status'] : 'pending';

// Validate status
if (!in_array($status, ['pending', 'cancelled'])) {
    die("Invalid status.");
}

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

// Update the status
$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
$stmt->bind_param("si", $status, $order_id);
$stmt->execute();
$stmt->close();
$conn->close();

// Redirect based on status
if ($status === 'pending') {
    header("Location: receipt.php");
} else {
    header("Location: cancelorder.php");
}
exit();
