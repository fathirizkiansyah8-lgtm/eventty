<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css'
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

@include('admin.partials.sidebar', ['activePage' => 'settings'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <h1 class="admin-page-hd-title">Profil Admin</h1>
            <p class="admin-page-hd-sub">Informasi akun admin yang tampil pada aplikasi</p>
        </div>

        <div class="admin-card" style="max-width: 900px;">
            <div class="admin-card-hd" style="padding-bottom: 0.75rem; border-bottom: 1px solid #edf2f7;">
                <h2 class="admin-card-title" style="font-size: 1.05rem;">Data Profil</h2>
            </div>
            <div class="admin-card-body" style="padding-top: 1.5rem;">
                <form>
                    <div style="display: grid; grid-template-columns: 150px 1fr; gap: 2rem; align-items: center;">
                        <div style="display:flex; justify-content:center;">
                            <div style="width: 110px; height: 110px; border-radius: 50%; background: #edf2f7; border: 1px solid #dfe8f3; display:flex; align-items:center; justify-content:center; color:#0f172a; font-size: 2.6rem; font-weight:700;">A</div>
                        </div>

                        <div style="display: grid; gap: 1rem;">
                            <div class="aform-group" style="margin: 0;">
                                <label class="aform-label" for="adminName">Nama Admin</label>
                                <input type="text" id="adminName" class="aform-input" value="Admin OSIS" placeholder="Masukkan nama admin" style="background:#fff; border-color:#dfe7f1; border-radius:10px;">
                            </div>

                            <div class="aform-group" style="margin: 0;">
                                <label class="aform-label" for="adminEmail">Email</label>
                                <input type="email" id="adminEmail" class="aform-input" value="admin@eventty.sch.id" placeholder="Masukkan email admin" style="background:#fff; border-color:#dfe7f1; border-radius:10px;">
                            </div>

                            <div class="aform-group" style="margin: 0;">
                                <label class="aform-label" for="adminPosition">Jabatan</label>
                                <input type="text" id="adminPosition" class="aform-input" value="Ketua OSIS" placeholder="Masukkan jabatan admin" style="background:#fff; border-color:#dfe7f1; border-radius:10px;">
                            </div>

                            <div style="padding-top: .25rem;">
                                <button type="button" class="abtn abtn-primary" onclick="alert('Perubahan profil berhasil disimpan!');" style="border-radius: 10px; padding: .8rem 1.2rem; font-weight: 700;">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')

@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])
</body>
</html>
