<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Sertifikat — Eventty</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/components/header.css',
        'resources/css/admin/certificates.css',
    ])
</head>
<body>

<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar admin-sidebar" id="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Eventty" class="sidebar-logo">
        <div><div class="sidebar-brand">Eventty</div><div class="adm-cert-sub">Admin Panel</div></div>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section">
            <div class="sidebar-section-title">Menu Utama</div>
            <a href="{{ url('/admin/dashboard') }}"    class="sidebar-link"><span class="sidebar-link-icon">📊</span><span>Dashboard</span></a>
            <a href="{{ url('/admin/events') }}"       class="sidebar-link"><span class="sidebar-link-icon">🎉</span><span>Kelola Event</span></a>
            <a href="{{ url('/admin/participants') }}"  class="sidebar-link"><span class="sidebar-link-icon">👥</span><span>Peserta</span></a>
            <a href="{{ url('/admin/attendance') }}"   class="sidebar-link"><span class="sidebar-link-icon">✅</span><span>Kehadiran</span></a>
            <a href="{{ url('/admin/certificates') }}" class="sidebar-link active"><span class="sidebar-link-icon">🏆</span><span>Sertifikat</span></a>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Pengelolaan</div>
            <a href="{{ url('/admin/announcements') }}" class="sidebar-link"><span class="sidebar-link-icon">📢</span><span>Pengumuman</span></a>
            <a href="{{ url('/admin/students') }}"      class="sidebar-link"><span class="sidebar-link-icon">🎓</span><span>Data Siswa</span></a>
            <a href="{{ url('/admin/messages') }}"      class="sidebar-link"><span class="sidebar-link-icon">💬</span><span>Messages</span></a>
        </div>
    </nav>
</aside>

