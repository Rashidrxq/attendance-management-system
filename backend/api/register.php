<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../db/db.php';
// your other code here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for required fields
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['role']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])) {
        die("⚠️ All required fields were not provided!");
    }

    // Assign all variables from the form
    $username = trim($_POST['username']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']) ?? null; // Optional field
    $address = trim($_POST['address']) ?? null;       // Optional field
    $password = $_POST['password'];
    $role = $_POST['role']; // should be 'student', 'teacher', or 'employee'

    // Check if username or email already exists
    $stmt = $db->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result->fetchArray()) {
        die("⚠️ Username or Email already taken!");
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the INSERT statement with all new fields
    $stmt = $db->prepare("INSERT INTO users (username, first_name, last_name, email, department, address, password, role)
                         VALUES (:username, :first_name, :last_name, :email, :department, :address, :password, :role)");

    // Bind all values to the statement
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':first_name', $first_name, SQLITE3_TEXT);
    $stmt->bindValue(':last_name', $last_name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':department', $department, SQLITE3_TEXT);
    $stmt->bindValue(':address', $address, SQLITE3_TEXT);
    $stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
    $stmt->bindValue(':role', $role, SQLITE3_TEXT);

    // Execute the statement
    if ($stmt->execute()) {
        echo "✅ Registered successfully. <a href='/atm/frontend/index.html'>Click here to login</a>";
    } else {
        echo "❌ Registration failed.";
    }
}
?>