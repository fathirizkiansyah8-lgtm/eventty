<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventty — Platform Event Sekolah Modern</title>
    <meta name="description" content="Temukan berbagai event sekolah, daftar dengan mudah, pantau kehadiran, dan dapatkan sertifikat digital bersama Eventty.">
    @vite([
        'resources/css/auth/landing.css',
        'resources/js/auth/landing.js',
    ])
</head>
<body>

{{-- ═══════════════════════════════
     NAVBAR
════════════════════════════════ --}}
<header class="lp-nav" id="navbar">
    <div class="lp-container lp-nav-inner">

        <a href="/" class="lp-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Eventty Logo" class="lp-brand-img">
            <span class="lp-brand-name">Event<strong>ty</strong></span>
        </a>

        <nav class="lp-nav-links" id="navMenu">
            <a href="/" class="lp-nav-link active" id="nl-home">Home</a>
            <a href="/events/public?id=1" class="lp-nav-link" id="nl-events" data-require-login="true" data-redirect="/events/public?id=1">Events</a>
            <a href="/login" class="lp-nav-link" id="nl-features">Fitur</a>
            <a href="/login" class="lp-nav-link" id="nl-how">Cara Kerja</a>
            <a href="/login" class="lp-nav-link" id="nl-about">Tentang</a>
        </nav>

        <div class="lp-nav-actions">
            <a href="/login"    class="lp-btn-ghost">Login</a>
            <a href="/register" class="lp-btn-primary">Daftar Sekarang</a>
        </div>

        <button class="lp-hamburger" id="mobileMenuButton" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>

    </div>
</header>


