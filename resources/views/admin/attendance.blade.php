<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran - Eventty</title>
    
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
        'resources/css/admin/attendance.css'
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
                
                <a href="{{ url('/admin/attendance') }}" class="sidebar-link active">
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
                
                <a href="{{ url('/admin/announcements') }}" class="sidebar-link">
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

        <!-- Attendance Content -->
        <div class="attendance-content">
            <div class="section-header">
                <h1 class="section-title">Kehadiran</h1>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter-bar">
                <div class="search-box">
                    <input type="text" class="input-field" id="searchInput" placeholder="Cari peserta...">
                </div>
                <div class="filter-box">
                    <select class="input-field" id="eventFilter">
                        <option value="">Semua Event</option>
                        <option value="career-day">Career Day</option>
                        <option value="workshop-programming">Workshop Programming</option>
                        <option value="lomba-design">Lomba Design</option>
                        <option value="seminar-pendidikan">Seminar Pendidikan</option>
                    </select>
                    <select class="input-field" id="attendanceFilter">
                        <option value="">Semua Status</option>
                        <option value="present">Hadir</option>
                        <option value="absent">Tidak Hadir</option>
                        <option value="pending">Belum Dicek</option>
                    </select>
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Event</th>
                            <th>Status Kehadiran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Fathi</td>
                            <td>12345</td>
                            <td>XII IPA 1</td>
                            <td>Career Day</td>
                            <td><span class="badge badge-warning">Belum Dicek</span></td>
                            <td>
                                <div class="attendance-actions">
                                    <button class="btn btn-success btn-sm attendance-btn" data-status="present">✓ Hadir</button>
                                    <button class="btn btn-danger btn-sm attendance-btn" data-status="absent">✗ Tidak</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Ahmad</td>
                            <td>12346</td>
                            <td>XII IPA 2</td>
                            <td>Workshop Programming</td>
                            <td><span class="badge badge-success">Hadir</span></td>
                            <td>
                                <div class="attendance-actions">
                                    <button class="btn btn-outline btn-sm attendance-btn" disabled>Sudah Dicek</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Budi</td>
                            <td>12347</td>
                            <td>XI IPS 1</td>
                            <td>Lomba Design</td>
                            <td><span class="badge badge-danger">Tidak Hadir</span></td>
                            <td>
                                <div class="attendance-actions">
                                    <button class="btn btn-outline btn-sm attendance-btn" disabled>Sudah Dicek</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Citra</td>
                            <td>12348</td>
                            <td>X IPA 1</td>
                            <td>Seminar Pendidikan</td>
                            <td><span class="badge badge-success">Hadir</span></td>
                            <td>
                                <div class="attendance-actions">
                                    <button class="btn btn-outline btn-sm attendance-btn" disabled>Sudah Dicek</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Dewi</td>
                            <td>12349</td>
                            <td>XII IPS 1</td>
                            <td>Workshop Leadership</td>
                            <td><span class="badge badge-warning">Belum Dicek</span></td>
                            <td>
                                <div class="attendance-actions">
                                    <button class="btn btn-success btn-sm attendance-btn" data-status="present">✓ Hadir</button>
                                    <button class="btn btn-danger btn-sm attendance-btn" data-status="absent">✗ Tidak</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Eko</td>
                            <td>12350</td>
                            <td>XI IPA 1</td>
                            <td>Career Day</td>
                            <td><span class="badge badge-warning">Belum Dicek</span></td>
                            <td>
                                <div class="attendance-actions">
                                    <button class="btn btn-success btn-sm attendance-btn" data-status="present">✓ Hadir</button>
                                    <button class="btn btn-danger btn-sm attendance-btn" data-status="absent">✗ Tidak</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="btn btn-outline btn-sm pagination-btn" disabled>Previous</button>
                <button class="btn btn-primary btn-sm pagination-btn active">1</button>
                <button class="btn btn-outline btn-sm pagination-btn">2</button>
                <button class="btn btn-outline btn-sm pagination-btn">Next</button>
            </div>
        </div>
    </main>

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
        'resources/js/admin/attendance.js'
    ])
</body>
</html>