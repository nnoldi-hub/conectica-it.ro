<!DOCTYPE html>
<html>
<head>
    <title>Test Simple</title>
</head>
<body>
    <h1>PAGINA DE TEST FUNCȚIONEAZĂ!</h1>
    <p>Data: <?php echo date('Y-m-d H:i:s'); ?></p>
    
    <div style="background: #f0f0f0; padding: 20px; margin: 20px 0; border: 2px solid #333;">
        <h2>LOGIN SIMPLU</h2>
        <form method="POST">
            <p>
                Username: <input type="text" name="user" placeholder="admin">
            </p>
            <p>
                Password: <input type="password" name="pass" placeholder="demo123">
            </p>
            <p>
                <button type="submit" name="login" style="padding: 10px 20px; background: blue; color: white; border: none;">LOGIN</button>
            </p>
        </form>
        
        <?php
        if(isset($_POST['login'])) {
            $user = $_POST['user'] ?? '';
            $pass = $_POST['pass'] ?? '';
            
            if($user == 'admin' && $pass == 'demo123') {
                echo '<p style="color: green; font-weight: bold;">✅ LOGIN REUȘIT!</p>';
                echo '<a href="dashboard.php" style="background: green; color: white; padding: 10px; text-decoration: none;">DASHBOARD</a>';
            } else {
                echo '<p style="color: red;">❌ LOGIN EȘUAT!</p>';
            }
        }
        ?>
    </div>
    
    <p><a href="../index.php">← Înapoi la site</a></p>
</body>
</html>
