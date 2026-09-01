@extends('user.layout')

@section('title', $event->name)

@push('css')
    @vite('resources/css/user/dashboard.css')
@endpush

@section('content')
<div class="dashboard-content" style="padding:1.5rem 1.75rem;">

    {{-- Back button --}}
    <div style="margin-bottom:1.25rem;">
        <a href="{{ url('/user/events') }}" class="btn btn-outline btn-sm">
            ← Kembali ke Semua Event
        </a>
    </div>

    {{-- Event Banner --}}
    <div style="border-radius:1rem;overflow:hidden;position:relative;height:260px;background:#0f1f4e;margin-bottom:1.5rem;">
        @if($event->banner_path)
            <img src="{{ $event->banner_url }}" alt="{{ $event->name }}"
                 style="width:100%;height:100%;object-fit:cover;">
        @endif
        <div style="position:absolute;top:1rem;left:1rem;">
            <span style="background:{{ $event->category->color }};color:#fff;padding:.3rem .75rem;border-radius:999px;font-size:.75rem;font-weight:700;">
                {{ $event->category->name }}
            </span>
        </div>
        <div style="position:absolute;top:1rem;right:1rem;">
            @php
                $statusStyle = match($event->status) {
                    'open'      => 'background:#10b981',
                    'closed'    => 'background:#f59e0b',
                    'completed' => 'background:#6b7280',
                    'cancelled' => 'background:#ef4444',
                    default     => 'background:#3b82f6',
                };
                $statusLabel = match($event->status) {
                    'open'      => 'Buka',
                    'closed'    => 'Tutup',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default     => 'Draft',
                };
            @endphp
            <span style="{{ $statusStyle }};color:#fff;padding:.3rem .75rem;border-radius:999px;font-size:.75rem;font-weight:700;">
                {{ $statusLabel }}
            </span>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

        {{-- Left: Event Info --}}
        <div>
            <h1 style="font-size:1.6rem;font-weight:800;color:var(--text-primary);margin-bottom:.5rem;">
                {{ $event->name }}
            </h1>
            <p style="font-size:.85rem;color:var(--text-muted);margin-bottom:1.5rem;">
                Diselenggarakan oleh <strong>{{ $event->organizer }}</strong>
            </p>

            {{-- Detail grid --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1.5rem;">
                @foreach([
                    ['📅', 'Tanggal', $event->formatted_date],
                    ['🕐', 'Waktu', $event->formatted_time],
                    ['📍', 'Lokasi', $event->location],
                    ['👥', 'Kuota', $event->registered_count . '/' . $event->quota . ' peserta'],
                ] as [$icon, $label, $value])
                <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:.75rem;padding:.875rem 1rem;">
                    <div style="font-size:.7rem;color:var(--text-muted);font-weight:600;margin-bottom:.25rem;">{{ $icon }} {{ $label }}</div>
                    <div style="font-size:.875rem;font-weight:700;color:var(--text-primary);">{{ $value }}</div>
                </div>
                @endforeach
            </div>

            {{-- Quota bar --}}
            @if($event->quota > 0)
            <div style="margin-bottom:1.5rem;">
                @php $pct = min(100, round($event->registered_count / $event->quota * 100)); @endphp
                <div style="display:flex;justify-content:space-between;font-size:.78rem;color:var(--text-muted);margin-bottom:.35rem;">
                    <span>Kuota terisi</span><span>{{ $pct }}%</span>
                </div>
                <div style="height:8px;background:var(--bg-tertiary);border-radius:999px;overflow:hidden;">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ $pct >= 90 ? '#ef4444' : '#3b82f6' }};border-radius:999px;transition:width .5s;"></div>
                </div>
            </div>
            @endif

            {{-- Description --}}
            <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:.75rem;padding:1.25rem;">
                <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:.75rem;">Deskripsi</h3>
                <p style="font-size:.875rem;color:var(--text-secondary);line-height:1.7;white-space:pre-line;">{{ $event->description }}</p>
            </div>
        </div>

        {{-- Right: Registration Card --}}
        <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:1rem;padding:1.25rem;position:sticky;top:1rem;">
            <h3 style="font-size:1rem;font-weight:800;color:var(--text-primary);margin-bottom:1rem;">Pendaftaran</h3>

            @if($isRegistered)
                <div style="background:#dcfce7;border:1.5px solid #86efac;border-radius:.75rem;padding:.875rem;text-align:center;margin-bottom:1rem;">
                    <div style="font-size:1.5rem;">✅</div>
                    <div style="font-weight:700;color:#15803d;margin-top:.25rem;">Anda sudah terdaftar</div>
                </div>
                <a href="{{ url('/user/my-events') }}" class="btn btn-outline" style="width:100%;text-align:center;">
                    Lihat di Event Saya
                </a>

            @elseif($event->status !== 'open')
                <div style="background:var(--bg-tertiary);border-radius:.75rem;padding:.875rem;text-align:center;margin-bottom:1rem;">
                    <div style="font-size:1.5rem;">🚫</div>
                    <div style="font-weight:600;color:var(--text-muted);margin-top:.25rem;">Pendaftaran tidak tersedia</div>
                    <div style="font-size:.78rem;color:var(--text-muted);margin-top:.25rem;">Status: {{ $statusLabel }}</div>
                </div>

            @elseif($event->isFull())
                <div style="background:#fef3c7;border:1.5px solid #fcd34d;border-radius:.75rem;padding:.875rem;text-align:center;margin-bottom:1rem;">
                    <div style="font-size:1.5rem;">😮</div>
                    <div style="font-weight:700;color:#b45309;margin-top:.25rem;">Kuota sudah penuh</div>
                </div>

            @else
                <form method="POST" action="{{ url('/user/events/register') }}" id="registerForm">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <div style="font-size:.82rem;color:var(--text-muted);margin-bottom:1rem;line-height:1.5;">
                        Sisa kuota: <strong style="color:var(--text-primary);">{{ $event->getRemainingSlots() }} tempat</strong>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%;">
                        Daftar Sekarang
                    </button>
                </form>
            @endif

            {{-- Event meta --}}
            <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);font-size:.75rem;color:var(--text-muted);">
                <div style="margin-bottom:.35rem;">📌 Dibuat oleh: {{ $event->creator->name }}</div>
                <div>🗓 Terakhir diperbarui: {{ $event->updated_at->format('d M Y') }}</div>
            </div>
        </div>

    </div>

    {{-- Flash messages --}}
    @if(session('success'))
    <div style="position:fixed;bottom:1.5rem;right:1.5rem;background:#dcfce7;border:1.5px solid #86efac;color:#15803d;padding:.875rem 1.25rem;border-radius:.75rem;font-weight:600;font-size:.875rem;box-shadow:0 4px 12px rgba(0,0,0,.1);z-index:9999;">
        ✅ {{ session('success') }}
    </div>
    @endif

</div>
@endsection
