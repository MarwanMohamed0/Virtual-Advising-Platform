<?php
/**
 * Assignment Model - Handles all assignment-related database operations
 */

require_once __DIR__ . '/../../config/database.php';

class AssignmentModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    /**
     * Get assignment by ID
     */
    public function getAssignmentById($assignmentId) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.course_code, c.course_name,
                   u.first_name, u.last_name, u.email
            FROM assignments a
            JOIN courses c ON a.course_id = c.id
            JOIN users u ON a.student_id = u.id
            WHERE a.id = ?
        ");
        $stmt->execute([$assignmentId]);
        return $stmt->fetch();
    }
    
    /**
     * Get assignments with filters
     */
    public function getAssignments($filters = []) {
        $sql = "
            SELECT a.*, c.course_code, c.course_name,
                   u.first_name, u.last_name, u.email
            FROM assignments a
            JOIN courses c ON a.course_id = c.id
            JOIN users u ON a.student_id = u.id
            WHERE 1=1
        ";
        $params = [];
        
        if (!empty($filters['student_id'])) {
            $sql .= " AND a.student_id = ?";
            $params[] = $filters['student_id'];
        }
        
        if (!empty($filters['course_id'])) {
            $sql .= " AND a.course_id = ?";
            $params[] = $filters['course_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND a.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['priority'])) {
            $sql .= " AND a.priority = ?";
            $params[] = $filters['priority'];
        }
        
        if (!empty($filters['due_before'])) {
            $sql .= " AND a.due_date <= ?";
            $params[] = $filters['due_before'];
        }
        
        $sql .= " ORDER BY a.due_date ASC";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT ?";
            $params[] = $filters['limit'];
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Create new assignment
     */
    public function createAssignment($assignmentData) {
        $stmt = $this->pdo->prepare("
            INSERT INTO assignments (student_id, course_id, title, description, due_date, 
                                   priority, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $assignmentData['student_id'],
            $assignmentData['course_id'],
            $assignmentData['title'],
            $assignmentData['description'] ?? null,
            $assignmentData['due_date'],
            $assignmentData['priority'] ?? 'medium',
            $assignmentData['status'] ?? 'pending'
        ]);
    }
    
    /**
     * Update assignment
     */
    public function updateAssignment($assignmentId, $assignmentData) {
        $allowedFields = ['title', 'description', 'due_date', 'priority', 'status', 'grade', 'submitted_at'];
        $updates = [];
        $params = [];
        
        foreach ($allowedFields as $field) {
            if (isset($assignmentData[$field])) {
                $updates[] = "$field = ?";
                $params[] = $assignmentData[$field];
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $params[] = $assignmentId;
        $sql = "UPDATE assignments SET " . implode(', ', $updates) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Delete assignment
     */
    public function deleteAssignment($assignmentId) {
        $stmt = $this->pdo->prepare("DELETE FROM assignments WHERE id = ?");
        return $stmt->execute([$assignmentId]);
    }
    
    /**
     * Get upcoming assignments for student
     */
    public function getUpcomingAssignments($studentId, $limit = 10) {
        return $this->getAssignments([
            'student_id' => $studentId,
            'status' => ['pending', 'in_progress'],
            'due_before' => date('Y-m-d', strtotime('+30 days')),
            'limit' => $limit
        ]);
    }
    
    /**
     * Get overdue assignments
     */
    public function getOverdueAssignments($studentId = null) {
        $filters = [
            'status' => ['pending', 'in_progress'],
            'due_before' => date('Y-m-d H:i:s')
        ];
        
        if ($studentId) {
            $filters['student_id'] = $studentId;
        }
        
        return $this->getAssignments($filters);
    }
}
?>
