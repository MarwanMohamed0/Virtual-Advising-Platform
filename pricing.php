<?php
// MashouraX Virtual Advising Platform - pricing
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
    <title>Pricing - MashouraX Virtual Advising Platform</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .pricing-section {
            padding: 180px 5% 100px;
            position: relative;
            z-index: 1;
        }

        .pricing-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 4rem;
        }

        .pricing-header .section-label {
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .pricing-header h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff, #DAA520);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .pricing-header p {
            font-size: 1.2rem;
            color: #aaa;
            line-height: 1.8;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 4rem;
        }

        .pricing-card {
            background: rgba(20, 20, 20, 0.8);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 20px;
            padding: 2.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .pricing-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #DAA520, #FFD700);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            border-color: rgba(218, 165, 32, 0.5);
            box-shadow: 0 20px 40px rgba(218, 165, 32, 0.1);
        }

        .pricing-card:hover::before {
            opacity: 1;
        }

        .pricing-card.featured {
            border-color: rgba(218, 165, 32, 0.6);
            background: rgba(30, 30, 30, 0.9);
            transform: scale(1.05);
        }

        .pricing-card.featured::before {
            opacity: 1;
        }

        .pricing-card.featured .plan-badge {
            display: block;
        }

        .plan-badge {
            display: none;
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            color: #000;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .plan-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .plan-description {
            color: #aaa;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .plan-price {
            margin-bottom: 2rem;
        }

        .price-amount {
            font-size: 3.5rem;
            font-weight: 900;
            color: #DAA520;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .price-period {
            color: #999;
            font-size: 1rem;
        }

        .plan-features {
            list-style: none;
            margin-bottom: 2rem;
        }

        .plan-features li {
            padding: 0.8rem 0;
            color: #ccc;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .plan-features li:last-child {
            border-bottom: none;
        }

        .plan-features li::before {
            content: '✓';
            color: #DAA520;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .plan-button {
            width: 100%;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            color: #000;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .plan-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(218, 165, 32, 0.3);
        }

        .plan-button.secondary {
            background: transparent;
            color: #DAA520;
            border: 2px solid #DAA520;
        }

        .plan-button.secondary:hover {
            background: rgba(218, 165, 32, 0.1);
        }

        .faq-section {
            padding: 100px 5%;
            position: relative;
            z-index: 1;
        }

        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .faq-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .faq-header p {
            color: #aaa;
            font-size: 1.1rem;
        }

        .faq-item {
            background: rgba(20, 20, 20, 0.6);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 15px;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: rgba(218, 165, 32, 0.4);
        }

        .faq-question {
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
        }

        .faq-question::after {
            content: '+';
            font-size: 1.5rem;
            color: #DAA520;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding: 0 1.5rem;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 0 1.5rem 1.5rem;
        }

        .faq-answer p {
            color: #aaa;
            line-height: 1.8;
        }

        @media (max-width: 768px) {
            .pricing-header h1 {
                font-size: 2.5rem;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .pricing-card.featured {
                transform: scale(1);
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

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-header">
            <div class="section-label">Pricing Plans</div>
            <h1>Choose the Right Plan for Your Institution</h1>
            <p>Flexible pricing options designed to scale with your needs. Start with a free trial and upgrade as you grow.</p>
        </div>

        <div class="pricing-grid">
            <!-- Starter Plan -->
            <div class="pricing-card">
                <div class="plan-name">Starter</div>
                <div class="plan-description">Perfect for small institutions getting started with virtual advising</div>
                <div class="plan-price">
                    <div class="price-amount">25,000 EGP</div>
                    <div class="price-period">per month</div>
                </div>
                <ul class="plan-features">
                    <li>Up to 1,000 students</li>
                    <li>24/7 AI chat support</li>
                    <li>Basic analytics dashboard</li>
                    <li>Email support</li>
                    <li>850+ pre-built Q&A library</li>
                    <li>Mobile app access</li>
                </ul>
                <a href="trial.php" class="plan-button secondary">Start Free Trial</a>
            </div>

            <!-- Professional Plan -->
            <div class="pricing-card featured">
                <div class="plan-badge">Most Popular</div>
                <div class="plan-name">Professional</div>
                <div class="plan-description">Ideal for mid-sized institutions requiring advanced features</div>
                <div class="plan-price">
                    <div class="price-amount">65,000 EGP</div>
                    <div class="price-period">per month</div>
                </div>
                <ul class="plan-features">
                    <li>Up to 5,000 students</li>
                    <li>24/7 AI chat support</li>
                    <li>Advanced analytics & reporting</li>
                    <li>Priority email & phone support</li>
                    <li>Custom knowledge base</li>
                    <li>Multi-language support</li>
                    <li>Integration with SIS/LMS</li>
                    <li>Dedicated account manager</li>
                </ul>
                <a href="trial.php" class="plan-button">Start Free Trial</a>
            </div>

            <!-- Enterprise Plan -->
            <div class="pricing-card">
                <div class="plan-name">Enterprise</div>
                <div class="plan-description">For large institutions with complex needs and custom requirements</div>
                <div class="plan-price">
                    <div class="price-amount">Custom</div>
                    <div class="price-period">contact us</div>
                </div>
                <ul class="plan-features">
                    <li>Unlimited students</li>
                    <li>24/7 AI chat support</li>
                    <li>Enterprise analytics & BI</li>
                    <li>24/7 dedicated support</li>
                    <li>Fully customized solution</li>
                    <li>White-label options</li>
                    <li>Advanced integrations</li>
                    <li>On-premise deployment</li>
                    <li>SLA guarantees</li>
                    <li>Training & onboarding</li>
                </ul>
                <a href="contact.php" class="plan-button secondary">Contact Sales</a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="faq-container">
            <div class="faq-header">
                <h2>Frequently Asked Questions</h2>
                <p>Everything you need to know about our pricing</p>
            </div>

            <div class="faq-item">
                <div class="faq-question">What's included in the free trial?</div>
                <div class="faq-answer">
                    <p>Our free trial includes full access to all features of the Starter plan for 14 days. No credit card required. You can upgrade, downgrade, or cancel at any time during the trial.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Can I change plans later?</div>
                <div class="faq-answer">
                    <p>Yes! You can upgrade or downgrade your plan at any time. Changes take effect immediately, and we'll prorate any charges or credits accordingly.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Are there any setup fees?</div>
                <div class="faq-answer">
                    <p>No setup fees for Starter and Professional plans. Enterprise plans may include implementation fees depending on customization requirements, which will be discussed during the sales process.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">What payment methods do you accept?</div>
                <div class="faq-answer">
                    <p>We accept all major credit cards, bank transfers, and mobile wallet payments (Vodafone Cash, Orange Money, Etisalat Cash). Enterprise customers can also set up invoicing with net-30 payment terms.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Is there a discount for annual billing?</div>
                <div class="faq-answer">
                    <p>Yes! Annual billing saves you 15% compared to monthly billing. Contact our sales team to learn more about annual pricing options.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">What happens if I exceed my student limit?</div>
                <div class="faq-answer">
                    <p>We'll notify you when you're approaching your limit. You can upgrade your plan at any time, or we can discuss custom pricing for overages. We never cut off service without notice.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Ready to Get Started?</h2>
        <p>Join thousands of institutions using MashouraX to transform student success.</p>
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

    <script>
        // FAQ Accordion functionality
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                const isActive = faqItem.classList.contains('active');
                
                // Close all FAQ items
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Open clicked item if it wasn't active
                if (!isActive) {
                    faqItem.classList.add('active');
                }
            });
        });
    </script>
    <script src="cookies-loader.js"></script>
</body>
</html>

