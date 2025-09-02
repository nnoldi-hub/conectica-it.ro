<?php
// Content Editor Page
?>

<div class="content-header">
    <h1 class="content-title">Editare Conținut Site</h1>
    <p class="content-subtitle">Actualizează informațiile de pe pagina principală și alte secțiuni</p>
</div>

<div class="dashboard-grid">
    <!-- Hero Section Editor -->
    <div class="card" style="grid-column: 1 / -1;">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-home"></i>
            </div>
            <div>
                <h3 class="card-title">Secțiunea Hero (Pagina Principală)</h3>
            </div>
        </div>
        <form id="heroForm" style="display: grid; gap: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Titlu Principal</label>
                    <input type="text" name="hero_title" value="Nyikora Noldi - Freelancer IT" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Subtitlu</label>
                    <input type="text" name="hero_subtitle" value="Dezvoltator Web & Soluții IT Personalizate" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Descriere</label>
                <textarea name="hero_description" rows="4" 
                          style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; resize: vertical;">Cu peste 3 ani de experiență în dezvoltarea web și soluții IT, transform ideile tale în realitate digitală. Specializat în aplicații web moderne, e-commerce și soluții personalizate.</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Text Buton Principal</label>
                    <input type="text" name="hero_btn_primary" value="Vezi Proiectele Mele" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Text Buton Secundar</label>
                    <input type="text" name="hero_btn_secondary" value="Contactează-mă" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
            </div>
            <div style="display: flex; gap: 15px;">
                <button type="submit" style="padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Salvează Modificările
                </button>
                <button type="button" onclick="previewChanges()" style="padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-eye"></i> Previzualizează
                </button>
            </div>
        </form>
    </div>

    <!-- About Section Editor -->
    <div class="card" style="grid-column: 1 / -1;">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <h3 class="card-title">Secțiunea Despre Mine</h3>
            </div>
        </div>
        <form id="aboutForm" style="display: grid; gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Titlu Secțiune</label>
                <input type="text" name="about_title" value="Despre Mine" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Descriere Detaliată</label>
                <textarea name="about_description" rows="6" 
                          style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; resize: vertical;">Sunt un freelancer IT pasionat cu experiență în dezvoltarea de aplicații web moderne și soluții personalizate. 

Îmi place să colaborez cu clienții pentru a transforma viziunile lor în produse digitale funcționale și atractive. Specializarea mea include PHP, JavaScript, HTML/CSS, și tehnologii moderne de frontend și backend.

De-a lungul carierei mele, am lucrat la diverse proiecte, de la site-uri corporate simple până la aplicații web complexe și platforme e-commerce.</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Ani Experiență</label>
                    <input type="number" name="experience_years" value="3" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Proiecte Complete</label>
                    <input type="number" name="completed_projects" value="12" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Clienți Mulțumiți</label>
                    <input type="number" name="happy_clients" value="10" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
            </div>
            <div style="display: flex; gap: 15px;">
                <button type="submit" style="padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Salvează Modificările
                </button>
            </div>
        </form>
    </div>

    <!-- Services Section Editor -->
    <div class="card" style="grid-column: 1 / -1;">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-cogs"></i>
            </div>
            <div>
                <h3 class="card-title">Secțiunea Servicii</h3>
            </div>
        </div>
        
        <div id="servicesContainer">
            <!-- Service 1 -->
            <div class="service-item" style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 15px;">
                <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 15px; align-items: start;">
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Icona</label>
                        <input type="text" name="service_icon[]" value="fas fa-code" placeholder="ex: fas fa-code"
                               style="width: 150px; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Titlu Serviciu</label>
                        <input type="text" name="service_title[]" value="Dezvoltare Web" 
                               style="width: 100%; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
                        <label style="display: block; margin: 8px 0; font-weight: 600;">Descriere</label>
                        <textarea name="service_description[]" rows="2" 
                                  style="width: 100%; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white; resize: vertical;">Site-uri web responsive, aplicații moderne și platforme personalizate</textarea>
                    </div>
                    <button type="button" onclick="removeService(this)" style="padding: 8px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="service-item" style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 15px;">
                <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 15px; align-items: start;">
                    <div>
                        <input type="text" name="service_icon[]" value="fas fa-shopping-cart" 
                               style="width: 150px; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
                    </div>
                    <div>
                        <input type="text" name="service_title[]" value="E-commerce" 
                               style="width: 100%; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
                        <textarea name="service_description[]" rows="2" 
                                  style="width: 100%; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white; resize: vertical; margin-top: 8px;">Magazine online complete cu sisteme de plată și management produse</textarea>
                    </div>
                    <button type="button" onclick="removeService(this)" style="padding: 8px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="service-item" style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 15px;">
                <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 15px; align-items: start;">
                    <div>
                        <input type="text" name="service_icon[]" value="fas fa-mobile-alt" 
                               style="width: 150px; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
                    </div>
                    <div>
                        <input type="text" name="service_title[]" value="Aplicații Mobile" 
                               style="width: 100%; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
                        <textarea name="service_description[]" rows="2" 
                                  style="width: 100%; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white; resize: vertical; margin-top: 8px;">Aplicații mobile native și web-based pentru toate dispozitivele</textarea>
                    </div>
                    <button type="button" onclick="removeService(this)" style="padding: 8px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <button type="button" onclick="addService()" style="padding: 12px 25px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                <i class="fas fa-plus"></i> Adaugă Serviciu
            </button>
            <button type="button" onclick="saveServices()" style="padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save"></i> Salvează Serviciile
            </button>
        </div>
    </div>
