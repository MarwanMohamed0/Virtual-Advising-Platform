<?php
/**
 * Database Setup Script for MashouraX Virtual Advising Platform
 * 
 * This script helps initialize the database and create the necessary tables.
 * Run this script once after setting up your MySQL database.
 */

require_once 'config/database.php';

// Check if database connection works
if (!testDBConnection()) {
    die("
    <h2>Database Setup Failed</h2>
    <p>Could not connect to the database. Please check your configuration in <code>config/database.php</code></p>
    <p>Make sure:</p>
    <ul>
        <li>MySQL server is running</li>
        <li>Database credentials are correct</li>
        <li>Database 'mashourax_platform' exists</li>
    </ul>
    ");
}

// Initialize database tables
if (initializeDatabase()) {
    echo "
    <h2>Database Setup Successful!</h2>
    <p>✅ Database tables have been created successfully.</p>
    <p>✅ Default admin user has been created:</p>
    <ul>
        <li><strong>Email:</strong> admin@mashourax.com</li>
        <li><strong>Password:</strong> admin123</li>
        <li><strong>Role:</strong> Admin</li>
    </ul>
    <p><strong>Important:</strong> Please change the admin password after first login!</p>
    <p><a href='index.php'>Go to Homepage</a> | <a href='login.php'>Go to Login</a></p>
    ";
} else {
    echo "
    <h2>Database Setup Failed</h2>
    <p>❌ Failed to create database tables. Please check the error logs.</p>
    ";
}
?>
