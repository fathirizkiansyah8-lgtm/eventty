document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for notifications
    const notifications = [
        {
            id: 1,
            message: "Pendaftaran Career Day berhasil! Anda sekarang terdaftar untuk event ini.",
            time: "2 menit yang lalu",
            icon: "🎉",
            type: "success",
            read: false,
            action: "Lihat Event"
        },
        {
            id: 2,
            message: "Event Career Day akan dimulai besok pada pukul 08:00 di Aula Sekolah. Jangan lupa hadir!",
            time: "1 jam yang lalu",
            icon: "📢",
            type: "info",
            read: false,
            action: "Lihat Detail"
        },
        {
            id: 3,
            message: "Jadwal event Workshop Programming berubah. Event baru akan diadakan pada 25 August 2026.",
            time: "3 jam yang lalu",
            icon: "⚠️",
            type: "warning",
            read: false,
            action: "Lihat Perubahan"
        },
        {
            id: 4,
            message: "Sertifikat Workshop Leadership telah tersedia. Anda dapat mengunduh sertifikat sekarang.",
            time: "Kemarin",
            icon: "🏆",
            type: "success",
            read: true,
            action: "Lihat Sertifikat"
        },
        {
            id: 5,
            message: "Pengumuman baru dari OSIS: Ada event baru yang akan segera dibuka. Stay tuned!",
            time: "2 hari yang lalu",
            icon: "📢",
            type: "info",
            read: true,
            action: "Lihat Pengumuman"
        },
        {
            id: 6,
            message: "Kehadiran Anda untuk Seminar Pendidikan telah dicatat. Terima kasih telah hadir!",
            time: "3 hari yang lalu",
            icon: "✅",
            type: "success",
            read: true,
            action: "Lihat Detail"
        },
        {
            id: 7,
            message: "Selamat ulang tahun! Semoga hari Anda menyenangkan dan penuh kebahagiaan.",
            time: "1 minggu yang lalu",
            icon: "🎂",
            type: "info",
            read: true,
            action: "Terima Kasih"
        }
    ];

    // Filter buttons
    const filterBtns = document.querySelectorAll('.filter-btn');
    const notificationItems = document.querySelectorAll('.notification-item');

    // Handle filter button clicks
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            filterNotifications(filter);
        });
    });

    // Function to filter notifications
    function filterNotifications(filter) {
        notificationItems.forEach(item => {
            const isRead = item.dataset.read === 'true';
            
            if (filter === 'all') {
                item.style.display = 'flex';
            } else if (filter === 'unread' && !isRead) {
                item.style.display = 'flex';
            } else if (filter === 'read' && isRead) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });

        checkEmptyState();
    }

    // Handle notification item clicks (mark as read)
    notificationItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Don't mark as read if action button was clicked
            if (e.target.closest('.notification-action-btn')) {
                return;
            }

            if (this.classList.contains('unread')) {
                this.classList.remove('unread');
                this.dataset.read = 'true';
                updateNotificationBadge();
                // TODO: Update backend to mark as read
            }
        });

        // Handle action button clicks
        const actionBtn = item.querySelector('.notification-action-btn');
        if (actionBtn) {
            actionBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const action = this.textContent.trim();
                
                // Mark notification as read when action is taken
                if (item.classList.contains('unread')) {
                    item.classList.remove('unread');
                    item.dataset.read = 'true';
                    updateNotificationBadge();
                }

                // TODO: Handle different actions based on notification type
                console.log('Action:', action);
            });
        }
    });

    // Mark all as read
    const markAllReadBtn = document.getElementById('markAllReadBtn');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            notificationItems.forEach(item => {
                if (item.classList.contains('unread')) {
                    item.classList.remove('unread');
                    item.dataset.read = 'true';
                }
            });
            updateNotificationBadge();
            // TODO: Update backend to mark all as read
        });
    }

    // Clear all notifications
    const clearAllBtn = document.getElementById('clearAllBtn');
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')) {
                notificationItems.forEach(item => {
                    item.style.display = 'none';
                });
                checkEmptyState();
                // TODO: Update backend to clear all notifications
            }
        });
    }

    // Update notification badge count
    function updateNotificationBadge() {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            const unreadCount = document.querySelectorAll('.notification-item.unread').length;
            badge.textContent = unreadCount;
            
            if (unreadCount === 0) {
                badge.style.display = 'none';
            } else {
                badge.style.display = 'flex';
            }
        }
    }

    // Check empty state
    function checkEmptyState() {
        const visibleItems = Array.from(notificationItems).filter(item => item.style.display !== 'none');
        const notificationsList = document.querySelector('.notifications-list');
        
        // Remove existing empty state
        const existingEmptyState = notificationsList.querySelector('.empty-state');
        if (existingEmptyState) {
            existingEmptyState.remove();
        }

        if (visibleItems.length === 0) {
            const emptyState = document.createElement('div');
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <div class="empty-state-icon">🔔</div>
                <div class="empty-state-title">Tidak ada notifikasi</div>
                <div class="empty-state-description">Tidak ada notifikasi yang sesuai dengan filter yang dipilih</div>
            `;
            notificationsList.appendChild(emptyState);
        }
    }

    // Initialize notification badge
    updateNotificationBadge();
});
