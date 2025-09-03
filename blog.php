<?php 
$page_title = "Blog IT";
$page_description = "Blog cu articole despre dezvoltare web, PHP, MySQL, tehnologii moderne și tips & tricks pentru programatori.";
include 'config/config.php';
include 'includes/head.php'; 
?>

<div class="py-4">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Blog IT & Dezvoltare Web</h1>
        <p class="lead text-muted">Articole, tutoriale și insights din lumea dezvoltării web</p>
    </div>
    
    <!-- Featured Article -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-lg bg-gradient text-white featured-article">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="badge bg-warning text-dark mb-2">Articol recomandat</span>
                            <h2 class="card-title mb-3">Cum să construiești o aplicație web modernă cu PHP și MySQL</h2>
                            <p class="card-text mb-4">Un ghid complet pentru dezvoltarea unei aplicații web robuste, de la planificare până la deployment. Învață cele mai bune practici și tehnici moderne...</p>
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://via.placeholder.com/40x40/28a745/ffffff?text=N" class="rounded-circle me-2" alt="Author">
                                <div>
                                    <small class="text-white-50">Nyikora Noldi • 15 Dec 2024 • 8 min citire</small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-light">Citește articolul</a>
                        </div>
                        <div class="col-lg-4">
                            <img src="https://via.placeholder.com/400x250/1a237e/ffffff?text=PHP+MySQL+Guide" class="img-fluid rounded" alt="Featured Article">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Blog Categories -->
    <div class="mb-4">
        <div class="d-flex justify-content-center flex-wrap gap-2">
            <button class="btn btn-outline-primary active" data-category="all">Toate</button>
            <button class="btn btn-outline-primary" data-category="php">PHP</button>
            <button class="btn btn-outline-primary" data-category="mysql">MySQL</button>
            <button class="btn btn-outline-primary" data-category="javascript">JavaScript</button>
            <button class="btn btn-outline-primary" data-category="tutorials">Tutoriale</button>
            <button class="btn btn-outline-primary" data-category="tips">Tips & Tricks</button>
        </div>
    </div>
    
    <!-- Blog Articles Grid -->
    <div class="row g-4" id="articles-container">
        
        <!-- Article 1 -->
        <div class="col-lg-4 col-md-6 article-item" data-category="php tutorials">
            <article class="card h-100 border-0 shadow-sm">
                <img src="https://via.placeholder.com/400x200/0d47a1/ffffff?text=PHP+Security" class="card-img-top" alt="PHP Security">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary">PHP</span>
                        <small class="text-muted">10 Dec 2024</small>
                    </div>
                    <h5 class="card-title">
                        <a href="#" class="text-decoration-none">Securitatea în PHP: Cele mai importante vulnerabilități</a>
                    </h5>
                    <p class="card-text">Cum să protejezi aplicațiile PHP împotriva atacurilor comune: SQL injection, XSS, CSRF și multe altele...</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>6 min citire
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i>245 vizualizări
                        </small>
                    </div>
                </div>
            </article>
        </div>
        
        <!-- Article 2 -->
        <div class="col-lg-4 col-md-6 article-item" data-category="mysql tutorials">
            <article class="card h-100 border-0 shadow-sm">
                <img src="https://via.placeholder.com/400x200/28a745/ffffff?text=MySQL+Optimization" class="card-img-top" alt="MySQL Optimization">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-success">MySQL</span>
                        <small class="text-muted">5 Dec 2024</small>
                    </div>
                    <h5 class="card-title">
                        <a href="#" class="text-decoration-none">Optimizarea performanțelor în MySQL</a>
                    </h5>
                    <p class="card-text">Tehnici avansate pentru optimizarea query-urilor, indexare eficientă și configurarea serverului MySQL...</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>8 min citire
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i>189 vizualizări
                        </small>
                    </div>
                </div>
            </article>
        </div>
        
        <!-- Article 3 -->
        <div class="col-lg-4 col-md-6 article-item" data-category="javascript tips">
            <article class="card h-100 border-0 shadow-sm">
                <img src="https://via.placeholder.com/400x200/ffc107/000000?text=JavaScript+ES6" class="card-img-top" alt="JavaScript ES6">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-warning text-dark">JavaScript</span>
                        <small class="text-muted">1 Dec 2024</small>
                    </div>
                    <h5 class="card-title">
                        <a href="#" class="text-decoration-none">JavaScript ES6+: Funcționalități esențiale</a>
                    </h5>
                    <p class="card-text">Explorează funcționalitățile moderne ale JavaScript: arrow functions, destructuring, async/await și mult mai mult...</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>5 min citire
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i>312 vizualizări
                        </small>
                    </div>
                </div>
            </article>
        </div>
        
        <!-- Article 4 -->
        <div class="col-lg-4 col-md-6 article-item" data-category="tips tutorials">
            <article class="card h-100 border-0 shadow-sm">
                <img src="https://via.placeholder.com/400x200/17a2b8/ffffff?text=Git+Workflow" class="card-img-top" alt="Git Workflow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-info">Git</span>
                        <small class="text-muted">25 Nov 2024</small>
                    </div>
                    <h5 class="card-title">
                        <a href="#" class="text-decoration-none">Workflow Git pentru dezvoltatori</a>
                    </h5>
                    <p class="card-text">Un ghid practic pentru utilizarea Git în proiecte reale: branching strategies, merge vs rebase, și best practices...</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>7 min citire
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i>156 vizualizări
                        </small>
                    </div>
                </div>
            </article>
        </div>
        
        <!-- Article 5 -->
        <div class="col-lg-4 col-md-6 article-item" data-category="php tips">
            <article class="card h-100 border-0 shadow-sm">
                <img src="https://via.placeholder.com/400x200/6610f2/ffffff?text=PHP+8+Features" class="card-img-top" alt="PHP 8 Features">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary">PHP</span>
                        <small class="text-muted">20 Nov 2024</small>
                    </div>
                    <h5 class="card-title">
                        <a href="#" class="text-decoration-none">Noutățile din PHP 8: Ce trebuie să știi</a>
                    </h5>
                    <p class="card-text">Descoperă funcționalitățile noi din PHP 8: Union types, Match expressions, Constructor property promotion și multe altele...</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>9 min citire
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i>298 vizualizări
                        </small>
                    </div>
                </div>
            </article>
        </div>
        
        <!-- Article 6 -->
        <div class="col-lg-4 col-md-6 article-item" data-category="tutorials tips">
            <article class="card h-100 border-0 shadow-sm">
                <img src="https://via.placeholder.com/400x200/dc3545/ffffff?text=API+Development" class="card-img-top" alt="API Development">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-danger">API</span>
                        <small class="text-muted">15 Nov 2024</small>
                    </div>
                    <h5 class="card-title">
                        <a href="#" class="text-decoration-none">Cum să construiești un API REST în PHP</a>
                    </h5>
                    <p class="card-text">Ghid pas cu pas pentru crearea unui API REST robust: autentificare, validare, documentare și testare...</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>12 min citire
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i>427 vizualizări
                        </small>
                    </div>
                </div>
            </article>
        </div>
        
    </div>
    
    <!-- Load More -->
    <div class="text-center mt-5">
        <button class="btn btn-outline-primary btn-lg" id="loadMore">
            <i class="fas fa-plus me-2"></i>Încarcă mai multe articole
        </button>
    </div>
    
    <!-- Newsletter Subscription -->
    <div class="card border-0 bg-gradient text-white mt-5">
        <div class="card-body text-center p-5">
            <h3 class="mb-3">Rămâi la curent cu noutățile</h3>
            <p class="lead mb-4">Abonează-te la newsletter pentru a primi cele mai noi articole și tutoriale direct în email</p>
            <form class="row g-3 justify-content-center" action="#" method="POST">
                <div class="col-auto">
                    <input type="email" class="form-control form-control-lg" placeholder="Adresa ta de email" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-light btn-lg">
                        <i class="fas fa-envelope me-2"></i>Abonează-te
                    </button>
                </div>
            </form>
            <small class="text-white-50 mt-2 d-block">
                <i class="fas fa-shield-alt me-1"></i>
                Nu trimitem spam. Te poți dezabona oricând.
            </small>
        </div>
    </div>
    
