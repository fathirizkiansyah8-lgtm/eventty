<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/announcements.css'
    ])
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>

<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

@include('admin.partials.sidebar', ['activePage' => 'announcements'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <h1 class="admin-page-hd-title">Pengumuman</h1>
            <button class="abtn abtn-primary" id="createAnnouncementBtn">+ Buat Pengumuman</button>
        </div>

        <!-- Search and Filter -->
        <div class="admin-table-hd">
            <div class="admin-search-wrap">
                <input type="text" class="admin-search-input" id="searchInput" placeholder="Cari pengumuman...">
            </div>
            <div class="admin-filter-row">
                <select class="admin-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Announcements List -->
        <div class="announcements-list">
            <div class="admin-card">
                <div class="admin-card-hd">
                    <h3 class="admin-card-title">Event Baru Akan Segera Dibuka</h3>
                    <div class="announcement-status">
                        <span class="abadge abadge-green">Active</span>
                    </div>
                </div>
                <div class="admin-card-body">
                    <p>Siapkan diri Anda untuk event baru yang akan segera dibuka. Event ini akan memberikan pengalaman yang menarik dan bermanfaat bagi semua siswa.</p>
                </div>
                <div class="announcement-footer">
                    <div class="announcement-meta">
                        <span class="announcement-date">10 August 2026</span>
                        <span class="announcement-target">Target: Semua Siswa</span>
                    </div>
                    <div class="announcement-actions">
                        <button class="abtn abtn-outline abtn-sm" onclick="alert('Fitur edit pengumuman akan segera tersedia.')">Edit</button>
                        <button class="abtn abtn-danger abtn-sm" onclick="if(confirm('Hapus pengumuman ini?')){alert('Pengumuman berhasil dihapus!');}">Hapus</button>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-hd">
                    <h3 class="admin-card-title">Perubahan Jadwal Workshop</h3>
                    <div class="announcement-status">
                        <span class="abadge abadge-green">Active</span>
                    </div>
                </div>
                <div class="admin-card-body">
                    <p>Jadwal Workshop Programming telah berubah. Event baru akan diadakan pada 25 August 2026 di Lab Komputer. Mohon perhatikan perubahan ini.</p>
                </div>
                <div class="announcement-footer">
                    <div class="announcement-meta">
                        <span class="announcement-date">8 August 2026</span>
                        <span class="announcement-target">Target: Peserta Workshop</span>
                    </div>
                    <div class="announcement-actions">
                        <button class="abtn abtn-outline abtn-sm" onclick="alert('Fitur edit pengumuman akan segera tersedia.')">Edit</button>
                        <button class="abtn abtn-danger abtn-sm" onclick="if(confirm('Hapus pengumuman ini?')){alert('Pengumuman berhasil dihapus!');}">Hapus</button>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-hd">
                    <h3 class="admin-card-title">Selamat Datang di Eventy</h3>
                    <div class="announcement-status">
                        <span class="abadge abadge-gray">Inactive</span>
                    </div>
                </div>
                <div class="admin-card-body">
                    <p>Selamat datang di platform Eventy. Platform ini dirancang untuk memudahkan pengelolaan event sekolah. Silakan explore fitur-fitur yang tersedia.</p>
                </div>
                <div class="announcement-footer">
                    <div class="announcement-meta">
                        <span class="announcement-date">1 August 2026</span>
                        <span class="announcement-target">Target: Semua Pengguna</span>
                    </div>
                    <div class="announcement-actions">
                        <button class="abtn abtn-outline abtn-sm" onclick="alert('Fitur edit pengumuman akan segera tersedia.')">Edit</button>
                        <button class="abtn abtn-danger abtn-sm" onclick="if(confirm('Hapus pengumuman ini?')){alert('Pengumuman berhasil dihapus!');}">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Announcement Modal -->
        <div class="admin-modal-overlay" id="createAnnouncementModal">
            <div class="admin-modal">
                <div class="admin-modal-hd">
                    <h3 class="admin-modal-title">Buat Pengumuman</h3>
                    <button class="admin-modal-close" id="closeCreateModal">&times;</button>
                </div>
                <div class="admin-modal-body">
                    <form id="createAnnouncementForm">
                        <div class="aform-group">
                            <label class="aform-label" for="announcementTitle">Judul *</label>
                            <input type="text" id="announcementTitle" class="aform-input" placeholder="Masukkan judul pengumuman" required>
                        </div>
                        <div class="aform-group">
                            <label class="aform-label" for="announcementContent">Isi *</label>
                            <textarea id="announcementContent" class="aform-textarea" rows="4" placeholder="Masukkan isi pengumuman" required></textarea>
                        </div>
                        <div class="aform-group">
                            <label class="aform-label" for="announcementTarget">Target</label>
                            <select id="announcementTarget" class="aform-select">
                                <option value="all">Semua Pengguna</option>
                                <option value="students">Semua Siswa</option>
                                <option value="participants">Peserta Event</option>
                            </select>
                        </div>
                        <div class="aform-group">
                            <label class="aform-label" for="announcementDate">Tanggal</label>
                            <input type="date" id="announcementDate" class="aform-input">
                        </div>
                        <div class="aform-group">
                            <label class="aform-label" for="announcementStatus">Status</label>
                            <select id="announcementStatus" class="aform-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="admin-modal-ft">
                    <button class="abtn abtn-secondary" id="cancelCreateBtn">Batal</button>
                    <button class="abtn abtn-primary" id="saveAnnouncementBtn" onclick="document.getElementById('createAnnouncementModal').classList.remove('active'); alert('Pengumuman berhasil disimpan!');">Simpan</button>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')

@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])
@vite(['resources/js/admin/announcements.js'])
</body>
</html>
