<?php
/**
 * Example: How to use the View layer in your existing PHP files
 * 
 * This shows how to integrate the MVC views with your existing dashboard files
 */

// Example 1: Using views in student-dashboard.php
require_once __DIR__ . '/BaseView.php';
require_once __DIR__ . '/ViewHelper.php';
require_once __DIR__ . '/../model/StudentModel.php';
require_once __DIR__ . '/../model/AcademicModel.php';
require_once __DIR__ . '/../model/MeetingModel.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireLogin();
$user = getCurrentUser();

if ($user['role'] !== 'student') {
    header('Location: index.php');
    exit();
}

// Get data using models
$studentModel = new StudentModel();
$academicModel = new AcademicModel();
$meetingModel = new MeetingModel();

$academicProgress = $studentModel->getAcademicProgress($user['id']);
$upcomingAssignments = $academicModel->getStudentAssignments($user['id'], 'pending');
$upcomingMeetings = $meetingModel->getUpcomingMeetings($user['id'], 'student', 5);

// Create view instance
$view = new BaseView();
$helper = new ViewHelper();

// Set data for the view
$view->set([
    'user' => $user,
    'academicProgress' => $academicProgress,
    'upcomingAssignments' => $upcomingAssignments,
    'upcomingMeetings' => $upcomingMeetings,
    'pageTitle' => 'Student Dashboard',
    'showNavigation' => true,
    'showFooter' => true,
    'cssFile' => 'index.css'
]);

// Include header
$view->partial('header');

// Render the dashboard view
$view->display('student/dashboard');

// Include footer
$view->partial('footer');
?>

