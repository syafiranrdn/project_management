<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../database.php';

$sql = "
SELECT
    u.user_id,
    u.name,
    u.email,
    u.role,
    u.admin_level,
    u.department_id,
    d.department_name,
    u.status,
    u.created_at
FROM users u
LEFT JOIN departments d ON d.department_id = u.department_id
ORDER BY u.user_id ASC
";

try {
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll();

    echo json_encode([
        "ok"   => true,
        "data" => $data
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "ok"    => false,
        "error" => "Query failed",
        "details" => $e->getMessage()
    ]);
}
