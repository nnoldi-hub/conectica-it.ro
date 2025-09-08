<?php
/**
 * SEO Helper Functions
 * Funcții pentru gestionarea SEO în frontend
 */

class SEOHelper {
    private $pdo;
    private $global_seo = [];
    private $current_page_seo = [];
    private $current_page = '';
    
    public function __construct($database = null) {
        if ($database) {
            $this->pdo = $database;
            $this->loadSEOSettings();
        }
        
        // Detect current page
        $this->current_page = $this->detectCurrentPage();
    }
    
    /**
     * Load SEO settings from database
     */
    private function loadSEOSettings() {
        try {
            // Load global settings
            $stmt = $this->pdo->prepare("SELECT * FROM seo_settings WHERE setting_type = 'global' LIMIT 1");
            $stmt->execute();
            $this->global_seo = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
            
            // Load page-specific settings
            $stmt = $this->pdo->prepare("SELECT * FROM seo_settings WHERE setting_type = 'page'");
            $stmt->execute();
            $page_settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($page_settings as $setting) {
                $this->current_page_seo[$setting['page_name']] = $setting;
            }
        } catch (PDOException $e) {
            // Fallback to default settings if database fails
            $this->global_seo = $this->getDefaultSEOSettings();
        }
    }
    
    /**
     * Detect current page from URL
     */
    private function detectCurrentPage() {
        $current_file = basename($_SERVER['PHP_SELF'], '.php');
        
        // Map file names to page names
        $page_map = [
            'index' => 'index',
            'projects' => 'projects',
            'blog' => 'blog',
            'contact' => 'contact',
            'request-quote' => 'request-quote'
        ];
        
        return $page_map[$current_file] ?? 'index';
    }
    
    /**
     * Get default SEO settings
     */
    private function getDefaultSEOSettings() {
        return [
            'site_title' => 'Conectica IT - Soluții IT Profesionale | Nyikora Noldi',
            'site_description' => 'Dezvoltator web freelancer specializat în crearea de soluții IT moderne și inovatoare. Servicii de dezvoltare web, aplicații personalizate și consultanță IT.',
            'site_keywords' => 'dezvoltare web, freelancer IT, programare, design web, aplicații web, PHP, JavaScript, consultanță IT, Nyikora Noldi',
            'canonical_url' => 'https://yourdomain.com',
            'og_image' => '/assets/images/og-image.jpg',
            'google_analytics' => '',
            'robots_txt' => "User-agent: *\nDisallow: /admin/\nDisallow: /config/\nDisallow: /logs/\nSitemap: https://yourdomain.com/sitemap.xml"
        ];
    }
    
    /**
     * Get page title
     */
    public function getTitle($default = '') {
        $page_seo = $this->current_page_seo[$this->current_page] ?? [];
        
        if (!empty($page_seo['site_title'])) {
            return $page_seo['site_title'];
        } elseif (!empty($this->global_seo['site_title'])) {
            return $this->global_seo['site_title'];
        } elseif (!empty($default)) {
            return $default;
        }
        
        return $this->getDefaultSEOSettings()['site_title'];
    }
    
    /**
     * Get meta description
     */
    public function getDescription($default = '') {
        $page_seo = $this->current_page_seo[$this->current_page] ?? [];
        
        if (!empty($page_seo['site_description'])) {
            return $page_seo['site_description'];
        } elseif (!empty($this->global_seo['site_description'])) {
            return $this->global_seo['site_description'];
        } elseif (!empty($default)) {
            return $default;
        }
        
        return $this->getDefaultSEOSettings()['site_description'];
    }
    
    /**
     * Get meta keywords
     */
    public function getKeywords($default = '') {
        $page_seo = $this->current_page_seo[$this->current_page] ?? [];
        
        if (!empty($page_seo['site_keywords'])) {
            return $page_seo['site_keywords'];
        } elseif (!empty($this->global_seo['site_keywords'])) {
            return $this->global_seo['site_keywords'];
        } elseif (!empty($default)) {
            return $default;
        }
        
        return $this->getDefaultSEOSettings()['site_keywords'];
    }
    
    /**
     * Get canonical URL
     */
    public function getCanonicalUrl($path = '') {
        $base_url = $this->global_seo['canonical_url'] ?? 'https://yourdomain.com';
        return rtrim($base_url, '/') . '/' . ltrim($path, '/');
    }
    
    /**
     * Get Open Graph title
     */
    public function getOGTitle() {
        $page_seo = $this->current_page_seo[$this->current_page] ?? [];
        return $page_seo['og_title'] ?? $this->getTitle();
    }
    
    /**
     * Get Open Graph description
     */
    public function getOGDescription() {
        $page_seo = $this->current_page_seo[$this->current_page] ?? [];
        return $page_seo['og_description'] ?? $this->getDescription();
    }
    
    /**
     * Get Open Graph image
     */
    public function getOGImage() {
        $page_seo = $this->current_page_seo[$this->current_page] ?? [];
        
        if (!empty($page_seo['og_image'])) {
            return $this->getCanonicalUrl($page_seo['og_image']);
        } elseif (!empty($this->global_seo['og_image'])) {
            return $this->getCanonicalUrl($this->global_seo['og_image']);
        }
        
        return $this->getCanonicalUrl('/assets/images/og-image.jpg');
    }
    
