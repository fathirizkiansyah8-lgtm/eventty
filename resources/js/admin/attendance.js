document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for attendance
    const attendanceData = [
        {
            id: 1,
            name: "Fathi",
            nis: "12345",
            class: "XII IPA 1",
            event: "Career Day",
            status: "Belum Dicek"
        },
        {
            id: 2,
            name: "Ahmad",
            nis: "12346",
            class: "XII IPA 2",
            event: "Workshop Programming",
            status: "Hadir"
        },
        {
            id: 3,
            name: "Budi",
            nis: "12347",
            class: "XI IPS 1",
            event: "Lomba Design",
            status: "Tidak Hadir"
        },
        {
            id: 4,
            name: "Citra",
            nis: "12348",
            class: "X IPA 1",
            event: "Seminar Pendidikan",
            status: "Hadir"
        },
        {
            id: 5,
            name: "Dewi",
            nis: "12349",
            class: "XII IPS 1",
            event: "Workshop Leadership",
            status: "Belum Dicek"
        }
    ];

    // Handle search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table tbody tr');
            
            tableRows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const nis = row.cells[1].textContent.toLowerCase();
                const eventClass = row.cells[2].textContent.toLowerCase();
                const event = row.cells[3].textContent.toLowerCase();
                
                if (name.includes(searchTerm) || nis.includes(searchTerm) || eventClass.includes(searchTerm) || event.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Handle event filter
    const eventFilter = document.getElementById('eventFilter');
    if (eventFilter) {
        eventFilter.addEventListener('change', function() {
            const selectedEvent = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table tbody tr');
            
            tableRows.forEach(row => {
                const event = row.cells[3].textContent.toLowerCase();
                
                if (selectedEvent === '' || event.includes(selectedEvent)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Handle attendance filter
    const attendanceFilter = document.getElementById('attendanceFilter');
    if (attendanceFilter) {
        attendanceFilter.addEventListener('change', function() {
            const selectedStatus = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table tbody tr');
            
            tableRows.forEach(row => {
                const statusBadge = row.cells[4].querySelector('.badge');
                const status = statusBadge.textContent.toLowerCase();
                
                if (selectedStatus === '' || status === selectedStatus || 
                    (selectedStatus === 'pending' && status === 'belum dicek') ||
                    (selectedStatus === 'present' && status === 'hadir') ||
                    (selectedStatus === 'absent' && status === 'tidak hadir')) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Handle attendance buttons
    const attendanceBtns = document.querySelectorAll('.attendance-btn');
    attendanceBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.disabled) return;

            const status = this.dataset.status;
            const row = this.closest('tr');
            const participantName = row.cells[0].textContent;
            const statusBadge = row.cells[4].querySelector('.badge');
            const attendanceActions = row.querySelector('.attendance-actions');

            // Confirm attendance change
            const actionText = status === 'present' ? 'hadir' : 'tidak hadir';
            if (confirm(`Tandai ${participantName} sebagai ${actionText}?`)) {
                // TODO: Update attendance status in backend
                console.log(`Marking ${participantName} as ${status}`);

                // Update UI
                if (status === 'present') {
                    statusBadge.className = 'badge badge-success';
                    statusBadge.textContent = 'Hadir';
                } else {
                    statusBadge.className = 'badge badge-danger';
                    statusBadge.textContent = 'Tidak Hadir';
                }

                // Disable buttons and show "Sudah Dicek"
                attendanceActions.innerHTML = `
                    <button class="btn btn-outline btn-sm attendance-btn" disabled>Sudah Dicek</button>
                `;
            }
        });
    });

    // Handle pagination
    const paginationBtns = document.querySelectorAll('.pagination-btn');
    paginationBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.disabled) return;
            
            // Remove active class from all buttons
            paginationBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // TODO: Load page data
            console.log('Page:', this.textContent);
        });
    });

    // Check empty state
    function checkEmptyState() {
        const tableRows = document.querySelectorAll('.table tbody tr');
        let visibleCount = 0;
        
        tableRows.forEach(row => {
            if (row.style.display !== 'none') {
                visibleCount++;
            }
        });

        const tableContainer = document.querySelector('.table-container');
        const existingEmptyState = tableContainer.querySelector('.empty-state');
        if (existingEmptyState) {
            existingEmptyState.remove();
        }

        if (visibleCount === 0) {
            const emptyState = document.createElement('div');
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <div class="empty-state-icon">✅</div>
                <div class="empty-state-title">Tidak ada data kehadiran ditemukan</div>
                <div class="empty-state-description">Coba ubah filter atau cari peserta lain</div>
            `;
            tableContainer.innerHTML = '';
            tableContainer.appendChild(emptyState);
        }
    }

    // Check empty state on filter change
    if (searchInput) searchInput.addEventListener('input', checkEmptyState);
    if (eventFilter) eventFilter.addEventListener('change', checkEmptyState);
    if (attendanceFilter) attendanceFilter.addEventListener('change', checkEmptyState);
});
