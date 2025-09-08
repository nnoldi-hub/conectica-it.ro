<?php
require_once __DIR__ . '/../../includes/init.php';
header('Content-Type: text/plain');
echo 'DB_HOST=' . (defined('DB_HOST') ? DB_HOST : 'n/a') . "\n";
echo 'DB_NAME=' . (defined('DB_NAME') ? DB_NAME : 'n/a') . "\n";
echo 'Has PDO=' . ((isset($pdo) && $pdo instanceof PDO) ? 'yes' : 'no') . "\n";
try {
    if (isset($pdo) && $pdo instanceof PDO) {
        $c = $pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn();
        echo 'Projects count=' . $c . "\n";
        $p = $pdo->query('SELECT COUNT(*) FROM projects WHERE is_published=1')->fetchColumn();
        echo 'Published count=' . $p . "\n";
    }
} catch (Throwable $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
?>