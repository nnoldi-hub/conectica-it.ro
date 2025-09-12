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
    // Enhanced meta tags for all pages
    $title = isset($page_title) ? htmlspecialchars($page_title) : SITE_NAME;
    $description = isset($page_description) ? htmlspecialchars($page_description) : 'Freelancer IT - Nyikora Noldi. Servicii profesionale de dezvoltare web, aplicații PHP, MySQL, și soluții IT personalizate.';
    $keywords = 'freelancer IT, dezvoltare web, PHP, MySQL, Bootstrap, JavaScript, aplicații web, programare România, consultant IT';
    $canonical_url = BASE_URL . $_SERVER['REQUEST_URI'];
    $og_image = isset($page_image) ? BASE_URL . $page_image : BASE_URL . '/assets/images/og-image-conectica-it.jpg';
    
    // SEO Meta Tags
    echo "<title>{$title}</title>\n";
    echo "    <meta name='viewport' content='width=device-width,initial-scale=1'>\n";
    echo "    <meta name=\"description\" content=\"{$description}\">\n";
    echo "    <meta name=\"keywords\" content=\"{$keywords}\">\n";
    echo "    <meta name=\"author\" content=\"Nyikora Noldi\">\n";
    echo "    <meta name=\"robots\" content=\"index, follow\">\n";
    echo "    <link rel=\"canonical\" href=\"{$canonical_url}\">\n";
    
    // Open Graph Meta Tags (Complete Set)
    echo "    <!-- Open Graph Meta Tags -->\n";
    echo "    <meta property=\"og:type\" content=\"website\">\n";
    echo "    <meta property=\"og:title\" content=\"{$title}\">\n";
    echo "    <meta property=\"og:description\" content=\"{$description}\">\n";
    echo "    <meta property=\"og:image\" content=\"{$og_image}\">\n";
    echo "    <meta property=\"og:image:width\" content=\"1200\">\n";
    echo "    <meta property=\"og:image:height\" content=\"630\">\n";
    echo "    <meta property=\"og:image:type\" content=\"image/jpeg\">\n";
    echo "    <meta property=\"og:url\" content=\"{$canonical_url}\">\n";
    echo "    <meta property=\"og:site_name\" content=\"Conectica IT\">\n";
    echo "    <meta property=\"og:locale\" content=\"ro_RO\">\n";
    
    // Twitter Card Meta Tags (Complete Set)
    echo "    <!-- Twitter Card Meta Tags -->\n";
    echo "    <meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    echo "    <meta name=\"twitter:title\" content=\"{$title}\">\n";
    echo "    <meta name=\"twitter:description\" content=\"{$description}\">\n";
    echo "    <meta name=\"twitter:image\" content=\"{$og_image}\">\n";
    echo "    <meta name=\"twitter:image:alt\" content=\"Conectica IT - {$title}\">\n";
    echo "    <meta name=\"twitter:site\" content=\"@conectica_it\">\n";
    echo "    <meta name=\"twitter:creator\" content=\"@nyikora_noldi\">\n";
    
    // Additional Meta Tags
    echo "    <meta name=\"theme-color\" content=\"#0d47a1\">\n";
    echo "    <meta name=\"msapplication-TileColor\" content=\"#0d47a1\">\n";
    
    // JSON-LD Structured Data
    $current_page = basename($_SERVER['PHP_SELF'], '.php');
    
    if ($current_page === 'index') {
        // Person + Organization schema for homepage
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
        echo "        \"image\": \"{$og_image}\",\n";
        echo "        \"address\": {\n";
        echo "            \"@type\": \"PostalAddress\",\n";
        echo "            \"addressCountry\": \"Romania\"\n";
        echo "        },\n";
        echo "        \"knowsAbout\": [\"Dezvoltare Web\", \"PHP\", \"JavaScript\", \"MySQL\", \"Bootstrap\", \"Aplicații Web\"],\n";
        echo "        \"offers\": {\n";
        echo "            \"@type\": \"Service\",\n";
        echo "            \"name\": \"Servicii Dezvoltare Web\",\n";
        echo "            \"description\": \"Dezvoltare aplicații web moderne, consultanță IT și soluții personalizate\"\n";
        echo "        },\n";
        echo "        \"sameAs\": [\n";
        echo "            \"https://github.com/nnoldi-hub\",\n";
        echo "            \"https://www.linkedin.com/in/nyikora-noldi\"\n";
        echo "        ]\n";
        echo "    }\n";
        echo "    </script>\n";
    } elseif ($current_page === 'article' && isset($_GET['slug'])) {
        // Article schema for blog posts
        try {
            require_once __DIR__ . '/init.php';
            if ($pdo instanceof PDO) {
                $stmt = $pdo->prepare("SELECT title, excerpt, cover_image, COALESCE(published_at, created_at) as dt FROM blog_posts WHERE slug=? AND status='published' LIMIT 1");
                $stmt->execute([$_GET['slug']]);
                $article = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($article) {
                    $article_image = $article['cover_image'] ? BASE_URL . $article['cover_image'] : $og_image;
                    echo "    <!-- Article JSON-LD Structured Data -->\n";
                    echo "    <script type=\"application/ld+json\">\n";
                    echo "    {\n";
                    echo "        \"@context\": \"https://schema.org\",\n";
                    echo "        \"@type\": \"Article\",\n";
                    echo "        \"headline\": \"" . addslashes($article['title']) . "\",\n";
                    echo "        \"description\": \"" . addslashes($article['excerpt']) . "\",\n";
                    echo "        \"image\": \"{$article_image}\",\n";
                    echo "        \"datePublished\": \"" . date('c', strtotime($article['dt'])) . "\",\n";
                    echo "        \"dateModified\": \"" . date('c', strtotime($article['dt'])) . "\",\n";
                    echo "        \"author\": {\n";
                    echo "            \"@type\": \"Person\",\n";
                    echo "            \"name\": \"Nyikora Noldi\",\n";
                    echo "            \"url\": \"" . BASE_URL . "\"\n";
                    echo "        },\n";
                    echo "        \"publisher\": {\n";
                    echo "            \"@type\": \"Organization\",\n";
                    echo "            \"name\": \"Conectica IT\",\n";
                    echo "            \"logo\": {\n";
                    echo "                \"@type\": \"ImageObject\",\n";
                    echo "                \"url\": \"" . BASE_URL . "/assets/images/logo.png\"\n";
                    echo "            }\n";
                    echo "        },\n";
                    echo "        \"mainEntityOfPage\": {\n";
                    echo "            \"@type\": \"WebPage\",\n";
                    echo "            \"@id\": \"{$canonical_url}\"\n";
                    echo "        }\n";
                    echo "    }\n";
                    echo "    </script>\n";
                }
            }
        } catch (Exception $e) {
            // Fallback if database fails
        }
    }
    ?>
    

    <!-- Preload LCP Hero Image (ajustat pentru homepage) -->
    <?php if ($current_page === 'index'): ?>
        <link rel="preload" as="image" href="/assets/images/placeholders/nnoldi.png" imagesrcset="/assets/images/placeholders/nnoldi.png 120w" imagesizes="120px">
    <?php endif; ?>

    <!-- Preload CSS critic -->
    <link rel="preload" as="style" href="<?php echo $base_path; ?>assets/css/style.css">
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts: preconnect & preload -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo $base_path; ?>favicon.svg">
    <link rel="alternate icon" href="<?php echo $base_path; ?>favicon.ico">
    <!-- Custom CSS -->
    <link href='<?php echo $base_path; ?>assets/css/style.css' rel='stylesheet'>

    <!-- Preload JS critic (Bootstrap) -->
    <link rel="preload" as="script" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    
    <?php
    // Add social media structured data
    if (isset($pdo) && function_exists('getSocialMediaSettings') && function_exists('generateSocialMediaStructuredData')) {
        $socialSettings = getSocialMediaSettings($pdo);
        echo generateSocialMediaStructuredData($socialSettings, 'Conectica IT');
    }
    ?>
</head>
<body>
    <nav class='navbar navbar-expand-lg navbar-dark bg-dark fixed-top'>
        <div class='container'>
            <a class='navbar-brand d-flex align-items-center' href='<?php echo $base_path; ?>index.php'>
                <img src='<?php echo $base_path; ?>assets/images/logo.png' alt='Conectica‑IT' width='60' height='60' class='me-2' onerror="this.style.display='none'">
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