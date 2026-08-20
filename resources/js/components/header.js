document.addEventListener('DOMContentLoaded', function () {
    // 1. Logika Theme Toggle (Terang / Gelap)
    const themeToggle = document.getElementById('themeToggle');
    const sunIcon = document.querySelector('.sun-icon');
    const moonIcon = document.querySelector('.moon-icon');

    // Cek tema yang tersimpan sebelumnya
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.body.setAttribute('data-theme', savedTheme);
    updateThemeIcons(savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            const currentTheme = document.body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcons(newTheme);
        });
    }

    function updateThemeIcons(theme) {
        if (sunIcon && moonIcon) {
            if (theme === 'dark') {
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            } else {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            }
        }
    }

    // 2. Logika Dropdown Notifikasi
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');

    if (notificationBtn && notificationDropdown) {
        notificationBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            // Tutup profile dropdown jika terbuka
            const profileDropdownEl = document.getElementById('profileDropdown');
            if (profileDropdownEl) profileDropdownEl.classList.remove('active');
            notificationDropdown.classList.toggle('active');
        });

        document.addEventListener('click', function (e) {
            if (!notificationDropdown.contains(e.target) && !notificationBtn.contains(e.target)) {
                notificationDropdown.classList.remove('active');
            }
        });

        notificationDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    // 3. Logika Dropdown Profil
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            // Tutup notification dropdown jika terbuka
            if (notificationDropdown) notificationDropdown.classList.remove('active');
            profileDropdown.classList.toggle('active');
        });

        // Tutup dropdown jika klik di luar area
        document.addEventListener('click', function (e) {
            if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
                profileDropdown.classList.remove('active');
            }
        });

        // Jangan tutup dropdown ketika klik di dalam elemen dropdown
        profileDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    // 4. Logika Tombol Keluar & Modal Logout (Diperbarui agar lebih aman)
    const headerLogoutBtn = document.getElementById('headerLogoutBtn');
    const logoutModal = document.getElementById('logoutModal');
    const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');

    if (headerLogoutBtn) {
        headerLogoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Tutup dropdown jika ada
            if (profileDropdown) {
                profileDropdown.classList.remove('active');
            }
            
            // Tampilkan modal konfirmasi logout
            const modal = document.getElementById('logoutModal') || logoutModal;
            if (modal) {
                modal.classList.add('active');
            } else {
                console.error('Elemen logoutModal tidak ditemukan di HTML!');
            }
        });
    }

    if (cancelLogoutBtn) {
        cancelLogoutBtn.addEventListener('click', function () {
            const modal = document.getElementById('logoutModal') || logoutModal;
            if (modal) {
                modal.classList.remove('active');
            }
        });
    }

    // 5. Logika Modal Pendaftaran Event (Form per Jurusan)
    const eventRegModal = document.getElementById('eventRegistrationModal');
    const cancelRegBtn = document.getElementById('cancelRegBtn');
    const regButtons = document.querySelectorAll('.btn-trigger-register');

    regButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const eventTitle = this.getAttribute('data-event-title') || 'Event';
            const eventDate  = this.getAttribute('data-event-date')  || 'Jadwal sesuai agenda';

            // Set judul di header form
            const titleEl = document.getElementById('eventRegistrationTitle');
            const dateEl  = document.getElementById('regFormEventDate');
            const nameEl  = document.getElementById('regEventNameInput');

            if (titleEl) titleEl.textContent = eventTitle;
            if (dateEl)  dateEl.textContent  = '📅 ' + eventDate;
            if (nameEl)  nameEl.value        = eventTitle;

            // Reset pilihan kelas & jurusan setiap buka form
            const kelasEl   = document.getElementById('regKelas');
            const jurusanEl = document.getElementById('regJurusan');
            const slotEl    = document.getElementById('slotStatus');
            if (kelasEl)   kelasEl.value = '';
            if (jurusanEl) { jurusanEl.innerHTML = '<option value="">-- Pilih Kelas dulu --</option>'; }
            if (slotEl)    slotEl.style.display = 'none';

            // Refresh dropdown setelah event name di-set (agar cek slot pakai nama yg benar)
            if (typeof updateJurusanOptions === 'function') updateJurusanOptions();

            if (eventRegModal) {
                eventRegModal.classList.add('active');
            }
        });
    });

    if (cancelRegBtn && eventRegModal) {
        cancelRegBtn.addEventListener('click', function () {
            eventRegModal.classList.remove('active');
        });
    }

    // Tutup modal jika klik di luar area modal (overlay) atau tekan tombol Escape
    document.addEventListener('click', function (e) {
        const modal = document.getElementById('logoutModal');
        if (modal && e.target === modal) {
            modal.classList.remove('active');
        }
        if (eventRegModal && e.target === eventRegModal) {
            eventRegModal.classList.remove('active');
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('logoutModal');
            if (modal && modal.classList.contains('active')) {
                modal.classList.remove('active');
            }
            if (eventRegModal && eventRegModal.classList.contains('active')) {
                eventRegModal.classList.remove('active');
            }
        }
    });
});

