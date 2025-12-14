<?php
/**
 * Student Dashboard View
 * Template for student dashboard
 */
require_once __DIR__ . '/../BaseView.php';
require_once __DIR__ . '/../ViewHelper.php';

$view = new BaseView();
$helper = new ViewHelper();
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Welcome, <?php echo $view->escape($user['first_name']); ?>!</h1>
        <div class="user-info">
            <?php echo $helper->avatar($user); ?>
            <span><?php echo $helper->userName($user); ?></span>
        </div>
    </div>

    <!-- Academic Progress Section -->
    <?php if (isset($academicProgress) && !empty($academicProgress)): ?>
    <section class="dashboard-section">
        <h2>Academic Progress</h2>
        <div class="progress-cards">
            <div class="progress-card">
                <h3>GPA</h3>
                <div class="progress-value"><?php echo $helper->gpa($academicProgress['gpa'] ?? 0); ?></div>
            </div>
            <div class="progress-card">
                <h3>Credits</h3>
                <div class="progress-value">
                    <?php echo $academicProgress['credits_completed'] ?? 0; ?> / 
                    <?php echo $academicProgress['credits_required'] ?? 120; ?>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php 
                        echo $helper->percentage(
                            $academicProgress['credits_completed'] ?? 0, 
                            $academicProgress['credits_required'] ?? 120
                        ); 
                    ?>%"></div>
                </div>
            </div>
            <?php if (isset($academicProgress['advisor'])): ?>
            <div class="progress-card">
                <h3>Advisor</h3>
                <div class="progress-value"><?php echo $view->escape($academicProgress['advisor']); ?></div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Upcoming Assignments -->
    <?php if (isset($upcomingAssignments) && !empty($upcomingAssignments)): ?>
    <section class="dashboard-section">
        <h2>Upcoming Assignments</h2>
        <div class="assignments-list">
            <?php foreach ($upcomingAssignments as $assignment): ?>
            <div class="assignment-item">
                <div class="assignment-info">
                    <h4><?php echo $view->escape($assignment['title'] ?? ''); ?></h4>
                    <p class="assignment-course"><?php echo $view->escape($assignment['course'] ?? ''); ?></p>
                    <p class="assignment-due">Due: <?php echo $helper->datetime($assignment['due_date'] ?? ''); ?></p>
                </div>
                <div class="assignment-meta">
                    <span class="badge <?php echo $helper->priorityBadge($assignment['priority'] ?? 'medium'); ?>">
                        <?php echo ucfirst($assignment['priority'] ?? 'medium'); ?>
                    </span>
                    <span class="badge <?php echo $helper->statusBadge($assignment['status'] ?? 'pending'); ?>">
                        <?php echo ucfirst($assignment['status'] ?? 'pending'); ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
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
                    <h4>Meeting with <?php echo $view->escape($meeting['advisor_first_name'] ?? 'Advisor'); ?></h4>
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

