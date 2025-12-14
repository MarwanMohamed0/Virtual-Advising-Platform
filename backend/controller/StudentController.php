<?php
/**
 * Student Controller
 * Handles student-specific operations and dashboard data
 */

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../model/StudentModel.php';
require_once __DIR__ . '/../model/AcademicModel.php';
require_once __DIR__ . '/../model/MeetingModel.php';

class StudentController extends BaseController {
    
    /**
     * Get student dashboard data
     */
    public function getDashboard() {
        $this->requireRole('student');
        
        $studentId = $this->currentUser['id'];
        
        $studentModel = new StudentModel();
        $academicModel = new AcademicModel();
        $meetingModel = new MeetingModel();
        
        $academicProgress = $studentModel->getAcademicProgress($studentId);
        $upcomingAssignments = $academicModel->getStudentAssignments($studentId, 'pending');
        $recentActivities = $studentModel->getRecentActivities($studentId, 10);
        $upcomingMeetings = $meetingModel->getUpcomingMeetings($studentId, 'student', 5);
        
        Response::success([
            'academic_progress' => $academicProgress,
            'upcoming_assignments' => $upcomingAssignments,
            'recent_activities' => $recentActivities,
            'upcoming_meetings' => $upcomingMeetings
        ], 'Dashboard data retrieved successfully');
    }
    
    /**
     * Get academic progress
     */
    public function getAcademicProgress() {
        $this->requireRole('student');
        
        $studentModel = new StudentModel();
        $progress = $studentModel->getAcademicProgress($this->currentUser['id']);
        
        if (!$progress) {
            Response::notFound('Academic progress not found');
        }
        
        Response::success(['progress' => $progress], 'Academic progress retrieved successfully');
    }
    
    /**
     * Get courses
     */
    public function getCourses() {
        $this->requireRole('student');
        
        $academicModel = new AcademicModel();
        $courses = $academicModel->getStudentCourses($this->currentUser['id']);
        
        Response::success(['courses' => $courses], 'Courses retrieved successfully');
    }
    
    /**
     * Get grades
     */
    public function getGrades($courseId = null) {
        $this->requireRole('student');
        
        $academicModel = new AcademicModel();
        $grades = $academicModel->getStudentGrades($this->currentUser['id'], $courseId);
        
        Response::success(['grades' => $grades], 'Grades retrieved successfully');
    }
    
    /**
     * Get assignments
     */
    public function getAssignments($status = null) {
        $this->requireRole('student');
        
        $academicModel = new AcademicModel();
        $assignments = $academicModel->getStudentAssignments($this->currentUser['id'], $status);
        
        Response::success(['assignments' => $assignments], 'Assignments retrieved successfully');
    }
}
?>