{{-- ═══════════════════════════════
     HERO
════════════════════════════════ --}}
<section class="lp-hero" id="home">
    <div class="lp-container lp-hero-inner">

        {{-- LEFT --}}
        <div class="lp-hero-copy reveal">

            <div class="lp-hero-eyebrow">
                <span class="lp-eyebrow-dot"></span>
                Platform Event Sekolah
            </div>

            <h1 class="lp-hero-h1">
                Event Sekolah,<br>
                <span class="lp-hero-accent">Lebih Mudah</span> Diikuti.
            </h1>

            <p class="lp-hero-sub">
                Temukan berbagai event sekolah, daftar dengan mudah, pantau
                kehadiran, dan dapatkan sertifikat digital setelah hadir.
            </p>

            <div class="lp-hero-btns">
                <a href="/events/public?id=1" class="lp-btn-primary lp-btn-lg" data-require-login="true" data-redirect="/events/public?id=1">
                    Lihat Event
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="/register" class="lp-btn-outline lp-btn-lg">Daftar Sekarang</a>
            </div>

            <div class="lp-hero-trust">
                <div class="lp-trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Gratis untuk siswa</span>
                </div>
                <div class="lp-trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Sertifikat digital</span>
                </div>
                <div class="lp-trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Absensi terdata</span>
                </div>
            </div>

        </div>

        {{-- RIGHT — Product Mockup --}}
        <div class="lp-hero-visual reveal">

            {{-- Background glow --}}
            <div class="lp-visual-glow"></div>

            {{-- ═══ BROWSER MOCKUP (main screen) ═══ --}}
            <div class="lp-browser">
                {{-- Browser chrome bar --}}
                <div class="lp-browser-chrome">
                    <div class="lp-chrome-dots">
                        <span class="lp-dot r"></span>
                        <span class="lp-dot y"></span>
                        <span class="lp-dot g"></span>
                    </div>
                    <div class="lp-chrome-url">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        eventty.sch.id/dashboard
                    </div>
                    <div style="width:44px;"></div>
                </div>

                {{-- Dashboard inside browser --}}
                <div class="lp-browser-content">

                    {{-- Sidebar --}}
                    <div class="lp-mini-sidebar">
                        <div class="lp-mini-logo">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Eventty" style="width:100%;height:100%;object-fit:cover;border-radius:5px;">
                        </div>
                        <div class="lp-mini-nav">
                            <div class="lp-mini-nav-item active">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                                <span>Dashboard</span>
                            </div>
                            <div class="lp-mini-nav-item">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <span>Events</span>
                            </div>
                            <div class="lp-mini-nav-item">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                                <span>Sertifikat</span>
                            </div>
                            <div class="lp-mini-nav-item">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                <span>Messages</span>
                            </div>
                        </div>
                    </div>

                    {{-- Main area --}}
                    <div class="lp-mini-main">
                        {{-- Top bar --}}
                        <div class="lp-mini-topbar">
                            <div>
                                <div class="lp-mini-greet">Selamat datang,</div>
                                <div class="lp-mini-name">Fathi Rizkiansyah 👋</div>
                            </div>
                            <div class="lp-mini-avatar">F</div>
                        </div>

                        {{-- Stats --}}
                        <div class="lp-mini-stats">
                            <div class="lp-ms blue">
                                <div class="lp-ms-n">8</div>
                                <div class="lp-ms-l">Event Aktif</div>
                            </div>
                            <div class="lp-ms purple">
                                <div class="lp-ms-n">4</div>
                                <div class="lp-ms-l">Event Saya</div>
                            </div>
                            <div class="lp-ms green">
                                <div class="lp-ms-n">2</div>
                                <div class="lp-ms-l">Sertifikat</div>
                            </div>
                        </div>

                        {{-- Events --}}
                        <div class="lp-mini-section-title">Event Mendatang</div>

                        <div class="lp-mini-ev">
                            <div class="lp-mini-ev-bar blue"></div>
                            <img src="{{ asset('images/careerday.jpeg') }}" class="lp-mini-ev-thumb" alt="">
                            <div class="lp-mini-ev-info">
                                <div class="lp-mini-ev-name">Career Day 2026</div>
                                <div class="lp-mini-ev-meta">20 Agu · Aula Sekolah</div>
                            </div>
                            <span class="lp-mini-badge open">Buka</span>
                        </div>

                        <div class="lp-mini-ev">
                            <div class="lp-mini-ev-bar orange"></div>
                            <img src="{{ asset('images/classmeeting.jpeg') }}" class="lp-mini-ev-thumb" alt="">
                            <div class="lp-mini-ev-info">
                                <div class="lp-mini-ev-name">Classmeeting 2026</div>
                                <div class="lp-mini-ev-meta">1–5 Sep · Lapangan</div>
                            </div>
                            <span class="lp-mini-badge hot">47/50</span>
                        </div>

                        <div class="lp-mini-ev">
                            <div class="lp-mini-ev-bar green"></div>
                            <img src="{{ asset('images/workshop.png') }}" class="lp-mini-ev-thumb" alt="">
                            <div class="lp-mini-ev-info">
                                <div class="lp-mini-ev-name">Workshop Programming</div>
                                <div class="lp-mini-ev-meta">25 Agu · Lab RPL</div>
                            </div>
                            <span class="lp-mini-badge open">Buka</span>
                        </div>

                    </div>{{-- /mini-main --}}
                </div>{{-- /browser-content --}}
            </div>{{-- /browser --}}

            {{-- ═══ LAPTOP KEDUA (angled, behind) ═══ --}}
            <div class="lp-laptop2">
                <div class="lp-laptop2-screen">
                    {{-- Event detail page mockup --}}
                    <div class="lp-l2-topbar">
                        <div class="lp-chrome-dots" style="gap:3px;">
                            <span class="lp-dot r" style="width:7px;height:7px;"></span>
                            <span class="lp-dot y" style="width:7px;height:7px;"></span>
                            <span class="lp-dot g" style="width:7px;height:7px;"></span>
                        </div>
                        <div class="lp-l2-url">
                            <svg width="7" height="7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            eventty.sch.id/events
                        </div>
                    </div>
                    <div class="lp-l2-body">
                        {{-- Event grid --}}
                        <div class="lp-l2-header">
                            <div class="lp-l2-title">Event Mendatang</div>
                            <div class="lp-l2-viewall">Lihat Semua →</div>
                        </div>
                        <div class="lp-l2-cards">
                            <div class="lp-l2-card">
                                <div class="lp-l2-card-img" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                                    <span style="font-size:8px;font-weight:800;color:#fff;text-align:center;padding:4px;">CAREER DAY</span>
                                </div>
                                <div class="lp-l2-card-body">
                                    <div class="lp-l2-card-cat career">Career</div>
                                    <div class="lp-l2-card-name">Career Day 2026</div>
                                    <div class="lp-l2-card-date">20 Agu 2026</div>
                                    <div class="lp-l2-card-bar"><div style="width:90%;background:#ef4444;"></div></div>
                                </div>
                            </div>
                            <div class="lp-l2-card">
                                <div class="lp-l2-card-img" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);">
                                    <span style="font-size:8px;font-weight:800;color:#fff;text-align:center;padding:4px;">WORKSHOP</span>
                                </div>
                                <div class="lp-l2-card-body">
                                    <div class="lp-l2-card-cat workshop">Workshop</div>
                                    <div class="lp-l2-card-name">Workshop Programming</div>
                                    <div class="lp-l2-card-date">25 Agu 2026</div>
                                    <div class="lp-l2-card-bar"><div style="width:67%;background:#2563eb;"></div></div>
                                </div>
                            </div>
                            <div class="lp-l2-card">
                                <div class="lp-l2-card-img" style="background:linear-gradient(135deg,#0f172a,#1e3a8a);">
                                    <span style="font-size:8px;font-weight:800;color:#fff;text-align:center;padding:4px;">CLASSMEET</span>
                                </div>
                                <div class="lp-l2-card-body">
                                    <div class="lp-l2-card-cat competition">Kompetisi</div>
                                    <div class="lp-l2-card-name">Classmeeting 2026</div>
                                    <div class="lp-l2-card-date">1–5 Sep 2026</div>
                                    <div class="lp-l2-card-bar"><div style="width:94%;background:#ef4444;"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-laptop2-base">
                    <div class="lp-laptop2-hinge"></div>
                </div>
            </div>

            {{-- Floating badges --}}
            <div class="lp-float-badge lp-float-1">
                <div class="lp-float-icon green">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div>
                    <div class="lp-float-title">Terdaftar!</div>
                    <div class="lp-float-sub">Career Day 2026</div>
                </div>
            </div>

            <div class="lp-float-badge lp-float-2">
                <div class="lp-float-icon blue">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
                <div>
                    <div class="lp-float-title">Sertifikat</div>
                    <div class="lp-float-sub">Siap diunduh</div>
                </div>
            </div>

        </div>{{-- /lp-hero-visual --}}

    </div>
