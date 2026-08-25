<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Eventy</title>

    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/components/header.css',
    ])

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ══════════════════════════════════════════
   ADMIN SIDEBAR
══════════════════════════════════════════ */
.admin-sidebar {
    background: #0f1f4e !important;
    border-right: none !important;
}
.admin-sidebar .sidebar-header {
    border-bottom: 1px solid rgba(255,255,255,0.1) !important;
}
.admin-sidebar .sidebar-brand {
    color: #fff !important;
    font-weight: 800;
}
.admin-sidebar .sidebar-sub {
    font-size:.62rem; color:rgba(255,255,255,.5); font-weight:500;
    letter-spacing:.03em; margin-top:-2px;
}
.admin-sidebar .sidebar-section-title {
    color: rgba(255,255,255,.4) !important;
    font-size:.65rem; letter-spacing:.08em;
}
.admin-sidebar .sidebar-link {
    color: rgba(255,255,255,.65) !important;
    border-radius:.75rem;
}
.admin-sidebar .sidebar-link:hover {
    background: rgba(255,255,255,.1) !important;
    color: #fff !important;
}
.admin-sidebar .sidebar-link.active {
    background: rgba(255,255,255,.15) !important;
    color: #fff !important;
}
.admin-sidebar .sidebar-link-icon svg { stroke: currentColor; }
.admin-sidebar .sidebar-quote {
    margin:.5rem .875rem .5rem;
    padding:.875rem 1rem;
    background:rgba(255,255,255,.07);
    border-radius:.875rem;
    font-size:.73rem; color:rgba(255,255,255,.6);
    font-style:italic; line-height:1.6;
}
.admin-sidebar .sidebar-copy {
    padding:0 .875rem .875rem;
    font-size:.62rem; color:rgba(255,255,255,.3); line-height:1.6;
}

/* Main content offset */
.admin-main { margin-left:260px; min-height:100vh; background:var(--bg-primary); }

