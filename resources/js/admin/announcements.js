document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for announcements
    const announcements = [
        {
            id: 1,
            title: "Event Baru Akan Segera Dibuka",
            content: "Siapkan diri Anda untuk event baru yang akan segera dibuka. Event ini akan memberikan pengalaman yang menarik dan bermanfaat bagi semua siswa.",
            target: "Semua Siswa",
            date: "10 August 2026",
            status: "Active"
        },
        {
            id: 2,
            title: "Perubahan Jadwal Workshop",
            content: "Jadwal Workshop Programming telah berubah. Event baru akan diadakan pada 25 August 2026 di Lab Komputer. Mohon perhatikan perubahan ini.",
            target: "Peserta Workshop",
            date: "8 August 2026",
            status: "Active"
        },
        {
            id: 3,
            title: "Selamat Datang di Eventy",
            content: "Selamat datang di platform Eventy. Platform ini dirancang untuk memudahkan pengelolaan event sekolah. Silakan explore fitur-fitur yang tersedia.",
            target: "Semua Pengguna",
            date: "1 August 2026",
            status: "Inactive"
        }
    ];

    // Create announcement modal
    const createAnnouncementBtn = document.getElementById('createAnnouncementBtn');
    const createAnnouncementModal = document.getElementById('createAnnouncementModal');
    const closeCreateModal = document.getElementById('closeCreateModal');
    const cancelCreateBtn = document.getElementById('cancelCreateBtn');
    const saveAnnouncementBtn = document.getElementById('saveAnnouncementBtn');
    const createAnnouncementForm = document.getElementById('createAnnouncementForm');

    // Open create modal
    if (createAnnouncementBtn && createAnnouncementModal) {
        createAnnouncementBtn.addEventListener('click', function() {
            createAnnouncementModal.classList.add('active');
        });
    }

    // Close create modal
    function closeCreateModalFunc() {
        if (createAnnouncementModal) {
            createAnnouncementModal.classList.remove('active');
        }
        // Reset form
        if (createAnnouncementForm) {
            createAnnouncementForm.reset();
        }
    }

    if (closeCreateModal) {
        closeCreateModal.addEventListener('click', closeCreateModalFunc);
    }

    if (cancelCreateBtn) {
        cancelCreateBtn.addEventListener('click', closeCreateModalFunc);
    }

    // Close modal when clicking outside
    if (createAnnouncementModal) {
        createAnnouncementModal.addEventListener('click', function(e) {
            if (e.target === createAnnouncementModal) {
                closeCreateModalFunc();
            }
        });
    }

    // Save announcement
    if (saveAnnouncementBtn && createAnnouncementForm) {
        saveAnnouncementBtn.addEventListener('click', function() {
            const title = document.getElementById('announcementTitle').value.trim();
            const content = document.getElementById('announcementContent').value.trim();
            const target = document.getElementById('announcementTarget').value;
            const date = document.getElementById('announcementDate').value;
            const status = document.getElementById('announcementStatus').value;

            // Basic validation
            if (title === '' || content === '') {
                alert('Judul dan isi pengumuman wajib diisi');
                return;
            }

            // TODO: Send data to backend
            console.log('Creating announcement:', { title, content, target, date, status });

            // Show success message
            alert('Pengumuman berhasil dibuat!');

            // Close modal
            closeCreateModalFunc();

            // TODO: Refresh announcements list
        });
    }

    // Handle search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const announcementCards = document.querySelectorAll('.announcement-card');
            
            announcementCards.forEach(card => {
                const title = card.querySelector('.announcement-title').textContent.toLowerCase();
                const content = card.querySelector('.announcement-content p').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || content.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Handle status filter
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value.toLowerCase();
            const announcementCards = document.querySelectorAll('.announcement-card');
            
            announcementCards.forEach(card => {
                const statusBadge = card.querySelector('.announcement-status .badge');
                const status = statusBadge.textContent.toLowerCase();
                
                if (selectedStatus === '' || status === selectedStatus) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Handle announcement card actions
    const announcementCards = document.querySelectorAll('.announcement-card');
    announcementCards.forEach(card => {
        const editBtn = card.querySelector('.btn-outline');
        const deleteBtn = card.querySelector('.btn-danger');
        const title = card.querySelector('.announcement-title').textContent;

        if (editBtn) {
            editBtn.addEventListener('click', function() {
                // TODO: Open edit modal with existing data
                console.log('Edit announcement:', title);
            });
        }

        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                if (confirm(`Apakah Anda yakin ingin menghapus pengumuman "${title}"?`)) {
                    // TODO: Delete announcement from backend
                    console.log('Delete announcement:', title);
                    card.style.display = 'none';
                }
            });
        }
    });

    // Check empty state
    function checkEmptyState() {
        const announcementCards = document.querySelectorAll('.announcement-card');
        let visibleCount = 0;
        
        announcementCards.forEach(card => {
            if (card.style.display !== 'none') {
                visibleCount++;
            }
        });

        const announcementsList = document.querySelector('.announcements-list');
        const existingEmptyState = announcementsList.querySelector('.empty-state');
        if (existingEmptyState) {
            existingEmptyState.remove();
        }

        if (visibleCount === 0) {
            const emptyState = document.createElement('div');
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <div class="empty-state-icon">📢</div>
                <div class="empty-state-title">Tidak ada pengumuman ditemukan</div>
                <div class="empty-state-description">Coba ubah filter atau buat pengumuman baru</div>
            `;
            announcementsList.appendChild(emptyState);
        }
    }

    // Check empty state on filter change
    if (searchInput) searchInput.addEventListener('input', checkEmptyState);
    if (statusFilter) statusFilter.addEventListener('change', checkEmptyState);

    // Keyboard shortcuts for modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && createAnnouncementModal && createAnnouncementModal.classList.contains('active')) {
            closeCreateModalFunc();
        }
    });
});
