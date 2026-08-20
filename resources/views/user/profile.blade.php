@extends('user.layout')

@section('title', 'Profil')

@push('css')
    @vite('resources/css/user/dashboard.css')
@endpush

@section('content')
    <div class="dashboard-content">
        <div class="section-header">
            <h1 class="section-title">Profil Saya</h1>
            <button class="btn btn-primary" id="editProfileBtn">Edit Profil</button>
        </div>

        <div class="event-card">
            <div class="event-content">
                <div class="profile-header">
                    <div class="avatar avatar-lg">
                        <span>F</span>
                    </div>
                    <div class="profile-info">
                        <h2 class="event-title">Fathi</h2>
                        <p class="profile-role">Siswa</p>
                    </div>
                </div>

                <div class="profile-details">
                    <h3 class="profile-section-title">Informasi Pribadi</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">Fathi</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">NIS</div>
                            <div class="info-value">12345</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Kelas</div>
                            <div class="info-value">XII RPL 1</div>
                        </div>
                    </div>

                    <h3 class="profile-section-title" style="margin-top: var(--spacing-lg);">Statistik</h3>
                    <div class="statistics-grid">
                        <div class="stat-card">
                            <div class="stat-icon stat-icon-blue">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">2</div>
                                <div class="stat-label">Event Diikuti</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon stat-icon-green">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="7"></circle>
                                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">2</div>
                                <div class="stat-label">Sertifikat</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon stat-icon-purple">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">100%</div>
                                <div class="stat-label">Kehadiran</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal-overlay" id="editProfileModal" style="display: none;">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Edit Profil</h3>
                <button class="modal-close" id="closeEditModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="input-group" style="margin-bottom: var(--spacing-md);">
                        <label class="input-label" for="editName">Nama Lengkap</label>
                        <input type="text" id="editName" class="input-field" value="Fathi" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                    </div>
                    <div class="input-group" style="margin-bottom: var(--spacing-md);">
                        <label class="input-label" for="editClass">Kelas</label>
                        <input type="text" id="editClass" class="input-field" value="XII RPL 1" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelEditBtn">Batal</button>
                <button class="btn btn-primary" id="saveProfileBtn">Simpan</button>
            </div>
        </div>
    </div>
@endsection