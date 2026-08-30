<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
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

@include('admin.partials.sidebar', ['activePage' => 'certificates'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Kelola Sertifikat</h1>
                <p class="admin-page-hd-sub">Pantau dan terbitkan sertifikat peserta event</p>
            </div>
        </div>

        {{-- ── STATS ── --}}
        <div class="admin-stats" style="grid-template-columns:repeat(4,1fr);">
            <div class="admin-stat">
                <div class="admin-stat-icon asi-blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">342</div>
                    <div class="admin-stat-lbl">Total Sertifikat</div>
                </div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon asi-orange">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">57</div>
                    <div class="admin-stat-lbl">Menunggu</div>
                    <div class="admin-stat-sub">Status PENDING</div>
                </div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon asi-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">187</div>
                    <div class="admin-stat-lbl">Siap Diterbitkan</div>
                    <div class="admin-stat-sub">Status ELIGIBLE</div>
                </div>
            </div>
            <div class="admin-stat">
                <div class="admin-stat-icon asi-green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">98</div>
                    <div class="admin-stat-lbl">Sudah Diterbitkan</div>
                    <div class="admin-stat-sub">Status ISSUED</div>
                </div>
            </div>
        </div>

        {{-- ── WORKFLOW INFO ── --}}
        <div style="background:#f0f9ff;border:1.5px solid #bae6fd;border-radius:.875rem;padding:1rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:flex-start;gap:.875rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0369a1" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <div style="font-size:.8rem;font-weight:700;color:#0c4a6e;margin-bottom:.35rem;">Alur Sertifikat</div>
                <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
                    @php $steps = [['PENDING','gray','Peserta Mendaftar'],['ELIGIBLE','blue','Peserta Hadir'],['ISSUED','green','Sertifikat Terbit'],['NOT ELIGIBLE','red','Tidak Hadir']]; @endphp
                    @foreach($steps as $i => $s)
                    <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .65rem;border-radius:999px;font-size:.68rem;font-weight:700;background:{{ ['#f1f5f9','#dbeafe','#dcfce7','#fee2e2'][$i] }};color:{{ ['#475569','#1d4ed8','#15803d','#dc2626'][$i] }};">{{ $s[0] }}</span>
                    <span style="font-size:.7rem;color:#64748b;">{{ $s[2] }}</span>
                    @if($i < 2) <span style="color:#94a3b8;">→</span> @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── TABS ── --}}
        <div style="display:flex;gap:4px;background:#f1f5f9;border-radius:.75rem;padding:4px;width:fit-content;margin-bottom:1.25rem;">
            <button class="cert-tab active" id="tabAuto" onclick="switchTab('auto')" style="padding:.5rem 1.25rem;border-radius:.5rem;font-size:.825rem;font-weight:700;border:none;cursor:pointer;background:#fff;color:#0f172a;box-shadow:0 1px 4px rgba(0,0,0,.08);transition:all .2s;font-family:inherit;">Event Umum</button>
            <button class="cert-tab" id="tabComp" onclick="switchTab('comp')" style="padding:.5rem 1.25rem;border-radius:.5rem;font-size:.825rem;font-weight:700;border:none;cursor:pointer;background:transparent;color:#64748b;transition:all .2s;font-family:inherit;">Kompetisi</button>
        </div>

        {{-- ── PANEL: EVENT UMUM ── --}}
        <div id="panelAuto">
            <div class="admin-table-wrap">
                <div class="admin-table-hd">
                    <div class="admin-search-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="admin-search-input" placeholder="Cari peserta atau event..." oninput="filterTable(this,'certTableAuto')">
                    </div>
                    <div class="admin-filter-row">
                        <select class="admin-select" onchange="filterTable(null,'certTableAuto')">
                            <option value="">Semua Event</option>
                            <option>Seminar Digital</option>
                            <option>Workshop Leadership</option>
                            <option>Career Day 2026</option>
                        </select>
                        <select class="admin-select" id="certStatusAutoFilter" onchange="filterTable(null,'certTableAuto')">
                            <option value="">Semua Status</option>
                            <option value="PENDING">Menunggu</option>
                            <option value="ELIGIBLE">Siap Terbit</option>
                            <option value="ISSUED">Diterbitkan</option>
                            <option value="NOT ELIGIBLE">Tidak Memenuhi</option>
                        </select>
                        <button class="abtn abtn-success abtn-sm" onclick="alert('Bulk issue: akan menerbitkan semua sertifikat dengan status ELIGIBLE')">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Terbitkan Semua Eligible
                        </button>
                    </div>
                </div>
                <div class="admin-table-scroll">
                    <table class="admin-table" id="certTableAuto">
                        <thead>
                            <tr>
                                <th>Nama Peserta</th>
                                <th>NIS</th>
                                <th>Event</th>
                                <th>Kehadiran</th>
                                <th>Status Sertifikat</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $certs = [
                                ['Fathi Rizkiansyah', '12345', 'Seminar Digital',    'HADIR',        'ISSUED',       '10 Sep 2026'],
                                ['Ahmad Rizki',       '12346', 'Workshop Leadership','HADIR',        'ELIGIBLE',     '15 Agu 2026'],
                                ['Budi Santoso',      '12347', 'Career Day 2026',    'BELUM DICEK',  'PENDING',      '20 Agu 2026'],
                                ['Citra Dewi',        '12348', 'Seminar Digital',    'HADIR',        'ISSUED',       '10 Sep 2026'],
                                ['Dewi Anggraini',    '12349', 'Workshop Leadership','HADIR',        'ELIGIBLE',     '15 Agu 2026'],
                                ['Eko Prasetyo',      '12350', 'Career Day 2026',    'TIDAK HADIR',  'NOT ELIGIBLE', '20 Agu 2026'],
                                ['Fani Oktavia',      '12351', 'Seminar Digital',    'BELUM DICEK',  'PENDING',      '10 Sep 2026'],
                            ];
                            $certStatusUI = [
                                'PENDING'      => ['Menunggu',          'abadge-yellow'],
                                'ELIGIBLE'     => ['Siap Diterbitkan',  'abadge-blue'],
                                'ISSUED'       => ['Diterbitkan',       'abadge-green'],
                                'NOT ELIGIBLE' => ['Tidak Memenuhi',    'abadge-red'],
                            ];
                            $attendUI = [
                                'HADIR'        => 'abadge-green',
                                'TIDAK HADIR'  => 'abadge-red',
                                'BELUM DICEK'  => 'abadge-yellow',
                            ];
                            @endphp
                            @foreach($certs as $cert)
                            @php
                                [$clabel,$ccls] = $certStatusUI[$cert[4]] ?? [$cert[4],'abadge-gray'];
                                $acls = $attendUI[$cert[3]] ?? 'abadge-gray';
                            @endphp
                            <tr>
                                <td style="font-weight:700;color:#0f172a;">{{ $cert[0] }}</td>
                                <td style="color:#64748b;font-size:.8rem;font-family:monospace;">{{ $cert[1] }}</td>
                                <td style="font-size:.825rem;">{{ $cert[2] }}</td>
                                <td><span class="abadge {{ $acls }}">{{ $cert[3] }}</span></td>
                                <td><span class="abadge {{ $ccls }}">{{ $clabel }}</span></td>
                                <td style="color:#64748b;font-size:.78rem;white-space:nowrap;">{{ $cert[5] }}</td>
                                <td>
                                    <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                        <button class="abtn abtn-outline abtn-sm" onclick="openCertPreview('{{ $cert[0] }}','{{ $cert[2] }}','{{ $cert[5] }}','participation')">Preview</button>
                                        @if($cert[4] === 'ELIGIBLE')
                                        <button class="abtn abtn-success abtn-sm" onclick="alert('Sertifikat diterbitkan untuk {{ $cert[0] }}')">Terbitkan</button>
                                        @elseif($cert[4] === 'ISSUED')
                                        <button class="abtn abtn-outline abtn-sm">Download</button>
                                        @else
                                        <button class="abtn abtn-outline abtn-sm" disabled style="opacity:.4;cursor:not-allowed;" title="{{ $cert[4]==='NOT ELIGIBLE'?'Peserta tidak hadir':'Kehadiran belum dikonfirmasi' }}">Terbitkan</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="admin-pagination">
                    <span class="admin-pagination-info">Menampilkan 1–7 dari 285 sertifikat</span>
                    <div class="admin-pagination-btns">
                        <button class="admin-page-btn" disabled>‹</button>
                        <button class="admin-page-btn active">1</button>
                        <button class="admin-page-btn">2</button>
                        <button class="admin-page-btn">›</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── PANEL: KOMPETISI ── --}}
        <div id="panelComp" style="display:none;">
            <div class="admin-table-wrap">
                <div class="admin-table-hd">
                    <div class="admin-search-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="admin-search-input" placeholder="Cari peserta..." oninput="filterTable(this,'certTableComp')">
                    </div>
                    <div class="admin-filter-row">
                        <select class="admin-select">
                            <option>Semua Event</option>
                            <option>Turnamen Basket</option>
                            <option>Class Meeting Futsal</option>
                            <option>Lomba Desain Grafis</option>
                        </select>
                    </div>
                </div>
                <div class="admin-table-scroll">
                    <table class="admin-table" id="certTableComp">
                        <thead>
                            <tr>
                                <th>Nama Peserta</th>
                                <th>NIS</th>
                                <th>Event</th>
                                <th>Penghargaan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $compCerts = [
                                ['Fathi Rizkiansyah', '12345', 'Turnamen Basket',      'JUARA 1', 'ISSUED'],
                                ['Ahmad Rizki',       '12360', 'Turnamen Basket',      'JUARA 2', 'ISSUED'],
                                ['Budi Santoso',      '12347', 'Class Meeting Futsal', 'JUARA 1', 'ISSUED'],
                                ['Dewi Anggraini',    '12349', 'Lomba Desain Grafis',  '—',       'PENDING'],
                            ];
                            $rankStyle = ['JUARA 1'=>['🥇','#92400e','#fef3c7'], 'JUARA 2'=>['🥈','#475569','#f1f5f9'], 'JUARA 3'=>['🥉','#9a3412','#ffedd5'], '—'=>['','#94a3b8','#f8fafc']];
                            @endphp
                            @foreach($compCerts as $cc)
                            @php [$emoji,$tc,$bg] = $rankStyle[$cc[3]] ?? ['','#94a3b8','#f8fafc']; [$clabel,$ccls] = $certStatusUI[$cc[4]] ?? [$cc[4],'abadge-gray']; @endphp
                            <tr>
                                <td style="font-weight:700;color:#0f172a;">{{ $cc[0] }}</td>
                                <td style="color:#64748b;font-size:.8rem;font-family:monospace;">{{ $cc[1] }}</td>
                                <td style="font-size:.825rem;">{{ $cc[2] }}</td>
                                <td>
                                    <span style="display:inline-flex;align-items:center;gap:.35rem;padding:.2rem .75rem;border-radius:999px;font-size:.72rem;font-weight:700;background:{{ $bg }};color:{{ $tc }};">
                                        {{ $emoji }} {{ $cc[3] }}
                                    </span>
                                </td>
                                <td><span class="abadge {{ $ccls }}">{{ $clabel }}</span></td>
                                <td>
                                    <div style="display:flex;gap:5px;">
                                        @if($cc[4] === 'ISSUED')
                                        <button class="abtn abtn-outline abtn-sm" onclick="openCertPreview('{{ $cc[0] }}','{{ $cc[2] }}','2026','achievement','{{ $cc[3] }}')">Preview</button>
                                        <button class="abtn abtn-outline abtn-sm">Download</button>
                                        @elseif($cc[3] === '—')
                                        <button class="abtn abtn-primary abtn-sm" onclick="alert('Tetapkan juara untuk {{ $cc[0] }} di event {{ $cc[2] }}')">Tetapkan Juara</button>
                                        @else
                                        <button class="abtn abtn-success abtn-sm" onclick="alert('Terbitkan sertifikat {{ $cc[3] }} untuk {{ $cc[0] }}')">Terbitkan</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ── CERTIFICATE PREVIEW MODAL ── --}}
