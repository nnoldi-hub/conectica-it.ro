<?php
// Quotes Page
?>

<div class="content-header">
    <h1 class="content-title">Cereri de Ofertă</h1>
    <p class="content-subtitle">Gestionează cererile de ofertă și propunerile de colaborare</p>
</div>

<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; gap: 15px;">
        <select id="filterQuotes" style="padding: 10px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
            <option value="all">Toate Cererile</option>
            <option value="new">Noi</option>
            <option value="in_review">În Evaluare</option>
            <option value="responded">Răspuns Trimis</option>
            <option value="accepted">Acceptate</option>
            <option value="rejected">Respinse</option>
        </select>
        <button onclick="exportQuotes()" style="padding: 10px 20px; background: rgba(34,197,94,0.3); border: 1px solid rgba(34,197,94,0.5); border-radius: 6px; color: white; cursor: pointer;">
            <i class="fas fa-download"></i> Export Excel
        </button>
    </div>
    <div style="color: rgba(255,255,255,0.8);">
        <span id="quoteCount">5 cereri noi</span>
    </div>
</div>

<!-- Quotes List -->
<div style="display: grid; gap: 25px;">
    <!-- Quote Request 1 - New -->
    <div class="card quote-item" data-status="new" style="position: relative; border-left: 4px solid #667eea;">
        <div style="position: absolute; top: 15px; right: 15px; display: flex; gap: 10px;">
            <span class="status-badge" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; background: rgba(102, 126, 234, 0.2); color: #667eea;">Nou</span>
            <select onchange="updateQuoteStatus(1, this.value)" style="padding: 4px 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white; font-size: 0.8rem;">
                <option value="new">Nou</option>
                <option value="in_review">În Evaluare</option>
                <option value="responded">Răspuns Trimis</option>
                <option value="accepted">Acceptat</option>
                <option value="rejected">Respins</option>
            </select>
        </div>
        
        <div style="display: grid; grid-template-columns: auto 1fr; gap: 20px;">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 600;">
                T
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin-bottom: 8px; font-size: 1.3rem;">TechStartup SRL</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; font-size: 0.9rem; opacity: 0.8;">
                            <span><i class="fas fa-user"></i> Alexandru Popescu</span>
                            <span><i class="fas fa-envelope"></i> alex.popescu@techstartup.ro</span>
                            <span><i class="fas fa-phone"></i> 0721 456 789</span>
                            <span><i class="fas fa-calendar"></i> Acum 3 ore</span>
                        </div>
                    </div>
                </div>
                
                <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                        <div>
                            <strong style="color: #667eea;">Tip Proiect:</strong> Aplicație Web
                        </div>
                        <div>
                            <strong style="color: #667eea;">Buget Estimat:</strong> 5,000 - 8,000 EUR
                        </div>
                        <div>
                            <strong style="color: #667eea;">Termen Dorit:</strong> 2-3 luni
                        </div>
                        <div>
                            <strong style="color: #667eea;">Compania:</strong> TechStartup SRL
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <strong style="color: #667eea;">Descrierea Proiectului:</strong><br>
                        <div style="margin-top: 8px; line-height: 1.6;">
                            Avem nevoie de o platformă web pentru gestionarea proiectelor interne. Aplicația trebuie să permită:
                            - Management task-uri și deadline-uri
                            - Sistem de colaborare în echipă
                            - Rapoarte și dashboard-uri
                            - Integrare cu calendarul Google
                            - Design modern și responsive
                        </div>
                    </div>
                    
                    <div>
                        <strong style="color: #667eea;">Tehnologii Preferate:</strong>
                        <div style="margin-top: 8px;">
                            <span style="background: rgba(102,126,234,0.2); padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; margin-right: 8px;">PHP</span>
                            <span style="background: rgba(102,126,234,0.2); padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; margin-right: 8px;">JavaScript</span>
                            <span style="background: rgba(102,126,234,0.2); padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; margin-right: 8px;">MySQL</span>
                            <span style="background: rgba(102,126,234,0.2); padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">Bootstrap</span>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button onclick="viewQuoteDetails(1)" style="padding: 10px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-eye"></i> Vezi Detaliile Complete
                    </button>
                    <button onclick="respondToQuote(1)" style="padding: 10px 20px; background: rgba(34, 197, 94, 0.3); border: 1px solid rgba(34, 197, 94, 0.5); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-reply"></i> Trimite Ofertă
                    </button>
                    <button onclick="createProposal(1)" style="padding: 10px 20px; background: rgba(251, 191, 36, 0.3); border: 1px solid rgba(251, 191, 36, 0.5); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-file-contract"></i> Generează Propunere
                    </button>
                    <button onclick="deleteQuote(1)" style="padding: 10px 20px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-trash"></i> Șterge
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quote Request 2 - In Review -->
    <div class="card quote-item" data-status="in_review" style="position: relative; border-left: 4px solid #f59e0b;">
        <div style="position: absolute; top: 15px; right: 15px; display: flex; gap: 10px;">
            <span class="status-badge" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; background: rgba(251, 191, 36, 0.2); color: #fbbf24;">În Evaluare</span>
            <select onchange="updateQuoteStatus(2, this.value)" style="padding: 4px 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white; font-size: 0.8rem;">
                <option value="new">Nou</option>
                <option value="in_review" selected>În Evaluare</option>
                <option value="responded">Răspuns Trimis</option>
                <option value="accepted">Acceptat</option>
                <option value="rejected">Respins</option>
            </select>
        </div>
        
        <div style="display: grid; grid-template-columns: auto 1fr; gap: 20px;">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 600;">
                E
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin-bottom: 8px; font-size: 1.3rem;">E-Fashion Store</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; font-size: 0.9rem; opacity: 0.8;">
                            <span><i class="fas fa-user"></i> Maria Georgescu</span>
                            <span><i class="fas fa-envelope"></i> maria@efashion.ro</span>
                            <span><i class="fas fa-phone"></i> 0734 567 890</span>
                            <span><i class="fas fa-calendar"></i> Ieri</span>
                        </div>
                    </div>
                </div>
                
                <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                        <div>
                            <strong style="color: #f59e0b;">Tip Proiect:</strong> E-commerce
                        </div>
                        <div>
                            <strong style="color: #f59e0b;">Buget Estimat:</strong> 3,000 - 5,000 EUR
                        </div>
                        <div>
                            <strong style="color: #f59e0b;">Termen Dorit:</strong> 1-2 luni
                        </div>
                        <div>
                            <strong style="color: #f59e0b;">Compania:</strong> E-Fashion Store
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <strong style="color: #f59e0b;">Descrierea Proiectului:</strong><br>
                        <div style="margin-top: 8px; line-height: 1.6;">
                            Magazin online pentru produse fashion cu funcționalități avansate:
                            - Catalog produse cu filtrare complexă
                            - Sistem de plăți multiple (card, PayPal, transfer)
                            - Gestiune stocuri și comenzi
                            - Review-uri și rating produse
                            - Program de loialitate clienți
                        </div>
                    </div>
                    
                    <div>
                        <strong style="color: #f59e0b;">Tehnologii Preferate:</strong>
                        <div style="margin-top: 8px;">
                            <span style="background: rgba(251,191,36,0.2); padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; margin-right: 8px;">WooCommerce</span>
                            <span style="background: rgba(251,191,36,0.2); padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; margin-right: 8px;">WordPress</span>
                            <span style="background: rgba(251,191,36,0.2); padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">Custom PHP</span>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button onclick="viewQuoteDetails(2)" style="padding: 10px 20px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-eye"></i> Vezi Detaliile Complete
                    </button>
                    <button onclick="respondToQuote(2)" style="padding: 10px 20px; background: rgba(34, 197, 94, 0.3); border: 1px solid rgba(34, 197, 94, 0.5); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-reply"></i> Trimite Ofertă
                    </button>
                    <button onclick="createProposal(2)" style="padding: 10px 20px; background: rgba(251, 191, 36, 0.3); border: 1px solid rgba(251, 191, 36, 0.5); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-file-contract"></i> Generează Propunere
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quote Request 3 - Responded -->
    <div class="card quote-item" data-status="responded" style="position: relative; border-left: 4px solid #22c55e; opacity: 0.8;">
        <div style="position: absolute; top: 15px; right: 15px; display: flex; gap: 10px;">
            <span class="status-badge" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; background: rgba(34, 197, 94, 0.2); color: #22c55e;">Răspuns Trimis</span>
            <select onchange="updateQuoteStatus(3, this.value)" style="padding: 4px 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white; font-size: 0.8rem;">
                <option value="new">Nou</option>
                <option value="in_review">În Evaluare</option>
                <option value="responded" selected>Răspuns Trimis</option>
                <option value="accepted">Acceptat</option>
                <option value="rejected">Respins</option>
            </select>
        </div>
        
        <div style="display: grid; grid-template-columns: auto 1fr; gap: 20px;">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 600;">
                B
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin-bottom: 8px; font-size: 1.3rem;">Business Solutions</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; font-size: 0.9rem; opacity: 0.8;">
                            <span><i class="fas fa-user"></i> Ionuț Marin</span>
                            <span><i class="fas fa-envelope"></i> ionut@business-sol.ro</span>
                            <span><i class="fas fa-phone"></i> 0745 123 789</span>
                            <span><i class="fas fa-calendar"></i> Acum 2 zile</span>
                        </div>
                    </div>
                </div>
                
                <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                        <div>
                            <strong style="color: #22c55e;">Tip Proiect:</strong> Website Corporate
                        </div>
                        <div>
                            <strong style="color: #22c55e;">Buget Estimat:</strong> 2,000 - 3,000 EUR
                        </div>
                        <div>
                            <strong style="color: #22c55e;">Termen Dorit:</strong> 3-4 săptămâni
                        </div>
                        <div>
                            <strong style="color: #22c55e;">Status Ofertă:</strong> <span style="color: #22c55e;">Trimisă (2,400 EUR)</span>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <strong style="color: #22c55e;">Descrierea Proiectului:</strong><br>
                        <div style="margin-top: 8px; line-height: 1.6;">
                            Website corporate modern pentru companie de consultanță business cu:
                            - Design profesional și clean
                            - Secțiuni: Despre, Servicii, Echipă, Contact
                            - Formulare de contact și newsletter
                            - Blog integrat pentru articole
                            - Optimizare SEO
                        </div>
                    </div>
                    
                    <div style="background: rgba(34, 197, 94, 0.1); padding: 15px; border-radius: 8px; border: 1px solid rgba(34, 197, 94, 0.3);">
                        <strong style="color: #22c55e;"><i class="fas fa-check-circle"></i> Oferta Trimisă:</strong><br>
                        <div style="margin-top: 8px; font-size: 0.9rem;">
                            Preț: <strong>2,400 EUR</strong> | Termen: <strong>3 săptămâni</strong> | Trimis: <strong>23 Aug 2025</strong>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button onclick="viewQuoteDetails(3)" style="padding: 10px 20px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-eye"></i> Vezi Oferta Trimisă
                    </button>
                    <button onclick="followUpQuote(3)" style="padding: 10px 20px; background: rgba(102, 126, 234, 0.3); border: 1px solid rgba(102, 126, 234, 0.5); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-phone"></i> Follow-up
                    </button>
                    <button onclick="duplicateQuote(3)" style="padding: 10px 20px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-copy"></i> Duplică Template
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quote Details Modal -->
<div id="quoteModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 2000; padding: 20px; overflow-y: auto;">
    <div style="max-width: 900px; margin: 0 auto; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); border-radius: 15px; padding: 30px; position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 id="modalTitle" style="color: white;">Detalii Cerere Ofertă</h2>
            <button onclick="closeQuoteModal()" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; padding: 5px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div id="modalContent" style="color: white; line-height: 1.6;">
            <!-- Quote content will be loaded here -->
        </div>
    </div>
