<?php
$page_title = 'Detalii proiect';
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/head.php';

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$project = null;

if ($slug && $pdo instanceof PDO) {
    try {
        $stmt = $pdo->prepare("SELECT id, slug, title, description, short_description, image, gallery, technologies, category, project_url, github_url, client_name, completion_date, duration_weeks, status FROM projects WHERE slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        $project = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        if (ini_get('display_errors')) {
            echo "<div class='container mt-4'><div class='alert alert-warning'>Eroare la citirea proiectului: " . htmlspecialchars($e->getMessage()) . "</div></div>";
        }
    }
}
?>

<div class="container py-5">
    <?php if (!$project): ?>
        <div class="alert alert-info">Proiectul nu a fost găsit.</div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <?php 
                $primary = !empty($project['image']) ? $project['image'] : 'assets/images/placeholders/wide-purple.svg';
                $gallery = [];
                if (!empty($project['gallery'])) {
                    $jg = json_decode($project['gallery'], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($jg)) {
                        $gallery = $jg;
                    }
                }
                // Build slides with primary first, unique
                $slides = array_values(array_unique(array_filter(array_merge([$primary], $gallery))));
                ?>
                <?php if (count($slides) > 1): ?>
                <div id="carouselProj" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-inner rounded shadow-sm">
                        <?php foreach ($slides as $i => $url): ?>
                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                            <img src="<?= htmlspecialchars($url) ?>" class="d-block w-100" style="max-height:460px;object-fit:cover;cursor: zoom-in;" alt="<?= htmlspecialchars($project['title']) ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProj" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProj" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <?php else: ?>
                <img src="<?= htmlspecialchars($primary) ?>" class="img-fluid rounded shadow-sm mb-3" style="cursor: zoom-in;" alt="<?= htmlspecialchars($project['title']) ?>">
                <?php endif; ?>
                <h1 class="h3 mb-3">
                    <?= htmlspecialchars($project['title']) ?>
                    <?php if (!empty($project['project_url'])): ?>
                        <span class="badge bg-success align-middle ms-2">LIVE</span>
                    <?php endif; ?>
                </h1>
                <p class="lead text-muted"><?= htmlspecialchars($project['short_description'] ?? '') ?></p>
                <div class="content">
                    <?= nl2br(htmlspecialchars($project['description'] ?? 'Descriere indisponibilă.')) ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Detalii</h5>
                        <?php 
                        $tech = [];
                        if (!empty($project['technologies'])) {
                            $decoded = json_decode($project['technologies'], true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                $tech = $decoded;
                            }
                        }
                        ?>
                        <?php if($tech): ?>
                        <div class="mb-3 d-flex flex-wrap gap-2">
                            <?php foreach ($tech as $t): ?>
                                <span class="badge bg-secondary"><?= htmlspecialchars($t) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($project['project_url'])): ?>
                        <a class="btn btn-primary w-100 mb-2" target="_blank" rel="noopener" href="<?= htmlspecialchars($project['project_url']) ?>">
                            <i class="fas fa-external-link-alt me-1"></i> Vezi Live
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($project['github_url'])): ?>
                        <a class="btn btn-outline-dark w-100" target="_blank" rel="noopener" href="<?= htmlspecialchars($project['github_url']) ?>">
                            <i class="fab fa-github me-1"></i> Cod sursă
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/foot.php'; ?>
<style>
.lightbox-overlay{position:fixed;inset:0;background:rgba(0,0,0,.95);display:none;align-items:center;justify-content:center;z-index:2000}
.lightbox-overlay.show{display:flex}
.lightbox-img{max-width:95vw;max-height:95vh;object-fit:contain;box-shadow:0 0 30px rgba(0,0,0,.6);border-radius:6px}
.lightbox-btn{position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.15);border:none;color:#fff;padding:10px 14px;border-radius:8px;cursor:pointer}
.lightbox-prev{left:20px}
.lightbox-next{right:20px}
.lightbox-close{top:20px;right:20px;transform:none}
</style>
<div id="lightbox" class="lightbox-overlay" role="dialog" aria-modal="true" aria-label="Galerie proiect">
    <button class="lightbox-btn lightbox-prev" aria-label="Imagine anterioară">&#10094;</button>
    <img id="lightboxImg" class="lightbox-img" alt="Imagine proiect">
    <button class="lightbox-btn lightbox-next" aria-label="Imagine următoare">&#10095;</button>
    <button class="lightbox-btn lightbox-close" aria-label="Închide">&#10006;</button>
</div>
<script>
(function(){
    const slides = <?= json_encode($slides ?? []) ?>;
    const lb = document.getElementById('lightbox');
    const img = document.getElementById('lightboxImg');
    const btnPrev = lb.querySelector('.lightbox-prev');
    const btnNext = lb.querySelector('.lightbox-next');
    const btnClose = lb.querySelector('.lightbox-close');
    let idx = 0;
    function show(i){ if(!slides.length) return; idx = (i+slides.length)%slides.length; img.src = slides[idx]; lb.classList.add('show'); }
    function hide(){ lb.classList.remove('show'); img.src=''; }
    btnPrev.addEventListener('click',()=>show(idx-1));
    btnNext.addEventListener('click',()=>show(idx+1));
    btnClose.addEventListener('click', hide);
    lb.addEventListener('click', e=>{ if(e.target===lb) hide(); });
    document.addEventListener('keydown', e=>{ if(!lb.classList.contains('show')) return; if(e.key==='Escape') hide(); if(e.key==='ArrowLeft') show(idx-1); if(e.key==='ArrowRight') show(idx+1); });

    // open on click images
    document.querySelectorAll('#carouselProj .carousel-item img').forEach((el,i)=>{
        el.addEventListener('click', ()=>show(i));
    });
    const single = document.querySelector('img[alt="<?= htmlspecialchars($project['title']) ?>"].img-fluid');
    if(single){ single.addEventListener('click', ()=>show(0)); }
})();
</script>
