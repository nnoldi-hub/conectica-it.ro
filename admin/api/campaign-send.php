<?php
// Clean newsletter campaign sender - uses only PHPMailer for reliability
ini_set('display_errors', 0);
ob_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/hostico_mailer.php';
require_once __DIR__ . '/../../includes/newsletter_template.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
if (!$auth->isAuthenticated()) { 
    ob_end_clean(); 
    echo json_encode(['success'=>false,'error'=>'NEAUTH']); 
    exit; 
}

$isPreview = isset($_GET['preview']);
$isTest = isset($_GET['test']);
$raw = file_get_contents('php://input');
$data = json_decode($raw, true) ?: [];

if (!$isPreview && !$isTest) {
    $csrf = $data['csrf_token'] ?? '';
    if (!$auth->validateCSRFToken($csrf)) { 
        ob_end_clean(); 
        echo json_encode(['success'=>false,'error'=>'CSRF_INVALID']); 
        exit; 
    }
}

$mode = $data['mode'] ?? 'builder';
$subject = trim($data['subject'] ?? '');

if ($subject === '' && !$isPreview && !$isTest) { 
    ob_end_clean(); 
    echo json_encode(['success'=>false,'error'=>'SUBJECT_REQUIRED']); 
    exit; 
}

try {
    // Generate HTML content
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

    // Handle preview request
    if ($isPreview) { 
        ob_end_clean(); 
        echo json_encode(['success'=>true,'html'=>$html]); 
        exit; 
    }

    // Check database
    if (!($pdo instanceof PDO)) { 
        ob_end_clean(); 
        echo json_encode(['success'=>false,'error'=>'DB_OFFLINE']); 
        exit; 
    }

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

    // Determine targets
    $testEmail = trim($data['test_email'] ?? '');
    $dry = !empty($data['dry_run']);
    $targets = [];

    if ($testEmail) {
        if (filter_var($testEmail, FILTER_VALIDATE_EMAIL)) { 
            $targets = [$testEmail]; 
        } else { 
            ob_end_clean(); 
            echo json_encode(['success'=>false,'error'=>'TEST_EMAIL_INVALID']); 
            exit; 
        }
    } else {
        $stmt = $pdo->query('SELECT email FROM newsletter_subscribers ORDER BY id ASC');
        $targets = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    }

    // Initialize mailer
    $mailer = new HosticoMailer();
    if (isset($_GET['debugsmtp']) || isset($_GET['test'])) { 
        $mailer->setDebug(true); 
    }

    // Test connection first if requested
    if (isset($_GET['test'])) {
        $connTest = $mailer->testConnection();
        ob_end_clean();
        echo json_encode([
            'success' => $connTest['success'],
            'message' => $connTest['message'],
            'smtp_log' => $connTest['details'],
            'config_check' => [
                'smtp_host' => defined('SMTP_HOST') ? SMTP_HOST : 'MISSING',
                'smtp_port' => defined('SMTP_PORT') ? SMTP_PORT : 'MISSING', 
                'smtp_user' => defined('SMTP_USER') ? SMTP_USER : 'MISSING',
                'smtp_pass' => defined('SMTP_PASS') && trim(SMTP_PASS) ? 'SET' : 'MISSING',
                'mail_from' => defined('MAIL_FROM') ? MAIL_FROM : 'MISSING',
                'native_smtp' => 'YES (Hostico compatible)',
                'phpmailer_blocked' => 'YES (expected on Hostico)'
            ]
        ]);
        exit;
    }

    // Send emails
    $sent = 0; $fail = 0; $skipped = 0; $errors = [];
    
    if (!$dry) {
        foreach ($targets as $i => $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                $skipped++; 
                continue; 
            }
            
            $ok = false;
            try { 
                $ok = $mailer->send($email, '', $subject, $html); 
            } catch (Throwable $e) { 
                $ok = false; 
                $errors[] = $e->getMessage(); 
            }
            
            if ($ok) { 
                $sent++; 
            } else { 
                $fail++; 
                $le = $mailer->getLastError(); 
                if ($le && !in_array($le, $errors)) { 
                    $errors[] = $le; 
                } 
            }
            
            // Throttle every 30 emails
            if (($i + 1) % 30 === 0) { 
                usleep(500000); // 0.5 second pause
            }
        }
    }

    // Prepare response
    $resp = [
        'success' => true,
        'total' => count($targets),
        'sent' => $sent,
        'fail' => $fail,
        'skipped' => $skipped,
        'dry' => $dry,
        'errors' => array_slice($errors, 0, 5), // Limit errors shown
        'diag' => [
            'native_smtp' => 'da',
            'smtp_configured' => (defined('SMTP_PASS') && trim(SMTP_PASS) !== '') ? 'da' : 'nu',
            'config_loaded' => defined('MAIL_FROM') ? 'da' : 'nu',
            'hostico_mode' => 'da'
        ]
    ];

    // Include debug log if requested or if there were errors
    if ((isset($_GET['debugsmtp']) || $fail > 0) && method_exists($mailer, 'getDebugLog')) { 
        $resp['smtp_log'] = $mailer->getDebugLog(); 
    }

    ob_end_clean(); 
    echo json_encode($resp); 
    exit;

} catch (Throwable $e) {
    $out = ob_get_clean();
    echo json_encode([
        'success' => false,
        'error' => 'SERVER_ERROR',
        'details' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => basename($e->getFile())
    ]);
}
