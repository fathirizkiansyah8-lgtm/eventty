document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for my events
    const myEvents = [
        {
            id: 1,
            name: "Career Day",
            date: "20 August 2026",
            time: "08:00 — 12:00",
            location: "Aula Sekolah",
            status: "Registered",
            attendance: "Belum Dicek",
            hasCertificate: false
        },
        {
            id: 2,
            name: "Workshop Leadership",
            date: "15 August 2026",
            time: "09:00 — 15:00",
            location: "Lab Komputer",
            status: "Attended",
            attendance: "Hadir",
            hasCertificate: true
        },
        {
            id: 3,
            name: "Seminar Pendidikan",
            date: "10 August 2026",
            time: "10:00 — 12:00",
            location: "Aula Sekolah",
            status: "Absent",
            attendance: "Tidak Hadir",
            hasCertificate: false
        },
        {
            id: 4,
            name: "Workshop Design",
            date: "5 August 2026",
            time: "09:00 — 16:00",
            location: "Lab Design",
            status: "Completed",
            attendance: "Hadir",
            hasCertificate: true
        }
    ];

    // Handle filter change
    const filterStatus = document.getElementById('filterStatus');
    if (filterStatus) {
        filterStatus.addEventListener('change', function() {
            const selectedStatus = this.value;
            const eventItems = document.querySelectorAll('.event-item');
            
            eventItems.forEach(item => {
                const statusBadge = item.querySelector('.badge');
                const eventStatus = statusBadge.textContent.trim();
                
                if (selectedStatus === '' || eventStatus.toLowerCase() === selectedStatus.toLowerCase()) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Handle event item actions
    const eventItems = document.querySelectorAll('.event-item');
    eventItems.forEach(item => {
        const detailBtn = item.querySelector('.btn-outline');
        const certificateBtn = item.querySelector('.btn-primary');

        if (detailBtn) {
            detailBtn.addEventListener('click', function() {
                // TODO: Navigate to event detail page
                console.log('View event detail');
            });
        }

        if (certificateBtn) {
            certificateBtn.addEventListener('click', function() {
                // TODO: Navigate to certificate view or download
                console.log('View certificate');
            });
        }
    });

    // Function to filter events by status
    function filterEventsByStatus(status) {
        const eventItems = document.querySelectorAll('.event-item');
        
        eventItems.forEach(item => {
            const statusBadge = item.querySelector('.badge');
            const eventStatus = statusBadge.textContent.trim();
            
            if (status === '' || eventStatus.toLowerCase() === status.toLowerCase()) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Function to show empty state if no events match filter
    function checkEmptyState() {
        const eventItems = document.querySelectorAll('.event-item');
        let visibleCount = 0;
        
        eventItems.forEach(item => {
            if (item.style.display !== 'none') {
                visibleCount++;
            }
        });

        const existingEmptyState = document.querySelector('.empty-state');
        if (existingEmptyState) {
            existingEmptyState.remove();
        }

        if (visibleCount === 0) {
            const eventsList = document.querySelector('.events-list');
            const emptyState = document.createElement('div');
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <div class="empty-state-icon">📋</div>
                <div class="empty-state-title">Tidak ada event ditemukan</div>
                <div class="empty-state-description">Coba ubah filter atau cari event lain</div>
            `;
            eventsList.appendChild(emptyState);
        }
    }

    // Check empty state on filter change
    if (filterStatus) {
        filterStatus.addEventListener('change', checkEmptyState);
    }
});
