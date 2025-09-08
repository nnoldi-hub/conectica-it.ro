<?php
$page_title = 'Despre mine';
$page_description = 'Află mai multe despre Nyikora Noldi: experiență, abilități și valori în dezvoltarea de soluții IT.';
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/head.php';
?>

<section class="py-5">
  <div class="container">
    <div class="row align-items-center g-4 mb-5">
      <div class="col-lg-5">
        <img src="assets/images/placeholders/wide-orange.svg" class="img-fluid rounded shadow-sm" alt="Portret Nyikora Noldi">
      </div>
      <div class="col-lg-7">
        <h1 class="mb-3">Despre mine</h1>
        <p class="lead text-muted">Sunt Nyikora Noldi, dezvoltator web freelancer. Construiesc aplicații robuste, ușor de întreținut și orientate pe obiectivele de business.</p>
        <ul class="list-unstyled">
          <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Experiență cu PHP, MySQL, Bootstrap, JavaScript</li>
          <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Focus pe performanță, securitate, UX și SEO</li>
          <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Comunicare clară și livrare predictibilă</li>
        </ul>
        <div class="mt-3">
          <a href="projects.php" class="btn btn-primary me-2"><i class="fas fa-briefcase me-2"></i>Vezi proiectele</a>
          <a href="contact.php" class="btn btn-outline-primary"><i class="fas fa-paper-plane me-2"></i>Contactează-mă</a>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title">Abilități</h5>
            <div class="d-flex flex-wrap gap-2">
              <span class="badge bg-secondary">PHP</span>
              <span class="badge bg-secondary">MySQL</span>
              <span class="badge bg-secondary">Bootstrap 5</span>
              <span class="badge bg-secondary">JavaScript</span>
              <span class="badge bg-secondary">REST APIs</span>
              <span class="badge bg-secondary">SEO</span>
              <span class="badge bg-secondary">Securitate</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title">Valori</h5>
            <ul class="mb-0">
              <li class="mb-2">Calitate și simplitate în implementare</li>
              <li class="mb-2">Transparență și feedback constant</li>
              <li class="mb-2">Învățare continuă și responsabilitate</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 bg-gradient text-white">
      <div class="card-body p-4 p-md-5 text-center">
        <h3 class="mb-3">Hai să lucrăm împreună</h3>
        <p class="lead mb-4">Spune-mi pe scurt despre proiectul tău, iar eu revin rapid cu idei și pașii următori.</p>
        <a href="request-quote.php" class="btn btn-light btn-lg"><i class="fas fa-paper-plane me-2"></i>Cere ofertă</a>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/foot.php'; ?>
