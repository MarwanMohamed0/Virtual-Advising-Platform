<?php
/**
 * Setup Chat Database Table
 * Run this file once to create the chat_messages table
 * 
 * Usage: Open this file in your browser or run: php setup_chat_database.php
 */

require_once 'config/database.php';

try {
    $pdo = getDBConnection();
    
    echo "<h2>Setting up Chat Database...</h2>";
    
    // Create chat_messages table
    $sql = "
    CREATE TABLE IF NOT EXISTS chat_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        message TEXT NOT NULL,
        type ENUM('user', 'bot') NOT NULL DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_user_id (user_id),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($sql);
    
    echo "<p style='color: green;'>✅ <strong>Success!</strong> chat_messages table created successfully!</p>";
    
    // Verify table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'chat_messages'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✅ Table verified and ready to use!</p>";
        
        // Show table structure
        echo "<h3>Table Structure:</h3>";
        $stmt = $pdo->query("DESCRIBE chat_messages");
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>❌ Error: Table was not created. Please check your database connection.</p>";
    }
    
    echo "<hr>";
    echo "<p><a href='chat.php'>Go to Chat Interface</a> | <a href='index.php'>Go to Home</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ <strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    
    if (strpos($e->getMessage(), 'Base table or view not found') !== false) {
        echo "<p style='color: orange;'>⚠️ <strong>Note:</strong> The 'users' table might not exist. Please run the main database schema first.</p>";
        echo "<p>You can find the schema files:</p>";
        echo "<ul>";
        echo "<li><code>database_schema.sql</code> - Main schema</li>";
        echo "<li><code>database_schema_extended.sql</code> - Extended schema (includes chat_messages)</li>";
        echo "</ul>";
    }
    
    echo "<hr>";
    echo "<h3>Manual Setup:</h3>";
    echo "<p>If automatic setup fails, you can run the SQL manually:</p>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
    echo htmlspecialchars($sql);
    echo "</pre>";
}
?>

