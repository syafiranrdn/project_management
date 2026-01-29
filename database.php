<?php
/* ==================================================
   DATABASE CONFIG (RAILWAY - MYSQL)
   Used by all APIs (activities, users, notes, etc.)
================================================== */

/* ===== LOAD ENV VARIABLES ===== */
$DB_HOST = getenv('MYSQLHOST');
$DB_PORT = getenv('MYSQLPORT') ?: 3306;
$DB_USER = getenv('MYSQLUSER');
$DB_PASS = getenv('MYSQLPASSWORD');
$DB_NAME = getenv('MYSQLDATABASE');

/* ===== VALIDATE ENV (IMPORTANT) ===== */
if (
    empty($DB_HOST) ||
    empty($DB_USER) ||
    empty($DB_PASS) ||
    empty($DB_NAME)
) {
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode([
        "ok" => false,
        "error" => "Missing Railway database environment variables",
        "env" => [
            "MYSQLHOST" => $DB_HOST ? "OK" : "MISSING",
            "MYSQLUSER" => $DB_USER ? "OK" : "MISSING",
            "MYSQLPASSWORD" => $DB_PASS ? "OK" : "MISSING",
            "MYSQLDATABASE" => $DB_NAME ? "OK" : "MISSING",
            "MYSQLPORT" => $DB_PORT
        ]
    ]);
    exit;
}

/* ===== CONNECT ===== */
$conn = mysqli_init();
mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);

$connected = mysqli_real_connect(
    $conn,
    $DB_HOST,
    $DB_USER,
    $DB_PASS,
    $DB_NAME,
    (int)$DB_PORT
);

if (!$connected) {
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode([
        "ok" => false,
        "error" => "Database connection failed",
        "details" => mysqli_connect_error()
    ]);
    exit;
}

/* ===== FORCE UTF-8 ===== */
mysqli_set_charset($conn, "utf8mb4");

/* ===== OPTIONAL: TIMEZONE (SAFE) ===== */
// mysqli_query($conn, "SET time_zone = '+00:00'");

/* ===== DONE ===== */
// $conn is now ready to be used everywhere
