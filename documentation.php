<?php
// MashouraX Virtual Advising Platform - documentation
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation - MashouraX</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="bg-animation"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

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
            </li>
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
            <div class="section-label">Resources</div>
            <h2 class="section-title">Documentation</h2>
            <p class="section-description">Get started quickly with setup guides, API references, and admin docs.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">⚙️</div>
                <h3>Getting Started</h3>
                <p>Onboarding steps for institutions and admins to launch MashouraX successfully.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔌</div>
                <h3>Integrations</h3>
                <p>Connect SIS/LMS systems and configure secure data flows with best practices.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3>API Reference</h3>
                <p>Endpoints and schemas for custom workflows and advanced automations.</p>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="section-header">
            <div class="section-label">Setup Guides</div>
            <h2 class="section-title">Get Started Quickly</h2>
            <p class="section-description">Follow these steps to launch MashouraX in your environment.</p>
        </div>
        <div class="features-grid" style="max-width:1200px;">
            <div class="feature-card">
                <div class="feature-icon">✅</div>
                <h3>Provision</h3>
                <ul class="support-features">
                    <li>Create tenant and primary admin</li>
                    <li>Verify institutional email domain</li>
                    <li>Set base URL and regional settings</li>
                </ul>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔐</div>
                <h3>Authentication</h3>
                <ul class="support-features">
                    <li>Enable SSO (SAML2 / OIDC) or local accounts</li>
                    <li>Enforce MFA and password policy</li>
                    <li>Invite advisors and staff</li>
                </ul>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔗</div>
                <h3>Integrations</h3>
                <ul class="support-features">
                    <li>Connect SIS/LMS with secure API keys</li>
                    <li>Schedule nightly sync and roster imports</li>
                    <li>Map student attributes and cohorts</li>
                </ul>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3>Launch</h3>
                <ul class="support-features">
                    <li>Publish chatbot widget to portal</li>
                    <li>Enable knowledge packs and analytics</li>
                    <li>Announce rollout to students and staff</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="section-header">
            <div class="section-label">API Reference</div>
            <h2 class="section-title">Key Endpoints</h2>
            <p class="section-description">Use Bearer tokens. All endpoints are JSON over HTTPS.</p>
        </div>
        <div class="features-grid" style="max-width:1200px;grid-template-columns:1fr 1fr;">
            <div class="feature-card">
                <div class="feature-icon">GET</div>
                <h3>/api/v1/health</h3>
                <p>Basic health check.</p>
                <pre style="margin-top:1rem;background:rgba(0,0,0,0.5);padding:1rem;border-radius:10px;overflow:auto;">curl -s https://your-domain.edu/api/v1/health</pre>
            </div>
            <div class="feature-card">
                <div class="feature-icon">POST</div>
                <h3>/api/v1/messages</h3>
                <p>Create a support message.</p>
                <pre style="margin-top:1rem;background:rgba(0,0,0,0.5);padding:1rem;border-radius:10px;overflow:auto;">curl -X POST https://your-domain.edu/api/v1/messages
-H "Authorization: Bearer YOUR_TOKEN"
-H "Content-Type: application/json"
-d '{
  "studentId": "S12345",
  "text": "I need help with financial aid"
}'</pre>
            </div>
            <div class="feature-card" style="grid-column:1 / -1;">
                <div class="feature-icon">🔔</div>
                <h3>Webhooks</h3>
                <p>Receive event callbacks (message.created, student.flagged). Each request is signed with HMAC SHA-256.</p>
                <pre style="margin-top:1rem;background:rgba(0,0,0,0.5);padding:1rem;border-radius:10px;overflow:auto;">POST https://your-server.edu/hooks/mashourax
Headers:
  X-Signature: t=1690000000,v1=hex-hmac
