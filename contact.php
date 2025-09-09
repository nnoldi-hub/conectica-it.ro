<?php 
$page_title = "Contact & Colaborare | Cere Ofertă Dezvoltare Web | Conectica IT";
$page_description = "Contactează-mă pentru proiecte web, aplicații PHP, consultanță IT. Răspund rapid la cereri. Telefon: +40740173581, Email: conectica.it.ro@gmail.com";
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/head.php'; 
?>

<div class="py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4">Contact</h1>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user text-white fa-lg"></i>
                            </div>
                            <h5 class="card-title">Nyikora Noldi</h5>
                            <p class="card-text text-muted">Freelancer & Developer IT</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Informații Contact</h5>
                            <div class="contact-item mb-3">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <strong>Email:</strong><br>
                                <a href="mailto:<?php echo CONTACT_EMAIL; ?>" class="text-decoration-none"><?php echo CONTACT_EMAIL; ?></a>
                            </div>
                            <div class="contact-item mb-3">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <strong>Telefon:</strong><br>
                                <a href="tel:<?php echo CONTACT_PHONE; ?>" class="text-decoration-none"><?php echo CONTACT_PHONE; ?></a>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-globe text-primary me-2"></i>
                                <strong>Website:</strong><br>
                                <a href="https://<?php echo WEBSITE_URL; ?>" class="text-decoration-none" target="_blank"><?php echo WEBSITE_URL; ?></a>
                            </div>
                            
                            <?php
                            // Display social media links
                            if (isset($pdo) && function_exists('getSocialMediaSettings')) {
                                $socialSettings = getSocialMediaSettings($pdo);
                                $hasAnyLink = array_filter($socialSettings);
                                
                                if (!empty($hasAnyLink)): ?>
                                    <div class="contact-item mt-4">
                                        <i class="fas fa-share-alt text-primary me-2"></i>
                                        <strong>Urmărește-mă:</strong><br>
                                        <div class="mt-2">
                                            <?php echo generateSocialMediaIcons($socialSettings, 'social-icons contact-social'); ?>
                                        </div>
                                    </div>
                                    
                                    <style>
                                    .contact-social .social-icon {
                                        width: 35px;
                                        height: 35px;
                                        font-size: 14px;
                                        margin-right: 8px;
                                        margin-bottom: 8px;
                                    }
                                    </style>
                                <?php endif;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">Trimite-mi un mesaj</h5>
                            
                            <?php
                            // Initialize CSRF token
                            if (!isset($_SESSION['csrf_token'])) {
                                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                            }
                            
                            // Process form submission
                            $form_error = '';
                            $form_success = '';
                            
                            if (isset($_POST['send_message'])) {
                                // CSRF validation
                                if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                                    $form_error = 'Token de securitate invalid. Te rog să încerci din nou.';
                                } else {
                                    // Basic rate limiting (session-based)
                                    $last_submit = $_SESSION['last_contact_submit'] ?? 0;
                                    if (time() - $last_submit < 30) {
                                        $form_error = 'Te rog să aștepți 30 de secunde între mesaje.';
                                    } else {
                                        // Validate and sanitize input
                                        $name = trim($_POST['name'] ?? '');
                                        $email = trim($_POST['email'] ?? '');
                                        $phone = trim($_POST['phone'] ?? '');
                                        $subject = trim($_POST['subject'] ?? '');
                                        $message = trim($_POST['message'] ?? '');
                                        
                                        // Server-side validation
                                        if (strlen($name) < 2) {
                                            $form_error = 'Numele trebuie să aibă cel puțin 2 caractere.';
                                        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                            $form_error = 'Adresa de email nu este validă.';
                                        } elseif (strlen($message) < 10) {
                                            $form_error = 'Mesajul trebuie să aibă cel puțin 10 caractere.';
                                        } elseif (!in_array($subject, ['dezvoltare-web', 'aplicatie-php', 'baza-date', 'mentenanta', 'consultanta', 'altele'])) {
                                            $form_error = 'Te rog să selectezi un subiect valid.';
                                        } else {
                                            // All validations passed
                                            $_SESSION['last_contact_submit'] = time();
                                            
                                            // Here you would normally send the email
                                            // For now, just show success message
                                            $form_success = 'Mulțumesc pentru mesaj! Te voi contacta în cel mai scurt timp posibil.';
                                            
                                            // Regenerate CSRF token after successful submission
                                            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                                        }
                                    }
                                }
                            }
                            
                            // Display messages
                            if ($form_error): ?>
                                <div class="alert alert-danger mb-4" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($form_error) ?>
                                </div>
                            <?php endif;
                            
                            if ($form_success): ?>
                                <div class="alert alert-success mb-4" role="alert">
                                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($form_success) ?>
                                </div>
                            <?php endif; ?>
                            
                            <form action="contact.php" method="POST" class="contact-form" novalidate>
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nume complet *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" 
                                               required minlength="2" maxlength="100">
                                        <div class="invalid-feedback">
                                            Te rog să introduci numele tău complet (min. 2 caractere).
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                                               required>
                                        <div class="invalid-feedback">
                                            Te rog să introduci o adresă de email validă.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Telefon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" 
                                               pattern="[0-9+\-\s\(\)]+" maxlength="20">
                                        <div class="invalid-feedback">
                                            Te rog să introduci un număr de telefon valid.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subject" class="form-label">Subiect *</label>
                                        <select class="form-select" id="subject" name="subject" required>
                                            <option value="">Selectează subiectul</option>
                                            <option value="dezvoltare-web" <?= ($_POST['subject'] ?? '') === 'dezvoltare-web' ? 'selected' : '' ?>>Dezvoltare Web</option>
                                            <option value="aplicatie-php" <?= ($_POST['subject'] ?? '') === 'aplicatie-php' ? 'selected' : '' ?>>Aplicație PHP</option>
                                            <option value="baza-date" <?= ($_POST['subject'] ?? '') === 'baza-date' ? 'selected' : '' ?>>Bază de Date</option>
                                            <option value="mentenanta" <?= ($_POST['subject'] ?? '') === 'mentenanta' ? 'selected' : '' ?>>Mentenanță IT</option>
                                            <option value="consultanta" <?= ($_POST['subject'] ?? '') === 'consultanta' ? 'selected' : '' ?>>Consultanță IT</option>
                                            <option value="altele" <?= ($_POST['subject'] ?? '') === 'altele' ? 'selected' : '' ?>>Altele</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Te rog să selectezi un subiect.
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Mesaj *</label>
                                        <textarea class="form-control" id="message" name="message" rows="5" 
                                                  placeholder="Descrie-mi proiectul tău sau întrebarea pe care o ai..." 
                                                  required minlength="10" maxlength="2000"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                                        <div class="invalid-feedback">
                                            Te rog să scrii un mesaj (min. 10 caractere, max. 2000).
                                        </div>
                                        <div class="form-text">
                                            <span id="char-count">0</span>/2000 caractere
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="privacy-consent" required>
                                            <label class="form-check-label" for="privacy-consent">
                                                Sunt de acord ca datele mele să fie procesate conform <a href="politica-cookies.php" target="_blank">politicii de confidențialitate</a> *
                                            </label>
                                            <div class="invalid-feedback">
                                                Trebuie să accepți politica de confidențialitate.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" name="send_message" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane me-2"></i>Trimite Mesajul
                                        </button>
                                        <small class="text-muted ms-3">
                                            <i class="fas fa-shield-alt me-1"></i>Protejat împotriva spam-ului
                                        </small>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <h4 class="mb-3">De ce să lucrezi cu mine?</h4>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-clock text-primary fa-2x mb-2"></i>
                            <h6>Răspuns Rapid</h6>
                            <p class="text-muted small">Răspund la mesaje în maxim 24h</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-shield-alt text-primary fa-2x mb-2"></i>
                            <h6>Calitate Garantată</h6>
                            <p class="text-muted small">Cod curat și soluții profesionale</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-handshake text-primary fa-2x mb-2"></i>
                            <h6>Comunicare Transparentă</h6>
                            <p class="text-muted small">Te țin la curent în fiecare etapă</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for message textarea
    const messageTextarea = document.getElementById('message');
    const charCount = document.getElementById('char-count');
    
    function updateCharCount() {
        const count = messageTextarea.value.length;
        charCount.textContent = count;
        
        // Visual feedback for character count
        if (count > 1900) {
            charCount.style.color = '#dc3545'; // Red
        } else if (count > 1500) {
            charCount.style.color = '#ffc107'; // Yellow
        } else {
            charCount.style.color = '#6c757d'; // Default gray
        }
    }
    
    messageTextarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Initialize count
    
    // Bootstrap form validation
    const form = document.querySelector('.contact-form');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    });
    
    // Real-time validation feedback
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/foot.php'; ?>