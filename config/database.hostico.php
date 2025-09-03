<?php
/**
 * Database Configuration pentru Hostico
 * 
 * Configurează conexiunea la baza de date MySQL
 * Pentru producție, folosește variabile de mediu pentru securitate
 */

// Database settings - CONFIGURATE PENTRU HOSTICO
define('DB_HOST', 'localhost'); // Sau server-ul MySQL de la Hostico
define('DB_USERNAME', 'ylcqhxpa_nnoldi'); // Username-ul bazei de date
define('DB_PASSWORD', 'PetreIonel205!');  // ACTUALIZEAZĂ CU PAROLA TA
define('DB_NAME', 'ylcqhxpa_conectica'); // Numele bazei de date
define('DB_CHARSET', 'utf8mb4');

// Connection function
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
        // În producție, nu afișa detalii despre erori
        if (isset($_ENV['ENVIRONMENT']) && $_ENV['ENVIRONMENT'] === 'development') {
            die("Connection failed: " . $e->getMessage());
        } else {
            die("Database connection error. Please try again later.");
        }
    }
}

// Test connection (doar pentru development)
function testDatabaseConnection() {
    try {
        $pdo = getDatabaseConnection();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
