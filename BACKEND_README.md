# MashouraX Virtual Advising Platform - Backend Documentation

## Overview

This document describes the backend architecture and structure of the MashouraX Virtual Advising Platform.

## Directory Structure

```
Virtual-Advising-Platform/
├── api/                          # API endpoints
│   ├── students.php             # Student API endpoints
│   ├── advisors.php             # Advisor API endpoints
│   ├── admin.php                # Admin API endpoints
│   ├── meetings.php             # Meeting management API
│   └── notifications.php        # Notification API
├── config/
│   └── database.php             # Database configuration
├── includes/
│   ├── auth.php                 # Authentication functions
│   ├── models/                  # Data models (MVC pattern)
│   │   ├── UserModel.php
│   │   ├── StudentModel.php
│   │   ├── AdvisorModel.php
│   │   ├── MeetingModel.php
│   │   ├── AssignmentModel.php
│   │   ├── CourseModel.php
│   │   └── NotificationModel.php
│   ├── services/                # Business logic layer
│   │   ├── StudentService.php
│   │   ├── AdvisorService.php
│   │   └── AdminService.php
│   └── utils/                   # Utility classes
│       ├── Validator.php        # Input validation
│       ├── Response.php         # API response utilities
│       ├── Logger.php           # Activity logging
│       ├── Helper.php           # General helpers
│       └── Security.php         # Security utilities
└── database_schema_extended.sql # Extended database schema
```

## Architecture

The backend follows a **Model-Service-Controller** pattern:

1. **Models** (`includes/models/`) - Handle all database operations
2. **Services** (`includes/services/`) - Contain business logic
3. **API Endpoints** (`api/`) - Handle HTTP requests and responses
4. **Utilities** (`includes/utils/`) - Reusable helper functions

## Database Schema

### Core Tables

- `users` - User accounts
- `user_sessions` - Active sessions
- `password_reset_tokens` - Password reset functionality

### Extended Tables (from `database_schema_extended.sql`)

- `student_profiles` - Student-specific information
- `advisor_profiles` - Advisor-specific information
- `courses` - Course catalog
- `student_courses` - Student course enrollments
- `assignments` - Student assignments
- `meetings` - Advising meetings/appointments
- `meeting_requests` - Meeting requests
- `notifications` - User notifications
- `activity_logs` - System activity logs
- `ai_conversations` - AI chat conversations
- `system_settings` - System configuration
- `analytics` - Analytics data

## Models

### UserModel
- `getUserById($userId)` - Get user by ID
- `getUserByEmail($email)` - Get user by email
- `getUsers($filters)` - Get users with filters
- `createUser($userData)` - Create new user
- `updateUser($userId, $userData)` - Update user
- `getUserStats()` - Get user statistics

### StudentModel
- `getStudentProfile($userId)` - Get student profile
- `saveStudentProfile($userId, $profileData)` - Save/update profile
- `getStudents($filters)` - Get students with filters
- `getAdvisorStudents($advisorId)` - Get advisor's students
- `getAtRiskStudents($advisorId)` - Get at-risk students
- `assignAdvisor($userId, $advisorId)` - Assign advisor

### MeetingModel
- `getMeetingById($meetingId)` - Get meeting by ID
- `getMeetings($filters)` - Get meetings with filters
- `createMeeting($meetingData)` - Create new meeting
- `updateMeeting($meetingId, $meetingData)` - Update meeting
- `getUpcomingMeetings($userId, $role, $limit)` - Get upcoming meetings
- `getMeetingStats($advisorId)` - Get meeting statistics

### AssignmentModel
- `getAssignmentById($assignmentId)` - Get assignment by ID
- `getAssignments($filters)` - Get assignments with filters
- `createAssignment($assignmentData)` - Create assignment
- `updateAssignment($assignmentId, $assignmentData)` - Update assignment
- `getUpcomingAssignments($studentId, $limit)` - Get upcoming assignments
- `getOverdueAssignments($studentId)` - Get overdue assignments

### CourseModel
- `getCourseById($courseId)` - Get course by ID
- `getCourses($filters)` - Get courses with filters
- `createCourse($courseData)` - Create course
- `getStudentCourses($studentId, $semester, $year)` - Get student courses
- `enrollStudent($studentId, $courseId, $semester, $year)` - Enroll student

### NotificationModel
- `getUserNotifications($userId, $filters)` - Get user notifications
- `createNotification($notificationData)` - Create notification
- `markAsRead($notificationId)` - Mark as read
- `getUnreadCount($userId)` - Get unread count

## Services

### StudentService
- `getDashboardData($userId)` - Get complete dashboard data
- `updateProfile($userId, $profileData)` - Update student profile
- `getAcademicProgress($userId)` - Calculate academic progress

### AdvisorService
- `getDashboardData($advisorId)` - Get advisor dashboard data
- `getStudentDetails($advisorId, $studentId)` - Get student details
- `assignStudent($advisorId, $studentId)` - Assign student to advisor

