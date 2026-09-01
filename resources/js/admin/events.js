document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 1;
    let currentFilters = { search: '', category: 'all', status: 'all', sort: 'created_at', order: 'desc' };

    initializeAdminEvents();

    async function initializeAdminEvents() {
        await loadCategories();
        await loadEvents();
        initializeFilters();
    }

    // ── Load categories ──
    async function loadCategories() {
        try {
            const categories = await api.get('/api/admin/categories');
            const select = document.getElementById('categoryFilter');
            if (!select) return;
            categories.forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat.id;
                opt.textContent = cat.name;
                select.appendChild(opt);
            });
        } catch (e) { /* silent */ }
    }

    // ── Load events list ──
    async function loadEvents(page = 1) {
        const tbody = document.getElementById('eventsTableBody') || document.querySelector('.events-table tbody');
        if (!tbody) return;

        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:2rem;">Memuat data...</td></tr>`;

        try {
            const params = { page, ...currentFilters };
            Object.keys(params).forEach(k => { if (params[k] === 'all' || params[k] === '') delete params[k]; });

            const response = await api.get('/api/admin/events', params);
            const events = response.data || [];

            if (events.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:2rem;">
                    <div>📅</div><p>Tidak ada event ditemukan</p>
                    <a href="/admin/events/create" class="btn btn-primary" style="margin-top:0.5rem;">Buat Event Pertama</a>
                </td></tr>`;
                updatePagination(response, page);
                return;
            }

            tbody.innerHTML = events.map(event => `
                <tr data-event-id="${event.id}">
                    <td>
                        <div style="font-weight:700;">${event.name}</div>
                        <div style="font-size:.75rem;color:#64748b;">${event.created_by}</div>
                    </td>
                    <td><span class="abadge" style="background:${event.category_color}20;color:${event.category_color};border:1px solid ${event.category_color}40">${event.category}</span></td>
                    <td>${event.date}</td>
                    <td>${event.time}</td>
                    <td>
                        <div style="min-width:80px;">
                            <div style="font-size:.75rem;color:#64748b;margin-bottom:3px;">${event.registered_count}/${event.quota}</div>
                            <div style="height:5px;background:#f1f5f9;border-radius:999px;overflow:hidden;">
                                <div style="height:100%;width:${Math.min(100, Math.round(event.registered_count/event.quota*100))}%;background:#1d4ed8;border-radius:999px;"></div>
                            </div>
                        </div>
                    </td>
                    <td><span class="abadge ${getStatusClass(event.status)}">${getStatusLabel(event.status)}</span></td>
                    <td>
                        <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                            <a href="/admin/events/${event.id}/edit" class="abtn abtn-outline abtn-sm">Edit</a>
                            <button class="abtn abtn-danger abtn-sm delete-event-btn" data-event-id="${event.id}" data-event-name="${event.name}">Hapus</button>
                        </div>
                    </td>
                </tr>
            `).join('');

            updatePagination(response, page);
            currentPage = page;

        } catch (error) {
            tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:2rem;">Gagal memuat data. <button onclick="location.reload()">Coba Lagi</button></td></tr>`;
            handleApiError(error);
        }
    }

    function getStatusClass(status) {
        const m = { draft: 'abadge-gray', open: 'abadge-green', closed: 'abadge-orange', completed: 'abadge-blue', cancelled: 'abadge-red' };
        return m[status] || 'abadge-gray';
    }
    function getStatusLabel(status) {
        const m = { draft: 'Draft', open: 'Dibuka', closed: 'Ditutup', completed: 'Selesai', cancelled: 'Dibatalkan' };
        return m[status] || status;
    }

    // ── Update pagination ──
    function updatePagination(response, page) {
        const paginationEl = document.getElementById('eventsPagination') || document.querySelector('.pagination');
        if (!paginationEl) return;
        const last = response.last_page || 1;
        if (last <= 1) { paginationEl.innerHTML = ''; return; }

        let html = '';
        for (let i = Math.max(1, page - 2); i <= Math.min(last, page + 2); i++) {
            html += `<button class="abtn ${i === page ? 'abtn-primary' : 'abtn-outline'} abtn-sm page-btn" data-page="${i}">${i}</button>`;
        }
        paginationEl.innerHTML = html;
    }

    // ── Initialize filter listeners ──
    function initializeFilters() {
        const searchInput = document.getElementById('searchEvents');
        if (searchInput) {
            let debounce;
            searchInput.addEventListener('input', function () {
                clearTimeout(debounce);
                debounce = setTimeout(() => { currentFilters.search = this.value; loadEvents(1); }, 400);
            });
        }

        ['categoryFilter', 'statusFilter'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('change', function () {
                currentFilters[id === 'categoryFilter' ? 'category' : 'status'] = this.value;
                loadEvents(1);
            });
        });

        // Pagination + Delete (delegated)
        document.addEventListener('click', async function (e) {
            if (e.target.classList.contains('page-btn')) {
                loadEvents(parseInt(e.target.dataset.page));
            }

            if (e.target.classList.contains('delete-event-btn')) {
                const { eventId, eventName } = e.target.dataset;
                if (!confirm(`Hapus event "${eventName}"? Tindakan ini tidak dapat dibatalkan.`)) return;
                try {
                    setLoadingState(e.target, true, 'Menghapus...');
                    const response = await api.delete(`/admin/events/${eventId}`);
                    if (response.success) {
                        showNotification(response.message, 'success');
                        loadEvents(currentPage);
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
