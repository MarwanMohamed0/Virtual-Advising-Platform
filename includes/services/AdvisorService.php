<?php
/**
 * Advisor Service - Business logic for advisor operations
 */

require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../models/MeetingModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class AdvisorService {
    private $studentModel;
    private $meetingModel;
    private $userModel;
    
    public function __construct() {
        $this->studentModel = new StudentModel();
        $this->meetingModel = new MeetingModel();
        $this->userModel = new UserModel();
    }
    
    /**
     * Get advisor dashboard data
     */
    public function getDashboardData($advisorId) {
        $students = $this->studentModel->getAdvisorStudents($advisorId);
        $atRiskStudents = $this->studentModel->getAtRiskStudents($advisorId);
        $upcomingMeetings = $this->meetingModel->getUpcomingMeetings($advisorId, 'advisor', 10);
        $stats = $this->meetingModel->getMeetingStats($advisorId);
        
        return [
            'stats' => [
                'total_students' => count($students),
                'assigned_students' => count($students),
                'at_risk_students' => count($atRiskStudents),
                'meetings_today' => $stats['today'] ?? 0,
                'meetings_week' => $stats['this_week'] ?? 0,
                'pending_requests' => 0, // TODO: Implement meeting requests
                'urgent_cases' => count($atRiskStudents)
            ],
            'assigned_students' => $students,
            'at_risk_students' => $atRiskStudents,
            'upcoming_meetings' => $upcomingMeetings
        ];
    }
    
    /**
     * Get student details for advisor
     */
    public function getStudentDetails($advisorId, $studentId) {
        $student = $this->studentModel->getStudentProfile($studentId);
        
        // Verify advisor has access to this student
        if ($student && $student['advisor_id'] == $advisorId) {
            return [
                'profile' => $student,
                'meetings' => $this->meetingModel->getMeetings([
                    'student_id' => $studentId,
                    'advisor_id' => $advisorId
                ])
            ];
        }
        
        return null;
    }
    
    /**
     * Assign student to advisor
     */
    public function assignStudent($advisorId, $studentId) {
        return $this->studentModel->assignAdvisor($studentId, $advisorId);
    }
}
?>
