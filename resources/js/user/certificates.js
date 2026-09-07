/**
 * Certificates — pakai fetch langsung (tidak bergantung window.api)
 */
document.addEventListener('DOMContentLoaded', function () {
    var currentFilter = 'all';
    var CSRF = document.querySelector('meta[name="csrf-token"]')
        ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

    loadCertificates();
    initFilters();

    // ── Fetch helper ──
    function apiFetch(url) {
        return fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF
            }
        }).then(function (r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        });
    }

    // ── Load certificates ──
    function loadCertificates(filter, search) {
        filter = filter || 'all';
        search = search || '';

        var container = document.getElementById('certificatesGrid');
        if (!container) return;

        container.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text-muted);">'
            + '<iconify-icon icon="solar:medal-ribbons-star-linear" width="36" height="36" style="margin-bottom:.75rem;display:block;margin-left:auto;margin-right:auto;"></iconify-icon>'
            + '<p>Memuat sertifikat...</p></div>';

        var url = '/api/user/certificates';
        var params = [];
        if (filter !== 'all') params.push('type=' + encodeURIComponent(filter));
        if (search)           params.push('search=' + encodeURIComponent(search));
        if (params.length)    url += '?' + params.join('&');

        apiFetch(url)
            .then(function (certs) { renderCertificates(certs, container); })
            .catch(function (err) {
                console.error('Certificates error:', err);
                container.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text-muted);">'
                    + '<iconify-icon icon="solar:danger-triangle-linear" width="36" height="36" style="margin-bottom:.75rem;display:block;margin-left:auto;margin-right:auto;"></iconify-icon>'
                    + '<p style="font-weight:600;margin-bottom:.5rem;">Gagal memuat sertifikat</p>'
                    + '<button onclick="location.reload()" style="padding:.45rem 1rem;border-radius:.625rem;border:1.5px solid var(--border-color);background:var(--bg-secondary);cursor:pointer;font-size:.82rem;">Coba Lagi</button>'
                    + '</div>';
            });
    }

    // ── Render certificate grid ──
    function renderCertificates(certs, container) {
        if (!certs || certs.length === 0) {
            container.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:4rem;color:var(--text-muted);">'
                + '<iconify-icon icon="solar:medal-ribbons-star-linear" width="48" height="48" style="margin-bottom:1rem;display:block;margin-left:auto;margin-right:auto;opacity:.4;"></iconify-icon>'
                + '<h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:.35rem;">Belum ada sertifikat</h3>'
                + '<p style="font-size:.82rem;margin-bottom:1rem;">Ikuti event dan hadir untuk mendapatkan sertifikat.</p>'
                + '<a href="/user/events" style="display:inline-block;padding:.5rem 1.25rem;background:#0f1f4e;color:#fff;border-radius:.625rem;font-size:.82rem;font-weight:700;text-decoration:none;">Lihat Event</a>'
                + '</div>';
            return;
        }

        container.innerHTML = certs.map(function (cert) {
            var typeLabel = (cert.certificate_type || 'participation').replace(/_/g, ' ');
            typeLabel = typeLabel.charAt(0).toUpperCase() + typeLabel.slice(1);

            return '<div class="certificate-card" style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:1.125rem;overflow:hidden;display:flex;flex-direction:column;">'

                // Header: icon + badge
                + '<div style="background:linear-gradient(135deg,#0f1f4e 0%,#1d4ed8 100%);padding:1.5rem;text-align:center;position:relative;">'
                + '<iconify-icon icon="solar:medal-ribbons-star-bold" width="48" height="48" style="color:#fbbf24;display:block;margin:0 auto .5rem;"></iconify-icon>'
                + '<span style="background:rgba(255,255,255,.15);color:#fff;padding:.2rem .65rem;border-radius:999px;font-size:.68rem;font-weight:700;">' + typeLabel + '</span>'
                + '</div>'

                // Body
                + '<div style="padding:1rem;flex:1;display:flex;flex-direction:column;gap:.5rem;">'
                + '<h4 style="font-size:.925rem;font-weight:800;color:var(--text-primary);line-height:1.3;margin:0;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">' + esc(cert.event_name) + '</h4>'
                + '<p style="font-size:.75rem;color:var(--text-muted);margin:0;">' + esc(cert.event_category) + '</p>'
                + '<div style="display:flex;flex-direction:column;gap:.3rem;margin-top:auto;">'
                + '<div style="display:flex;align-items:center;gap:.35rem;font-size:.75rem;color:var(--text-muted);">'
                + '<iconify-icon icon="solar:calendar-linear"></iconify-icon> ' + esc(cert.event_date) + '</div>'
                + '<div style="display:flex;align-items:center;gap:.35rem;font-size:.75rem;color:var(--text-muted);">'
                + '<iconify-icon icon="solar:card-linear"></iconify-icon> No. ' + esc(cert.certificate_number) + '</div>'
                + '<div style="display:flex;align-items:center;gap:.35rem;font-size:.75rem;color:#10b981;font-weight:600;">'
                + '<iconify-icon icon="solar:check-circle-linear"></iconify-icon> Diterbitkan ' + esc(cert.issued_date) + '</div>'
                + '</div></div>'

                // Actions
                + '<div style="padding:.75rem 1rem;border-top:1px solid var(--border-color);display:flex;gap:.5rem;">'
                + '<button class="view-cert-btn" data-cert-id="' + cert.id + '" '
                + 'style="flex:1;padding:.5rem;border-radius:.625rem;border:1.5px solid var(--border-color);background:var(--bg-primary);color:var(--text-secondary);font-size:.775rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.3rem;font-family:inherit;">'
                + '<iconify-icon icon="solar:eye-linear"></iconify-icon> Lihat'
                + '</button>'
                + (cert.certificate_url
                    ? '<a href="' + cert.certificate_url + '" download style="flex:1;padding:.5rem;border-radius:.625rem;border:none;background:#0f1f4e;color:#fff;font-size:.775rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.3rem;text-decoration:none;">'
                      + '<iconify-icon icon="solar:download-linear"></iconify-icon> Unduh</a>'
                    : '<button disabled style="flex:1;padding:.5rem;border-radius:.625rem;border:1.5px solid var(--border-color);background:var(--bg-tertiary);color:var(--text-muted);font-size:.775rem;font-weight:700;cursor:not-allowed;display:flex;align-items:center;justify-content:center;gap:.3rem;font-family:inherit;">Belum tersedia</button>'
                  )
                + '</div>'
                + '</div>';
        }).join('');
    }

    // ── Init filters & modal ──
    function initFilters() {
        // Search
        var searchInput = document.getElementById('certSearch');
        if (searchInput) {
            var debounce;
            searchInput.addEventListener('input', function () {
                clearTimeout(debounce);
                debounce = setTimeout(function () {
                    loadCertificates(currentFilter, searchInput.value.trim());
                }, 400);
            });
        }

        // Type filter
        var typeFilter = document.getElementById('typeFilter');
        if (typeFilter) {
            typeFilter.addEventListener('change', function () {
                currentFilter = this.value;
                loadCertificates(currentFilter);
            });
        }

        // Modal close
        var modal = document.getElementById('certPreviewModal');
        var closeBtn = document.getElementById('closeCertModal');
        if (closeBtn && modal) {
            closeBtn.addEventListener('click', function () { closeModal(modal); });
            modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(modal); });
        }
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal) closeModal(modal);
        });

        // View button (delegated)
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.view-cert-btn');
            if (btn) showCertDetail(btn.dataset.certId);
        });
    }

    function closeModal(modal) {
        if (modal) { modal.classList.remove('active'); document.body.style.overflow = ''; }
    }

    // ── Show cert detail modal ──
    function showCertDetail(certId) {
        var modal   = document.getElementById('certPreviewModal');
        var content = document.getElementById('certModalContent');
        if (!modal || !content) return;

        content.innerHTML = '<div style="text-align:center;padding:1.5rem;"><p>Memuat...</p></div>';
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';

        apiFetch('/user/certificates/' + certId + '/view')
            .then(function (cert) {
                content.innerHTML = '<div style="text-align:center;padding:1.5rem;">'
                    + '<iconify-icon icon="solar:medal-ribbons-star-bold" width="48" height="48" style="color:#fbbf24;margin-bottom:.75rem;display:block;margin-left:auto;margin-right:auto;"></iconify-icon>'
                    + '<h3 style="font-size:1.1rem;font-weight:800;margin-bottom:.25rem;">Certificate of ' + esc(cert.certificate_type) + '</h3>'
                    + '<p style="font-size:.82rem;color:#64748b;margin-bottom:.5rem;">Diberikan kepada:</p>'
                    + '<div style="font-size:1.3rem;font-weight:800;color:var(--text-primary);margin-bottom:.2rem;">' + esc(cert.user_name || (window.authUserName || '')) + '</div>'
                    + '<div style="font-size:.78rem;color:#64748b;margin-bottom:1rem;">'
                    + esc(cert.user_nis || (window.authUserNis || '')) + ' · ' + esc(cert.user_class || (window.authUserClass || ''))
                    + '</div>'
                    + '<p style="font-size:.875rem;margin-bottom:.4rem;">atas keikutsertaannya dalam</p>'
                    + '<p style="font-size:1rem;font-weight:700;color:#1d4ed8;margin-bottom:.4rem;">' + esc(cert.event_name) + '</p>'
                    + '<p style="font-size:.78rem;color:#64748b;">📅 ' + esc(cert.event_date) + ' · Diterbitkan: ' + esc(cert.issued_date) + '</p>'
                    + '<div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #e2e8f0;font-size:.7rem;color:#94a3b8;">No. ' + esc(cert.certificate_number) + '</div>'
                    + (cert.certificate_url ? '<a href="' + cert.certificate_url + '" download style="display:inline-flex;align-items:center;gap:.4rem;margin-top:1rem;padding:.65rem 1.25rem;background:#0f1f4e;color:#fff;border-radius:.75rem;text-decoration:none;font-weight:700;font-size:.875rem;"><iconify-icon icon="solar:download-linear"></iconify-icon> Download PDF</a>' : '')
                    + '</div>';
            })
            .catch(function (err) {
                console.error(err);
                content.innerHTML = '<div style="text-align:center;padding:1.5rem;">'
                    + '<p style="color:#ef4444;">Gagal memuat detail sertifikat.</p>'
                    + '<button onclick="document.getElementById(\'certPreviewModal\').classList.remove(\'active\')" '
                    + 'style="margin-top:.75rem;padding:.45rem 1rem;border-radius:.5rem;border:1.5px solid var(--border-color);cursor:pointer;background:var(--bg-secondary);">Tutup</button>'
                    + '</div>';
            });
    }

    // ── HTML escape ──
    function esc(str) {
        return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
});
