<?php 
$page_title = "Contact";
$page_description = "Contactează Nyikora Noldi pentru servicii IT profesionale. Email, telefon și informații complete de contact.";
require_once 'config/config.php';
require_once 'includes/head.php'; 
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
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">Trimite-mi un mesaj</h5>
                            <form action="contact.php" method="POST" class="contact-form">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nume complet *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Telefon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subject" class="form-label">Subiect *</label>
                                        <select class="form-select" id="subject" name="subject" required>
                                            <option value="">Selectează subiectul</option>
                                            <option value="dezvoltare-web">Dezvoltare Web</option>
                                            <option value="aplicatie-php">Aplicație PHP</option>
                                            <option value="baza-date">Bază de Date</option>
                                            <option value="mentenanta">Mentenanță IT</option>
                                            <option value="consultanta">Consultanță IT</option>
                                            <option value="altele">Altele</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Mesaj *</label>
                                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Descrie-mi proiectul tău sau întrebarea pe care o ai..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" name="send_message" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane me-2"></i>Trimite Mesajul
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <?php
                            if(isset($_POST['send_message'])) {
                                // Aici poți adăuga logica pentru trimiterea email-ului
                                echo '<div class="alert alert-success mt-3" role="alert">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Mulțumesc pentru mesaj! Te voi contacta în cel mai scurt timp posibil.
                                      </div>';
                            }
                            ?>
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

<?php require_once 'includes/foot.php'; ?>