@extends('user.layout')

@section('title', 'Kalender Event')

@push('css')
<style>
.calendar-page { padding: 1.5rem 1.75rem; font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }

.calendar-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 1.5rem;
    align-items: start;
}

/* ── PAGE TITLE ── */
.cal-page-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--text-primary);
    font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
    margin-bottom: 1.25rem;
}

/* ── CALENDAR CARD ── */
.calendar-card {
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1.25rem;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}

.cal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #0f1f4e 0%, #1a3a7c 100%);
}

.cal-nav-btn {
    width: 34px; height: 34px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.15);
    color: white;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s;
    font-size: 1rem;
}
.cal-nav-btn:hover { background: rgba(255,255,255,0.28); }

.cal-month-label {
    font-size: 1rem;
    font-weight: 800;
    color: white;
    letter-spacing: 0.02em;
}

/* Day headers */
.cal-days-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: var(--bg-tertiary);
    border-bottom: 1px solid var(--border-color);
}
.cal-day-name {
    text-align: center;
    padding: 0.6rem 0;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Grid */
.cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
}

.cal-cell {
    min-height: 78px;
    padding: 0.4rem;
    border-right: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    position: relative;
    cursor: default;
    transition: background 0.15s;
}
.cal-cell:nth-child(7n) { border-right: none; }
.cal-cell:hover { background: var(--bg-tertiary); }

.cal-cell.empty { background: var(--bg-primary); cursor: default; }
.cal-cell.today {
    background: #eff6ff;
    border-color: #bfdbfe;
}
.cal-cell.today .cal-date-num {
    background: #0f1f4e;
    color: white;
    border-radius: 50%;
    width: 26px; height: 26px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800;
}
.cal-cell.has-event { cursor: pointer; }

.cal-date-num {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
    width: 26px; height: 26px;
    display: flex; align-items: center; justify-content: center;
}
.cal-cell.empty .cal-date-num { color: var(--text-muted); opacity: 0.4; }

.cal-event-dot {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    background: #dbeafe;
    color: #1d4ed8;
    font-size: 0.62rem;
    font-weight: 700;
    padding: 0.15rem 0.35rem;
    border-radius: 0.3rem;
    margin-bottom: 0.15rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}
