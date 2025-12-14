<?php
// MashouraX Virtual Advising Platform - help-center
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center - MashouraX</title>
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

    <section class="features" style="padding-top: 180px;">
        <div class="section-header">
            <div class="section-label">Resources</div>
            <h2 class="section-title">Help Center</h2>
            <p class="section-description">Find answers to common questions, or get in touch with our team.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">❓</div>
                <h3>FAQs</h3>
                <p>Quick answers for students and staff using MashouraX daily.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛠️</div>
                <h3>Troubleshooting</h3>
                <p>Guides to resolve common issues and optimize performance.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧑‍💼</div>
                <h3>Contact Support</h3>
                <p>Need help? Reach out to our support team 24/7 for assistance.</p>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="section-header">
            <div class="section-label">Contact</div>
            <h2 class="section-title">Send Us a Message</h2>
            <p class="section-description">Reach our support team for help or advising. We typically respond within one business day.</p>
        </div>

        <div class="features-grid" style="max-width:900px;grid-template-columns:1fr;">
            <div class="feature-card contact-card">
                <form action="mailto:support@mashourax.com" method="post" enctype="text/plain">
                    <div style="display:grid;gap:1rem;">
                        <input type="text" name="Name" placeholder="Your name" required 
                               style="padding:1rem;background:transparent;color:#fff;border:1px solid rgba(218,165,32,0.3);border-radius:10px;outline:none;"/>
                        <input type="email" name="Email" placeholder="Your email" required 
                               style="padding:1rem;background:transparent;color:#fff;border:1px solid rgba(218,165,32,0.3);border-radius:10px;outline:none;"/>
                        <input type="text" name="Subject" placeholder="Subject" required 
                               style="padding:1rem;background:transparent;color:#fff;border:1px solid rgba(218,165,32,0.3);border-radius:10px;outline:none;"/>
                        <textarea name="Message" placeholder="How can we help?" rows="6" required 
                                  style="padding:1rem;background:transparent;color:#fff;border:1px solid rgba(218,165,32,0.3);border-radius:10px;outline:none;resize:vertical;"></textarea>
                        <div style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
                            <button type="submit" class="primary-btn">Send Message →</button>
                            <a href="mailto:support@mashourax.com" class="secondary-btn" style="text-decoration:none;display:inline-block;">Email Us Directly</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        (function(){
            var form = document.querySelector('section.features form');
            if (!form) return;
            form.addEventListener('submit', function(e){
                e.preventDefault();
                var data = new FormData(form);
                var name = (data.get('Name') || '').toString().trim();
                var email = (data.get('Email') || '').toString().trim();
                var subject = (data.get('Subject') || 'Support Request').toString().trim();
                var message = (data.get('Message') || '').toString().trim();

                var emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                if (!name || !emailOk || !subject) {
                    alert('Please enter a valid name, email, and subject.');
                    return;
                }

                var body = 'Name: ' + name + '\n' +
                           'Email: ' + email + '\n\n' +
                           message;
                var mailto = 'mailto:support@mashourax.com' +
                             '?subject=' + encodeURIComponent(subject) +
                             '&body=' + encodeURIComponent(body);
                window.location.href = mailto;
            });
        })();
    </script>

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


