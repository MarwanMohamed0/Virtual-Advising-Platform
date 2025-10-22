<?php
/**
 * Debug Login Issues
 * This script will help diagnose login problems
 */

require_once 'config/database.php';

echo "<h2>Login Debug Information</h2>";

try {
    $pdo = getDBConnection();
    echo "✅ Database connection successful<br><br>";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Users table exists<br>";
        
        // Check if admin user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute(['admin@mashourax.com']);
        $admin = $stmt->fetch();
        
        if ($admin) {
            echo "✅ Admin user exists<br>";
            echo "<strong>Admin user details:</strong><br>";
            echo "ID: " . $admin['id'] . "<br>";
            echo "Name: " . $admin['first_name'] . " " . $admin['last_name'] . "<br>";
            echo "Email: " . $admin['email'] . "<br>";
            echo "Role: " . $admin['role'] . "<br>";
            echo "Email Verified: " . ($admin['email_verified'] ? 'YES' : 'NO') . "<br>";
            echo "Is Active: " . ($admin['is_active'] ? 'YES' : 'NO') . "<br>";
            echo "Password Hash: " . substr($admin['password_hash'], 0, 20) . "...<br><br>";
            
            // Test password verification
            $testPassword = 'admin123';
            if (password_verify($testPassword, $admin['password_hash'])) {
                echo "✅ Password verification works<br>";
            } else {
                echo "❌ Password verification FAILED<br>";
                echo "The password 'admin123' does not match the stored hash<br>";
            }
            
            // Check what's causing the login failure
            echo "<br><strong>Login failure analysis:</strong><br>";
            if (!$admin['is_active']) {
                echo "❌ User is not active<br>";
            }
            if (!$admin['email_verified']) {
                echo "❌ Email is not verified<br>";
            }
            if (!password_verify($testPassword, $admin['password_hash'])) {
                echo "❌ Password doesn't match<br>";
            }
            
        } else {
            echo "❌ Admin user does NOT exist<br>";
            echo "Creating admin user...<br>";
            
            // Create admin user
            $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                INSERT INTO users (first_name, last_name, email, password_hash, institution, role, email_verified, is_active) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $result = $stmt->execute([
                'Admin',
                'User', 
                'admin@mashourax.com',
                $passwordHash,
                'MashouraX Platform',
                'admin',
                1, // email_verified = true
                1  // is_active = true
            ]);
            
            if ($result) {
                echo "✅ Admin user created successfully<br>";
            } else {
                echo "❌ Failed to create admin user<br>";
            }
        }
        
    } else {
        echo "❌ Users table does NOT exist<br>";
        echo "Please run setup.php first<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>If admin user doesn't exist or has wrong password, it will be created/fixed above</li>";
echo "<li>If email_verified is NO, the user will be updated to YES</li>";
echo "<li>Try logging in again with admin@mashourax.com / admin123</li>";
echo "</ol>";
?>
