<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Event - Eventty</title>
    
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
        'resources/css/admin/create-event.css'
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
                
                <a href="{{ url('/admin/events') }}" class="sidebar-link active">
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

        <!-- Create Event Content -->
        <div class="create-event-content">
            <div class="section-header">
                <h1 class="section-title">Buat Event Baru</h1>
                <button class="btn btn-secondary" id="cancelBtn">Batal</button>
            </div>

            <div class="form-container">
                <form id="createEventForm">
                    <div class="form-section">
                        <h2 class="form-section-title">Informasi Event</h2>
                        
                        <div class="form-row">
                            <div class="input-group">
                                <label class="input-label" for="eventName">Nama Event *</label>
                                <input type="text" id="eventName" class="input-field" placeholder="Masukkan nama event" required>
                                <small class="field-error" id="eventNameError"></small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group">
                                <label class="input-label" for="eventCategory">Kategori *</label>
                                <select id="eventCategory" class="input-field" required>
                                    <option value="">Pilih kategori</option>
                                    <option value="school-event">School Event</option>
                                    <option value="workshop">Workshop</option>
                                    <option value="seminar">Seminar</option>
                                    <option value="competition">Competition</option>
                                    <option value="training">Training</option>
                                </select>
                                <small class="field-error" id="eventCategoryError"></small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group">
                                <label class="input-label" for="eventDescription">Deskripsi</label>
                                <textarea id="eventDescription" class="input-field" rows="4" placeholder="Deskripsi event"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="form-section-title">Waktu & Lokasi</h2>
                        
                        <div class="form-row form-row-2">
                            <div class="input-group">
                                <label class="input-label" for="eventDate">Tanggal *</label>
                                <input type="date" id="eventDate" class="input-field" required>
                                <small class="field-error" id="eventDateError"></small>
                            </div>
                            <div class="input-group">
                                <label class="input-label" for="eventTime">Waktu *</label>
                                <input type="time" id="eventTime" class="input-field" required>
                                <small class="field-error" id="eventTimeError"></small>
                            </div>
                        </div>

                        <div class="form-row form-row-2">
                            <div class="input-group">
                                <label class="input-label" for="eventStartTime">Waktu Mulai</label>
                                <input type="time" id="eventStartTime" class="input-field">
                            </div>
                            <div class="input-group">
                                <label class="input-label" for="eventEndTime">Waktu Selesai</label>
                                <input type="time" id="eventEndTime" class="input-field">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group">
                                <label class="input-label" for="eventLocation">Lokasi *</label>
                                <input type="text" id="eventLocation" class="input-field" placeholder="Masukkan lokasi event" required>
                                <small class="field-error" id="eventLocationError"></small>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="form-section-title">Kapasitas & Penyelenggara</h2>
                        
                        <div class="form-row form-row-2">
                            <div class="input-group">
                                <label class="input-label" for="eventQuota">Kuota Peserta *</label>
                                <input type="number" id="eventQuota" class="input-field" placeholder="Masukkan kuota" min="1" required>
                                <small class="field-error" id="eventQuotaError"></small>
                            </div>
                            <div class="input-group">
                                <label class="input-label" for="eventOrganizer">Penyelenggara *</label>
                                <input type="text" id="eventOrganizer" class="input-field" placeholder="Masukkan nama penyelenggara" required>
                                <small class="field-error" id="eventOrganizerError"></small>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="form-section-title">Banner Event</h2>
                        
                        <div class="form-row">
                            <div class="input-group">
                                <label class="input-label" for="eventBanner">Banner Image</label>
                                <input type="file" id="eventBanner" class="input-field" accept="image/*">
                                <small class="field-hint">Format: JPG, PNG. Maksimal 2MB.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="form-section-title">Status Event</h2>
                        
                        <div class="form-row">
                            <div class="input-group">
                                <label class="input-label" for="eventStatus">Status</label>
                                <select id="eventStatus" class="input-field">
                                    <option value="draft">Draft</option>
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Event</button>
                    </div>
                </form>
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
        'resources/js/admin/create-event.js'
    ])
</body>
</html>