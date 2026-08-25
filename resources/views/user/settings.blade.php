@extends('user.layout')

@section('title', 'Pengaturan')

@push('css')
<style>
.settings-page {
    padding: 1.75rem 1.75rem;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
}

.settings-page-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 1.75rem;
}

.settings-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    align-items: start;
}

/* Card */
.stg-card {
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1.1rem;
    overflow: hidden;
}

.stg-card-head {
    padding: .75rem 1.25rem;
    background: var(--bg-tertiary);
    border-bottom: 1px solid var(--border-color);
}
.stg-card-head-title {
    font-size: .7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--text-muted);
}

/* Row */
.stg-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: .95rem 1.25rem;
    border-bottom: 1px solid var(--border-color);
    transition: background .15s;
}
.stg-row:last-child { border-bottom: none; }
.stg-row:hover { background: var(--bg-primary); }

.stg-row-info { flex: 1; }
.stg-row-label {
    font-size: .875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: .15rem;
}
.stg-row-desc {
    font-size: .75rem;
    color: var(--text-muted);
    line-height: 1.4;
}

/* Toggle */
.toggle-wrap {
    display: flex;
    align-items: center;
    gap: .5rem;
    flex-shrink: 0;
}
.toggle-state-lbl {
    font-size: .72rem;
    font-weight: 700;
    color: var(--text-muted);
    min-width: 28px;
    text-align: right;
}
.toggle-switch {
    position: relative;
    width: 46px;
    height: 25px;
    display: inline-block;
    cursor: pointer;
    flex-shrink: 0;
}
.toggle-switch input { display: none; }
.toggle-track {
    position: absolute;
    inset: 0;
    border-radius: 999px;
    background: #cbd5e1;
    border: 1.5px solid #94a3b8;
    transition: all .25s;
}
.toggle-switch input:checked ~ .toggle-track {
    background: #0f1f4e;
    border-color: #0f1f4e;
}
.toggle-thumb {
    position: absolute;
    top: 3px; left: 3px;
    width: 17px; height: 17px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 1px 4px rgba(0,0,0,.2);
    transition: transform .25s cubic-bezier(.4,0,.2,1);
}
.toggle-switch input:checked ~ .toggle-track ~ .toggle-thumb {
    transform: translateX(21px);
}

/* Theme toggle special */
.theme-toggle-row {
    display: flex;
    align-items: center;
    gap: .625rem;
    flex-shrink: 0;
}
.theme-emoji { font-size: 1rem; line-height: 1; }

/* Profile info card */
.profile-info-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.1rem 1.25rem;
}
.profile-avatar-big {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg,#0f1f4e,#3b82f6);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.25rem; font-weight: 800;
    flex-shrink: 0;
}
.profile-name  { font-size: .95rem; font-weight: 800; color: var(--text-primary); }
.profile-email { font-size: .75rem; color: var(--text-muted); margin-top: .1rem; }
.profile-class {
    display: inline-flex; align-items: center; gap: .3rem;
    background: #dbeafe; color: #1d4ed8;
    font-size: .68rem; font-weight: 700;
    padding: .2rem .6rem; border-radius: 999px; margin-top: .35rem;
}

