<?php
require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
$auth->requireAuth();

header('Content-Type: text/html; charset=utf-8');
echo '<h2>Diag Blog</h2>';

if (!($pdo instanceof PDO)) {
    echo '<div style="color:#b00">DB OFFLINE</div>';
    exit;
}

try {
    $dbName = $pdo->query('SELECT DATABASE()')->fetchColumn();
    echo '<div>DB: <strong>' . htmlspecialchars($dbName) . '</strong></div>';

    $exists = $pdo->query("SHOW TABLES LIKE 'blog_posts'")->fetchColumn();
    echo '<div>blog_posts exists: ' . ($exists ? 'YES' : 'NO') . '</div>';

    if ($exists) {
        $row = $pdo->query("SHOW TABLE STATUS LIKE 'blog_posts'")->fetch(PDO::FETCH_ASSOC);
        echo '<pre>' . htmlspecialchars(print_r($row, true)) . '</pre>';

        $cols = $pdo->query("SHOW COLUMNS FROM blog_posts")->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>' . htmlspecialchars(print_r($cols, true)) . '</pre>';
    }

    // Privilege test: insert/delete dummy if table exists
    if ($exists) {
        $slug = 'diag-' . substr(bin2hex(random_bytes(3)), 0, 6);
        $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, status, author, read_minutes) VALUES (?,?,?,?,?)");
        $ok = $stmt->execute(['Diag Post', $slug, 'draft', 'Diag', 1]);
        echo '<div>Insert test: ' . ($ok ? 'OK' : 'FAIL') . '</div>';
        if ($ok) {
            $id = $pdo->lastInsertId();
            $pdo->prepare('DELETE FROM blog_posts WHERE id=?')->execute([$id]);
            echo '<div>Delete test: OK</div>';
        }
    }
} catch (Throwable $e) {
    echo '<div style="color:#b00">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
}
