<?php 
$page_title = "Conectica IT - Dezvoltare Web & Soluții IT Profesionale | Nyikora Noldi";
$page_description = "Dezvoltator web freelancer cu experiență în PHP, MySQL, JavaScript. Creez aplicații web moderne, rapide și sigure pentru afaceri. Consultanță IT profesională în România.";
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

<!-- De ce să lucrezi cu mine - Benefits Section -->
<section class='py-5 bg-light'>
    <div class='container'>
        <div class='text-center mb-5'>
            <h2 class='mb-3'>De ce să alegi Conectica IT?</h2>
            <p class='lead text-muted'>Beneficiile de a lucra cu un dezvoltator web dedicat și experimentat</p>
        </div>
        
        <div class='row g-4'>
            <div class='col-lg-4'>
                <div class='card border-0 shadow-sm h-100 text-center'>
                    <div class='card-body p-4'>
                        <div class='bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center' style='width: 80px; height: 80px;'>
                            <i class='fas fa-rocket text-white fa-2x'></i>
                        </div>
                        <h5 class='card-title'>Livrare Rapidă</h5>
                        <p class='card-text text-muted'>Proiectele se finalizează la timp, fără compromisuri asupra calității. Proces de dezvoltare eficient și predictibil.</p>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4'>
                <div class='card border-0 shadow-sm h-100 text-center'>
                    <div class='card-body p-4'>
                        <div class='bg-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center' style='width: 80px; height: 80px;'>
                            <i class='fas fa-shield-alt text-white fa-2x'></i>
                        </div>
                        <h5 class='card-title'>Cod Sigur & Curat</h5>
                        <p class='card-text text-muted'>Securitate implementată din start. Cod documentat și organizat pentru ușurința în mentenanță viitoare.</p>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4'>
                <div class='card border-0 shadow-sm h-100 text-center'>
                    <div class='card-body p-4'>
                        <div class='bg-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center' style='width: 80px; height: 80px;'>
                            <i class='fas fa-comments text-white fa-2x'></i>
                        </div>
                        <h5 class='card-title'>Comunicare Clară</h5>
                        <p class='card-text text-muted'>Răspund în maxim 24h. Te țin la curent cu progresul și explic totul în termeni clari, fără jargon tehnic.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class='row g-4 mt-4'>
            <div class='col-lg-6'>
                <div class='card border-0 shadow-sm h-100'>
                    <div class='card-body p-4'>
                        <div class='d-flex align-items-center mb-3'>
                            <div class='bg-warning rounded-circle me-3 d-flex align-items-center justify-content-center' style='width: 60px; height: 60px;'>
                                <i class='fas fa-cogs text-white fa-lg'></i>
                            </div>
                            <div>
                                <h5 class='card-title mb-1'>Tehnologii Moderne</h5>
                                <p class='card-text text-muted mb-0'>Frameworks și tool-uri la zi</p>
                            </div>
                        </div>
                        <p class='card-text'>Folosesc PHP 8+, MySQL optimizat, Bootstrap 5, și cele mai bune practici din industrie pentru rezultate superioare.</p>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-6'>
                <div class='card border-0 shadow-sm h-100'>
                    <div class='card-body p-4'>
                        <div class='d-flex align-items-center mb-3'>
                            <div class='bg-danger rounded-circle me-3 d-flex align-items-center justify-content-center' style='width: 60px; height: 60px;'>
                                <i class='fas fa-headset text-white fa-lg'></i>
                            </div>
                            <div>
                                <h5 class='card-title mb-1'>Suport Continuu</h5>
                                <p class='card-text text-muted mb-0'>Relația nu se termină la launch</p>
                            </div>
                        </div>
                        <p class='card-text'>Oferă documentație completă și suport pentru mentenanță. Sunt aici pentru actualizări și îmbunătățiri viitoare.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Procesul în 3 pași -->
