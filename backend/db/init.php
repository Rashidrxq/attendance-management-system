<?php
$db = new SQLite3(__DIR__ . '/database.sqlite');

// Create a more complete users table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    first_name TEXT,
    last_name TEXT,
    email TEXT UNIQUE,
    department TEXT,
    address TEXT,
    password TEXT NOT NULL,
    role TEXT NOT NULL
)");

// Create the attendance table (no changes needed here)
$db->exec("CREATE TABLE IF NOT EXISTS attendance (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    date TEXT,
    status TEXT,
    FOREIGN KEY(user_id) REFERENCES users(id)
)");

echo "Database initialized with updated user table.";
?>