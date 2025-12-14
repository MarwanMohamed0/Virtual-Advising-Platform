<?php
// MashouraX Virtual Advising Platform - analytics-dashboard
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
    <title>Analytics Dashboard - MashouraX Virtual Advising Platform</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .analytics-page-section {
            padding: 180px 5% 100px;
            position: relative;
            z-index: 1;
        }

        .analytics-header {
            text-align: center;
            max-width: 900px;
            margin: 0 auto 4rem;
        }

        .analytics-header .section-label {
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .analytics-header h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff, #DAA520);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .analytics-header p {
            font-size: 1.2rem;
            color: #aaa;
            line-height: 1.8;
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 4rem;
        }

        .analytics-card {
            background: rgba(20, 20, 20, 0.8);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 20px;
            padding: 2.5rem;
            transition: all 0.3s ease;
        }

        .analytics-card:hover {
            transform: translateY(-10px);
            border-color: rgba(218, 165, 32, 0.5);
            box-shadow: 0 20px 40px rgba(218, 165, 32, 0.1);
        }

        .analytics-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }

        .analytics-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .analytics-card p {
            color: #aaa;
            line-height: 1.8;
            font-size: 1rem;
        }

        .metrics-section {
            padding: 100px 5%;
            position: relative;
            z-index: 1;
            background: rgba(218, 165, 32, 0.02);
        }

        .metrics-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .metrics-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .metrics-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .metrics-header p {
            color: #aaa;
            font-size: 1.1rem;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .metric-item {
            background: rgba(20, 20, 20, 0.6);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .metric-item:hover {
            border-color: rgba(218, 165, 32, 0.4);
            transform: translateY(-5px);
        }

        .metric-item h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #DAA520;
        }

        .metric-item ul {
            list-style: none;
            padding: 0;
        }

        .metric-item ul li {
            padding: 0.6rem 0;
            color: #ccc;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .metric-item ul li:last-child {
            border-bottom: none;
        }

        .metric-item ul li::before {
            content: '✓';
            color: #DAA520;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .analytics-header h1 {
                font-size: 2.5rem;
            }

            .analytics-grid,
            .metrics-grid {
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

    <!-- Analytics Header Section -->
    <section class="analytics-page-section">
        <div class="analytics-header">
            <div class="section-label">Analytics Dashboard</div>
            <h1>Data-Driven Insights for Student Success</h1>
            <p>Make informed decisions with comprehensive analytics and real-time dashboards that track student engagement, identify at-risk students, and measure the impact of your advising programs.</p>
        </div>

        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="analytics-icon">📊</div>
                <h3>Real-Time Dashboards</h3>
                <p>Monitor key metrics in real-time with customizable dashboards. Track student interactions, response times, satisfaction scores, and engagement levels at a glance.</p>
            </div>
            <div class="analytics-card">
                <div class="analytics-icon">📈</div>
                <h3>Student Engagement Tracking</h3>
                <p>Identify which students are actively engaging and which may need additional support. Track interaction frequency, question types, and response patterns.</p>
            </div>
            <div class="analytics-card">
                <div class="analytics-icon">🎯</div>
                <h3>At-Risk Student Identification</h3>
                <p>Automatically flag students who may be struggling based on engagement patterns, question topics, and interaction history. Proactively reach out before issues escalate.</p>
            </div>
            <div class="analytics-card">
                <div class="analytics-icon">💬</div>
                <h3>Conversation Analytics</h3>
                <p>Analyze conversation topics, sentiment, and resolution rates. Understand what students are asking about most and identify knowledge gaps.</p>
            </div>
            <div class="analytics-card">
                <div class="analytics-icon">⏱️</div>
                <h3>Performance Metrics</h3>
                <p>Measure response times, resolution rates, and advisor workload. Track improvements over time and optimize resource allocation.</p>
            </div>
            <div class="analytics-card">
                <div class="analytics-icon">📋</div>
                <h3>Custom Reports</h3>
                <p>Generate detailed reports on any metric that matters to your institution. Export data for further analysis or share with stakeholders.</p>
            </div>
        </div>
    </section>

    <!-- Metrics Section -->
    <section class="metrics-section">
        <div class="metrics-container">
            <div class="metrics-header">
                <h2>Key Metrics & Insights</h2>
                <p>Comprehensive analytics to drive student success</p>
            </div>
            <div class="metrics-grid">
                <div class="metric-item">
                    <h3>Engagement Metrics</h3>
                    <ul>
                        <li>Active student count</li>
                        <li>Interaction frequency</li>
                        <li>Response rates</li>
                        <li>Session duration</li>
                    </ul>
                </div>
                <div class="metric-item">
                    <h3>Performance Metrics</h3>
                    <ul>
                        <li>Average response time</li>
                        <li>Resolution rate</li>
                        <li>Satisfaction scores</li>
                        <li>Escalation rates</li>
                    </ul>
                </div>
                <div class="metric-item">
                    <h3>Trend Analysis</h3>
                    <ul>
                        <li>Topic trends over time</li>
                        <li>Seasonal patterns</li>
                        <li>Peak usage times</li>
                        <li>Growth metrics</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Ready to Unlock Your Data Insights?</h2>
        <p>Start tracking and improving student success with our comprehensive analytics dashboard.</p>
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
