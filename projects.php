<?php 
$page_title = "Proiecte";
$page_description = "Portofoliul meu de proiecte web - aplicații PHP, soluții personalizate și dezvoltare web modernă.";
require_once 'config/config.php';
require_once 'includes/head.php'; 
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
        
        <!-- Exemplu de proiect 1 - E-commerce -->
        <div class="col-lg-6 project-item" data-category="web php ecommerce">
            <div class="card h-100 project-card">
                <div class="position-relative overflow-hidden">
                    <img src="https://via.placeholder.com/600x300/1a237e/ffffff?text=E-commerce+Store" class="card-img-top" alt="E-commerce Store">
                    <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <a href="#" class="btn btn-primary me-2" title="Vezi Demo">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light" title="Vezi Codul">
                                <i class="fas fa-code"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Magazin Online Modern</h5>
                    <p class="card-text">Platformă e-commerce completă cu sistem de plăți, gestionare produse și panou de administrare.</p>
                    <div class="mb-3">
                        <span class="badge bg-primary me-1">PHP</span>
                        <span class="badge bg-success me-1">MySQL</span>
                        <span class="badge bg-info me-1">Bootstrap</span>
                        <span class="badge bg-warning">JavaScript</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Decembrie 2024
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>4 săptămâni
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Exemplu de proiect 2 - Web App -->
        <div class="col-lg-6 project-item" data-category="web php">
            <div class="card h-100 project-card">
                <div class="position-relative overflow-hidden">
                    <img src="https://via.placeholder.com/600x300/0d47a1/ffffff?text=Task+Manager" class="card-img-top" alt="Task Manager">
                    <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <a href="#" class="btn btn-primary me-2" title="Vezi Demo">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light" title="Vezi Codul">
                                <i class="fas fa-code"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Sistem de Management Task-uri</h5>
                    <p class="card-text">Aplicație web pentru gestionarea task-urilor cu sistem de utilizatori, notificări și rapoarte.</p>
                    <div class="mb-3">
                        <span class="badge bg-primary me-1">PHP</span>
                        <span class="badge bg-success me-1">MySQL</span>
                        <span class="badge bg-secondary me-1">AJAX</span>
                        <span class="badge bg-info">API REST</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Noiembrie 2024
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>3 săptămâni
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Exemplu de proiect 3 - CMS -->
        <div class="col-lg-6 project-item" data-category="web php database">
            <div class="card h-100 project-card">
                <div class="position-relative overflow-hidden">
                    <img src="https://via.placeholder.com/600x300/01579b/ffffff?text=CMS+Platform" class="card-img-top" alt="CMS Platform">
                    <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <a href="#" class="btn btn-primary me-2" title="Vezi Demo">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light" title="Vezi Codul">
                                <i class="fas fa-code"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Platformă CMS Personalizată</h5>
                    <p class="card-text">Sistem de management conținut cu editor drag & drop, SEO optimizat și multi-limbă.</p>
                    <div class="mb-3">
                        <span class="badge bg-primary me-1">PHP</span>
                        <span class="badge bg-success me-1">MySQL</span>
                        <span class="badge bg-warning me-1">jQuery</span>
                        <span class="badge bg-dark">SEO</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Octombrie 2024
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>6 săptămâni
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Exemplu de proiect 4 - Database -->
        <div class="col-lg-6 project-item" data-category="database php">
            <div class="card h-100 project-card">
                <div class="position-relative overflow-hidden">
                    <img src="https://via.placeholder.com/600x300/28a745/ffffff?text=Inventory+System" class="card-img-top" alt="Inventory System">
                    <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <a href="#" class="btn btn-primary me-2" title="Vezi Demo">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light" title="Vezi Codul">
                                <i class="fas fa-code"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Sistem de Inventariere</h5>
                    <p class="card-text">Aplicație complexă pentru gestionarea stocurilor cu rapoarte avansate și integrări externe.</p>
                    <div class="mb-3">
                        <span class="badge bg-primary me-1">PHP</span>
                        <span class="badge bg-success me-1">MySQL</span>
                        <span class="badge bg-info me-1">Chart.js</span>
                        <span class="badge bg-secondary">PDF Export</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Septembrie 2024
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>5 săptămâni
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
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

<?php include 'includes/foot.php'; ?>