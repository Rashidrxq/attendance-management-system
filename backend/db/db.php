<?php
// This establishes a connection to the SQLite database.
// Include this file in any script that needs to access the database.
try {
    $db = new SQLite3(__DIR__ . '/database.sqlite');
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>