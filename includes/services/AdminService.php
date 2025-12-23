<?php
/**
 * Admin Service - Business logic for admin operations
 */

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../models/MeetingModel.php';
require_once __DIR__ . '/../../config/database.php';

class AdminService {
    private $userModel;
    private $studentModel;
    private $meetingModel;
    private $pdo;
    
    public function __construct() {
        $this->userModel = new UserModel();
        $this->studentModel = new StudentModel();
        $this->meetingModel = new MeetingModel();
        $this->pdo = getDBConnection();
    }
    
    /**
     * Get admin dashboard data
     */
    public function getDashboardData() {
        $userStats = $this->userModel->getUserStats();
        $recentUsers = $this->userModel->getUsers(['limit' => 10]);
        $activeSessions = $this->getActiveSessions();
        
        return [
            'user_stats' => $userStats,
            'recent_users' => $recentUsers,
            'active_sessions' => $activeSessions,
            'system_stats' => $this->getSystemStats()
        ];
    }
    
    /**
     * Get active sessions
     */
    private function getActiveSessions() {
        $stmt = $this->pdo->query("
            SELECT u.first_name, u.last_name, u.email, u.role, s.created_at, s.ip_address
            FROM user_sessions s
            JOIN users u ON s.user_id = u.id
            WHERE s.expires_at > NOW()
            ORDER BY s.created_at DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Get system statistics
     */
    private function getSystemStats() {
        return [
            'total_meetings' => $this->pdo->query("SELECT COUNT(*) FROM meetings")->fetchColumn(),
            'total_courses' => $this->pdo->query("SELECT COUNT(*) FROM courses WHERE is_active = 1")->fetchColumn(),
            'total_assignments' => $this->pdo->query("SELECT COUNT(*) FROM assignments")->fetchColumn(),
            'total_notifications' => $this->pdo->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0")->fetchColumn()
        ];
    }
    
    /**
     * Manage user (activate/deactivate)
     */
    public function manageUser($userId, $action) {
        if ($action === 'activate') {
            return $this->userModel->updateUser($userId, ['is_active' => 1]);
        } elseif ($action === 'deactivate') {
            return $this->userModel->updateUser($userId, ['is_active' => 0]);
        }
        return false;
    }
}
?>
