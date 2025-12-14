<?php
/**
 * Meeting Controller
 * Handles appointments and meetings
 */

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../model/MeetingModel.php';

class MeetingController extends BaseController {
    
    /**
     * Create a meeting
     */
    public function createMeeting() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['advisor_id', 'student_id', 'scheduled_at']);
        
        // Verify permissions
        if ($this->currentUser['role'] === 'student' && $this->currentUser['id'] != $data['student_id']) {
            Response::forbidden('You can only create meetings for yourself');
        }
        
        if ($this->currentUser['role'] === 'advisor' && $this->currentUser['id'] != $data['advisor_id']) {
            Response::forbidden('You can only create meetings as yourself');
        }
        
        $meetingData = [
            'advisor_id' => (int)$data['advisor_id'],
            'student_id' => (int)$data['student_id'],
            'scheduled_at' => $data['scheduled_at'],
            'duration' => $data['duration'] ?? 30,
            'type' => $data['type'] ?? 'General',
            'notes' => isset($data['notes']) ? $this->sanitize($data['notes']) : null
        ];
        
        $meetingModel = new MeetingModel();
        $result = $meetingModel->createMeeting($meetingData);
        
        if ($result['success']) {
            Response::success(['meeting_id' => $result['meeting_id']], $result['message']);
        } else {
            Response::error($result['message'], 400);
        }
    }
    
    /**
     * Get meetings
     */
    public function getMeetings() {
        $this->requireLogin();
        
        $status = $_GET['status'] ?? null;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : null;
        
        $meetingModel = new MeetingModel();
        $meetings = $meetingModel->getMeetings(
            $this->currentUser['id'],
            $this->currentUser['role'],
            $status,
            $limit
        );
        
        Response::success(['meetings' => $meetings], 'Meetings retrieved successfully');
    }
    
    /**
     * Get upcoming meetings
     */
    public function getUpcomingMeetings() {
        $this->requireLogin();
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        
        $meetingModel = new MeetingModel();
        $meetings = $meetingModel->getUpcomingMeetings(
            $this->currentUser['id'],
            $this->currentUser['role'],
            $limit
        );
        
        Response::success(['meetings' => $meetings], 'Upcoming meetings retrieved successfully');
    }
    
    /**
     * Update meeting status
     */
    public function updateStatus() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['meeting_id', 'status']);
        
        $meetingId = (int)$data['meeting_id'];
        $status = $data['status'];
        
        $meetingModel = new MeetingModel();
        $result = $meetingModel->updateMeetingStatus($meetingId, $status);
        
        if ($result['success']) {
            Response::success([], $result['message']);
        } else {
            Response::error($result['message'], 400);
        }
    }
    
    /**
     * Cancel meeting
     */
    public function cancelMeeting() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['meeting_id']);
        
        $meetingId = (int)$data['meeting_id'];
        $reason = isset($data['reason']) ? $this->sanitize($data['reason']) : null;
        
        $meetingModel = new MeetingModel();
        $result = $meetingModel->cancelMeeting($meetingId, $reason);
        
        if ($result) {
            Response::success([], 'Meeting cancelled successfully');
        } else {
            Response::error('Failed to cancel meeting', 500);
        }
    }
    
    /**
     * Reschedule meeting
     */
    public function rescheduleMeeting() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['meeting_id', 'new_datetime']);
        
        $meetingId = (int)$data['meeting_id'];
        $newDateTime = $data['new_datetime'];
        
        $meetingModel = new MeetingModel();
        $result = $meetingModel->rescheduleMeeting($meetingId, $newDateTime);
        
        if ($result) {
            Response::success([], 'Meeting rescheduled successfully');
        } else {
            Response::error('Failed to reschedule meeting', 500);
        }
    }
}
?>