.cal-event-dot.green  { background: #dcfce7; color: #15803d; }
.cal-event-dot.orange { background: #fef3c7; color: #d97706; }
.cal-event-dot.red    { background: #fee2e2; color: #dc2626; }
.cal-event-dot.purple { background: #ede9fe; color: #7c3aed; }

/* ── RIGHT PANEL ── */
.cal-right { display: flex; flex-direction: column; gap: 1.25rem; }

/* Upcoming events sidebar */
.cal-upcoming {
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1.25rem;
    padding: 1.25rem;
}
.cal-upcoming-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.upcoming-item {
    display: flex;
    gap: 0.875rem;
    align-items: flex-start;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}
.upcoming-item:last-child { border-bottom: none; padding-bottom: 0; }

.upcoming-date-box {
    width: 42px; flex-shrink: 0;
    background: linear-gradient(135deg, #0f1f4e, #1a3a7c);
    border-radius: 0.625rem;
    text-align: center;
    padding: 0.35rem 0;
    color: white;
}
.upcoming-date-day { font-size: 1.1rem; font-weight: 800; line-height: 1; }
.upcoming-date-month { font-size: 0.6rem; font-weight: 600; letter-spacing: 0.05em; opacity: 0.8; text-transform: uppercase; }

.upcoming-info { flex: 1; min-width: 0; }
.upcoming-name {
    font-size: 0.825rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.15rem;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.upcoming-meta {
    font-size: 0.72rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

/* Legend */
.cal-legend {
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1.25rem;
    padding: 1.25rem;
}
.cal-legend-title {
    font-size: 0.875rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.875rem;
}
.legend-item {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-secondary);
    font-weight: 500;
}
.legend-dot {
    width: 12px; height: 12px;
    border-radius: 0.25rem;
    flex-shrink: 0;
}
</style>
@endpush

@section('content')
<div class="calendar-page">
    <h1 class="cal-page-title">📅 Kalender Event</h1>

    <div class="calendar-layout">

        {{-- ── CALENDAR ── --}}
        <div>
            <div class="calendar-card">
                <div class="cal-header">
                    <button class="cal-nav-btn" id="prevMonth" title="Bulan sebelumnya">&#8249;</button>
                    <span class="cal-month-label" id="calMonthLabel">September 2026</span>
                    <button class="cal-nav-btn" id="nextMonth" title="Bulan berikutnya">&#8250;</button>
                </div>

                <div class="cal-days-header">
                    <div class="cal-day-name">Min</div>
                    <div class="cal-day-name">Sen</div>
                    <div class="cal-day-name">Sel</div>
                    <div class="cal-day-name">Rab</div>
                    <div class="cal-day-name">Kam</div>
                    <div class="cal-day-name">Jum</div>
                    <div class="cal-day-name">Sab</div>
                </div>

                <div class="cal-grid" id="calGrid">
                    {{-- Rendered by JS --}}
                </div>
            </div>
        </div>

        {{-- ── RIGHT PANEL ── --}}
        <div class="cal-right">

            {{-- Upcoming Events --}}
            <div class="cal-upcoming">
                <div class="cal-upcoming-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Event Mendatang
                </div>

                <div class="upcoming-item">
                    <div class="upcoming-date-box">
                        <div class="upcoming-date-day">20</div>
                        <div class="upcoming-date-month">Aug</div>
                    </div>
                    <div class="upcoming-info">
                        <div class="upcoming-name">Career Day</div>
                        <div class="upcoming-meta">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            08:00 — 11:30 · Avis
                        </div>
                    </div>
                </div>

                <div class="upcoming-item">
                    <div class="upcoming-date-box">
                        <div class="upcoming-date-day">25</div>
                        <div class="upcoming-date-month">Aug</div>
                    </div>
                    <div class="upcoming-info">
                        <div class="upcoming-name">Workshop Programming</div>
                        <div class="upcoming-meta">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            09:00 — 15:00 · Lab RPL
                        </div>
                    </div>
                </div>

                <div class="upcoming-item">
                    <div class="upcoming-date-box">
                        <div class="upcoming-date-day">01</div>
                        <div class="upcoming-date-month">Sep</div>
                    </div>
                    <div class="upcoming-info">
                        <div class="upcoming-name">Classmeeting</div>
                        <div class="upcoming-meta">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            07:30 — 15:00 · Lapangan
                        </div>
                    </div>
                </div>

                <div class="upcoming-item">
                    <div class="upcoming-date-box">
                        <div class="upcoming-date-day">03</div>
                        <div class="upcoming-date-month">Sep</div>
                    </div>
                    <div class="upcoming-info">
                        <div class="upcoming-name">Seminar Kewirausahaan</div>
                        <div class="upcoming-meta">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            10:00 — 12:00 · Avis
                        </div>
                    </div>
                </div>

                <div class="upcoming-item">
                    <div class="upcoming-date-box">
                        <div class="upcoming-date-day">10</div>
                        <div class="upcoming-date-month">Sep</div>
                    </div>
                    <div class="upcoming-info">
                        <div class="upcoming-name">Turnamen Basket</div>
                        <div class="upcoming-meta">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            08:00 — 16:00 · Lap. Basket
                        </div>
                    </div>
                </div>
            </div>

            {{-- Legend --}}
            <div class="cal-legend">
                <div class="cal-legend-title">Keterangan</div>
                <div class="legend-item">
                    <div class="legend-dot" style="background:#dbeafe;"></div>
                    School Event / Career
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background:#dcfce7;"></div>
                    Workshop / Seminar
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background:#fef3c7;"></div>
                    Competition / Classmeet
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background:#ede9fe;"></div>
                    Sports
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background:#0f1f4e; border-radius:50%;"></div>
                    Hari Ini
                </div>
            </div>

        </div>{{-- /cal-right --}}
    </div>{{-- /calendar-layout --}}
</div>
@endsection

@push('js')
<script>
(function () {
    // Event data — format: { day, month (0-based), year, label, color }
    const events = [
        { day: 20, month: 7, year: 2026, label: 'Career Day',        color: 'blue' },
        { day: 25, month: 7, year: 2026, label: 'Workshop',          color: 'green' },
        { day:  1, month: 8, year: 2026, label: 'Classmeeting',      color: 'orange' },
        { day:  2, month: 8, year: 2026, label: 'Classmeeting',      color: 'orange' },
        { day:  3, month: 8, year: 2026, label: 'Classmeeting',      color: 'orange' },
        { day:  4, month: 8, year: 2026, label: 'Classmeeting',      color: 'orange' },
        { day:  5, month: 8, year: 2026, label: 'Classmeeting',      color: 'orange' },
        { day:  3, month: 8, year: 2026, label: 'Seminar',           color: 'green' },
        { day: 10, month: 8, year: 2026, label: 'Turnamen Basket',   color: 'purple' },
    ];

    const MONTHS = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    let current = new Date(2026, 8, 1); // Sept 2026

    function getEventsOn(day, month, year) {
        return events.filter(e => e.day === day && e.month === month && e.year === year);
    }

    function render() {
        const year  = current.getFullYear();
        const month = current.getMonth();
        const today = new Date();

        document.getElementById('calMonthLabel').textContent = MONTHS[month] + ' ' + year;

        const firstDay   = new Date(year, month, 1).getDay(); // 0=Sun
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        // Previous month fill
        const prevDays   = new Date(year, month, 0).getDate();

        const grid = document.getElementById('calGrid');
        grid.innerHTML = '';

        let cells = [];

        // Leading empty cells (prev month)
        for (let i = 0; i < firstDay; i++) {
            cells.push({ day: prevDays - firstDay + i + 1, type: 'prev-empty' });
        }
        // Current month
        for (let d = 1; d <= daysInMonth; d++) {
            cells.push({ day: d, type: 'current' });
        }
        // Trailing empty cells
        const remainder = cells.length % 7;
        if (remainder !== 0) {
            for (let i = 1; i <= 7 - remainder; i++) {
                cells.push({ day: i, type: 'next-empty' });
            }
        }

        cells.forEach(function (cell) {
            const div = document.createElement('div');
            div.className = 'cal-cell';

            if (cell.type !== 'current') {
                div.classList.add('empty');
                const num = document.createElement('div');
                num.className = 'cal-date-num';
                num.textContent = cell.day;
                div.appendChild(num);
            } else {
                const isToday = (cell.day === today.getDate() && month === today.getMonth() && year === today.getFullYear());
                if (isToday) div.classList.add('today');

                const num = document.createElement('div');
                num.className = 'cal-date-num';
                num.textContent = cell.day;
                div.appendChild(num);

                const dayEvents = getEventsOn(cell.day, month, year);
                if (dayEvents.length) {
                    div.classList.add('has-event');
                    dayEvents.slice(0, 2).forEach(function (ev) {
                        const dot = document.createElement('div');
                        dot.className = 'cal-event-dot ' + (ev.color || '');
                        dot.textContent = ev.label;
                        div.appendChild(dot);
                    });
                    if (dayEvents.length > 2) {
                        const more = document.createElement('div');
                        more.className = 'cal-event-dot';
                        more.style.opacity = '0.6';
                        more.textContent = '+' + (dayEvents.length - 2) + ' lagi';
                        div.appendChild(more);
                    }
                }
            }

            grid.appendChild(div);
        });
    }

    document.getElementById('prevMonth').addEventListener('click', function () {
        current.setMonth(current.getMonth() - 1);
        render();
    });
    document.getElementById('nextMonth').addEventListener('click', function () {
        current.setMonth(current.getMonth() + 1);
        render();
    });

    render();
})();
</script>
@endpush
