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

/* 📥 READ JSON BODY */
$input = json_decode(file_get_contents("php://input"), true);

$email = trim($input['email'] ?? '');
$password = trim($input['password'] ?? '');

/* 🧪 VALIDATION */
if ($email === '' || $password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Email and password required'
    ]);
    exit;
}

/* 🔍 FIND USER (PDO – EXPLICIT BINDING) */
$sql = "
    SELECT user_id, name, email, password, role
    FROM users
    WHERE email = :email
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

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
