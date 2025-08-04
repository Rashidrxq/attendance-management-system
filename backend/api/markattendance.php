<?php
require_once '../session.php'; // Your session check file
require_once '../db/db.php';   // The SQLite connection file
require_login();
header('Content-Type: application/json');

$user = $_SESSION['user'];
$userId = $user['id'];
$date = date("Y-m-d");

// Step 1: Check if attendance was already marked in the database
$stmt = $db->prepare("SELECT id FROM attendance WHERE user_id = :user_id AND date = :date");
$stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);
$stmt->bindValue(':date', $date, SQLITE3_TEXT);
$result = $stmt->execute();

if ($result->fetchArray()) {
    echo json_encode(['success' => false, 'message' => 'Attendance already marked for today.']);
    exit;
}

// Step 2: Insert the new attendance record into the database
$stmt = $db->prepare("INSERT INTO attendance (user_id, date, status) VALUES (:user_id, :date, :status)");
$stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);
$stmt->bindValue(':date', $date, SQLITE3_TEXT);
$stmt->bindValue(':status', 'Present', SQLITE3_TEXT);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Attendance marked successfully.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to mark attendance.']);
}
?>