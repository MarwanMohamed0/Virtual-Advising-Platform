<?php
/**
 * Contact Model
 * Handles contact form submissions and inquiries
 */

require_once __DIR__ . '/../core/BaseModel.php';

class ContactModel extends BaseModel {
    
    protected $table = 'contacts';
    
    /**
     * Create a new contact inquiry
     */
    public function createContact($data) {
        $sql = "INSERT INTO contacts (full_name, email, phone, subject, message) 
                VALUES (:full_name, :email, :phone, :subject, :message)";
        
        $params = [
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'] ?? null,
            ':subject' => $data['subject'],
            ':message' => $data['message']
        ];
        
        $result = $this->execute($sql, $params);
        
        if ($result) {
            return [
                'success' => true,
                'id' => $this->getLastInsertId(),
                'message' => 'Contact inquiry submitted successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Failed to submit contact inquiry'
        ];
    }
    
    /**
     * Get all contacts (admin only)
     */
    public function getAllContacts($limit = 50, $offset = 0, $status = null) {
        $sql = "SELECT * FROM contacts";
        $params = [];
        
        if ($status) {
            $sql .= " WHERE status = :status";
            $params[':status'] = $status;
        }
        
        $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
        
        return $this->query($sql, $params);
    }
    
    /**
     * Get contact by ID
     */
    public function getContactById($id) {
        $sql = "SELECT * FROM contacts WHERE id = :id";
        $result = $this->query($sql, [':id' => $id]);
        return $result ? $result[0] : null;
    }
    
    /**
     * Update contact status
     */
    public function updateStatus($id, $status) {
        $allowedStatuses = ['new', 'read', 'replied', 'resolved'];
        if (!in_array($status, $allowedStatuses)) {
            return false;
        }
        
        $sql = "UPDATE contacts SET status = :status WHERE id = :id";
        return $this->execute($sql, [
            ':status' => $status,
            ':id' => $id
        ]);
    }
    
    /**
     * Get contact count by status
     */
    public function getContactCounts() {
        $sql = "SELECT status, COUNT(*) as count FROM contacts GROUP BY status";
        $results = $this->query($sql);
        
        $counts = [
            'new' => 0,
            'read' => 0,
            'replied' => 0,
            'resolved' => 0,
            'total' => 0
        ];
        
        foreach ($results as $result) {
            $counts[$result['status']] = (int)$result['count'];
            $counts['total'] += (int)$result['count'];
        }
        
        return $counts;
    }
}
?>

