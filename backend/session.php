
<?php
session_start();

function require_login() {
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Not logged in.']);
        exit;
    }
}
?>