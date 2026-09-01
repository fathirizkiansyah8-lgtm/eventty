@extends('user.layout')

@section('title', 'My Events')

@push('css')
<style>
/* â•â• My Events Page â•â• */
.myev-page { padding: 1.5rem 1.75rem; font-family: 'Plus Jakarta Sans','Inter',sans-serif; }
.myev-page-title { font-size: 1.35rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.5rem; }

/* â”€â”€ Stats row â”€â”€ */
.myev-stats {
    display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 1.5rem;
}
.myev-stat {
    background: var(--bg-secondary); border: 1.5px solid var(--border-color);
    border-radius: 1rem; padding: .875rem 1rem; text-align: center;
}
.myev-stat-num { font-size: 1.5rem; font-weight: 800; color: var(--text-primary); display: block; line-height: 1.1; }
.myev-stat-lbl { font-size: .7rem; color: var(--text-muted); font-weight: 500; margin-top: 3px; display: block; }

/* â”€â”€ Filter chips â”€â”€ */
.myev-filters { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 1.25rem; }
.myev-chip {
    padding: .38rem 1rem; border-radius: 999px; font-size: .78rem; font-weight: 600;
    border: 1.5px solid var(--border-color); background: var(--bg-secondary);
    color: var(--text-secondary); cursor: pointer; transition: all .15s; white-space: nowrap;
}
.myev-chip:hover { border-color: var(--primary); color: var(--primary); }
.myev-chip.active { background: var(--primary); border-color: var(--primary); color: #fff; }

/* â”€â”€ Event list â”€â”€ */
.myev-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 2rem; }

.myev-item {
    background: var(--bg-secondary); border: 1.5px solid var(--border-color);
    border-radius: 14px; overflow: hidden; display: flex; align-items: stretch;
    transition: all .2s;
}
.myev-item:hover { box-shadow: 0 4px 18px rgba(0,0,0,.07); border-color: var(--border-color-hover); }

.myev-item-img { width: 90px; flex-shrink: 0; overflow: hidden; background: var(--bg-tertiary); }
.myev-item-img img { width: 100%; height: 100%; object-fit: cover; display: block; }

.myev-item-body { flex: 1; padding: .875rem 1.1rem; display: flex; align-items: center; gap: 1rem; min-width: 0; }

