<?php
// Returns JSON list of projects for admin
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
if (!$auth->isAuthenticated()) {
    echo json_encode(['success' => false, 'error' => 'NEAUTH']);
    exit;
}

$items = [];
$total = 0;

try {
    // Verify table exists
    $tableExists = false;
    if ($pdo instanceof PDO) {
        $stmt = $pdo->query("SHOW TABLES LIKE 'projects'");
        $tableExists = $stmt && $stmt->fetchColumn();
    }

    if ($tableExists) {
        $stmt = $pdo->query("SELECT id, title, slug, short_description, description, image, gallery, technologies, status, category, project_url, github_url, client_name, duration_weeks, featured, is_published, created_at, updated_at FROM projects ORDER BY id DESC");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = count($items);
    }

    echo json_encode(['success' => true, 'items' => $items, 'total' => $total, 'csrf' => $auth->generateCSRFToken()]);
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'error' => 'DB_ERROR']);
}
