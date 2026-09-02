<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kehadiran — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/attendance.css',
    ])
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>

<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

@include('admin.partials.sidebar', ['activePage' => 'attendance'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Kehadiran</h1>
                <p class="admin-page-hd-sub">Catat dan pantau kehadiran peserta per event</p>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div style="background:#dcfce7;border:1.5px solid #86efac;color:#15803d;padding:.75rem 1rem;border-radius:.75rem;margin-bottom:1rem;font-size:.875rem;font-weight:600;">
            ✅ {{ session('success') }}
        </div>
        @endif

        {{-- Summary cards --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:.875rem;margin-bottom:1.25rem;">
            @foreach([
                ['Total Peserta',   $summary['total'],     '#3b82f6', '👥'],
                ['Hadir',          $summary['present'],    '#10b981', '✅'],
                ['Tidak Hadir',    $summary['absent'],     '#ef4444', '❌'],
                ['Belum Dicek',    $summary['unchecked'],  '#f59e0b', '⏳'],
            ] as [$lbl, $val, $color, $icon])
            <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:.875rem;padding:.875rem 1rem;display:flex;align-items:center;gap:.75rem;">
                <div style="font-size:1.4rem;">{{ $icon }}</div>
                <div>
                    <div style="font-size:1.35rem;font-weight:800;color:{{ $color }};line-height:1;">{{ $val }}</div>
                    <div style="font-size:.72rem;color:#64748b;font-weight:500;margin-top:2px;">{{ $lbl }}</div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Filter form --}}
        <form method="GET" action="{{ url('/admin/attendance') }}" id="filterForm">
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
                                {{ $ev->name }} ({{ $ev->date->format('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                    <select class="admin-select" name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="present"    {{ request('status') === 'present'    ? 'selected' : '' }}>Hadir</option>
                        <option value="absent"     {{ request('status') === 'absent'     ? 'selected' : '' }}>Tidak Hadir</option>
                        <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Belum Dicek</option>
                        <option value="cancelled"  {{ request('status') === 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @if(request()->hasAny(['search','event_id','status']))
                        <a href="{{ url('/admin/attendance') }}" class="abtn abtn-secondary abtn-sm">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Attendance Table --}}
        <div class="admin-table-wrap">
            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Peserta</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Event</th>
                            <th>Tgl. Daftar</th>
                            <th>Status Kehadiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        @forelse($participants as $p)
                        @php
                            $statusMap = [
                                'present'    => ['Hadir',        'abadge-green'],
                                'absent'     => ['Tidak Hadir',  'abadge-red'],
                                'registered' => ['Belum Dicek',  'abadge-yellow'],
                                'cancelled'  => ['Dibatalkan',   'abadge-gray'],
                            ];
                            [$statusLabel, $statusClass] = $statusMap[$p->attendance_status] ?? ['?','abadge-gray'];
                        @endphp
                        <tr id="row-{{ $p->id }}">
                            <td>
                                <div style="font-weight:700;color:#0f172a;font-size:.875rem;">{{ $p->user->name }}</div>
                            </td>
                            <td style="color:#64748b;font-size:.82rem;">{{ $p->user->nis ?? '-' }}</td>
                            <td style="color:#64748b;font-size:.82rem;">{{ $p->user->class ?? '-' }}</td>
                            <td>
                                <div style="font-size:.82rem;font-weight:600;color:#0f172a;">{{ $p->event->name }}</div>
                                <div style="font-size:.7rem;color:#94a3b8;">{{ $p->event->date->format('d M Y') }}</div>
                            </td>
                            <td style="color:#64748b;font-size:.78rem;">{{ $p->registration_date->format('d M Y') }}</td>
                            <td>
                                <span class="abadge {{ $statusClass }}" id="badge-{{ $p->id }}">{{ $statusLabel }}</span>
                            </td>
                            <td>
                                <div class="attendance-actions" style="display:flex;gap:.35rem;">
                                    <button class="abtn abtn-sm {{ $p->attendance_status === 'present' ? 'abtn-success' : 'abtn-outline' }}"
                                            onclick="markAttendance({{ $p->id }}, 'present', this)"
                                            {{ $p->attendance_status === 'present' ? 'disabled' : '' }}>
                                        ✓ Hadir
                                    </button>
                                    <button class="abtn abtn-sm {{ $p->attendance_status === 'absent' ? 'abtn-danger' : 'abtn-outline' }}"
                                            onclick="markAttendance({{ $p->id }}, 'absent', this)"
                                            {{ $p->attendance_status === 'absent' ? 'disabled' : '' }}>
                                        ✗ Absen
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3rem;color:#94a3b8;">
                                <div style="font-size:2rem;margin-bottom:.75rem;">📋</div>
                                <div style="font-weight:600;margin-bottom:.25rem;">Belum ada data kehadiran</div>
                                @if(request()->hasAny(['search','event_id','status']))
                                    <div style="font-size:.82rem;">Tidak ada peserta yang cocok dengan filter.</div>
                                    <a href="{{ url('/admin/attendance') }}" class="abtn abtn-outline abtn-sm" style="margin-top:.75rem;display:inline-block;">Reset Filter</a>
                                @else
                                    <div style="font-size:.82rem;">Pastikan ada siswa yang mendaftar event terlebih dahulu.</div>
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
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
function markAttendance(participantId, status, clickedBtn) {
    var row = document.getElementById('row-' + participantId);
    var badge = document.getElementById('badge-' + participantId);
    var buttons = row.querySelectorAll('.attendance-actions button');

    // Disable all buttons saat proses
    buttons.forEach(function(b) { b.disabled = true; b.style.opacity = '0.6'; });

    fetch('/api/admin/attendance/mark', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ participant_id: participantId, status: status })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            // Update badge
            if (status === 'present') {
                badge.className = 'abadge abadge-green';
                badge.textContent = 'Hadir';
            } else {
                badge.className = 'abadge abadge-red';
                badge.textContent = 'Tidak Hadir';
            }

            // Update tombol: yang diklik jadi aktif, yang lain kembali outline
            buttons.forEach(function(b) {
                b.style.opacity = '1';
                var btnStatus = b.getAttribute('onclick').includes("'present'") ? 'present' : 'absent';
                if (btnStatus === status) {
                    b.disabled = true;
                    b.className = 'abtn abtn-sm ' + (status === 'present' ? 'abtn-success' : 'abtn-danger');
                } else {
                    b.disabled = false;
                    b.className = 'abtn abtn-sm abtn-outline';
                }
            });

            // Update summary counts di page
            updateSummaryBadge();
        } else {
            alert('Gagal: ' + (data.message || 'Terjadi kesalahan.'));
            buttons.forEach(function(b) { b.disabled = false; b.style.opacity = '1'; });
        }
    })
    .catch(function(err) {
        console.error(err);
        alert('Terjadi kesalahan koneksi.');
        buttons.forEach(function(b) { b.disabled = false; b.style.opacity = '1'; });
    });
}

function updateSummaryBadge() {
    // Hitung ulang dari DOM
    var rows = document.querySelectorAll('#attendanceTableBody tr[id^="row-"]');
    var counts = { present: 0, absent: 0, registered: 0 };
    rows.forEach(function(row) {
        var badge = row.querySelector('.abadge');
        if (!badge) return;
        if (badge.classList.contains('abadge-green'))  counts.present++;
        else if (badge.classList.contains('abadge-red')) counts.absent++;
        else counts.registered++;
    });
    // Update summary cards (index 0=total,1=hadir,2=tidak,3=belum)
    var cards = document.querySelectorAll('.admin-content > div:first-of-type > div');
    if (cards[1]) cards[1].querySelector('div > div:first-child').textContent = counts.present;
    if (cards[2]) cards[2].querySelector('div > div:first-child').textContent = counts.absent;
    if (cards[3]) cards[3].querySelector('div > div:first-child').textContent = counts.registered;
}
</script>

</body>
</html>
