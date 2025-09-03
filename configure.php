<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Configurare Finală - Conectica IT</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #34495e; }
        input[type="password"], input[type="text"] { width: 100%; padding: 12px; border: 2px solid #bdc3c7; border-radius: 5px; font-size: 16px; }
        input:focus { border-color: #3498db; outline: none; }
        button { background: #3498db; color: white; padding: 12px 25px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        button:hover { background: #2980b9; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .info { background: #cce7ff; color: #004085; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .readonly { background-color: #f8f9fa; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Configurare Finală - Conectica IT</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['db_password'])) {
            $password = $_POST['db_password'];
            
            // Actualizează fișierul database.php
            $config_content = file_get_contents('config/database.php');
            $config_content = str_replace('SET_YOUR_PASSWORD_HERE', $password, $config_content);
            file_put_contents('config/database.php', $config_content);
            
            // Testează conexiunea
            require_once 'config/database.php';
            try {
                $pdo = getDatabaseConnection();
                echo '<div class="success">✅ Conexiunea la baza de date funcționează perfect!</div>';
                
                // Verifică dacă tabelele există
                $stmt = $pdo->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                if (count($tables) === 0) {
                    echo '<div class="error">❌ Baza de date este goală! Trebuie să imporți install.sql prin phpMyAdmin.</div>';
                    echo '<div class="info">
                        <strong>Pași următori:</strong><br>
                        1. Mergi în cPanel → phpMyAdmin<br>
                        2. Selectează baza de date: ylcqhxpa_conectica<br>
                        3. Apasă pe Import<br>
                        4. Alege fișierul install.sql din proiect<br>
                        5. Apasă Go pentru import<br>
                        6. Revin la această pagină
                    </div>';
                } else {
                    echo '<div class="success">✅ Tabelele există în baza de date!</div>';
                    
                    // Creează fișierul de blocare
                    file_put_contents('setup.lock', date('Y-m-d H:i:s') . " - Configurat cu succes!\n");
                    
                    echo '<div class="success">
                        <h3>🎉 Configurarea s-a finalizat cu succes!</h3>
                        <p><strong>Credențiale admin implicite:</strong></p>
                        <p>Username: <code>admin</code><br>
                        Parola: <code>demo123</code></p>
                        <p><a href="admin/login.php" style="color: #3498db; text-decoration: none;">🔐 Accesează Panoul Admin</a></p>
                        <p><a href="index.php" style="color: #3498db; text-decoration: none;">🏠 Vezi Site-ul</a></p>
                    </div>';
                }
                
            } catch (Exception $e) {
                echo '<div class="error">❌ Eroare: ' . htmlspecialchars($e->getMessage()) . '</div>';
                echo '<div class="info">Verifică parola introdusă și încearcă din nou.</div>';
            }
        } else {
        ?>
        
        <div class="info">
            <strong>📋 Informații detectate:</strong><br>
            Database Host: localhost<br>
            Database User: ylcqhxpa_nnoldi<br>
            Database Name: ylcqhxpa_conectica
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label>Database Host:</label>
                <input type="text" value="localhost" readonly class="readonly">
            </div>
            
            <div class="form-group">
                <label>Database Username:</label>
                <input type="text" value="ylcqhxpa_nnoldi" readonly class="readonly">
            </div>
            
            <div class="form-group">
                <label>Database Name:</label>
                <input type="text" value="ylcqhxpa_conectica" readonly class="readonly">
            </div>
            
            <div class="form-group">
                <label for="db_password">Database Password: *</label>
                <input type="password" name="db_password" id="db_password" required placeholder="Introdu parola bazei de date...">
                <small style="color: #7f8c8d;">Parola pe care ai setat-o când ai creat baza de date în cPanel</small>
            </div>
            
            <button type="submit">🔧 Configurează și Testează</button>
        </form>
        
        <?php } ?>
    </div>
</body>
</html>
