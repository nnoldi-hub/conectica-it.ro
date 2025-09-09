<?php
require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

// Auth with bootstrap-provided PDO
$auth = new AuthSystem(isset($pdo) ? $pdo : null);
$auth->requireAuth();

$success_message = '';
$error_message = '';

// Handle actions
if ($_POST) {
    if (!$auth->validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error_message = 'Token de securitate invalid!';
    } else {
        $action = $_POST['action'] ?? '';
        $testimonial_id = intval($_POST['testimonial_id'] ?? 0);
        
        if ($action === 'approve' && $testimonial_id) {
            try {
                $admin_id = 1; // Get from session in real implementation
                $stmt = $pdo->prepare("UPDATE testimonials SET status = 'approved', approved_at = NOW(), approved_by = ? WHERE id = ?");
                if ($stmt->execute([$admin_id, $testimonial_id])) {
                    $success_message = 'Testimonialul a fost aprobat și publicat!';
                } else {
                    $error_message = 'Eroare la aprobarea testimonialului!';
                }
            } catch (PDOException $e) {
                $error_message = 'Eroare la baza de date: ' . $e->getMessage();
            }
        } elseif ($action === 'reject' && $testimonial_id) {
            try {
                $admin_id = 1;
                $stmt = $pdo->prepare("UPDATE testimonials SET status = 'rejected', approved_at = NOW(), approved_by = ? WHERE id = ?");
                if ($stmt->execute([$admin_id, $testimonial_id])) {
                    $success_message = 'Testimonialul a fost respins!';
                } else {
                    $error_message = 'Eroare la respingerea testimonialului!';
                }
            } catch (PDOException $e) {
                $error_message = 'Eroare la baza de date: ' . $e->getMessage();
            }
        } elseif ($action === 'delete' && $testimonial_id) {
            try {
                $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
                if ($stmt->execute([$testimonial_id])) {
                    $success_message = 'Testimonialul a fost șters definitiv!';
                } else {
                    $error_message = 'Eroare la ștergerea testimonialului!';
                }
            } catch (PDOException $e) {
                $error_message = 'Eroare la baza de date: ' . $e->getMessage();
            }
        } elseif ($action === 'toggle_featured' && $testimonial_id) {
            try {
                $stmt = $pdo->prepare("UPDATE testimonials SET featured = NOT featured WHERE id = ?");
                if ($stmt->execute([$testimonial_id])) {
                    $success_message = 'Statutul featured a fost actualizat!';
                } else {
                    $error_message = 'Eroare la actualizarea statutului!';
                }
            } catch (PDOException $e) {
                $error_message = 'Eroare la baza de date: ' . $e->getMessage();
            }
        }
    }
}

// Get statistics
try {
    $stats_query = "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
        SUM(CASE WHEN featured = 1 AND status = 'approved' THEN 1 ELSE 0 END) as featured,
        AVG(CASE WHEN status = 'approved' THEN rating ELSE NULL END) as avg_rating
    FROM testimonials";
    
    $stats = $pdo->query($stats_query)->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $stats = ['total' => 0, 'pending' => 0, 'approved' => 0, 'rejected' => 0, 'featured' => 0, 'avg_rating' => 0];
}

// Get testimonials with pagination
$page = intval($_GET['page'] ?? 1);
$per_page = 10;
$offset = ($page - 1) * $per_page;

$filter = $_GET['filter'] ?? 'all';
$search = trim($_GET['search'] ?? '');

$where_conditions = [];
$params = [];

if ($filter !== 'all') {
    $where_conditions[] = "status = ?";
    $params[] = $filter;
}

if ($search) {
    $where_conditions[] = "(client_name LIKE ? OR client_company LIKE ? OR testimonial LIKE ?)";
    $search_param = '%' . $search . '%';
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
}

$where_clause = $where_conditions ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

try {
    // Get total count
    $count_query = "SELECT COUNT(*) FROM testimonials $where_clause";
    $stmt = $pdo->prepare($count_query);
    $stmt->execute($params);
    $total_testimonials = $stmt->fetchColumn();
    
    // Get testimonials
    $query = "SELECT * FROM testimonials $where_clause ORDER BY created_at DESC LIMIT $per_page OFFSET $offset";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $total_pages = ceil($total_testimonials / $per_page);
} catch (PDOException $e) {
    $testimonials = [];
    $total_testimonials = 0;
    $total_pages = 0;
}

$csrf_token = $auth->generateCSRFToken();
?>

