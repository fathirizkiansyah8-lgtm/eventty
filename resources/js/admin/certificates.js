document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for certificates
    const certificates = [
        {
            id: 1,
            event: "Workshop Leadership",
            participant: "Fathi",
            nis: "12345",
            type: "Participation",
            status: "Available"
        },
        {
            id: 2,
            event: "Workshop Design",
            participant: "Ahmad",
            nis: "12346",
            type: "Completion",
            status: "Available"
        },
        {
            id: 3,
            event: "Seminar Teknologi",
            participant: "Budi",
            nis: "12347",
            type: "Attendance",
            status: "Pending"
        },
        {
            id: 4,
            event: "Workshop Leadership",
            participant: "Citra",
            nis: "12348",
            type: "Achievement",
            status: "Available"
        },
        {
            id: 5,
            event: "Workshop Design",
            participant: "Dewi",
            nis: "12349",
            type: "Participation",
            status: "Pending"
        }
    ];

    // Handle search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table tbody tr');
            
            tableRows.forEach(row => {
                const event = row.cells[0].textContent.toLowerCase();
                const participant = row.cells[1].textContent.toLowerCase();
                const nis = row.cells[2].textContent.toLowerCase();
                
                if (event.includes(searchTerm) || participant.includes(searchTerm) || nis.includes(searchTerm)) {
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
                const event = row.cells[0].textContent.toLowerCase();
                
                if (selectedEvent === '' || event.includes(selectedEvent)) {
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
            const participantName = row.cells[1].textContent;
            const eventName = row.cells[0].textContent;

            if (action === 'Lihat') {
                // TODO: Open certificate preview
                console.log('View certificate for:', participantName, eventName);
            } else if (action === 'Generate') {
                // TODO: Generate certificate
                if (confirm(`Generate sertifikat untuk ${participantName} - ${eventName}?`)) {
                    console.log('Generate certificate for:', participantName, eventName);
                    // TODO: Update status to Available after generation
                }
            } else if (action === 'Download') {
                // TODO: Download certificate
                console.log('Download certificate for:', participantName, eventName);
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
                <div class="empty-state-icon">🏆</div>
                <div class="empty-state-title">Tidak ada sertifikat ditemukan</div>
                <div class="empty-state-description">Coba ubah filter atau cari sertifikat lain</div>
            `;
            tableContainer.innerHTML = '';
            tableContainer.appendChild(emptyState);
        }
    }

    // Check empty state on filter change
    if (searchInput) searchInput.addEventListener('input', checkEmptyState);
    if (eventFilter) eventFilter.addEventListener('change', checkEmptyState);
    if (statusFilter) statusFilter.addEventListener('change', checkEmptyState);
});