</section>


{{-- ═══════════════════════════════
     EVENT SEDANG BERLANGSUNG
════════════════════════════════ --}}
<section class="lp-section lp-events-section" id="events">
    <div class="lp-container">

        <div class="lp-section-hd">
            <div class="reveal">
                <div class="lp-section-eyebrow">EVENT SEDANG BERLANGSUNG</div>
                <h2 class="lp-section-h2">Temukan event yang cocok <span>untukmu</span></h2>
            </div>
            <a href="/login" class="lp-link-arrow reveal">
                Lihat Semua Event
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        <div class="lp-events-grid">

            {{-- Card 1 --}}
            <article class="lp-ev-card reveal">
                <div class="lp-ev-img">
                    <img src="{{ asset('images/careerday.jpeg') }}" alt="Career Day" loading="lazy">
                    <span class="lp-ev-badge open">Buka</span>
                    <span class="lp-ev-cat career">Career</span>
                </div>
                <div class="lp-ev-body">
                    <h3 class="lp-ev-title">Career Day 2026</h3>
                    <div class="lp-ev-meta">
                        <span class="lp-ev-meta-item">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            20 Agustus 2026
                        </span>
                        <span class="lp-ev-meta-item">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Aula Sekolah
                        </span>
                    </div>
                    <div class="lp-ev-quota">
                        <div class="lp-quota-bar">
                            <div style="width:90%"></div>
                        </div>
                        <span class="lp-quota-text">45 / 50 peserta</span>
                    </div>
                    <a href="{{ url('/events/public?id=1') }}" class="lp-ev-btn" data-require-login="true" data-redirect="{{ url('/events/public?id=1') }}">Lihat Detail</a>
                </div>
            </article>

            {{-- Card 2 --}}
            <article class="lp-ev-card reveal">
                <div class="lp-ev-img">
                    <img src="{{ asset('images/workshop.png') }}" alt="Workshop" loading="lazy">
                    <span class="lp-ev-badge open">Buka</span>
                    <span class="lp-ev-cat workshop">Workshop</span>
                </div>
                <div class="lp-ev-body">
                    <h3 class="lp-ev-title">Workshop Programming</h3>
                    <div class="lp-ev-meta">
                        <span class="lp-ev-meta-item">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            25 Agustus 2026
                        </span>
                        <span class="lp-ev-meta-item">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Lab RPL
                        </span>
                    </div>
                    <div class="lp-ev-quota">
                        <div class="lp-quota-bar">
                            <div style="width:67%"></div>
                        </div>
                        <span class="lp-quota-text">20 / 30 peserta</span>
                    </div>
                    <a href="{{ url('/events/public?id=4') }}" class="lp-ev-btn" data-require-login="true" data-redirect="{{ url('/events/public?id=4') }}">Lihat Detail</a>
                </div>
            </article>

            {{-- Card 3 --}}
            <article class="lp-ev-card reveal">
                <div class="lp-ev-img">
                    <img src="{{ asset('images/classmeeting.jpeg') }}" alt="Classmeeting" loading="lazy">
                    <span class="lp-ev-badge hot">Hampir Penuh</span>
                    <span class="lp-ev-cat competition">Kompetisi</span>
                </div>
                <div class="lp-ev-body">
                    <h3 class="lp-ev-title">Classmeeting 2026</h3>
                    <div class="lp-ev-meta">
                        <span class="lp-ev-meta-item">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            1–5 September 2026
                        </span>
                        <span class="lp-ev-meta-item">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Lapangan Sekolah
                        </span>
                    </div>
                    <div class="lp-ev-quota">
                        <div class="lp-quota-bar warn">
                            <div style="width:94%"></div>
                        </div>
                        <span class="lp-quota-text">47 / 50 peserta</span>
                    </div>
                    <a href="{{ url('/events/public?id=3') }}" class="lp-ev-btn" data-require-login="true" data-redirect="{{ url('/events/public?id=3') }}">Lihat Detail</a>
                </div>
            </article>

            {{-- Card 4 --}}
            <article class="lp-ev-card reveal">
                <div class="lp-ev-img">
                    <img src="{{ asset('images/seminar.png') }}" alt="Seminar" loading="lazy">
                    <span class="lp-ev-badge open">Buka</span>
                    <span class="lp-ev-cat seminar">Seminar</span>
                </div>
                <div class="lp-ev-body">
                    <h3 class="lp-ev-title">Seminar Kewirausahaan</h3>
                    <div class="lp-ev-meta">
                        <span class="lp-ev-meta-item">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            3 September 2026
                        </span>
                        <span class="lp-ev-meta-item">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Aula Sekolah
                        </span>
                    </div>
                    <div class="lp-ev-quota">
                        <div class="lp-quota-bar">
                            <div style="width:80%"></div>
                        </div>
                        <span class="lp-quota-text">40 / 50 peserta</span>
                    </div>
                    <a href="{{ url('/events/public?id=6') }}" class="lp-ev-btn" data-require-login="true" data-redirect="{{ url('/events/public?id=6') }}">Lihat Detail</a>
                </div>
            </article>

        </div>
    </div>
