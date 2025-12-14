<?php
/**
 * Autoloader
 * Automatically loads classes when needed
 */

spl_autoload_register(function ($className) {
    // Base directory
    $baseDir = __DIR__ . '/../';
    
    // Convert namespace to directory structure
    $className = str_replace('\\', '/', $className);
    
    // Possible file locations
    $paths = [
        $baseDir . 'core/' . $className . '.php',
        $baseDir . 'model/' . $className . '.php',
        $baseDir . 'controller/' . $className . '.php',
    ];
    
    // Try to load from each path
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
?>

