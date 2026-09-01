@extends('user.layout')

@section('title', 'Sertifikat')

@push('css')
<style>
/* â•â• Certificates Page â•â• */
.cert-page { padding: 1.5rem 1.75rem; font-family:'Plus Jakarta Sans','Inter',sans-serif; }
.cert-page-title { font-size:1.35rem; font-weight:800; color:var(--text-primary); margin-bottom:1.5rem; }

/* Tabs */
.cert-tabs { display:flex; gap:4px; background:var(--bg-tertiary); border-radius:12px; padding:4px; margin-bottom:1.75rem; width:fit-content; }
.cert-tab { padding:.5rem 1.25rem; border-radius:9px; font-size:.825rem; font-weight:700; border:none; cursor:pointer; background:transparent; color:var(--text-muted); transition:all .2s; font-family:inherit; white-space:nowrap; }
.cert-tab.active { background:var(--bg-secondary); color:var(--text-primary); box-shadow:0 1px 4px rgba(0,0,0,.08); }

/* Tab panels */
.cert-panel { display:none; }
.cert-panel.active { display:block; }

/* Grid */
.cert-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(290px,1fr)); gap:18px; }

/* Card */
.cert-card { background:var(--bg-secondary); border:1.5px solid var(--border-color); border-radius:16px; overflow:hidden; transition:all .2s; display:flex; flex-direction:column; }
.cert-card:hover { box-shadow:0 6px 24px rgba(0,0,0,.07); border-color:var(--border-color-hover); transform:translateY(-2px); }

