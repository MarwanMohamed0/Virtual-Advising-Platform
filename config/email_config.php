<?php
/**
 * MashouraX Email Configuration
 * Location: config/email_config.php
 */

return [
    // SMTP Settings (Fill these in)
    'smtp_host' => 'smtp.gmail.com',  // For Gmail. Change if using different provider
    'smtp_port' => 587,                // 587 for TLS (Gmail), 465 for SSL
    'smtp_encryption' => 'tls',        // 'tls' or 'ssl'
    'smtp_username' => 'your-email@gmail.com',      // TODO: Add your email
    'smtp_password' => 'your-app-password-here',    // TODO: Add app password
    
    // Sender Information
    'from_email' => 'noreply@mashourax.com',
    'from_name' => 'MashouraX',
    'reply_to' => 'support@mashourax.com',
    
    // Website Settings
    'website_url' => 'https://yourdomain.com',  // TODO: Add your domain
    'website_name' => 'MashouraX - Virtual Advising Platform',
    'logo_url' => 'https://yourdomain.com/assets/logo.png',
    'support_email' => 'support@mashourax.com',
    
    // Brand Colors (for email templates)
    'brand_color' => '#DAA520',  // Gold from your theme
    'background_color' => '#000000',
    'text_color' => '#ffffff',
    
    // Security & Tokens
    'verification_token_expiry' => 24, // hours
    'reset_token_expiry' => 1,         // hour
    'meeting_reminder_hours' => 24,    // Send reminder 24h before meeting
    
    // Email Features
    'enable_email_verification' => true,
    'enable_welcome_email' => true,
    'enable_meeting_notifications' => true,
    
    // Debug Mode
    'debug_mode' => true,  // Set to false in production
    'test_email' => '',    // For testing: sends all emails here if set
];