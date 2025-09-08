<?php
// Seed/Upsert for Matchday project (self-contained so it can run via CLI)
require_once __DIR__ . '/../../config/database.php';

// Build a PDO connection without selecting DB first, so we can create it if missing
try {
    $baseDsn = "mysql:host=" . DB_HOST . ";charset=" . (defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4');
    $pdo = new PDO($baseDsn, DB_USERNAME, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Ensure database exists, then select it
    $dbName = DB_NAME;
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `{$dbName}`");

    // Ensure projects table exists (minimal schema required for seeding)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `projects` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(200) NOT NULL,
      `slug` varchar(200) NOT NULL,
      `description` text,
      `short_description` varchar(500) DEFAULT NULL,
      `image` varchar(255) DEFAULT NULL,
      `gallery` json DEFAULT NULL,
      `technologies` json DEFAULT NULL,
      `category` varchar(100) DEFAULT NULL,
      `project_url` varchar(255) DEFAULT NULL,
      `github_url` varchar(255) DEFAULT NULL,
      `client_name` varchar(100) DEFAULT NULL,
      `completion_date` date DEFAULT NULL,
      `duration_weeks` int(11) DEFAULT NULL,
      `status` enum('completed','in_progress','planned') DEFAULT 'completed',
      `featured` tinyint(1) DEFAULT 0,
      `views` int(11) DEFAULT 0,
      `meta_title` varchar(200) DEFAULT NULL,
      `meta_description` varchar(300) DEFAULT NULL,
      `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `is_published` tinyint(1) DEFAULT 1,
      PRIMARY KEY (`id`),
      UNIQUE KEY `slug` (`slug`),
      KEY `category` (`category`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
} catch (Throwable $e) {
    fwrite(STDERR, "DB init error: " . $e->getMessage() . "\n");
    exit(1);
}

$slug = 'matchday';
$title = 'Matchday.ro – Blog sportiv modern';
$short = 'Blog sportiv modern, rapid și responsive, dedicat știrilor și cronicilor de meci.';
$desc = 'Structură clară pe categorii, pagini SEO-friendly și design curat orientat pe lectură.';
$image = 'assets/images/placeholders/wide-purple.svg';
$gallery = json_encode([
    'assets/images/placeholders/wide-orange.svg',
    'assets/images/placeholders/wide-green.svg'
], JSON_UNESCAPED_SLASHES);
$tech = json_encode(['PHP 8','MySQL','Bootstrap 5','JavaScript','TinyMCE/CKEditor','PHPMailer'], JSON_UNESCAPED_SLASHES);
$project_url = 'https://matchday.ro';
$github_url = '';

$sql = "INSERT INTO projects (slug, title, short_description, description, image, gallery, technologies, project_url, github_url, is_published)
        VALUES (:slug,:title,:short,:descr,:image,:gallery,:tech,:url,:git,1)
        ON DUPLICATE KEY UPDATE
          title=VALUES(title),
          short_description=VALUES(short_description),
          description=VALUES(description),
          image=VALUES(image),
          gallery=VALUES(gallery),
          technologies=VALUES(technologies),
          project_url=VALUES(project_url),
          github_url=VALUES(github_url),
          is_published=1";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':slug' => $slug,
    ':title' => $title,
    ':short' => $short,
    ':descr' => $desc,
    ':image' => $image,
    ':gallery' => $gallery,
    ':tech' => $tech,
    ':url' => $project_url,
    ':git' => $github_url,
]);

echo "OK: seeded/updated {$slug}\n";
