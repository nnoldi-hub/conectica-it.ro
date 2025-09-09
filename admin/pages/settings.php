<?php
require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

// Auth with bootstrap-provided PDO
$auth = new AuthSystem(isset($pdo) ? $pdo : null);
$auth->requireAuth();

$success_message = '';
$error_message = '';

// Handle form submission
if ($_POST) {
    if (!$auth->validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error_message = 'Token de securitate invalid!';
    } else {
        $action = $_POST['action'] ?? '';
        
        if ($action === 'update_settings') {
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $website_url = trim($_POST['website_url'] ?? '');
            $company_name = trim($_POST['company_name'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $description = trim($_POST['description'] ?? '');
            
            // Social media settings
            $facebook_url = trim($_POST['facebook_url'] ?? '');
            $instagram_url = trim($_POST['instagram_url'] ?? '');
            $linkedin_url = trim($_POST['linkedin_url'] ?? '');
            $youtube_url = trim($_POST['youtube_url'] ?? '');
            
            // Validation
            if (empty($email)) {
                $error_message = 'Emailul este obligatoriu!';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = 'Adresa de email nu este validă!';
            } else {
                try {
                    // Check if settings table exists, if not create it
                    $stmt = $pdo->query("SHOW TABLES LIKE 'site_settings'");
                    if ($stmt->rowCount() == 0) {
                        $createTable = "CREATE TABLE site_settings (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            setting_key VARCHAR(100) UNIQUE NOT NULL,
                            setting_value TEXT,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                        )";
                        $pdo->exec($createTable);
                    }
                    
                    // Update or insert settings
                    $settings = [
                        'contact_email' => $email,
                        'contact_phone' => $phone,
                        'website_url' => $website_url,
                        'company_name' => $company_name,
                        'company_address' => $address,
                        'company_description' => $description,
                        'social_facebook' => $facebook_url,
                        'social_instagram' => $instagram_url,
                        'social_linkedin' => $linkedin_url,
                        'social_youtube' => $youtube_url
                    ];
                    
                    foreach ($settings as $key => $value) {
                        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) 
                                             VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                        $stmt->execute([$key, $value]);
                    }
                    
                    $success_message = 'Setările au fost salvate cu succes!';
                } catch (PDOException $e) {
                    $error_message = 'Eroare la salvarea setărilor: ' . $e->getMessage();
                }
            }
        }
    }
}

// Get current settings
$current_settings = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $current_settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (PDOException $e) {
    // Use default values if table doesn't exist yet
}

// Set default values
$settings = array_merge([
    'contact_email' => 'conectica.it.ro@gmail.com',
    'contact_phone' => '0740173581',
    'website_url' => 'conectica-it.ro',
    'company_name' => 'Conectica IT',
    'company_address' => '',
    'company_description' => '',
    'social_facebook' => 'https://www.facebook.com/oferte.conectica.it.ro',
    'social_instagram' => '',
    'social_linkedin' => '',
    'social_youtube' => ''
], $current_settings);

$csrf_token = $auth->generateCSRFToken();
?>

