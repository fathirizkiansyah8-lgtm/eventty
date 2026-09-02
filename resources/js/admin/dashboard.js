document.addEventListener('DOMContentLoaded', function() {
    // Initialize admin dashboard
    initializeAdminDashboard();

    async function initializeAdminDashboard() {
        try {
            // Load all dashboard data
            await Promise.all([
                loadAdminStatistics(),
                loadRecentEvents(),
                loadAnalytics()
            ]);

            // Initialize event handlers
            initializeEventHandlers();

            // Animate statistics after loading
            animateStatistics();
        } catch (error) {
            console.error('Error initializing admin dashboard:', error);
            handleApiError(error);
        }
    }

    /**
     * Load admin statistics from API
     */
    async function loadAdminStatistics() {
        try {
            const stats = await api.get('/api/admin/stats');

            // Update statistics cards
            updateStatistic('total-events', stats.total_events);
            updateStatistic('active-events', stats.active_events);
            updateStatistic('total-participants', stats.total_participants);
            updateStatistic('completed-events', stats.completed_events);

        } catch (error) {
            console.error('Error loading admin statistics:', error);
            showNotification('Failed to load statistics', 'warning');
        }
    }

    /**
     * Load recent events from API
     */
    async function loadRecentEvents() {
        try {
            const events = await api.get('/api/admin/recent-events');

            const tableBody = document.querySelector('#recentEventsTable tbody');
            if (!tableBody) return;

            if (!events || events.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="empty-state">
                                <div class="empty-icon">📅</div>
                                <p>Belum ada event yang dibuat</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            // Generate table rows
            tableBody.innerHTML = events.map(event => `
                <tr>
                    <td>${event.name}</td>
                    <td>
                        <span class="badge" style="background-color: ${event.category_color}">
                            ${event.category}
                        </span>
                    </td>
                    <td>${event.date}</td>
                    <td>${event.registered_count}/${event.quota}</td>
                    <td><span class="badge badge-${getStatusClass(event.status)}">${event.status}</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn view-btn" data-event-id="${event.id}">View</button>
                            <button class="action-btn edit-btn" data-event-id="${event.id}">Edit</button>
                            <button class="action-btn delete-btn" data-event-id="${event.id}">Delete</button>
                        </div>
                    </td>
                </tr>
            `).join('');

        } catch (error) {
            console.error('Error loading recent events:', error);
        }
    }

    /**
     * Load analytics data and create charts
     */
    async function loadAnalytics() {
        try {
            const [participationData, attendanceData] = await Promise.all([
                api.get('/api/admin/participation-analytics'),
                api.get('/api/admin/attendance-analytics')
            ]);

            // Create participation chart
            createParticipationChart(participationData);

            // Create attendance chart
            createAttendanceChart(attendanceData);

        } catch (error) {
            console.error('Error loading analytics:', error);
        }
    }

    /**
     * Create participation chart (Bar Chart)
     */
    function createParticipationChart(data) {
        const canvas = document.getElementById('participationChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');

        // Simple bar chart implementation (you can replace with Chart.js)
        // For now, just display the data in a simple way
        const container = canvas.parentElement;
        container.innerHTML = `
            <div class="chart-container">
                <h4>Participation Trends</h4>
                <div class="simple-chart">
                    ${data.labels.map((label, index) => `
                        <div class="chart-bar">
                            <div class="bar-value" style="height: ${(data.data[index] / Math.max(...data.data)) * 100}%"></div>
                            <div class="bar-label">${label}</div>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    }

    /**
     * Create attendance chart (Pie Chart)
     */
    function createAttendanceChart(data) {
        const canvas = document.getElementById('attendanceChart');
        if (!canvas) return;

        const container = canvas.parentElement;
        const total = data.data.reduce((sum, value) => sum + value, 0);

        container.innerHTML = `
            <div class="chart-container">
                <h4>Attendance Overview</h4>
                <div class="pie-chart-legend">
                    ${data.labels.map((label, index) => `
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: ${data.colors[index]}"></div>
                            <span>${label}: ${data.data[index]} (${((data.data[index] / total) * 100).toFixed(1)}%)</span>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    }

    /**
     * Initialize event handlers
     */
    function initializeEventHandlers() {
        // Handle create event button
        const createEventBtn = document.getElementById('createEventBtn');
        if (createEventBtn) {
            createEventBtn.addEventListener('click', function() {
                window.location.href = '/admin/events/create';
            });
        }

        // Handle table action buttons
        document.addEventListener('click', function(e) {
            const button = e.target;

            if (button.classList.contains('view-btn')) {
                const eventId = button.dataset.eventId;
                window.location.href = `/admin/events/${eventId}`;
            }

            else if (button.classList.contains('edit-btn')) {
                const eventId = button.dataset.eventId;
                window.location.href = `/admin/events/${eventId}/edit`;
            }

            else if (button.classList.contains('delete-btn')) {
                const eventId = button.dataset.eventId;
                handleDeleteEvent(eventId, button);
            }
        });

        // Handle view all events button
        const viewAllEventsBtn = document.querySelector('.view-all-events');
        if (viewAllEventsBtn) {
            viewAllEventsBtn.addEventListener('click', function() {
                window.location.href = '/admin/events';
            });
        }
    }

    /**
     * Handle event deletion
     */
    async function handleDeleteEvent(eventId, button) {
        if (!confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
            return;
        }

        try {
            setLoadingState(button, true, 'Deleting...');

            const response = await api.delete(`/admin/events/${eventId}`);

            if (response.success) {
                showNotification(response.message, 'success');

                // Remove row from table
                const row = button.closest('tr');
                row.remove();

                // Reload statistics
                loadAdminStatistics();
            }

        } catch (error) {
            console.error('Error deleting event:', error);
            handleApiError(error);
        } finally {
            setLoadingState(button, false);
        }
    }

    /**
     * Get CSS class for status badge
     */
    function getStatusClass(status) {
        const statusClasses = {
            'draft': 'secondary',
            'open': 'success',
            'closed': 'warning',
            'completed': 'info',
            'cancelled': 'danger'
        };
        return statusClasses[status.toLowerCase()] || 'secondary';
    }

    /**
     * Update statistic value with animation
     */
    function updateStatistic(statId, value) {
        const element = document.querySelector(`[data-stat="${statId}"] .stat-number`);
        if (element) {
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
            const duration = 1500;
            const start = 0;
            const startTime = Date.now();

            function updateNumber() {
                const currentTime = Date.now();
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

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

    // Refresh data every 5 minutes
    setInterval(() => {
        loadAdminStatistics();
        loadRecentEvents();
    }, 5 * 60 * 1000);
});
