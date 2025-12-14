# MashouraX Backend - MVC Architecture

This directory contains the complete MVC (Model-View-Controller) backend implementation for the MashouraX Virtual Advising Platform.

## Directory Structure

```
backend/
├── api/
│   └── index.php          # API router - main entry point
├── controller/             # Controllers (business logic)
│   ├── AdminController.php
│   ├── AdvisorController.php
│   ├── AuthController.php
│   ├── ChatController.php
│   ├── MeetingController.php
│   ├── StudentController.php
│   └── UserController.php
├── core/                  # Core classes and utilities
│   ├── BaseController.php
│   ├── BaseModel.php
│   ├── Helper.php
│   ├── Response.php
│   └── Validator.php
├── model/                 # Models (data layer)
│   ├── AcademicModel.php
│   ├── AdminModel.php
│   ├── AdvisorModel.php
│   ├── ChatModel.php
│   ├── MeetingModel.php
│   ├── SessionModel.php
│   ├── StudentModel.php
│   └── UserModel.php
└── README.md             # This file
```

## Architecture Overview

### Models (Data Layer)
Models handle all database operations and business logic related to data:
- **UserModel**: User registration, authentication, profile management
- **SessionModel**: Session creation, verification, cleanup
- **StudentModel**: Student-specific data and academic progress
- **AdvisorModel**: Advisor statistics and student assignments
- **AdminModel**: System administration and user management
- **ChatModel**: Chat support and messaging
- **MeetingModel**: Appointments and meetings
- **AcademicModel**: Courses, grades, assignments

### Controllers (Business Logic)
Controllers handle HTTP requests and coordinate between models and views:
- **AuthController**: Login, signup, logout, session verification
- **UserController**: User profile management
- **StudentController**: Student dashboard and academic data
- **AdvisorController**: Advisor dashboard and student management
- **AdminController**: System administration
- **ChatController**: Chat messaging
- **MeetingController**: Meeting management

### Core Classes
- **BaseModel**: Common database operations for all models
- **BaseController**: Common controller functionality (auth, validation, responses)
- **Response**: Standardized JSON response formatting
- **Validator**: Input validation utilities
- **Helper**: General utility functions

## API Endpoints

### Authentication
- `POST /backend/api/index.php/auth/login` - User login
- `POST /backend/api/index.php/auth/signup` - User registration
- `POST /backend/api/index.php/auth/logout` - User logout
- `GET /backend/api/index.php/auth/me` - Get current user
- `GET /backend/api/index.php/auth/verify` - Verify session

### User Management
- `GET /backend/api/index.php/user/profile` - Get user profile
- `POST /backend/api/index.php/user/profile/update` - Update profile
- `POST /backend/api/index.php/user/password/change` - Change password
- `GET /backend/api/index.php/users` - Get users list (admin)

### Student
- `GET /backend/api/index.php/student/dashboard` - Get dashboard data
- `GET /backend/api/index.php/student/progress` - Get academic progress
- `GET /backend/api/index.php/student/courses` - Get courses
- `GET /backend/api/index.php/student/grades` - Get grades
- `GET /backend/api/index.php/student/assignments` - Get assignments

### Advisor
- `GET /backend/api/index.php/advisor/dashboard` - Get dashboard data
- `GET /backend/api/index.php/advisor/stats` - Get statistics
- `GET /backend/api/index.php/advisor/students` - Get assigned students
- `POST /backend/api/index.php/advisor/assign` - Assign student
- `GET /backend/api/index.php/advisor/meetings` - Get upcoming meetings

### Admin
- `GET /backend/api/index.php/admin/dashboard` - Get dashboard data
- `GET /backend/api/index.php/admin/stats` - Get system statistics
- `GET /backend/api/index.php/admin/users` - Get all users
- `POST /backend/api/index.php/admin/user/status` - Update user status
- `POST /backend/api/index.php/admin/user/role` - Update user role
- `POST /backend/api/index.php/admin/user/delete` - Delete user
- `GET /backend/api/index.php/admin/sessions` - Get active sessions

