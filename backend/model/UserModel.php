<?php
/**
 * User Model
 * Handles all user-related database operations
 */

require_once __DIR__ . '/../core/BaseModel.php';

class UserModel extends BaseModel {
    protected $table = 'users';
    
    /**
     * Register a new user
     */
    public function register($userData) {
        // Validate email doesn't exist
        if ($this->findOneBy('email', $userData['email'])) {
            return ['success' => false, 'message' => 'Email already registered'];
        }
        
        // Hash password
        $userData['password_hash'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        unset($userData['password']);
        
        // Set defaults
        $userData['email_verified'] = $userData['email_verified'] ?? 1;
        $userData['is_active'] = $userData['is_active'] ?? 1;
        $userData['newsletter_subscription'] = $userData['newsletter_subscription'] ?? 0;
        
        $userId = $this->create($userData);
        
        if ($userId) {
            $user = $this->findById($userId);
            unset($user['password_hash']);
            return ['success' => true, 'user' => $user, 'message' => 'User registered successfully'];
        }
        
        return ['success' => false, 'message' => 'Failed to register user'];
    }
    
    /**
     * Authenticate user
     */
    public function authenticate($email, $password) {
        $user = $this->findOneBy('email', $email);
        
        if (!$user) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }
        
        if (!$user['is_active']) {
            return ['success' => false, 'message' => 'Account is inactive'];
        }
        
        if (!password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }
        
        // Update last login
        $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
        
        // Remove sensitive data
        unset($user['password_hash']);
        
        return ['success' => true, 'user' => $user];
    }
    
    /**
     * Get user by email
     */
    public function getByEmail($email) {
        $user = $this->findOneBy('email', $email);
        if ($user) {
            unset($user['password_hash']);
        }
        return $user;
    }
    
    /**
     * Get users by role
     */
    public function getByRole($role, $limit = null, $offset = null) {
        $sql = "SELECT id, first_name, last_name, email, role, institution, created_at, last_login, is_active 
                FROM {$this->table} 
                WHERE role = ?";
        
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
            if ($offset) {
                $sql .= " OFFSET " . (int)$offset;
            }
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$role]);
        return $stmt->fetchAll();
    }
    
    /**
     * Update user profile
     */
    public function updateProfile($userId, $data) {
        // Remove fields that shouldn't be updated directly
        unset($data['password'], $data['password_hash'], $data['id'], $data['role']);
        
        return $this->update($userId, $data);
    }
    
    /**
     * Change password
     */
    public function changePassword($userId, $oldPassword, $newPassword) {
        $user = $this->findById($userId);
        
        if (!password_verify($oldPassword, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Current password is incorrect'];
        }
        
        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->update($userId, ['password_hash' => $newHash]);
        
        return ['success' => true, 'message' => 'Password changed successfully'];
    }
    
    /**
     * Get user statistics
     */
    public function getStatistics() {
        return [
            'total' => $this->count(),
            'students' => $this->count(['role' => 'student']),
            'advisors' => $this->count(['role' => 'advisor']),
            'admins' => $this->count(['role' => 'admin']),
            'active' => $this->count(['is_active' => 1]),
            'new_today' => $this->query(
                "SELECT COUNT(*) FROM {$this->table} WHERE DATE(created_at) = CURDATE()"
            )->fetchColumn(),
            'new_week' => $this->query(
                "SELECT COUNT(*) FROM {$this->table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)"
            )->fetchColumn(),
            'new_month' => $this->query(
                "SELECT COUNT(*) FROM {$this->table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)"
            )->fetchColumn()
        ];
    }
}
?>

