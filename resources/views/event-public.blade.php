<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">Detail Event — Eventty</title>
    @vite([
        'resources/css/auth/event-public.css',
    ])
</head>
<body>

{{-- ═══ NAVBAR ═══ --}}
<header class="epnav" id="epNavbar">
    <div class="epnav-inner">

        <a href="/" class="epnav-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Eventty" class="epnav-logo">
            <span class="epnav-name">Event<strong>ty</strong></span>
        </a>

        <nav class="epnav-links">
            <a href="/" class="epnav-link">Beranda</a>
            <a href="/#events" class="epnav-link">Events</a>
            <a href="/#features" class="epnav-link">Fitur</a>
            <a href="/#about" class="epnav-link">Tentang</a>
        </nav>

        <div class="epnav-actions">
            <a href="/login"    class="epnav-btn-ghost">Login</a>
            <a href="/register" class="epnav-btn-primary">Daftar Sekarang</a>
        </div>

    </div>
</header>

{{-- ═══ BACK BAR ═══ --}}
<div class="ep-back-bar">
    <div class="ep-back-inner">
        <a href="/" class="ep-back-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Beranda
        </a>
        <div class="ep-breadcrumb">
            <a href="/">Beranda</a>
            <span>›</span>
            <a href="/#events">Event</a>
            <span>›</span>
            <span id="bcName">Detail Event</span>
        </div>
    </div>
</div>

{{-- ═══ HERO BANNER ═══ --}}
<div class="ep-hero" id="epHero">
    <div class="ep-hero-overlay"></div>
    <img id="epHeroImg" src="{{ asset('images/seminar.png') }}" alt="Event" class="ep-hero-bg">
    <div class="ep-hero-content">
        <span class="ep-hero-badge seminar" id="epBadge">Seminar</span>
        <h1 class="ep-hero-title" id="epTitle">Seminar Digital</h1>
        <p class="ep-hero-sub" id="epSub">Transformasi digital dan peran teknologi dalam dunia kerja masa kini</p>
        <div class="ep-hero-meta">
            <span class="ep-hero-meta-item" id="epHeroDate">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                10 September 2026
            </span>
            <span class="ep-hero-meta-item" id="epHeroLoc">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Aula Sekolah
            </span>
        </div>
    </div>
</div>

