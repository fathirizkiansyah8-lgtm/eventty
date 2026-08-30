/* =========================================================
   EVENTTY — LANDING PAGE JS
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    /* ── Elements ── */
    var navbar     = document.getElementById('navbar');
    var hamburger  = document.getElementById('mobileMenuButton');
    var navMenu    = document.getElementById('navMenu');
    var navLinks   = document.querySelectorAll('.lp-nav-link');
    var sections   = document.querySelectorAll('section[id]');
    var reveals    = document.querySelectorAll('.reveal');


    /* ─────────────────────────────────────
       NAVBAR — scroll effect
    ───────────────────────────────────── */
    function handleNavScroll () {
        if (!navbar) return;
        if (window.scrollY > 30) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    window.addEventListener('scroll', handleNavScroll, { passive: true });
    handleNavScroll();


    /* ─────────────────────────────────────
       HAMBURGER — mobile menu
    ───────────────────────────────────── */
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

    /* Resize: close mobile menu on desktop */
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768 && navMenu && hamburger) {
            navMenu.classList.remove('open');
            hamburger.classList.remove('open');
        }
    });


    /* ─────────────────────────────────────
       SCROLL REVEAL
    ───────────────────────────────────── */
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


    /* ─────────────────────────────────────
       ACTIVE NAV — section tracking
    ───────────────────────────────────── */
    if (sections.length > 0 && navLinks.length > 0) {
        function updateActiveNav () {
            var scrollY = window.scrollY + 120;
            var current = '';
            sections.forEach(function (sec) {
                if (scrollY >= sec.offsetTop) {
                    current = sec.getAttribute('id');
                }
            });
            navLinks.forEach(function (link) {
                var href = link.getAttribute('href') || '';
                link.classList.toggle('active', href === '#' + current);
            });
        }
        window.addEventListener('scroll', updateActiveNav, { passive: true });
        updateActiveNav();
    }


    /* ─────────────────────────────────────
       SMOOTH SCROLL — anchor links
    ───────────────────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var id = this.getAttribute('href').substring(1);
            var target = document.getElementById(id);
            if (!target) return;
            e.preventDefault();
            var offset = navbar ? navbar.offsetHeight + 8 : 68;
            window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
        });
    });


    /* ─────────────────────────────────────
       STAGGERED REVEAL — cards
    ───────────────────────────────────── */
    var cardGrids = document.querySelectorAll('.lp-events-grid, .lp-features-grid, .lp-steps');
    cardGrids.forEach(function (grid) {
        var cards = grid.querySelectorAll('.reveal');
        cards.forEach(function (card, i) {
            card.style.transitionDelay = (i * 80) + 'ms';
        });
    });

});
