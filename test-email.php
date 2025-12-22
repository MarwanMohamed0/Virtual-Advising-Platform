<?php
/**
 * MashouraX Email System - Example Usage & Test File
 * Location: test-email.php (in your root directory)
 */

require_once 'vendor/autoload.php';
require_once 'classes/EmailService.php';

// Initialize the email service
try {
    $emailService = new EmailService();
    echo "✓ Email service initialized successfully<br><br>";
} catch (Exception $e) {
    die("✗ Failed to initialize email service: " . $e->getMessage());
}

// Test configuration
$testEmail = "your-test-email@example.com"; // CHANGE THIS

echo "<h2>MashouraX Email System Test</h2>";
echo "<hr>";

// ======================
// TEST 1: Connection Test
// ======================
echo "<h3>Test 1: Testing SMTP Connection</h3>";
if ($emailService->testConnection($testEmail)) {
    echo "✓ <strong>SUCCESS!</strong> Test email sent to: $testEmail<br>";
    echo "Check your inbox to confirm email delivery.<br><br>";
} else {
    echo "✗ <strong>FAILED!</strong> Could not send test email.<br>";
    echo "Check your SMTP configuration in config/email_config.php<br><br>";
}

// ======================
// Example Usage Patterns
// ======================
echo "<hr><h3>Example Usage Patterns</h3>";

// Example 1: Send verification email
echo "<h4>1. Send Verification Email:</h4>";
echo "<pre>";
echo "// After user registration
\$token = bin2hex(random_bytes(32));
\$expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));

// Store token in database
\$stmt = \$db->prepare(\"UPDATE users SET verification_token = ?, verification_token_expires = ? WHERE email = ?\");
\$stmt->execute([\$token, \$expiresAt, \$userEmail]);

// Send email
\$emailService->sendVerificationEmail(\$userEmail, \$userName, \$token);
";
echo "</pre>";

// Example 2: Send password reset
echo "<h4>2. Send Password Reset Email:</h4>";
echo "<pre>";
echo "// When user requests password reset
\$token = bin2hex(random_bytes(32));
\$expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

\$stmt = \$db->prepare(\"UPDATE users SET password_reset_token = ?, password_reset_expires = ? WHERE email = ?\");
\$stmt->execute([\$token, \$expiresAt, \$userEmail]);

\$emailService->sendPasswordResetEmail(\$userEmail, \$userName, \$token);
";
echo "</pre>";

// Example 3: Send welcome email
echo "<h4>3. Send Welcome Email:</h4>";
echo "<pre>";
echo "// After successful email verification
\$emailService->sendWelcomeEmail(\$userEmail, \$userName, 'student');
// or
\$emailService->sendWelcomeEmail(\$advisorEmail, \$advisorName, 'advisor');
";
echo "</pre>";

// Example 4: Send meeting confirmation
echo "<h4>4. Send Meeting Confirmation:</h4>";
echo "<pre>";
echo "// After booking a meeting
\$meetingDetails = [
    'id' => 123,
    'title' => 'Academic Advising Session',
    'date' => 'December 25, 2025',
    'time' => '2:00 PM EST',
    'advisor_name' => 'Dr. Sarah Johnson',
    'meeting_link' => 'https://meet.mashourax.com/abc123'
];

\$emailService->sendMeetingConfirmation(\$studentEmail, \$studentName, \$meetingDetails);
";
echo "</pre>";

// Example 5: Send meeting reminder
echo "<h4>5. Send Meeting Reminder (Automated via Cron):</h4>";
echo "<pre>";
echo "// In a cron job that runs every hour
\$tomorrow = date('Y-m-d', strtotime('+1 day'));
\$stmt = \$db->prepare(\"
    SELECT m.*, u.email, u.full_name, a.full_name as advisor_name
    FROM meetings m
    JOIN users u ON m.user_id = u.id
    JOIN users a ON m.advisor_id = a.id
    WHERE DATE(m.meeting_date) = ? AND m.reminder_sent = 0
\");
\$stmt->execute([\$tomorrow]);

while (\$meeting = \$stmt->fetch(PDO::FETCH_ASSOC)) {
    \$meetingDetails = [
        'title' => \$meeting['title'],
        'date' => date('F j, Y', strtotime(\$meeting['meeting_date'])),
        'time' => date('g:i A', strtotime(\$meeting['meeting_time'])),
        'advisor_name' => \$meeting['advisor_name'],
        'meeting_link' => \$meeting['meeting_link']
    ];
    
    \$emailService->sendMeetingReminder(\$meeting['email'], \$meeting['full_name'], \$meetingDetails);
    
    // Mark as sent
    \$updateStmt = \$db->prepare(\"UPDATE meetings SET reminder_sent = 1 WHERE id = ?\");
    \$updateStmt->execute([\$meeting['id']]);
}
";
echo "</pre>";

// Example 6: Send cancellation
echo "<h4>6. Send Meeting Cancellation:</h4>";
echo "<pre>";
echo "// When cancelling a meeting
\$meetingDetails = [
    'title' => 'Academic Advising Session',
    'date' => 'December 25, 2025',
    'time' => '2:00 PM EST',
    'cancellation_reason' => 'Advisor unavailable - emergency'
];

\$emailService->sendMeetingCancellation(\$studentEmail, \$studentName, \$meetingDetails);
";
echo "</pre>";

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Check your email inbox for the test message</li>";
echo "<li>If you didn't receive it, check spam/junk folder</li>";
echo "<li>Review and update config/email_config.php with your SMTP settings</li>";
echo "<li>Run the database schema (database/email_schema.sql)</li>";
echo "<li>Integrate the email calls into your registration, login, and meeting booking flows</li>";
echo "</ol>";

echo "<hr>";
echo "<p><strong>For Gmail:</strong> Use an 'App Password' instead of your regular password.</p>";
echo "<p>Generate one at: <a href='https://myaccount.google.com/apppasswords' target='_blank'>https://myaccount.google.com/apppasswords</a></p>";
?>