.cert-card-banner { height:120px; position:relative; overflow:hidden; flex-shrink:0; }
.cert-card-banner img { width:100%; height:100%; object-fit:cover; display:block; }
.cert-card-banner .cert-type-badge { position:absolute; top:10px; left:10px; padding:3px 9px; border-radius:6px; font-size:.65rem; font-weight:800; text-transform:uppercase; letter-spacing:.04em; background:rgba(15,31,78,.75); color:#fff; backdrop-filter:blur(4px); }

.cert-card-body { padding:1rem 1.1rem 1.1rem; flex:1; display:flex; flex-direction:column; }
.cert-card-event { font-size:.95rem; font-weight:800; color:var(--text-primary); margin-bottom:.3rem; line-height:1.3; }
.cert-card-sub   { font-size:.75rem; color:var(--text-muted); font-weight:500; margin-bottom:.875rem; }

.cert-card-date  { display:flex; align-items:center; gap:5px; font-size:.72rem; color:var(--text-muted); font-weight:500; margin-bottom:.875rem; }
.cert-card-date svg { flex-shrink:0; }

/* Status states */
.cert-status-row { display:flex; align-items:center; gap:8px; margin-bottom:1rem; }

.cert-badge-available { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:999px; background:#dcfce7; color:#15803d; font-size:.7rem; font-weight:700; }
.cert-badge-waiting   { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:999px; background:var(--warning-light); color:#b45309; font-size:.7rem; font-weight:700; }
.cert-badge-achievement { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:999px; background:#fef3c7; color:#92400e; font-size:.7rem; font-weight:700; }

.cert-actions { display:flex; gap:7px; margin-top:auto; flex-wrap:wrap; }
.cert-btn-view { flex:1; min-width:80px; padding:.55rem .875rem; border-radius:9px; border:1.5px solid var(--border-color); background:transparent; color:var(--text-secondary); font-size:.78rem; font-weight:700; cursor:pointer; transition:all .15s; font-family:inherit; }
.cert-btn-view:hover { border-color:var(--primary); color:var(--primary); }
.cert-btn-download { flex:1; min-width:80px; padding:.55rem .875rem; border-radius:9px; border:none; background:var(--primary); color:#fff; font-size:.78rem; font-weight:700; cursor:pointer; transition:all .15s; font-family:inherit; display:flex; align-items:center; justify-content:center; gap:5px; }
.cert-btn-download:hover { background:var(--primary-hover); }
.cert-btn-locked { flex:1; padding:.55rem .875rem; border-radius:9px; border:1.5px solid var(--border-color); background:var(--bg-tertiary); color:var(--text-muted); font-size:.78rem; font-weight:700; cursor:not-allowed; font-family:inherit; display:flex; align-items:center; justify-content:center; gap:5px; opacity:.7; }

/* Achievement badge on card */
.cert-achievement-badge { display:flex; align-items:center; justify-content:center; gap:10px; padding:.75rem; background:linear-gradient(135deg,#fef9c3,#fef3c7); border:1.5px solid #fde68a; border-radius:11px; margin-bottom:.875rem; }
.cert-achievement-rank  { font-size:1.3rem; font-weight:900; color:#92400e; line-height:1; }
.cert-achievement-info  { display:flex; flex-direction:column; }
.cert-achievement-label { font-size:.62rem; font-weight:600; color:#b45309; text-transform:uppercase; letter-spacing:.04em; }
.cert-achievement-value { font-size:.875rem; font-weight:800; color:#78350f; }

/* Empty state */
.cert-empty { display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px; padding:4rem 2rem; text-align:center; color:var(--text-muted); }
.cert-empty svg { opacity:.25; margin-bottom:4px; }
.cert-empty p { font-size:.875rem; line-height:1.6; }

/* â”€â”€ Preview Modal â”€â”€ */
.cert-modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,.6); display:flex; align-items:center; justify-content:center; z-index:9999; opacity:0; visibility:hidden; transition:all .25s; padding:1rem; }
.cert-modal-overlay.active { opacity:1; visibility:visible; }

.cert-modal-box { background:var(--bg-secondary); border-radius:18px; width:100%; max-width:640px; max-height:92vh; overflow-y:auto; box-shadow:0 24px 64px rgba(0,0,0,.3); transform:scale(.96); transition:transform .25s; }
.cert-modal-overlay.active .cert-modal-box { transform:scale(1); }

.cert-modal-hd { display:flex; align-items:center; justify-content:space-between; padding:1rem 1.25rem; border-bottom:1px solid var(--border-color); }
.cert-modal-hd-title { font-size:.9rem; font-weight:700; color:var(--text-primary); }
.cert-modal-close { width:30px; height:30px; border-radius:50%; border:1.5px solid var(--border-color); background:transparent; color:var(--text-secondary); cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:1rem; transition:all .15s; }
.cert-modal-close:hover { background:var(--bg-tertiary); color:var(--text-primary); }

/* Certificate preview design */
.cert-preview-wrap { padding:1.5rem; }
.cert-preview { background:linear-gradient(145deg,#0d1b4b 0%,#162152 40%,#1a2d6e 100%); border-radius:14px; padding:2.5rem 2rem; text-align:center; position:relative; overflow:hidden; }
.cert-preview::before { content:''; position:absolute; top:-60px; right:-60px; width:200px; height:200px; border-radius:50%; border:1px solid rgba(255,255,255,.06); }
.cert-preview::after  { content:''; position:absolute; bottom:-40px; left:-40px; width:150px; height:150px; border-radius:50%; border:1px solid rgba(255,255,255,.06); }
.cert-preview-logo { font-size:.8rem; font-weight:800; color:rgba(255,255,255,.5); letter-spacing:.15em; text-transform:uppercase; margin-bottom:.5rem; }
.cert-preview-school { font-size:.65rem; font-weight:600; color:rgba(255,255,255,.4); letter-spacing:.1em; margin-bottom:1.75rem; }
.cert-preview-divider { width:50px; height:2px; background:rgba(255,255,255,.2); border-radius:1px; margin:0 auto 1.5rem; }
.cert-preview-type { font-size:.72rem; font-weight:700; letter-spacing:.15em; text-transform:uppercase; color:#93c5fd; margin-bottom:.25rem; }
.cert-preview-heading { font-size:1.5rem; font-weight:800; color:#ffffff; letter-spacing:-.5px; margin-bottom:.25rem; line-height:1.2; }
.cert-preview-sub { font-size:.72rem; color:rgba(255,255,255,.5); margin-bottom:1.75rem; }
.cert-preview-given { font-size:.72rem; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.1em; margin-bottom:.5rem; }
.cert-preview-name { font-size:1.35rem; font-weight:800; color:#fbbf24; letter-spacing:-.3px; margin-bottom:1.5rem; }
.cert-preview-for   { font-size:.7rem; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.08em; margin-bottom:.4rem; }
.cert-preview-event { font-size:1.1rem; font-weight:700; color:#ffffff; margin-bottom:.5rem; }
.cert-preview-date  { font-size:.72rem; color:rgba(255,255,255,.45); margin-bottom:1.75rem; }
.cert-preview-achievement { display:inline-block; padding:.5rem 1.5rem; background:linear-gradient(135deg,#f59e0b,#d97706); border-radius:999px; font-size:.875rem; font-weight:800; color:#fff; letter-spacing:.02em; margin-bottom:1.5rem; }
.cert-preview-footer { display:flex; align-items:center; justify-content:center; gap:6px; font-size:.62rem; color:rgba(255,255,255,.3); font-weight:600; letter-spacing:.08em; text-transform:uppercase; padding-top:1.5rem; border-top:1px solid rgba(255,255,255,.08); }

.cert-modal-ft { padding:1rem 1.25rem; border-top:1px solid var(--border-color); display:flex; justify-content:flex-end; gap:.625rem; flex-wrap:wrap; }

/* Dark mode */
body[data-theme="dark"] .cert-card { border-color:var(--border-color); }
body[data-theme="dark"] .cert-preview { background:linear-gradient(145deg,#0a1535 0%,#0f1f4e 40%,#162152 100%); }

/* Responsive */
@media (max-width:768px) {
    .cert-page { padding:1rem; }
    .cert-grid { grid-template-columns:1fr; }
    .cert-tabs { width:100%; }
    .cert-tab  { flex:1; text-align:center; }
}
</style>
@endpush


@section('content')
<div class="cert-page">
    <h1 class="cert-page-title">Sertifikat Saya</h1>

    {{-- Filter & Search --}}
    <div style="display:flex;gap:.65rem;flex-wrap:wrap;margin-bottom:1.25rem;align-items:center;">
        <input type="text" id="certSearch" placeholder="🔍 Cari nama event..."
               style="padding:.5rem .875rem;border:1.5px solid var(--border-color);border-radius:999px;font-size:.82rem;background:var(--bg-secondary);color:var(--text-primary);outline:none;min-width:220px;">
        <select id="typeFilter"
                style="padding:.5rem .875rem;border:1.5px solid var(--border-color);border-radius:999px;font-size:.82rem;background:var(--bg-secondary);color:var(--text-primary);">
            <option value="all">Semua Tipe</option>
            <option value="participation">Participation</option>
            <option value="completion">Completion</option>
            <option value="attendance">Attendance</option>
            <option value="achievement">Achievement</option>
        </select>
    </div>

    {{-- Certificate Grid — diisi oleh certificates.js via API --}}
    <div class="cert-grid" id="certificatesGrid">
        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text-muted);">
            <p>Memuat sertifikat...</p>
        </div>
    </div>

    {{-- Modal Preview Sertifikat --}}
    <div class="cert-modal-overlay" id="certPreviewModal">
        <div class="cert-modal">
            <button class="cert-modal-close" id="closeCertModal">✕</button>
            <div class="cert-modal-preview" id="certModalContent">
                {{-- Diisi oleh JS --}}
            </div>
        </div>
    </div>

</div>

{{-- Pass nama user ke JS agar dipakai di preview sertifikat --}}
<script>
    window.authUserName = @json(Auth::user()->name);
    window.authUserNis  = @json(Auth::user()->nis ?? '');
    window.authUserClass = @json(Auth::user()->class ?? '');
</script>
@endsection

@push('js')
@vite(['resources/js/utils/api.js', 'resources/js/user/certificates.js'])
@endpush
