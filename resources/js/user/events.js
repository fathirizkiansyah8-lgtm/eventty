document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 1;
    let currentFilters = { search: '', category: 'all', status: 'all', sort: 'date' };
    let isLoading = false;

    initializeEventsPage();

    async function initializeEventsPage() {
        await loadCategories();
        await loadEvents();
        initializeFilters();
    }

    // ── Load categories for filter dropdown ──
    async function loadCategories() {
        try {
            // Gunakan endpoint yang accessible oleh student (bukan admin)
            const categories = await api.get('/api/user/categories');
            const select = document.getElementById('categoryFilter');
            if (!select || !categories) return;

            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.name;
                select.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }

    // ── Load events list from API ──
    async function loadEvents(page = 1) {
        if (isLoading) return;
        isLoading = true;

        const container = document.getElementById('eventsGrid') || document.querySelector('.events-grid');
        if (container) {
            container.innerHTML = `
                <div class="loading-state" style="grid-column:1/-1;text-align:center;padding:3rem;">
                    <div class="spinner"></div>
                    <p>Memuat event...</p>
                </div>`;
        }

        try {
            const params = { page, ...currentFilters };
            Object.keys(params).forEach(key => {
                if (params[key] === 'all' || params[key] === '') delete params[key];
            });

            const response = await api.get('/api/user/events', params);

            if (!container) return;

            const events = response.data || [];

            if (events.length === 0) {
                container.innerHTML = `
                    <div class="ev-empty-state">
                        <iconify-icon icon="lucide:calendar-search" width="48" height="48"></iconify-icon>
                        <h3>Tidak ada event ditemukan</h3>
                        <p>Coba ubah filter atau kata kunci pencarian Anda.</p>
                    </div>`;
                updatePagination(response, page);
                return;
            }

            container.innerHTML = events.map(event => {
                const pct = event.quota > 0
                    ? Math.min(100, Math.round(event.registered_count / event.quota * 100))
                    : 0;
                const fillClass = pct >= 90 ? 'danger' : pct >= 70 ? 'warn' : '';

                const imgHtml = `<img src="${event.banner_url}" alt="${event.name}" loading="lazy"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                     <div class="ev-card-img-placeholder" style="display:none;">
                         <iconify-icon icon="lucide:image-off" width="40" height="40"></iconify-icon>
                     </div>`;

                const certBadge = event.has_certificate
                    ? `<span class="ev-card-cert"><iconify-icon icon="lucide:badge-check"></iconify-icon> Sertifikat</span>` : '';

                const fullBadge = event.is_full
                    ? `<span class="ev-card-full">Penuh</span>` : '';

                let actionBtn = '';
                if (event.is_registered) {
                    actionBtn = `<button class="ev-btn-registered" disabled>
                        <iconify-icon icon="lucide:check"></iconify-icon> Terdaftar
                    </button>`;
                } else if (event.is_full || event.status !== 'open') {
                    actionBtn = `<button class="ev-btn-full" disabled>Tidak Tersedia</button>`;
                } else {
                    actionBtn = `<button class="ev-btn-register register-btn"
                        data-event-id="${event.id}"
                        data-event-name="${event.name.replace(/"/g,'&quot;')}">
                        Daftar
                    </button>`;
                }

                return `
                <div class="ev-card" onclick="if(!event.target.closest('button'))window.location='/user/events/${event.id}'" data-event-id="${event.id}">
                    <div class="ev-card-img">
                        ${imgHtml}
                        <span class="ev-card-cat" style="background:${event.category_color}">${event.category}</span>
                        ${certBadge}
                        ${fullBadge}
                    </div>
                    <div class="ev-card-body">
                        <div class="ev-card-name">${event.name}</div>
                        <div class="ev-card-meta">
                            <div class="ev-card-meta-item">
                                <iconify-icon icon="lucide:calendar-days"></iconify-icon>
                                <span>${event.date}</span>
                            </div>
                            <div class="ev-card-meta-item">
                                <iconify-icon icon="lucide:clock-3"></iconify-icon>
                                <span>${event.time}</span>
                            </div>
                            <div class="ev-card-meta-item">
                                <iconify-icon icon="lucide:map-pin"></iconify-icon>
                                <span>${event.location}</span>
                            </div>
                        </div>
                        <div class="ev-card-quota-wrap">
                            <div class="ev-card-quota-row">
                                <span>${event.registered_count}/${event.quota} peserta</span>
                                <span>${pct}%</span>
                            </div>
                            <div class="ev-card-quota-bar">
                                <div class="ev-card-quota-fill ${fillClass}" style="width:${pct}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ev-card-footer">
                        <a href="/user/events/${event.id}" class="ev-btn-detail" onclick="event.stopPropagation()">
                            Detail
                        </a>
                        ${actionBtn}
                    </div>
                </div>`;
            }).join('');

            updatePagination(response, page);
            currentPage = page;

        } catch (error) {
            console.error('Error loading events:', error);
            if (container) {
                container.innerHTML = `
                    <div class="error-state" style="grid-column:1/-1;text-align:center;padding:3rem;">
                        <div style="font-size:2rem;margin-bottom:1rem;">⚠️</div>
                        <h3>Gagal memuat event</h3>
                        <button class="btn btn-primary" onclick="location.reload()">Coba Lagi</button>
                    </div>`;
            }
            handleApiError(error);
        } finally {
            isLoading = false;
        }
    }

    // ── Update pagination UI ──
    function updatePagination(response, currentPage) {
        const paginationContainer = document.getElementById('pagination');
        if (!paginationContainer) return;

        const lastPage = response.last_page || 1;
        const total    = response.total    || 0;
        const from     = response.from     || 0;
        const to       = response.to       || 0;

        if (lastPage <= 1) {
            paginationContainer.innerHTML = total > 0
                ? `<div class="ev-pagination-info">Menampilkan ${total} event</div>` : '';
            return;
        }

        let btns = '';
        if (currentPage > 1) {
            btns += `<button class="ev-page-btn" data-page="${currentPage - 1}">
                <iconify-icon icon="lucide:chevron-left"></iconify-icon>
            </button>`;
        }
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
            btns += `<button class="ev-page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
        }
        if (currentPage < lastPage) {
            btns += `<button class="ev-page-btn" data-page="${currentPage + 1}">
                <iconify-icon icon="lucide:chevron-right"></iconify-icon>
            </button>`;
        }

        paginationContainer.innerHTML = `
            <div class="ev-pagination-info">Menampilkan ${from}–${to} dari ${total} event</div>
            <div class="ev-pagination-btns">${btns}</div>`;
    }

    // ── Initialize filter event listeners ──
    function initializeFilters() {
        // Search input
        const searchInput = document.getElementById('searchInput') || document.querySelector('.search-input');
        if (searchInput) {
            let debounceTimer;
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    currentFilters.search = this.value.trim();
                    loadEvents(1);
                }, 400);
            });
        }

        // Category filter
        const categoryFilter = document.getElementById('categoryFilter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', function () {
                currentFilters.category = this.value;
                loadEvents(1);
            });
        }

        // Status filter
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', function () {
                currentFilters.status = this.value;
                loadEvents(1);
            });
        }

        // Sort filter
        const sortFilter = document.getElementById('sortFilter');
        if (sortFilter) {
            sortFilter.addEventListener('change', function () {
                currentFilters.sort = this.value;
                loadEvents(1);
            });
        }

        // Pagination (delegated)
        document.addEventListener('click', function (e) {
            if (e.target.closest('.ev-page-btn')) {
                const btn = e.target.closest('.ev-page-btn');
                const page = parseInt(btn.dataset.page);
                if (page && page !== currentPage) loadEvents(page);
            }

            // Registration button
            if (e.target.classList.contains('register-btn')) {
                const eventId = e.target.dataset.eventId;
                const eventName = e.target.dataset.eventName;
                handleRegistration(eventId, eventName, e.target);
            }
        });
    }

    // ── Handle event registration ──
    async function handleRegistration(eventId, eventName, button) {
        if (!confirm(`Daftar ke event "${eventName}"?`)) return;

        try {
            setLoadingState(button, true, 'Mendaftar...');
            const response = await api.post('/user/events/register', { event_id: eventId });

            if (response.success) {
                showNotification(response.message, 'success');
                button.textContent = '✓ Terdaftar';
                button.classList.replace('btn-primary', 'btn-success');
                button.classList.remove('register-btn');
                button.disabled = true;
            }
        } catch (error) {
            handleApiError(error);
        } finally {
            setLoadingState(button, false);
        }
    }
});
