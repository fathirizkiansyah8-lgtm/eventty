@extends('user.layout')

@section('title', 'My Events')

@push('css')
<style>
/* ══ My Events Page ══ */
.myev-page { padding:1.5rem 1.75rem; font-family:'Plus Jakarta Sans','Inter',sans-serif; }

.myev-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:.75rem; }
.myev-page-title { font-size:1.35rem; font-weight:800; color:var(--text-primary); }

/* Filter chips */
.myev-filters { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:1.5rem; }
.myev-chip { padding:.38rem 1rem; border-radius:999px; font-size:.78rem; font-weight:600; border:1.5px solid var(--border-color); background:var(--bg-secondary); color:var(--text-secondary); cursor:pointer; transition:all .15s; white-space:nowrap; user-select:none; }
.myev-chip:hover { border-color:var(--primary); color:var(--primary); }
.myev-chip.active { background:var(--primary); border-color:var(--primary); color:#fff; }

/* Stats row */
.myev-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:1.75rem; }
.myev-stat-card { background:var(--bg-secondary); border:1.5px solid var(--border-color); border-radius:13px; padding:.875rem 1rem; text-align:center; }
.myev-stat-num { font-size:1.5rem; font-weight:800; color:var(--text-primary); display:block; line-height:1.1; }
.myev-stat-lbl { font-size:.7rem; color:var(--text-muted); font-weight:500; margin-top:3px; display:block; }

/* Events list */
.myev-list { display:flex; flex-direction:column; gap:12px; }

.myev-item { background:var(--bg-secondary); border:1.5px solid var(--border-color); border-radius:14px; overflow:hidden; display:flex; align-items:stretch; transition:all .2s; }
.myev-item:hover { box-shadow:0 4px 18px rgba(0,0,0,.07); border-color:var(--border-color-hover); }

.myev-item-img { width:100px; flex-shrink:0; overflow:hidden; background:var(--bg-tertiary); }
.myev-item-img img { width:100%; height:100%; object-fit:cover; display:block; }

.myev-item-body { flex:1; padding:.875rem 1.1rem; display:flex; align-items:center; gap:1rem; min-width:0; }

