<?php
// database.php (Railway compatible)

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

/* ===== DATABASE CONFIG ===== */
$DB_HOST = getenv('MYSQLHOST') ?: 'YOUR_HOST';
$DB_PORT = getenv('MYSQLPORT') ?: '3306';
$DB_NAME = getenv('MYSQLDATABASE') ?: 'YOUR_DB';
$DB_USER = getenv('MYSQLUSER') ?: 'YOUR_USER';
$DB_PASS = getenv('MYSQLPASSWORD') ?: 'YOUR_PASSWORD';

try {
    $dsn = "mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=utf8mb4";
    $conn = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Database connection failed",
        "message" => $e->getMessage()
    ]);
    exit;
}
