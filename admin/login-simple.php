<?php
// Simple login fallback for admin access
require_once __DIR__ . '/../includes/init.php';

session_start();

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple hardcoded credentials for emergency access
    if ($username === 'admin' && $password === 'demo123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = 'admin';
        $_SESSION['login_time'] = time();
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Username sau parolă incorectă!';
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Conectica IT</title>
    <style>
        body { font-family: Arial; background: #1a1a2e; color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .login-box { background: rgba(255,255,255,0.1); padding: 40px; border-radius: 15px; text-align: center; max-width: 400px; width: 90%; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: none; border-radius: 8px; background: rgba(255,255,255,0.2); color: white; }
        input::placeholder { color: rgba(255,255,255,0.7); }
        button { width: 100%; padding: 12px; background: #667eea; border: none; border-radius: 8px; color: white; font-weight: bold; cursor: pointer; margin-top: 10px; }
        button:hover { background: #5a6fd8; }
        .error { background: rgba(255,0,0,0.3); padding: 10px; border-radius: 8px; margin-bottom: 15px; }
        .demo { background: rgba(0,150,255,0.3); padding: 15px; border-radius: 8px; margin: 15px 0; }
        a { color: #667eea; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🛡️ Admin Simple</h1>
        <p>Conectica IT - Emergency Access</p>
        
        <?php if($error): ?>
            <div class="error">⚠️ <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">🔑 Login</button>
        </form>
        
        <div class="demo">
            <strong>Demo:</strong><br>
            Username: <strong>admin</strong><br>
            Password: <strong>demo123</strong>
        </div>
        
        <p><a href="../index.php">← Back to site</a></p>
        <p><a href="login.php">Advanced Login</a></p>
    </div>
</body>
</html>
