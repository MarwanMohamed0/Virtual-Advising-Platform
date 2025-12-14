# Integration Guide

This guide shows how to integrate the MVC backend with your existing frontend PHP files.

## Quick Start

### 1. Update Database Schema

Run the extended database schema to create all necessary tables:

```sql
-- Run database_schema_extended.sql
mysql -u your_username -p your_database < database_schema_extended.sql
```

Or import it through phpMyAdmin.

### 2. Using the API from PHP Files

You can call the API endpoints from your existing PHP files using cURL or file_get_contents:

```php
<?php
// Example: Get student dashboard data via API
function getStudentDashboardAPI() {
    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/backend/api/index.php/student/dashboard';
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Use it
$dashboard = getStudentDashboardAPI();
if ($dashboard['success']) {
    $data = $dashboard['data'];
    // Use $data in your view
}
?>
```

### 3. Using Models Directly in PHP Files

You can also use the models directly in your PHP files:

```php
<?php
// In student-dashboard.php
require_once 'backend/model/StudentModel.php';
require_once 'backend/model/AcademicModel.php';

$studentModel = new StudentModel();
$academicProgress = $studentModel->getAcademicProgress($user['id']);

$academicModel = new AcademicModel();
$courses = $academicModel->getStudentCourses($user['id']);
?>
```

### 4. Using JavaScript/AJAX

Include the API helper functions and use them in your JavaScript:

```html
<script src="backend/api-example.js"></script>
<script>
// Login example
async function handleLogin() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    const result = await login(email, password);
    
    if (result.success) {
        // Redirect or update UI
        window.location.href = 'student-dashboard.php';
    } else {
        alert(result.message);
    }
}

// Get dashboard data
async function loadDashboard() {
    const result = await getStudentDashboard();
    if (result.success) {
        const data = result.data;
        // Update UI with data
        document.getElementById('gpa').textContent = data.academic_progress.gpa;
    }
}
</script>
```

## Migration Examples

### Example 1: Update login.php

Instead of calling `authenticateUser()` directly, you can use the API:

```php
<?php
// OLD WAY (still works)
require_once 'includes/auth.php';
$result = authenticateUser($email, $password);

// NEW WAY (using API)
$url = 'http://' . $_SERVER['HTTP_HOST'] . '/backend/api/index.php/auth/login';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['email' => $email, 'password' => $password]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = json_decode(curl_exec($ch), true);
curl_close($ch);

// OR use model directly
require_once 'backend/model/UserModel.php';
require_once 'backend/model/SessionModel.php';

$userModel = new UserModel();
$result = $userModel->authenticate($email, $password);
if ($result['success']) {
    $sessionModel = new SessionModel();
    $sessionModel->createSession($result['user']['id']);
}
?>
```

### Example 2: Update student-dashboard.php

```php
<?php
require_once 'includes/auth.php';
requireLogin();
$user = getCurrentUser();

// Use StudentModel directly
require_once 'backend/model/StudentModel.php';
require_once 'backend/model/AcademicModel.php';
require_once 'backend/model/MeetingModel.php';

$studentModel = new StudentModel();
$academicProgress = $studentModel->getAcademicProgress($user['id']);

$academicModel = new AcademicModel();
$upcomingAssignments = $academicModel->getStudentAssignments($user['id'], 'pending');

$meetingModel = new MeetingModel();
$upcomingMeetings = $meetingModel->getUpcomingMeetings($user['id'], 'student', 5);
?>
```

### Example 3: Update chat-support.php

```php
<?php
// Instead of using session-based chat, use ChatModel
require_once 'includes/auth.php';
requireLogin();
require_once 'backend/model/ChatModel.php';

$chatModel = new ChatModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'send_message') {
        $message = trim($_POST['message'] ?? '');
        
        if (!empty($message)) {
            // Save user message
            $chatModel->saveMessage($user['id'], $message, 'user');
            
            // Get bot response
            $botResponse = $chatModel->getBotResponse($message);
            
            // Save bot response
            $chatModel->saveMessage($user['id'], $botResponse, 'bot');
            
            echo json_encode([
                'success' => true,
                'response' => $botResponse,
                'time' => date('H:i')
            ]);
        }
        exit;
    }
    
    if ($_POST['action'] === 'get_history') {
        $history = $chatModel->getChatHistory($user['id'], 50);
        echo json_encode(['success' => true, 'history' => $history]);
        exit;
    }
    
    if ($_POST['action'] === 'clear_history') {
        $chatModel->clearHistory($user['id']);
        echo json_encode(['success' => true]);
        exit;
    }
}
?>
```

## API Endpoint URLs

All API endpoints are accessible at:
```
http://your-domain/backend/api/index.php/{endpoint}
```

For example:
- Login: `POST /backend/api/index.php/auth/login`
- Student Dashboard: `GET /backend/api/index.php/student/dashboard`
- Send Chat: `POST /backend/api/index.php/chat/send`

## Testing the API

You can test the API using:

1. **Browser Console** (for GET requests):
```javascript
fetch('/backend/api/index.php/auth/verify')
    .then(r => r.json())
    .then(console.log);
```

2. **Postman/Insomnia**: Import the endpoints and test with proper authentication

3. **cURL**:
```bash
# Login
curl -X POST http://localhost/backend/api/index.php/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123"}'

# Get dashboard (with session cookie)
curl -X GET http://localhost/backend/api/index.php/student/dashboard \
  -H "Cookie: session_token=your_token_here"
```

## Best Practices

1. **Use Models Directly**: For server-side PHP code, use models directly instead of making HTTP requests to your own API
2. **Use API for AJAX**: For JavaScript/frontend AJAX calls, use the API endpoints
3. **Error Handling**: Always check `success` field in API responses
4. **Authentication**: Session cookies are automatically handled, but ensure users are logged in before making API calls
5. **Validation**: The backend validates all input, but you should also validate on the frontend for better UX

## Troubleshooting

### API returns 404
- Check that `.htaccess` is working (mod_rewrite enabled)
- Verify the route exists in `backend/api/index.php`
- Check file permissions

### Authentication fails
- Ensure session cookies are being sent
- Check that `user_sessions` table exists
- Verify session token format

### Database errors
- Run the extended schema SQL file
- Check database connection in `config/database.php`
- Verify table names match model expectations

### CORS issues
- CORS headers are set in `backend/api/index.php`
- For production, restrict `Access-Control-Allow-Origin` to your domain

