<?php
// MashouraX Virtual Advising Platform - security
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
    <title>Security & Compliance - MashouraX Virtual Advising Platform</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .security-page-section {
            padding: 180px 5% 100px;
            position: relative;
            z-index: 1;
        }

        .security-header {
            text-align: center;
            max-width: 900px;
            margin: 0 auto 4rem;
        }

        .security-header .section-label {
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .security-header h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff, #DAA520);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .security-header p {
            font-size: 1.2rem;
            color: #aaa;
            line-height: 1.8;
        }

        .security-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 4rem;
        }

        .security-item {
            background: rgba(20, 20, 20, 0.8);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 20px;
            padding: 2.5rem;
            transition: all 0.3s ease;
            text-align: center;
        }

        .security-item:hover {
            transform: translateY(-10px);
            border-color: rgba(218, 165, 32, 0.5);
            box-shadow: 0 20px 40px rgba(218, 165, 32, 0.1);
        }

        .security-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }

        .security-item h4 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .security-item p {
            color: #aaa;
            line-height: 1.8;
            font-size: 1rem;
        }

        .compliance-section {
            padding: 100px 5%;
            position: relative;
            z-index: 1;
            background: rgba(218, 165, 32, 0.02);
        }

        .compliance-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .compliance-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .compliance-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .compliance-header p {
            color: #aaa;
            font-size: 1.1rem;
        }

        .compliance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .compliance-card {
            background: rgba(20, 20, 20, 0.6);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .compliance-card:hover {
            border-color: rgba(218, 165, 32, 0.4);
            transform: translateY(-5px);
        }

        .compliance-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #DAA520;
        }

        .compliance-card ul {
            list-style: none;
            padding: 0;
        }

        .compliance-card ul li {
            padding: 0.6rem 0;
            color: #ccc;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .compliance-card ul li:last-child {
            border-bottom: none;
        }

        .compliance-card ul li::before {
            content: '✓';
            color: #DAA520;
            font-weight: 700;
        }

        .security-features-section {
            padding: 100px 5%;
            position: relative;
            z-index: 1;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .features-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .features-header p {
            color: #aaa;
            font-size: 1.1rem;
        }

        .features-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-item {
            background: rgba(20, 20, 20, 0.6);
            border-left: 4px solid #DAA520;
            border-radius: 10px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(20, 20, 20, 0.8);
            transform: translateX(10px);
        }

        .feature-item h3 {
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            color: #fff;
        }

        .feature-item p {
            color: #aaa;
            line-height: 1.8;
        }

        @media (max-width: 768px) {
            .security-header h1 {
                font-size: 2.5rem;
            }

            .security-grid,
            .compliance-grid,
            .features-list {
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

    <!-- Security Header Section -->
    <section class="security-page-section">
        <div class="security-header">
            <div class="section-label">Security & Compliance</div>
            <h1>Enterprise-Grade Security You Can Trust</h1>
            <p>Your data protection is our top priority. We implement industry-leading security measures to keep student information safe and ensure full regulatory compliance.</p>
        </div>

        <div class="security-grid">
            <div class="security-item">
                <div class="security-icon">🔒</div>
                <h4>End-to-End Encryption</h4>
                <p>All data is encrypted in transit and at rest using industry-standard AES-256 encryption protocols. Your sensitive information remains protected at all times.</p>
            </div>
            <div class="security-item">
                <div class="security-icon">✓</div>
                <h4>FERPA Compliant</h4>
                <p>Fully compliant with FERPA regulations to protect student education records and privacy. We maintain strict adherence to all educational privacy standards.</p>
            </div>
            <div class="security-item">
                <div class="security-icon">🛡️</div>
                <h4>SOC 2 Type II</h4>
                <p>Certified SOC 2 Type II compliant, ensuring the highest standards of data security, availability, and operational excellence.</p>
            </div>
            <div class="security-item">
                <div class="security-icon">👤</div>
                <h4>Role-Based Access</h4>
                <p>Granular permission controls ensure users only access information relevant to their role. Multi-factor authentication available for enhanced security.</p>
            </div>
            <div class="security-item">
                <div class="security-icon">🔍</div>
                <h4>Audit Logging</h4>
                <p>Comprehensive audit trails track all system activities for complete transparency and accountability. Full activity history maintained for compliance.</p>
            </div>
            <div class="security-item">
                <div class="security-icon">🌐</div>
                <h4>GDPR Ready</h4>
                <p>Built with global privacy standards in mind, including GDPR compliance for international institutions. Data portability and right to deletion supported.</p>
            </div>
        </div>
    </section>

    <!-- Compliance Section -->
    <section class="compliance-section">
        <div class="compliance-container">
            <div class="compliance-header">
                <h2>Compliance & Certifications</h2>
                <p>We meet and exceed industry standards for data protection and privacy</p>
            </div>
            <div class="compliance-grid">
                <div class="compliance-card">
                    <h3>Data Protection</h3>
                    <ul>
                        <li>GDPR Compliance</li>
                        <li>CCPA Compliance</li>
                        <li>FERPA Compliance</li>
                        <li>Data Encryption Standards</li>
                    </ul>
                </div>
                <div class="compliance-card">
                    <h3>Security Standards</h3>
                    <ul>
                        <li>SOC 2 Type II Certified</li>
                        <li>ISO 27001 Aligned</li>
                        <li>Regular Security Audits</li>
                        <li>Penetration Testing</li>
                    </ul>
                </div>
                <div class="compliance-card">
                    <h3>Privacy Controls</h3>
                    <ul>
                        <li>Data Minimization</li>
                        <li>Access Controls</li>
                        <li>Data Retention Policies</li>
                        <li>Right to Deletion</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Security Features Section -->
    <section class="security-features-section">
        <div class="features-container">
            <div class="features-header">
                <h2>Advanced Security Features</h2>
                <p>Comprehensive protection for your institution's data</p>
            </div>
            <div class="features-list">
                <div class="feature-item">
                    <h3>Multi-Factor Authentication</h3>
                    <p>Optional MFA support for all user accounts, including SMS, email, and authenticator app verification methods.</p>
                </div>
                <div class="feature-item">
                    <h3>Regular Security Updates</h3>
                    <p>Continuous monitoring and regular security patches to protect against emerging threats and vulnerabilities.</p>
                </div>
                <div class="feature-item">
                    <h3>Secure Data Centers</h3>
                    <p>Data hosted in secure, redundant data centers with 99.9% uptime SLA and disaster recovery capabilities.</p>
                </div>
                <div class="feature-item">
                    <h3>Intrusion Detection</h3>
                    <p>Advanced intrusion detection and prevention systems monitor and block suspicious activities in real-time.</p>
                </div>
                <div class="feature-item">
                    <h3>Data Backup & Recovery</h3>
                    <p>Automated daily backups with point-in-time recovery options to ensure data availability and business continuity.</p>
                </div>
                <div class="feature-item">
                    <h3>Vulnerability Management</h3>
                    <p>Regular vulnerability assessments and penetration testing to identify and remediate security weaknesses.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Have Security Questions?</h2>
        <p>Our security team is available to discuss your specific compliance and security requirements.</p>
        <div class="hero-buttons">
            <button class="primary-btn" onclick="window.location.href='contact.php'">Contact Security Team →</button>
            <button class="secondary-btn" onclick="window.location.href='pricing.php'">View Pricing</button>
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

