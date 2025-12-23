<?php
/**
 * Admin Dashboard - MashouraX Virtual Advising Platform
 * Comprehensive admin dashboard with all management features
 */

require_once 'includes/auth.php';

// Check if user is logged in and is admin
requireLogin();
$user = getCurrentUser();

if ($user['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Get dashboard statistics
try {
    $pdo = getDBConnection();
    
    // Get user statistics
    $userStats = [
        'total_users' => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
        'students' => $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn(),
        'advisors' => $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'advisor'")->fetchColumn(),
        'admins' => $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn(),
        'active_sessions' => $pdo->query("SELECT COUNT(*) FROM user_sessions WHERE expires_at > NOW()")->fetchColumn(),
        'new_users_today' => $pdo->query("SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()")->fetchColumn(),
        'new_users_week' => $pdo->query("SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn(),
        'new_users_month' => $pdo->query("SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn()
    ];
    
    // Get recent users
    $recentUsers = $pdo->query("
        SELECT first_name, last_name, email, role, institution, created_at 
        FROM users 
        ORDER BY created_at DESC 
        LIMIT 10
    ")->fetchAll();
    
    // Get active sessions
    $activeSessions = $pdo->query("
        SELECT u.first_name, u.last_name, u.email, u.role, s.created_at, s.ip_address
        FROM user_sessions s
        JOIN users u ON s.user_id = u.id
        WHERE s.expires_at > NOW()
        ORDER BY s.created_at DESC
        LIMIT 10
    ")->fetchAll();
    
} catch (Exception $e) {
    error_log("Dashboard error: " . $e->getMessage());
    $userStats = [];
    $recentUsers = [];
    $activeSessions = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MashouraX</title>
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
            background: #007bff;
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
            border-color: rgba(0, 123, 255, 0.3);
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
        
        .stat-change {
            color: #4CAF50;
            font-size: 14px;
            font-weight: 500;
        }
        
        .stat-change.negative {
            color: #f44336;
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
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .section-action:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .data-table td {
            color: #aaa;
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .data-table tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .role-student {
            background: rgba(33, 150, 243, 0.2);
            color: #2196F3;
        }
        
        .role-advisor {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
        }
        
        .role-admin {
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
            border-color: rgba(0, 123, 255, 0.3);
        }
        
        .action-icon {
            width: 60px;
            height: 60px;
            background: #007bff;
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
            <h1 class="dashboard-title">Admin Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                </div>
                <div>
                    <div style="color: #ffffff; font-weight: 600;"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></div>
                    <div style="font-size: 14px;">Administrator</div>
                </div>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Total Users</h3>
                    <div class="stat-icon" style="background: rgba(0, 123, 255, 0.2); color: #007bff;">👥</div>
                </div>
                <p class="stat-value"><?php echo number_format($userStats['total_users'] ?? 0); ?></p>
                <p class="stat-change">All registered users</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Students</h3>
                    <div class="stat-icon" style="background: rgba(33, 150, 243, 0.2); color: #2196F3;">🎓</div>
                </div>
                <p class="stat-value"><?php echo number_format($userStats['students'] ?? 0); ?></p>
                <p class="stat-change">Active students</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Advisors</h3>
                    <div class="stat-icon" style="background: rgba(76, 175, 80, 0.2); color: #4CAF50;">👨‍🏫</div>
                </div>
                <p class="stat-value"><?php echo number_format($userStats['advisors'] ?? 0); ?></p>
                <p class="stat-change">Academic advisors</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Active Sessions</h3>
                    <div class="stat-icon" style="background: rgba(255, 152, 0, 0.2); color: #FF9800;">🔐</div>
                </div>
                <p class="stat-value"><?php echo number_format($userStats['active_sessions'] ?? 0); ?></p>
                <p class="stat-change">Currently online</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">New Today</h3>
                    <div class="stat-icon" style="background: rgba(156, 39, 176, 0.2); color: #9C27B0;">📈</div>
                </div>
                <p class="stat-value"><?php echo number_format($userStats['new_users_today'] ?? 0); ?></p>
                <p class="stat-change">Registered today</p>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">This Week</h3>
                    <div class="stat-icon" style="background: rgba(244, 67, 54, 0.2); color: #f44336;">📊</div>
                </div>
                <p class="stat-value"><?php echo number_format($userStats['new_users_week'] ?? 0); ?></p>
                <p class="stat-change">Last 7 days</p>
            </div>
        </div>

        <!-- Recent Users Section -->
        <div class="dashboard-section">
    <h2 class="section-title" style="margin-bottom: 30px;">Quick Actions</h2>
    <div class="quick-actions">
        <div class="action-card" onclick="window.location.href='manage_users.php'">
            <div class="action-icon">👥</div>
            <h3 class="action-title">Manage Users</h3>
            <p class="action-desc">Add, edit, or remove user accounts</p>
        </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Institution</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentUsers as $recentUser): ?>
                    <tr>
                        <td style="color: #ffffff; font-weight: 600;">
                            <?php echo htmlspecialchars($recentUser['first_name'] . ' ' . $recentUser['last_name']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($recentUser['email']); ?></td>
                        <td>
                            <span class="role-badge role-<?php echo $recentUser['role']; ?>">
                                <?php echo ucfirst($recentUser['role']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($recentUser['institution']); ?></td>
                        <td><?php echo date('M j, Y', strtotime($recentUser['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Active Sessions Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">Active Sessions</h2>
                <a href="#" class="section-action">Manage Sessions</a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>IP Address</th>
                        <th>Session Started</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activeSessions as $session): ?>
                    <tr>
                        <td style="color: #ffffff; font-weight: 600;">
                            <?php echo htmlspecialchars($session['first_name'] . ' ' . $session['last_name']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($session['email']); ?></td>
                        <td>
                            <span class="role-badge role-<?php echo $session['role']; ?>">
                                <?php echo ucfirst($session['role']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($session['ip_address']); ?></td>
                        <td><?php echo date('M j, Y H:i', strtotime($session['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-section">
            <h2 class="section-title" style="margin-bottom: 30px;">Quick Actions</h2>
            <div class="quick-actions">
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">👥</div>
                    <h3 class="action-title">Manage Users</h3>
                    <p class="action-desc">Add, edit, or remove user accounts</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📊</div>
                    <h3 class="action-title">Analytics</h3>
                    <p class="action-desc">View detailed platform analytics</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">⚙️</div>
                    <h3 class="action-title">Settings</h3>
                    <p class="action-desc">Configure platform settings</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📧</div>
                    <h3 class="action-title">Notifications</h3>
                    <p class="action-desc">Send announcements to users</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">🔒</div>
                    <h3 class="action-title">Security</h3>
                    <p class="action-desc">Manage security settings</p>
                </div>
                
                <div class="action-card" onclick="window.location.href='#'">
                    <div class="action-icon">📈</div>
                    <h3 class="action-title">Reports</h3>
                    <p class="action-desc">Generate usage reports</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
