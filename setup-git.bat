@echo off
echo ================================
echo  Conectica IT - Git Setup
echo ================================
echo.

REM Check if Git is installed
git --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Git nu este instalat sau nu este în PATH.
    echo Te rog instalează Git de la: https://git-scm.com/
    pause
    exit /b 1
)

echo Git detectat! Inițializez repository-ul...
echo.

REM Initialize Git repository
git init

REM Add all files respecting .gitignore
echo Adaug fișierele la repository...
git add .

REM Create initial commit
echo Creez primul commit...
git commit -m "🚀 Initial commit - Conectica IT Portfolio

✨ Features:
- Complete responsive portfolio website
- Advanced admin dashboard with sidebar navigation
- Content management system with CRUD operations
- Project portfolio manager with image upload
- Message system with filtering and responses  
- Quote request management system
- Blog management interface
- Enhanced security with AuthSystem
- CSRF protection and session management
- Rate limiting and attack prevention
- Comprehensive logging system
- Production-ready configuration

🔧 Technical Stack:
- PHP 8.3+ with modern security practices
- MySQL database with optimized schema
- Bootstrap 5.3.3 responsive framework
- Font Awesome 6.4.0 icons
- Vanilla JavaScript for interactions
- Apache/Nginx web server support

🛡️ Security Features:
- Advanced authentication system
- CSRF token protection  
- XSS and SQL injection prevention
- Security headers and CSP
- Rate limiting and bot protection
- Audit logging and monitoring

📦 Ready for deployment with complete documentation"

echo.
echo ================================
echo  Repository inițializat cu succes!
echo ================================
echo.
echo Pașii următori:
echo 1. Creează un repository nou pe GitHub/GitLab
echo 2. Adaugă remote URL:
echo    git remote add origin https://github.com/username/repository.git
echo 3. Push la repository:
echo    git push -u origin main
echo.
echo Pentru a vedea status-ul:
echo    git status
echo.
echo Pentru a vedea commit-urile:
echo    git log --oneline
echo.

pause
