<?php
// Alias for newsletter-send.php with a neutral name to avoid ad blockers
// Ensure clean JSON (suppress HTML warnings/notices)
ini_set('display_errors', 0);
ob_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/mailer.php';
require_once __DIR__ . '/../../includes/newsletter_template.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
if (!$auth->isAuthenticated()) { ob_end_clean(); echo json_encode(['success'=>false,'error'=>'NEAUTH']); exit; }

$isPreview = isset($_GET['preview']);
$raw = file_get_contents('php://input');
$data = json_decode($raw, true) ?: [];
if (!$isPreview) {
    $csrf = $data['csrf_token'] ?? '';
    if (!$auth->validateCSRFToken($csrf)) { ob_end_clean(); echo json_encode(['success'=>false,'error'=>'CSRF_INVALID']); exit; }
}

$mode = $data['mode'] ?? 'builder';
$subject = trim($data['subject'] ?? '');
if ($subject === '' && !$isPreview) { ob_end_clean(); echo json_encode(['success'=>false,'error'=>'SUBJECT_REQUIRED']); exit; }

try {
    if ($mode === 'builder') {
        $opt = [
            'subject' => $subject,
            'preheader' => trim($data['preheader'] ?? ''),
            'title' => trim($data['title'] ?? $subject),
            'intro' => trim($data['intro'] ?? ''),
            'cta_url' => trim($data['cta_url'] ?? 'blog.php'),
            'items' => is_array($data['items'] ?? null) ? $data['items'] : []
        ];
        $html = newsletter_template_html($opt);
    } else {
        $html = trim($data['body'] ?? '');
    }

    if ($isPreview) { ob_end_clean(); echo json_encode(['success'=>true,'html'=>$html]); exit; }

    if (!($pdo instanceof PDO)) { ob_end_clean(); echo json_encode(['success'=>false,'error'=>'DB_OFFLINE']); exit; }
    $pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(190) NOT NULL UNIQUE,
        source VARCHAR(255) DEFAULT NULL,
        ip_address VARCHAR(45) DEFAULT NULL,
        user_agent VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        confirmed_at DATETIME DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $testEmail = trim($data['test_email'] ?? '');
    $dry = !empty($data['dry_run']);

    $targets = [];
    if ($testEmail) {
    if (filter_var($testEmail, FILTER_VALIDATE_EMAIL)) { $targets = [$testEmail]; }
    else { ob_end_clean(); echo json_encode(['success'=>false,'error'=>'TEST_EMAIL_INVALID']); exit; }
    } else {
        $stmt = $pdo->query('SELECT email FROM newsletter_subscribers ORDER BY id ASC');
        $targets = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    }

    $mailer = new SimpleMailer();
        if (isset($_GET['debugsmtp'])) { $mailer->setDebug(true); }
    $diag = [
        'hasSmtp' => (defined('SMTP_PASS') && trim((string)SMTP_PASS) !== ''),
        'host' => defined('SMTP_HOST') ? SMTP_HOST : null,
        'port' => defined('SMTP_PORT') ? SMTP_PORT : null,
        'secure' => defined('SMTP_SECURE') ? SMTP_SECURE : null,
        'mailAvailable' => function_exists('mail'),
        'phpmailer' => class_exists('PHPMailer\\PHPMailer\\PHPMailer'),
    ];
    $sent=0; $fail=0; $skipped=0; $errors=[];
    if (!$dry) {
        foreach ($targets as $i=>$email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $skipped++; continue; }
            $ok = false; try { $ok = $mailer->send($email, '', $subject, $html); } catch (Throwable $e) { $ok=false; $errors[] = $e->getMessage(); }
            if ($ok) { $sent++; }
            else { $fail++; $le = $mailer->getLastError(); if ($le) { $errors[] = $le; } }
            if (($i+1)%30===0) { usleep(300000); }
        }
    }

    $resp = ['success'=>true,'total'=>count($targets),'sent'=>$sent,'fail'=>$fail,'skipped'=>$skipped,'dry'=>$dry,'errors'=>$errors,'diag'=>$diag];
    if ((isset($_GET['debugsmtp']) || !empty($errors)) && method_exists($mailer,'getDebugLog')) { $resp['smtp_log'] = $mailer->getDebugLog(); }
    ob_end_clean(); echo json_encode($resp); exit;
} catch (Throwable $e) {
    $out = ob_get_clean();
    echo json_encode(['success'=>false,'error'=>'SERVER_ERROR','details'=>$e->getMessage(),'out'=>substr((string)$out,0,500)]);
}