</div>

<!-- Response Modal -->
<div id="responseModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 2000; padding: 20px; overflow-y: auto;">
    <div style="max-width: 800px; margin: 0 auto; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); border-radius: 15px; padding: 30px; position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 style="color: white;">Trimite Ofertă</h2>
            <button onclick="closeResponseModal()" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; padding: 5px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="responseForm" style="display: grid; gap: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Preț Ofertat (EUR)</label>
                    <input type="number" id="quotePrice" name="price" step="100" required
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Termen Livrare</label>
                    <input type="text" id="quoteDeadline" name="deadline" placeholder="ex: 3 săptămâni" required
                           style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white;">
                </div>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: white;">Mesaj Personalizat</label>
                <textarea id="quoteMessage" name="message" rows="8" required
                          style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; resize: vertical;"
                          placeholder="Scrie aici oferta detaliată...">Bună ziua,

Mulțumesc pentru interesul acordat serviciilor mele de dezvoltare web.

După analizarea cerințelor dumneavoastră, vă propun următoarea ofertă:

🔸 Preț: [PRET] EUR
🔸 Termen de livrare: [TERMEN]
🔸 Include: [DETALII SERVICII]

Rămân la dispoziția dumneavoastră pentru orice clarificări.

Cu stimă,
Nyikora Noldi
Freelancer IT - Conectica IT
Tel: 0740173581
Email: conectica.it.ro@gmail.com</textarea>
            </div>
            
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button type="button" onclick="previewResponse()" style="padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-eye"></i> Preview
                </button>
                <button type="button" onclick="closeResponseModal()" style="padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                    Anulează
                </button>
                <button type="submit" style="padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-paper-plane"></i> Trimite Oferta
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let quotes = [
    {id: 1, company: 'TechStartup SRL', contact: 'Alexandru Popescu', status: 'new', budget: '5,000 - 8,000 EUR'},
    {id: 2, company: 'E-Fashion Store', contact: 'Maria Georgescu', status: 'in_review', budget: '3,000 - 5,000 EUR'},
    {id: 3, company: 'Business Solutions', contact: 'Ionuț Marin', status: 'responded', budget: '2,000 - 3,000 EUR'}
];

