# View Files Summary

All view files are located in the `backend/view/` directory. Here's what was created:

## View Files Structure

```
backend/view/
├── BaseView.php              # Base view class for rendering
├── ViewHelper.php            # Helper functions for views
├── README.md                 # View documentation
├── example-usage.php         # Example of how to use views
│
├── partials/                 # Reusable partial views
│   ├── header.php           # Header template
│   └── footer.php           # Footer template
│
├── student/                 # Student-specific views
│   └── dashboard.php        # Student dashboard template
│
├── advisor/                 # Advisor-specific views
│   └── dashboard.php        # Advisor dashboard template
│
└── admin/                   # Admin-specific views
    └── dashboard.php        # Admin dashboard template
```

## Quick Start

### 1. Basic Usage

```php
<?php
require_once 'backend/view/BaseView.php';
require_once 'backend/view/ViewHelper.php';

$view = new BaseView();
$helper = new ViewHelper();

// Set data
$view->set('user', $user);
$view->set('title', 'My Page');

// Render view
$view->display('student/dashboard');
?>
```

### 2. Using with Models

```php
<?php
require_once 'backend/view/BaseView.php';
require_once 'backend/model/StudentModel.php';

$studentModel = new StudentModel();
$progress = $studentModel->getAcademicProgress($userId);

$view = new BaseView();
$view->set('academicProgress', $progress);
$view->display('student/dashboard');
?>
```

### 3. Using Partials (Header/Footer)

```php
<?php
$view = new BaseView();
$view->set('pageTitle', 'Student Dashboard');
$view->set('showNavigation', true);
$view->set('showFooter', true);

// Include header
$view->partial('header');

// Your content
echo $view->render('student/dashboard');

// Include footer
$view->partial('footer');
?>
```

## Available Views

### Student Views
- **`student/dashboard.php`** - Student dashboard with academic progress, assignments, and meetings

### Advisor Views
- **`advisor/dashboard.php`** - Advisor dashboard with statistics, assigned students, and meetings

### Admin Views
- **`admin/dashboard.php`** - Admin dashboard with system statistics, users, and sessions

### Partials
- **`partials/header.php`** - Reusable header with navigation
- **`partials/footer.php`** - Reusable footer

## View Helper Functions

The `ViewHelper` class provides these functions:

- `date($date, $format)` - Format date
- `datetime($datetime, $format)` - Format datetime
- `timeAgo($datetime)` - Get "time ago" string
- `userName($user)` - Get user full name
- `userInitials($user)` - Get user initials
- `gpa($gpa)` - Format GPA
- `percentage($part, $total)` - Calculate percentage
- `statusBadge($status)` - Get CSS class for status badge
- `priorityBadge($priority)` - Get CSS class for priority badge
- `truncate($text, $length)` - Truncate text
- `avatar($user, $size)` - Generate avatar HTML

## Integration with Existing Files

You can integrate these views into your existing PHP files:

### Example: Update student-dashboard.php

```php
<?php
// At the top of student-dashboard.php
require_once 'includes/auth.php';
require_once 'backend/view/BaseView.php';
require_once 'backend/view/ViewHelper.php';
require_once 'backend/model/StudentModel.php';

requireLogin();
$user = getCurrentUser();

// Get data using models
$studentModel = new StudentModel();
$academicProgress = $studentModel->getAcademicProgress($user['id']);

// Use view
$view = new BaseView();
$view->set('user', $user);
$view->set('academicProgress', $academicProgress);
$view->set('pageTitle', 'Student Dashboard');

$view->partial('header');
$view->display('student/dashboard');
$view->partial('footer');
?>
```

## Creating New Views

1. Create a new file in the appropriate directory:
   - `backend/view/student/` for student views
   - `backend/view/advisor/` for advisor views
   - `backend/view/admin/` for admin views

2. Use BaseView and ViewHelper:

```php
<?php
require_once __DIR__ . '/../BaseView.php';
require_once __DIR__ . '/../ViewHelper.php';

$view = new BaseView();
$helper = new ViewHelper();
?>

<div class="my-view">
    <h1><?php echo $view->escape($title); ?></h1>
    <p><?php echo $helper->date($createdAt); ?></p>
</div>
```

## Security

Always escape output using `$view->escape()`:

```php
<!-- Safe -->
<?php echo $view->escape($userInput); ?>

<!-- Unsafe - DON'T DO THIS -->
<?php echo $userInput; ?>
```

## See Also

- `backend/view/README.md` - Detailed view documentation
- `backend/view/example-usage.php` - Complete usage example
- `backend/README.md` - General backend documentation

