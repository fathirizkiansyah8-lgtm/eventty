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

        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Peserta</h1>
                <p class="admin-page-hd-sub">
                    Seluruh pendaftaran event siswa
                    <span style="margin-left:.5rem;background:#f1f5f9;color:#64748b;padding:.15rem .5rem;border-radius:999px;font-size:.72rem;font-weight:700;">
                        {{ $totalParticipants }} total
                    </span>
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
</div>

{{-- Detail Modal --}}
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

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
function openDetail(name, nis, kelas, event, eventDate, status, regDate) {
    document.getElementById('detailName').textContent = name;
    var rows = [['NIS', nis],['Kelas', kelas],['Event', event],['Tanggal Event', eventDate],['Status', status],['Tanggal Daftar', regDate]];
    document.getElementById('detailTable').innerHTML = rows.map(function(r) {
        return '<tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:.625rem 0;color:#64748b;font-weight:600;width:40%;">' + r[0] + '</td><td style="padding:.625rem 0;color:#0f172a;">' + r[1] + '</td></tr>';
    }).join('');
    document.getElementById('participantDetailModal').classList.add('active');
}
</script>
</body>
</html>
