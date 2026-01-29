<?php
/* =============================
   DATABASE CONFIG (RAILWAY - PDO)
============================= */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

/* =============================
   READ ENV VARIABLES
============================= */

$dbHost = getenv('mysql.railway.internal');
$dbPort = getenv('3306') ?: 3306;
$dbName = getenv('railway');
$dbUser = getenv('root');
$dbPass = getenv('lpYfrUyFMFPeCqJzYwnpUZRKIwIyotlT');

if (!$dbHost || !$dbName || !$dbUser) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Missing Railway MySQL environment variables"
    ]);
    exit;
}

/* =============================
   CONNECT (PDO)
============================= */

try {
    $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";

    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
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
