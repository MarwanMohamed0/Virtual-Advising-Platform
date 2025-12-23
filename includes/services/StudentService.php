<?php
/**
 * Student Service - Business logic for student operations
 */

require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/MeetingModel.php';
require_once __DIR__ . '/../models/AssignmentModel.php';
require_once __DIR__ . '/../models/CourseModel.php';

class StudentService {
    private $studentModel;
    private $userModel;
    private $meetingModel;
    private $assignmentModel;
    private $courseModel;
    
    public function __construct() {
        $this->studentModel = new StudentModel();
        $this->userModel = new UserModel();
        $this->meetingModel = new MeetingModel();
        $this->assignmentModel = new AssignmentModel();
        $this->courseModel = new CourseModel();
    }
    
    /**
     * Get student dashboard data
     */
    public function getDashboardData($userId) {
        $profile = $this->studentModel->getStudentProfile($userId);
        $user = $this->userModel->getUserById($userId);
        
        if (!$profile) {
            // Create default profile if doesn't exist
            $this->studentModel->saveStudentProfile($userId, []);
            $profile = $this->studentModel->getStudentProfile($userId);
        }
        
        return [
            'profile' => $profile,
            'user' => $user,
            'academic_progress' => [
                'gpa' => $profile['gpa'] ?? 0.00,
                'credits_completed' => $profile['credits_completed'] ?? 0,
                'credits_required' => $profile['credits_required'] ?? 120,
                'major' => $profile['major'] ?? 'Not declared',
                'academic_year' => $profile['academic_year'] ?? 'Freshman',
                'status' => $profile['status'] ?? 'active'
            ],
            'upcoming_assignments' => $this->assignmentModel->getUpcomingAssignments($userId, 5),
            'upcoming_meetings' => $this->meetingModel->getUpcomingMeetings($userId, 'student', 5),
            'courses' => $this->courseModel->getStudentCourses($userId)
        ];
    }
    
    /**
     * Update student profile
     */
    public function updateProfile($userId, $profileData) {
        return $this->studentModel->saveStudentProfile($userId, $profileData);
    }
    
    /**
     * Get student academic progress
     */
    public function getAcademicProgress($userId) {
        $profile = $this->studentModel->getStudentProfile($userId);
        $courses = $this->courseModel->getStudentCourses($userId);
        
        $totalCredits = 0;
        $totalPoints = 0;
        
        foreach ($courses as $course) {
            if ($course['status'] === 'completed' && $course['grade']) {
                $credits = $course['credits'] ?? 3;
                $gradePoints = $this->gradeToPoints($course['grade']);
                $totalCredits += $credits;
                $totalPoints += ($gradePoints * $credits);
            }
        }
        
        $gpa = $totalCredits > 0 ? $totalPoints / $totalCredits : 0;
        
        return [
            'gpa' => round($gpa, 2),
            'credits_completed' => $totalCredits,
            'credits_required' => $profile['credits_required'] ?? 120,
            'progress_percentage' => round(($totalCredits / ($profile['credits_required'] ?? 120)) * 100, 2)
        ];
    }
    
    /**
     * Convert letter grade to points
     */
    private function gradeToPoints($grade) {
        $gradeMap = [
            'A+' => 4.0, 'A' => 4.0, 'A-' => 3.7,
            'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
            'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7,
            'D+' => 1.3, 'D' => 1.0, 'D-' => 0.7,
            'F' => 0.0
        ];
        
        return $gradeMap[strtoupper($grade)] ?? 0.0;
    }
}
?>
