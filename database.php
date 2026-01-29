<?php
/**
 * DATABASE CONFIG — RAILWAY (PDO ONLY)
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

/* =============================
   RAILWAY ENV VARIABLES
============================= */

$dbHost = getenv('MYSQLHOST');
$dbPort = getenv('MYSQLPORT') ?: 3306;
$dbName = getenv('MYSQLDATABASE');
$dbUser = getenv('MYSQLUSER');
$dbPass = getenv('MYSQLPASSWORD');

if (!$dbHost || !$dbName || !$dbUser) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Missing Railway MySQL environment variables"
    ]);
    exit;
}

/* =============================
   PDO CONNECTION
============================= */

try {
    $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Database connection failed",
        "details" => $e->getMessage()
    ]);
    exit;
}