<main class="main-content">
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
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <span class="notification-badge">5</span>
                </button>
                <div class="header-profile" id="profileBtn">
                    <div class="avatar avatar-sm"><span>A</span></div>
                    <div class="header-profile-info"><span class="header-profile-name">Admin</span><span class="header-profile-role">OSIS</span></div>
                </div>
            </div>
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="notification-header"><span class="notification-title">Notifikasi</span><span class="notification-mark-all">Tandai semua dibaca</span></div>
                <div class="notification-list">
                    <div class="notification-item unread"><div class="notification-content"><div class="notification-icon">📝</div><div class="notification-text"><div class="notification-message">Pendaftaran baru untuk Career Day</div><div class="notification-time">5 menit lalu</div></div></div></div>
                    <div class="notification-item unread"><div class="notification-content"><div class="notification-icon">⚠️</div><div class="notification-text"><div class="notification-message">Kuota Workshop hampir penuh</div><div class="notification-time">30 menit lalu</div></div></div></div>
                    <div class="notification-item"><div class="notification-content"><div class="notification-icon">✅</div><div class="notification-text"><div class="notification-message">Event Seminar berhasil dibuat</div><div class="notification-time">1 jam lalu</div></div></div></div>
                </div>
                <div class="notification-footer"><span class="notification-view-all">Lihat semua</span></div>
            </div>
            <div class="profile-dropdown" id="profileDropdown">
                <a href="{{ url('/admin/settings') }}" class="profile-dropdown-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    <span>Pengaturan</span>
                </a>
                <div class="profile-dropdown-divider"></div>
                <button type="button" id="headerLogoutBtn" class="profile-dropdown-item danger" style="display:flex;align-items:center;gap:.75rem;width:100%;border:none;background:none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Keluar</span>
                </button>
            </div>
        </div>
    </header>

    <!-- ── Certificates Content ── -->
    <div class="adm-cert-page">

        <div class="section-header">
            <h1 class="section-title">Kelola Sertifikat</h1>
        </div>

        <!-- Tabs -->
        <div class="adm-cert-tabs">
            <button class="adm-cert-tab active" data-panel="automatic" onclick="switchAdmCertTab('automatic',this)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                Automatic Certificates
            </button>
            <button class="adm-cert-tab" data-panel="competition" onclick="switchAdmCertTab('competition',this)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Competition Certificates
            </button>
        </div>

        <!-- ── AUTOMATIC PANEL ── -->
        <div class="adm-cert-panel active" id="adm-cert-panel-automatic">

            <!-- Stats -->
            <div class="adm-cert-stats">
                <div class="adm-cert-stat-card">
                    <div class="adm-cert-stat-icon blue"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                    <div class="adm-cert-stat-info"><span class="adm-cert-stat-num">1,234</span><span class="adm-cert-stat-lbl">Total Peserta</span></div>
                </div>
                <div class="adm-cert-stat-card">
                    <div class="adm-cert-stat-icon green"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <div class="adm-cert-stat-info"><span class="adm-cert-stat-num">987</span><span class="adm-cert-stat-lbl">Total Hadir</span></div>
                </div>
                <div class="adm-cert-stat-card">
                    <div class="adm-cert-stat-icon purple"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg></div>
                    <div class="adm-cert-stat-info"><span class="adm-cert-stat-num">987</span><span class="adm-cert-stat-lbl">Sertifikat Tersedia</span></div>
                </div>
                <div class="adm-cert-stat-card">
                    <div class="adm-cert-stat-icon orange"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <div class="adm-cert-stat-info"><span class="adm-cert-stat-num">247</span><span class="adm-cert-stat-lbl">Menunggu Kehadiran</span></div>
                </div>
            </div>

            <!-- Search + Filter -->
            <div class="adm-cert-bar">
                <div class="adm-cert-search">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Cari peserta atau event..." id="certSearch" oninput="filterCertTable(this.value)">
                </div>
                <div class="adm-cert-filters">
                    <select class="input-field" id="certEventFilter" onchange="filterCertTable('')">
                        <option value="">Semua Event</option>
                        <option>Seminar Digital</option>
                        <option>Workshop Leadership</option>
                        <option>Career Day 2026</option>
                    </select>
                    <select class="input-field" id="certStatusFilter" onchange="filterCertTable('')">
                        <option value="">Semua Status</option>
                        <option value="available">Available</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table" id="certTable">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Peserta</th>
                            <th>NIS</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-event="Seminar Digital" data-status="available">
                            <td><div class="adm-cert-event-cell"><span class="adm-cert-event-dot seminar"></span>Seminar Digital</div></td>
                            <td>Fathi Rizkiansyah</td><td>12345</td><td>Participation</td>
                            <td><span class="badge badge-success">Available</span></td>
                            <td><div class="action-buttons"><button class="btn btn-outline btn-sm" onclick="adminPreviewCert('Fathi Rizkiansyah','Seminar Digital','Participation')">Lihat</button><button class="btn btn-primary btn-sm">Generate</button><button class="btn btn-outline btn-sm">Download</button></div></td>
                        </tr>
                        <tr data-event="Workshop Leadership" data-status="available">
                            <td><div class="adm-cert-event-cell"><span class="adm-cert-event-dot workshop"></span>Workshop Leadership</div></td>
                            <td>Siti Nurhaliza</td><td>12346</td><td>Completion</td>
                            <td><span class="badge badge-success">Available</span></td>
                            <td><div class="action-buttons"><button class="btn btn-outline btn-sm" onclick="adminPreviewCert('Siti Nurhaliza','Workshop Leadership','Completion')">Lihat</button><button class="btn btn-primary btn-sm">Generate</button><button class="btn btn-outline btn-sm">Download</button></div></td>
                        </tr>
                        <tr data-event="Career Day 2026" data-status="pending">
                            <td><div class="adm-cert-event-cell"><span class="adm-cert-event-dot career"></span>Career Day 2026</div></td>
                            <td>Budi Santoso</td><td>12347</td><td>Attendance</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td><div class="action-buttons"><button class="btn btn-outline btn-sm">Lihat</button><button class="btn btn-primary btn-sm">Generate</button><button class="btn btn-outline btn-sm" disabled>Download</button></div></td>
                        </tr>
                        <tr data-event="Seminar Digital" data-status="available">
                            <td><div class="adm-cert-event-cell"><span class="adm-cert-event-dot seminar"></span>Seminar Digital</div></td>
                            <td>Rizky Pratama</td><td>12348</td><td>Participation</td>
                            <td><span class="badge badge-success">Available</span></td>
                            <td><div class="action-buttons"><button class="btn btn-outline btn-sm" onclick="adminPreviewCert('Rizky Pratama','Seminar Digital','Participation')">Lihat</button><button class="btn btn-primary btn-sm">Generate</button><button class="btn btn-outline btn-sm">Download</button></div></td>
                        </tr>
                        <tr data-event="Workshop Leadership" data-status="pending">
                            <td><div class="adm-cert-event-cell"><span class="adm-cert-event-dot workshop"></span>Workshop Leadership</div></td>
                            <td>Dewi Anggraini</td><td>12349</td><td>Participation</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td><div class="action-buttons"><button class="btn btn-outline btn-sm">Lihat</button><button class="btn btn-primary btn-sm">Generate</button><button class="btn btn-outline btn-sm" disabled>Download</button></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                <button class="btn btn-outline btn-sm" disabled>Previous</button>
                <button class="btn btn-primary btn-sm">1</button>
                <button class="btn btn-outline btn-sm">2</button>
                <button class="btn btn-outline btn-sm">Next</button>
            </div>
        </div>

        <!-- ── COMPETITION PANEL ── -->
        <div class="adm-cert-panel" id="adm-cert-panel-competition">

            <!-- Stats -->
            <div class="adm-cert-stats">
                <div class="adm-cert-stat-card">
                    <div class="adm-cert-stat-icon yellow"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
                    <div class="adm-cert-stat-info"><span class="adm-cert-stat-num">4</span><span class="adm-cert-stat-lbl">Event Kompetisi</span></div>
                </div>
                <div class="adm-cert-stat-card">
                    <div class="adm-cert-stat-icon green"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg></div>
                    <div class="adm-cert-stat-info"><span class="adm-cert-stat-num">12</span><span class="adm-cert-stat-lbl">Sertifikat Diterbitkan</span></div>
                </div>
                <div class="adm-cert-stat-card">
                    <div class="adm-cert-stat-icon orange"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <div class="adm-cert-stat-info"><span class="adm-cert-stat-num">3</span><span class="adm-cert-stat-lbl">Menunggu Penetapan</span></div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr><th>Event</th><th>Peserta</th><th>NIS</th><th>Penghargaan</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div class="adm-cert-event-cell"><span class="adm-cert-event-dot competition"></span>Turnamen Basket</div></td>
                            <td>Fathi Rizkiansyah</td><td>12345</td>
                            <td><span class="adm-rank-badge gold">🥇 Juara 1</span></td>
                            <td><span class="badge badge-success">Available</span></td>
                            <td><div class="action-buttons"><button class="btn btn-outline btn-sm" onclick="adminPreviewComp('Fathi Rizkiansyah','Turnamen Basket','JUARA 1')">Lihat</button><button class="btn btn-outline btn-sm">Download</button></div></td>
                        </tr>
                        <tr>
                            <td><div class="adm-cert-event-cell"><span class="adm-cert-event-dot competition"></span>Turnamen Basket</div></td>
                            <td>Ahmad Rizki</td><td>12360</td>
                            <td><span class="adm-rank-badge silver">🥈 Juara 2</span></td>
                            <td><span class="badge badge-success">Available</span></td>
                            <td><div class="action-buttons"><button class="btn btn-outline btn-sm" onclick="adminPreviewComp('Ahmad Rizki','Turnamen Basket','JUARA 2')">Lihat</button><button class="btn btn-outline btn-sm">Download</button></div></td>
                        </tr>
                        <tr>
                            <td><div class="adm-cert-event-cell"><span class="adm-cert-event-dot competition"></span>Class Meeting — Futsal</div></td>
                            <td>Budi Santoso</td><td>12347</td>
                            <td><span class="adm-rank-badge gold">🥇 Juara 1</span></td>
                            <td><span class="badge badge-success">Available</span></td>
                            <td><div class="action-buttons"><button class="btn btn-outline btn-sm" onclick="adminPreviewComp('Budi Santoso','Class Meeting Futsal','JUARA 1')">Lihat</button><button class="btn btn-outline btn-sm">Download</button></div></td>
                        </tr>
                        <tr>
                            <td><div class="adm-cert-event-cell"><span class="adm-cert-event-dot competition"></span>Lomba Desain Grafis</div></td>
                            <td>Dewi Anggraini</td><td>12349</td>
                            <td><span class="adm-rank-badge pending">— Belum Ditetapkan</span></td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td><div class="action-buttons"><button class="btn btn-primary btn-sm">Tetapkan Juara</button></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- /adm-cert-page -->
