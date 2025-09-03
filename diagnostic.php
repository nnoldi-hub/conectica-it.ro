<?php
/**
 * Diagnostic Script pentru Hostico
 * Verifică ce fișiere au fost deploy-uite și unde se află
 */

echo "<!DOCTYPE html><html><head><title>Conectica IT - Diagnostic</title></head><body>";
echo "<h1>🔍 Diagnostic Conectica IT Portfolio</h1>";
echo "<p><strong>Data:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// Verifică directorul curent
echo "<h2>📁 Directorul curent:</h2>";
echo "<p><code>" . __DIR__ . "</code></p>";

// Listează fișierele din directorul curent
echo "<h2>📋 Fișiere în directorul curent:</h2>";
$files = scandir('.');
$php_files = [];
$other_files = [];

foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            $php_files[] = $file;
        } else {
            $other_files[] = $file;
        }
    }
}

echo "<h3>🐘 Fișiere PHP:</h3><ul>";
foreach ($php_files as $file) {
    echo "<li><a href='$file' target='_blank'>$file</a></li>";
}
echo "</ul>";

echo "<h3>📄 Alte fișiere:</h3><ul>";
foreach ($other_files as $file) {
    if (is_dir($file)) {
        echo "<li>📁 <strong>$file/</strong></li>";
    } else {
        echo "<li>$file</li>";
    }
}
echo "</ul>";

// Verifică dacă există subdirectoare importante
$important_dirs = ['admin', 'config', 'assets', 'includes'];
echo "<h2>📂 Directoare importante:</h2>";
foreach ($important_dirs as $dir) {
    if (is_dir($dir)) {
        echo "<p style='color:green'>✅ $dir/ - EXISTS</p>";
        
        // Listează fișierele din directorul admin
        if ($dir === 'admin') {
            $admin_files = scandir($dir);
            echo "<ul>";
            foreach ($admin_files as $file) {
                if ($file !== '.' && $file !== '..') {
                    echo "<li>$file</li>";
                }
            }
            echo "</ul>";
        }
    } else {
        echo "<p style='color:red'>❌ $dir/ - NOT FOUND</p>";
    }
}

// Verifică conexiunea la baza de date
echo "<h2>🗄️ Test Conexiune Baza de Date:</h2>";
if (file_exists('config/database.php')) {
    echo "<p style='color:green'>✅ Fișierul config/database.php există</p>";
    
    try {
        require_once 'config/database.php';
        $pdo = getDatabaseConnection();
        echo "<p style='color:green'>✅ Conexiunea la baza de date funcționează!</p>";
        
        // Verifică tabelele
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "<p>Tabele găsite: " . implode(', ', $tables) . "</p>";
        
    } catch (Exception $e) {
        echo "<p style='color:red'>❌ Eroare conexiune DB: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color:red'>❌ Fișierul config/database.php nu există</p>";
}

// Verifică permisiunile
echo "<h2>🔒 Permisiuni:</h2>";
$check_permissions = ['.', 'admin', 'config', 'assets'];
foreach ($check_permissions as $path) {
    if (file_exists($path)) {
        $perms = fileperms($path);
        $octal = sprintf('%o', $perms & 0777);
        echo "<p>$path: $octal</p>";
    }
}

// Link-uri pentru testare
echo "<h2>🔗 Link-uri de test:</h2>";
echo "<ul>";
echo "<li><a href='index.php' target='_blank'>Homepage (index.php)</a></li>";
echo "<li><a href='admin/login.php' target='_blank'>Admin Login</a></li>";
echo "<li><a href='projects.php' target='_blank'>Projects</a></li>";
echo "<li><a href='contact.php' target='_blank'>Contact</a></li>";
echo "</ul>";

// Informații server
echo "<h2>🖥️ Informații Server:</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

echo "<hr>";
echo "<p><small>© 2025 Conectica IT - Diagnostic Script</small></p>";
echo "</body></html>";
?>
