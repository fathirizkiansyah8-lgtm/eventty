@extends('user.layout')

@section('title', 'News & Updates')

@push('css')
<style>
/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   NEWS PAGE
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.news-page { padding: 1.5rem 1.75rem; font-family: 'Plus Jakarta Sans','Inter',sans-serif; }

.news-top {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem; flex-wrap: wrap; gap: .75rem;
}
.news-page-title { font-size:1.4rem; font-weight:800; color:var(--text-primary); }
.news-count-badge {
    background:#0f1f4e; color:#fff; font-size:.72rem; font-weight:700;
    padding:.25rem .65rem; border-radius:999px;
}

/* Filter chips */
.news-filters { display:flex; gap:.5rem; flex-wrap:wrap; margin-bottom:1.25rem; }
.nf-chip {
    padding:.38rem 1rem; border-radius:999px; font-size:.78rem; font-weight:600;
    border:1.5px solid var(--border-color); background:var(--bg-secondary);
    color:var(--text-secondary); cursor:pointer; transition:all .15s; white-space:nowrap;
    user-select:none;
}
.nf-chip:hover { border-color:#0f1f4e; color:#0f1f4e; }
.nf-chip.active { background:#0f1f4e; border-color:#0f1f4e; color:#fff; }

/* News grid */
.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.1rem;
}

/* Card */
.news-card {
    background: var(--bg-secondary);
    border: 1.5px solid var(--border-color);
    border-radius: 1.1rem;
    overflow: hidden;
    cursor: pointer;
    transition: all .2s;
    display: flex; flex-direction: column;
}
.news-card:hover {
    border-color: #0f1f4e;
    box-shadow: 0 6px 24px rgba(15,31,78,.1);
    transform: translateY(-2px);
}

/* Thumbnail */
.news-thumb {
    width:100%; height:150px; object-fit:cover; display:block;
    background: linear-gradient(135deg,#1a3a7c,#3b6fd4);
    flex-shrink:0;
}
.news-thumb-gradient-1 { background: linear-gradient(135deg,#1a3a7c 0%,#3b82f6 100%); }
.news-thumb-gradient-2 { background: linear-gradient(135deg,#064e3b 0%,#10b981 100%); }
.news-thumb-gradient-3 { background: linear-gradient(135deg,#78350f 0%,#f59e0b 100%); }
.news-thumb-placeholder {
    width:100%; height:150px; display:flex; align-items:center; justify-content:center;
    font-size:3rem; flex-shrink:0;
}

/* Body */
.news-body { padding:.9rem 1.1rem 1rem; display:flex; flex-direction:column; flex:1; }

.news-meta-top {
    display:flex; align-items:center; gap:.5rem; margin-bottom:.5rem; flex-wrap:wrap;
}
.cat-badge {
    font-size:.65rem; font-weight:800; padding:.2rem .6rem; border-radius:999px;
    text-transform:uppercase; letter-spacing:.04em;
}
.cat-achievement { background:#fef3c7; color:#d97706; }
.cat-academic    { background:#dbeafe; color:#1d4ed8; }
.cat-event       { background:#dcfce7; color:#15803d; }
.cat-announcement{ background:#ede9fe; color:#7c3aed; }
.cat-competition { background:#fce7f3; color:#be185d; }

/* â”€â”€ Competition Result Card thumbnail â”€â”€ */
.news-thumb-comp {
    width:100%; height:150px; flex-shrink:0;
    display:flex; flex-direction:column; justify-content:space-between;
    padding:.875rem .875rem .625rem;
    overflow:hidden; position:relative;
}

.comp-result-banner {
    display:flex; align-items:center; gap:.625rem;
}
.comp-trophy { font-size:1.5rem; line-height:1; }
.comp-banner-info { display:flex; flex-direction:column; gap:1px; }
.comp-banner-event { font-size:.78rem; font-weight:800; color:#fff; line-height:1.2; }
.comp-banner-label { font-size:.62rem; font-weight:500; color:rgba(255,255,255,.6); }

.comp-podium-row {
    display:flex; align-items:flex-end; justify-content:center;
    gap:.375rem; padding-top:.25rem;
}

.comp-podium-item {
    display:flex; flex-direction:column; align-items:center; gap:2px;
    padding:.375rem .5rem .5rem;
    border-radius:.5rem .5rem 0 0;
    flex:1; text-align:center;
}
.comp-podium-item.gold   { background:rgba(251,191,36,.25); border-top:2px solid #fbbf24; min-height:64px; justify-content:flex-end; }
.comp-podium-item.silver { background:rgba(255,255,255,.12); border-top:2px solid rgba(255,255,255,.35); min-height:52px; justify-content:flex-end; }
.comp-podium-item.bronze { background:rgba(251,146,60,.18); border-top:2px solid #fb923c; min-height:44px; justify-content:flex-end; }

.comp-podium-medal { font-size:1rem; line-height:1; }
.comp-podium-class { font-size:.62rem; font-weight:800; color:#fff; line-height:1.2; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:56px; }
.comp-podium-rank  { font-size:.55rem; font-weight:600; color:rgba(255,255,255,.65); white-space:nowrap; }

.imp-badge {
    font-size:.62rem; font-weight:800; padding:.18rem .55rem; border-radius:999px;
    background:#fee2e2; color:#dc2626; text-transform:uppercase; letter-spacing:.04em;
}

.news-title {
    font-size:.925rem; font-weight:800; color:var(--text-primary);
    line-height:1.35; margin-bottom:.45rem;
}
.news-excerpt {
    font-size:.8rem; color:var(--text-muted); line-height:1.6;
    flex:1; display:-webkit-box; -webkit-line-clamp:2;
    -webkit-box-orient:vertical; overflow:hidden;
}
.news-footer {
    display:flex; align-items:center; justify-content:space-between;
    margin-top:.75rem; padding-top:.65rem; border-top:1px solid var(--border-color);
    gap:.5rem; flex-wrap:wrap;
}
.news-footer-left { display:flex; align-items:center; gap:.875rem; }
.news-stat { font-size:.72rem; color:var(--text-muted); font-weight:600;
    display:flex; align-items:center; gap:.3rem; }
.news-time { font-size:.72rem; color:var(--text-muted); font-weight:500; }
.news-read-time { font-size:.68rem; color:var(--text-muted); background:var(--bg-tertiary);
    padding:.15rem .5rem; border-radius:.3rem; }

/* â•â• MODAL â•â• */
.modal-overlay {
    position:fixed; inset:0; background:rgba(0,0,0,.55);
    display:flex; align-items:center; justify-content:center;
    z-index:9999; opacity:0; visibility:hidden; transition:all .25s;
    padding:1rem;
}
.modal-overlay.active { opacity:1; visibility:visible; }

.news-modal {
    background:var(--bg-secondary); border-radius:1.25rem;
    width:100%; max-width:680px; max-height:88vh; overflow-y:auto;
    transform:scale(.96); transition:transform .25s;
    box-shadow:0 24px 64px rgba(0,0,0,.25);
}
.modal-overlay.active .news-modal { transform:scale(1); }

.nm-thumb { width:100%; height:220px; object-fit:cover; border-radius:1.25rem 1.25rem 0 0; }
.nm-thumb-placeholder {
    width:100%; height:220px; border-radius:1.25rem 1.25rem 0 0;
    display:flex; align-items:center; justify-content:center; font-size:4.5rem;
}

.nm-body { padding:1.5rem 1.75rem 1.75rem; }

.nm-meta { display:flex; align-items:center; gap:.5rem; margin-bottom:.875rem; flex-wrap:wrap; }

.nm-title { font-size:1.35rem; font-weight:800; color:var(--text-primary); line-height:1.3; margin-bottom:.5rem; }
.nm-byline { font-size:.78rem; color:var(--text-muted); margin-bottom:1.25rem; }

.nm-section { margin-bottom:1.1rem; }
.nm-section-title {
    font-size:.85rem; font-weight:800; color:var(--text-primary);
    text-transform:uppercase; letter-spacing:.05em; margin-bottom:.5rem;
    padding-bottom:.35rem; border-bottom:2px solid var(--border-color);
}
.nm-text { font-size:.875rem; color:var(--text-secondary); line-height:1.75; }
.nm-list { list-style:none; padding:0; margin:0; }
.nm-list li {
    font-size:.875rem; color:var(--text-secondary); padding:.3rem 0;
    display:flex; align-items:flex-start; gap:.6rem; line-height:1.5;
}
.nm-list li::before { content:'â€¢'; color:#0f1f4e; font-weight:900; flex-shrink:0; margin-top:.05rem; }

.nm-highlight {
    background:linear-gradient(135deg,#eff6ff,#dbeafe); border:1px solid #bfdbfe;
    border-radius:.75rem; padding:.875rem 1.1rem; margin:1rem 0;
}
.nm-highlight-text { font-size:.875rem; font-weight:600; color:#1e40af; }

.nm-actions {
    display:flex; align-items:center; gap:.75rem; margin-top:1.5rem;
    padding-top:1.1rem; border-top:1px solid var(--border-color); flex-wrap:wrap;
}
.nm-action-btn {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.45rem 1rem; border-radius:.625rem;
    border:1.5px solid var(--border-color); background:var(--bg-secondary);
    color:var(--text-secondary); font-size:.8rem; font-weight:700;
    cursor:pointer; transition:all .15s;
}
.nm-action-btn:hover { border-color:#0f1f4e; color:#0f1f4e; background:#f0f4ff; }
.nm-close-btn {
    margin-left:auto; padding:.45rem 1.1rem;
    border-radius:.625rem; border:none;
    background:#0f1f4e; color:#fff; font-size:.8rem; font-weight:700;
    cursor:pointer; transition:background .15s;
}
.nm-close-btn:hover { background:#1a3a7c; }
</style>
@endpush

@section('content')
<div class="news-page">

    {{-- ── Tab header ── --}}
    <div class="news-top">
        <h1 class="news-page-title">Notifikasi & Pengumuman</h1>
        <div style="display:flex;gap:.5rem;align-items:center;">
            @if($unreadCount > 0)
                <span class="news-count-badge">{{ $unreadCount }} belum dibaca</span>
            @endif
        </div>
    </div>

    {{-- ── Tab navigation ── --}}
    <div style="display:flex;gap:4px;background:var(--bg-tertiary);border-radius:.875rem;padding:4px;width:fit-content;margin-bottom:1.5rem;">
        <button id="tabNotif" onclick="switchTab('notif')"
                style="padding:.5rem 1.25rem;border-radius:.625rem;font-size:.825rem;font-weight:700;border:none;cursor:pointer;background:var(--bg-secondary);color:var(--text-primary);box-shadow:0 1px 4px rgba(0,0,0,.08);transition:all .2s;font-family:inherit;">
            🔔 Notifikasi Saya
            @if($unreadCount > 0)
                <span style="background:#ef4444;color:#fff;font-size:.65rem;font-weight:800;padding:.1rem .45rem;border-radius:999px;margin-left:.35rem;">{{ $unreadCount }}</span>
            @endif
        </button>
        <button id="tabAnnounce" onclick="switchTab('announce')"
                style="padding:.5rem 1.25rem;border-radius:.625rem;font-size:.825rem;font-weight:700;border:none;cursor:pointer;background:transparent;color:var(--text-muted);transition:all .2s;font-family:inherit;">
            📢 Pengumuman
        </button>
        <button id="tabEvents" onclick="switchTab('events')"
                style="padding:.5rem 1.25rem;border-radius:.625rem;font-size:.825rem;font-weight:700;border:none;cursor:pointer;background:transparent;color:var(--text-muted);transition:all .2s;font-family:inherit;">
            📅 Event Mendatang
        </button>
    </div>

    {{-- ══════════════════════════════════════
         TAB 1: NOTIFIKASI PERSONAL
    ══════════════════════════════════════ --}}
    <div id="panelNotif">

        @if($notifications->count() > 0)
        <div style="display:flex;justify-content:flex-end;gap:.5rem;margin-bottom:1rem;">
            <form method="POST" action="{{ route('user.notifications.read-all') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nf-chip" style="border:none;cursor:pointer;">✓ Tandai semua dibaca</button>
            </form>
            <form method="POST" action="{{ route('user.notifications.delete-all') }}" style="display:inline;"
                  onsubmit="return confirm('Hapus semua notifikasi?')">
                @csrf @method('DELETE')
                <button type="submit" class="nf-chip" style="border-color:#ef4444;color:#ef4444;border:none;cursor:pointer;">🗑 Hapus semua</button>
            </form>
        </div>
        @endif

        <div style="display:flex;flex-direction:column;gap:.625rem;" id="notifList">
            @forelse($notifications as $notif)
            @php
                $typeColors = ['success'=>'#10b981','warning'=>'#f59e0b','error'=>'#ef4444','info'=>'#3b82f6'];
                $typeIcons  = ['success'=>'✅','warning'=>'⚠️','error'=>'❌','info'=>'ℹ️'];
                $color = $typeColors[$notif->type] ?? '#3b82f6';
                $icon  = $typeIcons[$notif->type] ?? 'ℹ️';
            @endphp
            <div style="background:var(--bg-secondary);border:1.5px solid {{ $notif->isRead() ? 'var(--border-color)' : $color . '40' }};border-left:3px solid {{ $color }};border-radius:.875rem;padding:1rem 1.25rem;display:flex;align-items:flex-start;gap:.875rem;transition:all .2s;{{ $notif->isRead() ? 'opacity:.8;' : '' }}"
                 id="notif-{{ $notif->id }}">
                <div style="font-size:1.2rem;flex-shrink:0;margin-top:.1rem;">{{ $icon }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:700;color:var(--text-primary);font-size:.875rem;margin-bottom:.2rem;">
                        {{ $notif->title }}
                        @if(!$notif->isRead())
                            <span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#ef4444;margin-left:.4rem;vertical-align:middle;"></span>
                        @endif
                    </div>
                    <div style="font-size:.8rem;color:var(--text-secondary);line-height:1.5;margin-bottom:.4rem;">{{ $notif->message }}</div>
                    <div style="font-size:.72rem;color:var(--text-muted);">{{ $notif->created_at->diffForHumans() }}</div>
                </div>
                <div style="display:flex;gap:.4rem;flex-shrink:0;">
                    @if(!$notif->isRead())
                    <form method="POST" action="{{ route('user.notifications.read', $notif->id) }}">
                        @csrf
                        <button type="submit" title="Tandai dibaca"
                                style="width:28px;height:28px;border-radius:50%;border:1.5px solid var(--border-color);background:var(--bg-primary);cursor:pointer;font-size:.75rem;color:var(--text-muted);">
                            ✓
                        </button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('user.notifications.delete', $notif->id) }}"
                          onsubmit="return confirm('Hapus notifikasi ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" title="Hapus"
                                style="width:28px;height:28px;border-radius:50%;border:1.5px solid #fca5a5;background:#fff5f5;cursor:pointer;font-size:.75rem;color:#ef4444;">
                            ✕
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:3rem;color:var(--text-muted);">
                <div style="font-size:2.5rem;margin-bottom:.75rem;">🔔</div>
                <div style="font-weight:600;margin-bottom:.25rem;">Belum ada notifikasi</div>
                <div style="font-size:.82rem;">Notifikasi akan muncul saat Anda mendaftar atau ada update event.</div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ══════════════════════════════════════
         TAB 2: PENGUMUMAN DARI ADMIN
    ══════════════════════════════════════ --}}
    <div id="panelAnnounce" style="display:none;">
        @forelse($announcements as $ann)
        @php
            $priorityStyle = match($ann->priority ?? 'normal') {
                'urgent' => ['border-left:3px solid #ef4444;', '#ef4444', '🚨'],
                'high'   => ['border-left:3px solid #f59e0b;', '#f59e0b', '⚡'],
                default  => ['border-left:3px solid #3b82f6;', '#3b82f6', '📢'],
            };
            $targetMap = ['all_students'=>'Semua Siswa','participants'=>'Peserta Event','all_users'=>'Semua Pengguna','specific_class'=>'Kelas Tertentu'];
        @endphp
        <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);{{ $priorityStyle[0] }}border-radius:.875rem;padding:1.25rem;margin-bottom:.875rem;">
            <div style="display:flex;align-items:flex-start;gap:.75rem;margin-bottom:.75rem;">
                <div style="font-size:1.3rem;">{{ $priorityStyle[2] }}</div>
                <div style="flex:1;">
                    <div style="font-weight:800;font-size:.975rem;color:var(--text-primary);margin-bottom:.2rem;">
                        {{ $ann->title }}
                        @if($ann->is_pinned)
                            <span style="font-size:.7rem;margin-left:.35rem;">📌</span>
                        @endif
                    </div>
                    <div style="font-size:.72rem;color:var(--text-muted);">
                        {{ $targetMap[$ann->target] ?? 'Semua' }} ·
                        {{ $ann->publish_date->format('d F Y, H:i') }} ·
                        oleh {{ $ann->creator->name ?? 'Admin' }}
                    </div>
                </div>
            </div>
            <p style="font-size:.875rem;color:var(--text-secondary);line-height:1.7;">{{ $ann->content }}</p>
        </div>
        @empty
        <div style="text-align:center;padding:3rem;color:var(--text-muted);">
            <div style="font-size:2.5rem;margin-bottom:.75rem;">📢</div>
            <div style="font-weight:600;margin-bottom:.25rem;">Belum ada pengumuman</div>
            <div style="font-size:.82rem;">Pengumuman dari admin akan tampil di sini.</div>
        </div>
        @endforelse
    </div>

    {{-- ══════════════════════════════════════
         TAB 3: EVENT MENDATANG
    ══════════════════════════════════════ --}}
    <div id="panelEvents" style="display:none;">
        @forelse($upcomingEvents as $ev)
        @php
            $pct = $ev->quota > 0 ? min(100, round($ev->registered_count / $ev->quota * 100)) : 0;
        @endphp
        <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:.875rem;padding:1.25rem;margin-bottom:.875rem;display:flex;gap:1rem;align-items:flex-start;">
            <div style="width:48px;height:48px;border-radius:.75rem;background:{{ $ev->category->color ?? '#3b82f6' }}20;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">🎉</div>
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;margin-bottom:.35rem;">
                    <span style="font-weight:800;font-size:.925rem;color:var(--text-primary);">{{ $ev->name }}</span>
                    <span style="font-size:.65rem;font-weight:700;padding:.15rem .5rem;border-radius:999px;background:{{ $ev->category->color ?? '#3b82f6' }}20;color:{{ $ev->category->color ?? '#3b82f6' }};">{{ $ev->category->name }}</span>
                    @if($ev->has_certificate)
                        <span style="font-size:.65rem;font-weight:700;padding:.15rem .5rem;border-radius:999px;background:#dcfce7;color:#15803d;">🏆 Sertifikat</span>
                    @endif
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:.375rem .875rem;margin-bottom:.625rem;">
                    <span style="font-size:.78rem;color:var(--text-muted);">📅 {{ $ev->date->format('d F Y') }}</span>
                    <span style="font-size:.78rem;color:var(--text-muted);">🕐 {{ $ev->start_time->format('H:i') }} – {{ $ev->end_time->format('H:i') }}</span>
                    <span style="font-size:.78rem;color:var(--text-muted);">📍 {{ $ev->location }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:.875rem;">
                    <div style="flex:1;max-width:160px;">
                        <div style="height:5px;background:var(--bg-tertiary);border-radius:999px;overflow:hidden;">
                            <div style="height:100%;width:{{ $pct }}%;background:{{ $pct >= 90 ? '#ef4444' : ($ev->category->color ?? '#3b82f6') }};border-radius:999px;"></div>
                        </div>
                        <div style="font-size:.68rem;color:var(--text-muted);margin-top:2px;">{{ $ev->registered_count }}/{{ $ev->quota }} peserta</div>
                    </div>
                    <a href="{{ url('/user/events/' . $ev->id) }}"
                       style="padding:.45rem .875rem;border-radius:.625rem;border:1.5px solid var(--border-color);background:var(--bg-primary);color:var(--text-primary);font-size:.78rem;font-weight:700;text-decoration:none;white-space:nowrap;transition:all .15s;"
                       onmouseover="this.style.borderColor='#3b82f6';this.style.color='#3b82f6';"
                       onmouseout="this.style.borderColor='var(--border-color)';this.style.color='var(--text-primary)';">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:3rem;color:var(--text-muted);">
            <div style="font-size:2.5rem;margin-bottom:.75rem;">📅</div>
            <div style="font-weight:600;margin-bottom:.25rem;">Belum ada event mendatang</div>
            <div style="font-size:.82rem;">Event yang tersedia akan tampil di sini.</div>
        </div>
        @endforelse
    </div>

</div>
@endsection

@push('js')
<script>
var activeTab = 'notif';
function switchTab(tab) {
    activeTab = tab;
    ['notif','announce','events'].forEach(function(t) {
        var panel = document.getElementById('panel' + t.charAt(0).toUpperCase() + t.slice(1));
        var btn   = document.getElementById('tab'   + t.charAt(0).toUpperCase() + t.slice(1));
        if (!panel || !btn) return;
        if (t === tab) {
            panel.style.display = '';
            btn.style.background = 'var(--bg-secondary)';
            btn.style.color      = 'var(--text-primary)';
            btn.style.boxShadow  = '0 1px 4px rgba(0,0,0,.08)';
        } else {
            panel.style.display = 'none';
            btn.style.background = 'transparent';
            btn.style.color      = 'var(--text-muted)';
            btn.style.boxShadow  = 'none';
        }
    });
<<<<<<< HEAD
}
// Set initial tab style
switchTab('notif');
=======

    document.getElementById('newsModalInner').innerHTML = `
        ${thumbHtml}
        <div class="nm-body">
            <div class="nm-meta">
                <span class="cat-badge ${catClass}">${d.catLabel}</span>
                ${impBadge}
            </div>
            <h2 class="nm-title">${d.title}</h2>
            <div class="nm-byline">${d.byline}</div>
            ${sectionsHtml}
            <div class="nm-actions">
                <button class="nm-action-btn">ðŸ‘ Helpful</button>
                <button class="nm-action-btn">ðŸ”— Share</button>
                <button class="nm-action-btn">ðŸ”– Bookmark</button>
                <button class="nm-close-btn" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    `;
    normalizeNewsText(document.getElementById('newsModalInner'));

    document.getElementById('newsModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('newsModal').classList.remove('active');
    document.body.style.overflow = '';
}

function closeModalOutside(e) {
    if (e.target === document.getElementById('newsModal')) closeModal();
}

document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeModal();
});

function decodeMojibake(value) {
    if (!/[ðŸÂâ]/.test(value)) return value;
    try {
        var cp1252 = {
            '€': 0x80, '‚': 0x82, 'ƒ': 0x83, '„': 0x84, '…': 0x85,
            '†': 0x86, '‡': 0x87, '‰': 0x89, 'Š': 0x8a, '‹': 0x8b,
            'Œ': 0x8c, 'Ž': 0x8e, '‘': 0x91, '’': 0x92, '“': 0x93,
            '”': 0x94, '•': 0x95, '–': 0x96, '—': 0x97, '˜': 0x98,
            '™': 0x99, 'š': 0x9a, '›': 0x9b, 'œ': 0x9c, 'ž': 0x9e,
            'Ÿ': 0x9f,
        };
        var bytes = Array.from(value).map(function (character) {
            var code = cp1252[character] || character.charCodeAt(0);
            return '%' + code.toString(16).padStart(2, '0');
        }).join('');
        return decodeURIComponent(bytes);
    } catch (error) {
        return value;
    }
}

function normalizeNewsText(root) {
    var walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
    var node;
    while ((node = walker.nextNode())) {
        if (node.parentElement && !['SCRIPT', 'STYLE'].includes(node.parentElement.tagName)) {
            node.nodeValue = decodeMojibake(node.nodeValue);
        }
    }
}

normalizeNewsText(document.body);
>>>>>>> f2d372f4c62e8d25440e45f8b0b0c2c13b30efa6
</script>
@endpush
