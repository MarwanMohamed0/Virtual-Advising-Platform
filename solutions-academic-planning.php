<?php
// MashouraX Virtual Advising Platform - solutions-academic-planning
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Planning - Solutions | MashouraX</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="bg-animation"></div>
    <div class="top-bar">
        <div class="top-bar-left">
            <div class="top-bar-item"><span>📧</span> support@mashourax.com</div>
            <div class="top-bar-item"><span>📞</span> +1 (555) 123-4567</div>
        </div>
        <div class="top-bar-right">
            <a href="index.php#about" class="top-bar-link">About</a>
            <a href="index.php#blog" class="top-bar-link">Blog</a>
            <a href="index.php#careers" class="top-bar-link">Careers</a>
        </div>
    </div>

    <nav>
        <div class="logo" onclick="window.location.href='index.php'">MashouraX</div>
        <ul class="nav-center">
            <li class="nav-item">
                <a href="#solutions">Solutions ▾</a>
                <div class="dropdown">
                    <a href="solutions-virtual-advising.php">Virtual Advising</a>
                    <a href="solutions-student-success.php">Student Success</a>
                    <a href="solutions-academic-planning.php">Academic Planning</a>
                    <a href="solutions-career-services.php">Career Services</a>
                </div>
           
                <li class="nav-item">
                    <a href="#features">Features ▾</a>
                    <div class="dropdown">
                        <a href="#">AI-Powered Support</a>
                        <a href="#">Analytics Dashboard</a>
                        <a href="#">24/7 Chat Support</a>
                        <a href="#">Mobile App</a>
                    </div>
            </li>
            <li class="nav-item">
                <a href="#">Resources ▾</a>
                <div class="dropdown">
                    <a href="case-studies.php">Case Studies</a>
                    <a href="documentation.php">Documentation</a>
                    <a href="webinars.php">Webinars</a>
                    <a href="help-center.php">Help Center</a>
                </div>
            </li>
            <li class="nav-item"><a href="index.php#pricing">Pricing</a></li>
            <li class="nav-item"><a href="index.php#security">Security</a></li>
        </ul>
        <div class="nav-right">
            <button class="search-btn">🔍 Search</button>
            <button class="login-btn" onclick="window.location.href='login.php'">Login</button>
            <button class="demo-btn" onclick="window.location.href='demo.php'">Request Demo</button>
        </div>
    </nav>

    <section class="features" style="padding-top: 180px;">
        <div class="section-header">
            <div class="section-label">Solutions</div>
            <h2 class="section-title">Academic Planning</h2>
            <p class="section-description">Clear degree pathways, intelligent course selection, and on-time completion.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🗺️</div>
                <h3>Pathway Builder</h3>
                <p>Create semester-by-semester plans aligned to program requirements and goals.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎓</div>
                <h3>Eligibility Checks</h3>
                <p>Validate prerequisites and co-requisites to prevent registration roadblocks.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚖️</div>
                <h3>What‑If Scenarios</h3>
                <p>Compare majors and simulate changes without risking degree progress.</p>
            </div>
        </div>
    </section>

    <section class="support-section">
        <div class="support-container">
            <div class="support-content">
                <div class="ai-subtitle">Overview</div>
                <h2>Plan With Confidence—From First Year to Graduation</h2>
                <p>Ensure every student has a clear, achievable path to a credential. Advisors get visibility; students get guidance; registrars get cleaner data.</p>
                <ul class="support-features">
                    <li>Automatic requirement audits and progress bars</li>
                    <li>Advisor notes synced to plans and courses</li>
                    <li>Scheduling that avoids time conflicts and overloads</li>
                    <li>Exportable plans for advising sessions</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="section-header">
            <div class="section-label">Integrations</div>
            <h2 class="section-title">Connect to Your SIS and LMS</h2>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔗</div>
                <h3>Live Course Data</h3>
                <p>Sync sections, availability, prerequisites, and instructor details automatically.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <h3>Bidirectional Updates</h3>
                <p>Push planned schedules and registrations back to your SIS workflows.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧩</div>
                <h3>APIs & Webhooks</h3>
                <p>Extend planning with custom rules, approvals, and degree audit systems.</p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2>Give Every Student a Clear Plan</h2>
        <p>Launch academic planning with templates tailored to your programs.</p>
        <div class="hero-buttons">
            <button class="primary-btn" onclick="window.location.href='trial.php'">Start Free Trial →</button>
            <button class="secondary-btn" onclick="window.location.href='demo.php'">See a Live Plan</button>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <h3>MashouraX</h3>
                <p>Empowering institutions with AI-powered virtual advising to transform student success and drive better outcomes.</p>
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
                    <li><a href="index.php#">About Us</a></li>
                    <li><a href="index.php#">Careers</a></li>
                    <li><a href="index.php#">Contact</a></li>
                    <li><a href="index.php#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 MashouraX. All rights reserved. Built with excellence for student success.</p>
        </div>
    </footer>
</body>
</html>



