<?php
header('Content-Type: application/json; charset=UTF-8');

require_once dirname(__DIR__, 2) . '/database.php';

/* 🔒 POST ONLY */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
    exit;
}

/* 📥 READ RAW BODY */
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

/* 🔧 ADD THIS BLOCK (IMPORTANT FIX) */
if (!$data && isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded')) {
    parse_str($raw, $data);
}

/* ✅ SAFE READ */
$email = trim($data['email'] ?? '');
$password = trim($data['password'] ?? '');

/* 🧪 VALIDATION */
if ($email === '' || $password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Email and password required'
    ]);
    exit;
}

/* 🔍 FIND USER */
$stmt = $conn->prepare("
    SELECT user_id, name, email, password, role
    FROM users
    WHERE email = ?
    LIMIT 1
");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode([
        'success' => false,
        'message' => 'User not found'
    ]);
    exit;
}

/* 🔐 PASSWORD CHECK */
if (!password_verify($password, $user['password'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid credentials'
    ]);
    exit;
}

/* ✅ SUCCESS */
unset($user['password']);

echo json_encode([
    'success' => true,
    'user' => $user
]);
exit;
