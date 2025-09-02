<?php
// Messages Page
?>

<div class="content-header">
    <h1 class="content-title">Mesaje Primite</h1>
    <p class="content-subtitle">Vizualizează și gestionează mesajele primite prin formularul de contact</p>
</div>

<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; gap: 15px;">
        <select id="filterMessages" style="padding: 10px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white;">
            <option value="all">Toate Mesajele</option>
            <option value="unread">Necitite</option>
            <option value="read">Citite</option>
            <option value="important">Importante</option>
        </select>
        <button onclick="markAllAsRead()" style="padding: 10px 20px; background: rgba(102,126,234,0.3); border: 1px solid rgba(102,126,234,0.5); border-radius: 6px; color: white; cursor: pointer;">
            <i class="fas fa-check-double"></i> Marchează toate ca citite
        </button>
    </div>
    <div style="color: rgba(255,255,255,0.8);">
        <span id="messageCount">3 mesaje noi</span>
    </div>
</div>

<!-- Messages List -->
<div style="display: grid; gap: 20px;">
    <!-- Message 1 - Unread -->
    <div class="card message-item" data-status="unread" style="position: relative; border-left: 4px solid #667eea;">
        <div style="position: absolute; top: 15px; right: 15px; display: flex; gap: 10px;">
            <span class="status-badge" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; background: rgba(102, 126, 234, 0.2); color: #667eea;">Nou</span>
            <button onclick="toggleImportant(1)" style="background: none; border: none; color: rgba(255,255,255,0.5); cursor: pointer; font-size: 1.1rem;">
                <i class="far fa-star"></i>
            </button>
        </div>
        
        <div style="display: grid; grid-template-columns: auto 1fr; gap: 20px;">
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 600;">
                A
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <h3 style="margin-bottom: 5px; font-size: 1.2rem;">Ana Maria Popescu</h3>
                        <div style="display: flex; gap: 15px; font-size: 0.9rem; opacity: 0.8;">
                            <span><i class="fas fa-envelope"></i> ana.maria@email.com</span>
                            <span><i class="fas fa-phone"></i> 0721 234 567</span>
                            <span><i class="fas fa-clock"></i> Acum 2 ore</span>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #667eea;">Subiect:</strong> Cerere dezvoltare site web pentru afacere
                </div>
                <div style="line-height: 1.6; margin-bottom: 15px; max-height: 100px; overflow: hidden;">
                    Bună ziua, am o afacere mică în domeniul fashion și aș avea nevoie de un site web modern cu funcționalități e-commerce. Am văzut proiectele dumneavoastră și sunt impresionată de calitate. Aș dori să discutăm despre posibilitatea unei colaborări...
                </div>
                <div style="display: flex; gap: 10px;">
                    <button onclick="readMessage(1)" style="padding: 8px 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-eye"></i> Citește complet
                    </button>
                    <button onclick="replyMessage(1)" style="padding: 8px 15px; background: rgba(34, 197, 94, 0.3); border: 1px solid rgba(34, 197, 94, 0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-reply"></i> Răspunde
                    </button>
                    <button onclick="deleteMessage(1)" style="padding: 8px 15px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-trash"></i> Șterge
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Message 2 - Unread -->
    <div class="card message-item" data-status="unread" style="position: relative; border-left: 4px solid #667eea;">
        <div style="position: absolute; top: 15px; right: 15px; display: flex; gap: 10px;">
            <span class="status-badge" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; background: rgba(102, 126, 234, 0.2); color: #667eea;">Nou</span>
            <button onclick="toggleImportant(2)" style="background: none; border: none; color: rgba(255,255,255,0.5); cursor: pointer; font-size: 1.1rem;">
                <i class="far fa-star"></i>
            </button>
        </div>
        
        <div style="display: grid; grid-template-columns: auto 1fr; gap: 20px;">
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 600;">
                I
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <h3 style="margin-bottom: 5px; font-size: 1.2rem;">Ionuț Georgescu</h3>
                        <div style="display: flex; gap: 15px; font-size: 0.9rem; opacity: 0.8;">
                            <span><i class="fas fa-envelope"></i> ionut.geo@company.ro</span>
                            <span><i class="fas fa-phone"></i> 0734 567 890</span>
                            <span><i class="fas fa-clock"></i> Ieri</span>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #667eea;">Subiect:</strong> Întrebare despre servicii hosting și mentenanță
                </div>
                <div style="line-height: 1.6; margin-bottom: 15px; max-height: 100px; overflow: hidden;">
                    Salut! Am un site web dezvoltat în WordPress și am nevoie de servicii de hosting și mentenanță lunară. Oferiți și astfel de servicii sau vă ocupați doar de dezvoltare? Mulțumesc pentru răspuns!
                </div>
                <div style="display: flex; gap: 10px;">
                    <button onclick="readMessage(2)" style="padding: 8px 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-eye"></i> Citește complet
                    </button>
                    <button onclick="replyMessage(2)" style="padding: 8px 15px; background: rgba(34, 197, 94, 0.3); border: 1px solid rgba(34, 197, 94, 0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-reply"></i> Răspunde
                    </button>
                    <button onclick="deleteMessage(2)" style="padding: 8px 15px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-trash"></i> Șterge
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Message 3 - Read -->
    <div class="card message-item" data-status="read" style="position: relative; border-left: 4px solid rgba(255,255,255,0.2); opacity: 0.8;">
        <div style="position: absolute; top: 15px; right: 15px; display: flex; gap: 10px;">
            <span class="status-badge" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; background: rgba(34, 197, 94, 0.2); color: #22c55e;">Citit</span>
            <button onclick="toggleImportant(3)" style="background: none; border: none; color: #fbbf24; cursor: pointer; font-size: 1.1rem;">
                <i class="fas fa-star"></i>
            </button>
        </div>
        
        <div style="display: grid; grid-template-columns: auto 1fr; gap: 20px;">
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 600;">
                M
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <h3 style="margin-bottom: 5px; font-size: 1.2rem;">Maria Ionescu</h3>
                        <div style="display: flex; gap: 15px; font-size: 0.9rem; opacity: 0.8;">
                            <span><i class="fas fa-envelope"></i> maria.ionescu@business.ro</span>
                            <span><i class="fas fa-phone"></i> 0745 123 456</span>
                            <span><i class="fas fa-clock"></i> Acum 3 zile</span>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #667eea;">Subiect:</strong> Mulțumiri pentru proiectul finalizat - recomanări
                </div>
                <div style="line-height: 1.6; margin-bottom: 15px; max-height: 100px; overflow: hidden;">
                    Mulțumesc din nou pentru munca excelentă la site-ul companiei noastre! Suntem foarte mulțumiți de rezultat și de profesionalismul echipei. Voi recomanda cu siguranță serviciile dumneavoastră...
                </div>
                <div style="display: flex; gap: 10px;">
                    <button onclick="readMessage(3)" style="padding: 8px 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-eye"></i> Citește complet
                    </button>
                    <button onclick="replyMessage(3)" style="padding: 8px 15px; background: rgba(34, 197, 94, 0.3); border: 1px solid rgba(34, 197, 94, 0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-reply"></i> Răspunde
                    </button>
                    <button onclick="deleteMessage(3)" style="padding: 8px 15px; background: rgba(255,69,69,0.3); border: 1px solid rgba(255,69,69,0.5); border-radius: 6px; color: white; cursor: pointer;">
                        <i class="fas fa-trash"></i> Șterge
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Message Detail Modal -->
<div id="messageModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 2000; padding: 20px; overflow-y: auto;">
    <div style="max-width: 800px; margin: 0 auto; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); border-radius: 15px; padding: 30px; position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 id="modalSubject" style="color: white;">Subiect mesaj</h2>
            <button onclick="closeMessageModal()" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; padding: 5px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div id="modalContent" style="color: white; line-height: 1.6;">
            <!-- Message content will be loaded here -->
        </div>
        
        <div style="margin-top: 30px; display: flex; gap: 15px;">
            <button onclick="replyFromModal()" style="padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                <i class="fas fa-reply"></i> Răspunde
            </button>
            <button onclick="closeMessageModal()" style="padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; font-weight: 600; cursor: pointer;">
                Închide
            </button>
        </div>
    </div>
