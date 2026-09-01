@extends('user.layout')

@section('title', 'Dashboard')

@push('css')
<style>
/* =============================================
   EVENTY DASHBOARD â€” Scrapbook Aesthetic Style
   ============================================= */

/* Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.eventy-dashboard {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 1.5rem;
    padding: 1.5rem 1.75rem;
    min-height: 100%;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    background: var(--bg-primary);
}

/* â”€â”€ LEFT COLUMN â”€â”€ */
.eventy-left { display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; }

/* â”€â”€ HERO BANNER â”€â”€ */
.hero-banner {
    position: relative;
    background: linear-gradient(135deg, #0f1f4e 0%, #1a3a7c 50%, #1e4fc2 100%);
    border-radius: 1.25rem;
    padding: 2rem 2.25rem;
    overflow: hidden;
    min-height: 180px;
    display: flex;
    align-items: center;
    box-shadow: 0 8px 32px rgba(15, 31, 78, 0.25);
}

/* Torn paper bottom edge */
.hero-banner::after {
    content: '';
    position: absolute;
    bottom: -2px; left: 0; right: 0;
    height: 18px;
    background: var(--bg-primary);
    clip-path: polygon(0% 100%, 2% 40%, 4% 80%, 6% 20%, 8% 60%, 10% 10%, 12% 70%, 14% 30%, 16% 80%, 18% 15%, 20% 65%, 22% 25%, 24% 75%, 26% 10%, 28% 55%, 30% 20%, 32% 70%, 34% 35%, 36% 85%, 38% 15%, 40% 60%, 42% 20%, 44% 75%, 46% 30%, 48% 70%, 50% 10%, 52% 60%, 54% 25%, 56% 80%, 58% 15%, 60% 65%, 62% 30%, 64% 75%, 66% 20%, 68% 65%, 70% 15%, 72% 70%, 74% 25%, 76% 80%, 78% 10%, 80% 55%, 82% 20%, 84% 70%, 86% 35%, 88% 75%, 90% 15%, 92% 60%, 94% 25%, 96% 70%, 98% 30%, 100% 55%, 100% 100%);
}

/* Decorative circles */
.hero-banner::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    pointer-events: none;
}

.hero-deco-circle {
    position: absolute;
    bottom: -40px; right: 180px;
    width: 140px; height: 140px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
    pointer-events: none;
}

.hero-content { position: relative; z-index: 2; flex: 1; }

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: rgba(255,255,255,0.15);
    color: #a5c8ff;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 0.3rem 0.8rem;
    border-radius: 999px;
    margin-bottom: 0.875rem;
}

.hero-title {
    font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
    font-size: 1.6rem;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.25;
    margin-bottom: 0.5rem;
    max-width: 480px;
}

.hero-title span { color: #7dd3fc; }

.hero-subtitle {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.65);
    margin-bottom: 1.25rem;
    max-width: 380px;
}

.hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #ffffff;
    color: #0f1f4e;
    font-weight: 700;
    font-size: 0.875rem;
    padding: 0.6rem 1.4rem;
    border-radius: 999px;
    text-decoration: none;
    transition: all 0.2s;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}
.hero-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.25); color: #0f1f4e; }

/* Polaroid decorations */
.hero-polaroids {
    position: absolute;
    right: 1.5rem; top: 50%;
    transform: translateY(-50%);
    display: flex;
    gap: 0.75rem;
    z-index: 2;
}

.polaroid {
    background: #fff;
    padding: 0.5rem 0.5rem 1.5rem;
    border-radius: 0.25rem;
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    width: 90px;
    flex-shrink: 0;
    transform: rotate(-4deg);
}
.polaroid:nth-child(2) { transform: rotate(3deg) translateY(-8px); }
.polaroid:nth-child(3) { transform: rotate(-2deg) translateY(4px); }

.polaroid img {
    width: 100%;
    height: 70px;
    object-fit: cover;
    border-radius: 0.1rem;
    display: block;
}
.polaroid-label {
    font-size: 0.6rem;
    font-weight: 700;
    color: #334155;
    text-align: center;
    margin-top: 0.35rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* â”€â”€ EVENTS SECTION â”€â”€ */
.events-section { display: flex; flex-direction: column; gap: 1rem; }

.events-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

.events-topbar-left {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.eventy-section-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--text-primary);
    white-space: nowrap;
}

