document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for participants
    const participants = [
        {
            id: 1,
            name: "Fathi",
            nis: "12345",
            class: "XII IPA 1",
            event: "Career Day",
            status: "Registered",
            attendance: "Belum Dicek"
        },
        {
            id: 2,
            name: "Ahmad",
            nis: "12346",
            class: "XII IPA 2",
            event: "Workshop Programming",
            status: "Registered",
            attendance: "Hadir"
        },
        {
            id: 3,
            name: "Budi",
            nis: "12347",
            class: "XI IPS 1",
            event: "Lomba Design",
            status: "Registered",
            attendance: "Tidak Hadir"
        },
        {
            id: 4,
            name: "Citra",
            nis: "12348",
            class: "X IPA 1",
            event: "Seminar Pendidikan",
            status: "Attended",
            attendance: "Hadir"
        },
        {
            id: 5,
            name: "Dewi",
            nis: "12349",
            class: "XII IPS 1",
            event: "Workshop Leadership",
            status: "Attended",
            attendance: "Hadir"
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

    // Handle class filter
    const classFilter = document.getElementById('classFilter');
    if (classFilter) {
        classFilter.addEventListener('change', function() {
            const selectedClass = this.value;
            const tableRows = document.querySelectorAll('.table tbody tr');
            
            tableRows.forEach(row => {
                const eventClass = row.cells[2].textContent;
                
                if (selectedClass === '' || eventClass.startsWith(selectedClass)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Handle status filter
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table tbody tr');
            
            tableRows.forEach(row => {
                const statusBadge = row.cells[4].querySelector('.badge');
                const status = statusBadge.textContent.toLowerCase();
                
                if (selectedStatus === '' || status === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Handle action buttons
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.textContent.trim();
            const row = this.closest('tr');
            const participantName = row.cells[0].textContent;

            if (action === 'Detail') {
                // TODO: Navigate to participant detail page
                console.log('View participant detail:', participantName);
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
                <div class="empty-state-icon">👥</div>
                <div class="empty-state-title">Tidak ada peserta ditemukan</div>
                <div class="empty-state-description">Coba ubah filter atau cari peserta lain</div>
            `;
            tableContainer.innerHTML = '';
            tableContainer.appendChild(emptyState);
        }
    }

    // Check empty state on filter change
    if (searchInput) searchInput.addEventListener('input', checkEmptyState);
    if (eventFilter) eventFilter.addEventListener('change', checkEmptyState);
    if (classFilter) classFilter.addEventListener('change', checkEmptyState);
    if (statusFilter) statusFilter.addEventListener('change', checkEmptyState);
});
