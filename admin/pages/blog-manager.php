<?php
// Blog Manager Page
?>

<div class="content-header">
    <h1 class="content-title">Manager Blog</h1>
    <p class="content-subtitle">Creează și gestionează articolele de blog</p>
</div>

<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; gap: 15px;">
        <a href="?page=blog-editor" style="display:inline-block; padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer; text-decoration:none;">
            <i class="fas fa-plus"></i> Articol Nou
        </a>
        <select style="padding: 10px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
            <option value="all">Toate Articolele</option>
            <option value="published">Publicate</option>
            <option value="draft">Draft</option>
        </select>
    </div>
</div>

<div class="dashboard-grid">
    <div class="card">
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
            <a href="?page=blog-editor" style="padding: 8px 15px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 6px; color: white; cursor: pointer; text-decoration:none; display:inline-block;">
                <i class="fas fa-edit"></i> Editează
            </a>
            <a href="?page=blog-preview" style="padding: 8px 15px; background: rgba(34,197,94,0.3); border: 1px solid rgba(34,197,94,0.5); border-radius: 6px; color: white; cursor: pointer; text-decoration:none; display:inline-block;">
                <i class="fas fa-eye"></i> Vezi
            </a>
        </div>
    </div>

    <div class="card">
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
            <a href="?page=blog-editor" style="padding: 8px 15px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 6px; color: white; cursor: pointer; text-decoration:none; display:inline-block;">
                <i class="fas fa-edit"></i> Continuă editarea
            </a>
            <button disabled style="padding: 8px 15px; background: rgba(251,191,36,0.2); border: 1px solid rgba(251,191,36,0.3); border-radius: 6px; color: rgba(255,255,255,0.7); cursor: not-allowed;">
                <i class="fas fa-upload"></i> Publică
            </button>
        </div>
    </div>
</div>

<script>
// Optional: future enhancements for filtering/pagination can go here
</script>
