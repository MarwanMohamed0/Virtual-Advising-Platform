<?php
// MashouraX Virtual Advising Platform - chat-support
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
    <title>24/7 Chat Support - MashouraX Virtual Advising Platform</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .chat-page-section {
            padding: 180px 5% 100px;
            position: relative;
            z-index: 1;
        }

        .chat-header {
            text-align: center;
            max-width: 900px;
            margin: 0 auto 4rem;
        }

        .chat-header .section-label {
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .chat-header h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff, #DAA520);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .chat-header p {
            font-size: 1.2rem;
            color: #aaa;
            line-height: 1.8;
        }

        .chat-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 4rem;
        }

        .chat-feature-card {
            background: rgba(20, 20, 20, 0.8);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 20px;
            padding: 2.5rem;
            transition: all 0.3s ease;
        }

        .chat-feature-card:hover {
            transform: translateY(-10px);
            border-color: rgba(218, 165, 32, 0.5);
            box-shadow: 0 20px 40px rgba(218, 165, 32, 0.1);
        }

        .chat-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }

        .chat-feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .chat-feature-card p {
            color: #aaa;
            line-height: 1.8;
            font-size: 1rem;
        }

        .support-benefits-section {
            padding: 100px 5%;
            position: relative;
            z-index: 1;
            background: rgba(218, 165, 32, 0.02);
        }

        .benefits-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .benefits-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .benefits-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .benefits-header p {
            color: #aaa;
            font-size: 1.1rem;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .benefit-item {
            background: rgba(20, 20, 20, 0.6);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            border-color: rgba(218, 165, 32, 0.4);
            transform: translateY(-5px);
        }

        .benefit-item h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #DAA520;
        }

        .benefit-item ul {
            list-style: none;
            padding: 0;
        }

        .benefit-item ul li {
            padding: 0.6rem 0;
            color: #ccc;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .benefit-item ul li:last-child {
            border-bottom: none;
        }

        .benefit-item ul li::before {
            content: '✓';
            color: #DAA520;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .chat-header h1 {
                font-size: 2.5rem;
            }

            .chat-features-grid,
            .benefits-grid {
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

    <!-- Chat Support Header Section -->
    <section class="chat-page-section">
        <div class="chat-header">
            <div class="section-label">24/7 Chat Support</div>
            <h1>Always-On Student Support</h1>
            <p>Provide instant, accurate answers to student questions around the clock. Our AI-powered chat support never sleeps, ensuring students get help whenever they need it, day or night.</p>
        </div>

        <div class="chat-features-grid">
            <div class="chat-feature-card">
                <div class="chat-icon">⏰</div>
                <h3>24/7 Availability</h3>
                <p>Students can get help at any time, whether it's 2 AM or during peak registration periods. No more waiting for business hours or dealing with busy phone lines.</p>
            </div>
            <div class="chat-feature-card">
                <div class="chat-icon">⚡</div>
                <h3>Instant Responses</h3>
                <p>Get answers in seconds, not hours or days. Our AI assistant responds immediately to common questions, reducing student frustration and improving satisfaction.</p>
            </div>
            <div class="chat-feature-card">
                <div class="chat-icon">💬</div>
                <h3>Natural Conversations</h3>
                <p>Students can ask questions naturally, just like chatting with a human advisor. Our AI understands context and provides conversational, helpful responses.</p>
            </div>
            <div class="chat-feature-card">
                <div class="chat-icon">🔄</div>
                <h3>Seamless Escalation</h3>
                <p>When students need human assistance, the conversation seamlessly transfers to a live advisor with full context, ensuring continuity and no repeated explanations.</p>
            </div>
            <div class="chat-feature-card">
                <div class="chat-icon">📱</div>
                <h3>Multi-Platform Access</h3>
                <p>Students can access chat support from any device - desktop, tablet, or mobile. Consistent experience across all platforms with responsive design.</p>
            </div>
            <div class="chat-feature-card">
                <div class="chat-icon">📝</div>
                <h3>Conversation History</h3>
                <p>All conversations are saved and accessible. Students can review past interactions, and advisors can see full context when taking over a conversation.</p>
            </div>
        </div>
    </section>

    <!-- Support Benefits Section -->
    <section class="support-benefits-section">
        <div class="benefits-container">
            <div class="benefits-header">
                <h2>Benefits of 24/7 Chat Support</h2>
                <p>Transform your student support operations</p>
            </div>
            <div class="benefits-grid">
                <div class="benefit-item">
                    <h3>For Students</h3>
                    <ul>
                        <li>Instant answers to questions</li>
                        <li>Available anytime, anywhere</li>
                        <li>No phone wait times</li>
                        <li>Consistent, accurate information</li>
                    </ul>
                </div>
                <div class="benefit-item">
                    <h3>For Institutions</h3>
                    <ul>
                        <li>Reduced advisor workload</li>
                        <li>Lower support costs</li>
                        <li>Improved student satisfaction</li>
                        <li>Better resource allocation</li>
                    </ul>
                </div>
                <div class="benefit-item">
                    <h3>For Advisors</h3>
                    <ul>
                        <li>Focus on complex issues</li>
                        <li>Reduced repetitive questions</li>
                        <li>Full conversation context</li>
                        <li>Better work-life balance</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Ready to Provide 24/7 Support?</h2>
        <p>Start offering round-the-clock assistance to your students today.</p>
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
                    <a href="https://twitter.com" target="_blank" class="social-link" title="Follow us on X">𝕏</a>
                    <a href="https://linkedin.com" target="_blank" class="social-link" title="Connect on LinkedIn">in</a>
                    <a href="https://facebook.com" target="_blank" class="social-link" title="Like us on Facebook">f</a>
                    <a href="https://youtube.com" target="_blank" class="social-link" title="Subscribe on YouTube">▶</a>
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
