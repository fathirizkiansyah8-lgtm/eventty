document.addEventListener('DOMContentLoaded', function () {
    let currentFilter = 'all';
    let currentPage = 1;
    initializeNotifications();

    async function initializeNotifications() {
        await loadNotifications();
        initializeFilterTabs();
        initializeActions();
    }

    // ── Load notifications from API ──
    async function loadNotifications(filter = 'all', page = 1) {
        const container = document.getElementById('notificationsList') || document.querySelector('.notifications-list');
        if (!container) return;

        container.innerHTML = `<div class="loading-state" style="text-align:center;padding:2rem;"><p>Memuat notifikasi...</p></div>`;

        try {
            const params = { page };
            if (filter !== 'all') params.filter = filter;

            const response = await api.get('/api/user/notifications', params);
            const notifications = response.data || [];

            // Update unread count badge
            updateUnreadBadge();

            if (notifications.length === 0) {
                container.innerHTML = `
                    <div class="empty-state" style="text-align:center;padding:3rem;">
                        <div style="font-size:3rem;margin-bottom:1rem;">🔔</div>
                        <h3>Tidak ada notifikasi</h3>
                        <p>${filter === 'unread' ? 'Semua notifikasi sudah dibaca.' : 'Belum ada notifikasi.'}</p>
                    </div>`;
                return;
            }

            container.innerHTML = notifications.map(notif => `
                <div class="notification-item ${notif.is_read ? '' : 'unread'}" data-notif-id="${notif.id}">
                    <div class="notif-icon-wrap notif-type-${notif.type}">
                        <i class="${notif.icon}"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-title">${notif.title}</div>
                        <div class="notif-message">${notif.message}</div>
                        <div class="notif-time">${notif.formatted_time}</div>
                    </div>
                    <div class="notif-actions">
                        ${!notif.is_read
                            ? `<button class="btn-icon mark-read-btn" data-notif-id="${notif.id}" title="Tandai sudah dibaca">
                                   <i class="fas fa-check"></i>
                               </button>`
                            : ''
                        }
                        <button class="btn-icon delete-notif-btn" data-notif-id="${notif.id}" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');

        } catch (error) {
            console.error('Error loading notifications:', error);
            container.innerHTML = `
                <div class="error-state" style="text-align:center;padding:2rem;">
                    <h3>Gagal memuat notifikasi</h3>
                    <button class="btn btn-primary" onclick="location.reload()">Coba Lagi</button>
                </div>`;
            handleApiError(error);
        }
    }

    // ── Update unread count badge ──
    async function updateUnreadBadge() {
        try {
            const data = await api.get('/api/user/notifications/unread-count');
            const badges = document.querySelectorAll('.notif-unread-count, .notification-badge');
            badges.forEach(badge => {
                badge.textContent = data.count;
                badge.style.display = data.count > 0 ? 'flex' : 'none';
            });
        } catch (error) {
            // silently fail
        }
    }

    // ── Initialize filter tabs ──
    function initializeFilterTabs() {
        const tabs = document.querySelectorAll('[data-notif-filter]');
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.notifFilter;
                loadNotifications(currentFilter);
            });
        });
    }

    // ── Initialize action buttons ──
    function initializeActions() {
        // Mark all as read
        const markAllBtn = document.getElementById('markAllReadBtn');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', async function () {
                try {
                    setLoadingState(this, true, 'Menandai...');
                    const response = await api.post('/user/notifications/read-all');
                    if (response.success) {
                        showNotification(response.message, 'success');
                        loadNotifications(currentFilter);
                    }
                } catch (error) {
                    handleApiError(error);
                } finally {
                    setLoadingState(this, false);
                }
            });
        }

        // Delete all
        const deleteAllBtn = document.getElementById('deleteAllNotifBtn');
        if (deleteAllBtn) {
            deleteAllBtn.addEventListener('click', async function () {
                if (!confirm('Hapus semua notifikasi?')) return;
                try {
                    setLoadingState(this, true, 'Menghapus...');
                    const response = await api.delete('/user/notifications');
                    if (response.success) {
                        showNotification(response.message, 'success');
                        loadNotifications(currentFilter);
                    }
                } catch (error) {
                    handleApiError(error);
                } finally {
                    setLoadingState(this, false);
                }
            });
        }

        // Delegated events for per-notification actions
        document.addEventListener('click', async function (e) {
            // Mark single as read
            if (e.target.closest('.mark-read-btn')) {
                const btn = e.target.closest('.mark-read-btn');
                const notifId = btn.dataset.notifId;
                try {
                    await api.post(`/user/notifications/${notifId}/read`);
                    const item = document.querySelector(`.notification-item[data-notif-id="${notifId}"]`);
                    if (item) {
                        item.classList.remove('unread');
                        btn.remove();
                    }
                    updateUnreadBadge();
                } catch (error) {
                    handleApiError(error);
                }
            }

            // Delete single notification
            if (e.target.closest('.delete-notif-btn')) {
                const btn = e.target.closest('.delete-notif-btn');
                const notifId = btn.dataset.notifId;
                try {
                    await api.delete(`/user/notifications/${notifId}`);
                    const item = document.querySelector(`.notification-item[data-notif-id="${notifId}"]`);
                    if (item) item.remove();
                    updateUnreadBadge();
                } catch (error) {
                    handleApiError(error);
                }
            }
        });
    }
});
