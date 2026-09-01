@extends('user.layout')

@section('title', 'News & Updates')

@push('css')
<style>
/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   NEWS PAGE
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.news-page { padding: 1.5rem 1.75rem; font-family: 'Plus Jakarta Sans','Inter',sans-serif; }

.news-top {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem; flex-wrap: wrap; gap: .75rem;
}
.news-page-title { font-size:1.4rem; font-weight:800; color:var(--text-primary); }
.news-count-badge {
    background:#0f1f4e; color:#fff; font-size:.72rem; font-weight:700;
    padding:.25rem .65rem; border-radius:999px;
}

/* Filter chips */
.news-filters { display:flex; gap:.5rem; flex-wrap:wrap; margin-bottom:1.25rem; }
.nf-chip {
    padding:.38rem 1rem; border-radius:999px; font-size:.78rem; font-weight:600;
    border:1.5px solid var(--border-color); background:var(--bg-secondary);
    color:var(--text-secondary); cursor:pointer; transition:all .15s; white-space:nowrap;
    user-select:none;
}
.nf-chip:hover { border-color:#0f1f4e; color:#0f1f4e; }
.nf-chip.active { background:#0f1f4e; border-color:#0f1f4e; color:#fff; }

/* News grid */
.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.1rem;
}

/* Card */
.news-card {
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1.1rem;
    overflow: hidden;
    cursor: pointer;
    transition: all .2s;
    display: flex; flex-direction: column;
}
.news-card:hover {
    border-color: #0f1f4e;
    box-shadow: 0 6px 24px rgba(15,31,78,.1);
    transform: translateY(-2px);
}

/* Thumbnail */
.news-thumb {
    width:100%; height:150px; object-fit:cover; display:block;
    background: linear-gradient(135deg,#1a3a7c,#3b6fd4);
    flex-shrink:0;
}
.news-thumb-gradient-1 { background: linear-gradient(135deg,#1a3a7c 0%,#3b82f6 100%); }
.news-thumb-gradient-2 { background: linear-gradient(135deg,#064e3b 0%,#10b981 100%); }
.news-thumb-gradient-3 { background: linear-gradient(135deg,#78350f 0%,#f59e0b 100%); }
.news-thumb-placeholder {
    width:100%; height:150px; display:flex; align-items:center; justify-content:center;
    font-size:3rem; flex-shrink:0;
}

/* Body */
.news-body { padding:.9rem 1.1rem 1rem; display:flex; flex-direction:column; flex:1; }

.news-meta-top {
    display:flex; align-items:center; gap:.5rem; margin-bottom:.5rem; flex-wrap:wrap;
}
.cat-badge {
    font-size:.65rem; font-weight:800; padding:.2rem .6rem; border-radius:999px;
    text-transform:uppercase; letter-spacing:.04em;
}
.cat-achievement { background:#fef3c7; color:#d97706; }
.cat-academic    { background:#dbeafe; color:#1d4ed8; }
.cat-event       { background:#dcfce7; color:#15803d; }
.cat-announcement{ background:#ede9fe; color:#7c3aed; }
.cat-competition { background:#fce7f3; color:#be185d; }

/* â”€â”€ Competition Result Card thumbnail â”€â”€ */
.news-thumb-comp {
    width:100%; height:150px; flex-shrink:0;
    display:flex; flex-direction:column; justify-content:space-between;
    padding:.875rem .875rem .625rem;
    overflow:hidden; position:relative;
}

.comp-result-banner {
    display:flex; align-items:center; gap:.625rem;
}
.comp-trophy { font-size:1.5rem; line-height:1; }
.comp-banner-info { display:flex; flex-direction:column; gap:1px; }
.comp-banner-event { font-size:.78rem; font-weight:800; color:#fff; line-height:1.2; }
.comp-banner-label { font-size:.62rem; font-weight:500; color:rgba(255,255,255,.6); }

.comp-podium-row {
    display:flex; align-items:flex-end; justify-content:center;
    gap:.375rem; padding-top:.25rem;
}

.comp-podium-item {
    display:flex; flex-direction:column; align-items:center; gap:2px;
    padding:.375rem .5rem .5rem;
    border-radius:.5rem .5rem 0 0;
    flex:1; text-align:center;
}
.comp-podium-item.gold   { background:rgba(251,191,36,.25); border-top:2px solid #fbbf24; min-height:64px; justify-content:flex-end; }
.comp-podium-item.silver { background:rgba(255,255,255,.12); border-top:2px solid rgba(255,255,255,.35); min-height:52px; justify-content:flex-end; }
.comp-podium-item.bronze { background:rgba(251,146,60,.18); border-top:2px solid #fb923c; min-height:44px; justify-content:flex-end; }

.comp-podium-medal { font-size:1rem; line-height:1; }
.comp-podium-class { font-size:.62rem; font-weight:800; color:#fff; line-height:1.2; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:56px; }
.comp-podium-rank  { font-size:.55rem; font-weight:600; color:rgba(255,255,255,.65); white-space:nowrap; }

.imp-badge {
    font-size:.62rem; font-weight:800; padding:.18rem .55rem; border-radius:999px;
    background:#fee2e2; color:#dc2626; text-transform:uppercase; letter-spacing:.04em;
}

.news-title {
    font-size:.925rem; font-weight:800; color:var(--text-primary);
    line-height:1.35; margin-bottom:.45rem;
}
.news-excerpt {
    font-size:.8rem; color:var(--text-muted); line-height:1.6;
    flex:1; display:-webkit-box; -webkit-line-clamp:2;
    -webkit-box-orient:vertical; overflow:hidden;
}
.news-footer {
    display:flex; align-items:center; justify-content:space-between;
    margin-top:.75rem; padding-top:.65rem; border-top:1px solid var(--border-color);
    gap:.5rem; flex-wrap:wrap;
}
.news-footer-left { display:flex; align-items:center; gap:.875rem; }
.news-stat { font-size:.72rem; color:var(--text-muted); font-weight:600;
    display:flex; align-items:center; gap:.3rem; }
.news-time { font-size:.72rem; color:var(--text-muted); font-weight:500; }
.news-read-time { font-size:.68rem; color:var(--text-muted); background:var(--bg-tertiary);
    padding:.15rem .5rem; border-radius:.3rem; }

/* â•â• MODAL â•â• */
.modal-overlay {
    position:fixed; inset:0; background:rgba(0,0,0,.55);
    display:flex; align-items:center; justify-content:center;
    z-index:9999; opacity:0; visibility:hidden; transition:all .25s;
    padding:1rem;
}
.modal-overlay.active { opacity:1; visibility:visible; }

.news-modal {
    background:var(--bg-secondary); border-radius:1.25rem;
    width:100%; max-width:680px; max-height:88vh; overflow-y:auto;
    transform:scale(.96); transition:transform .25s;
    box-shadow:0 24px 64px rgba(0,0,0,.25);
}
.modal-overlay.active .news-modal { transform:scale(1); }

.nm-thumb { width:100%; height:220px; object-fit:cover; border-radius:1.25rem 1.25rem 0 0; }
.nm-thumb-placeholder {
    width:100%; height:220px; border-radius:1.25rem 1.25rem 0 0;
    display:flex; align-items:center; justify-content:center; font-size:4.5rem;
}

.nm-body { padding:1.5rem 1.75rem 1.75rem; }

.nm-meta { display:flex; align-items:center; gap:.5rem; margin-bottom:.875rem; flex-wrap:wrap; }

.nm-title { font-size:1.35rem; font-weight:800; color:var(--text-primary); line-height:1.3; margin-bottom:.5rem; }
.nm-byline { font-size:.78rem; color:var(--text-muted); margin-bottom:1.25rem; }

.nm-section { margin-bottom:1.1rem; }
.nm-section-title {
    font-size:.85rem; font-weight:800; color:var(--text-primary);
    text-transform:uppercase; letter-spacing:.05em; margin-bottom:.5rem;
    padding-bottom:.35rem; border-bottom:2px solid var(--border-color);
}
.nm-text { font-size:.875rem; color:var(--text-secondary); line-height:1.75; }
.nm-list { list-style:none; padding:0; margin:0; }
.nm-list li {
    font-size:.875rem; color:var(--text-secondary); padding:.3rem 0;
    display:flex; align-items:flex-start; gap:.6rem; line-height:1.5;
}
.nm-list li::before { content:'â€¢'; color:#0f1f4e; font-weight:900; flex-shrink:0; margin-top:.05rem; }

.nm-highlight {
    background:linear-gradient(135deg,#eff6ff,#dbeafe); border:1px solid #bfdbfe;
    border-radius:.75rem; padding:.875rem 1.1rem; margin:1rem 0;
}
.nm-highlight-text { font-size:.875rem; font-weight:600; color:#1e40af; }

.nm-actions {
    display:flex; align-items:center; gap:.75rem; margin-top:1.5rem;
    padding-top:1.1rem; border-top:1px solid var(--border-color); flex-wrap:wrap;
}
.nm-action-btn {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.45rem 1rem; border-radius:.625rem;
    border:1.5px solid var(--border-color); background:var(--bg-secondary);
    color:var(--text-secondary); font-size:.8rem; font-weight:700;
    cursor:pointer; transition:all .15s;
}
.nm-action-btn:hover { border-color:#0f1f4e; color:#0f1f4e; background:#f0f4ff; }
.nm-close-btn {
    margin-left:auto; padding:.45rem 1.1rem;
    border-radius:.625rem; border:none;
    background:#0f1f4e; color:#fff; font-size:.8rem; font-weight:700;
    cursor:pointer; transition:background .15s;
}
.nm-close-btn:hover { background:#1a3a7c; }
</style>
@endpush

@section('content')
<div class="news-page">

    {{-- TOP --}}
    <div class="news-top">
        <h1 class="news-page-title">ðŸ“° News & Updates</h1>
        <span class="news-count-badge" id="newsCount">Berita</span>
    </div>

    {{-- FILTERS --}}
    <div class="news-filters">
        <span class="nf-chip active" data-cat="all">All</span>
        <span class="nf-chip" data-cat="event">Event</span>
        <span class="nf-chip" data-cat="academic">Academic</span>
        <span class="nf-chip" data-cat="achievement">Achievement</span>
        <span class="nf-chip" data-cat="competition-result">Hasil Kompetisi</span>
        <span class="nf-chip" data-cat="announcement">Announcement</span>
    </div>

    {{-- GRID --}}
    <div class="news-grid" id="newsGrid">

        {{-- 1. Programming Competition --}}
        <div class="news-card" data-cat="achievement" data-id="1" onclick="openModal(1)">
            <img class="news-thumb" src="{{ asset('images/workshop.png') }}" alt="Programming Competition">
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-achievement">Achievement</span>
                    <span class="imp-badge">âš¡ Important</span>
                </div>
                <div class="news-title">ðŸ† SMKN 20 Jakarta Wins National Programming Competition</div>
                <div class="news-excerpt">Tim programming sekolah berhasil meraih juara pertama di kompetisi nasional. Tiga siswa membawa pulang trofi bergengsi dari ajang bergengsi ini.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 234</span>
                        <span class="news-time">2 hours ago</span>
                    </div>
                    <span class="news-read-time">3 min read</span>
                </div>
            </div>
        </div>

        {{-- 2. Basketball --}}
        <div class="news-card" data-cat="achievement" data-id="2" onclick="openModal(2)">
            <img class="news-thumb" src="{{ asset('images/basket.jpeg') }}" alt="Basketball">
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-achievement">Achievement</span>
                    <span class="imp-badge">âš¡ Important</span>
                </div>
                <div class="news-title">ðŸ€ Basketball Team Advances to Regional Finals</div>
                <div class="news-excerpt">Tim basket SMKN 20 Jakarta melaju ke final regional setelah mengalahkan lawan dengan skor 78-72 dalam pertandingan yang sangat seru.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 187</span>
                        <span class="news-time">5 hours ago</span>
                    </div>
                    <span class="news-read-time">2 min read</span>
                </div>
            </div>
        </div>

        {{-- 3. Final Exam --}}
        <div class="news-card" data-cat="academic" data-id="3" onclick="openModal(3)">
            <div class="news-thumb-placeholder news-thumb-gradient-3">ðŸ“š</div>
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-academic">Academic</span>
                    <span class="imp-badge">âš¡ Important</span>
                </div>
                <div class="news-title">ðŸ“š Important: Final Exam Schedule Released</div>
                <div class="news-excerpt">Jadwal ujian akhir semester telah resmi dirilis. Perhatikan tanggal penting dan panduan yang wajib diikuti semua siswa.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 456</span>
                        <span class="news-time">1 day ago</span>
                    </div>
                    <span class="news-read-time">4 min read</span>
                </div>
            </div>
        </div>

        {{-- 4. Career Day --}}
        <div class="news-card" data-cat="event" data-id="4" onclick="openModal(4)">
            <img class="news-thumb" src="{{ asset('images/careerday.jpeg') }}" alt="Career Day">
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-event">Event</span>
                </div>
                <div class="news-title">ðŸ’¼ Career Day 2027 Registration Now Open</div>
                <div class="news-excerpt">Pendaftaran Career Day 2027 resmi dibuka! Temui speaker dari Google, Gojek, Tokopedia dan ikuti berbagai workshop seru.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 312</span>
                        <span class="news-time">1 day ago</span>
                    </div>
                    <span class="news-read-time">3 min read</span>
                </div>
            </div>
        </div>

        {{-- 5. Library --}}
        <div class="news-card" data-cat="academic" data-id="5" onclick="openModal(5)">
            <div class="news-thumb-placeholder news-thumb-gradient-2">ðŸ“–</div>
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-academic">Academic</span>
                </div>
                <div class="news-title">ðŸ“– New Library Digital Resources Available</div>
                <div class="news-excerpt">Perpustakaan sekolah kini menambahkan 500+ e-book dan jurnal online dari berbagai subjek. Akses gratis dengan student ID.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 145</span>
                        <span class="news-time">2 days ago</span>
                    </div>
                    <span class="news-read-time">2 min read</span>
                </div>
            </div>
        </div>

        {{-- 6. Class Meeting --}}
        <div class="news-card" data-cat="event" data-id="6" onclick="openModal(6)">
            <img class="news-thumb" src="{{ asset('images/classmeeting.jpeg') }}" alt="Class Meeting">
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-event">Event</span>
                </div>
                <div class="news-title">ðŸŽ‰ Class Meeting 2027 Spectacular Success</div>
                <div class="news-excerpt">Class Meeting 2027 resmi berakhir dengan gemilang! 500+ peserta, 15 kompetisi, dan momen tak terlupakan dari seluruh kelas.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 523</span>
                        <span class="news-time">3 days ago</span>
                    </div>
                    <span class="news-read-time">4 min read</span>
                </div>
            </div>
        </div>

        {{-- 7. Student Council --}}
        <div class="news-card" data-cat="announcement" data-id="7" onclick="openModal(7)">
            <div class="news-thumb-placeholder news-thumb-gradient-1">ðŸ—³ï¸</div>
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-announcement">Announcement</span>
                    <span class="imp-badge">âš¡ Important</span>
                </div>
                <div class="news-title">ðŸ—³ï¸ Student Council Elections Announcement</div>
                <div class="news-excerpt">Pemilihan pengurus OSIS tahunan segera dilaksanakan. Daftarkan dirimu atau gunakan hak pilihmu untuk masa depan sekolah yang lebih baik!</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 278</span>
                        <span class="news-time">4 days ago</span>
                    </div>
                    <span class="news-read-time">3 min read</span>
                </div>
            </div>
        </div>

        {{-- 8. Art Exhibition --}}
        <div class="news-card" data-cat="event" data-id="8" onclick="openModal(8)">
            <div class="news-thumb-placeholder news-thumb-gradient-1" style="background:linear-gradient(135deg,#4c1d95,#7c3aed);">ðŸŽ¨</div>
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-event">Event</span>
                </div>
                <div class="news-title">ðŸŽ¨ Art Exhibition Features Student Masterpieces</div>
                <div class="news-excerpt">Pameran seni karya siswa SMKN 20 Jakarta digelar di galeri sekolah. Lukisan, patung, seni digital, dan masih banyak lagi karya luar biasa.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 167</span>
                        <span class="news-time">5 days ago</span>
                    </div>
                    <span class="news-read-time">3 min read</span>
                </div>
            </div>
        </div>

        {{-- 9. Hasil Basket Class Meeting --}}
        <div class="news-card" data-cat="competition-result" data-id="9" onclick="openModal(9)">
            <div class="news-thumb-comp" style="background:linear-gradient(135deg,#0f1f4e 0%,#1a3a7c 100%);">
                <div class="comp-result-banner">
                    <span class="comp-trophy">ðŸ†</span>
                    <div class="comp-banner-info">
                        <span class="comp-banner-event">Class Meeting â€” Basket</span>
                        <span class="comp-banner-label">Hasil Pertandingan</span>
                    </div>
                </div>
                <div class="comp-podium-row">
                    <div class="comp-podium-item silver">
                        <span class="comp-podium-medal">ðŸ¥ˆ</span>
                        <span class="comp-podium-class">XI TKJ 2</span>
                        <span class="comp-podium-rank">Juara 2</span>
                    </div>
                    <div class="comp-podium-item gold">
                        <span class="comp-podium-medal">ðŸ¥‡</span>
                        <span class="comp-podium-class">XI RPL 1</span>
                        <span class="comp-podium-rank">Juara 1</span>
                    </div>
                    <div class="comp-podium-item bronze">
                        <span class="comp-podium-medal">ðŸ¥‰</span>
                        <span class="comp-podium-class">XII AK 1</span>
                        <span class="comp-podium-rank">Juara 3</span>
                    </div>
                </div>
            </div>
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-competition">Hasil Kompetisi</span>
                    <span class="imp-badge">âš¡ Resmi</span>
                </div>
                <div class="news-title">ðŸ€ Hasil Lomba Basket â€” Class Meeting 2026</div>
                <div class="news-excerpt">XI RPL 1 keluar sebagai juara basket putra Class Meeting 2026 setelah mengalahkan XI TKJ 2 dengan skor 54-48 di babak final.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 341</span>
                        <span class="news-time">1 day ago</span>
                    </div>
                    <span class="news-read-time">2 min read</span>
                </div>
            </div>
        </div>

        {{-- 10. Hasil Futsal --}}
        <div class="news-card" data-cat="competition-result" data-id="10" onclick="openModal(10)">
            <div class="news-thumb-comp" style="background:linear-gradient(135deg,#064e3b 0%,#065f46 100%);">
                <div class="comp-result-banner">
                    <span class="comp-trophy">âš½</span>
                    <div class="comp-banner-info">
                        <span class="comp-banner-event">Class Meeting â€” Futsal</span>
                        <span class="comp-banner-label">Hasil Pertandingan</span>
                    </div>
                </div>
                <div class="comp-podium-row">
                    <div class="comp-podium-item silver">
                        <span class="comp-podium-medal">ðŸ¥ˆ</span>
                        <span class="comp-podium-class">X BD 1</span>
                        <span class="comp-podium-rank">Juara 2</span>
                    </div>
                    <div class="comp-podium-item gold">
                        <span class="comp-podium-medal">ðŸ¥‡</span>
                        <span class="comp-podium-class">XI RPL 2</span>
                        <span class="comp-podium-rank">Juara 1</span>
                    </div>
                    <div class="comp-podium-item bronze">
                        <span class="comp-podium-medal">ðŸ¥‰</span>
                        <span class="comp-podium-class">XII MP 1</span>
                        <span class="comp-podium-rank">Juara 3</span>
                    </div>
                </div>
            </div>
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-competition">Hasil Kompetisi</span>
                </div>
                <div class="news-title">âš½ Hasil Lomba Futsal â€” Class Meeting 2026</div>
                <div class="news-excerpt">XI RPL 2 meraih gelar juara futsal putra setelah drama adu penalti melawan X BD 1 dalam final yang menegangkan.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 298</span>
                        <span class="news-time">1 day ago</span>
                    </div>
                    <span class="news-read-time">2 min read</span>
                </div>
            </div>
        </div>

        {{-- 11. Hasil Vocal Group --}}
        <div class="news-card" data-cat="competition-result" data-id="11" onclick="openModal(11)">
            <div class="news-thumb-comp" style="background:linear-gradient(135deg,#4c1d95 0%,#6d28d9 100%);">
                <div class="comp-result-banner">
                    <span class="comp-trophy">ðŸŽ¤</span>
                    <div class="comp-banner-info">
                        <span class="comp-banner-event">Class Meeting â€” Vocal Group</span>
                        <span class="comp-banner-label">Hasil Kompetisi</span>
                    </div>
                </div>
                <div class="comp-podium-row">
                    <div class="comp-podium-item silver">
                        <span class="comp-podium-medal">ðŸ¥ˆ</span>
                        <span class="comp-podium-class">XI LPS 1</span>
                        <span class="comp-podium-rank">Juara 2</span>
                    </div>
                    <div class="comp-podium-item gold">
                        <span class="comp-podium-medal">ðŸ¥‡</span>
                        <span class="comp-podium-class">X MP 1</span>
                        <span class="comp-podium-rank">Juara 1</span>
                    </div>
                    <div class="comp-podium-item bronze">
                        <span class="comp-podium-medal">ðŸ¥‰</span>
                        <span class="comp-podium-class">XII BD 2</span>
                        <span class="comp-podium-rank">Juara 3</span>
                    </div>
                </div>
            </div>
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-competition">Hasil Kompetisi</span>
                </div>
                <div class="news-title">ðŸŽ¤ Hasil Lomba Vocal Group â€” Class Meeting 2026</div>
                <div class="news-excerpt">X MP 1 tampil memukau dan berhasil meraih juara pertama Vocal Group dengan penampilan yang luar biasa memukau dewan juri.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 214</span>
                        <span class="news-time">2 days ago</span>
                    </div>
                    <span class="news-read-time">2 min read</span>
                </div>
            </div>
        </div>

        {{-- 12. Hasil Lomba Desain --}}
        <div class="news-card" data-cat="competition-result" data-id="12" onclick="openModal(12)">
            <div class="news-thumb-comp" style="background:linear-gradient(135deg,#b45309 0%,#d97706 100%);">
                <div class="comp-result-banner">
                    <span class="comp-trophy">ðŸŽ¨</span>
                    <div class="comp-banner-info">
                        <span class="comp-banner-event">Lomba Desain Grafis</span>
                        <span class="comp-banner-label">Hasil Kompetisi</span>
                    </div>
                </div>
                <div class="comp-podium-row">
                    <div class="comp-podium-item silver">
                        <span class="comp-podium-medal">ðŸ¥ˆ</span>
                        <span class="comp-podium-class">Siti N.</span>
                        <span class="comp-podium-rank">Juara 2</span>
                    </div>
                    <div class="comp-podium-item gold">
                        <span class="comp-podium-medal">ðŸ¥‡</span>
                        <span class="comp-podium-class">Fathi R.</span>
                        <span class="comp-podium-rank">Juara 1</span>
                    </div>
                    <div class="comp-podium-item bronze">
                        <span class="comp-podium-medal">ðŸ¥‰</span>
                        <span class="comp-podium-class">Budi S.</span>
                        <span class="comp-podium-rank">Juara 3</span>
                    </div>
                </div>
            </div>
            <div class="news-body">
                <div class="news-meta-top">
                    <span class="cat-badge cat-competition">Hasil Kompetisi</span>
                </div>
                <div class="news-title">ðŸŽ¨ Hasil Lomba Desain Grafis 2026</div>
                <div class="news-excerpt">Fathi Rizkiansyah (XI RPL 1) berhasil meraih juara pertama Lomba Desain Grafis dengan karya poster digital bertema lingkungan.</div>
                <div class="news-footer">
                    <div class="news-footer-left">
                        <span class="news-stat">ðŸ‘ 189</span>
                        <span class="news-time">3 days ago</span>
                    </div>
                    <span class="news-read-time">2 min read</span>
                </div>
            </div>
        </div>

    </div>{{-- /news-grid --}}
</div>{{-- /news-page --}}

{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â• MODAL â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div class="modal-overlay" id="newsModal" onclick="closeModalOutside(event)">
    <div class="news-modal" id="newsModalInner"></div>
</div>
@endsection

@push('js')
<script>
// â”€â”€ Modal content data
const newsData = {
    1: {
        cat: 'achievement', catLabel: 'Achievement', important: true,
        title: 'ðŸ† SMKN 20 Jakarta Wins National Programming Competition',
        thumb: '{{ asset("images/workshop.png") }}', thumbAlt: 'Programming Competition',
        byline: 'By Humas SMKN 20 Jakarta Â· 2 hours ago Â· 3 min read Â· 234 views',
        sections: [
            { title: 'Selamat kepada Tim Kita!', type: 'text',
              content: 'Tim programming SMKN 20 Jakarta berhasil meraih gelar juara pertama dalam kompetisi pemrograman nasional yang diikuti oleh lebih dari 150 sekolah dari seluruh Indonesia. Ini adalah pencapaian luar biasa yang membanggakan seluruh keluarga besar SMKN 20 Jakarta.' },
            { title: 'Detail Prestasi', type: 'list', items: [
                'ðŸ¥‡ First Place â€” Algorithm Design Category',
                'ðŸ† Best Mobile App Award â€” Aplikasi terbaik dari 50+ peserta',
                'â­ Special Jury Award â€” Inovasi terbaik tahun ini',
            ]},
            { title: 'Para Pemenang', type: 'list', items: [
                'Ahmad Rizki Pratama (XI RPL 1) â€” Team Captain & Algorithm Lead',
                'Siti Nurhaliza (XI RPL 2) â€” Mobile Development',
                'Budi Santoso (XII RPL 1) â€” UI/UX & Presentation',
            ]},
            { title: 'Ucapan Terima Kasih', type: 'highlight',
              content: 'Terima kasih kepada Bapak/Ibu coach Pak Dani dan Bu Rina yang telah mendampingi tim selama 3 bulan persiapan. Juga kepada seluruh siswa SMKN 20 yang telah memberikan dukungan penuh!' },
        ]
    },
    2: {
        cat: 'achievement', catLabel: 'Achievement', important: true,
        title: 'ðŸ€ Basketball Team Advances to Regional Finals',
        thumb: '{{ asset("images/basket.jpeg") }}', thumbAlt: 'Basketball Team',
        byline: 'By Tim Olahraga SMKN 20 Â· 5 hours ago Â· 2 min read Â· 187 views',
        sections: [
            { title: 'Menuju Final Regional!', type: 'text',
              content: 'Tim basket putra SMKN 20 Jakarta resmi melaju ke babak final regional setelah meraih kemenangan gemilang 78-72 atas SMKN 5 Jakarta dalam pertandingan semifinal yang berlangsung sangat ketat di GOR Soemantri Brodjonegoro.' },
            { title: 'Highlight Pertandingan', type: 'list', items: [
                'ðŸ€ Skor akhir: SMKN 20 Jakarta 78 â€” SMKN 5 Jakarta 72',
                'â­ Top scorer: Fajar Ramadan (XI TKJ 1) â€” 24 poin',
                'ðŸ›¡ï¸ Best defender: Reno Saputra (XII RPL 2) â€” 8 rebound',
                'ðŸŽ¯ 3-pointer terbaik di kuarter terakhir membalik keadaan',
            ]},
            { title: 'Detail Final Regional', type: 'list', items: [
                'ðŸ“… Tanggal: 15 September 2026',
                'â° Waktu: 14:00 WIB',
                'ðŸ“ Lokasi: GOR Soemantri Brodjonegoro, Jakarta',
                'ðŸ†š Lawan: SMA Negeri 8 Jakarta',
            ]},
            { title: 'Yuk Support Tim Kita!', type: 'highlight',
              content: 'Mari kita ramaikan final regional! Hadir dan berikan semangat kepada tim basket SMKN 20 Jakarta. Panitia akan menyediakan bus bagi siswa yang ingin datang mendukung â€” daftar ke OSIS sebelum 12 September 2026.' },
        ]
    },
    3: {
        cat: 'academic', catLabel: 'Academic', important: true,
        title: 'ðŸ“š Important: Final Exam Schedule Released',
        thumb: null, thumbClass: 'news-thumb-gradient-3', thumbEmoji: 'ðŸ“š',
        byline: 'By Academic Affairs SMKN 20 Â· 1 day ago Â· 4 min read Â· 456 views',
        sections: [
            { title: 'Informasi Ujian Akhir Semester', type: 'text',
              content: 'Jadwal Ujian Akhir Semester (UAS) telah resmi ditetapkan oleh pihak akademik. Seluruh siswa wajib memperhatikan tanggal dan ketentuan berikut ini.' },
            { title: 'Key Dates', type: 'list', items: [
                'ðŸ“… Review Session: 20â€“25 September 2026',
                'ðŸ“ Exam Period: 26 September â€“ 10 Oktober 2026',
                'ðŸ“Š Result Announcement: 20 Oktober 2026',
                'ðŸŽ“ Remedial (jika ada): 22â€“24 Oktober 2026',
            ]},
            { title: 'Panduan Penting (Wajib Dibaca)', type: 'list', items: [
                'ðŸªª Wajib membawa kartu pelajar/ID setiap hari ujian',
                'ðŸ“µ Tidak diperbolehkan membawa perangkat elektronik',
                'ðŸ‘• Wajib mengenakan seragam lengkap dan rapi',
                'â° Hadir minimal 15 menit sebelum ujian dimulai',
                'ðŸš« Keterlambatan lebih dari 30 menit tidak diperbolehkan masuk',
            ]},
            { title: 'Tips Persiapan Ujian', type: 'list', items: [
                'ðŸ“– Mulai review materi 2 minggu sebelum ujian',
                'ðŸ’¤ Tidur cukup malam sebelum ujian â€” minimal 7-8 jam',
                'ðŸ¥— Sarapan bergizi sebelum berangkat ke sekolah',
                'ðŸ“ Buat rangkuman/mind map untuk setiap mata pelajaran',
            ]},
            { title: 'Informasi Lebih Lanjut', type: 'highlight',
              content: 'Hubungi Bagian Akademik di ruang TU atau email ke akademik@smkn20jkt.sch.id untuk pertanyaan lebih lanjut mengenai jadwal ujian.' },
        ]
    },
    4: {
        cat: 'event', catLabel: 'Event', important: false,
        title: 'ðŸ’¼ Career Day 2027 Registration Now Open',
        thumb: '{{ asset("images/careerday.jpeg") }}', thumbAlt: 'Career Day',
        byline: 'By OSIS SMKN 20 Jakarta Â· 1 day ago Â· 3 min read Â· 312 views',
        sections: [
            { title: 'Pendaftaran Resmi Dibuka!', type: 'text',
              content: 'Career Day 2027 hadir kembali dengan format yang lebih besar dan lebih seru dari tahun sebelumnya! Temui profesional dari berbagai industri, ikuti workshop eksklusif, dan eksplorasi peluang karirmu.' },
            { title: 'Event Highlights', type: 'list', items: [
                'ðŸŽ¤ 10+ Keynote Speaker dari industri terkemuka',
                'ðŸ› ï¸ 8 Workshop paralel yang bisa kamu pilih',
                'ðŸ¢ 30+ Company Booth dari berbagai sektor',
                'ðŸ¤ Sesi networking dengan HR profesional',
            ]},
            { title: 'Confirmed Speakers', type: 'list', items: [
                'ðŸ”µ Rudi Hartono â€” Senior Engineer, Google Indonesia',
                'ðŸŸ¢ Sari Dewi â€” Product Manager, Gojek',
                'ðŸ”´ Bima Arya â€” CTO, Tokopedia',
                'ðŸŸ¡ Anisa Rahman â€” UX Designer, Shopee',
                'âš« Hendra Gunawan â€” CEO, Startup Lokal Unicorn',
            ]},
            { title: 'Cara Registrasi', type: 'list', items: [
                '1ï¸âƒ£ Kunjungi halaman Events di aplikasi ini',
                '2ï¸âƒ£ Cari "Career Day 2027" dan klik Daftar',
                '3ï¸âƒ£ Isi formulir pendaftaran lengkap',
                '4ï¸âƒ£ Konfirmasi akan dikirim ke WhatsApp kamu',
            ]},
            { title: 'Info Tambahan', type: 'highlight',
              content: 'Acara berlangsung pada 20 Agustus 2026 pukul 08:00â€“15:00 WIB di Aula Sekolah. Gratis untuk seluruh siswa SMKN 20 Jakarta. Kuota terbatas 50 peserta â€” daftar sekarang!' },
        ]
    },
    5: {
        cat: 'academic', catLabel: 'Academic', important: false,
        title: 'ðŸ“– New Library Digital Resources Available',
        thumb: null, thumbClass: 'news-thumb-gradient-2', thumbEmoji: 'ðŸ“–',
        byline: 'By Perpustakaan SMKN 20 Â· 2 days ago Â· 2 min read Â· 145 views',
        sections: [
            { title: 'Koleksi Digital Terbaru', type: 'text',
              content: 'Perpustakaan SMKN 20 Jakarta dengan bangga mengumumkan penambahan lebih dari 500 e-book dan 200 jurnal ilmiah online yang kini bisa diakses secara gratis oleh seluruh siswa.' },
            { title: '500+ E-Book Tersedia', type: 'list', items: [
                'ðŸ’» Computer Science & Programming (120+ buku)',
                'ðŸ“ Mathematics & Statistics (85+ buku)',
                'ðŸ“š Indonesian & World Literature (90+ buku)',
                'ðŸ”¬ Science & Technology (110+ buku)',
                'ðŸ’¼ Business & Entrepreneurship (75+ buku)',
                'ðŸŽ¨ Art & Design (45+ buku)',
            ]},
            { title: 'Cara Akses', type: 'list', items: [
                'ðŸŒ Buka portal: library.smkn20jkt.sch.id',
                'ðŸ” Login dengan Student ID dan password sekolah',
                'ðŸ” Gunakan fitur search untuk menemukan buku',
                'ðŸ“¥ Download PDF atau baca online langsung',
            ]},
            { title: 'Info Perpustakaan', type: 'highlight',
              content: 'Untuk bantuan teknis akses e-library, kunjungi ruang perpustakaan di lantai 2 pada hari Seninâ€“Jumat pukul 07:30â€“15:00 WIB atau hubungi pustakawan di ext. 205.' },
        ]
    },
    6: {
        cat: 'event', catLabel: 'Event', important: false,
        title: 'ðŸŽ‰ Class Meeting 2027 Spectacular Success',
        thumb: '{{ asset("images/classmeeting.jpeg") }}', thumbAlt: 'Class Meeting',
        byline: 'By Panitia Class Meeting Â· 3 days ago Â· 4 min read Â· 523 views',
        sections: [
            { title: 'Momen yang Tak Terlupakan!', type: 'text',
              content: 'Class Meeting 2027 resmi telah berakhir dengan pencapaian luar biasa! Lebih dari 500 siswa dari 24 kelas berpartisipasi dalam 15 kategori kompetisi selama 5 hari penuh penuh keceriaan dan semangat.' },
            { title: 'Competition Results', type: 'list', items: [
                'âš½ Futsal Putra: Juara â€” XI RPL 1 | Runner-up â€” XI TKJ 2',
                'ðŸ€ Basket Putri: Juara â€” XII AK 1 | Runner-up â€” XI BD 1',
                'ðŸŽ¤ Vocal Group: Juara â€” X MP 1 | Runner-up â€” XI LPS 1',
                'ðŸŽ¨ Mural Competition: Juara â€” XI RPL 2 | Runner-up â€” X AK 2',
                'ðŸ§© Cerdas Cermat: Juara â€” XII RPL 1 | Runner-up â€” XI AK 1',
            ]},
            { title: 'Special Awards', type: 'list', items: [
                'ðŸ† Best Class Spirit â€” XI RPL 1',
                'ðŸŒŸ Most Creative Class â€” X BD 1',
                'ðŸ¤ Best Sportsmanship â€” XII AK 2',
            ]},
            { title: 'Statistik Event', type: 'list', items: [
                'ðŸ‘¥ 500+ peserta aktif dari 24 kelas',
                'ðŸ… 15 kategori kompetisi',
                'ðŸŽ–ï¸ 45 trofi dan penghargaan dibagikan',
                'ðŸ“¸ 1.200+ foto diabadikan',
                'â±ï¸ 5 hari pelaksanaan penuh',
            ]},
            { title: 'Terima Kasih!', type: 'highlight',
              content: 'Terima kasih kepada seluruh panitia, guru pembimbing, dan siswa yang telah menjadikan Class Meeting 2027 sebagai event terbaik sepanjang sejarah SMKN 20 Jakarta. Sampai jumpa di Class Meeting 2028!' },
        ]
    },
    7: {
        cat: 'announcement', catLabel: 'Announcement', important: true,
        title: 'ðŸ—³ï¸ Student Council Elections Announcement',
        thumb: null, thumbClass: 'news-thumb-gradient-1', thumbEmoji: 'ðŸ—³ï¸',
        byline: 'By Pembina OSIS SMKN 20 Â· 4 days ago Â· 3 min read Â· 278 views',
        sections: [
            { title: 'Pemilihan Pengurus OSIS 2026/2027', type: 'text',
              content: 'Pemilihan pengurus OSIS tahunan SMKN 20 Jakarta akan segera dilaksanakan. Ini adalah kesempatan bagi seluruh siswa untuk berpartisipasi dalam proses demokrasi sekolah dan membentuk masa depan organisasi kita.' },
            { title: 'Important Dates', type: 'list', items: [
                'ðŸ“‹ Pendaftaran Calon: 1â€“7 September 2026',
                'ðŸ“¢ Masa Kampanye: 8â€“14 September 2026',
                'ðŸ—³ï¸ Hari Pemilihan: 15 September 2026',
                'ðŸ“Š Pengumuman Hasil: 16 September 2026',
                'ðŸŽ“ Pelantikan: 1 Oktober 2026',
            ]},
            { title: 'Posisi yang Dipilih', type: 'list', items: [
                'ðŸ‘‘ Ketua OSIS',
                'ðŸ¤ Wakil Ketua OSIS',
                'ðŸ“ Sekretaris Umum',
                'ðŸ’° Bendahara Umum',
                'ðŸ“‚ Ketua Bidang (6 bidang)',
            ]},
            { title: 'Syarat Pencalonan', type: 'list', items: [
                'âœ… Siswa aktif kelas X atau XI (bukan kelas XII)',
                'ðŸ“Š Nilai rata-rata minimal 75',
                'âœ… Tidak sedang menjalani sanksi akademik',
                'ðŸ“„ Mendapat persetujuan dari wali kelas',
                'ðŸ“ Mengisi formulir pencalonan resmi',
            ]},
            { title: 'Gunakan Hak Pilihmu!', type: 'highlight',
              content: 'Pemilihan dilakukan secara langsung, umum, bebas, rahasia, jujur dan adil (LUBER JURDIL). Seluruh siswa SMKN 20 Jakarta berhak memberikan suara. Partisipasi aktif adalah kunci organisasi yang kuat!' },
        ]
    },
    8: {
        cat: 'event', catLabel: 'Event', important: false,
        title: 'ðŸŽ¨ Art Exhibition Features Student Masterpieces',
        thumb: null, thumbClass: '', thumbEmoji: 'ðŸŽ¨',
        thumbStyle: 'background:linear-gradient(135deg,#4c1d95,#7c3aed)',
        byline: 'By Ekstrakurikuler Seni SMKN 20 Â· 5 days ago Â· 3 min read Â· 167 views',
        sections: [
            { title: 'Pameran Seni Tahunan Hadir Lagi!', type: 'text',
              content: 'Pameran Seni Siswa SMKN 20 Jakarta tahun ini menghadirkan lebih dari 120 karya terpilih dari 80 siswa berbakat. Memasuki tahun ke-5, pameran ini semakin berkembang dengan kategori baru dan tema yang lebih berani.' },
            { title: 'Detail Pameran', type: 'list', items: [
                'ðŸ“… Durasi: 5â€“12 September 2026',
                'ðŸ“ Lokasi: Galeri Seni SMKN 20 (Lantai 3)',
                'â° Jam Buka: Seninâ€“Sabtu, 09:00â€“16:00 WIB',
                'ðŸŽ« Tiket: Gratis untuk siswa dan guru',
            ]},
            { title: 'Kategori Karya', type: 'list', items: [
                'ðŸ–¼ï¸ Lukisan & Sketsa (35 karya)',
                'ðŸº Patung & Instalasi (18 karya)',
                'ðŸ’» Digital Art & Photography (30 karya)',
                'ðŸŽ­ Mixed Media (22 karya)',
                'âœï¸ Ilustrasi & Komik (15 karya)',
            ]},
            { title: 'Special Events', type: 'list', items: [
                'ðŸŽ¤ Artist Talk â€” 6 September 2026 pukul 14:00',
                'ðŸ› ï¸ Live Painting Workshop â€” 8 September 2026 pukul 10:00',
                'ðŸ† Award Night & Closing â€” 12 September 2026 pukul 16:00',
            ]},
            { title: 'Group Visit', type: 'highlight',
              content: 'Untuk group visit kelas atau komunitas, hubungi koordinator pameran di Ibu Rani (ruang guru seni) atau WhatsApp 0812-xxxx-xxxx minimal 2 hari sebelumnya.' },
        ]
    },
    9: {
        cat: 'competition-result', catLabel: 'Hasil Kompetisi', important: true,
        title: 'ðŸ€ Hasil Lomba Basket â€” Class Meeting 2026',
        thumb: null, thumbClass: '', thumbEmoji: 'ðŸ€',
        thumbStyle: 'background:linear-gradient(135deg,#0f1f4e,#1a3a7c)',
        byline: 'By Panitia Class Meeting Â· 1 day ago Â· 2 min read Â· 341 views',
        sections: [
            { title: 'Selamat kepada Para Juara!', type: 'text',
              content: 'Lomba basket putra Class Meeting 2026 telah resmi berakhir. Setelah melewati pertandingan sengit selama 3 hari, berikut hasil akhir yang telah ditetapkan oleh dewan juri.' },
            { title: 'Hasil Akhir Lomba Basket Putra', type: 'list', items: [
                'ðŸ¥‡ Juara 1 â€” XI RPL 1 (skor final: 54-48)',
                'ðŸ¥ˆ Juara 2 â€” XI TKJ 2',
                'ðŸ¥‰ Juara 3 â€” XII AK 1',
            ]},
            { title: 'Highlight Pertandingan Final', type: 'list', items: [
                'ðŸ€ Skor babak pertama: XI RPL 1 (28) â€” XI TKJ 2 (24)',
                'â­ Top scorer: Fathi Rizkiansyah (XI RPL 1) â€” 18 poin',
                'ðŸ›¡ï¸ Best defender: Rizky Pratama (XI RPL 1) â€” 9 rebound',
                'â±ï¸ Pertandingan berlangsung ketat hingga detik terakhir',
            ]},
            { title: 'Penghargaan Tambahan', type: 'list', items: [
                'â­ MVP (Most Valuable Player): Fathi Rizkiansyah â€” XI RPL 1',
                'ðŸƒ Best Young Player: Ahmad Rizki â€” X BD 1',
                'ðŸ¤ Best Sportsmanship: XII AK 1',
            ]},
            { title: 'Sertifikat & Hadiah', type: 'highlight',
              content: 'Sertifikat achievement untuk juara 1, 2, dan 3 akan tersedia di akun Eventty masing-masing peserta dalam 1x24 jam. Trofi dan hadiah akan diserahkan pada upacara penutupan Class Meeting.' },
        ]
    },
    10: {
        cat: 'competition-result', catLabel: 'Hasil Kompetisi', important: false,
        title: 'âš½ Hasil Lomba Futsal â€” Class Meeting 2026',
        thumb: null, thumbClass: '', thumbEmoji: 'âš½',
        thumbStyle: 'background:linear-gradient(135deg,#064e3b,#065f46)',
        byline: 'By Panitia Class Meeting Â· 1 day ago Â· 2 min read Â· 298 views',
        sections: [
            { title: 'Juara Futsal Putra Telah Ditentukan!', type: 'text',
              content: 'Setelah drama adu penalti yang menegangkan, XI RPL 2 akhirnya berhasil meraih gelar juara futsal putra Class Meeting 2026 setelah imbang 2-2 di waktu normal melawan X BD 1.' },
            { title: 'Hasil Akhir Lomba Futsal Putra', type: 'list', items: [
                'ðŸ¥‡ Juara 1 â€” XI RPL 2 (menang adu penalti 4-3)',
                'ðŸ¥ˆ Juara 2 â€” X BD 1',
                'ðŸ¥‰ Juara 3 â€” XII MP 1',
            ]},
            { title: 'Statistik Final', type: 'list', items: [
                'âš½ Skor normal: XI RPL 2 (2) â€” X BD 1 (2)',
                'ðŸŽ¯ Penalti: XI RPL 2 (4) â€” X BD 1 (3)',
                'â­ Top scorer: Budi Santoso (XI RPL 2) â€” 3 gol',
                'ðŸ§¤ Best goalkeeper: Hendra (X BD 1)',
            ]},
            { title: 'Info Sertifikat', type: 'highlight',
              content: 'Sertifikat achievement untuk seluruh juara akan tersedia di akun Eventty dalam 1x24 jam setelah pengumuman resmi ini.' },
        ]
    },
    11: {
        cat: 'competition-result', catLabel: 'Hasil Kompetisi', important: false,
        title: 'ðŸŽ¤ Hasil Lomba Vocal Group â€” Class Meeting 2026',
        thumb: null, thumbClass: '', thumbEmoji: 'ðŸŽ¤',
        thumbStyle: 'background:linear-gradient(135deg,#4c1d95,#6d28d9)',
        byline: 'By Panitia Class Meeting Â· 2 days ago Â· 2 min read Â· 214 views',
        sections: [
            { title: 'X MP 1 Sabet Juara Vocal Group!', type: 'text',
              content: 'X MP 1 tampil memukau dengan aransemen lagu yang kreatif dan kekompakan yang luar biasa, berhasil merebut hati dewan juri dan meraih juara pertama Vocal Group Class Meeting 2026.' },
            { title: 'Hasil Akhir Lomba Vocal Group', type: 'list', items: [
                'ðŸ¥‡ Juara 1 â€” X MP 1',
                'ðŸ¥ˆ Juara 2 â€” XI LPS 1',
                'ðŸ¥‰ Juara 3 â€” XII BD 2',
            ]},
            { title: 'Penilaian Juri', type: 'list', items: [
                'ðŸŽµ Kategori: Kekompakan, Teknik Vokal, Aransemen, Stage Presence',
                'â­ Nilai tertinggi: X MP 1 (94.5/100)',
                'ðŸŽ™ï¸ Special mention: XI LPS 1 â€” Best Arrangement',
            ]},
            { title: 'Info Sertifikat', type: 'highlight',
              content: 'Sertifikat achievement untuk seluruh juara akan tersedia di akun Eventty dalam 1x24 jam.' },
        ]
    },
    12: {
        cat: 'competition-result', catLabel: 'Hasil Kompetisi', important: false,
        title: 'ðŸŽ¨ Hasil Lomba Desain Grafis 2026',
        thumb: null, thumbClass: '', thumbEmoji: 'ðŸŽ¨',
        thumbStyle: 'background:linear-gradient(135deg,#b45309,#d97706)',
        byline: 'By Panitia OSIS Â· 3 days ago Â· 2 min read Â· 189 views',
        sections: [
            { title: 'Fathi Rizkiansyah Juara Desain Grafis!', type: 'text',
              content: 'Lomba Desain Grafis bertema "Lingkungan Hijau" telah usai. Fathi Rizkiansyah dari XI RPL 1 berhasil meraih juara pertama dengan karya poster digital yang dinilai paling inovatif dan impactful oleh dewan juri.' },
            { title: 'Hasil Akhir Lomba Desain Grafis', type: 'list', items: [
                'ðŸ¥‡ Juara 1 â€” Fathi Rizkiansyah (XI RPL 1)',
                'ðŸ¥ˆ Juara 2 â€” Siti Nurhaliza (XI AK 1)',
                'ðŸ¥‰ Juara 3 â€” Budi Santoso (XII RPL 1)',
                'ðŸŒŸ Best Concept â€” Dewi Anggraini (XI MP 1)',
            ]},
            { title: 'Karya Terbaik', type: 'list', items: [
                'ðŸ–¼ï¸ Judul karya Fathi: "Jejak Hijau" â€” Poster digital A3',
                'ðŸ› ï¸ Tools: Adobe Illustrator + Canva',
                'ðŸ’¡ Tema: Kampanye hemat energi untuk generasi muda',
                'ðŸ“Š Nilai: 96/100 dari 3 dewan juri',
            ]},
            { title: 'Info Sertifikat', type: 'highlight',
              content: 'Sertifikat achievement untuk seluruh pemenang tersedia di akun Eventty masing-masing. Karya terbaik akan dipajang di galeri sekolah selama 2 minggu.' },
        ]
    },
};
document.querySelectorAll('.nf-chip').forEach(function(chip){
    chip.addEventListener('click', function(){
        document.querySelectorAll('.nf-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        const cat = this.getAttribute('data-cat');
        const cards = document.querySelectorAll('#newsGrid .news-card');
        let visible = 0;
        cards.forEach(function(card){
            const match = cat === 'all' || card.getAttribute('data-cat') === cat;
            card.style.display = match ? '' : 'none';
            if(match) visible++;
        });
        document.getElementById('newsCount').textContent = visible + ' Berita';
    });
});

// â”€â”€ Open modal
function openModal(id) {
    const d = newsData[id];
    if (!d) return;

    let thumbHtml = '';
    if (d.thumb) {
        thumbHtml = `<img class="nm-thumb" src="${d.thumb}" alt="${d.thumbAlt || ''}">`;
    } else {
        const style = d.thumbStyle ? `style="${d.thumbStyle}"` : `class="nm-thumb-placeholder ${d.thumbClass||''}"`;
        thumbHtml = `<div class="nm-thumb-placeholder ${d.thumbClass||''}" ${d.thumbStyle ? 'style="'+d.thumbStyle+'"' : ''}>${d.thumbEmoji||''}</div>`;
    }

    const catColors = {achievement:'cat-achievement',academic:'cat-academic',event:'cat-event',announcement:'cat-announcement','competition-result':'cat-competition'};
    const catClass = catColors[d.cat] || 'cat-event';
    const impBadge = d.important ? '<span class="imp-badge">âš¡ Important</span>' : '';

    let sectionsHtml = '';
    (d.sections||[]).forEach(function(s){
        sectionsHtml += `<div class="nm-section"><div class="nm-section-title">${s.title}</div>`;
        if (s.type === 'text') {
            sectionsHtml += `<p class="nm-text">${s.content}</p>`;
        } else if (s.type === 'list') {
            sectionsHtml += '<ul class="nm-list">';
            (s.items||[]).forEach(function(item){
                sectionsHtml += `<li>${item}</li>`;
            });
            sectionsHtml += '</ul>';
        } else if (s.type === 'highlight') {
            sectionsHtml += `<div class="nm-highlight"><p class="nm-highlight-text">${s.content}</p></div>`;
        }
        sectionsHtml += '</div>';
    });

    document.getElementById('newsModalInner').innerHTML = `
        ${thumbHtml}
        <div class="nm-body">
            <div class="nm-meta">
                <span class="cat-badge ${catClass}">${d.catLabel}</span>
                ${impBadge}
            </div>
            <h2 class="nm-title">${d.title}</h2>
            <div class="nm-byline">${d.byline}</div>
            ${sectionsHtml}
            <div class="nm-actions">
                <button class="nm-action-btn">ðŸ‘ Helpful</button>
                <button class="nm-action-btn">ðŸ”— Share</button>
                <button class="nm-action-btn">ðŸ”– Bookmark</button>
                <button class="nm-close-btn" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    `;

    document.getElementById('newsModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('newsModal').classList.remove('active');
    document.body.style.overflow = '';
}

function closeModalOutside(e) {
    if (e.target === document.getElementById('newsModal')) closeModal();
}

document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeModal();
});
</script>
@endpush

@push('js')
@vite(['resources/js/utils/api.js', 'resources/js/user/notifications.js'])
@endpush

