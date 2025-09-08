<?php
// Create or update a blog post (draft/publish)
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

$auth = new AuthSystem(isset($pdo) ? $pdo : null);
if (!$auth->isAuthenticated()) {
    echo json_encode(['success' => false, 'error' => 'NEAUTH']);
    exit;
}

// CSRF check
$token = $_POST['csrf_token'] ?? '';
if (!$auth->validateCSRFToken($token)) {
    echo json_encode(['success' => false, 'error' => 'CSRF_INVALID']);
    exit;
}

// Collect fields
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title = trim($_POST['title'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$excerpt = trim($_POST['excerpt'] ?? '');
$content_html = trim($_POST['content_html'] ?? '');
$cover_image = trim($_POST['cover_image'] ?? '');
$category = trim($_POST['category'] ?? '');
$tags = trim($_POST['tags'] ?? ''); // comma-separated or JSON array
$status = ($_POST['status'] ?? 'draft') === 'published' ? 'published' : 'draft';
$author = trim($_POST['author'] ?? 'Conectica IT');
$read_minutes = (int)($_POST['read_minutes'] ?? 5);
$featured = isset($_POST['featured']) ? (int)$_POST['featured'] : 0;

if ($title === '') {
    echo json_encode(['success' => false, 'error' => 'TITLE_REQUIRED']);
    exit;
}

// Normalize lengths
$title = mb_substr($title, 0, 200);
$slug = $slug !== '' ? mb_substr($slug, 0, 200) : strtolower(trim(preg_replace('/[^a-z0-9-]+/i', '-', $title), '-'));
$excerpt = mb_substr($excerpt, 0, 800);
$cover_image = mb_substr($cover_image, 0, 255);
$category = mb_substr($category, 0, 100);
$author = mb_substr($author, 0, 100);
$read_minutes = max(1, min(60, $read_minutes));
$featured = $featured ? 1 : 0;

// Normalize tags into JSON stored in TEXT
$tagsJson = null;
if ($tags !== '') {
    $arr = json_decode($tags, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($arr)) {
        $tagsJson = json_encode(array_values(array_map(function($t){ return mb_substr(trim((string)$t),0,40); }, $arr)));
    } else {
        $parts = array_values(array_filter(array_map(function($t){ return mb_substr(trim($t),0,40); }, explode(',', $tags))));
        $tagsJson = json_encode($parts);
    }
}

try {
    if (!($pdo instanceof PDO)) {
        echo json_encode(['success' => false, 'error' => 'DB_OFFLINE', 'message' => 'Conexiunea la baza de date lipsește.']);
        exit;
    }
    // Ensure table exists
    $tableExists = false;
    $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
    $tableExists = $stmt && $stmt->fetchColumn();
    if (!$tableExists) {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `blog_posts` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(200) NOT NULL,
            `slug` VARCHAR(200) NOT NULL UNIQUE,
            `excerpt` TEXT NULL,
            `content_html` MEDIUMTEXT NULL,
            `cover_image` VARCHAR(255) NULL,
            `category` VARCHAR(100) NULL,
            `tags` TEXT NULL,
            `status` ENUM('draft','published') NOT NULL DEFAULT 'draft',
            `author` VARCHAR(100) NULL,
            `read_minutes` INT NOT NULL DEFAULT 5,
            `views` INT NOT NULL DEFAULT 0,
            `featured` TINYINT(1) NOT NULL DEFAULT 0,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
            `published_at` TIMESTAMP NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }

    if ($id > 0) {
        // Update
        $sql = "UPDATE `blog_posts` SET `title`=?, `slug`=?, `excerpt`=?, `content_html`=?, `cover_image`=?, `category`=?, `tags`=?, `status`=?, `author`=?, `read_minutes`=?, `featured`=?, `updated_at`=CURRENT_TIMESTAMP, `published_at`=? WHERE `id`=?";
        $publishedAt = ($status === 'published') ? date('Y-m-d H:i:s') : null;
        // Keep existing published_at if already set and still published
        if ($status === 'published') {
            $stmt = $pdo->prepare("SELECT `published_at` FROM `blog_posts` WHERE `id` = ?");
            $stmt->execute([$id]);
            $currentPub = $stmt->fetchColumn();
            if ($currentPub) { $publishedAt = $currentPub; }
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $slug, $excerpt, $content_html, $cover_image, $category, $tagsJson, $status, $author, $read_minutes, $featured, $publishedAt, $id]);
    } else {
        // Insert with unique slug handling
        $sql = "INSERT INTO `blog_posts` (`title`, `slug`, `excerpt`, `content_html`, `cover_image`, `category`, `tags`, `status`, `author`, `read_minutes`, `featured`, `published_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $publishedAt = ($status === 'published') ? date('Y-m-d H:i:s') : null;
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$title, $slug, $excerpt, $content_html, $cover_image, $category, $tagsJson, $status, $author, $read_minutes, $featured, $publishedAt]);
        } catch (PDOException $ex) {
            if ($ex->getCode() === '23000') {
                $slug .= '-' . substr(bin2hex(random_bytes(2)), 0, 3);
                $stmt->execute([$title, $slug, $excerpt, $content_html, $cover_image, $category, $tagsJson, $status, $author, $read_minutes, $featured, $publishedAt]);
            } else { throw $ex; }
        }
        $id = (int)$pdo->lastInsertId();
    }

    echo json_encode(['success' => true, 'id' => $id, 'slug' => $slug, 'status' => $status]);
} catch (Throwable $e) {
    $msg = $e instanceof PDOException ? $e->getMessage() : 'Unexpected';
    error_log('[blog-save] ' . $msg);
    echo json_encode(['success' => false, 'error' => 'DB_ERROR', 'message' => $msg]);
}
