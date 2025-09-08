<?php 
$page_title = "Acasă";
$page_description = "Freelancer IT - Nyikora Noldi. Servicii profesionale de dezvoltare web, aplicații PHP, MySQL, și soluții IT personalizate pentru afaceri moderne.";
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/head.php'; 
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

<section class='py-5'>
    <div class='container'>
        <div class='row align-items-center g-4'>
            <div class='col-lg-5'>
                <img src='assets/images/placeholders/nnoldi.png' loading='lazy' class='img-fluid rounded shadow-sm' alt='Nyikora Noldi'>
            </div>
            <div class='col-lg-7'>
                <h2 class='mb-3'>Despre mine</h2>
                <p class='lead text-muted'>Sunt Nyikora Noldi, dezvoltator web freelancer. Îmi place să creez soluții simple, eficiente și scalabile care rezolvă probleme reale pentru afaceri.</p>
                <ul class='list-unstyled mb-4'>
                    <li class='mb-2'><i class='fas fa-check text-primary me-2'></i> Peste 5 ani experiență în PHP și MySQL</li>
                    <li class='mb-2'><i class='fas fa-check text-primary me-2'></i> Focus pe performanță, securitate și UX</li>
                    <li class='mb-2'><i class='fas fa-check text-primary me-2'></i> Colaborare transparentă și livrări predictibile</li>
                </ul>
                <a href='contact.php' class='btn btn-primary me-2'>Hai să discutăm</a>
                <a href='projects.php' class='btn btn-outline-primary'>Vezi proiecte</a>
            </div>
        </div>
    </div>
</section>

<section class='py-5 bg-light'>
    <div class='container'>
        <h2 class='text-center mb-5'>Testimoniale</h2>
        <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class='row justify-content-center'>
                        <div class='col-md-8 col-lg-6'>
                            <div class='card border-0 shadow-sm'>
                                <div class='card-body'>
                                    <p>„Implementarea a fost rapidă și fără bătăi de cap. Recomand!”</p>
                                    <div class='d-flex align-items-center mt-3'>
                                        <div class='bg-primary rounded-circle me-3' style='width:40px;height:40px;'></div>
                                        <div>
                                            <strong>Andrei Pop</strong>
                                            <div class='text-muted small'>Manager, Axy</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class='row justify-content-center'>
                        <div class='col-md-8 col-lg-6'>
                            <div class='card border-0 shadow-sm'>
                                <div class='card-body'>
                                    <p>„Profesionalism și comunicare excelentă. Rezultate peste așteptări.”</p>
                                    <div class='d-flex align-items-center mt-3'>
                                        <div class='bg-success rounded-circle me-3' style='width:40px;height:40px;'></div>
                                        <div>
                                            <strong>Roxana I.</strong>
                                            <div class='text-muted small'>Fondator, R-Tex</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class='row justify-content-center'>
                        <div class='col-md-8 col-lg-6'>
                            <div class='card border-0 shadow-sm'>
                                <div class='card-body'>
                                    <p>„Abordare pragmatică și focus pe business. Vom colabora din nou.”</p>
                                    <div class='d-flex align-items-center mt-3'>
                                        <div class='bg-info rounded-circle me-3' style='width:40px;height:40px;'></div>
                                        <div>
                                            <strong>Marius C.</strong>
                                            <div class='text-muted small'>CTO, Nexa</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Următor</span>
            </button>
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

