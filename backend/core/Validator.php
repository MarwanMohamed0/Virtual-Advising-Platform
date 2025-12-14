<?php
/**
 * Validator Class
 * Provides validation utilities
 */

class Validator {
    
    /**
     * Validate email
     */
    public static function email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validate password strength
     */
    public static function password($password, $minLength = 8) {
        return strlen($password) >= $minLength;
    }
    
    /**
     * Validate required fields
     */
    public static function required($value) {
        return !empty($value);
    }
    
    /**
     * Validate string length
     */
    public static function length($value, $min = null, $max = null) {
        $len = strlen($value);
        
        if ($min !== null && $len < $min) {
            return false;
        }
        
        if ($max !== null && $len > $max) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Validate date format
     */
    public static function date($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
    
    /**
     * Validate integer
     */
    public static function integer($value) {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
    
    /**
     * Validate role
     */
    public static function role($role) {
        $allowedRoles = ['student', 'advisor', 'admin'];
        return in_array($role, $allowedRoles);
    }
    
    /**
     * Validate multiple fields
     */
    public static function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            
            foreach ($fieldRules as $rule => $params) {
                if ($rule === 'required' && !self::required($value)) {
                    $errors[$field][] = "Field {$field} is required";
                    continue;
                }
                
                if ($rule === 'required' || !empty($value)) {
                    switch ($rule) {
                        case 'email':
                            if (!self::email($value)) {
                                $errors[$field][] = "Field {$field} must be a valid email";
                            }
                            break;
                            
                        case 'password':
                            $minLength = $params ?? 8;
                            if (!self::password($value, $minLength)) {
                                $errors[$field][] = "Field {$field} must be at least {$minLength} characters";
                            }
                            break;
                            
                        case 'length':
                            $min = $params['min'] ?? null;
                            $max = $params['max'] ?? null;
                            if (!self::length($value, $min, $max)) {
                                $errors[$field][] = "Field {$field} length must be between {$min} and {$max}";
                            }
                            break;
                            
                        case 'integer':
                            if (!self::integer($value)) {
                                $errors[$field][] = "Field {$field} must be an integer";
                            }
                            break;
                            
                        case 'role':
                            if (!self::role($value)) {
                                $errors[$field][] = "Field {$field} must be a valid role";
                            }
                            break;
                    }
                }
            }
        }
        
        return $errors;
    }
}
?>

