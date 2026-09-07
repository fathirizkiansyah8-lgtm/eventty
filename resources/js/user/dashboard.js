document.addEventListener('DOMContentLoaded', function () {

    // ── Animate stat numbers yang sudah di-render server-side ──
    // Target: .mini-stat-num (bukan [data-stat] yang tidak ada di blade)
    animateStats();

    // ── Handle register button dari event rows di dashboard ──
    initRegisterButtons();

    // ── Dynamic greeting berdasarkan jam ──
    updateGreeting();


    // =========================================
    // ANIMATE STATS
    // =========================================
    function animateStats() {
        document.querySelectorAll('.mini-stat-num').forEach(function (el) {
            var raw = el.textContent.trim();
            var target = parseInt(raw, 10);
            if (isNaN(target) || target === 0) return;

            el.textContent = '0';
            var start = Date.now();
            var duration = 1200;

            function tick() {
                var elapsed = Date.now() - start;
                var progress = Math.min(elapsed / duration, 1);
                // ease-out cubic
                var eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target);
                if (progress < 1) requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
        });
    }


    // =========================================
    // REGISTER BUTTONS di event rows dashboard
    // =========================================
    function initRegisterButtons() {
        var CSRF = document.querySelector('meta[name="csrf-token"]')
            ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

        document.addEventListener('click', function (e) {
            // Tombol daftar di event-row dashboard
            var btn = e.target.closest('.dashboard-register-btn');
            if (!btn) return;

            var eventId = btn.dataset.eventId;
            var eventName = btn.dataset.eventName;
            if (!eventId) return;

            if (!confirm('Daftar ke event "' + eventName + '"?')) return;

            btn.disabled = true;
            btn.textContent = 'Mendaftar...';

            fetch('/user/events/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ event_id: eventId })
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    showDashToast(data.message, 'success');
                    btn.textContent = '✓ Terdaftar';
                    btn.classList.remove('dashboard-register-btn');
                    btn.style.background = '#10b981';
                    btn.style.color = '#fff';
                    btn.style.cursor = 'default';
                    // Animasikan stats naik 1
                    var joinedEls = document.querySelectorAll('.mini-stat-num');
                    // indeks 0 = events_joined
                    if (joinedEls[0]) {
                        var v = parseInt(joinedEls[0].textContent) || 0;
                        joinedEls[0].textContent = v + 1;
                    }
                } else {
                    showDashToast(data.message || 'Gagal mendaftar.', 'error');
                    btn.disabled = false;
                    btn.textContent = 'Daftar';
                }
            })
            .catch(function () {
                showDashToast('Terjadi kesalahan koneksi.', 'error');
                btn.disabled = false;
                btn.textContent = 'Daftar';
            });
        });
    }


    // =========================================
    // GREETING berdasarkan jam
    // =========================================
    function updateGreeting() {
        var el = document.querySelector('.dashboard-greeting');
        if (!el) return;
        var h = new Date().getHours();
        el.textContent = h < 12 ? 'Selamat Pagi' :
                         h < 15 ? 'Selamat Siang' :
                         h < 18 ? 'Selamat Sore' : 'Selamat Malam';
    }


    // =========================================
    // SIMPLE TOAST
    // =========================================
    function showDashToast(msg, type) {
        var old = document.getElementById('dashToast');
        if (old) old.remove();
        var t = document.createElement('div');
        t.id = 'dashToast';
        var bg = type === 'error' ? '#ef4444' : '#10b981';
        t.style.cssText = 'position:fixed;bottom:1.5rem;right:1.5rem;background:' + bg
            + ';color:#fff;padding:.875rem 1.25rem;border-radius:.75rem;'
            + 'font-weight:600;font-size:.875rem;box-shadow:0 4px 16px rgba(0,0,0,.2);'
            + 'z-index:9999;max-width:320px;';
        t.textContent = (type === 'error' ? '❌ ' : '✅ ') + msg;
        document.body.appendChild(t);
        setTimeout(function () { if (t.parentNode) t.remove(); }, 3500);
    }

});