<div class="testimonials-management">
    <div class="page-header">
        <h2><i class="fas fa-quote-left"></i> Management Testimoniale</h2>
        <p>Gestionează testimonialele clienților și aprobă cele noi</p>
    </div>

    <?php if ($success_message): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php echo htmlspecialchars($success_message); ?>
    </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <?php echo htmlspecialchars($error_message); ?>
    </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="fas fa-quote-left"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['total']; ?></h3>
                <p>Total Testimoniale</p>
            </div>
        </div>
        
        <div class="stat-card pending">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['pending']; ?></h3>
                <p>În Așteptare</p>
            </div>
        </div>
        
        <div class="stat-card approved">
            <div class="stat-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['approved']; ?></h3>
                <p>Aprobate</p>
            </div>
        </div>
        
        <div class="stat-card featured">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['featured']; ?></h3>
                <p>Recomandate</p>
            </div>
        </div>
        
        <div class="stat-card rating">
            <div class="stat-icon">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['avg_rating'], 1); ?></h3>
                <p>Rating Mediu</p>
            </div>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="actions-bar">
        <div class="search-section">
            <form method="GET" class="search-form">
                <div class="form-group">
                    <input type="text" name="search" placeholder="Caută testimoniale..." 
                           value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                </div>
                <div class="form-group">
                    <select name="filter" class="form-select">
                        <option value="all" <?php echo $filter === 'all' ? 'selected' : ''; ?>>Toate</option>
                        <option value="pending" <?php echo $filter === 'pending' ? 'selected' : ''; ?>>În Așteptare</option>
                        <option value="approved" <?php echo $filter === 'approved' ? 'selected' : ''; ?>>Aprobate</option>
                        <option value="rejected" <?php echo $filter === 'rejected' ? 'selected' : ''; ?>>Respinse</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Caută
                </button>
            </form>
        </div>
        
        <div class="action-buttons">
            <a href="../../add-testimonial.php" target="_blank" class="btn btn-success">
                <i class="fas fa-plus"></i> Link Public pentru Clienți
            </a>
        </div>
    </div>

    <!-- Testimonials List -->
    <div class="testimonials-list">
        <?php if (empty($testimonials)): ?>
        <div class="empty-state">
            <i class="fas fa-quote-left"></i>
            <h3>Nu sunt testimoniale</h3>
            <p>Nu s-au găsit testimoniale pentru criteriile selectate.</p>
            <a href="../../add-testimonial.php" target="_blank" class="btn btn-primary">
                <i class="fas fa-plus"></i> Adaugă primul testimonial
            </a>
        </div>
        <?php else: ?>
        <?php foreach ($testimonials as $testimonial): ?>
        <div class="testimonial-card">
            <div class="testimonial-header">
                <div class="client-info">
                    <h4><?php echo htmlspecialchars($testimonial['client_name']); ?></h4>
                    <p class="client-details">
                        <?php if ($testimonial['client_position']): ?>
                            <span><?php echo htmlspecialchars($testimonial['client_position']); ?></span>
                        <?php endif; ?>
                        <?php if ($testimonial['client_company']): ?>
                            <span> la <?php echo htmlspecialchars($testimonial['client_company']); ?></span>
                        <?php endif; ?>
                    </p>
                    <?php if ($testimonial['client_email']): ?>
                        <p class="client-email">
                            <i class="fas fa-envelope"></i>
                            <?php echo htmlspecialchars($testimonial['client_email']); ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <div class="testimonial-meta">
                    <div class="status-badge status-<?php echo $testimonial['status']; ?>">
                        <?php 
                        $status_labels = [
                            'pending' => 'În Așteptare',
                            'approved' => 'Aprobat',
                            'rejected' => 'Respins'
                        ];
                        echo $status_labels[$testimonial['status']] ?? $testimonial['status'];
                        ?>
                    </div>
                    
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?php echo $i <= $testimonial['rating'] ? 'active' : ''; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    
                    <?php if ($testimonial['featured']): ?>
                        <div class="featured-badge">
                            <i class="fas fa-star"></i> Recomandat
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="testimonial-content">
                <p>"<?php echo htmlspecialchars($testimonial['testimonial']); ?>"</p>
                
                <?php if ($testimonial['project_details']): ?>
                    <div class="project-details">
                        <strong>Proiect:</strong> <?php echo htmlspecialchars($testimonial['project_details']); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="testimonial-footer">
                <div class="dates">
                    <span class="date">
                        <i class="fas fa-calendar"></i>
                        Trimis: <?php echo date('d.m.Y H:i', strtotime($testimonial['created_at'])); ?>
                    </span>
                    <?php if ($testimonial['approved_at']): ?>
                        <span class="date">
                            <i class="fas fa-check-circle"></i>
                            Procesat: <?php echo date('d.m.Y H:i', strtotime($testimonial['approved_at'])); ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <div class="actions">
                    <?php if ($testimonial['status'] === 'pending'): ?>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                            <input type="hidden" name="action" value="approve">
                            <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-check"></i> Aprobă
                            </button>
                        </form>
                        
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                            <input type="hidden" name="action" value="reject">
                            <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-warning">
                                <i class="fas fa-times"></i> Respinge
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <?php if ($testimonial['status'] === 'approved'): ?>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                            <input type="hidden" name="action" value="toggle_featured">
                            <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                            <button type="submit" class="btn btn-sm <?php echo $testimonial['featured'] ? 'btn-warning' : 'btn-info'; ?>">
                                <i class="fas fa-star"></i>
                                <?php echo $testimonial['featured'] ? 'Dezactivează' : 'Activează'; ?> Recomandat
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <form method="POST" style="display: inline;" onsubmit="return confirm('Ești sigur că vrei să ștergi acest testimonial?');">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Șterge
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>&filter=<?php echo urlencode($filter); ?>&search=<?php echo urlencode($search); ?>" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-chevron-left"></i> Anterior
            </a>
        <?php endif; ?>
        
        <span class="page-info">
            Pagina <?php echo $page; ?> din <?php echo $total_pages; ?> 
            (<?php echo $total_testimonials; ?> testimoniale)
        </span>
        
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>&filter=<?php echo urlencode($filter); ?>&search=<?php echo urlencode($search); ?>" class="btn btn-sm btn-outline-primary">
                Următor <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<style>