/* Danger */
.stg-card.danger .stg-card-head { background: rgba(239,68,68,.06); border-bottom-color: rgba(239,68,68,.15); }
.stg-card.danger .stg-card-head-title { color: #dc2626; }

.danger-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .45rem 1rem; border-radius: .6rem;
    border: 1.5px solid #ef4444; background: transparent;
    color: #ef4444; font-size: .78rem; font-weight: 700;
    cursor: pointer; transition: all .15s; flex-shrink: 0;
}
.danger-btn:hover { background: #ef4444; color: #fff; }
</style>
@endpush

@section('content')
<div class="settings-page">
    <h1 class="settings-page-title">Pengaturan</h1>

    <div class="settings-layout">

        {{-- KOLOM KIRI --}}
        <div style="display:flex; flex-direction:column; gap:1.25rem;">

            {{-- Profil --}}
            <div class="stg-card">
                <div class="stg-card-head">
                    <div class="stg-card-head-title">Profil Saya</div>
                </div>
                <div class="profile-info-card">
                    <div class="profile-avatar-big">F</div>
                    <div>
                        <div class="profile-name">Fathi</div>
                        <div class="profile-email">fathi@smkn20jkt.sch.id</div>
                        <div class="profile-class">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            XI RPL 1
                        </div>
                    </div>
                </div>
                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">NIS</div>
                        <div class="stg-row-desc">Nomor Induk Siswa</div>
                    </div>
                    <span style="font-size:.875rem; font-weight:700; color:var(--text-primary);">12345</span>
                </div>
                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">Kelas</div>
                        <div class="stg-row-desc">Kelas aktif saat ini</div>
                    </div>
                    <span style="font-size:.875rem; font-weight:700; color:var(--text-primary);">XI RPL 1</span>
                </div>
            </div>

            {{-- Tampilan --}}
            <div class="stg-card">
                <div class="stg-card-head">
                    <div class="stg-card-head-title">Tampilan</div>
                </div>
                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">Mode Gelap</div>
                        <div class="stg-row-desc">Aktifkan tema gelap untuk kenyamanan mata</div>
                    </div>
                    <div class="theme-toggle-row">
                        <span class="theme-emoji" id="themeStateLabel">☀️</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="themeToggleSetting">
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                        <span class="theme-emoji">🌙</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN --}}
        <div style="display:flex; flex-direction:column; gap:1.25rem;">

            {{-- Notifikasi --}}
            <div class="stg-card">
                <div class="stg-card-head">
                    <div class="stg-card-head-title">Notifikasi</div>
                </div>

                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">Notifikasi Event Baru</div>
                        <div class="stg-row-desc">Pemberitahuan saat event baru dibuka</div>
                    </div>
                    <div class="toggle-wrap">
                        <span class="toggle-state-lbl" id="notif1Label">ON</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="notif1Toggle" checked onchange="updateNotif('notif1Toggle','notif1Label')">
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                    </div>
                </div>

                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">Pengingat Event</div>
                        <div class="stg-row-desc">Ingatkan sebelum event dimulai</div>
                    </div>
                    <div class="toggle-wrap">
                        <span class="toggle-state-lbl" id="notif2Label">ON</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="notif2Toggle" checked onchange="updateNotif('notif2Toggle','notif2Label')">
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                    </div>
                </div>

                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">Sertifikat Tersedia</div>
                        <div class="stg-row-desc">Beritahu ketika sertifikat bisa diunduh</div>
                    </div>
                    <div class="toggle-wrap">
                        <span class="toggle-state-lbl" id="notif3Label">OFF</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="notif3Toggle" onchange="updateNotif('notif3Toggle','notif3Label')">
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                    </div>
                </div>

                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">Pengumuman OSIS</div>
                        <div class="stg-row-desc">Info terbaru dari OSIS dan sekolah</div>
                    </div>
                    <div class="toggle-wrap">
                        <span class="toggle-state-lbl" id="notif4Label">ON</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="notif4Toggle" checked onchange="updateNotif('notif4Toggle','notif4Label')">
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                    </div>
                </div>

                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">Hasil Kehadiran</div>
                        <div class="stg-row-desc">Notifikasi setelah absensi dikonfirmasi</div>
                    </div>
                    <div class="toggle-wrap">
                        <span class="toggle-state-lbl" id="notif5Label">OFF</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="notif5Toggle" onchange="updateNotif('notif5Toggle','notif5Label')">
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Privasi --}}
            <div class="stg-card">
                <div class="stg-card-head">
                    <div class="stg-card-head-title">Privasi</div>
                </div>
                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">Tampilkan Profil Publik</div>
                        <div class="stg-row-desc">Siswa lain bisa melihat profilmu</div>
                    </div>
                    <div class="toggle-wrap">
                        <span class="toggle-state-lbl" id="priv1Label">ON</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="priv1Toggle" checked onchange="updateNotif('priv1Toggle','priv1Label')">
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                    </div>
                </div>
                <div class="stg-row">
                    <div class="stg-row-info">
                        <div class="stg-row-label">Tampilkan Aktivitas Event</div>
                        <div class="stg-row-desc">Riwayat event yang kamu ikuti</div>
                    </div>
                    <div class="toggle-wrap">
                        <span class="toggle-state-lbl" id="priv2Label">OFF</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="priv2Toggle" onchange="updateNotif('priv2Toggle','priv2Label')">
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Theme toggle sync
    const themeInput = document.getElementById('themeToggleSetting');
    const themeLabel = document.getElementById('themeStateLabel');
    const saved = localStorage.getItem('theme') || 'light';
    themeInput.checked = (saved === 'dark');
    themeLabel.textContent = saved === 'dark' ? '🌙' : '☀️';
    document.body.setAttribute('data-theme', saved);

    themeInput.addEventListener('change', function () {
        const t = this.checked ? 'dark' : 'light';
        document.body.setAttribute('data-theme', t);
        localStorage.setItem('theme', t);
        themeLabel.textContent = t === 'dark' ? '🌙' : '☀️';
    });

    // Load saved notif states
    ['notif1Toggle','notif2Toggle','notif3Toggle','notif4Toggle','notif5Toggle','priv1Toggle','priv2Toggle'].forEach(function(id, i) {
        const labels = ['notif1Label','notif2Label','notif3Label','notif4Label','notif5Label','priv1Label','priv2Label'];
        const s = localStorage.getItem('stg_' + id);
        if (s !== null) {
            const el = document.getElementById(id);
            const lb = document.getElementById(labels[i]);
            if (el) el.checked = s === 'true';
            if (lb) {
                lb.textContent = (s === 'true') ? 'ON' : 'OFF';
                lb.style.color = (s === 'true') ? '#0f1f4e' : 'var(--text-muted)';
            }
        }
    });
});

function updateNotif(toggleId, labelId) {
    const el = document.getElementById(toggleId);
    const lb = document.getElementById(labelId);
    if (lb) {
        lb.textContent = el.checked ? 'ON' : 'OFF';
        lb.style.color = el.checked ? '#0f1f4e' : 'var(--text-muted)';
    }
    localStorage.setItem('stg_' + toggleId, el.checked);
}
</script>
@endpush
