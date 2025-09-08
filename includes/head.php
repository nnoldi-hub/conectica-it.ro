<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Presentation-only: paths and flags
$is_admin = isset($_SERVER['REQUEST_URI']) && (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false);
$base_path = $is_admin ? '../' : '';
?>
<!doctype html>
<html lang="ro">
<head>
    <meta charset='utf-8'>
    
    <?php 
    // Prefer SEO helper meta if available, else fallback
    if (isset($seo) && $seo instanceof SEOHelper) {
        echo $seo->generateMetaTags();
        echo "\n" . $seo->generateStructuredData();
    } else {
        // Generate enhanced meta tags (fallback)
        $title = isset($page_title) ? htmlspecialchars($page_title) : SITE_NAME;
        $description = isset($page_description) ? htmlspecialchars($page_description) : 'Freelancer IT - Nyikora Noldi. Servicii profesionale de dezvoltare web, aplicații PHP, MySQL, și soluții IT personalizate.';
        $keywords = 'freelancer IT, dezvoltare web, PHP, MySQL, Bootstrap, JavaScript, aplicații web, programare România, consultant IT';
        $canonical_url = BASE_URL . $_SERVER['REQUEST_URI'];
        $og_image = BASE_URL . '/assets/images/og-image-conectica-it.jpg';
        
        echo "<title>{$title}</title>\n";
        echo "    <meta name='viewport' content='width=device-width,initial-scale=1'>\n";
        echo "    <meta name=\"description\" content=\"{$description}\">\n";
        echo "    <meta name=\"keywords\" content=\"{$keywords}\">\n";
        echo "    <meta name=\"author\" content=\"Nyikora Noldi\">\n";
        echo "    <meta name=\"robots\" content=\"index, follow\">\n";
        echo "    <link rel=\"canonical\" href=\"{$canonical_url}\">\n";
        
        // Open Graph tags
        echo "    <!-- Open Graph Meta Tags -->\n";
        echo "    <meta property=\"og:type\" content=\"website\">\n";
        echo "    <meta property=\"og:title\" content=\"{$title}\">\n";
        echo "    <meta property=\"og:description\" content=\"{$description}\">\n";
        echo "    <meta property=\"og:image\" content=\"{$og_image}\">\n";
        echo "    <meta property=\"og:url\" content=\"{$canonical_url}\">\n";
        echo "    <meta property=\"og:site_name\" content=\"Conectica IT\">\n";
        echo "    <meta property=\"og:locale\" content=\"ro_RO\">\n";
        
        // Twitter Card tags
        echo "    <!-- Twitter Card Meta Tags -->\n";
        echo "    <meta name=\"twitter:card\" content=\"summary_large_image\">\n";
        echo "    <meta name=\"twitter:title\" content=\"{$title}\">\n";
        echo "    <meta name=\"twitter:description\" content=\"{$description}\">\n";
        echo "    <meta name=\"twitter:image\" content=\"{$og_image}\">\n";
        
        // JSON-LD structured data for homepage
        if (basename($_SERVER['PHP_SELF'], '.php') === 'index') {
            echo "    <!-- JSON-LD Structured Data -->\n";
            echo "    <script type=\"application/ld+json\">\n";
            echo "    {\n";
            echo "        \"@context\": \"https://schema.org\",\n";
            echo "        \"@type\": [\"Person\", \"Organization\"],\n";
            echo "        \"name\": \"Nyikora Noldi\",\n";
            echo "        \"alternateName\": \"Conectica IT\",\n";
            echo "        \"jobTitle\": \"Dezvoltator Web Freelancer\",\n";
            echo "        \"description\": \"{$description}\",\n";
            echo "        \"url\": \"" . BASE_URL . "\",\n";
            echo "        \"telephone\": \"+40740173581\",\n";
            echo "        \"email\": \"conectica.it.ro@gmail.com\",\n";
            echo "        \"address\": {\n";
            echo "            \"@type\": \"PostalAddress\",\n";
            echo "            \"addressCountry\": \"Romania\"\n";
            echo "        },\n";
            echo "        \"knowsAbout\": [\"Dezvoltare Web\", \"PHP\", \"JavaScript\", \"MySQL\", \"Bootstrap\", \"Aplicații Web\"],\n";
            echo "        \"offers\": {\n";
            echo "            \"@type\": \"Service\",\n";
            echo "            \"name\": \"Servicii Dezvoltare Web\",\n";
            echo "            \"description\": \"Dezvoltare aplicații web moderne, consultanță IT și soluții personalizate\"\n";
            echo "        }\n";
            echo "    }\n";
            echo "    </script>\n";
        }
    }
    ?>
    
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo $base_path; ?>favicon.svg">
    <link rel="alternate icon" href="<?php echo $base_path; ?>favicon.ico">
    <!-- Custom CSS -->
    <link href='<?php echo $base_path; ?>assets/css/style.css' rel='stylesheet'>
</head>
<body>
    <nav class='navbar navbar-expand-lg navbar-dark bg-dark fixed-top'>
        <div class='container'>
            <a class='navbar-brand d-flex align-items-center' href='<?php echo $base_path; ?>index.php'>
                <img src='<?php echo $base_path; ?>assets/images/logo.png' alt='Conectica‑IT' height='60' class='me-2' onerror="this.style.display='none'">
                <span class='fw-bold d-none d-sm-inline'>Conectica‑IT</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>index.php">Acasă</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>projects.php">Proiecte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>about.php">Despre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>blog.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>contact.php">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex">
                    <a class='btn btn-primary btn-sm me-2' href='<?php echo $base_path; ?>request-quote.php'>
                        <i class="fas fa-paper-plane me-1"></i>Cere Ofertă
                    </a>
                    <?php
                    // Show Admin only if user is already authenticated or on admin pages
                    $show_admin = $is_admin || (isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated']);
                    if ($show_admin): ?>
                    <a class='btn btn-outline-light btn-sm' href='<?php echo $is_admin ? '' : 'admin/'; ?>login.php'>
                        <i class="fas fa-user-shield me-1"></i>Admin
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <main style="margin-top: 76px;">
        <div class='container'>