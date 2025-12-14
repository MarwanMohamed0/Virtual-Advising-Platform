<?php
/**
 * Student Model
 * Handles student-specific data and operations
 */

require_once __DIR__ . '/../core/BaseModel.php';

class StudentModel extends BaseModel {
    
    /**
     * Get student academic progress
     */
    public function getAcademicProgress($studentId) {
        // This would typically join with courses, enrollments, etc.
        // For now, returning structure that can be extended
        $stmt = $this->pdo->prepare("
            SELECT 
                u.id,
                u.first_name,
                u.last_name,
                u.email,
                u.institution
            FROM users u
            WHERE u.id = ? AND u.role = 'student'
        ");
        $stmt->execute([$studentId]);
        $student = $stmt->fetch();
        
        if (!$student) {
            return null;
        }
        
        // Get GPA (would need grades table)
        $gpa = $this->calculateGPA($studentId);
        
        // Get credits (would need enrollments table)
        $credits = $this->getCredits($studentId);
        
        // Get advisor assignment
        $advisor = $this->getAssignedAdvisor($studentId);
        
        return [
            'student' => $student,
            'gpa' => $gpa,
            'credits_completed' => $credits['completed'] ?? 0,
            'credits_required' => $credits['required'] ?? 120,
            'advisor' => $advisor,
            'progress_percentage' => $credits['required'] > 0 
                ? round(($credits['completed'] / $credits['required']) * 100, 2) 
                : 0
        ];
    }
    
    /**
     * Calculate GPA
     */
    private function calculateGPA($studentId) {
        // This would query a grades table
        // For now, return mock data structure
        $stmt = $this->pdo->query("
            SELECT AVG(grade) as gpa 
            FROM student_grades 
            WHERE student_id = $studentId
        ");
        
        try {
            $result = $stmt->fetch();
            return $result ? round($result['gpa'], 2) : 0.0;
        } catch (Exception $e) {
            // Table doesn't exist yet, return default
            return 0.0;
        }
    }
    
    /**
     * Get credits information
     */
    private function getCredits($studentId) {
        // This would query enrollments/courses table
        try {
            $stmt = $this->pdo->query("
                SELECT 
                    SUM(CASE WHEN status = 'completed' THEN credits ELSE 0 END) as completed,
                    SUM(credits) as total
                FROM student_enrollments 
                WHERE student_id = $studentId
            ");
            $result = $stmt->fetch();
            return [
                'completed' => $result['completed'] ?? 0,
                'required' => 120 // Default requirement
            ];
        } catch (Exception $e) {
            return ['completed' => 0, 'required' => 120];
        }
    }
    
    /**
     * Get assigned advisor
     */
    private function getAssignedAdvisor($studentId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT u.id, u.first_name, u.last_name, u.email
                FROM advisor_student_assignments a
                JOIN users u ON a.advisor_id = u.id
                WHERE a.student_id = ? AND a.is_active = 1
                LIMIT 1
            ");
            $stmt->execute([$studentId]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Get upcoming assignments
     */
    public function getUpcomingAssignments($studentId, $limit = 10) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM student_assignments
                WHERE student_id = ? AND due_date >= CURDATE()
                ORDER BY due_date ASC
                LIMIT ?
            ");
            $stmt->execute([$studentId, $limit]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Get recent activities
     */
    public function getRecentActivities($studentId, $limit = 10) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM student_activities
                WHERE student_id = ?
                ORDER BY created_at DESC
                LIMIT ?
            ");
            $stmt->execute([$studentId, $limit]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Get all students
     */
    public function getAllStudents($limit = null, $offset = null) {
        $sql = "SELECT id, first_name, last_name, email, institution, created_at 
                FROM users 
                WHERE role = 'student'";
        
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
            if ($offset) {
                $sql .= " OFFSET " . (int)$offset;
            }
        }
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>

