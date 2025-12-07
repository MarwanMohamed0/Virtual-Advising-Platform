<?php
/**
 * Advisor Dashboard - MashouraX Virtual Advising Platform
 * Comprehensive advisor dashboard for managing students
 */

require_once 'includes/auth.php';

// Check if user is logged in and is advisor
requireLogin();
$user = getCurrentUser();

if ($user['role'] !== 'advisor') {
    header('Location: index.php');
    exit();
}

// Get advisor statistics and data
try {
    $pdo = getDBConnection();
    
    // Get advisor's student statistics
    $advisorStats = [
        'total_students' => $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn(),
        'assigned_students' => 25, // Mock data - would need advisor_student_assignments table
        'meetings_today' => 3,
        'meetings_week' => 12,
        'pending_requests' => 8,
        'urgent_cases' => 2
    ];
    
    // Get assigned students (mock data)
    $assignedStudents = [
        [
            'name' => 'John Smith',
            'email' => 'john.smith@university.edu',
            'major' => 'Computer Science',
            'gpa' => 3.8,
            'year' => 'Junior',
            'last_meeting' => '2024-12-05',
            'next_meeting' => '2024-12-15',
            'status' => 'active'
        ],
        [
            'name' => 'Sarah Johnson',
            'email' => 'sarah.johnson@university.edu',
            'major' => 'Business Administration',
            'gpa' => 3.5,
            'year' => 'Sophomore',
            'last_meeting' => '2024-12-08',
            'next_meeting' => '2024-12-18',
            'status' => 'active'
        ],
        [
            'name' => 'Michael Brown',
            'email' => 'michael.brown@university.edu',
            'major' => 'Engineering',
            'gpa' => 2.9,
            'year' => 'Senior',
            'last_meeting' => '2024-11-28',
            'next_meeting' => '2024-12-12',
            'status' => 'at_risk'
        ]
    ];
    
    // Get upcoming meetings (mock data)
    $upcomingMeetings = [
        [
            'student' => 'Emily Davis',
            'time' => '2024-12-15 10:00:00',
            'type' => 'Academic Planning',
            'duration' => '30 minutes',
            'status' => 'confirmed'
        ],
        [
            'student' => 'David Wilson',
            'time' => '2024-12-15 14:30:00',
            'type' => 'Career Guidance',
            'duration' => '45 minutes',
            'status' => 'confirmed'
        ],
        [
            'student' => 'Lisa Anderson',
            'time' => '2024-12-16 09:15:00',
            'type' => 'Course Selection',
            'duration' => '30 minutes',
            'status' => 'pending'
        ]
    ];
    
} catch (Exception $e) {
    error_log("Advisor dashboard error: " . $e->getMessage());
    $advisorStats = [];
    $assignedStudents = [];
    $upcomingMeetings = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advisor Dashboard - MashouraX</title>
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
            background: #4CAF50;
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
            border-color: rgba(76, 175, 80, 0.3);
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
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .section-action:hover {
            background: #388E3C;
            transform: translateY(-2px);
        }
        
        .student-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .student-item:hover {
            border-color: rgba(76, 175, 80, 0.3);
            transform: translateY(-2px);
        }
        
        .student-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .student-name {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-active {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
        }
        
        .status-at_risk {
            background: rgba(244, 67, 54, 0.2);
            color: #f44336;
        }
        
        .student-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-label {
            color: #aaa;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .detail-value {
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
        }
        
        .meeting-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .meeting-item:last-child {
            border-bottom: none;
        }
        
        .meeting-time {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            min-width: 80px;
            text-align: center;
        }
        
        .meeting-content {
            flex: 1;
        }
        
        .meeting-student {
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .meeting-type {
            color: #aaa;
            font-size: 14px;
            margin: 0 0 5px 0;
        }
        
        .meeting-duration {
            color: #666;
            font-size: 12px;
        }
        
        .meeting-status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-confirmed {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
        }
        
        .status-pending {
            background: rgba(255, 152, 0, 0.2);
            color: #FF9800;
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
            border-color: rgba(76, 175, 80, 0.3);
        }
        
        .action-icon {
            width: 60px;
            height: 60px;
            background: #4CAF50;
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
            
            .student-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Advisor Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                </div>
                <div>
                    <div style="color: #ffffff; font-weight: 600;"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></div>
                    <div style="font-size: 14px;">Academic Advisor - <?php echo htmlspecialchars($user['institution']); ?></div>
                </div>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>

        <!-- Advisor Statistics Cards -->
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Assigned Students</h3>
                    <div class="stat-icon" style="background: rgba(76, 175, 80, 0.2); color: #4CAF50;">👥</div>
                </div>
                <p class="stat-value"><?php echo number_format($advisorStats['assigned_students'] ?? 0); ?></p>
                <p class="stat-subtitle">Under your guidance</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Meetings Today</h3>
                    <div class="stat-icon" style="background: rgba(33, 150, 243, 0.2); color: #2196F3;">📅</div>
                </div>
                <p class="stat-value"><?php echo number_format($advisorStats['meetings_today'] ?? 0); ?></p>
                <p class="stat-subtitle">Scheduled appointments</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">This Week</h3>
                    <div class="stat-icon" style="background: rgba(255, 152, 0, 0.2); color: #FF9800;">📊</div>
                </div>
                <p class="stat-value"><?php echo number_format($advisorStats['meetings_week'] ?? 0); ?></p>
                <p class="stat-subtitle">Total meetings</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Pending Requests</h3>
                    <div class="stat-icon" style="background: rgba(156, 39, 176, 0.2); color: #9C27B0;">⏳</div>
                </div>
                <p class="stat-value"><?php echo number_format($advisorStats['pending_requests'] ?? 0); ?></p>
                <p class="stat-subtitle">Awaiting response</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Urgent Cases</h3>
                    <div class="stat-icon" style="background: rgba(244, 67, 54, 0.2); color: #f44336;">⚠️</div>
                </div>
                <p class="stat-value"><?php echo number_format($advisorStats['urgent_cases'] ?? 0); ?></p>
                <p class="stat-subtitle">Require immediate attention</p>
            </div>
        </div>

        <!-- Assigned Students Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">Assigned Students</h2>
                <a href="#" class="section-action">Manage Students</a>
            </div>
            <?php foreach ($assignedStudents as $student): ?>
            <div class="student-item">
                <div class="student-header">
                    <h3 class="student-name"><?php echo htmlspecialchars($student['name']); ?></h3>
                    <span class="status-badge status-<?php echo $student['status']; ?>">
                        <?php echo ucfirst(str_replace('_', ' ', $student['status'])); ?>
                    </span>
                </div>
                <div class="student-details">
                    <div class="detail-item">
                        <span class="detail-label">Email</span>
                        <span class="detail-value"><?php echo htmlspecialchars($student['email']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Major</span>
                        <span class="detail-value"><?php echo htmlspecialchars($student['major']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">GPA</span>
                        <span class="detail-value"><?php echo $student['gpa']; ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Year</span>
                        <span class="detail-value"><?php echo $student['year']; ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Last Meeting</span>
                        <span class="detail-value"><?php echo date('M j, Y', strtotime($student['last_meeting'])); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Next Meeting</span>
                        <span class="detail-value"><?php echo date('M j, Y', strtotime($student['next_meeting'])); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Upcoming Meetings Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">Upcoming Meetings</h2>
                <a href="#" class="section-action">Schedule Meeting</a>
            </div>
            <?php foreach ($upcomingMeetings as $meeting): ?>
            <div class="meeting-item">
                <div class="meeting-time">
                    <?php echo date('H:i', strtotime($meeting['time'])); ?>
                </div>
                <div class="meeting-content">
                    <h4 class="meeting-student"><?php echo htmlspecialchars($meeting['student']); ?></h4>
                    <p class="meeting-type"><?php echo htmlspecialchars($meeting['type']); ?></p>
                    <p class="meeting-duration"><?php echo $meeting['duration']; ?></p>
                </div>
                <span class="meeting-status status-<?php echo $meeting['status']; ?>">
                    <?php echo ucfirst($meeting['status']); ?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-section">
            <h2 class="section-title" style="margin-bottom: 30px;">Quick Actions</h2>
            <div class="quick-actions">
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">👥</div>
                    <h3 class="action-title">Manage Students</h3>
                    <p class="action-desc">View and manage assigned students</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📅</div>
                    <h3 class="action-title">Schedule Meeting</h3>
                    <p class="action-desc">Book appointments with students</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📊</div>
                    <h3 class="action-title">Student Progress</h3>
                    <p class="action-desc">Track academic progress</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📝</div>
                    <h3 class="action-title">Notes & Reports</h3>
                    <p class="action-desc">Add notes and generate reports</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">🎯</div>
                    <h3 class="action-title">Goal Setting</h3>
                    <p class="action-desc">Help students set academic goals</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📧</div>
                    <h3 class="action-title">Communications</h3>
                    <p class="action-desc">Send messages to students</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
