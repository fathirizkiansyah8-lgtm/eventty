<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Event — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/create-event.css',
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

        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Buat Event Baru</h1>
                <p class="admin-page-hd-sub">Isi detail event yang akan dibuat</p>
            </div>
            <a href="{{ url('/admin/events') }}" class="abtn abtn-secondary">Batal</a>
        </div>

        {{-- Validation errors --}}
        @if($errors->any())
        <div style="background:#fee2e2;border:1.5px solid #fca5a5;color:#991b1b;padding:.875rem 1rem;border-radius:.75rem;margin-bottom:1.25rem;font-size:.875rem;">
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin:.35rem 0 0;padding-left:1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-container">

            {{-- ✅ Form dengan method POST, action ke controller store, enctype untuk file upload --}}
            <form id="createEventForm"
                  method="POST"
                  action="{{ route('admin.events.store') }}"
                  enctype="multipart/form-data"
                  novalidate>
                @csrf

                {{-- ── Informasi Event ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Informasi Event</h2>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventName">Nama Event <span style="color:#ef4444;">*</span></label>
                            <input type="text"
                                   id="eventName"
                                   name="name"
                                   class="input-field {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   placeholder="Masukkan nama event"
                                   value="{{ old('name') }}"
                                   required>
                            <small class="field-error" id="eventNameError">{{ $errors->first('name') }}</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventCategory">Kategori <span style="color:#ef4444;">*</span></label>
                            {{-- ✅ Kategori dari database --}}
                            <select id="eventCategory"
                                    name="category_id"
                                    class="input-field {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                                    required>
                                <option value="">Pilih kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="field-error" id="eventCategoryError">{{ $errors->first('category_id') }}</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventDescription">Deskripsi <span style="color:#ef4444;">*</span></label>
                            <textarea id="eventDescription"
                                      name="description"
                                      class="input-field {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                      rows="4"
                                      placeholder="Deskripsi singkat event"
                                      required>{{ old('description') }}</textarea>
                            <small class="field-error">{{ $errors->first('description') }}</small>
                        </div>
                    </div>
                </div>

                {{-- ── Waktu & Lokasi ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Waktu &amp; Lokasi</h2>

                    {{-- ✅ Hapus field duplikat "eventTime" — hanya gunakan start_time dan end_time --}}
                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventDate">Tanggal <span style="color:#ef4444;">*</span></label>
                            <input type="date"
                                   id="eventDate"
                                   name="date"
                                   class="input-field {{ $errors->has('date') ? 'is-invalid' : '' }}"
                                   value="{{ old('date') }}"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            <small class="field-error" id="eventDateError">{{ $errors->first('date') }}</small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventStartTime">Waktu Mulai <span style="color:#ef4444;">*</span></label>
                            <input type="time"
                                   id="eventStartTime"
                                   name="start_time"
                                   class="input-field {{ $errors->has('start_time') ? 'is-invalid' : '' }}"
                                   value="{{ old('start_time') }}"
                                   required>
                            <small class="field-error">{{ $errors->first('start_time') }}</small>
                        </div>
                    </div>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventEndTime">Waktu Selesai <span style="color:#ef4444;">*</span></label>
                            <input type="time"
                                   id="eventEndTime"
                                   name="end_time"
                                   class="input-field {{ $errors->has('end_time') ? 'is-invalid' : '' }}"
                                   value="{{ old('end_time') }}"
                                   required>
                            <small class="field-error">{{ $errors->first('end_time') }}</small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventLocation">Lokasi <span style="color:#ef4444;">*</span></label>
                            <input type="text"
                                   id="eventLocation"
                                   name="location"
                                   class="input-field {{ $errors->has('location') ? 'is-invalid' : '' }}"
                                   placeholder="Masukkan lokasi event"
                                   value="{{ old('location') }}"
                                   required>
                            <small class="field-error" id="eventLocationError">{{ $errors->first('location') }}</small>
                        </div>
                    </div>
                </div>

                {{-- ── Kapasitas & Penyelenggara ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Kapasitas &amp; Penyelenggara</h2>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventQuota">Kuota Peserta <span style="color:#ef4444;">*</span></label>
                            <input type="number"
                                   id="eventQuota"
                                   name="quota"
                                   class="input-field {{ $errors->has('quota') ? 'is-invalid' : '' }}"
                                   placeholder="Contoh: 100"
                                   min="1"
                                   value="{{ old('quota') }}"
                                   required>
                            <small class="field-error" id="eventQuotaError">{{ $errors->first('quota') }}</small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventOrganizer">Penyelenggara <span style="color:#ef4444;">*</span></label>
                            <input type="text"
                                   id="eventOrganizer"
                                   name="organizer"
                                   class="input-field {{ $errors->has('organizer') ? 'is-invalid' : '' }}"
                                   placeholder="Contoh: OSIS SMKN 20"
                                   value="{{ old('organizer', 'OSIS') }}"
                                   required>
                            <small class="field-error" id="eventOrganizerError">{{ $errors->first('organizer') }}</small>
                        </div>
                    </div>
                </div>

                {{-- ── Banner ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Banner Event</h2>
                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventBanner">Banner Image</label>
                            <input type="file"
                                   id="eventBanner"
                                   name="banner"
                                   class="input-field"
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            <small class="field-hint">Format: JPG, PNG. Maksimal 2MB.</small>
                            <small class="field-error">{{ $errors->first('banner') }}</small>
                            {{-- Preview banner saat file dipilih --}}
                            <div id="bannerPreview" style="display:none;margin-top:.75rem;">
                                <img id="bannerPreviewImg" src="" alt="Preview Banner"
                                     style="max-width:320px;max-height:180px;border-radius:.75rem;object-fit:cover;border:1.5px solid #e2e8f0;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Sertifikat ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Sertifikat</h2>
                    <p style="font-size:.82rem;color:#64748b;margin-bottom:1rem;">
                        Apakah event ini menyediakan sertifikat untuk peserta yang hadir?
                    </p>

                    {{-- Hidden field default false, di-override checkbox jika dipilih Ya --}}
                    <input type="hidden" name="has_certificate" value="0">

                    <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1rem;" id="certOptions">

                        {{-- Pilihan: Ya --}}
                        <label id="certOptYes"
                               style="flex:1;min-width:180px;display:flex;align-items:center;gap:.75rem;padding:.875rem 1.1rem;border:2px solid #e2e8f0;border-radius:.875rem;cursor:pointer;transition:all .15s;background:#fff;">
                            <input type="radio" name="has_certificate" value="1"
                                   id="certRadioYes"
                                   {{ old('has_certificate') == '1' ? 'checked' : '' }}
                                   style="width:18px;height:18px;accent-color:#2563eb;flex-shrink:0;">
                            <div>
                                <div style="font-size:.875rem;font-weight:700;color:#0f172a;">Ya, sertifikat tersedia</div>
                                <div style="font-size:.72rem;color:#94a3b8;margin-top:1px;">Peserta yang hadir mendapat sertifikat</div>
                            </div>
                        </label>

                        {{-- Pilihan: Tidak --}}
                        <label id="certOptNo"
                               style="flex:1;min-width:180px;display:flex;align-items:center;gap:.75rem;padding:.875rem 1.1rem;border:2px solid #e2e8f0;border-radius:.875rem;cursor:pointer;transition:all .15s;background:#fff;">
                            <input type="radio" name="has_certificate" value="0"
                                   id="certRadioNo"
                                   {{ old('has_certificate', '0') == '0' ? 'checked' : '' }}
                                   style="width:18px;height:18px;accent-color:#2563eb;flex-shrink:0;">
                            <div>
                                <div style="font-size:.875rem;font-weight:700;color:#0f172a;">Tidak, tanpa sertifikat</div>
                                <div style="font-size:.72rem;color:#94a3b8;margin-top:1px;">Event ini tidak menyertakan sertifikat</div>
                            </div>
                        </label>

                    </div>

                    {{-- Info tambahan yang muncul jika Ya dipilih --}}
                    <div id="certInfo" style="{{ old('has_certificate') == '1' ? 'display:block' : 'display:none' }};background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:.75rem;padding:.875rem 1rem;font-size:.82rem;color:#1e40af;">
                        <strong>ℹ️ Info:</strong> Sertifikat akan otomatis bisa diterbitkan untuk peserta yang hadir setelah event selesai.
                        Admin bisa menerbitkan sertifikat dari halaman <a href="{{ url('/admin/certificates') }}" style="font-weight:700;color:#1d4ed8;">Kelola Sertifikat</a>.
                    </div>
                </div>

                {{-- ── Status ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Status Event</h2>
                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventStatus">Status <span style="color:#ef4444;">*</span></label>
                            <select id="eventStatus"
                                    name="status"
                                    class="input-field"
                                    required>
                                <option value="draft"  {{ old('status', 'draft') === 'draft'  ? 'selected' : '' }}>Draft — Belum dipublikasikan</option>
                                <option value="open"   {{ old('status') === 'open'   ? 'selected' : '' }}>Open — Pendaftaran dibuka</option>
                                <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Closed — Pendaftaran ditutup</option>
                            </select>
                            <small class="field-hint" style="margin-top:.35rem;">
                                Pilih <strong>Draft</strong> jika ingin menyimpan tanpa mempublikasikan.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ url('/admin/events') }}" class="abtn abtn-secondary"
                       onclick="return confirm('Batalkan pembuatan event? Data yang sudah diisi akan hilang.')">
                        Batal
                    </a>
                    <button type="submit" class="abtn abtn-primary" id="submitBtn">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Event
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
// ── Banner preview saat file dipilih ──
document.getElementById('eventBanner').addEventListener('change', function () {
    var file = this.files[0];
    var preview = document.getElementById('bannerPreview');
    var previewImg = document.getElementById('bannerPreviewImg');

    if (!file) { preview.style.display = 'none'; return; }

    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 2MB.');
        this.value = '';
        preview.style.display = 'none';
        return;
    }

    var reader = new FileReader();
    reader.onload = function (e) {
        previewImg.src = e.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

// ── Validasi sisi klien sebelum submit ──
document.getElementById('createEventForm').addEventListener('submit', function (e) {
    var valid = true;
    var firstError = null;

    // Clear semua error
    this.querySelectorAll('.field-error').forEach(function (el) {
        if (!el.textContent.includes('{{ $errors->')) { el.textContent = ''; }
    });

    var required = [
        { id: 'eventName',       msg: 'Nama event harus diisi.',          errId: 'eventNameError' },
        { id: 'eventCategory',   msg: 'Kategori harus dipilih.',          errId: 'eventCategoryError' },
        { id: 'eventDescription',msg: 'Deskripsi harus diisi.',           errId: null },
        { id: 'eventDate',       msg: 'Tanggal harus diisi.',             errId: 'eventDateError' },
        { id: 'eventStartTime',  msg: 'Waktu mulai harus diisi.',         errId: null },
        { id: 'eventEndTime',    msg: 'Waktu selesai harus diisi.',       errId: null },
        { id: 'eventLocation',   msg: 'Lokasi harus diisi.',              errId: 'eventLocationError' },
        { id: 'eventQuota',      msg: 'Kuota peserta harus diisi.',       errId: 'eventQuotaError' },
        { id: 'eventOrganizer',  msg: 'Penyelenggara harus diisi.',       errId: 'eventOrganizerError' },
    ];

    required.forEach(function (field) {
        var el = document.getElementById(field.id);
        if (!el || el.value.trim() === '' || el.value === '') {
            valid = false;
            var errEl = field.errId ? document.getElementById(field.errId) : el.nextElementSibling;
            if (errEl) errEl.textContent = field.msg;
            if (!firstError) firstError = el;
        }
    });

    // Validasi waktu selesai > waktu mulai
    var startTime = document.getElementById('eventStartTime').value;
    var endTime   = document.getElementById('eventEndTime').value;
    if (startTime && endTime && startTime >= endTime) {
        valid = false;
        var endErr = document.getElementById('eventEndTime').nextElementSibling;
        if (endErr) endErr.textContent = 'Waktu selesai harus lebih dari waktu mulai.';
        if (!firstError) firstError = document.getElementById('eventEndTime');
    }

    if (!valid) {
        e.preventDefault();
        if (firstError) { firstError.focus(); firstError.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
        return;
    }

    // Loading state
    var btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.2-8.6"/></svg> Menyimpan...';
});

// ── Toggle highlight pilihan sertifikat ──
(function () {
    var radios = document.querySelectorAll('input[name="has_certificate"][type="radio"]');
    var certInfo = document.getElementById('certInfo');

    function updateCertStyle() {
        var yesChecked = document.getElementById('certRadioYes').checked;
        var optYes = document.getElementById('certOptYes');
        var optNo  = document.getElementById('certOptNo');

        if (yesChecked) {
            optYes.style.borderColor = '#2563eb';
            optYes.style.background  = '#eff6ff';
            optNo.style.borderColor  = '#e2e8f0';
            optNo.style.background   = '#fff';
            if (certInfo) certInfo.style.display = 'block';
        } else {
            optNo.style.borderColor  = '#2563eb';
            optNo.style.background   = '#eff6ff';
            optYes.style.borderColor = '#e2e8f0';
            optYes.style.background  = '#fff';
            if (certInfo) certInfo.style.display = 'none';
        }
    }

    radios.forEach(function (r) { r.addEventListener('change', updateCertStyle); });
    updateCertStyle(); // set initial state
})();
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
.is-invalid { border-color: #ef4444 !important; }
</style>

</body>
</html>