<div class="settings-management">
    <div class="page-header">
        <h2><i class="fas fa-cog"></i> Setări Site</h2>
        <p>Configurează setările generale și informațiile de contact</p>
    </div>

    <?php if ($success_message): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php echo htmlspecialchars($success_message); ?>
    </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <?php echo htmlspecialchars($error_message); ?>
    </div>
    <?php endif; ?>

    <div class="settings-sections">
        <div class="settings-card">
            <h3><i class="fas fa-address-book"></i> Informații Contact</h3>
            
            <form method="POST" class="settings-form">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <input type="hidden" name="action" value="update_settings">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email Contact
                        </label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($settings['contact_email']); ?>" 
                               placeholder="email@example.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone"></i>
                            Telefon
                        </label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($settings['contact_phone']); ?>" 
                               placeholder="0740173581">
                    </div>
                    
                    <div class="form-group">
                        <label for="website_url">
                            <i class="fas fa-globe"></i>
                            URL Website
                        </label>
                        <input type="text" id="website_url" name="website_url" 
                               value="<?php echo htmlspecialchars($settings['website_url']); ?>" 
                               placeholder="conectica-it.ro">
                    </div>
                    
                    <div class="form-group">
                        <label for="company_name">
                            <i class="fas fa-building"></i>
                            Nume Companie
                        </label>
                        <input type="text" id="company_name" name="company_name" 
                               value="<?php echo htmlspecialchars($settings['company_name']); ?>" 
                               placeholder="Conectica IT">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="address">
                            <i class="fas fa-map-marker-alt"></i>
                            Adresă
                        </label>
                        <input type="text" id="address" name="address" 
                               value="<?php echo htmlspecialchars($settings['company_address']); ?>" 
                               placeholder="Strada, Numărul, Orașul, Județul">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="description">
                            <i class="fas fa-info-circle"></i>
                            Descriere Companie
                        </label>
                        <textarea id="description" name="description" rows="4" 
                                  placeholder="O scurtă descriere a companiei..."><?php echo htmlspecialchars($settings['company_description']); ?></textarea>
                    </div>
                    
                    <!-- Social Media Section -->
                    <div class="form-section">
                        <h4><i class="fab fa-facebook"></i> Social Media</h4>
                        <p class="section-description">Configurează linkurile către conturile de social media ale companiei</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="facebook_url">
                            <i class="fab fa-facebook"></i>
                            Facebook
                        </label>
                        <input type="url" id="facebook_url" name="facebook_url" 
                               value="<?php echo htmlspecialchars($settings['social_facebook']); ?>" 
                               placeholder="https://www.facebook.com/pagina-ta">
                    </div>
                    
                    <div class="form-group">
                        <label for="instagram_url">
                            <i class="fab fa-instagram"></i>
                            Instagram
                        </label>
                        <input type="url" id="instagram_url" name="instagram_url" 
                               value="<?php echo htmlspecialchars($settings['social_instagram']); ?>" 
                               placeholder="https://www.instagram.com/contul-tau">
                    </div>
                    
                    <div class="form-group">
                        <label for="linkedin_url">
                            <i class="fab fa-linkedin"></i>
                            LinkedIn
                        </label>
                        <input type="url" id="linkedin_url" name="linkedin_url" 
                               value="<?php echo htmlspecialchars($settings['social_linkedin']); ?>" 
                               placeholder="https://www.linkedin.com/company/compania-ta">
                    </div>
                    
                    <div class="form-group">
                        <label for="youtube_url">
                            <i class="fab fa-youtube"></i>
                            YouTube
                        </label>
                        <input type="url" id="youtube_url" name="youtube_url" 
                               value="<?php echo htmlspecialchars($settings['social_youtube']); ?>" 
                               placeholder="https://www.youtube.com/canalul-tau">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Salvează Setările
                    </button>
                </div>
            </form>
        </div>
        
        <!-- SEO Settings -->
        <div class="settings-card">
            <h3><i class="fas fa-search"></i> Informații SEO</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Sitemap URL:</label>
                    <span>
                        <a href="../../sitemap.xml" target="_blank">
                            <?php echo htmlspecialchars($settings['website_url']); ?>/sitemap.xml
                        </a>
                    </span>
                </div>
                <div class="info-item">
                    <label>RSS Feed:</label>
                    <span>
                        <a href="../../rss.xml" target="_blank">
                            <?php echo htmlspecialchars($settings['website_url']); ?>/rss.xml
                        </a>
                    </span>
                </div>
                <div class="info-item">
                    <label>Robots.txt:</label>
                    <span>
                        <a href="../../robots.txt" target="_blank">
                            <?php echo htmlspecialchars($settings['website_url']); ?>/robots.txt
                        </a>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- System Info -->
        <div class="settings-card">
            <h3><i class="fas fa-server"></i> Informații Sistem</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Versiune PHP:</label>
                    <span><?php echo PHP_VERSION; ?></span>
                </div>
                <div class="info-item">
                    <label>Server:</label>
                    <span><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></span>
                </div>
                <div class="info-item">
                    <label>Ultima actualizare:</label>
                    <span><?php echo date('d.m.Y H:i'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.settings-management {
    padding: 0;
}

.page-header {
    margin-bottom: 30px;
    text-align: center;
}

.page-header h2 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 2.2rem;
}

.page-header p {
    color: #7f8c8d;
    font-size: 1.1rem;
}

.settings-sections {
    display: grid;
    gap: 25px;
    margin-bottom: 30px;
}

.settings-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.settings-card h3 {
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    color: #2c3e50;
    margin-bottom: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-group input,
.form-group textarea {
    padding: 12px 15px;
    border: 2px solid rgba(52, 152, 219, 0.2);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: rgba(52, 152, 219, 0.1);
    border-radius: 8px;
}

.info-item label {
    font-weight: 600;
    color: #2c3e50;
}

.info-item span {
    color: #3498db;
    font-weight: 500;
}

.info-item a {
    color: #3498db;
    text-decoration: none;
}

.info-item a:hover {
    text-decoration: underline;
}

.form-actions {
    text-align: center;
}

.btn {
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2980b9, #3498db);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
}

.alert-success {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
    border: 1px solid rgba(39, 174, 96, 0.3);
}

.alert-danger {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Form validation
document.querySelector('.settings-form').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            field.style.borderColor = '';
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Te rog completează toate câmpurile obligatorii!');
    }
});

// Real-time validation for email
document.getElementById('email').addEventListener('blur', function() {
    const email = this.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        this.style.borderColor = '#e74c3c';
        alert('Te rog introdu o adresă de email validă!');
    } else {
        this.style.borderColor = '';
    }
});
</script>