.myev-item-left { flex: 1; min-width: 0; }
.myev-item-cat { display: inline-block; font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; padding: 2px 8px; border-radius: 5px; margin-bottom: .4rem; }
.myev-item-cat.seminar     { background: #dbeafe; color: #1d4ed8; }
.myev-item-cat.workshop    { background: #dcfce7; color: #15803d; }
.myev-item-cat.competition { background: #fef3c7; color: #b45309; }
.myev-item-cat.career      { background: #ede9fe; color: #6d28d9; }

.myev-item-title { font-size: .925rem; font-weight: 800; color: var(--text-primary); margin-bottom: .35rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.myev-item-meta  { display: flex; flex-wrap: wrap; gap: .5rem .875rem; }
.myev-item-meta-i { display: flex; align-items: center; gap: 4px; font-size: .72rem; color: var(--text-muted); font-weight: 500; }

.myev-item-right { display: flex; flex-direction: column; align-items: flex-end; gap: .625rem; flex-shrink: 0; }

.myev-status { display: inline-flex; align-items: center; padding: 4px 11px; border-radius: 999px; font-size: .7rem; font-weight: 700; white-space: nowrap; }
.myev-status.registered { background: #dbeafe; color: #1d4ed8; }
.myev-status.upcoming   { background: #dcfce7; color: #15803d; }
.myev-status.attended   { background: #dcfce7; color: #15803d; }
.myev-status.absent     { background: #fee2e2; color: #dc2626; }

.myev-btn-detail { padding: .4rem .875rem; border-radius: 8px; border: 1.5px solid var(--border-color); background: transparent; color: var(--text-secondary); font-size: .75rem; font-weight: 700; cursor: pointer; transition: all .15s; font-family: inherit; white-space: nowrap; }
.myev-btn-detail:hover { border-color: var(--primary); color: var(--primary); }

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   KALENDER (di bawah list)
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.myev-cal-section {
    margin-top: .5rem;
    border-top: 1.5px solid var(--border-color);
    padding-top: 1.5rem;
}
.myev-cal-section-title {
    font-size: 1rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.1rem;
    display: flex; align-items: center; gap: .5rem;
}

.cal-card {
    background: var(--bg-secondary); border: 1.5px solid var(--border-color);
    border-radius: 1.25rem; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.05);
    margin-bottom: 1.1rem;
}
.cal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.1rem 1.4rem;
    background: linear-gradient(135deg, #0f1f4e 0%, #1a3a7c 100%);
}
.cal-nav-btn {
    width: 32px; height: 32px; border-radius: 50%; border: none;
    background: rgba(255,255,255,.15); color: white; cursor: pointer;
    display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: background .15s;
}
.cal-nav-btn:hover { background: rgba(255,255,255,.28); }
.cal-month-label { font-size: .975rem; font-weight: 800; color: white; letter-spacing: .02em; }

.cal-days-header {
    display: grid; grid-template-columns: repeat(7, 1fr);
    background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color);
}
.cal-day-name {
    text-align: center; padding: .55rem 0; font-size: .68rem; font-weight: 700;
    color: var(--text-muted); text-transform: uppercase; letter-spacing: .05em;
}

.cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); }
.cal-cell {
    min-height: 72px; padding: .35rem .3rem;
    border-right: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);
    transition: background .15s;
}
.cal-cell:nth-child(7n) { border-right: none; }
.cal-cell:hover { background: var(--bg-tertiary); }
.cal-cell.empty { background: var(--bg-primary); }
.cal-cell.today { background: #eff6ff; border-color: #bfdbfe; }
.cal-cell.today .cal-date-num {
    background: #0f1f4e; color: white; border-radius: 50%;
    width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-weight: 800;
}
.cal-cell.has-event { cursor: pointer; }
.cal-date-num {
    font-size: .78rem; font-weight: 600; color: var(--text-secondary);
    margin-bottom: .2rem; width: 24px; height: 24px;
    display: flex; align-items: center; justify-content: center;
}
.cal-cell.empty .cal-date-num { color: var(--text-muted); opacity: .4; }

.cal-event-chip {
    display: block; font-size: .58rem; font-weight: 700;
    padding: .12rem .35rem; border-radius: .3rem; margin-bottom: .12rem;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;
}
.cal-event-chip.blue   { background: #dbeafe; color: #1d4ed8; }
.cal-event-chip.green  { background: #dcfce7; color: #15803d; }
.cal-event-chip.orange { background: #fef3c7; color: #d97706; }
.cal-event-chip.purple { background: #ede9fe; color: #7c3aed; }

.cal-legend {
    background: var(--bg-secondary); border: 1.5px solid var(--border-color);
    border-radius: 1rem; padding: .875rem 1.25rem;
    display: flex; flex-wrap: wrap; gap: .75rem 1.5rem;
}
.legend-item { display: flex; align-items: center; gap: .5rem; font-size: .775rem; color: var(--text-secondary); font-weight: 500; }
.legend-dot  { width: 11px; height: 11px; border-radius: .25rem; flex-shrink: 0; }

/* Responsive */
@media (max-width: 768px) {
    .myev-page  { padding: 1rem; }
    .myev-stats { grid-template-columns: repeat(2,1fr); }
    .myev-item-img { width: 70px; }
    .myev-item-body { flex-direction: column; align-items: flex-start; gap: .5rem; }
    .myev-item-right { align-items: flex-start; flex-direction: row; flex-wrap: wrap; }
}
@media (max-width: 480px) {
    .myev-item-img { display: none; }
}
</style>
@endpush


@section('content')
<div class="myev-page">
    <h1 class="myev-page-title">My Events</h1>

    {{-- Stats --}}
    <div class="myev-stats" id="myEvStats">
        <div class="myev-stat"><span class="myev-stat-num" id="statTotal">-</span><span class="myev-stat-lbl">Total Terdaftar</span></div>
        <div class="myev-stat"><span class="myev-stat-num" id="statUpcoming">-</span><span class="myev-stat-lbl">Akan Datang</span></div>
        <div class="myev-stat"><span class="myev-stat-num" id="statAttended">-</span><span class="myev-stat-lbl">Selesai Dihadiri</span></div>
        <div class="myev-stat"><span class="myev-stat-num" id="statCerts">-</span><span class="myev-stat-lbl">Sertifikat Tersedia</span></div>
    </div>

    {{-- Filter chips --}}
    <div class="myev-filters">
        <span class="myev-chip active" data-filter="all">Semua</span>
        <span class="myev-chip" data-filter="registered">Terdaftar</span>
        <span class="myev-chip" data-filter="present">Hadir</span>
        <span class="myev-chip" data-filter="absent">Absen</span>
        <span class="myev-chip" data-filter="cancelled">Dibatalkan</span>
    </div>

    {{-- Event list --}}
    <div class="myev-list" id="myEventsList">
        <div style="text-align:center;padding:2rem;color:var(--text-muted);">Memuat data...</div>
    </div>

</div>
@endsection

@push('js')
@vite(['resources/js/utils/api.js', 'resources/js/user/my-events.js'])
@endpush