</section>


{{-- ═══════════════════════════════
     STATISTICS
════════════════════════════════ --}}
<section class="lp-stats-strip">
    <div class="lp-container">
        <div class="lp-stats-inner">

            <div class="lp-stat-item reveal">
                <div class="lp-stat-icon-wrap navy">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div>
                    <div class="lp-stat-num">24+</div>
                    <div class="lp-stat-label">Total Event</div>
                </div>
            </div>

            <div class="lp-stat-sep"></div>

            <div class="lp-stat-item reveal">
                <div class="lp-stat-icon-wrap blue">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <div class="lp-stat-num">342+</div>
                    <div class="lp-stat-label">Total Peserta</div>
                </div>
            </div>

            <div class="lp-stat-sep"></div>

            <div class="lp-stat-item reveal">
                <div class="lp-stat-icon-wrap green">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
                <div>
                    <div class="lp-stat-num">98+</div>
                    <div class="lp-stat-label">Sertifikat</div>
                </div>
            </div>

            <div class="lp-stat-sep"></div>

            <div class="lp-stat-item reveal">
                <div class="lp-stat-icon-wrap orange">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <div class="lp-stat-num">95%</div>
                    <div class="lp-stat-label">Attendance</div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ═══════════════════════════════
     KENAPA EVENTTY
