# Conectica IT - Professional Portfolio

🌐 **Professional freelancer portfolio pentru Nyikora Noldi**  
📧 conectica.it.ro@gmail.com | 📱 0740173581

## 🚀 Auto-Deployment Setup (LIVE!)

### ✅ Deployment-ul este acum COMPLET AUTOMAT!

**Cum funcționează:**
1. **Faci modificări local** în VS Code sau orice editor
2. **Salvezi și commit-ui**: `git add . && git commit -m "Message"`
3. **Push la GitHub**: `git push origin main` 
4. **Hostico deployment automat** → **Site-ul se actualizează în 2-3 minute!**

### 🎯 Comenzi Rapide pentru Deployment:

#### Windows (PowerShell):
```powershell
# Deployment rapid cu scriptul
.\deploy.ps1

# Sau manual
git add .
git commit -m "Descrierea modificărilor"
git push origin main
```

#### Linux/Mac (Bash):
```bash
# Deployment rapid cu scriptul
./deploy.sh

# Sau manual
git add .
git commit -m "Descrierea modificărilor"  
git push origin main
```

### 🔧 Configurare Completă:

- **Database**: `ylcqhxpa_conectica` (CONFIGURATĂ ✅)
- **Repository**: `https://github.com/nnoldi-hub/conectica-it.ro` (CONECTAT ✅)
- **Auto-Deployment**: `.cpanel.yml` (FUNCȚIONAL ✅)
- **Admin Panel**: `/admin/` (OPERAȚIONAL ✅)

### 🌐 Link-uri Live:
- **Website Principal**: https://conectica-it.ro
- **Admin Panel**: https://conectica-it.ro/admin/
- **Debug Page**: https://conectica-it.ro/test.php

## �📋 Descrierea Proiectului

Portofoliu profesional pentru servicii IT și dezvoltare web, cu sistem complet de administrare și gestionare a conținutului.

## ✨ Funcționalități

### Frontend
- **Design Modern**: Glassmorphism effects cu animații fluide
- **Responsive**: Optimizat pentru toate dispozitivele
- **Secțiuni Principale**:
  - 🏠 Homepage cu hero section
  - 👨‍💻 Despre mine și experiență
  - 🛠️ Servicii oferite
  - 💼 Portofoliu proiecte
  - 📝 Blog articole
  - 📞 Contact și formulare

### Backend Admin Panel
- **Dashboard Complet**: Statistici și management centralizat
- **Editor Conținut**: Editare live a textelor și serviciilor
- **Manager Proiecte**: CRUD complet cu imagini
- **Sistem Mesaje**: Vizualizare și răspuns la contacte
- **Gestionare Cereri**: Management oferte și quotes
- **Blog Manager**: Editare articole și categorii

### Securitate Avansată
- **Autentificare Robustă**: Session management cu CSRF protection
- **Rate Limiting**: Protecție împotriva brute force
- **Security Headers**: CSP, XSS protection, clickjacking prevention
- **Logging System**: Monitorizare activitate și evenimente de securitate
- **Input Validation**: Validare și sanitizare date

## � Instalare și Setup

### Cerințe
- PHP 8.0+
- MySQL 5.7+
- Web Server (Apache/Nginx)
- SSL Certificate (recomandat)

### 1. Clonare Repository
```bash
git clone <repository-url> conectica-portfolio
cd conectica-portfolio
```

### 2. Configurare Database
```sql
-- Execută install.sql pentru structura de bază
mysql -u username -p database_name < install.sql
```

### 3. Configurare Environment
```bash
# Copiază și editează configurația
cp config/config.prod.php config/config.php

# Editează setările de bază de date și securitate
nano config/config.php
```

## � Credențiale Demo

**Admin Panel**: `/admin/`
- **Username**: `admin`
- **Password**: `demo123`

> ⚠️ **IMPORTANT**: Schimbă credențialele în producție!

1. **Clonează proiectul în directorul web**
   ```bash
   git clone [url-repo] /path/to/webroot/conectica-it-pro-portfolio
   ```

2. **Configurează baza de date**
   - Creează o bază de date MySQL
   - Importă fișierul `install.sql`
   - Actualizează `config/database.php` cu datele de conexiune

3. **Configurează setările**
   - Editează `config/config.php` cu informațiile tale
   - Actualizează datele de contact și URL-ul site-ului

