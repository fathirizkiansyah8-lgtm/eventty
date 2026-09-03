/**
 * My Events — menggunakan fetch langsung agar tidak bergantung
 * pada window.api yang mungkin belum siap saat modul ini dieksekusi.
 */
document.addEventListener('DOMContentLoaded', function () {
    var currentFilter = 'all';
    var CSRF = document.querySelector('meta[name="csrf-token"]')
               ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
               : '';

    loadMyEvents();
    initFilters();

    // ── Load events dari API ──
    function loadMyEvents(filter) {
        filter = filter || 'all';
        var container = document.getElementById('myEventsList');
        if (!container) return;

        container.innerHTML = '<div style="text-align:center;padding:2rem;color:var(--text-muted);">Memuat data...</div>';

        var url = '/api/user/my-events';
        if (filter !== 'all') url += '?status=' + encodeURIComponent(filter);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF
            }
        })
        .then(function(r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(function(events) {
            updateStats(events);
            renderEvents(events, container, filter);
        })
        .catch(function(err) {
            console.error('My events error:', err);
            container.innerHTML = '<div style="text-align:center;padding:3rem;color:var(--text-muted);">'
                + '<div style="font-size:2rem;margin-bottom:.75rem;">⚠️</div>'
                + '<div style="font-weight:600;margin-bottom:.5rem;">Gagal memuat event</div>'
                + '<button onclick="location.reload()" style="padding:.45rem 1rem;border-radius:.625rem;border:1.5px solid var(--border-color);background:var(--bg-secondary);cursor:pointer;font-size:.82rem;">Coba Lagi</button>'
                + '</div>';
        });
    }

    // ── Render event list ──
    function renderEvents(events, container, filter) {
        if (!events || events.length === 0) {
            container.innerHTML = '<div style="text-align:center;padding:3rem;color:var(--text-muted);">'
                + '<div style="font-size:2.5rem;margin-bottom:.75rem;">📅</div>'
                + '<div style="font-weight:700;font-size:.975rem;color:var(--text-primary);margin-bottom:.35rem;">Belum ada event</div>'
                + '<div style="font-size:.82rem;margin-bottom:1rem;">'
                + (filter !== 'all' ? 'Tidak ada event dengan status yang dipilih.' : 'Anda belum mendaftar ke event apapun.')
                + '</div>'
                + '<a href="/user/events" style="display:inline-block;padding:.5rem 1.25rem;background:#0f1f4e;color:#fff;border-radius:.625rem;font-size:.82rem;font-weight:700;text-decoration:none;">Cari Event</a>'
                + '</div>';
            return;
        }

        var statusMap = {
            registered: { label: 'Terdaftar',   cls: 'registered' },
            present:    { label: 'Hadir',        cls: 'attended'   },
            absent:     { label: 'Tidak Hadir',  cls: 'absent'     },
            cancelled:  { label: 'Dibatalkan',   cls: 'absent'     }
        };

        container.innerHTML = events.map(function(event) {
            var sInfo = statusMap[event.attendance_status] || { label: event.attendance_status, cls: '' };
            var catName = (event.category || '').toLowerCase();
            var catCls = ['seminar','workshop','competition','career'].find(function(c) {
                return catName.indexOf(c) !== -1;
            }) || 'seminar';

            var certBadge = event.has_certificate
                ? '<span style="margin-left:.35rem;font-size:.62rem;background:#dcfce7;color:#15803d;padding:.1rem .45rem;border-radius:999px;font-weight:700;">🏆 Sertifikat</span>'
                : '';

            var cancelBtn = (event.attendance_status === 'registered' && event.is_upcoming)
                ? '<button class="myev-btn-detail cancel-btn" style="border-color:#fca5a5;color:#ef4444;" data-event-id="' + event.id + '" data-event-name="' + esc(event.name) + '">Batalkan</button>'
                : '';

            var certBtn = event.can_get_certificate
                ? '<a href="/user/certificates" class="myev-btn-detail" style="background:#dcfce7;border-color:#86efac;color:#15803d;">🏆 Sertifikat</a>'
                : '';

            var thumb = event.banner_url
                ? '<img src="' + esc(event.banner_url) + '" alt="' + esc(event.name) + '" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;" onerror="this.parentElement.innerHTML=\'🎉\';this.parentElement.style.display=\'flex\';this.parentElement.style.alignItems=\'center\';this.parentElement.style.justifyContent=\'center\';this.parentElement.style.fontSize=\'2rem\';">'
                : '<div style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;font-size:2rem;">🎉</div>';

            return '<div class="myev-item" data-event-id="' + event.id + '">'
                + '<div class="myev-item-img">' + thumb + '</div>'
                + '<div class="myev-item-body">'
                + '<div class="myev-item-left">'
                + '<span class="myev-item-cat ' + catCls + '">' + esc(event.category) + '</span>'
                + '<div class="myev-item-title">' + esc(event.name) + certBadge + '</div>'
                + '<div class="myev-item-meta">'
                + '<span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> ' + esc(event.date) + '</span>'
                + '<span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> ' + esc(event.time) + '</span>'
                + '<span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> ' + esc(event.location) + '</span>'
                + '</div>'
                + '<div style="font-size:.7rem;color:var(--text-muted);margin-top:.35rem;">Didaftarkan: ' + esc(event.registration_date) + '</div>'
                + '</div>'
                + '<div class="myev-item-right">'
                + '<span class="myev-status ' + sInfo.cls + '">' + sInfo.label + '</span>'
                + '<a href="/user/events/' + event.id + '" class="myev-btn-detail">Detail</a>'
                + certBtn
                + cancelBtn
                + '</div>'
                + '</div>'
                + '</div>';
        }).join('');
    }

    // ── Update stats ──
    function updateStats(events) {
        if (!events) events = [];
        var set = function(id, val) { var el = document.getElementById(id); if (el) el.textContent = val; };
        set('statTotal',    events.length);
        set('statUpcoming', events.filter(function(e) { return e.is_upcoming && e.attendance_status !== 'cancelled'; }).length);
        set('statAttended', events.filter(function(e) { return e.attendance_status === 'present'; }).length);
        set('statCerts',    events.filter(function(e) { return e.can_get_certificate; }).length);
    }

    // ── Filter chips ──
    function initFilters() {
        var chips = document.querySelectorAll('[data-filter]');
        chips.forEach(function(chip) {
            chip.addEventListener('click', function() {
                chips.forEach(function(c) { c.classList.remove('active'); });
                this.classList.add('active');
                currentFilter = this.dataset.filter;
                loadMyEvents(currentFilter);
            });
        });

        // Cancel (delegated)
        document.addEventListener('click', function(e) {
            var btn = e.target.closest ? e.target.closest('.cancel-btn') : null;
            if (!btn) return;

            var eventId   = btn.dataset.eventId;
            var eventName = btn.dataset.eventName;
            if (!confirm('Batalkan pendaftaran untuk "' + eventName + '"?')) return;

            btn.disabled = true;
            btn.textContent = 'Membatalkan...';

            fetch('/user/events/cancel', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ event_id: eventId })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    showSimpleToast(data.message, 'success');
                    loadMyEvents(currentFilter);
                } else {
                    showSimpleToast(data.message || 'Gagal membatalkan.', 'error');
                    btn.disabled = false;
                    btn.textContent = 'Batalkan';
                }
            })
            .catch(function() {
                showSimpleToast('Terjadi kesalahan.', 'error');
                btn.disabled = false;
                btn.textContent = 'Batalkan';
            });
        });
    }

    // ── HTML escape ──
    function esc(str) {
        return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // ── Simple toast ──
    function showSimpleToast(msg, type) {
        var old = document.getElementById('myEvToast');
        if (old) old.remove();
        var toast = document.createElement('div');
        toast.id = 'myEvToast';
        var bg = type === 'error' ? '#ef4444' : '#10b981';
        toast.style.cssText = 'position:fixed;bottom:1.5rem;right:1.5rem;background:' + bg
            + ';color:#fff;padding:.875rem 1.25rem;border-radius:.75rem;font-weight:600;'
            + 'font-size:.875rem;box-shadow:0 4px 12px rgba(0,0,0,.15);z-index:9999;max-width:320px;';
        toast.textContent = (type === 'error' ? '❌ ' : '✅ ') + msg;
        document.body.appendChild(toast);
        setTimeout(function() { if (toast.parentNode) toast.remove(); }, 3000);
    }
});
