<?php
/**
 * Database Configuration pentru Hostico Production
 * Configurare directă și simplă
 */

// Database settings - CONFIGURATE DIRECT PENTRU HOSTICO
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'ylcqhxpa_nnoldi');
define('DB_PASSWORD', 'PetreIonel205!');
define('DB_NAME', 'ylcqhxpa_conectica');
define('DB_CHARSET', 'utf8mb4');

// Connection function - versiune simplificată
function getDatabaseConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
        return $pdo;
        
    } catch (PDOException $e) {
        die("Database connection error: " . $e->getMessage());
    }
}

// Test simplu de conexiune
function testDatabaseConnection() {
    try {
        $pdo = getDatabaseConnection();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Test rapid la încărcare
try {
    $test_connection = getDatabaseConnection();
    // echo "✅ Database connection OK!";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage();
}
?>
