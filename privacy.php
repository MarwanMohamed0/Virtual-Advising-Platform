<?php
// MashouraX Virtual Advising Platform - privacy
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MashouraX - Privacy Policy</title>
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
            padding: 180px 5% 80px;
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
            font-size: 1.2rem;
            color: #aaa;
            line-height: 1.8;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .last-updated {
            color: #DAA520;
            font-size: 0.95rem;
            margin-top: 1rem;
        }

        .content-section {
            position: relative;
            padding: 4rem 5% 8rem;
            z-index: 1;
        }

        .content-container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 25px;
            padding: 4rem;
        }

        .toc {
            background: rgba(218, 165, 32, 0.05);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .toc h3 {
            color: #DAA520;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .toc ul {
            list-style: none;
        }

        .toc li {
            margin-bottom: 0.8rem;
        }

        .toc a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .toc a:hover {
            color: #DAA520;
        }

        .policy-section {
            margin-bottom: 4rem;
        }

        .policy-section h2 {
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(218, 165, 32, 0.2);
        }

        .policy-section h3 {
            font-size: 1.8rem;
            color: #DAA520;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .policy-section p {
            color: #aaa;
            font-size: 1.05rem;
            line-height: 1.9;
            margin-bottom: 1.5rem;
        }

        .policy-section ul {
            color: #aaa;
            font-size: 1.05rem;
            line-height: 1.9;
            margin-left: 2rem;
            margin-bottom: 1.5rem;
        }

        .policy-section li {
            margin-bottom: 0.8rem;
        }

        .highlight-box {
            background: rgba(218, 165, 32, 0.1);
            border-left: 4px solid #DAA520;
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: 10px;
        }

        .highlight-box p {
            margin: 0;
            color: #fff;
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
            h1 {
                font-size: 3.5rem;
            }

            .nav-center {
                display: none;
            }

            .content-container {
                padding: 3rem 2rem;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            .content-container {
                padding: 2rem 1.5rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>

    <?php require_once 'includes/navigation.php'; ?>

    <section class="hero">
        <div class="hero-badge">
            <span>🔒</span> Your Privacy Matters
        </div>
        <h1>Privacy Policy</h1>
        <p>We are committed to protecting your privacy and ensuring the security of your personal information.</p>
        <p class="last-updated">Last Updated: January 15, 2025</p>
    </section>

    <section class="content-section">
        <div class="content-container">
            <div class="toc">
                <h3>Table of Contents</h3>
                <ul>
                    <li><a href="#introduction">1. Introduction</a></li>
                    <li><a href="#information">2. Information We Collect</a></li>
                    <li><a href="#usage">3. How We Use Your Information</a></li>
                    <li><a href="#sharing">4. Information Sharing</a></li>
                    <li><a href="#security">5. Data Security</a></li>
                    <li><a href="#rights">6. Your Rights</a></li>
                    <li><a href="#cookies">7. Cookies and Tracking</a></li>
                    <li><a href="#children">8. Children's Privacy</a></li>
                    <li><a href="#changes">9. Changes to This Policy</a></li>
                    <li><a href="#contact">10. Contact Us</a></li>
                </ul>
            </div>

            <div class="policy-section" id="introduction">
                <h2>1. Introduction</h2>
                <p>Welcome to MashouraX. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our virtual advising platform. Please read this privacy policy carefully.</p>
                <div class="highlight-box">
                    <p><strong>Important:</strong> By using MashouraX, you agree to the collection and use of information in accordance with this policy.</p>
                </div>
            </div>

            <div class="policy-section" id="information">
                <h2>2. Information We Collect</h2>
                <p>We collect several types of information to provide and improve our service:</p>
                
                <h3>Personal Information</h3>
                <ul>
                    <li>Name and contact information (email address, phone number)</li>
                    <li>Student ID or institutional identification</li>
                    <li>Academic records and educational history</li>
                    <li>Demographic information (age, location)</li>
                    <li>Account credentials and preferences</li>
                </ul>

                <h3>Usage Information</h3>
                <ul>
                    <li>Log data (IP address, browser type, pages visited)</li>
                    <li>Device information and identifiers</li>
                    <li>Interaction data with our platform</li>
                    <li>Communication records with advisors</li>
                    <li>Survey responses and feedback</li>
                </ul>

                <h3>Educational Data</h3>
                <ul>
                    <li>Course enrollment and completion data</li>
                    <li>Grades and academic performance</li>
                    <li>Career interests and goals</li>
                    <li>Advising session notes and recommendations</li>
                </ul>
            </div>

            <div class="policy-section" id="usage">
                <h2>3. How We Use Your Information</h2>
                <p>MashouraX uses the collected information for various purposes:</p>
                <ul>
                    <li>To provide and maintain our virtual advising services</li>
                    <li>To personalize your experience and provide tailored recommendations</li>
                    <li>To communicate with you about your account and services</li>
                    <li>To improve our platform through data analysis and research</li>
                    <li>To monitor usage patterns and prevent fraud or abuse</li>
                    <li>To comply with legal obligations and institutional requirements</li>
                    <li>To send important notifications and updates</li>
                    <li>To provide customer support and respond to inquiries</li>
                </ul>
            </div>

            <div class="policy-section" id="sharing">
                <h2>4. Information Sharing</h2>
                <p>We may share your information in the following situations:</p>

                <h3>With Educational Institutions</h3>
                <p>We share relevant information with your institution's authorized personnel, including advisors, administrators, and faculty members, to provide advising services.</p>

                <h3>With Service Providers</h3>
                <p>We may share information with third-party service providers who assist us in operating our platform, conducting business, or serving our users.</p>

                <h3>For Legal Compliance</h3>
                <p>We may disclose information when required by law, regulation, legal process, or governmental request.</p>

                <div class="highlight-box">
                    <p><strong>We will never sell your personal information to third parties.</strong></p>
                </div>
            </div>

            <div class="policy-section" id="security">
                <h2>5. Data Security</h2>
                <p>We implement robust security measures to protect your information:</p>
                <ul>
                    <li><strong>Encryption:</strong> All data is encrypted in transit using TLS/SSL and at rest using AES-256 encryption</li>
                    <li><strong>Access Controls:</strong> Role-based access ensures only authorized personnel can access your data</li>
                    <li><strong>Regular Audits:</strong> We conduct regular security audits and penetration testing</li>
                    <li><strong>Compliance:</strong> We comply with FERPA, GDPR, and SOC 2 Type II standards</li>
                    <li><strong>Monitoring:</strong> Continuous monitoring for suspicious activities and security threats</li>
                    <li><strong>Data Backup:</strong> Regular backups ensure data recovery in case of incidents</li>
                </ul>
                <p>While we implement strong security measures, no method of transmission over the internet is 100% secure. We cannot guarantee absolute security.</p>
            </div>

            <div class="policy-section" id="rights">
                <h2>6. Your Rights</h2>
                <p>You have the following rights regarding your personal information:</p>
                <ul>
                    <li><strong>Access:</strong> Request access to your personal data</li>
                    <li><strong>Correction:</strong> Request correction of inaccurate information</li>
                    <li><strong>Deletion:</strong> Request deletion of your personal data (subject to legal requirements)</li>
                    <li><strong>Export:</strong> Request a copy of your data in a portable format</li>
                    <li><strong>Opt-Out:</strong> Opt-out of marketing communications</li>
                    <li><strong>Restriction:</strong> Request restriction of processing in certain circumstances</li>
                </ul>
                <p>To exercise these rights, please contact us at privacy@mashourax.com</p>
            </div>

            <div class="policy-section" id="cookies">
                <h2>7. Cookies and Tracking Technologies</h2>
                <p>We use cookies and similar tracking technologies to track activity on our platform and hold certain information:</p>
                
                <h3>Types of Cookies We Use</h3>
                <ul>
                    <li><strong>Essential Cookies:</strong> Required for the platform to function properly</li>
                    <li><strong>Analytics Cookies:</strong> Help us understand how users interact with our platform</li>
                    <li><strong>Preference Cookies:</strong> Remember your settings and preferences</li>
                    <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements (with your consent)</li>
                </ul>
                <p>You can control cookie preferences through your browser settings. Note that disabling certain cookies may limit platform functionality.</p>
            </div>

            <div class="policy-section" id="children">
                <h2>8. Children's Privacy</h2>
                <p>Our service is designed for educational institutions and students. While we may serve users under 18, we do so through institutional partnerships with appropriate parental consent and COPPA compliance where applicable.</p>
                <p>We do not knowingly collect personal information from children under 13 without verifiable parental consent. If you believe we have collected such information, please contact us immediately.</p>
            </div>

            <div class="policy-section" id="changes">
                <h2>9. Changes to This Privacy Policy</h2>
                <p>We may update our Privacy Policy from time to time. We will notify you of any changes by:</p>
                <ul>
                    <li>Posting the new Privacy Policy on this page</li>
                    <li>Updating the "Last Updated" date</li>
                    <li>Sending you an email notification for significant changes</li>
                    <li>Displaying a prominent notice on our platform</li>
                </ul>
                <p>You are advised to review this Privacy Policy periodically for any changes. Changes are effective when posted on this page.</p>
            </div>

            <div class="policy-section" id="contact">
                <h2>10. Contact Us</h2>
                <p>If you have any questions about this Privacy Policy or our data practices, please contact us:</p>
                <ul>
                    <li><strong>Email:</strong> privacy@mashourax.com</li>
                    <li><strong>Phone:</strong> +012 707 23373</li>
                    <li><strong>Address:</strong> Obour, Cairo, Egypt</li>
                    <li><strong>Data Protection Officer:</strong> dpo@mashourax.com</li>
                </ul>
                <p>We will respond to your inquiry within 30 days.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <h3>MashouraX</h3>
                <p>Empowering institutions with AI-powered virtual advising to transform student success.</p>
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
</body>
</html>
