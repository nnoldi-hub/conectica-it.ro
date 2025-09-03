# Manual Deployment Guide - Hostico

## Când auto-deployment se blochează (se învârte):

### Opțiunea 1: cPanel File Manager
1. Login la Hostico cPanel
2. **File Manager** → Navighează la `/home/ylcqhxpa/repositories/conectica-it.ro/`
3. **Select All** (Ctrl+A) → **Copy** (Ctrl+C)
4. **Navighează la** `/home/ylcqhxpa/public_html/`
5. **Paste** (Ctrl+V) → **Replace All**

### Opțiunea 2: Comanda SSH (dacă ai acces)
```bash
# Conectare SSH
ssh ylcqhxpa@conectica-it.ro

# Copy fișierele
cp -r /home/ylcqhxpa/repositories/conectica-it.ro/* /home/ylcqhxpa/public_html/
cp /home/ylcqhxpa/repositories/conectica-it.ro/.htaccess /home/ylcqhxpa/public_html/

# Setări permisiuni
chmod -R 755 /home/ylcqhxpa/public_html/
chmod 644 /home/ylcqhxpa/public_html/.htaccess
```

### Opțiunea 3: Reset Deployment
1. În cPanel → **Git Version Control**
2. Click pe **"Update from Remote"** să resetez
3. După aceea click **"Deploy HEAD Commit"**

## Fișierele importante de copiat:
- `index.php` (cu test comment-ul)
- `includes/head.php` (cu fix-ul pentru 500 error)  
- `test.php` (pentru debugging)
- `config/database.php`
- `.htaccess`

## Verificare după deployment:
- https://conectica-it.ro → Să vadă timestamp-ul nou
- https://conectica-it.ro/admin/ → Să funcționeze
- https://conectica-it.ro/test.php → Să arate "All OK"
