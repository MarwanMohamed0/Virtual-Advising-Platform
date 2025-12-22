<?php
/**
 * MashouraX Email Service Class
 * Location: classes/EmailService.php
 * 
 * Handles all email functionality using PHPMailer
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $config;
    private $mail;
    private $db;
    
    public function __construct($db = null) {
        $this->config = require __DIR__ . '/../config/email_config.php';
        $this->db = $db;
        $this->initializeMailer();
    }
    
    /**
     * Initialize PHPMailer with SMTP configuration
     */
    private function initializeMailer() {
        $this->mail = new PHPMailer(true);
        
        try {
            // SMTP Configuration
            $this->mail->isSMTP();
            $this->mail->Host = $this->config['smtp_host'];
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $this->config['smtp_username'];
            $this->mail->Password = $this->config['smtp_password'];
            $this->mail->SMTPSecure = $this->config['smtp_encryption'];
            $this->mail->Port = $this->config['smtp_port'];
            
            // Sender Information
            $this->mail->setFrom(
                $this->config['from_email'], 
                $this->config['from_name']
            );
            $this->mail->addReplyTo($this->config['reply_to']);
            
            // Email Settings
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';
            
            // Debug Mode
            $this->mail->SMTPDebug = $this->config['debug_mode'] ? 0 : 0;
            
        } catch (Exception $e) {
            error_log("EmailService initialization error: " . $e->getMessage());
            throw new Exception("Failed to initialize email service");
        }
    }
    
    /**
     * Send email verification
     */
    public function sendVerificationEmail($userEmail, $userName, $token) {
        $verifyUrl = $this->config['website_url'] . '/verify-email.php?token=' . $token;
        
        $subject = "Verify Your MashouraX Account";
        $body = $this->getEmailTemplate('verification', [
            'user_name' => $userName,
            'verify_url' => $verifyUrl,
            'expiry_hours' => $this->config['verification_token_expiry']
        ]);
        
        return $this->send($userEmail, $subject, $body);
    }
    
    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail($userEmail, $userName, $token) {
        $resetUrl = $this->config['website_url'] . '/reset-password.php?token=' . $token;
        
        $subject = "Reset Your MashouraX Password";
        $body = $this->getEmailTemplate('password_reset', [
            'user_name' => $userName,
            'reset_url' => $resetUrl,
            'expiry_hours' => $this->config['reset_token_expiry']
        ]);
        
        return $this->send($userEmail, $subject, $body);
    }
    
    /**
     * Send welcome email after successful registration
     */
    public function sendWelcomeEmail($userEmail, $userName, $userType = 'student') {
        $subject = "Welcome to MashouraX! 🎓";
        $body = $this->getEmailTemplate('welcome', [
            'user_name' => $userName,
            'user_type' => $userType,
            'dashboard_url' => $this->config['website_url'] . '/dashboard.php'
        ]);
        
        return $this->send($userEmail, $subject, $body);
    }
    
    /**
     * Send meeting confirmation email
     */
    public function sendMeetingConfirmation($userEmail, $userName, $meetingDetails) {
        $subject = "Meeting Confirmed - " . $meetingDetails['title'];
        $body = $this->getEmailTemplate('meeting_confirmation', [
            'user_name' => $userName,
            'meeting_title' => $meetingDetails['title'],
            'meeting_date' => $meetingDetails['date'],
            'meeting_time' => $meetingDetails['time'],
            'advisor_name' => $meetingDetails['advisor_name'],
            'meeting_link' => $meetingDetails['meeting_link'] ?? '',
            'meeting_id' => $meetingDetails['id']
        ]);
        
        return $this->send($userEmail, $subject, $body);
    }
    
    /**
     * Send meeting reminder email
     */
    public function sendMeetingReminder($userEmail, $userName, $meetingDetails) {
        $subject = "Reminder: Meeting Tomorrow - " . $meetingDetails['title'];
        $body = $this->getEmailTemplate('meeting_reminder', [
            'user_name' => $userName,
            'meeting_title' => $meetingDetails['title'],
            'meeting_date' => $meetingDetails['date'],
            'meeting_time' => $meetingDetails['time'],
            'advisor_name' => $meetingDetails['advisor_name'],
            'meeting_link' => $meetingDetails['meeting_link'] ?? ''
        ]);
        
        return $this->send($userEmail, $subject, $body);
    }
    
    /**
     * Send meeting cancellation email
     */
    public function sendMeetingCancellation($userEmail, $userName, $meetingDetails) {
        $subject = "Meeting Cancelled - " . $meetingDetails['title'];
        $body = $this->getEmailTemplate('meeting_cancellation', [
            'user_name' => $userName,
            'meeting_title' => $meetingDetails['title'],
            'meeting_date' => $meetingDetails['date'],
            'meeting_time' => $meetingDetails['time'],
            'reason' => $meetingDetails['cancellation_reason'] ?? 'Not specified'
        ]);
        
        return $this->send($userEmail, $subject, $body);
    }
    
    /**
     * Core send method
     */
    private function send($to, $subject, $body) {
        try {
            // Clear previous recipients
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();
            
            // Test mode: redirect all emails
            if (!empty($this->config['test_email'])) {
                $this->mail->addAddress($this->config['test_email']);
                $subject = "[TEST - To: $to] " . $subject;
            } else {
                $this->mail->addAddress($to);
            }
            
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);
            
            $result = $this->mail->send();
            
            // Log email in database if available
            if ($this->db && $result) {
                $this->logEmail($to, $subject, 'sent');
            }
            
            return $result;
            
        } catch (Exception $e) {
            error_log("Email send error: " . $this->mail->ErrorInfo);
            
            // Log failed email
            if ($this->db) {
                $this->logEmail($to, $subject, 'failed', $this->mail->ErrorInfo);
            }
            
            return false;
        }
    }
    
    /**
     * Log email activity to database
     */
    private function logEmail($to, $subject, $status, $error = null) {
        if (!$this->db) return;
        
        try {
            $stmt = $this->db->prepare("
                INSERT INTO email_logs (recipient, subject, status, error_message, sent_at)
                VALUES (?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$to, $subject, $status, $error]);
        } catch (Exception $e) {
            error_log("Failed to log email: " . $e->getMessage());
        }
    }
    
    /**
     * Get email template with data
     */
    private function getEmailTemplate($template, $data) {
        $templateFile = __DIR__ . "/../email_templates/{$template}.php";
        
        if (!file_exists($templateFile)) {
            throw new Exception("Email template not found: {$template}");
        }
        
        // Extract data for template
        extract($data);
        extract($this->config);
        
        // Capture template output
        ob_start();
        include $templateFile;
        return ob_get_clean();
    }
    
    /**
     * Test email configuration
     */
    public function testConnection($testEmail) {
        try {
            $subject = "MashouraX Email Test";
            $body = $this->getBaseTemplate(
                "Test Email",
                "<p>This is a test email from MashouraX.</p>" .
                "<p>If you received this, your email configuration is working correctly!</p>"
            );
            
            return $this->send($testEmail, $subject, $body);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Get base HTML template wrapper
     */
    private function getBaseTemplate($title, $content) {
        return '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($title) . '</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0a0a0a; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #0a0a0a; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #1a1a1a; border-radius: 12px; overflow: hidden; border: 1px solid rgba(218, 165, 32, 0.2);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 30px; text-align: center; border-bottom: 1px solid rgba(218, 165, 32, 0.2);">
                            <h1 style="margin: 0; color: #DAA520; font-size: 28px; font-weight: 700;">MashouraX</h1>
                            <p style="margin: 8px 0 0; color: #888; font-size: 14px;">Virtual Advising Platform</p>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px; color: #ffffff;">
                            ' . $content . '
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; text-align: center; border-top: 1px solid rgba(218, 165, 32, 0.2); background-color: #0f0f0f;">
                            <p style="margin: 0 0 10px; color: #666; font-size: 12px;">
                                © 2025 MashouraX. All rights reserved.
                            </p>
                            <p style="margin: 0; color: #666; font-size: 12px;">
                                <a href="' . $this->config['website_url'] . '/privacy.php" style="color: #DAA520; text-decoration: none;">Privacy Policy</a> | 
                                <a href="' . $this->config['website_url'] . '/contact.php" style="color: #DAA520; text-decoration: none;">Contact Support</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    }
}