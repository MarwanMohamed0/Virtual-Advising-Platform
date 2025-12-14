<?php
/**
 * User Controller
 * Handles user profile management and operations
 */

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../model/UserModel.php';

class UserController extends BaseController {
    
    /**
     * Get user profile
     */
    public function getProfile($userId = null) {
        $this->requireLogin();
        
        // If no userId provided, get current user's profile
        if (!$userId) {
            $userId = $this->currentUser['id'];
        }
        
        // Users can only view their own profile unless they're admin
        if ($userId != $this->currentUser['id'] && $this->currentUser['role'] !== 'admin') {
            Response::forbidden();
        }
        
        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        
        if (!$user) {
            Response::notFound('User not found');
        }
        
        unset($user['password_hash']);
        Response::success(['user' => $user], 'Profile retrieved successfully');
    }
    
    /**
     * Update user profile
     */
    public function updateProfile($userId = null) {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
            Response::error('Method not allowed', 405);
        }
        
        if (!$userId) {
            $userId = $this->currentUser['id'];
        }
        
        // Users can only update their own profile unless they're admin
        if ($userId != $this->currentUser['id'] && $this->currentUser['role'] !== 'admin') {
            Response::forbidden();
        }
        
        $data = $this->getRequestData();
        
        // Sanitize allowed fields
        $allowedFields = ['first_name', 'last_name', 'institution', 'newsletter_subscription'];
        $updateData = [];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $updateData[$field] = $this->sanitize($data[$field]);
            }
        }
        
        if (empty($updateData)) {
            Response::error('No valid fields to update', 400);
        }
        
        $userModel = new UserModel();
        $result = $userModel->updateProfile($userId, $updateData);
        
        if ($result) {
            $user = $userModel->findById($userId);
            unset($user['password_hash']);
            Response::success(['user' => $user], 'Profile updated successfully');
        } else {
            Response::error('Failed to update profile', 500);
        }
    }
    
    /**
     * Change password
     */
    public function changePassword() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['old_password', 'new_password']);
        
        if (strlen($data['new_password']) < 8) {
            Response::error('New password must be at least 8 characters long', 400);
        }
        
        $userModel = new UserModel();
        $result = $userModel->changePassword(
            $this->currentUser['id'],
            $data['old_password'],
            $data['new_password']
        );
        
        if ($result['success']) {
            Response::success([], $result['message']);
        } else {
            Response::error($result['message'], 400);
        }
    }
    
    /**
     * Get users list (admin only)
     */
    public function getUsers() {
        $this->requireRole('admin');
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        $role = $_GET['role'] ?? null;
        
        $userModel = new UserModel();
        
        if ($role) {
            $users = $userModel->getByRole($role, $limit, $offset);
        } else {
            $users = $userModel->findAll($limit, $offset);
            // Remove password hashes
            foreach ($users as &$user) {
                unset($user['password_hash']);
            }
        }
        
        Response::success(['users' => $users], 'Users retrieved successfully');
    }
}
?>

