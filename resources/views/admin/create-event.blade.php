<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <div class="form-container">
            <form id="createEventForm">

                {{-- ── Informasi Event ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Informasi Event</h2>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventName">Nama Event <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="eventName" class="input-field" placeholder="Masukkan nama event" required>
                            <small class="field-error" id="eventNameError"></small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventCategory">Kategori <span style="color:#ef4444;">*</span></label>
                            <select id="eventCategory" class="input-field" required>
                                <option value="">Pilih kategori</option>
                                <option value="school-event">School Event</option>
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
                            <textarea id="eventDescription" class="input-field" rows="4" placeholder="Deskripsi singkat event"></textarea>
                        </div>
                    </div>
                </div>

                {{-- ── Waktu & Lokasi ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Waktu &amp; Lokasi</h2>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventDate">Tanggal <span style="color:#ef4444;">*</span></label>
                            <input type="date" id="eventDate" class="input-field" required>
                            <small class="field-error" id="eventDateError"></small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventTime">Waktu Mulai <span style="color:#ef4444;">*</span></label>
                            <input type="time" id="eventTime" class="input-field" required>
                        </div>
                    </div>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventStartTime">Waktu Mulai</label>
                            <input type="time" id="eventStartTime" class="input-field">
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventEndTime">Waktu Selesai</label>
                            <input type="time" id="eventEndTime" class="input-field">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventLocation">Lokasi <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="eventLocation" class="input-field" placeholder="Masukkan lokasi event" required>
                            <small class="field-error" id="eventLocationError"></small>
                        </div>
                    </div>
                </div>

                {{-- ── Kapasitas & Penyelenggara ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Kapasitas &amp; Penyelenggara</h2>

                    <div class="form-row form-row-2">
                        <div class="input-group">
                            <label class="input-label" for="eventQuota">Kuota Peserta <span style="color:#ef4444;">*</span></label>
                            <input type="number" id="eventQuota" class="input-field" placeholder="Contoh: 100" min="1" required>
                            <small class="field-error" id="eventQuotaError"></small>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="eventOrganizer">Penyelenggara <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="eventOrganizer" class="input-field" placeholder="Contoh: OSIS SMKN 20" required>
                            <small class="field-error" id="eventOrganizerError"></small>
                        </div>
                    </div>
                </div>

                {{-- ── Banner ── --}}
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

                {{-- ── SERTIFIKAT ── (T5: UI Only, no backend) --}}
                <div class="form-section">
                    <h2 class="form-section-title">Sertifikat</h2>
                    <p style="font-size:.82rem;color:#64748b;margin-bottom:1rem;">Apakah event ini menyediakan sertifikat untuk peserta?</p>

                    {{-- Toggle pilihan --}}
                    <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.25rem;" id="certOptions">
                        <label class="cert-opt" id="certOptYes" style="flex:1;min-width:180px;display:flex;align-items:center;gap:.75rem;padding:.875rem 1.1rem;border:2px solid #e2e8f0;border-radius:.875rem;cursor:pointer;transition:all .15s;background:#fff;" onclick="setCertOpt(true)">
                            <div class="cert-opt-radio" id="certRadioYes" style="width:18px;height:18px;border-radius:50%;border:2px solid #d1d5db;flex-shrink:0;display:flex;align-items:center;justify-content:center;transition:all .15s;"></div>
                            <div>
                                <div style="font-size:.875rem;font-weight:700;color:#0f172a;">Ya, sertifikat tersedia</div>
                                <div style="font-size:.72rem;color:#94a3b8;margin-top:1px;">Peserta yang hadir mendapat sertifikat digital</div>
                            </div>
                        </label>
                        <label class="cert-opt" id="certOptNo" style="flex:1;min-width:180px;display:flex;align-items:center;gap:.75rem;padding:.875rem 1.1rem;border:2px solid #e2e8f0;border-radius:.875rem;cursor:pointer;transition:all .15s;background:#fff;" onclick="setCertOpt(false)">
                            <div class="cert-opt-radio" id="certRadioNo" style="width:18px;height:18px;border-radius:50%;border:2px solid #d1d5db;flex-shrink:0;display:flex;align-items:center;justify-content:center;transition:all .15s;"></div>
                            <div>
                                <div style="font-size:.875rem;font-weight:700;color:#0f172a;">Tidak, tanpa sertifikat</div>
                                <div style="font-size:.72rem;color:#94a3b8;margin-top:1px;">Event ini tidak menyertakan sertifikat</div>
                            </div>
                        </label>
                    </div>

                    {{-- Config fields — shown only when Yes is selected --}}
                    <div id="certConfig" style="display:none;">
                        <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:.875rem;padding:1.25rem;margin-bottom:1rem;">

                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                                <div class="input-group">
                                    <label class="input-label">Judul Sertifikat</label>
                                    <input type="text" id="certTitle" class="input-field" value="Certificate of Participation" placeholder="Judul sertifikat">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Template</label>
                                    <select id="certTemplate" class="input-field">
                                        <option value="participation">Participation</option>
                                        <option value="achievement">Achievement</option>
                                        <option value="completion">Completion</option>
                                    </select>
                                </div>
                            </div>

                            <div class="input-group" style="margin-bottom:1rem;">
                                <label class="input-label">Nama Penyelenggara (di sertifikat)</label>
                                <input type="text" id="certOrganizer" class="input-field" value="OSIS SMKN 20 Jakarta" placeholder="Nama penyelenggara">
                            </div>

                            <div class="input-group" style="margin-bottom:1rem;">
                                <label class="input-label">Template Sertifikat / Gambar</label>
                                <div style="border:1.5px dashed #cbd5e1;border-radius:12px;padding:1rem;background:#fff;">
                                    <input type="file" id="certTemplateUpload" accept="image/*" hidden>
                                    <div id="certTemplatePreview" style="display:flex;align-items:center;justify-content:center;width:100%;min-height:180px;border-radius:12px;background:linear-gradient(135deg,#eef6ff,#f8fafc);border:1px solid #dfeaf9;overflow:hidden;position:relative;">
                                        <div id="certTemplatePlaceholder" style="text-align:center;color:#64748b;padding:1rem;">
                                            <div style="width:56px;height:56px;border-radius:14px;background:#e2e8f0;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8"><path d="M4 16l4.5-4.5 3.5 3.5 5-6 7 7"/><circle cx="15" cy="8" r="1.8"/></svg>
                                            </div>
                                            <div style="font-size:.8rem;font-weight:700;color:#0f172a;margin-bottom:.25rem;">Belum ada template sertifikat</div>
                                            <div style="font-size:.72rem;">Upload desain dari teman Anda nanti</div>
                                        </div>
                                        <img id="certTemplateImage" alt="Preview template sertifikat" style="display:none;max-width:100%;max-height:220px;object-fit:contain;" />
                                    </div>
                                    <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-top:.75rem;">
                                        <button type="button" onclick="document.getElementById('certTemplateUpload').click()" style="border:none;border-radius:10px;background:#2563eb;color:#fff;padding:.6rem .9rem;font-weight:700;cursor:pointer;">Pilih Gambar</button>
                                        <button type="button" id="replaceCertTemplateBtn" onclick="document.getElementById('certTemplateUpload').click()" style="border:1px solid #cbd5e1;border-radius:10px;background:#fff;color:#0f172a;padding:.6rem .9rem;font-weight:700;cursor:pointer;">Ganti Gambar</button>
                                        <button type="button" id="removeCertTemplateBtn" onclick="removeCertTemplate()" style="border:1px solid #fecaca;border-radius:10px;background:#fff;color:#b91c1c;padding:.6rem .9rem;font-weight:700;cursor:pointer;">Hapus</button>
                                    </div>
                                    <div style="font-size:.7rem;color:#64748b;margin-top:.5rem;">Format yang didukung: JPG, PNG, WEBP. Ukuran bisa disesuaikan sesuai tema event.</div>
                                </div>
                            </div>

                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                                <div class="input-group">
                                    <label class="input-label">Nama Penandatangan</label>
                                    <input type="text" id="certSigner" class="input-field" placeholder="Nama Ketua OSIS / Pembina">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Jabatan Penandatangan</label>
                                    <input type="text" id="certSignerRole" class="input-field" placeholder="Ketua OSIS / Pembina">
                                </div>
                            </div>
                        </div>

                        {{-- Certificate Preview --}}
                        <div>
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;">
                                <span style="font-size:.8rem;font-weight:700;color:#0f172a;">Preview Sertifikat</span>
                                <button type="button" onclick="updateCertPreview()" style="font-size:.72rem;color:#1d4ed8;font-weight:600;background:none;border:none;cursor:pointer;padding:0;">Perbarui Preview</button>
                            </div>
                            <div id="certPreviewBox" style="background:linear-gradient(145deg,#0d1b4b 0%,#162152 40%,#1a2d6e 100%);border-radius:12px;padding:2rem 1.75rem;text-align:center;position:relative;overflow:hidden;max-width:520px;margin:0 auto;">
                                <div style="position:absolute;top:-40px;right:-40px;width:150px;height:150px;border-radius:50%;border:1px solid rgba(255,255,255,.07);"></div>
                                <div style="position:relative;z-index:2;">
                                    <div style="font-size:.65rem;font-weight:800;letter-spacing:.15em;color:rgba(255,255,255,.4);text-transform:uppercase;margin-bottom:.25rem;">— EVENTTY —</div>
                                    <div style="font-size:.58rem;color:rgba(255,255,255,.3);letter-spacing:.1em;margin-bottom:1.25rem;">SMKN 20 JAKARTA</div>
                                    <div style="width:36px;height:1.5px;background:rgba(255,255,255,.15);margin:0 auto .875rem;"></div>
                                    <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#93c5fd;margin-bottom:.15rem;">Certificate</div>
                                    <div style="font-size:1.1rem;font-weight:800;color:#fff;margin-bottom:.875rem;" id="prevCertTitle">OF PARTICIPATION</div>
                                    <div style="font-size:.6rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.35rem;">Diberikan kepada</div>
                                    <div style="font-size:.95rem;font-weight:800;color:#fbbf24;margin-bottom:.875rem;">NAMA PESERTA</div>
                                    <div style="font-size:.6rem;color:rgba(255,255,255,.4);margin-bottom:.3rem;">atas partisipasinya dalam</div>
                                    <div style="font-size:.825rem;font-weight:700;color:#fff;margin-bottom:.35rem;" id="prevEventName">NAMA EVENT</div>
                                    <div style="font-size:.6rem;color:rgba(255,255,255,.35);margin-bottom:1rem;" id="prevEventDate">Tanggal Event</div>
                                    <div style="width:36px;height:1px;background:rgba(255,255,255,.1);margin:0 auto .875rem;"></div>
                                    <div style="display:flex;align-items:center;justify-content:space-evenly;padding-top:.5rem;">
                                        <div style="text-align:center;">
                                            <div style="width:48px;height:1px;background:rgba(255,255,255,.2);margin:0 auto .35rem;"></div>
                                            <div style="font-size:.58rem;color:rgba(255,255,255,.4);" id="prevSigner">Penandatangan</div>
                                            <div style="font-size:.52rem;color:rgba(255,255,255,.3);" id="prevSignerRole">Jabatan</div>
                                        </div>
                                        <div style="text-align:center;">
                                            <div id="certQrBox" style="width:52px;height:52px;border-radius:8px;background:#f8fafc;padding:4px;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 18px rgba(15,23,42,.18);margin:0 auto .35rem;overflow:hidden;">
                                                <svg id="certQrSvg" width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" aria-label="QR code preview"></svg>
                                            </div>
                                            <div style="font-size:.5rem;color:rgba(255,255,255,.25);">QR Code</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p style="font-size:.68rem;color:#94a3b8;text-align:center;margin-top:.625rem;">Preview. Nama peserta akan diisi otomatis.</p>
                        </div>
                    </div>
                </div>

                {{-- ── Status ── --}}
                <div class="form-section">
                    <h2 class="form-section-title">Status Event</h2>
                    <div class="form-row">
                        <div class="input-group">
                            <label class="input-label" for="eventStatus">Status</label>
                            <select id="eventStatus" class="input-field">
                                <option value="draft">Draft</option>
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ url('/admin/events') }}" class="abtn abtn-secondary">Batal</a>
                    <button type="submit" class="abtn abtn-primary">
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
var certEnabled = null;

function setCertOpt(yes) {
    certEnabled = yes;
    var optYes  = document.getElementById('certOptYes');
    var optNo   = document.getElementById('certOptNo');
    var radYes  = document.getElementById('certRadioYes');
    var radNo   = document.getElementById('certRadioNo');
    var config  = document.getElementById('certConfig');

    if (yes) {
        optYes.style.borderColor  = '#2563eb';
        optYes.style.background   = '#eff6ff';
        optNo.style.borderColor   = '#e2e8f0';
        optNo.style.background    = '#fff';
        radYes.style.borderColor  = '#2563eb';
        radYes.style.background   = '#2563eb';
        radYes.innerHTML          = '<div style="width:7px;height:7px;border-radius:50%;background:#fff;"></div>';
        radNo.style.borderColor   = '#d1d5db';
        radNo.style.background    = 'transparent';
        radNo.innerHTML           = '';
        config.style.display      = 'block';
        updateCertPreview();
    } else {
        optNo.style.borderColor   = '#2563eb';
        optNo.style.background    = '#eff6ff';
        optYes.style.borderColor  = '#e2e8f0';
        optYes.style.background   = '#fff';
        radNo.style.borderColor   = '#2563eb';
        radNo.style.background    = '#2563eb';
        radNo.innerHTML           = '<div style="width:7px;height:7px;border-radius:50%;background:#fff;"></div>';
        radYes.style.borderColor  = '#d1d5db';
        radYes.style.background   = 'transparent';
        radYes.innerHTML          = '';
        config.style.display      = 'none';
    }
}

function buildQrSvg(seed) {
    var size = 44;
    var cell = 4;
    var matrix = Array.from({ length: size / cell }, function () {
        return Array(size / cell).fill(0);
    });

    var fill = function (x, y) {
        if (x >= 0 && y >= 0 && x < matrix.length && y < matrix.length) {
            matrix[y][x] = 1;
        }
    };

    var finder = function (x, y) {
        for (var dy = 0; dy < 7; dy++) {
            for (var dx = 0; dx < 7; dx++) {
                var border = dx === 0 || dy === 0 || dx === 6 || dy === 6;
                var center = dx >= 2 && dx <= 4 && dy >= 2 && dy <= 4;
                if (border || center) {
                    fill(x + dx, y + dy);
                }
            }
        }
    };

    finder(0, 0);
    finder(matrix.length - 7, 0);
    finder(0, matrix.length - 7);

    for (var y = 0; y < matrix.length; y++) {
        for (var x = 0; x < matrix.length; x++) {
            if (matrix[y][x] !== 1) {
                var v = ((x * 13 + y * 17 + seed * 7) % 11);
                if (v < 5) {
                    matrix[y][x] = 1;
                }
            }
        }
    }

    var svg = '<rect width="44" height="44" fill="#f8fafc"/>';
    for (var y = 0; y < matrix.length; y++) {
        for (var x = 0; x < matrix.length; x++) {
            if (matrix[y][x]) {
                svg += '<rect x="' + (x * cell + 1) + '" y="' + (y * cell + 1) + '" width="' + (cell - 1) + '" height="' + (cell - 1) + '" fill="#0f172a"/>';
            }
        }
    }
    return svg;
}

function updateCertPreview() {
    var title   = document.getElementById('certTitle').value || 'Certificate of Participation';
    var signer  = document.getElementById('certSigner').value || 'Penandatangan';
    var role    = document.getElementById('certSignerRole').value || 'Jabatan';
    var evName  = (document.getElementById('eventName').value || 'NAMA EVENT').toUpperCase();
    var evDate  = document.getElementById('eventDate').value || 'Tanggal Event';
    var parts   = evDate.split('-');
    var months  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    var fmtDate = parts.length === 3 ? parts[2]+' '+months[parseInt(parts[1])-1]+' '+parts[0] : evDate;

    var titleParts  = title.split(' ');
    var titleSuffix = titleParts.slice(2).join(' ').toUpperCase() || 'PARTICIPATION';

    document.getElementById('prevCertTitle').textContent  = 'OF ' + titleSuffix;
    document.getElementById('prevEventName').textContent  = evName;
    document.getElementById('prevEventDate').textContent  = fmtDate;
    document.getElementById('prevSigner').textContent     = signer;
    document.getElementById('prevSignerRole').textContent = role;

    var qrSvg = document.getElementById('certQrSvg');
    if (qrSvg) {
        qrSvg.innerHTML = buildQrSvg((evName.length + title.length) % 9 || 3);
    }
}

const certTemplateUpload = document.getElementById('certTemplateUpload');
const certTemplateImage = document.getElementById('certTemplateImage');
const certTemplatePlaceholder = document.getElementById('certTemplatePlaceholder');

function removeCertTemplate() {
    if (certTemplateUpload) certTemplateUpload.value = '';
    if (certTemplateImage) {
        certTemplateImage.src = '';
        certTemplateImage.style.display = 'none';
    }
    if (certTemplatePlaceholder) certTemplatePlaceholder.style.display = 'block';
}

if (certTemplateUpload) {
    certTemplateUpload.addEventListener('change', function (event) {
        var file = event.target.files && event.target.files[0];
        if (!file) return;

        var reader = new FileReader();
        reader.onload = function (e) {
            if (certTemplateImage) {
                certTemplateImage.src = e.target.result;
                certTemplateImage.style.display = 'block';
            }
            if (certTemplatePlaceholder) certTemplatePlaceholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
}

document.getElementById('eventName').addEventListener('input', function() { if(certEnabled) updateCertPreview(); });
document.getElementById('eventDate').addEventListener('change', function() { if(certEnabled) updateCertPreview(); });
window.addEventListener('DOMContentLoaded', function () {
    updateCertPreview();
});
</script>
</body>
</html>
