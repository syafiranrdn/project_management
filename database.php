<?php
header("Content-Type: application/json");

require_once __DIR__ . "/../database.php";

/* =============================
   DEBUG MODE (TEMPORARY)
============================= */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* =============================
   QUERY
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

/* =============================
   EXECUTE
============================= */
$result = mysqli_query($conn, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Query failed",
        "sql_error" => mysqli_error($conn)
    ]);
    exit;
}

/* =============================
   FETCH DATA
============================= */
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

/* =============================
   RESPONSE
============================= */
echo json_encode([
    "ok" => true,
    "count" => count($data),
    "data" => $data
]);
