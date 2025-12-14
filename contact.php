<?php
// MashouraX Virtual Advising Platform - contact
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
    <title>MashouraX - Contact Us</title>
    <link rel="stylesheet" href="index.css">
    <style>

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
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .contact-section {
            position: relative;
            padding: 4rem 5% 8rem;
            z-index: 1;
        }

        .contact-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
        }

        .contact-info h2 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .contact-info p {
            color: #aaa;
            font-size: 1.15rem;
            line-height: 1.8;
            margin-bottom: 3rem;
        }

        .contact-methods {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .contact-method {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .contact-method:hover {
            border-color: #DAA520;
            transform: translateY(-5px);
        }

        .contact-method-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .contact-method h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .contact-method p {
            color: #DAA520;
            font-size: 1.1rem;
            margin: 0;
        }

        .contact-form {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 25px;
            padding: 3rem;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.8rem;
            color: #fff;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 10px;
            color: #fff;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #DAA520;
            background: rgba(255, 255, 255, 0.08);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            color: #000;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(218, 165, 32, 0.5);
        }

        .map-section {
            position: relative;
            padding: 8rem 5%;
            z-index: 1;
            background: rgba(218, 165, 32, 0.02);
        }

        .map-container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 25px;
            padding: 3rem;
            text-align: center;
        }

        .map-placeholder {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 8rem;
            margin-top: 2rem;
        }

        .map-placeholder p {
            color: #666;
            font-size: 1.2rem;
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
            .contact-container {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 3.5rem;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            .footer-content {
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

    <section class="hero">
        <div class="hero-badge">
            <span>💬</span> Get In Touch
        </div>
        <h1>We'd Love to Hear From You</h1>
        <p>Have questions about MashouraX? Our team is here to help. Reach out to us and we'll respond as soon as possible.</p>
    </section>

    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-info">
                <h2>Contact Information</h2>
                <p>Get in touch with our team for support, sales inquiries, or partnership opportunities.</p>
                
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="contact-method-icon">📧</div>
                        <h3>Email Us</h3>
                        <p>support@mashourax.com</p>
                    </div>
                    
                    <div class="contact-method">
                        <div class="contact-method-icon">📞</div>
                        <h3>Call Us</h3>
                        <p>+1 (555) 123-4567</p>
                    </div>
                    
                    <div class="contact-method">
                        <div class="contact-method-icon">📍</div>
                        <h3>Visit Us</h3>
                        <p>Cairo, Egypt</p>
                    </div>
                    
                    <div class="contact-method">
                        <div class="contact-method-icon">⏰</div>
                        <h3>Business Hours</h3>
                        <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <form id="contactForm">
                    <div id="formMessage" style="display: none; padding: 1rem; margin-bottom: 1.5rem; border-radius: 10px; text-align: center;"></div>
                    
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="full_name" id="full_name" required placeholder="Enter your full name">
                    </div>
                    
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" id="email" required placeholder="Enter your email">
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" id="phone" placeholder="Enter your phone number">
                    </div>
                    
                    <div class="form-group">
                        <label>Subject *</label>
                        <select name="subject" id="subject" required>
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="sales">Sales</option>
                            <option value="support">Technical Support</option>
                            <option value="partnership">Partnership</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Message *</label>
                        <textarea name="message" id="message" required placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn" id="submitBtn">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <section class="map-section">
        <div class="map-container">
            <h2 style="font-size: 3rem; margin-bottom: 1rem; color: #fff;">Find Us</h2>
            <p style="color: #aaa; font-size: 1.15rem;">Located in the heart of Cairo, Egypt</p>
            <div class="map-placeholder">
                <p>🗺️ Obour</p>
            </div>
        </div>
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

    <script>
        document.getElementById('contactForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = document.getElementById('submitBtn');
            const messageDiv = document.getElementById('formMessage');
            const originalBtnText = submitBtn.textContent;
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            messageDiv.style.display = 'none';
            
            // Get form data
            const formData = {
                full_name: document.getElementById('full_name').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                subject: document.getElementById('subject').value,
                message: document.getElementById('message').value.trim()
            };
            
            try {
                const response = await fetch('backend/api/index.php/contact/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success message
                    messageDiv.style.display = 'block';
                    messageDiv.style.background = 'rgba(34, 197, 94, 0.1)';
                    messageDiv.style.border = '1px solid rgba(34, 197, 94, 0.3)';
                    messageDiv.style.color = '#22c55e';
                    messageDiv.textContent = 'Thank you! Your message has been sent successfully. We\'ll get back to you soon.';
                    
                    // Reset form
                    form.reset();
                } else {
                    // Show error message
                    messageDiv.style.display = 'block';
                    messageDiv.style.background = 'rgba(239, 68, 68, 0.1)';
                    messageDiv.style.border = '1px solid rgba(239, 68, 68, 0.3)';
                    messageDiv.style.color = '#ef4444';
                    messageDiv.textContent = data.message || 'Failed to send message. Please try again.';
                }
            } catch (error) {
                // Show error message
                messageDiv.style.display = 'block';
                messageDiv.style.background = 'rgba(239, 68, 68, 0.1)';
                messageDiv.style.border = '1px solid rgba(239, 68, 68, 0.3)';
                messageDiv.style.color = '#ef4444';
                messageDiv.textContent = 'Network error. Please check your connection and try again.';
                console.error('Error:', error);
            } finally {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
                
                // Scroll to message
                messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    </script>
</body>
</html>