{{-- ═══ MAIN BODY ═══ --}}
<div class="ep-body">
    <div class="ep-container">
        <div class="ep-layout">

            {{-- ── LEFT COLUMN ── --}}
            <div class="ep-main-col">

                {{-- Status row --}}
                <div class="ep-status-row">
                    <div class="ep-status-left">
                        <span class="ep-status-dot open" id="epStatusDot"></span>
                        <span class="ep-status-text" id="epStatusText">Pendaftaran Dibuka</span>
                    </div>
                    <span class="ep-status-right" id="epStatusInfo">28 slot tersisa</span>
                </div>

                {{-- Info grid --}}
                <div class="ep-info-grid">
                    <div class="ep-info-card">
                        <div class="ep-info-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div><div class="ep-info-label">Tanggal</div><div class="ep-info-value" id="infoDate">10 September 2026</div></div>
                    </div>
                    <div class="ep-info-card">
                        <div class="ep-info-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div><div class="ep-info-label">Waktu</div><div class="ep-info-value" id="infoTime">08:00 – 12:00 WIB</div></div>
                    </div>
                    <div class="ep-info-card">
                        <div class="ep-info-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div><div class="ep-info-label">Lokasi</div><div class="ep-info-value" id="infoLocation">Aula Sekolah</div></div>
                    </div>
                    <div class="ep-info-card">
                        <div class="ep-info-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>
                        </div>
                        <div><div class="ep-info-label">Penyelenggara</div><div class="ep-info-value" id="infoOrganizer">OSIS SMKN 20</div></div>
                    </div>
                    <div class="ep-info-card">
                        <div class="ep-info-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div><div class="ep-info-label">Kuota</div><div class="ep-info-value" id="infoQuota">100 peserta</div></div>
                    </div>
                    <div class="ep-info-card">
                        <div class="ep-info-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                        </div>
                        <div><div class="ep-info-label">Sertifikat</div><div class="ep-info-value" id="infoCert">Certificate of Participation</div></div>
                    </div>
                </div>

                {{-- Quota bar --}}
                <div class="ep-quota-card">
                    <div class="ep-quota-hd">
                        <span class="ep-quota-label">Kapasitas Pendaftaran</span>
                        <span class="ep-quota-count" id="quotaCount">72 / 100 peserta</span>
                    </div>
                    <div class="ep-quota-track"><div class="ep-quota-fill" id="quotaFill" style="width:72%"></div></div>
                    <p class="ep-quota-note" id="quotaNote">28 slot tersisa — Daftar sebelum penuh!</p>
                </div>

                {{-- About --}}
                <div class="ep-section">
                    <h2 class="ep-section-title">Tentang Event</h2>
                    <div class="ep-prose" id="epDesc">
                        <p>Seminar Digital hadir untuk membekali siswa SMKN 20 Jakarta dengan pemahaman mendalam tentang transformasi digital yang sedang berlangsung di berbagai sektor industri.</p>
                        <p>Dalam era serba digital ini, kemampuan beradaptasi dengan teknologi bukan lagi pilihan—melainkan keharusan. Seminar ini menghadirkan para praktisi industri terkemuka yang siap berbagi pengalaman nyata dalam menghadapi tantangan transformasi digital.</p>
                    </div>
                </div>

                {{-- Requirements --}}
                <div class="ep-section">
                    <h2 class="ep-section-title">Persyaratan Peserta</h2>
                    <ul class="ep-req-list">
                        <li>Siswa aktif SMKN 20 Jakarta kelas X, XI, atau XII</li>
                        <li>Memiliki akun Eventty yang sudah terverifikasi</li>
                        <li>Mengisi formulir pendaftaran dengan lengkap dan benar</li>
                        <li>Bersedia hadir tepat waktu dan mengikuti seluruh rangkaian acara</li>
                        <li>Mengenakan seragam sekolah lengkap pada hari pelaksanaan</li>
                    </ul>
                </div>

                {{-- Agenda --}}
                <div class="ep-section">
                    <h2 class="ep-section-title">Agenda Acara</h2>
                    <div class="ep-agenda">
                        <div class="ep-agenda-row"><div class="ep-agenda-time">08:00</div><div class="ep-agenda-dot"></div><div class="ep-agenda-detail"><strong>Registrasi &amp; Check-in</strong><span>Pengambilan name tag dan materials</span></div></div>
                        <div class="ep-agenda-row"><div class="ep-agenda-time">08:30</div><div class="ep-agenda-dot"></div><div class="ep-agenda-detail"><strong>Opening &amp; Sambutan</strong><span>Kata sambutan dari Kepala Sekolah &amp; Ketua OSIS</span></div></div>
                        <div class="ep-agenda-row"><div class="ep-agenda-time">09:00</div><div class="ep-agenda-dot"></div><div class="ep-agenda-detail"><strong>Sesi 1 — Transformasi Digital di Industri</strong><span>Pembicara: Rudi Hartono, Senior Engineer Google Indonesia</span></div></div>
                        <div class="ep-agenda-row"><div class="ep-agenda-time">10:00</div><div class="ep-agenda-dot"></div><div class="ep-agenda-detail"><strong>Sesi 2 — Peluang Karir di Era Digital</strong><span>Pembicara: Sari Dewi, Product Manager Gojek</span></div></div>
                        <div class="ep-agenda-row"><div class="ep-agenda-time">11:00</div><div class="ep-agenda-dot"></div><div class="ep-agenda-detail"><strong>Sesi Tanya Jawab</strong><span>Diskusi interaktif bersama pembicara</span></div></div>
                        <div class="ep-agenda-row"><div class="ep-agenda-time">11:45</div><div class="ep-agenda-dot"></div><div class="ep-agenda-detail"><strong>Penutupan &amp; Foto Bersama</strong><span>Sertifikat tersedia di akun Eventty</span></div></div>
                    </div>
                </div>

                {{-- Notice --}}
                <div class="ep-notice">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        <strong>Informasi Sertifikat</strong>
                        <p>Setelah hadir dan absensi dikonfirmasi Admin, sertifikat digital otomatis tersedia di menu <strong>Certificates</strong> pada akun Eventty kamu.</p>
                    </div>
                </div>

            </div>{{-- /main-col --}}

            {{-- ── RIGHT SIDEBAR ── --}}
            <div class="ep-side-col">

                {{-- Register card --}}
                <div class="ep-reg-card" id="regCard">
                    <div class="ep-reg-head">
                        <h3>Daftar Event</h3>
                        <p>Ikuti event ini dan dapatkan sertifikat kehadiran digital.</p>
                    </div>
                    <div class="ep-reg-perks">
                        <div class="ep-perk">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                            Sertifikat Digital
                        </div>
                        <div class="ep-perk">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22.92 17z"/></svg>
                            Notifikasi Reminder
                        </div>
                        <div class="ep-perk">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Gratis untuk Siswa
                        </div>
                    </div>
                    <div class="ep-reg-cta">
                        <a href="/login" class="ep-btn-register">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Login untuk Mendaftar
                        </a>
                        <p class="ep-reg-note">Belum punya akun? <a href="/register">Daftar gratis</a></p>
                    </div>
                </div>

                {{-- Related events --}}
                <div class="ep-related-card">
                    <h3 class="ep-related-title">Event Lainnya</h3>
                    <div class="ep-related-list">
                        <a href="/events/public?id=2" class="ep-related-item">
                            <img src="{{ asset('images/careerday.jpeg') }}" alt="Career Day" class="ep-rel-thumb">
                            <div><span class="ep-rel-name">Career Day 2026</span><small>15 September 2026</small></div>
                        </a>
                        <a href="/events/public?id=3" class="ep-related-item">
                            <img src="{{ asset('images/classmeeting.jpeg') }}" alt="Classmeeting" class="ep-rel-thumb">
                            <div><span class="ep-rel-name">Classmeeting 2026</span><small>1–5 September 2026</small></div>
                        </a>
                        <a href="/events/public?id=4" class="ep-related-item">
                            <img src="{{ asset('images/workshop.png') }}" alt="Workshop" class="ep-rel-thumb">
                            <div><span class="ep-rel-name">Workshop Programming</span><small>25 September 2026</small></div>
                        </a>
                    </div>
                </div>

            </div>{{-- /side-col --}}

        </div>{{-- /layout --}}
    </div>{{-- /container --}}
