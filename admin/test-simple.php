<?php
// Test rapid pentru admin
echo "<h1>Test Admin</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";

// Test bootstrap
try {
    require_once __DIR__ . '/../includes/init.php';
    echo "<p>✅ Bootstrap loaded successfully</p>";
    
    // Test constants
    if (defined('SITE_NAME')) {
        echo "<p>✅ SITE_NAME: " . SITE_NAME . "</p>";
    } else {
        echo "<p>❌ SITE_NAME not defined</p>";
    }
    
    // Test database
    if (isset($pdo)) {
        echo "<p>✅ Database connection available</p>";
    } else {
        echo "<p>❌ Database connection not available</p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='login.php'>Back to login</a></p>";
?>
