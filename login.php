<?php
// MashouraX Virtual Advising Platform - login
require_once 'includes/auth.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $result = authenticateUser($email, $password);
    
    if ($result['success']) {
        // Start user session
        startUserSession($result['user']);
        
        // Redirect to homepage after login
        header('Location: index.php');
        exit();
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
    <title>Login - MashouraX</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1><a href="index.php">MashouraX</a></h1>
            <p>Virtual Advising Platform</p>
        </div>

        <div class="login-card">
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Sign in to continue your academic journey</p>
            </div>

            <?php if (isset($errorMessage)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" method="POST" action="">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="forgot-password">
                    <a href="#forgot">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn">Sign In</button>
            </form>

            <div class="divider">
                <span>Or continue with</span>
            </div>

            <div class="social-login">
                <button class="social-btn" onclick="socialLogin('google')">Google</button>
                <button class="social-btn" onclick="socialLogin('microsoft')">Microsoft</button>
            </div>

            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign up</a>
            </div>
        </div>

        <div class="back-home">
            <a href="index.php">← Back to Home</a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Basic validation
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in all fields.');
                return;
            }

            // If validation passes, let the form submit normally
        });

        function socialLogin(provider) {
            alert(`Logging in with ${provider}...`);
            // In a real application, handle OAuth flow
        }
    </script>
</body>
</html>
