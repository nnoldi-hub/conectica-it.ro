<?php
// Initialize the common bootstrap first
require_once __DIR__ . '/../includes/init.php';

// Then load the AuthSystem
require_once __DIR__ . '/AuthSystem.php';

$auth = new AuthSystem();

// Check if already logged in
if ($auth->isAuthenticated()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$error_code = '';
$csrf_token = $auth->generateCSRFToken();

if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $csrf_token_input = $_POST['csrf_token'] ?? '';
    $remember_me = isset($_POST['remember_me']);
    
    // Authenticate with enhanced security
    $result = $auth->authenticate($username, $password, $csrf_token_input, $remember_me);
    
    if ($result['success']) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = $result['error'];
        $error_code = $result['error_code'] ?? '';
        
        // Generate new CSRF token after failed attempt
        $csrf_token = $auth->generateCSRFToken();
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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 400px;
        }
        h1 { text-align: center; margin-bottom: 10px; font-size: 2rem; }
        .subtitle { text-align: center; margin-bottom: 30px; opacity: 0.8; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; }
        input[type="text"], input[type="password"], input[type="checkbox"] {
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 15px;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }
        input::placeholder { color: rgba(255, 255, 255, 0.6); }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 15px 0;
        }
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            padding: 0;
        }
        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .error {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid rgba(255, 0, 0, 0.5);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error.locked {
            background: rgba(255, 165, 0, 0.2);
            border-color: rgba(255, 165, 0, 0.5);
        }
        .demo-info {
            background: rgba(0, 150, 255, 0.2);
            border: 1px solid rgba(0, 150, 255, 0.5);
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .security-info {
            background: rgba(0, 255, 0, 0.15);
            border: 1px solid rgba(0, 255, 0, 0.3);
            padding: 10px;
            border-radius: 8px;
            margin: 15px 0;
            font-size: 12px;
            text-align: center;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .back-link a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>🛡️ Admin</h1>
        <p class="subtitle">Conectica IT - Nyikora Noldi</p>
        
        <?php if($error): ?>
            <div class="error <?php echo $error_code === 'ACCOUNT_LOCKED' ? 'locked' : ''; ?>">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" id="loginForm">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            
            <div class="form-group">
                <label for="username">Nume utilizator</label>
                <input type="text" id="username" name="username" 
                       placeholder="Introdu username" required 
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                       <?php echo $error_code === 'ACCOUNT_LOCKED' ? 'disabled' : ''; ?>>
            </div>
            
            <div class="form-group">
                <label for="password">Parolă</label>
                <input type="password" id="password" name="password" 
                       placeholder="Introdu parola" required
                       <?php echo $error_code === 'ACCOUNT_LOCKED' ? 'disabled' : ''; ?>>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="remember_me" name="remember_me"
                       <?php echo $error_code === 'ACCOUNT_LOCKED' ? 'disabled' : ''; ?>>
                <label for="remember_me">Ține-mă minte (30 zile)</label>
            </div>
            
            <button type="submit" name="login" class="btn"
                    <?php echo $error_code === 'ACCOUNT_LOCKED' ? 'disabled' : ''; ?>>
                🔑 Conectează-te
            </button>
        </form>
        
        <div class="demo-info">
            <strong>📋 Credențiale Demo:</strong><br>
            Username: <strong>admin</strong><br>
            Password: <strong>demo123</strong>
        </div>
        
        <div class="security-info">
            🔐 <strong>Securitate:</strong> CSRF Protection • Session Management • Rate Limiting
        </div>
        
        <div class="back-link">
            <a href="../index.php">← Înapoi la site</a>
        </div>
    </div>

    <script>
        // Enhanced form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                alert('Te rog completează toate câmpurile.');
                return;
            }
            
            if (username.length < 3) {
                e.preventDefault();
                alert('Username-ul trebuie să aibă cel puțin 3 caractere.');
                return;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Parola trebuie să aibă cel puțin 6 caractere.');
                return;
            }
        });
        
        // Auto-unlock form after lockout period
        <?php if($error_code === 'ACCOUNT_LOCKED'): ?>
        setTimeout(function() {
            location.reload();
        }, 15 * 60 * 1000); // 15 minutes
        <?php endif; ?>
    </script>
</body>
</html>