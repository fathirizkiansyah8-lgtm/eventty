document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for events
    const events = [
        {
            id: 1,
            name: "Career Day",
            category: "School Event",
            date: "20 Aug 2026",
            location: "Aula Sekolah",
            participants: 45,
            quota: 50,
            status: "Open"
        },
        {
            id: 2,
            name: "Workshop Programming",
            category: "Workshop",
            date: "25 Aug 2026",
            location: "Lab Komputer",
            participants: 20,
            quota: 30,
            status: "Open"
        },
        {
            id: 3,
            name: "Lomba Design",
            category: "Competition",
            date: "1 Sep 2026",
            location: "Aula Sekolah",
            participants: 45,
            quota: 50,
            status: "Almost Full"
        },
        {
            id: 4,
            name: "Seminar Pendidikan",
            category: "Seminar",
            date: "10 Aug 2026",
            location: "Aula Sekolah",
            participants: 50,
            quota: 50,
            status: "Closed"
        },
        {
            id: 5,
            name: "Workshop Leadership",
            category: "Workshop",
            date: "15 Aug 2026",
            location: "Lab Komputer",
            participants: 35,
            quota: 40,
            status: "Completed"
        }
    ];

    // Handle create event button
    const createEventBtn = document.getElementById('createEventBtn');
    if (createEventBtn) {
        createEventBtn.addEventListener('click', function() {
            // TODO: Navigate to create event page
            window.location.href = '/admin/events/create';
        });
    }

    // Handle search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table tbody tr');
            
            tableRows.forEach(row => {
                const eventName = row.cells[0].textContent.toLowerCase();
                const category = row.cells[1].textContent.toLowerCase();
                const location = row.cells[3].textContent.toLowerCase();
                
                if (eventName.includes(searchTerm) || category.includes(searchTerm) || location.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Handle category filter
    const categoryFilter = document.getElementById('categoryFilter');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            const selectedCategory = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table tbody tr');
            
            tableRows.forEach(row => {
                const category = row.cells[1].textContent.toLowerCase();
                
                if (selectedCategory === '' || category === selectedCategory) {
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
                const statusBadge = row.cells[6].querySelector('.badge');
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
    let eventToDelete = null;

    actionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.textContent.trim();
            const row = this.closest('tr');
            const eventName = row.cells[0].textContent;

            if (action === 'Lihat') {
                // TODO: Navigate to event detail page
                console.log('View event:', eventName);
            } else if (action === 'Edit') {
                // TODO: Navigate to edit event page
                console.log('Edit event:', eventName);
                window.location.href = '/admin/events/edit/1';
            } else if (action === 'Hapus') {
                eventToDelete = row;
                showDeleteModal(eventName);
            }
        });
    });

    // Delete modal
    const deleteModal = document.getElementById('deleteModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    function showDeleteModal(eventName) {
        if (deleteModal) {
            deleteModal.classList.add('active');
        }
    }

    function hideDeleteModal() {
        if (deleteModal) {
            deleteModal.classList.remove('active');
        }
        eventToDelete = null;
    }

    if (closeDeleteModal) {
        closeDeleteModal.addEventListener('click', hideDeleteModal);
    }

    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', hideDeleteModal);
    }

    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            if (eventToDelete) {
                // TODO: Call backend to delete event
                console.log('Deleting event');
                eventToDelete.style.display = 'none';
                hideDeleteModal();
                // TODO: Show success message
            }
        });
    }

    // Close modal when clicking outside
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === deleteModal) {
                hideDeleteModal();
            }
        });
    }

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
                <div class="empty-state-icon">🎉</div>
                <div class="empty-state-title">Tidak ada event ditemukan</div>
                <div class="empty-state-description">Coba ubah filter atau cari event lain</div>
            `;
            tableContainer.innerHTML = '';
            tableContainer.appendChild(emptyState);
        }
    }

    // Check empty state on filter change
    if (searchInput) searchInput.addEventListener('input', checkEmptyState);
    if (categoryFilter) categoryFilter.addEventListener('change', checkEmptyState);
    if (statusFilter) statusFilter.addEventListener('change', checkEmptyState);
});
