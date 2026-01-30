<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../../database.php';

$stmt = $conn->query("
    SELECT 
        user_id,
        name,
        email,
        role,
        status,
        created_at
    FROM users
    ORDER BY user_id ASC
");

$data = $stmt->fetchAll();

echo json_encode([
    "ok" => true,
    "data" => $data
]);
