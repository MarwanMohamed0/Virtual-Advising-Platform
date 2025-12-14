<?php
/**
 * Authentication Controller
 * Handles login, signup, logout, and session management
 */

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../model/SessionModel.php';

class AuthController extends BaseController {
    
    /**
     * Handle login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['email', 'password']);
        
        $email = $this->sanitize($data['email']);
        $password = $data['password'];
        
        $userModel = new UserModel();
        $result = $userModel->authenticate($email, $password);
        
        if (!$result['success']) {
            Response::error($result['message'], 401);
        }
        
        // Create session
        $sessionModel = new SessionModel();
        $sessionResult = $sessionModel->createSession(
            $result['user']['id'],
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null
        );
        
        if (!$sessionResult['success']) {
            Response::error('Failed to create session', 500);
        }
        
        Response::success([
            'user' => $result['user'],
            'token' => $sessionResult['token']
        ], 'Login successful');
    }
    
    /**
     * Handle signup/registration
     */
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['first_name', 'last_name', 'email', 'password', 'institution', 'role']);
        
        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Response::error('Invalid email format', 400);
        }
        
        // Validate role
        $allowedRoles = ['student', 'advisor', 'admin'];
        if (!in_array($data['role'], $allowedRoles)) {
            Response::error('Invalid role selected', 400);
        }
        
        // Validate password strength
        if (strlen($data['password']) < 8) {
            Response::error('Password must be at least 8 characters long', 400);
        }
        
        $userData = [
            'first_name' => $this->sanitize($data['first_name']),
            'last_name' => $this->sanitize($data['last_name']),
            'email' => $this->sanitize($data['email']),
            'password' => $data['password'],
            'institution' => $this->sanitize($data['institution']),
            'role' => $data['role'],
            'newsletter_subscription' => isset($data['newsletter']) ? 1 : 0
        ];
        
        $userModel = new UserModel();
        $result = $userModel->register($userData);
        
        if (!$result['success']) {
            Response::error($result['message'], 400);
        }
        
        Response::success(['user' => $result['user']], $result['message']);
    }
    
    /**
     * Handle logout
     */
    public function logout() {
        if (isset($_COOKIE['session_token'])) {
            $sessionModel = new SessionModel();
            $sessionModel->deleteSession($_COOKIE['session_token']);
        }
        
        Response::success([], 'Logged out successfully');
    }
    
    /**
     * Get current user
     */
    public function getCurrentUser() {
        if (!$this->currentUser) {
            Response::unauthorized();
        }
        
        Response::success(['user' => $this->currentUser], 'User retrieved successfully');
    }
    
    /**
     * Verify session
     */
    public function verifySession() {
        if (isset($_COOKIE['session_token'])) {
            $sessionModel = new SessionModel();
            $user = $sessionModel->verifySession($_COOKIE['session_token']);
            
            if ($user) {
                Response::success(['user' => $user, 'valid' => true], 'Session valid');
            }
        }
        
        Response::success(['valid' => false], 'Session invalid or expired');
    }
}
?>

