<?php
require_once '../session.php';
require_once '../db/db.php';
require_login();
header('Content-Type: application/json');

$user = $_SESSION['user'];
$userId = $user['id'];

// Prepare and execute the query to get all attendance records for the user
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