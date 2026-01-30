<?php
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../../database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
    exit;
}

$email    = trim($_POST['email'] ?? '');
$password = (string)($_POST['password'] ?? '');

if ($email === '' || $password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Email and password required'
    ]);
    exit;
}

$stmt = $conn->prepare("
    SELECT user_id, name, email, password, role, status, admin_level, department_id
    FROM users
    WHERE email = ?
    LIMIT 1
");

$stmt->bind_param("s", $email);
$stmt->execute();
$res  = $stmt->get_result();
$user = $res ? $res->fetch_assoc() : null;
$stmt->close();

if (!$user || !password_verify($password, $user['password'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid email or password'
    ]);
    exit;
}

if ($user['status'] !== 'Active') {
    echo json_encode([
        'success' => false,
        'message' => 'Account inactive'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'user' => [
        'user_id' => (int)$user['user_id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role'],
        'admin_level' => $user['admin_level'],
        'department_id' => $user['department_id']
    ]
]);
