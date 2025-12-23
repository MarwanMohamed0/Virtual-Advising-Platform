<?php
/**
 * Students API Endpoint
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/services/StudentService.php';
require_once __DIR__ . '/../includes/utils/Response.php';
require_once __DIR__ . '/../includes/utils/Validator.php';

header('Content-Type: application/json');

// Check authentication
$user = getCurrentUser();
if (!$user) {
    Response::unauthorized('Authentication required');
}

$method = $_SERVER['REQUEST_METHOD'];
$service = new StudentService();

switch ($method) {
    case 'GET':
        if ($user['role'] === 'student' && isset($_GET['dashboard'])) {
            // Get student dashboard data
            $data = $service->getDashboardData($user['id']);
            Response::success('Dashboard data retrieved', $data);
        } elseif ($user['role'] === 'student' && isset($_GET['progress'])) {
            // Get academic progress
            $data = $service->getAcademicProgress($user['id']);
            Response::success('Academic progress retrieved', $data);
        } else {
            Response::error('Invalid request');
        }
        break;
        
    case 'POST':
        if ($user['role'] === 'student' && isset($_POST['update_profile'])) {
            // Update student profile
            $validation = Validator::validateRequired($_POST, ['major', 'academic_year']);
            if (!$validation['valid']) {
                Response::validationError($validation['errors']);
            }
            
            $result = $service->updateProfile($user['id'], $_POST);
            if ($result) {
                Response::success('Profile updated successfully');
            } else {
                Response::error('Failed to update profile');
            }
        } else {
            Response::error('Invalid request');
        }
        break;
        
    default:
        Response::error('Method not allowed', null, 405);
}
?>
