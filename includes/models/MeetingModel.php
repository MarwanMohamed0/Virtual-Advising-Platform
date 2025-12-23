<?php
/**
 * Meeting Model - Handles all meeting/appointment-related database operations
 */

require_once __DIR__ . '/../../config/database.php';

class MeetingModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    /**
     * Get meeting by ID
     */
    public function getMeetingById($meetingId) {
        $stmt = $this->pdo->prepare("
            SELECT m.*, 
                   s.first_name as student_first_name, s.last_name as student_last_name, s.email as student_email,
                   a.first_name as advisor_first_name, a.last_name as advisor_last_name, a.email as advisor_email
            FROM meetings m
            JOIN users s ON m.student_id = s.id
            JOIN users a ON m.advisor_id = a.id
            WHERE m.id = ?
        ");
        $stmt->execute([$meetingId]);
        return $stmt->fetch();
    }
    
    /**
     * Get meetings with filters
     */
    public function getMeetings($filters = []) {
        $sql = "
            SELECT m.*, 
                   s.first_name as student_first_name, s.last_name as student_last_name, s.email as student_email,
                   a.first_name as advisor_first_name, a.last_name as advisor_last_name, a.email as advisor_email
            FROM meetings m
            JOIN users s ON m.student_id = s.id
            JOIN users a ON m.advisor_id = a.id
            WHERE 1=1
        ";
        $params = [];
        
        if (!empty($filters['student_id'])) {
            $sql .= " AND m.student_id = ?";
            $params[] = $filters['student_id'];
        }
        
        if (!empty($filters['advisor_id'])) {
            $sql .= " AND m.advisor_id = ?";
            $params[] = $filters['advisor_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND m.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(m.meeting_date) >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(m.meeting_date) <= ?";
            $params[] = $filters['date_to'];
        }
        
        $sql .= " ORDER BY m.meeting_date ASC";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT ?";
            $params[] = $filters['limit'];
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Create new meeting
     * @return int|false Returns meeting ID on success, false on failure
     */
    public function createMeeting($meetingData) {
        $stmt = $this->pdo->prepare("
            INSERT INTO meetings (student_id, advisor_id, title, description, meeting_date, 
                                duration, type, status, location, meeting_link)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            $meetingData['student_id'],
            $meetingData['advisor_id'],
            $meetingData['title'],
            $meetingData['description'] ?? null,
            $meetingData['meeting_date'],
            $meetingData['duration'] ?? 30,
            $meetingData['type'] ?? 'general',
            $meetingData['status'] ?? 'scheduled',
            $meetingData['location'] ?? 'Virtual',
            $meetingData['meeting_link'] ?? null
        ]);
        
        return $result ? $this->pdo->lastInsertId() : false;
    }
    
    /**
     * Update meeting
     */
    public function updateMeeting($meetingId, $meetingData) {
        $allowedFields = ['title', 'description', 'meeting_date', 'duration', 'type', 
                         'status', 'location', 'meeting_link', 'notes'];
        $updates = [];
        $params = [];
        
        foreach ($allowedFields as $field) {
            if (isset($meetingData[$field])) {
                $updates[] = "$field = ?";
                $params[] = $meetingData[$field];
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $params[] = $meetingId;
        $sql = "UPDATE meetings SET " . implode(', ', $updates) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Delete meeting
     */
    public function deleteMeeting($meetingId) {
        $stmt = $this->pdo->prepare("DELETE FROM meetings WHERE id = ?");
        return $stmt->execute([$meetingId]);
    }
    
    /**
     * Get upcoming meetings for user
     */
    public function getUpcomingMeetings($userId, $role, $limit = 10) {
        $field = $role === 'student' ? 'student_id' : 'advisor_id';
        return $this->getMeetings([
            $field => $userId,
            'status' => ['scheduled', 'confirmed'],
            'date_from' => date('Y-m-d'),
            'limit' => $limit
        ]);
    }
    
    /**
     * Get meeting statistics
     */
    public function getMeetingStats($advisorId = null) {
        $stats = [];
        $where = $advisorId ? "WHERE advisor_id = $advisorId" : "";
        
        $stats['total'] = $this->pdo->query("SELECT COUNT(*) FROM meetings $where")->fetchColumn();
        $stats['scheduled'] = $this->pdo->query("SELECT COUNT(*) FROM meetings $where AND status IN ('scheduled', 'confirmed')")->fetchColumn();
        $stats['completed'] = $this->pdo->query("SELECT COUNT(*) FROM meetings $where AND status = 'completed'")->fetchColumn();
        $stats['today'] = $this->pdo->query("SELECT COUNT(*) FROM meetings $where AND DATE(meeting_date) = CURDATE()")->fetchColumn();
        $stats['this_week'] = $this->pdo->query("SELECT COUNT(*) FROM meetings $where AND WEEK(meeting_date) = WEEK(NOW())")->fetchColumn();
        
        return $stats;
    }
}
?>
