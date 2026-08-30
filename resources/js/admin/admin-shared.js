/* =========================================================
   EVENTTY — ADMIN SHARED JS
   Handles dropdowns, logout modal, sidebar toggle
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    /* ── Theme (apply immediately) ── */
    (function () {
        var t = localStorage.getItem('theme') || 'light';
        document.body.setAttribute('data-theme', t);
    })();

    /* ── Notification dropdown ── */
    var notifBtn      = document.getElementById('notifBtn');
    var notifDropdown = document.getElementById('notifDropdown');
    var profileBtn    = document.getElementById('profileBtn');
    var profileDrop   = document.getElementById('profileDropdown');

    function closeAllDropdowns() {
        if (notifDropdown) notifDropdown.classList.remove('active');
        if (profileDrop)   profileDrop.classList.remove('active');
    }

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = notifDropdown.classList.contains('active');
            closeAllDropdowns();
            if (!isOpen) notifDropdown.classList.add('active');
        });
    }

    if (profileBtn && profileDrop) {
        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = profileDrop.classList.contains('active');
            closeAllDropdowns();
            if (!isOpen) profileDrop.classList.add('active');
        });
    }

    document.addEventListener('click', function () {
        closeAllDropdowns();
    });

    /* prevent close when clicking inside dropdown */
    [notifDropdown, profileDrop].forEach(function (el) {
        if (el) el.addEventListener('click', function (e) { e.stopPropagation(); });
    });

    /* ── Logout modal ── */
    var logoutModal    = document.getElementById('logoutModal');
    var headerLogout   = document.getElementById('headerLogoutBtn');
    var cancelLogout   = document.getElementById('cancelLogoutBtn');

    if (headerLogout && logoutModal) {
        headerLogout.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            closeAllDropdowns();
            logoutModal.classList.add('active');
        });
    }

    if (cancelLogout && logoutModal) {
        cancelLogout.addEventListener('click', function () {
            logoutModal.classList.remove('active');
        });
    }

    if (logoutModal) {
        logoutModal.addEventListener('click', function (e) {
            if (e.target === logoutModal) logoutModal.classList.remove('active');
        });
    }

    /* ── Sidebar toggle (mobile) ── */
    var sidebarToggle  = document.getElementById('sidebarToggle');
    var sidebar        = document.getElementById('sidebar');
    var sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('active');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function () {
            if (sidebar) sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
        });
    }

    /* ── Escape key ── */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
            if (logoutModal) logoutModal.classList.remove('active');
        }
    });

});
