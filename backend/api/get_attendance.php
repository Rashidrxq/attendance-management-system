<?php
header('Content-Type: application/json');
require_once '../db/db.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'No user ID']);
    exit;
}

$stmt = $db->prepare('SELECT date, status FROM attendance WHERE user_id = :user_id ORDER BY date DESC');
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$result = $stmt->execute();

$history = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $history[] = $row;
}

echo json_encode(['success' => true, 'history' => $history]);
?>