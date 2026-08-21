document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Mock data for user profile
    const userProfile = {
        name: "Fathi",
        nis: "12345",
        class: "XII IPA 1",
        email: "fathi@sekolah.sch.id",
        phone: "+62 812 3456 7890",
        role: "Siswa",
        eventsJoined: 12,
        certificates: 6,
        attendance: "85%"
    };

    // Edit profile modal
    const editProfileBtn = document.getElementById('editProfileBtn');
    const editProfileModal = document.getElementById('editProfileModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const saveProfileBtn = document.getElementById('saveProfileBtn');
    const editProfileForm = document.getElementById('editProfileForm');

    // Open edit profile modal
    if (editProfileBtn && editProfileModal) {
        editProfileBtn.addEventListener('click', function() {
            editProfileModal.classList.add('active');
        });
    }

    // Close edit profile modal
    function closeEditModalFunc() {
        if (editProfileModal) {
            editProfileModal.classList.remove('active');
        }
    }

    if (closeEditModal) {
        closeEditModal.addEventListener('click', closeEditModalFunc);
    }

    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', closeEditModalFunc);
    }

    // Close modal when clicking outside
    if (editProfileModal) {
        editProfileModal.addEventListener('click', function(e) {
            if (e.target === editProfileModal) {
                closeEditModalFunc();
            }
        });
    }

    // Save profile changes
    if (saveProfileBtn && editProfileForm) {
        saveProfileBtn.addEventListener('click', function() {
            const name = document.getElementById('editName').value.trim();
            const email = document.getElementById('editEmail').value.trim();
            const phone = document.getElementById('editPhone').value.trim();

            // Basic validation
            if (name === '' || email === '' || phone === '') {
                alert('Semua field harus diisi');
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Email tidak valid');
                return;
            }

            // TODO: Update profile data to backend
            console.log('Saving profile:', { name, email, phone });

            // Update UI with new data
            const profileName = document.querySelector('.profile-name');
            const emailValue = document.querySelector('.info-item:nth-child(4) .info-value');
            const phoneValue = document.querySelector('.info-item:nth-child(5) .info-value');

            if (profileName) profileName.textContent = name;
            if (emailValue) emailValue.textContent = email;
            if (phoneValue) phoneValue.textContent = phone;

            // Close modal
            closeEditModalFunc();

            // Show success message
            alert('Profil berhasil diperbarui');
        });
    }

    // Change avatar button
    const changeAvatarBtn = document.getElementById('changeAvatarBtn');
    if (changeAvatarBtn) {
        changeAvatarBtn.addEventListener('click', function() {
            // Create file input
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*';
            fileInput.style.display = 'none';

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // TODO: Upload avatar to backend
                    console.log('Avatar file selected:', file.name);
                    alert('Fitur upload avatar akan segera tersedia');
                }
            });

            document.body.appendChild(fileInput);
            fileInput.click();
            document.body.removeChild(fileInput);
        });
    }

    // Keyboard shortcuts for modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && editProfileModal && editProfileModal.classList.contains('active')) {
            closeEditModalFunc();
        }
    });
});
