<?php
header("Content-Type: application/json");

echo json_encode([
  "ok" => true,
  "service" => "project_management API",
  "time" => date("c")
]);
