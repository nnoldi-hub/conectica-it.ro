<?php
/**
 * Authentication System
 * Secure authentication with session management and CSRF protection
 */

class AuthSystem {
    private $db;
    private $session_timeout = 3600; // 1 hour
    private $max_login_attempts = 5;
    private $lockout_duration = 900; // 15 minutes
    
    public function __construct($database = null) {
        if ($database) {
            $this->db = $database;
        }
        $this->initSession();
    }
    
    /**
     * Initialize secure session
     */
    private function initSession() {
        if (session_status() == PHP_SESSION_NONE) {
            // Secure session configuration
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
            ini_set('session.cookie_samesite', 'Strict');
            
            session_start();
            
            // Regenerate session ID periodically
            if (!isset($_SESSION['created'])) {
                $_SESSION['created'] = time();
            } else if (time() - $_SESSION['created'] > 1800) {
                session_regenerate_id(true);
                $_SESSION['created'] = time();
            }
        }
    }
    
    /**
     * Generate CSRF token
     */
    public function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token
     */
    public function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Check if user is locked out due to failed login attempts
     */
    private function isLockedOut($username) {
        if (!isset($_SESSION['login_attempts'][$username])) {
            return false;
        }
        
        $attempts = $_SESSION['login_attempts'][$username];
        if ($attempts['count'] >= $this->max_login_attempts) {
            if (time() - $attempts['last_attempt'] < $this->lockout_duration) {
                return true;
            } else {
                // Reset attempts after lockout period
                unset($_SESSION['login_attempts'][$username]);
            }
        }
        
        return false;
    }
    
    /**
     * Record failed login attempt
     */
    private function recordFailedAttempt($username) {
        if (!isset($_SESSION['login_attempts'][$username])) {
            $_SESSION['login_attempts'][$username] = [
                'count' => 0,
                'last_attempt' => 0
            ];
        }
        
        $_SESSION['login_attempts'][$username]['count']++;
        $_SESSION['login_attempts'][$username]['last_attempt'] = time();
    }
    
    /**
     * Clear failed login attempts
     */
    private function clearFailedAttempts($username) {
        if (isset($_SESSION['login_attempts'][$username])) {
            unset($_SESSION['login_attempts'][$username]);
        }
    }
    
    /**
     * Authenticate user with enhanced security
     */
    public function authenticate($username, $password, $csrf_token = null, $remember_me = false) {
        // Validate CSRF token if provided
        if ($csrf_token && !$this->validateCSRFToken($csrf_token)) {
            return [
                'success' => false,
                'error' => 'Invalid security token. Please refresh and try again.',
                'error_code' => 'CSRF_INVALID'
            ];
        }
        
        // Input validation
        $username = trim($username);
        if (empty($username) || empty($password)) {
            return [
                'success' => false,
                'error' => 'Username and password are required.',
                'error_code' => 'MISSING_FIELDS'
            ];
        }
        
        // Check for lockout
        if ($this->isLockedOut($username)) {
            return [
                'success' => false,
                'error' => 'Too many failed attempts. Please try again in 15 minutes.',
                'error_code' => 'ACCOUNT_LOCKED'
            ];
        }
        
        // Simple authentication for demo (replace with database lookup)
        if ($username === 'admin' && $password === 'demo123') {
            // Clear failed attempts
            $this->clearFailedAttempts($username);
            
            // Create secure session
            $this->createUserSession($username, [
                'username' => $username,
                'role' => 'admin',
                'login_time' => time(),
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
            ]);
            
            // Set remember me cookie if requested
            if ($remember_me) {
                $this->setRememberMeCookie($username);
            }
            
            // Log successful login
            $this->logActivity('LOGIN_SUCCESS', $username);
            
            return [
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'username' => $username,
                    'role' => 'admin'
                ]
            ];
        } else {
            // Record failed attempt
            $this->recordFailedAttempt($username);
            
            // Log failed login
            $this->logActivity('LOGIN_FAILED', $username);
            
            return [
                'success' => false,
                'error' => 'Invalid username or password.',
                'error_code' => 'INVALID_CREDENTIALS'
            ];
        }
    }
    
    /**
     * Create secure user session
     */
    private function createUserSession($username, $userData) {
        // Regenerate session ID
        session_regenerate_id(true);
        
        // Set session data
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_data'] = $userData;
        $_SESSION['login_time'] = time();
        $_SESSION['last_activity'] = time();
        $_SESSION['session_token'] = bin2hex(random_bytes(32));
        
        // Generate new CSRF token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    /**
     * Set remember me cookie
     */
    private function setRememberMeCookie($username) {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (30 * 24 * 60 * 60); // 30 days
        
        setcookie('remember_token', $token, [
            'expires' => $expiry,
            'path' => '/',
            'secure' => isset($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        
        $_SESSION['remember_token'] = $token;
    }
    
    /**
     * Check if user is authenticated
     */
    public function isAuthenticated() {
        if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
            return false;
        }
        
        // Check session timeout
        if (isset($_SESSION['last_activity']) && 
            (time() - $_SESSION['last_activity'] > $this->session_timeout)) {
            $this->logout();
            return false;
        }
        
        // Update last activity
        $_SESSION['last_activity'] = time();
        
        return true;
    }
    
    /**
     * Get current user data
     */
    public function getCurrentUser() {
        if (!$this->isAuthenticated()) {
            return null;
        }
        
        return $_SESSION['admin_data'] ?? null;
    }
    
    /**
     * Logout user
     */
    public function logout() {
        $username = $_SESSION['admin_username'] ?? 'unknown';
        
        // Log logout activity
        $this->logActivity('LOGOUT', $username);
        
        // Clear session data
        session_unset();
        session_destroy();
        
        // Clear remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
        }
        
        // Start new session
        session_start();
        session_regenerate_id(true);
    }
    
    /**
     * Require authentication for protected pages
     */
    public function requireAuth($redirect_url = 'login.php') {
        if (!$this->isAuthenticated()) {
            header('Location: ' . $redirect_url);
            exit;
        }
    }
    
    /**
     * Log security activities
     */
    private function logActivity($action, $username, $details = '') {
        $log_entry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'action' => $action,
            'username' => $username,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'details' => $details
        ];
        
        // Write to log file (ensure logs directory exists)
        $log_dir = __DIR__ . '/../logs';
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        
        $log_file = $log_dir . '/auth_' . date('Y-m') . '.log';
        $log_line = json_encode($log_entry) . PHP_EOL;
        file_put_contents($log_file, $log_line, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Get security information
     */
    public function getSecurityInfo() {
        if (!$this->isAuthenticated()) {
            return null;
        }
        
        return [
            'login_time' => $_SESSION['login_time'] ?? null,
            'last_activity' => $_SESSION['last_activity'] ?? null,
            'session_remaining' => $this->session_timeout - (time() - ($_SESSION['last_activity'] ?? time())),
            'ip_address' => $_SESSION['admin_data']['ip_address'] ?? 'unknown',
            'failed_attempts' => $_SESSION['login_attempts'] ?? []
        ];
    }
    
    /**
     * Check for suspicious activity
     */
    public function checkSuspiciousActivity() {
        if (!$this->isAuthenticated()) {
            return false;
        }
        
        $current_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $session_ip = $_SESSION['admin_data']['ip_address'] ?? 'unknown';
        
        // Check if IP address changed
        if ($current_ip !== $session_ip) {
            $this->logActivity('SUSPICIOUS_IP_CHANGE', $_SESSION['admin_username'] ?? 'unknown', 
                "IP changed from {$session_ip} to {$current_ip}");
            return true;
        }
        
        return false;
    }
}
?>
