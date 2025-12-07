<?php
// MashouraX Virtual Advising Platform - index
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
    <title>MashouraX - Virtual Advising Platform</title>
    <link rel="stylesheet" href="index.css">
    <style>
        /* Fallback styles in case external CSS fails */
        body { 
            background: #000 !important; 
            color: #fff !important; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }
        .hero { 
            min-height: 100vh !important; 
            display: flex !important; 
            align-items: center !important; 
            justify-content: center !important;
            padding: 140px 5% 0 !important;
        }
        .hero h1 { 
            font-size: 4.5rem !important; 
            color: #fff !important; 
            margin-bottom: 1.5rem !important;
        }
        .hero p { 
            color: #aaa !important; 
            font-size: 1.25rem !important; 
            margin-bottom: 2.5rem !important;
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

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-left">
            <div class="top-bar-item">
                <span>📧</span> support@mashourax.com
            </div>
            <div class="top-bar-item">
                <span>📞</span> +20 (012) 707 23373
            </div>
        </div>
        <div class="top-bar-right">
            <a href="about.html" class="top-bar-link">About</a>
            <a href="#" class="top-bar-link">Blog</a>
            <a href="#" class="top-bar-link">Careers</a>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav>
        <div class="logo"><a href="index.html">MashouraX</a></div>
        <ul class="nav-center">
            <li class="nav-item">
                <a href="#solutions">Solutions ▾</a>
                <div class="dropdown">
                    <a href="solutions-virtual-advising.html">Virtual Advising</a>
                    <a href="solutions-student-success.html">Student Success</a>
                    <a href="solutions-academic-planning.html">Academic Planning</a>
                    <a href="solutions-career-services.html">Career Services</a>
                </div>
            </li>
           
            <li class="nav-item">
                <a href="#features">Features ▾</a>
                <div class="dropdown">
                    <a href="ai-features.html">AI-Powered Support</a>
                    <a href="analytics-dashboard.html">Analytics Dashboard</a>
                    <a href="chat-support.php">24/7 Chat Support</a>
                    <a href="mobile.html">Mobile App</a>
                </div>
           
            </li> 
            <li class="nav-item">
                <a href="#resources">Resources ▾</a>
                <div class="dropdown">
                    <a href="case-studies.html">Case Studies</a>
                    <a href="documentation.html">Documentation</a>
                    <a href="webinars.html">Webinars</a>
                    <a href="help-center.html">Help Center</a>
                </div>
            </li>
            
           
            <li class="nav-item">
                <a href="#pricing">Pricing</a>
            </li>
            <li class="nav-item">
                <a href="#security">Security</a>
            </li>
        </ul>
        <div class="nav-right">
            <button class="search-btn">🔍 Search</button>
            <button class="login-btn" onclick="window.location.href='login.html'">Login</button>
            <button class="demo-btn" onclick="window.location.href='demo.html'">Request Demo</button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-badge">
                    <span>✨</span> 24/7 AI-Powered Virtual Advising
                </div>
                <h1>Transform Your Academic Journey</h1>
                <p>Combine AI-powered automation with personalized guidance to create student-specific conversations proven to increase enrollment and degree completion. Experience support that never sleeps.</p>
                <div class="hero-buttons">
                    <button class="primary-btn" onclick="window.location.href='trial.php'">Start Free Trial →</button>
                    <button class="secondary-btn" onclick="window.location.href='demo.php'">Watch Demo</button>
                </div>
            </div>
            <div class="hero-right">
                <div class="hero-visual">
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <h3>98%</h3>
                            <p>Satisfaction Rate</p>
                        </div>
                        <div class="hero-stat">
                            <h3>24/7</h3>
                            <p>Support Available</p>
                        </div>
                        <div class="hero-stat">
                            <h3>10K+</h3>
                            <p>Active Students</p>
                        </div>
                        <div class="hero-stat">
                            <h3>850+</h3>
                            <p>AI Questions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="trust-section">
        <div class="trust-content">
            <p>Trusted by Leading Institutions Worldwide</p>
            <div class="trust-logos">
                <div class="trust-logo">MIU</div>
                <div class="trust-logo">ST.FATIMA</div>
                <div class="trust-logo">OXFORD</div>
                <div class="trust-logo">HARVARD</div>
            </div>
        </div>
    </section>

    <!-- AI Section -->
    <section class="ai-section">
        <div class="ai-container">
            <div class="ai-content">
                <div class="ai-subtitle">AI-Powered Student Support</div>
                <h2>Experience the Power of Machine Learning</h2>
                <p>From a library of 850+ vetted questions, MashouraX continually improves the quality of answers and stays compliant with evolving regulatory updates. Our advanced AI adapts to each student's unique needs.</p>
                <button class="primary-btn" onclick="window.location.href='ai-features.php'">Explore AI Features →</button>
            </div>
            <div class="ai-visual">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-header">
            <div class="section-label">Powerful Features</div>
            <h2 class="section-title">Everything You Need for Student Success</h2>
            <p class="section-description">Comprehensive tools designed to enhance student engagement, streamline advising processes, and drive measurable outcomes.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>Instant Support</h3>
                <p>Deploy MashouraX to answer common and repetitive student questions instantly, providing consistent 24/7 support across your institution.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Smart Analytics</h3>
                <p>Track student engagement, identify at-risk students, and make data-driven decisions to improve retention and completion rates.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✉️</div>
                <h3>Personalized Outreach</h3>
                <p>Craft outbound email campaigns to engage prospective and current students with timely, personalized messages that drive action.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Degree Planning</h3>
                <p>Guide students to degree completion with intelligent course recommendations and milestone tracking tailored to individual goals.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <h3>Seamless Integration</h3>
                <p>Connect with your existing SIS, LMS, and administrative systems for a unified experience across all platforms.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Mobile First</h3>
                <p>Students can access advising support anywhere, anytime on any device with our responsive mobile-optimized interface.</p>
            </div>
        </div>
    </section>

    <!-- Security Section -->
    <section class="security-section" id="security">
        <div class="security-container">
            <div class="section-header">
                <div class="section-label">Security & Compliance</div>
                <h2 class="section-title">Enterprise-Grade Security You Can Trust</h2>
                <p class="section-description">Your data protection is our top priority. We implement industry-leading security measures to keep student information safe and ensure full regulatory compliance.</p>
            </div>
            <div class="security-grid">
                <div class="security-item">
                    <div class="security-icon">🔒</div>
                    <h4>End-to-End Encryption</h4>
                    <p>All data is encrypted in transit and at rest using industry-standard AES-256 encryption protocols.</p>
                </div>
                <div class="security-item">
                    <div class="security-icon">✓</div>
                    <h4>FERPA Compliant</h4>
                    <p>Fully compliant with FERPA regulations to protect student education records and privacy.</p>
                </div>
                <div class="security-item">
                    <div class="security-icon">🛡️</div>
                    <h4>SOC 2 Type II</h4>
                    <p>Certified SOC 2 Type II compliant, ensuring the highest standards of data security and availability.</p>
                </div>
                <div class="security-item">
                    <div class="security-icon">👤</div>
                    <h4>Role-Based Access</h4>
                    <p>Granular permission controls ensure users only access information relevant to their role.</p>
                </div>
                <div class="security-item">
                    <div class="security-icon">🔍</div>
                    <h4>Audit Logging</h4>
                    <p>Comprehensive audit trails track all system activities for complete transparency and accountability.</p>
                </div>
                <div class="security-item">
                    <div class="security-icon">🌐</div>
                    <h4>GDPR Ready</h4>
                    <p>Built with global privacy standards in mind, including GDPR compliance for international institutions.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="stats">
        <div class="section-header">
            <div class="section-label">By The Numbers</div>
            <h2 class="section-title">Key Stats On Student Expectations</h2>
        </div>
        <div class="stats-grid">
            <div class="stat-item">
                <h2>67%</h2>
                <p>Find aid offers unclear</p>
            </div>
            <div class="stat-item">
                <h2>45%</h2>
                <p>Switch if aid takes 4 weeks</p>
            </div>
            <div class="stat-item">
                <h2>82%</h2>
                <p>Want 24/7 virtual help</p>
            </div>
            <div class="stat-item">
                <h2>95%</h2>
                <p>Completion rate increase</p>
            </div>
        </div>
    </section>

    
    <section class="support-section">
        <div class="support-container">
            <div class="support-visual">
            </div>
            <div class="support-content">
                <div class="ai-subtitle">Student Success</div>
                <h2>Guide Students to Degree Completion</h2>
                <p>Support students throughout their journey while driving enrollment and retention with intelligent, proactive guidance tailored to their unique path.</p>
                <ul class="support-features">
                    <li>Automated milestone tracking and reminders</li>
                    <li>Personalized course recommendations</li>
                    <li>Financial aid guidance and support</li>
                    <li>Career planning and advising</li>
                    <li>Real-time progress monitoring</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Ready to Transform Student Success?</h2>
        <p>Join thousands of institutions using MashouraX to provide exceptional 24/7 student support and drive better outcomes.</p>
        <div class="hero-buttons">
            <button class="primary-btn">Start Free Trial →</button>
            <button class="secondary-btn">Schedule a Demo</button>
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
    <div class="search-overlay" id="searchOverlay" aria-hidden="true" style="display:none;position:fixed;inset:0;z-index:2000;align-items:center;justify-content:center;background:rgba(0,0,0,0.7);backdrop-filter:blur(6px);">
        <div class="search-panel" role="dialog" aria-modal="true" aria-labelledby="searchTitle" style="width:min(900px,92vw);background:rgba(0,0,0,0.95);border:1px solid rgba(218,165,32,0.2);border-radius:14px;padding:1rem 1rem 1.2rem;">
            <div class="search-header" style="display:flex;gap:0.6rem;align-items:center;margin-bottom:0.8rem;">
                <input id="globalSearchInput" class="search-input" placeholder="Search pages or this page..." style="flex:1;padding:0.9rem 1rem;background:transparent;color:#fff;border:1px solid rgba(218,165,32,0.35);border-radius:10px;outline:none;" />
                <button class="secondary-btn" id="closeSearchBtn">Close</button>
            </div>
            <div class="search-results" id="globalSearchResults" style="max-height:55vh;overflow:auto;display:grid;gap:0.8rem;"></div>
        </div>
    </div>
    <script>
        (function(){
            var overlay = document.getElementById('searchOverlay');
            var input = document.getElementById('globalSearchInput');
            var results = document.getElementById('globalSearchResults');
            var openBtn = document.querySelector('.search-btn');
            var closeBtn = document.getElementById('closeSearchBtn');

            function openSearch(){
                if(!overlay) return;
                overlay.style.display = 'flex';
                overlay.setAttribute('aria-hidden','false');
                setTimeout(function(){ input && input.focus(); }, 10);
                renderResults('');
            }
            function closeSearch(){
                overlay.style.display = 'none';
                overlay.setAttribute('aria-hidden','true');
            }
            function renderResults(q){
                var pages = [
                    {title:'Case Studies', url:'case-studies.php', tags:['case','studies','trusted','universities']},
                    {title:'Documentation', url:'documentation.php', tags:['docs','guide','api','setup']},
                    {title:'Webinars', url:'webinars.php', tags:['events','sessions','talks']},
                    {title:'Help Center', url:'help-center.php', tags:['help','support','contact']},
                    {title:'Home', url:'index.php', tags:['home','features','security']}
                ];
                q = (q||'').toLowerCase();
                var items = [];
                pages.forEach(function(p){
                    var hay = (p.title+' '+p.tags.join(' ')).toLowerCase();
                    if(!q || hay.includes(q)){
                        items.push({html:'<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;"><div><span style="color:#DAA520;font-size:0.8rem;margin-right:0.5rem;">Page</span>'+p.title+'</div><a class="secondary-btn" href="'+p.url+'">Open</a></div>'});
                    }
                });
                if(q){
                    var nodes = Array.from(document.querySelectorAll('h1,h2,h3,p,li'));
                    nodes.forEach(function(n){
                        var t = (n.textContent||'').trim();
                        if(t && t.toLowerCase().includes(q)){
                            items.push({html:'<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;"><div><span style="color:#DAA520;font-size:0.8rem;margin-right:0.5rem;">This page</span>'+t.substring(0,120)+'</div><button class="secondary-btn" data-scroll="1">View</button></div>', scrollTo: n});
                        }
                    });
                }
                if(!items.length){
                    results.innerHTML = '<div style="color:#aaa;">No results. Try keywords like "case", "docs", "webinars", or "help".</div>';
                } else {
                    results.innerHTML = items.map(function(it){ return '<div style="padding:0.8rem;background:rgba(255,255,255,0.02);border:1px solid rgba(218,165,32,0.15);border-radius:10px;">'+it.php+'</div>'; }).join('');
                    var scrollBtns = Array.from(results.querySelectorAll('[data-scroll]'));
                    var scrollTargets = items.filter(function(i){return i.scrollTo;}).map(function(i){return i.scrollTo;});
                    scrollBtns.forEach(function(btn, idx){
                        var target = scrollTargets[idx];
                        btn && btn.addEventListener('click', function(){ target && target.scrollIntoView({behavior:'smooth', block:'center'}); closeSearch(); });
                    });
                }
            }
            if(openBtn){ openBtn.addEventListener('click', openSearch); }
            if(closeBtn){ closeBtn.addEventListener('click', closeSearch); }
            document.addEventListener('keydown', function(e){
                if((e.ctrlKey||e.metaKey) && e.key.toLowerCase()==='k'){ e.preventDefault(); openSearch(); }
                if(e.key==='Escape'){ closeSearch(); }
            });
            if(input){ input.addEventListener('input', function(){ renderResults(input.value); }); }
        })();
    </script>
    <script src="cookies-loader.js"></script> 
</body>
</html>
