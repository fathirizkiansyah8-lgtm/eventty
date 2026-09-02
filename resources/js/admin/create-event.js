document.addEventListener('DOMContentLoaded', function() {
    // Initialize create event form
    initializeCreateEventForm();

    async function initializeCreateEventForm() {
        try {
            // Load categories for dropdown
            await loadCategories();

            // Initialize form handlers
            initializeFormHandlers();

            // Set up form validation
            setupFormValidation();

        } catch (error) {
            console.error('Error initializing create event form:', error);
            handleApiError(error);
        }
    }

    /**
     * Load event categories from API
     */
    async function loadCategories() {
        try {
            const categories = await api.get('/api/admin/categories');

            const categorySelect = document.getElementById('eventCategory');
            if (!categorySelect || !categories) return;

            // Clear existing options except the first one
            categorySelect.innerHTML = '<option value="">Pilih Kategori</option>';

            // Add category options
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });

        } catch (error) {
            console.error('Error loading categories:', error);
            showNotification('Failed to load categories', 'warning');
        }
    }

    /**
     * Initialize form handlers
     */
    function initializeFormHandlers() {
        const form = document.getElementById('createEventForm');
        const cancelBtn = document.getElementById('cancelBtn');
        const bannerInput = document.getElementById('eventBanner');

        // Set minimum date to today
        const dateInput = document.getElementById('eventDate');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        }

        // Handle form submission
        if (form) {
            form.addEventListener('submit', handleFormSubmit);
        }

        // Handle cancel button
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin membatalkan? Data yang belum disimpan akan hilang.')) {
                    window.location.href = '/admin/events';
                }
            });
        }

        // Handle banner file selection
        if (bannerInput) {
            bannerInput.addEventListener('change', handleBannerPreview);
        }

        // Auto-populate organizer with current user name
        const organizerInput = document.getElementById('eventOrganizer');
        if (organizerInput && !organizerInput.value) {
            organizerInput.value = 'OSIS'; // Default organizer
        }
    }

    /**
     * Handle form submission
     */
    async function handleFormSubmit(e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');

        try {
            setLoadingState(submitBtn, true, 'Creating...');

            // Prepare form data
            const formData = new FormData(form);

            // Convert form data for API
            const eventData = {
                name: formData.get('name'),
                description: formData.get('description'),
                category_id: formData.get('category_id'),
                date: formData.get('date'),
                start_time: formData.get('start_time'),
                end_time: formData.get('end_time'),
                location: formData.get('location'),
                organizer: formData.get('organizer'),
                quota: parseInt(formData.get('quota')),
                status: formData.get('status'),
            };

            // Create FormData for file upload
            const uploadData = new FormData();
            Object.keys(eventData).forEach(key => {
                uploadData.append(key, eventData[key]);
            });

            // Add banner file if selected
            const bannerFile = formData.get('banner');
            if (bannerFile && bannerFile.size > 0) {
                uploadData.append('banner', bannerFile);
            }

            // Submit to API
            const response = await api.post('/admin/events', uploadData);

            if (response.success) {
                showNotification(response.message, 'success');

                // Redirect to events list after short delay
                setTimeout(() => {
                    window.location.href = '/admin/events';
                }, 1500);
            }

        } catch (error) {
            console.error('Error creating event:', error);

            if (error.isValidationError()) {
                displayValidationErrors(error.getValidationErrors());
            } else {
                handleApiError(error);
            }
        } finally {
            setLoadingState(submitBtn, false);
        }
    }

    /**
     * Handle banner file preview
     */
    function handleBannerPreview(e) {
        const file = e.target.files[0];
        const previewContainer = document.querySelector('.banner-preview');

        if (!file) {
            if (previewContainer) {
                previewContainer.style.display = 'none';
            }
            return;
        }

        // Validate file
        if (!file.type.startsWith('image/')) {
            showNotification('Please select an image file', 'error');
            e.target.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) { // 2MB limit
            showNotification('File size must be less than 2MB', 'error');
            e.target.value = '';
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            if (!previewContainer) {
                // Create preview container if it doesn't exist
                const preview = document.createElement('div');
                preview.className = 'banner-preview';
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Banner Preview" style="max-width: 200px; max-height: 150px; border-radius: 8px; object-fit: cover;">
                    <button type="button" class="remove-banner" onclick="removeBannerPreview()">×</button>
                `;
                document.getElementById('eventBanner').parentNode.appendChild(preview);
            } else {
                previewContainer.innerHTML = `
                    <img src="${e.target.result}" alt="Banner Preview" style="max-width: 200px; max-height: 150px; border-radius: 8px; object-fit: cover;">
                    <button type="button" class="remove-banner" onclick="removeBannerPreview()">×</button>
                `;
                previewContainer.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    }

    /**
     * Remove banner preview
     */
    window.removeBannerPreview = function() {
        const bannerInput = document.getElementById('eventBanner');
        const previewContainer = document.querySelector('.banner-preview');

        if (bannerInput) bannerInput.value = '';
        if (previewContainer) previewContainer.style.display = 'none';
    };

    /**
     * Setup form validation
     */
    function setupFormValidation() {
        // Real-time validation on blur
        const requiredFields = ['eventName', 'eventCategory', 'eventDate', 'eventStartTime', 'eventEndTime', 'eventLocation', 'eventQuota', 'eventOrganizer'];

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('blur', () => validateField(field));
                field.addEventListener('input', () => clearFieldError(field));
            }
        });

        // Time validation
        const startTimeField = document.getElementById('eventStartTime');
        const endTimeField = document.getElementById('eventEndTime');

        if (startTimeField && endTimeField) {
            const validateTimes = () => {
                const startTime = startTimeField.value;
                const endTime = endTimeField.value;

                if (startTime && endTime && startTime >= endTime) {
                    showFieldError(endTimeField, 'End time must be after start time');
                    return false;
                }
                clearFieldError(endTimeField);
                return true;
            };

            startTimeField.addEventListener('change', validateTimes);
            endTimeField.addEventListener('change', validateTimes);
        }
    }

    /**
     * Validate entire form
     */
    function validateForm() {
        let isValid = true;

        // Clear all previous errors
        clearAllErrors();

        // Required field validation
        const requiredFields = [
            { id: 'eventName', message: 'Event name is required' },
            { id: 'eventCategory', message: 'Category is required' },
            { id: 'eventDate', message: 'Date is required' },
            { id: 'eventStartTime', message: 'Start time is required' },
            { id: 'eventEndTime', message: 'End time is required' },
            { id: 'eventLocation', message: 'Location is required' },
            { id: 'eventQuota', message: 'Quota is required' },
            { id: 'eventOrganizer', message: 'Organizer is required' }
        ];

        requiredFields.forEach(field => {
            const element = document.getElementById(field.id);
            if (element && !element.value.trim()) {
                showFieldError(element, field.message);
                isValid = false;
            }
        });

        // Quota validation
        const quotaField = document.getElementById('eventQuota');
        if (quotaField) {
            const quota = parseInt(quotaField.value);
            if (quota && (quota < 1 || quota > 1000)) {
                showFieldError(quotaField, 'Quota must be between 1 and 1000');
                isValid = false;
            }
        }

        // Time validation
        const startTime = document.getElementById('eventStartTime')?.value;
        const endTime = document.getElementById('eventEndTime')?.value;
        if (startTime && endTime && startTime >= endTime) {
            showFieldError(document.getElementById('eventEndTime'), 'End time must be after start time');
            isValid = false;
        }

        return isValid;
    }

    /**
     * Validate individual field
     */
    function validateField(field) {
        clearFieldError(field);

        if (!field.value.trim()) {
            showFieldError(field, `${field.getAttribute('data-label') || 'This field'} is required`);
            return false;
        }

        // Special validation for specific fields
        if (field.id === 'eventQuota') {
            const quota = parseInt(field.value);
            if (quota < 1 || quota > 1000) {
                showFieldError(field, 'Quota must be between 1 and 1000');
                return false;
            }
        }

        return true;
    }

    /**
     * Display validation errors from API
     */
    function displayValidationErrors(errors) {
        Object.keys(errors).forEach(fieldName => {
            const fieldElement = document.getElementById(`event${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}`);
            if (fieldElement && errors[fieldName][0]) {
                showFieldError(fieldElement, errors[fieldName][0]);
            }
        });
    }

    /**
     * Show field error
     */
    function showFieldError(field, message) {
        const errorElement = document.getElementById(field.id + 'Error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        field.classList.add('error');
    }

    /**
     * Clear field error
     */
    function clearFieldError(field) {
        const errorElement = document.getElementById(field.id + 'Error');
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
        field.classList.remove('error');
    }

    /**
     * Clear all form errors
     */
    function clearAllErrors() {
        document.querySelectorAll('.field-error').forEach(error => {
            error.textContent = '';
            error.style.display = 'none';
        });
        document.querySelectorAll('.error').forEach(field => {
            field.classList.remove('error');
        });
    }
});
