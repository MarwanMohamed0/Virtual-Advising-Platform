<?php
/**
 * Gemini AI Service
 * Handles communication with Google Gemini API for AI chat responses
 */

require_once __DIR__ . '/../../config/api.php';

class GeminiService {
    private $apiKey;
    private $apiUrl;
    private $model;
    
    public function __construct() {
        $this->apiKey = getGeminiApiKey();
        $this->model = defined('GEMINI_MODEL') ? GEMINI_MODEL : 'gemini-pro';
        
        // Build the API URL dynamically - correct format for Gemini API
        $baseUrl = defined('GEMINI_API_BASE_URL') ? GEMINI_API_BASE_URL : 'https://generativelanguage.googleapis.com/v1beta/models';
        $this->apiUrl = $baseUrl . '/' . $this->model . ':generateContent';
        
        // Don't throw exception here - let the calling code handle it
        // This allows graceful fallback to keyword matching
    }
    
    /**
     * Generate AI response using Gemini API
     * 
     * @param string $userMessage The user's message
     * @param array $conversationHistory Previous messages for context (optional)
     * @param string $systemPrompt System instructions for the AI (optional)
     * @return string AI-generated response
     * @throws Exception If API call fails
     */
    public function generateResponse($userMessage, $conversationHistory = [], $systemPrompt = null) {
        // Check if API key is configured
        if (empty($this->apiKey)) {
            throw new Exception('Gemini API key is not configured. Please set GEMINI_API_KEY in config/api.php');
        }
        
        // Build the system prompt for academic advising context
        if ($systemPrompt === null) {
            $systemPrompt = $this->getDefaultSystemPrompt();
        }
        
        // Prepare the request payload - Gemini API format
        $payload = [
            'contents' => []
        ];
        
        // Add conversation history if provided
        if (!empty($conversationHistory)) {
            foreach ($conversationHistory as $msg) {
                $role = isset($msg['type']) && $msg['type'] === 'bot' ? 'model' : 'user';
                $payload['contents'][] = [
                    'role' => $role,
                    'parts' => [
                        ['text' => $msg['message']]
                    ]
                ];
            }
        }
        
        // Add system prompt as first user message if provided (some API versions don't support systemInstruction)
        if (!empty($systemPrompt)) {
            // Try systemInstruction first (for newer API versions)
            $payload['systemInstruction'] = [
                'parts' => [
                    ['text' => $systemPrompt]
                ]
            ];
        }
        
        // Add current user message
        $payload['contents'][] = [
            'role' => 'user',
            'parts' => [
                ['text' => $userMessage]
            ]
        ];
        
        // Add generation config
        $payload['generationConfig'] = [
            'temperature' => GEMINI_TEMPERATURE,
            'topK' => GEMINI_TOP_K,
            'topP' => GEMINI_TOP_P,
            'maxOutputTokens' => GEMINI_MAX_TOKENS,
        ];
        
        // Make API request - URL format: https://generativelanguage.googleapis.com/v1beta/models/{model}:generateContent?key={key}
        $url = $this->apiUrl . '?key=' . urlencode($this->apiKey);
        
        // Debug: Log the URL being used (without the key for security)
        error_log("Gemini API URL: " . str_replace($this->apiKey, 'HIDDEN', $url));
        error_log("Gemini API Payload: " . json_encode($payload));
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            error_log("Gemini API cURL Error: " . $error);
            throw new Exception('Failed to connect to Gemini API: ' . $error);
        }
        
        if ($httpCode !== 200) {
            error_log("Gemini API HTTP Error: " . $httpCode . " - Response: " . $response);
            error_log("Gemini API URL used: " . str_replace($this->apiKey, 'HIDDEN', $url));
            
            // Try to parse error response
            $errorData = json_decode($response, true);
            $errorMessage = 'Gemini API returned error code: ' . $httpCode;
            if (isset($errorData['error']['message'])) {
                $errorMessage .= ' - ' . $errorData['error']['message'];
            }
            
            // Special handling for quota/rate limit errors (429)
            if ($httpCode === 429) {
                throw new Exception('QUOTA_EXCEEDED: ' . $errorMessage);
            }
            
            throw new Exception($errorMessage);
        }
        
        $responseData = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Gemini API JSON Error: " . json_last_error_msg());
            throw new Exception('Failed to parse Gemini API response');
        }
        
        // Extract the generated text
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return $responseData['candidates'][0]['content']['parts'][0]['text'];
        } else {
            error_log("Gemini API Unexpected Response: " . json_encode($responseData));
            throw new Exception('Unexpected response format from Gemini API');
        }
    }
    
    /**
     * Get default system prompt for academic advising
     * @return string System prompt
     */
    private function getDefaultSystemPrompt() {
        return "You are Gemini, a helpful AI assistant that can answer ANY question. " .
               "Answer questions directly and helpfully - whether they're about:\n" .
               "- General knowledge (science, history, geography, etc.)\n" .
               "- Academic topics (study plans, courses, GPA, etc.)\n" .
               "- Problem-solving and explanations\n" .
               "- Advice and guidance\n" .
               "- Facts and information\n" .
               "- Or anything else the user asks\n\n" .
               "Guidelines:\n" .
               "- Always provide direct, accurate, and helpful answers\n" .
               "- Be conversational and friendly\n" .
               "- Use examples and detailed explanations when helpful\n" .
               "- Never refuse to answer - always try to be helpful\n" .
               "- If you don't know something, admit it but try to provide related helpful information\n" .
               "- Format responses clearly with bullet points or numbered lists when appropriate\n\n" .
               "Your goal is to be like Google's Gemini - capable of answering questions on any topic. Be helpful, accurate, and engaging.";
    }
    
    /**
     * Generate response with custom system prompt
     * 
     * @param string $userMessage The user's message
     * @param string $customPrompt Custom system instructions
     * @param array $conversationHistory Previous messages (optional)
     * @return string AI-generated response
     */
    public function generateCustomResponse($userMessage, $customPrompt, $conversationHistory = []) {
        return $this->generateResponse($userMessage, $conversationHistory, $customPrompt);
    }
    
    /**
     * Check if API is available and working
     * @return bool True if API is working, false otherwise
     */
    public function testConnection() {
        try {
            $testResponse = $this->generateResponse("Hello");
            return !empty($testResponse);
        } catch (Exception $e) {
            error_log("Gemini API Test Failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

