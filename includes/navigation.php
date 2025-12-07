<?php
/**
 * Navigation Component - MashouraX Virtual Advising Platform
 * Reusable navigation with role-based dashboard routing
 */

try {
    require_once __DIR__ . '/auth.php';
    // Get current user if logged in
    $currentUser = getCurrentUser();
} catch (Exception $e) {
    // If database connection fails, set currentUser to null
    $currentUser = null;
    error_log("Navigation auth error: " . $e->getMessage());
}

// Determine dashboard URL based on user role
$dashboardUrl = 'student-dashboard.php'; // default
if ($currentUser) {
    switch ($currentUser['role']) {
        case 'admin':
            $dashboardUrl = 'admin-dashboard.php';
            break;
        case 'advisor':
            $dashboardUrl = 'advisor-dashboard.php';
            break;
        case 'student':
        default:
            $dashboardUrl = 'student-dashboard.php';
            break;
    }
}
?>

<!-- Top Bar -->
<div class="top-bar">
    <div class="top-bar-left">
        <div class="top-bar-item">
            <span>📧</span> support@mashourax.com
        </div>
        <div class="top-bar-item">
            <span>📞</span> +20 (012) 707 23373
        </div>
    </div>
    <div class="top-bar-right">
        <a href="about.php" class="top-bar-link">About</a>
        <a href="#" class="top-bar-link">Blog</a>
        <a href="#" class="top-bar-link">Careers</a>
    </div>
</div>

<!-- Main Navigation -->
<nav>
    <div class="logo"><a href="index.php">MashouraX</a></div>
    <ul class="nav-center">
        <li class="nav-item">
            <a href="#solutions">Solutions ▾</a>
            <div class="dropdown">
                <a href="solutions-virtual-advising.php">Virtual Advising</a>
                <a href="solutions-student-success.php">Student Success</a>
                <a href="solutions-academic-planning.php">Academic Planning</a>
                <a href="solutions-career-services.php">Career Services</a>
            </div>
        </li>
       
        <li class="nav-item">
            <a href="#features">Features ▾</a>
            <div class="dropdown">
                <a href="ai-features.php">AI-Powered Support</a>
                <a href="analytics-dashboard.php">Analytics Dashboard</a>
                <a href="#">24/7 Chat Support</a>
                <a href="mobile.php">Mobile App</a>
            </div>
        </li> 
        <li class="nav-item">
            <a href="#resources">Resources ▾</a>
            <div class="dropdown">
                <a href="case-studies.php">Case Studies</a>
                <a href="documentation.php">Documentation</a>
                <a href="webinars.php">Webinars</a>
                <a href="help-center.php">Help Center</a>
            </div>
        </li>
        
       
        <li class="nav-item">
            <a href="#pricing">Pricing</a>
        </li>
        <li class="nav-item">
            <a href="#security">Security</a>
        </li>
    </ul>
    <div class="nav-right">
        <button class="search-btn">🔍 Search</button>
        <?php if ($currentUser): ?>
            <div class="user-menu">
                <span class="user-greeting">Welcome, <?php echo htmlspecialchars($currentUser['first_name']); ?>!</span>
                <div class="user-dropdown">
                    <a href="<?php echo $dashboardUrl; ?>">Dashboard</a>
                    <a href="profile.php">Profile</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <button class="login-btn" onclick="window.location.href='login.php'">Login</button>
            <button class="demo-btn" onclick="window.location.href='demo.php'">Request Demo</button>
        <?php endif; ?>
    </div>
</nav>

