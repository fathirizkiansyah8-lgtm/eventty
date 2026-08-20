document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for certificates
    const certificates = [
        {
            id: 1,
            eventName: "Workshop Leadership",
            date: "15 August 2026",
            type: "Participation",
            status: "Available"
        },
        {
            id: 2,
            eventName: "Workshop Design",
            date: "5 August 2026",
            type: "Completion",
            status: "Available"
        },
        {
            id: 3,
            eventName: "Seminar Teknologi",
            date: "28 July 2026",
            type: "Attendance",
            status: "Available"
        },
        {
            id: 4,
            eventName: "Training Public Speaking",
            date: "20 July 2026",
            type: "Achievement",
            status: "Available"
        },
        {
            id: 5,
            eventName: "Workshop Photography",
            date: "15 July 2026",
            type: "Participation",
            status: "Available"
        },
        {
            id: 6,
            eventName: "Lomba Presentasi",
            date: "10 July 2026",
            type: "Winner",
            status: "Available"
        }
    ];

    // Handle certificate card actions
    const certificateCards = document.querySelectorAll('.certificate-card');
    certificateCards.forEach(card => {
        const viewBtn = card.querySelector('.btn-outline');
        const downloadBtn = card.querySelector('.btn-primary');

        if (viewBtn) {
            viewBtn.addEventListener('click', function() {
                // TODO: Open certificate preview modal
                console.log('View certificate');
            });
        }

        if (downloadBtn) {
            downloadBtn.addEventListener('click', function() {
                // TODO: Download certificate file
                console.log('Download certificate');
            });
        }
    });

    // Function to show empty state if no certificates
    function checkEmptyState() {
        const certificateCards = document.querySelectorAll('.certificate-card');
        const certificatesGrid = document.querySelector('.certificates-grid');
        
        if (certificateCards.length === 0) {
            const emptyState = document.createElement('div');
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <div class="empty-state-icon">🏆</div>
                <div class="empty-state-title">Belum ada sertifikat</div>
                <div class="empty-state-description">Ikuti event dan selesaikan kehadiran untuk mendapatkan sertifikat</div>
            `;
            certificatesGrid.innerHTML = '';
            certificatesGrid.appendChild(emptyState);
        }
    }

    // Check empty state on load
    checkEmptyState();

    // Function to filter certificates by type
    function filterCertificatesByType(type) {
        const certificateCards = document.querySelectorAll('.certificate-card');
        
        certificateCards.forEach(card => {
            const typeDetail = card.querySelectorAll('.certificate-detail')[1];
            const certificateType = typeDetail.textContent.trim().split(' ')[1];
            
            if (type === '' || certificateType === type) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Add certificate type filter if needed
    // Can be extended with a dropdown filter similar to my-events page
});
