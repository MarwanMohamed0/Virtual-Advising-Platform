<?php
/**
 * Admin Dashboard View
 * Template for admin dashboard
 */
require_once __DIR__ . '/../BaseView.php';
require_once __DIR__ . '/../ViewHelper.php';

$view = new BaseView();
$helper = new ViewHelper();
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Admin Dashboard</h1>
        <div class="user-info">
            <?php echo $helper->avatar($user); ?>
            <span><?php echo $helper->userName($user); ?></span>
        </div>
    </div>

    <!-- System Statistics -->
    <?php if (isset($systemStats) && !empty($systemStats)): ?>
    <section class="dashboard-section">
        <h2>System Statistics</h2>
        <div class="stats-grid">
            <?php if (isset($systemStats['users'])): ?>
            <div class="stat-card">
                <h3>Total Users</h3>
                <div class="stat-value"><?php echo $systemStats['users']['total'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Students</h3>
                <div class="stat-value"><?php echo $systemStats['users']['students'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Advisors</h3>
                <div class="stat-value"><?php echo $systemStats['users']['advisors'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Admins</h3>
                <div class="stat-value"><?php echo $systemStats['users']['admins'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Active Sessions</h3>
                <div class="stat-value"><?php echo $systemStats['active_sessions'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>New Users (Today)</h3>
                <div class="stat-value"><?php echo $systemStats['users']['new_today'] ?? 0; ?></div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Recent Users -->
    <?php if (isset($recentUsers) && !empty($recentUsers)): ?>
    <section class="dashboard-section">
        <h2>Recent Users</h2>
        <div class="users-table">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Institution</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentUsers as $recentUser): ?>
                    <tr>
                        <td><?php echo $view->escape($recentUser['first_name'] ?? '' . ' ' . $recentUser['last_name'] ?? ''); ?></td>
                        <td><?php echo $view->escape($recentUser['email'] ?? ''); ?></td>
                        <td>
                            <span class="badge badge-info"><?php echo ucfirst($recentUser['role'] ?? ''); ?></span>
                        </td>
                        <td><?php echo $view->escape($recentUser['institution'] ?? ''); ?></td>
                        <td><?php echo $helper->timeAgo($recentUser['created_at'] ?? ''); ?></td>
                        <td>
                            <a href="#" class="btn btn-sm">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php endif; ?>

    <!-- Active Sessions -->
    <?php if (isset($activeSessions) && !empty($activeSessions)): ?>
    <section class="dashboard-section">
        <h2>Active Sessions</h2>
        <div class="sessions-table">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>IP Address</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activeSessions as $session): ?>
                    <tr>
                        <td><?php echo $view->escape($session['first_name'] ?? '' . ' ' . $session['last_name'] ?? ''); ?></td>
                        <td><?php echo $view->escape($session['email'] ?? ''); ?></td>
                        <td>
                            <span class="badge badge-info"><?php echo ucfirst($session['role'] ?? ''); ?></span>
                        </td>
                        <td><?php echo $view->escape($session['ip_address'] ?? ''); ?></td>
                        <td><?php echo $helper->timeAgo($session['created_at'] ?? ''); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php endif; ?>
</div>

