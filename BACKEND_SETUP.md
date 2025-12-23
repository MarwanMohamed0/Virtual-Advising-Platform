# Backend Setup Guide - MashouraX Virtual Advising Platform

## Quick Start

### 1. Database Setup

First, run the extended database schema to create all necessary tables:

```bash
mysql -u root -p mashourax_platform < database_schema_extended.sql
```

Or via phpMyAdmin:
1. Select the `mashourax_platform` database
2. Go to SQL tab
3. Copy and paste the contents of `database_schema_extended.sql`
4. Execute

### 2. Verify Database Configuration

Check `config/database.php` and ensure your database credentials are correct:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mashourax_platform');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 3. Test API Endpoints

You can test the API endpoints using curl or Postman:

```bash
# Test student dashboard (requires authentication)
curl -X GET "http://localhost/Virtual-Advising-Platform/api/students.php?dashboard" \
  -H "Cookie: session_token=YOUR_SESSION_TOKEN"
```

## Backend Structure

### Models (`includes/models/`)
- **UserModel.php** - User management
- **StudentModel.php** - Student profiles and data
- **MeetingModel.php** - Meeting/appointment management
- **AssignmentModel.php** - Assignment tracking
- **CourseModel.php** - Course catalog and enrollment
- **NotificationModel.php** - Notification system

### Services (`includes/services/`)
- **StudentService.php** - Student business logic
- **AdvisorService.php** - Advisor business logic
- **AdminService.php** - Admin business logic

### API Endpoints (`api/`)
- **students.php** - Student API
- **advisors.php** - Advisor API
- **admin.php** - Admin API
- **meetings.php** - Meeting management API
- **notifications.php** - Notification API

### Utilities (`includes/utils/`)
- **Validator.php** - Input validation
- **Response.php** - Standardized API responses
- **Logger.php** - Activity logging
- **Helper.php** - General utilities
- **Security.php** - Security functions

## Integration with Frontend

### Example: Fetching Student Dashboard Data

```javascript
// In your student-dashboard.php or JavaScript file
fetch('api/students.php?dashboard')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Use data.data to populate dashboard
            console.log('Academic Progress:', data.data.academic_progress);
            console.log('Upcoming Assignments:', data.data.upcoming_assignments);
            console.log('Upcoming Meetings:', data.data.upcoming_meetings);
        } else {
            console.error('Error:', data.message);
        }
    })
    .catch(error => console.error('Network error:', error));
```

### Example: Creating a Meeting

```javascript
const formData = new FormData();
formData.append('title', 'Academic Planning Session');
formData.append('meeting_date', '2024-12-20 14:00:00');
formData.append('advisor_id', '5');
formData.append('duration', '30');
formData.append('type', 'academic_planning');

fetch('api/meetings.php', {
    method: 'POST',
    body: formData
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        alert('Meeting scheduled successfully!');
        // Refresh meetings list
    } else {
        alert('Error: ' + data.message);
    }
});
```

### Example: Getting Notifications

```javascript
fetch('api/notifications.php?unread_only=1&limit=10')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notifications = data.data.notifications;
            const unreadCount = data.data.unread_count;
            
            // Update notification badge
            document.getElementById('notification-badge').textContent = unreadCount;
            
            // Display notifications
            notifications.forEach(notification => {
                // Render notification
            });
        }
    });
```

## Updating Existing Dashboards

### Student Dashboard

Replace mock data in `student-dashboard.php`:

```php
// OLD (mock data):
$academicProgress = [
    'gpa' => 3.7,
    'credits_completed' => 45,
    // ...
];

// NEW (real data):
require_once 'includes/services/StudentService.php';
$studentService = new StudentService();
$dashboardData = $studentService->getDashboardData($user['id']);
$academicProgress = $dashboardData['academic_progress'];
$upcomingAssignments = $dashboardData['upcoming_assignments'];
$upcomingMeetings = $dashboardData['upcoming_meetings'];
```

### Advisor Dashboard

Replace mock data in `advisor-dashboard.php`:

```php
// OLD (mock data):
$advisorStats = [
    'total_students' => 25,
    // ...
];

// NEW (real data):
require_once 'includes/services/AdvisorService.php';
$advisorService = new AdvisorService();
$dashboardData = $advisorService->getDashboardData($user['id']);
$advisorStats = $dashboardData['stats'];
$assignedStudents = $dashboardData['assigned_students'];
```

### Admin Dashboard

The admin dashboard already uses real data, but you can enhance it:

```php
require_once 'includes/services/AdminService.php';
$adminService = new AdminService();
$dashboardData = $adminService->getDashboardData();
$userStats = $dashboardData['user_stats'];
$systemStats = $dashboardData['system_stats'];
```

## Common Tasks

### Adding a New Model

1. Create file in `includes/models/YourModel.php`
2. Extend base functionality as needed
3. Use prepared statements for all queries
4. Return data in consistent format

### Adding a New API Endpoint

1. Create file in `api/your-endpoint.php`
2. Include authentication check
3. Use Response class for output
4. Handle different HTTP methods (GET, POST, PUT, DELETE)

### Adding Validation

Use the Validator class:

```php
require_once 'includes/utils/Validator.php';

$validation = Validator::validateRequired($_POST, ['field1', 'field2']);
if (!$validation['valid']) {
    Response::validationError($validation['errors']);
}
```

## Security Best Practices

1. **Always validate input** - Use Validator class
2. **Use prepared statements** - All models use PDO prepared statements
3. **Check authentication** - All API endpoints require authentication
4. **Sanitize output** - Use Security::escape() for display
5. **Log important actions** - Use Logger class

## Troubleshooting

### API Returns 401 Unauthorized
- Check if user is logged in
- Verify session token is being sent
- Check `includes/auth.php` authentication logic

### Database Connection Errors
- Verify database credentials in `config/database.php`
- Ensure database exists
- Check MySQL service is running

### Model Methods Not Working
- Verify database tables exist (run `database_schema_extended.sql`)
- Check table names match exactly
- Verify foreign key relationships

## Next Steps

1. **Run the extended schema** - Create all database tables
2. **Test API endpoints** - Verify they work correctly
3. **Update dashboards** - Replace mock data with real API calls
4. **Add error handling** - Implement proper error messages
5. **Add logging** - Track important user actions

## Support

For issues or questions:
- Check `BACKEND_README.md` for detailed documentation
- Review model and service class comments
- Check error logs in your web server
