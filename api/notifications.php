<?php
/**
 * Notifications API Endpoint
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/models/NotificationModel.php';
require_once __DIR__ . '/../includes/utils/Response.php';

header('Content-Type: application/json');

// Check authentication
$user = getCurrentUser();
if (!$user) {
    Response::unauthorized('Authentication required');
}

$method = $_SERVER['REQUEST_METHOD'];
$model = new NotificationModel();

switch ($method) {
    case 'GET':
        $filters = [];
        
        if (isset($_GET['unread_only'])) {
            $filters['is_read'] = 0;
        }
        
        if (isset($_GET['type'])) {
            $filters['type'] = $_GET['type'];
        }
        
        if (isset($_GET['limit'])) {
            $filters['limit'] = intval($_GET['limit']);
        } else {
            $filters['limit'] = 20;
        }
        
        $notifications = $model->getUserNotifications($user['id'], $filters);
        $unreadCount = $model->getUnreadCount($user['id']);
        
        Response::success('Notifications retrieved', [
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
        break;
        
    case 'POST':
        if (isset($_POST['mark_read']) && isset($_POST['id'])) {
            // Mark single notification as read
            $result = $model->markAsRead(intval($_POST['id']));
            if ($result) {
                Response::success('Notification marked as read');
            } else {
                Response::error('Failed to mark notification as read');
            }
        } elseif (isset($_POST['mark_all_read'])) {
            // Mark all notifications as read
            $result = $model->markAllAsRead($user['id']);
            if ($result) {
                Response::success('All notifications marked as read');
            } else {
                Response::error('Failed to mark notifications as read');
            }
        } else {
            Response::error('Invalid request');
        }
        break;
        
    case 'DELETE':
        if (!isset($_GET['id'])) {
            Response::error('Notification ID is required');
        }
        
        $result = $model->deleteNotification(intval($_GET['id']));
        if ($result) {
            Response::success('Notification deleted successfully');
        } else {
            Response::error('Failed to delete notification');
        }
        break;
        
    default:
        Response::error('Method not allowed', null, 405);
}
?>