function viewQuoteDetails(id) {
    const quoteDetails = {
        1: {
            title: 'TechStartup SRL - Platformă Management Proiecte',
            content: `
                <div style="display: grid; gap: 25px;">
                    <div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 12px;">
                        <h3 style="margin-bottom: 15px; color: #667eea;">Informații Client</h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div><strong>Companie:</strong> TechStartup SRL</div>
                            <div><strong>Persoană Contact:</strong> Alexandru Popescu</div>
                            <div><strong>Email:</strong> alex.popescu@techstartup.ro</div>
                            <div><strong>Telefon:</strong> 0721 456 789</div>
                            <div><strong>Website:</strong> www.techstartup.ro</div>
                            <div><strong>Poziție:</strong> CTO</div>
                        </div>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 12px;">
                        <h3 style="margin-bottom: 15px; color: #667eea;">Detalii Proiect</h3>
                        <div style="margin-bottom: 20px;">
                            <strong>Descriere Detaliată:</strong><br>
                            Aplicația trebuie să fie o platformă completă de management proiecte pentru echipele interne:
                            
                            <ul style="margin: 10px 0 10px 20px;">
                                <li>Dashboard central cu overview proiecte</li>
                                <li>Sistem de task-uri cu priorități și assignare</li>
                                <li>Timeline și Gantt charts</li>
                                <li>Colaborare în timp real (chat, comentarii)</li>
                                <li>Gestiunea documentelor și file sharing</li>
                                <li>Raportare automată și metrici performanță</li>
                                <li>Integrări: Google Calendar, Slack, email</li>
                                <li>Aplicație mobilă complementară (opțional)</li>
                            </ul>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div><strong>Buget:</strong> 5,000 - 8,000 EUR</div>
                            <div><strong>Termen:</strong> 2-3 luni</div>
                            <div><strong>Numărul utilizatori:</strong> 20-50</div>
                            <div><strong>Hosting:</strong> Cloud (AWS/DigitalOcean)</div>
                        </div>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 12px;">
                        <h3 style="margin-bottom: 15px; color: #667eea;">Cerințe Tehnice</h3>
                        <div><strong>Backend:</strong> PHP 8+ sau Node.js</div>
                        <div><strong>Frontend:</strong> Vue.js sau React</div>
                        <div><strong>Baza de date:</strong> MySQL sau PostgreSQL</div>
                        <div><strong>Autentificare:</strong> JWT, 2FA opțional</div>
                        <div><strong>API:</strong> RESTful, documentație Swagger</div>
                        <div><strong>Design:</strong> Modern, responsive, dark/light mode</div>
                    </div>
                </div>
            `
        },
        2: {
            title: 'E-Fashion Store - Magazin Online Fashion',
            content: `Detalii complete pentru magazinul online fashion...`
        },
        3: {
            title: 'Business Solutions - Website Corporate',
            content: `Detalii complete pentru website-ul corporate...`
        }
    };
    
    const modal = document.getElementById('quoteModal');
    document.getElementById('modalTitle').textContent = quoteDetails[id].title;
    document.getElementById('modalContent').innerHTML = quoteDetails[id].content;
    modal.style.display = 'block';
}