</div>

<script>
// Form submission handlers
document.getElementById('heroForm').addEventListener('submit', function(e) {
    e.preventDefault();
    saveContent('hero', new FormData(this));
});

document.getElementById('aboutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    saveContent('about', new FormData(this));
});

function saveContent(section, formData) {
    // Show loading state
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Se salvează...';
    submitBtn.disabled = true;
    
    // Simulate API call (replace with actual implementation)
    setTimeout(() => {
        alert('Conținutul pentru secțiunea "' + section + '" a fost salvat cu succes!');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 1500);
}

function previewChanges() {
    window.open('../index.php', '_blank');
}

// Services management
function addService() {
    const container = document.getElementById('servicesContainer');
    const serviceItem = document.createElement('div');
    serviceItem.className = 'service-item';
    serviceItem.style.cssText = 'background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 15px;';
    
    serviceItem.innerHTML = `
        <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 15px; align-items: start;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Icona</label>
                <input type="text" name="service_icon[]" placeholder="ex: fas fa-cog"
                       style="width: 150px; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Titlu Serviciu</label>
                <input type="text" name="service_title[]" placeholder="Nume serviciu" 
                       style="width: 100%; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
                <label style="display: block; margin: 8px 0; font-weight: 600;">Descriere</label>
                <textarea name="service_description[]" rows="2" placeholder="Descriere serviciu"
                          style="width: 100%; padding: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white; resize: vertical;"></textarea>
            </div>
            <button type="button" onclick="removeService(this)" style="padding: 8px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    container.appendChild(serviceItem);
}

function removeService(button) {
    if(confirm('Sigur vrei să ștergi acest serviciu?')) {
        button.closest('.service-item').remove();
    }
}

function saveServices() {
    const formData = new FormData();
    
    // Collect all service data
    const icons = document.querySelectorAll('input[name="service_icon[]"]');
    const titles = document.querySelectorAll('input[name="service_title[]"]');
    const descriptions = document.querySelectorAll('textarea[name="service_description[]"]');
    
    const services = [];
    for(let i = 0; i < icons.length; i++) {
        if(titles[i].value.trim()) {
            services.push({
                icon: icons[i].value,
                title: titles[i].value,
                description: descriptions[i].value
            });
        }
    }
    
    formData.append('services', JSON.stringify(services));
    
    // Show loading state
    const saveBtn = event.target;
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Se salvează...';
    saveBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        alert('Serviciile au fost salvate cu succes!');
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    }, 1500);
}
</script>
