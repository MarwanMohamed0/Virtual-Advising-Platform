<?php
/**
 * List Available Gemini Models
 * This will show which models are available for your API key
 */

require_once 'config/api.php';

$apiKey = GEMINI_API_KEY;

// List models endpoint
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . urlencode($apiKey);

echo "<h2>Available Gemini Models</h2>";
echo "<pre>";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// GET is the default, no need to set CURLOPT_POST
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "ERROR: {$error}\n";
} else {
    echo "HTTP Code: {$httpCode}\n\n";
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        
        if (isset($data['models'])) {
            echo "✅ Found " . count($data['models']) . " available models:\n\n";
            
            foreach ($data['models'] as $model) {
                $name = $model['name'] ?? 'Unknown';
                $displayName = $model['displayName'] ?? 'N/A';
                $description = $model['description'] ?? 'N/A';
                $supportedMethods = isset($model['supportedGenerationMethods']) ? implode(', ', $model['supportedGenerationMethods']) : 'N/A';
                
                echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                echo "Name: {$name}\n";
                echo "Display Name: {$displayName}\n";
                echo "Description: {$description}\n";
                echo "Supported Methods: {$supportedMethods}\n";
                
                // Extract model ID from name (e.g., "models/gemini-pro" -> "gemini-pro")
                $modelId = str_replace('models/', '', $name);
                
                // Check if generateContent is supported
                if (strpos($supportedMethods, 'generateContent') !== false) {
                    echo "✅ CAN USE FOR CHAT!\n";
                    echo "   Use this in config: define('GEMINI_MODEL', '{$modelId}');\n";
                }
                echo "\n";
            }
        } else {
            echo "Response: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
        }
    } else {
        echo "Error Response: " . substr($response, 0, 500) . "\n";
    }
}

echo "</pre>";
?>

