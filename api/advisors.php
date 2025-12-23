<?php
/**
 * Advisors API Endpoint
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/services/AdvisorService.php';
require_once __DIR__ . '/../includes/utils/Response.php';

header('Content-Type: application/json');

// Check authentication
$user = getCurrentUser();
if (!$user || $user['role'] !== 'advisor') {
    Response::unauthorized('Advisor access required');
}

$method = $_SERVER['REQUEST_METHOD'];
$service = new AdvisorService();

switch ($method) {
    case 'GET':
        if (isset($_GET['dashboard'])) {
            // Get advisor dashboard data
            $data = $service->getDashboardData($user['id']);
            Response::success('Dashboard data retrieved', $data);
        } elseif (isset($_GET['student']) && isset($_GET['id'])) {
            // Get student details
            $studentId = intval($_GET['id']);
            $data = $service->getStudentDetails($user['id'], $studentId);
            if ($data) {
                Response::success('Student details retrieved', $data);
            } else {
                Response::notFound('Student not found or access denied');
            }
        } else {
            Response::error('Invalid request');
        }
        break;
        
    case 'POST':
        if (isset($_POST['assign_student']) && isset($_POST['student_id'])) {
            // Assign student to advisor
            $studentId = intval($_POST['student_id']);
            $result = $service->assignStudent($user['id'], $studentId);
            if ($result) {
                Response::success('Student assigned successfully');
            } else {
                Response::error('Failed to assign student');
            }
        } else {
            Response::error('Invalid request');
        }
        break;
        
    default:
        Response::error('Method not allowed', null, 405);
}
?>
