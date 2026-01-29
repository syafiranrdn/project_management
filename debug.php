<?php
header("Content-Type: application/json");

/* FORCE ERROR VISIBILITY */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo json_encode([
    "step" => "start",
    "php_version" => phpversion()
]);

require_once __DIR__ . "/database.php";

if (!isset($conn)) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "database.php loaded BUT $conn not set"
    ]);
    exit;
}

if (mysqli_connect_errno()) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "MySQL connection error",
        "details" => mysqli_connect_error()
    ]);
    exit;
}

/* SIMPLE QUERY */
$q = mysqli_query($conn, "SHOW TABLES");

if (!$q) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "SHOW TABLES failed",
        "sql_error" => mysqli_error($conn)
    ]);
    exit;
}

$tables = [];
while ($r = mysqli_fetch_row($q)) {
    $tables[] = $r[0];
}

echo json_encode([
    "ok" => true,
    "tables" => $tables
]);
