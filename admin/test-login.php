<!DOCTYPE html>
<html>
<head>
    <title>Test Login</title>
</head>
<body>
    <h1>LOGIN TEST</h1>
    <p>Dacă vezi acest mesaj, serverul PHP funcționează!</p>
    <p>Data curentă: <?php echo date('Y-m-d H:i:s'); ?></p>
    
    <form method="POST" action="">
        <h3>Login Admin</h3>
        
        <?php
        if(isset($_POST['login'])) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if($username === 'admin' && $password === 'demo123') {
                echo '<p style="color: green;">✅ LOGIN SUCCESS!</p>';
                echo '<a href="dashboard.php">Du-te la Dashboard</a>';
            } else {
                echo '<p style="color: red;">❌ Credențiale greșite!</p>';
            }
        }
        ?>
        
        <p>
            <label>Username:</label><br>
            <input type="text" name="username" placeholder="admin" required>
        </p>
        <p>
            <label>Password:</label><br>
            <input type="password" name="password" placeholder="demo123" required>
        </p>
        <p>
            <button type="submit" name="login">LOGIN</button>
        </p>
    </form>
    
    <p><a href="../index.php">Înapoi la site</a></p>
</body>
</html>
