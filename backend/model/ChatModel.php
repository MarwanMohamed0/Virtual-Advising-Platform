<?php
/**
 * Chat Model
 * Handles chat support and messaging
 */

require_once __DIR__ . '/../core/BaseModel.php';

class ChatModel extends BaseModel {
    protected $table = 'chat_messages';
    
    /**
     * Save chat message
     */
    public function saveMessage($userId, $message, $type = 'user') {
        $data = [
            'user_id' => $userId,
            'message' => $message,
            'type' => $type, // 'user' or 'bot'
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->create($data);
    }
    
    /**
     * Get chat history
     */
    public function getChatHistory($userId, $limit = 50) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM {$this->table}
                WHERE user_id = ?
                ORDER BY created_at DESC
                LIMIT ?
            ");
            $stmt->execute([$userId, $limit]);
            $messages = $stmt->fetchAll();
            
            // Reverse to get chronological order
            return array_reverse($messages);
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Clear chat history
     */
    public function clearHistory($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
    
    /**
     * Get bot response based on message
     */
    public function getBotResponse($message) {
        $lowerMsg = strtolower($message);
        
        // Account/login related
        if (strpos($lowerMsg, 'account') !== false || strpos($lowerMsg, 'login') !== false) {
            return "I can help you with account issues! Could you please specify what problem you're experiencing? For immediate assistance, you can reset your password using the 'Forgot Password' link.";
        }
        
        // Pricing related
        if (strpos($lowerMsg, 'pricing') !== false || strpos($lowerMsg, 'plan') !== false || strpos($lowerMsg, 'cost') !== false) {
            return "We offer three plans:<br><br><strong>Basic:</strong> EGP 2,999/month - Up to 500 students<br><strong>Professional:</strong> EGP 5,999/month - Up to 2,000 students<br><strong>Enterprise:</strong> EGP 12,999/month - Unlimited students<br><br>All include a 30-day free trial!";
        }
        
        // Integration/technical
        if (strpos($lowerMsg, 'integrate') !== false || strpos($lowerMsg, 'setup') !== false || strpos($lowerMsg, 'technical') !== false) {
            return "Our technical team can help with integration! We support SIS, LMS, and various administrative systems. Would you like me to connect you with a technical specialist?";
        }
        
        // Features
        if (strpos($lowerMsg, 'feature') !== false || strpos($lowerMsg, 'what can') !== false) {
            return "MashouraX offers:<br>• 24/7 AI-powered virtual advising<br>• Smart analytics and reporting<br>• Personalized student outreach<br>• Degree planning tools<br>• Mobile app access<br>• Seamless integrations<br><br>Would you like to learn more about any specific feature?";
        }
        
        // Support/help
        if (strpos($lowerMsg, 'help') !== false || strpos($lowerMsg, 'support') !== false) {
            return "I'm here to help! You can ask me about:<br>• Account and login issues<br>• Pricing and plans<br>• Features and capabilities<br>• Technical integration<br>• General questions<br><br>What would you like to know?";
        }
        
        // Default response
        return "Thank you for your message! I'm here to help with questions about MashouraX. Could you provide more details about what you need assistance with?";
    }
}
?>