</main>

<!-- Preview Modal -->
<div class="modal-overlay" id="admCertModal" style="display:flex;align-items:center;justify-content:center;padding:1rem;" onclick="if(event.target===this){this.classList.remove('active');document.body.style.overflow='';}">
    <div style="background:var(--bg-secondary);border-radius:18px;width:100%;max-width:580px;max-height:92vh;overflow-y:auto;box-shadow:0 24px 64px rgba(0,0,0,.3);transform:scale(.96);transition:transform .25s;" id="admCertModalBox">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border-bottom:1px solid var(--border-color);">
            <span style="font-size:.9rem;font-weight:700;color:var(--text-primary);" id="admCertModalTitle">Preview Sertifikat</span>
            <button onclick="document.getElementById('admCertModal').classList.remove('active');document.body.style.overflow='';" style="width:30px;height:30px;border-radius:50%;border:1.5px solid var(--border-color);background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;color:var(--text-secondary);">✕</button>
        </div>
        <div style="padding:1.5rem;" id="admCertModalBody"></div>
        <div style="padding:1rem 1.25rem;border-top:1px solid var(--border-color);display:flex;justify-content:flex-end;gap:.625rem;">
            <button class="btn btn-outline btn-sm" onclick="document.getElementById('admCertModal').classList.remove('active');document.body.style.overflow='';">Tutup</button>
            <button class="btn btn-primary btn-sm">Download PDF</button>
        </div>
    </div>
