<?php
// Common bootstrap and Auth system
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/AuthSystem.php';

// Create Auth with existing PDO if available
$auth = new AuthSystem(isset($pdo) ? $pdo : null);
$auth->requireAuth(); // Require authentication

$user = $auth->getCurrentUser();
$security_info = $auth->getSecurityInfo();
$admin_username = $user['username'] ?? 'Admin';

// Check for suspicious activity
if ($auth->checkSuspiciousActivity()) {
    error_log("Suspicious activity detected for user: " . $user['username']);
}

// Handle logout
if (isset($_POST['logout'])) {
    $auth->logout();
    header('Location: login.php');
    exit;
}

// Get current page from URL parameter
$current_page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Conectica IT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            color: white;
        }
        
        /* Header */
        .header {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px 0;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            font-size: 0.9rem;
            color: white;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .user-info > i {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            font-size: 16px;
        }
        
        .logout-btn {
            padding: 8px 15px;
            background: rgba(255, 69, 69, 0.2);
            border: 1px solid rgba(255, 69, 69, 0.5);
            border-radius: 6px;
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: rgba(255, 69, 69, 0.4);
        }
        
        /* Layout */
        .admin-layout {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 0;
            position: fixed;
            height: calc(100vh - 70px);
            overflow-y: auto;
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .menu-item {
            margin: 5px 0;
        }
        
        .menu-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .menu-link:hover,
        .menu-link.active {
            background: rgba(102, 126, 234, 0.2);
            border-left-color: #667eea;
            color: white;
        }
        
        .menu-icon {
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }
        
        .content-header {
            margin-bottom: 30px;
        }
        
        .content-title {
            font-size: 2.2rem;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .content-subtitle {
            opacity: 0.7;
            font-size: 1.1rem;
        }
        
        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        /* Cards */
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .card-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 10px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .card-description {
            opacity: 0.8;
            line-height: 1.5;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        /* Recent Activity */
        .recent-activity {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            background: rgba(102, 126, 234, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .activity-time {
            opacity: 0.6;
            font-size: 0.9rem;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 70px;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .menu-link span {
                display: none;
            }
            
            .menu-link {
                justify-content: center;
                padding: 15px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <h1><i class="fas fa-shield-alt"></i> Admin Panel</h1>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <?php 
                    // Debug avatar path
                    $avatar_path = $user['avatar'] ?? '';
                    $full_path = '../' . $avatar_path;
                    ?>
                    <?php if (!empty($avatar_path) && file_exists($full_path)): ?>
                        <img src="../<?php echo htmlspecialchars($avatar_path); ?>" 
                             alt="Avatar" class="user-avatar">
                    <?php else: ?>
                        <i class="fas fa-user"></i>
                    <?php endif; ?>
                    <span>Bună ziua, <strong><?php echo htmlspecialchars($user['name'] ?? $admin_username); ?></strong></span>
                    <?php if ($security_info): ?>
                    <div class="security-status" style="font-size: 11px; opacity: 0.8; margin-top: 2px;">
                        <i class="fas fa-shield-alt"></i>
                        IP: <?php echo htmlspecialchars($security_info['ip_address']); ?> • 
                        Sesiune: <?php echo gmdate('i\m s\s', max(0, $security_info['session_remaining'])); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="logout" class="logout-btn" style="background: none; border: none; color: inherit; cursor: pointer; padding: 10px 20px; border-radius: 8px; transition: all 0.3s ease;">
                        <i class="fas fa-sign-out-alt"></i> Deconectare
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <nav>
                <ul class="sidebar-menu">
                    <li class="menu-item">
                        <a href="?page=dashboard" class="menu-link <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=content" class="menu-link <?php echo ($current_page == 'content') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-edit"></i>
                            <span>Editare Site</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=projects" class="menu-link <?php echo ($current_page == 'projects') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-rocket"></i>
                            <span>Proiecte</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=blog" class="menu-link <?php echo ($current_page == 'blog') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-blog"></i>
                            <span>Blog</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=testimonials" class="menu-link <?php echo ($current_page == 'testimonials') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-quote-left"></i>
                            <span>Testimoniale</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=newsletter" class="menu-link <?php echo ($current_page == 'newsletter') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-paper-plane"></i>
                            <span>Newsletter</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=messages" class="menu-link <?php echo ($current_page == 'messages') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-envelope"></i>
                            <span>Mesaje</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=quotes" class="menu-link <?php echo ($current_page == 'quotes') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-file-invoice-dollar"></i>
                            <span>Cereri Ofertă</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=settings" class="menu-link <?php echo ($current_page == 'settings') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-cog"></i>
                            <span>Setări</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=profile" class="menu-link <?php echo ($current_page == 'profile') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-user-cog"></i>
                            <span>Profilul Meu</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=analytics" class="menu-link <?php echo ($current_page == 'analytics') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-chart-line"></i>
                            <span>Analiză</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="?page=seo-manager" class="menu-link <?php echo ($current_page == 'seo-manager') ? 'active' : ''; ?>">
                            <i class="menu-icon fas fa-search"></i>
                            <span>SEO Manager</span>
                        </a>
                    </li>
                    <li class="menu-item" style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                        <a href="../index.php" class="menu-link" target="_blank">
                            <i class="menu-icon fas fa-external-link-alt"></i>
                            <span>Vezi Site-ul</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <?php
            // Include different content based on page parameter
            switch($current_page) {
                case 'content':
                    include 'pages/content-editor.php';
                    break;
                case 'projects':
                    include 'pages/projects-manager.php';
                    break;
                case 'blog':
                    include 'pages/blog-manager.php';
                    break;
                case 'blog-editor':
                    include 'pages/blog-editor.php';
                    break;
                case 'blog-preview':
                    include 'pages/blog-preview.php';
                    break;
                case 'testimonials':
                    include 'pages/testimonials.php';
                    break;
                case 'newsletter':
                    include 'pages/newsletter.php';
                    break;
                case 'messages':
                    include 'pages/messages.php';
                    break;
                case 'quotes':
                    include 'pages/quotes.php';
                    break;
                case 'settings':
                    include 'pages/settings.php';
                    break;
                    
                case 'profile':
                    include 'pages/profile.php';
                    break;
                case 'analytics':
                    include 'pages/analytics.php';
                    break;
                    
                case 'seo-manager':
                    include 'pages/seo-manager.php';
                    break;
                default:
                    // Dashboard home content
                    ?>
                    <div class="content-header">
                        <h1 class="content-title">Dashboard Conectica IT</h1>
                        <p class="content-subtitle">Bun venit în panoul de administrare - Gestionează conținutul și monitorizează activitatea</p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="stats-grid">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Proiecte</h3>
                                    <div class="card-value">12</div>
                                </div>
                            </div>
                            <p class="card-description">Proiecte completate cu succes</p>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Mesaje</h3>
                                    <div class="card-value">3</div>
                                </div>
                            </div>
                            <p class="card-description">Mesaje noi de la clienți</p>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-blog"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Articole</h3>
                                    <div class="card-value">8</div>
                                </div>
                            </div>
                            <p class="card-description">Articole de blog publicate</p>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Cereri Ofertă</h3>
                                    <div class="card-value">5</div>
                                </div>
                            </div>
                            <p class="card-description">Cereri de ofertă în așteptare</p>
                        </div>
                    </div>

                    <!-- Dashboard Grid -->
                    <div class="dashboard-grid">
                        <!-- Quick Actions -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Acțiuni Rapide</h3>
                                </div>
                            </div>
                            <div class="card-description">
                                <p style="margin-bottom: 15px;"><a href="?page=projects" style="color: #667eea; text-decoration: none;"><i class="fas fa-plus"></i> Adaugă Proiect Nou</a></p>
                                <p style="margin-bottom: 15px;"><a href="?page=blog" style="color: #667eea; text-decoration: none;"><i class="fas fa-pen"></i> Scrie Articol Nou</a></p>
                                <p style="margin-bottom: 15px;"><a href="?page=content" style="color: #667eea; text-decoration: none;"><i class="fas fa-edit"></i> Editează Pagina Principală</a></p>
                                <p><a href="?page=messages" style="color: #667eea; text-decoration: none;"><i class="fas fa-envelope-open"></i> Citește Mesajele</a></p>
                            </div>
                        </div>

                        <!-- Recent Messages Summary -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Mesaje Recente</h3>
                                </div>
                            </div>
                            <div class="card-description">
                                <div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                    <strong>Ana Maria</strong> - Cerere dezvoltare site
                                    <br><small style="opacity: 0.7;">Acum 2 ore</small>
                                </div>
                                <div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                    <strong>Ionuț Popescu</strong> - Întrebare despre hosting
                                    <br><small style="opacity: 0.7;">Ieri</small>
                                </div>
                                <div>
                                    <strong>Maria Georgescu</strong> - Mulțumiri pentru proiect
                                    <br><small style="opacity: 0.7;">Acum 3 zile</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="recent-activity">
                        <h3 style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-history"></i> Activitate Recentă
                        </h3>
                        
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Proiect "E-commerce Modern" finalizat</div>
                                <div class="activity-time">Acum 1 oră</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Mesaj nou primit de la Ana Maria</div>
                                <div class="activity-time">Acum 2 ore</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-blog"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Articol "Trends în Web Development" publicat</div>
                                <div class="activity-time">Ieri</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Cerere de ofertă nouă primită</div>
                                <div class="activity-time">Acum 2 zile</div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
            }
            ?>
        </main>
    </div>

    <script>
        // Mobile menu toggle (if needed)
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }
        
        // Auto-refresh stats (optional)
        setInterval(function() {
            // Could implement real-time updates here
        }, 30000);
    </script>
</body>
</html>
