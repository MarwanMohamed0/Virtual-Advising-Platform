<?php
/**
 * Advisor Controller
 * Handles advisor-specific operations and dashboard data
 */

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../model/AdvisorModel.php';
require_once __DIR__ . '/../model/MeetingModel.php';
require_once __DIR__ . '/../model/UserModel.php';

class AdvisorController extends BaseController {
    
    /**
     * Get advisor dashboard data
     */
    public function getDashboard() {
        $this->requireRole('advisor');
        
        $advisorId = $this->currentUser['id'];
        
        $advisorModel = new AdvisorModel();
        $meetingModel = new MeetingModel();
        
        $stats = $advisorModel->getAdvisorStats($advisorId);
        $assignedStudents = $advisorModel->getAssignedStudents($advisorId, 20);
        $upcomingMeetings = $meetingModel->getUpcomingMeetings($advisorId, 'advisor', 10);
        
        Response::success([
            'stats' => $stats,
            'assigned_students' => $assignedStudents,
            'upcoming_meetings' => $upcomingMeetings
        ], 'Dashboard data retrieved successfully');
    }
    
    /**
     * Get advisor statistics
     */
    public function getStats() {
        $this->requireRole('advisor');
        
        $advisorModel = new AdvisorModel();
        $stats = $advisorModel->getAdvisorStats($this->currentUser['id']);
        
        Response::success(['stats' => $stats], 'Statistics retrieved successfully');
    }
    
    /**
     * Get assigned students
     */
    public function getAssignedStudents() {
        $this->requireRole('advisor');
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : null;
        
        $advisorModel = new AdvisorModel();
        $students = $advisorModel->getAssignedStudents($this->currentUser['id'], $limit);
        
        Response::success(['students' => $students], 'Assigned students retrieved successfully');
    }
    
    /**
     * Assign student to advisor
     */
    public function assignStudent() {
        $this->requireRole('advisor');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['student_id']);
        
        $studentId = (int)$data['student_id'];
        
        // Verify student exists and is actually a student
        $userModel = new UserModel();
        $student = $userModel->findById($studentId);
        
        if (!$student || $student['role'] !== 'student') {
            Response::error('Invalid student ID', 400);
        }
        
        $advisorModel = new AdvisorModel();
        $result = $advisorModel->assignStudent($this->currentUser['id'], $studentId);
        
        if ($result['success']) {
            Response::success([], $result['message']);
        } else {
            Response::error($result['message'], 400);
        }
    }
    
    /**
     * Get upcoming meetings
     */
    public function getUpcomingMeetings() {
        $this->requireRole('advisor');
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        
        $meetingModel = new MeetingModel();
        $meetings = $meetingModel->getUpcomingMeetings($this->currentUser['id'], 'advisor', $limit);
        
        Response::success(['meetings' => $meetings], 'Upcoming meetings retrieved successfully');
    }
}
?>

