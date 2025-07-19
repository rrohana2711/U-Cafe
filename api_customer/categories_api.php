<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', 'Khadijah_04', 'u-cafe');
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$sql = "SELECT DISTINCT category FROM menu_items";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

echo json_encode($categories);
$conn->close();
?>
