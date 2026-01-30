<?php
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../../database.php';

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
    exit;
}

// Read JSON input (FlutterFlow)
$input = json_decode(file_get_contents("php://input"), true);

$email    = trim($input['email'] ?? '');
$password = (string)($input['password'] ?? '');

if ($email === '' || $password === '') {
    echo json_encode([
        "success" => false,
        "message" => "Email and password required"
    ]);
    exit;
}

// Prepare query (same as your admin logic)
$stmt = $conn->prepare("
    SELECT 
        user_id,
        name,
        email,
        password,
        role,
        status,
        admin_level,
        department_id
    FROM users
    WHERE email = ?
    LIMIT 1
");

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Server error"
    ]);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$res  = $stmt->get_result();
$user = $res ? $res->fetch_assoc() : null;
$stmt->close();

if (!$user) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);
    exit;
}

// Block inactive accounts
if (($user['status'] ?? 'Active') !== 'Active') {
    echo json_encode([
        "success" => false,
        "message" => "Your account is not active"
    ]);
    exit;
}

// Password verify (SAME as admin)
if (!password_verify($password, (string)$user['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);
    exit;
}

// Allow only Admin & Staff
if (!in_array($user['role'], ['Admin', 'Staff'], true)) {
    echo json_encode([
        "success" => false,
        "message" => "Not authorized"
    ]);
    exit;
}

// ✅ LOGIN SUCCESS (NO SESSION, NO REDIRECT)
echo json_encode([
    "success" => true,
    "user" => [
        "user_id"       => (int)$user['user_id'],
        "name"          => $user['name'],
        "email"         => $user['email'],
        "role"          => $user['role'],
        "admin_level"   => $user['admin_level'],
        "department_id" => isset($user['department_id']) ? (int)$user['department_id'] : null
    ]
]);
