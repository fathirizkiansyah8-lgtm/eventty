<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

@include('admin.partials.sidebar', ['activePage' => 'participants'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Peserta</h1>
                <p class="admin-page-hd-sub">Kelola dan pantau seluruh peserta event</p>
            </div>
        </div>

        <div class="admin-table-wrap">
            <div class="admin-table-hd">
                <div class="admin-search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" class="admin-search-input" id="searchInput" placeholder="Cari nama peserta atau NIS...">
                </div>
                <div class="admin-filter-row">
                    <select class="admin-select" id="eventFilter">
                        <option value="">Semua Event</option>
                        <option>Career Day</option>
                        <option>Workshop Programming</option>
                        <option>Lomba Design</option>
                        <option>Seminar Pendidikan</option>
                    </select>
                    <select class="admin-select" id="classFilter">
                        <option value="">Semua Kelas</option>
                        <option>Kelas X</option>
                        <option>Kelas XI</option>
                        <option>Kelas XII</option>
                    </select>
                    <select class="admin-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="registered">Registered</option>
                        <option value="attended">Attended</option>
                        <option value="absent">Absent</option>
                    </select>
                </div>
            </div>

            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Event</th>
                            <th>Status</th>
                            <th>Kehadiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $participants = [
                            ['Fathi Rizkiansyah', '12345', 'XII RPL 1', 'Career Day',           'registered', 'pending'],
                            ['Ahmad Rizki',       '12346', 'XII AK 2',  'Workshop Programming', 'attended',   'hadir'],
                            ['Budi Santoso',      '12347', 'XI IPS 1',  'Lomba Design',         'registered', 'tidak'],
                            ['Citra Dewi',        '12348', 'X RPL 1',   'Seminar Pendidikan',   'attended',   'hadir'],
                            ['Dewi Anggraini',    '12349', 'XII MP 1',  'Workshop Leadership',  'attended',   'hadir'],
                            ['Eko Prasetyo',      '12350', 'XI AK 1',   'Career Day',           'registered', 'pending'],
                            ['Fani Oktavia',      '12351', 'XII RPL 2', 'Workshop Programming', 'absent',     'tidak'],
                            ['Gita Sari',         '12352', 'X BD 1',    'Lomba Design',         'registered', 'pending'],
                        ];
                        $statusBadge = [
                            'registered' => ['REGISTERED', 'abadge-blue'],
                            'attended'   => ['ATTENDED',   'abadge-green'],
                            'absent'     => ['ABSENT',     'abadge-red'],
                        ];
                        $attendBadge = [
                            'hadir'   => ['HADIR',         'abadge-green'],
                            'tidak'   => ['TIDAK HADIR',   'abadge-red'],
                            'pending' => ['BELUM DICEK',   'abadge-yellow'],
                        ];
                        @endphp
                        @foreach($participants as $p)
                        @php
                            [$slabel,$scls] = $statusBadge[$p[4]] ?? ['–','abadge-gray'];
                            [$alabel,$acls] = $attendBadge[$p[5]] ?? ['–','abadge-gray'];
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:.625rem;">
                                    <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#1e40af,#3b82f6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.75rem;font-weight:800;flex-shrink:0;">{{ substr($p[0],0,1) }}</div>
                                    <span style="font-weight:700;color:#0f172a;">{{ $p[0] }}</span>
                                </div>
                            </td>
                            <td style="color:#64748b;font-size:.8rem;font-family:monospace;">{{ $p[1] }}</td>
                            <td style="color:#64748b;font-size:.8rem;">{{ $p[2] }}</td>
                            <td style="color:#0f172a;font-size:.825rem;">{{ $p[3] }}</td>
                            <td><span class="abadge {{ $scls }}">{{ $slabel }}</span></td>
                            <td><span class="abadge {{ $acls }}">{{ $alabel }}</span></td>
                            <td>
                                <button class="abtn abtn-outline abtn-sm" onclick="openParticipantDetail('{{ $p[0] }}','{{ $p[1] }}','{{ $p[2] }}','{{ $p[3] }}','{{ $slabel }}','{{ $alabel }}')">Detail</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                <span class="admin-pagination-info">Menampilkan 1–8 dari 342 peserta</span>
                <div class="admin-pagination-btns">
                    <button class="admin-page-btn" disabled>‹</button>
                    <button class="admin-page-btn active">1</button>
                    <button class="admin-page-btn">2</button>
                    <button class="admin-page-btn">3</button>
                    <button class="admin-page-btn">›</button>
                </div>
            </div>
        </div>

        {{-- Detail Modal --}}
        <div class="admin-modal-overlay" id="participantDetailModal" onclick="if(event.target===this)this.classList.remove('active')">
            <div class="admin-modal" style="max-width:480px;">
                <div class="admin-modal-hd">
                    <div class="admin-modal-icon blue">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="admin-modal-title" id="detailName">Detail Peserta</h3>
                </div>
                <div style="padding:0 1.5rem 1rem;">
                    <table style="width:100%;font-size:.85rem;border-collapse:collapse;">
                        @foreach([['NIS','detailNis'],['Kelas','detailKelas'],['Event','detailEvent'],['Status','detailStatus'],['Kehadiran','detailKehadiran']] as $row)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:.625rem 0;color:#64748b;font-weight:600;width:38%;">{{ $row[0] }}</td>
                            <td style="padding:.625rem 0;color:#0f172a;font-weight:500;" id="{{ $row[1] }}">—</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="admin-modal-ft">
                    <button type="button" class="abtn abtn-secondary" onclick="document.getElementById('participantDetailModal').classList.remove('active')">Tutup</button>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
function openParticipantDetail(name, nis, kelas, event, status, kehadiran) {
    document.getElementById('detailName').textContent = name;
    document.getElementById('detailNis').textContent = nis;
    document.getElementById('detailKelas').textContent = kelas;
    document.getElementById('detailEvent').textContent = event;
    document.getElementById('detailStatus').textContent = status;
    document.getElementById('detailKehadiran').textContent = kehadiran;
    document.getElementById('participantDetailModal').classList.add('active');
}

// Live search
document.getElementById('searchInput').addEventListener('input', function() {
    var q = this.value.toLowerCase();
    document.querySelectorAll('.admin-table tbody tr').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
</body>
</html>
