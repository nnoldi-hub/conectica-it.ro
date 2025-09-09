<?php
require_once 'includes/init.php';

echo "<h2>Upgrade Testimonials Table</h2>";

try {
    // Check if columns already exist
    $stmt = $pdo->query("DESCRIBE testimonials");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $needed_columns = [
        'client_email', 'project_details', 'approval_token', 
        'status', 'submitted_at', 'approved_at', 'approved_by'
    ];
    
    $missing_columns = array_diff($needed_columns, $columns);
    
    if (empty($missing_columns)) {
        echo "<p style='color: green;'>✓ Toate coloanele există deja!</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Lipsesc coloanele: " . implode(', ', $missing_columns) . "</p>";
        echo "<p>Executez upgrade...</p>";
        
        // Read and execute upgrade script
        $upgrade_sql = file_get_contents('upgrade-testimonials.sql');
        $statements = explode(';', $upgrade_sql);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement) && !str_starts_with($statement, '--')) {
                try {
                    $pdo->exec($statement);
                    echo "<p style='color: green;'>✓ Executat: " . substr($statement, 0, 50) . "...</p>";
                } catch (PDOException $e) {
                    // Ignore errors for existing columns/indexes
                    if (strpos($e->getMessage(), 'Duplicate column name') === false && 
                        strpos($e->getMessage(), 'Duplicate key name') === false) {
                        echo "<p style='color: red;'>✗ Eroare: " . $e->getMessage() . "</p>";
                    }
                }
            }
        }
        
        echo "<p style='color: green;'>✓ Upgrade complet!</p>";
    }
    
    // Show current table structure
    echo "<h3>Structura curentă a tabelei:</h3>";
    $stmt = $pdo->query("DESCRIBE testimonials");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Default']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Show sample data
    echo "<h3>Date de test:</h3>";
    $stmt = $pdo->query("SELECT * FROM testimonials LIMIT 3");
    $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($testimonials)) {
        echo "<p>Nu există testimoniale în baza de date.</p>";
        echo "<p><a href='add-testimonial.php' style='color: blue;'>Adaugă primul testimonial</a></p>";
    } else {
        echo "<p>Găsite " . count($testimonials) . " testimoniale:</p>";
        foreach ($testimonials as $testimonial) {
            echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px 0;'>";
            echo "<strong>" . htmlspecialchars($testimonial['client_name']) . "</strong>";
            if (isset($testimonial['status'])) {
                echo " - Status: " . htmlspecialchars($testimonial['status']);
            }
            echo "<br>";
            echo htmlspecialchars(substr($testimonial['testimonial'], 0, 100)) . "...";
            echo "</div>";
        }
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Eroare la baza de date: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<br><p><a href='admin/' style='color: blue;'>Accesează Admin Panel</a></p>";
echo "<p><a href='add-testimonial.php' style='color: green;'>Testează formularul public</a></p>";
?>
