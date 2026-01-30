<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../database.php';

$sql = "SELECT * FROM activities ORDER BY created_at DESC LIMIT 10";
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);
