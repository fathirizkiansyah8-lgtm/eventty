<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event — Eventty</title>
    @vite([
        'resources/css/auth/landing.css',
        'resources/css/auth/event-public.css',
        'resources/js/auth/landing.js',
    ])
</head>
<body>

    <header class="landing-header" id="navbar">
        <div class="container navbar">
            <a href="/" class="brand">
                <span class="brand-mark">E</span>
                <span class="brand-text">Event<span>ty</span></span>
            </a>
            <nav class="nav-menu" id="navMenu">
                <a href="/" class="nav-link">Beranda</a>
                <a href="/#events" class="nav-link">Event</a>
                <a href="/#features" class="nav-link">Fitur</a>
                <a href="/#about" class="nav-link">Tentang</a>
            </nav>
            <div class="nav-actions">
                <a href="/login" class="btn btn-login">Masuk</a>
                <a href="/register" class="btn btn-primary">Daftar</a>
            </div>
            <button type="button" class="mobile-menu-button" id="mobileMenuButton" aria-label="Buka menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <main class="ep-main">

        <!-- Breadcrumb -->
        <div class="ep-breadcrumb-bar">
            <div class="container">
                <nav class="ep-breadcrumb">
                    <a href="/">Beranda</a>
                    <span>›</span>
                    <a href="/#events">Event</a>
                    <span>›</span>
                    <span id="bcName">Detail Event</span>
                </nav>
            </div>
        </div>

        <!-- Hero -->
        <div class="ep-hero" id="epHero">
            <div class="ep-hero-overlay"></div>
            <img id="epHeroImg" src="{{ asset('images/seminar.png') }}" alt="Event Banner" class="ep-hero-bg">
            <div class="container ep-hero-inner">
                <span class="ep-hero-badge seminar" id="epBadge">Seminar</span>
                <h1 class="ep-hero-title" id="epTitle">Seminar Digital</h1>
                <p class="ep-hero-sub" id="epSub">Transformasi digital dan peran teknologi dalam dunia kerja masa kini</p>
            </div>
        </div>

        <!-- Body -->
        <div class="container ep-body">
            <div class="ep-two-col">

                <!-- Main -->
                <div class="ep-main-col">

                    <!-- Status -->
                    <div class="ep-status-row">
                        <span class="ep-status-dot open" id="epStatusDot"></span>
                        <span class="ep-status-text open" id="epStatusText">Pendaftaran Dibuka</span>
                        <span class="ep-status-sep"></span>
                        <span class="ep-status-info" id="epStatusInfo">28 slot tersisa</span>
                    </div>

                    <!-- Info grid -->
                    <div class="ep-info-grid">
                        <div class="ep-info-tile">
                            <div class="ep-info-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                            <div class="ep-info-body"><span class="ep-info-lbl">Tanggal</span><span class="ep-info-val" id="epDate">10 September 2026</span></div>
                        </div>
                        <div class="ep-info-tile">
                            <div class="ep-info-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                            <div class="ep-info-body"><span class="ep-info-lbl">Waktu</span><span class="ep-info-val" id="epTime">08:00 – 12:00 WIB</span></div>
                        </div>
                        <div class="ep-info-tile">
                            <div class="ep-info-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                            <div class="ep-info-body"><span class="ep-info-lbl">Lokasi</span><span class="ep-info-val" id="epLocation">Aula Sekolah</span></div>
                        </div>
                        <div class="ep-info-tile">
                            <div class="ep-info-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                            <div class="ep-info-body"><span class="ep-info-lbl">Penyelenggara</span><span class="ep-info-val" id="epOrganizer">OSIS SMKN 20</span></div>
                        </div>
                        <div class="ep-info-tile">
                            <div class="ep-info-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                            <div class="ep-info-body"><span class="ep-info-lbl">Kuota</span><span class="ep-info-val" id="epQuota">100 peserta</span></div>
                        </div>
                        <div class="ep-info-tile">
                            <div class="ep-info-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg></div>
                            <div class="ep-info-body"><span class="ep-info-lbl">Sertifikat</span><span class="ep-info-val" id="epCert">Certificate of Participation</span></div>
                        </div>
                    </div>

                    <!-- Quota bar -->
                    <div class="ep-quota-card">
                        <div class="ep-quota-top">
                            <span class="ep-quota-label">Kapasitas Pendaftaran</span>
                            <span class="ep-quota-count" id="epQuotaCount">72 / 100 peserta</span>
                        </div>
                        <div class="ep-quota-track"><div class="ep-quota-fill" id="epQuotaFill" style="width:72%"></div></div>
                        <p class="ep-quota-note" id="epQuotaNotes">28 slot tersisa — Segera daftar sebelum penuh!</p>
                    </div>

                    <!-- Description -->
                    <div class="ep-section">
                        <h2 class="ep-section-h">Tentang Event</h2>
                        <div class="ep-prose" id="epDesc">
                            <p>Seminar Digital hadir untuk membekali siswa SMKN 20 Jakarta dengan pemahaman mendalam tentang transformasi digital yang sedang berlangsung di berbagai sektor industri.</p>
                            <p>Dalam era serba digital ini, kemampuan beradaptasi dengan teknologi bukan lagi pilihan—melainkan keharusan. Seminar ini menghadirkan para praktisi terkemuka yang siap berbagi pengalaman nyata menghadapi tantangan transformasi digital.</p>
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="ep-section">
                        <h2 class="ep-section-h">Persyaratan Peserta</h2>
                        <ul class="ep-req-list">
                            <li>Siswa aktif SMKN 20 Jakarta kelas X, XI, atau XII</li>
                            <li>Memiliki akun Eventty yang sudah terverifikasi</li>
                            <li>Mengisi formulir pendaftaran dengan lengkap dan benar</li>
                            <li>Bersedia hadir tepat waktu dan mengikuti seluruh rangkaian acara</li>
                            <li>Mengenakan seragam sekolah lengkap pada hari pelaksanaan</li>
                        </ul>
                    </div>

                    <!-- Agenda -->
                    <div class="ep-section">
                        <h2 class="ep-section-h">Agenda Acara</h2>
                        <div class="ep-agenda">
                            <div class="ep-agenda-item"><span class="ep-ag-time">08:00</span><span class="ep-ag-dot"></span><div class="ep-ag-detail"><strong>Registrasi &amp; Check-in</strong><span>Pengambilan name tag dan materials</span></div></div>
                            <div class="ep-agenda-item"><span class="ep-ag-time">08:30</span><span class="ep-ag-dot"></span><div class="ep-ag-detail"><strong>Opening &amp; Sambutan</strong><span>Kata sambutan dari Kepala Sekolah &amp; Ketua OSIS</span></div></div>
                            <div class="ep-agenda-item"><span class="ep-ag-time">09:00</span><span class="ep-ag-dot"></span><div class="ep-ag-detail"><strong>Sesi 1 — Transformasi Digital di Industri</strong><span>Pembicara: Rudi Hartono, Senior Engineer Google Indonesia</span></div></div>
                            <div class="ep-agenda-item"><span class="ep-ag-time">10:00</span><span class="ep-ag-dot"></span><div class="ep-ag-detail"><strong>Sesi 2 — Peluang Karir di Era Digital</strong><span>Pembicara: Sari Dewi, Product Manager Gojek</span></div></div>
                            <div class="ep-agenda-item"><span class="ep-ag-time">11:00</span><span class="ep-ag-dot"></span><div class="ep-ag-detail"><strong>Sesi Tanya Jawab</strong><span>Diskusi interaktif bersama para pembicara</span></div></div>
                            <div class="ep-agenda-item"><span class="ep-ag-time">11:45</span><span class="ep-ag-dot"></span><div class="ep-ag-detail"><strong>Penutupan &amp; Sertifikat</strong><span>Sertifikat digital tersedia di akun Eventty</span></div></div>
                        </div>
                    </div>

                    <!-- Info notice -->
                    <div class="ep-notice">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <div>
                            <strong>Informasi Sertifikat</strong>
                            <p>Setelah hadir dan absensi dikonfirmasi Admin, sertifikat digital otomatis tersedia di menu <strong>Certificates</strong> pada akun Eventty kamu.</p>
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="ep-side-col">

                    <!-- Register card -->
                    <div class="ep-reg-card">
                        <div class="ep-reg-head">
                            <h3>Daftar Event</h3>
                            <p>Ikuti event ini dan dapatkan sertifikat kehadiran digital.</p>
                        </div>
                        <div class="ep-reg-perks">
                            <div class="ep-perk"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg><span>Sertifikat Digital</span></div>
                            <div class="ep-perk"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg><span>Notifikasi Reminder</span></div>
                            <div class="ep-perk"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span>Gratis untuk Siswa</span></div>
                        </div>
                        <div class="ep-reg-cta">
                            <a href="/login" class="ep-btn-login">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                Login untuk Mendaftar
                            </a>
                            <p class="ep-reg-note">Belum punya akun? <a href="/register">Daftar gratis</a></p>
                        </div>
                    </div>

                    <!-- Poster -->
                    <div class="ep-poster-card">
                        <p class="ep-poster-lbl">Poster Event</p>
                        <img id="epPosterImg" src="{{ asset('images/seminar.png') }}" alt="Poster" class="ep-poster-img">
                    </div>

                    <!-- Related -->
                    <div class="ep-related-card">
                        <h3 class="ep-related-h">Event Lainnya</h3>
                        <div class="ep-related-list">
                            <a href="/events/public?id=2" class="ep-related-item">
                                <img src="{{ asset('images/careerday.jpeg') }}" alt="Career Day" class="ep-rel-thumb">
                                <div class="ep-rel-info"><span>Career Day 2026</span><small>15 September 2026</small></div>
                            </a>
                            <a href="/events/public?id=3" class="ep-related-item">
                                <img src="{{ asset('images/classmeeting.jpeg') }}" alt="Class Meeting" class="ep-rel-thumb">
                                <div class="ep-rel-info"><span>Class Meeting 2026</span><small>20 September 2026</small></div>
                            </a>
                            <a href="/events/public?id=4" class="ep-related-item">
                                <img src="{{ asset('images/workshop.png') }}" alt="Workshop" class="ep-rel-thumb">
                                <div class="ep-rel-info"><span>Workshop Programming</span><small>25 September 2026</small></div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container footer-container">
            <div class="footer-brand">
                <a href="/" class="brand footer-logo"><span class="brand-mark">E</span><span class="brand-text">Event<span>ty</span></span></a>
                <p>Platform manajemen event sekolah yang membantu siswa menemukan dan mengikuti berbagai kegiatan.</p>
            </div>
            <div class="footer-links">
                <div class="footer-column"><h4>Platform</h4><a href="/#features">Fitur</a><a href="/#how-it-works">Cara Kerja</a></div>
                <div class="footer-column"><h4>Akun</h4><a href="/login">Masuk</a><a href="/register">Daftar</a></div>
                <div class="footer-column"><h4>Eventty</h4><a href="/">Beranda</a><a href="/#events">Event</a></div>
            </div>
        </div>
        <div class="container footer-bottom">
            <span>© {{ date('Y') }} Eventty. All rights reserved.</span>
            <span>School Event Management System</span>
        </div>
    </footer>

    <script>
    var eventsData = {
        1: { title:'Seminar Digital', sub:'Transformasi digital dan peran teknologi dalam dunia kerja', cat:'seminar', catLabel:'Seminar', img:'{{ asset("images/seminar.png") }}', date:'10 September 2026', time:'08:00 – 12:00 WIB', location:'Aula Sekolah', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:72, cert:'Certificate of Participation', status:'open', statusLabel:'Pendaftaran Dibuka' },
        2: { title:'Career Day 2026', sub:'Temui profesional dari 30+ perusahaan dan eksplorasi peluang karir', cat:'career', catLabel:'Career', img:'{{ asset("images/careerday.jpeg") }}', date:'15 September 2026', time:'08:00 – 15:00 WIB', location:'Aula Sekolah', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:45, cert:'Certificate of Participation', status:'open', statusLabel:'Pendaftaran Dibuka' },
        3: { title:'Class Meeting 2026', sub:'Kompetisi antar kelas dalam berbagai cabang olahraga dan seni', cat:'competition', catLabel:'Kompetisi', img:'{{ asset("images/classmeeting.jpeg") }}', date:'20 September 2026', time:'07:30 – 17:00 WIB', location:'Lapangan Sekolah', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:60, cert:'Certificate of Achievement', status:'open', statusLabel:'Pendaftaran Dibuka' },
        4: { title:'Workshop Programming', sub:'Belajar web dan mobile development bersama mentor berpengalaman', cat:'workshop', catLabel:'Workshop', img:'{{ asset("images/workshop.png") }}', date:'25 September 2026', time:'09:00 – 15:00 WIB', location:'Lab RPL', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:30, cert:'Certificate of Completion', status:'soon', statusLabel:'Segera Dibuka' },
        5: { title:'Turnamen Basket', sub:'Kompetisi basket antar kelas, raih trofi dan sertifikat achievement', cat:'competition', catLabel:'Kompetisi', img:'{{ asset("images/basket.jpeg") }}', date:'10 Oktober 2026', time:'08:00 – 16:00 WIB', location:'Lapangan Basket', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:20, cert:'Certificate of Achievement', status:'open', statusLabel:'Pendaftaran Dibuka' },
        6: { title:'Seminar Kewirausahaan', sub:'Inspirasi bisnis dari pengusaha muda sukses', cat:'seminar', catLabel:'Seminar', img:'{{ asset("images/ilustrasi-logo.png") }}', date:'3 Oktober 2026', time:'10:00 – 12:00 WIB', location:'Aula Sekolah', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:15, cert:'Certificate of Participation', status:'soon', statusLabel:'Segera Dibuka' },
    };
    (function(){
        var p = new URLSearchParams(window.location.search);
        var id = parseInt(p.get('id')) || 1;
        var ev = eventsData[id] || eventsData[1];
        document.getElementById('bcName').textContent = ev.title;
        document.getElementById('epHeroImg').src = ev.img;
        document.getElementById('epPosterImg').src = ev.img;
        document.getElementById('epTitle').textContent = ev.title;
        document.getElementById('epSub').textContent = ev.sub;
        var badge = document.getElementById('epBadge');
        badge.textContent = ev.catLabel;
        badge.className = 'ep-hero-badge ' + ev.cat;
        document.getElementById('epDate').textContent = ev.date;
        document.getElementById('epTime').textContent = ev.time;
        document.getElementById('epLocation').textContent = ev.location;
        document.getElementById('epOrganizer').textContent = ev.organizer;
        document.getElementById('epQuota').textContent = ev.quota + ' peserta';
        document.getElementById('epCert').textContent = ev.cert;
        var pct = Math.round(ev.registered / ev.quota * 100);
        var rem = ev.quota - ev.registered;
        document.getElementById('epQuotaCount').textContent = ev.registered + ' / ' + ev.quota + ' peserta';
        document.getElementById('epQuotaFill').style.width = pct + '%';
        document.getElementById('epQuotaNotes').textContent = rem + ' slot tersisa — Segera daftar sebelum penuh!';
        document.getElementById('epStatusInfo').textContent = rem + ' slot tersisa';
        var dot = document.getElementById('epStatusDot');
        var txt = document.getElementById('epStatusText');
        dot.className = 'ep-status-dot ' + ev.status;
        txt.textContent = ev.statusLabel;
        txt.className = 'ep-status-text ' + ev.status;
        document.title = ev.title + ' — Eventty';
    })();
    </script>
</body>
</html>
