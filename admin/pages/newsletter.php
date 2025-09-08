<?php
// Admin Newsletter Manager: subscribers list + campaign composer
if (!isset($auth)) { echo '<div class="card">Autentificare necesară.</div>'; return; }
$csrf_token = $auth->generateCSRFToken();
?>

<div class="content-header">
  <h1 class="content-title">Newsletter</h1>
  <p class="content-subtitle">Gestionează abonații și trimite campanii cu articole</p>
</div>

<div class="card" style="margin-bottom:20px">
  <div class="card-header">
    <div class="card-icon"><i class="fas fa-users"></i></div>
    <div>
      <h3 class="card-title">Abonați</h3>
      <div class="card-description">Lista ultimilor abonați</div>
    </div>
  </div>
  <div id="subsWrap" class="card-description">
    <em>Se încarcă abonații…</em>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-icon"><i class="fas fa-paper-plane"></i></div>
    <div>
      <h3 class="card-title">Campanie nouă</h3>
      <div class="card-description">Construiește un newsletter pe baza articolelor publicate</div>
    </div>
  </div>

  <form id="campaignForm">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div>
        <label>Subiect</label>
        <input type="text" name="subject" required style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.08);color:#fff;">
      </div>
      <div>
        <label>Preheader</label>
        <input type="text" name="preheader" placeholder="Rezumat scurt…" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.08);color:#fff;">
      </div>
      <div>
        <label>Titlu în newsletter</label>
        <input type="text" name="title" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.08);color:#fff;">
      </div>
      <div>
        <label>CTA URL</label>
        <input type="text" name="cta_url" placeholder="/blog.php" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.08);color:#fff;">
      </div>
      <div style="grid-column:1/-1;">
        <label>Introducere</label>
        <textarea name="intro" rows="3" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.08);color:#fff;"></textarea>
      </div>
    </div>

    <div style="margin-top:14px;display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start;">
      <div>
        <label>Articole publicate (selectează până la 3)</label>
        <div id="postsList" style="max-height:260px;overflow:auto;border:1px solid rgba(255,255,255,.15);border-radius:8px;padding:10px"></div>
      </div>
      <div>
        <label>Elemente selectate</label>
        <div id="chosenList" style="min-height:120px;border:1px dashed rgba(255,255,255,.2);border-radius:8px;padding:10px"></div>
      </div>
    </div>

    <div style="margin-top:14px;display:flex;gap:10px;align-items:center;">
      <label><input type="checkbox" name="dry_run" checked> Dry-run (test, nu trimite)</label>
      <input type="email" name="test_email" placeholder="trimite doar către această adresă (opțional)" style="flex:1;padding:8px;border-radius:8px;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.08);color:#fff;">
      <button type="button" id="previewBtn" class="logout-btn" style="border-color:#6b7280;background:rgba(107,114,128,0.25);">Previzualizează</button>
      <button type="button" id="sendBtn" class="logout-btn" style="border-color:#22c55e;background:rgba(34,197,94,0.25);">Trimite</button>
      <span id="sendMsg" style="opacity:.85"></span>
    </div>
  </form>
  <div id="previewHtml" class="card" style="margin-top:14px;display:none"></div>
</div>

<script>
const subsWrap = document.getElementById('subsWrap');
const postsList = document.getElementById('postsList');
const chosenList = document.getElementById('chosenList');
const sendBtn = document.getElementById('sendBtn');
const sendMsg = document.getElementById('sendMsg');
const previewBtn = document.getElementById('previewBtn');
const previewHtml = document.getElementById('previewHtml');
const form = document.getElementById('campaignForm');

