<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
    ])
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>

{{-- Sidebar toggle (mobile) --}}
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

@include('admin.partials.sidebar', ['activePage' => 'dashboard'])

<div class="admin-main">

    @include('admin.partials.header')

    <div class="admin-content">

        {{-- Page title --}}
        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Dashboard</h1>
                <p class="admin-page-hd-sub">Ringkasan aktivitas dan statistik Eventty</p>
            </div>
            <a href="{{ url('/admin/events/create') }}" class="abtn abtn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Event Baru
            </a>
        </div>

        {{-- ── STAT CARDS ── --}}
        <div class="admin-stats">
            <div class="admin-stat">
                <div class="admin-stat-icon asi-blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">24</div>
                    <div class="admin-stat-lbl">Total Event</div>
                    <div class="admin-stat-trend-up">↑ 4 bulan ini</div>
                </div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon asi-green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">8</div>
                    <div class="admin-stat-lbl">Event Aktif</div>
                    <div class="admin-stat-sub">Sedang berjalan</div>
                </div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon asi-orange">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">342</div>
                    <div class="admin-stat-lbl">Total Peserta</div>
                    <div class="admin-stat-trend-up">↑ 28 minggu ini</div>
                </div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon asi-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">16</div>
                    <div class="admin-stat-lbl">Event Selesai</div>
                    <div class="admin-stat-sub">dari 24 total</div>
                </div>
            </div>
        </div>

        {{-- ── 2-COL GRID ── --}}
        <div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;align-items:start;">

            {{-- ── LEFT COLUMN ── --}}
            <div style="display:flex;flex-direction:column;gap:1.25rem;">

                {{-- Highlight Banner --}}
                <div style="background:linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 60%,#3b82f6 100%);border-radius:1rem;padding:1.5rem 1.75rem;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-50px;right:-50px;width:180px;height:180px;background:rgba(255,255,255,.06);border-radius:50%;"></div>
                    <div style="position:absolute;bottom:-30px;left:60%;width:120px;height:120px;background:rgba(255,255,255,.04);border-radius:50%;"></div>
                    <div style="position:relative;z-index:2;">
                        <div style="display:inline-flex;align-items:center;gap:.375rem;background:rgba(255,255,255,.15);border-radius:999px;padding:.2rem .75rem;font-size:.68rem;font-weight:700;color:#bfdbfe;letter-spacing:.05em;text-transform:uppercase;margin-bottom:.625rem;">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            Highlight Event
                        </div>
                        <h2 style="font-size:1.25rem;font-weight:800;color:#ffffff;margin-bottom:.375rem;letter-spacing:-.3px;">Classmeeting 2026 <span style="color:#7dd3fc;">Sedang Berjalan!</span></h2>
                        <p style="font-size:.8rem;color:rgba(255,255,255,.7);margin-bottom:1rem;max-width:360px;">47 dari 50 kuota terisi. Pantau pendaftaran dan kehadiran secara real-time.</p>
                        <a href="{{ url('/admin/events') }}" style="display:inline-flex;align-items:center;gap:.5rem;background:#fff;color:#1e40af;font-size:.8rem;font-weight:700;padding:.45rem 1.1rem;border-radius:999px;text-decoration:none;transition:all .18s;box-shadow:0 2px 8px rgba(0,0,0,.15);">
                            Kelola Event
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                    <div style="position:absolute;right:1.5rem;top:50%;transform:translateY(-50%);display:flex;flex-direction:column;gap:.5rem;z-index:2;">
                        <div style="background:rgba(255,255,255,.15);backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);border-radius:.625rem;padding:.4rem .875rem;font-size:.72rem;font-weight:700;color:#fff;white-space:nowrap;">47/50 Peserta <span style="opacity:.65;font-weight:400;">Almost Full</span></div>
                        <div style="background:rgba(255,255,255,.15);backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);border-radius:.625rem;padding:.4rem .875rem;font-size:.72rem;font-weight:700;color:#fff;white-space:nowrap;">1–5 Sep 2026 <span style="opacity:.65;font-weight:400;">5 hari</span></div>
                    </div>
                </div>

                {{-- Recent Events Table --}}
                <div class="admin-table-wrap">
                    <div class="admin-table-hd">
                        <span style="font-size:.9rem;font-weight:800;color:#0f172a;">Event Terbaru</span>
                        <a href="{{ url('/admin/events') }}" class="abtn abtn-outline abtn-sm">Lihat Semua</a>
                    </div>
                    <div class="admin-table-scroll">
                        <table class="admin-table">
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
                                @php
                                $events = [
                                    ['Career Day', 'School Event', 'careerday.jpeg', '20 Aug 2026', 'open', 45, 50],
                                    ['Workshop Programming', 'Workshop', 'workshop.png', '25 Aug 2026', 'open', 20, 30],
                                    ['Classmeeting', 'Competition', 'classmeeting.jpeg', '1–5 Sep 2026', 'ongoing', 47, 50],
                                    ['Seminar Kewirausahaan', 'Seminar', 'seminar.png', '3 Sep 2026', 'open', 40, 50],
                                    ['Turnamen Basket', 'Sports', 'basket.jpeg', '10 Sep 2026', 'open', 10, 24],
                                ];
                                $statusMap = ['open' => ['Buka', 'abadge-green'], 'ongoing' => ['Berjalan', 'abadge-blue'], 'closed' => ['Tutup', 'abadge-red']];
                                @endphp
                                @foreach($events as $ev)
                                @php [$label, $cls] = $statusMap[$ev[4]] ?? ['Buka', 'abadge-green']; $pct = round($ev[5]/$ev[6]*100); @endphp
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:.75rem;">
                                            <img src="{{ asset('images/'.$ev[2]) }}" alt="" style="width:38px;height:32px;border-radius:.375rem;object-fit:cover;background:#f1f5f9;flex-shrink:0;">
                                            <div>
                                                <div style="font-weight:700;font-size:.825rem;color:#0f172a;">{{ $ev[0] }}</div>
                                                <div style="font-size:.7rem;color:#94a3b8;">{{ $ev[1] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-size:.8rem;color:#64748b;white-space:nowrap;">{{ $ev[3] }}</td>
                                    <td><span class="abadge {{ $cls }}">{{ $label }}</span></td>
                                    <td>
                                        <div style="min-width:90px;">
                                            <div style="display:flex;justify-content:space-between;font-size:.68rem;font-weight:600;color:#94a3b8;margin-bottom:3px;"><span>{{ $ev[5] }}/{{ $ev[6] }}</span><span>{{ $pct }}%</span></div>
                                            <div style="height:5px;background:#f1f5f9;border-radius:999px;overflow:hidden;">
                                                <div style="height:100%;width:{{ $pct }}%;background:{{ $pct>=85 ? '#ef4444' : '#1d4ed8' }};border-radius:999px;transition:width .6s;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/events') }}" class="abtn abtn-outline abtn-sm">Kelola</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Charts row --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

                    {{-- Bar chart --}}
                    <div class="admin-card">
                        <div class="admin-card-hd">
                            <span class="admin-card-title">Pendaftar (7 Hari Terakhir)</span>
                        </div>
                        <div class="admin-card-body">
                            <div id="barChart" style="display:flex;align-items:flex-end;gap:.5rem;height:100px;"></div>
                        </div>
                    </div>

                    {{-- Donut event status --}}
                    <div class="admin-card">
                        <div class="admin-card-hd">
                            <span class="admin-card-title">Status Event</span>
                        </div>
                        <div class="admin-card-body" style="display:flex;align-items:center;gap:1.25rem;">
                            <svg width="100" height="100" viewBox="0 0 100 100" style="flex-shrink:0;">
                                <circle cx="50" cy="50" r="38" fill="none" stroke="#f1f5f9" stroke-width="12"/>
                                <circle cx="50" cy="50" r="38" fill="none" stroke="#10b981" stroke-width="12" stroke-dasharray="159.6 79.8" stroke-dashoffset="0" stroke-linecap="round" transform="rotate(-90 50 50)"/>
                                <circle cx="50" cy="50" r="38" fill="none" stroke="#3b82f6" stroke-width="12" stroke-dasharray="79.8 159.6" stroke-dashoffset="-159.6" stroke-linecap="round" transform="rotate(-90 50 50)"/>
                                <text x="50" y="46" text-anchor="middle" font-size="14" font-weight="800" fill="#0f172a">24</text>
                                <text x="50" y="59" text-anchor="middle" font-size="8" fill="#94a3b8">Total</text>
                            </svg>
                            <div style="display:flex;flex-direction:column;gap:.5rem;flex:1;">
                                @foreach([['Selesai','#10b981',16],['Aktif','#3b82f6',8],['Draft','#f59e0b',0]] as $s)
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div style="width:9px;height:9px;border-radius:50%;background:{{ $s[1] }};flex-shrink:0;"></div>
                                    <span style="font-size:.75rem;color:#475569;font-weight:600;flex:1;">{{ $s[0] }}</span>
                                    <span style="font-size:.875rem;font-weight:800;color:#0f172a;">{{ $s[2] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

            </div>{{-- /left --}}

            {{-- ── RIGHT COLUMN ── --}}
            <div style="display:flex;flex-direction:column;gap:1.25rem;">

                {{-- Admin card --}}
                <div style="background:linear-gradient(145deg,#0f1f4e,#1e3a8a);border-radius:1rem;padding:1.25rem;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-30px;right:-30px;width:100px;height:100px;background:rgba(255,255,255,.06);border-radius:50%;"></div>
                    <div style="position:relative;z-index:2;">
                        <div style="width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,#60a5fa,#818cf8);display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:800;color:#fff;border:2px solid rgba(255,255,255,.25);margin-bottom:.75rem;">A</div>
                        <div style="font-size:.95rem;font-weight:800;color:#fff;">Admin OSIS</div>
                        <div style="font-size:.7rem;color:rgba(255,255,255,.55);margin-top:2px;">admin@eventty.sch.id</div>
                        <div style="display:inline-flex;align-items:center;gap:.3rem;background:rgba(255,255,255,.15);color:#bfdbfe;font-size:.65rem;font-weight:700;padding:.18rem .55rem;border-radius:999px;margin-top:.45rem;letter-spacing:.02em;">Super Admin · OSIS</div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-top:.875rem;">
                            @foreach([['24','Event'],['342','Peserta'],['98','Sertifikat'],['95%','Kehadiran']] as $s)
                            <div style="background:rgba(255,255,255,.1);border-radius:.625rem;padding:.55rem;text-align:center;">
                                <div style="font-size:1.1rem;font-weight:800;color:#fff;line-height:1;">{{ $s[0] }}</div>
                                <div style="font-size:.6rem;color:rgba(255,255,255,.55);font-weight:600;margin-top:2px;">{{ $s[1] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Quick actions --}}
                <div class="admin-card">
                    <div class="admin-card-hd">
                        <span class="admin-card-title">Quick Actions</span>
                    </div>
                    <div class="admin-card-body" style="padding:.875rem;display:grid;grid-template-columns:1fr 1fr;gap:.5rem;">
                        @foreach([
                            ['/admin/events/create', 'Buat Event', '#dbeafe', '#1d4ed8', '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>'],
                            ['/admin/participants', 'Peserta', '#dcfce7', '#15803d', '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>'],
                            ['/admin/attendance', 'Kehadiran', '#fef3c7', '#b45309', '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
                            ['/admin/announcements', 'Pengumuman', '#ede9fe', '#6d28d9', '<path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3z"/>'],
                            ['/admin/certificates', 'Sertifikat', '#fee2e2', '#dc2626', '<circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>'],
                            ['/admin/students', 'Data Siswa', '#f0fdf4', '#15803d', '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/>'],
                        ] as $qa)
                        <a href="{{ url($qa[0]) }}" style="display:flex;flex-direction:column;align-items:center;gap:.35rem;padding:.65rem .5rem;border:1.5px solid #e8edf5;background:#f8fafc;border-radius:.75rem;text-decoration:none;color:#0f172a;font-size:.68rem;font-weight:700;text-align:center;transition:all .15s;" onmouseover="this.style.borderColor='#1d4ed8';this.style.background='#eff6ff';this.style.color='#1d4ed8'" onmouseout="this.style.borderColor='#e8edf5';this.style.background='#f8fafc';this.style.color='#0f172a'">
                            <div style="width:32px;height:32px;border-radius:.5rem;background:{{ $qa[2] }};display:flex;align-items:center;justify-content:center;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="{{ $qa[3] }}" stroke-width="2">{!! $qa[4] !!}</svg>
                            </div>
                            {{ $qa[1] }}
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Attention items --}}
                <div class="admin-card">
                    <div class="admin-card-hd">
                        <span class="admin-card-title">Perlu Perhatian</span>
                    </div>
                    @php
                    $tasks = [
                        ['red', 'Classmeeting hampir penuh (47/50)', 'Urgent'],
                        ['orange', 'Career Day — 5 hari lagi', 'Soon'],
                        ['blue', '28 sertifikat belum diterbitkan', 'Pending'],
                        ['orange', 'Absensi Workshop belum dikunci', 'Review'],
                    ];
                    $dotMap = ['red'=>'#ef4444','orange'=>'#f59e0b','blue'=>'#3b82f6'];
                    @endphp
                    @foreach($tasks as $task)
                    <div style="display:flex;align-items:center;gap:.75rem;padding:.7rem 1rem;border-bottom:1px solid #f1f5f9;">
                        <div style="width:7px;height:7px;border-radius:50%;background:{{ $dotMap[$task[0]] }};flex-shrink:0;"></div>
                        <div style="flex:1;font-size:.78rem;font-weight:600;color:#0f172a;line-height:1.4;">{{ $task[1] }}</div>
                        <span style="font-size:.62rem;font-weight:700;padding:.12rem .5rem;border-radius:999px;background:#f1f5f9;color:#64748b;white-space:nowrap;">{{ $task[2] }}</span>
                    </div>
                    @endforeach

                    {{-- Activity --}}
                    <div style="padding:.875rem 1rem .625rem;font-size:.72rem;font-weight:800;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;border-top:1px solid #f1f5f9;margin-top:.25rem;">Aktivitas Terbaru</div>
                    @php
                    $activities = [
                        ['#dcfce7','#15803d','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>','Ahmad Rizki mendaftar Career Day','2 menit lalu'],
                        ['#dbeafe','#1d4ed8','<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>','Event Turnamen Basket dibuat','1 jam lalu'],
                        ['#fef3c7','#b45309','<polyline points="20 6 9 17 4 12"/>','Absensi Seminar dikonfirmasi (40 hadir)','3 jam lalu'],
                        ['#ede9fe','#6d28d9','<circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>','12 sertifikat Workshop diterbitkan','Kemarin'],
                    ];
                    @endphp
                    @foreach($activities as $act)
                    <div style="display:flex;align-items:flex-start;gap:.75rem;padding:.625rem 1rem;border-bottom:1px solid #f8fafc;">
                        <div style="width:32px;height:32px;border-radius:.5rem;background:{{ $act[0] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $act[1] }}" stroke-width="2">{!! $act[2] !!}</svg>
                        </div>
                        <div>
                            <div style="font-size:.775rem;font-weight:600;color:#0f172a;line-height:1.4;">{{ $act[3] }}</div>
                            <div style="font-size:.68rem;color:#94a3b8;margin-top:2px;">{{ $act[4] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>{{-- /right --}}

        </div>{{-- /grid --}}
    </div>{{-- /admin-content --}}
</div>{{-- /admin-main --}}

{{-- Logout Modal --}}
<div class="admin-modal-overlay" id="logoutModal">
    <div class="admin-modal">
        <div class="admin-modal-hd">
            <div class="admin-modal-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </div>
            <h3 class="admin-modal-title">Konfirmasi Keluar</h3>
        </div>
        <div class="admin-modal-body">Apakah Anda yakin ingin keluar dari Dashboard Admin?</div>
        <div class="admin-modal-ft">
            <button type="button" class="abtn abtn-secondary" id="cancelLogoutBtn">Batal</button>
            <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="abtn abtn-danger">Ya, Keluar</button>
            </form>
        </div>
    </div>
</div>

@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
(function(){
    var data = [{d:'Sen',v:42},{d:'Sel',v:78},{d:'Rab',v:55},{d:'Kam',v:91},{d:'Jum',v:67},{d:'Sab',v:48},{d:'Min',v:33}];
    var max = Math.max.apply(null, data.map(function(d){return d.v;}));
    var chart = document.getElementById('barChart');
    if(!chart) return;
    data.forEach(function(d){
        var pct = (d.v/max*100).toFixed(0);
        var col = d.v >= 80 ? '#1d4ed8' : '#93c5fd';
        chart.innerHTML += '<div style="display:flex;flex-direction:column;align-items:center;gap:.3rem;flex:1;">'
            + '<div style="font-size:.62rem;color:#94a3b8;font-weight:600;">'+d.v+'</div>'
            + '<div style="width:100%;height:'+pct+'%;border-radius:.375rem .375rem 0 0;background:'+col+';min-height:8px;transition:height .6s;" title="'+d.v+' pendaftar"></div>'
            + '<div style="font-size:.62rem;color:#94a3b8;font-weight:600;">'+d.d+'</div>'
            + '</div>';
    });
})();
</script>

</body>
</html>
