<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Conectica IT</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>Conectica IT - Test de Diagnostic</h1>
    
    <?php if (1): ?>
        <p class="success">✅ PHP funcționează!</p>
        <p class="info">📅 Data: <?= date('Y-m-d H:i:s') ?></p>
        <p class="info">🐘 PHP Version: <?= phpversion() ?></p>
        <p class="info">🖥️ Server: <?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></p>
    <?php else: ?>
        <p class="error">❌ PHP nu funcționează!</p>
    <?php endif; ?>
    
    <?php
    // Test database connection
    try {
        require_once 'config/database.php';
        echo '<p class="success">✅ Database connection: OK</p>';
    } catch (Exception $e) {
        echo '<p class="error">❌ Database connection: ' . $e->getMessage() . '</p>';
    }
    ?>
    
    <hr>
    <h2>Link-uri de test:</h2>
    <ul>
        <li><a href="phptest.php">PHP Test Simplu</a></li>
        <li><a href="index.php">Pagina Principală</a></li>
        <li><a href="admin/">Admin Panel</a></li>
        <li><a href="test.php">Test Original</a></li>
    </ul>
</body>
</html>
