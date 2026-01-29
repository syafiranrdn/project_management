<?php
/* =============================
   DATABASE CONFIG (RAILWAY - MYSQLI)
============================= */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* =============================
   READ RAILWAY ENV VARIABLES
============================= */

$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT') ?: 3306;
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');

if (!$host || !$user || !$db) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Missing Railway MySQL environment variables"
    ]);
    exit;
}

/* =============================
   CONNECT (MYSQLI)
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
