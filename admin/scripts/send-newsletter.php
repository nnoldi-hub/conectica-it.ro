<?php
// Simple Newsletter Sender (manual trigger)
// Protect with token defined in config/mail.php (NEWSLETTER_ADMIN_TOKEN)

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/mailer.php';
require_once __DIR__ . '/../../config/mail.php';

function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$token = $_GET['token'] ?? $_POST['token'] ?? '';
if (!NEWSLETTER_ADMIN_TOKEN) {
    http_response_code(500);
    echo '<p style="font-family:sans-serif">Configurați NEWSLETTER_ADMIN_TOKEN în config/mail.php</p>';
    exit;
}
if ($token !== NEWSLETTER_ADMIN_TOKEN) {
    http_response_code(403);
    echo '<p style="font-family:sans-serif">Acces restricționat</p>';
    exit;
}

$status = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $subject = trim($_POST['subject'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $dry = isset($_POST['dry_run']);

    if ($subject === '' || $body === '') {
        $status = 'Introduceți subiect și conținut.';
    } elseif (!($pdo instanceof PDO)) {
        $status = 'BD indisponibilă.';
    } else {
        // Ensure table exists
        $pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(190) NOT NULL UNIQUE,
            source VARCHAR(255) DEFAULT NULL,
            ip_address VARCHAR(45) DEFAULT NULL,
            user_agent VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            confirmed_at DATETIME DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $stmt = $pdo->query("SELECT email FROM newsletter_subscribers ORDER BY id ASC");
        $subs = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
        $sent = 0; $fail = 0; $skipped = 0;
        $mailer = new SimpleMailer();

        if (!$dry) {
            foreach ($subs as $i => $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $skipped++; continue; }
                $ok = false;
                try { $ok = $mailer->send($email, '', $subject, $body); } catch (Throwable $e) { $ok = false; }
                if ($ok) { $sent++; } else { $fail++; }
                // Soft throttle every 30 emails
                if (($i+1) % 30 === 0) { usleep(300000); }
            }
        }
        $status = 'Subscribers: ' . count($subs) . ' | Sent: ' . $sent . ' | Fail: ' . $fail . ' | Skipped: ' . $skipped . ($dry ? ' (dry-run, nimic trimis)' : '');
    }
}

?><!doctype html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Newsletter Sender</title>
    <style>body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;padding:20px;max-width:900px;margin:0 auto;color:#111;background:#f8f9fb}input,textarea{width:100%;padding:10px;border:1px solid #ccc;border-radius:8px}label{font-weight:600;margin-top:12px;display:block}button{background:#2563eb;color:#fff;border:none;padding:10px 16px;border-radius:8px;cursor:pointer}button:disabled{opacity:.6}.status{margin:10px 0;padding:10px;border-radius:8px;background:#eef} .row{display:grid;grid-template-columns:1fr;gap:12px}</style>
</head>
<body>
    <h1>Trimite Newsletter</h1>
    <p>From: <?php echo h(MAIL_FROM_NAME . ' <' . MAIL_FROM . '>'); ?></p>
    <?php if ($status): ?><div class="status"><?php echo h($status); ?></div><?php endif; ?>
    <form method="post">
        <input type="hidden" name="token" value="<?php echo h($token); ?>">
        <label>Subiect</label>
        <input type="text" name="subject" placeholder="Ex: Noutăți AI & DevOps (Septembrie)" required>
        <label>Conținut HTML</label>
        <textarea name="body" rows="12" placeholder="&lt;h2&gt;Salut!&lt;/h2&gt; &lt;p&gt;Ultimele noutăți...&lt;/p&gt;" required></textarea>
        <label><input type="checkbox" name="dry_run" checked> Dry-run (nu trimite, doar calculează)</label>
        <div style="margin-top:12px"><button type="submit">Rulează</button></div>
    </form>
    <p style="margin-top:20px;color:#555">Sfat: testează întâi cu adresa ta și dezactivează Dry-run când ești gata.</p>
</body>
</html>