<?php
/**
 * Chat Model
 * Handles chat support and messaging
 */

require_once __DIR__ . '/../core/BaseModel.php';
require_once __DIR__ . '/../../config/api.php';

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
     * Get bot response using Gemini AI or fallback to keyword matching
     * 
     * @param string $message User's message
     * @param int|null $userId User ID for conversation history (optional)
     * @return string Bot response
     */
    public function getBotResponse($message, $userId = null) {
        // Always try to use Gemini AI if configured - it can answer ANY question
        if (isGeminiConfigured()) {
            try {
                require_once __DIR__ . '/../services/GeminiService.php';
                $geminiService = new GeminiService();
                
                // Get conversation history for context (last 10 messages)
                $conversationHistory = [];
                if ($userId !== null) {
                    $history = $this->getChatHistory($userId, 10);
                    // Format history for Gemini API
                    foreach ($history as $msg) {
                        $conversationHistory[] = [
                            'type' => $msg['type'],
                            'message' => $msg['message']
                        ];
                    }
                }
                
                // Generate AI response - Gemini can handle ANY question
                $response = $geminiService->generateResponse($message, $conversationHistory);
                
                // Clean up HTML tags if needed (Gemini might return markdown)
                $response = $this->formatResponse($response);
                
                return $response;
            } catch (Exception $e) {
                // Log detailed error for debugging
                $errorMsg = $e->getMessage();
                error_log("Gemini API Error: " . $errorMsg);
                
                // Check if it's a quota exceeded error (429)
                if (strpos($errorMsg, '429') !== false || strpos($errorMsg, 'quota') !== false || strpos($errorMsg, 'QUOTA_EXCEEDED') !== false) {
                    // Quota exceeded - show helpful message and suggest solutions
                    error_log("Gemini API quota exceeded, using keyword fallback");
                    
                    // Try keyword matching first
                    $keywordResponse = $this->getKeywordResponse($message);
                    
                    // If keyword matching gives a generic response, add quota notice
                    if (strpos($keywordResponse, "I can help answer that!") !== false || 
                        strpos($keywordResponse, "I'd be happy to help") !== false) {
                        return $keywordResponse . "<br><br><div style='background: #fff3cd; border-left: 4px solid #ffc107; padding: 12px; margin-top: 12px; border-radius: 4px;'><strong>⚠️ Note:</strong> The Gemini AI service is currently unavailable due to quota limits. " .
                               "To enable full AI responses that can answer ANY question, please:<br>" .
                               "1. Wait for quota reset (usually 24 hours), or<br>" .
                               "2. Get a new API key from <a href='https://makersuite.google.com/app/apikey' target='_blank'>Google AI Studio</a>, or<br>" .
                               "3. Upgrade your plan at <a href='https://ai.google.dev/pricing' target='_blank'>Google AI Pricing</a><br><br>" .
                               "Once quota is available, I'll be able to answer any question just like Gemini! 🚀</div>";
                    }
                    
                    return $keywordResponse;
                }
                
                // For other errors, try keyword matching as fallback
                error_log("Gemini API Error Trace: " . $e->getTraceAsString());
                return $this->getKeywordResponse($message);
            }
        }
        
        // Fallback to keyword-based responses if Gemini is not configured
        return $this->getKeywordResponse($message);
    }
    
    /**
     * Format AI response (convert markdown to HTML if needed)
     * 
     * @param string $response Raw AI response
     * @return string Formatted response
     */
    private function formatResponse($response) {
        // Convert markdown bold to HTML
        $response = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $response);
        // Convert markdown italic to HTML
        $response = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $response);
        // Convert line breaks
        $response = nl2br($response);
        
        return $response;
    }
    
    /**
     * Get keyword-based response (fallback method)
     * 
     * @param string $message User's message
     * @return string Bot response
     */
    private function getKeywordResponse($message) {
        $lowerMsg = strtolower(trim($message));
        $trimmedMsg = trim($message);
        
        // FIRST: Handle general knowledge questions that can be answered directly
        // Capital cities
        if (preg_match('/(what.*capital.*of|capital.*of.*is)/i', $lowerMsg)) {
            if (strpos($lowerMsg, 'france') !== false) {
                return "The capital of France is <strong>Paris</strong>. 🇫🇷<br><br>Paris is not only the capital but also the largest city in France, known for its rich history, art, culture, and landmarks like the Eiffel Tower and the Louvre Museum.";
            }
            if (strpos($lowerMsg, 'egypt') !== false) {
                return "The capital of Egypt is <strong>Cairo</strong>. 🇪🇬<br><br>Cairo is the largest city in Egypt and Africa, located on the banks of the Nile River.";
            }
            if (strpos($lowerMsg, 'usa') !== false || strpos($lowerMsg, 'united states') !== false || strpos($lowerMsg, 'america') !== false) {
                return "The capital of the United States is <strong>Washington, D.C.</strong> 🇺🇸<br><br>Washington D.C. is not part of any state and serves as the federal capital.";
            }
            if (strpos($lowerMsg, 'uk') !== false || strpos($lowerMsg, 'britain') !== false || strpos($lowerMsg, 'england') !== false) {
                return "The capital of the United Kingdom is <strong>London</strong>. 🇬🇧<br><br>London is also the capital of England and is one of the world's major global cities.";
            }
            return "I'd be happy to tell you about capital cities! Could you specify which country you're asking about? For example: 'What is the capital of France?'";
        }
        
        // General "what is" questions - try to answer common ones
        if (preg_match('/^what is (.+)\?/i', $trimmedMsg, $matches)) {
            $subject = strtolower(trim($matches[1]));
            
            // Common definitions
            if (strpos($subject, 'gpa') !== false) {
                return "GPA stands for <strong>Grade Point Average</strong>. It's a numerical representation of your academic performance, typically on a scale of 0.0 to 4.0. It's calculated by averaging the grade points earned in all your courses, weighted by credit hours.";
            }
            if (strpos($subject, 'ai') !== false && strpos($subject, 'artificial intelligence') === false) {
                return "AI stands for <strong>Artificial Intelligence</strong>. It refers to computer systems that can perform tasks typically requiring human intelligence, such as learning, reasoning, problem-solving, and understanding natural language.";
            }
        }
        
        // Greetings and introductions
        if (preg_match('/^(hi|hello|hey|greetings|good morning|good afternoon|good evening|sup|what\'s up)/i', $lowerMsg)) {
            return "Hello! 👋 I'm your AI Academic Advisor. I'm here to help you with:<br><br>• Course selection and recommendations<br>• Academic planning and degree requirements<br>• GPA and grade inquiries<br>• Meeting scheduling with advisors<br>• General academic questions<br><br>What can I help you with today?";
        }
        
        // Name/introduction questions
        if (preg_match('/(what.*your name|who are you|introduce yourself|tell me about yourself)/i', $lowerMsg)) {
            return "I'm your AI Academic Advisor! 🤖 I'm here 24/7 to help you navigate your academic journey. I can assist with course planning, academic requirements, GPA questions, meeting scheduling, and much more. How can I help you today?";
        }
        
        // What can you do / capabilities
        if (preg_match('/(what can you|what do you|how can you|your capabilities|what are you|abilities)/i', $lowerMsg)) {
            return "I can help you with many academic tasks! Here's what I can do:<br><br>📚 <strong>Course Planning:</strong> Recommend courses, check prerequisites, plan your schedule<br>📊 <strong>Academic Progress:</strong> Check GPA, view credits, track degree progress<br>📅 <strong>Meetings:</strong> Find advisor meeting times, schedule appointments<br>🎓 <strong>Graduation:</strong> Check requirements, plan your path to graduation<br>💡 <strong>General Help:</strong> Answer questions about academic policies and procedures<br><br>What would you like to know?";
        }
        
        // GPA related (expanded patterns)
        if (preg_match('/(gpa|grade point average|my grades|my average|check.*grade)/i', $lowerMsg)) {
            return "To check your GPA:<br><br>📊 <strong>Student Dashboard:</strong> Go to your dashboard and check the Academic Progress section<br>📋 <strong>Transcript:</strong> View your full transcript in the Academic Records section<br>👨‍🏫 <strong>Advisor:</strong> Contact your academic advisor for a detailed breakdown<br><br>Your GPA is calculated based on all completed courses weighted by credit hours. Need help understanding how it's calculated?";
        }
        
        // Course recommendations/questions (expanded patterns)
        if (preg_match('/(course|class|subject).*(take|recommend|select|choose|register|enroll|next|semester|term)/i', $lowerMsg) || 
            preg_match('/(what.*course|which.*course|course.*should|need.*course)/i', $lowerMsg)) {
            return "I can help with course selection! Here's my advice:<br><br>✅ <strong>Check Requirements:</strong> Review your degree requirements in Academic Planning<br>📖 <strong>Prerequisites:</strong> Make sure you've completed required prerequisites<br>⚖️ <strong>Balance:</strong> Consider your current course load and difficulty<br>👨‍🏫 <strong>Advisor:</strong> Consult your advisor for personalized recommendations<br><br>What's your major? I can help you find courses that fit your requirements!";
        }
        
        // Advisor meeting questions (expanded patterns)
        if (preg_match('/(advisor|adviser).*(meeting|appointment|schedule|when|next|time)/i', $lowerMsg) ||
            preg_match('/(meeting|appointment).*(advisor|adviser|when|next|schedule)/i', $lowerMsg)) {
            return "To find your advisor meetings:<br><br>📅 <strong>Dashboard:</strong> Check the 'Upcoming Meetings' section on your Student Dashboard<br>📋 <strong>Meetings Page:</strong> Visit the Meetings section to see all scheduled appointments<br>📧 <strong>Email:</strong> Check your email for meeting confirmations<br>📞 <strong>Contact:</strong> Reach out to your advisor directly to schedule or reschedule<br><br>Would you like help scheduling a new meeting?";
        }
        
        // Graduation requirements (expanded patterns)
        if (preg_match('/(graduation|graduate|degree.*requirement|what.*need.*graduate|requirements.*graduate)/i', $lowerMsg)) {
            return "To check graduation requirements:<br><br>📊 <strong>Academic Progress:</strong> View your dashboard to see completed vs required credits<br>📋 <strong>Degree Audit:</strong> Check your degree audit in the Academic Planning section<br>📚 <strong>Major Requirements:</strong> Review your major's specific course requirements<br>👨‍🏫 <strong>Advisor Meeting:</strong> Schedule a meeting to ensure you're on track<br><br>I can help you understand what's needed to graduate on time!";
        }
        
        // Grades/assignments
        if (preg_match('/(grade|grades|assignment|homework|project|exam|test|quiz)/i', $lowerMsg)) {
            return "I can help with grades and assignments! You can:<br><br>📊 <strong>View Grades:</strong> Check your Student Dashboard for recent grades<br>📝 <strong>Assignments:</strong> See upcoming assignments in the Assignments section<br>📈 <strong>Progress:</strong> Track your academic progress over time<br>👨‍🏫 <strong>Questions:</strong> Contact your instructor or advisor for grade-related questions<br><br>What specific information do you need?";
        }
        
        // Schedule/timetable
        if (preg_match('/(schedule|timetable|class.*schedule|when.*class|class.*time)/i', $lowerMsg)) {
            return "To view your schedule:<br><br>📅 <strong>Dashboard:</strong> Check your Student Dashboard for your current schedule<br>📋 <strong>Courses:</strong> Visit the Courses section to see all enrolled classes<br>📱 <strong>Mobile:</strong> Use the mobile app for quick schedule access<br><br>Need help planning your schedule for next semester?";
        }
        
        // Account/login related
        if (preg_match('/(account|login|password|sign in|log in|forgot.*password|reset.*password)/i', $lowerMsg)) {
            return "I can help with account issues! Here's what you can do:<br><br>🔐 <strong>Password Reset:</strong> Use the 'Forgot Password' link on the login page<br>📧 <strong>Email:</strong> Check your email for password reset instructions<br>💬 <strong>Support:</strong> Contact support@mashourax.com for account help<br><br>What specific account issue are you experiencing?";
        }
        
        // Pricing related
        if (preg_match('/(pricing|price|cost|plan|subscription|fee|payment)/i', $lowerMsg)) {
            return "Here are our pricing plans:<br><br>💰 <strong>Basic:</strong> EGP 2,999/month - Up to 500 students<br>💼 <strong>Professional:</strong> EGP 5,999/month - Up to 2,000 students<br>🏢 <strong>Enterprise:</strong> EGP 12,999/month - Unlimited students<br><br>✨ All plans include a 30-day free trial!<br><br>Would you like more details about any plan?";
        }
        
        // Features
        if (preg_match('/(feature|what.*offer|capabilities|what.*can.*do)/i', $lowerMsg)) {
            return "MashouraX offers amazing features:<br><br>🤖 <strong>24/7 AI Advising:</strong> Get help anytime, anywhere<br>📊 <strong>Analytics:</strong> Smart reporting and insights<br>👥 <strong>Personalization:</strong> Tailored student outreach<br>📚 <strong>Planning:</strong> Degree planning tools<br>📱 <strong>Mobile:</strong> Full app access<br>🔗 <strong>Integration:</strong> Seamless system connections<br><br>Which feature interests you most?";
        }
        
        // Support/help
        if (preg_match('/(help|support|assistance|how.*help|need.*help)/i', $lowerMsg)) {
            return "I'm here to help! 💪 You can ask me about:<br><br>📚 Academic planning and courses<br>📊 Grades and GPA<br>📅 Meeting scheduling<br>🎓 Graduation requirements<br>🔐 Account and login issues<br>💡 General questions<br><br>What would you like to know?";
        }
        
        // Thank you / appreciation
        if (preg_match('/(thank|thanks|appreciate|grateful)/i', $lowerMsg)) {
            return "You're welcome! 😊 I'm always here to help. If you have any other questions about your academics, courses, or degree planning, just ask!";
        }
        
        // Goodbye
        if (preg_match('/(bye|goodbye|see you|later|farewell)/i', $lowerMsg)) {
            return "Goodbye! 👋 Feel free to come back anytime if you need help with your academics. Have a great day!";
        }
        
        // Questions starting with "how"
        if (preg_match('/^how\s+/i', $lowerMsg)) {
            return "I'd be happy to help explain how things work! Could you be more specific about what you'd like to know? For example:<br><br>• How to check your GPA<br>• How to schedule a meeting<br>• How to select courses<br>• How to view your grades<br><br>What would you like to learn about?";
        }
        
        // Questions starting with "what" - handle general knowledge (but check capital cities first)
        if (preg_match('/^what\s+/i', $lowerMsg) && !preg_match('/(what.*your name|what can you|what do you)/i', $lowerMsg)) {
            // Check for capital city questions FIRST before generic "what is"
            if (preg_match('/(what.*capital.*of|capital.*of.*is)/i', $lowerMsg)) {
                if (strpos($lowerMsg, 'france') !== false) {
                    return "The capital of France is <strong>Paris</strong>. 🇫🇷<br><br>Paris is not only the capital but also the largest city in France, known for its rich history, art, culture, and landmarks like the Eiffel Tower and the Louvre Museum.";
                }
                if (strpos($lowerMsg, 'egypt') !== false) {
                    return "The capital of Egypt is <strong>Cairo</strong>. 🇪🇬<br><br>Cairo is the largest city in Egypt and Africa, located on the banks of the Nile River.";
                }
                if (strpos($lowerMsg, 'usa') !== false || strpos($lowerMsg, 'united states') !== false || strpos($lowerMsg, 'america') !== false) {
                    return "The capital of the United States is <strong>Washington, D.C.</strong> 🇺🇸<br><br>Washington D.C. is not part of any state and serves as the federal capital.";
                }
                return "I'd be happy to tell you about capital cities! Could you specify which country you're asking about? For example: 'What is the capital of France?'";
            }
            
            // Check for "what is" questions about general knowledge
            if (preg_match('/^what is (.+)\?/i', $trimmedMsg, $matches)) {
                $subject = strtolower(trim($matches[1]));
                // Common definitions
                if (strpos($subject, 'gpa') !== false) {
                    return "GPA stands for <strong>Grade Point Average</strong>. It's a numerical representation of your academic performance, typically on a scale of 0.0 to 4.0. It's calculated by averaging the grade points earned in all your courses, weighted by credit hours.";
                }
                if (strpos($subject, 'ai') !== false && strpos($subject, 'artificial intelligence') === false) {
                    return "AI stands for <strong>Artificial Intelligence</strong>. It refers to computer systems that can perform tasks typically requiring human intelligence, such as learning, reasoning, problem-solving, and understanding natural language.";
                }
                // Other "what is" questions
                return "I'd be happy to explain '" . htmlspecialchars(trim($matches[1])) . "'! " .
                       "For the most detailed and accurate answer, the Gemini AI service would be ideal. " .
                       "For now, I can help with academic topics like:<br><br>" .
                       "• What courses should I take?<br>• What are my graduation requirements?<br>• What is my GPA?<br>• What meetings do I have?<br><br>" .
                       "What academic topic would you like help with?";
            } else {
                return "I can help answer that! Could you provide a bit more detail? For example:<br><br>• What courses should I take?<br>• What are my graduation requirements?<br>• What is my GPA?<br>• What meetings do I have?<br><br>What specifically would you like to know?";
            }
        }
        
        // Questions starting with "when"
        if (preg_match('/^when\s+/i', $lowerMsg)) {
            return "I can help you find timing information! Are you asking about:<br><br>• When is your next advisor meeting?<br>• When are your classes?<br>• When are assignments due?<br>• When can you register for courses?<br><br>What timing information do you need?";
        }
        
        // Questions starting with "where"
        if (preg_match('/^where\s+/i', $lowerMsg)) {
            return "I can help you find locations and information! Are you looking for:<br><br>• Where to check your grades?<br>• Where to view your schedule?<br>• Where to find course information?<br>• Where to contact your advisor?<br><br>What are you trying to find?";
        }
        
        // "How" questions
        if (preg_match('/^how\s+/i', $lowerMsg)) {
            return "I'd be happy to help explain how things work! Could you be more specific about what you'd like to know? For example:<br><br>• How to check your GPA<br>• How to schedule a meeting<br>• How to select courses<br>• How to view your grades<br><br>What would you like to learn about?";
        }
        
        // If it's a question (ends with ?), try to provide a general helpful response
        if (substr($trimmedMsg, -1) === '?') {
            return "I'd be happy to help answer your question! For the most comprehensive and accurate answers, " .
                   "the Gemini AI service provides the best responses. Currently, I'm using a simplified system.<br><br>" .
                   "I can definitely help with:<br>• 📚 Academic questions and study plans<br>• 📊 GPA and grades<br>• 📅 Scheduling and meetings<br>" .
                   "• 🎓 Graduation requirements<br>• 💡 Study strategies<br>• 🔧 Problem-solving<br><br>" .
                   "What academic topic can I help you with?";
        }
        
        // For statements or general messages, acknowledge and try to help
        return "Thanks for your message! I'm here to help answer any questions you have. " .
               "For the best experience with detailed answers, the Gemini AI service provides comprehensive responses. " .
               "I can help with academics, study plans, general knowledge, and more! What would you like to know?";
    }
}
?>

