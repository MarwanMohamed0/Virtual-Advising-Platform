<?php
/**
 * Test Gemini API Connection
 * Use this to verify your Gemini API is working correctly
 */

require_once 'config/api.php';
require_once 'backend/services/GeminiService.php';

header('Content-Type: application/json');

try {
    echo json_encode([
        'api_configured' => isGeminiConfigured(),
        'api_key_set' => !empty(GEMINI_API_KEY),
        'api_key_preview' => substr(GEMINI_API_KEY, 0, 10) . '...' . substr(GEMINI_API_KEY, -5),
        'test' => 'Testing API connection...'
    ], JSON_PRETTY_PRINT);
    
    if (isGeminiConfigured()) {
        echo "\n\n";
        echo "Testing Gemini API call...\n";
        echo "API Base URL: " . GEMINI_API_BASE_URL . "\n";
        echo "Model: " . GEMINI_MODEL . "\n";
        echo "Full URL will be: " . GEMINI_API_BASE_URL . "/" . GEMINI_MODEL . ":generateContent\n\n";
        
        $geminiService = new GeminiService();
        
        // Use reflection to get the private apiUrl property for debugging
        $reflection = new ReflectionClass($geminiService);
        $property = $reflection->getProperty('apiUrl');
        $property->setAccessible(true);
        $apiUrl = $property->getValue($geminiService);
        echo "Actual API URL (key hidden): " . str_replace(GEMINI_API_KEY, 'HIDDEN_KEY', $apiUrl) . "\n\n";
        
        $response = $geminiService->generateResponse("What is the capital of France?");
        
        echo json_encode([
            'success' => true,
            'response' => $response,
            'message' => 'Gemini API is working correctly!'
        ], JSON_PRETTY_PRINT);
    } else {
        echo "\n\n";
        echo json_encode([
            'error' => 'Gemini API key is not configured',
            'message' => 'Please set GEMINI_API_KEY in config/api.php'
        ], JSON_PRETTY_PRINT);
    }
} catch (Exception $e) {
    echo "\n\n";
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
}
?>

