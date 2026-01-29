<?php
/* =============================
   DATABASE CONFIG (RAILWAY)
============================= */

header("Content-Type: application/json");

// Load Railway environment variables
$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT') ?: 3306;
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');

// Safety check
if (!$host || !$user || !$db) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Missing Railway MySQL environment variables",
        "env" => [
            "MYSQLHOST" => $host,
            "MYSQLUSER" => $user,
            "MYSQLDATABASE" => $db
        ]
    ]);
    exit;
}

/* =============================
   CONNECT
============================= */
$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Database connection failed",
        "details" => mysqli_connect_error()
    ]);
    exit;
}

// Force UTF-8
mysqli_set_charset($conn, "utf8mb4");
