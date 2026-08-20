@extends('user.layout')

@section('title', 'Pengaturan')

@push('css')
<style>
.settings-page {
    padding: 1.5rem 1.75rem;
    max-width: 680px;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
}

.settings-page-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--text-primary);
    font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
    margin-bottom: 1.5rem;
}

/* ── SECTION CARD ── */
.settings-card {
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1.25rem;
    overflow: hidden;
    margin-bottom: 1.25rem;
}

.settings-card-header {
    padding: 1rem 1.5rem 0.75rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--bg-tertiary);
}

.settings-card-title {
    font-size: 0.85rem;
    font-weight: 800;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

/* ── ROW ── */
.settings-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    transition: background 0.15s;
}
.settings-row:last-child { border-bottom: none; }
.settings-row:hover { background: var(--bg-primary); }

.settings-row-left { flex: 1; }
.settings-row-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.15rem;
}
.settings-row-desc {
    font-size: 0.775rem;
    color: var(--text-muted);
    font-weight: 400;
}

/* ── TOGGLE SWITCH ── */
.toggle-wrap {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    flex-shrink: 0;
}

.toggle-label-text {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--text-muted);
    min-width: 28px;
    text-align: center;
    transition: color 0.2s;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
    cursor: pointer;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}

.toggle-track {
    position: absolute;
    inset: 0;
    border-radius: 999px;
    background: #cbd5e1;
    border: 2px solid #94a3b8;
    transition: background 0.25s, border-color 0.25s;
}

.toggle-switch input:checked ~ .toggle-track {
    background: #0f1f4e;
    border-color: #0f1f4e;
}

.toggle-thumb {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #ffffff;
    box-shadow: 0 1px 4px rgba(0,0,0,0.25);
    transition: transform 0.25s cubic-bezier(.4,0,.2,1);
}

.toggle-switch input:checked ~ .toggle-track ~ .toggle-thumb,
.toggle-switch input:checked + .toggle-track + .toggle-thumb {
    transform: translateX(22px);
}

/* Fix: use sibling combinator inside label */
.toggle-switch input:checked ~ * .toggle-thumb { transform: translateX(22px); }

