<?php
/**
 * Database Connection Test Script
 * This script will help diagnose database connection issues
 */

echo "<h2>Database Connection Diagnostic</h2>";

// Test 1: Check if MySQL extension is available
echo "<h3>1. PHP MySQL Extension Check</h3>";
if (extension_loaded('pdo_mysql')) {
    echo "✅ PDO MySQL extension is loaded<br>";
} else {
    echo "❌ PDO MySQL extension is NOT loaded<br>";
    echo "Please install php-mysql extension<br>";
}

// Test 2: Check MySQL service
echo "<h3>2. MySQL Service Check</h3>";
$connection = @mysqli_connect('localhost', 'root', '');
if ($connection) {
    echo "✅ MySQL service is running<br>";
    mysqli_close($connection);
} else {
    echo "❌ MySQL service is NOT running or not accessible<br>";
    echo "Error: " . mysqli_connect_error() . "<br>";
    echo "Please start MySQL service<br>";
}

// Test 3: Check database existence
echo "<h3>3. Database Existence Check</h3>";
$connection = @mysqli_connect('localhost', 'root', '');
if ($connection) {
    $result = mysqli_query($connection, "SHOW DATABASES LIKE 'mashourax_platform'");
    if (mysqli_num_rows($result) > 0) {
        echo "✅ Database 'mashourax_platform' exists<br>";
    } else {
        echo "❌ Database 'mashourax_platform' does NOT exist<br>";
        echo "Creating database...<br>";
        if (mysqli_query($connection, "CREATE DATABASE mashourax_platform")) {
            echo "✅ Database created successfully<br>";
        } else {
            echo "❌ Failed to create database: " . mysqli_error($connection) . "<br>";
        }
    }
    mysqli_close($connection);
} else {
    echo "❌ Cannot connect to MySQL to check database<br>";
}

// Test 4: Test PDO connection
echo "<h3>4. PDO Connection Test</h3>";
try {
    $dsn = "mysql:host=localhost;dbname=mashourax_platform;charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    echo "✅ PDO connection successful<br>";
    
    // Test if tables exist
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (empty($tables)) {
        echo "⚠️ Database exists but no tables found. Run setup.php to create tables.<br>";
    } else {
        echo "✅ Tables found: " . implode(', ', $tables) . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ PDO connection failed: " . $e->getMessage() . "<br>";
}

// Test 5: Check file permissions
echo "<h3>5. File Permissions Check</h3>";
$config_file = __DIR__ . '/config/database.php';
if (is_readable($config_file)) {
    echo "✅ config/database.php is readable<br>";
} else {
    echo "❌ config/database.php is NOT readable<br>";
}

$includes_file = __DIR__ . '/includes/auth.php';
if (is_readable($includes_file)) {
    echo "✅ includes/auth.php is readable<br>";
} else {
    echo "❌ includes/auth.php is NOT readable<br>";
}

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>If MySQL is not running, start your MySQL service</li>";
echo "<li>If database doesn't exist, it should be created automatically</li>";
echo "<li>If tables don't exist, visit <a href='setup.php'>setup.php</a> to create them</li>";
echo "<li>If you have a different MySQL password, update config/database.php</li>";
echo "</ol>";
?>
