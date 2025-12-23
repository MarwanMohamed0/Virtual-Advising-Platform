<?php
/**
 * User Model - Handles all user-related database operations
 */

require_once __DIR__ . '/../../config/database.php';

class UserModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    /**
     * Get user by ID
     */
    public function getUserById($userId) {
        $stmt = $this->pdo->prepare("
            SELECT id, first_name, last_name, email, role, institution, 
                   newsletter_subscription, email_verified, created_at, last_login, is_active
            FROM users 
            WHERE id = ? AND is_active = 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    
    /**
     * Get user by email
     */
    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("
            SELECT id, first_name, last_name, email, password_hash, role, institution, 
                   newsletter_subscription, email_verified, created_at, last_login, is_active
            FROM users 
            WHERE email = ? AND is_active = 1
        ");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    /**
     * Get all users with optional filters
     */
    public function getUsers($filters = []) {
        $sql = "SELECT id, first_name, last_name, email, role, institution, created_at, last_login, is_active FROM users WHERE 1=1";
        $params = [];
        
        if (!empty($filters['role'])) {
            $sql .= " AND role = ?";
            $params[] = $filters['role'];
        }
        
        if (!empty($filters['institution'])) {
            $sql .= " AND institution = ?";
            $params[] = $filters['institution'];
        }
        
        if (isset($filters['is_active'])) {
            $sql .= " AND is_active = ?";
            $params[] = $filters['is_active'];
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT ?";
            $params[] = $filters['limit'];
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Create new user
     */
    public function createUser($userData) {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password_hash, institution, role, newsletter_subscription, email_verified)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['password_hash'],
            $userData['institution'],
            $userData['role'],
            $userData['newsletter_subscription'] ?? false,
            $userData['email_verified'] ?? true
        ]);
    }
    
    /**
     * Update user
     */
    public function updateUser($userId, $userData) {
        $allowedFields = ['first_name', 'last_name', 'email', 'institution', 'newsletter_subscription', 'is_active'];
        $updates = [];
        $params = [];
        
        foreach ($allowedFields as $field) {
            if (isset($userData[$field])) {
                $updates[] = "$field = ?";
                $params[] = $userData[$field];
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $params[] = $userId;
        $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Update password
     */
    public function updatePassword($userId, $passwordHash) {
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        return $stmt->execute([$passwordHash, $userId]);
    }
    
    /**
     * Delete user (soft delete)
     */
    public function deleteUser($userId) {
        $stmt = $this->pdo->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
        return $stmt->execute([$userId]);
    }
    
    /**
     * Get user statistics
     */
    public function getUserStats() {
        $stats = [];
        
        $stats['total'] = $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $stats['students'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
        $stats['advisors'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE role = 'advisor'")->fetchColumn();
        $stats['admins'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
        $stats['active'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE is_active = 1")->fetchColumn();
        $stats['new_today'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()")->fetchColumn();
        $stats['new_week'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn();
        $stats['new_month'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn();
        
        return $stats;
    }
    
    /**
     * Search users
     */
    public function searchUsers($query, $limit = 20) {
        $searchTerm = "%$query%";
        $stmt = $this->pdo->prepare("
            SELECT id, first_name, last_name, email, role, institution, created_at
            FROM users
            WHERE (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)
            AND is_active = 1
            ORDER BY first_name, last_name
            LIMIT ?
        ");
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $limit]);
        return $stmt->fetchAll();
    }
}
?>
