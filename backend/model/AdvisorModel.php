<?php
/**
 * Advisor Model
 * Handles advisor-specific data and operations
 */

require_once __DIR__ . '/../core/BaseModel.php';

class AdvisorModel extends BaseModel {
    
    /**
     * Get advisor statistics
     */
    public function getAdvisorStats($advisorId) {
        $totalStudents = $this->pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
        
        $assignedCount = $this->getAssignedStudentsCount($advisorId);
        $meetingsToday = $this->getMeetingsCount($advisorId, 'today');
        $meetingsWeek = $this->getMeetingsCount($advisorId, 'week');
        $pendingRequests = $this->getPendingRequestsCount($advisorId);
        $urgentCases = $this->getUrgentCasesCount($advisorId);
        
        return [
            'total_students' => $totalStudents,
            'assigned_students' => $assignedCount,
            'meetings_today' => $meetingsToday,
            'meetings_week' => $meetingsWeek,
            'pending_requests' => $pendingRequests,
            'urgent_cases' => $urgentCases
        ];
    }
    
    /**
     * Get assigned students
     */
    public function getAssignedStudents($advisorId, $limit = null) {
        try {
            $sql = "
                SELECT 
                    u.id,
                    u.first_name,
                    u.last_name,
                    u.email,
                    u.institution,
                    a.assigned_at,
                    a.is_active
                FROM advisor_student_assignments a
                JOIN users u ON a.student_id = u.id
                WHERE a.advisor_id = ? AND a.is_active = 1
                ORDER BY u.last_name, u.first_name
            ";
            
            if ($limit) {
                $sql .= " LIMIT " . (int)$limit;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$advisorId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Get assigned students count
     */
    private function getAssignedStudentsCount($advisorId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) 
                FROM advisor_student_assignments 
                WHERE advisor_id = ? AND is_active = 1
            ");
            $stmt->execute([$advisorId]);
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get meetings count
     */
    private function getMeetingsCount($advisorId, $period = 'today') {
        try {
            $sql = "SELECT COUNT(*) FROM meetings WHERE advisor_id = ?";
            
            if ($period === 'today') {
                $sql .= " AND DATE(scheduled_at) = CURDATE()";
            } elseif ($period === 'week') {
                $sql .= " AND scheduled_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$advisorId]);
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get pending requests count
     */
    private function getPendingRequestsCount($advisorId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) 
                FROM meeting_requests 
                WHERE advisor_id = ? AND status = 'pending'
            ");
            $stmt->execute([$advisorId]);
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get urgent cases count
     */
    private function getUrgentCasesCount($advisorId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) 
                FROM advisor_student_assignments a
                JOIN users u ON a.student_id = u.id
                WHERE a.advisor_id = ? AND a.is_active = 1
                AND (SELECT gpa FROM student_grades WHERE student_id = u.id ORDER BY id DESC LIMIT 1) < 2.0
            ");
            $stmt->execute([$advisorId]);
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get upcoming meetings
     */
    public function getUpcomingMeetings($advisorId, $limit = 10) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    m.*,
                    u.first_name as student_first_name,
                    u.last_name as student_last_name,
                    u.email as student_email
                FROM meetings m
                JOIN users u ON m.student_id = u.id
                WHERE m.advisor_id = ? AND m.scheduled_at >= NOW()
                ORDER BY m.scheduled_at ASC
                LIMIT ?
            ");
            $stmt->execute([$advisorId, $limit]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Assign student to advisor
     */
    public function assignStudent($advisorId, $studentId) {
        try {
            // Check if assignment already exists
            $stmt = $this->pdo->prepare("
                SELECT id FROM advisor_student_assignments 
                WHERE advisor_id = ? AND student_id = ?
            ");
            $stmt->execute([$advisorId, $studentId]);
            
            if ($stmt->fetch()) {
                return ['success' => false, 'message' => 'Student already assigned'];
            }
            
            // Create assignment
            $stmt = $this->pdo->prepare("
                INSERT INTO advisor_student_assignments (advisor_id, student_id, assigned_at, is_active)
                VALUES (?, ?, NOW(), 1)
            ");
            $stmt->execute([$advisorId, $studentId]);
            
            return ['success' => true, 'message' => 'Student assigned successfully'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to assign student'];
        }
    }
}
?>

