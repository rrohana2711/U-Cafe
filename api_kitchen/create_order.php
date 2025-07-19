<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
include('../kitchen/connect.php');

$data = json_decode(file_get_contents("php://input"), true);
if ($data === null) {
    echo json_encode(["error" => "JSON decode failed"]);
    exit();
}
$rawInput = file_get_contents("php://input");
file_put_contents("debug.json", $rawInput); // Logs raw body
$data = json_decode($rawInput, true);


if (!$data || !isset($data['customer_name'], $data['customer_phone'], $data['order_type'], $data['items'])) {
    echo json_encode(["error" => "Missing data"]);
    exit();
}

$customer_name = $data['customer_name'];
$customer_phone = $data['customer_phone'];
$order_type = $data['order_type'];
$status = 'pending';
$items = $data['items'];
$total = 0;

$conn->begin_transaction();

try {
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

    $stmt = $conn->prepare("INSERT INTO orders (order_number, customer_name, customer_phone, order_type, order_date, status, total_amount) VALUES (?,?, ?, ?, NOW(), ?, 0)");
    $stmt->bind_param("sssss", $order_number, $customer_name, $customer_phone, $order_type, $status);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    foreach ($items as $item) {
        $name = $item['item_name'];
        $qty = intval($item['quantity']);

        // Check if item exists
        $res = $conn->query("SELECT price FROM menu_items WHERE item_name = '$name'");
        if ($res->num_rows == 0) {
            throw new Exception("Menu item not found: $name");
        }

        $row = $res->fetch_assoc();
        $price = floatval($row['price']);
        $total += $price * $qty;

        $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, item_name, quantity) VALUES (?, ?, ?)");
        $stmt2->bind_param("isi", $order_id, $name, $qty);
        $stmt2->execute();
    }

    $conn->query("UPDATE orders SET total_amount = $total WHERE order_id = $order_id");

    $conn->commit();
    echo json_encode(["message" => "Order created", "order_id" => $order_id]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Failed to create order", "details" => $e->getMessage()]);
}
?>