document.addEventListener('DOMContentLoaded', function() {
    // Initialize dashboard
    initializeDashboard();

    async function initializeDashboard() {
        try {
            // Load all dashboard data
            await Promise.all([
                loadStatistics(),
                loadNearestEvent(),
                loadUpcomingEvents()
            ]);

            // Initialize event handlers
            initializeEventHandlers();

            // Animate statistics after loading
            animateStatistics();
        } catch (error) {
            console.error('Error initializing dashboard:', error);
            handleApiError(error);
        }
    }

    /**
     * Load dashboard statistics from API
     */
    async function loadStatistics() {
        try {
            const stats = await api.get('/api/user/stats');

            // Update statistics cards
            updateStatistic('events-joined', stats.events_joined);
            updateStatistic('upcoming-events', stats.upcoming_events);
            updateStatistic('completed-events', stats.completed_events);
            updateStatistic('certificates', stats.certificates);

        } catch (error) {
            console.error('Error loading statistics:', error);
            // Show fallback data or error message
            showNotification('Failed to load statistics', 'warning');
        }
    }

    /**
     * Load nearest event from API
     */
    async function loadNearestEvent() {
        try {
            const nearestEvent = await api.get('/api/user/nearest-event');

            const container = document.querySelector('.nearest-event-card');
            if (!container) return;

            if (!nearestEvent) {
                // No nearest event
                container.innerHTML = `
                    <div class="nearest-event-empty">
                        <div class="empty-icon">ðŸ“…</div>
                        <h3>Belum ada event mendatang</h3>
                        <p>Daftarkan diri Anda pada event yang tersedia.</p>
                        <a href="/user/events" class="btn btn-primary">Lihat Semua Event</a>
                    </div>
                `;
                return;
            }

            // Update nearest event card
            container.innerHTML = `
                <div class="nearest-event-header">
                    <div class="nearest-event-badge">Event Terdekat</div>
                    <div class="nearest-event-countdown">
                        <span class="countdown-days">${nearestEvent.days_until}</span>
                        <span class="countdown-label">hari lagi</span>
                    </div>
                </div>
                <div class="nearest-event-content">
                    <h3 class="nearest-event-title">${nearestEvent.name}</h3>
                    <div class="nearest-event-details">
                        <div class="detail-item">
                            <i class="fas fa-calendar"></i>
                            <span>${nearestEvent.date}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <span>${nearestEvent.time}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>${nearestEvent.location}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-tag"></i>
                            <span>${nearestEvent.category}</span>
                        </div>
                    </div>
                </div>
                <div class="nearest-event-actions">
                    <a href="/user/events/${nearestEvent.id}" class="btn btn-primary">Lihat Detail</a>
                </div>
            `;

        } catch (error) {
            console.error('Error loading nearest event:', error);
        }
    }

    /**
     * Load upcoming events from API
     */
    async function loadUpcomingEvents() {
        try {
            const events = await api.get('/api/user/upcoming-events');

            const container = document.querySelector('.upcoming-events-grid');
            if (!container) return;

            if (!events || events.length === 0) {
                container.innerHTML = `
                    <div class="upcoming-events-empty">
                        <div class="empty-icon">ðŸŽ‰</div>
                        <h3>Belum ada event mendatang</h3>
                        <p>Event baru akan segera hadir. Stay tuned!</p>
                    </div>
                `;
                return;
            }

            // Generate event cards
            container.innerHTML = events.map(event => `
                <div class="event-card" data-event-id="${event.id}">
                    <div class="event-image">
                        <img src="${event.banner_url}" alt="${event.name}" loading="lazy">
                        <div class="event-category" style="background-color: ${event.category_color}">
                            ${event.category}
                        </div>
                    </div>
                    <div class="event-content">
                        <h4 class="event-title">${event.name}</h4>
                        <div class="event-details">
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>${event.date}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>${event.time}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>${event.location}</span>
                            </div>
                        </div>
                        <div class="event-quota">
                            <div class="quota-bar">
                                <div class="quota-fill" style="width: ${(event.registered_count / event.quota) * 100}%"></div>
                            </div>
                            <span class="quota-text">${event.registered_count}/${event.quota} peserta</span>
                        </div>
                    </div>
                    <div class="event-actions">
                        <a href="/user/events/${event.id}" class="btn btn-outline">Lihat Detail</a>
                        ${event.is_full ?
                            '<button class="btn btn-secondary" disabled>Penuh</button>' :
                            event.is_registered ?
                                '<button class="btn btn-success" disabled>Terdaftar</button>' :
                                `<button class="btn btn-primary register-btn" data-event-id="${event.id}">Daftar</button>`
                        }
                    </div>
                </div>
            `).join('');

        } catch (error) {
            console.error('Error loading upcoming events:', error);
        }
    }

    /**
     * Initialize event handlers
     */
    function initializeEventHandlers() {
        // Handle event registration buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('register-btn')) {
                const eventId = e.target.dataset.eventId;
                handleEventRegistration(eventId, e.target);
            }
        });

        // Handle "Lihat Semua" button
        const viewAllBtn = document.querySelector('.upcoming-events-section .btn-outline');
        if (viewAllBtn) {
            viewAllBtn.addEventListener('click', function() {
                window.location.href = '/user/events';
            });
        }
    }

    /**
     * Handle event registration
     */
    async function handleEventRegistration(eventId, button) {
        try {
            setLoadingState(button, true, 'Mendaftar...');

            const response = await api.post('/user/events/register', {
                event_id: eventId
            });

            if (response.success) {
                showNotification(response.message, 'success');

                // Update button state
                button.textContent = 'Terdaftar';
                button.classList.remove('btn-primary', 'register-btn');
                button.classList.add('btn-success');
                button.disabled = true;

                // Reload statistics
                loadStatistics();
            }

        } catch (error) {
            console.error('Error registering for event:', error);
            handleApiError(error);
        } finally {
            setLoadingState(button, false);
        }
    }

    /**
     * Update statistic value with animation
     */
    function updateStatistic(statId, value) {
        const element = document.querySelector(`[data-stat="${statId}"] .stat-number`);
        if (element) {
            // Store the target value
            element.setAttribute('data-target', value);
        }
    }

    /**
     * Animate statistics on load
     */
    function animateStatistics() {
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-target')) || 0;
            const duration = 1500; // Animation duration in ms
            const start = 0;
            const startTime = Date.now();

            function updateNumber() {
                const currentTime = Date.now();
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Easing function (ease-out)
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(start + (target - start) * easeOut);

                stat.textContent = current;

                if (progress < 1) {
                    requestAnimationFrame(updateNumber);
                }
            }

            requestAnimationFrame(updateNumber);
        });
    }

    /**
     * Dynamic greeting based on time
     */
    function updateGreeting() {
        const greetingElement = document.querySelector('.dashboard-greeting');
        if (!greetingElement) return;

        const hour = new Date().getHours();
        let greeting;

        if (hour < 12) {
            greeting = 'Selamat Pagi';
        } else if (hour < 15) {
            greeting = 'Selamat Siang';
        } else if (hour < 18) {
            greeting = 'Selamat Sore';
        } else {
            greeting = 'Selamat Malam';
        }

        greetingElement.textContent = greeting;
    }

    // Update greeting on load
    updateGreeting();

    // Refresh data every 5 minutes
    setInterval(() => {
        loadStatistics();
        loadNearestEvent();
    }, 5 * 60 * 1000);
});
