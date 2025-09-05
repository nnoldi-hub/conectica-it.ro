<?php
require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';
$auth = new AuthSystem(isset($pdo) ? $pdo : null);
$auth->requireAuth();

$title = $_GET['title'] ?? 'Titlu Articol';
$excerpt = $_GET['excerpt'] ?? 'Rezumat scurt al articolului...';
?>

<div class="content-header">
    <h1 class="content-title">Previzualizare Articol</h1>
    <p class="content-subtitle">Așa va arăta articolul publicat</p>
</div>

<div class="card" style="background: rgba(255,255,255,0.08); border-radius: 15px; padding: 20px;">
    <img src="../assets/images/placeholders/wide-purple.svg" alt="Cover" style="width:100%; height:260px; object-fit:cover; border-radius:12px; margin-bottom:15px;">
    <h2 style="margin:10px 0;"><?php echo htmlspecialchars($title); ?></h2>
    <p style="opacity:0.8;"><?php echo htmlspecialchars($excerpt); ?></p>
    <div style="margin-top:10px;">
        <span class="status-badge" style="padding:6px 10px; border-radius:12px; background: rgba(102,126,234,0.2); color:#fff;">Draft</span>
    </div>
</div>

<div style="margin-top:15px;">
    <a href="?page=blog" class="btn" style="padding:10px 18px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.3); border-radius:8px; color:#fff; font-weight:600; text-decoration:none;">Înapoi</a>
</div>
