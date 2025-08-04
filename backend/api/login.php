<?php
session_start();
require_once '../db/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Check for POST data
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['role'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Username, password, and role are required.']);
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];
$role = strtolower(trim($_POST['role'])); // normalize role

// Prepare and execute the SELECT query to find the user in the database
$stmt = $db->prepare('SELECT * FROM users WHERE username = :username AND role = :role');
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':role', $role, SQLITE3_TEXT);
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);

// Verify user and password
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    // Invalid credentials
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
}
?>