<?php
// MashouraX Virtual Advising Platform - ai-features
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
    <title>AI-Powered Support - MashouraX Virtual Advising Platform</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .feature-page-section {
            padding: 180px 5% 100px;
            position: relative;
            z-index: 1;
        }

        .feature-header {
            text-align: center;
            max-width: 900px;
            margin: 0 auto 4rem;
        }

        .feature-header .section-label {
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .feature-header h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff, #DAA520);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-header p {
            font-size: 1.2rem;
            color: #aaa;
            line-height: 1.8;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 4rem;
        }

        .feature-card {
            background: rgba(20, 20, 20, 0.8);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 20px;
            padding: 2.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: rgba(218, 165, 32, 0.5);
            box-shadow: 0 20px 40px rgba(218, 165, 32, 0.1);
        }

        .feature-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .feature-card p {
            color: #aaa;
            line-height: 1.8;
            font-size: 1rem;
        }

        .ai-capabilities-section {
            padding: 100px 5%;
            position: relative;
            z-index: 1;
            background: rgba(218, 165, 32, 0.02);
        }

        .capabilities-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .capabilities-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .capabilities-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .capabilities-header p {
            color: #aaa;
            font-size: 1.1rem;
        }

        .capabilities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .capability-item {
            background: rgba(20, 20, 20, 0.6);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .capability-item:hover {
            border-color: rgba(218, 165, 32, 0.4);
            transform: translateY(-5px);
        }

        .capability-item h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #DAA520;
        }

        .capability-item ul {
            list-style: none;
            padding: 0;
        }

        .capability-item ul li {
            padding: 0.6rem 0;
            color: #ccc;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .capability-item ul li:last-child {
            border-bottom: none;
        }

        .capability-item ul li::before {
            content: '✓';
            color: #DAA520;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .feature-header h1 {
                font-size: 2.5rem;
            }

            .features-grid,
            .capabilities-grid {
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

    <!-- AI Features Header Section -->
    <section class="feature-page-section">
        <div class="feature-header">
            <div class="section-label">AI-Powered Support</div>
            <h1>Intelligent Virtual Advising at Your Fingertips</h1>
            <p>Experience the power of machine learning with our advanced AI assistant that understands context, learns from interactions, and provides accurate, personalized guidance to students 24/7.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🧠</div>
                <h3>Natural Language Processing</h3>
                <p>Advanced NLP capabilities understand student questions in natural language, regardless of how they phrase their inquiries. Our AI comprehends context and intent for accurate responses.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3>850+ Pre-Built Questions</h3>
                <p>Start with a comprehensive library of 850+ vetted questions covering financial aid, registration, academic planning, and more. Continuously updated with regulatory changes.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <h3>Continuous Learning</h3>
                <p>Our AI learns from every interaction, improving response quality over time. Machine learning algorithms adapt to your institution's specific policies and student needs.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌐</div>
                <h3>Multi-Language Support</h3>
                <p>Serve students in their preferred language. Our AI supports multiple languages with accurate translations and culturally appropriate responses.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>Contextual Conversations</h3>
                <p>Maintains conversation context throughout interactions, remembering previous questions and providing coherent, personalized follow-up responses.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Sentiment Analysis</h3>
                <p>Detects student emotions and adjusts responses accordingly. Escalates to human advisors when students need additional support or are frustrated.</p>
            </div>
        </div>
    </section>

    <!-- AI Capabilities Section -->
    <section class="ai-capabilities-section">
        <div class="capabilities-container">
            <div class="capabilities-header">
                <h2>Advanced AI Capabilities</h2>
                <p>Comprehensive AI features designed to enhance student support</p>
            </div>
            <div class="capabilities-grid">
                <div class="capability-item">
                    <h3>Knowledge Management</h3>
                    <ul>
                        <li>Custom knowledge base integration</li>
                        <li>Document parsing and indexing</li>
                        <li>Automatic policy updates</li>
                        <li>Version control for policies</li>
                    </ul>
                </div>
                <div class="capability-item">
                    <h3>Intelligent Routing</h3>
                    <ul>
                        <li>Smart question categorization</li>
                        <li>Automatic escalation to humans</li>
                        <li>Priority-based routing</li>
                        <li>Department-specific routing</li>
                    </ul>
                </div>
                <div class="capability-item">
                    <h3>Analytics & Insights</h3>
                        <ul>
                        <li>Conversation analytics</li>
                        <li>Topic trend analysis</li>
                        <li>Student satisfaction tracking</li>
                        <li>Performance metrics</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Ready to Experience AI-Powered Support?</h2>
        <p>See how our AI can transform your student support operations and improve outcomes.</p>
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
