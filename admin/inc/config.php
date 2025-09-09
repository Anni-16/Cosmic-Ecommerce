<?php
// Turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Prev Database configuration
$dbhost = 'localhost';
$dbname = 'cosmicenergies_db';
$dbuser = 'root';
$dbpass = '';

// Current Database configuration
// $dbhost = 'localhost';
// $dbname = 'cosm_db';
// $dbuser = 'cosm_user';
// $dbpass = 'ptuKkkEjhHIkmsq%';

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Show connection error
    die("Connection failed: " . $e->getMessage());
}
