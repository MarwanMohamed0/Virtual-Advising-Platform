<?php
/**
 * Test Advisor Dashboard Access
 * This script helps debug advisor dashboard issues
 */

echo "<h2>Advisor Dashboard Test</h2>";

// Test 1: Check if files exist
echo "<h3>1. File Existence Check</h3>";
$files_to_check = [
    'advisor-dashboard.php' => 'Advisor Dashboard',
    'includes/auth.php' => 'Authentication Functions',
    'config/database.php' => 'Database Configuration'
];

foreach ($files_to_check as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description} exists<br>";
    } else {
        echo "❌ {$description} missing<br>";
    }
}

// Test 2: Check database connection
echo "<h3>2. Database Connection Test</h3>";
try {
    require_once 'config/database.php';
    $pdo = getDBConnection();
    echo "✅ Database connection successful<br>";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Users table exists<br>";
        
        // Check for advisor users
        $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'advisor'");
        $advisorCount = $stmt->fetchColumn();
        echo "✅ Found {$advisorCount} advisor(s) in database<br>";
        
        if ($advisorCount > 0) {
            // Show advisor details
            $stmt = $pdo->query("SELECT first_name, last_name, email FROM users WHERE role = 'advisor' LIMIT 5");
            $advisors = $stmt->fetchAll();
            echo "<strong>Advisor users:</strong><br>";
            foreach ($advisors as $advisor) {
                echo "• " . $advisor['first_name'] . " " . $advisor['last_name'] . " (" . $advisor['email'] . ")<br>";
            }
        } else {
            echo "⚠️ No advisor users found. Create one to test the dashboard.<br>";
        }
    } else {
        echo "❌ Users table does not exist<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test 3: Check authentication functions
echo "<h3>3. Authentication Functions Test</h3>";
try {
    require_once 'includes/auth.php';
    echo "✅ Authentication functions loaded<br>";
    
    // Test if functions exist
    $functions = ['getCurrentUser', 'requireLogin', 'authenticateUser'];
    foreach ($functions as $function) {
        if (function_exists($function)) {
            echo "✅ Function {$function} exists<br>";
        } else {
            echo "❌ Function {$function} missing<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Authentication error: " . $e->getMessage() . "<br>";
}

// Test 4: Test advisor dashboard access
echo "<h3>4. Advisor Dashboard Access Test</h3>";
echo "<p>To test the advisor dashboard:</p>";
echo "<ol>";
echo "<li>Create an advisor account by signing up with role 'advisor'</li>";
echo "<li>Login with that account</li>";
echo "<li>Click 'Dashboard' in the user menu</li>";
echo "<li>Or visit: <a href='advisor-dashboard.php' target='_blank'>advisor-dashboard.php</a></li>";
echo "</ol>";

// Test 5: Create test advisor if none exists
echo "<h3>5. Create Test Advisor</h3>";
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'advisor'");
    $advisorCount = $stmt->fetchColumn();
    
    if ($advisorCount == 0) {
        echo "Creating test advisor account...<br>";
        
        $passwordHash = password_hash('advisor123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password_hash, institution, role, email_verified, is_active) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            'Test',
            'Advisor',
            'advisor@test.com',
            $passwordHash,
            'Test University',
            'advisor',
            1, // email_verified = true
            1  // is_active = true
        ]);
        
        if ($result) {
            echo "✅ Test advisor created successfully!<br>";
            echo "<strong>Test credentials:</strong><br>";
            echo "Email: advisor@test.com<br>";
            echo "Password: advisor123<br>";
            echo "<a href='login.php'>Go to Login</a><br>";
        } else {
            echo "❌ Failed to create test advisor<br>";
        }
    } else {
        echo "✅ Advisor accounts already exist<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error creating test advisor: " . $e->getMessage() . "<br>";
}

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>If no advisor exists, use the test credentials above</li>";
echo "<li>Login and try accessing the dashboard</li>";
echo "<li>If still not working, check the error logs</li>";
echo "</ol>";
?>
