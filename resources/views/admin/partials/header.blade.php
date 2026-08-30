{{-- Admin Header — digunakan di semua halaman admin --}}
<header class="admin-header" id="adminHeader">

    <div class="admin-header-left">
        <span class="admin-greeting">Selamat datang,</span>
        <span class="admin-page-title">Admin OSIS 👋</span>
    </div>

    <div class="admin-header-right">

        {{-- Notification button --}}
        <button class="admin-icon-btn" id="notifBtn" aria-label="Notifikasi" title="Notifikasi">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <span class="admin-notif-badge">3</span>
        </button>

        {{-- Profile button --}}
        <div class="admin-profile-btn" id="profileBtn" style="padding: .45rem .7rem; border: 1px solid #e2e8f0; background: rgba(255,255,255,0.7); border-radius: 12px;">
            <div class="admin-avatar" style="width: 32px; height: 32px; border-radius: 10px; font-size: .8rem;">A</div>
            <div class="admin-profile-info" style="gap: 0; line-height: 1.15;">
                <span class="admin-profile-name" style="font-size: .8rem; font-weight: 700; color: #0f172a;">Admin OSIS</span>
                <span class="admin-profile-role" style="font-size: .65rem; color: #64748b;">Ketua OSIS</span>
            </div>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:#94a3b8;margin-left:2px;"><polyline points="6 9 12 15 18 9"/></svg>
        </div>

        {{-- Notification Dropdown --}}
        <div class="admin-dropdown" id="notifDropdown" style="right:120px;">
            <div class="admin-dropdown-header">
                <span class="admin-dropdown-title">
                    Notifikasi
                    <span class="admin-dropdown-mark-all">Tandai dibaca</span>
                </span>
            </div>
            <div class="admin-dropdown-list">
                <div class="admin-dropdown-item unread">
                    <div class="admin-dropdown-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="admin-dropdown-text">
                        <div class="admin-dropdown-msg">Pendaftaran baru untuk Career Day</div>
                        <div class="admin-dropdown-time">5 menit yang lalu</div>
                    </div>
                </div>
                <div class="admin-dropdown-item unread">
                    <div class="admin-dropdown-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <div class="admin-dropdown-text">
                        <div class="admin-dropdown-msg">Kuota Workshop hampir penuh</div>
                        <div class="admin-dropdown-time">30 menit yang lalu</div>
                    </div>
                </div>
                <div class="admin-dropdown-item">
                    <div class="admin-dropdown-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="admin-dropdown-text">
                        <div class="admin-dropdown-msg">Event Seminar berhasil dibuat</div>
                        <div class="admin-dropdown-time">1 jam yang lalu</div>
                    </div>
                </div>
            </div>
            <div class="admin-dropdown-footer">
                <a href="{{ url('/admin/notifications') }}">Lihat semua notifikasi</a>
            </div>
        </div>

        {{-- Profile Dropdown --}}
        <div class="admin-dropdown" id="profileDropdown" style="width: 240px; right: 0;">
            <div style="padding: .875rem 1rem .75rem; border-bottom: 1px solid #edf2f7; background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <div class="admin-avatar" style="width:38px;height:38px;font-size:.9rem;border-radius:12px;">A</div>
                    <div style="min-width:0;">
                        <div style="font-size:.825rem;font-weight:700;color:#0f172a;line-height:1.3;">Admin OSIS</div>
                        <div style="font-size:.68rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">admin@eventty.sch.id</div>
                    </div>
                </div>
            </div>
            <div class="admin-dropdown-list" style="padding: .45rem 0;">
                <a href="{{ url('/admin/settings') }}" class="admin-dropdown-item" style="margin: 0 .35rem; border-radius: 10px;">
                    <div class="admin-dropdown-icon" style="width: 28px; height: 28px; border-radius: 8px; background: #f1f5f9; color: #334155;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="admin-dropdown-text"><div class="admin-dropdown-msg" style="font-weight:600;">Profil</div></div>
                </a>
                <div class="admin-dropdown-divider" style="margin: .35rem 0;"></div>
                <button type="button" id="headerLogoutBtn" class="admin-dropdown-item danger" style="margin: 0 .35rem; border-radius: 10px;">
                    <div class="admin-dropdown-icon" style="width: 28px; height: 28px; border-radius: 8px; background:#fee2e2;color:#dc2626;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </div>
                    <div class="admin-dropdown-text"><div class="admin-dropdown-msg" style="font-weight:600;">Keluar</div></div>
                </button>
            </div>
        </div>

    </div>
</header>
