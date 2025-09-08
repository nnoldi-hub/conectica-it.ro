<?php
// Simple newsletter subscription endpoint
// Stores email, source page, IP, user agent
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../includes/init.php';

function json_out($ok, $message, $code = 200) {
    http_response_code($ok ? 200 : $code);
    echo json_encode(['ok' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

// Allow only POST with JSON
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    json_out(false, 'Method not allowed', 405);
}

// Parse JSON body
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) {
    json_out(false, 'Body invalid', 400);
}

$email = trim($data['email'] ?? '');
$source = trim($data['source'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_out(false, 'Email invalid', 422);
}

// Prepare environment
if (!($pdo instanceof PDO)) {
    json_out(false, 'DB indisponibilă', 500);
}

try {
    // Create table if not exists (safe no-op if exists)
    $pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INT(11) NOT NULL AUTO_INCREMENT,
        email VARCHAR(190) NOT NULL,
        source VARCHAR(255) DEFAULT NULL,
        ip_address VARCHAR(45) DEFAULT NULL,
        user_agent VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        confirmed_at DATETIME DEFAULT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY uniq_email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    $ua = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 250);

    // Upsert by email
    $sql = "INSERT INTO newsletter_subscribers (email, source, ip_address, user_agent)
            VALUES (:email, :source, :ip, :ua)
            ON DUPLICATE KEY UPDATE source=VALUES(source), ip_address=VALUES(ip_address), user_agent=VALUES(user_agent)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':source' => $source ?: basename($_SERVER['REQUEST_URI'] ?? 'site'),
        ':ip' => $ip,
        ':ua' => $ua,
    ]);

    json_out(true, 'Abonare înregistrată');
} catch (Throwable $e) {
    json_out(false, 'Eroare server', 500);
}
?>