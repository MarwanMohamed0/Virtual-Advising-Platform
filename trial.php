<?php
// MashouraX Virtual Advising Platform - trial
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MashouraX - Start Your Free Trial</title>
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
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            color: #fff;
        }

        .hero p {
            font-size: 1.25rem;
            color: #aaa;
            margin-bottom: 3rem;
            line-height: 1.8;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .pricing-section {
            position: relative;
            padding: 4rem 5% 8rem;
            z-index: 1;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .pricing-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 25px;
            padding: 3rem 2.5rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .pricing-card.featured {
            border: 2px solid #DAA520;
            transform: scale(1.05);
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            border-color: #DAA520;
            box-shadow: 0 25px 60px rgba(218, 165, 32, 0.2);
        }

        .pricing-card.featured:hover {
            transform: scale(1.05) translateY(-10px);
        }

        .popular-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            color: #000;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .plan-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1rem;
        }

        .plan-description {
            color: #999;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .plan-price {
            display: flex;
            align-items: baseline;
            margin-bottom: 2rem;
        }

        .currency {
            font-size: 1.5rem;
            color: #DAA520;
            margin-right: 0.3rem;
        }

        .price {
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .period {
            font-size: 1rem;
            color: #666;
            margin-left: 0.5rem;
        }

        .trial-info {
            background: rgba(218, 165, 32, 0.1);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
            text-align: center;
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .select-btn {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            color: #000;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .select-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(218, 165, 32, 0.5);
        }

        .select-btn.secondary {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(218, 165, 32, 0.5);
        }

        .select-btn.secondary:hover {
            background: rgba(218, 165, 32, 0.1);
            border-color: #DAA520;
        }

        .features-list {
            list-style: none;
        }

        .features-list li {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #ccc;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .features-list li::before {
            content: '✓';
            color: #DAA520;
            font-weight: bold;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .features-list li.unavailable {
            color: #555;
        }

        .features-list li.unavailable::before {
            content: '✗';
            color: #555;
        }

        .trial-benefits {
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

        .section-label {
            color: #DAA520;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
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

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .benefit-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            text-align: center;
            transition: all 0.4s ease;
        }

        .benefit-card:hover {
            transform: translateY(-10px);
            border-color: #DAA520;
            box-shadow: 0 20px 60px rgba(218, 165, 32, 0.15);
        }

        .benefit-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }

        .benefit-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .benefit-card p {
            color: #aaa;
            line-height: 1.7;
        }

        .faq-section {
            position: relative;
            padding: 8rem 5%;
            z-index: 1;
        }

        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .faq-item {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 15px;
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: #DAA520;
        }

        .faq-question {
            padding: 1.8rem 2rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.15rem;
            font-weight: 600;
            color: #fff;
        }

        .faq-question::after {
            content: '+';
            font-size: 2rem;
            color: #DAA520;
            transition: transform 0.3s ease;
        }

        .faq-question.active::after {
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-answer.active {
            max-height: 500px;
        }

        .faq-answer-content {
            padding: 0 2rem 1.8rem;
            color: #aaa;
            line-height: 1.8;
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
            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .pricing-card.featured {
                transform: scale(1);
            }

            h1 {
                font-size: 3rem;
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
            <li class="nav-item"><a href="#pricing">Pricing</a></li>
            <li class="nav-item"><a href="#features">Features</a></li>
            <li class="nav-item"><a href="#faq">FAQ</a></li>
        </ul>
        <div class="nav-right">
            <button class="search-btn">🔍 Search</button>
            <button class="login-btn">Login</button>
            <button class="demo-btn">Request Demo</button>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-badge">
            <span>🎉</span> Start Your 30-Day Free Trial Today
        </div>
        <h1>Choose Your Perfect Plan</h1>
        <p>Experience the full power of MashouraX with our 30-day free trial. No credit card required. Cancel anytime.</p>
    </section>

    <section class="pricing-section" id="pricing">
        <div class="pricing-grid">
            <div class="pricing-card">
                <div class="plan-name">Basic</div>
                <div class="plan-description">Perfect for small institutions getting started</div>
                <div class="plan-price">
                    <span class="currency">EGP</span>
                    <span class="price">2,999</span>
                    <span class="period">/month</span>
                </div>
                <div class="trial-info">✨ 30-Day Free Trial Included</div>
                <button class="select-btn secondary">Start Free Trial</button>
                <ul class="features-list">
                    <li>Up to 500 students</li>
                    <li>Basic AI chatbot support</li>
                    <li>Email support</li>
                    <li>5 advisor accounts</li>
                    <li>Basic analytics dashboard</li>
                    <li>Mobile app access</li>
                    <li class="unavailable">Advanced AI recommendations</li>
                    <li class="unavailable">Custom integrations</li>
                    <li class="unavailable">Priority support</li>
                </ul>
            </div>

            <div class="pricing-card featured">
                <div class="popular-badge">Most Popular</div>
                <div class="plan-name">Professional</div>
                <div class="plan-description">Ideal for growing institutions</div>
                <div class="plan-price">
                    <span class="currency">EGP</span>
                    <span class="price">5,999</span>
                    <span class="period">/month</span>
                </div>
                <div class="trial-info">✨ 30-Day Free Trial Included</div>
                <button class="select-btn">Start Free Trial</button>
                <ul class="features-list">
                    <li>Up to 2,000 students</li>
                    <li>Advanced AI chatbot with ML</li>
                    <li>Priority email & chat support</li>
                    <li>20 advisor accounts</li>
                    <li>Advanced analytics & reporting</li>
                    <li>Mobile app access</li>
                    <li>AI-powered recommendations</li>
                    <li>Custom email campaigns</li>
                    <li>SIS/LMS integrations</li>
                    <li>Training webinars</li>
                    <li class="unavailable">Dedicated account manager</li>
                </ul>
            </div>

            <div class="pricing-card">
                <div class="plan-name">Enterprise</div>
                <div class="plan-description">Complete solution for large institutions</div>
                <div class="plan-price">
                    <span class="currency">EGP</span>
                    <span class="price">12,999</span>
                    <span class="period">/month</span>
                </div>
                <div class="trial-info">✨ 30-Day Free Trial Included</div>
                <button class="select-btn secondary">Start Free Trial</button>
                <ul class="features-list">
                    <li>Unlimited students</li>
                    <li>Enterprise AI with custom training</li>
                    <li>24/7 priority support</li>
                    <li>Unlimited advisor accounts</li>
                    <li>Enterprise analytics suite</li>
                    <li>Mobile app access</li>
                    <li>Advanced AI recommendations</li>
                    <li>Custom integrations</li>
                    <li>Dedicated account manager</li>
                    <li>Custom development</li>
                    <li>White-label options</li>
                    <li>SLA guarantees</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="trial-benefits" id="features">
        <div class="section-header">
            <div class="section-label">Trial Benefits</div>
            <h2 class="section-title">What's Included in Your Free Trial</h2>
            <p class="section-description">Experience all premium features risk-free for 30 days.</p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">🎯</div>
                <h3>Full Feature Access</h3>
                <p>Get complete access to all features of your selected plan.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">💳</div>
                <h3>No Credit Card Required</h3>
                <p>Start your trial immediately without payment information.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">📊</div>
                <h3>Live Data & Analytics</h3>
                <p>Work with real data and see actual results from day one.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">👨‍💼</div>
                <h3>Dedicated Onboarding</h3>
                <p>Get personalized setup assistance from our expert team.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">🔄</div>
                <h3>Easy Cancellation</h3>
                <p>Cancel anytime during the trial with no questions asked.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">📚</div>
                <h3>Training Resources</h3>
                <p>Access our complete library of tutorials and documentation.</p>
            </div>
        </div>
    </section>

    <section class="faq-section" id="faq">
        <div class="section-header">
            <div class="section-label">FAQ</div>
            <h2 class="section-title">Frequently Asked Questions</h2>
        </div>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question" onclick="this.classList.toggle('active'); this.nextElementSibling.classList.toggle('active')">
                    How does the 30-day free trial work?
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Start using MashouraX immediately with full access to all features. No credit card required. After 30 days, choose to subscribe or your account expires with no charges.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="this.classList.toggle('active'); this.nextElementSibling.classList.toggle('active')">
                    Can I switch plans during the trial?
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Yes! You can upgrade or downgrade your plan at any time during the trial period.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="this.classList.toggle('active'); this.nextElementSibling.classList.toggle('active')">
                    What payment methods do you accept?
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        We accept all major credit cards, PayPal, and bank transfers for Egyptian customers.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="this.classList.toggle('active'); this.nextElementSibling.classList.toggle('active')">
                    Is there a setup fee?
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        No! There are no setup fees for any of our plans. You only pay the monthly subscription.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="this.classList.toggle('active'); this.nextElementSibling.classList.toggle('active')">
                    Can I cancel my subscription?
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Yes, you can cancel your subscription at any time. No long-term contracts or cancellation fees.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <h3>MashouraX</h3>
                <p>Empowering institutions with AI-powered virtual advising.</p>
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
                </ul>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <ul class="footer-links">
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Case Studies</a></li>
                    <li><a href="#">Help Center</a></li>
                </ul>