════════════════════════════════ --}}
<section class="lp-section lp-features-section" id="features">
    <div class="lp-container">

        <div class="lp-section-center reveal">
            <div class="lp-section-eyebrow">KENAPA EVENTTY?</div>
            <h2 class="lp-section-h2">Semua kebutuhan event sekolah <span>dalam satu platform.</span></h2>
            <p class="lp-section-sub">Eventty dirancang untuk membantu siswa dan admin OSIS mengelola kegiatan sekolah secara lebih terstruktur dan efisien.</p>
        </div>

        <div class="lp-features-grid">

            <div class="lp-feat-card reveal">
                <div class="lp-feat-icon-wrap navy">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <h3 class="lp-feat-title">Kelola Event</h3>
                <p class="lp-feat-desc">Buat, kelola, dan pantau semua event sekolah dari satu dashboard admin yang mudah digunakan.</p>
                <a href="/register" class="lp-feat-link">Mulai Kelola <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>

            <div class="lp-feat-card reveal">
                <div class="lp-feat-icon-wrap blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><polyline points="9 15 12 18 15 15"/></svg>
                </div>
                <h3 class="lp-feat-title">Pendaftaran Mudah</h3>
                <p class="lp-feat-desc">Daftar event hanya dalam beberapa langkah. Sistem kuota per jurusan yang adil dan transparan.</p>
                <a href="/register" class="lp-feat-link">Coba Daftar <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>

            <div class="lp-feat-card reveal">
                <div class="lp-feat-icon-wrap green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <h3 class="lp-feat-title">Kehadiran Terdata</h3>
                <p class="lp-feat-desc">Absensi digital yang akurat dan terorganisir. Admin bisa mengkonfirmasi kehadiran secara real-time.</p>
                <a href="/register" class="lp-feat-link">Lihat Fitur <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>

            <div class="lp-feat-card reveal">
                <div class="lp-feat-icon-wrap orange">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
                <h3 class="lp-feat-title">Sertifikat Digital</h3>
                <p class="lp-feat-desc">Sertifikat otomatis diterbitkan bagi peserta yang memenuhi syarat kehadiran. Tersimpan di akunmu.</p>
                <a href="/register" class="lp-feat-link">Lihat Contoh <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>

        </div>

    </div>
</section>


{{-- ═══════════════════════════════
     HOW IT WORKS
════════════════════════════════ --}}
<section class="lp-section lp-how-section" id="how-it-works">
    <div class="lp-container">

        <div class="lp-section-center reveal">
            <div class="lp-section-eyebrow">CARA KERJA EVENTTY</div>
            <h2 class="lp-section-h2">Mulai dalam <span>empat langkah</span> sederhana</h2>
        </div>

        <div class="lp-steps">

            <div class="lp-step reveal">
                <div class="lp-step-num">01</div>
                <div class="lp-step-icon-wrap">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <h3 class="lp-step-title">Pilih Event</h3>
                <p class="lp-step-desc">Temukan event yang menarik dari berbagai kategori.</p>
            </div>

            <div class="lp-step-arrow reveal">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>

            <div class="lp-step reveal">
                <div class="lp-step-num">02</div>
                <div class="lp-step-icon-wrap">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                </div>
                <h3 class="lp-step-title">Daftar Event</h3>
                <p class="lp-step-desc">Isi formulir pendaftaran dengan cepat dan mudah.</p>
            </div>

            <div class="lp-step-arrow reveal">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>

            <div class="lp-step reveal">
                <div class="lp-step-num">03</div>
                <div class="lp-step-icon-wrap">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <h3 class="lp-step-title">Hadir di Event</h3>
                <p class="lp-step-desc">Ikuti kegiatan dan admin mencatat kehadiranmu.</p>
            </div>

            <div class="lp-step-arrow reveal">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>

            <div class="lp-step reveal">
                <div class="lp-step-num">04</div>
                <div class="lp-step-icon-wrap gold">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
                <h3 class="lp-step-title">Dapatkan Sertifikat</h3>
                <p class="lp-step-desc">Sertifikat digital otomatis tersedia di akunmu.</p>
            </div>

        </div>

    </div>
