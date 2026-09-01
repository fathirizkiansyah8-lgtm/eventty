@extends('user.layout')

@section('title', 'Event')

@push('css')
    @vite('resources/css/user/dashboard.css')
@endpush

@section('content')
<div class="dashboard-content" style="padding: 1.5rem 1.75rem;">

    {{-- Page Header --}}
    <div class="section-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.75rem;">
        <div>
            <h1 style="font-size:1.4rem;font-weight:800;color:var(--text-primary);margin:0;">Semua Event</h1>
            <p style="font-size:.82rem;color:var(--text-muted);margin:.25rem 0 0;">Temukan dan daftar event sekolah yang menarik</p>
        </div>
        <a href="{{ url('/user/my-events') }}" class="btn btn-outline btn-sm">Event Saya â†’</a>
    </div>

    {{-- Filters --}}
    <div style="display:flex;gap:.65rem;flex-wrap:wrap;margin-bottom:1.25rem;align-items:center;">
        <input type="text" id="searchInput" placeholder="ðŸ” Cari event..."
               style="padding:.5rem .875rem;border:1.5px solid var(--border-color);border-radius:999px;font-size:.82rem;background:var(--bg-secondary);color:var(--text-primary);outline:none;min-width:220px;">
        <select id="categoryFilter"
                style="padding:.5rem .875rem;border:1.5px solid var(--border-color);border-radius:999px;font-size:.82rem;background:var(--bg-secondary);color:var(--text-primary);">
            <option value="all">Semua Kategori</option>
        </select>
        <select id="statusFilter"
                style="padding:.5rem .875rem;border:1.5px solid var(--border-color);border-radius:999px;font-size:.82rem;background:var(--bg-secondary);color:var(--text-primary);">
            <option value="all">Semua Status</option>
            <option value="upcoming">Mendatang</option>
            <option value="available">Tersedia</option>
            <option value="full">Penuh</option>
        </select>
    </div>

    {{-- Events Grid --}}
    <div id="eventsGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1rem;">
        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text-muted);">
            <p>Memuat event...</p>
        </div>
    </div>

    {{-- Pagination --}}
    <div id="pagination" style="display:flex;justify-content:center;gap:.5rem;flex-wrap:wrap;margin-top:1.5rem;align-items:center;"></div>

</div>
@endsection

@push('js')
@vite(['resources/js/utils/api.js', 'resources/js/user/events.js'])
@endpush
