<?php
header("Content-Type: application/json");

require_once __DIR__ . "/../database.php";

/* =============================
   FETCH USERS
============================= */

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
LEFT JOIN departments d
    ON d.department_id = u.department_id
ORDER BY u.user_id ASC
";

$result = mysqli_query($conn, $sql);

// 🔴 CRITICAL: handle SQL error
if (!$result) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Query failed",
        "sql_error" => mysqli_error($conn)
    ]);
    exit;
}

$users = [];

while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode([
    "ok" => true,
    "count" => count($users),
    "data" => $users
]);
