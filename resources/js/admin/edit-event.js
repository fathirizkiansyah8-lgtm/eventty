document.addEventListener('DOMContentLoaded', function () {
    // Get event ID from the page
    const eventId = document.getElementById('editEventForm')?.dataset?.eventId
                  || window.location.pathname.split('/').slice(-2, -1)[0];

    initializeEditEvent();

    async function initializeEditEvent() {
        try {
            await loadCategories();
            if (eventId) await loadEventData(eventId);
            initializeFormHandlers();
            setupFormValidation();
        } catch (error) {
            console.error('Error initializing edit event:', error);
            handleApiError(error);
        }
    }

    // ── Load categories ──
    async function loadCategories() {
        try {
            const categories = await api.get('/api/admin/categories');
            const select = document.getElementById('eventCategory');
            if (!select) return;
            select.innerHTML = '<option value="">Pilih Kategori</option>';
            categories.forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat.id;
                opt.textContent = cat.name;
                select.appendChild(opt);
            });
        } catch (e) { /* silent */ }
    }

    // ── Load event data to pre-fill form ──
    async function loadEventData(id) {
        try {
            const event = await api.get(`/admin/events/${id}`);

            // Fill form fields
            const fieldMap = {
                'eventName': event.name,
                'eventDescription': event.description,
                'eventDate': event.date,
                'eventStartTime': event.start_time,
                'eventEndTime': event.end_time,
                'eventLocation': event.location,
                'eventOrganizer': event.organizer,
                'eventQuota': event.quota,
                'eventStatus': event.status,
                'eventCategory': event.category_id,
            };

            Object.entries(fieldMap).forEach(([id, val]) => {
                const el = document.getElementById(id);
                if (el) el.value = val || '';
            });

            // Show current banner
            if (event.banner_url) {
                const previewContainer = document.querySelector('.current-banner');
                if (previewContainer) {
                    previewContainer.innerHTML = `
                        <img src="${event.banner_url}" alt="Current Banner"
                             style="max-width:200px;max-height:120px;border-radius:8px;object-fit:cover;">
                        <p style="font-size:.75rem;color:#64748b;margin-top:.25rem;">Banner saat ini</p>`;
                    previewContainer.style.display = 'block';
                }
            }

        } catch (error) {
            console.error('Error loading event data:', error);
            showNotification('Gagal memuat data event', 'error');
        }
    }

    // ── Initialize form handlers ──
    function initializeFormHandlers() {
        const form = document.getElementById('editEventForm');
        const cancelBtn = document.getElementById('cancelBtn');
        const bannerInput = document.getElementById('eventBanner');

        if (form) form.addEventListener('submit', handleFormSubmit);

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (confirm('Batalkan perubahan? Data yang belum disimpan akan hilang.')) {
                    window.location.href = '/admin/events';
                }
            });
        }

        if (bannerInput) bannerInput.addEventListener('change', handleBannerPreview);
    }

    // ── Handle form submission ──
    async function handleFormSubmit(e) {
        e.preventDefault();
        if (!validateForm()) return;

        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');

        try {
            setLoadingState(submitBtn, true, 'Menyimpan...');

            const formData = new FormData(form);
            // Method spoofing for PUT
            formData.append('_method', 'PUT');

            const response = await api.post(`/admin/events/${eventId}`, formData);

            if (response.success) {
                showNotification(response.message, 'success');
                setTimeout(() => { window.location.href = '/admin/events'; }, 1500);
            }
        } catch (error) {
            if (error.isValidationError()) {
                displayValidationErrors(error.getValidationErrors());
            } else {
                handleApiError(error);
            }
        } finally {
            setLoadingState(submitBtn, false);
        }
    }

    // ── Banner preview ──
    function handleBannerPreview(e) {
        const file = e.target.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) { showNotification('File max 2MB', 'error'); e.target.value = ''; return; }

        const reader = new FileReader();
        reader.onload = function (ev) {
            let preview = document.querySelector('.banner-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'banner-preview';
                e.target.parentNode.appendChild(preview);
            }
            preview.innerHTML = `<img src="${ev.target.result}" style="max-width:200px;max-height:120px;border-radius:8px;object-fit:cover;" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    }

    // ── Form validation ──
    function setupFormValidation() {
        ['eventName', 'eventCategory', 'eventDate', 'eventStartTime', 'eventEndTime', 'eventLocation', 'eventQuota', 'eventOrganizer'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('blur', () => validateField(el));
                el.addEventListener('input', () => clearFieldError(el));
            }
        });
    }

    function validateForm() {
        let isValid = true;
        clearAllErrors();

        [{ id: 'eventName', msg: 'Nama event harus diisi' }, { id: 'eventCategory', msg: 'Kategori harus dipilih' },
         { id: 'eventDate', msg: 'Tanggal harus diisi' }, { id: 'eventStartTime', msg: 'Waktu mulai harus diisi' },
         { id: 'eventEndTime', msg: 'Waktu selesai harus diisi' }, { id: 'eventLocation', msg: 'Lokasi harus diisi' },
         { id: 'eventQuota', msg: 'Kuota harus diisi' }, { id: 'eventOrganizer', msg: 'Penyelenggara harus diisi' }
        ].forEach(({ id, msg }) => {
            const el = document.getElementById(id);
            if (el && !el.value.trim()) { showFieldError(el, msg); isValid = false; }
        });

        const start = document.getElementById('eventStartTime')?.value;
        const end = document.getElementById('eventEndTime')?.value;
        if (start && end && start >= end) {
            showFieldError(document.getElementById('eventEndTime'), 'Waktu selesai harus setelah waktu mulai');
            isValid = false;
        }
        return isValid;
    }

    function validateField(field) { if (!field.value.trim()) { showFieldError(field, 'Field ini harus diisi'); return false; } clearFieldError(field); return true; }
    function showFieldError(field, msg) { const err = document.getElementById(field.id + 'Error'); if (err) { err.textContent = msg; err.style.display = 'block'; } field.classList.add('error'); }
    function clearFieldError(field) { const err = document.getElementById(field.id + 'Error'); if (err) { err.textContent = ''; err.style.display = 'none'; } field.classList.remove('error'); }
    function clearAllErrors() { document.querySelectorAll('.field-error').forEach(e => { e.textContent = ''; e.style.display = 'none'; }); document.querySelectorAll('.error').forEach(e => e.classList.remove('error')); }
    function displayValidationErrors(errors) { Object.keys(errors).forEach(key => { const el = document.getElementById(`event${key.charAt(0).toUpperCase() + key.slice(1)}`); if (el && errors[key][0]) showFieldError(el, errors[key][0]); }); }
});
