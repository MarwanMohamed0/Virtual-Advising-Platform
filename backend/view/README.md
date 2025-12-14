# View Layer Documentation

The view layer in the MVC architecture handles the presentation of data to users.

## Structure

```
backend/view/
├── BaseView.php          # Base view class with rendering methods
├── ViewHelper.php        # Helper functions for views
├── partials/             # Reusable partial views
│   ├── header.php
│   └── footer.php
├── student/              # Student-specific views
│   └── dashboard.php
├── advisor/              # Advisor-specific views
│   └── dashboard.php
└── admin/               # Admin-specific views
    └── dashboard.php
```

## Usage

### Using BaseView

```php
<?php
require_once 'backend/view/BaseView.php';

$view = new BaseView();
$view->set('user', $user);
$view->set('data', $someData);

// Render a view
echo $view->render('student/dashboard', ['additional' => 'data']);

// Or display directly
$view->display('student/dashboard');
?>
```

### Using ViewHelper

```php
<?php
require_once 'backend/view/ViewHelper.php';

$helper = new ViewHelper();

// Format dates
echo $helper->date('2024-12-15'); // Dec 15, 2024
echo $helper->datetime('2024-12-15 14:30:00'); // Dec 15, 2024 02:30 PM

// Format user names
echo $helper->userName($user); // John Doe
echo $helper->userInitials($user); // JD

// Format numbers
echo $helper->gpa(3.75); // 3.75
echo $helper->percentage(45, 120); // 37.5

// Get badge classes
echo $helper->statusBadge('active'); // badge-success
echo $helper->priorityBadge('high'); // badge-danger
?>
```

### Using Partials

```php
<?php
$view = new BaseView();
$view->set('pageTitle', 'Student Dashboard');
$view->set('showNavigation', true);
$view->set('showFooter', true);

// Include header
$view->partial('header');

// Your content here
?>

<div>Your content</div>

<?php
// Include footer
$view->partial('footer');
?>
```

## Creating New Views

1. Create a new view file in the appropriate directory:
   - `backend/view/student/` for student views
   - `backend/view/advisor/` for advisor views
   - `backend/view/admin/` for admin views

2. Use the BaseView and ViewHelper classes:

```php
<?php
$view = new BaseView();
$helper = new ViewHelper();
?>

<div class="my-view">
    <h1><?php echo $view->escape($title); ?></h1>
    <p>Created: <?php echo $helper->date($createdAt); ?></p>
</div>
```

## Integration with Controllers

Views can be used in controllers or directly in PHP files:

```php
<?php
// In a controller or PHP file
require_once 'backend/view/BaseView.php';
require_once 'backend/model/StudentModel.php';

$studentModel = new StudentModel();
$progress = $studentModel->getAcademicProgress($userId);

$view = new BaseView();
$view->set('user', $user);
$view->set('academicProgress', $progress);

// Render the view
$view->display('student/dashboard');
?>
```

## Helper Functions Available

- `date($date, $format)` - Format date
- `datetime($datetime, $format)` - Format datetime
- `timeAgo($datetime)` - Get time ago string
- `userName($user)` - Get user full name
- `userInitials($user)` - Get user initials
- `gpa($gpa)` - Format GPA
- `percentage($part, $total)` - Calculate percentage
- `statusBadge($status)` - Get status badge class
- `priorityBadge($priority)` - Get priority badge class
- `truncate($text, $length)` - Truncate text
- `avatar($user, $size)` - Generate avatar HTML

## Security

Always use `$view->escape()` to escape output:

```php
<!-- Good -->
<?php echo $view->escape($userInput); ?>

<!-- Bad -->
<?php echo $userInput; ?>
```

## Best Practices

1. **Separate Logic from Presentation**: Keep business logic in controllers/models, not in views
2. **Use Partials**: Reuse common elements like headers and footers
3. **Escape Output**: Always escape user-generated content
4. **Use Helpers**: Use ViewHelper for common formatting tasks
5. **Keep Views Simple**: Views should primarily display data, not process it