</div>

<style>
.featured-article {
    background: linear-gradient(135deg, #1a237e 0%, #0d47a1 50%, #01579b 100%);
    position: relative;
    overflow: hidden;
}

.article-item {
    transition: all 0.3s ease;
}

.article-item .card {
    transition: all 0.3s ease;
}

.article-item:hover .card {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 102, 204, 0.2);
}

.article-item .card-img-top {
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.article-item:hover .card-img-top {
    transform: scale(1.05);
}

.article-item .card-title a {
    color: var(--text-light);
    transition: color 0.3s ease;
}

.article-item:hover .card-title a {
    color: var(--primary-color);
}

.btn[data-category] {
    transition: all 0.3s ease;
}

.btn[data-category].active {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}

.article-item.fade-out {
    opacity: 0;
    transform: scale(0.8);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category filtering
    const categoryButtons = document.querySelectorAll('[data-category]');
    const articleItems = document.querySelectorAll('.article-item');
    
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Update active button
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter articles
            articleItems.forEach(item => {
                if (category === 'all' || item.getAttribute('data-category').includes(category)) {
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
    
    // Load more functionality
    const loadMoreBtn = document.getElementById('loadMore');
    let currentlyVisible = 6;
    
    loadMoreBtn.addEventListener('click', function() {
        // Simulate loading more articles
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Se încarcă...';
        
        setTimeout(() => {
            // Here you would typically load more articles via AJAX
            this.innerHTML = '<i class="fas fa-plus me-2"></i>Încarcă mai multe articole';
            
            // For demo, hide button after clicking
            if (currentlyVisible >= 12) {
                this.style.display = 'none';
            }
            currentlyVisible += 6;
        }, 1000);
    });
    
    // Reading time calculation (simple estimation)
    document.querySelectorAll('.card-text').forEach(text => {
        const words = text.textContent.split(' ').length;
        const readingTime = Math.ceil(words / 200); // Average reading speed
        // This could be used to dynamically set reading times
    });
});
</script>

<?php require_once 'includes/foot.php'; ?>