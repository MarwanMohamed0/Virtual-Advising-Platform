<?php
require_once 'includes/auth.php';

requireLogin();
$user = getCurrentUser();

if ($user['role'] !== 'advisor') {
    header('Location: index.php');
    exit();
}

$pdo = getDBConnection();
$advisorId = $user['id'];
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId   = (int)($_POST['student_id'] ?? 0);
    $date        = trim($_POST['date'] ?? '');
    $time        = trim($_POST['time'] ?? '');
    $duration    = (int)($_POST['duration'] ?? 30);
    $type        = trim($_POST['type'] ?? 'General');

    if (!$studentId || !$date || !$time) {
        $errors[] = 'Student, date, and time are required.';
    }

    $scheduledAt = $date . ' ' . $time . ':00';

    if (!$errors) {
        $stmt = $pdo->prepare("
            INSERT INTO meetings (advisor_id, student_id, scheduled_at, duration, type, status)
            VALUES (:advisor_id, :student_id, :scheduled_at, :duration, :type, 'scheduled')
        ");
        $stmt->execute([
            ':advisor_id'   => $advisorId,
            ':student_id'   => $studentId,
            ':scheduled_at' => $scheduledAt,
            ':duration'     => $duration,
            ':type'         => $type,
        ]);
        $success = 'Meeting scheduled successfully.';
    }
}

// load only students assigned to this advisor
$studentsStmt = $pdo->prepare("
    SELECT s.id, s.first_name, s.last_name
    FROM advisor_student_assignments asa
    JOIN users s ON asa.student_id = s.id
    WHERE asa.advisor_id = :advisor_id
      AND asa.is_active = 1
      AND s.role = 'student'
    ORDER BY s.first_name, s.last_name
");
$studentsStmt->execute([':advisor_id' => $advisorId]);
$students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Meeting - MashouraX</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Schedule Meeting</h1>
        <a href="advisor-dashboard.php" class="section-action">← Back to Dashboard</a>
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
        <form method="post">
            <div class="dashboard-grid">
                <div class="stat-card">
                    <label>Student</label>
                    <select name="student_id" required>
                        <option value="">Select student</option>
                        <?php foreach ($students as $s): ?>
                            <option value="<?php echo (int)$s['id']; ?>">
                                <?php echo htmlspecialchars($s['first_name'].' '.$s['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label>Date</label>
                    <input type="date" name="date" required>

                    <label>Time</label>
                    <input type="time" name="time" required>
                </div>
                <div class="stat-card">
                    <label>Duration (minutes)</label>
                    <input type="number" name="duration" value="30" min="15" max="240">

                    <label>Type</label>
                    <input type="text" name="type" value="General">

                    <button type="submit" class="section-action" style="margin-top:18px;">
                        Save Meeting
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
