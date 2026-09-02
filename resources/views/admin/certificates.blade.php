<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat â€” Eventty Admin</title>
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

        {{-- Stats dari DB --}}
        @php
            use App\Models\Certificate;
            use App\Models\EventParticipant;

            $certStats = [
                'total'    => Certificate::count(),
                'issued'   => Certificate::where('status','issued')->count(),
                'generated'=> Certificate::where('status','generated')->count(),
            ];
            // Peserta yang hadir di event completed tapi belum punya sertifikat = eligible
            $eligibleCount = EventParticipant::where('attendance_status','present')
                ->whereHas('event', fn($q) => $q->where('status','completed'))
                ->whereDoesntHave('user.certificates', fn($q) => $q->whereColumn('certificates.event_id','event_participants.event_id'))
                ->count();
        @endphp
        <div class="admin-stats" style="grid-template-columns:repeat(4,1fr);">
            @foreach([
                ['asi-blue',   $certStats['total'],    'Total Sertifikat', null],
                ['asi-orange', $eligibleCount,          'Siap Diterbitkan', 'Peserta hadir, belum ada sertifikat'],
                ['asi-purple', $certStats['generated'], 'Generated',        'Belum diterbitkan resmi'],
                ['asi-green',  $certStats['issued'],    'Diterbitkan',      'Status ISSUED'],
            ] as [$icon, $val, $lbl, $sub])
            <div class="admin-stat">
                <div class="admin-stat-icon {{ $icon }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
                <div class="admin-stat-body">
                    <div class="admin-stat-num">{{ $val }}</div>
                    <div class="admin-stat-lbl">{{ $lbl }}</div>
                    @if($sub)<div class="admin-stat-sub">{{ $sub }}</div>@endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Peserta yang layak mendapat sertifikat (hadir di event completed) --}}
        @php
            $eligibleParticipants = EventParticipant::with(['user','event','event.category'])
                ->where('attendance_status','present')
                ->whereHas('event', fn($q) => $q->where('status','completed'))
                ->orderBy('created_at','desc')
                ->paginate(15);
        @endphp

        <div class="admin-table-wrap">
            <div class="admin-table-hd">
                <span style="font-size:.9rem;font-weight:800;color:#0f172a;">
                    Peserta Layak Sertifikat
                    <span style="font-size:.75rem;color:#64748b;font-weight:500;margin-left:.5rem;">(Hadir di event yang sudah selesai)</span>
                </span>
            </div>
            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama Peserta</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Event</th>
                            <th>Kategori</th>
                            <th>Kehadiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eligibleParticipants as $ep)
                        @php
                            $hasCert = \App\Models\Certificate::where('user_id',$ep->user_id)
                                ->where('event_id',$ep->event_id)->exists();
                        @endphp
                        <tr>
                            <td style="font-weight:700;color:#0f172a;">{{ $ep->user->name }}</td>
                            <td style="color:#64748b;font-size:.8rem;font-family:monospace;">{{ $ep->user->nis ?? '-' }}</td>
                            <td style="color:#64748b;font-size:.8rem;">{{ $ep->user->class ?? '-' }}</td>
                            <td style="font-size:.825rem;">{{ $ep->event->name }}</td>
                            <td>
                                <span class="abadge abadge-gray" style="background:{{ $ep->event->category->color ?? '#94a3b8' }}20;color:{{ $ep->event->category->color ?? '#64748b' }};">
                                    {{ $ep->event->category->name ?? '-' }}
                                </span>
                            </td>
                            <td><span class="abadge abadge-green">Hadir ✓</span></td>
                            <td>
                                @if($hasCert)
                                    <span class="abadge abadge-green" style="font-size:.72rem;">Sudah Ada</span>
                                @else
                                    <button class="abtn abtn-success abtn-sm"
                                            onclick="issueCertificate({{ $ep->user_id }}, {{ $ep->event_id }}, '{{ addslashes($ep->user->name) }}', '{{ addslashes($ep->event->name) }}', this)">
                                        Terbitkan
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3rem;color:#94a3b8;">
                                <div style="font-size:2rem;margin-bottom:.75rem;">🏆</div>
                                <div style="font-weight:600;margin-bottom:.25rem;">Belum ada peserta yang layak</div>
                                <div style="font-size:.82rem;">Peserta yang hadir di event completed akan muncul di sini.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($eligibleParticipants->hasPages())
            <div class="admin-pagination">
                <span class="admin-pagination-info">
                    Menampilkan {{ $eligibleParticipants->firstItem() }}–{{ $eligibleParticipants->lastItem() }} dari {{ $eligibleParticipants->total() }}
                </span>
                <div class="admin-pagination-btns">
                    @if(!$eligibleParticipants->onFirstPage())
                        <a href="{{ $eligibleParticipants->previousPageUrl() }}" class="admin-page-btn">‹</a>
                    @endif
                    @foreach($eligibleParticipants->getUrlRange(max(1,$eligibleParticipants->currentPage()-2),min($eligibleParticipants->lastPage(),$eligibleParticipants->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="admin-page-btn {{ $page == $eligibleParticipants->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach
                    @if($eligibleParticipants->hasMorePages())
                        <a href="{{ $eligibleParticipants->nextPageUrl() }}" class="admin-page-btn">›</a>
                    @endif
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
function issueCertificate(userId, eventId, studentName, eventName, btn) {
    if (!confirm('Terbitkan sertifikat untuk ' + studentName + ' (' + eventName + ')?')) return;

    btn.disabled = true;
    btn.textContent = 'Memproses...';

    fetch('/api/admin/certificates/issue', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ user_id: userId, event_id: eventId })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            btn.outerHTML = '<span class="abadge abadge-green" style="font-size:.72rem;">Sudah Ada</span>';
        } else {
            alert('Gagal: ' + (data.message || 'Terjadi kesalahan.'));
            btn.disabled = false;
            btn.textContent = 'Terbitkan';
        }
    })
    .catch(function() {
        alert('Terjadi kesalahan koneksi.');
        btn.disabled = false;
        btn.textContent = 'Terbitkan';
    });
}
</script>

</body>
</html>
