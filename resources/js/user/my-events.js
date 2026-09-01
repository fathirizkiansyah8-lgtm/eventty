document.addEventListener('DOMContentLoaded', function () {
    let currentFilter = 'all';
    initializeMyEvents();

    async function initializeMyEvents() {
        await loadMyEvents();
        initializeFilterTabs();
    }

    // ── Load my events from API ──
    async function loadMyEvents(filter = 'all') {
        const container = document.getElementById('myEventsList') || document.querySelector('.my-events-list');
        if (!container) return;

        container.innerHTML = `<div class="loading-state" style="text-align:center;padding:3rem;"><p>Memuat event Anda...</p></div>`;

        try {
            const params = {};
            if (filter !== 'all') params.status = filter;

            const events = await api.get('/api/user/my-events', params);

            if (!events || events.length === 0) {
                container.innerHTML = `
                    <div class="empty-state" style="text-align:center;padding:3rem;">
                        <div style="font-size:3rem;margin-bottom:1rem;">📅</div>
                        <h3>Belum ada event</h3>
                        <p>Anda belum mendaftar ke event apapun${filter !== 'all' ? ` dengan status "${filter}"` : ''}.</p>
                        <a href="/user/events" class="btn btn-primary" style="margin-top:1rem;">Cari Event</a>
                    </div>`;
                return;
            }

            container.innerHTML = events.map(event => {
                const statusBadge = getStatusBadge(event.attendance_status);
                return `
                <div class="my-event-card" data-event-id="${event.id}">
                    <div class="my-event-image">
                        <img src="${event.banner_url}" alt="${event.name}" loading="lazy"
                             onerror="this.src='${window.location.origin}/images/seminar.png'">
                    </div>
                    <div class="my-event-content">
                        <div class="my-event-header">
                            <h4 class="my-event-title">${event.name}</h4>
                            ${statusBadge}
                        </div>
                        <div class="my-event-info">
                            <span><i class="fas fa-calendar-alt"></i> ${event.date}</span>
                            <span><i class="fas fa-clock"></i> ${event.time}</span>
                            <span><i class="fas fa-map-marker-alt"></i> ${event.location}</span>
                            <span><i class="fas fa-tag"></i> ${event.category}</span>
                        </div>
                        <div class="my-event-footer-info">
                            <small>Didaftarkan: ${event.registration_date}</small>
                        </div>
                    </div>
                    <div class="my-event-actions">
                        <a href="/user/events/${event.id}" class="btn btn-outline btn-sm">Lihat Detail</a>
                        ${event.can_get_certificate
                            ? `<a href="/user/certificates" class="btn btn-primary btn-sm">Sertifikat</a>`
                            : ''
                        }
                        ${event.attendance_status === 'registered' && event.is_upcoming
                            ? `<button class="btn btn-danger btn-sm cancel-btn" data-event-id="${event.id}" data-event-name="${event.name}">Batalkan</button>`
                            : ''
                        }
                    </div>
                </div>`;
            }).join('');

        } catch (error) {
            console.error('Error loading my events:', error);
            container.innerHTML = `
                <div class="error-state" style="text-align:center;padding:3rem;">
                    <h3>Gagal memuat event</h3>
                    <button class="btn btn-primary" onclick="location.reload()">Coba Lagi</button>
                </div>`;
            handleApiError(error);
        }
    }

    // ── Status badge helper ──
    function getStatusBadge(status) {
        const map = {
            registered: ['Terdaftar', 'badge-info'],
            present: ['Hadir', 'badge-success'],
            absent: ['Tidak Hadir', 'badge-danger'],
            cancelled: ['Dibatalkan', 'badge-secondary'],
            completed: ['Selesai', 'badge-primary'],
        };
        const [label, cls] = map[status] || ['Unknown', 'badge-secondary'];
        return `<span class="badge ${cls}">${label}</span>`;
    }

    // ── Initialize filter tabs ──
    function initializeFilterTabs() {
        const tabs = document.querySelectorAll('[data-filter]');
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.filter;
                loadMyEvents(currentFilter);
            });
        });

        // Cancel registration (delegated)
        document.addEventListener('click', async function (e) {
            if (e.target.classList.contains('cancel-btn')) {
                const eventId = e.target.dataset.eventId;
                const eventName = e.target.dataset.eventName;

                if (!confirm(`Batalkan pendaftaran untuk "${eventName}"?`)) return;

                try {
                    setLoadingState(e.target, true, 'Membatalkan...');
                    const response = await api.post('/user/events/cancel', { event_id: eventId });
                    if (response.success) {
                        showNotification(response.message, 'success');
                        loadMyEvents(currentFilter);
                    }
                } catch (error) {
                    handleApiError(error);
                } finally {
                    setLoadingState(e.target, false);
                }
            }
        });
    }
});
