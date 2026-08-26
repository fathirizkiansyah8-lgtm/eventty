<!DOCTYPE html>
<<<<<<< HEAD
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="icon" href="logo.jpeg">
</head>
<body>

</body>
</html>
=======
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Eventty — Event Sekolah Lebih Mudah</title>

    <meta
        name="description"
        content="Eventty adalah platform manajemen event sekolah untuk membantu siswa menemukan, mendaftar, dan mengikuti berbagai kegiatan sekolah."
    >

    @vite([
        'resources/css/auth/landing.css',
        'resources/js/auth/landing.js'
    ])
</head>

<body>

    <!-- ================= NAVBAR ================= -->
    <header class="landing-header" id="navbar">
        <div class="container navbar">

            <a href="/" class="brand">
                <span class="brand-mark">E</span>

                <span class="brand-text">
                    Event<span>ty</span>
                </span>
            </a>

            <nav class="nav-menu" id="navMenu">
                <a href="#home" class="nav-link active">Beranda</a>
                <a href="#events" class="nav-link">Event</a>
                <a href="#features" class="nav-link">Fitur</a>
                <a href="#how-it-works" class="nav-link">Cara Kerja</a>
                <a href="#about" class="nav-link">Tentang</a>
            </nav>

            <div class="nav-actions">
                <a href="/login" class="btn btn-login">Masuk</a>
                <a href="/register" class="btn btn-primary">Daftar</a>
            </div>

            <button
                type="button"
                class="mobile-menu-button"
                id="mobileMenuButton"
                aria-label="Buka menu"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </header>


    <main>

        <!-- ================= HERO ================= -->
        <section class="hero-section" id="home">

            <div class="hero-background-shape shape-one"></div>
            <div class="hero-background-shape shape-two"></div>

            <div class="container hero-container">

                <div class="hero-content reveal">

                    <div class="hero-badge">
                        <span class="badge-dot"></span>
                        Platform Event Sekolah
                    </div>

                    <h1>
                        Semua Event Sekolah,
                        <span>Lebih Mudah.</span>
                    </h1>

                    <p class="hero-description">
                        Eventty membantu siswa menemukan, mendaftar, dan
                        mengikuti berbagai kegiatan sekolah dalam satu platform
                        yang sederhana dan terorganisir.
                    </p>

                    <div class="hero-actions">
                        <a href="/login" class="btn btn-primary btn-large">
                            Mulai Sekarang
                            <span class="arrow">→</span>
                        </a>

                        <a href="#features" class="btn btn-outline btn-large">
                            Pelajari Eventty
                        </a>
                    </div>

                    <div class="hero-note">
                        <span class="check-icon">✓</span>
                        Dibuat untuk kebutuhan kegiatan sekolah
                    </div>

                </div>


                <!-- HERO VISUAL -->
                <div class="hero-visual reveal">

                    <div class="dashboard-preview">

                        <div class="preview-topbar">
                            <div class="preview-brand">
                                <span class="mini-logo">E</span>
                                <span>Eventty</span>
                            </div>

                            <div class="preview-profile">
                                <span class="profile-circle"></span>
                                <span class="profile-line"></span>
                            </div>
                        </div>


                        <div class="preview-body">

                            <div class="preview-heading">
                                <div>
                                    <span class="preview-small-text">
                                        Selamat datang kembali,
                                    </span>

                                    <strong>Fathi 👋</strong>
                                </div>

                                <div class="notification-dot"></div>
                            </div>


                            <div class="preview-stat-grid">

                                <div class="preview-stat">
                                    <span class="stat-icon blue"></span>

                                    <div>
                                        <small>Event Aktif</small>
                                        <strong>08</strong>
                                    </div>
                                </div>

                                <div class="preview-stat">
                                    <span class="stat-icon purple"></span>

                                    <div>
                                        <small>Event Saya</small>
                                        <strong>04</strong>
                                    </div>
                                </div>

                            </div>


                            <div class="preview-event-title">
                                Event Mendatang
                            </div>


                            <div class="preview-event">

                                <div class="event-date">
                                    <strong>24</strong>
                                    <span>SEP</span>
                                </div>

                                <div class="event-info">
                                    <strong>Career Day 2026</strong>
                                    <span>Auditorium Sekolah</span>
                                </div>

                                <span class="event-arrow">→</span>

                            </div>


                            <div class="preview-event">

                                <div class="event-date second">
                                    <strong>02</strong>
                                    <span>OKT</span>
                                </div>

                                <div class="event-info">
                                    <strong>Class Meeting</strong>
                                    <span>Lapangan Sekolah</span>
                                </div>

                                <span class="event-arrow">→</span>

                            </div>

                        </div>

                    </div>

                    <div class="floating-card floating-card-one">
                        <span class="floating-icon">✓</span>

                        <div>
                            <strong>Pendaftaran Berhasil</strong>
                            <small>Career Day 2026</small>
                        </div>
                    </div>

                    <div class="floating-card floating-card-two">
                        <span class="calendar-icon">24</span>

                        <div>
                            <strong>Event Baru</strong>
                            <small>2 hari lagi</small>
                        </div>
                    </div>

                </div>

            </div>

        </section>


        <!-- ================= TRUST / STATS ================= -->
        <section class="stats-section">

            <div class="container stats-grid">

                <div class="stat-item reveal">
                    <strong>1</strong>
                    <span>Platform</span>
                </div>

                <div class="stat-divider"></div>

                <div class="stat-item reveal">
                    <strong>24/7</strong>
                    <span>Akses Informasi</span>
                </div>

                <div class="stat-divider"></div>

                <div class="stat-item reveal">
                    <strong>100%</strong>
                    <span>Terorganisir</span>
                </div>

                <div class="stat-divider"></div>

                <div class="stat-item reveal">
                    <strong>∞</strong>
                    <span>Potensi Kegiatan</span>
                </div>

            </div>

        </section>


        <!-- ================= EVENTS ================= -->
        <section class="events-section section" id="events">
            <div class="container">

                <div class="section-heading reveal">
                    <span class="section-label">EVENT MENDATANG</span>
                    <h2>Temukan event <span>yang menarik untukmu.</span></h2>
                    <p>Ikuti berbagai kegiatan sekolah — seminar, workshop, kompetisi, hingga career day. Daftar akun untuk bergabung.</p>
                </div>

                <div class="events-filter-row reveal">
                    <button class="ev-filter-btn active" data-filter="all">Semua</button>
                    <button class="ev-filter-btn" data-filter="seminar">Seminar</button>
                    <button class="ev-filter-btn" data-filter="workshop">Workshop</button>
                    <button class="ev-filter-btn" data-filter="competition">Kompetisi</button>
                    <button class="ev-filter-btn" data-filter="career">Career</button>
                </div>

                <div class="pub-events-grid" id="pubEventsGrid">

                    <article class="pub-event-card reveal" data-category="seminar">
                        <div class="pub-event-img-wrap">
                            <img src="{{ asset('images/seminar.png') }}" alt="Seminar Digital" loading="lazy">
                            <span class="pub-cat-badge seminar">Seminar</span>
                            <span class="pub-status-tag open">Buka</span>
                        </div>
                        <div class="pub-event-body">
                            <h3 class="pub-event-title">Seminar Digital</h3>
                            <div class="pub-event-meta">
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>10 September 2026</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>08:00 – 12:00</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                            </div>
                            <p class="pub-event-desc">Pelajari transformasi digital dan peran teknologi bersama praktisi industri terkemuka.</p>
                            <div class="pub-event-footer">
                                <div class="pub-quota-wrap">
                                    <div class="pub-quota-bar"><div style="width:72%"></div></div>
                                    <span class="pub-quota-txt">72/100</span>
                                </div>
                                <a href="/events/public?id=1" class="pub-cta-link">Lihat Detail →</a>
                            </div>
                        </div>
                    </article>

                    <article class="pub-event-card reveal" data-category="career">
                        <div class="pub-event-img-wrap">
                            <img src="{{ asset('images/careerday.jpeg') }}" alt="Career Day" loading="lazy">
                            <span class="pub-cat-badge career">Career</span>
                            <span class="pub-status-tag open">Buka</span>
                        </div>
                        <div class="pub-event-body">
                            <h3 class="pub-event-title">Career Day 2026</h3>
                            <div class="pub-event-meta">
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>15 September 2026</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>08:00 – 15:00</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                            </div>
                            <p class="pub-event-desc">Temui profesional dari 30+ perusahaan dan eksplorasi peluang karir masa depanmu.</p>
                            <div class="pub-event-footer">
                                <div class="pub-quota-wrap">
                                    <div class="pub-quota-bar"><div style="width:45%"></div></div>
                                    <span class="pub-quota-txt">45/100</span>
                                </div>
                                <a href="/events/public?id=2" class="pub-cta-link">Lihat Detail →</a>
                            </div>
                        </div>
                    </article>

                    <article class="pub-event-card reveal" data-category="competition">
                        <div class="pub-event-img-wrap">
                            <img src="{{ asset('images/classmeeting.jpeg') }}" alt="Class Meeting" loading="lazy">
                            <span class="pub-cat-badge competition">Kompetisi</span>
                            <span class="pub-status-tag open">Buka</span>
                        </div>
                        <div class="pub-event-body">
                            <h3 class="pub-event-title">Class Meeting 2026</h3>
                            <div class="pub-event-meta">
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>20 September 2026</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>07:30 – 17:00</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Lapangan Sekolah</span>
                            </div>
                            <p class="pub-event-desc">Kompetisi antar kelas — olahraga dan seni. Raih trofi dan sertifikat achievement!</p>
                            <div class="pub-event-footer">
                                <div class="pub-quota-wrap">
                                    <div class="pub-quota-bar"><div style="width:60%"></div></div>
                                    <span class="pub-quota-txt">60/100</span>
                                </div>
                                <a href="/events/public?id=3" class="pub-cta-link">Lihat Detail →</a>
                            </div>
                        </div>
                    </article>

                    <article class="pub-event-card reveal" data-category="workshop">
                        <div class="pub-event-img-wrap">
                            <img src="{{ asset('images/workshop.png') }}" alt="Workshop Programming" loading="lazy">
                            <span class="pub-cat-badge workshop">Workshop</span>
                            <span class="pub-status-tag soon">Segera</span>
                        </div>
                        <div class="pub-event-body">
                            <h3 class="pub-event-title">Workshop Programming</h3>
                            <div class="pub-event-meta">
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>25 September 2026</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>09:00 – 15:00</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Lab RPL</span>
                            </div>
                            <p class="pub-event-desc">Belajar web dan mobile development bersama mentor berpengalaman. Cocok untuk semua level.</p>
                            <div class="pub-event-footer">
                                <div class="pub-quota-wrap">
                                    <div class="pub-quota-bar"><div style="width:30%"></div></div>
                                    <span class="pub-quota-txt">30/100</span>
                                </div>
                                <a href="/events/public?id=4" class="pub-cta-link">Lihat Detail →</a>
                            </div>
                        </div>
                    </article>

                    <article class="pub-event-card reveal" data-category="competition">
                        <div class="pub-event-img-wrap">
                            <img src="{{ asset('images/basket.jpeg') }}" alt="Turnamen Basket" loading="lazy">
                            <span class="pub-cat-badge competition">Kompetisi</span>
                            <span class="pub-status-tag open">Buka</span>
                        </div>
                        <div class="pub-event-body">
                            <h3 class="pub-event-title">Turnamen Basket</h3>
                            <div class="pub-event-meta">
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>10 Oktober 2026</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>08:00 – 16:00</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Lapangan Basket</span>
                            </div>
                            <p class="pub-event-desc">Kompetisi basket antar kelas. Tunjukkan skill-mu dan rebut trofi juara beserta sertifikat!</p>
                            <div class="pub-event-footer">
                                <div class="pub-quota-wrap">
                                    <div class="pub-quota-bar"><div style="width:20%"></div></div>
                                    <span class="pub-quota-txt">20/100</span>
                                </div>
                                <a href="/events/public?id=5" class="pub-cta-link">Lihat Detail →</a>
                            </div>
                        </div>
                    </article>

                    <article class="pub-event-card reveal" data-category="seminar">
                        <div class="pub-event-img-wrap">
                            <img src="{{ asset('images/ilustrasi-logo.png') }}" alt="Seminar Kewirausahaan" loading="lazy">
                            <span class="pub-cat-badge seminar">Seminar</span>
                            <span class="pub-status-tag soon">Segera</span>
                        </div>
                        <div class="pub-event-body">
                            <h3 class="pub-event-title">Seminar Kewirausahaan</h3>
                            <div class="pub-event-meta">
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>3 Oktober 2026</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>10:00 – 12:00</span>
                                <span class="pub-meta-row"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Aula Sekolah</span>
                            </div>
                            <p class="pub-event-desc">Inspirasi bisnis dari pengusaha muda sukses. Mulai usaha di usia sekolah dengan modal minim.</p>
                            <div class="pub-event-footer">
                                <div class="pub-quota-wrap">
                                    <div class="pub-quota-bar"><div style="width:15%"></div></div>
                                    <span class="pub-quota-txt">15/100</span>
                                </div>
                                <a href="/events/public?id=6" class="pub-cta-link">Lihat Detail →</a>
                            </div>
                        </div>
                    </article>

                </div>

                <div class="events-bottom-cta reveal">
                    <a href="/login" class="btn btn-primary btn-large">Lihat Semua Event <span class="arrow">→</span></a>
                    <span class="events-bottom-note">Daftar akun untuk mendaftar event</span>
                </div>

            </div>
        </section>


        <!-- ================= FEATURES ================= -->
        <section class="features-section section" id="features">

            <div class="container">

                <div class="section-heading reveal">

                    <span class="section-label">
                        FITUR UTAMA
                    </span>

                    <h2>
                        Semua yang kamu butuhkan
                        <span>dalam satu tempat.</span>
                    </h2>

                    <p>
                        Eventty dirancang untuk membuat pengalaman mengikuti
                        event sekolah menjadi lebih praktis dan terorganisir.
                    </p>

                </div>


                <div class="features-grid">

                    <article class="feature-card reveal">

                        <div class="feature-icon blue-icon">
                            <span>01</span>
                        </div>

                        <h3>Temukan Event</h3>

                        <p>
                            Lihat berbagai kegiatan sekolah yang sedang
                            berlangsung maupun yang akan datang.
                        </p>

                        <a href="/login" class="feature-link">
                            Lihat Event <span>→</span>
                        </a>

                    </article>


                    <article class="feature-card reveal">

                        <div class="feature-icon purple-icon">
                            <span>02</span>
                        </div>

                        <h3>Pendaftaran Mudah</h3>

                        <p>
                            Daftar ke event yang kamu inginkan tanpa proses
                            yang rumit dan membingungkan.
                        </p>

                        <a href="/login" class="feature-link">
                            Mulai Daftar <span>→</span>
                        </a>

                    </article>


                    <article class="feature-card reveal">

                        <div class="feature-icon green-icon">
                            <span>03</span>
                        </div>

                        <h3>Kelola Event</h3>

                        <p>
                            Pantau event yang kamu ikuti dan dapatkan informasi
                            terbaru secara lebih teratur.
                        </p>

                        <a href="/login" class="feature-link">
                            Kelola Event <span>→</span>
                        </a>

                    </article>


                    <article class="feature-card reveal">

                        <div class="feature-icon orange-icon">
                            <span>04</span>
                        </div>

                        <h3>Notifikasi</h3>

                        <p>
                            Jangan lewatkan informasi penting mengenai event,
                            jadwal, dan pengumuman sekolah.
                        </p>

                        <a href="/login" class="feature-link">
                            Lihat Informasi <span>→</span>
                        </a>

                    </article>


                    <article class="feature-card reveal">

                        <div class="feature-icon pink-icon">
                            <span>05</span>
                        </div>

                        <h3>Sertifikat Digital</h3>

                        <p>
                            Akses sertifikat kegiatan yang kamu ikuti dengan
                            lebih praktis melalui akun Eventty.
                        </p>

                        <a href="/login" class="feature-link">
                            Lihat Sertifikat <span>→</span>
                        </a>

                    </article>


                    <article class="feature-card reveal">

                        <div class="feature-icon cyan-icon">
                            <span>06</span>
                        </div>

                        <h3>Informasi Terpusat</h3>

                        <p>
                            Semua informasi kegiatan sekolah tersedia dalam
                            satu sistem yang mudah digunakan.
                        </p>

                        <a href="/login" class="feature-link">
                            Jelajahi Eventty <span>→</span>
                        </a>

                    </article>

                </div>

            </div>

        </section>


        <!-- ================= HOW IT WORKS ================= -->
        <section class="how-section section" id="how-it-works">

            <div class="container">

                <div class="section-heading centered reveal">

                    <span class="section-label">
                        CARA KERJA
                    </span>

                    <h2>
                        Mulai dalam
                        <span>tiga langkah sederhana.</span>
                    </h2>

                    <p>
                        Tidak perlu proses yang rumit. Cari event, daftar,
                        lalu ikuti kegiatannya.
                    </p>

                </div>


                <div class="steps-container">

                    <div class="step reveal">

                        <div class="step-number">
                            01
                        </div>

                        <div class="step-content">
                            <h3>Buat Akun</h3>

                            <p>
                                Daftarkan akun menggunakan data siswa yang
                                diperlukan oleh sekolah.
                            </p>
                        </div>

                    </div>


                    <div class="step-line"></div>


                    <div class="step reveal">

                        <div class="step-number">
                            02
                        </div>

                        <div class="step-content">
                            <h3>Pilih Event</h3>

                            <p>
                                Temukan event yang menarik dan lihat detail
                                kegiatan sebelum melakukan pendaftaran.
                            </p>
                        </div>

                    </div>


                    <div class="step-line"></div>


                    <div class="step reveal">

                        <div class="step-number">
                            03
                        </div>

                        <div class="step-content">
                            <h3>Ikuti Kegiatan</h3>

                            <p>
                                Pantau informasi event dan ikuti kegiatan
                                sesuai jadwal yang telah ditentukan.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- ================= ABOUT ================= -->
        <section class="about-section section" id="about">

            <div class="container about-container">

                <div class="about-content reveal">

                    <span class="section-label">
                        TENTANG EVENTTY
                    </span>

                    <h2>
                        Satu platform untuk
                        <span>berbagai kegiatan sekolah.</span>
                    </h2>

                    <p>
                        Eventty hadir untuk membantu sekolah dan siswa
                        mengelola berbagai kegiatan secara lebih terstruktur.
                    </p>

                    <p>
                        Mulai dari pendaftaran event, informasi kegiatan,
                        notifikasi, hingga sertifikat digital dapat
                        dikelola melalui satu platform.
                    </p>

                    <a href="/register" class="btn btn-primary btn-large">
                        Buat Akun
                        <span class="arrow">→</span>
                    </a>

                </div>


                <div class="about-visual reveal">

                    <div class="about-card">

                        <div class="about-card-top">
                            <span class="mini-logo">E</span>

                            <div>
                                <small>EVENTTY</small>
                                <strong>School Event Platform</strong>
                            </div>
                        </div>


                        <div class="about-card-content">

                            <div class="about-check">
                                <span>✓</span>
                                <div>
                                    <strong>Event Terorganisir</strong>
                                    <small>Semua kegiatan dalam satu platform</small>
                                </div>
                            </div>

                            <div class="about-check">
                                <span>✓</span>
                                <div>
                                    <strong>Pendaftaran Praktis</strong>
                                    <small>Proses cepat dan sederhana</small>
                                </div>
                            </div>

                            <div class="about-check">
                                <span>✓</span>
                                <div>
                                    <strong>Informasi Terintegrasi</strong>
                                    <small>Update event lebih mudah</small>
                                </div>
                            </div>

                            <div class="about-check">
                                <span>✓</span>
                                <div>
                                    <strong>Sertifikat Digital</strong>
                                    <small>Akses sertifikat secara online</small>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- ================= CTA ================= -->
        <section class="cta-section">

            <div class="container">

                <div class="cta-card reveal">

                    <div class="cta-decoration decoration-one"></div>
                    <div class="cta-decoration decoration-two"></div>

                    <div class="cta-content">

                        <span class="section-label light-label">
                            SIAP MEMULAI?
                        </span>

                        <h2>
                            Jangan lewatkan event
                            sekolah berikutnya.
                        </h2>

                        <p>
                            Bergabung dengan Eventty dan temukan berbagai
                            kegiatan sekolah dalam satu tempat.
                        </p>

                        <div class="cta-actions">

                            <a
                                href="/register"
                                class="btn btn-white btn-large"
                            >
                                Buat Akun
                                <span class="arrow">→</span>
                            </a>

                            <a
                                href="/login"
                                class="cta-login-link"
                            >
                                Sudah punya akun? <strong>Masuk</strong>
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>


    <!-- ================= FOOTER ================= -->
    <footer class="footer">

        <div class="container footer-container">

            <div class="footer-brand">

                <a href="/" class="brand footer-logo">
                    <span class="brand-mark">E</span>

                    <span class="brand-text">
                        Event<span>ty</span>
                    </span>
                </a>

                <p>
                    Platform manajemen event sekolah yang membantu siswa
                    menemukan dan mengikuti berbagai kegiatan.
                </p>

            </div>


            <div class="footer-links">

                <div class="footer-column">

                    <h4>Platform</h4>

                    <a href="#features">Fitur</a>
                    <a href="#how-it-works">Cara Kerja</a>
                    <a href="#about">Tentang</a>

                </div>


                <div class="footer-column">

                    <h4>Akun</h4>

                    <a href="/login">Masuk</a>
                    <a href="/register">Daftar</a>

                </div>


                <div class="footer-column">

                    <h4>Eventty</h4>

                    <a href="#home">Beranda</a>
                    <a href="#features">Informasi</a>

                </div>

            </div>

        </div>


        <div class="container footer-bottom">

            <span>
                © {{ date('Y') }} Eventty. All rights reserved.
            </span>

            <span>
                School Event Management System
            </span>

        </div>

    </footer>

</body>
</html>
>>>>>>> 8d161b57d7d562a17b0bc64ab5b3a2ef31220bce
