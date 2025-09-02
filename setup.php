<?php
/**
 * Setup Script pentru Hostico
 * Rulează acest script o singură dată pentru a configura site-ul
 */

// Verifică dacă site-ul este deja configurat
if (file_exists('setup.lock')) {
    die('Site-ul este deja configurat! Șterge fișierul setup.lock pentru a reconfigura.');
}

echo "<h1>🚀 Configurare Conectica IT Portfolio pe Hostico</h1>";

// Verifică dacă există baza de date
try {
    require_once 'config/database.php';
    $pdo = getDatabaseConnection();
    echo "<p style='color:green'>✅ Conexiunea la baza de date funcționează!</p>";
    
    // Verifică dacă tabelele există
    $tables = ['admins', 'projects', 'blog_posts', 'contact_messages', 'quote_requests', 'seo_settings'];
    $existing_tables = [];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            $existing_tables[] = $table;
        }
    }
    
    if (count($existing_tables) === count($tables)) {
        echo "<p style='color:green'>✅ Toate tabelele există în baza de date!</p>";
        
        // Verifică dacă există admin user
        $stmt = $pdo->query("SELECT COUNT(*) FROM admins WHERE username = 'admin'");
        $admin_exists = $stmt->fetchColumn();
        
        if ($admin_exists) {
            echo "<p style='color:green'>✅ Utilizatorul admin există!</p>";
        } else {
            echo "<p style='color:orange'>⚠️ Utilizatorul admin nu există. Creez unul implicit...</p>";
            
            // Creează admin user
            $password_hash = password_hash('demo123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admins (username, password_hash, name, email, phone, bio) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                'admin',
                $password_hash,
                'Nyikora Noldi',
                'conectica.it.ro@gmail.com',
                '0740173581',
                'Dezvoltator web freelancer specializat în soluții IT moderne și inovatoare.'
            ]);
            echo "<p style='color:green'>✅ Admin user creat cu succes!</p>";
        }
        
    } else {
        echo "<p style='color:red'>❌ Lipsesc tabele din baza de date!</p>";
        echo "<p>Tabele existente: " . implode(', ', $existing_tables) . "</p>";
        echo "<p><strong>Soluție:</strong> Importă fișierul install.sql în phpMyAdmin.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Eroare la conexiunea cu baza de date:</p>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "<p><strong>Soluții:</strong></p>";
    echo "<ul>";
    echo "<li>1. Verifică datele din config/database.php</li>";
    echo "<li>2. Asigură-te că baza de date există în cPanel</li>";
    echo "<li>3. Verifică username-ul și parola bazei de date</li>";
    echo "</ul>";
}

// Verifică permisiunile dosarelor
$directories = ['admin/', 'config/', 'assets/images/'];
echo "<h3>📁 Verificare Permisiuni</h3>";

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "<p style='color:green'>✅ $dir - permisiuni OK</p>";
        } else {
            echo "<p style='color:orange'>⚠️ $dir - permisiuni limitate</p>";
        }
    } else {
        echo "<p style='color:red'>❌ $dir - directorul nu există</p>";
    }
}

// Creează fișierul de blocare
if (!isset($e)) { // Dacă nu au fost erori
    file_put_contents('setup.lock', date('Y-m-d H:i:s') . "\nSite configurat cu succes pe Hostico\n");
    echo "<p style='color:green; font-weight:bold'>✅ Configurarea s-a finalizat cu succes!</p>";
    echo "<p><a href='index.php' style='padding:10px 20px; background:blue; color:white; text-decoration:none; border-radius:5px'>Vezi Site-ul</a> ";
    echo "<a href='admin/login.php' style='padding:10px 20px; background:green; color:white; text-decoration:none; border-radius:5px; margin-left:10px'>Admin Panel</a></p>";
    echo "<hr>";
    echo "<p><strong>Credențiale Admin:</strong></p>";
    echo "<p>URL: <code>" . $_SERVER['HTTP_HOST'] . "/admin/login.php</code></p>";
    echo "<p>Username: <code>admin</code></p>";
    echo "<p>Password: <code>demo123</code></p>";
    echo "<p style='color:red'><strong>⚠️ IMPORTANT:</strong> Schimbă parola din admin panel!</p>";
} else {
    echo "<p style='color:red; font-weight:bold'>❌ Configurarea nu s-a finalizat din cauza erorilor de mai sus.</p>";
}

echo "<hr>";
echo "<p><small>© 2025 Conectica IT - Nyikora Noldi</small></p>";
?>
