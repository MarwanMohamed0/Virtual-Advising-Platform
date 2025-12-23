<?php
/**
 * Logger - Activity logging utilities
 */

require_once __DIR__ . '/../../config/database.php';

class Logger {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    /**
     * Log activity
     */
    public function log($userId, $action, $entityType = null, $entityId = null, $description = null) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO activity_logs (user_id, action, entity_type, entity_id, description, ip_address, user_agent)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([
                $userId,
                $action,
                $entityType,
                $entityId,
                $description,
                $_SERVER['REMOTE_ADDR'] ?? null,
                $_SERVER['HTTP_USER_AGENT'] ?? null
            ]);
        } catch (Exception $e) {
            error_log("Logging error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get activity logs
     */
    public function getLogs($filters = []) {
        $sql = "SELECT * FROM activity_logs WHERE 1=1";
        $params = [];
        
        if (!empty($filters['user_id'])) {
            $sql .= " AND user_id = ?";
            $params[] = $filters['user_id'];
        }
        
        if (!empty($filters['action'])) {
            $sql .= " AND action = ?";
            $params[] = $filters['action'];
        }
        
        if (!empty($filters['entity_type'])) {
            $sql .= " AND entity_type = ?";
            $params[] = $filters['entity_type'];
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
}
?>
