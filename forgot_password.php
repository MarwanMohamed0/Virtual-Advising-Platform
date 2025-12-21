<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password - MashouraX</title>

<style>


@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

* {
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

body {
    margin: 0;
    min-height: 100vh;
    background: radial-gradient(circle at top, #1c1c1c, #000);
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
}

.auth-container {
    text-align: center;
}

.logo {
    color: #e0ad2f;
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 5px;
}

.subtitle {
    color: #aaa;
    margin-bottom: 30px;
}

.auth-card {
    background: #151515;
    padding: 30px;
    border-radius: 14px;
    width: 380px;
    box-shadow: 0 0 40px rgba(0,0,0,.7);
}

.auth-card h2 {
    margin-bottom: 10px;
}

.muted {
    color: #888;
    font-size: 14px;
    margin-bottom: 20px;
}

label {
    display: block;
    text-align: left;
    margin-bottom: 6px;
    font-size: 14px;
}

input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: none;
    outline: none;
    margin-bottom: 15px;
    background: #222;
    color: #fff;
}

input::placeholder {
    color: #666;
}

.btn-primary {
    width: 100%;
    background: #e0ad2f;
    color: #000;
    padding: 12px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
}

.btn-primary:hover {
    background: #f0be3c;
}

.back-link {
    display: inline-block;
    margin-top: 15px;
    color: #e0ad2f;
    text-decoration: none;
    font-size: 14px;
}

.back-link:hover {
    text-decoration: underline;
}
</style>

</head>
<body>

<div class="auth-container">
    <h1 class="logo">MashouraX</h1>
    <p class="subtitle">Virtual Advising Platform</p>

    <div class="auth-card">
        <h2>Forgot Password</h2>
        <p class="muted">Enter your email to receive a reset link</p>

        <form action="process_forgot.php" method="POST">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="you@example.com" required>

            <button class="btn-primary">Send Reset Link</button>
        </form>

        <a href="login.php" class="back-link">← Back to Login</a>
    </div>
</div>

</body>
</html>
