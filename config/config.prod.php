<?php
/**
 * Production Configuration Template
 * Copy this file to config.php and modify settings for production
 */

// Production Environment Settings
define('ENVIRONMENT', 'production');
define('DEBUG_MODE', false);

// Database Configuration (Production)
define('DB_HOST', 'localhost');
define('DB_NAME', 'conectica_portfolio');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_secure_password');
define('DB_CHARSET', 'utf8mb4');

// Security Settings
define('SITE_URL', 'https://yourdomain.com');
define('ADMIN_URL', 'https://yourdomain.com/admin');
define('SECURE_COOKIES', true);
define('FORCE_HTTPS', true);

// Session Security
define('SESSION_TIMEOUT', 3600); // 1 hour
define('SESSION_REGENERATE_INTERVAL', 1800); // 30 minutes

// Authentication Settings
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_DURATION', 900); // 15 minutes
define('PASSWORD_MIN_LENGTH', 8);
define('REQUIRE_STRONG_PASSWORD', true);

// File Upload Settings
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
define('ALLOWED_EXTENSIONS', 'jpg,jpeg,png,gif,webp,pdf,doc,docx');
define('UPLOAD_PATH', '/uploads/');

// Email Configuration
define('SMTP_HOST', 'your-smtp-server.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@domain.com');
define('SMTP_PASSWORD', 'your-email-password');
define('SMTP_ENCRYPTION', 'tls');
define('FROM_EMAIL', 'noreply@yourdomain.com');
define('FROM_NAME', 'Conectica IT');

// Rate Limiting
define('RATE_LIMIT_ENABLED', true);
define('RATE_LIMIT_REQUESTS', 100); // requests per hour
define('RATE_LIMIT_TIME_WINDOW', 3600); // 1 hour

// Logging
define('LOG_ENABLED', true);
define('LOG_LEVEL', 'ERROR'); // DEBUG, INFO, WARNING, ERROR
define('LOG_PATH', __DIR__ . '/../logs/');
define('LOG_MAX_SIZE', 10485760); // 10MB
define('LOG_MAX_FILES', 10);

// Cache Settings
define('CACHE_ENABLED', true);
define('CACHE_DURATION', 3600); // 1 hour
define('CACHE_PATH', __DIR__ . '/../cache/');

// Error Handling
define('SHOW_ERRORS', false);
define('LOG_ERRORS', true);
define('ERROR_EMAIL', 'admin@yourdomain.com');

// Backup Settings
define('BACKUP_ENABLED', true);
define('BACKUP_PATH', __DIR__ . '/../backups/');
define('BACKUP_RETENTION_DAYS', 30);

// API Settings (if needed)
define('API_ENABLED', false);
define('API_KEY', 'your-secret-api-key');
define('API_RATE_LIMIT', 1000); // requests per hour

// Third-party Integrations
define('GOOGLE_ANALYTICS_ID', 'GA-XXXXX-X');
define('RECAPTCHA_SITE_KEY', 'your-recaptcha-site-key');
define('RECAPTCHA_SECRET_KEY', 'your-recaptcha-secret-key');

// Maintenance Mode
define('MAINTENANCE_MODE', false);
define('MAINTENANCE_MESSAGE', 'Site is under maintenance. Please check back later.');
define('MAINTENANCE_ALLOWED_IPS', serialize(['127.0.0.1', 'your-ip-address']));

// Security Headers
define('CSP_POLICY', "default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:;");

// Time Zone
define('DEFAULT_TIMEZONE', 'Europe/Bucharest');
date_default_timezone_set(DEFAULT_TIMEZONE);

// Custom Functions for Production
function isProduction() {
    return ENVIRONMENT === 'production';
}

function getConfigValue($key, $default = null) {
    return defined($key) ? constant($key) : $default;
}

function logSecurityEvent($event, $details = []) {
    if (LOG_ENABLED) {
        $log_data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'event' => $event,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'details' => $details
        ];
        
        $log_file = LOG_PATH . 'security_' . date('Y-m') . '.log';
        file_put_contents($log_file, json_encode($log_data) . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

// Initialize error handling for production
if (isProduction()) {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', LOG_PATH . 'php_errors.log');
    
    set_error_handler(function($severity, $message, $filename, $lineno) {
        if (LOG_ENABLED) {
            error_log("[$severity] $message in $filename on line $lineno");
        }
        return true;
    });
    
    set_exception_handler(function($exception) {
        if (LOG_ENABLED) {
            error_log("Uncaught exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());
        }
        
        // Show generic error page
        http_response_code(500);
        if (file_exists(__DIR__ . '/../errors/500.html')) {
            include __DIR__ . '/../errors/500.html';
        } else {
            echo "Internal Server Error";
        }
        exit;
    });
}
?>
