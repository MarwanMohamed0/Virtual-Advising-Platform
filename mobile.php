<?php
// MashouraX Virtual Advising Platform - mobile
try {
    require_once 'includes/auth.php';
    $currentUser = getCurrentUser();
} catch (Exception $e) {
    $currentUser = null;
    error_log("Auth error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile App - MashouraX Virtual Advising Platform</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .mobile-page-section {
            padding: 180px 5% 100px;
            position: relative;
            z-index: 1;
        }

        .mobile-header {
            text-align: center;
            max-width: 900px;
            margin: 0 auto 4rem;
        }

        .mobile-header .section-label {
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .mobile-header h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff, #DAA520);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mobile-header p {
            font-size: 1.2rem;
            color: #aaa;
            line-height: 1.8;
        }

        .mobile-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 4rem;
        }

        .mobile-feature-card {
            background: rgba(20, 20, 20, 0.8);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 20px;
            padding: 2.5rem;
            transition: all 0.3s ease;
        }

        .mobile-feature-card:hover {
            transform: translateY(-10px);
            border-color: rgba(218, 165, 32, 0.5);
            box-shadow: 0 20px 40px rgba(218, 165, 32, 0.1);
        }

        .mobile-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }

        .mobile-feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .mobile-feature-card p {
            color: #aaa;
            line-height: 1.8;
            font-size: 1rem;
        }

        .app-features-section {
            padding: 100px 5%;
            position: relative;
            z-index: 1;
            background: rgba(218, 165, 32, 0.02);
        }

        .app-features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .app-features-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .app-features-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .app-features-header p {
            color: #aaa;
            font-size: 1.1rem;
        }

        .app-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .app-feature-item {
            background: rgba(20, 20, 20, 0.6);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .app-feature-item:hover {
            border-color: rgba(218, 165, 32, 0.4);
            transform: translateY(-5px);
        }

        .app-feature-item h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #DAA520;
        }

        .app-feature-item ul {
            list-style: none;
            padding: 0;
        }

        .app-feature-item ul li {
            padding: 0.6rem 0;
            color: #ccc;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .app-feature-item ul li:last-child {
            border-bottom: none;
        }

        .app-feature-item ul li::before {
            content: '✓';
            color: #DAA520;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .mobile-header h1 {
                font-size: 2.5rem;
            }

            .mobile-features-grid,
            .app-features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>
    
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <?php require_once 'includes/navigation.php'; ?>

    <!-- Mobile App Header Section -->
    <section class="mobile-page-section">
        <div class="mobile-header">
            <div class="section-label">Mobile App</div>
            <h1>Student Support on the Go</h1>
            <p>Access MashouraX virtual advising from anywhere, anytime. Our mobile-optimized platform ensures students can get help whether they're on campus, at home, or on the go.</p>
        </div>

        <div class="mobile-features-grid">
            <div class="mobile-feature-card">
                <div class="mobile-icon">📱</div>
                <h3>Responsive Design</h3>
                <p>Fully responsive interface that works seamlessly on smartphones, tablets, and desktops. Consistent experience across all devices with touch-optimized controls.</p>
            </div>
            <div class="mobile-feature-card">
                <div class="mobile-icon">🚀</div>
                <h3>Fast Performance</h3>
                <p>Lightning-fast load times and smooth interactions, even on slower connections. Optimized for mobile networks with efficient data usage.</p>
            </div>
            <div class="mobile-feature-card">
                <div class="mobile-icon">💬</div>
                <h3>Mobile Chat Interface</h3>
                <p>Native chat experience designed for mobile devices. Easy-to-use interface with quick responses, emoji support, and voice input capabilities.</p>
            </div>
            <div class="mobile-feature-card">
                <div class="mobile-icon">🔔</div>
                <h3>Push Notifications</h3>
                <p>Stay informed with real-time notifications for important updates, responses to questions, and deadline reminders. Never miss critical information.</p>
            </div>
            <div class="mobile-feature-card">
                <div class="mobile-icon">📋</div>
                <h3>Offline Access</h3>
                <p>Access frequently asked questions and saved conversations even when offline. Sync automatically when connection is restored.</p>
            </div>
            <div class="mobile-feature-card">
                <div class="mobile-icon">🔐</div>
                <h3>Secure & Private</h3>
                <p>Enterprise-grade security on mobile devices with encrypted communications, secure authentication, and privacy protection for sensitive student data.</p>
            </div>
        </div>
    </section>

    <!-- App Features Section -->
    <section class="app-features-section">
        <div class="app-features-container">
            <div class="app-features-header">
                <h2>Mobile App Features</h2>
                <p>Everything students need, optimized for mobile</p>
            </div>
            <div class="app-features-grid">
                <div class="app-feature-item">
                    <h3>Core Features</h3>
                    <ul>
                        <li>24/7 AI chat support</li>
                        <li>Quick question search</li>
                        <li>Conversation history</li>
                        <li>Profile management</li>
                    </ul>
                </div>
                <div class="app-feature-item">
                    <h3>Student Tools</h3>
                    <ul>
                        <li>Academic progress tracking</li>
                        <li>Course information</li>
                        <li>Appointment scheduling</li>
                        <li>Document access</li>
                    </ul>
                </div>
                <div class="app-feature-item">
                    <h3>Platform Support</h3>
                    <ul>
                        <li>iOS and Android ready</li>
                        <li>Progressive Web App</li>
                        <li>Cross-platform sync</li>
                        <li>Regular updates</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Ready to Go Mobile?</h2>
        <p>Give your students the flexibility to access support from any device, anywhere.</p>
        <div class="hero-buttons">
            <button class="primary-btn" onclick="window.location.href='trial.php'">Start Free Trial →</button>
            <button class="secondary-btn" onclick="window.location.href='demo.php'">Schedule a Demo</button>
        </div>
    </section>

    <!-- Footer -->
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

    <script src="cookies-loader.js"></script>
</body>
</html>