.myev-item-left { flex:1; min-width:0; }
.myev-item-cat { display:inline-block; font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; padding:2px 8px; border-radius:5px; margin-bottom:.4rem; }
.myev-item-cat.seminar    { background:#dbeafe; color:#1d4ed8; }
.myev-item-cat.workshop   { background:#dcfce7; color:#15803d; }
.myev-item-cat.competition{ background:#fef3c7; color:#b45309; }
.myev-item-cat.career     { background:#ede9fe; color:#6d28d9; }

.myev-item-title { font-size:.925rem; font-weight:800; color:var(--text-primary); margin-bottom:.35rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.myev-item-meta  { display:flex; flex-wrap:wrap; gap:.5rem .875rem; }
.myev-item-meta-i{ display:flex; align-items:center; gap:4px; font-size:.72rem; color:var(--text-muted); font-weight:500; }
.myev-item-meta-i svg { flex-shrink:0; }

.myev-item-right { display:flex; flex-direction:column; align-items:flex-end; gap:.625rem; flex-shrink:0; }

/* Status badges */
.myev-status { display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:999px; font-size:.7rem; font-weight:700; white-space:nowrap; }
.myev-status.registered { background:#dbeafe; color:#1d4ed8; }
.myev-status.upcoming   { background:#dcfce7; color:#15803d; }
.myev-status.ongoing    { background:#fef3c7; color:#b45309; }
.myev-status.completed  { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.myev-status.attended   { background:#dcfce7; color:#15803d; }
.myev-status.absent     { background:#fee2e2; color:#dc2626; }

.myev-item-actions { display:flex; gap:6px; }
.myev-btn-detail { padding:.4rem .875rem; border-radius:8px; border:1.5px solid var(--border-color); background:transparent; color:var(--text-secondary); font-size:.75rem; font-weight:700; cursor:pointer; transition:all .15s; font-family:inherit; white-space:nowrap; }
.myev-btn-detail:hover { border-color:var(--primary); color:var(--primary); }

/* Empty state */
.myev-empty { display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px; padding:4rem 2rem; text-align:center; color:var(--text-muted); }
.myev-empty svg { opacity:.22; margin-bottom:4px; }
.myev-empty h3 { font-size:1rem; font-weight:700; color:var(--text-secondary); }
.myev-empty p  { font-size:.825rem; line-height:1.6; }

/* Dark mode */
body[data-theme="dark"] .myev-item-cat.seminar    { background:rgba(219,234,254,.15); }
body[data-theme="dark"] .myev-item-cat.workshop   { background:rgba(220,252,231,.15); }
body[data-theme="dark"] .myev-item-cat.competition{ background:rgba(254,243,199,.15); }
body[data-theme="dark"] .myev-item-cat.career     { background:rgba(237,233,254,.15); }

/* Responsive */
@media (max-width:768px) {
    .myev-page { padding:1rem; }
    .myev-stats { grid-template-columns:repeat(2,1fr); }
    .myev-item-img { width:70px; }
    .myev-item-body { flex-direction:column; align-items:flex-start; gap:.625rem; padding:.75rem; }
    .myev-item-right { align-items:flex-start; flex-direction:row; flex-wrap:wrap; }
}
@media (max-width:480px) {
    .myev-stats { grid-template-columns:1fr 1fr; }
    .myev-item-img { display:none; }
}
</style>
@endpush

@section('content')
<div class="myev-page">

    <div class="myev-top">
        <h1 class="myev-page-title">My Events</h1>
    </div>

    {{-- Stats --}}
    <div class="myev-stats">
        <div class="myev-stat-card">
            <span class="myev-stat-num" id="statTotal">5</span>
            <span class="myev-stat-lbl">Total Terdaftar</span>
        </div>
        <div class="myev-stat-card">
            <span class="myev-stat-num" id="statUpcoming">3</span>
            <span class="myev-stat-lbl">Akan Datang</span>
        </div>
        <div class="myev-stat-card">
            <span class="myev-stat-num" id="statCompleted">2</span>
            <span class="myev-stat-lbl">Selesai Dihadiri</span>
        </div>
        <div class="myev-stat-card">
            <span class="myev-stat-num" id="statCerts">2</span>
            <span class="myev-stat-lbl">Sertifikat Tersedia</span>
        </div>
    </div>

    {{-- Filter chips --}}
    <div class="myev-filters">
        <span class="myev-chip active" data-filter="all">Semua</span>
        <span class="myev-chip" data-filter="registered">Terdaftar</span>
        <span class="myev-chip" data-filter="upcoming">Akan Datang</span>
        <span class="myev-chip" data-filter="completed">Selesai</span>
        <span class="myev-chip" data-filter="attended">Hadir</span>
    </div>

    {{-- Events list --}}
    <div class="myev-list" id="myEvList">

        <div class="myev-item" data-status="upcoming">
            <div class="myev-item-img"><img src="{{ asset('images/seminar.png') }}" alt="Seminar Digital"></div>
            <div class="myev-item-body">
                <div class="myev-item-left">
                    <span class="myev-item-cat seminar">Seminar</span>
                    <div class="myev-item-title">Seminar Digital</div>
                    <div class="myev-item-meta">
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>10 September 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>08:00 – 12:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status upcoming">Akan Datang</span>
                    <div class="myev-item-actions">
                        <button class="myev-btn-detail">Detail</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="myev-item" data-status="registered">
            <div class="myev-item-img"><img src="{{ asset('images/careerday.jpeg') }}" alt="Career Day"></div>
            <div class="myev-item-body">
                <div class="myev-item-left">
                    <span class="myev-item-cat career">Career</span>
                    <div class="myev-item-title">Career Day 2026</div>
                    <div class="myev-item-meta">
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>15 September 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>08:00 – 15:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status registered">Terdaftar</span>
                    <div class="myev-item-actions">
                        <button class="myev-btn-detail">Detail</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="myev-item" data-status="upcoming">
            <div class="myev-item-img"><img src="{{ asset('images/classmeeting.jpeg') }}" alt="Class Meeting"></div>
            <div class="myev-item-body">
                <div class="myev-item-left">
                    <span class="myev-item-cat competition">Kompetisi</span>
                    <div class="myev-item-title">Class Meeting 2026</div>
                    <div class="myev-item-meta">
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>20 September 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>07:30 – 17:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Lapangan Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status registered">Terdaftar</span>
                    <div class="myev-item-actions">
                        <button class="myev-btn-detail">Detail</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="myev-item" data-status="attended">
            <div class="myev-item-img"><img src="{{ asset('images/sertifikat.png') }}" alt="Workshop Leadership"></div>
            <div class="myev-item-body">
                <div class="myev-item-left">
                    <span class="myev-item-cat workshop">Workshop</span>
                    <div class="myev-item-title">Workshop Leadership</div>
                    <div class="myev-item-meta">
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>15 Agustus 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>09:00 – 15:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status attended">Hadir ✓</span>
                    <div class="myev-item-actions">
                        <button class="myev-btn-detail">Sertifikat</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="myev-item" data-status="attended">
            <div class="myev-item-img"><img src="{{ asset('images/seminar.png') }}" alt="Seminar Teknologi"></div>
            <div class="myev-item-body">
                <div class="myev-item-left">
                    <span class="myev-item-cat seminar">Seminar</span>
                    <div class="myev-item-title">Seminar Teknologi</div>
                    <div class="myev-item-meta">
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>28 Juli 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>08:00 – 12:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status attended">Hadir ✓</span>
                    <div class="myev-item-actions">
                        <button class="myev-btn-detail">Sertifikat</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('js')
<script>
(function(){
    var chips   = document.querySelectorAll('.myev-chip');
    var items   = document.querySelectorAll('.myev-item');

    chips.forEach(function(chip){
        chip.addEventListener('click', function(){
            chips.forEach(function(c){ c.classList.remove('active'); });
            chip.classList.add('active');
            var filter = chip.getAttribute('data-filter');
            items.forEach(function(item){
                var status = item.getAttribute('data-status');
                var matchesFilter = filter === 'completed' ? status === 'attended' : status === filter;
                if(filter === 'all' || matchesFilter){
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
})();
</script>
@endpush
