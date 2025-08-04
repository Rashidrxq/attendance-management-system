
<?php
header('Content-Type: application/json');
require_once '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'No user ID']);
    exit;
}

$date = date('Y-m-d');

// Check if already marked
$stmt = $db->prepare('SELECT id FROM attendance WHERE user_id = :user_id AND date = :date');
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$stmt->bindValue(':date', $date, SQLITE3_TEXT);
$result = $stmt->execute();
if ($result->fetchArray()) {
    echo json_encode(['success' => false, 'message' => 'Attendance already marked for today']);
    exit;
}

// Insert attendance
$stmt = $db->prepare('INSERT INTO attendance (user_id, date, status) VALUES (:user_id, :date, :status)');
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$stmt->bindValue(':date', $date, SQLITE3_TEXT);
$stmt->bindValue(':status', 'Present', SQLITE3_TEXT);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to mark attendance']);
}
?>