<?php
/**
 * Course Model - Handles all course-related database operations
 */

require_once __DIR__ . '/../../config/database.php';

class CourseModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    /**
     * Get course by ID
     */
    public function getCourseById($courseId) {
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$courseId]);
        return $stmt->fetch();
    }
    
    /**
     * Get course by code
     */
    public function getCourseByCode($courseCode) {
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE course_code = ?");
        $stmt->execute([$courseCode]);
        return $stmt->fetch();
    }
    
    /**
     * Get all courses with filters
     */
    public function getCourses($filters = []) {
        $sql = "SELECT * FROM courses WHERE 1=1";
        $params = [];
        
        if (!empty($filters['department'])) {
            $sql .= " AND department = ?";
            $params[] = $filters['department'];
        }
        
        if (isset($filters['is_active'])) {
            $sql .= " AND is_active = ?";
            $params[] = $filters['is_active'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (course_code LIKE ? OR course_name LIKE ?)";
            $searchTerm = "%{$filters['search']}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY course_code";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT ?";
            $params[] = $filters['limit'];
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Create new course
     */
    public function createCourse($courseData) {
        $stmt = $this->pdo->prepare("
            INSERT INTO courses (course_code, course_name, department, credits, description, prerequisites, is_active)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $courseData['course_code'],
            $courseData['course_name'],
            $courseData['department'] ?? null,
            $courseData['credits'] ?? 3,
            $courseData['description'] ?? null,
            $courseData['prerequisites'] ?? null,
            $courseData['is_active'] ?? true
        ]);
    }
    
    /**
     * Update course
     */
    public function updateCourse($courseId, $courseData) {
        $allowedFields = ['course_code', 'course_name', 'department', 'credits', 
                         'description', 'prerequisites', 'is_active'];
        $updates = [];
        $params = [];
        
        foreach ($allowedFields as $field) {
            if (isset($courseData[$field])) {
                $updates[] = "$field = ?";
                $params[] = $courseData[$field];
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $params[] = $courseId;
        $sql = "UPDATE courses SET " . implode(', ', $updates) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Delete course
     */
    public function deleteCourse($courseId) {
        $stmt = $this->pdo->prepare("UPDATE courses SET is_active = 0 WHERE id = ?");
        return $stmt->execute([$courseId]);
    }
    
    /**
     * Get student enrolled courses
     */
    public function getStudentCourses($studentId, $semester = null, $year = null) {
        $sql = "
            SELECT sc.*, c.course_code, c.course_name, c.department, c.credits
            FROM student_courses sc
            JOIN courses c ON sc.course_id = c.id
            WHERE sc.student_id = ?
        ";
        $params = [$studentId];
        
        if ($semester) {
            $sql .= " AND sc.semester = ?";
            $params[] = $semester;
        }
        
        if ($year) {
            $sql .= " AND sc.year = ?";
            $params[] = $year;
        }
        
        $sql .= " ORDER BY sc.semester DESC, sc.year DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Enroll student in course
     */
    public function enrollStudent($studentId, $courseId, $semester, $year) {
        $stmt = $this->pdo->prepare("
            INSERT INTO student_courses (student_id, course_id, semester, year, status)
            VALUES (?, ?, ?, ?, 'enrolled')
            ON DUPLICATE KEY UPDATE status = 'enrolled'
        ");
        
        return $stmt->execute([$studentId, $courseId, $semester, $year]);
    }
}
?>
