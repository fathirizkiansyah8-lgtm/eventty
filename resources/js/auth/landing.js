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

    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';

    function setActiveLandingPanel(target) {
        var panelName = target || 'home';
        document.body.setAttribute('data-landing-panel', panelName);
        landingPanels.forEach(function (panel) {
            var isActive = panel.getAttribute('data-panel') === panelName;
            panel.classList.toggle('active', isActive);
            if (isActive) {
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

    var initialPanel = window.location.hash.replace('#', '') || 'home';
    setActiveLandingPanel(initialPanel);

    document.querySelectorAll('[data-landing-target]').forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            var target = this.getAttribute('data-landing-target');
            if (!target) return;
            e.preventDefault();
            setActiveLandingPanel(target);
        });
    });
    document.querySelectorAll('.lp-ev-btn[href^="/events/public"]').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            var destination = link.href;
            document.body.classList.add('lp-page-leaving');
            window.setTimeout(function () {
                window.location.assign(destination);
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
