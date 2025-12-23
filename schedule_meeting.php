<?php
require_once 'includes/auth.php';

requireLogin();
$user = getCurrentUser();

if ($user['role'] !== 'advisor') {
    header('Location: index.php');
    exit();
}

$pdo       = getDBConnection();
$advisorId = $user['id'];
$errors    = [];
$success   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = (int)($_POST['student_id'] ?? 0);
    $date      = trim($_POST['date'] ?? '');
    $time      = trim($_POST['time'] ?? '');
    $duration  = (int)($_POST['duration'] ?? 30);
    $type      = trim($_POST['type'] ?? 'Academic Planning');
    $notes     = trim($_POST['notes'] ?? '');

    if (!$studentId || !$date || !$time) {
        $errors[] = 'Student, date, and time are required.';
    }

    $scheduledAt = $date . ' ' . $time . ':00';

    if (!$errors) {
        $stmt = $pdo->prepare("
            INSERT INTO meetings
            (advisor_id, student_id, scheduled_at, duration, type, status, notes)
            VALUES (:advisor_id, :student_id, :scheduled_at, :duration, :type, 'scheduled', :notes)
        ");
        $stmt->execute([
            ':advisor_id'   => $advisorId,
            ':student_id'   => $studentId,
            ':scheduled_at' => $scheduledAt,
            ':duration'     => $duration,
            ':type'         => $type,
            ':notes'        => $notes,
        ]);
        $success = 'Meeting scheduled successfully.';
    }
}

// load assigned students for this advisor
$studentsStmt = $pdo->prepare("
    SELECT id, first_name, last_name
    FROM users
    WHERE role = 'student'
    ORDER BY first_name, last_name
");
$studentsStmt->execute();
$students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Meeting - MashouraX</title>
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
        .dashboard-section {
            max-width: 1400px;
            margin: 0 auto 30px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }
        .section-title {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 20px 0;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 15px;
            padding: 20px 25px;
        }
        .stat-card label {
            display: block;
            color: #ddd;
            font-size: 14px;
            margin-bottom: 6px;
        }
        .stat-card input,
        .stat-card select,
        .stat-card textarea {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            margin-bottom: 14px;
            outline: none;
            resize: vertical;
        }
        .stat-card input:focus,
        .stat-card select:focus,
        .stat-card textarea:focus {
            border-color: #4CAF50;
        }
        .alert {
            max-width: 1400px;
            margin: 0 auto 20px;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 14px;
        }
        .alert-error {
            background: rgba(220, 53, 69, 0.15);
            color: #f8d7da;
            border: 1px solid rgba(220, 53, 69, 0.4);
        }
        .alert-success {
            background: rgba(40, 167, 69, 0.15);
            color: #d4edda;
            border: 1px solid rgba(40, 167, 69, 0.4);
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
        <h1 class="dashboard-title">Schedule Meeting</h1>
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
            <a href="advisor-dashboard.php" class="section-action">← Back to Dashboard</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <?php if ($errors): ?>
        <div class="alert alert-error">
            <?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-section">
        <h2 class="section-title">New Meeting</h2>
        <form method="post">
            <div class="dashboard-grid">
                <div class="stat-card">
                    <label for="student_id">Student</label>
                    <select name="student_id" id="student_id" required>
                        <option value="">Select student</option>
                        <?php foreach ($students as $s): ?>
                            <option value="<?php echo (int)$s['id']; ?>">
                                <?php echo htmlspecialchars($s['first_name'].' '.$s['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" required>

                    <label for="time">Time</label>
                    <input type="time" name="time" id="time" required>
                </div>

                <div class="stat-card">
                    <label for="duration">Duration (minutes)</label>
                    <input type="number" name="duration" id="duration" value="30" min="15" max="240">

                    <label for="type">Meeting Type</label>
                    <input type="text" name="type" id="type" value="Academic Planning">

                    <label for="notes">Notes (optional)</label>
                    <textarea name="notes" id="notes" rows="4"
                              placeholder="Topics to discuss, preparation notes, etc."></textarea>

                    <button type="submit" class="section-action" style="margin-top:10px;">
                        Save Meeting
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