</section>


{{-- ═══════════════════════════════
     CERTIFICATE SHOWCASE
════════════════════════════════ --}}
<section class="lp-section lp-cert-section" id="about">
    <div class="lp-container lp-cert-inner">

        {{-- LEFT --}}
        <div class="lp-cert-copy reveal">
            <div class="lp-section-eyebrow">SERTIFIKAT DIGITAL EVENTTY</div>
            <h2 class="lp-section-h2" style="max-width:420px;">Bukti nyata partisipasimu dalam setiap <span>event sekolah.</span></h2>
            <p class="lp-cert-desc">Dapatkan sertifikat digital resmi setelah mengikuti event dan memenuhi syarat kehadiran. Tersimpan permanen di akunmu.</p>

            <ul class="lp-cert-benefits">
                <li>
                    <span class="lp-benefit-check">✓</span>
                    Tersimpan permanen di akun Eventty
                </li>
                <li>
                    <span class="lp-benefit-check">✓</span>
                    Dilengkapi QR Code verifikasi
                </li>
                <li>
                    <span class="lp-benefit-check">✓</span>
                    Bisa diunduh kapan saja dalam format PDF
                </li>
                <li>
                    <span class="lp-benefit-check">✓</span>
                    Tersedia untuk event umum maupun kompetisi
                </li>
            </ul>

            <a href="/register" class="lp-btn-primary lp-btn-lg" style="display:inline-flex;margin-top:.25rem;">
                Lihat Contoh Sertifikat
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        {{-- RIGHT — Certificate mockup --}}
        <div class="lp-cert-visual reveal">
            <div class="lp-cert-card-mockup">

                <div class="lp-cert-header-bar">
                    <div class="lp-cert-logo">E</div>
                    <div>
                        <div class="lp-cert-platform">EVENTTY</div>
                        <div class="lp-cert-school">SMKN 20 Jakarta</div>
                    </div>
                </div>

                <div class="lp-cert-body">
                    <div class="lp-cert-label-sm">SERTIFIKAT</div>
                    <div class="lp-cert-type">of Participation</div>
                    <div class="lp-cert-divider"></div>
                    <div class="lp-cert-given-to">Diberikan kepada</div>
                    <div class="lp-cert-name">Fathi Rizkiansyah</div>
                    <div class="lp-cert-for">Atas partisipasinya dalam event</div>
                    <div class="lp-cert-event-name">Career Day 2026</div>
                    <div class="lp-cert-date">20 Agustus 2026 · Aula Sekolah</div>
                </div>

                <div class="lp-cert-footer-bar">
                    <div class="lp-cert-sign">
                        <div class="lp-cert-sign-line"></div>
                        <div class="lp-cert-sign-name">Ketua OSIS</div>
                        <div class="lp-cert-sign-title">SMKN 20 Jakarta</div>
                    </div>
                    <div class="lp-cert-qr">
                        <div class="lp-cert-qr-box">
                            <svg width="36" height="36" viewBox="0 0 100 100" fill="none">
                                <rect x="10" y="10" width="30" height="30" rx="4" fill="#10265c" opacity=".15"/>
                                <rect x="14" y="14" width="22" height="22" rx="2" fill="#10265c" opacity=".25"/>
                                <rect x="18" y="18" width="14" height="14" rx="1" fill="#10265c"/>
                                <rect x="60" y="10" width="30" height="30" rx="4" fill="#10265c" opacity=".15"/>
                                <rect x="64" y="14" width="22" height="22" rx="2" fill="#10265c" opacity=".25"/>
                                <rect x="68" y="18" width="14" height="14" rx="1" fill="#10265c"/>
                                <rect x="10" y="60" width="30" height="30" rx="4" fill="#10265c" opacity=".15"/>
                                <rect x="14" y="64" width="22" height="22" rx="2" fill="#10265c" opacity=".25"/>
                                <rect x="18" y="68" width="14" height="14" rx="1" fill="#10265c"/>
                                <rect x="60" y="60" width="8" height="8" rx="1" fill="#10265c"/>
                                <rect x="72" y="60" width="8" height="8" rx="1" fill="#10265c"/>
                                <rect x="60" y="72" width="8" height="8" rx="1" fill="#10265c"/>
                                <rect x="72" y="72" width="8" height="8" rx="1" fill="#10265c"/>
                                <rect x="45" y="10" width="8" height="8" rx="1" fill="#10265c" opacity=".5"/>
                                <rect x="45" y="25" width="8" height="8" rx="1" fill="#10265c" opacity=".5"/>
                                <rect x="10" y="45" width="8" height="8" rx="1" fill="#10265c" opacity=".5"/>
                                <rect x="25" y="45" width="8" height="8" rx="1" fill="#10265c" opacity=".5"/>
                            </svg>
                        </div>
                        <div class="lp-cert-cert-id">EVT/2026/CD/000045</div>
                    </div>
                </div>

            </div>

            {{-- Glow effect --}}
            <div class="lp-cert-glow"></div>
        </div>

    </div>
