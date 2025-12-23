<?php
/**
 * Advisor Dashboard - MashouraX Virtual Advising Platform
 */

require_once 'includes/auth.php';

requireLogin();
$user = getCurrentUser();

if ($user['role'] !== 'advisor') {
    header('Location: index.php');
    exit();
}

$pdo = getDBConnection();

// Handle status change (Active / At Risk)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'], $_POST['status'])) {
    $studentId = (int) $_POST['student_id'];
    $status    = $_POST['status'] === 'at_risk' ? 'at_risk' : 'active';

    $stmt = $pdo->prepare("
        UPDATE users
        SET student_status = :status
        WHERE id = :id AND role = 'student'
    ");
    $stmt->execute([
        ':status' => $status,
        ':id'     => $studentId,
    ]);
}

// Load advisor statistics and real students
try {
    // Total students in system
    $totalStudents = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();

    // Real assigned students for this advisor.
    // For now, treat all students as 'assigned' to this advisor.
    $studentsStmt = $pdo->query("
        SELECT id, first_name, last_name, email, institution,
               COALESCE(student_status, 'active') AS student_status,
               created_at
        FROM users
        WHERE role = 'student'
        ORDER BY created_at DESC
        LIMIT 50
    ");
    $assignedStudents = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Basic stats using real data
    $activeCount = $pdo->query("
        SELECT COUNT(*) FROM users
        WHERE role = 'student' AND COALESCE(student_status,'active') = 'active'
    ")->fetchColumn();

    $atRiskCount = $pdo->query("
        SELECT COUNT(*) FROM users
        WHERE role = 'student' AND student_status = 'at_risk'
    ")->fetchColumn();

    $advisorStats = [
        'total_students'    => $totalStudents,
        'assigned_students' => count($assignedStudents),
        'active_students'   => $activeCount,
        'at_risk_students'  => $atRiskCount,
        // keep simple placeholders for meetings until you wire real tables
        'meetings_today'    => 0,
        'meetings_week'     => 0,
        'pending_requests'  => 0,
        'urgent_cases'      => $atRiskCount,
    ];

    // For now keep meetings mocked or empty
    $upcomingMeetings = [];

} catch (Exception $e) {
    error_log("Advisor dashboard error: " . $e->getMessage());
    $advisorStats      = [];
    $assignedStudents  = [];
    $upcomingMeetings  = [];
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
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }
        .stat-subtitle {
            color: #aaa;
            font-size: 14px;
        }
        .dashboard-section {
            max-width: 1400px;
            margin: 0 auto 30px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }
        .detail-label {
            color: #aaa;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .detail-value {
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
        }
        .status-form {
            margin-top: 10px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .status-form button {
            border: none;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .btn-active {
            background: #4CAF50;
            color: #fff;
        }
        .btn-risk {
            background: #f44336;
            color: #fff;
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
                <div style="color:#fff;font-weight:600;">
                    <?php echo htmlspecialchars($user['first_name'].' '.$user['last_name']); ?>
                </div>
                <div style="font-size:14px;">
                    Academic Advisor - <?php echo htmlspecialchars($user['institution']); ?>
                </div>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Stats -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-header">
                <h3 class="stat-title">Total Students</h3>
                <div class="stat-icon" style="background:rgba(76,175,80,0.2);color:#4CAF50;">👥</div>
            </div>
            <p class="stat-value"><?php echo number_format($advisorStats['total_students'] ?? 0); ?></p>
            <p class="stat-subtitle">In the system</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <h3 class="stat-title">Assigned Students</h3>
                <div class="stat-icon" style="background:rgba(33,150,243,0.2);color:#2196F3;">🎓</div>
            </div>
            <p class="stat-value"><?php echo number_format($advisorStats['assigned_students'] ?? 0); ?></p>
            <p class="stat-subtitle">Currently listed below</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <h3 class="stat-title">Active</h3>
                <div class="stat-icon" style="background:rgba(76,175,80,0.2);color:#4CAF50;">✅</div>
            </div>
            <p class="stat-value"><?php echo number_format($advisorStats['active_students'] ?? 0); ?></p>
            <p class="stat-subtitle">Good standing</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <h3 class="stat-title">At Risk</h3>
                <div class="stat-icon" style="background:rgba(244,67,54,0.2);color:#f44336;">⚠️</div>
            </div>
            <p class="stat-value"><?php echo number_format($advisorStats['at_risk_students'] ?? 0); ?></p>
            <p class="stat-subtitle">Need attention</p>
        </div>
    </div>

    <!-- Assigned Students (real data) -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2 class="section-title">Assigned Students</h2>
            <span style="color:#aaa;font-size:14px;">
                Showing latest <?php echo count($assignedStudents); ?> students
            </span>
        </div>

        <?php if (!$assignedStudents): ?>
            <p style="color:#aaa;">No students found yet.</p>
        <?php endif; ?>

        <?php foreach ($assignedStudents as $s): ?>
            <div class="student-item">
                <div class="student-header">
                    <h3 class="student-name">
                        <?php echo htmlspecialchars($s['first_name'].' '.$s['last_name']); ?>
                    </h3>
                    <span class="status-badge status-<?php echo $s['student_status']; ?>">
                        <?php echo $s['student_status'] === 'at_risk' ? 'AT RISK' : 'ACTIVE'; ?>
                    </span>
                </div>

                <div class="student-details">
                    <div>
                        <div class="detail-label">Email</div>
                        <div class="detail-value"><?php echo htmlspecialchars($s['email']); ?></div>
                    </div>
                    <div>
                        <div class="detail-label">Institution</div>
                        <div class="detail-value"><?php echo htmlspecialchars($s['institution']); ?></div>
                    </div>
                    <div>
                        <div class="detail-label">Joined</div>
                        <div class="detail-value">
                            <?php echo date('M j, Y', strtotime($s['created_at'])); ?>
                        </div>
                    </div>
                </div>

                <!-- Status controls -->
                <form method="post" class="status-form">
                    <input type="hidden" name="student_id" value="<?php echo (int)$s['id']; ?>">
                    <button type="submit" name="status" value="active" class="btn-active">
                        Mark Active
                    </button>
                    <button type="submit" name="status" value="at_risk" class="btn-risk">
                        Mark At Risk
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- You can later add Upcoming Meetings + Quick Actions again here -->

</div>
</body>
</html>
