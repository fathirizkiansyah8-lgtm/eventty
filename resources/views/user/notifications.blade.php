@extends('user.layout')

@section('title', 'News & Pengumuman')

@push('css')
<style>
.news-page { padding: 1.5rem 1.75rem; font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }

.news-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.news-page-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--text-primary);
    font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
}

.news-filter-tabs {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}

.news-tab {
    padding: 0.4rem 1rem;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    border: 1.5px solid var(--border-color);
    background: var(--bg-secondary);
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.15s;
}
.news-tab:hover  { border-color: #0f1f4e; color: #0f1f4e; }
.news-tab.active { background: #0f1f4e; border-color: #0f1f4e; color: white; }

.news-list { display: flex; flex-direction: column; gap: 0.875rem; }

.news-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1rem;
    padding: 1rem 1.25rem;
    transition: all 0.2s;
    position: relative;
}
.news-card:hover {
    border-color: #0f1f4e;
    box-shadow: 0 4px 16px rgba(15,31,78,0.08);
    transform: translateY(-1px);
}
.news-card.unread { border-left: 3px solid #3b82f6; }

.news-card-dot {
    width: 9px; height: 9px;
    border-radius: 50%;
    background: #3b82f6;
    flex-shrink: 0;
    margin-top: 0.35rem;
}
.news-card.read .news-card-dot { background: transparent; }

.news-icon-wrap {
    width: 42px; height: 42px;
    border-radius: 0.75rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.icon-bg-green  { background: #dcfce7; }
.icon-bg-blue   { background: #dbeafe; }
.icon-bg-yellow { background: #fef3c7; }
.icon-bg-purple { background: #ede9fe; }
.icon-bg-red    { background: #fee2e2; }

.news-body { flex: 1; min-width: 0; }
.news-message {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    line-height: 1.5;
    margin-bottom: 0.25rem;
}
.news-time {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
}

.news-action-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.875rem;
    border-radius: 0.5rem;
    border: 1.5px solid var(--border-color);
    background: transparent;
    color: var(--text-secondary);
    font-size: 0.775rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    flex-shrink: 0;
    align-self: center;
    text-decoration: none;
}
.news-action-btn:hover { border-color: #0f1f4e; color: #0f1f4e; background: #f0f4ff; }

.news-header-actions { display: flex; gap: 0.5rem; }
.news-hdr-btn {
    padding: 0.4rem 0.9rem;
    border-radius: 0.5rem;
    border: 1.5px solid var(--border-color);
    background: var(--bg-secondary);
    color: var(--text-secondary);
    font-size: 0.775rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
}
.news-hdr-btn:hover { border-color: #0f1f4e; color: #0f1f4e; }
</style>
@endpush

@section('content')
<div class="news-page">

    <div class="news-page-header">
        <h1 class="news-page-title">News & Pengumuman</h1>
        <div class="news-header-actions">
            <button class="news-hdr-btn" id="markAllReadBtn">Tandai Semua Dibaca</button>
            <button class="news-hdr-btn" id="clearAllBtn">Hapus Semua</button>
        </div>
    </div>

    <div class="news-filter-tabs">
        <button class="news-tab active" data-filter="all">Semua</button>
        <button class="news-tab" data-filter="unread">Belum Dibaca</button>
        <button class="news-tab" data-filter="read">Sudah Dibaca</button>
    </div>

    <div class="news-list" id="newsList">

        <div class="news-card unread" data-read="false">
            <div class="news-card-dot"></div>
            <div class="news-icon-wrap icon-bg-green">🎉</div>
            <div class="news-body">
                <div class="news-message">Pendaftaran Career Day berhasil! Anda sekarang terdaftar untuk event ini.</div>
                <div class="news-time">2 menit yang lalu</div>
            </div>
            <a href="{{ url('/user/events/1') }}" class="news-action-btn">Lihat Event</a>
        </div>

        <div class="news-card unread" data-read="false">
            <div class="news-card-dot"></div>
            <div class="news-icon-wrap icon-bg-blue">📢</div>
            <div class="news-body">
                <div class="news-message">Event Career Day akan dimulai besok pada pukul 08:00 di Aula Sekolah. Jangan lupa hadir!</div>
                <div class="news-time">1 jam yang lalu</div>
            </div>
            <a href="{{ url('/user/events/1') }}" class="news-action-btn">Lihat Detail</a>
        </div>

        <div class="news-card unread" data-read="false">
            <div class="news-card-dot"></div>
            <div class="news-icon-wrap icon-bg-yellow">⚠️</div>
            <div class="news-body">
                <div class="news-message">Jadwal event Workshop Programming berubah. Event baru akan diadakan pada 25 August 2026.</div>
                <div class="news-time">3 jam yang lalu</div>
            </div>
            <a href="{{ url('/user/events/2') }}" class="news-action-btn">Lihat Perubahan</a>
        </div>

        <div class="news-card read" data-read="true">
            <div class="news-card-dot"></div>
            <div class="news-icon-wrap icon-bg-purple">🏆</div>
            <div class="news-body">
                <div class="news-message">Sertifikat Workshop Leadership telah tersedia. Anda dapat mengunduh sertifikat sekarang.</div>
                <div class="news-time">Kemarin</div>
            </div>
            <a href="{{ url('/user/certificates') }}" class="news-action-btn">Lihat Sertifikat</a>
        </div>

        <div class="news-card read" data-read="true">
            <div class="news-card-dot"></div>
            <div class="news-icon-wrap icon-bg-blue">📣</div>
            <div class="news-body">
                <div class="news-message">Pengumuman baru dari OSIS: Ada event baru yang akan segera dibuka. Stay tuned!</div>
                <div class="news-time">2 hari yang lalu</div>
            </div>
            <a href="{{ url('/user/events') }}" class="news-action-btn">Lihat Event</a>
        </div>

        <div class="news-card read" data-read="true">
            <div class="news-card-dot"></div>
            <div class="news-icon-wrap icon-bg-green">✅</div>
            <div class="news-body">
                <div class="news-message">Kehadiran Anda untuk Seminar Kewirausahaan telah dicatat. Terima kasih telah hadir!</div>
                <div class="news-time">3 hari yang lalu</div>
            </div>
            <a href="{{ url('/user/events/4') }}" class="news-action-btn">Lihat Detail</a>
        </div>

        <div class="news-card read" data-read="true">
            <div class="news-card-dot"></div>
            <div class="news-icon-wrap icon-bg-red">🏀</div>
            <div class="news-body">
                <div class="news-message">Pendaftaran Turnamen Basket dibuka! Daftarkan tim jurusanmu sebelum slot habis.</div>
                <div class="news-time">5 hari yang lalu</div>
            </div>
            <a href="{{ url('/user/events/5') }}" class="news-action-btn">Daftar Sekarang</a>
        </div>

    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs   = document.querySelectorAll('.news-tab');
    const cards  = document.querySelectorAll('#newsList .news-card');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const f = this.getAttribute('data-filter');
            cards.forEach(function (c) {
                const isUnread = c.getAttribute('data-read') === 'false';
                if (f === 'all')    c.style.display = '';
                else if (f === 'unread') c.style.display = isUnread  ? '' : 'none';
                else                     c.style.display = !isUnread ? '' : 'none';
            });
        });
    });

    document.getElementById('markAllReadBtn').addEventListener('click', function () {
        cards.forEach(function (c) {
            c.classList.remove('unread');
            c.classList.add('read');
            c.setAttribute('data-read', 'true');
            c.style.borderLeft = '';
            const dot = c.querySelector('.news-card-dot');
            if (dot) dot.style.background = 'transparent';
        });
    });

    document.getElementById('clearAllBtn').addEventListener('click', function () {
        if (confirm('Hapus semua notifikasi?')) {
            document.getElementById('newsList').innerHTML =
                '<div style="text-align:center;padding:3rem;color:var(--text-muted);font-size:0.9rem;">Tidak ada notifikasi.</div>';
        }
    });
});
</script>
@endpush
