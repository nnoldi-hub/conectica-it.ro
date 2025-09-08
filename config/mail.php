<?php
// Mail configuration (default for production). Override safely in mail.local.php (ignored by git)

// Defaults (Hostico)
if (!defined('SMTP_HOST')) define('SMTP_HOST', 'mail.conectica-it.ro');
if (!defined('SMTP_PORT')) define('SMTP_PORT', 465); // SMTPS
if (!defined('SMTP_SECURE')) define('SMTP_SECURE', 'ssl'); // 'ssl' for 465, 'tls' for 587
if (!defined('SMTP_USER')) define('SMTP_USER', 'noutati@conectica-it.ro');
// DO NOT COMMIT PASSWORDS. Put real password in mail.local.php on server.
if (!defined('SMTP_PASS')) define('SMTP_PASS', '');

if (!defined('MAIL_FROM')) define('MAIL_FROM', 'noutati@conectica-it.ro');
if (!defined('MAIL_FROM_NAME')) define('MAIL_FROM_NAME', 'Conectica‑IT Noutăți');

// Simple admin token to protect newsletter sender script when accessed via web
if (!defined('NEWSLETTER_ADMIN_TOKEN')) define('NEWSLETTER_ADMIN_TOKEN', '');

// Local overrides (not committed). Create config/mail.local.php with real credentials.
if (file_exists(__DIR__ . '/mail.local.php')) {
    require_once __DIR__ . '/mail.local.php';
}
?>