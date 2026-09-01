document.addEventListener('DOMContentLoaded', function () {
    let currentFilters = { event_id: '', status: 'all', search: '' };

    initializeAttendance();

    async function initializeAttendance() {
        await loadEventsForFilter();
        await loadAttendance();
        initializeFilters();
    }

    // ── Load events for filter ──
    async function loadEventsForFilter() {
        try {
            const events = await api.get('/api/admin/attendance/events');
            const select = document.getElementById('eventFilter');
            if (!select) return;
            select.innerHTML = '<option value="">Semua Event</option>';
            events.forEach(event => {
                const opt = document.createElement('option');
                opt.value = event.id;
                opt.textContent = `${event.name} (${event.date})`;
                select.appendChild(opt);
            });
        } catch (e) { /* silent */ }
    }

    // ── Load attendance list ──
    async function loadAttendance(page = 1) {
        const tbody = document.getElementById('attendanceTableBody') || document.querySelector('.attendance-table tbody');
        if (!tbody) return;

        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;">Memuat data kehadiran...</td></tr>`;

        try {
            const params = { page, ...currentFilters };
            Object.keys(params).forEach(k => { if (!params[k] || params[k] === 'all') delete params[k]; });

            const response = await api.get('/api/admin/attendance', params);
            const list = response.data || [];

            if (list.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;">
                    <div>📋</div><p>Tidak ada data kehadiran${currentFilters.event_id ? ' untuk event ini' : ''}.</p>
                </td></tr>`;
                return;
            }

            tbody.innerHTML = list.map(item => `
                <tr data-participant-id="${item.id}">
                    <td>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <img src="${item.student_avatar}" alt="" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                            <div>
                                <div style="font-weight:600;">${item.student_name}</div>
                                <div style="font-size:.7rem;color:#64748b;">${item.student_nis || '-'}</div>
                            </div>
                        </div>
                    </td>
                    <td>${item.student_class || '-'}</td>
                    <td>${item.event_name}</td>
                    <td>${item.event_date}</td>
                    <td>${item.registration_date}</td>
                    <td>
                        <span class="abadge ${getAttendanceBadge(item.attendance_status)}">
                            ${getAttendanceLabel(item.attendance_status)}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.35rem;">
                            <button class="abtn abtn-sm ${item.attendance_status === 'present' ? 'abtn-primary' : 'abtn-outline'} mark-present-btn"
                                    data-participant-id="${item.id}" ${item.attendance_status === 'present' ? 'disabled' : ''}>
                                ✓ Hadir
                            </button>
                            <button class="abtn abtn-sm ${item.attendance_status === 'absent' ? 'abtn-danger' : 'abtn-outline'} mark-absent-btn"
                                    data-participant-id="${item.id}" ${item.attendance_status === 'absent' ? 'disabled' : ''}>
                                ✗ Absen
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');

        } catch (error) {
            tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;">Gagal memuat data.</td></tr>`;
            handleApiError(error);
        }
    }

    function getAttendanceBadge(s) { return { present: 'abadge-green', absent: 'abadge-red', registered: 'abadge-blue', cancelled: 'abadge-gray' }[s] || 'abadge-gray'; }
    function getAttendanceLabel(s) { return { present: 'Hadir', absent: 'Tidak Hadir', registered: 'Terdaftar', cancelled: 'Dibatalkan' }[s] || s; }

    // ── Initialize filters ──
    function initializeFilters() {
        const eventFilter = document.getElementById('eventFilter');
        if (eventFilter) eventFilter.addEventListener('change', function () { currentFilters.event_id = this.value; loadAttendance(1); });

        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) statusFilter.addEventListener('change', function () { currentFilters.status = this.value; loadAttendance(1); });

        const searchInput = document.getElementById('searchAttendance');
        if (searchInput) {
            let debounce;
            searchInput.addEventListener('input', function () { clearTimeout(debounce); debounce = setTimeout(() => { currentFilters.search = this.value; loadAttendance(1); }, 400); });
        }

        // Attendance mark buttons (delegated)
        document.addEventListener('click', async function (e) {
            const presentBtn = e.target.closest('.mark-present-btn');
            const absentBtn = e.target.closest('.mark-absent-btn');
            const btn = presentBtn || absentBtn;
            if (!btn) return;

            const participantId = btn.dataset.participantId;
            const status = presentBtn ? 'present' : 'absent';

            try {
                setLoadingState(btn, true, '...');
                const response = await api.post('/api/admin/attendance/mark', { participant_id: participantId, status });
                if (response.success) {
                    showNotification(response.message, 'success');
                    // Update row
                    const row = btn.closest('tr');
                    if (row) {
                        const statusCell = row.querySelector('.abadge');
                        if (statusCell) { statusCell.className = `abadge ${getAttendanceBadge(status)}`; statusCell.textContent = getAttendanceLabel(status); }

                        row.querySelectorAll('.mark-present-btn, .mark-absent-btn').forEach(b => {
                            b.className = b.classList.contains('mark-present-btn')
                                ? `abtn abtn-sm ${status === 'present' ? 'abtn-primary' : 'abtn-outline'} mark-present-btn`
                                : `abtn abtn-sm ${status === 'absent' ? 'abtn-danger' : 'abtn-outline'} mark-absent-btn`;
                            b.disabled = (status === 'present' && b.classList.contains('mark-present-btn')) ||
                                         (status === 'absent' && b.classList.contains('mark-absent-btn'));
                        });
                    }
                }
            } catch (error) {
                handleApiError(error);
            } finally {
                setLoadingState(btn, false);
            }
        });
    }
});
