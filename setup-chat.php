<?php
/**
 * Script de configurare automată chat pentru server
 * Rulează acest script o singură dată pe server pentru a activa chat-ul
 */

require_once __DIR__ . '/includes/init.php';

$configFile = CONFIG_PATH . '/config.php';
$backupFile = CONFIG_PATH . '/config.php.backup';

echo "<!DOCTYPE html><html><head><title>Setup Chat - Conectica-IT</title>";
echo "<style>body{font-family:Arial;margin:40px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style></head><body>";
echo "<h1>🔧 Configurare Chat Conectica-IT</h1>";

// Backup config existent
if (file_exists($configFile) && !file_exists($backupFile)) {
    copy($configFile, $backupFile);
    echo "<p class='info'>✓ Backup config creat: config.php.backup</p>";
}

// Configurația de chat
$chatConfig = "<?php 
define('SITE_NAME','Conectica‑IT — Nyikora Noldi');
define('BASE_URL','https://conectica-it.ro');
define('CONTACT_EMAIL', 'conectica.it.ro@gmail.com');
define('CONTACT_PHONE', '0740173581');
define('WEBSITE_URL', 'conectica-it.ro');

// Live chat settings - ACTIVAT
define('CHAT_ENABLED', true);
define('CHAT_PROVIDER', 'tawk');

// Tawk.to IDs - Configurate pentru Conectica-IT
define('CHAT_TAWK_PROPERTY_ID', '68ba8c61b1986019272e8bdf');
define('CHAT_TAWK_WIDGET_ID', '1j4cb8n2t');

// Crisp (backup, nu e folosit)
define('CHAT_CRISP_WEBSITE_ID', '');

// UI controls - Optimizate
define('CHAT_FLOAT_BUTTON', true);           // Buton floating Chat 
define('CHAT_HIDE_PROVIDER_BADGE', true);    // Ascunde bubble-ul Tawk pentru design curat
?>";

// Scrie configurația
$success = file_put_contents($configFile, $chatConfig);

if ($success) {
    echo "<p class='success'>✅ Configurația chat a fost activată cu succes!</p>";
    
    // Re-include config pentru a verifica
    include $configFile;
    echo "<p class='success'>✓ CHAT_ENABLED: " . (defined('CHAT_ENABLED') && CHAT_ENABLED ? 'Activat' : 'Dezactivat') . "</p>";
    echo "<p class='info'>✓ Provider: " . (defined('CHAT_PROVIDER') ? CHAT_PROVIDER : 'nedefinit') . "</p>";
    echo "<p class='info'>✓ Tawk Property ID: " . (defined('CHAT_TAWK_PROPERTY_ID') ? CHAT_TAWK_PROPERTY_ID : 'nedefinit') . "</p>";
    echo "<p class='info'>✓ Tawk Widget ID: " . (defined('CHAT_TAWK_WIDGET_ID') ? CHAT_TAWK_WIDGET_ID : 'nedefinit') . "</p>";
    echo "<p class='info'>✓ Buton floating: " . (defined('CHAT_FLOAT_BUTTON') && CHAT_FLOAT_BUTTON ? 'Activat' : 'Dezactivat') . "</p>";
    
} else {
    echo "<p class='error'>❌ Eroare la scrierea fișierului config.php</p>";
    echo "<p class='error'>Verifică permisiunile pentru directorul config/</p>";
}

echo "<hr>";
echo "<h2>🎯 Următorii pași:</h2>";
echo "<ol>";
echo "<li><strong>Testează chat-ul:</strong> <a href='/chat-status.php' target='_blank'>Verifică status chat</a></li>";
echo "<li><strong>Configurează Tawk.to:</strong> <a href='/docs/tawk-setup-guide.md' target='_blank'>Ghid complet setup</a></li>";
echo "<li><strong>Vezi homepage:</strong> <a href='/index.php' target='_blank'>Testează widget live</a></li>";
echo "</ol>";

echo "<h3>🔗 Links utile:</h3>";
echo "<ul>";
echo "<li><a href='https://dashboard.tawk.to/68ba8c61b1986019272e8bdf' target='_blank'>Dashboard Tawk.to</a></li>";
echo "<li><a href='https://wa.me/40740173581' target='_blank'>Test WhatsApp</a></li>";
echo "<li><a href='/projects.php' target='_blank'>Test trigger proiecte</a></li>";
echo "</ul>";

echo "<div style='background:#f0f9ff;padding:15px;margin:20px 0;border-left:4px solid #0ea5e9;'>";
echo "<h4>💡 Pro Tips:</h4>";
echo "<ul>";
echo "<li>Widget-ul apare în <strong>dreapta jos</strong> pe toate paginile</li>";
echo "<li>Butonul 'Chat' este floating - se poate ascunde din config</li>";
echo "<li>Tawk bubble-ul original este ascuns pentru design curat</li>";
echo "<li>Vezi <code>docs/tawk-setup-guide.md</code> pentru configurare completă</li>";
echo "</ul></div>";

// Cleanup reminder
echo "<hr><p class='info'>🗑️ Pentru securitate, șterge acest fișier după configurare: <code>rm setup-chat.php</code></p>";

echo "</body></html>";
?>