</div>{{-- /body --}}

{{-- ═══ FOOTER SIMPLE ═══ --}}
<footer class="ep-footer">
    <div class="ep-footer-inner">
        <a href="/" class="epnav-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Eventty" class="epnav-logo">
            <span class="epnav-name" style="color:#fff;">Event<strong>ty</strong></span>
        </a>
        <span class="ep-footer-text">© {{ date('Y') }} Eventty. Platform Event Sekolah.</span>
        <a href="/" class="ep-footer-back">← Kembali ke Beranda</a>
    </div>
</footer>

<script>
var eventsData = {
    1: { title:'Seminar Digital', sub:'Transformasi digital dan peran teknologi dalam dunia kerja', cat:'seminar', catLabel:'Seminar', img:'{{ asset("images/seminar.png") }}', date:'10 September 2026', time:'08:00 – 12:00 WIB', location:'Aula Sekolah', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:72, cert:'Certificate of Participation', status:'open', statusLabel:'Pendaftaran Dibuka' },
    2: { title:'Career Day 2026', sub:'Temui profesional dari 30+ perusahaan dan eksplorasi peluang karir', cat:'career', catLabel:'Career', img:'{{ asset("images/careerday.jpeg") }}', date:'15 September 2026', time:'08:00 – 15:00 WIB', location:'Aula Sekolah', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:45, cert:'Certificate of Participation', status:'open', statusLabel:'Pendaftaran Dibuka' },
    3: { title:'Classmeeting 2026', sub:'Kompetisi antar kelas dalam berbagai cabang olahraga dan seni', cat:'competition', catLabel:'Kompetisi', img:'{{ asset("images/classmeeting.jpeg") }}', date:'1–5 September 2026', time:'07:30 – 17:00 WIB', location:'Lapangan Sekolah', organizer:'OSIS SMKN 20 Jakarta', quota:50, registered:47, cert:'Certificate of Achievement', status:'hot', statusLabel:'Hampir Penuh' },
    4: { title:'Workshop Programming', sub:'Belajar web dan mobile development bersama mentor berpengalaman', cat:'workshop', catLabel:'Workshop', img:'{{ asset("images/workshop.png") }}', date:'25 September 2026', time:'09:00 – 15:00 WIB', location:'Lab RPL', organizer:'OSIS SMKN 20 Jakarta', quota:30, registered:20, cert:'Certificate of Completion', status:'open', statusLabel:'Pendaftaran Dibuka' },
    5: { title:'Turnamen Basket', sub:'Kompetisi basket antar kelas, raih trofi dan sertifikat achievement', cat:'competition', catLabel:'Kompetisi', img:'{{ asset("images/basket.jpeg") }}', date:'10 Oktober 2026', time:'08:00 – 16:00 WIB', location:'Lapangan Basket', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:20, cert:'Certificate of Achievement', status:'open', statusLabel:'Pendaftaran Dibuka' },
    6: { title:'Seminar Kewirausahaan', sub:'Inspirasi bisnis dari pengusaha muda sukses', cat:'seminar', catLabel:'Seminar', img:'{{ asset("images/seminar.png") }}', date:'3 Oktober 2026', time:'10:00 – 12:00 WIB', location:'Aula Sekolah', organizer:'OSIS SMKN 20 Jakarta', quota:100, registered:40, cert:'Certificate of Participation', status:'open', statusLabel:'Pendaftaran Dibuka' },
};

