<?php
/**
 * User Profile - MashouraX
 */

// 1. USE THE CORRECT AUTHENTICATION FROM YOUR SYSTEM
require_once 'includes/auth.php';

// 2. Check if user is logged in using your system's function
requireLogin();

// 3. Get the user data
$user = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - MashouraX</title>
    <link rel="stylesheet" href="index.css">
    <style>
        /* Reusing your Dashboard CSS for consistency */
        body { margin: 0; font-family: sans-serif; }
        
        .dashboard-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
            padding: 40px 20px;
            color: white;
        }

        .profile-card {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 40px;
            backdrop-filter: blur(10px);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 30px;
            margin-bottom: 30px;
        }

        .big-avatar {
            width: 80px;
            height: 80px;
            background: #2196F3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: bold;
            color: white;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .info-group label {
            display: block;
            color: #aaa;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .info-group .value {
            font-size: 18px;
            font-weight: 500;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            color: #aaa;
            text-decoration: none;
        }
        .back-btn:hover { color: white; }

        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <div style="max-width: 800px; margin: 0 auto;">
            <a href="student-dashboard.php" class="back-btn">← Back to Dashboard</a>
        </div>

        <div class="profile-card">
            <div class="profile-header">
                <div class="big-avatar">
                    <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                </div>
                <div>
                    <h1 style="margin: 0;"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h1>
                    <p style="color: #aaa; margin: 5px 0 0 0;"><?php echo htmlspecialchars($user['role']); ?></p>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-group">
                    <label>First Name</label>
                    <div class="value"><?php echo htmlspecialchars($user['first_name']); ?></div>
                </div>

                <div class="info-group">
                    <label>Last Name</label>
                    <div class="value"><?php echo htmlspecialchars($user['last_name']); ?></div>
                </div>

                <div class="info-group">
                    <label>Email Address</label>
                    <div class="value"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>

                <div class="info-group">
                    <label>Institution</label>
                    <div class="value"><?php echo htmlspecialchars($user['institution']); ?></div>
                </div>
            </div>

            <a href="logout.php" class="logout-btn">Log Out</a>
        </div>
    </div>

</body>
</html>