<?php
require_once(__DIR__ . '/../AuthSystem.php');

// Defensive DB initialization (ensure $database and $pdo exist)
if (!function_exists('getDatabaseConnection')) {
    // try to include config if not present
    @require_once(__DIR__ . '/../../config/database.php');
}

if (!isset($database) || !($database instanceof PDO)) {
    try {
        if (function_exists('getDatabaseConnection')) {
            $database = getDatabaseConnection();
        }
    } catch (Exception $e) {
        $database = null;
        $error_message = 'Eroare la conexiunea bazei de date: ' . $e->getMessage();
    }
}

if (!isset($pdo) && isset($database) && $database instanceof PDO) {
    $pdo = $database; // alias for legacy code
}

$auth = new AuthSystem();
$auth->requireAuth();

$success_message = '';
$error_message = '';

// Debugging: ensure errors are visible during development
error_reporting(E_ALL);
ini_set('display_errors', '1');

// If database connection failed, show admin-friendly error and stop further DB calls
if (!isset($database) || !($database instanceof PDO)) {
    $db_err = $error_message ?? 'Nu s-a putut stabili conexiunea la baza de date.';
    echo '<div class="alert alert-danger" style="margin:20px;">';
    echo '<h4><i class="fas fa-exclamation-triangle"></i> Eroare conexiune DB</h4>';
    echo '<p>' . htmlspecialchars($db_err) . '</p>';
    echo '<p>Verifică `config/database.php` și repornește serverul.</p>';
    echo '</div>';
    return; // Prevent further execution to avoid fatal errors
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$auth->validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error_message = 'Token de securitate invalid. Încercați din nou.';
    } else {
        // Global SEO Settings
        if (isset($_POST['save_global_seo'])) {
            $site_title = trim($_POST['site_title'] ?? '');
            $site_description = trim($_POST['site_description'] ?? '');
            $site_keywords = trim($_POST['site_keywords'] ?? '');
            $canonical_url = trim($_POST['canonical_url'] ?? '');
            $og_image = trim($_POST['og_image'] ?? '');
            $google_analytics = trim($_POST['google_analytics'] ?? '');
            $google_search_console = trim($_POST['google_search_console'] ?? '');
            $robots_txt = trim($_POST['robots_txt'] ?? '');
            
            try {
                // Check if SEO settings exist
                $stmt = $database->prepare("SELECT id FROM seo_settings WHERE setting_type = 'global' LIMIT 1");
                $stmt->execute();
                $exists = $stmt->fetch();
                
                if ($exists) {
                    // Update existing
                    $stmt = $database->prepare("UPDATE seo_settings SET 
                        site_title = ?, site_description = ?, site_keywords = ?, 
                        canonical_url = ?, og_image = ?, google_analytics = ?, 
                        google_search_console = ?, robots_txt = ?, updated_at = NOW() 
                        WHERE setting_type = 'global'");
                    $stmt->execute([
                        $site_title, $site_description, $site_keywords, 
                        $canonical_url, $og_image, $google_analytics, 
                        $google_search_console, $robots_txt
                    ]);
                } else {
                    // Insert new
                    $stmt = $database->prepare("INSERT INTO seo_settings 
                        (setting_type, site_title, site_description, site_keywords, 
                         canonical_url, og_image, google_analytics, google_search_console, robots_txt) 
                        VALUES ('global', ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $site_title, $site_description, $site_keywords, 
                        $canonical_url, $og_image, $google_analytics, 
                        $google_search_console, $robots_txt
                    ]);
                }
                
                $success_message = 'Setările SEO globale au fost salvate cu succes!';
                
            } catch (PDOException $e) {
                $error_message = 'Eroare la salvarea setărilor SEO: ' . $e->getMessage();
            }
            
        } elseif (isset($_POST['save_page_seo'])) {
            // Page-specific SEO
            $page_name = $_POST['page_name'] ?? '';
            $site_title = trim($_POST['site_title'] ?? '');
            $site_description = trim($_POST['site_description'] ?? '');
            $site_keywords = trim($_POST['site_keywords'] ?? '');
            $og_title = trim($_POST['og_title'] ?? '');
            $og_description = trim($_POST['og_description'] ?? '');
            $og_image = trim($_POST['og_image'] ?? '');
            
            try {
                $stmt = $database->prepare("SELECT id FROM seo_settings WHERE setting_type = 'page' AND page_name = ?");
                $stmt->execute([$page_name]);
                $exists = $stmt->fetch();
                
                if ($exists) {
                    $stmt = $database->prepare("UPDATE seo_settings SET 
                        site_title = ?, site_description = ?, site_keywords = ?, 
                        og_title = ?, og_description = ?, og_image = ?, updated_at = NOW() 
                        WHERE setting_type = 'page' AND page_name = ?");
                    $stmt->execute([
                        $site_title, $site_description, $site_keywords,
                        $og_title, $og_description, $og_image, $page_name
                    ]);
                } else {
                    $stmt = $database->prepare("INSERT INTO seo_settings 
                        (setting_type, page_name, site_title, site_description, site_keywords, 
                         og_title, og_description, og_image) 
                        VALUES ('page', ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $page_name, $site_title, $site_description, $site_keywords,
                        $og_title, $og_description, $og_image
                    ]);
                }
                
                $success_message = 'Setările SEO pentru pagina ' . ucfirst($page_name) . ' au fost salvate!';
                
            } catch (PDOException $e) {
                $error_message = 'Eroare la salvarea setărilor SEO: ' . $e->getMessage();
            }
        }
    }
}

// Get current SEO settings
try {
    $stmt = $database->prepare("SELECT * FROM seo_settings WHERE setting_type = 'global' LIMIT 1");
    $stmt->execute();
    $global_seo = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    
    $stmt = $database->prepare("SELECT * FROM seo_settings WHERE setting_type = 'page'");
    $stmt->execute();
    $page_seo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convert to associative array by page_name
    $page_settings = [];
    foreach ($page_seo as $setting) {
        $page_settings[$setting['page_name']] = $setting;
    }
    
} catch (PDOException $e) {
    $error_message = 'Eroare la încărcarea setărilor SEO: ' . $e->getMessage();
    $global_seo = [];
    $page_settings = [];
}
?>

<!-- SEO Manager Styles -->
<style>
.seo-container {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.seo-header {
    text-align: center;
    margin-bottom: 40px;
    padding: 20px 0;
    border-bottom: 2px solid rgba(102, 126, 234, 0.3);
}

.seo-title {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 10px;
}

.seo-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
}

.seo-tabs {
    background: rgba(0, 0, 0, 0.3);
    border-radius: 15px;
    padding: 8px;
    margin-bottom: 30px;
    display: flex;
    gap: 8px;
}

.seo-tab {
    flex: 1;
    padding: 15px 20px;
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.7);
    border-radius: 10px;
    transition: all 0.3s ease;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.seo-tab:hover {
    background: rgba(102, 126, 234, 0.2);
    color: white;
}

.seo-tab.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.seo-form-section {
    background: rgba(255, 255, 255, 0.08);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.seo-form-section h4 {
    color: #667eea;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.3rem;
}

.seo-input-group {
    margin-bottom: 20px;
}

.seo-label {
    display: block;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.seo-input, .seo-textarea, .seo-select {
    width: 100%;
    padding: 12px 16px;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    color: white;
    font-size: 14px;
    transition: all 0.3s ease;
}

.seo-input:focus, .seo-textarea:focus, .seo-select:focus {
    outline: none;
    border-color: #667eea;
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
}

.seo-input::placeholder, .seo-textarea::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.seo-textarea {
    resize: vertical;
    min-height: 100px;
}

.seo-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 12px 30px;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.seo-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}

.seo-btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.seo-btn-info {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
}

.seo-alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
}

.seo-alert-success {
    background: rgba(40, 167, 69, 0.2);
    border: 1px solid rgba(40, 167, 69, 0.5);
    color: #28a745;
}

.seo-alert-danger {
    background: rgba(220, 53, 69, 0.2);
    border: 1px solid rgba(220, 53, 69, 0.5);
    color: #dc3545;
}

.seo-help-text {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.6);
    margin-top: 5px;
}

