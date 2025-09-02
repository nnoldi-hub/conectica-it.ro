<?php
// Settings Page
?>

<div class="content-header">
    <h1 class="content-title">Setări Site</h1>
    <p class="content-subtitle">Configurează setările generale și informațiile de contact</p>
</div>

<div class="dashboard-grid">
    <div class="card" style="grid-column: 1 / -1;">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-cog"></i>
            </div>
            <div>
                <h3 class="card-title">Informații Contact</h3>
            </div>
        </div>
        <form style="display: grid; gap: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email</label>
                    <input type="email" value="conectica.it.ro@gmail.com" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Telefon</label>
                    <input type="tel" value="0740173581" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Website URL</label>
                <input type="url" value="conectica-it.ro" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
            </div>
            <button type="submit" style="padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer; justify-self: start;">
                <i class="fas fa-save"></i> Salvează Setările
            </button>
        </form>
    </div>
</div>
