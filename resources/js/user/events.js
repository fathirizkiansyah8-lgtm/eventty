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
                    <div class="empty-state" style="grid-column:1/-1;text-align:center;padding:3rem;">
                        <div style="font-size:3rem;margin-bottom:1rem;">🎉</div>
                        <h3>Tidak ada event ditemukan</h3>
                        <p>Coba ubah filter atau kata kunci pencarian Anda.</p>
                    </div>`;
                updatePagination(response, page);
                return;
            }

            container.innerHTML = events.map(event => `
                <div class="event-card" data-event-id="${event.id}">
                    <div class="event-image">
                        <img src="${event.banner_url}" alt="${event.name}" loading="lazy"
                             onerror="this.src='${window.location.origin}/images/seminar.png'">
                        <span class="event-category-badge" style="background:${event.category_color}">
                            ${event.category}
                        </span>
                        ${event.has_certificate ? '<span style="position:absolute;top:.5rem;right:.5rem;background:#10b981;color:#fff;padding:.2rem .55rem;border-radius:999px;font-size:.65rem;font-weight:700;">🏆 Sertifikat</span>' : ''}
                        ${event.is_full ? '<span class="event-full-badge">Penuh</span>' : ''}
                    </div>
                    <div class="event-content">
                        <h4 class="event-title">${event.name}</h4>
                        <div class="event-info">
                            <span><i class="fas fa-calendar-alt"></i> ${event.date}</span>
                            <span><i class="fas fa-clock"></i> ${event.time}</span>
                            <span><i class="fas fa-map-marker-alt"></i> ${event.location}</span>
                        </div>
                        <div class="event-quota-bar">
                            <div class="quota-fill" style="width:${Math.min(100, Math.round(event.registered_count/event.quota*100))}%"></div>
                        </div>
                        <div class="event-quota-text">${event.registered_count}/${event.quota} peserta</div>
                    </div>
                    <div class="event-footer">
                        <a href="/user/events/${event.id}" class="btn btn-outline">Detail</a>
                        ${event.is_registered
                            ? '<button class="btn btn-success" disabled>✓ Terdaftar</button>'
                            : event.is_full
                                ? '<button class="btn btn-secondary" disabled>Penuh</button>'
                                : `<button class="btn btn-primary register-btn" data-event-id="${event.id}" data-event-name="${event.name}">Daftar</button>`
                        }
                    </div>
                </div>
            `).join('');

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
        const paginationContainer = document.getElementById('pagination') || document.querySelector('.pagination');
        if (!paginationContainer) return;

        const lastPage = response.last_page || 1;
        const total = response.total || 0;

        if (lastPage <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        let html = `<div class="pagination-info">Menampilkan ${response.from}–${response.to} dari ${total} event</div>
                    <div class="pagination-buttons">`;

        if (currentPage > 1) {
            html += `<button class="btn btn-outline page-btn" data-page="${currentPage - 1}">‹ Prev</button>`;
        }
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
            html += `<button class="btn ${i === currentPage ? 'btn-primary' : 'btn-outline'} page-btn" data-page="${i}">${i}</button>`;
        }
        if (currentPage < lastPage) {
            html += `<button class="btn btn-outline page-btn" data-page="${currentPage + 1}">Next ›</button>`;
        }
        html += '</div>';
        paginationContainer.innerHTML = html;
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
            if (e.target.classList.contains('page-btn')) {
                const page = parseInt(e.target.dataset.page);
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
