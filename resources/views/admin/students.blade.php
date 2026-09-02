<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Siswa — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/students.css',
    ])
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
@include('admin.partials.sidebar', ['activePage' => 'students'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Data Siswa</h1>
                <p class="admin-page-hd-sub">
                    Daftar siswa yang terdaftar di sistem
                    <span style="margin-left:.5rem;background:#f1f5f9;color:#64748b;padding:.15rem .5rem;border-radius:999px;font-size:.72rem;font-weight:700;">
                        {{ $totalStudents }} siswa · {{ $activeStudents }} aktif
                    </span>
                </p>
            </div>
        </div>

        {{-- Filter form --}}
        <form method="GET" action="{{ url('/admin/students') }}">
            <div class="admin-table-hd" style="flex-wrap:wrap;gap:.5rem;">
                <div class="admin-search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" class="admin-search-input" name="search"
                           placeholder="Cari nama, NIS, email, kelas..."
                           value="{{ request('search') }}"
                           oninput="clearTimeout(window._st);window._st=setTimeout(()=>this.form.submit(),500)">
                </div>
                <div class="admin-filter-row">
                    <select class="admin-select" name="class_level" onchange="this.form.submit()">
                        <option value="">Semua Tingkat</option>
                        <option value="X"   {{ request('class_level') === 'X'   ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI"  {{ request('class_level') === 'XI'  ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ request('class_level') === 'XII' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                    <select class="admin-select" name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @if(request()->hasAny(['search','class_level','status']))
                        <a href="{{ url('/admin/students') }}" class="abtn abtn-secondary abtn-sm">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        <div class="admin-table-wrap">
            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Email</th>
                            <th>Event Diikuti</th>
                            <th>Sertifikat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $s)
                        @php
                            $colors = ['#3b82f6','#7c3aed','#059669','#d97706','#db2777','#6366f1','#f59e0b','#8b5cf6'];
                            $color = $colors[crc32($s->name) % count($colors)];
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:.625rem;">
                                    <div style="width:34px;height:34px;border-radius:50%;background:{{ $color }};display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem;font-weight:700;flex-shrink:0;">
                                        {{ strtoupper(substr($s->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700;color:#0f172a;font-size:.875rem;">{{ $s->name }}</div>
                                        <div style="font-size:.7rem;color:#94a3b8;">Bergabung {{ $s->created_at->format('M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#64748b;font-size:.82rem;font-family:monospace;">{{ $s->nis ?? '-' }}</td>
                            <td style="color:#64748b;font-size:.82rem;">{{ $s->class ?? '-' }}</td>
                            <td style="color:#64748b;font-size:.78rem;">{{ $s->email }}</td>
                            <td style="text-align:center;font-weight:700;color:#0f172a;">{{ $s->registered_events_count }}</td>
                            <td style="text-align:center;font-weight:700;color:#0f172a;">{{ $s->certificates_count }}</td>
                            <td>
                                <span class="abadge {{ $s->status === 'active' ? 'abadge-green' : 'abadge-gray' }}">
                                    {{ $s->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <button class="abtn abtn-outline abtn-sm"
                                        onclick="openStudentDetail(
                                            '{{ addslashes($s->name) }}',
                                            '{{ $s->nis ?? '-' }}',
                                            '{{ addslashes($s->class ?? '-') }}',
                                            '{{ $s->email }}',
                                            '{{ $s->registered_events_count }}',
                                            '{{ $s->certificates_count }}',
                                            '{{ $s->status }}',
                                            '{{ $s->created_at->format('d M Y') }}'
                                        )">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:3rem;color:#94a3b8;">
                                <div style="font-size:2rem;margin-bottom:.75rem;">👤</div>
                                <div style="font-weight:600;margin-bottom:.25rem;">Belum ada siswa terdaftar</div>
                                @if(request()->hasAny(['search','class_level','status']))
                                    <a href="{{ url('/admin/students') }}" class="abtn abtn-outline abtn-sm" style="margin-top:.75rem;display:inline-block;">Reset Filter</a>
                                @else
                                    <div style="font-size:.82rem;">Siswa dapat mendaftar melalui halaman registrasi.</div>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($students->hasPages())
            <div class="admin-pagination">
                <span class="admin-pagination-info">
                    Menampilkan {{ $students->firstItem() }}–{{ $students->lastItem() }} dari {{ $students->total() }} siswa
                </span>
                <div class="admin-pagination-btns">
                    @if($students->onFirstPage())
                        <button class="admin-page-btn" disabled>‹</button>
                    @else
                        <a href="{{ $students->previousPageUrl() }}" class="admin-page-btn">‹</a>
                    @endif
                    @foreach($students->getUrlRange(max(1,$students->currentPage()-2), min($students->lastPage(),$students->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="admin-page-btn {{ $page == $students->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach
                    @if($students->hasMorePages())
                        <a href="{{ $students->nextPageUrl() }}" class="admin-page-btn">›</a>
                    @else
                        <button class="admin-page-btn" disabled>›</button>
                    @endif
                </div>
            </div>
            @else
            <div class="admin-pagination">
                <span class="admin-pagination-info">{{ $students->count() }} siswa</span>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- Detail Modal --}}
<div class="admin-modal-overlay" id="studentDetailModal" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="admin-modal" style="max-width:460px;">
        <div class="admin-modal-hd">
            <div class="admin-modal-icon" style="background:#dbeafe;color:#1d4ed8;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <h3 class="admin-modal-title" id="detailStudentName">Detail Siswa</h3>
        </div>
        <div style="padding:0 1.5rem 1rem;">
            <table style="width:100%;font-size:.85rem;border-collapse:collapse;" id="studentDetailTable">
            </table>
        </div>
        <div class="admin-modal-ft">
            <button type="button" class="abtn abtn-secondary" onclick="document.getElementById('studentDetailModal').classList.remove('active')">Tutup</button>
        </div>
    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
function openStudentDetail(name, nis, kelas, email, events, certs, status, joined) {
    document.getElementById('detailStudentName').textContent = name;
    var rows = [
        ['NIS', nis], ['Kelas', kelas], ['Email', email],
        ['Event Diikuti', events + ' event'],
        ['Sertifikat', certs + ' sertifikat'],
        ['Status', status === 'active' ? '<span class="abadge abadge-green">Aktif</span>' : '<span class="abadge abadge-gray">Nonaktif</span>'],
        ['Bergabung', joined],
    ];
    document.getElementById('studentDetailTable').innerHTML = rows.map(function(r) {
        return '<tr style="border-bottom:1px solid #f1f5f9;">'
            + '<td style="padding:.625rem 0;color:#64748b;font-weight:600;width:40%;">' + r[0] + '</td>'
            + '<td style="padding:.625rem 0;color:#0f172a;">' + r[1] + '</td></tr>';
    }).join('');
    document.getElementById('studentDetailModal').classList.add('active');
}
</script>
</body>
</html>
