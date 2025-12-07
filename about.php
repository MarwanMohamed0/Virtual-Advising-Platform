<?php
// MashouraX Virtual Advising Platform - about
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MashouraX - About Us</title>
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
            cursor: pointer;
        }

        .nav-center {
            display: flex;
            gap: 3rem;
            list-style: none;
            align-items: center;
        }

        .nav-item > a {
            color: #fff;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-item > a:hover {
            color: #DAA520;
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
            .story-container {
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

            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>

    <div class="top-bar">
        <div class="top-bar-left">
            <div class="top-bar-item">
                <span>📧</span> support@mashourax.com
            </div>
            <div class="top-bar-item">
                <span>📞</span> +1 (555) 123-4567
            </div>
        </div>
        <div class="top-bar-right">
            <a href="#" class="top-bar-link">About</a>
            <a href="#" class="top-bar-link">Blog</a>
            <a href="#" class="top-bar-link">Careers</a>
        </div>
    </div>

    <nav>
        <div class="logo" onclick="window.location.href='index.php'">MashouraX</div>
        <ul class="nav-center">
            <li class="nav-item"><a href="index.php">Home</a></li>
            <li class="nav-item"><a href="#mission">Mission</a></li>
            <li class="nav-item"><a href="#team">Team</a></li>
            <li class="nav-item"><a href="#contact">Contact</a></li>
        </ul>
        <div class="nav-right">
            <button class="search-btn">🔍 Search</button>
            <button class="login-btn">Login</button>
            <button class="demo-btn">Request Demo</button>
        </div>
    </nav>

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
                    <li><a href="#">Virtual Advising</a></li>
                    <li><a href="#">Student Success</a></li>
                    <li><a href="#">Academic Planning</a></li>
                    <li><a href="#">Career Services</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <ul class="footer-links">
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Case Studies</a></li>
                    <li><a href="#">Webinars</a></li>
                    <li><a href="#">Help Center</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul class="footer-links">
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Contact</a></li>
