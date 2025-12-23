<?php
// MashouraX Virtual Advising Platform - signup
require_once 'includes/auth.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = [
        'first_name' => trim($_POST['firstName'] ?? ''),
        'last_name' => trim($_POST['lastName'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'institution' => trim($_POST['institution'] ?? ''),
        'role' => $_POST['role'] ?? 'student',
        'newsletter_subscription' => isset($_POST['newsletter'])
    ];
    
    // Debug information
    $debugInfo = [
        'form_data' => $_POST,
        'processed_data' => $userData,
        'role_selected' => $_POST['role'] ?? 'none',
        'role_validation' => in_array($userData['role'], ['student', 'advisor', 'admin'])
    ];
    
    $result = registerUser($userData);

    if ($result['success']) {
    
        // Optional: verify saved user while debugging
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$userData['email']]);
            $savedUser = $stmt->fetch();
            $debugInfo['saved_user'] = $savedUser;
        } catch (Exception $e) {
            $debugInfo['database_error'] = $e->getMessage();
        }
    
        // Redirect to homepage after successful signup
        header("Location: index.php");
        exit;
    
    } else {
        $errorMessage = $result['message'];
    }
}    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - MashouraX</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1><a href="index.php">MashouraX</a></h1>
            <p>Virtual Advising Platform</p>
        </div>

        <div class="signup-card">
            <div class="signup-header">
                <h2>Create Your Account</h2>
                <p>Join thousands transforming their academic journey</p>
            </div>

            <!-- Role Selection -->
            <div class="role-selection">
                <label class="role-label">I am a:</label>
                <div class="role-options">
                    <label class="role-option">
                        <input type="radio" name="role" value="student" <?php echo (!isset($_POST['role']) || $_POST['role'] === 'student') ? 'checked' : ''; ?>>
                        <div class="role-card">
                            <div class="role-icon">🎓</div>
                            <div class="role-name">Student</div>
                            <div class="role-description">Access personalized academic guidance</div>
                        </div>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="advisor" <?php echo (isset($_POST['role']) && $_POST['role'] === 'advisor') ? 'checked' : ''; ?>>
                        <div class="role-card">
                            <div class="role-icon">👨‍🏫</div>
                            <div class="role-name">Advisor</div>
                            <div class="role-description">Guide students to success</div>
                        </div>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="admin" <?php echo (isset($_POST['role']) && $_POST['role'] === 'admin') ? 'checked' : ''; ?>>
                        <div class="role-card">
                            <div class="role-icon">⚙️</div>
                            <div class="role-name">Admin</div>
                            <div class="role-description">Manage institutional operations</div>
                        </div>
                    </label>
                </div>
            </div>

            <?php if (isset($errorMessage)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($successMessage)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php endif; ?>
            
            

            <form id="signupForm" method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="John" value="<?php echo htmlspecialchars($_POST['firstName'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Doe" value="<?php echo htmlspecialchars($_POST['lastName'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="institution">Institution / Organization</label>
                    <input type="text" id="institution" name="institution" placeholder="Your university or college" value="<?php echo htmlspecialchars($_POST['institution'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a strong password" required>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter your password" required>
                </div>

                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="terms" name="terms" required>
                        <span>I agree to the <a href="#terms">Terms of Service</a> and <a href="#privacy">Privacy Policy</a></span>
                    </label>
                </div>

                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="newsletter" name="newsletter">
                        <span>Send me updates, tips, and special offers</span>
                    </label>
                </div>

                <button type="submit" class="signup-btn" href="index.php">Create Account</button>
            </form>

            <div class="divider">
                <span>Or sign up with</span>
            </div>

            <div class="social-login">
                <button class="social-btn" onclick="socialSignup('google')">Google</button>
                <button class="social-btn" onclick="socialSignup('microsoft')">Microsoft</button>
            </div>

            <div class="login-link">
                Already have an account? <a href="login.php">Sign in</a>
            </div>
        </div>

        <div class="back-home">
            <a href="index.php">← Back to Home</a>
        </div>
    </div>

    <script>
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const email = document.getElementById('email').value;
            const institution = document.getElementById('institution').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const role = document.querySelector('input[name="role"]:checked').value;
            const terms = document.getElementById('terms').checked;

            // Validate passwords match
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return;
            }

            // Validate password strength (at least 8 characters)
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long!');
                return;
            }

            // Validate terms acceptance
            if (!terms) {
                e.preventDefault();
                alert('You must agree to the Terms of Service and Privacy Policy!');
                return;
            }

            // If all validations pass, let the form submit normally
        });

        function socialSignup(provider) {
            const role = document.querySelector('input[name="role"]:checked').value;
            alert(`Signing up with ${provider} as ${role}...`);
            // In a real application, handle OAuth flow
        }
    </script>
</body>
</html>

