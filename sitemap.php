<?php
/**
 * Dynamic Sitemap Generator
 * Generează sitemap XML pentru SEO
 */

// Disable error display for XML output
ini_set('display_errors', 0);

// Set XML content type
header('Content-Type: application/xml; charset=utf-8');

// Include database and SEO helper
require_once(__DIR__ . '/config/database.php');
require_once(__DIR__ . '/includes/seo.php');

try {
    // Initialize SEO helper
    $seo = new SEOHelper($database);
    
    // Generate and output sitemap
    echo $seo->generateSitemap();
    
} catch (Exception $e) {
    // Fallback static sitemap
    $base_url = 'https://yourdomain.com'; // Update with your domain
    
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    
    $pages = [
        '' => ['priority' => '1.0', 'changefreq' => 'weekly'],
        'projects.php' => ['priority' => '0.9', 'changefreq' => 'weekly'],
        'blog.php' => ['priority' => '0.8', 'changefreq' => 'weekly'],
        'contact.php' => ['priority' => '0.7', 'changefreq' => 'monthly'],
        'request-quote.php' => ['priority' => '0.6', 'changefreq' => 'monthly']
    ];
    
    foreach ($pages as $page => $settings) {
        echo "  <url>\n";
        echo "    <loc>" . rtrim($base_url, '/') . '/' . $page . "</loc>\n";
        echo "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
        echo "    <changefreq>" . $settings['changefreq'] . "</changefreq>\n";
        echo "    <priority>" . $settings['priority'] . "</priority>\n";
        echo "  </url>\n";
    }
    
    echo '</urlset>';
}
?>
