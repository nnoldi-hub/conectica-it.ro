<?php
/**
 * Database Configuration pentru Hostico Production
 * Configurează conexiunea la baza de date MySQL
 */

// Database settings - PRE-CONFIGURATE PENTRU HOSTICO
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'ylcqhxpa_nnoldi');
define('DB_PASSWORD', 'NEEDS_PASSWORD');  // VA FI SETAT PRIN configure.php
define('DB_NAME', 'ylcqhxpa_conectica');
define('DB_CHARSET', 'utf8mb4');

// Connection function
function getDatabaseConnection() {
    try {
        // Verifică dacă parola nu este setată
        if (DB_PASSWORD === 'NEEDS_PASSWORD') {
            throw new PDOException("Database password not configured. Please run configure.php first.");
        }
        
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
        return $pdo;
        
    } catch (PDOException $e) {
        // În producție, nu afișa detalii despre erori sensibile
        if (strpos($e->getMessage(), 'password not configured') !== false) {
            die("Database not configured. Please access configure.php to set up the database connection.");
        }
        
        // Log eroarea pentru debugging
        error_log("Database connection error: " . $e->getMessage());
        die("Database connection error. Please check configuration.");
    }
}

// Test connection
function testDatabaseConnection() {
    try {
        $pdo = getDatabaseConnection();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
