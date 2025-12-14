<?php
/**
 * API Router
 * Main entry point for all API requests
 */

// Set CORS headers if needed
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Load required files
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/UserController.php';
require_once __DIR__ . '/../controller/StudentController.php';
require_once __DIR__ . '/../controller/AdvisorController.php';
require_once __DIR__ . '/../controller/AdminController.php';
require_once __DIR__ . '/../controller/ChatController.php';
require_once __DIR__ . '/../controller/MeetingController.php';
require_once __DIR__ . '/../controller/ContactController.php';

// Get request path
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

// Remove script name from URI
$path = str_replace(dirname($scriptName), '', $requestUri);
$path = trim($path, '/');

// Remove query string
$path = strtok($path, '?');

// Split path into segments
$segments = explode('/', $path);

// Remove empty segments
$segments = array_filter($segments, function($segment) {
    return !empty($segment);
});

$segments = array_values($segments);

// Route mapping
$routes = [
    // Authentication routes
    'auth/login' => ['AuthController', 'login'],
    'auth/signup' => ['AuthController', 'signup'],
    'auth/logout' => ['AuthController', 'logout'],
    'auth/me' => ['AuthController', 'getCurrentUser'],
    'auth/verify' => ['AuthController', 'verifySession'],
    
    // User routes
    'user/profile' => ['UserController', 'getProfile'],
    'user/profile/update' => ['UserController', 'updateProfile'],
    'user/password/change' => ['UserController', 'changePassword'],
    'users' => ['UserController', 'getUsers'],
    
    // Student routes
    'student/dashboard' => ['StudentController', 'getDashboard'],
    'student/progress' => ['StudentController', 'getAcademicProgress'],
    'student/courses' => ['StudentController', 'getCourses'],
    'student/grades' => ['StudentController', 'getGrades'],
    'student/assignments' => ['StudentController', 'getAssignments'],
    
    // Advisor routes
    'advisor/dashboard' => ['AdvisorController', 'getDashboard'],
    'advisor/stats' => ['AdvisorController', 'getStats'],
    'advisor/students' => ['AdvisorController', 'getAssignedStudents'],
    'advisor/assign' => ['AdvisorController', 'assignStudent'],
    'advisor/meetings' => ['AdvisorController', 'getUpcomingMeetings'],
    
    // Admin routes
    'admin/dashboard' => ['AdminController', 'getDashboard'],
    'admin/stats' => ['AdminController', 'getSystemStats'],
    'admin/users' => ['AdminController', 'getAllUsers'],
    'admin/user/status' => ['AdminController', 'updateUserStatus'],
    'admin/user/role' => ['AdminController', 'updateUserRole'],
    'admin/user/delete' => ['AdminController', 'deleteUser'],
    'admin/sessions' => ['AdminController', 'getActiveSessions'],
    
    // Chat routes
    'chat/send' => ['ChatController', 'sendMessage'],
    'chat/history' => ['ChatController', 'getHistory'],
    'chat/clear' => ['ChatController', 'clearHistory'],
    
    // Meeting routes
    'meeting/create' => ['MeetingController', 'createMeeting'],
    'meeting/list' => ['MeetingController', 'getMeetings'],
    'meeting/upcoming' => ['MeetingController', 'getUpcomingMeetings'],
    'meeting/status' => ['MeetingController', 'updateStatus'],
    'meeting/cancel' => ['MeetingController', 'cancelMeeting'],
    'meeting/reschedule' => ['MeetingController', 'rescheduleMeeting'],
    
    // Contact routes
    'contact/submit' => ['ContactController', 'submitContact'],
    'contact/list' => ['ContactController', 'getAllContacts'],
    'contact/get' => ['ContactController', 'getContact'],
    'contact/status' => ['ContactController', 'updateStatus'],
    'contact/stats' => ['ContactController', 'getStats'],
];

// Build route key from segments
$routeKey = implode('/', array_slice($segments, 0, 2));

// Check if route exists
if (isset($routes[$routeKey])) {
    $route = $routes[$routeKey];
    $controllerName = $route[0];
    $methodName = $route[1];
    
    // Create controller instance
    $controller = new $controllerName();
    
    // Get additional parameters
    $params = array_slice($segments, 2);
    
    // Call controller method
    try {
        if (empty($params)) {
            $controller->$methodName();
        } else {
            call_user_func_array([$controller, $methodName], $params);
        }
    } catch (Exception $e) {
        Response::error('Internal server error: ' . $e->getMessage(), 500);
    }
} else {
    // Route not found
    Response::error('Endpoint not found', 404);
}
?>

