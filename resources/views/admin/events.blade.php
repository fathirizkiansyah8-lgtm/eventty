<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <p class="admin-page-hd-sub">Buat, edit, dan pantau semua event sekolah</p>
            </div>
            <a href="{{ url('/admin/events/create') }}" class="abtn abtn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Event
            </a>
        </div>

        <div class="admin-table-wrap">
            <div class="admin-table-hd">
                <div class="admin-search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" class="admin-search-input" id="searchInput" placeholder="Cari event...">
                </div>
                <div class="admin-filter-row">
                    <select class="admin-select" id="categoryFilter">
                        <option value="">Semua Kategori</option>
                        <option value="school-event">School Event</option>
                        <option value="workshop">Workshop</option>
                        <option value="seminar">Seminar</option>
                        <option value="competition">Competition</option>
                    </select>
                    <select class="admin-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="open">Open</option>
                        <option value="almost-full">Almost Full</option>
                        <option value="closed">Closed</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
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
                        @php
                        $events = [
                            ['Career Day',           'School Event', '20 Aug 2026', 'Aula Sekolah',  45, 50, 'open'],
                            ['Workshop Programming', 'Workshop',     '25 Aug 2026', 'Lab Komputer',  20, 30, 'open'],
                            ['Lomba Design',         'Competition',  '1 Sep 2026',  'Aula Sekolah',  45, 50, 'almost-full'],
                            ['Seminar Pendidikan',   'Seminar',      '10 Aug 2026', 'Aula Sekolah',  50, 50, 'closed'],
                            ['Workshop Leadership',  'Workshop',     '15 Aug 2026', 'Lab Komputer',  35, 40, 'completed'],
                            ['Seminar Teknologi',    'Seminar',      '28 Jul 2026', 'Aula Sekolah',  60, 60, 'completed'],
                            ['Training Public Speaking','Workshop',  '20 Jul 2026', 'Lab Bahasa',    25, 30, 'completed'],
                            ['Workshop Photography', 'Workshop',     '15 Jul 2026', 'Studio Foto',   20, 25, 'completed'],
                        ];
                        $statusMap = [
                            'open'        => ['Buka',       'abadge-green'],
                            'almost-full' => ['Hampir Penuh','abadge-yellow'],
                            'closed'      => ['Tutup',      'abadge-red'],
                            'completed'   => ['Selesai',    'abadge-indigo'],
                        ];
                        @endphp
                        @foreach($events as $ev)
                        @php [$label, $cls] = $statusMap[$ev[6]] ?? ['Buka','abadge-green']; @endphp
                        <tr>
                            <td style="font-weight:700;color:#0f172a;">{{ $ev[0] }}</td>
                            <td><span class="abadge abadge-gray" style="font-size:.68rem;">{{ $ev[1] }}</span></td>
                            <td style="color:#64748b;font-size:.8rem;white-space:nowrap;">{{ $ev[2] }}</td>
                            <td style="color:#64748b;font-size:.8rem;">{{ $ev[3] }}</td>
                            <td>
                                <div style="min-width:80px;">
                                    <div style="font-size:.78rem;font-weight:600;color:#0f172a;margin-bottom:3px;">{{ $ev[4] }} / {{ $ev[5] }}</div>
                                    <div style="height:4px;background:#f1f5f9;border-radius:999px;overflow:hidden;">
                                        <div style="height:100%;width:{{ round($ev[4]/$ev[5]*100) }}%;background:{{ round($ev[4]/$ev[5]*100)>=90?'#ef4444':'#1d4ed8' }};border-radius:999px;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="abadge {{ $cls }}">{{ $label }}</span></td>
                            <td>
                                <div style="display:flex;gap:5px;">
                                    <button class="abtn abtn-outline abtn-sm">Lihat</button>
                                    <a href="{{ url('/admin/events/edit/1') }}" class="abtn abtn-outline abtn-sm">Edit</a>
                                    <button class="abtn abtn-danger abtn-sm" onclick="document.getElementById('deleteModal').classList.add('active')">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="admin-pagination">
                <span class="admin-pagination-info">Menampilkan 1–8 dari 24 event</span>
                <div class="admin-pagination-btns">
                    <button class="admin-page-btn" disabled>‹</button>
                    <button class="admin-page-btn active">1</button>
                    <button class="admin-page-btn">2</button>
                    <button class="admin-page-btn">3</button>
                    <button class="admin-page-btn">›</button>
                </div>
            </div>
        </div>

        {{-- Delete Confirmation Modal --}}
        <div class="admin-modal-overlay" id="deleteModal" onclick="if(event.target===this)this.classList.remove('active')">
            <div class="admin-modal">
                <div class="admin-modal-hd">
                    <div class="admin-modal-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </div>
                    <h3 class="admin-modal-title">Hapus Event?</h3>
                </div>
                <div class="admin-modal-body">Tindakan ini tidak dapat dibatalkan. Semua data peserta event ini akan ikut terhapus.</div>
                <div class="admin-modal-ft">
                    <button type="button" class="abtn abtn-secondary" onclick="document.getElementById('deleteModal').classList.remove('active')">Batal</button>
                    <button type="button" class="abtn abtn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])
</body>
</html>
