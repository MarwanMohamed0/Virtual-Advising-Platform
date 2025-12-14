<?php
/**
 * View Helper Class
 * Provides helper functions for views
 */

class ViewHelper {
    
    /**
     * Format date
     */
    public static function date($date, $format = 'M d, Y') {
        if (empty($date)) return '';
        try {
            return date($format, strtotime($date));
        } catch (Exception $e) {
            return $date;
        }
    }
    
    /**
     * Format datetime
     */
    public static function datetime($datetime, $format = 'M d, Y h:i A') {
        return self::date($datetime, $format);
    }
    
    /**
     * Time ago
     */
    public static function timeAgo($datetime) {
        if (empty($datetime)) return '';
        
        $time = time() - strtotime($datetime);
        
        if ($time < 60) return 'just now';
        if ($time < 3600) return floor($time / 60) . ' minutes ago';
        if ($time < 86400) return floor($time / 3600) . ' hours ago';
        if ($time < 2592000) return floor($time / 86400) . ' days ago';
        
        return self::date($datetime);
    }
    
    /**
     * Format user name
     */
    public static function userName($user) {
        if (is_array($user)) {
            return trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
        }
        return '';
    }
    
    /**
     * Get user initials
     */
    public static function userInitials($user) {
        $name = self::userName($user);
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        return $initials ?: 'U';
    }
    
    /**
     * Format GPA
     */
    public static function gpa($gpa) {
        return number_format($gpa, 2);
    }
    
    /**
     * Format percentage
     */
    public static function percentage($part, $total) {
        if ($total == 0) return 0;
        return round(($part / $total) * 100, 2);
    }
    
    /**
     * Get status badge class
     */
    public static function statusBadge($status) {
        $classes = [
            'active' => 'badge-success',
            'pending' => 'badge-warning',
            'completed' => 'badge-success',
            'cancelled' => 'badge-danger',
            'at_risk' => 'badge-danger',
            'in_progress' => 'badge-info',
            'overdue' => 'badge-danger'
        ];
        return $classes[$status] ?? 'badge-secondary';
    }
    
    /**
     * Get priority badge class
     */
    public static function priorityBadge($priority) {
        $classes = [
            'high' => 'badge-danger',
            'medium' => 'badge-warning',
            'low' => 'badge-info'
        ];
        return $classes[$priority] ?? 'badge-secondary';
    }
    
    /**
     * Truncate text
     */
    public static function truncate($text, $length = 100, $suffix = '...') {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }
    
    /**
     * Generate avatar URL or initials
     */
    public static function avatar($user, $size = 40) {
        $initials = self::userInitials($user);
        $name = self::userName($user);
        
        // You can use a service like Gravatar or generate SVG
        return "<div class='avatar' style='width:{$size}px;height:{$size}px;border-radius:50%;background:#007bff;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:bold;' title='{$name}'>{$initials}</div>";
    }
}
?>

