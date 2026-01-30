echo json_encode([
  "host" => getenv("MYSQLHOST"),
  "db" => getenv("MYSQLDATABASE")
]);