(function(){
    var p  = new URLSearchParams(window.location.search);
    var id = parseInt(p.get('id')) || 1;
    var ev = eventsData[id] || eventsData[1];

    document.title = ev.title + ' — Eventty';
    document.getElementById('bcName').textContent     = ev.title;
    document.getElementById('epHeroImg').src          = ev.img;
    document.getElementById('epTitle').textContent    = ev.title;
    document.getElementById('epSub').textContent      = ev.sub;
    document.getElementById('epHeroDate').innerHTML   = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> ' + ev.date;
    document.getElementById('epHeroLoc').innerHTML    = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> ' + ev.location;

    var badge = document.getElementById('epBadge');
    badge.textContent = ev.catLabel;
    badge.className   = 'ep-hero-badge ' + ev.cat;

    document.getElementById('infoDate').textContent     = ev.date;
    document.getElementById('infoTime').textContent     = ev.time;
    document.getElementById('infoLocation').textContent = ev.location;
    document.getElementById('infoOrganizer').textContent= ev.organizer;
    document.getElementById('infoQuota').textContent    = ev.quota + ' peserta';
    document.getElementById('infoCert').textContent     = ev.cert;

    var pct = Math.round(ev.registered / ev.quota * 100);
    var rem = ev.quota - ev.registered;
    document.getElementById('quotaCount').textContent   = ev.registered + ' / ' + ev.quota + ' peserta';
    document.getElementById('quotaFill').style.width    = pct + '%';
    document.getElementById('quotaFill').style.background = pct >= 85 ? '#ef4444' : '#2563eb';
    document.getElementById('quotaNotes') && (document.getElementById('quotaNotes').textContent = rem + ' slot tersisa');
    document.getElementById('quotaNote').textContent    = rem + ' slot tersisa — Daftar sebelum penuh!';
    document.getElementById('epStatusInfo').textContent = rem + ' slot tersisa';

    var statusDot  = document.getElementById('epStatusDot');
    var statusText = document.getElementById('epStatusText');
    if (ev.status === 'hot') {
        statusDot.className  = 'ep-status-dot hot';
        statusText.textContent = 'Hampir Penuh';
        statusText.style.color = '#b45309';
    } else {
        statusDot.className  = 'ep-status-dot open';
        statusText.textContent = ev.statusLabel;
        statusText.style.color = '#16a34a';
    }
})();

// Navbar scroll
var nav = document.getElementById('epNavbar');
window.addEventListener('scroll', function(){
    nav.classList.toggle('scrolled', window.scrollY > 20);
}, { passive: true });
</script>

</body>
</html>
