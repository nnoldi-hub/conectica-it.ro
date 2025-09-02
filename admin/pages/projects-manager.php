<?php
// Projects Manager Page
?>

<div class="content-header">
    <h1 class="content-title">Manager Proiecte</h1>
    <p class="content-subtitle">Adaugă, editează și gestionează proiectele din portofoliu</p>
</div>

<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; gap: 15px;">
        <button onclick="showAddProject()" style="padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
            <i class="fas fa-plus"></i> Proiect Nou
        </button>
        <button onclick="toggleView()" id="viewToggle" style="padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
            <i class="fas fa-th-large"></i> Vizualizare Grilă
        </button>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <input type="text" id="searchProjects" placeholder="Caută proiecte..." 
               style="padding: 10px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white; width: 200px;">
        <select id="filterStatus" style="padding: 10px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
            <option value="all">Toate Proiectele</option>
            <option value="completed">Finalizate</option>
            <option value="in_progress">În Progres</option>
            <option value="draft">Draft</option>
        </select>
    </div>
</div>

<!-- Add/Edit Project Modal -->
<div id="projectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 2000; padding: 20px; overflow-y: auto;">
    <div style="max-width: 800px; margin: 0 auto; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); border-radius: 15px; padding: 30px; position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 id="modalTitle" style="color: white;">Adaugă Proiect Nou</h2>
            <button onclick="closeModal()" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; padding: 5px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="projectForm" style="display: grid; gap: 20px;">
            <input type="hidden" id="projectId" name="project_id">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Titlu Proiect *</label>
                    <input type="text" id="projectTitle" name="title" required
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Status</label>
                    <select id="projectStatus" name="status" 
                            style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                        <option value="completed">Finalizat</option>
                        <option value="in_progress">În Progres</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Descriere Scurtă *</label>
                <textarea id="projectDescription" name="description" rows="3" required
                          style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; resize: vertical;"
                          placeholder="Descriere scurtă pentru preview..."></textarea>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Descriere Detaliată</label>
                <textarea id="projectDetailedDescription" name="detailed_description" rows="6"
                          style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; resize: vertical;"
                          placeholder="Descriere completă cu detalii tehnice, provocări, soluții..."></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Tehnologii Folosite</label>
                    <input type="text" id="projectTechnologies" name="technologies" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;"
                           placeholder="PHP, JavaScript, HTML, CSS...">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Durată Proiect</label>
                    <input type="text" id="projectDuration" name="duration" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;"
                           placeholder="ex: 2 săptămâni">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Client/Categorie</label>
                    <input type="text" id="projectClient" name="client" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;"
                           placeholder="Nume client sau categorie">
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">URL Demo/Live</label>
                    <input type="url" id="projectDemo" name="demo_url" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;"
                           placeholder="https://demo.example.com">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">GitHub/Cod Sursă</label>
                    <input type="url" id="projectGithub" name="github_url" 
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;"
                           placeholder="https://github.com/...">
                </div>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Imagini Proiect (URL-uri separate prin virgulă)</label>
                <textarea id="projectImages" name="images" rows="2"
                          style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; resize: vertical;"
                          placeholder="https://example.com/image1.jpg, https://example.com/image2.jpg..."></textarea>
                <small style="color: rgba(255,255,255,0.7);">Sau folosește butonul pentru a încărca imagini</small>
                <input type="file" id="imageUpload" multiple accept="image/*" style="margin-top: 10px; color: white;">
            </div>
            
            <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" onclick="closeModal()" 
                        style="padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                    Anulează
                </button>
                <button type="submit" 
                        style="padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Salvează Proiectul
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Projects List -->
<div id="projectsList">
    <!-- Grid View -->
    <div id="gridView" class="dashboard-grid">
        <!-- Project Card 1 -->
        <div class="card project-card" data-id="1" data-status="completed">
            <div style="position: relative;">
                <div style="position: absolute; top: 10px; right: 10px; display: flex; gap: 5px;">
                    <span class="status-badge status-completed" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; background: rgba(34, 197, 94, 0.2); color: #22c55e;">Finalizat</span>
                </div>
                <img src="https://via.placeholder.com/400x200/667eea/ffffff?text=E-commerce+Modern" alt="Project" 
                     style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
            </div>
            <div class="card-header">
                <div class="card-icon" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <h3 class="card-title">E-commerce Modern</h3>
                    <div style="font-size: 0.9rem; opacity: 0.7;">PHP, MySQL, JavaScript</div>
                </div>
            </div>
            <p class="card-description">Platformă de e-commerce completă cu sistem de plați, management produse și dashboard admin.</p>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                <div style="display: flex; gap: 10px;">
                    <button onclick="editProject(1)" style="padding: 6px 12px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-edit"></i> Editează
                    </button>
                    <button onclick="deleteProject(1)" style="padding: 6px 12px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="#" style="color: #667eea; text-decoration: none;"><i class="fas fa-external-link-alt"></i></a>
                    <a href="#" style="color: #667eea; text-decoration: none;"><i class="fas fa-code"></i></a>
                </div>
            </div>
        </div>

        <!-- Project Card 2 -->
        <div class="card project-card" data-id="2" data-status="completed">
            <div style="position: relative;">
                <div style="position: absolute; top: 10px; right: 10px;">
                    <span class="status-badge status-completed" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; background: rgba(34, 197, 94, 0.2); color: #22c55e;">Finalizat</span>
                </div>
                <img src="https://via.placeholder.com/400x200/764ba2/ffffff?text=Website+Corporate" alt="Project" 
                     style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
            </div>
            <div class="card-header">
                <div class="card-icon" style="background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h3 class="card-title">Website Corporate</h3>
                    <div style="font-size: 0.9rem; opacity: 0.7;">HTML, CSS, JavaScript</div>
                </div>
            </div>
            <p class="card-description">Site web corporate modern cu design responsive și animații interactive.</p>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                <div style="display: flex; gap: 10px;">
                    <button onclick="editProject(2)" style="padding: 6px 12px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-edit"></i> Editează
                    </button>
                    <button onclick="deleteProject(2)" style="padding: 6px 12px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="#" style="color: #667eea; text-decoration: none;"><i class="fas fa-external-link-alt"></i></a>
                    <a href="#" style="color: #667eea; text-decoration: none;"><i class="fas fa-code"></i></a>
                </div>
            </div>
        </div>

        <!-- Project Card 3 -->
        <div class="card project-card" data-id="3" data-status="in_progress">
            <div style="position: relative;">
                <div style="position: absolute; top: 10px; right: 10px;">
                    <span class="status-badge status-in-progress" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; background: rgba(251, 191, 36, 0.2); color: #fbbf24;">În Progres</span>
                </div>
                <img src="https://via.placeholder.com/400x200/f59e0b/ffffff?text=App+Mobile" alt="Project" 
                     style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
            </div>
            <div class="card-header">
                <div class="card-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div>
                    <h3 class="card-title">Aplicație Mobile</h3>
                    <div style="font-size: 0.9rem; opacity: 0.7;">React Native, Node.js</div>
                </div>
            </div>
            <p class="card-description">Aplicație mobilă pentru gestionarea taskurilor cu sincronizare în cloud.</p>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                <div style="display: flex; gap: 10px;">
                    <button onclick="editProject(3)" style="padding: 6px 12px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-edit"></i> Editează
                    </button>
                    <button onclick="deleteProject(3)" style="padding: 6px 12px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div style="display: flex; gap: 8px;">
                    <span style="color: rgba(255,255,255,0.5);"><i class="fas fa-clock"></i></span>
                </div>
            </div>
        </div>
    </div>

    <!-- List View (hidden by default) -->
    <div id="listView" style="display: none;">
        <div style="background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: rgba(0,0,0,0.3);">
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600;">Proiect</th>
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600;">Status</th>
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600;">Tehnologii</th>
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600;">Client</th>
                        <th style="padding: 15px; text-align: center; color: white; font-weight: 600;">Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <td style="padding: 15px; color: white;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="https://via.placeholder.com/50x50/667eea/ffffff" style="width: 50px; height: 50px; border-radius: 8px;">
                                <div>
                                    <div style="font-weight: 600;">E-commerce Modern</div>
                                    <div style="font-size: 0.9rem; opacity: 0.7;">Platformă completă de vânzări online</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <span class="status-badge status-completed" style="padding: 6px 12px; border-radius: 15px; font-size: 0.8rem; background: rgba(34, 197, 94, 0.2); color: #22c55e;">Finalizat</span>
                        </td>
                        <td style="padding: 15px; color: rgba(255,255,255,0.8);">PHP, MySQL, JavaScript</td>
                        <td style="padding: 15px; color: rgba(255,255,255,0.8);">Fashion Store</td>
                        <td style="padding: 15px; text-align: center;">
                            <button onclick="editProject(1)" style="padding: 6px 12px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 6px; color: white; cursor: pointer; margin-right: 5px;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteProject(1)" style="padding: 6px 12px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