### AdminService
- `getDashboardData()` - Get admin dashboard data
- `manageUser($userId, $action)` - Activate/deactivate user

## API Endpoints

### Students API (`api/students.php`)

**GET Requests:**
- `?dashboard` - Get student dashboard data
- `?progress` - Get academic progress

**POST Requests:**
- `update_profile` - Update student profile

### Advisors API (`api/advisors.php`)

**GET Requests:**
- `?dashboard` - Get advisor dashboard data
- `?student&id={id}` - Get student details

**POST Requests:**
- `assign_student` - Assign student to advisor

### Admin API (`api/admin.php`)

**GET Requests:**
- `?dashboard` - Get admin dashboard data

**POST Requests:**
- `manage_user` - Activate/deactivate user

### Meetings API (`api/meetings.php`)

**GET Requests:**
- Get all meetings (with optional filters: `status`, `upcoming`)

**POST Requests:**
- Create new meeting

**PUT/PATCH Requests:**
- Update meeting (requires `id` in request body)

**DELETE Requests:**
- Delete meeting (requires `id` in query string)

### Notifications API (`api/notifications.php`)

**GET Requests:**
- Get notifications (with optional filters: `unread_only`, `type`, `limit`)

**POST Requests:**
- `mark_read` - Mark notification as read
- `mark_all_read` - Mark all as read

**DELETE Requests:**
- Delete notification (requires `id` in query string)

## Utilities

### Validator
- `validateEmail($email)` - Validate email format
- `validatePassword($password, $minLength)` - Validate password strength
- `validateRequired($data, $requiredFields)` - Validate required fields
- `sanitizeString($string)` - Sanitize string input
- `validateDate($date, $format)` - Validate date format
- `validateRole($role)` - Validate user role

### Response
- `success($message, $data, $statusCode)` - Send success response
- `error($message, $errors, $statusCode)` - Send error response
- `unauthorized($message)` - Send 401 response
- `forbidden($message)` - Send 403 response
- `notFound($message)` - Send 404 response
- `validationError($errors)` - Send 422 validation error

### Logger
- `log($userId, $action, $entityType, $entityId, $description)` - Log activity
- `getLogs($filters)` - Get activity logs

### Helper
- `formatDate($date, $format)` - Format date
- `formatDateTime($datetime, $format)` - Format datetime
- `timeAgo($datetime)` - Get time ago string
- `redirect($url)` - Redirect to URL
- `isAjax()` - Check if request is AJAX

### Security
- `generateCSRFToken()` - Generate CSRF token
- `verifyCSRFToken($token)` - Verify CSRF token
- `sanitize($data)` - Sanitize input
- `hashPassword($password)` - Hash password
- `verifyPassword($password, $hash)` - Verify password
- `checkRateLimit($key, $maxAttempts, $timeWindow)` - Rate limiting

## Usage Examples

### Using Models

```php
require_once 'includes/models/StudentModel.php';

$studentModel = new StudentModel();
$profile = $studentModel->getStudentProfile($userId);
```

### Using Services

```php
require_once 'includes/services/StudentService.php';

$service = new StudentService();
$dashboardData = $service->getDashboardData($userId);
```

### Making API Calls (JavaScript)

```javascript
// Get student dashboard
fetch('api/students.php?dashboard')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(data.data);
        }
    });

// Create meeting
fetch('api/meetings.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({
        title: 'Academic Planning',
        meeting_date: '2024-12-20 14:00:00',
        advisor_id: 5
    })
})
.then(response => response.json())
.then(data => console.log(data));
```

## Setup Instructions

1. **Run Extended Database Schema:**
   ```sql
   mysql -u root -p mashourax_platform < database_schema_extended.sql
   ```

2. **Configure Database:**
   - Update `config/database.php` with your database credentials

3. **Set Permissions:**
   - Ensure `api/` directory is accessible via web server
   - Set proper file permissions

4. **Test API Endpoints:**
   - Use tools like Postman or curl to test endpoints
   - Ensure authentication is working

## Security Considerations

1. **Authentication:** All API endpoints require authentication via `includes/auth.php`
2. **Input Validation:** Always validate and sanitize user input
3. **SQL Injection:** All queries use prepared statements
4. **XSS Protection:** Output is escaped using `Security::escape()`
5. **CSRF Protection:** Use CSRF tokens for state-changing operations
6. **Rate Limiting:** Implement rate limiting for sensitive endpoints

## Error Handling

All API endpoints use the `Response` utility class for consistent error handling:
- Success responses: `{success: true, message: "...", data: {...}}`
- Error responses: `{success: false, message: "...", errors: [...]}`

## Logging

All important actions are logged using the `Logger` class:
- User actions
- System events
- Errors and exceptions

## Future Enhancements

- [ ] Add pagination to list endpoints
- [ ] Implement caching layer
- [ ] Add API versioning
- [ ] Implement WebSocket for real-time notifications
- [ ] Add comprehensive unit tests
- [ ] Implement API rate limiting middleware
- [ ] Add API documentation (Swagger/OpenAPI)
