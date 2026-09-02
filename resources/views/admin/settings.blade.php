<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
    ])
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
@include('admin.partials.sidebar', ['activePage' => 'settings'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <h1 class="admin-page-hd-title">Profil Admin</h1>
            <p class="admin-page-hd-sub">Kelola informasi akun dan keamanan</p>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div style="background:#dcfce7;border:1.5px solid #86efac;color:#15803d;padding:.75rem 1rem;border-radius:.75rem;margin-bottom:1.25rem;font-size:.875rem;font-weight:600;">✅ {{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div style="background:#fee2e2;border:1.5px solid #fca5a5;color:#991b1b;padding:.75rem 1rem;border-radius:.75rem;margin-bottom:1.25rem;font-size:.875rem;">
            <ul style="margin:0;padding-left:1.25rem;">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
        @endif

        @php $adminUser = Auth::user(); @endphp

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;max-width:900px;">

            {{-- Profile form --}}
            <div class="admin-card">
                <div class="admin-card-hd" style="padding-bottom:.75rem;border-bottom:1px solid #edf2f7;">
                    <h2 class="admin-card-title">Data Profil</h2>
                </div>
                <div class="admin-card-body" style="padding-top:1.25rem;">
                    <form method="POST" action="{{ route('admin.settings.profile') }}">
                        @csrf
                        <div style="display:flex;justify-content:center;margin-bottom:1.25rem;">
                            <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#60a5fa,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:2rem;font-weight:800;border:3px solid #e0e7ff;">
                                {{ strtoupper(substr($adminUser->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="aform-group">
                            <label class="aform-label" for="adminName">Nama</label>
                            <input type="text" id="adminName" name="name" class="aform-input"
                                   value="{{ old('name', $adminUser->name) }}" required>
                        </div>
                        <div class="aform-group">
                            <label class="aform-label" for="adminEmail">Email</label>
                            <input type="email" id="adminEmail" name="email" class="aform-input"
                                   value="{{ old('email', $adminUser->email) }}" required>
                        </div>
                        <div class="aform-group">
                            <label class="aform-label">NIS Admin</label>
                            <input type="text" class="aform-input" value="{{ $adminUser->nis ?? '-' }}" disabled
                                   style="background:#f8fafc;color:#94a3b8;">
                            <small style="color:#94a3b8;font-size:.72rem;">NIS tidak dapat diubah</small>
                        </div>
                        <button type="submit" class="abtn abtn-primary" style="width:100%;margin-top:.5rem;">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Password change form --}}
            <div class="admin-card">
                <div class="admin-card-hd" style="padding-bottom:.75rem;border-bottom:1px solid #edf2f7;">
                    <h2 class="admin-card-title">Ubah Password</h2>
                </div>
                <div class="admin-card-body" style="padding-top:1.25rem;">
                    <form method="POST" action="{{ route('admin.settings.password') }}">
                        @csrf
                        <div class="aform-group">
                            <label class="aform-label" for="currentPassword">Password Saat Ini</label>
                            <input type="password" id="currentPassword" name="current_password" class="aform-input"
                                   placeholder="Masukkan password lama" required>
                            @error('current_password')
                                <small style="color:#ef4444;font-size:.78rem;">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="aform-group">
                            <label class="aform-label" for="newPassword">Password Baru</label>
                            <input type="password" id="newPassword" name="password" class="aform-input"
                                   placeholder="Minimal 6 karakter" required minlength="6">
                        </div>
                        <div class="aform-group">
                            <label class="aform-label" for="confirmPassword">Konfirmasi Password Baru</label>
                            <input type="password" id="confirmPassword" name="password_confirmation" class="aform-input"
                                   placeholder="Ulangi password baru" required>
                        </div>
                        <button type="submit" class="abtn abtn-primary" style="width:100%;margin-top:.5rem;">
                            Ubah Password
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- System info card --}}
        <div class="admin-card" style="max-width:900px;margin-top:1.25rem;">
            <div class="admin-card-hd" style="padding-bottom:.75rem;border-bottom:1px solid #edf2f7;">
                <h2 class="admin-card-title">Informasi Sistem</h2>
            </div>
            <div class="admin-card-body" style="padding-top:1rem;">
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem;">
                    @foreach([
                        ['Nama Aplikasi', 'Eventty'],
                        ['Versi Laravel', app()->version()],
                        ['PHP Version', PHP_VERSION],
                        ['Environment', config('app.env')],
                        ['Database', config('database.default')],
                        ['Bergabung', $adminUser->created_at->format('d F Y')],
                    ] as [$label, $value])
                    <div style="background:#f8fafc;border:1px solid #e8edf5;border-radius:.625rem;padding:.75rem 1rem;">
                        <div style="font-size:.68rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">{{ $label }}</div>
                        <div style="font-size:.825rem;font-weight:700;color:#0f172a;">{{ $value }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])
</body>
</html>
