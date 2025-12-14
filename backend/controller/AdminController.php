<?php
/**
 * Admin Controller
 * Handles admin operations and system management
 */

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../model/AdminModel.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../model/SessionModel.php';

class AdminController extends BaseController {
    
    /**
     * Get admin dashboard data
     */
    public function getDashboard() {
        $this->requireRole('admin');
        
        $adminModel = new AdminModel();
        $systemStats = $adminModel->getSystemStats();
        $recentUsers = $adminModel->getRecentUsers(10);
        $activeSessions = $adminModel->getActiveSessions(10);
        
        Response::success([
            'system_stats' => $systemStats,
            'recent_users' => $recentUsers,
            'active_sessions' => $activeSessions
        ], 'Dashboard data retrieved successfully');
    }
    
    /**
     * Get system statistics
     */
    public function getSystemStats() {
        $this->requireRole('admin');
        
        $adminModel = new AdminModel();
        $stats = $adminModel->getSystemStats();
        
        Response::success(['stats' => $stats], 'System statistics retrieved successfully');
    }
    
    /**
     * Get all users
     */
    public function getAllUsers() {
        $this->requireRole('admin');
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        $role = $_GET['role'] ?? null;
        
        $userModel = new UserModel();
        
        if ($role) {
            $users = $userModel->getByRole($role, $limit, $offset);
        } else {
            $users = $userModel->findAll($limit, $offset);
            foreach ($users as &$user) {
                unset($user['password_hash']);
            }
        }
        
        Response::success(['users' => $users], 'Users retrieved successfully');
    }
    
    /**
     * Update user status
     */
    public function updateUserStatus() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['user_id', 'is_active']);
        
        $userId = (int)$data['user_id'];
        $isActive = (bool)$data['is_active'];
        
        $adminModel = new AdminModel();
        $result = $adminModel->updateUserStatus($userId, $isActive);
        
        if ($result) {
            Response::success([], 'User status updated successfully');
        } else {
            Response::error('Failed to update user status', 500);
        }
    }
    
    /**
     * Update user role
     */
    public function updateUserRole() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['user_id', 'role']);
        
        $userId = (int)$data['user_id'];
        $newRole = $data['role'];
        
        $adminModel = new AdminModel();
        $result = $adminModel->updateUserRole($userId, $newRole);
        
        if ($result['success']) {
            Response::success([], $result['message']);
        } else {
            Response::error($result['message'], 400);
        }
    }
    
    /**
     * Delete user
     */
    public function deleteUser($userId) {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::error('Method not allowed', 405);
        }
        
        $userId = (int)$userId;
        
        $adminModel = new AdminModel();
        $result = $adminModel->deleteUser($userId);
        
        if ($result['success']) {
            Response::success([], $result['message']);
        } else {
            Response::error($result['message'], 400);
        }
    }
    
    /**
     * Get active sessions
     */
    public function getActiveSessions() {
        $this->requireRole('admin');
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        
        $adminModel = new AdminModel();
        $sessions = $adminModel->getActiveSessions($limit);
        
        Response::success(['sessions' => $sessions], 'Active sessions retrieved successfully');
    }
}
?>