.testimonials-management {
    padding: 0;
}

.page-header {
    margin-bottom: 30px;
    text-align: center;
}

.page-header h2 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 2.2rem;
}

.page-header p {
    color: #7f8c8d;
    font-size: 1.1rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-left: 4px solid;
}

.stat-card.total { border-left-color: #3498db; }
.stat-card.pending { border-left-color: #f39c12; }
.stat-card.approved { border-left-color: #27ae60; }
.stat-card.featured { border-left-color: #e74c3c; }
.stat-card.rating { border-left-color: #9b59b6; }

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-card.total .stat-icon { background: #3498db; }
.stat-card.pending .stat-icon { background: #f39c12; }
.stat-card.approved .stat-icon { background: #27ae60; }
.stat-card.featured .stat-icon { background: #e74c3c; }
.stat-card.rating .stat-icon { background: #9b59b6; }

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.stat-content p {
    color: #7f8c8d;
    margin: 0;
    font-weight: 500;
}

.actions-bar {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.search-form {
    display: flex;
    gap: 15px;
    align-items: center;
}

.search-form .form-group {
    margin: 0;
}

.search-form .form-control,
.search-form .form-select {
    border: 2px solid rgba(52, 152, 219, 0.2);
    border-radius: 8px;
    padding: 8px 12px;
}

.testimonials-list {
    display: grid;
    gap: 20px;
}

.testimonial-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.testimonial-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px 20px 0;
}

.client-info h4 {
    color: #2c3e50;
    margin: 0 0 5px 0;
    font-size: 1.2rem;
}

.client-details {
    color: #7f8c8d;
    margin: 0 0 5px 0;
}

.client-email {
    color: #3498db;
    margin: 0;
    font-size: 0.9rem;
}

.testimonial-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: rgba(243, 156, 18, 0.1);
    color: #f39c12;
}

.status-approved {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
}

.status-rejected {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
}

.rating .star {
    color: #ddd;
    font-size: 1.2rem;
}

.rating .star.active {
    color: #f39c12;
}

.featured-badge {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.testimonial-content {
    padding: 20px;
}

.testimonial-content p {
    font-style: italic;
    color: #2c3e50;
    margin-bottom: 15px;
    line-height: 1.6;
}

.project-details {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-top: 10px;
}

.testimonial-footer {
    padding: 0 20px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.dates {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.date {
    color: #7f8c8d;
    font-size: 0.9rem;
}

.actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn {
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.9rem;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 0.8rem;
}

.btn-primary {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #27ae60, #2ecc71);
    color: white;
}

.btn-warning {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
}

.btn-info {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.btn-outline-primary {
    background: transparent;
    color: #3498db;
    border: 2px solid #3498db;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #7f8c8d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    margin-bottom: 10px;
    color: #2c3e50;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-top: 30px;
}

.page-info {
    color: #7f8c8d;
    font-weight: 500;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
}

.alert-success {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
    border: 1px solid rgba(39, 174, 96, 0.3);
}

.alert-danger {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-form {
        flex-direction: column;
        gap: 10px;
    }
    
    .testimonial-header {
        flex-direction: column;
        gap: 15px;
    }
    
    .testimonial-meta {
        align-items: flex-start;
    }
    
    .testimonial-footer {
        flex-direction: column;
        align-items: stretch;
    }
    
    .actions {
        justify-content: center;
    }
}
</style>

<script>
// Auto-refresh for pending testimonials
if (<?php echo $stats['pending']; ?> > 0) {
    setTimeout(() => {
        const url = new URL(window.location);
        if (url.searchParams.get('filter') === 'pending' || url.searchParams.get('filter') === 'all' || !url.searchParams.get('filter')) {
            location.reload();
        }
    }, 30000); // Refresh every 30 seconds if there are pending testimonials
}

// Confirm delete actions
document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('Ești sigur că vrei să ștergi acest testimonial? Această acțiune nu poate fi anulată!')) {
            e.preventDefault();
        }
    });
});
</script>
