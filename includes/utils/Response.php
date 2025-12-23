<?php
/**
 * Response - Standardized API response utilities
 */

class Response {
    /**
     * Send JSON response
     */
    public static function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Send success response
     */
    public static function success($message, $data = null, $statusCode = 200) {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
    
    /**
     * Send error response
     */
    public static function error($message, $errors = null, $statusCode = 400) {
        self::json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }
    
    /**
     * Send unauthorized response
     */
    public static function unauthorized($message = 'Unauthorized access') {
        self::error($message, null, 401);
    }
    
    /**
     * Send forbidden response
     */
    public static function forbidden($message = 'Access forbidden') {
        self::error($message, null, 403);
    }
    
    /**
     * Send not found response
     */
    public static function notFound($message = 'Resource not found') {
        self::error($message, null, 404);
    }
    
    /**
     * Send validation error response
     */
    public static function validationError($errors) {
        self::error('Validation failed', $errors, 422);
    }
}
?>
