document.addEventListener('DOMContentLoaded', function () {
    let currentFilter = 'all';

    initializeMyEvents();

    async function initializeMyEvents() {
        await loadMyEvents();
        initializeFilterTabs();
    }

    // ── Load my events from API ──
    async function loadMyEvents(filter = 'all') {
        const container = document.getElementById('myEventsList');
        if (!container) return;

        container.innerHTML = '<div style="text-align:center;padding:2rem;color:var(--text-muted);">Memuat data...</div>';

        try {
            const params = {};
            if (filter !== 'all') params.status = filter;

            const events = await api.get('/api/user/my-events', params);

            // Update stats
            updateStats(events);

            if (!events || events.length === 0) {
                container.innerHTML = `
                    <div style="text-align:center;padding:3rem;color:var(--text-muted);">
                        <div style="font-size:2.5rem;margin-bottom:.75rem;">📅</div>
                        <div style="font-weight:700;font-size:.975rem;color:var(--text-primary);margin-bottom:.35rem;">Belum ada event</div>
                        <div style="font-size:.82rem;margin-bottom:1rem;">
                            ${filter !== 'all' ? `Tidak ada event dengan status yang dipilih.` : 'Anda belum mendaftar ke event apapun.'}
                        </div>
                        <a href="/user/events" style="display:inline-block;padding:.5rem 1.25rem;background:#0f1f4e;color:#fff;border-radius:.625rem;font-size:.82rem;font-weight:700;text-decoration:none;">
                            Cari Event
                        </a>
                    </div>`;
                return;
            }

            container.innerHTML = events.map(event => {
                const statusMap = {
                    registered: { label: 'Terdaftar',   cls: 'registered' },
                    present:    { label: 'Hadir ✓',     cls: 'attended' },
                    absent:     { label: 'Tidak Hadir', cls: 'absent' },
                    cancelled:  { label: 'Dibatalkan',  cls: 'absent' },
                };
                const statusInfo = statusMap[event.attendance_status] || { label: event.attendance_status, cls: '' };

                // Category badge color mapping
                const catSlug = event.category.toLowerCase().replace(/\s+/g, '-');
                const catCls  = ['seminar','workshop','competition','career'].find(c => catSlug.includes(c)) || 'seminar';

                const cancelBtn = (event.attendance_status === 'registered' && event.is_upcoming)
                    ? `<button class="myev-btn-detail cancel-btn" style="border-color:#fca5a5;color:#ef4444;"
                               data-event-id="${event.id}" data-event-name="${escHtml(event.name)}">
                           Batalkan
                       </button>`
                    : '';

                const certBtn = event.can_get_certificate
                    ? `<a href="/user/certificates" class="myev-btn-detail" style="background:#dcfce7;border-color:#86efac;color:#15803d;">
                           🏆 Sertifikat
                       </a>`
                    : '';

                const certBadge = event.has_certificate
                    ? `<span style="font-size:.62rem;background:#dcfce7;color:#15803d;padding:.1rem .45rem;border-radius:999px;font-weight:700;margin-left:.35rem;">🏆 Sertifikat</span>`
                    : '';

                return `
                <div class="myev-item" data-event-id="${event.id}">
                    <div class="myev-item-img">
                        <img src="${event.banner_url}" alt="${escHtml(event.name)}" loading="lazy"
                             onerror="this.src='${window.location.origin}/images/seminar.png'">
                    </div>
                    <div class="myev-item-body">
                        <div class="myev-item-left">
                            <span class="myev-item-cat ${catCls}">${escHtml(event.category)}</span>
                            <div class="myev-item-title">${escHtml(event.name)}${certBadge}</div>
                            <div class="myev-item-meta">
                                <span class="myev-item-meta-i">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    ${event.date}
                                </span>
                                <span class="myev-item-meta-i">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    ${event.time}
                                </span>
                                <span class="myev-item-meta-i">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    ${escHtml(event.location)}
                                </span>
                            </div>
                            <div style="font-size:.7rem;color:var(--text-muted);margin-top:.35rem;">
                                Didaftarkan: ${event.registration_date}
                            </div>
                        </div>
                        <div class="myev-item-right">
                            <span class="myev-status ${statusInfo.cls}">${statusInfo.label}</span>
                            <a href="/user/events/${event.id}" class="myev-btn-detail">Detail</a>
                            ${certBtn}
                            ${cancelBtn}
                        </div>
                    </div>
                </div>`;
            }).join('');

        } catch (error) {
            console.error('Error loading my events:', error);
            container.innerHTML = `
                <div style="text-align:center;padding:3rem;color:var(--text-muted);">
                    <div style="font-size:2rem;margin-bottom:.75rem;">⚠️</div>
                    <div style="font-weight:600;">Gagal memuat event</div>
                    <button onclick="location.reload()" style="margin-top:.75rem;padding:.45rem 1rem;border-radius:.625rem;border:1.5px solid var(--border-color);background:var(--bg-secondary);cursor:pointer;font-size:.82rem;">
                        Coba Lagi
                    </button>
                </div>`;
            if (typeof handleApiError === 'function') handleApiError(error);
        }
    }

    // ── Update stats from the loaded events ──
    function updateStats(events) {
        if (!events) events = [];
        const total    = events.length;
        const upcoming = events.filter(e => e.is_upcoming && e.attendance_status !== 'cancelled').length;
        const attended = events.filter(e => e.attendance_status === 'present').length;
        const certs    = events.filter(e => e.can_get_certificate).length;

        const set = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
        set('statTotal',    total);
        set('statUpcoming', upcoming);
        set('statAttended', attended);
        set('statCerts',    certs);
    }

    // ── Initialize filter chips ──
    function initializeFilterTabs() {
        const chips = document.querySelectorAll('[data-filter]');
        chips.forEach(chip => {
            chip.addEventListener('click', function () {
                chips.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.filter;
                loadMyEvents(currentFilter);
            });
        });

        // Cancel registration (event delegation)
        document.addEventListener('click', async function (e) {
            const btn = e.target.closest('.cancel-btn');
            if (!btn) return;

            const eventId   = btn.dataset.eventId;
            const eventName = btn.dataset.eventName;
            if (!confirm(`Batalkan pendaftaran untuk "${eventName}"?`)) return;

            try {
                if (typeof setLoadingState === 'function') setLoadingState(btn, true, 'Membatalkan...');
                const response = await api.post('/user/events/cancel', { event_id: eventId });
                if (response.success) {
                    if (typeof showNotification === 'function') showNotification(response.message, 'success');
                    loadMyEvents(currentFilter);
                }
            } catch (error) {
                if (typeof handleApiError === 'function') handleApiError(error);
            } finally {
                if (typeof setLoadingState === 'function') setLoadingState(btn, false);
            }
        });
    }

    // ── HTML escape helper ──
    function escHtml(str) {
        return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
});
