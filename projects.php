<?php 
$page_title = "Proiecte";
$page_description = "Portofoliul meu de proiecte web - aplicații PHP, soluții personalizate și dezvoltare web modernă.";
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/head.php'; 
?>

<?php
// DB-driven list if `$projects` table exists; show warning in dev on failure
$projects = [];
try {
    if ($pdo instanceof PDO) {
        $stmt = $pdo->query("SELECT id, title, short_description AS short_desc, image, technologies AS tech, project_url AS url FROM projects WHERE is_published = 1 ORDER BY id DESC");
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Throwable $e) {
    if (ini_get('display_errors')) {
        echo "<div class='container mt-4'><div class='alert alert-warning'>Nu pot citi proiectele: " . htmlspecialchars($e->getMessage()) . "</div></div>";
    }
}
?>

<div class="py-4">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Portofoliul Meu</h1>
        <p class="lead text-muted">Iată câteva dintre proiectele pe care le-am realizat</p>
    </div>
    
    <!-- Project Categories Filter -->
    <div class="mb-4">
        <div class="d-flex justify-content-center flex-wrap gap-2">
            <button class="btn btn-outline-primary active" data-filter="all">Toate</button>
            <button class="btn btn-outline-primary" data-filter="web">Web Development</button>
            <button class="btn btn-outline-primary" data-filter="php">PHP Applications</button>
            <button class="btn btn-outline-primary" data-filter="database">Database</button>
            <button class="btn btn-outline-primary" data-filter="ecommerce">E-commerce</button>
        </div>
    </div>
    
    <div class="row g-4" id="projects-container">
        <?php if (!$projects): ?>
            <div class="col-12"><div class="alert alert-info">Momentan nu există proiecte publicate.</div></div>
        <?php else: ?>
            <?php foreach ($projects as $p): ?>
                <div class="col-lg-6 project-item" data-category="web php">
                    <div class="card h-100 project-card">
                        <div class="position-relative overflow-hidden">
                            <?php 
                            $img = !empty($p['image']) ? $p['image'] : 'https://placehold.co/600x300/0d47a1/ffffff?text=Project';
                            ?>
                            <img src="<?= htmlspecialchars($img) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['title']) ?>">
                            <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <?php if (!empty($p['url'])): ?>
                                        <a href="<?= htmlspecialchars($p['url']) ?>" target="_blank" rel="noopener" class="btn btn-primary me-2" title="Vezi Demo">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($p['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($p['short_desc'] ?: '') ?></p>
                            <?php if (!empty($p['tech'])): ?>
                                <div class="mb-3">
                                    <span class="badge bg-secondary"><?= htmlspecialchars(is_string($p['tech']) ? $p['tech'] : json_encode($p['tech'])) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Call to Action -->
    <div class="text-center mt-5 py-5">
        <div class="card border-0 bg-gradient text-white">
            <div class="card-body p-5">
                <h3 class="mb-3">Ai un proiect în minte?</h3>
                <p class="lead mb-4">Să lucrăm împreună pentru a-ți transforma ideile în realitate!</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="request-quote.php" class="btn btn-light btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Cere Ofertă
                    </a>
                    <a href="contact.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-comments me-2"></i>Să Discutăm
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</div>

<style>
.project-card {
    transition: all 0.3s ease;
    height: 100%;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 102, 204, 0.2);
}

.project-card .overlay {
    background: rgba(0, 0, 0, 0.8);
    opacity: 0;
    transition: all 0.3s ease;
}

.project-card:hover .overlay {
    opacity: 1;
}

.project-card img {
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.project-card:hover img {
    transform: scale(1.05);
}

.btn[data-filter] {
    transition: all 0.3s ease;
}

.btn[data-filter].active {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}

.project-item {
    transition: all 0.5s ease;
}

.project-item.fade-out {
    opacity: 0;
    transform: scale(0.8);
}
</style>

<script>
// Project filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    const projectItems = document.querySelectorAll('.project-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter projects
            projectItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category').includes(filter)) {
                    item.style.display = 'block';
                    item.classList.remove('fade-out');
                } else {
                    item.classList.add('fade-out');
                    setTimeout(() => {
                        if (item.classList.contains('fade-out')) {
                            item.style.display = 'none';
                        }
                    }, 300);
                }
            });
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/foot.php'; ?>