.seo-card {
    background: rgba(255, 255, 255, 0.08);
    border-radius: 15px;
    padding: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.seo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

.seo-card h5 {
    color: #667eea;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.seo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.seo-page-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 25px;
}

.seo-page-tab {
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.seo-page-tab:hover {
    background: rgba(102, 126, 234, 0.2);
    color: white;
    text-decoration: none;
}

.seo-page-tab.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.seo-tools-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.seo-preview {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 15px;
    margin-top: 15px;
    border-left: 4px solid #667eea;
}

.seo-preview h6 {
    color: #667eea;
    margin-bottom: 10px;
    font-size: 0.9rem;
}

.character-count {
    float: right;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
}

.character-count.warning {
    color: #ffc107;
}

.character-count.danger {
    color: #dc3545;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.seo-tip {
    background: rgba(255, 193, 7, 0.1);
    border: 1px solid rgba(255, 193, 7, 0.3);
    border-radius: 10px;
    padding: 15px;
    margin: 15px 0;
    color: #ffc107;
}
</style>

<div class="seo-container">
    <div class="seo-header">
        <h1 class="seo-title">
            <i class="fas fa-search-plus"></i> SEO Manager
        </h1>
        <p class="seo-subtitle">Gestionează setările SEO pentru optimizarea motorului de căutare</p>
    </div>
    
    <?php if ($success_message): ?>
        <div class="seo-alert seo-alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="seo-alert seo-alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>
    
    <!-- Navigation Tabs -->
    <div class="seo-tabs">
        <button class="seo-tab active" onclick="showTab('global')">
            <i class="fas fa-globe"></i>
            Setări Globale
        </button>
        <button class="seo-tab" onclick="showTab('pages')">
            <i class="fas fa-file-alt"></i>
            Pagini Specifice
        </button>
        <button class="seo-tab" onclick="showTab('tools')">
            <i class="fas fa-tools"></i>
            Instrumente SEO
        </button>
    </div>
    
    <!-- Tab Content -->
    <div id="global" class="tab-content active">
        <div class="seo-form-section">
            <h4><i class="fas fa-globe"></i> Informații Generale</h4>
            <form method="POST" id="globalSeoForm">
                <input type="hidden" name="csrf_token" value="<?php echo $auth->generateCSRFToken(); ?>">
                
                <div class="seo-grid">
                    <div>
                        <div class="seo-input-group">
                            <label class="seo-label">Titlu Site Principal</label>
                            <input type="text" class="seo-input" name="site_title" 
                                   value="<?php echo htmlspecialchars($global_seo['site_title'] ?? ''); ?>" 
                                   placeholder="Ex: Conectica IT - Soluții IT Profesionale"
                                   maxlength="60" oninput="updateCharCount(this, 60)">
                            <div class="seo-help-text">
                                Titlul principal care apare în tab-ul browserului și în rezultatele căutării
                                <span class="character-count" id="site_title_count">0/60</span>
                            </div>
                            <div class="seo-preview">
                                <h6><i class="fas fa-search"></i> Preview Google:</h6>
                                <div style="color: #1a0dab; font-size: 18px; text-decoration: underline;" id="title_preview">
                                    <?php echo htmlspecialchars($global_seo['site_title'] ?? 'Titlul Site-ului'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="seo-input-group">
                            <label class="seo-label">Descrierea Site-ului</label>
                            <textarea class="seo-textarea" name="site_description" 
                                      placeholder="Descriere concisă a serviciilor și experienței tale..."
                                      maxlength="160" oninput="updateCharCount(this, 160)" rows="4"><?php echo htmlspecialchars($global_seo['site_description'] ?? ''); ?></textarea>
                            <div class="seo-help-text">
                                Descrierea care apare sub titlu în rezultatele căutării Google
                                <span class="character-count" id="site_description_count">0/160</span>
                            </div>
                            <div class="seo-preview">
                                <div style="color: #545454; font-size: 14px; line-height: 1.4;" id="description_preview">
                                    <?php echo htmlspecialchars($global_seo['site_description'] ?? 'Descrierea site-ului va apărea aici...'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="seo-input-group">
                            <label class="seo-label">Cuvinte Cheie</label>
                            <input type="text" class="seo-input" name="site_keywords" 
                                   value="<?php echo htmlspecialchars($global_seo['site_keywords'] ?? ''); ?>" 
                                   placeholder="dezvoltare web, freelancer IT, PHP, MySQL">
                            <div class="seo-help-text">
                                Separate prin virgulă. Nu exagera - 5-10 cuvinte sunt suficiente
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="seo-input-group">
                            <label class="seo-label">URL-ul Principal</label>
                            <input type="url" class="seo-input" name="canonical_url" 
                                   value="<?php echo htmlspecialchars($global_seo['canonical_url'] ?? ''); ?>" 
                                   placeholder="https://conectica-it.ro">
                            <div class="seo-help-text">
                                Adresa completă a site-ului tău
                            </div>
                        </div>
                        
                        <div class="seo-input-group">
                            <label class="seo-label">Imagine pentru Social Media</label>
                            <input type="text" class="seo-input" name="og_image" 
                                   value="<?php echo htmlspecialchars($global_seo['og_image'] ?? ''); ?>" 
                                   placeholder="/assets/images/og-image.jpg">
                            <div class="seo-help-text">
                                Imaginea care apare când cineva împărtășește site-ul pe Facebook/Twitter
                                <br><strong>Dimensiuni recomandate:</strong> 1200x630px
                            </div>
                        </div>
                        
                        <div class="seo-tip">
                            <i class="fas fa-lightbulb"></i>
                            <strong>Sfat:</strong> Creează o imagine atractivă cu logo-ul tău și o scurtă descriere a serviciilor.
                        </div>
                    </div>
                </div>
                
                <div class="seo-form-section">
                    <h4><i class="fas fa-chart-line"></i> Instrumente de Analiză</h4>
                    <div class="seo-grid">
                        <div class="seo-input-group">
                            <label class="seo-label">Google Analytics ID</label>
                            <input type="text" class="seo-input" name="google_analytics" 
                                   value="<?php echo htmlspecialchars($global_seo['google_analytics'] ?? ''); ?>" 
                                   placeholder="G-XXXXXXXXXX sau UA-XXXXXXXX-X">
                            <div class="seo-help-text">
                                Pentru a urmări vizitatorii site-ului. 
                                <a href="https://analytics.google.com" target="_blank" style="color: #667eea;">Creează cont aici</a>
                            </div>
                        </div>
                        
                        <div class="seo-input-group">
                            <label class="seo-label">Google Search Console</label>
                            <input type="text" class="seo-input" name="google_search_console" 
                                   value="<?php echo htmlspecialchars($global_seo['google_search_console'] ?? ''); ?>" 
                                   placeholder="content=&quot;cod_verificare&quot;">
                            <div class="seo-help-text">
                                Codul de verificare pentru Search Console.
                                <a href="https://search.google.com/search-console" target="_blank" style="color: #667eea;">Setup aici</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="seo-form-section">
                    <h4><i class="fas fa-robot"></i> Configurare Robots.txt</h4>
                    <div class="seo-input-group">
                        <textarea class="seo-textarea" name="robots_txt" rows="8" style="font-family: 'Courier New', monospace;"><?php echo htmlspecialchars($global_seo['robots_txt'] ?? "User-agent: *\nDisallow: /admin/\nDisallow: /config/\nDisallow: /logs/\n\nSitemap: https://yourdomain.com/sitemap.xml"); ?></textarea>
                        <div class="seo-help-text">
                            Instrucțiuni pentru motoarele de căutare despre ce pagini să indexeze
                        </div>
                    </div>
                </div>
                
                <button type="submit" name="save_global_seo" class="seo-btn seo-btn-success">
                    <i class="fas fa-save"></i>
                    Salvează Setările Globale
                </button>
            </form>
        </div>
    </div>
    
    <!-- Pages Tab -->
    <div id="pages" class="tab-content">
        <div class="seo-form-section">
            <h4><i class="fas fa-file-alt"></i> Optimizare Pagini Individuale</h4>
            <p style="color: rgba(255,255,255,0.8); margin-bottom: 25px;">
                Personalizează setările SEO pentru fiecare pagină în parte pentru rezultate mai bune în căutări
            </p>
            
            <!-- Page Navigation -->
            <div class="seo-page-tabs">
                <?php
                $pages = ['index' => 'Acasă', 'projects' => 'Proiecte', 'blog' => 'Blog', 'contact' => 'Contact', 'request-quote' => 'Cere Ofertă'];
                $first = true;
                foreach ($pages as $page_key => $page_name): 
                ?>
                <a href="#" class="seo-page-tab <?php echo $first ? 'active' : ''; ?>" 
                   onclick="showPageTab('<?php echo $page_key; ?>')"><?php echo $page_name; ?></a>
                <?php 
                $first = false;
                endforeach; 
                ?>
            </div>
            
            <?php
            $first = true;
            foreach ($pages as $page_key => $page_name): 
            $page_data = $page_settings[$page_key] ?? [];
            ?>
            <div id="page-<?php echo $page_key; ?>" class="page-content <?php echo $first ? 'active' : ''; ?>">
                <div class="seo-card">
                    <h5><i class="fas fa-<?php echo $page_key === 'index' ? 'home' : ($page_key === 'projects' ? 'rocket' : ($page_key === 'blog' ? 'blog' : ($page_key === 'contact' ? 'envelope' : 'file-invoice-dollar'))); ?>"></i> 
                        SEO pentru <?php echo $page_name; ?>
                    </h5>
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $auth->generateCSRFToken(); ?>">
                        <input type="hidden" name="page_name" value="<?php echo $page_key; ?>">
                        
                        <div class="seo-grid">
                            <div>
                                <div class="seo-input-group">
                                    <label class="seo-label">Titlu Pagină</label>
                                    <input type="text" class="seo-input" name="site_title" 
                                           value="<?php echo htmlspecialchars($page_data['site_title'] ?? ''); ?>" 
                                           placeholder="Titlu specific pentru <?php echo $page_name; ?>"
                                           maxlength="60">
                                    <div class="seo-help-text">
                                        Un titlu unic și descriptiv pentru această pagină
                                    </div>
                                </div>
                                
                                <div class="seo-input-group">
                                    <label class="seo-label">Descriere Pagină</label>
                                    <textarea class="seo-textarea" name="site_description" rows="3"
                                              placeholder="Descriere specifică pentru <?php echo $page_name; ?>"
                                              maxlength="160"><?php echo htmlspecialchars($page_data['site_description'] ?? ''); ?></textarea>
                                    <div class="seo-help-text">
                                        Descrierea care va apărea în rezultatele de căutare pentru această pagină
                                    </div>
                                </div>
                                
                                <div class="seo-input-group">
                                    <label class="seo-label">Cuvinte Cheie Specifice</label>
                                    <input type="text" class="seo-input" name="site_keywords" 
                                           value="<?php echo htmlspecialchars($page_data['site_keywords'] ?? ''); ?>" 
                                           placeholder="Cuvinte cheie relevante pentru <?php echo $page_name; ?>">
                                    <div class="seo-help-text">
                                        Cuvinte cheie care descriu cel mai bine conținutul acestei pagini
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="seo-input-group">
                                    <label class="seo-label">Titlu Social Media</label>
                                    <input type="text" class="seo-input" name="og_title" 
                                           value="<?php echo htmlspecialchars($page_data['og_title'] ?? ''); ?>" 
                                           placeholder="Titlu pentru partajarea pe social media">
                                    <div class="seo-help-text">
                                        Poate fi diferit de titlul paginii pentru a fi mai atractiv pe social
                                    </div>
                                </div>
                                
                                <div class="seo-input-group">
                                    <label class="seo-label">Descriere Social Media</label>
                                    <textarea class="seo-textarea" name="og_description" rows="3"
                                              placeholder="Descriere pentru social media"><?php echo htmlspecialchars($page_data['og_description'] ?? ''); ?></textarea>
                                    <div class="seo-help-text">
                                        Descrierea care va apărea când pagina este partajată pe Facebook/Twitter
                                    </div>
                                </div>
                                
                                <div class="seo-input-group">
                                    <label class="seo-label">Imagine pentru Partajare</label>
                                    <input type="text" class="seo-input" name="og_image" 
                                           value="<?php echo htmlspecialchars($page_data['og_image'] ?? ''); ?>" 
                                           placeholder="/assets/images/<?php echo $page_key; ?>-social.jpg">
                                    <div class="seo-help-text">
                                        Imagine specifică pentru această pagină (1200x630px recomandat)
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" name="save_page_seo" class="seo-btn">
                            <i class="fas fa-save"></i>
                            Salvează pentru <?php echo $page_name; ?>
                        </button>
                    </form>
                </div>
            </div>
            <?php 
            $first = false;
            endforeach; 
            ?>
        </div>
    </div>
    
    <!-- Tools Tab -->
    <div id="tools" class="tab-content">
        <div class="seo-form-section">
            <h4><i class="fas fa-tools"></i> Instrumente și Verificări SEO</h4>
            
            <div class="seo-tools-grid">
                <div class="seo-card">
                    <h5><i class="fas fa-sitemap"></i> Fișiere SEO</h5>
                    <p style="margin-bottom: 20px; color: rgba(255,255,255,0.8);">
                        Accesează și verifică fișierele generate automat
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="../sitemap.php" target="_blank" class="seo-btn seo-btn-info">
                            <i class="fas fa-external-link-alt"></i>
                            Vezi Sitemap.xml
                        </a>
                        <a href="../robots.php" target="_blank" class="seo-btn seo-btn-info">
                            <i class="fas fa-robot"></i>
                            Vezi Robots.txt
                        </a>
                    </div>
                </div>
                
                <div class="seo-card">
                    <h5><i class="fas fa-chart-line"></i> Analiză și Monitorizare</h5>
                    <p style="margin-bottom: 20px; color: rgba(255,255,255,0.8);">
                        Instrumente externe pentru optimizare
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="https://search.google.com/search-console" target="_blank" class="seo-btn seo-btn-info" style="font-size: 0.9rem; padding: 8px 16px;">
                            <i class="fab fa-google"></i>
                            Search Console
                        </a>
                        <a href="https://analytics.google.com" target="_blank" class="seo-btn seo-btn-info" style="font-size: 0.9rem; padding: 8px 16px;">
                            <i class="fab fa-google"></i>
                            Google Analytics
                        </a>
                        <a href="https://pagespeed.web.dev" target="_blank" class="seo-btn seo-btn-info" style="font-size: 0.9rem; padding: 8px 16px;">
                            <i class="fas fa-tachometer-alt"></i>
                            PageSpeed Insights
                        </a>
                    </div>
                </div>
                
                <div class="seo-card">
                    <h5><i class="fas fa-info-circle"></i> Ghid Rapid SEO</h5>
                    <div style="font-size: 0.9rem; line-height: 1.6;">
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #ffc107;"><i class="fas fa-star"></i> Titluri:</strong>
                            <ul style="margin: 5px 0 0 20px; color: rgba(255,255,255,0.8);">
                                <li>50-60 caractere</li>
                                <li>Include cuvântul cheie</li>
                                <li>Să fie atractiv</li>
                            </ul>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #17a2b8;"><i class="fas fa-align-left"></i> Descrieri:</strong>
                            <ul style="margin: 5px 0 0 20px; color: rgba(255,255,255,0.8);">
                                <li>150-160 caractere</li>
                                <li>Include call-to-action</li>
                                <li>Descrie beneficiile</li>
                            </ul>
                        </div>
                        <div>
                            <strong style="color: #28a745;"><i class="fas fa-image"></i> Imagini:</strong>
                            <ul style="margin: 5px 0 0 20px; color: rgba(255,255,255,0.8);">
                                <li>1200x630px pentru social</li>
                                <li>Format JPG/PNG</li>
                                <li>Sub 1MB dimensiune</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.seo-tab');
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked tab
    event.target.classList.add('active');
}

// Page tab functionality
function showPageTab(pageName) {
    // Hide all page contents
    const pageContents = document.querySelectorAll('.page-content');
    pageContents.forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all page tabs
    const pageTabs = document.querySelectorAll('.seo-page-tab');
    pageTabs.forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Show selected page content
    document.getElementById('page-' + pageName).classList.add('active');
    
    // Add active class to clicked tab
    event.target.classList.add('active');
    
    return false; // Prevent default link behavior
}

// Character counter function
function updateCharCount(input, maxLength) {
    const currentLength = input.value.length;
    const countElement = document.getElementById(input.name + '_count');
    
    if (countElement) {
        countElement.textContent = currentLength + '/' + maxLength;
        
        // Update color based on length
        countElement.className = 'character-count';
        if (currentLength > maxLength * 0.9) {
            countElement.classList.add('danger');
        } else if (currentLength > maxLength * 0.8) {
            countElement.classList.add('warning');
        }
    }
    
    // Update preview
    updatePreview(input);
}

// Preview function
function updatePreview(input) {
    if (input.name === 'site_title') {
        const preview = document.getElementById('title_preview');
        if (preview) {
            preview.textContent = input.value || 'Titlul Site-ului';
        }
    } else if (input.name === 'site_description') {
        const preview = document.getElementById('description_preview');
        if (preview) {
            preview.textContent = input.value || 'Descrierea site-ului va apărea aici...';
        }
    }
}

// Initialize character counts on page load
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('[maxlength]');
    inputs.forEach(input => {
        const maxLength = parseInt(input.getAttribute('maxlength'));
        updateCharCount(input, maxLength);
        
        // Add event listener for real-time updates
        input.addEventListener('input', function() {
            updateCharCount(this, maxLength);
        });
    });
    
    // Add CSS for page content visibility
    const style = document.createElement('style');
    style.textContent = `
        .page-content {
            display: none;
        }
        .page-content.active {
            display: block;
        }
    `;
    document.head.appendChild(style);
});

// Form validation
document.getElementById('globalSeoForm')?.addEventListener('submit', function(e) {
    const titleInput = this.querySelector('[name="site_title"]');
    const descInput = this.querySelector('[name="site_description"]');
    
    if (titleInput.value.trim() === '') {
        e.preventDefault();
        alert('Te rog completează titlul site-ului!');
        titleInput.focus();
        return;
    }
    
    if (descInput.value.trim() === '') {
        e.preventDefault();
        alert('Te rog completează descrierea site-ului!');
        descInput.focus();
        return;
    }
});
</script>
