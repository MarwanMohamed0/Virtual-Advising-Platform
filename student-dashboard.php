<?php
/**
 * Student Dashboard - MashouraX Virtual Advising Platform
 * Comprehensive student dashboard with all academic features
 */

require_once 'includes/auth.php';

// Check if user is logged in and is student
requireLogin();
$user = getCurrentUser();

if ($user['role'] !== 'student') {
    header('Location: index.php');
    exit();
}

// Get student statistics and data
try {
    $pdo = getDBConnection();
    
    // Get student's academic progress (mock data for now)
    $academicProgress = [
        'gpa' => 3.7,
        'credits_completed' => 45,
        'credits_required' => 120,
        'semester' => 'Fall 2024',
        'major' => 'Computer Science',
        'advisor' => 'Dr. Sarah Johnson',
        'next_appointment' => '2024-12-15 14:00:00',
        'graduation_date' => '2025-05-15'
    ];
    
    // Get upcoming assignments (mock data)
    $upcomingAssignments = [
        [
            'title' => 'Data Structures Final Project',
            'course' => 'CS 201',
            'due_date' => '2024-12-20',
            'priority' => 'high',
            'status' => 'in_progress'
        ],
        [
            'title' => 'Calculus III Midterm',
            'course' => 'MATH 301',
            'due_date' => '2024-12-18',
            'priority' => 'high',
            'status' => 'pending'
        ],
        [
            'title' => 'Database Design Assignment',
            'course' => 'CS 301',
            'due_date' => '2024-12-22',
            'priority' => 'medium',
            'status' => 'pending'
        ]
    ];
    
    // Get recent activities (mock data)
    $recentActivities = [
        [
            'type' => 'meeting',
            'title' => 'Academic Advising Meeting',
            'description' => 'Discussed course selection for next semester',
            'date' => '2024-12-10',
            'time' => '14:30'
        ],
        [
            'type' => 'assignment',
            'title' => 'Submitted: Web Development Project',
            'description' => 'CS 202 - Web Programming',
            'date' => '2024-12-08',
            'time' => '23:45'
        ],
        [
            'type' => 'grade',
            'title' => 'Grade Posted: Algorithms Quiz',
            'description' => 'CS 201 - Data Structures',
            'date' => '2024-12-07',
            'time' => '10:15'
        ]
    ];
    
} catch (Exception $e) {
    error_log("Student dashboard error: " . $e->getMessage());
    $academicProgress = [];
    $upcomingAssignments = [];
    $recentActivities = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - MashouraX</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .dashboard-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
            padding: 120px 20px 60px;
        }
        
        .dashboard-header {
            max-width: 1400px;
            margin: 0 auto 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .dashboard-title {
            color: #ffffff;
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #aaa;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: #2196F3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .dashboard-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(33, 150, 243, 0.3);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .stat-title {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .stat-value {
            color: #ffffff;
            font-size: 36px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        
        .stat-subtitle {
            color: #aaa;
            font-size: 14px;
            margin: 0;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 15px;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #2196F3, #21CBF3);
            border-radius: 4px;
            transition: width 0.3s ease;
        }
        
        .dashboard-section {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .section-title {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        
        .section-action {
            background: #2196F3;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .section-action:hover {
            background: #1976D2;
            transform: translateY(-2px);
        }
        
        .assignment-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .assignment-item:hover {
            border-color: rgba(33, 150, 243, 0.3);
            transform: translateY(-2px);
        }
        
        .assignment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        
        .assignment-title {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        
        .priority-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .priority-high {
            background: rgba(244, 67, 54, 0.2);
            color: #f44336;
        }
        
        .priority-medium {
            background: rgba(255, 152, 0, 0.2);
            color: #FF9800;
        }
        
        .priority-low {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
        }
        
        .assignment-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
        
        .assignment-course {
            color: #aaa;
            font-size: 14px;
        }
        
        .assignment-due {
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
        }
        
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        
        .activity-meeting {
            background: rgba(33, 150, 243, 0.2);
            color: #2196F3;
        }
        
        .activity-assignment {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
        }
        
        .activity-grade {
            background: rgba(255, 152, 0, 0.2);
            color: #FF9800;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .activity-description {
            color: #aaa;
            font-size: 14px;
            margin: 0 0 5px 0;
        }
        
        .activity-time {
            color: #666;
            font-size: 12px;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .action-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .action-card:hover {
            transform: translateY(-3px);
            border-color: rgba(33, 150, 243, 0.3);
        }
        
        .action-icon {
            width: 60px;
            height: 60px;
            background: #2196F3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
            color: white;
        }
        
        .action-title {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 10px 0;
        }
        
        .action-desc {
            color: #aaa;
            font-size: 14px;
            margin: 0;
        }
        
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #c82333;
        }
        
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Student Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                </div>
                <div>
                    <div style="color: #ffffff; font-weight: 600;"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></div>
                    <div style="font-size: 14px;">Student - <?php echo htmlspecialchars($user['institution']); ?></div>
                </div>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>

        <!-- Academic Progress Cards -->
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Current GPA</h3>
                    <div class="stat-icon" style="background: rgba(33, 150, 243, 0.2); color: #2196F3;">📊</div>
                </div>
                <p class="stat-value"><?php echo $academicProgress['gpa'] ?? 'N/A'; ?></p>
                <p class="stat-subtitle">Out of 4.0</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Credits Completed</h3>
                    <div class="stat-icon" style="background: rgba(76, 175, 80, 0.2); color: #4CAF50;">🎓</div>
                </div>
                <p class="stat-value"><?php echo $academicProgress['credits_completed'] ?? 0; ?></p>
                <p class="stat-subtitle">of <?php echo $academicProgress['credits_required'] ?? 120; ?> required</p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo (($academicProgress['credits_completed'] ?? 0) / ($academicProgress['credits_required'] ?? 120)) * 100; ?>%"></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Current Semester</h3>
                    <div class="stat-icon" style="background: rgba(255, 152, 0, 0.2); color: #FF9800;">📅</div>
                </div>
                <p class="stat-value" style="font-size: 24px;"><?php echo $academicProgress['semester'] ?? 'N/A'; ?></p>
                <p class="stat-subtitle"><?php echo $academicProgress['major'] ?? 'Undeclared'; ?></p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Academic Advisor</h3>
                    <div class="stat-icon" style="background: rgba(156, 39, 176, 0.2); color: #9C27B0;">👨‍🏫</div>
                </div>
                <p class="stat-value" style="font-size: 20px;"><?php echo $academicProgress['advisor'] ?? 'Not Assigned'; ?></p>
                <p class="stat-subtitle">Next meeting: <?php echo isset($academicProgress['next_appointment']) ? date('M j', strtotime($academicProgress['next_appointment'])) : 'Not scheduled'; ?></p>
            </div>
        </div>

        <!-- Upcoming Assignments Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">Upcoming Assignments</h2>
                <a href="#" class="section-action">View All</a>
            </div>
            <?php foreach ($upcomingAssignments as $assignment): ?>
            <div class="assignment-item">
                <div class="assignment-header">
                    <h3 class="assignment-title"><?php echo htmlspecialchars($assignment['title']); ?></h3>
                    <span class="priority-badge priority-<?php echo $assignment['priority']; ?>">
                        <?php echo ucfirst($assignment['priority']); ?>
                    </span>
                </div>
                <div class="assignment-details">
                    <span class="assignment-course"><?php echo htmlspecialchars($assignment['course']); ?></span>
                    <span class="assignment-due">Due: <?php echo date('M j, Y', strtotime($assignment['due_date'])); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Recent Activities Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">Recent Activities</h2>
                <a href="#" class="section-action">View All</a>
            </div>
            <?php foreach ($recentActivities as $activity): ?>
            <div class="activity-item">
                <div class="activity-icon activity-<?php echo $activity['type']; ?>">
                    <?php 
                    switch($activity['type']) {
                        case 'meeting': echo '👥'; break;
                        case 'assignment': echo '📝'; break;
                        case 'grade': echo '📊'; break;
                        default: echo '📌';
                    }
                    ?>
                </div>
                <div class="activity-content">
                    <h4 class="activity-title"><?php echo htmlspecialchars($activity['title']); ?></h4>
                    <p class="activity-description"><?php echo htmlspecialchars($activity['description']); ?></p>
                    <p class="activity-time"><?php echo date('M j, Y', strtotime($activity['date'])); ?> at <?php echo $activity['time']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-section">
            <h2 class="section-title" style="margin-bottom: 30px;">Quick Actions</h2>
            <div class="quick-actions">
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📚</div>
                    <h3 class="action-title">Course Catalog</h3>
                    <p class="action-desc">Browse and register for courses</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📅</div>
                    <h3 class="action-title">Schedule Meeting</h3>
                    <p class="action-desc">Book time with your advisor</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📊</div>
                    <h3 class="action-title">Academic Progress</h3>
                    <p class="action-desc">View detailed progress reports</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">💼</div>
                    <h3 class="action-title">Career Planning</h3>
                    <p class="action-desc">Explore career opportunities</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📝</div>
                    <h3 class="action-title">Assignments</h3>
                    <p class="action-desc">View and submit assignments</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">🎯</div>
                    <h3 class="action-title">Goals & Planning</h3>
                    <p class="action-desc">Set and track academic goals</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
