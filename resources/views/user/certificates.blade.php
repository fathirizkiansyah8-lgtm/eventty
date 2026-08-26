@extends('user.layout')

@section('title', 'Sertifikat')

@push('css')
<style>
/* ══ Certificates Page ══ */
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

/* ── Preview Modal ── */
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

    {{-- Tabs --}}
    <div class="cert-tabs">
        <button class="cert-tab active" data-panel="general" onclick="switchCertTab('general',this)">Event Umum</button>
        <button class="cert-tab"        data-panel="competition" onclick="switchCertTab('competition',this)">Kompetisi</button>
    </div>

    {{-- Panel: Event Umum --}}
    <div class="cert-panel active" id="cert-panel-general">
        <div class="cert-grid">

            {{-- Available --}}
            <div class="cert-card">
                <div class="cert-card-banner">
                    <img src="{{ asset('images/sertifikat.png') }}" alt="Workshop Leadership">
                    <span class="cert-type-badge">Workshop</span>
                </div>
                <div class="cert-card-body">
                    <h3 class="cert-card-event">Workshop Leadership</h3>
                    <p class="cert-card-sub">Certificate of Participation</p>
                    <div class="cert-card-date"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>15 Agustus 2026</div>
                    <div class="cert-status-row">
                        <span class="cert-badge-available">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Sertifikat Tersedia
                        </span>
                    </div>
                    <div class="cert-actions">
                        <button class="cert-btn-view" onclick="previewCert({type:'participation',event:'Workshop Leadership',date:'15 Agustus 2026',name:'Fathi Rizkiansyah',kind:'Certificate of Participation'})">Lihat</button>
                        <button class="cert-btn-download"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>Download</button>
                    </div>
                </div>
            </div>

            {{-- Available --}}
            <div class="cert-card">
                <div class="cert-card-banner">
                    <img src="{{ asset('images/seminar.png') }}" alt="Seminar Teknologi">
                    <span class="cert-type-badge">Seminar</span>
                </div>
                <div class="cert-card-body">
                    <h3 class="cert-card-event">Seminar Teknologi</h3>
                    <p class="cert-card-sub">Certificate of Attendance</p>
                    <div class="cert-card-date"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>28 Juli 2026</div>
                    <div class="cert-status-row">
                        <span class="cert-badge-available">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Sertifikat Tersedia
                        </span>
                    </div>
                    <div class="cert-actions">
                        <button class="cert-btn-view" onclick="previewCert({type:'participation',event:'Seminar Teknologi',date:'28 Juli 2026',name:'Fathi Rizkiansyah',kind:'Certificate of Attendance'})">Lihat</button>
                        <button class="cert-btn-download"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>Download</button>
                    </div>
                </div>
            </div>

            {{-- Waiting --}}
            <div class="cert-card">
                <div class="cert-card-banner" style="background:var(--bg-tertiary);display:flex;align-items:center;justify-content:center;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" opacity=".4"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                    <span class="cert-type-badge">Career</span>
                </div>
                <div class="cert-card-body">
                    <h3 class="cert-card-event">Career Day 2026</h3>
                    <p class="cert-card-sub">Certificate of Participation</p>
                    <div class="cert-card-date"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>15 September 2026</div>
                    <div class="cert-status-row">
                        <span class="cert-badge-waiting">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Menunggu Kehadiran
                        </span>
                    </div>
                    <div class="cert-actions">
                        <button class="cert-btn-locked">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Sertifikat Terkunci
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Panel: Kompetisi --}}
    <div class="cert-panel" id="cert-panel-competition">
        <div class="cert-grid">

            {{-- Juara 1 --}}
            <div class="cert-card">
                <div class="cert-card-banner">
                    <img src="{{ asset('images/basket.jpeg') }}" alt="Turnamen Basket">
                    <span class="cert-type-badge">Kompetisi</span>
                </div>
                <div class="cert-card-body">
                    <h3 class="cert-card-event">Turnamen Basket</h3>
                    <p class="cert-card-sub">Certificate of Achievement</p>
                    <div class="cert-card-date"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>10 Oktober 2026</div>
                    <div class="cert-achievement-badge">
                        <span class="cert-achievement-rank">🥇</span>
                        <div class="cert-achievement-info">
                            <span class="cert-achievement-label">Penghargaan</span>
                            <span class="cert-achievement-value">JUARA 1</span>
                        </div>
                    </div>
                    <div class="cert-status-row">
                        <span class="cert-badge-achievement">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Sertifikat Tersedia
                        </span>
                    </div>
                    <div class="cert-actions">
                        <button class="cert-btn-view" onclick="previewCert({type:'achievement',event:'Turnamen Basket',date:'10 Oktober 2026',name:'Fathi Rizkiansyah',rank:'JUARA 1'})">Lihat</button>
                        <button class="cert-btn-download"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>Download</button>
                    </div>
                </div>
            </div>

            {{-- Juara 2 --}}
            <div class="cert-card">
                <div class="cert-card-banner">
                    <img src="{{ asset('images/classmeeting.jpeg') }}" alt="Class Meeting">
                    <span class="cert-type-badge">Kompetisi</span>
                </div>
                <div class="cert-card-body">
                    <h3 class="cert-card-event">Class Meeting — Futsal</h3>
                    <p class="cert-card-sub">Certificate of Achievement</p>
                    <div class="cert-card-date"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>20 September 2026</div>
                    <div class="cert-achievement-badge">
                        <span class="cert-achievement-rank">🥈</span>
                        <div class="cert-achievement-info">
                            <span class="cert-achievement-label">Penghargaan</span>
                            <span class="cert-achievement-value">JUARA 2</span>
                        </div>
                    </div>
                    <div class="cert-status-row">
                        <span class="cert-badge-achievement">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Sertifikat Tersedia
                        </span>
                    </div>
                    <div class="cert-actions">
                        <button class="cert-btn-view" onclick="previewCert({type:'achievement',event:'Class Meeting — Futsal',date:'20 September 2026',name:'Fathi Rizkiansyah',rank:'JUARA 2'})">Lihat</button>
                        <button class="cert-btn-download"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>Download</button>
                    </div>
                </div>
            </div>

            {{-- Waiting competition --}}
            <div class="cert-card">
                <div class="cert-card-banner" style="background:var(--bg-tertiary);display:flex;align-items:center;justify-content:center;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" opacity=".4"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                    <span class="cert-type-badge">Kompetisi</span>
                </div>
                <div class="cert-card-body">
                    <h3 class="cert-card-event">Lomba Desain Grafis</h3>
                    <p class="cert-card-sub">Certificate of Achievement</p>
                    <div class="cert-card-date"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>3 Oktober 2026</div>
                    <div class="cert-status-row">
                        <span class="cert-badge-waiting">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Menunggu Hasil
                        </span>
                    </div>
                    <div class="cert-actions">
                        <button class="cert-btn-locked">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Menunggu Pengumuman
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Preview Modal --}}
<div class="cert-modal-overlay" id="certPreviewModal" onclick="closeCertPreview(event)">
    <div class="cert-modal-box">
        <div class="cert-modal-hd">
            <span class="cert-modal-hd-title" id="certModalTitle">Preview Sertifikat</span>
            <button class="cert-modal-close" onclick="document.getElementById('certPreviewModal').classList.remove('active');document.body.style.overflow=''">✕</button>
        </div>
        <div class="cert-preview-wrap">
            <div class="cert-preview" id="certPreviewContent">
                {{-- Rendered by JS --}}
            </div>
        </div>
        <div class="cert-modal-ft">
            <button class="btn btn-outline btn-sm" onclick="document.getElementById('certPreviewModal').classList.remove('active');document.body.style.overflow=''">Tutup</button>
            <button class="btn btn-primary btn-sm">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download Sertifikat
            </button>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function switchCertTab(panel, btn) {
    document.querySelectorAll('.cert-tab').forEach(function(b){ b.classList.remove('active'); });
    document.querySelectorAll('.cert-panel').forEach(function(p){ p.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('cert-panel-' + panel).classList.add('active');
}

function previewCert(data) {
    var modal   = document.getElementById('certPreviewModal');
    var title   = document.getElementById('certModalTitle');
    var content = document.getElementById('certPreviewContent');
    title.textContent = 'Preview — ' + data.event;
    if (data.type === 'achievement') {
        content.innerHTML =
            '<div class="cert-preview-logo">— EVENTTY —</div>' +
            '<div class="cert-preview-school">SMKN 20 JAKARTA</div>' +
            '<div class="cert-preview-divider"></div>' +
            '<div class="cert-preview-type">Certificate</div>' +
            '<div class="cert-preview-heading">OF ACHIEVEMENT</div>' +
            '<div class="cert-preview-divider" style="margin-bottom:1.5rem"></div>' +
            '<div class="cert-preview-given">Diberikan kepada</div>' +
            '<div class="cert-preview-name">' + data.name.toUpperCase() + '</div>' +
            '<div class="cert-preview-for">sebagai</div>' +
            '<div class="cert-preview-achievement">' + data.rank + '</div>' +
            '<div class="cert-preview-event">' + data.event + '</div>' +
            '<div class="cert-preview-date">' + data.date + '</div>' +
            '<div class="cert-preview-footer"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>&nbsp;EVENTTY · SMKN 20 JAKARTA</div>';
    } else {
        content.innerHTML =
            '<div class="cert-preview-logo">— EVENTTY —</div>' +
            '<div class="cert-preview-school">SMKN 20 JAKARTA</div>' +
            '<div class="cert-preview-divider"></div>' +
            '<div class="cert-preview-type">Certificate</div>' +
            '<div class="cert-preview-heading">' + data.kind.replace('Certificate of ','OF ') + '</div>' +
            '<div class="cert-preview-divider" style="margin-bottom:1.5rem"></div>' +
            '<div class="cert-preview-given">Diberikan kepada</div>' +
            '<div class="cert-preview-name">' + data.name.toUpperCase() + '</div>' +
            '<div class="cert-preview-for">atas partisipasinya dalam</div>' +
            '<div class="cert-preview-event">' + data.event.toUpperCase() + '</div>' +
            '<div class="cert-preview-date">' + data.date + '</div>' +
            '<div class="cert-preview-footer"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>&nbsp;EVENTTY · SMKN 20 JAKARTA</div>';
    }
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeCertPreview(e) {
    if (e.target === document.getElementById('certPreviewModal')) {
        document.getElementById('certPreviewModal').classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('certPreviewModal').classList.remove('active');
        document.body.style.overflow = '';
    }
});
</script>
@endpush
