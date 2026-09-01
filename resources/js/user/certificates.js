document.addEventListener('DOMContentLoaded', function () {
    let currentFilter = 'all';
    initializeCertificates();

    async function initializeCertificates() {
        await loadCertificates();
        initializeFilters();
    }

    // ── Load certificates from API ──
    async function loadCertificates(filter = 'all', search = '') {
        const container = document.getElementById('certificatesGrid') || document.querySelector('.certificates-grid');
        if (!container) return;

        container.innerHTML = `<div class="loading-state" style="grid-column:1/-1;text-align:center;padding:3rem;"><p>Memuat sertifikat...</p></div>`;

        try {
            const params = {};
            if (filter !== 'all') params.type = filter;
            if (search) params.search = search;

            const certificates = await api.get('/api/user/certificates', params);

            if (!certificates || certificates.length === 0) {
                container.innerHTML = `
                    <div class="empty-state" style="grid-column:1/-1;text-align:center;padding:3rem;">
                        <div style="font-size:3rem;margin-bottom:1rem;">🏆</div>
                        <h3>Belum ada sertifikat</h3>
                        <p>Ikuti event dan hadir untuk mendapatkan sertifikat.</p>
                        <a href="/user/events" class="btn btn-primary" style="margin-top:1rem;">Lihat Event</a>
                    </div>`;
                return;
            }

            container.innerHTML = certificates.map(cert => `
                <div class="certificate-card">
                    <div class="cert-header">
                        <div class="cert-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <span class="cert-type-badge badge-success">${cert.certificate_type}</span>
                    </div>
                    <div class="cert-content">
                        <h4 class="cert-event-name">${cert.event_name}</h4>
                        <p class="cert-event-category">${cert.event_category}</p>
                        <div class="cert-details">
                            <span><i class="fas fa-calendar"></i> ${cert.event_date}</span>
                            <span><i class="fas fa-award"></i> ${cert.issued_date}</span>
                            <span><i class="fas fa-id-card"></i> ${cert.certificate_number}</span>
                        </div>
                    </div>
                    <div class="cert-actions">
                        <button class="btn btn-outline btn-sm view-cert-btn"
                                data-cert-id="${cert.id}">
                            <i class="fas fa-eye"></i> Lihat
                        </button>
                        ${cert.certificate_url
                            ? `<a href="${cert.certificate_url}" class="btn btn-primary btn-sm" download>
                                   <i class="fas fa-download"></i> Unduh
                               </a>`
                            : `<button class="btn btn-secondary btn-sm" disabled>Belum tersedia</button>`
                        }
                    </div>
                </div>
            `).join('');

        } catch (error) {
            console.error('Error loading certificates:', error);
            container.innerHTML = `
                <div class="error-state" style="grid-column:1/-1;text-align:center;padding:3rem;">
                    <h3>Gagal memuat sertifikat</h3>
                    <button class="btn btn-primary" onclick="location.reload()">Coba Lagi</button>
                </div>`;
            handleApiError(error);
        }
    }

    // ── Initialize filters ──
    function initializeFilters() {
        const searchInput = document.getElementById('certSearch');
        if (searchInput) {
            let debounce;
            searchInput.addEventListener('input', function () {
                clearTimeout(debounce);
                debounce = setTimeout(() => loadCertificates(currentFilter, this.value), 400);
            });
        }

        const typeFilter = document.getElementById('typeFilter');
        if (typeFilter) {
            typeFilter.addEventListener('change', function () {
                currentFilter = this.value;
                loadCertificates(currentFilter);
            });
        }

        // Close modal
        const closeBtn = document.getElementById('closeCertModal');
        const modal = document.getElementById('certPreviewModal');
        if (closeBtn && modal) {
            closeBtn.addEventListener('click', function () {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }

        // View certificate detail
        document.addEventListener('click', async function (e) {
            if (e.target.closest('.view-cert-btn')) {
                const certId = e.target.closest('.view-cert-btn').dataset.certId;
                await showCertificateDetail(certId);
            }
        });
    }

    // ── Show certificate detail modal ──
    async function showCertificateDetail(certId) {
        try {
            const cert = await api.get(`/user/certificates/${certId}/view`);
            const modal = document.getElementById('certPreviewModal');
            const content = document.getElementById('certModalContent');
            if (!modal || !content) {
                alert(`Sertifikat: ${cert.event_name}\nNomor: ${cert.certificate_number}\nTanggal: ${cert.issued_date}`);
                return;
            }

            content.innerHTML = `
                <div style="text-align:center;padding:1.5rem;">
                    <div style="font-size:2rem;margin-bottom:.5rem;">🏆</div>
                    <h3 style="font-size:1.1rem;font-weight:800;margin-bottom:.25rem;">Certificate of ${cert.certificate_type}</h3>
                    <p style="font-size:.82rem;color:#64748b;margin-bottom:1rem;">Diberikan kepada:</p>
                    <div style="font-size:1.4rem;font-weight:800;color:#0f172a;margin-bottom:.25rem;">${cert.user_name || window.authUserName}</div>
                    <div style="font-size:.78rem;color:#64748b;margin-bottom:1rem;">${cert.user_nis || window.authUserNis} · ${cert.user_class || window.authUserClass}</div>
                    <p style="font-size:.875rem;margin-bottom:.5rem;">atas keikutsertaannya dalam</p>
                    <p style="font-size:1rem;font-weight:700;color:#1d4ed8;margin-bottom:.5rem;">${cert.event_name}</p>
                    <p style="font-size:.78rem;color:#64748b;">📅 ${cert.event_date} &nbsp;|&nbsp; 🏅 Diterbitkan: ${cert.issued_date}</p>
                    <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #e2e8f0;font-size:.7rem;color:#94a3b8;">No. ${cert.certificate_number}</div>
                    ${cert.certificate_url ? `<a href="${cert.certificate_url}" class="btn btn-primary" style="margin-top:1rem;display:inline-block;" download>⬇ Download PDF</a>` : ''}
                </div>
            `;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        } catch (error) {
            handleApiError(error);
        }
    }
});
