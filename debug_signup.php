<?php
/**
 * Debug Signup Process
 * This script helps debug role selection issues during signup
 */

require_once '../includes/auth.php';

echo "<h2>Signup Debug Information</h2>";

// Test form data processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>Form Data Received:</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    $userData = [
        'first_name' => trim($_POST['firstName'] ?? ''),
        'last_name' => trim($_POST['lastName'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'institution' => trim($_POST['institution'] ?? ''),
        'role' => $_POST['role'] ?? 'student',
        'newsletter_subscription' => isset($_POST['newsletter'])
    ];
    
    echo "<h3>Processed User Data:</h3>";
    echo "<pre>";
    print_r($userData);
    echo "</pre>";
    
    // Test registration
    $result = registerUser($userData);
    
    echo "<h3>Registration Result:</h3>";
    echo "<pre>";
    print_r($result);
    echo "</pre>";
    
    if ($result['success']) {
        echo "<p style='color: green;'>✅ Registration successful!</p>";
        
        // Check what was actually saved in database
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$userData['email']]);
            $savedUser = $stmt->fetch();
            
            if ($savedUser) {
                echo "<h3>User Saved in Database:</h3>";
                echo "<pre>";
                print_r($savedUser);
                echo "</pre>";
                
                if ($savedUser['role'] === $userData['role']) {
                    echo "<p style='color: green;'>✅ Role saved correctly!</p>";
                } else {
                    echo "<p style='color: red;'>❌ Role mismatch! Expected: {$userData['role']}, Got: {$savedUser['role']}</p>";
                }
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Registration failed: " . $result['message'] . "</p>";
    }
}

// Show current users in database
echo "<h3>Current Users in Database:</h3>";
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT first_name, last_name, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 10");
    $users = $stmt->fetchAll();
    
    if ($users) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Name</th><th>Email</th><th>Role</th><th>Created</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td>" . htmlspecialchars($user['role']) . "</td>";
            echo "<td>" . $user['created_at'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found in database.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Signup</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 8px; width: 300px; }
        .role-options { display: flex; gap: 20px; margin: 10px 0; }
        .role-option { display: flex; align-items: center; }
        .role-option input { width: auto; margin-right: 10px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h3>Test Signup Form:</h3>
    <form method="POST">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="firstName" required>
        </div>
        
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="lastName" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label>Institution:</label>
            <input type="text" name="institution" required>
        </div>
        
        <div class="form-group">
            <label>Role:</label>
            <div class="role-options">
                <div class="role-option">
                    <input type="radio" name="role" value="student" id="role_student" checked>
                    <label for="role_student">Student</label>
                </div>
                <div class="role-option">
                    <input type="radio" name="role" value="advisor" id="role_advisor">
                    <label for="role_advisor">Advisor</label>
                </div>
                <div class="role-option">
                    <input type="radio" name="role" value="admin" id="role_admin">
                    <label for="role_admin">Admin</label>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="newsletter"> Subscribe to newsletter
            </label>
        </div>
        
        <button type="submit">Test Signup</button>
    </form>
    
    <h3>Instructions:</h3>
    <ol>
        <li>Fill out the form above</li>
        <li>Select "Advisor" as the role</li>
        <li>Submit the form</li>
        <li>Check the debug output above to see what's happening</li>
    </ol>
</body>
</html>
