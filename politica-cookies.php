<?php 
$page_title = "Politica de Cookies";
$page_description = "Informații despre utilizarea cookies-urilor pe site-ul Conectica-IT și cum să le gestionezi.";
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/head.php'; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h1 class="h2 mb-4">
                        <i class="fas fa-cookie-bite text-primary me-3"></i>
                        Politica de Cookies
                    </h1>
                    
                    <p class="lead text-muted mb-4">
                        Această politică explică cum utilizăm cookies-urile pe site-ul nostru și cum poți controla preferințele tale.
                    </p>
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="h4 mb-3">Ce sunt cookies-urile?</h3>
                            <p>
                                Cookies-urile sunt fișiere mici de text care sunt plasate pe dispozitivul tău când vizitezi un site web. 
                                Ele sunt utilizate pe scară largă pentru a face site-urile web să funcționeze mai eficient, precum și 
                                pentru a furniza informații proprietarilor site-ului.
                            </p>
                            
                            <h3 class="h4 mb-3 mt-4">Cum folosim cookies-urile</h3>
                            <p>Utilizăm cookies-urile pentru următoarele scopuri:</p>
                            
                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <div class="card border-start border-primary border-4 h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-cog text-primary me-2"></i>
                                                Cookies Esențiale
                                            </h5>
                                            <p class="card-text">
                                                Necesare pentru funcționarea de bază a site-ului, inclusiv navigarea și 
                                                accesarea zonelor securizate. Aceste cookies nu pot fi dezactivate.
                                            </p>
                                            <small class="text-muted">
                                                <strong>Exemple:</strong> Sesiuni de login, preferințe de limbă, coșul de cumpărături
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card border-start border-info border-4 h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-chart-line text-info me-2"></i>
                                                Cookies de Analiză
                                            </h5>
                                            <p class="card-text">
                                                Ne ajută să înțelegem cum utilizezi site-ul nostru prin colectarea de 
                                                informații anonime despre paginile vizitate și timpul petrecut.
                                            </p>
                                            <small class="text-muted">
                                                <strong>Servicii folosite:</strong> Google Analytics (opțional)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card border-start border-success border-4 h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-comments text-success me-2"></i>
                                                Cookies de Chat
                                            </h5>
                                            <p class="card-text">
                                                Utilizate pentru funcționarea sistemului de chat live, pentru a-ți 
                                                aminti preferințele și a menține continuitatea conversațiilor.
                                            </p>
                                            <small class="text-muted">
                                                <strong>Servicii folosite:</strong> Tawk.to, Crisp Chat
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card border-start border-warning border-4 h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-shield-alt text-warning me-2"></i>
                                                Cookies de Securitate
                                            </h5>
                                            <p class="card-text">
                                                Protejează împotriva atacurilor malițioase și asigură securitatea 
                                                comunicării între browserul tău și serverul nostru.
                                            </p>
                                            <small class="text-muted">
                                                <strong>Includ:</strong> CSRF tokens, verificare sesiuni, rate limiting
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="h4 mb-3 mt-5">Gestionarea cookies-urilor</h3>
                            <p>
                                Poți controla și/sau șterge cookies-urile după dorință. Poți șterge toate cookies-urile 
                                care sunt deja pe dispozitivul tău și poți seta majoritatea browserelor să le împiedice să fie plasate.
                            </p>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Atenție:</strong> Dacă faci acest lucru, este posibil să trebuiască să ajustezi manual 
                                unele preferințe de fiecare dată când vizitezi un site, iar unele servicii și funcții s-ar putea să nu funcționeze.
                            </div>
                            
                            <h4 class="h5 mb-3">Instrucțiuni pentru browsere populare:</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fab fa-chrome text-warning me-2"></i>
                                    <strong>Google Chrome:</strong> Setări → Confidențialitate și securitate → Cookies și alte date ale site-urilor
                                </li>
                                <li class="mb-2">
                                    <i class="fab fa-firefox text-danger me-2"></i>
                                    <strong>Firefox:</strong> Opțiuni → Confidențialitate și securitate → Cookies și date ale site-urilor
                                </li>
                                <li class="mb-2">
                                    <i class="fab fa-safari text-primary me-2"></i>
                                    <strong>Safari:</strong> Preferințe → Confidențialitate → Gestionare date site web
                                </li>
                                <li class="mb-2">
                                    <i class="fab fa-edge text-info me-2"></i>
                                    <strong>Microsoft Edge:</strong> Setări → Cookies și permisiuni pentru site
                                </li>
                            </ul>
                            
                            <h3 class="h4 mb-3 mt-5">Modificări ale acestei politici</h3>
                            <p>
                                Ne rezervăm dreptul de a actualiza această politică de cookies din când în când. 
                                Te încurajăm să revii periodic pentru a fi la curent cu modul în care protejăm informațiile tale.
                            </p>
                            
                            <div class="bg-light p-4 rounded mt-4">
                                <h4 class="h5 mb-3">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    Întrebări?
                                </h4>
                                <p class="mb-3">
                                    Dacă ai întrebări despre această politică de cookies sau despre cum gestionăm datele tale, 
                                    nu ezita să ne contactezi:
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <i class="fas fa-envelope me-2 text-muted"></i>
                                            <a href="mailto:<?php echo defined('CONTACT_EMAIL') ? CONTACT_EMAIL : 'conectica.it.ro@gmail.com'; ?>" class="text-decoration-none">
                                                <?php echo defined('CONTACT_EMAIL') ? CONTACT_EMAIL : 'conectica.it.ro@gmail.com'; ?>
                                            </a>
                                        </p>
                                        <p class="mb-2">
                                            <i class="fas fa-phone me-2 text-muted"></i>
                                            <a href="tel:<?php echo defined('CONTACT_PHONE') ? CONTACT_PHONE : '0740173581'; ?>" class="text-decoration-none">
                                                <?php echo defined('CONTACT_PHONE') ? CONTACT_PHONE : '0740173581'; ?>
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="contact.php" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            Trimite un mesaj
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4 pt-4 border-top">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Ultima actualizare: <?php echo date('d.m.Y'); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/foot.php'; ?>
