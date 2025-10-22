<?php
// MashouraX Virtual Advising Platform - mobile
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MashouraX - Mobile App</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #000;
            color: #fff;
            overflow-x: hidden;
        }

        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: linear-gradient(135deg, #000 0%, #0a0a0a 50%, #000 100%);
        }

        .bg-animation::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(218, 165, 32, 0.08) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: moveGrid 25s linear infinite;
        }

        @keyframes moveGrid {
            0% { transform: translate(0, 0); }
            100% { transform: translate(40px, 40px); }
        }

   .top-bar {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1001;
    padding: 0.8rem 5%;
    background: rgba(0, 0, 0, 0.95);
    border-bottom: 1px solid rgba(218, 165, 32, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
}

.top-bar-left {
    display: flex;
    gap: 2rem;
    align-items: center;
}

.top-bar-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #999;
}

.top-bar-item span {
    color: #DAA520;
}

.top-bar-right {
    display: flex;
    gap: 1.5rem;
}

.top-bar-link {
    color: #999;
    text-decoration: none;
    transition: color 0.3s ease;
}

.top-bar-link:hover {
    color: #DAA520;
}

/* Navigation */
nav {
    position: fixed;
    top: 45px;
    width: 100%;
    z-index: 1000;
    padding: 1.2rem 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(218, 165, 32, 0.2);
}

