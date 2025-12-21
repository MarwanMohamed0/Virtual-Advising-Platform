<?php
// MashouraX Virtual Advising Platform - about
try {
    require_once 'includes/auth.php';
    // Get current user if logged in
    $currentUser = getCurrentUser();
} catch (Exception $e) {
    // If database connection fails, set currentUser to null
    $currentUser = null;
    error_log("Auth error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MashouraX - About Us</title>
    <link rel="stylesheet" href="index.css">
    <style>
        /* Additional styles specific to about page */
        .hero {
            position: relative;
            padding: 180px 5% 100px;
            z-index: 1;
            text-align: center;
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

        .hero p {
            font-size: 1.3rem;
            color: #aaa;
            margin-bottom: 3rem;
            line-height: 1.8;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .story-section {
            position: relative;
            padding: 8rem 5%;
            z-index: 1;
        }

        .story-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .story-content h2 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
            line-height: 1.2;
        }

        .section-label {
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .story-content p {
            color: #aaa;
            font-size: 1.15rem;
            line-height: 1.9;
            margin-bottom: 1.5rem;
        }

        .story-visual {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 25px;
            padding: 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .story-visual::before {
            content: '🚀';
            font-size: 10rem;
            display: block;
            opacity: 0.4;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .mission-section {
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

        .mission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .mission-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 25px;
            padding: 3rem 2.5rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .mission-card:hover {
            transform: translateY(-10px);
            border-color: #DAA520;
            box-shadow: 0 25px 60px rgba(218, 165, 32, 0.2);
        }

        .mission-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }

        .mission-card h3 {
            font-size: 1.75rem;
            margin-bottom: 1rem;
            color: #fff;
            font-weight: 700;
        }

        .mission-card p {
            color: #aaa;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .values-section {
            position: relative;
            padding: 8rem 5%;
            z-index: 1;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .value-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.4s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
            border-color: #DAA520;
            box-shadow: 0 20px 60px rgba(218, 165, 32, 0.15);
        }

        .value-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }

        .value-card h4 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: #fff;
            font-weight: 700;
        }

        .value-card p {
            color: #999;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .team-section {
            position: relative;
            padding: 8rem 5%;
            z-index: 1;
            background: rgba(218, 165, 32, 0.02);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .team-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.4s ease;
        }

        .team-card:hover {
            transform: translateY(-10px);
            border-color: #DAA520;
            box-shadow: 0 20px 60px rgba(218, 165, 32, 0.15);
        }

        .team-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, rgba(218, 165, 32, 0.3), rgba(218, 165, 32, 0.1));
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            border: 2px solid rgba(218, 165, 32, 0.3);
        }

        .team-card h4 {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .team-role {
            color: #DAA520;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .team-card p {
            color: #999;
            line-height: 1.6;
            font-size: 0.95rem;
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

        .primary-btn {
            padding: 1.2rem 3rem;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            color: #000;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .primary-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(218, 165, 32, 0.5);
        }

        @media (max-width: 1024px) {
            .story-container {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 3.5rem;
            }

            .section-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
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

    <section class="hero">
        <div class="hero-badge">
            <span>🌟</span> About MashouraX
        </div>
        <h1>Revolutionizing Student Success Through AI</h1>
        <p>We're on a mission to transform how educational institutions support and guide students through their academic journey, making personalized advising accessible 24/7.</p>
    </section>

    <section class="story-section">
        <div class="story-container">
            <div class="story-content">
                <div class="section-label">Our Story</div>
                <h2>Building the Future of Education</h2>
                <p>MashouraX was founded with a simple yet powerful vision: every student deserves access to high-quality academic advising, regardless of time or location.</p>
                <p>We recognized that traditional advising models couldn't scale to meet the growing demands of modern education. Students needed instant answers, personalized guidance, and support that never sleeps.</p>
                <p>Today, we're proud to serve thousands of institutions and students worldwide, combining cutting-edge AI technology with human expertise to create meaningful educational outcomes.</p>
            </div>
            <div class="story-visual"></div>
        </div>
    </section>

    <section class="mission-section" id="mission">
        <div class="section-header">
            <div class="section-label">Our Mission & Vision</div>
            <h2 class="section-title">What Drives Us Forward</h2>
            <p class="section-description">We're committed to empowering educational institutions with the tools they need to support every student's success.</p>
        </div>
        <div class="mission-grid">
            <div class="mission-card">
                <div class="mission-icon">🎯</div>
                <h3>Our Mission</h3>
                <p>To democratize access to quality academic advising through innovative AI technology, ensuring every student receives personalized guidance to achieve their educational goals.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">🔮</div>
                <h3>Our Vision</h3>
                <p>To become the world's leading virtual advising platform, setting new standards for student support and transforming educational outcomes globally.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">💡</div>
                <h3>Our Approach</h3>
                <p>We combine advanced machine learning, data analytics, and human expertise to create an advising experience that's both scalable and deeply personalized.</p>
            </div>
        </div>
    </section>

    <section class="values-section">
        <div class="section-header">
            <div class="section-label">Our Values</div>
            <h2 class="section-title">What We Stand For</h2>
            <p class="section-description">Our core values guide every decision we make and every feature we build.</p>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🎓</div>
                <h4>Student-First</h4>
                <p>Every decision we make prioritizes student success and wellbeing.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🔒</div>
                <h4>Privacy & Security</h4>
                <p>We protect student data with enterprise-grade security and compliance.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🚀</div>
                <h4>Innovation</h4>
                <p>We continuously push boundaries to deliver cutting-edge solutions.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h4>Collaboration</h4>
                <p>We partner closely with institutions to understand and meet their needs.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">📊</div>
                <h4>Data-Driven</h4>
                <p>We use analytics and insights to continuously improve outcomes.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🌍</div>
                <h4>Accessibility</h4>
                <p>We make quality advising accessible to students everywhere.</p>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <h2>2020</h2>
                <p>Year Founded</p>
            </div>
            <div class="stat-item">
                <h2>500+</h2>
                <p>Institutions Served</p>
            </div>
            <div class="stat-item">
                <h2>10K+</h2>
                <p>Active Students</p>
            </div>
            <div class="stat-item">
                <h2>98%</h2>
                <p>Satisfaction Rate</p>
            </div>
            <div class="stat-item">
                <h2>50+</h2>
                <p>Team Members</p>
            </div>
            <div class="stat-item">
                <h2>15+</h2>
                <p>Countries</p>
            </div>
        </div>
    </section>

    <section class="team-section" id="team">
        <div class="section-header">
            <div class="section-label">Our Team</div>
            <h2 class="section-title">Meet the People Behind MashouraX</h2>
            <p class="section-description">A diverse team of educators, technologists, and innovators dedicated to transforming student success.</p>
        </div>
        <div class="team-grid">
            <div class="team-card">
                <div class="team-avatar">👨‍💼</div>
                <h4>Christian sherif</h4>
                <div class="team-role">Chief Executive Officer</div>
                <p>Former education technology leader with 15+ years transforming student experiences.</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">👩‍💻</div>
                <h4>Zeyad shedeed</h4>
                <div class="team-role">Chief Technology Officer</div>
                <p>AI researcher and engineer passionate about building scalable educational solutions.</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">👨‍🏫</div>
                <h4>Marwan mohamed</h4>
                <div class="team-role">Chief Academic Officer</div>
                <p>Former university dean bringing 20 years of advising expertise to our platform.</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">👩‍💼</div>
                <h4>Youssef essam</h4>
                <div class="team-role">Chief Product Officer</div>
                <p>Product strategist focused on creating intuitive experiences for students and advisors.</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">👩‍💼</div>
                <h4>Abdallah barbary</h4>
                <div class="team-role">Chief Product Officer</div>
                <p>Product strategist focused on creating intuitive experiences for students and advisors.</p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2>Ready to Transform Your Institution?</h2>
        <p>Join hundreds of institutions using MashouraX to provide exceptional student support and drive better outcomes.</p>
        <button class="primary-btn" onclick="window.location.href='trial.php'">Start Free Trial →</button>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <h3>MashouraX</h3>
                <p>Empowering institutions with AI-powered virtual advising to transform student success.</p>
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