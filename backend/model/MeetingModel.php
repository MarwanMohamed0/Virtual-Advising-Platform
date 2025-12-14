<?php
/**
 * Meeting Model
 * Handles appointments and meetings between advisors and students
 */

require_once __DIR__ . '/../core/BaseModel.php';

class MeetingModel extends BaseModel {
    protected $table = 'meetings';
    
    /**
     * Create a meeting
     */
    public function createMeeting($data) {
        $requiredFields = ['advisor_id', 'student_id', 'scheduled_at'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return ['success' => false, 'message' => "Missing required field: $field"];
            }
        }
        
        $data['status'] = $data['status'] ?? 'scheduled';
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $meetingId = $this->create($data);
        
        if ($meetingId) {
            return ['success' => true, 'meeting_id' => $meetingId, 'message' => 'Meeting scheduled successfully'];
        }
        
        return ['success' => false, 'message' => 'Failed to create meeting'];
    }
    
    /**
     * Get meetings for a user
     */
    public function getMeetings($userId, $role, $status = null, $limit = null) {
        $sql = "
            SELECT 
                m.*,
                advisor.first_name as advisor_first_name,
                advisor.last_name as advisor_last_name,
                advisor.email as advisor_email,
                student.first_name as student_first_name,
                student.last_name as student_last_name,
                student.email as student_email
            FROM {$this->table} m
            JOIN users advisor ON m.advisor_id = advisor.id
            JOIN users student ON m.student_id = student.id
            WHERE ";
        
        if ($role === 'advisor') {
            $sql .= "m.advisor_id = ?";
        } else {
            $sql .= "m.student_id = ?";
        }
        
        if ($status) {
            $sql .= " AND m.status = ?";
        }
        
        $sql .= " ORDER BY m.scheduled_at ASC";
        
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        
        $stmt = $this->pdo->prepare($sql);
        
        if ($status) {
            $stmt->execute([$userId, $status]);
        } else {
            $stmt->execute([$userId]);
        }
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get upcoming meetings
     */
    public function getUpcomingMeetings($userId, $role, $limit = 10) {
        $meetings = $this->getMeetings($userId, $role, 'scheduled', $limit);
        
        // Filter to only upcoming meetings
        $now = date('Y-m-d H:i:s');
        return array_filter($meetings, function($meeting) use ($now) {
            return $meeting['scheduled_at'] >= $now;
        });
    }
    
    /**
     * Update meeting status
     */
    public function updateMeetingStatus($meetingId, $status) {
        $allowedStatuses = ['scheduled', 'confirmed', 'completed', 'cancelled', 'rescheduled'];
        if (!in_array($status, $allowedStatuses)) {
            return ['success' => false, 'message' => 'Invalid status'];
        }
        
        $result = $this->update($meetingId, ['status' => $status]);
        
        return [
            'success' => $result,
            'message' => $result ? 'Meeting status updated' : 'Failed to update meeting status'
        ];
    }
    
    /**
     * Cancel meeting
     */
    public function cancelMeeting($meetingId, $reason = null) {
        $data = ['status' => 'cancelled'];
        if ($reason) {
            $data['cancellation_reason'] = $reason;
        }
        
        return $this->update($meetingId, $data);
    }
    
    /**
     * Reschedule meeting
     */
    public function rescheduleMeeting($meetingId, $newDateTime) {
        return $this->update($meetingId, [
            'scheduled_at' => $newDateTime,
            'status' => 'rescheduled'
        ]);
    }
}
?>

