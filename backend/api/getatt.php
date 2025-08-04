<?php
require_once '../session.php';
require_once '../db/db.php';
require_login();
header('Content-Type: application/json');

// Check for admin role
if ($_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Only admin can access this']);
    exit;
}

// Check if a user ID was provided in the URL
$userId = $_GET['id'] ?? '';
if (!$userId) {
    http_response_code(400);
    echo json_encode(['error' => 'User ID required']);
    exit;
}

// Prepare and execute the query to get attendance for the specified user
$stmt = $db->prepare("SELECT date, status FROM attendance WHERE user_id = :user_id ORDER BY date DESC");
$stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);
$result = $stmt->execute();

$history = [];
// Fetch all rows into the history array
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $history[] = $row;
}

echo json_encode($history);
?>