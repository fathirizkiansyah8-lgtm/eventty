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
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </span>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/admin/events') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'events' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </span>
                <span>Kelola Event</span>
            </a>

            <a href="{{ url('/admin/participants') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'participants' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </span>
                <span>Peserta</span>
            </a>

            <a href="{{ url('/admin/attendance') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'attendance' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </span>
                <span>Kehadiran</span>
            </a>

            <a href="{{ url('/admin/certificates') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'certificates' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="7"/>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                    </svg>
                </span>
                <span>Sertifikat</span>
            </a>

            <a href="{{ url('/admin/messages') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'messages' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </span>
                <span>Messages</span>
                <span class="admin-badge-pill">3</span>
            </a>
        </div>

        {{-- ── PENGELOLAAN ── --}}
        <div class="sidebar-section">
            <div class="sidebar-section-title">Pengelolaan</div>

            <a href="{{ url('/admin/announcements') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'announcements' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3z"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </span>
                <span>Pengumuman</span>
            </a>

            <a href="{{ url('/admin/students') }}"
               class="sidebar-link {{ ($activePage ?? '') === 'students' ? 'active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
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
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                </span>
                <span>Pengaturan</span>
            </a>
        </div>

    </nav>

    <div class="admin-sidebar-footer">
        © 2025 Eventty Admin
    </div>

</aside>
