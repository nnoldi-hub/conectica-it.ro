<?php
/**
 * Dynamic robots.txt Generator
 * Generează robots.txt pentru SEO
 */

// Set plain text content type
header('Content-Type: text/plain; charset=utf-8');

// Include database and get robots settings
require_once(__DIR__ . '/config/database.php');
require_once(__DIR__ . '/config/config.php');

try {
    $stmt = $database->prepare("SELECT robots_txt FROM seo_settings WHERE setting_type = 'global' LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result && !empty($result['robots_txt'])) {
        echo $result['robots_txt'];
    } else {
        throw new Exception('No robots.txt found in database');
    }
    
} catch (Exception $e) {
    // Fallback robots.txt
    echo "User-agent: *\n";
    echo "Disallow: /admin/\n";
    echo "Disallow: /config/\n";
    echo "Disallow: /logs/\n";
    echo "Disallow: /uploads/\n";
    echo "Allow: /uploads/avatars/\n";
    echo "\n";
    $base = defined('BASE_URL') ? rtrim(BASE_URL, '/') : 'https://yourdomain.com';
    echo "Sitemap: {$base}/sitemap.php\n";
}
?>