<section class='py-5'>
    <div class='container'>
        <div class='d-flex justify-content-between align-items-center mb-4'>
            <h2 class='mb-0'>Tech Insights</h2>
            <a class='btn btn-outline-primary' href='blog.php'>Toate articolele</a>
        </div>
        
        <?php
        // Get blog articles (same logic as blog.php)
        $blog_items = [];
        $blogTableExists = false;
        try {
            if ($pdo instanceof PDO) {
                $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
                $blogTableExists = $stmt && $stmt->fetchColumn();
            }
            if ($blogTableExists) {
                $cc = $pdo->query("SHOW COLUMNS FROM `blog_posts`")->fetchAll(PDO::FETCH_ASSOC);
                $names = array_map(function($r){ return $r['Field'] ?? $r[0]; }, $cc);
                $has = function($n) use ($names){ return in_array($n, $names, true); };
                $legacy = $has('content') && $has('featured_image') && $has('reading_time') && $has('is_published');
                if ($legacy) {
                    $sql = "SELECT id,title,slug,excerpt,featured_image as cover_image,category,reading_time as read_minutes,views,COALESCE(published_at, created_at) as dt FROM blog_posts WHERE is_published=1 ORDER BY featured DESC, dt DESC LIMIT 3";
                } else {
                    $sql = "SELECT id,title,slug,excerpt,cover_image,category,read_minutes,views,COALESCE(published_at, created_at) as dt FROM blog_posts WHERE status='published' ORDER BY featured DESC, dt DESC LIMIT 3";
                }
                $stmt = $pdo->query($sql);
                $blog_items = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
            }
        } catch (Throwable $e) { $blog_items = []; }
        ?>
        
        <div class='row g-4'>
            <?php if ($blogTableExists && $blog_items): ?>
                <?php foreach ($blog_items as $item): ?>
                <div class='col-md-4'>
                    <div class='card h-100 border-0 shadow-sm'>
                        <img src='<?= htmlspecialchars($item['cover_image'] ?: 'assets/images/placeholders/wide-purple.svg') ?>' class='card-img-top' alt='<?= htmlspecialchars($item['title']) ?>'>
                        <div class='card-body'>
                            <span class='badge bg-primary mb-2'><?= htmlspecialchars($item['category'] ?: 'Tech') ?></span>
                            <h5 class='card-title'><?= htmlspecialchars($item['title']) ?></h5>
                            <p class='card-text text-muted'><?= htmlspecialchars($item['excerpt']) ?></p>
                            <a href='article.php?slug=<?= urlencode($item['slug']) ?>' class='btn btn-sm btn-primary'>Citește ▶</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback static content when no DB articles -->
                <div class='col-md-4'>
                    <div class='card h-100 border-0 shadow-sm'>
                        <img src='assets/images/placeholders/wide-green.svg' class='card-img-top' alt='AI'>
                        <div class='card-body'>
                            <span class='badge bg-primary mb-2'>AI</span>
                            <h5 class='card-title'>AI practic pentru proiecte mici</h5>
                            <p class='card-text text-muted'>Cum integrezi AI în aplicații PHP fără infrastructură complexă.</p>
                            <a href='blog.php' class='btn btn-sm btn-primary'>Citește ▶</a>
                        </div>
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class='card h-100 border-0 shadow-sm'>
                        <img src='assets/images/placeholders/wide-purple.svg' class='card-img-top' alt='DevOps'>
                        <div class='card-body'>
                            <span class='badge bg-dark mb-2'>DevOps</span>
                            <h5 class='card-title'>Automatizări simple cu GitHub + cPanel</h5>
                            <p class='card-text text-muted'>Workflow minim pentru deploy rapid și sigur pe shared hosting.</p>
                            <a href='blog.php' class='btn btn-sm btn-primary'>Citește ▶</a>
                        </div>
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class='card h-100 border-0 shadow-sm'>
                        <img src='assets/images/placeholders/wide-orange.svg' class='card-img-top' alt='Security'>
                        <div class='card-body'>
                            <span class='badge bg-danger mb-2'>Security</span>
                            <h5 class='card-title'>Securitate esențială pentru formulare</h5>
                            <p class='card-text text-muted'>CSRF, rate limiting și validare input — ce să nu lipsească.</p>
                            <a href='blog.php' class='btn btn-sm btn-primary'>Citește ▶</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <style>
        .card .badge { letter-spacing: .3px; }
    </style>
</section>

<?php require_once __DIR__ . '/includes/foot.php'; ?>