</div>

<script>
let messages = [
    {id: 1, sender: 'Ana Maria Popescu', email: 'ana.maria@email.com', subject: 'Cerere dezvoltare site web pentru afacere', status: 'unread', important: false},
    {id: 2, sender: 'Ionuț Georgescu', email: 'ionut.geo@company.ro', subject: 'Întrebare despre servicii hosting și mentenanță', status: 'unread', important: false},
    {id: 3, sender: 'Maria Ionescu', email: 'maria.ionescu@business.ro', subject: 'Mulțumiri pentru proiectul finalizat', status: 'read', important: true}
];

function readMessage(id) {
    // Mark as read
    const messageCard = document.querySelector(`[data-status="unread"] .message-item:nth-child(${id})`);
    
    // Show full message content
    const messageData = {
        1: {
            subject: 'Cerere dezvoltare site web pentru afacere',
            content: `Bună ziua,

Am o afacere mică în domeniul fashion și aș avea nevoie de un site web modern cu funcționalități e-commerce. Am văzut proiectele dumneavoastră și sunt impresionată de calitate.

Aș dori să discutăm despre:
- Design modern și responsive
- Sistem de plăți online
- Catalog de produse cu filtrare
- Panou de administrare
- Integrare cu rețele sociale

Bugetul meu este flexibil pentru un proiect de calitate. Aștept cu nerăbdare răspunsul dumneavoastră.

Cu stimă,
Ana Maria Popescu
Fashion Boutique "Elegance"
Tel: 0721 234 567`
        },
        2: {
            subject: 'Întrebare despre servicii hosting și mentenanță',
            content: `Salut!

Am un site web dezvoltat în WordPress și am nevoie de servicii de hosting și mentenanță lunară. 

Oferiți și astfel de servicii sau vă ocupați doar de dezvoltare?

Site-ul are trafic mediu (aprox. 1000 vizitatori/lună) și ar avea nevoie de:
- Backup-uri regulate
- Actualizări de securitate
- Optimizare performanță
- Suport tehnic

Mulțumesc pentru răspuns!

Ionuț Georgescu
IT Manager @ TechCompany SRL`
        },
        3: {
            subject: 'Mulțumiri pentru proiectul finalizat - recomanări',
            content: `Dragă echipă,

Mulțumesc din nou pentru munca excelentă la site-ul companiei noastre! 

Suntem foarte mulțumiți de:
✓ Calitatea codului și designului
✓ Respectarea termenelor
✓ Comunicarea excelentă pe tot parcursul proiectului
✓ Suportul post-lansare

Voi recomanda cu siguranță serviciile dumneavoastră partenerilor de afaceri și prietenilor care au nevoie de dezvoltare web.

Sper să colaborăm din nou în viitor!

Cu recunoștință,
Maria Ionescu
CEO @ Business Solutions SRL`
        }
    };
    
    const modal = document.getElementById('messageModal');
    document.getElementById('modalSubject').textContent = messageData[id].subject;
    document.getElementById('modalContent').innerHTML = '<pre style="white-space: pre-wrap; font-family: inherit;">' + messageData[id].content + '</pre>';
    modal.style.display = 'block';
}

