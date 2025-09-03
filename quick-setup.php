<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>🔧 Setup Rapid - Conectica IT</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: #f0f0f0; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { background: #cce7ff; color: #004085; padding: 15px; border-radius: 5px; margin: 10px 0; }
        a { color: #007bff; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Setup Rapid Conectica IT</h1>
        
        <?php
        // Creează fișierul database.php direct
        $database_content = '<?php
define("DB_HOST", "localhost");
define("DB_USERNAME", "ylcqhxpa_nnoldi");
define("DB_PASSWORD", "PetreIonel205!");
define("DB_NAME", "ylcqhxpa_conectica");
define("DB_CHARSET", "utf8mb4");

function getDatabaseConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
    } catch (PDOException $e) {
        throw new Exception("Database connection failed: " . $e->getMessage());
    }
}

function testDatabaseConnection() {
    try {
        getDatabaseConnection();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>';

        // Salvează fișierul
        if (!file_exists('config')) {
            mkdir('config', 0755, true);
        }
        file_put_contents('config/database.php', $database_content);
        echo '<div class="success">✅ Fișierul config/database.php a fost creat!</div>';
        
        // Testează conexiunea
        require_once 'config/database.php';
        
        try {
            $pdo = getDatabaseConnection();
            echo '<div class="success">✅ Conexiunea la baza de date funcționează perfect!</div>';
            
            // Verifică tabelele
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (count($tables) > 0) {
                echo '<div class="success">✅ Baza de date conține ' . count($tables) . ' tabele!</div>';
                
                // Verifică admin user
                $stmt = $pdo->query("SELECT COUNT(*) FROM admins WHERE username = 'admin'");
                $admin_exists = $stmt->fetchColumn();
                
                if ($admin_exists) {
                    echo '<div class="success">✅ Utilizatorul admin există!</div>';
                } else {
                    echo '<div class="info">ℹ️ Utilizatorul admin nu există, dar baza de date este configurată.</div>';
                }
                
                echo '<div class="success">
                    <h3>🎉 Setup complet finalizat!</h3>
                    <p><strong>Site-ul este gata de utilizare:</strong></p>
                    <p><a href="index.php">🏠 Vezi Site-ul Principal</a></p>
                    <p><a href="admin/login.php">🔐 Acces Admin</a> (admin / demo123)</p>
                    <p><a href="projects.php">📁 Vezi Proiectele</a></p>
                    <p><a href="contact.php">📞 Pagina Contact</a></p>
                </div>';
                
            } else {
                echo '<div class="error">❌ Baza de date este goală! Trebuie să imporți install.sql prin phpMyAdmin.</div>';
                echo '<div class="info">
                    <p><strong>Pași următori:</strong></p>
                    <ol>
                        <li>Mergi în cPanel → phpMyAdmin</li>
                        <li>Selectează baza ylcqhxpa_conectica</li>
                        <li>Import → Alege install.sql</li>
                        <li>Apasă Go pentru import</li>
                    </ol>
                </div>';
            }
            
        } catch (Exception $e) {
            echo '<div class="error">❌ Eroare la conexiunea cu baza de date:</div>';
            echo '<div class="error">' . htmlspecialchars($e->getMessage()) . '</div>';
            echo '<div class="info">
                <p><strong>Posibile soluții:</strong></p>
                <ul>
                    <li>Verifică că baza de date ylcqhxpa_conectica există</li>
                    <li>Verifică că utilizatorul ylcqhxpa_nnoldi are acces la baza de date</li>
                    <li>Verifică parola bazei de date în cPanel</li>
                </ul>
            </div>';
        }
        ?>
    </div>
</body>
</html>
