<?php
require_once __DIR__ . '/../../config/database.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . (defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4');
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "DB: " . DB_NAME . " (host=" . DB_HOST . ")\n";
    $cnt = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    $pub = $pdo->query("SELECT COUNT(*) FROM projects WHERE is_published = 1")->fetchColumn();
    echo "Total projects: $cnt | Published: $pub\n";
    $rows = $pdo->query("SELECT id, slug, title, is_published FROM projects ORDER BY id DESC")->fetchAll();
    foreach ($rows as $r) {
        echo "- [" . $r['id'] . "] " . $r['slug'] . " | " . $r['title'] . " | pub=" . $r['is_published'] . "\n";
    }
} catch (Throwable $e) {
    fwrite(STDERR, "Error: " . $e->getMessage() . "\n");
    exit(1);
}
?>