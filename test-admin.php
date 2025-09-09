<?php
require_once 'includes/init.php';

echo "<h2>Test Admin User</h2>";

try {
    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute(['admin']);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo "<p style='color: green;'>✓ Admin user exists!</p>";
        echo "<ul>";
        echo "<li>Username: " . htmlspecialchars($admin['username']) . "</li>";
        echo "<li>Email: " . htmlspecialchars($admin['email']) . "</li>";
        echo "<li>Name: " . htmlspecialchars($admin['name'] ?? 'Not set') . "</li>";
        echo "<li>Phone: " . htmlspecialchars($admin['phone'] ?? 'Not set') . "</li>";
        echo "<li>Created: " . htmlspecialchars($admin['created_at']) . "</li>";
        echo "</ul>";
        
        // Test password verification
        echo "<h3>Password Test</h3>";
        if (password_verify('demo123', $admin['password_hash'])) {
            echo "<p style='color: green;'>✓ Password verification works!</p>";
        } else {
            echo "<p style='color: red;'>✗ Password verification failed!</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Admin user not found!</p>";
        
        // Create admin user
        echo "<h3>Creating admin user...</h3>";
        $password_hash = password_hash('demo123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admins (username, email, password_hash, name, phone, bio, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute(['admin', 'conectica.it.ro@gmail.com', $password_hash, 'Nyikora Noldi', '0740173581', 'Dezvoltator web freelancer specializat în soluții IT moderne și inovatoare.', 'admin'])) {
            echo "<p style='color: green;'>✓ Admin user created successfully!</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to create admin user!</p>";
        }
    }
    
    // Check site_settings table
    echo "<h3>Site Settings Table</h3>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'site_settings'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ site_settings table exists!</p>";
        
        $stmt = $pdo->query("SELECT * FROM site_settings");
        $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($settings) {
            echo "<p>Current settings:</p><ul>";
            foreach ($settings as $setting) {
                echo "<li>" . htmlspecialchars($setting['setting_key']) . ": " . htmlspecialchars($setting['setting_value']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No settings found in table.</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠ site_settings table doesn't exist - will be created when settings are saved</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<p><a href='admin/' style='color: blue;'>Go to Admin Panel</a></p>";
?>
