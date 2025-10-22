<?php
/**
 * Check User Roles in Database
 * This script shows all users and their roles to debug the issue
 */

require_once 'config/database.php';

echo "<h2>User Roles Check</h2>";

try {
    $pdo = getDBConnection();
    echo "✅ Database connection successful<br><br>";
    
    // Get all users
    $stmt = $pdo->query("SELECT id, first_name, last_name, email, role, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll();
    
    if (empty($users)) {
        echo "❌ No users found in database.<br>";
    } else {
        echo "<h3>All Users in Database:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 20px;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th>Actions</th>";
        echo "</tr>";
        
        foreach ($users as $user) {
            $roleColor = '';
            switch($user['role']) {
                case 'admin': $roleColor = 'color: red; font-weight: bold;'; break;
                case 'advisor': $roleColor = 'color: blue; font-weight: bold;'; break;
                case 'student': $roleColor = 'color: green; font-weight: bold;'; break;
                default: $roleColor = 'color: orange; font-weight: bold;'; break;
            }
            
            echo "<tr>";
            echo "<td>" . $user['id'] . "</td>";
            echo "<td>" . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td style='{$roleColor}'>" . strtoupper($user['role']) . "</td>";
            echo "<td>" . $user['created_at'] . "</td>";
            echo "<td>";
            echo "<a href='?test_login=" . $user['id'] . "' style='margin-right: 10px;'>Test Login</a>";
            echo "<a href='?change_role=" . $user['id'] . "&new_role=advisor' style='color: blue; margin-right: 10px;'>Make Advisor</a>";
            echo "<a href='?change_role=" . $user['id'] . "&new_role=admin' style='color: red; margin-right: 10px;'>Make Admin</a>";
            echo "<a href='?change_role=" . $user['id'] . "&new_role=student' style='color: green;'>Make Student</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Handle role change
    if (isset($_GET['change_role']) && isset($_GET['new_role'])) {
        $userId = (int)$_GET['change_role'];
        $newRole = $_GET['new_role'];
        
        $allowedRoles = ['student', 'advisor', 'admin'];
        if (in_array($newRole, $allowedRoles)) {
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $result = $stmt->execute([$newRole, $userId]);
            
            if ($result) {
                echo "<div style='background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
                echo "✅ User role updated to {$newRole}!";
                echo "</div>";
                echo "<script>setTimeout(function(){ window.location.href = window.location.pathname; }, 1500);</script>";
            } else {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
                echo "❌ Failed to update user role.";
                echo "</div>";
            }
        }
    }
    
    // Test login simulation
    if (isset($_GET['test_login'])) {
        $userId = (int)$_GET['test_login'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if ($user) {
            echo "<h3>Login Test for User: " . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . "</h3>";
            echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "<strong>User Role:</strong> <span style='color: blue; font-weight: bold;'>" . strtoupper($user['role']) . "</span><br>";
            
            // Simulate login routing
            $dashboardUrl = 'student-dashboard.php'; // default
            switch ($user['role']) {
                case 'admin':
                    $dashboardUrl = 'admin-dashboard.php';
                    break;
                case 'advisor':
                    $dashboardUrl = 'advisor-dashboard.php';
                    break;
                case 'student':
                default:
                    $dashboardUrl = 'student-dashboard.php';
                    break;
            }
            
            echo "<strong>Should redirect to:</strong> <a href='{$dashboardUrl}' target='_blank'>{$dashboardUrl}</a><br>";
            echo "<strong>Current login.php routing:</strong> ";
            
            // Check what login.php actually does
            echo "Login system should route based on role: {$user['role']} → {$dashboardUrl}<br>";
            
            echo "</div>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h3>Quick Actions:</h3>";
echo "<ol>";
echo "<li>Check the table above to see all users and their roles</li>";
echo "<li>Click 'Test Login' to see where each user should be redirected</li>";
echo "<li>Click 'Make Advisor' to change any user to advisor role</li>";
echo "<li>Then try logging in with that user</li>";
echo "</ol>";

echo "<h3>Test Credentials (if you need to create them):</h3>";
echo "<p>If no users exist, you can create test accounts:</p>";
echo "<a href='fix_user_roles.php' target='_blank' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Create Test Users</a>";
?>