function respondToQuote(id) {
    document.getElementById('responseModal').style.display = 'block';
    
    // Pre-fill some data based on quote
    const prices = {1: 6500, 2: 4000, 3: 2400};
    const deadlines = {1: '10 săptămâni', 2: '6 săptămâni', 3: '3 săptămâni'};
    
    document.getElementById('quotePrice').value = prices[id] || '';
    document.getElementById('quoteDeadline').value = deadlines[id] || '';
}

function createProposal(id) {
    alert('Se va genera un document PDF cu propunerea detaliată pentru client.');
}

function updateQuoteStatus(id, newStatus) {
    const statusBadge = event.target.parentElement.querySelector('.status-badge');
    const quoteItem = event.target.closest('.quote-item');
    
    // Update status badge
    const statusConfig = {
        'new': {text: 'Nou', color: '#667eea', bg: 'rgba(102, 126, 234, 0.2)'},
        'in_review': {text: 'În Evaluare', color: '#fbbf24', bg: 'rgba(251, 191, 36, 0.2)'},
        'responded': {text: 'Răspuns Trimis', color: '#22c55e', bg: 'rgba(34, 197, 94, 0.2)'},
        'accepted': {text: 'Acceptat', color: '#22c55e', bg: 'rgba(34, 197, 94, 0.2)'},
        'rejected': {text: 'Respins', color: '#ef4444', bg: 'rgba(239, 68, 68, 0.2)'}
    };
    
    const config = statusConfig[newStatus];
    statusBadge.textContent = config.text;
    statusBadge.style.color = config.color;
    statusBadge.style.background = config.bg;
    
    quoteItem.setAttribute('data-status', newStatus);
    
    alert(`Status-ul cererii a fost actualizat la: ${config.text}`);
}

