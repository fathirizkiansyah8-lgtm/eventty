document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for existing event (would be loaded from backend)
    const existingEventData = {
        name: "Career Day",
        category: "school-event",
        description: "Event career day untuk membantu siswa mempersiapkan masa depan mereka.",
        date: "2026-08-20",
        time: "08:00",
        startTime: "08:00",
        endTime: "12:00",
        location: "Aula Sekolah",
        quota: 50,
        organizer: "OSIS",
        status: "open"
    };

    // Form elements
    const editEventForm = document.getElementById('editEventForm');
    const cancelBtn = document.getElementById('cancelBtn');
    
    // Form fields
    const eventName = document.getElementById('eventName');
    const eventCategory = document.getElementById('eventCategory');
    const eventDescription = document.getElementById('eventDescription');
    const eventDate = document.getElementById('eventDate');
    const eventTime = document.getElementById('eventTime');
    const eventStartTime = document.getElementById('eventStartTime');
    const eventEndTime = document.getElementById('eventEndTime');
    const eventLocation = document.getElementById('eventLocation');
    const eventQuota = document.getElementById('eventQuota');
    const eventOrganizer = document.getElementById('eventOrganizer');
    const eventBanner = document.getElementById('eventBanner');
    const eventStatus = document.getElementById('eventStatus');

    // Error elements
    const eventNameError = document.getElementById('eventNameError');
    const eventCategoryError = document.getElementById('eventCategoryError');
    const eventDateError = document.getElementById('eventDateError');
    const eventTimeError = document.getElementById('eventTimeError');
    const eventLocationError = document.getElementById('eventLocationError');
    const eventQuotaError = document.getElementById('eventQuotaError');
    const eventOrganizerError = document.getElementById('eventOrganizerError');

    // Set minimum date to today
    if (eventDate) {
        const today = new Date().toISOString().split('T')[0];
        eventDate.setAttribute('min', today);
    }

    // Handle cancel button
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin membatalkan? Perubahan yang belum disimpan akan hilang.')) {
                window.location.href = '/admin/events';
            }
        });
    }

    // Form validation
    function validateForm() {
        let hasError = false;

        // Clear all errors
        const errorElements = document.querySelectorAll('.field-error');
        errorElements.forEach(el => el.textContent = '');

        // Validate event name
        if (eventName && eventName.value.trim() === '') {
            if (eventNameError) eventNameError.textContent = 'Nama event wajib diisi';
            hasError = true;
        }

        // Validate category
        if (eventCategory && eventCategory.value === '') {
            if (eventCategoryError) eventCategoryError.textContent = 'Kategori wajib dipilih';
            hasError = true;
        }

        // Validate date
        if (eventDate && eventDate.value === '') {
            if (eventDateError) eventDateError.textContent = 'Tanggal wajib diisi';
            hasError = true;
        }

        // Validate time
        if (eventTime && eventTime.value === '') {
            if (eventTimeError) eventTimeError.textContent = 'Waktu wajib diisi';
            hasError = true;
        }

        // Validate location
        if (eventLocation && eventLocation.value.trim() === '') {
            if (eventLocationError) eventLocationError.textContent = 'Lokasi wajib diisi';
            hasError = true;
        }

        // Validate quota
        if (eventQuota) {
            if (eventQuota.value === '') {
                if (eventQuotaError) eventQuotaError.textContent = 'Kuota wajib diisi';
                hasError = true;
            } else if (parseInt(eventQuota.value) < 1) {
                if (eventQuotaError) eventQuotaError.textContent = 'Kuota minimal 1';
                hasError = true;
            }
        }

        // Validate organizer
        if (eventOrganizer && eventOrganizer.value.trim() === '') {
            if (eventOrganizerError) eventOrganizerError.textContent = 'Penyelenggara wajib diisi';
            hasError = true;
        }

        return !hasError;
    }

    // Handle form submission
    if (editEventForm) {
        editEventForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            // Collect form data
            const formData = {
                name: eventName?.value.trim(),
                category: eventCategory?.value,
                description: eventDescription?.value.trim(),
                date: eventDate?.value,
                time: eventTime?.value,
                startTime: eventStartTime?.value,
                endTime: eventEndTime?.value,
                location: eventLocation?.value.trim(),
                quota: eventQuota?.value,
                organizer: eventOrganizer?.value.trim(),
                status: eventStatus?.value
            };

            // TODO: Update event data to backend
            console.log('Updating event:', formData);

            // Show success message
            alert('Event berhasil diperbarui!');

            // Redirect to events page
            window.location.href = '/admin/events';
        });
    }

    // Real-time validation
    const requiredFields = [eventName, eventCategory, eventDate, eventTime, eventLocation, eventQuota, eventOrganizer];
    requiredFields.forEach(field => {
        if (field) {
            field.addEventListener('input', function() {
                const errorElement = document.getElementById(this.id + 'Error');
                if (errorElement) {
                    errorElement.textContent = '';
                }
            });
        }
    });

    // Handle file upload preview
    if (eventBanner) {
        eventBanner.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    return;
                }

                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak valid. Gunakan JPG atau PNG.');
                    this.value = '';
                    return;
                }

                console.log('File selected:', file.name);
            }
        });
    }

    // Auto-fill end time based on start time
    if (eventStartTime && eventEndTime) {
        eventStartTime.addEventListener('change', function() {
            if (this.value && !eventEndTime.value) {
                // Set end time to 2 hours after start time
                const [hours, minutes] = this.value.split(':').map(Number);
                let endHours = hours + 2;
                if (endHours >= 24) endHours = endHours - 24;
                const endTime = `${String(endHours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                eventEndTime.value = endTime;
            }
        });
    }
});
