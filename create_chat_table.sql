-- Create chat_messages table for MashouraX Virtual Advising Platform
-- Run this SQL script in your MySQL database

USE mashourax_platform;

-- Chat messages table
CREATE TABLE IF NOT EXISTS chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    type ENUM('user', 'bot') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
);

-- Verify table was created
SELECT 'chat_messages table created successfully!' AS status;

