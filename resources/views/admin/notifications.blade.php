<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css'
    ])
    <style>
        .notification-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color, #e5e7eb);
            margin-bottom: 0.75rem;
            transition: background-color 0.2s;
            cursor: pointer;
        }
        .notification-item:hover {
            background-color: var(--bg-hover, #f9fafb);
        }
        .notification-item.unread {
            background-color: var(--bg-unread, #f0f9ff);
            border-color: var(--blue-200, #bfdbfe);
        }
        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .notification-icon.event {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        .notification-icon.cert {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        .notification-icon.system {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }
        .notification-icon.pending {
            background: linear-gradient(135deg, #f87171, #dc2626);
        }
        .notification-content {
            flex: 1;
        }
        .notification-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .notification-desc {
            font-size: 0.85rem;
            color: var(--text-muted, #6b7280);
            margin-bottom: 0.25rem;
        }
        .notification-time {
            font-size: 0.8rem;
            color: var(--text-muted, #9ca3af);
        }
        .notification-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ef4444;
            flex-shrink: 0;
            margin-top: 0.25rem;
        }
        .filter-chips {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        .filter-chip {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            border: 1px solid var(--border-color, #e5e7eb);
            background: transparent;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .filter-chip:hover {
            border-color: var(--primary, #3b82f6);
            color: var(--primary, #3b82f6);
        }
        .filter-chip.active {
            background: var(--primary, #3b82f6);
            color: white;
            border-color: var(--primary, #3b82f6);
        }
    </style>
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>

<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

@include('admin.partials.sidebar', ['activePage' => 'notifications'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <h1 class="admin-page-hd-title">Notifikasi</h1>
            <button class="abtn abtn-outline abtn-sm" onclick="alert('Semua notifikasi telah ditandai sebagai dibaca!');">Tandai Semua Dibaca</button>
        </div>

        <!-- Filter Chips -->
        <div class="filter-chips">
            <button class="filter-chip active" data-filter="all">Semua</button>
            <button class="filter-chip" data-filter="unread">Belum Dibaca</button>
            <button class="filter-chip" data-filter="event">Event</button>
            <button class="filter-chip" data-filter="cert">Sertifikat</button>
            <button class="filter-chip" data-filter="system">Sistem</button>
        </div>

        <!-- Notifications List -->
        <div class="notifications-list">
            <!-- Unread Notification 1 -->
            <div class="notification-item unread" data-type="event">
                <div class="notification-icon event">📝</div>
                <div class="notification-content">
                    <div class="notification-title">Pendaftaran Baru <span class="abadge abadge-blue">Event</span></div>
                    <div class="notification-desc">Ahmad Rizki mendaftar Career Day</div>
                    <div class="notification-time">2 menit lalu</div>
                </div>
                <div class="notification-dot"></div>
            </div>

            <!-- Unread Notification 2 -->
            <div class="notification-item unread" data-type="event">
                <div class="notification-icon event">⚠️</div>
                <div class="notification-content">
                    <div class="notification-title">Kuota Hampir Penuh <span class="abadge abadge-blue">Event</span></div>
                    <div class="notification-desc">Workshop Programming 28/30</div>
                    <div class="notification-time">15 menit lalu</div>
                </div>
                <div class="notification-dot"></div>
            </div>

            <!-- Read Notification 1 -->
            <div class="notification-item" data-type="cert">
                <div class="notification-icon cert">🏆</div>
                <div class="notification-content">
                    <div class="notification-title">Sertifikat Diterbitkan <span class="abadge abadge-green">Sertifikat</span></div>
                    <div class="notification-desc">12 sertifikat Workshop berhasil diterbitkan</div>
                    <div class="notification-time">1 jam lalu</div>
                </div>
            </div>

            <!-- Read Notification 2 -->
            <div class="notification-item" data-type="event">
                <div class="notification-icon event">✨</div>
                <div class="notification-content">
                    <div class="notification-title">Event Baru Dibuat <span class="abadge abadge-blue">Event</span></div>
                    <div class="notification-desc">Turnamen Basket berhasil ditambahkan</div>
                    <div class="notification-time">2 jam lalu</div>
                </div>
            </div>

            <!-- Unread Notification 3 -->
            <div class="notification-item unread" data-type="event">
                <div class="notification-icon pending">⏳</div>
                <div class="notification-content">
                    <div class="notification-title">Absensi Menunggu <span class="abadge abadge-blue">Event</span></div>
                    <div class="notification-desc">Career Day belum dikunci</div>
                    <div class="notification-time">3 jam lalu</div>
                </div>
                <div class="notification-dot"></div>
            </div>

            <!-- Read Notification 3 -->
            <div class="notification-item" data-type="event">
                <div class="notification-icon event">👥</div>
                <div class="notification-content">
                    <div class="notification-title">Peserta Baru <span class="abadge abadge-blue">Event</span></div>
                    <div class="notification-desc">5 siswa mendaftar Seminar Digital</div>
                    <div class="notification-time">Kemarin</div>
                </div>
            </div>

            <!-- Read Notification 4 -->
            <div class="notification-item" data-type="event">
                <div class="notification-icon event">🏁</div>
                <div class="notification-content">
                    <div class="notification-title">Event Selesai <span class="abadge abadge-blue">Event</span></div>
                    <div class="notification-desc">Workshop Leadership telah berakhir</div>
                    <div class="notification-time">2 hari lalu</div>
                </div>
            </div>

            <!-- Read Notification 5 -->
            <div class="notification-item" data-type="system">
                <div class="notification-icon system">⚙️</div>
                <div class="notification-content">
                    <div class="notification-title">Sistem <span class="abadge abadge-indigo">Sistem</span></div>
                    <div class="notification-desc">Backup data berhasil</div>
                    <div class="notification-time">3 hari lalu</div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')

@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])
<script>
    // Filter chip functionality
    document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            // Remove active class from all chips
            document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            // Add active class to clicked chip
            this.classList.add('active');

            // Filter notifications
            const filter = this.dataset.filter;
            document.querySelectorAll('.notification-item').forEach(item => {
                if (filter === 'all') {
                    item.style.display = '';
                } else if (filter === 'unread') {
                    item.style.display = item.classList.contains('unread') ? '' : 'none';
                } else {
                    item.style.display = item.dataset.type === filter ? '' : 'none';
                }
            });
        });
    });
</script>
</body>
</html>
