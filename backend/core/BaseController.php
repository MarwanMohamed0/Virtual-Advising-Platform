<?php
/**
 * Base Controller Class
 * Provides common functionality for all controllers
 */

class BaseController {
    protected $currentUser;
    
    public function __construct() {
        require_once __DIR__ . '/../../includes/auth.php';
        $this->currentUser = getCurrentUser();
    }
    
    /**
     * Require user to be logged in
     */
    protected function requireLogin() {
        if (!$this->currentUser) {
            $this->jsonResponse(['success' => false, 'message' => 'Authentication required'], 401);
            exit;
        }
    }
    
    /**
     * Require specific role
     */
    protected function requireRole($roles) {
        $this->requireLogin();
        
        if (is_array($roles)) {
            if (!in_array($this->currentUser['role'], $roles)) {
                $this->jsonResponse(['success' => false, 'message' => 'Insufficient permissions'], 403);
                exit;
            }
        } else {
            if ($this->currentUser['role'] !== $roles) {
                $this->jsonResponse(['success' => false, 'message' => 'Insufficient permissions'], 403);
                exit;
            }
        }
    }
    
    /**
     * Send JSON response
     */
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Validate required fields
     */
    protected function validateRequired($data, $requiredFields) {
        $missing = [];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $missing[] = $field;
            }
        }
        
        if (!empty($missing)) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Missing required fields: ' . implode(', ', $missing)
            ], 400);
            exit;
        }
    }
    
    /**
     * Sanitize input
     */
    protected function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Get current user
     */
    protected function getCurrentUser() {
        return $this->currentUser;
    }
    
    /**
     * Get request data
     */
    protected function getRequestData() {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents('php://input'), true);
            return $data ?? [];
        }
        
        return $_POST;
    }
}
?>

