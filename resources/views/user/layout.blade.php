<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Eventty') </title>
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/components/header.css',
        'resources/js/utils/iconify-migration.js',
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
        <iconify-icon icon="lucide:menu" width="20" height="20"></iconify-icon>
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
                    <span class="sidebar-link-icon"><iconify-icon icon="lucide:layout-dashboard"></iconify-icon></span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ url('/user/events') }}" class="sidebar-link @if(request()->is('user/events*')) active @endif">
                    <span class="sidebar-link-icon"><iconify-icon icon="lucide:calendar-days"></iconify-icon></span>
                    <span>Events</span>
                </a>

                <a href="{{ url('/user/notifications') }}" class="sidebar-link @if(request()->is('user/notifications')) active @endif">
                    <span class="sidebar-link-icon"><iconify-icon icon="lucide:megaphone"></iconify-icon></span>
                    <span>News</span>
                </a>

                <a href="{{ url('/user/my-events') }}" class="sidebar-link @if(request()->is('user/my-events')) active @endif">
                    <span class="sidebar-link-icon"><iconify-icon icon="lucide:calendar-check-2"></iconify-icon></span>
                    <span>My Events</span>
                </a>

                <a href="{{ url('/user/certificates') }}" class="sidebar-link @if(request()->is('user/certificates')) active @endif">
                    <span class="sidebar-link-icon"><iconify-icon icon="lucide:badge-check"></iconify-icon></span>
                    <span>Certificates</span>
                </a>

                <a href="{{ url('/user/messages') }}" class="sidebar-link @if(request()->is('user/messages*')) active @endif">
                    <span class="sidebar-link-icon"><iconify-icon icon="lucide:messages-square"></iconify-icon></span>
                    <span>Messages</span>
                </a>

                <a href="{{ url('/user/settings') }}" class="sidebar-link @if(request()->is('user/settings')) active @endif">
                    <span class="sidebar-link-icon">
                        <iconify-icon icon="solar:settings-linear"></iconify-icon>
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
                <iconify-icon icon="solar:layers-linear" width="16" height="16" style="color:var(--text-muted);"></iconify-icon>
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
                            <iconify-icon icon="solar:user-circle-linear" width="16" height="16"></iconify-icon>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ url('/user/messages') }}" class="profile-dropdown-item">
                            <iconify-icon icon="solar:chat-round-dots-linear" width="16" height="16"></iconify-icon>
                            <span>Messages</span>
                        </a>
                        <a href="{{ url('/user/settings') }}" class="profile-dropdown-item">
                            <iconify-icon icon="solar:settings-linear" width="16" height="16"></iconify-icon>
                            <span>Pengaturan</span>
                        </a>
                        <div class="profile-dropdown-divider"></div>
                        <button type="button" id="headerLogoutBtn" class="profile-dropdown-item danger" style="display:flex; align-items:center; gap:0.75rem; width:100%;">
                            <iconify-icon icon="solar:logout-2-linear" width="16" height="16"></iconify-icon>
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
            <button type="button" class="logout-modal-close" id="closeLogoutModalBtn" aria-label="Tutup">
                <iconify-icon icon="solar:close-circle-linear" width="20" height="20"></iconify-icon>
            </button>
            <div class="logout-modal-body-wrapper">
                <div class="logout-modal-icon-badge">
                    <iconify-icon icon="solar:logout-3-bold-duotone" width="26" height="26"></iconify-icon>
                </div>
                <div class="logout-modal-content">
                    <h3 class="logout-modal-title" id="logoutModalTitle">Konfirmasi Keluar</h3>
                    <p class="logout-modal-desc">
                        Apakah Anda yakin ingin keluar dari sesi ini? Anda perlu memasukkan kredensial lagi untuk masuk.
                    </p>
                </div>
            </div>
            <div class="logout-modal-actions">
                <button type="button" class="btn-logout-cancel" id="cancelLogoutBtn">
                    <iconify-icon icon="solar:close-square-linear" width="18" height="18"></iconify-icon>
                    <span>Batal</span>
                </button>
                <form action="{{ url('/logout') }}" method="POST" class="logout-form-inline">
                    @csrf
                    <button type="submit" class="btn-logout-confirm">
                        <iconify-icon icon="solar:logout-2-bold" width="18" height="18"></iconify-icon>
                        <span>Ya, Keluar</span>
                    </button>
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
                        <iconify-icon icon="solar:document-add-linear" width="18" height="18" style="color:white;"></iconify-icon>
                    </div>
                    <div>
                        <div style="color:white; font-size:0.72rem; font-weight:500; text-transform:uppercase; letter-spacing:0.05em; opacity:0.8;">Formulir Pendaftaran</div>
                        <div style="color:white; font-weight:700; font-size:1.1rem; line-height:1.2;" id="eventRegistrationTitle">Career Day</div>
                    </div>
                </div>
                <div style="color:rgba(255,255,255,0.85); font-size:0.82rem;" id="regFormEventDate"><iconify-icon icon="lucide:calendar-days"></iconify-icon> Jadwal menyesuaikan event</div>
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