### Chat
- `POST /backend/api/index.php/chat/send` - Send message
- `GET /backend/api/index.php/chat/history` - Get chat history
- `POST /backend/api/index.php/chat/clear` - Clear chat history

### Meetings
- `POST /backend/api/index.php/meeting/create` - Create meeting
- `GET /backend/api/index.php/meeting/list` - Get meetings
- `GET /backend/api/index.php/meeting/upcoming` - Get upcoming meetings
- `POST /backend/api/index.php/meeting/status` - Update meeting status
- `POST /backend/api/index.php/meeting/cancel` - Cancel meeting
- `POST /backend/api/index.php/meeting/reschedule` - Reschedule meeting

## Usage Examples

### JavaScript/AJAX Example

```javascript
// Login
fetch('/backend/api/index.php/auth/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        email: 'user@example.com',
        password: 'password123'
    })
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.log('Login successful', data.data);
    } else {
        console.error('Login failed', data.message);
    }
});

// Get student dashboard
fetch('/backend/api/index.php/student/dashboard')
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.log('Dashboard data', data.data);
    }
});

// Send chat message
fetch('/backend/api/index.php/chat/send', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        message: 'Hello, I need help with my courses'
    })
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.log('Bot response', data.data.response);
    }
});
```

### PHP Example

```php
// In your PHP files, you can use the models directly:
require_once 'backend/model/UserModel.php';

$userModel = new UserModel();
$result = $userModel->authenticate('user@example.com', 'password123');

if ($result['success']) {
    $user = $result['user'];
    // Use user data
}
```

## Response Format

All API endpoints return JSON responses in the following format:

### Success Response
```json
{
    "success": true,
    "message": "Operation successful",
    "data": {
        // Response data
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": [
        // Validation errors (if any)
    ]
}
```

## Authentication

Most endpoints require authentication. The system uses session tokens stored in cookies. When a user logs in, a session token is created and stored in the `user_sessions` table and as a cookie.

To access protected endpoints, the session cookie must be present and valid.

## Error Handling

All controllers use the `Response` class for consistent error handling:
- `400` - Bad Request (validation errors, invalid input)
- `401` - Unauthorized (authentication required)
- `403` - Forbidden (insufficient permissions)
- `404` - Not Found (resource doesn't exist)
- `500` - Internal Server Error

## Database Requirements

The backend requires the following database tables (see `database_schema_extended.sql`):
- `users`
- `user_sessions`
- `password_reset_tokens`
- `chat_messages` (optional)
- `meetings` (optional)
- `advisor_student_assignments` (optional)
- `student_enrollments` (optional)
- `student_grades` (optional)
- `student_assignments` (optional)
- `courses` (optional)

## Security Features

1. **Password Hashing**: All passwords are hashed using PHP's `password_hash()` function
2. **SQL Injection Prevention**: All queries use prepared statements
3. **XSS Protection**: Input is sanitized using `htmlspecialchars()`
4. **Session Management**: Secure session tokens with expiration
5. **Role-Based Access Control**: Controllers check user roles before allowing access

## Extending the Backend

### Adding a New Model

1. Create a new file in `backend/model/YourModel.php`
2. Extend `BaseModel`
3. Define your table name and methods

```php
class YourModel extends BaseModel {
    protected $table = 'your_table';
    
    public function yourMethod() {
        // Your logic here
    }
}
```

### Adding a New Controller

1. Create a new file in `backend/controller/YourController.php`
2. Extend `BaseController`
3. Add your methods

```php
class YourController extends BaseController {
    public function yourMethod() {
        $this->requireLogin();
        // Your logic here
        Response::success(['data' => $data], 'Success message');
    }
}
```

4. Add route in `backend/api/index.php`

```php
'your/route' => ['YourController', 'yourMethod'],
```

## Notes

- All timestamps are stored in MySQL datetime format
- Session tokens expire after 24 hours
- The backend is designed to work with the existing frontend PHP files
- Models gracefully handle missing tables (return empty arrays/null)
- Controllers automatically sanitize and validate input

