document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for statistics
    const statistics = {
        eventsJoined: 12,
        upcomingEvents: 5,
        completedEvents: 7,
        certificates: 6
    };

    // Mock data for nearest event
    const nearestEvent = {
        name: "Career Day",
        date: "20 August 2026",
        time: "08:00 — 12:00",
        location: "Aula Sekolah",
        status: "Open",
        participants: 45,
        quota: 50
    };

    // Mock data for upcoming events
    const upcomingEvents = [
        {
            id: 1,
            name: "Workshop Programming",
            category: "School Event",
            date: "25 August 2026",
            time: "09:00 — 15:00",
            location: "Lab Komputer",
            status: "Open",
            participants: 20,
            quota: 30
        },
        {
            id: 2,
            name: "Lomba Design",
            category: "Competition",
            date: "1 September 2026",
            time: "08:00 — 16:00",
            location: "Aula Sekolah",
            status: "Almost Full",
            participants: 45,
            quota: 50
        },
        {
            id: 3,
            name: "Seminar Kewirausahaan",
            category: "Seminar",
            date: "5 September 2026",
            time: "10:00 — 12:00",
            location: "Aula Sekolah",
            status: "Open",
            participants: 15,
            quota: 40
        }
    ];

    // Handle event card buttons
    const eventCards = document.querySelectorAll('.event-card');
    eventCards.forEach(card => {
        const detailBtn = card.querySelector('.btn-outline');
        const registerBtn = card.querySelector('.btn-primary');

        if (detailBtn) {
            detailBtn.addEventListener('click', function() {
                // TODO: Navigate to event detail page
                console.log('View event detail');
            });
        }

        if (registerBtn) {
            registerBtn.addEventListener('click', function() {
                // TODO: Handle event registration
                console.log('Register for event');
            });
        }
    });

    // Handle nearest event button
    const nearestEventBtn = document.querySelector('.nearest-event-actions .btn-primary');
    if (nearestEventBtn) {
        nearestEventBtn.addEventListener('click', function() {
            // TODO: Navigate to event detail page
            console.log('View nearest event detail');
        });
    }

    // Handle "Lihat Semua" button
    const viewAllBtn = document.querySelector('.upcoming-events-section .btn-outline');
    if (viewAllBtn) {
        viewAllBtn.addEventListener('click', function() {
            window.location.href = '/user/events';
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
});