.eventy-search {
    position: relative;
}
.eventy-search-icon {
    position: absolute;
    left: 0.75rem; top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
}
.eventy-search input {
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 999px;
    padding: 0.5rem 1rem 0.5rem 2.25rem;
    font-size: 0.825rem;
    color: var(--text-primary);
    width: 220px;
    outline: none;
    transition: border-color 0.2s;
}
.eventy-search input:focus { border-color: var(--primary); }
.eventy-search input::placeholder { color: var(--text-muted); }

.see-all-link {
    font-size: 0.825rem;
    font-weight: 600;
    color: var(--primary);
    white-space: nowrap;
    text-decoration: none;
}
.see-all-link:hover { text-decoration: underline; }

/* Filter chips */
.filter-chips {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.chip {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.9rem;
    border-radius: 999px;
    font-size: 0.775rem;
    font-weight: 600;
    cursor: pointer;
    border: 1.5px solid var(--border-color);
    background: var(--bg-secondary);
    color: var(--text-secondary);
    transition: all 0.15s;
    white-space: nowrap;
    user-select: none;
}
.chip:hover { border-color: var(--primary); color: var(--primary); }
.chip.active {
    background: #0f1f4e;
    border-color: #0f1f4e;
    color: #ffffff;
}

/* Event list items */
.event-list { display: flex; flex-direction: column; gap: 0.875rem; }

.event-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1rem;
    padding: 0.875rem 1rem;
    transition: all 0.2s;
    cursor: pointer;
}
.event-row:hover {
    border-color: #0f1f4e;
    box-shadow: 0 4px 16px rgba(15,31,78,0.08);
    transform: translateY(-1px);
}

.event-row-thumb {
    width: 72px;
    height: 60px;
    border-radius: 0.625rem;
    object-fit: cover;
    flex-shrink: 0;
    background: var(--bg-tertiary);
}

.event-row-info { flex: 1; min-width: 0; }

.event-row-title {
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--text-primary);
    margin-bottom: 0.2rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.event-row-meta {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    font-size: 0.775rem;
    color: var(--text-muted);
}
.event-row-meta span { display: flex; align-items: center; gap: 0.3rem; }

.event-row-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.4rem;
    flex-shrink: 0;
    min-width: 120px;
}

