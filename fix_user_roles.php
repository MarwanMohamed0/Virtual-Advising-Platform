<?php
/**
 * Fix User Roles
 * This script helps fix users who were registered with wrong roles
 */

require_once 'config/database.php';

echo "<h2>Fix User Roles</h2>";

try {
    $pdo = getDBConnection();
    echo "✅ Database connection successful<br><br>";
    
    // Get all users
    $stmt = $pdo->query("SELECT id, first_name, last_name, email, role, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll();
    
    if (empty($users)) {
        echo "No users found in database.<br>";
    } else {
        echo "<h3>Current Users:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 20px;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Email</th><th>Current Role</th><th>Created</th><th>Action</th></tr>";
        
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user['id'] . "</td>";
            echo "<td>" . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td style='color: " . ($user['role'] === 'admin' ? 'red' : ($user['role'] === 'advisor' ? 'blue' : 'green')) . ";'>" . strtoupper($user['role']) . "</td>";
            echo "<td>" . $user['created_at'] . "</td>";
            echo "<td>";
            
            // Add role change buttons
            if ($user['role'] !== 'admin') {
                echo "<a href='?change_role=" . $user['id'] . "&new_role=admin' style='color: red; margin-right: 10px;'>Make Admin</a>";
            }
            if ($user['role'] !== 'advisor') {
                echo "<a href='?change_role=" . $user['id'] . "&new_role=advisor' style='color: blue; margin-right: 10px;'>Make Advisor</a>";
            }
            if ($user['role'] !== 'student') {
                echo "<a href='?change_role=" . $user['id'] . "&new_role=student' style='color: green;'>Make Student</a>";
            }
            
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Handle role change
    if (isset($_GET['change_role']) && isset($_GET['new_role'])) {
        $userId = (int)$_GET['change_role'];
        $newRole = $_GET['new_role'];
        
        // Validate role
        $allowedRoles = ['student', 'advisor', 'admin'];
        if (in_array($newRole, $allowedRoles)) {
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $result = $stmt->execute([$newRole, $userId]);
            
            if ($result) {
                echo "<div style='background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
                echo "✅ User role updated successfully!";
                echo "</div>";
                
                // Refresh page to show updated roles
                echo "<script>setTimeout(function(){ window.location.href = window.location.pathname; }, 1500);</script>";
            } else {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
                echo "❌ Failed to update user role.";
                echo "</div>";
            }
        } else {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
            echo "❌ Invalid role selected.";
            echo "</div>";
        }
    }
    
    // Create test users if none exist
    if (empty($users)) {
        echo "<h3>Creating Test Users:</h3>";
        
        $testUsers = [
            ['Test', 'Admin', 'admin@test.com', 'admin123', 'Test University', 'admin'],
            ['Test', 'Advisor', 'advisor@test.com', 'advisor123', 'Test University', 'advisor'],
            ['Test', 'Student', 'student@test.com', 'student123', 'Test University', 'student']
        ];
        
        foreach ($testUsers as $userData) {
            $passwordHash = password_hash($userData[3], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                INSERT INTO users (first_name, last_name, email, password_hash, institution, role, email_verified, is_active) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $userData[0], $userData[1], $userData[2], $passwordHash, 
                $userData[4], $userData[5], 1, 1
            ]);
            
            if ($result) {
                echo "✅ Created {$userData[5]}: {$userData[2]} / {$userData[3]}<br>";
            } else {
                echo "❌ Failed to create {$userData[5]}: {$userData[2]}<br>";
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h3>Test Credentials:</h3>";
echo "<ul>";
echo "<li><strong>Admin:</strong> admin@test.com / admin123</li>";
echo "<li><strong>Advisor:</strong> advisor@test.com / advisor123</li>";
echo "<li><strong>Student:</strong> student@test.com / student123</li>";
echo "</ul>";

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Use the links above to change user roles if needed</li>";
echo "<li>Test login with different roles</li>";
echo "<li>Verify each role goes to the correct dashboard</li>";
echo "</ol>";
?>
