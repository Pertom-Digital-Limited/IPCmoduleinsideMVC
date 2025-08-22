<?php
// Display errors during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database settings, change as per your environment
define('DB_HOST', 'localhost');
define('DB_NAME', 'ipctask1'); 
define('DB_USER', 'root');           // default XAMPP user
define('DB_PASS', '');               

// Base URL (adjust if you use subfolder e.g., http://localhost/mvc-athlete/)
define('BASE_URL', 'http://localhost/');

// Database connection (PDO)
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
