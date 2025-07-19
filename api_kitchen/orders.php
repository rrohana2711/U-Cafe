<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
include('../kitchen/connect.php');

$status = $_GET['status'] ;

if ($status === '') {
    http_response_code(400);
    echo json_encode(["error" => "Missing status"]);
    exit();
}

$stmt = $conn->prepare("SELECT o.order_id, o.order_number, o.order_date, oi.item_name, oi.quantity
                        FROM orders o
                        JOIN order_items oi ON o.order_id = oi.order_id
                        WHERE o.status = ?
                        ORDER BY o.order_id DESC");
$stmt->bind_param("s", $status);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orderId = $row['order_id'];
    $orderNumber = $row['order_number'];

    if (!isset($orders[$orderId])) {
        $orders[$orderId] = [
            'id' => $orderId,
            'no' => $orderNumber,
            'time' => date('g:i:s a', strtotime($row['order_date'])),
            'items' => [],
            'status' => ucfirst($status)
        ];
    }

    $itemName = $row['item_name'] ;
    $quantity = $row['quantity'] ;
    $orders[$orderId]['items'][] = "{$itemName} x{$quantity}";
}

echo json_encode(array_values($orders));
?>