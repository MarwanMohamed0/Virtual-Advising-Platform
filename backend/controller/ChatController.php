<?php
/**
 * Chat Controller
 * Handles chat support and messaging
 */

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../model/ChatModel.php';

class ChatController extends BaseController {
    
    /**
     * Send message
     */
    public function sendMessage() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::error('Method not allowed', 405);
        }
        
        $data = $this->getRequestData();
        $this->validateRequired($data, ['message']);
        
        $message = $this->sanitize($data['message']);
        
        if (empty($message)) {
            Response::error('Message cannot be empty', 400);
        }
        
        try {
            $chatModel = new ChatModel();
            
            // Save user message
            $chatModel->saveMessage($this->currentUser['id'], $message, 'user');
            
            // Get bot response (pass user ID for conversation history context)
            $botResponse = $chatModel->getBotResponse($message, $this->currentUser['id']);
            
            // Save bot response
            $chatModel->saveMessage($this->currentUser['id'], $botResponse, 'bot');
            
            Response::success([
                'response' => $botResponse,
                'time' => date('H:i')
            ], 'Message sent successfully');
        } catch (Exception $e) {
            error_log("Chat error: " . $e->getMessage());
            Response::error('Failed to process message: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Get chat history
     */
    public function getHistory() {
        $this->requireLogin();
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
        
        $chatModel = new ChatModel();
        $history = $chatModel->getChatHistory($this->currentUser['id'], $limit);
        
        Response::success(['history' => $history], 'Chat history retrieved successfully');
    }
    
    /**
     * Clear chat history
     */
    public function clearHistory() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            Response::error('Method not allowed', 405);
        }
        
        $chatModel = new ChatModel();
        $result = $chatModel->clearHistory($this->currentUser['id']);
        
        if ($result) {
            Response::success([], 'Chat history cleared successfully');
        } else {
            Response::error('Failed to clear chat history', 500);
        }
    }
}
?>