function deleteQuote(id) {
    if (confirm('Sigur vrei să ștergi această cerere de ofertă? Acțiunea nu poate fi anulată.')) {
        const quoteItems = document.querySelectorAll('.quote-item');
        if (quoteItems[id - 1]) {
            quoteItems[id - 1].remove();
            alert('Cererea a fost ștersă cu succes!');
            updateQuoteCount();
        }
    }
}

function followUpQuote(id) {
    alert('Se va deschide clientul de email pentru trimiterea unui mesaj de follow-up.');
}

function duplicateQuote(id) {
    alert('Template-ul acestei oferte va fi salvat pentru utilizare viitoare.');
}

function exportQuotes() {
    alert('Se va genera un fișier Excel cu toate cererile de ofertă.');
}

function closeQuoteModal() {
    document.getElementById('quoteModal').style.display = 'none';
}

function closeResponseModal() {
    document.getElementById('responseModal').style.display = 'none';
}

function previewResponse() {
    const price = document.getElementById('quotePrice').value;
    const deadline = document.getElementById('quoteDeadline').value;
    const message = document.getElementById('quoteMessage').value;
    
    const previewWindow = window.open('', '_blank', 'width=600,height=800');
    previewWindow.document.write(`
        <html>
        <head><title>Preview Ofertă</title></head>
        <body style="font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5;">
            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <h2>Preview Ofertă</h2>
                <p><strong>Preț:</strong> ${price} EUR</p>
                <p><strong>Termen:</strong> ${deadline}</p>
                <hr style="margin: 20px 0;">
                <div style="white-space: pre-line;">${message.replace(/\[PRET\]/g, price).replace(/\[TERMEN\]/g, deadline)}</div>
            </div>
        </body>
        </html>
    `);
}

function updateQuoteCount() {
    const newQuotes = document.querySelectorAll('[data-status="new"]').length;
    document.getElementById('quoteCount').textContent = `${newQuotes} cereri noi`;
}

// Form submission
document.getElementById('responseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Se trimite...';
    submitBtn.disabled = true;
    
    // Simulate sending email
    setTimeout(() => {
        alert('Oferta a fost trimisă cu succes la client!');
        closeResponseModal();
        
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 2000);
});

// Filter quotes
document.getElementById('filterQuotes').addEventListener('change', function(e) {
    const filterValue = e.target.value;
    const quotes = document.querySelectorAll('.quote-item');
    
    quotes.forEach(quote => {
        const status = quote.getAttribute('data-status');
        
        if (filterValue === 'all' || status === filterValue) {
            quote.style.display = 'block';
        } else {
            quote.style.display = 'none';
        }
    });
});

// Close modals when clicking outside
document.getElementById('quoteModal').addEventListener('click', function(e) {
    if (e.target === this) closeQuoteModal();
});

document.getElementById('responseModal').addEventListener('click', function(e) {
    if (e.target === this) closeResponseModal();
});
</script>
