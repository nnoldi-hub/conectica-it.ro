<?php
// Delete a project by id
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
if (!$auth->isAuthenticated()) {
    echo json_encode(['success' => false, 'error' => 'NEAUTH']);
    exit;
}

$token = $_POST['csrf_token'] ?? '';
if (!$auth->validateCSRFToken($token)) {
    echo json_encode(['success' => false, 'error' => 'CSRF_INVALID']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'INVALID_ID']);
    exit;
}

try {
    $tableExists = false;
    if ($pdo instanceof PDO) {
        $stmt = $pdo->query("SHOW TABLES LIKE 'projects'");
        $tableExists = $stmt && $stmt->fetchColumn();
    }

    if ($tableExists) {
        $stmt = $pdo->prepare('DELETE FROM projects WHERE id = ?');
        $stmt->execute([$id]);
    }

    echo json_encode(['success' => true]);
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'error' => 'DB_ERROR']);
}