Body:
  { "event": "message.created", "id": "evt_123", ... }</pre>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="section-header">
            <div class="section-label">Admin Docs</div>
            <h2 class="section-title">Operate With Confidence</h2>
            <p class="section-description">Guidance for administrators on roles, security, and reporting.</p>
        </div>
        <div class="features-grid" style="max-width:1200px;">
            <div class="feature-card">
                <div class="feature-icon">👤</div>
                <h3>Roles &amp; Permissions</h3>
                <ul class="support-features">
                    <li>Admin: full system configuration</li>
                    <li>Advisor: student insights and messaging</li>
                    <li>Analyst: read-only analytics</li>
                </ul>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Security</h3>
                <ul class="support-features">
                    <li>Rotate API tokens every 90 days</li>
                    <li>Enforce MFA for all staff accounts</li>
                    <li>Review audit logs weekly</li>
                </ul>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📈</div>
                <h3>Reporting</h3>
                <ul class="support-features">
                    <li>Export metrics to CSV or S3</li>
                    <li>Schedule weekly retention reports</li>
                    <li>Create custom dashboards</li>
                </ul>
            </div>
        </div>
    </section>

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
                    <li><a href="index.php#">Virtual Advising</a></li>
                    <li><a href="index.php#">Student Success</a></li>
                    <li><a href="index.php#">Academic Planning</a></li>
                    <li><a href="index.php#">Career Services</a></li>
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
            function openSearch(){ if(!overlay) return; overlay.style.display='flex'; overlay.setAttribute('aria-hidden','false'); setTimeout(function(){ input&&input.focus();},10); renderResults(''); }
            function closeSearch(){ overlay.style.display='none'; overlay.setAttribute('aria-hidden','true'); }
            function renderResults(q){
                var pages=[
                    {title:'Case Studies', url:'case-studies.php', tags:['case','studies','trusted','universities']},
                    {title:'Documentation', url:'documentation.php', tags:['docs','guide','api','setup']},
                    {title:'Webinars', url:'webinars.php', tags:['events','sessions','talks']},
                    {title:'Help Center', url:'help-center.php', tags:['help','support','contact']}
                ];
                q=(q||'').toLowerCase(); var items=[];
                pages.forEach(function(p){var hay=(p.title+' '+p.tags.join(' ')).toLowerCase(); if(!q||hay.includes(q)){items.push({html:'<div style=\"display:flex;align-items:center;justify-content:space-between;gap:1rem;\"><div><span style=\"color:#DAA520;font-size:0.8rem;margin-right:0.5rem;\">Page</span>'+p.title+'</div><a class=\"secondary-btn\" href=\"'+p.url+'\">Open</a></div>'});}});
                if(q){ Array.from(document.querySelectorAll('h1,h2,h3,p,li')).forEach(function(n){ var t=(n.textContent||'').trim(); if(t && t.toLowerCase().includes(q)){ items.push({html:'<div style=\"display:flex;align-items:center;justify-content:space-between;gap:1rem;\"><div><span style=\"color:#DAA520;font-size:0.8rem;margin-right:0.5rem;\">This page</span>'+t.substring(0,120)+'</div><button class=\"secondary-btn\" data-scroll=\"1\">View</button></div>', scrollTo:n}); }}); }
                if(!items.length){ results.innerHTML='<div style=\"color:#aaa;\">No results. Try keywords like \"case\", \"docs\", \"webinars\", or \"help\".</div>'; }
                else { results.innerHTML=items.map(function(it){return '<div style=\"padding:0.8rem;background:rgba(255,255,255,0.02);border:1px solid rgba(218,165,32,0.15);border-radius:10px;\">'+it.php+'</div>';}).join('');
                    var btns=Array.from(results.querySelectorAll('[data-scroll]')); var targets=items.filter(function(i){return i.scrollTo;}).map(function(i){return i.scrollTo;});
                    btns.forEach(function(b,i){ var t=targets[i]; b&&b.addEventListener('click', function(){ t&&t.scrollIntoView({behavior:'smooth', block:'center'}); closeSearch(); }); }); }
            }
            if(openBtn){ openBtn.addEventListener('click', openSearch); }
            if(closeBtn){ closeBtn.addEventListener('click', closeSearch); }
            document.addEventListener('keydown', function(e){ if((e.ctrlKey||e.metaKey)&&e.key.toLowerCase()==='k'){ e.preventDefault(); openSearch(); } if(e.key==='Escape'){ closeSearch(); } });
            if(input){ input.addEventListener('input', function(){ renderResults(input.value); }); }
        })();
    </script>
</body>
</html>


