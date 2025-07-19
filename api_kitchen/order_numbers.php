<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
include('../kitchen/connect.php');

$status = $_GET['status'];

if ($status === '') {
    echo json_encode(["error" => "Missing status"]);
    exit();
}

$sql = "SELECT order_id FROM orders WHERE status = '$status' ORDER BY order_id DESC";
$result = $conn->query($sql);

$ids = [];
while ($row = $result->fetch_assoc()) {
    $ids[] = $row['order_id'];
}

echo json_encode($ids);
?>