<section class='py-5'>
    <div class='container'>
        <div class='text-center mb-5'>
            <h2 class='mb-3'>Cum lucrăm împreună</h2>
            <p class='lead text-muted'>Proces simplu și transparent, de la idee la lansare</p>
        </div>
        
        <div class='row g-4'>
            <div class='col-lg-4'>
                <div class='text-center'>
                    <div class='position-relative mb-4'>
                        <div class='bg-primary rounded-circle mx-auto d-flex align-items-center justify-content-center' style='width: 100px; height: 100px;'>
                            <span class='text-white fw-bold' style='font-size: 2rem;'>1</span>
                        </div>
                        <div class='position-absolute top-50 start-100 translate-middle d-none d-lg-block' style='width: 80px; height: 2px; background: #e9ecef;'></div>
                    </div>
                    <h5 class='mb-3'>Discutăm & Planificăm</h5>
                    <p class='text-muted'>Analizez cerințele tale, propun soluții și stabilim bugetul. Îți explic totul pas cu pas.</p>
                    <div class='mt-3'>
                        <span class='badge bg-light text-dark me-1'>Consultanță gratuită</span>
                        <span class='badge bg-light text-dark'>Ofertă detaliată</span>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4'>
                <div class='text-center'>
                    <div class='position-relative mb-4'>
                        <div class='bg-success rounded-circle mx-auto d-flex align-items-center justify-content-center' style='width: 100px; height: 100px;'>
                            <span class='text-white fw-bold' style='font-size: 2rem;'>2</span>
                        </div>
                        <div class='position-absolute top-50 start-100 translate-middle d-none d-lg-block' style='width: 80px; height: 2px; background: #e9ecef;'></div>
                    </div>
                    <h5 class='mb-3'>Dezvoltăm & Testăm</h5>
                    <p class='text-muted'>Creez aplicația pas cu pas. Primești actualizări regulate și poți testa funcționalitățile.</p>
                    <div class='mt-3'>
                        <span class='badge bg-light text-dark me-1'>Update-uri săptămânale</span>
                        <span class='badge bg-light text-dark'>Preview live</span>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4'>
                <div class='text-center'>
                    <div class='mb-4'>
                        <div class='bg-info rounded-circle mx-auto d-flex align-items-center justify-content-center' style='width: 100px; height: 100px;'>
                            <span class='text-white fw-bold' style='font-size: 2rem;'>3</span>
                        </div>
                    </div>
                    <h5 class='mb-3'>Lansăm & Susținem</h5>
                    <p class='text-muted'>Deploy pe server, training pentru utilizare și documentație completă. Rămân disponibil pentru suport.</p>
                    <div class='mt-3'>
                        <span class='badge bg-light text-dark me-1'>Go-live assistance</span>
                        <span class='badge bg-light text-dark'>Documentație</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class='text-center mt-5'>
            <h4 class='mb-3'>Pregătit să îți transformi ideea în realitate?</h4>
            <div class='d-grid gap-2 d-md-flex justify-content-md-center'>
                <a href='request-quote.php' class='btn btn-primary btn-lg me-2'>
                    <i class='fas fa-calculator me-2'></i>Cere Ofertă Gratuită
                </a>
                <a href='contact.php' class='btn btn-outline-primary btn-lg'>
                    <i class='fas fa-calendar-alt me-2'></i>Programează un apel
                </a>
            </div>
            <p class='text-muted mt-3'>
                <i class='fas fa-clock me-1'></i>Răspund în maxim 24h • 
                <i class='fas fa-phone me-1'></i>Consultanță inițială gratuită
            </p>
        </div>
    </div>
</section>

<section class='py-5 bg-light'>
    <div class='container'>
        <h2 class='text-center mb-5'>Testimoniale</h2>
        
        <?php
        // Get approved testimonials, prioritizing featured ones
        try {
            $testimonials_query = "SELECT * FROM testimonials 
                                 WHERE status = 'approved' 
                                 ORDER BY featured DESC, rating DESC, created_at DESC 
                                 LIMIT 6";
            $testimonials = $pdo->query($testimonials_query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $testimonials = [];
        }
        ?>
        
        <?php if (!empty($testimonials)): ?>
        <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($testimonials as $index => $testimonial): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class='row justify-content-center'>
                        <div class='col-md-8 col-lg-6'>
                            <div class='card border-0 shadow-sm h-100'>
                                <div class='card-body d-flex flex-column'>
                                    <?php if ($testimonial['featured']): ?>
                                        <div class="featured-badge mb-3">
                                            <i class="fas fa-star text-warning"></i>
                                            <span class="badge bg-warning text-dark">Recomandat</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="rating mb-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?php echo $i <= $testimonial['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    
                                    <p class="flex-grow-1">"<?php echo htmlspecialchars($testimonial['testimonial']); ?>"</p>
                                    
                                    <?php if ($testimonial['project_details']): ?>
                                        <div class="project-info mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-project-diagram"></i>
                                                Proiect: <?php echo htmlspecialchars($testimonial['project_details']); ?>
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class='d-flex align-items-center mt-auto'>
                                        <div class='bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center' 
                                             style='width:40px;height:40px; min-width:40px;'>
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <strong><?php echo htmlspecialchars($testimonial['client_name']); ?></strong>
                                            <?php if ($testimonial['client_position'] || $testimonial['client_company']): ?>
                                                <div class='text-muted small'>
                                                    <?php if ($testimonial['client_position']): ?>
                                                        <?php echo htmlspecialchars($testimonial['client_position']); ?>
                                                    <?php endif; ?>
                                                    <?php if ($testimonial['client_company']): ?>
                                                        <?php echo $testimonial['client_position'] ? ', ' : ''; ?>
                                                        <?php echo htmlspecialchars($testimonial['client_company']); ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (count($testimonials) > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Următor</span>
            </button>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="add-testimonial.php" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i> Adaugă testimonialul tău
            </a>
        </div>
        
        <?php else: ?>
        <!-- Fallback testimonials if none in database -->
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
        
        <div class="text-center mt-4">
            <a href="add-testimonial.php" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i> Fii primul care adaugă un testimonial
            </a>
        </div>
        <?php endif; ?>
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
                        <img src='<?= htmlspecialchars($item['cover_image'] ?: 'assets/images/placeholders/wide-purple.svg') ?>' class='card-img-top' alt='<?= htmlspecialchars($item['title']) ?>' loading='lazy'>
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
                        <img src='assets/images/placeholders/wide-green.svg' class='card-img-top' alt='AI' loading='lazy'>
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
                        <img src='assets/images/placeholders/wide-purple.svg' class='card-img-top' alt='DevOps' loading='lazy'>
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
                        <img src='assets/images/placeholders/wide-orange.svg' class='card-img-top' alt='Security' loading='lazy'>
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