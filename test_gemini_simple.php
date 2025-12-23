<?php
/**
 * Simple Gemini API Test
 * Tests the exact endpoint format
 */

require_once 'config/api.php';

$apiKey = GEMINI_API_KEY;
$model = 'gemini-pro';

// Test different endpoint formats
$endpoints = [
    'v1beta with gemini-pro' => "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
    'v1 with gemini-pro' => "https://generativelanguage.googleapis.com/v1/models/{$model}:generateContent?key={$apiKey}",
    'v1beta with gemini-1.5-flash' => "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}",
    'v1beta with gemini-1.5-pro' => "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key={$apiKey}",
];

$payload = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Say hello']
            ]
        ]
    ]
];

echo "<h2>Testing Gemini API Endpoints</h2>";
echo "<pre>";

foreach ($endpoints as $name => $url) {
    echo "\n=== Testing: {$name} ===\n";
    echo "URL: " . str_replace($apiKey, 'HIDDEN', $url) . "\n";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "ERROR: {$error}\n";
    } else {
        echo "HTTP Code: {$httpCode}\n";
        if ($httpCode === 200) {
            $data = json_decode($response, true);
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                echo "✅ SUCCESS! Response: " . substr($data['candidates'][0]['content']['parts'][0]['text'], 0, 100) . "...\n";
                echo "\n✅ WORKING ENDPOINT: {$name}\n";
                echo "✅ Use this URL format in config/api.php\n";
                break;
            } else {
                echo "Response: " . substr($response, 0, 200) . "\n";
            }
        } else {
            echo "Response: " . substr($response, 0, 300) . "\n";
        }
    }
    echo "\n";
}

echo "</pre>";
?>

