document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for students
    const students = [
        {
            id: 1,
            name: "Fathi",
            nis: "12345",
            class: "XII IPA 1",
            email: "fathi@sekolah.sch.id",
            status: "Active"
        },
        {
            id: 2,
            name: "Ahmad",
            nis: "12346",
            class: "XII IPA 2",
            email: "ahmad@sekolah.sch.id",
            status: "Active"
        },
        {
            id: 3,
            name: "Budi",
            nis: "12347",
            class: "XI IPS 1",
            email: "budi@sekolah.sch.id",
            status: "Active"
        },
        {
            id: 4,
            name: "Citra",
            nis: "12348",
            class: "X IPA 1",
            email: "citra@sekolah.sch.id",
            status: "Active"
        },
        {
            id: 5,
            name: "Dewi",
            nis: "12349",
            class: "XII IPS 1",
            email: "dewi@sekolah.sch.id",
            status: "Active"
        },
        {
            id: 6,
            name: "Eko",
            nis: "12350",
            class: "XI IPA 1",
            email: "eko@sekolah.sch.id",
            status: "Inactive"
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
                const studentClass = row.cells[2].textContent.toLowerCase();
                const email = row.cells[3].textContent.toLowerCase();
                
                if (name.includes(searchTerm) || nis.includes(searchTerm) || studentClass.includes(searchTerm) || email.includes(searchTerm)) {
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
                const studentClass = row.cells[2].textContent;
                
                if (selectedClass === '' || studentClass.startsWith(selectedClass)) {
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
            const studentName = row.cells[0].textContent;

            if (action === 'Detail') {
                // TODO: Navigate to student detail page
                console.log('View student detail:', studentName);
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
                <div class="empty-state-icon">🎓</div>
                <div class="empty-state-title">Tidak ada siswa ditemukan</div>
                <div class="empty-state-description">Coba ubah filter atau cari siswa lain</div>
            `;
            tableContainer.innerHTML = '';
            tableContainer.appendChild(emptyState);
        }
    }

    // Check empty state on filter change
    if (searchInput) searchInput.addEventListener('input', checkEmptyState);
    if (classFilter) classFilter.addEventListener('change', checkEmptyState);
    if (statusFilter) statusFilter.addEventListener('change', checkEmptyState);
});
