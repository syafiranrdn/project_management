<?php
/* =============================
   DATABASE CONFIG (RAILWAY)
============================= */

// Railway environment variables
$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT') ?: 3306;
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');

/* =============================
   CONNECT
============================= */
$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode([
        "ok" => false,
        "error" => "Database connection failed",
        "details" => mysqli_connect_error()
    ]);
    exit;
}

// Optional: force UTF-8
mysqli_set_charset($conn, "utf8mb4");
