<?php
/**
 * Contact Controller
 * Handles contact form submissions
 */

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../model/ContactModel.php';

class ContactController extends BaseController {
    
    /**
     * Submit contact form
     */
    public function submitContact() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['full_name', 'email', 'subject', 'message']);
        
        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Response::error('Invalid email format', 400);
        }
        
        // Sanitize input
        $contactData = [
            'full_name' => $this->sanitize($data['full_name']),
            'email' => $this->sanitize($data['email']),
            'phone' => isset($data['phone']) ? $this->sanitize($data['phone']) : null,
            'subject' => $this->sanitize($data['subject']),
            'message' => $this->sanitize($data['message'])
        ];
        
        $contactModel = new ContactModel();
        $result = $contactModel->createContact($contactData);
        
        if ($result['success']) {
            Response::success(['id' => $result['id']], $result['message']);
        } else {
            Response::error($result['message'], 500);
        }
    }
    
    /**
     * Get all contacts (admin only)
     */
    public function getAllContacts() {
        $this->requireRole('admin');
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        $status = $_GET['status'] ?? null;
        
        $contactModel = new ContactModel();
        $contacts = $contactModel->getAllContacts($limit, $offset, $status);
        
        Response::success(['contacts' => $contacts], 'Contacts retrieved successfully');
    }
    
    /**
     * Get contact by ID (admin only)
     */
    public function getContact($id) {
        $this->requireRole('admin');
        
        $contactModel = new ContactModel();
        $contact = $contactModel->getContactById($id);
        
        if (!$contact) {
            Response::notFound('Contact not found');
        }
        
        Response::success(['contact' => $contact], 'Contact retrieved successfully');
    }
    
    /**
     * Update contact status (admin only)
     */
    public function updateStatus() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['id', 'status']);
        
        $contactModel = new ContactModel();
        $result = $contactModel->updateStatus($data['id'], $data['status']);
        
        if ($result) {
            Response::success([], 'Contact status updated successfully');
        } else {
            Response::error('Failed to update contact status', 500);
        }
    }
    
    /**
     * Get contact statistics (admin only)
     */
    public function getStats() {
        $this->requireRole('admin');
        
        $contactModel = new ContactModel();
        $counts = $contactModel->getContactCounts();
        
        Response::success(['stats' => $counts], 'Contact statistics retrieved successfully');
    }
}
?>

