<?php 
// Auto-deployment test - Last updated: <?= date('Y-m-d H:i:s') ?>
$page_title = "Acasă";
$page_description = "Freelancer IT - Nyikora Noldi. Servicii profesionale de dezvoltare web, aplicații PHP, MySQL, și soluții IT personalizate pentru afaceri moderne.";
include 'config/config.php';
include 'includes/head.php'; 
?>

<section class='hero text-center py-5 mb-5'>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-lg-8'>
                <h1 class='display-4 fw-bold text-white mb-3'>Nyikora Noldi</h1>
                <h2 class='h4 text-white mb-4' style='opacity: 0.9;'>Freelancer & Developer IT</h2>
                <p class='lead text-white mb-4' style='opacity: 0.8;'>Specializat în dezvoltarea de aplicații web moderne și soluții IT personalizate</p>
                <div class='tech-stack mb-4'>
                    <span class='badge bg-light text-dark me-2 mb-2'>PHP</span>
                    <span class='badge bg-light text-dark me-2 mb-2'>MySQL</span>
                    <span class='badge bg-light text-dark me-2 mb-2'>Bootstrap</span>
                    <span class='badge bg-light text-dark me-2 mb-2'>JavaScript</span>
                    <span class='badge bg-light text-dark me-2 mb-2'>HTML/CSS</span>
                </div>
                <div class='d-grid gap-2 d-md-flex justify-content-md-center'>
                    <a href='projects.php' class='btn btn-primary btn-lg me-2'>Vezi Proiectele</a>
                    <a href='request-quote.php' class='btn btn-outline-light btn-lg'>Cere Ofertă</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class='services py-5'>
    <div class='container'>
        <h2 class='text-center mb-5'>Servicii Oferite</h2>
        <div class='row g-4'>
            <div class='col-md-4'>
                <div class='card h-100 border-0 shadow-sm'>
                    <div class='card-body text-center'>
                        <div class='bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center' style='width: 60px; height: 60px;'>
                            <i class='fas fa-code text-white'></i>
                        </div>
                        <h5 class='card-title'>Dezvoltare Web</h5>
                        <p class='card-text'>Aplicații web moderne, responsive și optimizate pentru performanță</p>
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                <div class='card h-100 border-0 shadow-sm'>
                    <div class='card-body text-center'>
                        <div class='bg-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center' style='width: 60px; height: 60px;'>
                            <i class='fas fa-database text-white'></i>
                        </div>
                        <h5 class='card-title'>Baze de Date</h5>
                        <p class='card-text'>Design și optimizare baze de date MySQL pentru aplicații complexe</p>
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                <div class='card h-100 border-0 shadow-sm'>
                    <div class='card-body text-center'>
                        <div class='bg-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center' style='width: 60px; height: 60px;'>
                            <i class='fas fa-tools text-white'></i>
                        </div>
                        <h5 class='card-title'>Mentenanță IT</h5>
                        <p class='card-text'>Suport tehnic și mentenanță pentru aplicațiile web existente</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class='contact-cta bg-light py-5'>
    <div class='container text-center'>
        <h2 class='mb-3'>Ai un proiect în minte?</h2>
        <p class='lead mb-4'>Să discutăm despre cum pot să te ajut să-ți atingi obiectivele!</p>
        <a href='contact.php' class='btn btn-primary btn-lg'>Contactează-mă</a>
    </div>
</section>

<?php include 'includes/foot.php'; ?>