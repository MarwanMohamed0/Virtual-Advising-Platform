<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/auth.php';

requireLogin();
$user = getCurrentUser();
if ($user['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$pdo = getDBConnection();

// Handle actions: add, edit, delete
$errors  = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create' || $action === 'update') {
        $id          = $_POST['id'] ?? null;
        $first_name  = trim($_POST['first_name'] ?? '');
        $last_name   = trim($_POST['last_name'] ?? '');
        $email       = trim($_POST['email'] ?? '');
        $institution = trim($_POST['institution'] ?? '');
        $role        = $_POST['role'] ?? 'student';

        // validation
        if (!in_array($role, ['student','advisor','admin'], true)) {
            $errors[] = 'Invalid role.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address.';
        }
        if ($first_name === '' || $last_name === '' || $institution === '') {
            $errors[] = 'First name, last name, and institution are required.';
        }

        if (!$errors) {
            if ($action === 'create') {
                $stmt = $pdo->prepare("
                    INSERT INTO users (first_name, last_name, email, institution, role, password_hash)
                    VALUES (:first_name, :last_name, :email, :institution, :role, :password_hash)
                ");
                $stmt->execute([
                    ':first_name'    => $first_name,
                    ':last_name'     => $last_name,
                    ':email'         => $email,
                    ':institution'   => $institution,
                    ':role'          => $role,
                    // default password – change in production
                    ':password_hash' => password_hash('ChangeMe123!', PASSWORD_DEFAULT),
                ]);
                $success = 'User created successfully.';
            } else {
                $stmt = $pdo->prepare("
                    UPDATE users
                    SET first_name  = :first_name,
                        last_name   = :last_name,
                        email       = :email,
                        institution = :institution,
                        role        = :role
                    WHERE id       = :id
                ");
                $stmt->execute([
                    ':first_name'  => $first_name,
                    ':last_name'   => $last_name,
                    ':email'       => $email,
                    ':institution' => $institution,
                    ':role'        => $role,
                    ':id'          => $id,
                ]);
                $success = 'User updated successfully.';
            }
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $success = 'User deleted successfully.';
    }
}

// Load all students/advisors/admins for table
$stmt = $pdo->query("
    SELECT id, first_name, last_name, email, role, institution, created_at
    FROM users
    WHERE role IN ('student','advisor','admin')
    ORDER BY created_at DESC
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - MashouraX</title>
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
        .stat-card select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            margin-bottom: 14px;
            outline: none;
        }

        .stat-card input:focus,
        .stat-card select:focus {
            border-color: #007bff;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .data-table td {
            color: #aaa;
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .data-table tr:hover {
            background: rgba(255, 255, 255, 0.04);
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
        <h1 class="dashboard-title">Manage Students & Advisors</h1>
        <a href="admin-dashboard.php" class="section-action">← Back to Dashboard</a>
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

    <!-- Create / Edit form -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2 class="section-title">Add / Edit User</h2>
        </div>

        <form method="post" id="userForm">
            <input type="hidden" name="id" id="user_id">
            <input type="hidden" name="action" id="form_action" value="create">

            <div class="dashboard-grid">
                <div class="stat-card">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" required>

                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="stat-card">
                    <label for="institution">Institution</label>
                    <input type="text" name="institution" id="institution" required>

                    <label for="role">Role</label>
                    <select name="role" id="role" required>
                        <option value="student">Student</option>
                        <option value="advisor">Advisor</option>
                        <option value="admin">Admin</option>
                    </select>

                    <button type="submit" class="section-action" style="margin-top:18px;">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Users table -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2 class="section-title">Students, Advisors & Admins</h2>
        </div>

        <table class="data-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Institution</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td style="color:#fff;font-weight:600;">
                        <?php echo htmlspecialchars($u['first_name'].' '.$u['last_name']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td>
                        <span class="role-badge role-<?php echo $u['role']; ?>">
                            <?php echo ucfirst($u['role']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($u['institution']); ?></td>
                    <td><?php echo date('M j, Y', strtotime($u['created_at'])); ?></td>
                    <td>
                        <button type="button"
                                onclick='editUser(<?php echo json_encode($u); ?>)'
                                class="section-action"
                                style="padding:6px 10px;font-size:12px;margin-right:6px;">
                            Edit
                        </button>

                        <form method="post" style="display:inline;"
                              onsubmit="return confirm('Delete this user?');">
                            <input type="hidden" name="id" value="<?php echo (int)$u['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="logout-btn"
                                    style="padding:6px 10px;font-size:12px;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
function editUser(u) {
    document.getElementById('user_id').value       = u.id;
    document.getElementById('first_name').value    = u.first_name;
    document.getElementById('last_name').value     = u.last_name;
    document.getElementById('email').value         = u.email;
    document.getElementById('institution').value   = u.institution;
    document.getElementById('role').value          = u.role;   // student/advisor/admin
    document.getElementById('form_action').value   = 'update';
}
</script>
</body>
</html>
