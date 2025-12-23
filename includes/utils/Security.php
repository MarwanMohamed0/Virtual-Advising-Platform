<?php
/**
 * Security - Security-related utilities
 */

class Security {
    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
    
    /**
     * Verify CSRF token
     */
    public static function verifyCSRFToken($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Sanitize input
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Escape output
     */
    public static function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validate and sanitize email
     */
    public static function validateEmail($email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    /**
     * Hash password
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Verify password
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Generate secure token
     */
    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length));
    }
    
    /**
     * Check rate limiting (simple implementation)
     */
    public static function checkRateLimit($key, $maxAttempts = 5, $timeWindow = 300) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $sessionKey = 'rate_limit_' . $key;
        $attempts = $_SESSION[$sessionKey] ?? [];
        
        // Remove old attempts outside time window
        $currentTime = time();
        $attempts = array_filter($attempts, function($timestamp) use ($currentTime, $timeWindow) {
            return ($currentTime - $timestamp) < $timeWindow;
        });
        
        if (count($attempts) >= $maxAttempts) {
            return false;
        }
        
        $attempts[] = $currentTime;
        $_SESSION[$sessionKey] = $attempts;
        
        return true;
    }
}
?>
