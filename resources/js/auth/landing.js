document.addEventListener("DOMContentLoaded", () => {

    /* =====================================================
       ELEMENTS
       ===================================================== */

    const navbar = document.getElementById("navbar");
    const mobileMenuButton =
        document.getElementById("mobileMenuButton");
    const navMenu =
        document.getElementById("navMenu");

    const navLinks =
        document.querySelectorAll(".nav-link");

    const revealElements =
        document.querySelectorAll(".reveal");


    /* =====================================================
       NAVBAR SCROLL EFFECT
       ===================================================== */

    const handleNavbarScroll = () => {

        if (!navbar) {
            return;
        }

        if (window.scrollY > 20) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    };

    window.addEventListener(
        "scroll",
        handleNavbarScroll,
        { passive: true }
    );

    handleNavbarScroll();


    /* =====================================================
       MOBILE MENU
       ===================================================== */

    if (mobileMenuButton && navMenu) {

        mobileMenuButton.addEventListener(
            "click",
            () => {

                const isOpen =
                    navMenu.classList.toggle("open");

                mobileMenuButton.classList.toggle(
                    "active",
                    isOpen
                );

                mobileMenuButton.setAttribute(
                    "aria-expanded",
                    String(isOpen)
                );
            }
        );


        /* Close menu after clicking a link */

        navLinks.forEach((link) => {

            link.addEventListener(
                "click",
                () => {

                    navMenu.classList.remove("open");

                    mobileMenuButton.classList.remove(
                        "active"
                    );

                    mobileMenuButton.setAttribute(
                        "aria-expanded",
                        "false"
                    );
                }
            );

        });


        /* Close when clicking outside */

        document.addEventListener(
            "click",
            (event) => {

                const clickedInsideMenu =
                    navMenu.contains(event.target);

                const clickedButton =
                    mobileMenuButton.contains(event.target);

                if (
                    !clickedInsideMenu &&
                    !clickedButton
                ) {

                    navMenu.classList.remove("open");

                    mobileMenuButton.classList.remove(
                        "active"
                    );

                    mobileMenuButton.setAttribute(
                        "aria-expanded",
                        "false"
                    );
                }
            }
        );

    }


    /* =====================================================
       SCROLL REVEAL
       ===================================================== */

    if ("IntersectionObserver" in window) {

        const observer =
            new IntersectionObserver(
                (entries, observerInstance) => {

                    entries.forEach((entry) => {

                        if (!entry.isIntersecting) {
                            return;
                        }

                        entry.target.classList.add(
                            "visible"
                        );

                        observerInstance.unobserve(
                            entry.target
                        );

                    });

                },
                {
                    threshold: 0.12,
                    rootMargin: "0px 0px -40px 0px"
                }
            );


        revealElements.forEach((element) => {
            observer.observe(element);
        });

    } else {

        revealElements.forEach((element) => {
            element.classList.add("visible");
        });

    }


    /* =====================================================
       ACTIVE NAVIGATION
       ===================================================== */

    const sections =
        document.querySelectorAll("section[id]");

    if (
        sections.length > 0 &&
        navLinks.length > 0
    ) {

        const updateActiveNavigation = () => {

            const scrollPosition =
                window.scrollY + 150;

            let currentSection = "";

            sections.forEach((section) => {

                const sectionTop =
                    section.offsetTop;

                const sectionHeight =
                    section.offsetHeight;

                if (
                    scrollPosition >= sectionTop &&
                    scrollPosition <
                        sectionTop + sectionHeight
                ) {
                    currentSection =
                        section.getAttribute("id");
                }

            });


            navLinks.forEach((link) => {

                const href =
                    link.getAttribute("href");

                link.classList.toggle(
                    "active",
                    href === `#${currentSection}`
                );

            });

        };


        window.addEventListener(
            "scroll",
            updateActiveNavigation,
            { passive: true }
        );

        updateActiveNavigation();

    }


    /* =====================================================
       SMOOTH SCROLL
       ===================================================== */

    document
        .querySelectorAll('a[href^="#"]')
        .forEach((anchor) => {

            anchor.addEventListener(
                "click",
                (event) => {

                    const targetId =
                        anchor
                            .getAttribute("href")
                            .substring(1);

                    const target =
                        document.getElementById(
                            targetId
                        );

                    if (!target) {
                        return;
                    }

                    event.preventDefault();

                    const navbarHeight =
                        navbar
                            ? navbar.offsetHeight
                            : 0;

                    const targetPosition =
                        target.offsetTop -
                        navbarHeight -
                        15;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: "smooth"
                    });

                }
            );

        });


    /* =====================================================
       RESIZE
       ===================================================== */

    window.addEventListener(
        "resize",
        () => {

            if (
                window.innerWidth > 720 &&
                navMenu &&
                mobileMenuButton
            ) {

                navMenu.classList.remove("open");

                mobileMenuButton.classList.remove(
                    "active"
                );

                mobileMenuButton.setAttribute(
                    "aria-expanded",
                    "false"
                );

            }

        }
    );

});


/* ── Events section filter ── */
document.addEventListener('DOMContentLoaded', function () {
    var filterBtns = document.querySelectorAll('.ev-filter-btn');
    var eventCards = document.querySelectorAll('.pub-event-card');
    if (!filterBtns.length) return;
    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var filter = btn.getAttribute('data-filter');
            filterBtns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            eventCards.forEach(function (card) {
                if (filter === 'all' || card.getAttribute('data-category') === filter) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });
});
