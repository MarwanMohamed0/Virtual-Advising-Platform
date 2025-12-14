<?php
// MashouraX Virtual Advising Platform - demo
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Demo - MashouraX</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="bg-animation"></div>
    
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <?php require_once 'includes/navigation.php'; ?>

    <!-- Demo Hero Section -->
    <section class="hero" style="min-height: auto; padding-top: 140px; padding-bottom: 60px;">
        <div class="hero-content" style="grid-template-columns: 1fr; text-align: center; max-width: 1200px;">
            <div>
                <div class="hero-badge">
                    <span>▶</span> Product Demo
                </div>
                <h1 style="font-size: 3.5rem;">See MashouraX in Action</h1>
                <p style="font-size: 1.15rem; max-width: 800px; margin: 0 auto 3rem;">
                    Discover how our AI-powered virtual advising platform transforms student success. Watch this comprehensive demo to see all features in action.
                </p>

                <!-- Video Container -->
                <div class="video-wrapper">
                    <iframe
                        src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                        title="MashouraX Product Demo"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Features Section -->
    <section class="features" style="padding-top: 4rem;">
        <div class="section-header">
            <div class="section-label">What You'll See</div>
            <h2 class="section-title">Explore Key Features in This Demo</h2>
            <p class="section-description">Discover the powerful capabilities that make MashouraX the leading virtual advising platform.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🤖</div>
                <h3>AI-Powered Conversations</h3>
                <p>See how our intelligent chatbot handles complex student queries with natural, personalized responses drawn from 850+ vetted questions.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Analytics Dashboard</h3>
                <p>Explore our comprehensive analytics that help you track engagement, identify at-risk students, and measure success metrics in real time.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Personalized Journeys</h3>
                <p>Watch how we create tailored academic pathways for each student, from enrollment through degree completion.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <h3>Seamless Integration</h3>
                <p>Learn how MashouraX integrates with your existing SIS, LMS, and other campus systems for a unified experience.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Ready to Get Started?</h2>
        <p>Start your free trial today and experience the power of AI-driven student success.</p>
        <div class="hero-buttons">
            <button class="primary-btn" onclick="window.location.href='trial.php'">Start Free Trial →</button>
            <button class="secondary-btn" onclick="window.location.href='index.php'">← Back to Home</button>
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
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 MashouraX. All rights reserved. Built with excellence for student success.</p>
        </div>
    </footer>

    <!-- Cookie Consent -->
    <script src="cookies-loader.js"></script>

    <style>
        /* Video Wrapper Styles */
        .video-wrapper {
            position: relative;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(218, 165, 32, 0.3);
            border: 1px solid rgba(218, 165, 32, 0.2);
            background: rgba(0, 0, 0, 0.5);
        }

        .video-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem !important;
            }
            
            .video-wrapper {
                max-width: 100%;
                border-radius: 12px;
            }
        }
    </style>
</body>
</html>
