<?php
// Send or preview newsletter campaign (JSON API)
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/mailer.php';
require_once __DIR__ . '/../../includes/newsletter_template.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
if (!$auth->isAuthenticated()) { echo json_encode(['success'=>false,'error'=>'NEAUTH']); exit; }

$isPreview = isset($_GET['preview']);

$raw = file_get_contents('php://input');
$data = json_decode($raw, true) ?: [];

if (!$isPreview) {
    $csrf = $data['csrf_token'] ?? '';
    if (!$auth->validateCSRFToken($csrf)) { echo json_encode(['success'=>false,'error'=>'CSRF_INVALID']); exit; }
}

$mode = $data['mode'] ?? 'builder';
$subject = trim($data['subject'] ?? '');
if ($subject === '' && !$isPreview) { echo json_encode(['success'=>false,'error'=>'SUBJECT_REQUIRED']); exit; }

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

    if ($isPreview) { echo json_encode(['success'=>true,'html'=>$html]); exit; }

    if (!($pdo instanceof PDO)) { echo json_encode(['success'=>false,'error'=>'DB_OFFLINE']); exit; }
    // Ensure subscribers table exists
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
        else { echo json_encode(['success'=>false,'error'=>'TEST_EMAIL_INVALID']); exit; }
    } else {
        $stmt = $pdo->query('SELECT email FROM newsletter_subscribers ORDER BY id ASC');
        $targets = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    }

    $mailer = new SimpleMailer();
    $sent=0; $fail=0; $skipped=0;
    if (!$dry) {
        foreach ($targets as $i=>$email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $skipped++; continue; }
            $ok = false; try { $ok = $mailer->send($email, '', $subject, $html); } catch (Throwable $e) { $ok=false; }
            if ($ok) $sent++; else $fail++;
            if (($i+1)%30===0) { usleep(300000); }
        }
    }

    echo json_encode(['success'=>true,'total'=>count($targets),'sent'=>$sent,'fail'=>$fail,'skipped'=>$skipped,'dry'=>$dry]);
} catch (Throwable $e) {
    echo json_encode(['success'=>false,'error'=>'SERVER_ERROR']);
}
