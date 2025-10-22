<?php
/**
 * Fix Admin Password
 * This script will reset the admin password to 'admin123'
 */

require_once 'config/database.php';

echo "<h2>Fixing Admin Password</h2>";

try {
    $pdo = getDBConnection();
    echo "✅ Database connection successful<br><br>";
    
    // Generate new password hash for 'admin123'
    $newPasswordHash = password_hash('admin123', PASSWORD_DEFAULT);
    echo "✅ New password hash generated<br>";
    
    // Update admin user password and ensure email is verified and active
    $stmt = $pdo->prepare("
        UPDATE users 
        SET password_hash = ?, email_verified = 1, is_active = 1 
        WHERE email = 'admin@mashourax.com'
    ");
    
    $result = $stmt->execute([$newPasswordHash]);
    
    if ($result) {
        echo "✅ Admin password updated successfully<br>";
        echo "✅ Email verification set to TRUE<br>";
        echo "✅ User status set to ACTIVE<br><br>";
        
        // Verify the update worked
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute(['admin@mashourax.com']);
        $admin = $stmt->fetch();
        
        if ($admin) {
            echo "<strong>Updated admin user details:</strong><br>";
            echo "Email: " . $admin['email'] . "<br>";
            echo "Role: " . $admin['role'] . "<br>";
            echo "Email Verified: " . ($admin['email_verified'] ? 'YES' : 'NO') . "<br>";
            echo "Is Active: " . ($admin['is_active'] ? 'YES' : 'NO') . "<br><br>";
            
            // Test password verification
            if (password_verify('admin123', $admin['password_hash'])) {
                echo "✅ Password verification now works!<br>";
                echo "✅ You can now login with admin@mashourax.com / admin123<br>";
            } else {
                echo "❌ Password verification still failed<br>";
            }
        }
        
    } else {
        echo "❌ Failed to update admin password<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Go to <a href='../auth/login.php'>login.php</a></li>";
echo "<li>Login with: admin@mashourax.com / admin123</li>";
echo "<li>You should now be able to access the platform!</li>";
echo "</ol>";
?>
