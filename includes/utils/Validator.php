<?php
/**
 * Validator - Input validation utilities
 */

class Validator {
    /**
     * Validate email
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validate password strength
     */
    public static function validatePassword($password, $minLength = 8) {
        if (strlen($password) < $minLength) {
            return ['valid' => false, 'message' => "Password must be at least $minLength characters"];
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            return ['valid' => false, 'message' => 'Password must contain at least one uppercase letter'];
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            return ['valid' => false, 'message' => 'Password must contain at least one lowercase letter'];
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            return ['valid' => false, 'message' => 'Password must contain at least one number'];
        }
        
        return ['valid' => true, 'message' => 'Password is valid'];
    }
    
    /**
     * Validate required fields
     */
    public static function validateRequired($data, $requiredFields) {
        $errors = [];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst(str_replace('_', ' ', $field)) . " is required";
            }
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
    
    /**
     * Sanitize string input
     */
    public static function sanitizeString($string) {
        return htmlspecialchars(strip_tags(trim($string)), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validate date format
     */
    public static function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
    
    /**
     * Validate datetime format
     */
    public static function validateDateTime($datetime, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $datetime);
        return $d && $d->format($format) === $datetime;
    }
    
    /**
     * Validate role
     */
    public static function validateRole($role) {
        $allowedRoles = ['student', 'advisor', 'admin'];
        return in_array($role, $allowedRoles);
    }
    
    /**
     * Validate GPA
     */
    public static function validateGPA($gpa) {
        return is_numeric($gpa) && $gpa >= 0 && $gpa <= 4.0;
    }
}
?>
