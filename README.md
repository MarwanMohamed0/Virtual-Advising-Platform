# MashouraX Virtual Advising Platform

A comprehensive virtual advising platform built with PHP and MySQL for educational institutions.

## Features

- **User Authentication**: Secure user registration and login system
- **Role-based Access**: Support for Students, Advisors, and Administrators
- **Session Management**: Secure session handling with database storage
- **Responsive Design**: Modern, mobile-friendly interface
- **Database Integration**: MySQL database with proper schema design

## Setup Instructions

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Installation

1. **Clone or download the project** to your web server directory

2. **Create MySQL Database**:
   ```sql
   CREATE DATABASE mashourax_platform;
   ```

3. **Configure Database Connection**:
   - Open `config/database.php`
   - Update the database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'mashourax_platform');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     ```

4. **Initialize Database**:
   - Visit `http://your-domain/setup.php` in your browser
   - This will create all necessary tables and a default admin user

5. **Default Admin Account**:
   - **Email**: admin@mashourax.com
   - **Password**: admin123
   - **Important**: Change this password after first login!

### File Structure

```
├── config/
│   └── database.php          # Database configuration
├── includes/
│   └── auth.php             # Authentication functions
├── *.php                    # Main application pages
├── *.css                    # Stylesheets
├── database_schema.sql      # Database schema
├── setup.php               # Database setup script
└── logout.php              # Logout functionality
```

### User Roles

- **Student**: Access to personalized academic guidance
- **Advisor**: Guide students to success
- **Admin**: Manage institutional operations

### Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention with prepared statements
- Session management with secure tokens
- CSRF protection ready (can be implemented)
- Input validation and sanitization

### Database Schema

The platform uses the following main tables:
- `users`: User accounts and profiles
- `user_sessions`: Active user sessions
- `password_reset_tokens`: Password reset functionality

### Usage

1. **Registration**: Users can register with their role (Student/Advisor/Admin)
2. **Login**: Secure authentication with role-based redirection
3. **Session Management**: Automatic session handling with 24-hour expiration
4. **Logout**: Secure logout with session cleanup

### Development

To add new features:
1. Update the database schema if needed
2. Add new functions to `includes/auth.php`
3. Update the relevant PHP pages
4. Test thoroughly with different user roles

### Troubleshooting

- **Database Connection Issues**: Check your MySQL credentials in `config/database.php`
- **Session Issues**: Ensure PHP sessions are enabled
- **Permission Issues**: Check file permissions on the web server

### Support

For technical support, contact: support@mashourax.com

---

**Note**: This is a development version. For production use, ensure you:
- Change default passwords
- Enable HTTPS
- Implement additional security measures
- Regular database backups
- Monitor error logs
