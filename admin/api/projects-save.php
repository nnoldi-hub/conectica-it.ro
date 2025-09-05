<?php
// Create or update a project
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

// Basic fields mapping
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title = trim($_POST['title'] ?? '');
$short = trim($_POST['short_description'] ?? ($_POST['description'] ?? ''));
$description = trim($_POST['description'] ?? '');
$status = $_POST['status'] ?? 'completed';
$technologies = $_POST['technologies'] ?? '';
$image = trim($_POST['image'] ?? '');
$project_url = trim($_POST['demo_url'] ?? ($_POST['project_url'] ?? ''));
$github_url = trim($_POST['github_url'] ?? '');
$is_published = isset($_POST['is_published']) ? (int)$_POST['is_published'] : 1;

if ($title === '') {
    echo json_encode(['success' => false, 'error' => 'TITLE_REQUIRED']);
    exit;
}

// normalize lengths to avoid strict mode errors
$title = mb_substr($title, 0, 200);
$short = mb_substr($short, 0, 500);
$image = mb_substr($image, 0, 255);
$project_url = mb_substr($project_url, 0, 255);
$github_url = mb_substr($github_url, 0, 255);

// validate status
if (!in_array($status, ['completed','in_progress','planned'], true)) {
    $status = 'completed';
}

// slug
$slug = strtolower(trim(preg_replace('/[^a-z0-9-]+/i', '-', $title), '-'));

try {
    // Ensure table exists
    $tableExists = false;
    if ($pdo instanceof PDO) {
        $stmt = $pdo->query("SHOW TABLES LIKE 'projects'");
        $tableExists = $stmt && $stmt->fetchColumn();
    }
    if (!$tableExists) {
        echo json_encode(['success' => true, 'simulated' => true, 'id' => $id ?: rand(1000,9999)]);
        exit;
    }

    // Normalize tech as JSON
    $techJson = null;
    if ($technologies !== '') {
        $tryJson = json_decode($technologies, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $techJson = json_encode(array_values($tryJson));
        } else {
            $parts = array_values(array_filter(array_map('trim', explode(',', $technologies))));
            $techJson = json_encode($parts);
        }
    }

    if ($id > 0) {
        $sql = "UPDATE projects SET title=?, slug=?, description=?, short_description=?, image=?, technologies=?, status=?, project_url=?, github_url=?, is_published=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $slug, $description, $short, $image, $techJson, $status, $project_url, $github_url, $is_published, $id]);
    } else {
        $sql = "INSERT INTO projects (title, slug, description, short_description, image, technologies, status, project_url, github_url, is_published) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$title, $slug, $description, $short, $image, $techJson, $status, $project_url, $github_url, $is_published]);
        } catch (PDOException $ex) {
            // Handle duplicate slug by appending a suffix once
            if ($ex->getCode() === '23000') {
                $slug .= '-' . substr(bin2hex(random_bytes(2)), 0, 3);
                $stmt->execute([$title, $slug, $description, $short, $image, $techJson, $status, $project_url, $github_url, $is_published]);
            } else {
                throw $ex;
            }
        }
        $id = (int)$pdo->lastInsertId();
    }

    echo json_encode(['success' => true, 'id' => $id, 'slug' => $slug]);
} catch (Throwable $e) {
    $msg = $e instanceof PDOException ? $e->getMessage() : 'Unexpected';
    echo json_encode(['success' => false, 'error' => 'DB_ERROR', 'message' => $msg]);
}