<div class="admin-modal-overlay" id="certPreviewModal" onclick="if(event.target===this)closeCertModal()" style="align-items:center;">
    <div style="background:#fff;border-radius:1.125rem;width:100%;max-width:580px;max-height:92vh;overflow-y:auto;box-shadow:0 20px 60px rgba(15,23,42,.2);">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border-bottom:1px solid #f1f5f9;">
            <span style="font-size:.9rem;font-weight:700;color:#0f172a;" id="certModalTitle">Preview Sertifikat</span>
            <button onclick="closeCertModal()" style="width:30px;height:30px;border-radius:50%;border:1.5px solid #e8edf5;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748b;font-size:1.1rem;">✕</button>
        </div>
        <div style="padding:1.5rem;" id="certModalBody"></div>
        <div style="padding:1rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:.625rem;">
            <button class="abtn abtn-secondary" onclick="closeCertModal()">Tutup</button>
            <button class="abtn abtn-primary">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download PDF
            </button>
        </div>
    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
/* ── Tab switching ── */
function switchTab(tab) {
    var isAuto = tab === 'auto';
    document.getElementById('panelAuto').style.display = isAuto ? '' : 'none';
    document.getElementById('panelComp').style.display = isAuto ? 'none' : '';
    var tabAuto = document.getElementById('tabAuto');
    var tabComp = document.getElementById('tabComp');
    [tabAuto, tabComp].forEach(function(t){ t.style.background='transparent'; t.style.color='#64748b'; t.style.boxShadow='none'; });
    var active = isAuto ? tabAuto : tabComp;
    active.style.background = '#fff'; active.style.color = '#0f172a'; active.style.boxShadow = '0 1px 4px rgba(0,0,0,.08)';
}

