<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - Eventty Admin</title>
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

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Edit Event</h1>
                <p class="admin-page-hd-sub">Perbarui informasi event: <strong>{{ $event->name }}</strong></p>
            </div>
            <a href="{{ url('/admin/events') }}" class="abtn abtn-secondary">Batal</a>
        </div>

        {{-- Validation errors --}}
        @if($errors->any())
        <div style="background:#fee2e2;border:1.5px solid #fca5a5;color:#991b1b;padding:.875rem 1rem;border-radius:.75rem;margin-bottom:1.25rem;font-size:.875rem;">
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin:.35rem 0 0;padding-left:1.25rem;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <div class="form-container">
            {{-- Form: method spoofing PUT, enctype untuk file upload --}}
            <form id="editEventForm"
                  method="POST"
                  action="{{ route('admin.events.update', $event->id) }}"
                  enctype="multipart/form-data"
                  novalidate>
                @csrf
                @method('PUT')
                {{-- Event ID untuk JS --}}
                <input type="hidden" id="editEventId" value="{{ $event->id }}">

                {{-- ── Informasi Event ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Informasi Event</h2>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventName">Nama Event <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="eventName" name="name" class="input-field"
                                   value="{{ old('name', $event->name) }}"
                                   placeholder="Masukkan nama event" required>
                            <small class="field-error" id="eventNameError">{{ $errors->first('name') }}</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventCategory">Kategori <span style="color:#ef4444;">*</span></label>
                            <select id="eventCategory" name="category_id" class="input-field" required>
                                <option value="">Pilih kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                            {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="field-error" id="eventCategoryError">{{ $errors->first('category_id') }}</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventDescription">Deskripsi <span style="color:#ef4444;">*</span></label>
                            <textarea id="eventDescription" name="description" class="input-field" rows="4"
                                      placeholder="Deskripsi event" required>{{ old('description', $event->description) }}</textarea>
                            <small class="field-error">{{ $errors->first('description') }}</small>
                        </div>
                    </div>
                </div>

                {{-- ── Waktu & Lokasi ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Waktu &amp; Lokasi</h2>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventDate">Tanggal <span style="color:#ef4444;">*</span></label>
                            <input type="date" id="eventDate" name="date" class="input-field"
                                   value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
                            <small class="field-error" id="eventDateError">{{ $errors->first('date') }}</small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventStartTime">Waktu Mulai <span style="color:#ef4444;">*</span></label>
                            <input type="time" id="eventStartTime" name="start_time" class="input-field"
                                   value="{{ old('start_time', $event->start_time->format('H:i')) }}" required>
                            <small class="field-error">{{ $errors->first('start_time') }}</small>
                        </div>
                    </div>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventEndTime">Waktu Selesai <span style="color:#ef4444;">*</span></label>
                            <input type="time" id="eventEndTime" name="end_time" class="input-field"
                                   value="{{ old('end_time', $event->end_time->format('H:i')) }}" required>
                            <small class="field-error">{{ $errors->first('end_time') }}</small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventLocation">Lokasi <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="eventLocation" name="location" class="input-field"
                                   value="{{ old('location', $event->location) }}"
                                   placeholder="Masukkan lokasi event" required>
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
                            <input type="number" id="eventQuota" name="quota" class="input-field"
                                   value="{{ old('quota', $event->quota) }}"
                                   placeholder="Contoh: 100" min="1" required>
                            <small class="field-error" id="eventQuotaError">{{ $errors->first('quota') }}</small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventOrganizer">Penyelenggara <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="eventOrganizer" name="organizer" class="input-field"
                                   value="{{ old('organizer', $event->organizer) }}"
                                   placeholder="Contoh: OSIS" required>
                            <small class="field-error" id="eventOrganizerError">{{ $errors->first('organizer') }}</small>
                        </div>
                    </div>
                </div>

                {{-- ── Banner ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Banner Event</h2>
                    <div class="form-row">
                        <div class="input-group">
                            @if($event->banner_path)
                            <div style="margin-bottom:.75rem;">
                                <img src="{{ $event->banner_url }}" alt="Banner saat ini"
                                     style="max-width:320px;max-height:180px;border-radius:.75rem;object-fit:cover;border:1.5px solid var(--border-color);">
                                <p style="font-size:.72rem;color:#64748b;margin-top:.35rem;">Banner saat ini. Upload baru untuk mengganti.</p>
                            </div>
                            @endif
                            <label class="input-label" for="eventBanner">{{ $event->banner_path ? 'Ganti Banner' : 'Banner Image' }}</label>
                            <input type="file" id="eventBanner" name="banner" class="input-field"
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            <small class="field-hint">Format: JPG, PNG. Maksimal 2MB.</small>
                            <small class="field-error">{{ $errors->first('banner') }}</small>
                            <div id="bannerPreview" style="display:none;margin-top:.75rem;">
                                <img id="bannerPreviewImg" src="" alt="Preview"
                                     style="max-width:320px;max-height:180px;border-radius:.75rem;object-fit:cover;border:1.5px solid var(--border-color);">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Sertifikat ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Sertifikat</h2>
                    <p style="font-size:.82rem;color:#64748b;margin-bottom:1rem;">Apakah event ini menyediakan sertifikat untuk peserta yang hadir?</p>
                    <input type="hidden" name="has_certificate" value="0">
                    <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
                        <label style="flex:1;min-width:180px;display:flex;align-items:center;gap:.75rem;padding:.875rem 1.1rem;border:2px solid var(--border-color);border-radius:.875rem;cursor:pointer;background:var(--bg-secondary);">
                            <input type="radio" name="has_certificate" value="1" id="certYes"
                                   {{ old('has_certificate', $event->has_certificate ? '1' : '0') == '1' ? 'checked' : '' }}
                                   style="width:18px;height:18px;accent-color:#2563eb;">
                            <div>
                                <div style="font-size:.875rem;font-weight:700;color:var(--text-primary);">Ya, sertifikat tersedia</div>
                                <div style="font-size:.72rem;color:#94a3b8;">Peserta yang hadir mendapat sertifikat</div>
                            </div>
                        </label>
                        <label style="flex:1;min-width:180px;display:flex;align-items:center;gap:.75rem;padding:.875rem 1.1rem;border:2px solid var(--border-color);border-radius:.875rem;cursor:pointer;background:var(--bg-secondary);">
                            <input type="radio" name="has_certificate" value="0" id="certNo"
                                   {{ old('has_certificate', $event->has_certificate ? '1' : '0') == '0' ? 'checked' : '' }}
                                   style="width:18px;height:18px;accent-color:#2563eb;">
                            <div>
                                <div style="font-size:.875rem;font-weight:700;color:var(--text-primary);">Tidak, tanpa sertifikat</div>
                                <div style="font-size:.72rem;color:#94a3b8;">Event ini tidak menyertakan sertifikat</div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- ── Status ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Status Event</h2>
                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventStatus">Status <span style="color:#ef4444;">*</span></label>
                            <select id="eventStatus" name="status" class="input-field" required>
                                @foreach(['draft'=>'Draft — Belum dipublikasikan','open'=>'Open — Pendaftaran dibuka','closed'=>'Closed — Pendaftaran ditutup','completed'=>'Completed — Event selesai','cancelled'=>'Cancelled — Event dibatalkan'] as $val => $lbl)
                                    <option value="{{ $val }}" {{ old('status', $event->status) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ url('/admin/events') }}" class="abtn abtn-secondary"
                       onclick="return confirm('Batalkan perubahan? Data yang belum disimpan akan hilang.')">
                        Batal
                    </a>
                    <button type="submit" class="abtn abtn-primary" id="submitEditBtn">
                        <iconify-icon icon="lucide:save" width="15" height="15"></iconify-icon>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
// ── Banner preview ──
document.getElementById('eventBanner')?.addEventListener('change', function () {
    var file = this.files[0];
    var preview = document.getElementById('bannerPreview');
    var img = document.getElementById('bannerPreviewImg');
    if (!file) { preview.style.display = 'none'; return; }
    if (file.size > 2 * 1024 * 1024) { alert('Ukuran file maksimal 2MB.'); this.value = ''; return; }
    var reader = new FileReader();
    reader.onload = function(e) { img.src = e.target.result; preview.style.display = 'block'; };
    reader.readAsDataURL(file);
});

// ── Client-side validation sebelum submit ──
document.getElementById('editEventForm')?.addEventListener('submit', function (e) {
    var valid = true;
    var first = null;
    var checks = [
        { id: 'eventName',      msg: 'Nama event harus diisi.',       errId: 'eventNameError' },
        { id: 'eventCategory',  msg: 'Kategori harus dipilih.',        errId: 'eventCategoryError' },
        { id: 'eventDate',      msg: 'Tanggal harus diisi.',           errId: 'eventDateError' },
        { id: 'eventStartTime', msg: 'Waktu mulai harus diisi.',       errId: null },
        { id: 'eventEndTime',   msg: 'Waktu selesai harus diisi.',     errId: null },
        { id: 'eventLocation',  msg: 'Lokasi harus diisi.',            errId: 'eventLocationError' },
        { id: 'eventQuota',     msg: 'Kuota harus diisi.',             errId: 'eventQuotaError' },
        { id: 'eventOrganizer', msg: 'Penyelenggara harus diisi.',     errId: 'eventOrganizerError' },
    ];
    checks.forEach(function(c) {
        var el = document.getElementById(c.id);
        var errEl = c.errId ? document.getElementById(c.errId) : (el ? el.nextElementSibling : null);
        if (el && !el.value.trim()) {
            if (errEl) errEl.textContent = c.msg;
            valid = false;
            if (!first) first = el;
        } else if (errEl) { errEl.textContent = ''; }
    });
    // Waktu selesai > mulai
    var st = document.getElementById('eventStartTime')?.value;
    var et = document.getElementById('eventEndTime')?.value;
    if (st && et && st >= et) {
        var errEl = document.getElementById('eventEndTime')?.nextElementSibling;
        if (errEl) errEl.textContent = 'Waktu selesai harus lebih dari waktu mulai.';
        valid = false;
        if (!first) first = document.getElementById('eventEndTime');
    }
    if (!valid) {
        e.preventDefault();
        if (first) { first.focus(); first.scrollIntoView({ behavior:'smooth', block:'center' }); }
        return;
    }
    // Loading state
    var btn = document.getElementById('submitEditBtn');
    if (btn) { btn.disabled = true; btn.innerHTML = '<iconify-icon icon="lucide:loader-2" width="15" height="15"></iconify-icon> Menyimpan...'; }
});
</script>

</body>
</html>
