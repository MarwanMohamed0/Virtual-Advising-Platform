// Global Search Functionality for MashouraX
(function(){
    // All pages in the site with their metadata
    const allPages = [
        {title:'Home', url:'index.html', tags:['home','features','security','ai','platform','mashourax']},
        {title:'About Us', url:'about.html', tags:['about','company','team','who we are']},
        {title:'AI Features', url:'ai-features.html', tags:['ai','features','artificial','intelligence','chatbot']},
        {title:'Analytics Dashboard', url:'analytics-dashboard.html', tags:['analytics','dashboard','data','metrics','reporting']},
        {title:'Case Studies', url:'case-studies.html', tags:['case','studies','trusted','universities','success stories']},
        {title:'Contact', url:'contact.html', tags:['contact','support','reach','get in touch']},
        {title:'Demo', url:'demo.html', tags:['demo','video','showcase','product demo']},
        {title:'Documentation', url:'documentation.html', tags:['docs','guide','api','setup','help']},
        {title:'Help Center', url:'help-center.html', tags:['help','support','contact','faq','troubleshooting']},
        {title:'Login', url:'login.html', tags:['login','signin','access','account']},
        {title:'Mobile App', url:'mobile.html', tags:['mobile','app','ios','android','smartphone']},
        {title:'Privacy Policy', url:'privacy.html', tags:['privacy','policy','legal','data protection']},
        {title:'Sign Up', url:'signup.html', tags:['signup','register','create','new account']},
        {title:'Solutions - Academic Planning', url:'solutions-academic-planning.html', tags:['solutions','academic','planning','curriculum','courses']},
        {title:'Solutions - Career Services', url:'solutions-career-services.html', tags:['solutions','career','services','jobs','employment']},
        {title:'Solutions - Student Success', url:'solutions-student-success.html', tags:['solutions','student','success','retention','outcomes']},
        {title:'Solutions - Virtual Advising', url:'solutions-virtual-advising.html', tags:['solutions','virtual','advising','counseling','guidance']},
        {title:'Trial', url:'trial.html', tags:['trial','free','start','demo','test']},
        {title:'Webinars', url:'webinars.html', tags:['webinars','events','sessions','talks','training']}
    ];

    function initializeSearch() {
        const overlay = document.getElementById('searchOverlay');
        const input = document.getElementById('globalSearchInput');
        const results = document.getElementById('globalSearchResults');
        const openBtn = document.querySelector('.search-btn');
        const closeBtn = document.getElementById('closeSearchBtn');

        if (!overlay || !input || !results) return;

        function openSearch() {
            overlay.style.display = 'flex';
            overlay.setAttribute('aria-hidden', 'false');
            setTimeout(() => {
                if (input) input.focus();
            }, 10);
            renderResults('');
        }

        function closeSearch() {
            overlay.style.display = 'none';
            overlay.setAttribute('aria-hidden', 'true');
        }

        function renderResults(query) {
            const q = (query || '').toLowerCase().trim();
            let items = [];

            // Search through all pages
            allPages.forEach(page => {
                const searchText = (page.title + ' ' + page.tags.join(' ')).toLowerCase();
                if (!q || searchText.includes(q)) {
                    items.push({
                        html: `<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
                            <div>
                                <span style="color:#DAA520;font-size:0.8rem;margin-right:0.5rem;">Page</span>
                                ${page.title}
                            </div>
                            <a class="secondary-btn" href="${page.url}">Open</a>
                        </div>`,
                        url: page.url
                    });
                }
            });

            // Search current page content if query exists
            if (q) {
                const contentElements = document.querySelectorAll('h1, h2, h3, h4, h5, h6, p, li, span');
                contentElements.forEach(element => {
                    const text = (element.textContent || '').trim();
                    if (text && text.toLowerCase().includes(q) && text.length > 10) {
                        items.push({
                            html: `<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
                                <div>
                                    <span style="color:#DAA520;font-size:0.8rem;margin-right:0.5rem;">This page</span>
                                    ${text.substring(0, 120)}${text.length > 120 ? '...' : ''}
                                </div>
                                <button class="secondary-btn" data-scroll="1">View</button>
                            </div>`,
                            scrollTo: element
                        });
                    }
                });
            }

            // Display results
            if (!items.length) {
                results.innerHTML = '<div style="color:#aaa;">No results found. Try different keywords or check the page list above.</div>';
            } else {
                results.innerHTML = items.map(item => 
                    `<div style="padding:0.8rem;background:rgba(255,255,255,0.02);border:1px solid rgba(218,165,32,0.15);border-radius:10px;margin-bottom:0.5rem;">
                        ${item.html}
                    </div>`
                ).join('');

                // Add scroll functionality for current page results
                const scrollButtons = results.querySelectorAll('[data-scroll]');
                const scrollTargets = items.filter(item => item.scrollTo).map(item => item.scrollTo);
                scrollButtons.forEach((button, index) => {
                    const target = scrollTargets[index];
                    if (target) {
                        button.addEventListener('click', function() {
                            target.scrollIntoView({behavior: 'smooth', block: 'center'});
                            closeSearch();
                        });
                    }
                });
            }
        }

        // Event listeners
        if (openBtn) {
            openBtn.addEventListener('click', openSearch);
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', closeSearch);
        }
        if (input) {
            input.addEventListener('input', function() {
                renderResults(input.value);
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                openSearch();
            }
            if (e.key === 'Escape') {
                closeSearch();
            }
        });

        // Close on overlay click
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeSearch();
            }
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSearch);
    } else {
        initializeSearch();
    }
})();
