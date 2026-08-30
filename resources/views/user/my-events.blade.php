@extends('user.layout')

@section('title', 'My Events')

@push('css')
<style>
/* ══ My Events Page ══ */
.myev-page { padding: 1.5rem 1.75rem; font-family: 'Plus Jakarta Sans','Inter',sans-serif; }
.myev-page-title { font-size: 1.35rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.5rem; }

/* ── Stats row ── */
.myev-stats {
    display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 1.5rem;
}
.myev-stat {
    background: var(--bg-secondary); border: 1.5px solid var(--border-color);
    border-radius: 1rem; padding: .875rem 1rem; text-align: center;
}
.myev-stat-num { font-size: 1.5rem; font-weight: 800; color: var(--text-primary); display: block; line-height: 1.1; }
.myev-stat-lbl { font-size: .7rem; color: var(--text-muted); font-weight: 500; margin-top: 3px; display: block; }

/* ── Filter chips ── */
.myev-filters { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 1.25rem; }
.myev-chip {
    padding: .38rem 1rem; border-radius: 999px; font-size: .78rem; font-weight: 600;
    border: 1.5px solid var(--border-color); background: var(--bg-secondary);
    color: var(--text-secondary); cursor: pointer; transition: all .15s; white-space: nowrap;
}
.myev-chip:hover { border-color: var(--primary); color: var(--primary); }
.myev-chip.active { background: var(--primary); border-color: var(--primary); color: #fff; }

/* ── Event list ── */
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

/* ══════════════════════
   KALENDER (di bawah list)
══════════════════════ */
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
    <div class="myev-stats">
        <div class="myev-stat"><span class="myev-stat-num">5</span><span class="myev-stat-lbl">Total Terdaftar</span></div>
        <div class="myev-stat"><span class="myev-stat-num">3</span><span class="myev-stat-lbl">Akan Datang</span></div>
        <div class="myev-stat"><span class="myev-stat-num">2</span><span class="myev-stat-lbl">Selesai Dihadiri</span></div>
        <div class="myev-stat"><span class="myev-stat-num">2</span><span class="myev-stat-lbl">Sertifikat Tersedia</span></div>
    </div>

    {{-- Filter chips --}}
    <div class="myev-filters">
        <span class="myev-chip active" data-filter="all">Semua</span>
        <span class="myev-chip" data-filter="upcoming">Akan Datang</span>
        <span class="myev-chip" data-filter="registered">Terdaftar</span>
        <span class="myev-chip" data-filter="attended">Hadir</span>
        <span class="myev-chip" data-filter="absent">Absen</span>
    </div>

    {{-- Event list --}}
    <div class="myev-list" id="myEvList">

        <div class="myev-item" data-status="upcoming">
            <div class="myev-item-img"><img src="{{ asset('images/seminar.png') }}" alt="Seminar Digital"></div>
            <div class="myev-item-body">
                <div class="myev-item-left">
                    <span class="myev-item-cat seminar">Seminar</span>
                    <div class="myev-item-title">Seminar Digital</div>
                    <div class="myev-item-meta">
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>10 Sep 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>08:00 – 12:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status upcoming">Akan Datang</span>
                    <button class="myev-btn-detail">Detail</button>
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
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>15 Sep 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>08:00 – 15:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status registered">Terdaftar</span>
                    <button class="myev-btn-detail">Detail</button>
                </div>
            </div>
        </div>

        <div class="myev-item" data-status="registered">
            <div class="myev-item-img"><img src="{{ asset('images/classmeeting.jpeg') }}" alt="Class Meeting"></div>
            <div class="myev-item-body">
                <div class="myev-item-left">
                    <span class="myev-item-cat competition">Kompetisi</span>
                    <div class="myev-item-title">Class Meeting 2026</div>
                    <div class="myev-item-meta">
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>20 Sep 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>07:30 – 17:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Lapangan Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status registered">Terdaftar</span>
                    <button class="myev-btn-detail">Detail</button>
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
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>15 Agu 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>09:00 – 15:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status attended">Hadir ✓</span>
                    <button class="myev-btn-detail">Sertifikat</button>
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
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>28 Jul 2026</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>08:00 – 12:00</span>
                        <span class="myev-item-meta-i"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                    </div>
                </div>
                <div class="myev-item-right">
                    <span class="myev-status attended">Hadir ✓</span>
                    <button class="myev-btn-detail">Sertifikat</button>
                </div>
            </div>
        </div>

    </div>

    {{-- ════ KALENDER (di bawah list) ════ --}}
    <div class="myev-cal-section">
        <h2 class="myev-cal-section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Kalender Event
        </h2>

        <div class="cal-card">
            <div class="cal-header">
                <button class="cal-nav-btn" id="prevMonth">&#8249;</button>
                <span class="cal-month-label" id="calMonthLabel">September 2026</span>
                <button class="cal-nav-btn" id="nextMonth">&#8250;</button>
            </div>
            <div class="cal-days-header">
                <div class="cal-day-name">Min</div><div class="cal-day-name">Sen</div>
                <div class="cal-day-name">Sel</div><div class="cal-day-name">Rab</div>
                <div class="cal-day-name">Kam</div><div class="cal-day-name">Jum</div>
                <div class="cal-day-name">Sab</div>
            </div>
            <div class="cal-grid" id="calGrid"></div>
        </div>

        <div class="cal-legend">
            <div class="legend-item"><div class="legend-dot" style="background:#dbeafe;"></div>School Event / Career</div>
            <div class="legend-item"><div class="legend-dot" style="background:#dcfce7;"></div>Workshop / Seminar</div>
            <div class="legend-item"><div class="legend-dot" style="background:#fef3c7;"></div>Competition / Class Meeting</div>
            <div class="legend-item"><div class="legend-dot" style="background:#ede9fe;"></div>Sports</div>
            <div class="legend-item"><div class="legend-dot" style="background:#0f1f4e;border-radius:50%;"></div>Hari Ini</div>
        </div>
    </div>

</div>
@endsection

@push('js')
<script>
// Filter chips
(function(){
    var chips = document.querySelectorAll('.myev-chip');
    var items = document.querySelectorAll('.myev-item');
    chips.forEach(function(chip){
        chip.addEventListener('click', function(){
            chips.forEach(function(c){ c.classList.remove('active'); });
            chip.classList.add('active');
            var filter = chip.getAttribute('data-filter');
            items.forEach(function(item){
                item.style.display = (filter==='all' || item.getAttribute('data-status')===filter) ? '' : 'none';
            });
        });
    });
})();

// Calendar
(function(){
    const events = [
        {day:10,month:8,year:2026,label:'Seminar',   color:'green'},
        {day:15,month:8,year:2026,label:'Career Day', color:'blue'},
        {day:20,month:8,year:2026,label:'Classmeeting',color:'orange'},
        {day:21,month:8,year:2026,label:'Classmeeting',color:'orange'},
        {day:22,month:8,year:2026,label:'Classmeeting',color:'orange'},
        {day:23,month:8,year:2026,label:'Classmeeting',color:'orange'},
        {day:24,month:8,year:2026,label:'Classmeeting',color:'orange'},
        {day:25,month:8,year:2026,label:'Workshop',   color:'green'},
        {day:10,month:9,year:2026,label:'Turnamen',   color:'purple'},
        {day:15,month:6,year:2026,label:'Workshop',   color:'green'},
    ];
    const MONTHS=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    let current = new Date(2026,8,1);

    function getEventsOn(d,m,y){ return events.filter(e=>e.day===d&&e.month===m&&e.year===y); }

    function render(){
        const year=current.getFullYear(), month=current.getMonth(), today=new Date();
        document.getElementById('calMonthLabel').textContent = MONTHS[month]+' '+year;
        const firstDay=new Date(year,month,1).getDay();
        const daysInMonth=new Date(year,month+1,0).getDate();
        const prevDays=new Date(year,month,0).getDate();
        const grid=document.getElementById('calGrid');
        grid.innerHTML='';
        let cells=[];
        for(let i=0;i<firstDay;i++) cells.push({day:prevDays-firstDay+i+1,type:'empty'});
        for(let d=1;d<=daysInMonth;d++) cells.push({day:d,type:'current'});
        const rem=cells.length%7;
        if(rem) for(let i=1;i<=7-rem;i++) cells.push({day:i,type:'next-empty'});
        cells.forEach(function(cell){
            const div=document.createElement('div');
            div.className='cal-cell';
            if(cell.type!=='current'){
                div.classList.add('empty');
                const num=document.createElement('div');
                num.className='cal-date-num'; num.textContent=cell.day;
                div.appendChild(num);
            } else {
                if(cell.day===today.getDate()&&month===today.getMonth()&&year===today.getFullYear()) div.classList.add('today');
                const num=document.createElement('div');
                num.className='cal-date-num'; num.textContent=cell.day;
                div.appendChild(num);
                const evs=getEventsOn(cell.day,month,year);
                if(evs.length){
                    div.classList.add('has-event');
                    evs.slice(0,2).forEach(function(ev){
                        const chip=document.createElement('div');
                        chip.className='cal-event-chip '+(ev.color||'blue');
                        chip.textContent=ev.label;
                        div.appendChild(chip);
                    });
                    if(evs.length>2){
                        const more=document.createElement('div');
                        more.className='cal-event-chip blue';
                        more.style.opacity='.6';
                        more.textContent='+'+(evs.length-2);
                        div.appendChild(more);
                    }
                }
            }
            grid.appendChild(div);
        });
    }
    document.getElementById('prevMonth').addEventListener('click',function(){ current.setMonth(current.getMonth()-1);render(); });
    document.getElementById('nextMonth').addEventListener('click',function(){ current.setMonth(current.getMonth()+1);render(); });
    render();
})();
</script>
@endpush