</section>


{{-- ═══════════════════════════════
     CTA
════════════════════════════════ --}}
<section class="lp-cta-section">
    <div class="lp-container lp-cta-inner">

        <div class="lp-cta-illus">
            <div class="lp-cta-circle c1"></div>
            <div class="lp-cta-circle c2"></div>
            <div class="lp-cta-people">
                <div class="lp-person p1">
                    <div class="lp-person-head"></div>
                    <div class="lp-person-body"></div>
                </div>
                <div class="lp-person p2">
                    <div class="lp-person-head"></div>
                    <div class="lp-person-body"></div>
                </div>
                <div class="lp-person p3">
                    <div class="lp-person-head"></div>
                    <div class="lp-person-body"></div>
                </div>
            </div>
        </div>

        <div class="lp-cta-copy reveal">
            <h2 class="lp-cta-h2">Ada event yang ingin kamu ikuti?</h2>
            <p class="lp-cta-sub">Temukan event sekolahmu dan mulai berpartisipasi bersama Eventty. Gratis untuk semua siswa.</p>
            <div class="lp-cta-btns">
                <a href="#events"   class="lp-btn-white lp-btn-lg">
                    Lihat Semua Event
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="/register" class="lp-btn-ghost-white lp-btn-lg">Daftar Gratis</a>
            </div>
        </div>

    </div>
</section>


{{-- ═══════════════════════════════
     FOOTER
════════════════════════════════ --}}
<footer class="lp-footer">
    <div class="lp-container lp-footer-top">

        <div class="lp-footer-brand">
            <a href="/" class="lp-brand" style="margin-bottom:.875rem;display:inline-flex;">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Eventty" class="lp-brand-img" style="filter:brightness(0) invert(1);">
                <span class="lp-brand-name" style="color:#ffffff;">Event<strong>ty</strong></span>
            </a>
            <p class="lp-footer-tagline">Platform manajemen event sekolah untuk pengalaman kegiatan yang lebih mudah, teratur, dan bermakna.</p>
        </div>

        <div class="lp-footer-cols">

            <div class="lp-footer-col">
                <h4>Menu</h4>
                <a href="#home">Home</a>
                <a href="#events">Events</a>
                <a href="#features">Fitur</a>
                <a href="#about">Tentang</a>
            </div>

            <div class="lp-footer-col">
                <h4>Untuk Siswa</h4>
                <a href="/register">Cara Daftar</a>
                <a href="/login">Event Saya</a>
                <a href="/login">Sertifikat</a>
                <a href="/login">Notifikasi</a>
            </div>

            <div class="lp-footer-col">
                <h4>Untuk Admin</h4>
                <a href="/login">Dashboard</a>
                <a href="/login">Kelola Event</a>
                <a href="/login">Peserta</a>
                <a href="/login">Kehadiran</a>
            </div>

            <div class="lp-footer-col">
                <h4>Hubungi Kami</h4>
                <a href="#">admin@eventty.sch.id</a>
                <a href="#">SMKN 20 Jakarta</a>
                <a href="#">Jl. Raya Sekolah No. 1</a>
            </div>

        </div>

    </div>

    <div class="lp-container lp-footer-bottom">
        <span>© {{ date('Y') }} Eventty. All rights reserved.</span>
        <span>School Event Management System</span>
    </div>

</footer>

</body>
</html>
