<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

/* =============================
   RAILWAY MYSQL ENV
============================= */
$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT') ?: 3306;
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');

/* =============================
   VALIDATE
============================= */
if (!$host || !$db || !$user) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Missing Railway MySQL environment variables"
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

mysqli_set_charset($conn, "utf8mb4");
