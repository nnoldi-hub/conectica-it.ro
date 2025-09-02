<?php
include '../config/database.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND is_active = 1");
    $stmt->execute(['admin']);
    $admin = $stmt->fetch();
    
    if($admin) {
        echo "✅ Admin găsit în baza de date:<br>";
        echo "Username: " . $admin['username'] . "<br>";
        echo "Email: " . $admin['email'] . "<br>";
        echo "Hash parola: " . substr($admin['password_hash'], 0, 20) . "...<br>";
        
        $password_check = password_verify('demo123', $admin['password_hash']);
        echo "Parola demo123 validă: " . ($password_check ? "✅ DA" : "❌ NU") . "<br>";
    } else {
        echo "❌ Admin nu găsit în baza de date";
    }
} catch(Exception $e) {
    echo "❌ Eroare conexiune: " . $e->getMessage();
}
?>
