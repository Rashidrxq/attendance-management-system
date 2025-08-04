<?php
// filepath: c:\xampp\htdocs\atm\backend\api\get_student.php
header('Content-Type: application/json');
require_once '../db/db.php';

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'No student ID provided']);
    exit;
}

$id = intval($_GET['id']);
$stmt = $db->prepare('SELECT id, username, first_name, last_name, email, department, address FROM users WHERE id = :id AND role = "student"');
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);

if ($user) {
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    echo json_encode(['success' => false, 'message' => 'Student not found']);
}
?>