let isGridView = true;
let projects = [
    {id: 1, title: 'E-commerce Modern', status: 'completed', technologies: 'PHP, MySQL, JavaScript', client: 'Fashion Store'},
    {id: 2, title: 'Website Corporate', status: 'completed', technologies: 'HTML, CSS, JavaScript', client: 'Business Corp'},
    {id: 3, title: 'Aplicație Mobile', status: 'in_progress', technologies: 'React Native, Node.js', client: 'StartupTech'}
];

function showAddProject() {
    document.getElementById('modalTitle').textContent = 'Adaugă Proiect Nou';
    document.getElementById('projectForm').reset();
    document.getElementById('projectId').value = '';
    document.getElementById('projectModal').style.display = 'block';
}

function editProject(id) {
    // Find project data (in real app, fetch from database)
    const project = projects.find(p => p.id === id);
    if (project) {
        document.getElementById('modalTitle').textContent = 'Editează Proiect';
        document.getElementById('projectId').value = id;
        document.getElementById('projectTitle').value = project.title;
        document.getElementById('projectStatus').value = project.status;
        // Fill other fields...
        document.getElementById('projectModal').style.display = 'block';
    }
}

function deleteProject(id) {
    if (confirm('Sigur vrei să ștergi acest proiect? Acțiunea nu poate fi anulată.')) {
        // Remove project (in real app, send delete request to server)
        const card = document.querySelector(`[data-id="${id}"]`);
        if (card) {
            card.remove();
            alert('Proiectul a fost șters cu succes!');
        }
    }
}

