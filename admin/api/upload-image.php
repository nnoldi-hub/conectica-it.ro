<?php
// Image upload endpoint for admin projects
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

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'NO_FILE']);
    exit;
}

$file = $_FILES['file'];
$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
$mime = mime_content_type($file['tmp_name']);
if (!isset($allowed[$mime])) {
    echo json_encode(['success' => false, 'error' => 'INVALID_TYPE']);
    exit;
}

// Limit ~5MB
if ($file['size'] > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'error' => 'FILE_TOO_LARGE']);
    exit;
}

$ext = $allowed[$mime];
$safeName = preg_replace('/[^a-z0-9\-]+/i', '-', pathinfo($file['name'], PATHINFO_FILENAME));
$filename = $safeName . '-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;

$targetDir = rtrim(PUBLIC_PATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'projects';
if (!is_dir($targetDir)) {
    @mkdir($targetDir, 0755, true);
}

$targetPath = $targetDir . DIRECTORY_SEPARATOR . $filename;
if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    echo json_encode(['success' => false, 'error' => 'MOVE_FAILED']);
    exit;
}

// Build web path absolute from site root
$webPath = '/assets/uploads/projects/' . $filename;
echo json_encode(['success' => true, 'url' => $webPath]);
