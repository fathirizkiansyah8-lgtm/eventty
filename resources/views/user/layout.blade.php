<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Eventy</title>

    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/components/header.css',
    ])

    @stack('css')
</head>

<body class="@yield('body-class')">
<script>
    // Apply saved theme immediately to prevent flash
    (function(){
        var t = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', t);
        document.addEventListener('DOMContentLoaded', function(){
            document.body.setAttribute('data-theme', t);
        });
    })();
</script>
    <!-- Sidebar Toggle -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Eventy Logo" class="sidebar-logo">
            <div>
                <div class="sidebar-brand">EVENTY</div>
                <div style="font-size:0.65rem; color:var(--text-muted); font-weight:500; margin-top:-2px; letter-spacing:0.03em;">School Event Management</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section">

                <a href="{{ url('/user/dashboard') }}" class="sidebar-link @if(request()->is('user/dashboard')) active @endif">
                    <span class="sidebar-link-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                        </svg>
                    </span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ url('/user/events') }}" class="sidebar-link @if(request()->is('user/events*')) active @endif">
                    <span class="sidebar-link-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </span>
                    <span>Events</span>
                </a>

                <a href="{{ url('/user/notifications') }}" class="sidebar-link @if(request()->is('user/notifications')) active @endif">
                    <span class="sidebar-link-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 22h16"></path>
                            <path d="M10 2v2"></path>
                            <path d="M14 2v2"></path>
                            <path d="M12 4C8.5 4 6 6.5 6 10v4l-2 2v1h16v-1l-2-2v-4c0-3.5-2.5-6-6-6z"></path>
                            <path d="M3 6l1.5 1.5"></path>
                            <path d="M21 6l-1.5 1.5"></path>
                        </svg>
                    </span>
                    <span>News</span>
                </a>

                <a href="{{ url('/user/my-events') }}" class="sidebar-link @if(request()->is('user/my-events')) active @endif">
                    <span class="sidebar-link-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                            <polyline points="9 16 11 18 15 14"></polyline>
                        </svg>
                    </span>
                    <span>My Events</span>
                </a>

                <a href="{{ url('/user/certificates') }}" class="sidebar-link @if(request()->is('user/certificates')) active @endif">
                    <span class="sidebar-link-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="7"></circle>
                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                        </svg>
                    </span>
                    <span>Certificates</span>
                </a>

                <a href="{{ url('/user/messages') }}" class="sidebar-link @if(request()->is('user/messages*')) active @endif">
                    <span class="sidebar-link-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </span>
                    <span>Messages</span>
                    <span class="sidebar-badge" id="sidebarMsgBadge">2</span>
                </a>

                <a href="{{ url('/user/settings') }}" class="sidebar-link @if(request()->is('user/settings')) active @endif">
                    <span class="sidebar-link-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </span>
                    <span>Settings</span>
                </a>

            </div>
        </nav>

        <!-- Quote Box -->
        <div style="margin: 0 0.875rem 0.75rem; padding: 1rem; background: var(--bg-tertiary); border-radius: 0.875rem; border: 1px solid var(--border-color); position: relative;">
            <div style="font-size: 0.75rem; color: var(--text-secondary); line-height: 1.6; font-style: italic;">
                "The best way to predict the future is to create it."
            </div>
            <div style="display: flex; justify-content: flex-end; margin-top: 0.4rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                    <path d="M2 17l10 5 10-5"></path>
                    <path d="M2 12l10 5 10-5"></path>
                </svg>
            </div>
        </div>

        <!-- Copyright -->
        <div style="padding: 0 0.875rem 1rem; text-align: left;">
            <div style="font-size: 0.65rem; color: var(--text-muted); font-weight: 500; line-height: 1.6;">
                © 2025 EVENTY<br>All rights reserved.
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <div class="header-greeting">
                    <span class="header-greeting-text">Selamat datang,</span>
                    <span class="header-user-name">{{ Auth::user()->name }}</span>
                </div>
            </div>

            <div class="header-right">
                <div class="header-actions">
                    <div class="header-profile" id="profileBtn">
                        <div class="avatar avatar-sm">
                            <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="profile-dropdown-header">
                            <div class="avatar avatar-md">
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <div class="profile-dropdown-user-info">
                                <span class="profile-dropdown-user-name">{{ Auth::user()->name }}</span>
                                <span class="profile-dropdown-user-nis">NIS {{ Auth::user()->nis ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="profile-dropdown-divider"></div>
                        <a href="{{ url('/user/profile') }}" class="profile-dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ url('/user/messages') }}" class="profile-dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span>Messages</span>
                        </a>
                        <a href="{{ url('/user/settings') }}" class="profile-dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                            <span>Pengaturan</span>
                        </a>
                        <div class="profile-dropdown-divider"></div>
                        <button type="button" id="headerLogoutBtn" class="profile-dropdown-item danger" style="display:flex; align-items:center; gap:0.75rem; width:100%;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Logout Confirmation Modal -->
    <div class="modal-overlay" id="logoutModal" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
        <div class="logout-modal">
            <div class="logout-modal-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </div>
            <div class="modal-header">
                <h3 class="modal-title" id="logoutModalTitle">Konfirmasi Keluar</h3>
            </div>
            <div class="modal-body">
                <p>
                    Apakah Anda yakin ingin keluar dari sesi ini? Anda perlu memasukkan kredensial lagi untuk masuk.
                </p>
            </div>
            <div class="modal-footer logout-modal-actions">
                <button type="button" class="btn-logout-cancel" id="cancelLogoutBtn">Batal</button>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout-confirm">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Event Registration Form Modal (Google Form Style) -->
    <div class="modal-overlay" id="eventRegistrationModal" role="dialog" aria-modal="true" aria-labelledby="eventRegistrationTitle">
        <div id="regModalBox" style="background: var(--bg-primary, #fff); border-radius: 1.25rem; box-shadow: 0 20px 60px rgba(0,0,0,0.15); width: 100%; max-width: 540px; max-height: 90vh; overflow-y: auto; padding: 0; position: relative;">

            <!-- Form Header Bar -->
            <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 1.25rem 1.25rem 0 0; padding: 1.5rem 1.75rem 1.25rem;">
                <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.5rem;">
                    <div style="width:36px; height:36px; background:rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </div>
                    <div>
                        <div style="color:white; font-size:0.72rem; font-weight:500; text-transform:uppercase; letter-spacing:0.05em; opacity:0.8;">Formulir Pendaftaran</div>
                        <div style="color:white; font-weight:700; font-size:1.1rem; line-height:1.2;" id="eventRegistrationTitle">Career Day</div>
                    </div>
                </div>
                <div style="color:rgba(255,255,255,0.85); font-size:0.82rem;" id="regFormEventDate">📅 Jadwal menyesuaikan event</div>
            </div>

            <!-- Form Body -->
            <div style="padding: 1.5rem 1.75rem;">

                <!-- Info: 1 slot per jurusan -->
                <div style="background:rgba(59,130,246,0.07); border:1px solid rgba(59,130,246,0.2); border-radius:0.75rem; padding:0.75rem 1rem; margin-bottom:1.5rem; font-size:0.825rem; color:#1e40af; display:flex; align-items:flex-start; gap:0.6rem;">
                    <span style="font-size:1rem; flex-shrink:0; margin-top:1px;">ℹ️</span>
                    <span>Pendaftaran bersifat <strong>1 perwakilan per jurusan</strong>. Jika jurusanmu sudah ada yang mendaftar, slot tidak tersedia lagi.</span>
                </div>

                <form id="eventRegForm" action="{{ url('/user/events/register') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_name" id="regEventNameInput" value="">

                    <!-- Nama Lengkap -->
                    <div style="margin-bottom:1.1rem;">
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--text-primary,#1e293b); margin-bottom:0.4rem;">
                            Nama Lengkap <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="full_name" id="regFullName" placeholder="Masukkan nama lengkap kamu"
                            style="width:100%; padding:0.65rem 0.875rem; border:1.5px solid var(--border-color,#e2e8f0); border-radius:0.625rem; font-size:0.9rem; color:var(--text-primary,#1e293b); background:var(--bg-secondary,#f8fafc); outline:none; box-sizing:border-box; transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='var(--border-color,#e2e8f0)'" required>
                    </div>

                    <!-- NIS -->
                    <div style="margin-bottom:1.1rem;">
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--text-primary,#1e293b); margin-bottom:0.4rem;">
                            NIS (Nomor Induk Siswa) <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="nis" id="regNis" placeholder="Contoh: 12345"
                            style="width:100%; padding:0.65rem 0.875rem; border:1.5px solid var(--border-color,#e2e8f0); border-radius:0.625rem; font-size:0.9rem; color:var(--text-primary,#1e293b); background:var(--bg-secondary,#f8fafc); outline:none; box-sizing:border-box; transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='var(--border-color,#e2e8f0)'" required>
                    </div>

                    <!-- Kelas -->
                    <div style="margin-bottom:1.1rem;">
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--text-primary,#1e293b); margin-bottom:0.4rem;">
                            Kelas <span style="color:#ef4444;">*</span>
                        </label>
                        <select name="kelas" id="regKelas"
                            style="width:100%; padding:0.65rem 0.875rem; border:1.5px solid var(--border-color,#e2e8f0); border-radius:0.625rem; font-size:0.9rem; color:var(--text-primary,#1e293b); background:var(--bg-secondary,#f8fafc); outline:none; box-sizing:border-box; cursor:pointer; transition:border-color 0.2s; appearance:auto;"
                            onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='var(--border-color,#e2e8f0)'" onchange="updateJurusanOptions()" required>
                            <option value="">-- Pilih Kelas --</option>
                            <option value="10">Kelas 10</option>
                            <option value="11">Kelas 11</option>
                            <option value="12">Kelas 12</option>
                        </select>
                    </div>

                    <!-- Jurusan -->
                    <div style="margin-bottom:1.5rem;">
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--text-primary,#1e293b); margin-bottom:0.4rem;">
                            Jurusan <span style="color:#ef4444;">*</span>
                        </label>
                        <select name="jurusan" id="regJurusan"
                            style="width:100%; padding:0.65rem 0.875rem; border:1.5px solid var(--border-color,#e2e8f0); border-radius:0.625rem; font-size:0.9rem; color:var(--text-primary,#1e293b); background:var(--bg-secondary,#f8fafc); outline:none; box-sizing:border-box; cursor:pointer; transition:border-color 0.2s; appearance:auto;"
                            onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='var(--border-color,#e2e8f0)'" required>
                            <option value="">-- Pilih Kelas dulu --</option>
                        </select>
                        <!-- Status slot jurusan -->
                        <div id="slotStatus" style="display:none; margin-top:0.5rem; padding:0.5rem 0.75rem; border-radius:0.5rem; font-size:0.8rem; font-weight:600;"></div>
                    </div>

                    <!-- No Telepon/WA -->
                    <div style="margin-bottom:1.5rem;">
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--text-primary,#1e293b); margin-bottom:0.4rem;">
                            No. WhatsApp <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="whatsapp" id="regWa" placeholder="Contoh: 08123456789"
                            style="width:100%; padding:0.65rem 0.875rem; border:1.5px solid var(--border-color,#e2e8f0); border-radius:0.625rem; font-size:0.9rem; color:var(--text-primary,#1e293b); background:var(--bg-secondary,#f8fafc); outline:none; box-sizing:border-box; transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='var(--border-color,#e2e8f0)'" required>
                    </div>

                    <!-- Buttons -->
                    <div style="display:flex; gap:0.75rem; justify-content:flex-end;">
                        <button type="button" id="cancelRegBtn"
                            style="padding:0.65rem 1.5rem; border-radius:0.625rem; border:1.5px solid var(--border-color,#e2e8f0); background:transparent; color:var(--text-secondary,#64748b); font-size:0.9rem; font-weight:600; cursor:pointer; transition:all 0.2s;"
                            onmouseover="this.style.background='var(--bg-secondary,#f8fafc)'" onmouseout="this.style.background='transparent'">
                            Batal
                        </button>
                        <button type="submit" id="regSubmitBtn"
                            style="padding:0.65rem 1.75rem; border-radius:0.625rem; border:none; background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%); color:white; font-size:0.9rem; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(59,130,246,0.35); transition:all 0.2s;"
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Daftar Sekarang →
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
    // Data jurusan per kelas
    const jurusanData = {
        '10': [
            'Manajemen Perkantoran',
            'Manajemen Logistik',
            'Bisnis Digital',
            'Bisnis Ritel',
            'Lembaga Perbankan Syariah',
            'Rekayasa Perangkat Lunak',
            'Akuntansi 1',
            'Akuntansi 2',
        ],
        '11': [
            'Manajemen Perkantoran 1',
            'Manajemen Perkantoran 2',
            'Akuntansi 1',
            'Akuntansi 2',
            'Rekayasa Perangkat Lunak',
            'Lembaga Perbankan Syariah',
            'Bisnis Digital',
            'Bisnis Ritel',
        ],
        '12': [
            'Manajemen Perkantoran 1',
            'Manajemen Perkantoran 2',
            'Akuntansi 1',
            'Akuntansi 2',
            'Rekayasa Perangkat Lunak',
            'Lembaga Perbankan Syariah',
            'Bisnis Digital',
            'Bisnis Ritel',
        ]
    };

    // Key untuk localStorage: event + kelas + jurusan
    function getSlotKey(eventName, kelas, jurusan) {
        return 'reg_slot__' + eventName.toLowerCase().replace(/\s+/g,'_') + '__' + kelas + '__' + jurusan.toLowerCase().replace(/\s+/g,'_');
    }

    function updateJurusanOptions() {
        const kelas = document.getElementById('regKelas').value;
        const jurusanSel = document.getElementById('regJurusan');
        const eventName = document.getElementById('regEventNameInput').value;
        const slotStatus = document.getElementById('slotStatus');

        jurusanSel.innerHTML = '';
        slotStatus.style.display = 'none';

        if (!kelas) {
            jurusanSel.innerHTML = '<option value="">-- Pilih Kelas dulu --</option>';
            return;
        }

        const defaultOpt = document.createElement('option');
        defaultOpt.value = '';
        defaultOpt.textContent = '-- Pilih Jurusan --';
        jurusanSel.appendChild(defaultOpt);

        (jurusanData[kelas] || []).forEach(function(j) {
            const opt = document.createElement('option');
            opt.value = j;
            // Cek apakah slot sudah penuh
            const taken = localStorage.getItem(getSlotKey(eventName, kelas, j));
            if (taken) {
                opt.textContent = j + ' — 🔴 Slot Penuh';
                opt.disabled = true;
                opt.style.color = '#94a3b8';
            } else {
                opt.textContent = j + ' — ✅ Tersedia';
            }
            jurusanSel.appendChild(opt);
        });
    }

    // Cek slot saat jurusan dipilih
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('regJurusan').addEventListener('change', function() {
            const kelas = document.getElementById('regKelas').value;
            const jurusan = this.value;
            const eventName = document.getElementById('regEventNameInput').value;
            const slotStatus = document.getElementById('slotStatus');

            if (!jurusan) { slotStatus.style.display = 'none'; return; }

            const taken = localStorage.getItem(getSlotKey(eventName, kelas, jurusan));
            if (taken) {
                slotStatus.style.display = 'block';
                slotStatus.style.background = 'rgba(239,68,68,0.1)';
                slotStatus.style.color = '#dc2626';
                slotStatus.style.border = '1px solid rgba(239,68,68,0.3)';
                slotStatus.innerHTML = '🔴 Slot untuk jurusan ini sudah diambil oleh siswa lain.';
            } else {
                slotStatus.style.display = 'block';
                slotStatus.style.background = 'rgba(34,197,94,0.1)';
                slotStatus.style.color = '#16a34a';
                slotStatus.style.border = '1px solid rgba(34,197,94,0.3)';
                slotStatus.innerHTML = '✅ Slot tersedia! Kamu bisa mendaftar.';
            }
        });

        // Override form submit untuk simpan ke localStorage
        document.getElementById('eventRegForm').addEventListener('submit', function(e) {
            const kelas = document.getElementById('regKelas').value;
            const jurusan = document.getElementById('regJurusan').value;
            const eventName = document.getElementById('regEventNameInput').value;

            if (!kelas || !jurusan) {
                e.preventDefault();
                alert('Harap pilih kelas dan jurusan terlebih dahulu.');
                return;
            }

            const key = getSlotKey(eventName, kelas, jurusan);
            const taken = localStorage.getItem(key);
            if (taken) {
                e.preventDefault();
                alert('Maaf, slot untuk jurusan ' + jurusan + ' (Kelas ' + kelas + ') sudah penuh!');
                return;
            }

            // Simpan slot
            const nama = document.getElementById('regFullName').value;
            const nis  = document.getElementById('regNis').value;
            localStorage.setItem(key, JSON.stringify({ nama, nis, kelas, jurusan, event: eventName, waktu: new Date().toISOString() }));
        });
    });
    </script>

    @vite([
        'resources/js/components/sidebar.js',
        'resources/js/components/header.js',
    ])

    @stack('js')
</body>
</html>