    /**
     * Generate complete SEO meta tags
     */
    public function generateMetaTags() {
        $title = htmlspecialchars($this->getTitle());
        $description = htmlspecialchars($this->getDescription());
        $keywords = htmlspecialchars($this->getKeywords());
        $canonical = htmlspecialchars($this->getCanonicalUrl($_SERVER['REQUEST_URI'] ?? ''));
        $og_title = htmlspecialchars($this->getOGTitle());
        $og_description = htmlspecialchars($this->getOGDescription());
        $og_image = htmlspecialchars($this->getOGImage());
        $og_url = htmlspecialchars($this->getCanonicalUrl($_SERVER['REQUEST_URI'] ?? ''));
        
        $meta_tags = "
    <!-- SEO Meta Tags -->
    <title>{$title}</title>
    <meta name=\"description\" content=\"{$description}\">
    <meta name=\"keywords\" content=\"{$keywords}\">
    <meta name=\"robots\" content=\"index, follow\">
    <meta name=\"author\" content=\"Nyikora Noldi\">
    <link rel=\"canonical\" href=\"{$canonical}\">
    
    <!-- Open Graph Meta Tags -->
    <meta property=\"og:type\" content=\"website\">
    <meta property=\"og:title\" content=\"{$og_title}\">
    <meta property=\"og:description\" content=\"{$og_description}\">
    <meta property=\"og:image\" content=\"{$og_image}\">
    <meta property=\"og:url\" content=\"{$og_url}\">
    <meta property=\"og:site_name\" content=\"Conectica IT\">
    
    <!-- Twitter Card Meta Tags -->
    <meta name=\"twitter:card\" content=\"summary_large_image\">
    <meta name=\"twitter:title\" content=\"{$og_title}\">
    <meta name=\"twitter:description\" content=\"{$og_description}\">
    <meta name=\"twitter:image\" content=\"{$og_image}\">
    
    <!-- Additional Meta Tags -->
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"theme-color\" content=\"#3498db\">
    <meta name=\"msapplication-TileColor\" content=\"#3498db\">";
        
        // Add Google Analytics if available
        if (!empty($this->global_seo['google_analytics'])) {
            $ga_id = htmlspecialchars($this->global_seo['google_analytics']);
            $meta_tags .= "
    
    <!-- Google Analytics -->
    <script async src=\"https://www.googletagmanager.com/gtag/js?id={$ga_id}\"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{$ga_id}');
    </script>";
        }
        
        // Add Google Search Console verification
        if (!empty($this->global_seo['google_search_console'])) {
            $gsc_content = htmlspecialchars($this->global_seo['google_search_console']);
            $meta_tags .= "
    <meta name=\"google-site-verification\" {$gsc_content}>";
        }
        
        return $meta_tags;
    }
    
    /**
     * Generate JSON-LD structured data
     */
    public function generateStructuredData() {
        $base_url = $this->getCanonicalUrl();
        $structured_data = [
            "@context" => "https://schema.org",
            "@type" => "Person",
            "name" => "Nyikora Noldi",
            "jobTitle" => "Dezvoltator Web Freelancer",
            "description" => $this->getDescription(),
            "url" => $base_url,
            "sameAs" => [
                // Add social media profiles here
            ],
            "contactPoint" => [
                "@type" => "ContactPoint",
                "telephone" => "+40740173581",
                "contactType" => "customer service",
                "email" => "conectica.it.ro@gmail.com"
            ],
            "address" => [
                "@type" => "PostalAddress",
                "addressCountry" => "RO"
            ],
            "knowsAbout" => [
                "Dezvoltare Web",
                "PHP",
                "JavaScript",
                "MySQL",
                "Aplicații Web",
                "Design Responsive"
            ]
        ];
        
        // Add organization data for business pages
        if ($this->current_page === 'index') {
            $structured_data["@type"] = ["Person", "Organization"];
            $structured_data["legalName"] = "Conectica IT";
            $structured_data["foundingDate"] = "2025";
            $structured_data["founder"] = [
                "@type" => "Person",
                "name" => "Nyikora Noldi"
            ];
        }
        
        return '<script type="application/ld+json">' . json_encode($structured_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
    }
    
    /**
     * Get current page for active states
     */
    public function getCurrentPage() {
        return $this->current_page;
    }
    
    /**
     * Generate sitemap XML
     */
    public function generateSitemap() {
        $base_url = $this->getCanonicalUrl();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Static pages
        $pages = [
            '' => ['priority' => '1.0', 'changefreq' => 'weekly'],
            'projects.php' => ['priority' => '0.9', 'changefreq' => 'weekly'],
            'about.php' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'blog.php' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'contact.php' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'request-quote.php' => ['priority' => '0.6', 'changefreq' => 'monthly'],
            'politica-cookies.php' => ['priority' => '0.3', 'changefreq' => 'yearly']
        ];
        
        foreach ($pages as $page => $settings) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . rtrim($base_url, '/') . '/' . $page . "</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>" . $settings['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $settings['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }
        
        $xml .= '</urlset>';
        return $xml;
    }
}

// Convenience functions for easy use in templates
function seo_title($default = '') {
    global $seo;
    return $seo ? $seo->getTitle($default) : $default;
}

function seo_description($default = '') {
    global $seo;
    return $seo ? $seo->getDescription($default) : $default;
}

function seo_keywords($default = '') {
    global $seo;
    return $seo ? $seo->getKeywords($default) : $default;
}

function seo_canonical($path = '') {
    global $seo;
    return $seo ? $seo->getCanonicalUrl($path) : '';
}

function seo_meta_tags() {
    global $seo;
    return $seo ? $seo->generateMetaTags() : '';
}

function seo_structured_data() {
    global $seo;
    return $seo ? $seo->generateStructuredData() : '';
}
?>
