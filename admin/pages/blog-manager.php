<?php
// Blog Manager Page
// We assume we're included from dashboard.php where $auth is available
$csrf_token = isset($auth) ? $auth->generateCSRFToken() : ($_SESSION['csrf_token'] ?? '');
?>

<div class="content-header">
    <h1 class="content-title">Manager Blog</h1>
    <p class="content-subtitle">Creează și gestionează articolele de blog</p>
</div>

<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; gap: 15px;">
        <button onclick="showAddArticle()" style="padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
            <i class="fas fa-plus"></i> Articol Nou
        </button>
        <select style="padding: 10px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
            <option value="all">Toate Articolele</option>
            <option value="published">Publicate</option>
            <option value="draft">Draft</option>
        </select>
    </div>
</div>

<div class="dashboard-grid">
    <div class="card" id="post-card-1" data-post-id="1">
    <img src="../assets/images/placeholders/wide-purple.svg" alt="Article" 
             style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-code"></i>
            </div>
            <div>
                <h3 class="card-title">Trends în Web Development 2025</h3>
                <div style="font-size: 0.9rem; opacity: 0.7;">Publicat acum 2 zile</div>
            </div>
        </div>
        <p class="card-description">Explorează cele mai noi tendințe în dezvoltarea web și tehnologiile care vor domina anul 2025...</p>
        <div style="display: flex; gap: 10px; margin-top: 15px;">
            <button style="padding: 8px 15px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 6px; color: white; cursor: pointer;">
                <i class="fas fa-edit"></i> Editează
            </button>
            <button style="padding: 8px 15px; background: rgba(34,197,94,0.3); border: 1px solid rgba(34,197,94,0.5); border-radius: 6px; color: white; cursor: pointer;">
                <i class="fas fa-eye"></i> Vezi
            </button>
            <button onclick="deletePost(1)" style="padding: 8px 15px; background: rgba(255,69,69,0.25); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: #ffd5d5; cursor: pointer;">
                <i class="fas fa-trash"></i> Șterge
            </button>
        </div>
    </div>

    <div class="card" id="post-card-2" data-post-id="2">
    <img src="../assets/images/placeholders/wide-green.svg" alt="Article" 
             style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
        <div class="card-header">
            <div class="card-icon">
                <i class="fab fa-php"></i>
            </div>
            <div>
                <h3 class="card-title">PHP Best Practices pentru 2025</h3>
                <div style="font-size: 0.9rem; opacity: 0.7;">Draft - salvat acum 1 oră</div>
            </div>
        </div>
        <p class="card-description">Ghid complet cu cele mai bune practici PHP pentru dezvoltatori moderni...</p>
        <div style="display: flex; gap: 10px; margin-top: 15px;">
            <button style="padding: 8px 15px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 6px; color: white; cursor: pointer;">
                <i class="fas fa-edit"></i> Continuă editarea
            </button>
            <button style="padding: 8px 15px; background: rgba(251,191,36,0.3); border: 1px solid rgba(251,191,36,0.5); border-radius: 6px; color: white; cursor: pointer;">
                <i class="fas fa-upload"></i> Publică
            </button>
            <button onclick="deletePost(2)" style="padding: 8px 15px; background: rgba(255,69,69,0.25); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: #ffd5d5; cursor: pointer;">
                <i class="fas fa-trash"></i> Șterge
            </button>
        </div>
    </div>
</div>

<script>
function showAddArticle() {
    alert('Editor de articole va fi implementat cu rich text editor și preview live.');
}

// Delete post (AJAX with CSRF)
function deletePost(id) {
    if (!confirm('Sigur dorești să ștergi acest articol? Acțiunea nu poate fi anulată.')) return;
    const btns = document.querySelectorAll('#post-card-' + id + ' button');
    btns.forEach(b => b.disabled = true);

    const body = new URLSearchParams({ id: String(id), csrf_token: '<?php echo htmlspecialchars($csrf_token); ?>' });
    fetch('/admin/api/blog-delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body
    }).then(r => r.json()).then(res => {
        if (res.success) {
            const el = document.getElementById('post-card-' + id);
            if (el) el.remove();
        } else {
            alert(res.error || 'A apărut o eroare la ștergere.');
            btns.forEach(b => b.disabled = false);
        }
    }).catch(() => {
        alert('Eroare de rețea. Încearcă din nou.');
        btns.forEach(b => b.disabled = false);
    });
}
</script>
