<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Event — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/events.css',
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

@include('admin.partials.sidebar', ['activePage' => 'events'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Kelola Event</h1>
                <p class="admin-page-hd-sub">
                    Buat, edit, dan pantau semua event sekolah
                    <span style="margin-left:.5rem;background:#f1f5f9;color:#64748b;padding:.15rem .5rem;border-radius:999px;font-size:.72rem;font-weight:700;">
                        {{ $events->total() }} event
                    </span>
                </p>
            </div>
            <a href="{{ url('/admin/events/create') }}" class="abtn abtn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Event
            </a>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div style="background:#dcfce7;border:1.5px solid #86efac;color:#15803d;padding:.75rem 1rem;border-radius:.75rem;margin-bottom:1rem;font-size:.875rem;font-weight:600;">
            ✅ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="background:#fee2e2;border:1.5px solid #fca5a5;color:#991b1b;padding:.75rem 1rem;border-radius:.75rem;margin-bottom:1rem;font-size:.875rem;font-weight:600;">
            ⚠️ {{ session('error') }}
        </div>
        @endif

        <div class="admin-table-wrap">
            {{-- Search & Filter — submit as GET --}}
            <form method="GET" action="{{ url('/admin/events') }}" id="filterForm">
                <div class="admin-table-hd">
                    <div class="admin-search-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="admin-search-input" id="searchInput" name="search"
                               placeholder="Cari event..." value="{{ request('search') }}"
                               oninput="clearTimeout(window._st);window._st=setTimeout(()=>this.form.submit(),500)">
                    </div>
                    <div class="admin-filter-row">
                        <select class="admin-select" name="category" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <select class="admin-select" name="status" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="open"      {{ request('status') === 'open'      ? 'selected' : '' }}>Open</option>
                            <option value="closed"    {{ request('status') === 'closed'    ? 'selected' : '' }}>Closed</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @if(request()->hasAny(['search','category','status']))
                        <a href="{{ url('/admin/events') }}" class="abtn abtn-secondary abtn-sm">Reset</a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Peserta / Kuota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $ev)
                        @php
                            $pct = $ev->quota > 0 ? min(100, round($ev->registered_count / $ev->quota * 100)) : 0;
                            $statusMap = [
                                'draft'     => ['Draft',   'abadge-gray'],
                                'open'      => ['Buka',    'abadge-green'],
                                'closed'    => ['Tutup',   'abadge-red'],
                                'completed' => ['Selesai', 'abadge-indigo'],
                                'cancelled' => ['Batal',   'abadge-gray'],
                            ];
                            [$label, $cls] = $statusMap[$ev->status] ?? ['Buka','abadge-green'];
                        @endphp
                        <tr>
                            <td>
                                <div style="font-weight:700;color:#0f172a;font-size:.875rem;">{{ $ev->name }}</div>
                                <div style="display:flex;align-items:center;gap:.35rem;margin-top:3px;">
                                    <span style="font-size:.7rem;color:#94a3b8;">{{ $ev->organizer }}</span>
                                    @if($ev->has_certificate)
                                        <span style="font-size:.62rem;background:#dcfce7;color:#15803d;padding:.1rem .4rem;border-radius:999px;font-weight:700;">🏆 Sertifikat</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="abadge abadge-gray" style="font-size:.68rem;background:{{ $ev->category->color ?? '#94a3b8' }}20;color:{{ $ev->category->color ?? '#64748b' }};">
                                    {{ $ev->category->name ?? '-' }}
                                </span>
                            </td>
                            <td style="color:#64748b;font-size:.8rem;white-space:nowrap;">
                                {{ $ev->date->format('d M Y') }}
                                <div style="font-size:.7rem;color:#94a3b8;">{{ $ev->start_time->format('H:i') }}</div>
                            </td>
                            <td style="color:#64748b;font-size:.8rem;">{{ Str::limit($ev->location, 25) }}</td>
                            <td>
                                <div style="min-width:80px;">
                                    <div style="font-size:.78rem;font-weight:600;color:#0f172a;margin-bottom:3px;">
                                        {{ $ev->registered_count }} / {{ $ev->quota }}
                                    </div>
                                    <div style="height:4px;background:#f1f5f9;border-radius:999px;overflow:hidden;">
                                        <div style="height:100%;width:{{ $pct }}%;background:{{ $pct >= 90 ? '#ef4444' : '#1d4ed8' }};border-radius:999px;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="abadge {{ $cls }}">{{ $label }}</span></td>
                            <td>
                                <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                    <a href="{{ url('/admin/events/' . $ev->id . '/edit') }}" class="abtn abtn-outline abtn-sm">Edit</a>
                                    <button class="abtn abtn-danger abtn-sm"
                                            onclick="confirmDelete({{ $ev->id }}, '{{ addslashes($ev->name) }}', {{ $ev->registered_count }})">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3rem;color:#94a3b8;">
                                <div style="font-size:2rem;margin-bottom:.75rem;">📅</div>
                                <div style="font-weight:600;margin-bottom:.25rem;">Belum ada event</div>
                                @if(request()->hasAny(['search','category','status']))
                                    <div style="font-size:.82rem;">Tidak ada event yang cocok dengan filter.</div>
                                    <a href="{{ url('/admin/events') }}" class="abtn abtn-outline abtn-sm" style="margin-top:.75rem;display:inline-block;">Reset Filter</a>
                                @else
                                    <a href="{{ url('/admin/events/create') }}" class="abtn abtn-primary abtn-sm" style="margin-top:.75rem;display:inline-block;">Buat Event Pertama</a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($events->hasPages())
            <div class="admin-pagination">
                <span class="admin-pagination-info">
                    Menampilkan {{ $events->firstItem() }}–{{ $events->lastItem() }} dari {{ $events->total() }} event
                </span>
                <div class="admin-pagination-btns">
                    @if($events->onFirstPage())
                        <button class="admin-page-btn" disabled>‹</button>
                    @else
                        <a href="{{ $events->previousPageUrl() }}" class="admin-page-btn">‹</a>
                    @endif

                    @foreach($events->getUrlRange(max(1, $events->currentPage()-2), min($events->lastPage(), $events->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="admin-page-btn {{ $page == $events->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach

                    @if($events->hasMorePages())
                        <a href="{{ $events->nextPageUrl() }}" class="admin-page-btn">›</a>
                    @else
                        <button class="admin-page-btn" disabled>›</button>
                    @endif
                </div>
            </div>
            @else
            <div class="admin-pagination">
                <span class="admin-pagination-info">Menampilkan {{ $events->count() }} event</span>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="admin-modal-overlay" id="deleteModal" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="admin-modal">
        <div class="admin-modal-hd">
            <div class="admin-modal-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
            </div>
            <h3 class="admin-modal-title">Hapus Event?</h3>
        </div>
        <div class="admin-modal-body" id="deleteModalBody">
            Tindakan ini tidak dapat dibatalkan.
        </div>
        <div class="admin-modal-ft">
            <button type="button" class="abtn abtn-secondary" onclick="document.getElementById('deleteModal').classList.remove('active')">Batal</button>
            <form id="deleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="abtn abtn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
function confirmDelete(id, name, participantCount) {
    var modal = document.getElementById('deleteModal');
    var body  = document.getElementById('deleteModalBody');
    var form  = document.getElementById('deleteForm');

    if (participantCount > 0) {
        body.innerHTML = '<span style="color:#ef4444;font-weight:600;">Event "' + name + '" memiliki ' + participantCount + ' peserta terdaftar dan tidak dapat dihapus.</span><br><small>Ubah status event menjadi "Cancelled" sebagai gantinya.</small>';
        form.style.display = 'none';
    } else {
        body.innerHTML = 'Yakin ingin menghapus event <strong>"' + name + '"</strong>? Tindakan ini tidak dapat dibatalkan.';
        form.style.display = 'inline';
        form.action = '/admin/events/' + id;
    }

    modal.classList.add('active');
}
</script>

</body>
</html>
