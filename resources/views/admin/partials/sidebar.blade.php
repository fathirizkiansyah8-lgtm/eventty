{{--
    Admin Sidebar — digunakan di semua halaman admin.
    Param: $activePage = 'dashboard' | 'events' | 'participants' | 'attendance'
                       | 'certificates' | 'messages' | 'announcements' | 'students' | 'settings'
--}}
<aside class="sidebar admin-sidebar" id="sidebar">

    <div class="sidebar-header">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Eventty Logo" class="sidebar-logo">
        <div>
            <div class="sidebar-brand">Eventty</div>
            <div class="admin-sidebar-sub">Admin Panel</div>
        </div>
    </div>

    <nav class="sidebar-nav">

        {{-- ── MENU UTAMA ── --}}
        <div class="sidebar-section">
            <div class="sidebar-section-title">Menu Utama</div>

            <a href="{{ url('/admin/dashboard') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'dashboard' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                        <iconify-icon icon="solar:widget-2-linear"></iconify-icon>
                </span>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/admin/events') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'events' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                        <iconify-icon icon="solar:calendar-linear"></iconify-icon>
                </span>
                <span>Kelola Event</span>
            </a>

            <a href="{{ url('/admin/participants') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'participants' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                        <iconify-icon icon="solar:users-group-rounded-linear"></iconify-icon>
                </span>
                <span>Peserta</span>
            </a>

            <a href="{{ url('/admin/attendance') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'attendance' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                        <iconify-icon icon="solar:check-circle-linear"></iconify-icon>
                </span>
                <span>Kehadiran</span>
            </a>

            <a href="{{ url('/admin/certificates') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'certificates' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                        <iconify-icon icon="solar:medal-ribbons-star-linear"></iconify-icon>
                </span>
                <span>Sertifikat</span>
            </a>

            <a href="{{ url('/admin/messages') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'messages' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                        <iconify-icon icon="solar:chat-round-dots-linear"></iconify-icon>
                </span>
                <span>Messages</span>
            </a>
        </div>

        {{-- ── PENGELOLAAN ── --}}
        <div class="sidebar-section">
            <div class="sidebar-section-title">Pengelolaan</div>

            <a href="{{ url('/admin/announcements') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'announcements' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                        <iconify-icon icon="solar:bell-linear"></iconify-icon>
                </span>
                <span>Pengumuman</span>
            </a>

            <a href="{{ url('/admin/students') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'students' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                        <iconify-icon icon="lucide:graduation-cap"></iconify-icon>
                </span>
                <span>Data Siswa</span>
            </a>
        </div>

        {{-- ── AKUN ── --}}
        <div class="sidebar-section">
            <div class="sidebar-section-title">Akun</div>

            <a href="{{ url('/admin/settings') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'settings' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                        <iconify-icon icon="solar:settings-linear"></iconify-icon>
                </span>
                <span>Pengaturan</span>
            </a>
        </div>

    </nav>

    <div class="admin-sidebar-footer">
        © 2025 Eventty Admin
    </div>

</aside>
