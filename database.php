<?php
/* =========================
   DATABASE (PDO - Railway)
========================= */

$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT') ?: 3306;
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "ok"      => false,
        "error"   => "Database connection failed",
        "details" => $e->getMessage()
    ]);
    exit;
}
