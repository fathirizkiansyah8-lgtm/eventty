<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard â€” Eventty Admin</title>
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

        {{-- ── STAT CARDS — dari $stats controller ── --}}
        <div class="admin-stats">
            <div class="admin-stat">
                <div class="admin-stat-icon asi-blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">{{ $stats['total_events'] }}</div>
                    <div class="admin-stat-lbl">Total Event</div>
                    <div class="admin-stat-sub">Semua event terdaftar</div>
                </div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon asi-green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">{{ $stats['active_events'] }}</div>
                    <div class="admin-stat-lbl">Event Aktif</div>
                    <div class="admin-stat-sub">Status open/closed</div>
                </div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon asi-orange">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">{{ $stats['total_participants'] }}</div>
                    <div class="admin-stat-lbl">Total Peserta</div>
                    <div class="admin-stat-sub">Siswa terdaftar event</div>
                </div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon asi-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">{{ $stats['completed_events'] }}</div>
                    <div class="admin-stat-lbl">Event Selesai</div>
                    @if($stats['total_events'] > 0)
                        <div class="admin-stat-sub">{{ round(($stats['completed_events'] / $stats['total_events']) * 100) }}% dari total</div>
                    @else
                        <div class="admin-stat-sub">Belum ada event</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── 2-COL GRID ── --}}
        <div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;align-items:start;">

            {{-- ── LEFT COLUMN ── --}}
            <div style="display:flex;flex-direction:column;gap:1.25rem;">

                {{-- Highlight: event aktif terdekat atau placeholder --}}
                @php
                    $featuredEvent = \App\Models\Event::active()
                        ->where('date', '>=', \Carbon\Carbon::today())
                        ->orderBy('date')
                        ->first();
                @endphp

                @if($featuredEvent)
                <div style="background:linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 60%,#3b82f6 100%);border-radius:1rem;padding:1.5rem 1.75rem;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-50px;right:-50px;width:180px;height:180px;background:rgba(255,255,255,.06);border-radius:50%;"></div>
                    <div style="position:absolute;bottom:-30px;left:60%;width:120px;height:120px;background:rgba(255,255,255,.04);border-radius:50%;"></div>
                    <div style="position:relative;z-index:2;">
                        <div style="display:inline-flex;align-items:center;gap:.375rem;background:rgba(255,255,255,.15);border-radius:999px;padding:.2rem .75rem;font-size:.68rem;font-weight:700;color:#bfdbfe;letter-spacing:.05em;text-transform:uppercase;margin-bottom:.625rem;">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            Event Mendatang
                        </div>
                        <h2 style="font-size:1.25rem;font-weight:800;color:#ffffff;margin-bottom:.375rem;letter-spacing:-.3px;">
                            {{ $featuredEvent->name }}
                        </h2>
                        <p style="font-size:.8rem;color:rgba(255,255,255,.7);margin-bottom:1rem;max-width:360px;">
                            {{ $featuredEvent->registered_count }}/{{ $featuredEvent->quota }} kuota terisi ·
                            {{ $featuredEvent->date->format('d M Y') }}
                        </p>
                        <a href="{{ url('/admin/events/' . $featuredEvent->id) }}" style="display:inline-flex;align-items:center;gap:.5rem;background:#fff;color:#1e40af;font-size:.8rem;font-weight:700;padding:.45rem 1.1rem;border-radius:999px;text-decoration:none;">
                            Kelola Event
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                    <div style="position:absolute;right:1.5rem;top:50%;transform:translateY(-50%);display:flex;flex-direction:column;gap:.5rem;z-index:2;">
                        @php $pct = $featuredEvent->quota > 0 ? round($featuredEvent->registered_count / $featuredEvent->quota * 100) : 0; @endphp
                        <div style="background:rgba(255,255,255,.15);backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);border-radius:.625rem;padding:.4rem .875rem;font-size:.72rem;font-weight:700;color:#fff;white-space:nowrap;">
                            {{ $featuredEvent->registered_count }}/{{ $featuredEvent->quota }} Peserta
                            <span style="opacity:.65;font-weight:400;">{{ $pct >= 90 ? 'Almost Full' : 'Tersedia' }}</span>
                        </div>
                        <div style="background:rgba(255,255,255,.15);backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);border-radius:.625rem;padding:.4rem .875rem;font-size:.72rem;font-weight:700;color:#fff;white-space:nowrap;">
                            {{ $featuredEvent->date->format('d M Y') }}
                            <span style="opacity:.65;font-weight:400;">{{ $featuredEvent->days_until_event }} hari lagi</span>
                        </div>
                    </div>
                </div>
                @else
                <div style="background:linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 60%,#3b82f6 100%);border-radius:1rem;padding:1.5rem 1.75rem;text-align:center;">
                    <div style="color:rgba(255,255,255,.7);font-size:.875rem;margin-bottom:.75rem;">Belum ada event aktif yang mendatang</div>
                    <a href="{{ url('/admin/events/create') }}" style="display:inline-flex;align-items:center;gap:.5rem;background:#fff;color:#1e40af;font-size:.8rem;font-weight:700;padding:.45rem 1.1rem;border-radius:999px;text-decoration:none;">
                        + Buat Event Sekarang
                    </a>
                </div>
                @endif

                {{-- Recent Events Table — dari $recentEvents controller --}}
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
                                @forelse($recentEvents as $ev)
                                @php
                                    $evPct = $ev->quota > 0 ? round($ev->registered_count / $ev->quota * 100) : 0;
                                    $evStatusMap = [
                                        'open'      => ['Buka',    'abadge-green'],
                                        'closed'    => ['Tutup',   'abadge-red'],
                                        'completed' => ['Selesai', 'abadge-indigo'],
                                        'cancelled' => ['Batal',   'abadge-gray'],
                                        'draft'     => ['Draft',   'abadge-gray'],
                                    ];
                                    [$evLabel, $evCls] = $evStatusMap[$ev->status] ?? ['Buka','abadge-green'];
                                @endphp
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:.75rem;">
                                            <div style="width:38px;height:32px;border-radius:.375rem;background:{{ $ev->category->color ?? '#3b82f6' }}20;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1rem;">🎉</div>
                                            <div>
                                                <div style="font-weight:700;font-size:.825rem;color:#0f172a;">{{ $ev->name }}</div>
                                                <div style="font-size:.7rem;color:#94a3b8;">{{ $ev->category->name ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-size:.8rem;color:#64748b;white-space:nowrap;">{{ $ev->date->format('d M Y') }}</td>
                                    <td><span class="abadge {{ $evCls }}">{{ $evLabel }}</span></td>
                                    <td>
                                        <div style="min-width:90px;">
                                            <div style="display:flex;justify-content:space-between;font-size:.68rem;font-weight:600;color:#94a3b8;margin-bottom:3px;">
                                                <span>{{ $ev->registered_count }}/{{ $ev->quota }}</span>
                                                <span>{{ $evPct }}%</span>
                                            </div>
                                            <div style="height:5px;background:#f1f5f9;border-radius:999px;overflow:hidden;">
                                                <div style="height:100%;width:{{ $evPct }}%;background:{{ $evPct >= 85 ? '#ef4444' : '#1d4ed8' }};border-radius:999px;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/events/' . $ev->id . '/edit') }}" class="abtn abtn-outline abtn-sm">Kelola</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="text-align:center;padding:2rem;color:#94a3b8;">
                                        <div style="font-size:1.5rem;margin-bottom:.5rem;">📅</div>
                                        <div>Belum ada event. <a href="{{ url('/admin/events/create') }}" style="color:#1d4ed8;font-weight:600;">Buat event pertama</a></div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Charts row — pendaftar 7 hari terakhir (real DB) + status event --}}
                @php
                    $last7Days = collect(range(6, 0))->map(function($i) {
                        $date = \Carbon\Carbon::today()->subDays($i);
                        return [
                            'label' => $date->format('D'),
                            'count' => \App\Models\EventParticipant::whereDate('created_at', $date)->count(),
                        ];
                    });
                    $maxCount = $last7Days->max('count') ?: 1;

                    $statusCounts = [
                        'completed' => \App\Models\Event::where('status','completed')->count(),
                        'open'      => \App\Models\Event::where('status','open')->count(),
                        'draft'     => \App\Models\Event::whereIn('status',['draft','closed','cancelled'])->count(),
                    ];
                    $totalForDonut = array_sum($statusCounts) ?: 1;
                @endphp
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

                    {{-- Bar chart: pendaftar 7 hari terakhir --}}
                    <div class="admin-card">
                        <div class="admin-card-hd">
                            <span class="admin-card-title">Pendaftar (7 Hari Terakhir)</span>
                        </div>
                        <div class="admin-card-body">
                            <div style="display:flex;align-items:flex-end;gap:.5rem;height:100px;">
                                @foreach($last7Days as $day)
                                @php $barPct = round(($day['count'] / $maxCount) * 100); @endphp
                                <div style="display:flex;flex-direction:column;align-items:center;gap:.3rem;flex:1;">
                                    <div style="font-size:.62rem;color:#94a3b8;font-weight:600;">{{ $day['count'] }}</div>
                                    <div style="width:100%;height:{{ max(8, $barPct) }}%;border-radius:.375rem .375rem 0 0;background:{{ $day['count'] > 0 ? '#1d4ed8' : '#e2e8f0' }};min-height:8px;transition:height .6s;"></div>
                                    <div style="font-size:.62rem;color:#94a3b8;font-weight:600;">{{ $day['label'] }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Donut: status event --}}
                    <div class="admin-card">
                        <div class="admin-card-hd">
                            <span class="admin-card-title">Status Event</span>
                        </div>
                        <div class="admin-card-body" style="display:flex;align-items:center;gap:1.25rem;">
                            @php
                                $r = 38;
                                $circ = 2 * M_PI * $r;
                                $completedDash = ($statusCounts['completed'] / $totalForDonut) * $circ;
                                $openDash      = ($statusCounts['open'] / $totalForDonut) * $circ;
                                $draftDash     = ($statusCounts['draft'] / $totalForDonut) * $circ;
                                $openOffset    = -$completedDash;
                                $draftOffset   = -$completedDash - $openDash;
                            @endphp
                            <svg width="100" height="100" viewBox="0 0 100 100" style="flex-shrink:0;">
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="#f1f5f9" stroke-width="12"/>
                                @if($statusCounts['completed'] > 0)
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="#10b981" stroke-width="12"
                                    stroke-dasharray="{{ round($completedDash, 2) }} {{ round($circ - $completedDash, 2) }}"
                                    stroke-dashoffset="0" stroke-linecap="round" transform="rotate(-90 50 50)"/>
                                @endif
                                @if($statusCounts['open'] > 0)
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="#3b82f6" stroke-width="12"
                                    stroke-dasharray="{{ round($openDash, 2) }} {{ round($circ - $openDash, 2) }}"
                                    stroke-dashoffset="{{ round($openOffset, 2) }}" stroke-linecap="round" transform="rotate(-90 50 50)"/>
                                @endif
                                <text x="50" y="46" text-anchor="middle" font-size="14" font-weight="800" fill="#0f172a">{{ $stats['total_events'] }}</text>
                                <text x="50" y="59" text-anchor="middle" font-size="8" fill="#94a3b8">Total</text>
                            </svg>
                            <div style="display:flex;flex-direction:column;gap:.5rem;flex:1;">
                                @foreach([['Selesai','#10b981',$statusCounts['completed']],['Aktif','#3b82f6',$statusCounts['open']],['Lainnya','#f59e0b',$statusCounts['draft']]] as $s)
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

                {{-- Admin identity card dari Auth::user() --}}
                @php $adminUser = Auth::user(); @endphp
                <div style="background:linear-gradient(145deg,#0f1f4e,#1e3a8a);border-radius:1rem;padding:1.25rem;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-30px;right:-30px;width:100px;height:100px;background:rgba(255,255,255,.06);border-radius:50%;"></div>
                    <div style="position:relative;z-index:2;">
                        <div style="width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,#60a5fa,#818cf8);display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:800;color:#fff;border:2px solid rgba(255,255,255,.25);margin-bottom:.75rem;">
                            {{ strtoupper(substr($adminUser->name, 0, 1)) }}
                        </div>
                        <div style="font-size:.95rem;font-weight:800;color:#fff;">{{ $adminUser->name }}</div>
                        <div style="font-size:.7rem;color:rgba(255,255,255,.55);margin-top:2px;">{{ $adminUser->email }}</div>
                        <div style="display:inline-flex;align-items:center;gap:.3rem;background:rgba(255,255,255,.15);color:#bfdbfe;font-size:.65rem;font-weight:700;padding:.18rem .55rem;border-radius:999px;margin-top:.45rem;letter-spacing:.02em;">Admin · OSIS</div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-top:.875rem;">
                            @foreach([
                                [$stats['total_events'], 'Event'],
                                [$stats['total_participants'], 'Peserta'],
                                [$stats['completed_events'], 'Selesai'],
                                [$stats['active_events'], 'Aktif'],
                            ] as $s)
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
                            ['/admin/events/create', 'Buat Event',  '#dbeafe', '#1d4ed8', '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>'],
                            ['/admin/participants',  'Peserta',     '#dcfce7', '#15803d', '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>'],
                            ['/admin/attendance',    'Kehadiran',   '#fef3c7', '#b45309', '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
                            ['/admin/announcements', 'Pengumuman',  '#ede9fe', '#6d28d9', '<path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3z"/>'],
                            ['/admin/certificates',  'Sertifikat',  '#fee2e2', '#dc2626', '<circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>'],
                            ['/admin/students',      'Data Siswa',  '#f0fdf4', '#15803d', '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/>'],
                        ] as $qa)
                        <a href="{{ url($qa[0]) }}" style="display:flex;flex-direction:column;align-items:center;gap:.35rem;padding:.65rem .5rem;border:1.5px solid #e8edf5;background:#f8fafc;border-radius:.75rem;text-decoration:none;color:#0f172a;font-size:.68rem;font-weight:700;text-align:center;transition:all .15s;"
                           onmouseover="this.style.borderColor='#1d4ed8';this.style.background='#eff6ff';this.style.color='#1d4ed8'"
                           onmouseout="this.style.borderColor='#e8edf5';this.style.background='#f8fafc';this.style.color='#0f172a'">
                            <div style="width:32px;height:32px;border-radius:.5rem;background:{{ $qa[2] }};display:flex;align-items:center;justify-content:center;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="{{ $qa[3] }}" stroke-width="2">{!! $qa[4] !!}</svg>
                            </div>
                            {{ $qa[1] }}
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- "Perlu Perhatian" — real dari DB --}}
                <div class="admin-card">
                    <div class="admin-card-hd">
                        <span class="admin-card-title">Perlu Perhatian</span>
                    </div>
                    @php
                        $attentionItems = collect();

                        // Event hampir penuh (>= 80% kuota)
                        $almostFull = \App\Models\Event::active()
                            ->upcoming()
                            ->where('quota', '>', 0)
                            ->whereRaw('registered_count >= quota * 0.8')
                            ->orderByRaw('registered_count / quota DESC')
                            ->limit(3)
                            ->get();
                        foreach ($almostFull as $ev) {
                            $pctFull = round($ev->registered_count / $ev->quota * 100);
                            $attentionItems->push(['color'=>'red','text'=> $ev->name . " hampir penuh ({$ev->registered_count}/{$ev->quota})",'tag'=>'Urgent']);
                        }

                        // Event mendatang dalam 3 hari
                        $soonEvents = \App\Models\Event::active()
                            ->whereBetween('date', [\Carbon\Carbon::today(), \Carbon\Carbon::today()->addDays(3)])
                            ->whereNotIn('id', $almostFull->pluck('id'))
                            ->limit(2)
                            ->get();
                        foreach ($soonEvents as $ev) {
                            $attentionItems->push(['color'=>'orange','text'=> $ev->name . ' — ' . $ev->days_until_event . ' hari lagi','tag'=>'Soon']);
                        }

                        // Peserta belum dicek absen
                        $unchecked = \App\Models\EventParticipant::where('attendance_status','registered')
                            ->whereHas('event', fn($q) => $q->where('date','<',\Carbon\Carbon::today()))
                            ->count();
                        if ($unchecked > 0) {
                            $attentionItems->push(['color'=>'blue','text'=> $unchecked . ' peserta belum dicatat kehadirannya','tag'=>'Pending']);
                        }
                    @endphp

                    @forelse($attentionItems as $item)
                    @php $dotColors = ['red'=>'#ef4444','orange'=>'#f59e0b','blue'=>'#3b82f6']; @endphp
                    <div style="display:flex;align-items:center;gap:.75rem;padding:.7rem 1rem;border-bottom:1px solid #f1f5f9;">
                        <div style="width:7px;height:7px;border-radius:50%;background:{{ $dotColors[$item['color']] }};flex-shrink:0;"></div>
                        <div style="flex:1;font-size:.78rem;font-weight:600;color:#0f172a;line-height:1.4;">{{ $item['text'] }}</div>
                        <span style="font-size:.62rem;font-weight:700;padding:.12rem .5rem;border-radius:999px;background:#f1f5f9;color:#64748b;white-space:nowrap;">{{ $item['tag'] }}</span>
                    </div>
                    @empty
                    <div style="padding:1rem;text-align:center;color:#94a3b8;font-size:.8rem;">
                        ✅ Semua berjalan baik
                    </div>
                    @endforelse

                    {{-- Aktivitas Terbaru dari DB --}}
                    <div style="padding:.875rem 1rem .625rem;font-size:.72rem;font-weight:800;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;border-top:1px solid #f1f5f9;margin-top:.25rem;">Aktivitas Terbaru</div>
                    @php
                        $recentActivity = \App\Models\EventParticipant::with(['user','event'])
                            ->orderBy('created_at','desc')
                            ->limit(4)
                            ->get();
                    @endphp
                    @forelse($recentActivity as $act)
                    <div style="display:flex;align-items:flex-start;gap:.75rem;padding:.625rem 1rem;border-bottom:1px solid #f8fafc;">
                        <div style="width:32px;height:32px;border-radius:.5rem;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.9rem;">👤</div>
                        <div>
                            <div style="font-size:.775rem;font-weight:600;color:#0f172a;line-height:1.4;">
                                {{ $act->user->name }} mendaftar <em>{{ $act->event->name }}</em>
                            </div>
                            <div style="font-size:.68rem;color:#94a3b8;margin-top:2px;">{{ $act->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div style="padding:1rem;text-align:center;color:#94a3b8;font-size:.8rem;">Belum ada aktivitas</div>
                    @endforelse
                </div>

            </div>{{-- /right --}}

        </div>{{-- /grid --}}
    </div>{{-- /admin-content --}}
</div>{{-- /admin-main --}}

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

</body>
</html>
