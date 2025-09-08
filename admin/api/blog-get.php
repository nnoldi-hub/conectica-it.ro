<?php
// Get a single blog post by id
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
if (!$auth->isAuthenticated()) {
    echo json_encode(['success' => false, 'error' => 'NEAUTH']);
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'INVALID_ID']);
    exit;
}

try {
    // Ensure table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
    $exists = $stmt && $stmt->fetchColumn();
    if (!$exists) { echo json_encode(['success' => false, 'error' => 'NOT_FOUND']); exit; }

    // Detect schema
    $cols = $pdo->query("SHOW COLUMNS FROM `blog_posts`")->fetchAll(PDO::FETCH_ASSOC);
    $names = array_map(function($r){ return $r['Field'] ?? $r[0]; }, $cols);
    $has = function($n) use ($names){ return in_array($n, $names, true); };
    $legacy = $has('content') && $has('featured_image') && $has('reading_time') && $has('is_published') && !$has('content_html');

    if ($legacy) {
        $sql = "SELECT id,title,slug,excerpt,content as content_html,featured_image as cover_image,category,tags,(CASE WHEN is_published=1 THEN 'published' ELSE 'draft' END) as status, NULL as author, reading_time as read_minutes, featured, views, created_at, published_at FROM blog_posts WHERE id = ? LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    } else {
        $sql = "SELECT id,title,slug,excerpt,content_html,cover_image,category,tags,status,author,read_minutes,featured,views,created_at,published_at FROM blog_posts WHERE id = ? LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) { echo json_encode(['success' => false, 'error' => 'NOT_FOUND']); exit; }

    echo json_encode(['success' => true, 'item' => $row]);
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'error' => 'DB_ERROR']);
}
