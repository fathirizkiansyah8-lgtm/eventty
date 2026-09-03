<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Peserta — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/participants.css',
    ])
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
@include('admin.partials.sidebar', ['activePage' => 'participants'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        {{-- Page header --}}
        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Peserta</h1>
                <p class="admin-page-hd-sub">
                    Seluruh pendaftaran event siswa
                    <span style="margin-left:.5rem;background:#f1f5f9;color:#64748b;padding:.15rem .5rem;border-radius:999px;font-size:.72rem;font-weight:700;">
                        {{ $totalParticipants }} total
                    </span>
                    @if($isCompetition && $selectedEvent)
                        <span style="margin-left:.35rem;background:#fef3c7;color:#b45309;padding:.15rem .5rem;border-radius:999px;font-size:.72rem;font-weight:700;">
                            🏆 Event Kompetisi — {{ $teamRegistrations->count() }} tim terdaftar
                        </span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Filter form --}}
        <form method="GET" action="{{ url('/admin/participants') }}">
            <div class="admin-table-hd" style="flex-wrap:wrap;gap:.5rem;">
                <div class="admin-search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" class="admin-search-input" name="search"
                           placeholder="Cari nama, NIS, atau kelas..."
                           value="{{ request('search') }}"
                           oninput="clearTimeout(window._st);window._st=setTimeout(()=>this.form.submit(),500)">
                </div>
                <div class="admin-filter-row">
                    <select class="admin-select" name="event_id" onchange="this.form.submit()">
                        <option value="">Semua Event</option>
                        @foreach($events as $ev)
                            <option value="{{ $ev->id }}" {{ request('event_id') == $ev->id ? 'selected' : '' }}>
                                {{ $ev->name }}
                                @if(strtolower($ev->category->name ?? '') === 'competition') (Kompetisi) @endif
                            </option>
                        @endforeach
                    </select>
                    <select class="admin-select" name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Terdaftar</option>
                        <option value="present"    {{ request('status') === 'present'    ? 'selected' : '' }}>Hadir</option>
                        <option value="absent"     {{ request('status') === 'absent'     ? 'selected' : '' }}>Tidak Hadir</option>
                        <option value="cancelled"  {{ request('status') === 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @if(request()->hasAny(['search','event_id','status']))
                        <a href="{{ url('/admin/participants') }}" class="abtn abtn-secondary abtn-sm">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- ════════════════════════════════════════════
             COMPETITION EVENT: Tab switcher
        ════════════════════════════════════════════ --}}
        @if($isCompetition && $selectedEvent)
        <div style="display:flex;gap:4px;background:#f1f5f9;border-radius:.75rem;padding:4px;width:fit-content;margin-bottom:1.25rem;">
            <button id="tabPeserta" onclick="switchParticipantTab('peserta')"
                    style="padding:.45rem 1.1rem;border-radius:.5rem;font-size:.82rem;font-weight:700;border:none;cursor:pointer;background:#fff;color:#0f172a;box-shadow:0 1px 4px rgba(0,0,0,.08);transition:all .2s;font-family:inherit;">
                👥 Peserta ({{ $participants->total() }})
            </button>
            <button id="tabTim" onclick="switchParticipantTab('tim')"
                    style="padding:.45rem 1.1rem;border-radius:.5rem;font-size:.82rem;font-weight:700;border:none;cursor:pointer;background:transparent;color:#64748b;transition:all .2s;font-family:inherit;">
                🏆 Data Tim ({{ $teamRegistrations->count() }})
            </button>
        </div>
        @endif

        {{-- ════════════════════════════════════════════
             PANEL PESERTA (tabel pendaftar)
        ════════════════════════════════════════════ --}}
        <div id="panelPeserta">
            <div class="admin-table-wrap">
                <div class="admin-table-scroll">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama Peserta</th>
                                <th>NIS</th>
                                <th>Kelas</th>
                                <th>Event</th>
                                <th>Tgl. Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($participants as $p)
                            @php
                                $statusMap = [
                                    'registered' => ['Terdaftar',   'abadge-blue'],
                                    'present'    => ['Hadir',       'abadge-green'],
                                    'absent'     => ['Tidak Hadir', 'abadge-red'],
                                    'cancelled'  => ['Dibatalkan',  'abadge-gray'],
                                ];
                                [$slabel, $scls] = $statusMap[$p->attendance_status] ?? ['?', 'abadge-gray'];
                            @endphp
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.625rem;">
                                        <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#1e40af,#3b82f6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.75rem;font-weight:800;flex-shrink:0;">
                                            {{ strtoupper(substr($p->user->name, 0, 1)) }}
                                        </div>
                                        <span style="font-weight:700;color:#0f172a;font-size:.875rem;">{{ $p->user->name }}</span>
                                    </div>
                                </td>
                                <td style="color:#64748b;font-size:.82rem;font-family:monospace;">{{ $p->user->nis ?? '-' }}</td>
                                <td style="color:#64748b;font-size:.82rem;">{{ $p->user->class ?? '-' }}</td>
                                <td>
                                    <div style="font-size:.82rem;font-weight:600;color:#0f172a;">{{ $p->event->name }}</div>
                                    <div style="font-size:.7rem;color:#94a3b8;">{{ $p->event->date->format('d M Y') }}</div>
                                </td>
                                <td style="color:#64748b;font-size:.78rem;">{{ $p->registration_date->format('d M Y') }}</td>
                                <td><span class="abadge {{ $scls }}">{{ $slabel }}</span></td>
                                <td>
                                    <button class="abtn abtn-outline abtn-sm"
                                            onclick="openDetail(
                                                '{{ addslashes($p->user->name) }}',
                                                '{{ $p->user->nis ?? '-' }}',
                                                '{{ addslashes($p->user->class ?? '-') }}',
                                                '{{ addslashes($p->event->name) }}',
                                                '{{ $p->event->date->format('d M Y') }}',
                                                '{{ $slabel }}',
                                                '{{ $p->registration_date->format('d M Y') }}'
                                            )">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align:center;padding:3rem;color:#94a3b8;">
                                    <div style="font-size:2rem;margin-bottom:.75rem;">👥</div>
                                    <div style="font-weight:600;margin-bottom:.25rem;">Belum ada peserta</div>
                                    @if(request()->hasAny(['search','event_id','status']))
                                        <a href="{{ url('/admin/participants') }}" class="abtn abtn-outline abtn-sm" style="margin-top:.75rem;display:inline-block;">Reset Filter</a>
                                    @else
                                        <div style="font-size:.82rem;">Peserta akan muncul setelah siswa mendaftar event.</div>
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($participants->hasPages())
                <div class="admin-pagination">
                    <span class="admin-pagination-info">
                        Menampilkan {{ $participants->firstItem() }}–{{ $participants->lastItem() }} dari {{ $participants->total() }} peserta
                    </span>
                    <div class="admin-pagination-btns">
                        @if($participants->onFirstPage())
                            <button class="admin-page-btn" disabled>‹</button>
                        @else
                            <a href="{{ $participants->previousPageUrl() }}" class="admin-page-btn">‹</a>
                        @endif
                        @foreach($participants->getUrlRange(max(1,$participants->currentPage()-2), min($participants->lastPage(),$participants->currentPage()+2)) as $page => $url)
                            <a href="{{ $url }}" class="admin-page-btn {{ $page == $participants->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach
                        @if($participants->hasMorePages())
                            <a href="{{ $participants->nextPageUrl() }}" class="admin-page-btn">›</a>
                        @else
                            <button class="admin-page-btn" disabled>›</button>
                        @endif
                    </div>
                </div>
                @else
                <div class="admin-pagination">
                    <span class="admin-pagination-info">{{ $participants->count() }} peserta</span>
                </div>
                @endif
            </div>
        </div>

        {{-- ════════════════════════════════════════════
             PANEL TIM (hanya untuk competition)
        ════════════════════════════════════════════ --}}
        @if($isCompetition && $selectedEvent)
        <div id="panelTim" style="display:none;">

            @if($teamRegistrations->count() > 0)

            {{-- Summary --}}
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.875rem;margin-bottom:1.25rem;">
                <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:.875rem;padding:.875rem 1rem;text-align:center;">
                    <div style="font-size:1.5rem;font-weight:800;color:#0f172a;">{{ $teamRegistrations->count() }}</div>
                    <div style="font-size:.72rem;color:#64748b;font-weight:600;margin-top:2px;">Tim Terdaftar</div>
                </div>
                <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:.875rem;padding:.875rem 1rem;text-align:center;">
                    <div style="font-size:1.5rem;font-weight:800;color:#0f172a;">
                        {{ $teamRegistrations->sum(fn($t) => count($t->members) + 1) }}
                    </div>
                    <div style="font-size:.72rem;color:#64748b;font-weight:600;margin-top:2px;">Total Anggota</div>
                </div>
                <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:.875rem;padding:.875rem 1rem;text-align:center;">
                    <div style="font-size:1rem;font-weight:800;color:#b45309;">
                        {{ $selectedEvent->name }}
                    </div>
                    <div style="font-size:.72rem;color:#64748b;font-weight:600;margin-top:2px;">Event Kompetisi</div>
                </div>
            </div>

            {{-- Tabel tim --}}
            <div class="admin-table-wrap">
                <div style="padding:.875rem 1rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:.875rem;font-weight:800;color:#0f172a;">Daftar Tim Peserta</span>
                    <span style="font-size:.78rem;color:#64748b;">{{ $teamRegistrations->count() }} tim</span>
                </div>
                <div class="admin-table-scroll">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Nama Tim</th>
                                <th>Kapten Tim</th>
                                <th>Anggota Tim</th>
                                <th>Total Anggota</th>
                                <th>Tgl. Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teamRegistrations as $i => $team)
                            <tr>
                                <td style="color:#94a3b8;font-weight:700;font-size:.82rem;">{{ $i + 1 }}</td>
                                <td>
                                    <div style="font-weight:800;font-size:.9rem;color:#0f172a;">{{ $team->team_name }}</div>
                                    <div style="font-size:.7rem;color:#94a3b8;margin-top:1px;">ID #{{ $team->id }}</div>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.5rem;">
                                        <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;font-weight:800;flex-shrink:0;">
                                            {{ strtoupper(substr($team->captain_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:700;font-size:.82rem;color:#0f172a;">{{ $team->captain_name }}</div>
                                            <div style="font-size:.68rem;color:#94a3b8;">
                                                NIS: {{ $team->captain->nis ?? '-' }} · {{ $team->captain->class ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if(count($team->members) > 0)
                                        <div style="display:flex;flex-direction:column;gap:2px;">
                                            @foreach($team->members as $member)
                                                <div style="display:flex;align-items:center;gap:.35rem;">
                                                    <div style="width:5px;height:5px;border-radius:50%;background:#3b82f6;flex-shrink:0;"></div>
                                                    <span style="font-size:.78rem;color:#475569;">{{ $member }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span style="color:#94a3b8;font-size:.78rem;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="background:#fef3c7;color:#b45309;padding:.25rem .6rem;border-radius:999px;font-size:.75rem;font-weight:700;">
                                        {{ $team->total_members }} orang
                                    </span>
                                </td>
                                <td style="color:#64748b;font-size:.78rem;white-space:nowrap;">
                                    {{ $team->created_at->format('d M Y') }}<br>
                                    <span style="font-size:.7rem;color:#94a3b8;">{{ $team->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    <button class="abtn abtn-outline abtn-sm"
                                            onclick="openTeamDetail(
                                                '{{ addslashes($team->team_name) }}',
                                                '{{ addslashes($team->captain_name) }}',
                                                '{{ addslashes($team->captain->nis ?? '-') }}',
                                                '{{ addslashes($team->captain->class ?? '-') }}',
                                                @json($team->members),
                                                '{{ $team->created_at->format('d M Y H:i') }}'
                                            )">
                                        Detail Tim
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @else
            {{-- Empty state --}}
            <div style="text-align:center;padding:3rem;color:#94a3b8;background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:1rem;">
                <div style="font-size:2.5rem;margin-bottom:.75rem;">🏆</div>
                <div style="font-weight:600;font-size:.975rem;color:#0f172a;margin-bottom:.35rem;">Belum ada tim yang mendaftar</div>
                <div style="font-size:.82rem;">Tim akan muncul setelah peserta mendaftar melalui form kompetisi.</div>
            </div>
            @endif

        </div>
        @endif

    </div>
</div>

{{-- ══ Modal: Detail Peserta ══ --}}
<div class="admin-modal-overlay" id="participantDetailModal" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="admin-modal" style="max-width:460px;">
        <div class="admin-modal-hd">
            <div class="admin-modal-icon" style="background:#dbeafe;color:#1d4ed8;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <h3 class="admin-modal-title" id="detailName">Detail Peserta</h3>
        </div>
        <div style="padding:0 1.5rem 1rem;"><table style="width:100%;font-size:.85rem;border-collapse:collapse;" id="detailTable"></table></div>
        <div class="admin-modal-ft">
            <button type="button" class="abtn abtn-secondary" onclick="document.getElementById('participantDetailModal').classList.remove('active')">Tutup</button>
        </div>
    </div>
</div>

{{-- ══ Modal: Detail Tim ══ --}}
<div class="admin-modal-overlay" id="teamDetailModal" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="admin-modal" style="max-width:480px;">
        <div class="admin-modal-hd">
            <div class="admin-modal-icon" style="background:#fef3c7;color:#b45309;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3 class="admin-modal-title" id="teamDetailTitle">Detail Tim</h3>
        </div>
        <div style="padding:0 1.5rem 1rem;" id="teamDetailBody"></div>
        <div class="admin-modal-ft">
            <button type="button" class="abtn abtn-secondary" onclick="document.getElementById('teamDetailModal').classList.remove('active')">Tutup</button>
        </div>
    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
// ── Tab switcher ──
function switchParticipantTab(tab) {
    var isPeserta = tab === 'peserta';
    document.getElementById('panelPeserta').style.display  = isPeserta ? '' : 'none';
    var panelTim = document.getElementById('panelTim');
    if (panelTim) panelTim.style.display = isPeserta ? 'none' : '';

    var btnP = document.getElementById('tabPeserta');
    var btnT = document.getElementById('tabTim');
    if (btnP) {
        btnP.style.background  = isPeserta ? '#fff' : 'transparent';
        btnP.style.color       = isPeserta ? '#0f172a' : '#64748b';
        btnP.style.boxShadow   = isPeserta ? '0 1px 4px rgba(0,0,0,.08)' : 'none';
    }
    if (btnT) {
        btnT.style.background  = !isPeserta ? '#fff' : 'transparent';
        btnT.style.color       = !isPeserta ? '#0f172a' : '#64748b';
        btnT.style.boxShadow   = !isPeserta ? '0 1px 4px rgba(0,0,0,.08)' : 'none';
    }
}

// ── Detail peserta modal ──
function openDetail(name, nis, kelas, event, eventDate, status, regDate) {
    document.getElementById('detailName').textContent = name;
    var rows = [
        ['NIS', nis], ['Kelas', kelas], ['Event', event],
        ['Tanggal Event', eventDate], ['Status', status], ['Tanggal Daftar', regDate]
    ];
    document.getElementById('detailTable').innerHTML = rows.map(function(r) {
        return '<tr style="border-bottom:1px solid #f1f5f9;">'
            + '<td style="padding:.625rem 0;color:#64748b;font-weight:600;width:40%;">' + r[0] + '</td>'
            + '<td style="padding:.625rem 0;color:#0f172a;">' + r[1] + '</td></tr>';
    }).join('');
    document.getElementById('participantDetailModal').classList.add('active');
}

// ── Detail tim modal ──
function openTeamDetail(teamName, captainName, captainNis, captainClass, members, regDate) {
    document.getElementById('teamDetailTitle').textContent = teamName;
    var memberList = Array.isArray(members) && members.length
        ? members.map(function(m){ return '<li style="padding:.2rem 0;">' + m + '</li>'; }).join('')
        : '<li style="color:#94a3b8;">—</li>';

    document.getElementById('teamDetailBody').innerHTML =
        '<table style="width:100%;font-size:.85rem;border-collapse:collapse;">'
        + '<tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:.625rem 0;color:#64748b;font-weight:600;width:40%;">Nama Tim</td><td style="padding:.625rem 0;font-weight:800;color:#0f172a;">' + teamName + '</td></tr>'
        + '<tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:.625rem 0;color:#64748b;font-weight:600;">Kapten</td><td style="padding:.625rem 0;color:#0f172a;">' + captainName + '</td></tr>'
        + '<tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:.625rem 0;color:#64748b;font-weight:600;">NIS Kapten</td><td style="padding:.625rem 0;color:#0f172a;">' + captainNis + '</td></tr>'
        + '<tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:.625rem 0;color:#64748b;font-weight:600;">Kelas Kapten</td><td style="padding:.625rem 0;color:#0f172a;">' + captainClass + '</td></tr>'
        + '<tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:.625rem 0;color:#64748b;font-weight:600;vertical-align:top;">Anggota</td>'
        + '<td style="padding:.625rem 0;color:#0f172a;"><ul style="margin:0;padding-left:1.1rem;">' + memberList + '</ul></td></tr>'
        + '<tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:.625rem 0;color:#64748b;font-weight:600;">Total</td>'
        + '<td style="padding:.625rem 0;font-weight:700;color:#b45309;">' + (Array.isArray(members) ? members.length + 1 : 1) + ' orang (kapten + anggota)</td></tr>'
        + '<tr><td style="padding:.625rem 0;color:#64748b;font-weight:600;">Tgl. Daftar</td><td style="padding:.625rem 0;color:#0f172a;">' + regDate + '</td></tr>'
        + '</table>';

    document.getElementById('teamDetailModal').classList.add('active');
}
</script>
</body>
</html>
