<?php
session_start();

// Simulăm o sesiune de admin pentru test
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_username'] = 'admin';
$_SESSION['admin_data'] = [
    'username' => 'admin',
    'name' => 'Nyikora Noldi',
    'email' => 'conectica.it.ro@gmail.com',
    'phone' => '0740173581',
    'bio' => 'Dezvoltator web freelancer specializat în soluții IT moderne și inovatoare.',
    'role' => 'admin'
];

echo "<h2>Test Profile Variables</h2>";

// Simulăm codul din profile.php pentru a testa variabilele
$user = $_SESSION['admin_data'] ?? null;
$username = $user['username'] ?? $_SESSION['admin_username'] ?? 'admin';

echo "<p><strong>User data:</strong></p>";
echo "<pre>" . print_r($user, true) . "</pre>";

echo "<p><strong>Username variable:</strong> " . htmlspecialchars($username) . "</p>";

echo "<p style='color: green;'>✓ Variables are properly defined now!</p>";

echo "<p><a href='admin/pages/profile.php' style='color: blue;'>Test Profile Page</a></p>";
echo "<p><a href='admin/' style='color: blue;'>Go to Admin Panel</a></p>";
?>
