<?php
require_once '../session.php'; // Note: your session file is in the parent dir
require_once '../db/db.php';
require_login();
header('Content-Type: application/json');

// Optional: Add admin role check
if ($_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Access denied.']);
    exit;
}

// Query to get all attendance with user details
$query = "
    SELECT u.username as name, u.role, a.date, a.status
    FROM attendance a
    JOIN users u ON a.user_id = u.id
    ORDER BY a.date DESC
";

$result = $db->query($query);
$data = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $data[] = $row;
}

echo json_encode(['success' => true, 'data' => $data]);
?>