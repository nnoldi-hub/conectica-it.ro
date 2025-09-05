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
                            <img src="<?= htmlspecialchars($url) ?>" class="d-block w-100" style="max-height:460px;object-fit:cover;" alt="<?= htmlspecialchars($project['title']) ?>">
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
                <img src="<?= htmlspecialchars($primary) ?>" class="img-fluid rounded shadow-sm mb-3" alt="<?= htmlspecialchars($project['title']) ?>">
                <?php endif; ?>
                <h1 class="h3 mb-3"><?= htmlspecialchars($project['title']) ?></h1>
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
