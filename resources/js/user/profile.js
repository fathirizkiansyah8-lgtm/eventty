document.addEventListener('DOMContentLoaded', function () {
    initializeProfile();

    async function initializeProfile() {
        await loadProfileData();
        initializeFormHandlers();
        initializeAvatarUpload();
    }

    // ── Load profile data from API ──
    async function loadProfileData() {
        try {
            const profile = await api.get('/api/user/profile');

            // Fill profile fields
            const fieldMap = {
                'profileName': profile.name,
                'profileEmail': profile.email,
                'profileNIS': profile.nis,
                'profileClass': profile.class,
                'profilePhone': profile.phone || '-',
                'profileAddress': profile.address || '-',
            };
            Object.entries(fieldMap).forEach(([id, val]) => {
                const el = document.getElementById(id);
                if (el) el.textContent = val;
            });

            // Fill stats
            const statsMap = {
                'statEventsJoined': profile.statistics.events_joined,
                'statCertificates': profile.statistics.certificates_earned,
                'statAttendanceRate': profile.statistics.attendance_rate + '%',
            };
            Object.entries(statsMap).forEach(([id, val]) => {
                const el = document.getElementById(id);
                if (el) el.textContent = val;
            });

            // Update avatar
            const avatar = document.getElementById('profileAvatar');
            if (avatar && profile.avatar_url) avatar.src = profile.avatar_url;

            // Pre-fill edit form
            const editFieldMap = {
                'editName': profile.name,
                'editEmail': profile.email,
                'editPhone': profile.phone,
                'editAddress': profile.address,
            };
            Object.entries(editFieldMap).forEach(([id, val]) => {
                const el = document.getElementById(id);
                if (el) el.value = val || '';
            });

        } catch (error) {
            console.error('Error loading profile:', error);
            handleApiError(error);
        }
    }

    // ── Initialize form handlers ──
    function initializeFormHandlers() {
        // Open edit modal
        const editBtn = document.getElementById('editProfileBtn');
        const editModal = document.getElementById('editProfileModal');
        const closeModalBtn = document.getElementById('closeEditModal') || document.querySelector('.modal-close');

        if (editBtn && editModal) {
            editBtn.addEventListener('click', () => editModal.classList.add('active'));
        }
        if (closeModalBtn && editModal) {
            closeModalBtn.addEventListener('click', () => editModal.classList.remove('active'));
        }
        if (editModal) {
            editModal.addEventListener('click', function (e) {
                if (e.target === editModal) editModal.classList.remove('active');
            });
        }

        // Edit profile form submission
        const editForm = document.getElementById('editProfileForm');
        if (editForm) {
            editForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const submitBtn = this.querySelector('button[type="submit"]');
                try {
                    setLoadingState(submitBtn, true, 'Menyimpan...');
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData.entries());
                    const response = await api.post('/user/profile/update', data);
                    if (response.success) {
                        showNotification(response.message, 'success');
                        editModal?.classList.remove('active');
                        loadProfileData();
                    }
                } catch (error) {
                    if (error.isValidationError()) {
                        displayFormErrors(error.getValidationErrors(), editForm);
                    } else {
                        handleApiError(error);
                    }
                } finally {
                    setLoadingState(submitBtn, false);
                }
            });
        }

        // Change password form
        const passwordForm = document.getElementById('changePasswordForm');
        if (passwordForm) {
            passwordForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const submitBtn = this.querySelector('button[type="submit"]');
                try {
                    setLoadingState(submitBtn, true, 'Memperbarui...');
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData.entries());
                    const response = await api.post('/user/profile/password', data);
                    if (response.success) {
                        showNotification(response.message, 'success');
                        this.reset();
                    }
                } catch (error) {
                    if (error.isValidationError()) {
                        displayFormErrors(error.getValidationErrors(), passwordForm);
                    } else {
                        handleApiError(error);
                    }
                } finally {
                    setLoadingState(submitBtn, false);
                }
            });
        }
    }

    // ── Avatar upload ──
    function initializeAvatarUpload() {
        const avatarInput = document.getElementById('avatarInput');
        if (!avatarInput) return;

        avatarInput.addEventListener('change', async function () {
            const file = this.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                showNotification('Ukuran file maksimal 2MB', 'error');
                this.value = '';
                return;
            }

            try {
                const formData = new FormData();
                formData.append('avatar', file);
                const response = await api.post('/user/profile/avatar', formData);
                if (response.success) {
                    showNotification(response.message, 'success');
                    const avatar = document.getElementById('profileAvatar');
                    if (avatar) avatar.src = response.avatar_url;
                }
            } catch (error) {
                handleApiError(error);
            }
        });
    }

    // ── Display form validation errors ──
    function displayFormErrors(errors, form) {
        Object.keys(errors).forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            const errorEl = form.querySelector(`#${fieldName}Error`) ||
                            form.querySelector(`.${fieldName}-error`);
            if (errorEl) errorEl.textContent = errors[fieldName][0];
            if (field) field.classList.add('error');
        });
    }
});