</div>

<!-- Logout Modal -->
<div class="modal-overlay" id="logoutModal">
    <div class="logout-modal">
        <div class="logout-modal-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div>
        <div class="modal-header"><h3 class="modal-title">Konfirmasi Keluar</h3></div>
        <div class="modal-body"><p>Yakin ingin keluar dari akun Admin?</p></div>
        <div class="modal-footer logout-modal-actions">
            <button type="button" class="btn-logout-cancel" id="cancelLogoutBtn">Batal</button>
            <form action="{{ url('/logout') }}" method="POST">@csrf<button type="submit" class="btn-logout-confirm">Ya, Keluar</button></form>
        </div>
    </div>
</div>

@vite([
    'resources/js/components/sidebar.js',
    'resources/js/components/header.js',
    'resources/js/admin/certificates.js',
])

<script>
function switchAdmCertTab(panel, btn) {
    document.querySelectorAll('.adm-cert-tab').forEach(function(b){ b.classList.remove('active'); });
    document.querySelectorAll('.adm-cert-panel').forEach(function(p){ p.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('adm-cert-panel-' + panel).classList.add('active');
}

function buildCertPreview(name, event, type, rank) {
    var isAchievement = !!rank;
    return '<div style="background:linear-gradient(145deg,#0d1b4b,#1a2d6e);border-radius:14px;padding:2.5rem 2rem;text-align:center;color:#fff;">' +
        '<div style="font-size:.72rem;font-weight:800;letter-spacing:.15em;color:rgba(255,255,255,.4);margin-bottom:.3rem;">— EVENTTY —</div>' +
        '<div style="font-size:.62rem;color:rgba(255,255,255,.3);letter-spacing:.1em;margin-bottom:1.5rem;">SMKN 20 JAKARTA</div>' +
        '<div style="width:40px;height:2px;background:rgba(255,255,255,.15);border-radius:1px;margin:0 auto 1.5rem;"></div>' +
        '<div style="font-size:.68rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#93c5fd;margin-bottom:.2rem;">Certificate</div>' +
        '<div style="font-size:1.4rem;font-weight:800;margin-bottom:1.5rem;">' + (isAchievement ? 'OF ACHIEVEMENT' : 'OF ' + type.toUpperCase()) + '</div>' +
        '<div style="font-size:.68rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.4rem;">Diberikan kepada</div>' +
        '<div style="font-size:1.25rem;font-weight:800;color:#fbbf24;margin-bottom:1.5rem;">' + name.toUpperCase() + '</div>' +
        (isAchievement ? '<div style="font-size:.68rem;color:rgba(255,255,255,.4);margin-bottom:.4rem;">sebagai</div><div style="display:inline-block;padding:.45rem 1.5rem;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:999px;font-weight:800;font-size:.875rem;margin-bottom:1rem;">' + rank + '</div>' : '<div style="font-size:.68rem;color:rgba(255,255,255,.4);margin-bottom:.4rem;">atas partisipasinya dalam</div>') +
        '<div style="font-size:1rem;font-weight:700;margin-bottom:1.5rem;">' + event.toUpperCase() + '</div>' +
        '<div style="padding-top:1.25rem;border-top:1px solid rgba(255,255,255,.08);font-size:.6rem;color:rgba(255,255,255,.25);letter-spacing:.08em;text-transform:uppercase;">EVENTTY · SMKN 20 JAKARTA</div>' +
    '</div>';
}

function adminPreviewCert(name, event, type) {
    document.getElementById('admCertModalTitle').textContent = 'Preview — ' + event;
    document.getElementById('admCertModalBody').innerHTML = buildCertPreview(name, event, type, null);
    var modal = document.getElementById('admCertModal');
    modal.classList.add('active');
    document.getElementById('admCertModalBox').style.transform = 'scale(1)';
    document.body.style.overflow = 'hidden';
}

function adminPreviewComp(name, event, rank) {
    document.getElementById('admCertModalTitle').textContent = 'Preview — ' + event;
    document.getElementById('admCertModalBody').innerHTML = buildCertPreview(name, event, null, rank);
    var modal = document.getElementById('admCertModal');
    modal.classList.add('active');
    document.getElementById('admCertModalBox').style.transform = 'scale(1)';
    document.body.style.overflow = 'hidden';
}

function filterCertTable(q) {
    var eventFilter  = document.getElementById('certEventFilter').value.toLowerCase();
    var statusFilter = document.getElementById('certStatusFilter').value.toLowerCase();
    var search = q.toLowerCase();
    document.querySelectorAll('#certTable tbody tr').forEach(function(row) {
        var text   = row.textContent.toLowerCase();
        var event  = row.getAttribute('data-event').toLowerCase();
        var status = row.getAttribute('data-status').toLowerCase();
        var matchSearch = !search || text.includes(search);
        var matchEvent  = !eventFilter || event.includes(eventFilter);
        var matchStatus = !statusFilter || status === statusFilter;
        row.style.display = (matchSearch && matchEvent && matchStatus) ? '' : 'none';
    });
}
</script>

</body>
</html>
