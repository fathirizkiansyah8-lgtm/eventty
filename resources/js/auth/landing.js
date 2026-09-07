/* =========================================================
   EVENTTY — LANDING PAGE JS
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    /* ── Elements ── */
    var navbar     = document.getElementById('navbar');
    var hamburger  = document.getElementById('mobileMenuButton');
    var navMenu    = document.getElementById('navMenu');
    var navLinks   = document.querySelectorAll('.lp-nav-link');
    var reveals    = document.querySelectorAll('.reveal');
    var landingPanels = document.querySelectorAll('.lp-landing-panel');

    function setActiveLandingPanel(target) {
        var panelName = target || 'home';
        var isHome = panelName === 'home';
        document.body.classList.toggle('lp-home-view', isHome);
        document.body.setAttribute('data-landing-panel', panelName);
        landingPanels.forEach(function (panel) {
            var isActive = !isHome && panel.getAttribute('data-panel') === panelName;
            panel.classList.toggle('active', isActive);
            if (isActive || isHome) {
                panel.querySelectorAll('.reveal').forEach(function (element) {
                    element.classList.add('visible');
                });
            }
        });

        navLinks.forEach(function (link) {
            var isActive = link.getAttribute('data-landing-target') === panelName;
            link.classList.toggle('active', isActive);
        });

        window.scrollTo({ top: 0, behavior: 'auto' });
    }

    function getPanelFromUrl() {
        var requestedPanel = new URLSearchParams(window.location.search).get('page') || 'home';
        return Array.from(landingPanels).some(function (panel) {
            return panel.getAttribute('data-panel') === requestedPanel;
        }) ? requestedPanel : 'home';
    }

    var initialPanel = getPanelFromUrl();
    setActiveLandingPanel(initialPanel);

    function escapeHtml(value) {
        return String(value || '').replace(/[&<>'"]/g, function (character) {
            return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' })[character];
        });
    }

    function renderLandingEvents(events) {
        var grid = document.getElementById('landingEventsGrid');
        if (!grid || !Array.isArray(events)) return;

        var today = new Date();
        today.setHours(0, 0, 0, 0);
        var upcoming = events.filter(function (event) {
            var eventDate = new Date(event.date);
            return !Number.isNaN(eventDate.getTime()) && eventDate >= today;
        });

        if (!upcoming.length) {
            grid.innerHTML = '<div class="lp-events-empty"><iconify-icon icon="solar:calendar-search-linear" width="34" height="34"></iconify-icon><strong>Belum ada event mendatang</strong><span>Event baru akan muncul di sini setelah tersedia.</span></div>';
            return;
        }

        grid.innerHTML = upcoming.slice(0, 4).map(function (event) {
            var quota = Number(event.quota) || 0;
            var registered = Number(event.registered_count) || 0;
            var percent = quota ? Math.min(100, Math.round((registered / quota) * 100)) : 0;
            var full = Boolean(event.is_full) || percent >= 100;
            return '<article class="lp-ev-card reveal visible">' +
                '<div class="lp-ev-img"><img src="' + escapeHtml(event.banner_url || '/images/seminar.png') + '" alt="' + escapeHtml(event.name) + '" loading="lazy"><span class="lp-ev-badge ' + (full ? 'hot' : 'open') + '">' + (full ? 'Penuh' : 'Buka') + '</span><span class="lp-ev-cat">' + escapeHtml(event.category || 'Event') + '</span></div>' +
                '<div class="lp-ev-body"><h3 class="lp-ev-title">' + escapeHtml(event.name) + '</h3>' +
                '<div class="lp-ev-meta"><span class="lp-ev-meta-item"><iconify-icon icon="solar:calendar-linear"></iconify-icon>' + escapeHtml(event.date) + '</span><span class="lp-ev-meta-item"><iconify-icon icon="solar:map-point-linear"></iconify-icon>' + escapeHtml(event.location) + '</span></div>' +
                '<div class="lp-ev-quota"><div class="lp-quota-bar ' + (percent >= 90 ? 'warn' : '') + '"><div style="width:' + percent + '%"></div></div><span class="lp-quota-text">' + registered + ' / ' + quota + ' peserta</span></div>' +
                '<a href="/login" class="lp-ev-btn" data-event-target="/events/public?id=' + encodeURIComponent(event.id) + '">Lihat Detail</a></div></article>';
        }).join('');
    }

    function loadLandingEvents() {
        var grid = document.getElementById('landingEventsGrid');
        if (!grid) return;
        grid.querySelectorAll('[data-event-date]').forEach(function (card) {
            var date = new Date(card.getAttribute('data-event-date'));
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            if (!Number.isNaN(date.getTime()) && date < today) card.remove();
        });
        fetch('/api/user/upcoming-events', { headers: { Accept: 'application/json' } })
            .then(function (response) { return response.ok ? response.json() : null; })
            .then(function (events) { if (Array.isArray(events) && events.length) renderLandingEvents(events); })
            .catch(function () { /* Public visitors may not have access to the authenticated feed. */ });
    }

    loadLandingEvents();

    window.addEventListener('popstate', function () {
        setActiveLandingPanel(getPanelFromUrl());
    });

    document.querySelectorAll('[data-landing-target]').forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            var target = this.getAttribute('data-landing-target');
            if (!target) return;
            e.preventDefault();
            var nextUrl = target === 'home' ? '/landing' : '/landing?page=' + encodeURIComponent(target);
            window.history.pushState({ panel: target }, '', nextUrl);
            setActiveLandingPanel(target);
        });
    });
    document.querySelectorAll('.lp-ev-btn[data-event-target]').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            var eventTarget = link.getAttribute('data-event-target');
            localStorage.setItem('eventty_login_redirect', eventTarget);
            document.body.classList.add('lp-page-leaving');
            window.setTimeout(function () {
                window.location.assign('/login');
            }, 160);
        });
    });

    function handleNavScroll () {
        if (!navbar) return;
        if (window.scrollY > 30) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    handleNavScroll();

    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function () {
            var open = navMenu.classList.toggle('open');
            hamburger.classList.toggle('open', open);
            hamburger.setAttribute('aria-expanded', String(open));
        });

        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                navMenu.classList.remove('open');
                hamburger.classList.remove('open');
                hamburger.setAttribute('aria-expanded', 'false');
            });
        });

        document.addEventListener('click', function (e) {
            if (!navMenu.contains(e.target) && !hamburger.contains(e.target)) {
                navMenu.classList.remove('open');
                hamburger.classList.remove('open');
                hamburger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth > 768 && navMenu && hamburger) {
            navMenu.classList.remove('open');
            hamburger.classList.remove('open');
        }
    });

    if ('IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
        );
        reveals.forEach(function (el) { revealObserver.observe(el); });
    } else {
        reveals.forEach(function (el) { el.classList.add('visible'); });
    }

    var cardGrids = document.querySelectorAll('.lp-events-grid, .lp-features-grid, .lp-steps');
    cardGrids.forEach(function (grid) {
        var cards = grid.querySelectorAll('.reveal');
        cards.forEach(function (card, i) {
            card.style.transitionDelay = (i * 80) + 'ms';
        });
    });

});
