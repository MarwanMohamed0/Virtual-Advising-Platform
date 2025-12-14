<?php
/**
 * Admin Model
 * Handles admin-specific operations and system management
 */

require_once __DIR__ . '/../core/BaseModel.php';

class AdminModel extends BaseModel {
    
    /**
     * Get system statistics
     */
    public function getSystemStats() {
        $userModel = new UserModel();
        $sessionModel = new SessionModel();
        
        $userStats = $userModel->getStatistics();
        $activeSessions = $sessionModel->getActiveSessionsCount();
        
        return [
            'users' => $userStats,
            'active_sessions' => $activeSessions,
            'system_health' => $this->checkSystemHealth()
        ];
    }
    
    /**
     * Get recent users
     */
    public function getRecentUsers($limit = 10) {
        $stmt = $this->pdo->query("
            SELECT id, first_name, last_name, email, role, institution, created_at 
            FROM users 
            ORDER BY created_at DESC 
            LIMIT " . (int)$limit
        );
        return $stmt->fetchAll();
    }
    
    /**
     * Get active sessions
     */
    public function getActiveSessions($limit = 10) {
        $sessionModel = new SessionModel();
        return $sessionModel->getActiveSessions($limit);
    }
    
    /**
     * Update user status
     */
    public function updateUserStatus($userId, $isActive) {
        $userModel = new UserModel();
        return $userModel->update($userId, ['is_active' => $isActive ? 1 : 0]);
    }
    
    /**
     * Delete user
     */
    public function deleteUser($userId) {
        $userModel = new UserModel();
        
        // Don't allow deleting yourself
        $currentUser = $this->getCurrentUser();
        if ($currentUser && $currentUser['id'] == $userId) {
            return ['success' => false, 'message' => 'Cannot delete your own account'];
        }
        
        $result = $userModel->delete($userId);
        return ['success' => $result, 'message' => $result ? 'User deleted successfully' : 'Failed to delete user'];
    }
    
    /**
     * Update user role
     */
    public function updateUserRole($userId, $newRole) {
        $allowedRoles = ['student', 'advisor', 'admin'];
        if (!in_array($newRole, $allowedRoles)) {
            return ['success' => false, 'message' => 'Invalid role'];
        }
        
        $userModel = new UserModel();
        $result = $userModel->update($userId, ['role' => $newRole]);
        
        return ['success' => $result, 'message' => $result ? 'Role updated successfully' : 'Failed to update role'];
    }
    
    /**
     * Check system health
     */
    private function checkSystemHealth() {
        try {
            // Check database connection
            $this->pdo->query("SELECT 1");
            
            // Check if critical tables exist
            $tables = ['users', 'user_sessions'];
            foreach ($tables as $table) {
                $stmt = $this->pdo->query("SHOW TABLES LIKE '$table'");
                if (!$stmt->fetch()) {
                    return ['status' => 'warning', 'message' => "Table $table missing"];
                }
            }
            
            return ['status' => 'healthy', 'message' => 'All systems operational'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Get current user (helper method)
     */
    private function getCurrentUser() {
        require_once __DIR__ . '/../../includes/auth.php';
        return getCurrentUser();
    }
}
?>

