<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../../database.php';

$stmt = $conn->query("
    SELECT 
        activity_id,
        title,
        status,
        created_at
    FROM activities
    ORDER BY created_at DESC
");

echo json_encode([
    "ok" => true,
    "data" => $stmt->fetchAll()
]);
