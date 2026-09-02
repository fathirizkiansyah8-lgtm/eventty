<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengumuman — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/announcements.css',
    ])
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
@include('admin.partials.sidebar', ['activePage' => 'announcements'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <div>
                <h1 class="admin-page-hd-title">Pengumuman</h1>
                <p class="admin-page-hd-sub">Buat dan kelola pengumuman untuk siswa</p>
            </div>
            <button class="abtn abtn-primary" onclick="document.getElementById('createModal').classList.add('active')">
                + Buat Pengumuman
            </button>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div style="background:#dcfce7;border:1.5px solid #86efac;color:#15803d;padding:.75rem 1rem;border-radius:.75rem;margin-bottom:1rem;font-size:.875rem;font-weight:600;">✅ {{ session('success') }}</div>
        @endif

        {{-- Filter form --}}
        <form method="GET" action="{{ url('/admin/announcements') }}">
            <div class="admin-table-hd" style="margin-bottom:1.25rem;">
                <div class="admin-search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" class="admin-search-input" name="search"
                           placeholder="Cari pengumuman..."
                           value="{{ request('search') }}"
                           oninput="clearTimeout(window._st);window._st=setTimeout(()=>this.form.submit(),500)">
                </div>
                <div class="admin-filter-row">
                    <select class="admin-select" name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="scheduled"{{ request('status') === 'scheduled'? 'selected' : '' }}>Terjadwal</option>
                    </select>
                    @if(request()->hasAny(['search','status']))
                        <a href="{{ url('/admin/announcements') }}" class="abtn abtn-secondary abtn-sm">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Announcements list --}}
        @forelse($announcements as $ann)
        @php
            $targetMap = ['all_students'=>'Semua Siswa','participants'=>'Peserta Event','all_users'=>'Semua Pengguna','specific_class'=>'Kelas Tertentu'];
            $targetLabel = $targetMap[$ann->target] ?? $ann->target;
            $priorityMap = ['normal'=>['abadge-gray','Normal'],'high'=>['abadge-orange','Penting'],'urgent'=>['abadge-red','Urgent']];
            [$priCls, $priLabel] = $priorityMap[$ann->priority ?? 'normal'] ?? ['abadge-gray','Normal'];
        @endphp
        <div class="admin-card" style="margin-bottom:.875rem;">
            <div class="admin-card-hd" style="align-items:flex-start;gap:.75rem;">
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;margin-bottom:.35rem;">
                        <h3 class="admin-card-title" style="margin:0;">{{ $ann->title }}</h3>
                        @if($ann->is_pinned) <span style="font-size:.7rem;">📌</span> @endif
                    </div>
                    <div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">
                        <span class="abadge {{ $ann->status === 'active' ? 'abadge-green' : ($ann->status === 'scheduled' ? 'abadge-blue' : 'abadge-gray') }}">
                            {{ ucfirst($ann->status) }}
                        </span>
                        <span class="abadge {{ $priCls }}">{{ $priLabel }}</span>
                        <span style="font-size:.72rem;color:#64748b;">→ {{ $targetLabel }}</span>
                    </div>
                </div>
                <div class="announcement-actions" style="display:flex;gap:.5rem;flex-shrink:0;">
                    {{-- Toggle status --}}
                    <form method="POST" action="{{ url('/admin/announcements/' . $ann->id . '/toggle') }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="abtn abtn-outline abtn-sm">
                            {{ $ann->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    {{-- Delete --}}
                    <form method="POST" action="{{ url('/admin/announcements/' . $ann->id) }}" style="display:inline;"
                          onsubmit="return confirm('Hapus pengumuman ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="abtn abtn-danger abtn-sm">Hapus</button>
                    </form>
                </div>
            </div>
            <div class="admin-card-body" style="color:#475569;font-size:.875rem;line-height:1.6;">
                {{ Str::limit($ann->content, 200) }}
            </div>
            <div class="announcement-footer" style="padding:.75rem 1rem;border-top:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;font-size:.75rem;color:#94a3b8;">
                <span>📅 {{ $ann->publish_date->format('d F Y, H:i') }}</span>
                <span>Dibuat oleh: {{ $ann->creator->name ?? 'Admin' }}</span>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:3rem;color:#94a3b8;">
            <div style="font-size:2.5rem;margin-bottom:.75rem;">📢</div>
            <div style="font-weight:600;margin-bottom:.25rem;">Belum ada pengumuman</div>
            @if(request()->hasAny(['search','status']))
                <a href="{{ url('/admin/announcements') }}" class="abtn abtn-outline abtn-sm" style="margin-top:.75rem;display:inline-block;">Reset Filter</a>
            @else
                <div style="font-size:.82rem;margin-bottom:.75rem;">Buat pengumuman pertama untuk siswa.</div>
                <button class="abtn abtn-primary" onclick="document.getElementById('createModal').classList.add('active')">+ Buat Sekarang</button>
            @endif
        </div>
        @endforelse

        {{-- Pagination --}}
        @if($announcements->hasPages())
        <div class="admin-pagination">
            <span class="admin-pagination-info">Menampilkan {{ $announcements->firstItem() }}–{{ $announcements->lastItem() }} dari {{ $announcements->total() }}</span>
            <div class="admin-pagination-btns">
                @if(!$announcements->onFirstPage())
                    <a href="{{ $announcements->previousPageUrl() }}" class="admin-page-btn">‹</a>
                @endif
                @foreach($announcements->getUrlRange(max(1,$announcements->currentPage()-2), min($announcements->lastPage(),$announcements->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="admin-page-btn {{ $page == $announcements->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                @endforeach
                @if($announcements->hasMorePages())
                    <a href="{{ $announcements->nextPageUrl() }}" class="admin-page-btn">›</a>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

{{-- Create Announcement Modal --}}
<div class="admin-modal-overlay" id="createModal" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="admin-modal" style="max-width:520px;">
        <div class="admin-modal-hd">
            <h3 class="admin-modal-title">Buat Pengumuman</h3>
        </div>
        <form method="POST" action="{{ url('/admin/announcements') }}">
            @csrf
            <div class="admin-modal-body" style="padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:.875rem;">
                <div class="aform-group" style="margin:0;">
                    <label class="aform-label">Judul <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="title" class="aform-input" placeholder="Judul pengumuman" required>
                </div>
                <div class="aform-group" style="margin:0;">
                    <label class="aform-label">Isi <span style="color:#ef4444;">*</span></label>
                    <textarea name="content" class="aform-textarea" rows="4" placeholder="Isi pengumuman..." required></textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                    <div class="aform-group" style="margin:0;">
                        <label class="aform-label">Target</label>
                        <select name="target" class="aform-select">
                            <option value="all_students">Semua Siswa</option>
                            <option value="participants">Peserta Event</option>
                            <option value="all_users">Semua Pengguna</option>
                        </select>
                    </div>
                    <div class="aform-group" style="margin:0;">
                        <label class="aform-label">Prioritas</label>
                        <select name="priority" class="aform-select">
                            <option value="normal">Normal</option>
                            <option value="high">Penting</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="aform-group" style="margin:0;">
                    <label class="aform-label">Status</label>
                    <select name="status" class="aform-select">
                        <option value="active">Aktif (Tampil sekarang)</option>
                        <option value="inactive">Nonaktif (Simpan sebagai draft)</option>
                    </select>
                </div>
            </div>
            <div class="admin-modal-ft">
                <button type="button" class="abtn abtn-secondary" onclick="document.getElementById('createModal').classList.remove('active')">Batal</button>
                <button type="submit" class="abtn abtn-primary">Simpan Pengumuman</button>
            </div>
        </form>
    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])
</body>
</html>