.status-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.2rem 0.65rem;
    border-radius: 999px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.03em;
}
.status-open    { background: #dcfce7; color: #15803d; }
.status-ongoing { background: #dbeafe; color: #1d4ed8; }
.status-closed  { background: #fee2e2; color: #dc2626; }
.status-soon    { background: #fef3c7; color: #d97706; }

/* Capacity bar */
.capacity-wrap { width: 100%; }
.capacity-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.68rem;
    color: var(--text-muted);
    margin-bottom: 0.2rem;
    font-weight: 600;
}
.capacity-bar {
    height: 5px;
    background: var(--bg-tertiary);
    border-radius: 999px;
    overflow: hidden;
    width: 120px;
}
.capacity-fill {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(90deg, #3b82f6, #0f1f4e);
    transition: width 0.6s ease;
}
.capacity-fill.full { background: linear-gradient(90deg, #f59e0b, #ef4444); }

/* â”€â”€ RIGHT COLUMN â”€â”€ */
.eventy-right { display: flex; flex-direction: column; gap: 1.25rem; }

/* User summary card */
.user-card {
    background: linear-gradient(145deg, #0f1f4e 0%, #1a3a7c 100%);
    border-radius: 1.25rem;
    padding: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(15,31,78,0.2);
}
.user-card::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 130px; height: 130px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
}
.user-card::after {
    content: '';
    position: absolute;
    bottom: -30px; left: -30px;
    width: 100px; height: 100px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
}

.user-card-inner { position: relative; z-index: 2; }

.user-avatar-wrap {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    margin-bottom: 1.25rem;
}
.user-avatar-big {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #60a5fa, #a78bfa);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; font-weight: 800; color: white;
    flex-shrink: 0;
    border: 2px solid rgba(255,255,255,0.3);
}
.user-name { font-weight: 800; font-size: 1rem; color: white; line-height: 1.2; }
.user-email { font-size: 0.75rem; color: rgba(255,255,255,0.6); margin-top: 0.15rem; }
.user-class-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: rgba(255,255,255,0.15);
    color: #bfdbfe;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 0.25rem 0.65rem;
    border-radius: 999px;
    margin-top: 0.4rem;
    letter-spacing: 0.02em;
}

/* Stats grid */
.stats-grid-2x2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.65rem;
    margin-top: 0.25rem;
}

.mini-stat {
    background: rgba(255,255,255,0.1);
    border-radius: 0.75rem;
    padding: 0.75rem;
    text-align: center;
    transition: background 0.2s;
}
.mini-stat:hover { background: rgba(255,255,255,0.16); }

.mini-stat-num {
    font-size: 1.4rem;
    font-weight: 800;
    color: #ffffff;
    line-height: 1;
}
.mini-stat-label {
    font-size: 0.65rem;
    color: rgba(255,255,255,0.6);
    font-weight: 600;
    margin-top: 0.2rem;
    letter-spacing: 0.02em;
}
.mini-stat-icon { font-size: 1rem; margin-bottom: 0.25rem; }

/* Quick Actions */
.quick-actions-card {
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1.25rem;
    padding: 1.25rem;
}
.qa-title {
    font-size: 0.9rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 1rem;
}
.qa-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.625rem;
}
.qa-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.875rem 0.5rem;
    background: var(--bg-primary);
    border: 1.5px solid var(--border-color);
    border-radius: 0.875rem;
    text-decoration: none;
    color: var(--text-primary);
    font-size: 0.72rem;
    font-weight: 700;
    text-align: center;
    cursor: pointer;
    transition: all 0.18s;
}
.qa-btn:hover {
    border-color: #0f1f4e;
    background: #f0f4ff;
    color: #0f1f4e;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(15,31,78,0.1);
}
.qa-btn-icon {
    width: 36px; height: 36px;
    border-radius: 0.625rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.qa-blue   { background: #dbeafe; }
.qa-green  { background: #dcfce7; }
.qa-purple { background: #ede9fe; }
.qa-orange { background: #fef3c7; }

/* Scrapbook note card */
.scrapbook-note {
    background: #fef9c3;
    border: 1.5px solid #fde68a;
    border-radius: 1rem;
    padding: 1rem 1.25rem;
    position: relative;
    overflow: hidden;
}
.scrapbook-note::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #f59e0b, #fbbf24, #fcd34d);
}
.scrapbook-note-text {
    font-size: 0.8rem;
    color: #78350f;
    font-style: italic;
    line-height: 1.6;
    font-weight: 500;
}
.scrapbook-note-author {
    font-size: 0.7rem;
    color: #92400e;
    font-weight: 700;
    margin-top: 0.5rem;
    text-align: right;
}
</style>
@endpush


@section('content')
<div class="eventy-dashboard">

    {{-- ══════════════════ LEFT COLUMN ══════════════════ --}}
    <div class="eventy-left">

        {{-- ── HERO BANNER (nearest upcoming event atau default) ── --}}
        <div class="hero-banner">
            <div class="hero-deco-circle"></div>
            <div class="hero-content">
                @if($nearestEvent)
                    <div class="hero-eyebrow">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                        {{ $nearestEvent->category->name ?? 'Event' }} · {{ $nearestEvent->date->format('F Y') }}
                    </div>
                    <h1 class="hero-title">{{ $nearestEvent->name }}</h1>
                    <p class="hero-subtitle">
                        {{ Str::limit($nearestEvent->description, 100) }}
                    </p>
                    <a href="{{ url('/user/events/' . $nearestEvent->id) }}" class="hero-btn">
                        Lihat Event
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                @elseif($upcomingEvents->isNotEmpty())
                    @php $featured = $upcomingEvents->first(); @endphp
                    <div class="hero-eyebrow">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                        {{ $featured->category->name ?? 'Event' }} · {{ $featured->date->format('F Y') }}
                    </div>
                    <h1 class="hero-title">{{ $featured->name }}</h1>
                    <p class="hero-subtitle">{{ Str::limit($featured->description, 100) }}</p>
                    <a href="{{ url('/user/events/' . $featured->id) }}" class="hero-btn">
                        Lihat Event
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                @else
                    <div class="hero-eyebrow">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                        Selamat Datang di Eventty
                    </div>
                    <h1 class="hero-title">Belum ada event <span>mendatang</span></h1>
                    <p class="hero-subtitle">Pantau terus halaman events untuk event terbaru dari sekolah.</p>
                    <a href="{{ url('/user/events') }}" class="hero-btn">
                        Lihat Semua Event
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                @endif
            </div>

            {{-- Polaroid dari 3 event pertama --}}
            @if($upcomingEvents->isNotEmpty())
            <div class="hero-polaroids">
                @foreach($upcomingEvents->take(3) as $pol)
                <div class="polaroid">
                    @if($pol->banner_path)
                        <img src="{{ $pol->banner_url }}" alt="{{ $pol->name }}">
                    @else
                        <div style="width:100%;height:80px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;font-size:1.5rem;">🎉</div>
                    @endif
                    <div class="polaroid-label">{{ Str::limit($pol->name, 14) }}</div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ── EVENTS SECTION ── --}}
        <div class="events-section">
            <div class="events-topbar">
                <div class="events-topbar-left">
                    <span class="eventy-section-title">Events Tersedia</span>
                    <div class="eventy-search">
                        <svg class="eventy-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="eventSearch" placeholder="Cari event...">
                    </div>
                </div>
                <a href="{{ url('/user/events') }}" class="see-all-link">Lihat Semua Events →</a>
            </div>

            {{-- Filter chips dari kategori DB --}}
            <div class="filter-chips" id="filterChips">
                <span class="chip active" data-filter="all">All</span>
                @foreach($categories as $cat)
                    <span class="chip" data-filter="{{ Str::slug($cat->name) }}">{{ $cat->name }}</span>
                @endforeach
            </div>

            {{-- Event list dari database --}}
            <div class="event-list" id="eventList">
                @forelse($upcomingEvents as $event)
                @php
                    $pct = $event->quota > 0 ? min(100, round($event->registered_count / $event->quota * 100)) : 0;
                    $isFull = $event->isFull();
                    $statusLabel = match($event->status) {
                        'open'   => $isFull ? 'Almost Full' : 'Open',
                        'closed' => 'Closed',
                        default  => ucfirst($event->status),
                    };
                    $statusClass = $isFull ? 'status-soon' : ($event->status === 'open' ? 'status-open' : 'status-closed');
                    $catSlug = Str::slug($event->category->name ?? 'other');
                @endphp
                <div class="event-row" data-category="{{ $catSlug }}" data-id="{{ $event->id }}">
                    @if($event->banner_path)
                        <img class="event-row-thumb" src="{{ $event->banner_url }}" alt="{{ $event->name }}">
                    @else
                        <div class="event-row-thumb" style="background:{{ $event->category->color ?? '#3b82f6' }};display:flex;align-items:center;justify-content:center;font-size:1.4rem;">🎉</div>
                    @endif
                    <div class="event-row-info">
                        <div class="event-row-title">{{ $event->name }}</div>
                        <div class="event-row-meta">
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $event->date->format('d M Y') }}
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $event->start_time->format('H:i') }} – {{ $event->end_time->format('H:i') }}
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ Str::limit($event->location, 20) }}
                            </span>
                        </div>
                    </div>
                    <div class="event-row-right">
                        <span class="status-tag {{ $statusClass }}">● {{ $statusLabel }}</span>
                        <div class="capacity-wrap">
                            <div class="capacity-label">
                                <span>{{ $event->registered_count }}/{{ $event->quota }}</span>
                                <span>Peserta</span>
                            </div>
                            <div class="capacity-bar">
                                <div class="capacity-fill {{ $pct >= 90 ? 'full' : '' }}" style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:2rem;color:var(--text-muted);">
                    <div style="font-size:2rem;margin-bottom:.5rem;">📅</div>
                    <p style="font-size:.875rem;">Belum ada event yang tersedia saat ini.</p>
                    <p style="font-size:.78rem;margin-top:.25rem;">Pantau terus untuk event terbaru!</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>{{-- /eventy-left --}}

    {{-- ══════════════════ RIGHT COLUMN ══════════════════ --}}
    <div class="eventy-right">

        {{-- ── USER CARD ── --}}
        <div class="user-card">
            <div class="user-card-inner">
                <div class="user-avatar-wrap">
                    <div class="user-avatar-big">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-email">NIS: {{ Auth::user()->nis ?? '-' }}</div>
                        <div class="user-class-badge">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            {{ Auth::user()->class ?? 'Belum diisi' }}
                        </div>
                    </div>
                </div>

                {{-- Stats real dari DB ── --}}
                <div class="stats-grid-2x2">
                    <div class="mini-stat">
                        <div class="mini-stat-icon">🎯</div>
                        <div class="mini-stat-num">{{ $stats['events_joined'] }}</div>
                        <div class="mini-stat-label">Events Joined</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon">🏆</div>
                        <div class="mini-stat-num">{{ $stats['certificates'] }}</div>
                        <div class="mini-stat-label">Certificates</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon">✅</div>
                        <div class="mini-stat-num">{{ $stats['completed_events'] }}</div>
                        <div class="mini-stat-label">Completed</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon">📅</div>
                        <div class="mini-stat-num">{{ $stats['upcoming_events'] }}</div>
                        <div class="mini-stat-label">Upcoming</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── QUICK ACTIONS ── --}}
        <div class="quick-actions-card">
            <div class="qa-title">Quick Actions</div>
            <div class="qa-grid">
                <a href="{{ url('/user/events') }}" class="qa-btn">
                    <div class="qa-btn-icon qa-blue">📋</div>
                    Cari Event
                </a>
                <a href="{{ url('/user/my-events') }}" class="qa-btn">
                    <div class="qa-btn-icon qa-green">📌</div>
                    Event Saya
                </a>
                <a href="{{ url('/user/certificates') }}" class="qa-btn">
                    <div class="qa-btn-icon qa-purple">🏅</div>
                    Sertifikat
                </a>
                <a href="{{ url('/user/profile') }}" class="qa-btn">
                    <div class="qa-btn-icon qa-orange">👤</div>
                    Profil
                </a>
            </div>
        </div>

        {{-- ── INFO STATUS ── --}}
        @if($stats['events_joined'] === 0)
        <div class="scrapbook-note">
            <div class="scrapbook-note-text">
                "Belum ada event yang diikuti. Yuk daftar event dan kembangkan dirimu!"
            </div>
            <div class="scrapbook-note-author">— Eventty School System ✏️</div>
        </div>
        @else
        <div class="scrapbook-note">
            <div class="scrapbook-note-text">
                "Kamu sudah mengikuti {{ $stats['events_joined'] }} event. Terus semangat dan raih lebih banyak sertifikat!"
            </div>
            <div class="scrapbook-note-author">— Eventty School System ✏️</div>
        </div>
        @endif

    </div>{{-- /eventy-right --}}

</div>{{-- /eventy-dashboard --}}
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Filter chips
    var chips = document.querySelectorAll('#filterChips .chip');
    var rows  = document.querySelectorAll('#eventList .event-row');

    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            chips.forEach(function(c) { c.classList.remove('active'); });
            this.classList.add('active');
            var filter = this.getAttribute('data-filter');
            rows.forEach(function (row) {
                var cat = row.getAttribute('data-category');
                row.style.display = (filter === 'all' || cat === filter) ? '' : 'none';
            });
        });
    });

    // Search
    var searchInput = document.getElementById('eventSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim();
            rows.forEach(function (row) {
                var titleEl = row.querySelector('.event-row-title');
                if (titleEl) {
                    row.style.display = titleEl.textContent.toLowerCase().includes(q) ? '' : 'none';
                }
            });
            if (q) chips.forEach(function(c) { c.classList.remove('active'); });
        });
    }

    // Click row → event detail
    rows.forEach(function (row) {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            if (id) window.location.href = '/user/events/' + id;
        });
    });
});
</script>
@endpush
