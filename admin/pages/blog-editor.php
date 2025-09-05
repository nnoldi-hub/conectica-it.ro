<?php
require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';
$auth = new AuthSystem(isset($pdo) ? $pdo : null);
$auth->requireAuth();

$title = '';
$excerpt = '';
$content = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $message = 'Titlul și conținutul sunt obligatorii.';
    } else {
        // In this simple version, just show a success message; DB save can be added later
        $message = 'Articol salvat local (demo). Integrarea cu DB se poate adăuga ulterior.';
    }
}
?>

<div class="content-header">
    <h1 class="content-title">Editor Articol</h1>
    <p class="content-subtitle">Scrie conținut și previzualizează înainte de publicare</p>
</div>

<?php if ($message): ?>
<div class="seo-alert seo-alert-success" style="margin-bottom:20px;">
    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($message); ?>
</div>
<?php endif; ?>

<form method="POST" style="display:grid; gap:15px;">
    <div>
        <label style="display:block; margin-bottom:6px; color:#fff; font-weight:600;">Titlu</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" 
               style="width:100%; padding:12px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.3); border-radius:8px; color:#fff;" required>
    </div>
    <div>
        <label style="display:block; margin-bottom:6px; color:#fff; font-weight:600;">Rezumat</label>
        <textarea name="excerpt" rows="3" style="width:100%; padding:12px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.3); border-radius:8px; color:#fff;"><?php echo htmlspecialchars($excerpt); ?></textarea>
    </div>
    <div>
        <label style="display:block; margin-bottom:6px; color:#fff; font-weight:600;">Conținut</label>
        <textarea name="content" rows="12" style="width:100%; padding:12px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.3); border-radius:8px; color:#fff;" required><?php echo htmlspecialchars($content); ?></textarea>
        <div style="margin-top:8px; color:rgba(255,255,255,0.7); font-size:0.9rem;">Păstrăm varianta simplă (text/HTML). Editor rich se poate integra ulterior.</div>
    </div>
    <div style="display:flex; gap:10px;">
        <button type="submit" class="btn" style="padding:10px 18px; background:linear-gradient(135deg, #667eea, #764ba2); border:none; border-radius:8px; color:#fff; font-weight:600; cursor:pointer;">
            <i class="fas fa-save"></i> Salvează
        </button>
        <a href="?page=blog-preview&title=<?php echo urlencode($title); ?>&excerpt=<?php echo urlencode($excerpt); ?>" target="_blank" class="btn" style="padding:10px 18px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.3); border-radius:8px; color:#fff; font-weight:600; text-decoration:none;">
            <i class="fas fa-eye"></i> Previzualizează
        </a>
        <a href="?page=blog" class="btn" style="padding:10px 18px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.3); border-radius:8px; color:#fff; font-weight:600; text-decoration:none;">
            Înapoi la listă
        </a>
    </div>
</form>
