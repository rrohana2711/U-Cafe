<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'u-cafe';
$user = 'root';
$pass = 'Khadijah_04';
$port = 3301;

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}

$sql = "SELECT item_id, item_name, category, price, image_url FROM menu_items";
$result = $conn->query($sql);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = [
        'item_id' => $row['item_id'],
        'item_name' => $row['item_name'],
        'category' => $row['category'],
        'price' => $row['price'],
        'image_path' => $row['image_url'] // Rename key to match frontend usage
    ];
}

echo json_encode($items);
$conn->close();
