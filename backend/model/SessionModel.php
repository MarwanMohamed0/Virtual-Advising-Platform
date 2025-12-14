<?php
/**
 * Session Model
 * Handles user session management
 */

require_once __DIR__ . '/../core/BaseModel.php';

class SessionModel extends BaseModel {
    protected $table = 'user_sessions';
    
    /**
     * Create a new session
     */
    public function createSession($userId, $ipAddress = null, $userAgent = null) {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $data = [
            'user_id' => $userId,
            'session_token' => $token,
            'expires_at' => $expiresAt,
            'ip_address' => $ipAddress ?? $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $userAgent ?? $_SERVER['HTTP_USER_AGENT'] ?? ''
        ];
        
        $sessionId = $this->create($data);
        
        if ($sessionId) {
            // Set cookie
            setcookie('session_token', $token, time() + (24 * 60 * 60), '/', '', false, true);
            return ['success' => true, 'token' => $token, 'session_id' => $sessionId];
        }
        
        return ['success' => false, 'message' => 'Failed to create session'];
    }
    
    /**
     * Verify session token
     */
    public function verifySession($token) {
        $stmt = $this->pdo->prepare("
            SELECT s.*, u.first_name, u.last_name, u.email, u.role, u.institution, u.is_active
            FROM {$this->table} s
            JOIN users u ON s.user_id = u.id
            WHERE s.session_token = ? AND s.expires_at > NOW() AND u.is_active = 1
        ");
        $stmt->execute([$token]);
        $session = $stmt->fetch();
        
        if ($session) {
            return [
                'id' => $session['user_id'],
                'first_name' => $session['first_name'],
                'last_name' => $session['last_name'],
                'email' => $session['email'],
                'role' => $session['role'],
                'institution' => $session['institution']
            ];
        }
        
        return false;
    }
    
    /**
     * Delete session
     */
    public function deleteSession($token) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE session_token = ?");
        $result = $stmt->execute([$token]);
        
        // Clear cookie
        setcookie('session_token', '', time() - 3600, '/', '', false, true);
        
        return $result;
    }
    
    /**
     * Delete all sessions for a user
     */
    public function deleteUserSessions($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
    
    /**
     * Clean expired sessions
     */
    public function cleanExpiredSessions() {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE expires_at < NOW()");
        return $stmt->execute();
    }
    
    /**
     * Get active sessions count
     */
    public function getActiveSessionsCount() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table} WHERE expires_at > NOW()");
        return $stmt->fetchColumn();
    }
    
    /**
     * Get active sessions with user info
     */
    public function getActiveSessions($limit = 10) {
        $stmt = $this->pdo->prepare("
            SELECT u.first_name, u.last_name, u.email, u.role, s.created_at, s.ip_address
            FROM {$this->table} s
            JOIN users u ON s.user_id = u.id
            WHERE s.expires_at > NOW()
            ORDER BY s.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
?>

