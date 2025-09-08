<?php
// Blog Editor (Create/Edit)
// Expected to be included from dashboard context with $auth, $pdo available
if (!isset($auth)) { echo '<div class="card">Autentificare necesară.</div>'; return; }
$csrf_token = $auth->generateCSRFToken();
?>

<div class="content-header">
	<h1 class="content-title">Editor Articol</h1>
	<p class="content-subtitle">Creează sau editează un articol de blog</p>
	<a href="?page=blog" class="logout-btn" style="display:inline-block;margin-top:10px;">&larr; Înapoi la Manager Blog</a>
	</div>

<div class="card" style="margin-top:20px;">
	<form id="blogForm">
	<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
	<input type="hidden" name="id" id="post_id" value="">
	<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
			<div>
				<label>Titlu</label>
				<input type="text" name="title" id="title" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;" required>
			</div>
			<div>
				<label>Slug (opțional)</label>
				<input type="text" name="slug" id="slug" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;">
			</div>
			<div>
				<label>Imagine cover (URL)</label>
				<input type="url" name="cover_image" id="cover_image" placeholder="/assets/images/placeholders/wide-purple.svg" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;">
			</div>
			<div>
				<label>Categorie</label>
				<input type="text" name="category" id="category" placeholder="PHP, MySQL, JS" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;">
			</div>
			<div style="grid-column:1/-1;">
				<label>Rezumat</label>
				<textarea name="excerpt" id="excerpt" rows="3" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;"></textarea>
			</div>
			<div style="grid-column:1/-1;">
				<label>Conținut (HTML permis)</label>
				<textarea name="content_html" id="content_html" rows="10" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;"></textarea>
			</div>
			<div>
				<label>Tag-uri (CSV sau JSON)</label>
				<input type="text" name="tags" id="tags" placeholder="PHP, Security" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;">
			</div>
			<div>
				<label>Autor</label>
				<input type="text" name="author" id="author" value="Nyikora Noldi" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;">
			</div>
			<div>
				<label>Min. citire</label>
				<input type="number" name="read_minutes" id="read_minutes" value="6" min="1" max="60" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;">
			</div>
			<div>
				<label>Status</label>
				<select name="status" id="status" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;">
					<option value="draft">Draft</option>
					<option value="published">Publicat</option>
				</select>
			</div>
			<div style="grid-column:1/-1;display:flex;gap:10px;align-items:center;">
				<label><input type="checkbox" name="featured" id="featured" value="1"> &nbsp; Articol recomandat</label>
				<button type="button" id="saveDraft" class="logout-btn">Salvează Draft</button>
				<button type="button" id="publish" class="logout-btn" style="border-color:#22c55e;background:rgba(34,197,94,0.25);">Publică</button>
				<span id="saveMsg" style="opacity:0.8;margin-left:10px;"></span>
			</div>
		</div>
	</form>
</div>

<div class="card" style="margin-top:20px;">
	<div class="card-header">
		<div class="card-icon"><i class="fas fa-eye"></i></div>
		<div>
			<h3 class="card-title">Previzualizare</h3>
		</div>
	</div>
	<div id="preview" class="card-description">
		<em>Completează câmpurile pentru a vedea previzualizarea.</em>
	</div>
</div>

<script>
const form = document.getElementById('blogForm');
const preview = document.getElementById('preview');
const statusSel = document.getElementById('status');
const saveMsg = document.getElementById('saveMsg');

function buildPreview() {
	const title = document.getElementById('title').value;
	const cover = document.getElementById('cover_image').value || '/assets/images/placeholders/wide-purple.svg';
	const excerpt = document.getElementById('excerpt').value;
	const author = document.getElementById('author').value || 'Conectica IT';
	const readm = document.getElementById('read_minutes').value || 5;
	preview.innerHTML = `
		<div style="display:flex;gap:20px;align-items:flex-start;">
			<img src="${cover}" alt="cover" style="width:260px;height:140px;object-fit:cover;border-radius:8px;">
			<div>
				<h3 style="margin:0 0 8px 0;">${title || '(fără titlu)'} <small style="opacity:0.7;font-weight:normal;">• ${readm} min</small></h3>
				<div style="opacity:0.8;margin-bottom:6px;">de ${author}</div>
				<div style="opacity:0.9;">${excerpt || ''}</div>
			</div>
		</div>
	`;
}

form.addEventListener('input', buildPreview);

function submitBlog(statusOverride) {
	const fd = new FormData(form);
	if (statusOverride) fd.set('status', statusOverride);
	saveMsg.textContent = 'Se salvează...';
	fetch('/admin/api/blog-save.php', { method: 'POST', body: fd })
		.then(r => r.json())
		.then(res => {
			if (res.success) {
				document.getElementById('post_id').value = res.id;
				saveMsg.textContent = (fd.get('status') === 'published') ? 'Publicat.' : 'Draft salvat.';
				setTimeout(()=> saveMsg.textContent='', 2500);
			} else {
				saveMsg.textContent = res.error || 'Eroare la salvare';
			}
		})
		.catch(() => saveMsg.textContent = 'Eroare de rețea');
}

document.getElementById('saveDraft').addEventListener('click', () => submitBlog('draft'));
document.getElementById('publish').addEventListener('click', () => submitBlog('published'));

// Initial preview
buildPreview();
</script>