/* ── DANGER ZONE ── */
.settings-card.danger-card .settings-card-header {
    background: rgba(239, 68, 68, 0.06);
    border-bottom-color: rgba(239, 68, 68, 0.15);
}
.settings-card.danger-card .settings-card-title { color: #dc2626; }

.btn-danger-outline {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 1.1rem;
    border-radius: 0.625rem;
    border: 1.5px solid #ef4444;
    background: transparent;
    color: #ef4444;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s;
    flex-shrink: 0;
}
.btn-danger-outline:hover { background: #ef4444; color: white; }
</style>
@endpush

@section('content')
<div class="settings-page">
    <h1 class="settings-page-title">Pengaturan</h1>

    {{-- ── TAMPILAN ── --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <div class="settings-card-title">Preferensi Tampilan</div>
        </div>

        <div class="settings-row">
            <div class="settings-row-left">
                <div class="settings-row-label">Mode Tampilan</div>
                <div class="settings-row-desc">Pilih antara mode terang atau mode gelap</div>
            </div>
            <div class="toggle-wrap">
                <span class="toggle-label-text" id="themeStateLabel">☀️</span>
                <label class="toggle-switch" title="Toggle mode gelap/terang">
                    <input type="checkbox" id="themeToggleSetting">
                    <div class="toggle-track"></div>
                    <div class="toggle-thumb"></div>
                </label>
                <span style="font-size:0.75rem; font-weight:700; color:var(--text-muted); min-width:32px;">🌙</span>
            </div>
        </div>
    </div>

    {{-- ── NOTIFIKASI ── --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <div class="settings-card-title">Notifikasi</div>
        </div>

        <div class="settings-row">
            <div class="settings-row-left">
                <div class="settings-row-label">Notifikasi Event Baru</div>
                <div class="settings-row-desc">Dapatkan pemberitahuan saat event baru dibuka</div>
            </div>
            <div class="toggle-wrap">
                <span class="toggle-label-text notif-state" id="notif1Label">ON</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="notif1Toggle" checked onchange="updateNotifLabel('notif1Toggle','notif1Label')">
                    <div class="toggle-track"></div>
                    <div class="toggle-thumb"></div>
                </label>
            </div>
        </div>

        <div class="settings-row">
            <div class="settings-row-left">
                <div class="settings-row-label">Notifikasi Pengingat Event</div>
                <div class="settings-row-desc">Ingatkan saya sebelum event dimulai</div>
            </div>
            <div class="toggle-wrap">
                <span class="toggle-label-text notif-state" id="notif2Label">ON</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="notif2Toggle" checked onchange="updateNotifLabel('notif2Toggle','notif2Label')">
                    <div class="toggle-track"></div>
                    <div class="toggle-thumb"></div>
                </label>
            </div>
        </div>

        <div class="settings-row">
            <div class="settings-row-left">
                <div class="settings-row-label">Notifikasi Sertifikat Tersedia</div>
                <div class="settings-row-desc">Beritahu saya ketika sertifikat sudah bisa diunduh</div>
            </div>
            <div class="toggle-wrap">
                <span class="toggle-label-text notif-state" id="notif3Label">OFF</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="notif3Toggle" onchange="updateNotifLabel('notif3Toggle','notif3Label')">
                    <div class="toggle-track"></div>
                    <div class="toggle-thumb"></div>
                </label>
            </div>
        </div>
    </div>

    {{-- ── AKUN / DANGER ZONE ── --}}
    <div class="settings-card danger-card">
        <div class="settings-card-header">
            <div class="settings-card-title">Zona Berbahaya</div>
        </div>

        <div class="settings-row">
            <div class="settings-row-left">
                <div class="settings-row-label">Hapus Akun</div>
                <div class="settings-row-desc">Tindakan ini permanen dan tidak dapat dibatalkan</div>
            </div>
            <button class="btn-danger-outline" onclick="confirm('Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                    <path d="M10 11v6M14 11v6"></path>
                </svg>
                Hapus Akun
            </button>
        </div>
    </div>

</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Theme toggle di settings
    const themeInput = document.getElementById('themeToggleSetting');
    const themeLabel = document.getElementById('themeStateLabel');

    // Sync dengan tema saat ini
    const savedTheme = localStorage.getItem('theme') || 'light';
    themeInput.checked = (savedTheme === 'dark');
    themeLabel.textContent = savedTheme === 'dark' ? '🌙' : '☀️';
    document.body.setAttribute('data-theme', savedTheme);

    themeInput.addEventListener('change', function () {
        const newTheme = this.checked ? 'dark' : 'light';
        document.body.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        themeLabel.textContent = newTheme === 'dark' ? '🌙' : '☀️';
    });

    // ── Load saved notif prefs
    ['notif1Toggle','notif2Toggle','notif3Toggle'].forEach(function (id, i) {
        const saved = localStorage.getItem('notif_' + id);
        const el    = document.getElementById(id);
        const lbl   = document.getElementById('notif' + (i+1) + 'Label');
        if (saved !== null) {
            el.checked = saved === 'true';
            if (lbl) lbl.textContent = el.checked ? 'ON' : 'OFF';
        }
    });
});

function updateNotifLabel(toggleId, labelId) {
    const el  = document.getElementById(toggleId);
    const lbl = document.getElementById(labelId);
    if (lbl) {
        lbl.textContent  = el.checked ? 'ON' : 'OFF';
        lbl.style.color  = el.checked ? '#0f1f4e' : 'var(--text-muted)';
    }
    localStorage.setItem('notif_' + toggleId, el.checked);
}
</script>
@endpush