/* ── Live search ── */
function filterTable(input, tableId) {
    var q = input ? input.value.toLowerCase() : '';
    document.querySelectorAll('#'+tableId+' tbody tr').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

/* ── Certificate Preview ── */
function buildCertHtml(name, event, date, type, rank) {
    var isAchievement = type === 'achievement';
    return '<div style="background:linear-gradient(145deg,#0d1b4b 0%,#162152 40%,#1a2d6e 100%);border-radius:14px;padding:2.5rem 2rem;text-align:center;position:relative;overflow:hidden;">'
        + '<div style="position:absolute;top:-50px;right:-50px;width:160px;height:160px;border-radius:50%;border:1px solid rgba(255,255,255,.06);"></div>'
        + '<div style="position:relative;z-index:2;">'
        + '<div style="font-size:.65rem;font-weight:800;letter-spacing:.15em;color:rgba(255,255,255,.4);text-transform:uppercase;margin-bottom:.25rem;">— EVENTTY —</div>'
        + '<div style="font-size:.58rem;color:rgba(255,255,255,.3);letter-spacing:.1em;margin-bottom:1.25rem;">SMKN 20 JAKARTA</div>'
        + '<div style="width:36px;height:1.5px;background:rgba(255,255,255,.15);margin:0 auto .875rem;"></div>'
        + '<div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#93c5fd;margin-bottom:.15rem;">Certificate</div>'
        + '<div style="font-size:1.2rem;font-weight:800;color:#fff;margin-bottom:1.25rem;">' + (isAchievement ? 'OF ACHIEVEMENT' : 'OF PARTICIPATION') + '</div>'
        + '<div style="font-size:.6rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.35rem;">Diberikan kepada</div>'
        + '<div style="font-size:1.1rem;font-weight:800;color:#fbbf24;margin-bottom:1.25rem;">' + name.toUpperCase() + '</div>'
        + (isAchievement
            ? '<div style="font-size:.6rem;color:rgba(255,255,255,.4);margin-bottom:.4rem;">sebagai</div><div style="display:inline-block;padding:.4rem 1.5rem;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:999px;font-weight:800;font-size:.875rem;color:#fff;margin-bottom:1rem;">' + rank + '</div>'
            : '<div style="font-size:.6rem;color:rgba(255,255,255,.4);margin-bottom:.35rem;">atas partisipasinya dalam</div>')
        + '<div style="font-size:.9rem;font-weight:700;color:#fff;margin-bottom:.35rem;">' + event.toUpperCase() + '</div>'
        + '<div style="font-size:.6rem;color:rgba(255,255,255,.3);margin-bottom:1.25rem;">' + date + '</div>'
        + '<div style="padding-top:1rem;border-top:1px solid rgba(255,255,255,.08);font-size:.58rem;color:rgba(255,255,255,.25);letter-spacing:.08em;text-transform:uppercase;">EVENTTY · SMKN 20 JAKARTA</div>'
        + '</div></div>';
}

function openCertPreview(name, event, date, type, rank) {
    rank = rank || '';
    document.getElementById('certModalTitle').textContent = 'Preview — ' + event;
    document.getElementById('certModalBody').innerHTML = buildCertHtml(name, event, date, type, rank);
    document.getElementById('certPreviewModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeCertModal() {
    document.getElementById('certPreviewModal').classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) { if(e.key==='Escape') closeCertModal(); });
</script>
</body>
</html>
