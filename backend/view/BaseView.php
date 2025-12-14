<?php
/**
 * Base View Class
 * Provides common functionality for rendering views
 */

class BaseView {
    protected $data = [];
    protected $viewPath;
    
    public function __construct($viewPath = null) {
        $this->viewPath = $viewPath ?: __DIR__;
    }
    
    /**
     * Set view data
     */
    public function set($key, $value = null) {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }
    
    /**
     * Get view data
     */
    public function get($key = null, $default = null) {
        if ($key === null) {
            return $this->data;
        }
        return $this->data[$key] ?? $default;
    }
    
    /**
     * Render a view file
     */
    public function render($viewFile, $data = []) {
        // Merge additional data
        $data = array_merge($this->data, $data);
        
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewPath = $this->viewPath . '/' . $viewFile . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new Exception("View file not found: {$viewFile}");
        }
        
        // Get the output
        $content = ob_get_clean();
        
        return $content;
    }
    
    /**
     * Render and output view
     */
    public function display($viewFile, $data = []) {
        echo $this->render($viewFile, $data);
    }
    
    /**
     * Escape output for security
     */
    public function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Include a partial view
     */
    public function partial($partialFile, $data = []) {
        $data = array_merge($this->data, $data);
        extract($data);
        
        $partialPath = $this->viewPath . '/partials/' . $partialFile . '.php';
        if (file_exists($partialPath)) {
            include $partialPath;
        } else {
            throw new Exception("Partial view not found: {$partialFile}");
        }
    }
}
?>

