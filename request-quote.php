<?php 
$page_title = "Cere Ofertă";
$page_description = "Solicită o ofertă personalizată pentru proiectul tău IT. Primești răspuns în 24 de ore cu detalii complete.";
include 'config/config.php';
require_once 'includes/head.php'; 
?>

<div class="py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold mb-3">Cere Ofertă Personalizată</h1>
                <p class="lead text-muted">Completează formularul de mai jos și îți voi trimite o ofertă detaliată în maxim 24 de ore</p>
            </div>
            
            <!-- Quote Form -->
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <form action="request-quote.php" method="POST" id="quoteForm" class="quote-form">
                        
                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h4 class="mb-3">
                                <i class="fas fa-user text-primary me-2"></i>Informații de Contact
                            </h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nume complet *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Adresa de email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Telefon</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6">
                                    <label for="company" class="form-label">Compania</label>
                                    <input type="text" class="form-control" id="company" name="company">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Project Details -->
                        <div class="mb-4">
                            <h4 class="mb-3">
                                <i class="fas fa-project-diagram text-primary me-2"></i>Detalii Proiect
                            </h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="project_type" class="form-label">Tipul proiectului *</label>
                                    <select class="form-select" id="project_type" name="project_type" required>
                                        <option value="">Selectează tipul proiectului</option>
                                        <option value="website-nou">Website nou</option>
                                        <option value="aplicatie-web">Aplicație web</option>
                                        <option value="ecommerce">Magazin online</option>
                                        <option value="cms">Sistem de management</option>
                                        <option value="api">API / Web Services</option>
                                        <option value="mentenanta">Mentenanță website</option>
                                        <option value="optimizare">Optimizare/Redesign</option>
                                        <option value="altele">Altele</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="budget" class="form-label">Buget aproximativ *</label>
                                    <select class="form-select" id="budget" name="budget" required>
                                        <option value="">Selectează bugetul</option>
                                        <option value="500-1000">500€ - 1.000€</option>
                                        <option value="1000-2500">1.000€ - 2.500€</option>
                                        <option value="2500-5000">2.500€ - 5.000€</option>
                                        <option value="5000-10000">5.000€ - 10.000€</option>
                                        <option value="10000+">10.000€+</option>
                                        <option value="discutie">De discutat</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="timeline" class="form-label">Termen de livrare *</label>
                                    <select class="form-select" id="timeline" name="timeline" required>
                                        <option value="">Selectează termenul</option>
                                        <option value="urgent">Urgent (1-2 săptămâni)</option>
                                        <option value="normal">Normal (3-4 săptămâni)</option>
                                        <option value="relaxed">Flexibil (1-2 luni)</option>
                                        <option value="future">Planificat pentru viitor</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="priority" class="form-label">Prioritatea proiectului</label>
                                    <select class="form-select" id="priority" name="priority">
                                        <option value="normal">Normală</option>
                                        <option value="high">Înaltă</option>
                                        <option value="urgent">Urgentă</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Technical Requirements -->
                        <div class="mb-4">
                            <h4 class="mb-3">
                                <i class="fas fa-cogs text-primary me-2"></i>Cerințe Tehnice
                            </h4>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Tehnologii preferate (opțional)</label>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="technologies[]" value="php" id="tech-php">
                                            <label class="form-check-label" for="tech-php">PHP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="technologies[]" value="mysql" id="tech-mysql">
                                            <label class="form-check-label" for="tech-mysql">MySQL</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="technologies[]" value="javascript" id="tech-js">
                                            <label class="form-check-label" for="tech-js">JavaScript</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="technologies[]" value="bootstrap" id="tech-bootstrap">
                                            <label class="form-check-label" for="tech-bootstrap">Bootstrap</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="technologies[]" value="api" id="tech-api">
                                            <label class="form-check-label" for="tech-api">API Integration</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="responsive" id="feat-responsive">
                                        <label class="form-check-label" for="feat-responsive">Design responsive</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="seo" id="feat-seo">
                                        <label class="form-check-label" for="feat-seo">Optimizare SEO</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="admin" id="feat-admin">
                                        <label class="form-check-label" for="feat-admin">Panou de administrare</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="users" id="feat-users">
                                        <label class="form-check-label" for="feat-users">Sistem utilizatori</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="payment" id="feat-payment">
                                        <label class="form-check-label" for="feat-payment">Sistem de plăți</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="multilang" id="feat-multilang">
                                        <label class="form-check-label" for="feat-multilang">Multi-limbă</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Project Description -->
                        <div class="mb-4">
                            <h4 class="mb-3">
                                <i class="fas fa-file-alt text-primary me-2"></i>Descrierea Proiectului
                            </h4>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrie-mi proiectul în detaliu *</label>
                                <textarea class="form-control" id="description" name="description" rows="5" 
                                    placeholder="Spune-mi despre obiectivele proiectului, funcționalitățile dorite, targetul de utilizatori, etc..." required></textarea>
                                <div class="form-text">Minimum 50 de caractere pentru o evaluare corectă</div>
                            </div>
                            <div class="mb-3">
                                <label for="inspiration" class="form-label">Website-uri de inspirație (opțional)</label>
                                <textarea class="form-control" id="inspiration" name="inspiration" rows="2" 
                                    placeholder="Adaugă link-uri către site-uri care îți plac sau care seamănă cu ce vrei să realizezi"></textarea>
                            </div>
                        </div>
                        
                        <!-- Additional Information -->
                        <div class="mb-4">
                            <h4 class="mb-3">
                                <i class="fas fa-info-circle text-primary me-2"></i>Informații Suplimentare
                            </h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="additional[]" value="hosting" id="add-hosting">
                                        <label class="form-check-label" for="add-hosting">Am nevoie de ajutor cu hosting-ul</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="additional[]" value="domain" id="add-domain">
                                        <label class="form-check-label" for="add-domain">Am nevoie de ajutor cu domeniul</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="additional[]" value="content" id="add-content">
                                        <label class="form-check-label" for="add-content">Am nevoie de ajutor cu conținutul</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="additional[]" value="maintenance" id="add-maintenance">
                                        <label class="form-check-label" for="add-maintenance">Doresc un contract de mentenanță</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="additional[]" value="training" id="add-training">
                                        <label class="form-check-label" for="add-training">Doresc training pentru administrare</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="text-center">
                            <button type="submit" name="request_quote" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i>Trimite Solicitarea
                            </button>
                            <p class="text-muted mt-3 small">
                                <i class="fas fa-shield-alt me-1"></i>
                                Informațiile tale sunt sigure și vor fi folosite doar pentru a-ți oferi o ofertă personalizată
                            </p>
                        </div>
                    </form>
                    
                    <?php
                    if(isset($_POST['request_quote'])) {
                        echo '<div class="alert alert-success mt-4" role="alert">
                                <h4 class="alert-heading">
                                    <i class="fas fa-check-circle me-2"></i>Solicitare trimisă cu succes!
                                </h4>
                                <p>Mulțumesc pentru încredere! Am primit solicitarea ta și îți voi trimite o ofertă detaliată în maxim 24 de ore pe adresa de email furnizată.</p>
                                <hr>
                                <p class="mb-0">
                                    <strong>Următorii pași:</strong><br>
                                    1. Voi analiza cerințele tale în detaliu<br>
                                    2. Îți voi trimite o ofertă personalizată cu timeline și costuri<br>
                                    3. Vom programa o întâlnire pentru a discuta detaliile
                                </p>
                              </div>';
                    }
                    ?>
                </div>
            </div>
            
            <!-- Pricing Info -->
            <div class="row mt-5 g-4">
                <div class="col-md-4">
                    <div class="card text-center border-0 h-100">
                        <div class="card-body">
                            <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <h5>Răspuns în 24h</h5>
                            <p class="text-muted">Îți voi trimite o ofertă detaliată în maxim 24 de ore</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-0 h-100">
                        <div class="card-body">
                            <div class="bg-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-euro-sign text-white"></i>
                            </div>
                            <h5>Prețuri Transparente</h5>
                            <p class="text-muted">Fără costuri ascunse - prețul din ofertă este prețul final</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-0 h-100">
                        <div class="card-body">
                            <div class="bg-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-handshake text-white"></i>
                            </div>
                            <h5>Garanție & Support</h5>
                            <p class="text-muted">3 luni garanție și suport tehnic gratuit după livrare</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quoteForm');
    const description = document.getElementById('description');
    
    // Character count for description
    description.addEventListener('input', function() {
        const length = this.value.length;
        const minLength = 50;
        
        if (length < minLength) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        } else {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
        }
    });
    
    // Form validation
    form.addEventListener('submit', function(e) {
        if (description.value.length < 50) {
            e.preventDefault();
            description.focus();
            alert('Te rog să descrii proiectul în cel puțin 50 de caractere pentru o evaluare corectă.');
        }
    });
    
    // Dynamic pricing hints
    const projectType = document.getElementById('project_type');
    const budget = document.getElementById('budget');
    
    projectType.addEventListener('change', function() {
        // You can add logic here to show estimated prices based on project type
    });
});
</script>

<?php include 'includes/foot.php'; ?>