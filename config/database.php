<?php
/**
 * Database Configuration
 * 
 * Configurează conexiunea la baza de date MySQL
 * Pentru producție, folosește variabile de mediu pentru securitate
 */

// Database settings - configurate pentru Hostico
// Folosește database.local.php DOAR în mediu local (Windows/localhost)
$__isLocal = false;
// Detect Windows dev or localhost domains/IPs
if (stripos(PHP_OS_FAMILY ?? '', 'Windows') !== false) {
    $__isLocal = true;
}
if (!empty($_SERVER['SERVER_NAME'])) {
    $sn = strtolower($_SERVER['SERVER_NAME']);
    if (in_array($sn, ['localhost', '127.0.0.1']) || str_ends_with($sn, '.local') || str_ends_with($sn, '.test')) {
        $__isLocal = true;
    }
}
if (in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1','::1'])) {
    $__isLocal = true;
}

if ($__isLocal && file_exists(__DIR__ . '/database.local.php')) {
    require_once __DIR__ . '/database.local.php';
} else {
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'ylcqhxpa_nnoldi');
    define('DB_PASSWORD', 'PetreIonel205!');
    define('DB_NAME', 'ylcqhxpa_conectica');
    define('DB_CHARSET', 'utf8mb4');
}
unset($__isLocal);

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