4. **Setări server**
   - Asigură-te că mod_rewrite este activat
   - Configurează virtual host sau folosește XAMPP/WAMP

## 📁 Structura Proiectului

```
conectica-it-pro-portfolio/
├── index.php              # Pagina principală
├── projects.php           # Portofoliul de proiecte  
├── blog.php              # Blog cu articole IT
├── contact.php           # Pagina de contact
├── request-quote.php     # Formular pentru oferte
├── install.sql           # Schema bazei de date
├── admin/                # Panou de administrare
│   ├── login.php        # Autentificare admin
│   ├── dashboard.php    # Dashboard principal
│   └── logout.php       # Deconectare
├── assets/              # Resurse statice
│   └── css/
│       └── style.css    # CSS personalizat
├── config/              # Configurări
│   ├── config.php       # Setări generale
│   └── database.php     # Conexiunea la DB
└── includes/            # Template-uri
    ├── head.php         # Header HTML
    └── foot.php         # Footer HTML
```

## 🎨 Personalizare

### Modificarea Informațiilor Personale

Editează `config/config.php`:
```php
define('SITE_NAME','Numele Tău - Titlu Profesional');
define('BASE_URL','https://domeniul-tau.ro');
define('CONTACT_EMAIL', 'email@domeniu.ro');
define('CONTACT_PHONE', '07XX XXX XXX');
define('WEBSITE_URL', 'domeniul-tau.ro');
```

### Actualizarea Culorilor și Stilurilor

Modifică variabilele CSS din `assets/css/style.css`:
```css
:root {
    --primary-color: #0066cc;    /* Culoarea principală */
    --secondary-color: #28a745;  /* Culoarea secundară */
    --accent-color: #17a2b8;     /* Culoarea accent */
    --dark-bg: #0b0f17;          /* Background întunecat */
    --text-light: #e8eef7;       /* Text pe fundal întunecat */
}
```

## 🔐 Panou de Administrare

### Acces Demo
- **URL**: `/admin/login.php`
- **Utilizator**: `admin`
- **Parolă**: `demo123`

### Funcționalități Admin
- Dashboard cu statistici
- Gestionarea proiectelor
- Editarea articolelor blog
- Vizualizarea mesajelor
- Setări site

> **Important**: În producție, schimbă credențialele și implementează un sistem de securitate robust cu hash-uri pentru parole și validare CSRF.

## 🚀 Deployment

### Pentru dezvoltare locală (XAMPP/WAMP):
1. Copiază proiectul în `htdocs` sau `www`
2. Accesează `http://localhost/conectica-it-pro-portfolio`

### Pentru server live:
1. Upload prin FTP/SFTP
2. Configurează baza de date
3. Actualizează permisiunile fișierelor
4. Configurează certificatul SSL

## 🔧 Dezvoltare Viitoare

### Funcționalități planificate:
- [ ] Sistem complet de CMS pentru proiecte
- [ ] API REST pentru integrări externe  
- [ ] Newsletter cu MailChimp/SendGrid
- [ ] Sistem de comentarii pentru blog
- [ ] Analytics și rapoarte
- [ ] Integrare cu social media
- [ ] Optimizări SEO avansate
- [ ] PWA capabilities

### Îmbunătățiri tehnice:
- [ ] Migrare la PHP 8+
- [ ] Implementare design patterns (MVC)
- [ ] Unit testing cu PHPUnit
- [ ] CI/CD pipeline
- [ ] Docker containerization
- [ ] Cache management (Redis/Memcached)

## 🤝 Contribuții

Proiectul este open pentru îmbunătățiri! Pentru contribuții:

1. Fork repository-ul
2. Creează un branch pentru feature (`git checkout -b feature/AmazingFeature`)
3. Commit schimbările (`git commit -m 'Add some AmazingFeature'`)
4. Push pe branch (`git push origin feature/AmazingFeature`)
5. Deschide un Pull Request

## 📞 Contact & Support

**Nyikora Noldi**
- Email: conectica.it.ro@gmail.com
- Telefon: 0740173581
- Website: conectica-it.ro

Pentru bug-uri și feature requests, folosește GitHub Issues.

## 📄 Licență

Acest proiect este licențiat sub MIT License - vezi fișierul [LICENSE.md](LICENSE.md) pentru detalii.

---

**Dezvoltat cu ❤️ în România** 🇷🇴

*Powered by PHP, MySQL, Bootstrap 5, Font Awesome & vanilla JavaScript*
