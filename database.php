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

$dbHost = getenv('MYSQLHOST');
$dbPort = getenv('MYSQLPORT') ?: 3306;
$dbName = getenv('MYSQLDATABASE');
$dbUser = getenv('MYSQLUSER');
$dbPass = getenv('MYSQLPASSWORD');

if (!$dbHost || !$dbName || !$dbUser) {
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode([
        "ok" => false,
        "error" => "Missing Railway MySQL environment variables",
        "debug" => [
            "MYSQLHOST" => $dbHost,
            "MYSQLPORT" => $dbPort,
            "MYSQLDATABASE" => $dbName,
            "MYSQLUSER" => $dbUser
        ]
    ]);
    exit;
}

/* =============================
   CONNECT (MYSQLI)
============================= */

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, (int)$dbPort);

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

mysqli_set_charset($conn, "utf8mb4");
