<?php
/**
 * Student Model - Handles all student-related database operations
 */

require_once __DIR__ . '/../../config/database.php';

class StudentModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    /**
     * Get student profile by user ID
     */
    public function getStudentProfile($userId) {
        $stmt = $this->pdo->prepare("
            SELECT sp.*, u.first_name, u.last_name, u.email, u.institution,
                   a.first_name as advisor_first_name, a.last_name as advisor_last_name, a.email as advisor_email
            FROM student_profiles sp
            JOIN users u ON sp.user_id = u.id
            LEFT JOIN users a ON sp.advisor_id = a.id
            WHERE sp.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    
    /**
     * Create or update student profile
     */
    public function saveStudentProfile($userId, $profileData) {
        // Check if profile exists
        $stmt = $this->pdo->prepare("SELECT id FROM student_profiles WHERE user_id = ?");
        $stmt->execute([$userId]);
        $exists = $stmt->fetch();
        
        if ($exists) {
            // Update existing profile
            $allowedFields = ['major', 'minor', 'gpa', 'credits_completed', 'credits_required', 
                            'enrollment_year', 'expected_graduation', 'academic_year', 'status', 'advisor_id'];
            $updates = [];
            $params = [];
            
            foreach ($allowedFields as $field) {
                if (isset($profileData[$field])) {
                    $updates[] = "$field = ?";
                    $params[] = $profileData[$field];
                }
            }
            
            if (empty($updates)) {
                return false;
            }
            
            $params[] = $userId;
            $sql = "UPDATE student_profiles SET " . implode(', ', $updates) . " WHERE user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } else {
            // Create new profile
            $stmt = $this->pdo->prepare("
                INSERT INTO student_profiles (user_id, student_id, major, minor, gpa, credits_completed, 
                                            credits_required, enrollment_year, expected_graduation, 
                                            academic_year, status, advisor_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([
                $userId,
                $profileData['student_id'] ?? null,
                $profileData['major'] ?? null,
                $profileData['minor'] ?? null,
                $profileData['gpa'] ?? 0.00,
                $profileData['credits_completed'] ?? 0,
                $profileData['credits_required'] ?? 120,
                $profileData['enrollment_year'] ?? date('Y'),
                $profileData['expected_graduation'] ?? null,
                $profileData['academic_year'] ?? 'Freshman',
                $profileData['status'] ?? 'active',
                $profileData['advisor_id'] ?? null
            ]);
        }
    }
    
    /**
     * Get all students with optional filters
     */
    public function getStudents($filters = []) {
        $sql = "
            SELECT sp.*, u.first_name, u.last_name, u.email, u.institution, u.created_at,
                   a.first_name as advisor_first_name, a.last_name as advisor_last_name
            FROM student_profiles sp
            JOIN users u ON sp.user_id = u.id
            LEFT JOIN users a ON sp.advisor_id = a.id
            WHERE 1=1
        ";
        $params = [];
        
        if (!empty($filters['advisor_id'])) {
            $sql .= " AND sp.advisor_id = ?";
            $params[] = $filters['advisor_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND sp.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['major'])) {
            $sql .= " AND sp.major = ?";
            $params[] = $filters['major'];
        }
        
        $sql .= " ORDER BY u.last_name, u.first_name";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT ?";
            $params[] = $filters['limit'];
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Get students assigned to an advisor
     */
    public function getAdvisorStudents($advisorId) {
        return $this->getStudents(['advisor_id' => $advisorId]);
    }
    
    /**
     * Get at-risk students
     */
    public function getAtRiskStudents($advisorId = null) {
        $filters = ['status' => 'at_risk'];
        if ($advisorId) {
            $filters['advisor_id'] = $advisorId;
        }
        return $this->getStudents($filters);
    }
    
    /**
     * Update student GPA
     */
    public function updateGPA($userId, $gpa) {
        $stmt = $this->pdo->prepare("UPDATE student_profiles SET gpa = ? WHERE user_id = ?");
        return $stmt->execute([$gpa, $userId]);
    }
    
    /**
     * Update student credits
     */
    public function updateCredits($userId, $creditsCompleted) {
        $stmt = $this->pdo->prepare("UPDATE student_profiles SET credits_completed = ? WHERE user_id = ?");
        return $stmt->execute([$creditsCompleted, $userId]);
    }
    
    /**
     * Assign advisor to student
     */
    public function assignAdvisor($userId, $advisorId) {
        $stmt = $this->pdo->prepare("UPDATE student_profiles SET advisor_id = ? WHERE user_id = ?");
        return $stmt->execute([$advisorId, $userId]);
    }
}
?>
