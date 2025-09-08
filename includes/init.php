<?php
// Common bootstrap to unify paths and initialization

// Show errors in development (remove or set to 0 in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Useful roots
define('PUBLIC_PATH', realpath(__DIR__ . '/..')); // public_html
define('ROOT_PATH', dirname(PUBLIC_PATH));        // one level above public_html

// Resolve config path: prefer /config inside this project, else fallback to parent /config
$__configPath = PUBLIC_PATH . DIRECTORY_SEPARATOR . 'config';
if (!is_dir($__configPath)) {
    $__configPath = ROOT_PATH . DIRECTORY_SEPARATOR . 'config';
}
define('CONFIG_PATH', $__configPath);
unset($__configPath);

// Global config (constants)
if (file_exists(CONFIG_PATH . '/config.php')) {
    require_once CONFIG_PATH . '/config.php';
}

// Composer autoload (if installed)
if (file_exists(PUBLIC_PATH . '/vendor/autoload.php')) {
    require_once PUBLIC_PATH . '/vendor/autoload.php';
}

// Optional: database connection helper and $pdo
$pdo = null;
if (file_exists(CONFIG_PATH . '/database.php')) {
    require_once CONFIG_PATH . '/database.php';
    try {
        if (function_exists('getDatabaseConnection')) {
            $pdo = getDatabaseConnection();
        }
    } catch (Throwable $e) {
        // In dev, show a non-fatal warning to avoid white-screen 500s
        if (ini_get('display_errors')) {
            echo "<div style='background:#fee;border:1px solid #f99;padding:10px;margin:10px;border-radius:6px;'>".
                 "Nu se poate stabili conexiunea la baza de date: " . htmlspecialchars($e->getMessage()) .
                 "</div>";
        }
    }
}

// Start session (if needed)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// SEO helper (structured meta, sitemap, etc.)
if (file_exists(__DIR__ . '/seo.php')) {
    require_once __DIR__ . '/seo.php';
    try {
        // Expose as global $seo
        $seo = new SEOHelper($pdo);
    } catch (Throwable $e) {
        // Non-fatal; fallback meta will be used in head.php
    }
}

?>
