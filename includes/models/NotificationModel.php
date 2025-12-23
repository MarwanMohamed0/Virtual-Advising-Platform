<?php
/**
 * Notification Model - Handles all notification-related database operations
 */

require_once __DIR__ . '/../../config/database.php';

class NotificationModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    /**
     * Get notification by ID
     */
    public function getNotificationById($notificationId) {
        $stmt = $this->pdo->prepare("SELECT * FROM notifications WHERE id = ?");
        $stmt->execute([$notificationId]);
        return $stmt->fetch();
    }
    
    /**
     * Get notifications for user
     */
    public function getUserNotifications($userId, $filters = []) {
        $sql = "SELECT * FROM notifications WHERE user_id = ?";
        $params = [$userId];
        
        if (isset($filters['is_read'])) {
            $sql .= " AND is_read = ?";
            $params[] = $filters['is_read'];
        }
        
        if (!empty($filters['type'])) {
            $sql .= " AND type = ?";
            $params[] = $filters['type'];
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
     * Create notification
     */
    public function createNotification($notificationData) {
        $stmt = $this->pdo->prepare("
            INSERT INTO notifications (user_id, title, message, type, link)
            VALUES (?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $notificationData['user_id'],
            $notificationData['title'],
            $notificationData['message'],
            $notificationData['type'] ?? 'info',
            $notificationData['link'] ?? null
        ]);
    }
    
    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId) {
        $stmt = $this->pdo->prepare("
            UPDATE notifications 
            SET is_read = 1, read_at = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([$notificationId]);
    }
    
    /**
     * Mark all notifications as read for user
     */
    public function markAllAsRead($userId) {
        $stmt = $this->pdo->prepare("
            UPDATE notifications 
            SET is_read = 1, read_at = NOW() 
            WHERE user_id = ? AND is_read = 0
        ");
        return $stmt->execute([$userId]);
    }
    
    /**
     * Delete notification
     */
    public function deleteNotification($notificationId) {
        $stmt = $this->pdo->prepare("DELETE FROM notifications WHERE id = ?");
        return $stmt->execute([$notificationId]);
    }
    
    /**
     * Get unread count for user
     */
    public function getUnreadCount($userId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
}
?>
