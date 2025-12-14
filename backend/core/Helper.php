<?php
/**
 * Helper Functions
 * Utility functions used throughout the application
 */

class Helper {
    
    /**
     * Format date for display
     */
    public static function formatDate($date, $format = 'M d, Y') {
        if (empty($date)) {
            return '';
        }
        
        try {
            $dateObj = new DateTime($date);
            return $dateObj->format($format);
        } catch (Exception $e) {
            return $date;
        }
    }
    
    /**
     * Format datetime for display
     */
    public static function formatDateTime($datetime, $format = 'M d, Y h:i A') {
        return self::formatDate($datetime, $format);
    }
    
    /**
     * Get time ago string
     */
    public static function timeAgo($datetime) {
        if (empty($datetime)) {
            return '';
        }
        
        try {
            $time = time() - strtotime($datetime);
            
            if ($time < 60) {
                return 'just now';
            } elseif ($time < 3600) {
                $minutes = floor($time / 60);
                return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
            } elseif ($time < 86400) {
                $hours = floor($time / 3600);
                return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
            } elseif ($time < 2592000) {
                $days = floor($time / 86400);
                return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
            } else {
                return self::formatDate($datetime);
            }
        } catch (Exception $e) {
            return $datetime;
        }
    }
    
    /**
     * Generate random string
     */
    public static function randomString($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Sanitize output
     */
    public static function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Calculate percentage
     */
    public static function percentage($part, $total) {
        if ($total == 0) {
            return 0;
        }
        return round(($part / $total) * 100, 2);
    }
    
    /**
     * Format file size
     */
    public static function formatFileSize($bytes) {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
    
    /**
     * Check if string contains substring
     */
    public static function contains($haystack, $needle) {
        return strpos($haystack, $needle) !== false;
    }
    
    /**
     * Get user full name
     */
    public static function getFullName($user) {
        if (is_array($user)) {
            return trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
        }
        return '';
    }
    
    /**
     * Get initials from name
     */
    public static function getInitials($name) {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        return $initials;
    }
}
?>

