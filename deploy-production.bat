@echo off
setlocal EnableDelayedExpansion

echo =====================================
echo   Conectica IT - Production Deploy
echo =====================================
echo.

REM Colors for better visibility (if supported)
set "GREEN=echo."
set "RED=echo ERROR:"
set "YELLOW=echo WARNING:"
set "BLUE=echo INFO:"

%BLUE% Checking production deployment prerequisites...
echo.

REM Check if we're in the right directory
if not exist "admin\dashboard.php" (
    %RED% Nu sunt în directorul corect al proiectului!
    %RED% Te rog rulează scriptul din directorul root al Conectica IT Portfolio.
    pause
    exit /b 1
)

REM Security checklist
echo ============= SECURITY CHECKLIST =============
echo.
echo 🔐 IMPORTANT: Verifică următoarele înainte de deploy:
echo.
echo [ ] 1. Ai schimbat credențialele admin din 'admin/demo123'?
echo [ ] 2. Ai configurat database-ul de producție în config/config.php?
echo [ ] 3. Ai activat HTTPS/SSL pe server?
echo [ ] 4. Ai configurat SMTP pentru email-uri?
echo [ ] 5. Ai setat permisiunile corecte pentru directoare? (755/644)
echo [ ] 6. Ai testat backup-ul bazei de date?
echo [ ] 7. Ai configurat fail2ban sau similar pentru protecție?
echo.

set /p "continue=Ai verificat toate punctele de mai sus? (Y/N): "
if /i not "!continue!"=="Y" (
    %YELLOW% Te rog verifică toate punctele de securitate înainte de deploy.
    pause
    exit /b 1
)

echo.
%GREEN% Proceeding with deployment preparation...
echo.

REM Create production directories if they don't exist
%BLUE% Creating production directories...
if not exist "logs" mkdir logs
if not exist "uploads" mkdir uploads
if not exist "cache" mkdir cache
if not exist "backups" mkdir backups

REM Set proper permissions reminder
echo.
%YELLOW% REMINDER: După upload pe server, execută:
echo     chmod 755 logs/ uploads/ cache/ backups/
echo     chmod 644 config/config.php
echo     chmod 644 .htaccess
echo.

REM Check critical files
%BLUE% Checking critical files...
set "missing_files="

if not exist "config\config.php" (
    set "missing_files=!missing_files! config/config.php"
)
if not exist "config\database.php" (
    set "missing_files=!missing_files! config/database.php"  
)
if not exist "install.sql" (
    set "missing_files=!missing_files! install.sql"
)
if not exist "admin\AuthSystem.php" (
    set "missing_files=!missing_files! admin/AuthSystem.php"
)

if not "!missing_files!"=="" (
    %RED% Lipsesc fișiere critice: !missing_files!
    pause
    exit /b 1
)

REM Create deployment checklist file
%BLUE% Creating deployment checklist...
(
echo # Conectica IT - Production Deployment Checklist
echo.
echo ## Pre-Deployment
echo - [ ] Backup current site (if updating^)
echo - [ ] Backup database
echo - [ ] Test all functionality locally
echo - [ ] Update config/config.php with production settings
echo - [ ] Change admin credentials from demo
echo - [ ] Verify SSL certificate is valid
echo.
echo ## Server Configuration  
echo - [ ] PHP 8.0+ installed
echo - [ ] MySQL 5.7+ configured
echo - [ ] Web server (Apache/Nginx^) configured
echo - [ ] Required PHP extensions enabled
echo - [ ] Upload limits configured (10MB+^)
echo.
echo ## File Deployment
echo - [ ] Upload all files except logs/, cache/, config/config.php
echo - [ ] Set file permissions: 755 for directories, 644 for files
echo - [ ] Upload and configure config/config.php separately
echo - [ ] Ensure .htaccess is working (test URL rewriting^)
echo.
echo ## Database Setup
echo - [ ] Create production database
echo - [ ] Import install.sql
echo - [ ] Create database user with appropriate permissions
echo - [ ] Test database connection
echo.
echo ## Security Verification
echo - [ ] Test admin login works
echo - [ ] Verify HTTPS redirects properly
echo - [ ] Check security headers (use securityheaders.com^)
echo - [ ] Test CSRF protection
echo - [ ] Verify rate limiting works
echo - [ ] Check log files are being created
echo.
echo ## Functionality Testing
echo - [ ] Homepage loads correctly
echo - [ ] All pages accessible
echo - [ ] Contact form sends emails
echo - [ ] Admin dashboard fully functional
echo - [ ] File uploads work in admin
echo - [ ] Project management works
echo - [ ] Message system operational
echo - [ ] Quote system functional
echo.
echo ## Post-Deployment
echo - [ ] Configure monitoring/alerts
echo - [ ] Set up automated backups
echo - [ ] Configure log rotation
echo - [ ] Test site performance
echo - [ ] Submit sitemap to search engines
echo - [ ] Update DNS if needed
echo.
echo ## Emergency Contacts
echo Developer: Nyikora Noldi
echo Email: conectica.it.ro@gmail.com  
echo Phone: 0740173581
) > "DEPLOYMENT-CHECKLIST.md"

REM Create production configuration reminder
%BLUE% Creating production config reminder...
(
echo ^<?php
echo // PRODUCTION CONFIG TEMPLATE - Copy to config/config.php
echo.
echo // Database Configuration
echo define^('DB_HOST', 'localhost'^);
echo define^('DB_NAME', 'conectica_portfolio'^);  
echo define^('DB_USER', 'your_db_username'^);
echo define^('DB_PASS', 'your_secure_db_password'^);
echo.
echo // Site Configuration
echo define^('SITE_URL', 'https://yourdomain.com'^);
echo define^('ADMIN_URL', 'https://yourdomain.com/admin'^);
echo define^('ENVIRONMENT', 'production'^);
echo.
echo // Email Configuration
echo define^('SMTP_HOST', 'smtp.yourdomain.com'^);
echo define^('SMTP_USERNAME', 'noreply@yourdomain.com'^);
echo define^('SMTP_PASSWORD', 'your_email_password'^);
echo.
echo // Security
echo define^('SECURE_COOKIES', true^);
echo define^('FORCE_HTTPS', true^);
echo ?^>
) > "config-production-template.php"

echo.
%GREEN% ===== DEPLOYMENT READY! =====
echo.
%BLUE% Files created:
echo   ✓ DEPLOYMENT-CHECKLIST.md
echo   ✓ config-production-template.php  
echo   ✓ logs/ directory
echo   ✓ uploads/ directory
echo   ✓ cache/ directory
echo   ✓ backups/ directory
echo.

%YELLOW% NEXT STEPS:
echo 1. Review DEPLOYMENT-CHECKLIST.md
echo 2. Upload files to production server
echo 3. Configure production database
echo 4. Update config/config.php with production values
echo 5. Test all functionality
echo 6. Go live! 🚀
echo.

%GREEN% Good luck with your deployment!
echo For support contact: conectica.it.ro@gmail.com
echo.

pause
