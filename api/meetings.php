<?php
/**
 * Meetings API Endpoint
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/models/MeetingModel.php';
require_once __DIR__ . '/../includes/utils/Response.php';
require_once __DIR__ . '/../includes/utils/Validator.php';

header('Content-Type: application/json');

// Check authentication
$user = getCurrentUser();
if (!$user) {
    Response::unauthorized('Authentication required');
}

$method = $_SERVER['REQUEST_METHOD'];
$model = new MeetingModel();

switch ($method) {
    case 'GET':
        $filters = [];
        
        if ($user['role'] === 'student') {
            $filters['student_id'] = $user['id'];
        } elseif ($user['role'] === 'advisor') {
            $filters['advisor_id'] = $user['id'];
        }
        
        if (isset($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        
        if (isset($_GET['upcoming'])) {
            $filters['date_from'] = date('Y-m-d');
        }
        
        $meetings = $model->getMeetings($filters);
        Response::success('Meetings retrieved', $meetings);
        break;
        
    case 'POST':
        $validation = Validator::validateRequired($_POST, ['title', 'meeting_date']);
        if (!$validation['valid']) {
            Response::validationError($validation['errors']);
        }
        
        $meetingData = [
            'student_id' => $user['role'] === 'student' ? $user['id'] : intval($_POST['student_id'] ?? 0),
            'advisor_id' => $user['role'] === 'advisor' ? $user['id'] : intval($_POST['advisor_id'] ?? 0),
            'title' => Validator::sanitizeString($_POST['title']),
            'description' => Validator::sanitizeString($_POST['description'] ?? ''),
            'meeting_date' => $_POST['meeting_date'],
            'duration' => intval($_POST['duration'] ?? 30),
            'type' => $_POST['type'] ?? 'general',
            'location' => Validator::sanitizeString($_POST['location'] ?? 'Virtual')
        ];
        
        if ($user['role'] === 'student' && !$meetingData['advisor_id']) {
            Response::error('Advisor ID is required');
        }
        
        if ($user['role'] === 'advisor' && !$meetingData['student_id']) {
            Response::error('Student ID is required');
        }
        
        $meetingId = $model->createMeeting($meetingData);
        if ($meetingId) {
            Response::success('Meeting created successfully', ['id' => $meetingId]);
        } else {
            Response::error('Failed to create meeting');
        }
        break;
        
    case 'PUT':
    case 'PATCH':
        parse_str(file_get_contents('php://input'), $data);
        
        if (!isset($data['id'])) {
            Response::error('Meeting ID is required');
        }
        
        $meetingId = intval($data['id']);
        $meeting = $model->getMeetingById($meetingId);
        
        if (!$meeting) {
            Response::notFound('Meeting not found');
        }
        
        // Check permissions
        if ($user['role'] === 'student' && $meeting['student_id'] != $user['id']) {
            Response::forbidden('Access denied');
        }
        
        if ($user['role'] === 'advisor' && $meeting['advisor_id'] != $user['id']) {
            Response::forbidden('Access denied');
        }
        
        $updateData = [];
        if (isset($data['title'])) $updateData['title'] = Validator::sanitizeString($data['title']);
        if (isset($data['description'])) $updateData['description'] = Validator::sanitizeString($data['description']);
        if (isset($data['meeting_date'])) $updateData['meeting_date'] = $data['meeting_date'];
        if (isset($data['status'])) $updateData['status'] = $data['status'];
        if (isset($data['notes'])) $updateData['notes'] = Validator::sanitizeString($data['notes']);
        
        $result = $model->updateMeeting($meetingId, $updateData);
        if ($result) {
            Response::success('Meeting updated successfully');
        } else {
            Response::error('Failed to update meeting');
        }
        break;
        
    case 'DELETE':
        if (!isset($_GET['id'])) {
            Response::error('Meeting ID is required');
        }
        
        $meetingId = intval($_GET['id']);
        $meeting = $model->getMeetingById($meetingId);
        
        if (!$meeting) {
            Response::notFound('Meeting not found');
        }
        
        // Check permissions
        if ($user['role'] === 'student' && $meeting['student_id'] != $user['id']) {
            Response::forbidden('Access denied');
        }
        
        if ($user['role'] === 'advisor' && $meeting['advisor_id'] != $user['id']) {
            Response::forbidden('Access denied');
        }
        
        $result = $model->deleteMeeting($meetingId);
        if ($result) {
            Response::success('Meeting deleted successfully');
        } else {
            Response::error('Failed to delete meeting');
        }
        break;
        
    default:
        Response::error('Method not allowed', null, 405);
}
?>
