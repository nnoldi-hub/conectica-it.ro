<?php
// Test simplu pentru debugging 500 error
echo "<h1>🔧 Test PHP</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Time: " . date('Y-m-d H:i:s') . "</p>";

// Test database connection
echo "<h2>Database Test:</h2>";
try {
    require_once 'config/database.php';
    $pdo = getDatabaseConnection();
    echo "<p style='color: green'>✅ Database connection OK!</p>";
} catch (Exception $e) {
    echo "<p style='color: red'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test config
echo "<h2>Config Test:</h2>";
try {
    require_once 'config/config.php';
    echo "<p style='color: green'>✅ Config loaded OK!</p>";
    echo "<p>Site Name: " . SITE_NAME . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red'>❌ Config error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test includes
echo "<h2>Includes Test:</h2>";
try {
    if (file_exists('includes/head.php')) {
        echo "<p style='color: green'>✅ includes/head.php exists</p>";
    } else {
        echo "<p style='color: red'>❌ includes/head.php missing</p>";
    }
    
    if (file_exists('includes/seo.php')) {
        echo "<p style='color: green'>✅ includes/seo.php exists</p>";
    } else {
        echo "<p style='color: red'>❌ includes/seo.php missing</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red'>❌ Includes error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>Test index.php</a> | <a href='admin/login.php'>Test Admin</a></p>";
?>
