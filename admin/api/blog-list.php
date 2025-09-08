<?php
// List blog posts as JSON, optional filter by status
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
if (!$auth->isAuthenticated()) {
    echo json_encode(['success' => false, 'error' => 'NEAUTH']);
    exit;
}

$status = $_GET['status'] ?? 'all';
$where = '';
$params = [];
if (in_array($status, ['draft','published'], true)) {
    $where = 'WHERE status = ?';
    $params[] = $status;
}

try {
    // If table missing, return demo items compatible with UI
    $tableExists = false;
    if ($pdo instanceof PDO) {
        $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
        $tableExists = $stmt && $stmt->fetchColumn();
    }
    if (!$tableExists) {
        echo json_encode([ 'success' => true, 'items' => [
            [
                'id' => 1,
                'title' => 'Trends în Web Development 2025',
                'slug' => 'trends-web-2025',
                'excerpt' => 'Explorează cele mai noi tendințe în dezvoltarea web pentru 2025...',
                'cover_image' => '/assets/images/placeholders/wide-purple.svg',
                'status' => 'published', 'read_minutes' => 7,
                'created_at' => date('Y-m-d H:i:s', time()-86400), 'views' => 245,
            ],
            [
                'id' => 2,
                'title' => 'PHP Best Practices pentru 2025',
                'slug' => 'php-best-practices-2025',
                'excerpt' => 'Ghid cu cele mai bune practici PHP pentru dezvoltatori moderni...',
                'cover_image' => '/assets/images/placeholders/wide-green.svg',
                'status' => 'draft', 'read_minutes' => 9,
                'created_at' => date('Y-m-d H:i:s', time()-3600), 'views' => 0,
            ],
        ]]);
        exit;
    }

    $sql = "SELECT id,title,slug,excerpt,cover_image,status,read_minutes,created_at,views,featured FROM blog_posts $where ORDER BY featured DESC, COALESCE(published_at, created_at) DESC LIMIT 100";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'items' => $rows]);
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'error' => 'DB_ERROR']);
}
