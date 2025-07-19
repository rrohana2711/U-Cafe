<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
include('../kitchen/connect.php');


$data = json_decode(file_get_contents("php://input"), true);

$order_id = intval($data['order_id'] ?? 0);
$new_status = $data['new_status'] ?? '';

if ($order_id && $new_status) {
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $new_status, $order_id);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Status updated successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update status']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
}
?>