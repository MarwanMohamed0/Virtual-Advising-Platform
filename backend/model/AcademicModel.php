<?php
/**
 * Academic Model
 * Handles academic data like courses, grades, assignments
 */

require_once __DIR__ . '/../core/BaseModel.php';

class AcademicModel extends BaseModel {
    
    /**
     * Get student courses
     */
    public function getStudentCourses($studentId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    e.*,
                    c.course_code,
                    c.course_name,
                    c.credits,
                    c.instructor
                FROM student_enrollments e
                JOIN courses c ON e.course_id = c.id
                WHERE e.student_id = ?
                ORDER BY c.course_code
            ");
            $stmt->execute([$studentId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Get student grades
     */
    public function getStudentGrades($studentId, $courseId = null) {
        try {
            $sql = "
                SELECT 
                    g.*,
                    c.course_code,
                    c.course_name
                FROM student_grades g
                JOIN courses c ON g.course_id = c.id
                WHERE g.student_id = ?
            ";
            
            $params = [$studentId];
            
            if ($courseId) {
                $sql .= " AND g.course_id = ?";
                $params[] = $courseId;
            }
            
            $sql .= " ORDER BY g.created_at DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Get student assignments
     */
    public function getStudentAssignments($studentId, $status = null) {
        try {
            $sql = "
                SELECT 
                    a.*,
                    c.course_code,
                    c.course_name
                FROM student_assignments a
                JOIN courses c ON a.course_id = c.id
                WHERE a.student_id = ?
            ";
            
            $params = [$studentId];
            
            if ($status) {
                $sql .= " AND a.status = ?";
                $params[] = $status;
            }
            
            $sql .= " ORDER BY a.due_date ASC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Calculate overall GPA
     */
    public function calculateGPA($studentId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT AVG(grade) as gpa
                FROM student_grades
                WHERE student_id = ?
            ");
            $stmt->execute([$studentId]);
            $result = $stmt->fetch();
            return $result ? round($result['gpa'], 2) : 0.0;
        } catch (Exception $e) {
            return 0.0;
        }
    }
    
    /**
     * Get total credits
     */
    public function getTotalCredits($studentId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    SUM(CASE WHEN e.status = 'completed' THEN c.credits ELSE 0 END) as completed,
                    SUM(c.credits) as total
                FROM student_enrollments e
                JOIN courses c ON e.course_id = c.id
                WHERE e.student_id = ?
            ");
            $stmt->execute([$studentId]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return ['completed' => 0, 'total' => 0];
        }
    }
}
?>

