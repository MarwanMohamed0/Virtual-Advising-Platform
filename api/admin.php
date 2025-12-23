<?php
/**
 * Admin API Endpoint
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/services/AdminService.php';
require_once __DIR__ . '/../includes/utils/Response.php';

header('Content-Type: application/json');

// Check authentication
$user = getCurrentUser();
if (!$user || $user['role'] !== 'admin') {
    Response::unauthorized('Admin access required');
}

$method = $_SERVER['REQUEST_METHOD'];
$service = new AdminService();

switch ($method) {
    case 'GET':
        if (isset($_GET['dashboard'])) {
            // Get admin dashboard data
            $data = $service->getDashboardData();
            Response::success('Dashboard data retrieved', $data);
        } else {
            Response::error('Invalid request');
        }
        break;
        
    case 'POST':
        if (isset($_POST['manage_user']) && isset($_POST['user_id']) && isset($_POST['action'])) {
            // Manage user (activate/deactivate)
            $userId = intval($_POST['user_id']);
            $action = $_POST['action'];
            $result = $service->manageUser($userId, $action);
            if ($result) {
                Response::success("User $action successfully");
            } else {
                Response::error('Failed to manage user');
            }
        } else {
            Response::error('Invalid request');
        }
        break;
        
    default:
        Response::error('Method not allowed', null, 405);
}
?>
