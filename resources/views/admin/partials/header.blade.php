{{-- Admin Header — digunakan di semua halaman admin --}}
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
@vite('resources/js/utils/iconify-migration.js')
@php $adminUser = Auth::user(); @endphp
<header class="admin-header" id="adminHeader">

    <div class="admin-header-left">
        <span class="admin-greeting">Selamat datang,</span>
        <span class="admin-page-title">{{ $adminUser->name }}</span>
    </div>

    <div class="admin-header-right">

        {{-- Notification button --}}
        <button class="admin-icon-btn" id="notifBtn" aria-label="Notifikasi" title="Notifikasi">
            <iconify-icon icon="lucide:bell" width="17" height="17"></iconify-icon>
            {{-- Badge hanya tampil jika ada pendaftar baru --}}
            @php $newRegistrations = \App\Models\EventParticipant::where('created_at', '>=', now()->subHours(24))->count(); @endphp
            @if($newRegistrations > 0)
                <span class="admin-notif-badge">{{ $newRegistrations > 9 ? '9+' : $newRegistrations }}</span>
            @endif
        </button>

        {{-- Profile button --}}
        <div class="admin-profile-btn" id="profileBtn" style="padding:.45rem .7rem;border:1px solid #e2e8f0;background:rgba(255,255,255,0.7);border-radius:12px;">
            <div class="admin-avatar" style="width:32px;height:32px;border-radius:10px;font-size:.8rem;">
                {{ strtoupper(substr($adminUser->name, 0, 1)) }}
            </div>
            <div class="admin-profile-info" style="gap:0;line-height:1.15;">
                <span class="admin-profile-name" style="font-size:.8rem;font-weight:700;color:#0f172a;">{{ $adminUser->name }}</span>
                <span class="admin-profile-role" style="font-size:.65rem;color:#64748b;">Admin OSIS</span>
            </div>
            <iconify-icon icon="solar:alt-arrow-down-linear" width="14" height="14" style="color:#94a3b8;margin-left:2px;"></iconify-icon>
        </div>

        {{-- Notification Dropdown — ditampilkan dari DB --}}
        <div class="admin-dropdown" id="notifDropdown" style="right:120px;">
            <div class="admin-dropdown-header">
                <span class="admin-dropdown-title">
                    Aktivitas Terbaru
                </span>
            </div>
            <div class="admin-dropdown-list" id="headerNotifList">
                @php
                    $recentParticipants = \App\Models\EventParticipant::with(['user','event'])
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                @forelse($recentParticipants as $rp)
                <div class="admin-dropdown-item {{ $rp->created_at->gt(now()->subHours(2)) ? 'unread' : '' }}">
                    <div class="admin-dropdown-icon">
                        <iconify-icon icon="solar:user-plus-linear" width="14" height="14"></iconify-icon>
                    </div>
                    <div class="admin-dropdown-text">
                        <div class="admin-dropdown-msg">{{ $rp->user->name }} mendaftar {{ $rp->event->name }}</div>
                        <div class="admin-dropdown-time">{{ $rp->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                <div class="admin-dropdown-item">
                    <div class="admin-dropdown-text">
                        <div class="admin-dropdown-msg" style="color:#94a3b8;">Belum ada aktivitas terbaru</div>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="admin-dropdown-footer">
                <a href="{{ url('/admin/participants') }}">Lihat semua peserta</a>
            </div>
        </div>

        {{-- Profile Dropdown --}}
        <div class="admin-dropdown" id="profileDropdown" style="width:240px;right:0;">
            <div style="padding:.875rem 1rem .75rem;border-bottom:1px solid #edf2f7;background:linear-gradient(180deg,#f8fafc 0%,#ffffff 100%);">
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <div class="admin-avatar" style="width:38px;height:38px;font-size:.9rem;border-radius:12px;">
                        {{ strtoupper(substr($adminUser->name, 0, 1)) }}
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:.825rem;font-weight:700;color:#0f172a;line-height:1.3;">{{ $adminUser->name }}</div>
                        <div style="font-size:.68rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $adminUser->email }}</div>
                    </div>
                </div>
            </div>
            <div class="admin-dropdown-list" style="padding:.45rem 0;">
                <a href="{{ url('/admin/settings') }}" class="admin-dropdown-item" style="margin:0 .35rem;border-radius:10px;">
                    <div class="admin-dropdown-icon" style="width:28px;height:28px;border-radius:8px;background:#f1f5f9;color:#334155;">
                        <iconify-icon icon="solar:settings-linear" width="14" height="14"></iconify-icon>
                    </div>
                    <div class="admin-dropdown-text"><div class="admin-dropdown-msg" style="font-weight:600;">Profil & Pengaturan</div></div>
                </a>
                <div class="admin-dropdown-divider" style="margin:.35rem 0;"></div>
                <button type="button" id="headerLogoutBtn" class="admin-dropdown-item danger" style="margin:0 .35rem;border-radius:10px;">
                    <div class="admin-dropdown-icon" style="width:28px;height:28px;border-radius:8px;background:#fee2e2;color:#dc2626;">
                        <iconify-icon icon="solar:logout-2-linear" width="14" height="14"></iconify-icon>
                    </div>
                    <div class="admin-dropdown-text"><div class="admin-dropdown-msg" style="font-weight:600;">Keluar</div></div>
                </button>
            </div>
        </div>

    </div>
</header>
