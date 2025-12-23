<?php
/**
 * Helper - General utility functions
 */

class Helper {
    /**
     * Format date for display
     */
    public static function formatDate($date, $format = 'M d, Y') {
        if (empty($date)) return '';
        $dateObj = new DateTime($date);
        return $dateObj->format($format);
    }
    
    /**
     * Format datetime for display
     */
    public static function formatDateTime($datetime, $format = 'M d, Y h:i A') {
        if (empty($datetime)) return '';
        $dateObj = new DateTime($datetime);
        return $dateObj->format($format);
    }
    
    /**
     * Get time ago string
     */
    public static function timeAgo($datetime) {
        $time = time() - strtotime($datetime);
        
        if ($time < 60) return 'just now';
        if ($time < 3600) return floor($time/60) . ' minutes ago';
        if ($time < 86400) return floor($time/3600) . ' hours ago';
        if ($time < 2592000) return floor($time/86400) . ' days ago';
        if ($time < 31536000) return floor($time/2592000) . ' months ago';
        return floor($time/31536000) . ' years ago';
    }
    
    /**
     * Generate random string
     */
    public static function randomString($length = 10) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Redirect to URL
     */
    public static function redirect($url) {
        header("Location: $url");
        exit();
    }
    
    /**
     * Get current URL
     */
    public static function currentUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Get base URL
     */
    public static function baseUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
    }
    
    /**
     * Check if request is AJAX
     */
    public static function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    /**
     * Get client IP address
     */
    public static function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? '';
        }
    }
    
    /**
     * Truncate string
     */
    public static function truncate($string, $length = 100, $suffix = '...') {
        if (strlen($string) <= $length) {
            return $string;
        }
        return substr($string, 0, $length) . $suffix;
    }
}
?>
