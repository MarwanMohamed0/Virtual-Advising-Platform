<?php
/**
 * Response Handler
 * Standardized API response formatting
 */

class Response {
    /**
     * Success response
     */
    public static function success($data = [], $message = 'Success', $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
    
    /**
     * Error response
     */
    public static function error($message = 'An error occurred', $statusCode = 400, $errors = []) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ]);
        exit;
    }
    
    /**
     * Validation error response
     */
    public static function validationError($errors) {
        self::error('Validation failed', 422, $errors);
    }
    
    /**
     * Unauthorized response
     */
    public static function unauthorized($message = 'Authentication required') {
        self::error($message, 401);
    }
    
    /**
     * Forbidden response
     */
    public static function forbidden($message = 'Insufficient permissions') {
        self::error($message, 403);
    }
    
    /**
     * Not found response
     */
    public static function notFound($message = 'Resource not found') {
        self::error($message, 404);
    }
}
?>