function h(s){ return String(s||'').replace(/[&<>]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;'}[c])); }

function loadSubs(){
  fetch('/admin/api/audience-list.php')
   .then(r=>r.json())
   .then(res=>{
      if(!res.success){ subsWrap.innerHTML = '<em>Nu am putut încărca abonații.</em>'; return; }
      const rows = res.items || [];
      const total = res.total || rows.length;
      let html = `<div style="margin-bottom:8px">Total: <strong>${total}</strong> abonați</div>`;
      html += '<table style="width:100%;border-collapse:collapse">\n<tr><th style="text-align:left;padding:6px;border-bottom:1px solid rgba(255,255,255,.2)">Email</th><th style="text-align:left;padding:6px;border-bottom:1px solid rgba(255,255,255,.2)">Data</th><th style="text-align:left;padding:6px;border-bottom:1px solid rgba(255,255,255,.2)">Sursa</th></tr>';
      rows.forEach(r=>{ html += `<tr><td style="padding:6px;border-bottom:1px solid rgba(255,255,255,.08)">${h(r.email)}</td><td style="padding:6px;border-bottom:1px solid rgba(255,255,255,.08)">${h(r.created_at||'')}</td><td style="padding:6px;border-bottom:1px solid rgba(255,255,255,.08)">${h(r.source||'')}</td></tr>`; });
      html += '</table>';
      subsWrap.innerHTML = html;
   })
}

function loadPosts(){
  fetch('/admin/api/blog-list.php?status=published')
   .then(r=>r.json())
   .then(res=>{
     postsList.innerHTML='';
     if(!res.success || !res.items || !res.items.length){ postsList.innerHTML='<em>Nu există articole publicate.</em>'; return; }
     res.items.forEach(p=>{
        const div=document.createElement('div');
        div.style.cssText='display:flex;gap:8px;align-items:center;padding:6px;border-bottom:1px solid rgba(255,255,255,.08)';
        div.innerHTML=`<img src="${h(p.cover_image||'/assets/images/placeholders/wide-purple.svg')}" style="width:60px;height:34px;object-fit:cover;border-radius:6px">`+
                       `<div style="flex:1">${h(p.title)}</div>`+
                       `<button type="button" data-id="${p.id}" class="logout-btn" style="padding:6px 10px">Adaugă</button>`;
        div.querySelector('button').addEventListener('click',()=>addItem(p));
        postsList.appendChild(div);
     });
   })
}

function addItem(p){
  const items = [...chosenList.querySelectorAll('[data-id]')];
  if(items.length>=3){ alert('Poți selecta maxim 3 articole.'); return; }
  if(items.find(x=>x.getAttribute('data-id')==String(p.id))) return;
  const item=document.createElement('div');
  item.setAttribute('data-id', String(p.id));
  item.style.cssText='display:flex;gap:8px;align-items:center;padding:6px;border-bottom:1px dashed rgba(255,255,255,.12)';
  item.innerHTML=`<span style="opacity:.8;">#${h(p.category||'')}</span>`+
                 `<div style="flex:1">${h(p.title)}</div>`+
                 `<button type="button" class="logout-btn" style="padding:4px 8px;background:rgba(255,69,69,.25);border-color:#ef4444">Scoate</button>`;
  item.querySelector('button').addEventListener('click',()=>item.remove());
  chosenList.appendChild(item);
}

function gatherItems(){
  const arr=[]; [...chosenList.querySelectorAll('[data-id]')].forEach(el=>{
    const title=el.querySelector('div').textContent; // from inner structure
    const id=el.getAttribute('data-id');
    const found = window._postsCache?.find(p=>String(p.id)===String(id));
    if(found){
      arr.push({ tag: found.category||'', title: found.title, desc: found.excerpt||'', url: '/article.php?slug='+found.slug });
    } else {
      arr.push({ tag:'', title, desc:'', url:'/blog.php' });
    }
  });
  return arr;
}

previewBtn.addEventListener('click', ()=>{
  const fd = new FormData(form);
  const payload = { mode:'builder',
    subject: fd.get('subject'), preheader: fd.get('preheader'), title: fd.get('title'), intro: fd.get('intro'), cta_url: fd.get('cta_url'),
    items: gatherItems()
  };
  fetch('/admin/api/campaign-send.php?preview=1', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload) })
    .then(async (r)=>{
      const ct = r.headers.get('content-type')||'';
      if(!r.ok){
        const t = await r.text().catch(()=> '');
        throw new Error(`HTTP ${r.status} ${r.statusText}${t? ' • '+t.slice(0,200):''}`);
      }
      if(ct.includes('application/json')) return r.json();
      const t = await r.text();
      try { return JSON.parse(t); } catch(e){ throw new Error('Răspuns nevalid (nu e JSON): '+t.slice(0,200)); }
    })
    .then(res=>{
      if(res.success && res.html){ previewHtml.style.display='block'; previewHtml.innerHTML = res.html; }
      else { previewHtml.style.display='block'; previewHtml.innerHTML = '<div class="card-description">Nu s-a putut genera previzualizarea.</div>'; }
    })
    .catch(err=>{ console.error(err); previewHtml.style.display='block'; previewHtml.innerHTML = '<div class="card-description">Eroare: '+String(err.message||err)+'</div>'; });
});

sendBtn.addEventListener('click', ()=>{
  const fd = new FormData(form);
  const payload = { csrf_token: fd.get('csrf_token'), mode:'builder', dry_run: fd.get('dry_run')?1:0, test_email: fd.get('test_email')||'',
    subject: fd.get('subject'), preheader: fd.get('preheader'), title: fd.get('title'), intro: fd.get('intro'), cta_url: fd.get('cta_url'),
    items: gatherItems()
  };
  sendBtn.disabled = true; sendMsg.textContent='Se trimite…';
  fetch('/admin/api/campaign-send.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload) })
    .then(async (r)=>{
      const ct = r.headers.get('content-type')||'';
      if(!r.ok){
        const t = await r.text().catch(()=> '');
        throw new Error(`HTTP ${r.status} ${r.statusText}${t? ' • '+t.slice(0,200):''}`);
      }
      if(ct.includes('application/json')) return r.json();
      const t = await r.text();
      try { return JSON.parse(t); } catch(e){ throw new Error('Răspuns nevalid (nu e JSON): '+t.slice(0,200)); }
    })
    .then(res=>{
      if(res.success){
        let extra = '';
        if (res.errors && res.errors.length) { extra = ' • detalii: ' + (res.errors[0] || ''); }
        sendMsg.textContent = `OK • subs: ${res.total} • trimise: ${res.sent} • erori: ${res.fail}${res.dry? ' • dry-run':''}${extra}`;
      } else {
        sendMsg.textContent = 'Eșec: ' + (res.error||'');
      }
    })
    .catch(err=>{ console.error(err); sendMsg.textContent='Eroare: ' + String(err.message||err); })
    .finally(()=> sendBtn.disabled=false);
});

// bootstrap
loadSubs();
fetch('/admin/api/blog-list.php?status=published').then(r=>r.json()).then(res=>{ window._postsCache = res.items||[]; loadPosts(); });
</script>
