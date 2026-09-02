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

    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';

    function redirectToLoginIfNeeded(event) {
        var targetUrl = event.currentTarget.getAttribute('data-redirect') || '/events/public?id=1';
        var isLoggedIn = localStorage.getItem('eventty_logged_in') === 'true';

        if (!isLoggedIn) {
            localStorage.setItem('eventty_login_redirect', targetUrl);
            window.location.href = '/login';
            return false;
        }

        window.location.href = targetUrl;
        return false;
    }

    document.querySelectorAll('[data-require-login="true"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            redirectToLoginIfNeeded(e);
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
            link.addEventListener('click', function (e) {
                if (link.getAttribute('data-require-login') === 'true') {
                    if (localStorage.getItem('eventty_logged_in') !== 'true') {
                        e.preventDefault();
                        localStorage.setItem('eventty_login_redirect', link.getAttribute('data-redirect') || '/events/public?id=1');
                        window.location.href = '/login';
                        return;
                    }
                }
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
