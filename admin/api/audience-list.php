<?php
// Alias for newsletter-subscribers.php using a neutral name
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
if (!$auth->isAuthenticated()) { echo json_encode(['success'=>false,'error'=>'NEAUTH']); exit; }

try {
    if (!($pdo instanceof PDO)) { echo json_encode(['success'=>false,'error'=>'DB_OFFLINE']); exit; }
    $pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(190) NOT NULL UNIQUE,
        source VARCHAR(255) DEFAULT NULL,
        ip_address VARCHAR(45) DEFAULT NULL,
        user_agent VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        confirmed_at DATETIME DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $stmt = $pdo->query('SELECT email, created_at, source FROM newsletter_subscribers ORDER BY id DESC LIMIT 200');
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    $total = (int)($pdo->query('SELECT COUNT(*) FROM newsletter_subscribers')->fetchColumn() ?: 0);
    echo json_encode(['success'=>true,'items'=>$items,'total'=>$total]);
} catch (Throwable $e) {
    echo json_encode(['success'=>false,'error'=>'SERVER_ERROR']);
}
