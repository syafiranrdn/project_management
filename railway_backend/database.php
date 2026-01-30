<?php
header('Content-Type: application/json; charset=UTF-8');

$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT');

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => mysqli_connect_error()
    ]);
    exit;
}
