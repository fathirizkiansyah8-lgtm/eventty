<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - Eventty</title>
    
    <!-- Logout Confirmation Modal -->
    <div class="modal-overlay" id="logoutModal" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
        <div class="logout-modal">
            <div class="logout-modal-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </div>
            <div class="modal-header">
                <h3 class="modal-title" id="logoutModalTitle">Konfirmasi Keluar</h3>
            </div>
            <div class="modal-body">
                <p>
                    Apakah Anda yakin ingin keluar dari akun Admin? Anda akan diarahkan kembali ke halaman login.
                </p>
            </div>
            <div class="modal-footer logout-modal-actions">
                <button type="button" class="btn-logout-cancel" id="cancelLogoutBtn">Batal</button>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout-confirm">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/components/header.css',
        'resources/css/admin/announcements.css'
    ])
</head>

<body>
    <!-- Mobile Sidebar Toggle -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar admin-sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Eventy Logo" class="sidebar-logo">
            <span class="sidebar-brand">Eventty</span>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section">
                <div class="sidebar-section-title">Menu Utama</div>
                
                <a href="{{ url('/admin/dashboard') }}" class="sidebar-link">
                    <span class="sidebar-link-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ url('/admin/events') }}" class="sidebar-link">
                    <span class="sidebar-link-icon">🎉</span>
                    <span>Kelola Event</span>
                </a>
                
                <a href="{{ url('/admin/participants') }}" class="sidebar-link">
                    <span class="sidebar-link-icon">👥</span>
                    <span>Peserta</span>
                </a>
                
                <a href="{{ url('/admin/attendance') }}" class="sidebar-link">
                    <span class="sidebar-link-icon">✅</span>
                    <span>Kehadiran</span>
                </a>
                
                <a href="{{ url('/admin/certificates') }}" class="sidebar-link">
                    <span class="sidebar-link-icon">🏆</span>
                    <span>Sertifikat</span>
                </a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Pengelolaan</div>
                
                <a href="{{ url('/admin/announcements') }}" class="sidebar-link active">
                    <span class="sidebar-link-icon">📢</span>
                    <span>Pengumuman</span>
                </a>
                
                <a href="{{ url('/admin/students') }}" class="sidebar-link">
                    <span class="sidebar-link-icon">🎓</span>
                    <span>Data Siswa</span>
                </a>
            </div>

            
        </nav>

        </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <div class="header-greeting">
                    <span class="header-greeting-text">Selamat datang,</span>
                    <span class="header-user-name">Admin OSIS 👋</span>
                </div>
            </div>

            <div class="header-right">
                <div class="header-actions">
                    <button class="header-action-btn" id="notificationBtn" aria-label="Notifikasi">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span class="notification-badge">5</span>
                    </button>

                    <div class="header-profile" id="profileBtn">
                        <div class="avatar avatar-sm">
                            <span>A</span>
                        </div>
                        <div class="header-profile-info">
                            <span class="header-profile-name">Admin</span>
                            <span class="header-profile-role">OSIS</span>
                        </div>
                    </div>
                </div>

                <!-- Notification Dropdown -->
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">
                        <span class="notification-title">Notifikasi</span>
                        <span class="notification-mark-all">Tandai semua dibaca</span>
                    </div>
                    <div class="notification-list">
                        <div class="notification-item unread">
                            <div class="notification-content">
                                <div class="notification-icon">📝</div>
                                <div class="notification-text">
                                    <div class="notification-message">Pendaftaran baru untuk Career Day</div>
                                    <div class="notification-time">5 menit yang lalu</div>
                                </div>
                            </div>
                        </div>
                        <div class="notification-item unread">
                            <div class="notification-content">
                                <div class="notification-icon">⚠️</div>
                                <div class="notification-text">
                                    <div class="notification-message">Kuota Workshop hampir penuh</div>
                                    <div class="notification-time">30 menit yang lalu</div>
                                </div>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-content">
                                <div class="notification-icon">✅</div>
                                <div class="notification-text">
                                    <div class="notification-message">Event Seminar berhasil dibuat</div>
                                    <div class="notification-time">1 jam yang lalu</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="notification-footer">
                        <span class="notification-view-all">Lihat semua notifikasi</span>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="profile-dropdown" id="profileDropdown">
                    <a href="{{ url('/admin/settings') }}" class="profile-dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                    <div class="profile-dropdown-divider"></div>
                    <button type="button" id="headerLogoutBtn" class="profile-dropdown-item danger" style="display:flex; align-items:center; gap:0.75rem; width:100%; border:none; background:none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Announcements Content -->
        <div class="announcements-content">
            <div class="section-header">
                <h1 class="section-title">Pengumuman</h1>
                <button class="btn btn-primary" id="createAnnouncementBtn">+ Buat Pengumuman</button>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter-bar">
                <div class="search-box">
                    <input type="text" class="input-field" id="searchInput" placeholder="Cari pengumuman...">
                </div>
                <div class="filter-box">
                    <select class="input-field" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Announcements List -->
            <div class="announcements-list">
                <div class="announcement-card">
                    <div class="announcement-header">
                        <h3 class="announcement-title">Event Baru Akan Segera Dibuka</h3>
                        <div class="announcement-status">
                            <span class="badge badge-success">Active</span>
                        </div>
                    </div>
                    <div class="announcement-content">
                        <p>Siapkan diri Anda untuk event baru yang akan segera dibuka. Event ini akan memberikan pengalaman yang menarik dan bermanfaat bagi semua siswa.</p>
                    </div>
                    <div class="announcement-footer">
                        <div class="announcement-meta">
                            <span class="announcement-date">10 August 2026</span>
                            <span class="announcement-target">Target: Semua Siswa</span>
                        </div>
                        <div class="announcement-actions">
                            <button class="btn btn-outline btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </div>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-header">
                        <h3 class="announcement-title">Perubahan Jadwal Workshop</h3>
                        <div class="announcement-status">
                            <span class="badge badge-success">Active</span>
                        </div>
                    </div>
                    <div class="announcement-content">
                        <p>Jadwal Workshop Programming telah berubah. Event baru akan diadakan pada 25 August 2026 di Lab Komputer. Mohon perhatikan perubahan ini.</p>
                    </div>
                    <div class="announcement-footer">
                        <div class="announcement-meta">
                            <span class="announcement-date">8 August 2026</span>
                            <span class="announcement-target">Target: Peserta Workshop</span>
                        </div>
                        <div class="announcement-actions">
                            <button class="btn btn-outline btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </div>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-header">
                        <h3 class="announcement-title">Selamat Datang di Eventy</h3>
                        <div class="announcement-status">
                            <span class="badge badge-secondary">Inactive</span>
                        </div>
                    </div>
                    <div class="announcement-content">
                        <p>Selamat datang di platform Eventy. Platform ini dirancang untuk memudahkan pengelolaan event sekolah. Silakan explore fitur-fitur yang tersedia.</p>
                    </div>
                    <div class="announcement-footer">
                        <div class="announcement-meta">
                            <span class="announcement-date">1 August 2026</span>
                            <span class="announcement-target">Target: Semua Pengguna</span>
                        </div>
                        <div class="announcement-actions">
                            <button class="btn btn-outline btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Announcement Modal -->
    <div class="modal-overlay" id="createAnnouncementModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Buat Pengumuman</h3>
                <button class="modal-close" id="closeCreateModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="createAnnouncementForm">
                    <div class="input-group">
                        <label class="input-label" for="announcementTitle">Judul *</label>
                        <input type="text" id="announcementTitle" class="input-field" placeholder="Masukkan judul pengumuman" required>
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="announcementContent">Isi *</label>
                        <textarea id="announcementContent" class="input-field" rows="4" placeholder="Masukkan isi pengumuman" required></textarea>
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="announcementTarget">Target</label>
                        <select id="announcementTarget" class="input-field">
                            <option value="all">Semua Pengguna</option>
                            <option value="students">Semua Siswa</option>
                            <option value="participants">Peserta Event</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="announcementDate">Tanggal</label>
                        <input type="date" id="announcementDate" class="input-field">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="announcementStatus">Status</label>
                        <select id="announcementStatus" class="input-field">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelCreateBtn">Batal</button>
                <button class="btn btn-primary" id="saveAnnouncementBtn">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal-overlay" id="logoutModal" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
        <div class="logout-modal">
            <div class="logout-modal-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </div>
            <div class="modal-header">
                <h3 class="modal-title" id="logoutModalTitle">Konfirmasi Keluar</h3>
            </div>
            <div class="modal-body">
                <p>
                    Apakah Anda yakin ingin keluar dari akun Admin? Anda akan diarahkan kembali ke halaman login.
                </p>
            </div>
            <div class="modal-footer logout-modal-actions">
                <button type="button" class="btn-logout-cancel" id="cancelLogoutBtn">Batal</button>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout-confirm">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    @vite([
        'resources/js/components/sidebar.js',
        'resources/js/components/header.js',
        'resources/js/admin/announcements.js'
    ])
</body>
</html>