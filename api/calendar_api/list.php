<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../../database.php';

$stmt = $conn->query("
    SELECT 
        event_id,
        title,
        start_date,
        end_date
    FROM calendar_events
    ORDER BY start_date ASC
");

echo json_encode([
    "ok" => true,
    "data" => $stmt->fetchAll()
]);
