<?php
/**
 * Authentication functions for MashouraX Virtual Advising Platform
 */

require_once __DIR__ . '/../config/database.php';

/**
 * Register a new user
 * @param array $userData User data array
 * @return array Result array with success status and message
 */
function registerUser($userData) {
    try {
        $pdo = getDBConnection();
        
        // Validate required fields
        $requiredFields = ['first_name', 'last_name', 'email', 'password', 'institution', 'role'];
        foreach ($requiredFields as $field) {
            if (empty($userData[$field])) {
                return ['success' => false, 'message' => "Field {$field} is required"];
            }
        }
        
        // Validate email format
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }
        
        // Validate role
        $allowedRoles = ['student', 'advisor', 'admin'];
        if (!in_array($userData['role'], $allowedRoles)) {
            return ['success' => false, 'message' => 'Invalid role selected'];
        }
        
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$userData['email']]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Email already registered'];
        }
        
        // Hash password
        $passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        // Insert user (no verification needed)
        $stmt = $pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password_hash, institution, role, newsletter_subscription, email_verified) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $passwordHash,
            $userData['institution'],
            $userData['role'],
            $userData['newsletter_subscription'] ?? false,
            1 // email_verified = true (no verification needed)
        ]);
        
        if ($result) {
            return [
                'success' => true, 
                'message' => 'Account created successfully! You can now login.',
                'user_id' => $pdo->lastInsertId()
            ];
        } else {
            return ['success' => false, 'message' => 'Failed to create account'];
        }
        
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred during registration'];
    }
}

/**
 * Authenticate user login
 * @param string $email User email
 * @param string $password User password
 * @return array Result array with success status and user data
 */
function authenticateUser($email, $password) {
    try {
        $pdo = getDBConnection();
        
        // Get user by email
        $stmt = $pdo->prepare("
            SELECT id, first_name, last_name, email, password_hash, role, institution, is_active, email_verified 
            FROM users 
            WHERE email = ? AND is_active = 1
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }
        
        // Verify password
        if (!password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }
        
        // Email verification not required - users can login immediately
        
        // Update last login
        $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $updateStmt->execute([$user['id']]);
        
        // Remove password hash from returned data
        unset($user['password_hash']);
        
        return [
            'success' => true, 
            'message' => 'Login successful',
            'user' => $user
        ];
        
    } catch (Exception $e) {
        error_log("Authentication error: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred during login'];
    }
}

/**
 * Start user session
 * @param array $user User data array
 * @return string Session token
 */
function startUserSession($user) {
    try {
        $pdo = getDBConnection();
        
        // Generate session token
        $sessionToken = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours')); // 24 hour session
        
        // Store session in database
        $stmt = $pdo->prepare("
            INSERT INTO user_sessions (user_id, session_token, expires_at, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $user['id'],
            $sessionToken,
            $expiresAt,
            $_SERVER['REMOTE_ADDR'] ?? '',
            $_SERVER['HTTP_USER_AGENT'] ?? ''
        ]);
        
        // Set session cookie
        setcookie('session_token', $sessionToken, time() + (24 * 60 * 60), '/', '', false, true);
        
        return $sessionToken;
        
    } catch (Exception $e) {
        error_log("Session start error: " . $e->getMessage());
        return false;
    }
}

/**
 * Verify user session
 * @return array|false User data if session valid, false otherwise
 */
function verifyUserSession() {
    try {
        if (!isset($_COOKIE['session_token'])) {
            return false;
        }
        
        $pdo = getDBConnection();
        
        // Get session from database
        $stmt = $pdo->prepare("
            SELECT s.user_id, s.expires_at, u.first_name, u.last_name, u.email, u.role, u.institution 
            FROM user_sessions s 
            JOIN users u ON s.user_id = u.id 
            WHERE s.session_token = ? AND s.expires_at > NOW() AND u.is_active = 1
        ");
        $stmt->execute([$_COOKIE['session_token']]);
        $session = $stmt->fetch();
        
        if (!$session) {
            return false;
        }
        
        return [
            'id' => $session['user_id'],
            'first_name' => $session['first_name'],
            'last_name' => $session['last_name'],
            'email' => $session['email'],
            'role' => $session['role'],
            'institution' => $session['institution']
        ];
        
    } catch (Exception $e) {
        error_log("Session verification error: " . $e->getMessage());
        return false;
    }
}

/**
 * Logout user
 * @return bool Success status
 */
function logoutUser() {
    try {
        if (isset($_COOKIE['session_token'])) {
            $pdo = getDBConnection();
            
            // Remove session from database
            $stmt = $pdo->prepare("DELETE FROM user_sessions WHERE session_token = ?");
            $stmt->execute([$_COOKIE['session_token']]);
            
            // Clear session cookie
            setcookie('session_token', '', time() - 3600, '/', '', false, true);
        }
        
        return true;
        
    } catch (Exception $e) {
        error_log("Logout error: " . $e->getMessage());
        return false;
    }
}

/**
 * Check if user is logged in
 * @return bool True if logged in, false otherwise
 */
function isLoggedIn() {
    return verifyUserSession() !== false;
}

/**
 * Get current user data
 * @return array|false User data if logged in, false otherwise
 */
function getCurrentUser() {
    return verifyUserSession();
}

/**
 * Require user to be logged in
 * Redirects to login page if not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

/**
 * Require specific user role
 * @param string|array $requiredRoles Required role(s)
 * @param string $redirectPage Page to redirect to if access denied
 */
function requireRole($requiredRoles, $redirectPage = 'index.php') {
    $user = getCurrentUser();
    if (!$user) {
        header('Location: login.php');
        exit();
    }
    
    if (is_array($requiredRoles)) {
        if (!in_array($user['role'], $requiredRoles)) {
            header('Location: ' . $redirectPage);
            exit();
        }
    } else {
        if ($user['role'] !== $requiredRoles) {
            header('Location: ' . $redirectPage);
            exit();
        }
    }
}
?>
