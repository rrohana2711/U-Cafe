<?php
$conn = new mysqli('localhost', 'root', '', 'u-cafe');

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}
?>
