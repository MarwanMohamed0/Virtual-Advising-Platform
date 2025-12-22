-- MashouraX Email System Database Schema
-- Run this SQL to add email functionality to your database

-- Add email-related columns to users table (if not exists)
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS email_verified BOOLEAN DEFAULT FALSE,
ADD COLUMN IF NOT EXISTS verification_token VARCHAR(255) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS verification_token_expires DATETIME DEFAULT NULL,
ADD COLUMN IF NOT EXISTS password_reset_token VARCHAR(255) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS password_reset_expires DATETIME DEFAULT NULL;

-- Create email logs table
CREATE TABLE IF NOT EXISTS email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    status ENUM('sent', 'failed', 'pending') DEFAULT 'pending',
    error_message TEXT DEFAULT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_recipient (recipient),
    INDEX idx_status (status),
    INDEX idx_sent_at (sent_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create email queue table (for async sending)
CREATE TABLE IF NOT EXISTS email_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    template VARCHAR(100) NOT NULL,
    priority TINYINT DEFAULT 5,
    attempts INT DEFAULT 0,
    max_attempts INT DEFAULT 3,
    status ENUM('pending', 'processing', 'sent', 'failed') DEFAULT 'pending',
    error_message TEXT DEFAULT NULL,
    scheduled_at DATETIME DEFAULT NULL,
    sent_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_scheduled (scheduled_at),
    INDEX idx_priority (priority)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create email preferences table
CREATE TABLE IF NOT EXISTS email_preferences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    receive_meeting_notifications BOOLEAN DEFAULT TRUE,
    receive_reminders BOOLEAN DEFAULT TRUE,
    receive_marketing BOOLEAN DEFAULT FALSE,
    receive_newsletters BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;