<?php
header("Content-Type: application/json; charset=UTF-8");

// connect database
require_once __DIR__ . '/../../database.php';

try {
    // contoh query — adjust ikut table sebenar kau
    $stmt = $conn->prepare("
        SELECT 
            user_id,
            name,
            email,
            role,
            status,
            created_at
        FROM users
        ORDER BY created_at DESC
    ");
    $stmt->execute();

    $users = $stmt->fetchAll();

    echo json_encode([
        "ok" => true,
        "count" => count($users),
        "data" => $users
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Failed to fetch users",
        "details" => $e->getMessage()
    ]);
}
