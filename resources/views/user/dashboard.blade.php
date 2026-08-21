@extends('user.layout')

@section('title', 'Dashboard')

@push('css')
<style>
/* =============================================
   EVENTY DASHBOARD — Scrapbook Aesthetic Style
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

/* ── LEFT COLUMN ── */
.eventy-left { display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; }

/* ── HERO BANNER ── */
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

/* ── EVENTS SECTION ── */
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

/* ── RIGHT COLUMN ── */
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

    {{-- ═══════════════════════════════════ LEFT COLUMN ═══ --}}
    <div class="eventy-left">

        {{-- ── HERO BANNER ── --}}
        <div class="hero-banner">
            <div class="hero-deco-circle"></div>
            <div class="hero-content">
                <div class="hero-eyebrow">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                    Event Unggulan · September 2026
                </div>
                <h1 class="hero-title">
                    CLASSMEET: <span>More Than Competition,</span><br>It's About Togetherness!
                </h1>
                <p class="hero-subtitle">Kompetisi antar kelas yang mempererat persatuan dan semangat SMKN 20 Jakarta.</p>
                <a href="{{ url('/user/events/3') }}" class="hero-btn">
                    Lihat Event
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
            {{-- Polaroid decorations --}}
            <div class="hero-polaroids">
                <div class="polaroid">
                    <img src="{{ asset('images/classmeeting.jpeg') }}" alt="Classmeeting">
                    <div class="polaroid-label">Classmeeting</div>
                </div>
                <div class="polaroid">
                    <img src="{{ asset('images/basket.jpeg') }}" alt="Basket">
                    <div class="polaroid-label">Turnamen</div>
                </div>
                <div class="polaroid">
                    <img src="{{ asset('images/careerday.jpeg') }}" alt="Career Day">
                    <div class="polaroid-label">Career Day</div>
                </div>
            </div>
        </div>

        {{-- ── EVENTS SECTION ── --}}
        <div class="events-section">

            {{-- Topbar: title + search + see all --}}
            <div class="events-topbar">
                <div class="events-topbar-left">
                    <span class="eventy-section-title">Events</span>
                    <div class="eventy-search">
                        <svg class="eventy-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="eventSearch" placeholder="Cari event...">
                    </div>
                </div>
                <a href="{{ url('/user/events') }}" class="see-all-link">Lihat Semua Events →</a>
            </div>

            {{-- Filter chips --}}
            <div class="filter-chips" id="filterChips">
                <span class="chip active" data-filter="all">All</span>
                <span class="chip" data-filter="classmeet">Classmeet</span>
                <span class="chip" data-filter="sports">Sports Competition</span>
                <span class="chip" data-filter="seminar">Seminar</span>
                <span class="chip" data-filter="workshop">Workshop</span>
                <span class="chip" data-filter="career">Career</span>
            </div>

            {{-- Event list --}}
            <div class="event-list" id="eventList">

                <div class="event-row" data-category="career">
                    <img class="event-row-thumb" src="{{ asset('images/careerday.jpeg') }}" alt="Career Day">
                    <div class="event-row-info">
                        <div class="event-row-title">Career Day</div>
                        <div class="event-row-meta">
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                20 Aug 2026
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                08:00 — 11:30
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Avis
                            </span>
                        </div>
                    </div>
                    <div class="event-row-right">
                        <span class="status-tag status-open">● Open</span>
                        <div class="capacity-wrap">
                            <div class="capacity-label"><span>45/50</span><span>Peserta</span></div>
                            <div class="capacity-bar"><div class="capacity-fill full" style="width:90%"></div></div>
                        </div>
                    </div>
                </div>

                <div class="event-row" data-category="workshop">
                    <img class="event-row-thumb" src="{{ asset('images/workshop.png') }}" alt="Workshop Programming">
                    <div class="event-row-info">
                        <div class="event-row-title">Workshop Programming</div>
                        <div class="event-row-meta">
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                25 Aug 2026
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                09:00 — 15:00
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Lab RPL
                            </span>
                        </div>
                    </div>
                    <div class="event-row-right">
                        <span class="status-tag status-open">● Open</span>
                        <div class="capacity-wrap">
                            <div class="capacity-label"><span>20/30</span><span>Peserta</span></div>
                            <div class="capacity-bar"><div class="capacity-fill" style="width:67%"></div></div>
                        </div>
                    </div>
                </div>

                <div class="event-row" data-category="classmeet">
                    <img class="event-row-thumb" src="{{ asset('images/classmeeting.jpeg') }}" alt="Classmeeting">
                    <div class="event-row-info">
                        <div class="event-row-title">Classmeeting</div>
                        <div class="event-row-meta">
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                1–5 Sep 2026
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                07:30 — 15:00
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Lapangan
                            </span>
                        </div>
                    </div>
                    <div class="event-row-right">
                        <span class="status-tag status-soon">● Almost Full</span>
                        <div class="capacity-wrap">
                            <div class="capacity-label"><span>47/50</span><span>Peserta</span></div>
                            <div class="capacity-bar"><div class="capacity-fill full" style="width:94%"></div></div>
                        </div>
                    </div>
                </div>

                <div class="event-row" data-category="seminar">
                    <img class="event-row-thumb" src="{{ asset('images/seminar.png') }}" alt="Seminar Kewirausahaan">
                    <div class="event-row-info">
                        <div class="event-row-title">Seminar Kewirausahaan</div>
                        <div class="event-row-meta">
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                3 Sep 2026
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                10:00 — 12:00
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Avis
                            </span>
                        </div>
                    </div>
                    <div class="event-row-right">
                        <span class="status-tag status-open">● Open</span>
                        <div class="capacity-wrap">
                            <div class="capacity-label"><span>40/50</span><span>Peserta</span></div>
                            <div class="capacity-bar"><div class="capacity-fill" style="width:80%"></div></div>
                        </div>
                    </div>
                </div>

                <div class="event-row" data-category="sports">
                    <img class="event-row-thumb" src="{{ asset('images/basket.jpeg') }}" alt="Turnamen Basket">
                    <div class="event-row-info">
                        <div class="event-row-title">Turnamen Basket</div>
                        <div class="event-row-meta">
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                10 Sep 2026
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                08:00 — 16:00
                            </span>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Lapangan Basket
                            </span>
                        </div>
                    </div>
                    <div class="event-row-right">
                        <span class="status-tag status-open">● Open</span>
                        <div class="capacity-wrap">
                            <div class="capacity-label"><span>10/24</span><span>Peserta</span></div>
                            <div class="capacity-bar"><div class="capacity-fill" style="width:42%"></div></div>
                        </div>
                    </div>
                </div>

            </div>{{-- /event-list --}}
        </div>{{-- /events-section --}}

    </div>{{-- /eventy-left --}}

    {{-- ═══════════════════════════════════ RIGHT COLUMN ═══ --}}
    <div class="eventy-right">

        {{-- ── USER CARD ── --}}
        <div class="user-card">
            <div class="user-card-inner">
                <div class="user-avatar-wrap">
                    <div class="user-avatar-big">F</div>
                    <div>
                        <div class="user-name">Fathi</div>
                        <div class="user-email">fathi@smkn20jkt.sch.id</div>
                        <div class="user-class-badge">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            XI RPL 1
                        </div>
                    </div>
                </div>

                {{-- 2×2 stats --}}
                <div class="stats-grid-2x2">
                    <div class="mini-stat">
                        <div class="mini-stat-icon">🎯</div>
                        <div class="mini-stat-num">12</div>
                        <div class="mini-stat-label">Events Joined</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon">🏆</div>
                        <div class="mini-stat-num">8</div>
                        <div class="mini-stat-label">Certificates</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon">✅</div>
                        <div class="mini-stat-num">95%</div>
                        <div class="mini-stat-label">Attendance</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon">⭐</div>
                        <div class="mini-stat-num">1,450</div>
                        <div class="mini-stat-label">Points</div>
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
                    Register Event
                </a>
                <a href="{{ url('/user/certificates') }}" class="qa-btn">
                    <div class="qa-btn-icon qa-green">🏅</div>
                    Certificates
                </a>
                <a href="{{ url('/user/events') }}" class="qa-btn">
                    <div class="qa-btn-icon qa-purple">📅</div>
                    Event Calendar
                </a>
                <a href="{{ url('/user/events') }}" class="qa-btn">
                    <div class="qa-btn-icon qa-orange">📰</div>
                    Latest News
                </a>
            </div>
        </div>

        {{-- ── SCRAPBOOK QUOTE ── --}}
        <div class="scrapbook-note">
            <div class="scrapbook-note-text">
                "The best way to predict the future is to create it. Ikuti setiap event dan ukir prestasi terbaikmu!"
            </div>
            <div class="scrapbook-note-author">— OSIS SMKN 20 Jakarta ✏️</div>
        </div>

    </div>{{-- /eventy-right --}}

</div>{{-- /eventy-dashboard --}}
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Filter chips
    const chips = document.querySelectorAll('#filterChips .chip');
    const rows  = document.querySelectorAll('#eventList .event-row');

    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            chips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const filter = this.getAttribute('data-filter');
            rows.forEach(function (row) {
                const cat = row.getAttribute('data-category');
                row.style.display = (filter === 'all' || cat === filter) ? '' : 'none';
            });
        });
    });

    // ── Search
    const searchInput = document.getElementById('eventSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            rows.forEach(function (row) {
                const title = row.querySelector('.event-row-title').textContent.toLowerCase();
                row.style.display = title.includes(q) ? '' : 'none';
            });
            // Reset chips if typing
            if (q) {
                chips.forEach(c => c.classList.remove('active'));
            }
        });
    }

    // ── Click row → go to detail
    rows.forEach(function (row, i) {
        row.addEventListener('click', function () {
            const urls = [
                '/user/events/1',
                '/user/events/2',
                '/user/events/3',
                '/user/events/4',
                '/user/events/5',
            ];
            if (urls[i]) window.location.href = urls[i];
        });
    });
});
</script>
@endpush
