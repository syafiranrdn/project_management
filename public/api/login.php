<?php
header('Content-Type: application/json; charset=UTF-8');

$raw = file_get_contents("php://input");

echo json_encode([
    "raw_input" => $raw,
    "decoded" => json_decode($raw, true),
]);
exit;
