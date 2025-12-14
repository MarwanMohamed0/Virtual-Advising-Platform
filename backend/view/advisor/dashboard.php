<?php
/**
 * Advisor Dashboard View
 * Template for advisor dashboard
 */
require_once __DIR__ . '/../BaseView.php';
require_once __DIR__ . '/../ViewHelper.php';

$view = new BaseView();
$helper = new ViewHelper();
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Advisor Dashboard</h1>
        <div class="user-info">
            <?php echo $helper->avatar($user); ?>
            <span><?php echo $helper->userName($user); ?></span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <?php if (isset($stats) && !empty($stats)): ?>
    <section class="dashboard-section">
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Students</h3>
                <div class="stat-value"><?php echo $stats['total_students'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Assigned Students</h3>
                <div class="stat-value"><?php echo $stats['assigned_students'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Meetings Today</h3>
                <div class="stat-value"><?php echo $stats['meetings_today'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Meetings This Week</h3>
                <div class="stat-value"><?php echo $stats['meetings_week'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Pending Requests</h3>
                <div class="stat-value"><?php echo $stats['pending_requests'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Urgent Cases</h3>
                <div class="stat-value"><?php echo $stats['urgent_cases'] ?? 0; ?></div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Assigned Students -->
    <?php if (isset($assignedStudents) && !empty($assignedStudents)): ?>
    <section class="dashboard-section">
        <h2>Assigned Students</h2>
        <div class="students-table">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Last Meeting</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assignedStudents as $student): ?>
                    <tr>
                        <td><?php echo $view->escape($student['first_name'] ?? '' . ' ' . $student['last_name'] ?? ''); ?></td>
                        <td><?php echo $view->escape($student['email'] ?? ''); ?></td>
                        <td>
                            <span class="badge badge-success">Active</span>
                        </td>
                        <td><?php echo $helper->date($student['assigned_at'] ?? ''); ?></td>
                        <td>
                            <a href="#" class="btn btn-sm">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php endif; ?>

    <!-- Upcoming Meetings -->
    <?php if (isset($upcomingMeetings) && !empty($upcomingMeetings)): ?>
    <section class="dashboard-section">
        <h2>Upcoming Meetings</h2>
        <div class="meetings-list">
            <?php foreach ($upcomingMeetings as $meeting): ?>
            <div class="meeting-item">
                <div class="meeting-info">
                    <h4><?php echo $view->escape($meeting['student_first_name'] ?? '' . ' ' . $meeting['student_last_name'] ?? ''); ?></h4>
                    <p><?php echo $helper->datetime($meeting['scheduled_at'] ?? ''); ?></p>
                    <p class="meeting-type"><?php echo $view->escape($meeting['type'] ?? 'General'); ?></p>
                </div>
                <div class="meeting-status">
                    <span class="badge <?php echo $helper->statusBadge($meeting['status'] ?? 'scheduled'); ?>">
                        <?php echo ucfirst($meeting['status'] ?? 'scheduled'); ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>

