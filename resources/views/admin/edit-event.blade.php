<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/create-event.css'
    ])
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>

<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

@include('admin.partials.sidebar', ['activePage' => 'events'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="page-header">
            <h1 class="page-title">Edit Event</h1>
            <a href="{{ url('/admin/events') }}" class="btn btn-secondary">Batal</a>
        </div>

        <div class="form-container">
            <form id="editEventForm">
                <div class="form-section">
                    <h2 class="form-section-title">Informasi Event</h2>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventName">Nama Event *</label>
                            <input type="text" id="eventName" class="input-field" value="Career Day" placeholder="Masukkan nama event" required>
                            <small class="field-error" id="eventNameError"></small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventCategory">Kategori *</label>
                            <select id="eventCategory" class="input-field" required>
                                <option value="">Pilih kategori</option>
                                <option value="school-event" selected>School Event</option>
                                <option value="workshop">Workshop</option>
                                <option value="seminar">Seminar</option>
                                <option value="competition">Competition</option>
                                <option value="training">Training</option>
                            </select>
                            <small class="field-error" id="eventCategoryError"></small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventDescription">Deskripsi</label>
                            <textarea id="eventDescription" class="input-field" rows="4" placeholder="Deskripsi event">Event career day untuk membantu siswa mempersiapkan masa depan mereka.</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="form-section-title">Waktu & Lokasi</h2>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventDate">Tanggal *</label>
                            <input type="date" id="eventDate" class="input-field" value="2026-08-20" required>
                            <small class="field-error" id="eventDateError"></small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventTime">Waktu *</label>
                            <input type="time" id="eventTime" class="input-field" value="08:00" required>
                            <small class="field-error" id="eventTimeError"></small>
                        </div>
                    </div>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventStartTime">Waktu Mulai</label>
                            <input type="time" id="eventStartTime" class="input-field" value="08:00">
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventEndTime">Waktu Selesai</label>
                            <input type="time" id="eventEndTime" class="input-field" value="12:00">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventLocation">Lokasi *</label>
                            <input type="text" id="eventLocation" class="input-field" value="Aula Sekolah" placeholder="Masukkan lokasi event" required>
                            <small class="field-error" id="eventLocationError"></small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="form-section-title">Kapasitas & Penyelenggara</h2>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventQuota">Kuota Peserta *</label>
                            <input type="number" id="eventQuota" class="input-field" value="50" placeholder="Masukkan kuota" min="1" required>
                            <small class="field-error" id="eventQuotaError"></small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventOrganizer">Penyelenggara *</label>
                            <input type="text" id="eventOrganizer" class="input-field" value="OSIS" placeholder="Masukkan nama penyelenggara" required>
                            <small class="field-error" id="eventOrganizerError"></small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="form-section-title">Banner Event</h2>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventBanner">Banner Image</label>
                            <input type="file" id="eventBanner" class="input-field" accept="image/*">
                            <small class="field-hint">Format: JPG, PNG. Maksimal 2MB.</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="form-section-title">Status Event</h2>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventStatus">Status</label>
                            <select id="eventStatus" class="input-field">
                                <option value="draft">Draft</option>
                                <option value="open" selected>Open</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ url('/admin/events') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')

@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])
@vite(['resources/js/admin/edit-event.js'])
</body>
</html>
