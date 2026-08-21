document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for admin statistics
    const adminStatistics = {
        totalEvents: 24,
        activeEvents: 8,
        totalParticipants: 342,
        completedEvents: 16
    };

    // Mock data for recent events
    const recentEvents = [
        {
            id: 1,
            name: "Career Day",
            category: "School Event",
            date: "20 Aug 2026",
            participants: 45,
            quota: 50,
            status: "Open"
        },
        {
            id: 2,
            name: "Workshop Programming",
            category: "Workshop",
            date: "25 Aug 2026",
            participants: 20,
            quota: 30,
            status: "Open"
        },
        {
            id: 3,
            name: "Lomba Design",
            category: "Competition",
            date: "1 Sep 2026",
            participants: 45,
            quota: 50,
            status: "Almost Full"
        },
        {
            id: 4,
            name: "Seminar Pendidikan",
            category: "Seminar",
            date: "10 Aug 2026",
            participants: 50,
            quota: 50,
            status: "Closed"
        },
        {
            id: 5,
            name: "Workshop Leadership",
            category: "Workshop",
            date: "15 Aug 2026",
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

    // Handle table action buttons
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.textContent.trim();
            const row = this.closest('tr');
            const eventName = row.cells[0].textContent;

            if (action === 'View') {
                // TODO: Navigate to event detail page
                console.log('View event:', eventName);
            } else if (action === 'Edit') {
                // TODO: Navigate to edit event page
                console.log('Edit event:', eventName);
            } else if (action === 'Delete') {
                // TODO: Show confirmation modal and delete event
                if (confirm(`Apakah Anda yakin ingin menghapus event "${eventName}"?`)) {
                    console.log('Delete event:', eventName);
                    // TODO: Call backend to delete event
                }
            }
        });
    });

    // Handle analytics filter change
    const analyticsFilter = document.querySelector('.analytics-filter');
    if (analyticsFilter) {
        analyticsFilter.addEventListener('change', function() {
            const filter = this.value;
            // TODO: Update chart data based on filter
            console.log('Analytics filter changed to:', filter);
        });
    }

    // Animate statistics on load
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const finalValue = parseInt(stat.textContent);
        let currentValue = 0;
        const increment = finalValue / 20;
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                stat.textContent = finalValue;
                clearInterval(timer);
            } else {
                stat.textContent = Math.floor(currentValue);
            }
        }, 50);
    });

    // Set greeting based on time
    function setGreeting() {
        const hour = new Date().getHours();
        const greetingText = document.querySelector('.header-greeting-text');
        
        if (greetingText) {
            let greeting = 'Selamat malam';
            if (hour >= 5 && hour < 12) {
                greeting = 'Selamat pagi';
            } else if (hour >= 12 && hour < 15) {
                greeting = 'Selamat siang';
            } else if (hour >= 15 && hour < 18) {
                greeting = 'Selamat sore';
            }
            
            greetingText.textContent = greeting + ',';
        }
    }

    setGreeting();

    // Update greeting every minute
    setInterval(setGreeting, 60000);

    // Interactive chart bars (simple hover effect)
    const chartBars = document.querySelectorAll('.chart-bar');
    chartBars.forEach(bar => {
        bar.addEventListener('mouseenter', function() {
            const height = this.style.height;
            // TODO: Show tooltip with exact value
            console.log('Bar height:', height);
        });
    });
});