/* ══ HEADER ══ */
.adm-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:.875rem 1.75rem; background:var(--bg-secondary);
    border-bottom:1px solid var(--border-color);
    position:sticky; top:0; z-index:50;
}
.adm-header-left { display:flex; flex-direction:column; }
.adm-greeting    { font-size:.75rem; color:var(--text-muted); font-weight:500; }
.adm-title       { font-size:1.05rem; font-weight:800; color:var(--text-primary); }
.adm-header-right{ display:flex; align-items:center; gap:.875rem; }
.adm-icon-btn {
    width:36px; height:36px; border-radius:50%; border:1.5px solid var(--border-color);
    background:var(--bg-secondary); display:flex; align-items:center; justify-content:center;
    cursor:pointer; color:var(--text-secondary); transition:all .15s; position:relative;
}
.adm-icon-btn:hover { border-color:#0f1f4e; color:#0f1f4e; }
.adm-notif-dot {
    position:absolute; top:-2px; right:-2px; width:10px; height:10px;
    background:#ef4444; border-radius:50%; border:2px solid var(--bg-secondary);
}
.adm-avatar {
    width:36px; height:36px; border-radius:50%;
    background:linear-gradient(135deg,#0f1f4e,#3b82f6);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:.875rem; font-weight:800; cursor:pointer;
    border:2px solid var(--border-color);
}
.adm-user-info { text-align:right; }
.adm-user-name { font-size:.825rem; font-weight:700; color:var(--text-primary); }
.adm-user-role { font-size:.7rem; color:var(--text-muted); }

/* ══ MAIN CONTENT ══ */
.adm-content { padding:1.5rem 1.75rem; font-family:'Plus Jakarta Sans','Inter',sans-serif; }

/* ══ STAT CARDS ══ */
.adm-stats {
    display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem;
}
.adm-stat {
    background:var(--bg-secondary); border:1.5px solid var(--border-color);
    border-radius:1.1rem; padding:1.1rem 1.25rem;
    display:flex; align-items:center; gap:1rem;
    transition:all .2s; cursor:default;
}
.adm-stat:hover { box-shadow:0 6px 20px rgba(15,31,78,.08); transform:translateY(-1px); }
.adm-stat-icon {
    width:48px; height:48px; border-radius:.875rem; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:1.3rem;
}
.si-blue   { background:#dbeafe; }
.si-green  { background:#dcfce7; }
.si-orange { background:#fef3c7; }
.si-purple { background:#ede9fe; }
.si-red    { background:#fee2e2; }
.adm-stat-body {}
.adm-stat-num  { font-size:1.6rem; font-weight:800; color:var(--text-primary); line-height:1; }
.adm-stat-lbl  { font-size:.78rem; font-weight:600; color:var(--text-muted); margin-top:.2rem; }
.adm-stat-sub  { font-size:.7rem; color:var(--text-muted); margin-top:.1rem; }
.adm-stat-up   { font-size:.68rem; font-weight:700; color:#16a34a; margin-top:.15rem; }

/* ══ 2-COL LAYOUT ══ */
.adm-grid { display:grid; grid-template-columns:1fr 320px; gap:1.5rem; }
.adm-left  { display:flex; flex-direction:column; gap:1.5rem; }
.adm-right { display:flex; flex-direction:column; gap:1.25rem; }

/* ══ SECTION HEADER ══ */
.adm-sec-header {
    display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;
}
.adm-sec-title { font-size:1rem; font-weight:800; color:var(--text-primary); }
.adm-sec-link  { font-size:.8rem; font-weight:600; color:#0f1f4e; text-decoration:none; }
.adm-sec-link:hover { text-decoration:underline; }

/* ══ HERO BANNER ══ */
.adm-hero {
    position:relative; background:linear-gradient(135deg,#0f1f4e 0%,#1a3a7c 55%,#1e4fc2 100%);
    border-radius:1.25rem; padding:1.75rem 2rem; overflow:hidden; min-height:160px;
    display:flex; align-items:center; box-shadow:0 8px 32px rgba(15,31,78,.2);
}
.adm-hero::after {
    content:''; position:absolute; bottom:-2px; left:0; right:0; height:16px;
    background:var(--bg-primary);
    clip-path:polygon(0% 100%,2% 40%,4% 80%,6% 20%,8% 60%,10% 10%,12% 70%,14% 30%,16% 80%,18% 15%,20% 65%,22% 25%,24% 75%,26% 10%,28% 55%,30% 20%,32% 70%,34% 35%,36% 85%,38% 15%,40% 60%,42% 20%,44% 75%,46% 30%,48% 70%,50% 10%,52% 60%,54% 25%,56% 80%,58% 15%,60% 65%,62% 30%,64% 75%,66% 20%,68% 65%,70% 15%,72% 70%,74% 25%,76% 80%,78% 10%,80% 55%,82% 20%,84% 70%,86% 35%,88% 75%,90% 15%,92% 60%,94% 25%,96% 70%,98% 30%,100% 55%,100% 100%);
}
.adm-hero::before {
    content:''; position:absolute; top:-60px; right:-60px; width:200px; height:200px;
    background:rgba(255,255,255,.05); border-radius:50%;
}
.adm-hero-content { position:relative; z-index:2; flex:1; }
.adm-hero-eyebrow {
    display:inline-flex; align-items:center; gap:.4rem;
    background:rgba(255,255,255,.15); color:#a5c8ff;
    font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em;
    padding:.25rem .75rem; border-radius:999px; margin-bottom:.75rem;
}
.adm-hero-title {
    font-size:1.5rem; font-weight:800; color:#fff; line-height:1.25; margin-bottom:.4rem;
}
.adm-hero-title span { color:#7dd3fc; }
.adm-hero-sub { font-size:.825rem; color:rgba(255,255,255,.65); margin-bottom:1.1rem; max-width:380px; }
.adm-hero-btn {
    display:inline-flex; align-items:center; gap:.5rem;
    background:#fff; color:#0f1f4e; font-weight:700; font-size:.825rem;
    padding:.5rem 1.25rem; border-radius:999px; text-decoration:none;
    box-shadow:0 4px 16px rgba(0,0,0,.2); transition:all .2s;
}
.adm-hero-btn:hover { transform:translateY(-2px); color:#0f1f4e; }
.adm-hero-badges {
    position:absolute; right:1.5rem; top:50%; transform:translateY(-50%);
    display:flex; flex-direction:column; gap:.6rem; z-index:2;
}
.adm-badge-pill {
    background:rgba(255,255,255,.15); backdrop-filter:blur(4px);
    border:1px solid rgba(255,255,255,.25); border-radius:.75rem;
    padding:.5rem .875rem; color:#fff; font-size:.75rem; font-weight:700;
    white-space:nowrap;
}
.adm-badge-pill span { opacity:.7; font-weight:400; margin-left:.35rem; }

/* ══ RECENT EVENTS TABLE ══ */
.adm-card {
    background:var(--bg-secondary); border:1.5px solid var(--border-color);
    border-radius:1.1rem; overflow:hidden;
}
.adm-card-header { padding:.875rem 1.25rem; border-bottom:1px solid var(--border-color); background:var(--bg-tertiary); }
.adm-table { width:100%; border-collapse:collapse; }
.adm-table th {
    padding:.625rem 1rem; font-size:.7rem; font-weight:800; text-transform:uppercase;
    letter-spacing:.05em; color:var(--text-muted); background:var(--bg-tertiary);
    border-bottom:1px solid var(--border-color); text-align:left;
}
.adm-table td {
    padding:.75rem 1rem; font-size:.825rem; color:var(--text-primary);
    border-bottom:1px solid var(--border-color); vertical-align:middle;
}
.adm-table tr:last-child td { border-bottom:none; }
.adm-table tr:hover td { background:var(--bg-primary); }

.ev-thumb {
    width:38px; height:32px; border-radius:.4rem; object-fit:cover;
    background:var(--bg-tertiary);
}
.ev-name { font-weight:700; font-size:.825rem; }
.ev-cat  { font-size:.7rem; color:var(--text-muted); }

.stag {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.18rem .65rem; border-radius:999px; font-size:.68rem; font-weight:700;
}
.stag-open     { background:#dcfce7; color:#15803d; }
.stag-ongoing  { background:#dbeafe; color:#1d4ed8; }
.stag-closed   { background:#fee2e2; color:#dc2626; }
.stag-full     { background:#fef3c7; color:#d97706; }

.prog-bar-wrap { width:90px; }
.prog-bar-track { height:5px; background:var(--bg-tertiary); border-radius:999px; overflow:hidden; }
.prog-bar-fill  { height:100%; border-radius:999px; background:linear-gradient(90deg,#3b82f6,#0f1f4e); }
.prog-bar-fill.warn { background:linear-gradient(90deg,#f59e0b,#ef4444); }
.prog-label { font-size:.65rem; color:var(--text-muted); margin-bottom:.2rem; font-weight:600; }

.tbl-action {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.25rem .65rem; border-radius:.4rem; font-size:.7rem; font-weight:700;
    border:1.5px solid var(--border-color); background:transparent; cursor:pointer;
    color:var(--text-secondary); transition:all .15s; text-decoration:none;
}
.tbl-action:hover { border-color:#0f1f4e; color:#0f1f4e; background:#f0f4ff; }

/* ══ ACTIVITY FEED ══ */
.activity-feed { display:flex; flex-direction:column; }
.activity-item {
    display:flex; gap:.875rem; align-items:flex-start;
    padding:.875rem 1.25rem; border-bottom:1px solid var(--border-color);
}
.activity-item:last-child { border-bottom:none; }
.activity-icon {
    width:36px; height:36px; border-radius:.625rem; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:1rem;
}
.activity-text { font-size:.8rem; font-weight:600; color:var(--text-primary); line-height:1.45; }
.activity-time { font-size:.7rem; color:var(--text-muted); margin-top:.15rem; }

/* ══ RIGHT PANEL ══ */
/* Admin summary card */
.adm-profile-card {
    background:linear-gradient(145deg,#0f1f4e 0%,#1a3a7c 100%);
    border-radius:1.25rem; padding:1.4rem; color:#fff;
    position:relative; overflow:hidden;
    box-shadow:0 8px 24px rgba(15,31,78,.2);
}
.adm-profile-card::before {
    content:''; position:absolute; top:-40px; right:-40px;
    width:120px; height:120px; background:rgba(255,255,255,.06); border-radius:50%;
}
.apc-inner { position:relative; z-index:2; }
.apc-avatar {
    width:54px; height:54px; border-radius:50%;
    background:linear-gradient(135deg,#60a5fa,#a78bfa);
    display:flex; align-items:center; justify-content:center;
    font-size:1.25rem; font-weight:800; color:#fff;
    border:2px solid rgba(255,255,255,.3); margin-bottom:.875rem;
}
.apc-name  { font-size:1rem; font-weight:800; color:#fff; }
.apc-email { font-size:.72rem; color:rgba(255,255,255,.6); margin-top:.1rem; }
.apc-role  {
    display:inline-flex; align-items:center; gap:.3rem;
    background:rgba(255,255,255,.15); color:#bfdbfe;
    font-size:.68rem; font-weight:700; padding:.2rem .6rem;
    border-radius:999px; margin-top:.5rem; letter-spacing:.02em;
}
.apc-stats { display:grid; grid-template-columns:1fr 1fr; gap:.6rem; margin-top:1rem; }
.apc-stat {
    background:rgba(255,255,255,.1); border-radius:.75rem; padding:.65rem;
    text-align:center; transition:background .2s;
}
.apc-stat:hover { background:rgba(255,255,255,.16); }
.apc-stat-num { font-size:1.3rem; font-weight:800; color:#fff; line-height:1; }
.apc-stat-lbl { font-size:.62rem; color:rgba(255,255,255,.6); font-weight:600; margin-top:.15rem; }
.apc-stat-icon { font-size:.9rem; margin-bottom:.2rem; }

/* Quick actions */
.adm-qa-card {
    background:var(--bg-secondary); border:1.5px solid var(--border-color);
    border-radius:1.1rem; padding:1.1rem;
}
.adm-qa-title { font-size:.875rem; font-weight:800; color:var(--text-primary); margin-bottom:.875rem; }
.adm-qa-grid  { display:grid; grid-template-columns:1fr 1fr; gap:.55rem; }
.adm-qa-btn {
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    gap:.35rem; padding:.75rem .5rem; border:1.5px solid var(--border-color);
    background:var(--bg-primary); border-radius:.875rem; text-decoration:none;
    color:var(--text-primary); font-size:.68rem; font-weight:700; text-align:center;
    cursor:pointer; transition:all .18s;
}
.adm-qa-btn:hover {
    border-color:#0f1f4e; background:#f0f4ff; color:#0f1f4e;
    transform:translateY(-2px); box-shadow:0 4px 12px rgba(15,31,78,.1);
}
.adm-qa-icon {
    width:34px; height:34px; border-radius:.55rem;
    display:flex; align-items:center; justify-content:center; font-size:1rem;
}

/* Pending task card */
.adm-tasks { display:flex; flex-direction:column; }
.adm-task-item {
    display:flex; align-items:center; gap:.75rem;
    padding:.75rem 1.1rem; border-bottom:1px solid var(--border-color);
    font-size:.8rem;
}
.adm-task-item:last-child { border-bottom:none; }
.adm-task-dot {
    width:8px; height:8px; border-radius:50%; flex-shrink:0;
}
.dot-red    { background:#ef4444; }
.dot-orange { background:#f59e0b; }
.dot-blue   { background:#3b82f6; }
.adm-task-text { flex:1; font-weight:600; color:var(--text-primary); line-height:1.4; }
.adm-task-badge {
    font-size:.65rem; font-weight:700; padding:.15rem .55rem; border-radius:999px;
    background:var(--bg-tertiary); color:var(--text-muted);
}

/* Chart area placeholder */
.adm-chart-card {
    background:var(--bg-secondary); border:1.5px solid var(--border-color);
    border-radius:1.1rem; overflow:hidden;
}
.adm-chart-body { padding:1.25rem; }
.adm-bar-chart { display:flex; align-items:flex-end; gap:.5rem; height:90px; margin-top:.75rem; }
.adm-bar-group { display:flex; flex-direction:column; align-items:center; gap:.3rem; flex:1; }
.adm-bar {
    width:100%; border-radius:.4rem .4rem 0 0;
    background:linear-gradient(180deg,#3b82f6,#0f1f4e);
    min-width:18px; transition:opacity .15s;
}
.adm-bar:hover { opacity:.8; }
.adm-bar-label { font-size:.62rem; color:var(--text-muted); font-weight:600; white-space:nowrap; }
</style>
</head>

<body>
<script>
(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();
</script>

<!-- Sidebar Toggle -->
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ══ ADMIN SIDEBAR ══ -->
<aside class="sidebar admin-sidebar" id="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Eventy Logo" class="sidebar-logo">
        <div>
            <div class="sidebar-brand">EVENTY</div>
            <div class="sidebar-sub">Admin Panel</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section">
            <div class="sidebar-section-title">Menu Utama</div>

            <a href="{{ url('/admin/dashboard') }}" class="sidebar-link active">
                <span class="sidebar-link-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg></span>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/admin/events') }}" class="sidebar-link">
                <span class="sidebar-link-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
                <span>Kelola Event</span>
            </a>

            <a href="{{ url('/admin/participants') }}" class="sidebar-link">
                <span class="sidebar-link-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                <span>Peserta</span>
            </a>

            <a href="{{ url('/admin/attendance') }}" class="sidebar-link">
                <span class="sidebar-link-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>
                <span>Kehadiran</span>
            </a>

            <a href="{{ url('/admin/certificates') }}" class="sidebar-link">
                <span class="sidebar-link-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg></span>
                <span>Sertifikat</span>
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Pengelolaan</div>

            <a href="{{ url('/admin/announcements') }}" class="sidebar-link">
                <span class="sidebar-link-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3z"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></span>
                <span>Pengumuman</span>
            </a>

            <a href="{{ url('/admin/students') }}" class="sidebar-link">
                <span class="sidebar-link-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></span>
                <span>Data Siswa</span>
            </a>

            <a href="{{ url('/admin/settings') }}" class="sidebar-link">
                <span class="sidebar-link-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span>
                <span>Pengaturan</span>
            </a>
        </div>
    </nav>

    <div class="admin-sidebar sidebar-quote">
        "Great events start with great management. Keep it organized."
    </div>
    <div class="admin-sidebar sidebar-copy">
        © 2025 EVENTY Admin<br>All rights reserved.
    </div>
</aside>

<!-- ══ MAIN ══ -->
<div class="admin-main">

    <!-- Header -->
    <header class="adm-header">
        <div class="adm-header-left">
            <span class="adm-greeting">Selamat datang kembali,</span>
            <span class="adm-title">Admin OSIS 👋</span>
        </div>
        <div class="adm-header-right">
            <!-- Notif bell -->
            <div class="adm-icon-btn" id="notificationBtn" style="position:relative;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="adm-notif-dot"></span>
            </div>
            <!-- User info -->
            <div class="adm-user-info">
                <div class="adm-user-name">Admin</div>
                <div class="adm-user-role">OSIS</div>
            </div>
            <div class="adm-avatar" id="profileBtn">A</div>

            <!-- Notification Dropdown -->
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="notification-header">
                    <span class="notification-title">Notifikasi</span>
                    <span class="notification-mark-all">Tandai semua dibaca</span>
                </div>
                <div class="notification-list">
                    <div class="notification-item unread"><div class="notification-content"><div class="notification-icon">📝</div><div class="notification-text"><div class="notification-message">Pendaftaran baru untuk Career Day</div><div class="notification-time">5 menit yang lalu</div></div></div></div>
                    <div class="notification-item unread"><div class="notification-content"><div class="notification-icon">⚠️</div><div class="notification-text"><div class="notification-message">Kuota Workshop hampir penuh</div><div class="notification-time">30 menit yang lalu</div></div></div></div>
                    <div class="notification-item"><div class="notification-content"><div class="notification-icon">✅</div><div class="notification-text"><div class="notification-message">Event Seminar berhasil dibuat</div><div class="notification-time">1 jam yang lalu</div></div></div></div>
                </div>
                <div class="notification-footer"><span class="notification-view-all">Lihat semua notifikasi</span></div>
            </div>

            <!-- Profile Dropdown -->
            <div class="profile-dropdown" id="profileDropdown">
                <a href="{{ url('/admin/settings') }}" class="profile-dropdown-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    <span>Pengaturan</span>
                </a>
                <div class="profile-dropdown-divider"></div>
                <button type="button" id="headerLogoutBtn" class="profile-dropdown-item danger" style="display:flex;align-items:center;gap:.75rem;width:100%;border:none;background:none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Keluar</span>
                </button>
            </div>
        </div>
    </header>

    <!-- ══ DASHBOARD CONTENT ══ -->
    <div class="adm-content">

        <!-- STAT CARDS -->
        <div class="adm-stats">
            <div class="adm-stat">
                <div class="adm-stat-icon si-blue">🎉</div>
                <div class="adm-stat-body">
                    <div class="adm-stat-num">24</div>
                    <div class="adm-stat-lbl">Total Event</div>
                    <div class="adm-stat-up">↑ 4 bulan ini</div>
                </div>
            </div>
            <div class="adm-stat">
                <div class="adm-stat-icon si-green">🟢</div>
                <div class="adm-stat-body">
                    <div class="adm-stat-num">8</div>
                    <div class="adm-stat-lbl">Event Aktif</div>
                    <div class="adm-stat-sub">Sedang berjalan</div>
                </div>
            </div>
            <div class="adm-stat">
                <div class="adm-stat-icon si-orange">👥</div>
                <div class="adm-stat-body">
                    <div class="adm-stat-num">342</div>
                    <div class="adm-stat-lbl">Total Peserta</div>
                    <div class="adm-stat-up">↑ 28 minggu ini</div>
                </div>
            </div>
            <div class="adm-stat">
                <div class="adm-stat-icon si-purple">✅</div>
                <div class="adm-stat-body">
                    <div class="adm-stat-num">16</div>
                    <div class="adm-stat-lbl">Event Selesai</div>
                    <div class="adm-stat-sub">Dari 24 total</div>
                </div>
            </div>
        </div>

        <!-- 2-COL GRID -->
        <div class="adm-grid">

            <!-- LEFT -->
            <div class="adm-left">

                <!-- HERO BANNER -->
                <div class="adm-hero">
                    <div class="adm-hero-content">
                        <div class="adm-hero-eyebrow">⚡ Highlight Event</div>
                        <h2 class="adm-hero-title">Classmeeting 2026 <span>Sedang Berjalan!</span></h2>
                        <p class="adm-hero-sub">47 dari 50 kuota terisi. Pantau pendaftaran dan kehadiran secara real-time.</p>
                        <a href="{{ url('/admin/events') }}" class="adm-hero-btn">
                            Kelola Event
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                    <div class="adm-hero-badges">
                        <div class="adm-badge-pill">🎯 47/50 Peserta<span>Almost Full</span></div>
                        <div class="adm-badge-pill">📅 1–5 Sep 2026<span>5 hari</span></div>
                        <div class="adm-badge-pill">📍 Lapangan<span>Outdoor</span></div>
                    </div>
                </div>

                <!-- RECENT EVENTS TABLE -->
                <div class="adm-card">
                    <div class="adm-card-header">
                        <div class="adm-sec-header" style="margin-bottom:0;">
                            <span class="adm-sec-title">Event Terbaru</span>
                            <a href="{{ url('/admin/events') }}" class="adm-sec-link">Lihat Semua →</a>
                        </div>
                    </div>
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Peserta</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.75rem;">
                                        <img class="ev-thumb" src="{{ asset('images/careerday.jpeg') }}" alt="">
                                        <div><div class="ev-name">Career Day</div><div class="ev-cat">School Event</div></div>
                                    </div>
                                </td>
                                <td>20 Aug 2026</td>
                                <td><span class="stag stag-open">● Open</span></td>
                                <td>
                                    <div class="prog-bar-wrap">
                                        <div class="prog-label">45/50</div>
                                        <div class="prog-bar-track"><div class="prog-bar-fill warn" style="width:90%"></div></div>
                                    </div>
                                </td>
                                <td><a href="{{ url('/admin/events') }}" class="tbl-action">Kelola</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.75rem;">
                                        <img class="ev-thumb" src="{{ asset('images/workshop.png') }}" alt="">
                                        <div><div class="ev-name">Workshop Programming</div><div class="ev-cat">Workshop</div></div>
                                    </div>
                                </td>
                                <td>25 Aug 2026</td>
                                <td><span class="stag stag-open">● Open</span></td>
                                <td>
                                    <div class="prog-bar-wrap">
                                        <div class="prog-label">20/30</div>
                                        <div class="prog-bar-track"><div class="prog-bar-fill" style="width:67%"></div></div>
                                    </div>
                                </td>
                                <td><a href="{{ url('/admin/events') }}" class="tbl-action">Kelola</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.75rem;">
                                        <img class="ev-thumb" src="{{ asset('images/classmeeting.jpeg') }}" alt="">
                                        <div><div class="ev-name">Classmeeting</div><div class="ev-cat">Competition</div></div>
                                    </div>
                                </td>
                                <td>1–5 Sep 2026</td>
                                <td><span class="stag stag-ongoing">● Ongoing</span></td>
                                <td>
                                    <div class="prog-bar-wrap">
                                        <div class="prog-label">47/50</div>
                                        <div class="prog-bar-track"><div class="prog-bar-fill warn" style="width:94%"></div></div>
                                    </div>
                                </td>
                                <td><a href="{{ url('/admin/events') }}" class="tbl-action">Kelola</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.75rem;">
                                        <img class="ev-thumb" src="{{ asset('images/seminar.png') }}" alt="">
                                        <div><div class="ev-name">Seminar Kewirausahaan</div><div class="ev-cat">Seminar</div></div>
                                    </div>
                                </td>
                                <td>3 Sep 2026</td>
                                <td><span class="stag stag-open">● Open</span></td>
                                <td>
                                    <div class="prog-bar-wrap">
                                        <div class="prog-label">40/50</div>
                                        <div class="prog-bar-track"><div class="prog-bar-fill" style="width:80%"></div></div>
                                    </div>
                                </td>
                                <td><a href="{{ url('/admin/events') }}" class="tbl-action">Kelola</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.75rem;">
                                        <img class="ev-thumb" src="{{ asset('images/basket.jpeg') }}" alt="">
                                        <div><div class="ev-name">Turnamen Basket</div><div class="ev-cat">Sports</div></div>
                                    </div>
                                </td>
                                <td>10 Sep 2026</td>
                                <td><span class="stag stag-open">● Open</span></td>
                                <td>
                                    <div class="prog-bar-wrap">
                                        <div class="prog-label">10/24</div>
                                        <div class="prog-bar-track"><div class="prog-bar-fill" style="width:42%"></div></div>
                                    </div>
                                </td>
                                <td><a href="{{ url('/admin/events') }}" class="tbl-action">Kelola</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- CHARTS ROW: Bar + Donut -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                    <!-- Bar Chart -->
                    <div class="adm-chart-card">
                        <div class="adm-card-header">
                            <span class="adm-sec-title">Pendaftar (7 Hari Terakhir)</span>
                        </div>
                        <div class="adm-chart-body">
                            <div class="adm-bar-chart" id="barChart" style="height:110px;"></div>
                        </div>
                    </div>

                    <!-- Donut Chart: Event Status -->
                    <div class="adm-chart-card">
                        <div class="adm-card-header">
                            <span class="adm-sec-title">Status Event</span>
                        </div>
                        <div class="adm-chart-body" style="display:flex;align-items:center;gap:1.25rem;">
                            <div style="position:relative;flex-shrink:0;">
                                <svg width="110" height="110" viewBox="0 0 110 110">
                                    <!-- Background circle -->
                                    <circle cx="55" cy="55" r="42" fill="none" stroke="var(--bg-tertiary)" stroke-width="14"/>
                                    <!-- Selesai (67%) green -->
                                    <circle cx="55" cy="55" r="42" fill="none" stroke="#10b981" stroke-width="14"
                                        stroke-dasharray="176.9 87.6" stroke-dashoffset="0"
                                        stroke-linecap="round" transform="rotate(-90 55 55)"/>
                                    <!-- Aktif (33%) blue -->
                                    <circle cx="55" cy="55" r="42" fill="none" stroke="#3b82f6" stroke-width="14"
                                        stroke-dasharray="87.6 176.9" stroke-dashoffset="-176.9"
                                        stroke-linecap="round" transform="rotate(-90 55 55)"/>
                                    <text x="55" y="51" text-anchor="middle" font-size="14" font-weight="800" fill="var(--text-primary)">24</text>
                                    <text x="55" y="65" text-anchor="middle" font-size="8" fill="var(--text-muted)">Total</text>
                                </svg>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.6rem;">
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div style="width:10px;height:10px;border-radius:50%;background:#10b981;flex-shrink:0;"></div>
                                    <span style="font-size:.75rem;color:var(--text-secondary);font-weight:600;">Selesai</span>
                                    <span style="font-size:.875rem;font-weight:800;color:var(--text-primary);margin-left:auto;">16</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div style="width:10px;height:10px;border-radius:50%;background:#3b82f6;flex-shrink:0;"></div>
                                    <span style="font-size:.75rem;color:var(--text-secondary);font-weight:600;">Aktif</span>
                                    <span style="font-size:.875rem;font-weight:800;color:var(--text-primary);margin-left:auto;">8</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div style="width:10px;height:10px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></div>
                                    <span style="font-size:.75rem;color:var(--text-secondary);font-weight:600;">Draft</span>
                                    <span style="font-size:.875rem;font-weight:800;color:var(--text-primary);margin-left:auto;">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Donut Row 2: Kehadiran + Kategori -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                    <!-- Donut: Attendance rate -->
                    <div class="adm-chart-card">
                        <div class="adm-card-header">
                            <span class="adm-sec-title">Tingkat Kehadiran</span>
                        </div>
                        <div class="adm-chart-body" style="display:flex;align-items:center;gap:1.25rem;">
                            <div style="position:relative;flex-shrink:0;">
                                <svg width="110" height="110" viewBox="0 0 110 110">
                                    <circle cx="55" cy="55" r="42" fill="none" stroke="var(--bg-tertiary)" stroke-width="14"/>
                                    <!-- Hadir 75% -->
                                    <circle cx="55" cy="55" r="42" fill="none" stroke="#10b981" stroke-width="14"
                                        stroke-dasharray="197.9 65.97" stroke-dashoffset="0"
                                        stroke-linecap="round" transform="rotate(-90 55 55)"/>
                                    <!-- Tidak Hadir 15% -->
                                    <circle cx="55" cy="55" r="42" fill="none" stroke="#ef4444" stroke-width="14"
                                        stroke-dasharray="39.59 224.3" stroke-dashoffset="-197.9"
                                        stroke-linecap="round" transform="rotate(-90 55 55)"/>
                                    <!-- Belum Dicek 10% -->
                                    <circle cx="55" cy="55" r="42" fill="none" stroke="#f59e0b" stroke-width="14"
                                        stroke-dasharray="26.39 237.5" stroke-dashoffset="-237.5"
                                        stroke-linecap="round" transform="rotate(-90 55 55)"/>
                                    <text x="55" y="51" text-anchor="middle" font-size="14" font-weight="800" fill="var(--text-primary)">95%</text>
                                    <text x="55" y="65" text-anchor="middle" font-size="8" fill="var(--text-muted)">Hadir</text>
                                </svg>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.6rem;">
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div style="width:10px;height:10px;border-radius:50%;background:#10b981;flex-shrink:0;"></div>
                                    <span style="font-size:.75rem;color:var(--text-secondary);font-weight:600;">Hadir</span>
                                    <span style="font-size:.875rem;font-weight:800;color:var(--text-primary);margin-left:auto;">75%</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div style="width:10px;height:10px;border-radius:50%;background:#ef4444;flex-shrink:0;"></div>
                                    <span style="font-size:.75rem;color:var(--text-secondary);font-weight:600;">Tidak Hadir</span>
                                    <span style="font-size:.875rem;font-weight:800;color:var(--text-primary);margin-left:auto;">15%</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div style="width:10px;height:10px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></div>
                                    <span style="font-size:.75rem;color:var(--text-secondary);font-weight:600;">Belum Dicek</span>
                                    <span style="font-size:.875rem;font-weight:800;color:var(--text-primary);margin-left:auto;">10%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Horizontal bar: Kategori event -->
                    <div class="adm-chart-card">
                        <div class="adm-card-header">
                            <span class="adm-sec-title">Event per Kategori</span>
                        </div>
                        <div class="adm-chart-body" style="display:flex;flex-direction:column;gap:.6rem;">
                            @php
                            $cats = [
                                ['Competition', 8, '#0f1f4e', '33%'],
                                ['Workshop',    6, '#3b82f6', '25%'],
                                ['Seminar',     5, '#10b981', '21%'],
                                ['Sports',      3, '#f59e0b', '13%'],
                                ['Career',      2, '#a78bfa', '8%'],
                            ];
                            @endphp
                            @foreach($cats as $cat)
                            <div>
                                <div style="display:flex;justify-content:space-between;font-size:.72rem;font-weight:600;color:var(--text-secondary);margin-bottom:.2rem;">
                                    <span>{{ $cat[0] }}</span><span>{{ $cat[1] }}</span>
                                </div>
                                <div style="height:7px;background:var(--bg-tertiary);border-radius:999px;overflow:hidden;">
                                    <div style="height:100%;width:{{ $cat[3] }};background:{{ $cat[2] }};border-radius:999px;transition:width .6s ease;"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>{{-- /adm-left --}}

            <!-- RIGHT -->
            <div class="adm-right">

                <!-- Admin profile card -->
                <div class="adm-profile-card">
                    <div class="apc-inner">
                        <div class="apc-avatar">A</div>
                        <div class="apc-name">Admin OSIS</div>
                        <div class="apc-email">admin@smkn20jkt.sch.id</div>
                        <div class="apc-role">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            Super Admin · OSIS
                        </div>
                        <div class="apc-stats">
                            <div class="apc-stat">
                                <div class="apc-stat-icon">🎉</div>
                                <div class="apc-stat-num">24</div>
                                <div class="apc-stat-lbl">Total Event</div>
                            </div>
                            <div class="apc-stat">
                                <div class="apc-stat-icon">👥</div>
                                <div class="apc-stat-num">342</div>
                                <div class="apc-stat-lbl">Peserta</div>
                            </div>
                            <div class="apc-stat">
                                <div class="apc-stat-icon">🏆</div>
                                <div class="apc-stat-num">98</div>
                                <div class="apc-stat-lbl">Sertifikat</div>
                            </div>
                            <div class="apc-stat">
                                <div class="apc-stat-icon">📊</div>
                                <div class="apc-stat-num">95%</div>
                                <div class="apc-stat-lbl">Attendance</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick actions -->
                <div class="adm-qa-card">
                    <div class="adm-qa-title">Quick Actions</div>
                    <div class="adm-qa-grid">
                        <a href="{{ url('/admin/events/create') }}" class="adm-qa-btn">
                            <div class="adm-qa-icon" style="background:#dbeafe;">➕</div>
                            Buat Event
                        </a>
                        <a href="{{ url('/admin/participants') }}" class="adm-qa-btn">
                            <div class="adm-qa-icon" style="background:#dcfce7;">👥</div>
                            Peserta
                        </a>
                        <a href="{{ url('/admin/attendance') }}" class="adm-qa-btn">
                            <div class="adm-qa-icon" style="background:#fef3c7;">✅</div>
                            Kehadiran
                        </a>
                        <a href="{{ url('/admin/announcements') }}" class="adm-qa-btn">
                            <div class="adm-qa-icon" style="background:#ede9fe;">📢</div>
                            Pengumuman
                        </a>
                        <a href="{{ url('/admin/certificates') }}" class="adm-qa-btn">
                            <div class="adm-qa-icon" style="background:#fee2e2;">🏅</div>
                            Sertifikat
                        </a>
                        <a href="{{ url('/admin/students') }}" class="adm-qa-btn">
                            <div class="adm-qa-icon" style="background:#f0fdf4;">🎓</div>
                            Data Siswa
                        </a>
                    </div>
                </div>

                <!-- Pending tasks -->
                <div class="adm-card">
                    <div class="adm-card-header">
                        <span class="adm-sec-title" style="font-size:.875rem;">⚡ Perlu Perhatian</span>
                    </div>
                    <div class="adm-tasks">
                        <div class="adm-task-item">
                            <div class="adm-task-dot dot-red"></div>
                            <div class="adm-task-text">Classmeeting hampir penuh (47/50)</div>
                            <span class="adm-task-badge">Urgent</span>
                        </div>
                        <div class="adm-task-item">
                            <div class="adm-task-dot dot-orange"></div>
                            <div class="adm-task-text">Career Day — 5 hari lagi</div>
                            <span class="adm-task-badge">Soon</span>
                        </div>
                        <div class="adm-task-item">
                            <div class="adm-task-dot dot-blue"></div>
                            <div class="adm-task-text">28 sertifikat belum diterbitkan</div>
                            <span class="adm-task-badge">Pending</span>
                        </div>
                        <div class="adm-task-item">
                            <div class="adm-task-dot dot-orange"></div>
                            <div class="adm-task-text">Absensi Workshop belum dikunci</div>
                            <span class="adm-task-badge">Review</span>
                        </div>
                        <div class="adm-task-item">
                            <div class="adm-task-dot dot-blue"></div>
                            <div class="adm-task-text">3 pengumuman baru menunggu review</div>
                            <span class="adm-task-badge">Pending</span>
                        </div>
                    </div>
                </div>

                <!-- Activity feed -->
                <div class="adm-card">
                    <div class="adm-card-header">
                        <span class="adm-sec-title" style="font-size:.875rem;">🕐 Aktivitas Terbaru</span>
                    </div>
                    <div class="activity-feed">
                        <div class="activity-item">
                            <div class="activity-icon si-green">📝</div>
                            <div><div class="activity-text">Ahmad Rizki mendaftar Career Day</div><div class="activity-time">2 menit lalu</div></div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon si-blue">🎉</div>
                            <div><div class="activity-text">Event Turnamen Basket dibuat</div><div class="activity-time">1 jam lalu</div></div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon si-orange">✅</div>
                            <div><div class="activity-text">Absensi Seminar dikonfirmasi (40 hadir)</div><div class="activity-time">3 jam lalu</div></div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon si-purple">🏅</div>
                            <div><div class="activity-text">12 sertifikat Workshop diterbitkan</div><div class="activity-time">Kemarin</div></div>
                        </div>
                    </div>
                </div>

            </div>{{-- /adm-right --}}
        </div>{{-- /adm-grid --}}
    </div>{{-- /adm-content --}}

</div>{{-- /admin-main --}}

<!-- Logout Modal -->
<div class="modal-overlay" id="logoutModal" role="dialog" aria-modal="true">
    <div class="logout-modal">
        <div class="logout-modal-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div>
        <div class="modal-header"><h3 class="modal-title">Konfirmasi Keluar</h3></div>
        <div class="modal-body"><p>Apakah Anda yakin ingin keluar dari Dashboard Admin?</p></div>
        <div class="modal-footer logout-modal-actions">
            <button type="button" class="btn-logout-cancel" id="cancelLogoutBtn">Batal</button>
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout-confirm">Ya, Keluar</button>
            </form>
        </div>
    </div>
</div>

@vite(['resources/js/components/sidebar.js', 'resources/js/components/header.js'])

<script>
// Bar chart
(function(){
    const data = [
        {day:'Sen', val:42}, {day:'Sel', val:78}, {day:'Rab', val:55},
        {day:'Kam', val:91}, {day:'Jum', val:67}, {day:'Sab', val:48}, {day:'Min', val:33}
    ];
    const max = Math.max(...data.map(d=>d.val));
    const chart = document.getElementById('barChart');
    if(!chart) return;
    data.forEach(function(d){
        const pct = (d.val/max*100).toFixed(0);
        chart.innerHTML += `
            <div class="adm-bar-group">
                <div class="adm-bar" style="height:${pct}%;" title="${d.val} pendaftar"></div>
                <div class="adm-bar-label">${d.day}</div>
            </div>`;
    });
})();
</script>

</body>
</html>
