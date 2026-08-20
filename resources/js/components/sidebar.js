document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarLinks = document.querySelectorAll('.sidebar-link');

    // Toggle sidebar on mobile
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            // On mobile, we need to recreate the overlay if it doesn't exist
            if (window.innerWidth <= 1024) {
                let overlay = document.getElementById('sidebarOverlay');
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.id = 'sidebarOverlay';
                    overlay.className = 'sidebar-overlay';
                    document.body.appendChild(overlay);
                    // Add click handler
                    overlay.addEventListener('click', function() {
                        sidebar.classList.remove('open');
                        overlay.style.display = 'none';
                    });
                }
                overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
            }
        });
    }

    // Handle sidebar link clicks
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            sidebarLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');

            // Close sidebar on mobile after clicking
            if (window.innerWidth <= 1024) {
                sidebar.classList.remove('open');
                const overlay = document.getElementById('sidebarOverlay');
                if (overlay) {
                    overlay.style.display = 'none';
                }
            }
        });
    });

    // Handle sidebar link based on current URL
    const currentPath = window.location.pathname;
    sidebarLinks.forEach(link => {
        const linkPath = new URL(link.href).pathname;
        if (currentPath === linkPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
            link.classList.add('active');
        }
    });

    // Handle window resize - remove overlay on desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            const overlay = document.getElementById('sidebarOverlay');
            if (overlay) {
                overlay.remove();
            }
        }
    });
});