.logo {
    font-size: 2rem;
    font-weight: 900;
    background: linear-gradient(135deg, #DAA520, #FFD700);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -1px;
}

.nav-center {
    display: flex;
    gap: 3rem;
    list-style: none;
    align-items: center;
}

.nav-item {
    position: relative;
}

.nav-item > a {
    color: #fff;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.nav-item > a:hover {
    color: #DAA520;
}

.dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(218, 165, 32, 0.2);
    border-radius: 10px;
    padding: 1rem 0;
    min-width: 220px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.nav-item:hover .dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown a {
    display: block;
    padding: 0.8rem 1.5rem;
    color: #ccc;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.dropdown a:hover {
    background: rgba(218, 165, 32, 0.1);
    color: #DAA520;
    padding-left: 2rem;
}

.nav-right {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.search-btn, .login-btn {
    padding: 0.6rem 1.2rem;
    background: transparent;
    color: #fff;
    border: 1px solid rgba(218, 165, 32, 0.3);
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover, .login-btn:hover {
    background: rgba(218, 165, 32, 0.1);
    border-color: #DAA520;
}

.demo-btn {
    padding: 0.7rem 1.8rem;
    background: linear-gradient(135deg, #DAA520, #FFD700);
    color: #000;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.demo-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(218, 165, 32, 0.4);
}
        .hero {
            position: relative;
            padding: 180px 5% 100px;
            z-index: 1;
        }

        .hero-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .hero-left {
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.5rem;
            background: rgba(218, 165, 32, 0.1);
            border: 1px solid rgba(218, 165, 32, 0.3);
            border-radius: 50px;
            color: #DAA520;
            font-size: 0.85rem;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        h1 {
            font-size: 4.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            color: #fff;
        }

        .hero-left p {
            font-size: 1.25rem;
            color: #aaa;
            margin-bottom: 2.5rem;
            line-height: 1.8;
        }

        .download-buttons {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .download-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(218, 165, 32, 0.3);
            border-radius: 15px;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            background: rgba(218, 165, 32, 0.1);
            border-color: #DAA520;
            transform: translateY(-3px);
        }

        .download-icon {
            font-size: 2.5rem;
        }

        .download-text {
            text-align: left;
        }

        .download-text small {
            display: block;
            color: #999;
            font-size: 0.8rem;
        }

        .download-text span {
            display: block;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .qr-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 15px;
        }

        .qr-code {
            width: 120px;
            height: 120px;
            background: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .qr-text {
            flex: 1;
        }

        .qr-text h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #DAA520;
        }

        .qr-text p {
            color: #999;
            font-size: 0.95rem;
        }

        .phone-mockup {
            position: relative;
            text-align: center;
        }

        .phone-frame {
            width: 350px;
            height: 700px;
            background: rgba(255, 255, 255, 0.05);
            border: 8px solid rgba(218, 165, 32, 0.3);
            border-radius: 40px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            position: relative;
            box-shadow: 0 30px 80px rgba(218, 165, 32, 0.2);
        }

        .phone-notch {
            width: 150px;
            height: 25px;
            background: #000;
            border-radius: 0 0 20px 20px;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .phone-screen {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(218, 165, 32, 0.1), rgba(0, 0, 0, 0.5));
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2rem;
        }

        .app-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .features-section {
            position: relative;
            padding: 8rem 5%;
            z-index: 1;
            background: rgba(218, 165, 32, 0.02);
        }

        .section-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 5rem;
        }

        .section-label {
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .section-title {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
            line-height: 1.2;
        }

        .section-description {
            color: #999;
            font-size: 1.15rem;
            line-height: 1.8;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            text-align: center;
            transition: all 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: #DAA520;
            box-shadow: 0 20px 60px rgba(218, 165, 32, 0.15);
        }

        .feature-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .feature-card p {
            color: #aaa;
            line-height: 1.7;
        }

        .stats-section {
            position: relative;
            padding: 6rem 5%;
            z-index: 1;
            background: linear-gradient(135deg, rgba(218, 165, 32, 0.05), rgba(0, 0, 0, 0.3));
            border-top: 1px solid rgba(218, 165, 32, 0.2);
            border-bottom: 1px solid rgba(218, 165, 32, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            max-width: 1400px;
            margin: 0 auto;
            text-align: center;
        }

        .stat-item h2 {
            font-size: 4rem;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.8rem;
            font-weight: 900;
        }

        .stat-item p {
            color: #aaa;
            font-size: 1.1rem;
        }

        .cta-section {
            position: relative;
            padding: 8rem 5%;
            text-align: center;
            z-index: 1;
        }

        .cta-section h2 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: #fff;
            line-height: 1.2;
        }

        .cta-section p {
            font-size: 1.3rem;
            color: #aaa;
            margin-bottom: 3rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.8;
        }

        footer {
            position: relative;
            padding: 4rem 5% 2rem;
            border-top: 1px solid rgba(218, 165, 32, 0.2);
            z-index: 1;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand h3 {
            font-size: 1.8rem;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .footer-brand p {
            color: #666;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .footer-col h4 {
            color: #fff;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.95rem;
        }

        .footer-links a:hover {
            color: #DAA520;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(218, 165, 32, 0.1);
            color: #666;
            font-size: 0.9rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: rgba(218, 165, 32, 0.1);
            border-color: #DAA520;
            color: #DAA520;
        }

        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 3.5rem;
            }

            .section-title {
                font-size: 2.5rem;
            }

            .nav-center {
                display: none;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .phone-frame {
                width: 280px;
                height: 560px;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-left">
            <div class="top-bar-item">
                <span>📧</span> support@mashourax.com
            </div>
            <div class="top-bar-item">
                <span>📞</span> +20 (012) 707 23373
            </div>
        </div>
        <div class="top-bar-right">
            <a href="about.php" class="top-bar-link">About</a>
            <a href="#" class="top-bar-link">Blog</a>
            <a href="#" class="top-bar-link">Careers</a>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav>
        <div class="logo">MashouraX</div>
        <ul class="nav-center">
            <li class="nav-item">
                <a href="#solutions">Solutions ▾</a>
                <div class="dropdown">
                    <a href="solutions-virtual-advising.php">Virtual Advising</a>
                    <a href="solutions-student-success.php">Student Success</a>
                    <a href="solutions-academic-planning.php">Academic Planning</a>
                    <a href="solutions-career-services.php">Career Services</a>
                </div>
            </li>
           
            <li class="nav-item">
                <a href="#features">Features ▾</a>
                <div class="dropdown">
                    <a href="ai-features.php">AI-Powered Support</a>
                    <a href="analytics-dashboard.php">Analytics Dashboard</a>
                    <a href="#">24/7 Chat Support</a>
                    <a href="mobile.php">Mobile App</a>
                </div>
           
            </li> 
            <li class="nav-item">
                <a href="#resources">Resources ▾</a>
                <div class="dropdown">
                    <a href="case-studies.php">Case Studies</a>
                    <a href="documentation.php">Documentation</a>
                    <a href="webinars.php">Webinars</a>
                    <a href="help-center.php">Help Center</a>
                </div>
            </li>
            
           
            <li class="nav-item">
                <a href="#pricing">Pricing</a>
            </li>
            <li class="nav-item">
                <a href="#security">Security</a>
            </li>
        </ul>
        <div class="nav-right">
            <button class="search-btn">🔍 Search</button>
            <button class="login-btn" onclick="window.location.href='login.php'">Login</button>
            <button class="demo-btn" onclick="window.location.href='demo.php'">Request Demo</button>
        </div>
    </nav>


    <section class="hero">
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-badge">
                    <span>📱</span> Mobile App
                </div>
                <h1>Advising On The Go</h1>
                <p>Access your academic advisor anytime, anywhere. Get instant answers, track your progress, and stay on top of your academic journey with the MashouraX mobile app.</p>
                
                <div class="download-buttons">
                    <a href="#" class="download-btn">
                        <div class="download-icon"></div>
                        <div class="download-text">
                            <small>Download on the</small>
                            <span>App Store</span>
                        </div>
                    </a>
                    <a href="#" class="download-btn">
                        <div class="download-icon">📱</div>
                        <div class="download-text">
                            <small>Get it on</small>
                            <span>Google Play</span>
                        </div>
                    </a>
                </div>

                <div class="qr-section">
                    <div class="qr-code">📲</div>
                    <div class="qr-text">
                        <h3>Scan to Download</h3>
                        <p>Use your phone's camera to scan and download the app instantly</p>
                    </div>
                </div>
            </div>

            <div class="phone-mockup">
                <div class="phone-frame">
                    <div class="phone-notch"></div>
                    <div class="phone-screen">
                        <div class="app-icon">M</div>
                        <h3 style="color: #DAA520; font-size: 1.5rem;">MashouraX</h3>
                        <p style="color: #999; font-size: 0.9rem;">Your Virtual Advisor</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <h2>4.8★</h2>
                <p>App Store Rating</p>
            </div>
            <div class="stat-item">
                <h2>50K+</h2>
                <p>Downloads</p>
            </div>
            <div class="stat-item">
                <h2>98%</h2>
                <p>User Satisfaction</p>
            </div>
            <div class="stat-item">
                <h2>24/7</h2>
                <p>Access Anywhere</p>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="section-header">
            <div class="section-label">App Features</div>
            <h2 class="section-title">Everything You Need in Your Pocket</h2>
            <p class="section-description">Powerful features designed for students on the move</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>Instant Chat</h3>
                <p>Get immediate answers to your questions with our AI-powered chatbot, available 24/7.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Progress Tracking</h3>
                <p>Monitor your academic progress, view your GPA, and track degree completion in real-time.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Smart Scheduling</h3>
                <p>Book appointments with advisors, view your schedule, and receive timely reminders.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Course Planning</h3>
                <p>Get personalized course recommendations and plan your academic path semester by semester.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔔</div>
                <h3>Push Notifications</h3>
                <p>Stay informed with important deadlines, registration dates, and personalized alerts.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Offline Mode</h3>
                <p>Access your academic information and saved content even without an internet connection.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>Secure & Private</h3>
                <p>Your data is protected with bank-level encryption and biometric authentication.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌙</div>
                <h3>Dark Mode</h3>
                <p>Easy on the eyes with our beautiful dark mode interface for late-night study sessions.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌍</div>
                <h3>Multi-Language</h3>
                <p>Access the app in your preferred language with full multilingual support.</p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2>Download MashouraX Today</h2>
        <p>Join thousands of students who are taking control of their academic journey with our mobile app.</p>
        <div class="download-buttons" style="justify-content: center;">
            <a href="#" class="download-btn">
                <div class="download-icon"></div>
                <div class="download-text">
                    <small>Download on the</small>
                    <span>App Store</span>
                </div>
            </a>
            <a href="#" class="download-btn">
                <div class="download-icon">📱</div>
                <div class="download-text">
                    <small>Get it on</small>
                    <span>Google Play</span>
                </div>
            </a>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <h3>MashouraX</h3>
                <p>Empowering institutions with AI-powered virtual advising to transform student success and drive better outcomes.</p>
                <div class="social-links">
                    <a href="#" class="social-link">𝕏</a>
                    <a href="#" class="social-link">in</a>
                    <a href="#" class="social-link">f</a>
                    <a href="#" class="social-link">▶</a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Solutions</h4>
                <ul class="footer-links">
                    <li><a href="solutions-virtual-advising.php">Virtual Advising</a></li>
                    <li><a href="solutions-student-success.php">Student Success</a></li>
                    <li><a href="solutions-academic-planning.php">Academic Planning</a></li>
                    <li><a href="solutions-career-services.php">Career Services</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <ul class="footer-links">
                    <li><a href="documentation.php">Documentation</a></li>
                    <li><a href="case-studies.php">Case Studies</a></li>
                    <li><a href="webinars.php">Webinars</a></li>
                    <li><a href="help-center.php">Help Center</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul class="footer-links">
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="solutions-career-services.php">Careers</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 MashouraX. All rights reserved. Built with excellence for student success.</p>
        </div>
    </footer>
</body>
</html>