function closeMessageModal() {
    document.getElementById('messageModal').style.display = 'none';
}

function replyMessage(id) {
    alert('Funcția de răspuns va fi implementată pentru a deschide clientul de email cu răspunsul pre-completat.');
}

function replyFromModal() {
    alert('Funcția de răspuns va fi implementată pentru a deschide clientul de email cu răspunsul pre-completat.');
    closeMessageModal();
}

function deleteMessage(id) {
    if (confirm('Sigur vrei să ștergi acest mesaj? Acțiunea nu poate fi anulată.')) {
        const messageItems = document.querySelectorAll('.message-item');
        if (messageItems[id - 1]) {
            messageItems[id - 1].remove();
            alert('Mesajul a fost șters cu succes!');
            updateMessageCount();
        }
    }
}

function toggleImportant(id) {
    const starBtn = event.target;
    const isImportant = starBtn.classList.contains('fas');
    
    if (isImportant) {
        starBtn.classList.remove('fas');
        starBtn.classList.add('far');
        starBtn.style.color = 'rgba(255,255,255,0.5)';
    } else {
        starBtn.classList.remove('far');
        starBtn.classList.add('fas');
        starBtn.style.color = '#fbbf24';
    }
}

function markAllAsRead() {
    const unreadMessages = document.querySelectorAll('[data-status="unread"]');
    unreadMessages.forEach(msg => {
        msg.setAttribute('data-status', 'read');
        msg.style.opacity = '0.8';
        msg.style.borderLeftColor = 'rgba(255,255,255,0.2)';
        
        const badge = msg.querySelector('.status-badge');
        badge.textContent = 'Citit';
        badge.style.background = 'rgba(34, 197, 94, 0.2)';
        badge.style.color = '#22c55e';
    });
    
    updateMessageCount();
    alert('Toate mesajele au fost marcate ca citite!');
}

function updateMessageCount() {
    const unreadCount = document.querySelectorAll('[data-status="unread"]').length;
    document.getElementById('messageCount').textContent = `${unreadCount} mesaje noi`;
}

// Filter messages
document.getElementById('filterMessages').addEventListener('change', function(e) {
    const filterValue = e.target.value;
    const messages = document.querySelectorAll('.message-item');
    
    messages.forEach(msg => {
        const status = msg.getAttribute('data-status');
        const isImportant = msg.querySelector('.fas.fa-star') !== null;
        
        let show = false;
        
        switch(filterValue) {
            case 'all':
                show = true;
                break;
            case 'unread':
                show = status === 'unread';
                break;
            case 'read':
                show = status === 'read';
                break;
            case 'important':
                show = isImportant;
                break;
        }
        
        msg.style.display = show ? 'block' : 'none';
    });
});

// Close modal when clicking outside
document.getElementById('messageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMessageModal();
    }
});
</script>