function closeModal() {
    document.getElementById('projectModal').style.display = 'none';
}

function toggleView() {
    isGridView = !isGridView;
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const toggleBtn = document.getElementById('viewToggle');
    
    if (isGridView) {
        gridView.style.display = 'grid';
        listView.style.display = 'none';
        toggleBtn.innerHTML = '<i class="fas fa-th-large"></i> Vizualizare Grilă';
    } else {
        gridView.style.display = 'none';
        listView.style.display = 'block';
        toggleBtn.innerHTML = '<i class="fas fa-list"></i> Vizualizare Listă';
    }
}

// Form submission
document.getElementById('projectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const isEdit = document.getElementById('projectId').value !== '';
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Se salvează...';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        alert(isEdit ? 'Proiectul a fost actualizat cu succes!' : 'Proiectul a fost adăugat cu succes!');
        closeModal();
        
        // In real app, refresh the projects list here
        
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 2000);
});

// Search and filter functionality
document.getElementById('searchProjects').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.project-card');
    
    cards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const description = card.querySelector('.card-description').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

document.getElementById('filterStatus').addEventListener('change', function(e) {
    const filterStatus = e.target.value;
    const cards = document.querySelectorAll('.project-card');
    
    cards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        
        if (filterStatus === 'all' || cardStatus === filterStatus) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Close modal when clicking outside
document.getElementById('projectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
