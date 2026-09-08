<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesan - Eventty Admin</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}">

    {{-- Iconify --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/messages.css',
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

@include('admin.partials.sidebar', ['activePage' => 'messages'])

<div class="admin-main">
    @include('admin.partials.header')

    <div class="admin-content-messages">
        <div class="adm-msg-card">
            <div class="adm-msg-layout" id="admMsgLayout">

                {{-- ════ CONVERSATION LIST (LEFT) ════ --}}
                <aside class="adm-msg-left">
                    <div class="adm-msg-left-hd">
                        <div class="adm-msg-left-title">
                            <iconify-icon icon="lucide:messages-square" width="20" height="20" style="color:#2563eb;"></iconify-icon>
                            <span>Pesan Masuk</span>
                        </div>
                        <span id="admUnreadTotal" class="adm-unread-badge" style="display:none;">0</span>
                    </div>

                    <div class="adm-search-container">
                        <div class="adm-search-inner">
                            <iconify-icon icon="lucide:search" width="16" height="16" style="color:#94a3b8;flex-shrink:0;"></iconify-icon>
                            <input type="text" id="admSearchConv" placeholder="Cari nama atau NIS siswa...">
                        </div>
                    </div>

                    <div id="admConvList" class="adm-conv-list">
                        <div style="text-align:center;padding:2.5rem 1rem;color:#94a3b8;font-size:.825rem;display:flex;flex-direction:column;align-items:center;gap:.5rem;">
                            <iconify-icon icon="lucide:loader-2" width="24" height="24" style="animation:spin 1s linear infinite;color:#3b82f6;"></iconify-icon>
                            <span>Memuat percakapan...</span>
                        </div>
                    </div>
                </aside>

                {{-- ════ CHAT PANEL (RIGHT) ════ --}}
                <section class="adm-msg-right" id="admChatPanel">

                    {{-- Empty State --}}
                    <div id="admChatEmpty" class="adm-empty-wrapper">
                        <div class="adm-empty-icon-box">
                            <iconify-icon icon="solar:chat-round-line-bold" width="38" height="38"></iconify-icon>
                        </div>
                        <div class="adm-empty-title">Pilih Percakapan Siswa</div>
                        <div class="adm-empty-desc">Klik salah satu nama siswa di daftar sebelah kiri untuk melihat percakapan atau mengunduh & membalas pesan.</div>
                    </div>

                    {{-- Active Chat View --}}
                    <div id="admActiveChat" class="adm-active-chat-wrap" style="display:none;">

                        {{-- Chat Header --}}
                        <div class="adm-chat-header">
                            <button class="adm-close-chat-btn" onclick="clearActiveChat()" style="display:none;margin-right:.25rem;" id="admBackBtnMobile">
                                <iconify-icon icon="lucide:arrow-left" width="16" height="16"></iconify-icon>
                            </button>

                            <div class="adm-chat-header-av" id="admChatAv">S</div>

                            <div class="adm-chat-header-info">
                                <div class="adm-chat-header-name" id="admChatName">Siswa</div>
                                <div class="adm-chat-header-sub" id="admChatSub">NIS · Kelas</div>
                            </div>

                            <button class="adm-close-chat-btn" onclick="clearActiveChat()" title="Tutup Percakapan">
                                <iconify-icon icon="lucide:x" width="16" height="16"></iconify-icon>
                            </button>
                        </div>

                        {{-- Chat Feed --}}
                        <div id="admChatFeed" class="adm-chat-feed">
                            <div style="text-align:center;padding:3rem 1rem;color:#94a3b8;font-size:.825rem;">Memuat pesan...</div>
                        </div>

                        {{-- Input Section --}}
                        <div class="adm-input-section">
                            <div class="adm-input-container" id="admInputWrap">
                                <textarea id="admInput" rows="1" placeholder="Tulis balasan pesan untuk siswa..."></textarea>
                                <button id="admSendBtn" disabled class="adm-send-button" title="Kirim Pesan">
                                    <iconify-icon icon="lucide:send" width="17" height="17"></iconify-icon>
                                </button>
                            </div>
                            <div class="adm-input-hint-text">Tekan Enter untuk mengirim · Shift + Enter untuk baris baru</div>
                        </div>

                    </div>
                </section>

            </div>
        </div>
    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<style>
@keyframes spin { 100% { transform: rotate(360deg); } }
</style>

<script>
var CSRF = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
var activeStudentId = null;
var pollTimer = null;
var lastMsgId = 0;

// ── Load conversation list ──
function loadConversations(search) {
    fetch('/api/admin/messages/conversations', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(function(r) { return r.json(); })
    .then(function(convs) {
        renderConvList(convs, search || '');
        updateUnreadTotal(convs);
    })
    .catch(function(e) { console.error('Error fetching conversations:', e); });
}

function renderConvList(convs, search) {
    var list = document.getElementById('admConvList');
    if (!list) return;
    var filtered = search ? convs.filter(function(c) {
        return c.name.toLowerCase().includes(search.toLowerCase())
            || (c.nis || '').includes(search);
    }) : convs;

    if (!filtered.length) {
        list.innerHTML = '<div style="text-align:center;padding:3rem 1rem;color:#94a3b8;font-size:.825rem;display:flex;flex-direction:column;align-items:center;gap:.5rem;">'
            + '<iconify-icon icon="lucide:message-square-off" width="32" height="32" style="color:#cbd5e1;"></iconify-icon>'
            + '<span>' + (convs.length ? 'Tidak ditemukan hasil pencarian.' : 'Belum ada percakapan dari siswa.') + '</span></div>';
        return;
    }

    list.innerHTML = filtered.map(function(c) {
        var isActive = c.id === activeStudentId;
        var initial = c.name.charAt(0).toUpperCase();
        return '<div class="adm-conv-item' + (isActive ? ' active' : '') + '" data-id="' + c.id + '" data-name="' + escHtml(c.name) + '" data-nis="' + escHtml(c.nis) + '" data-class="' + escHtml(c.class) + '" onclick="openConv(this)">'
            + '<div class="adm-avatar-wrapper">'
            + '<div class="adm-avatar">' + initial + '</div>'
            + (c.unread > 0 ? '<span class="adm-unread-dot">' + (c.unread > 9 ? '9+' : c.unread) + '</span>' : '')
            + '</div>'
            + '<div class="adm-conv-details">'
            + '<div class="adm-conv-top-row">'
            + '<span class="adm-conv-name">' + escHtml(c.name) + '</span>'
            + '<span class="adm-conv-time">' + escHtml(c.last_time || '') + '</span>'
            + '</div>'
            + '<div class="adm-conv-preview">' + escHtml(c.last_message || 'Belum ada pesan') + '</div>'
            + '</div></div>';
    }).join('');
}

function updateUnreadTotal(convs) {
    var total = convs.reduce(function(s, c) { return s + (c.unread || 0); }, 0);
    var badge = document.getElementById('admUnreadTotal');
    if (badge) {
        badge.textContent = total > 99 ? '99+' : total;
        badge.style.display = total > 0 ? 'inline-block' : 'none';
    }
}

// ── Open conversation ──
function openConv(el) {
    var id    = parseInt(el.dataset.id);
    var name  = el.dataset.name;
    var nis   = el.dataset.nis;
    var cls   = el.dataset.class;
    activeStudentId = id;

    // Update header info
    document.getElementById('admChatAv').textContent   = name.charAt(0).toUpperCase();
    document.getElementById('admChatName').textContent  = name;
    document.getElementById('admChatSub').textContent   = 'NIS ' + (nis || '-') + ' · ' + (cls || 'Siswa');

    // Show active chat panel
    document.getElementById('admChatEmpty').style.display = 'none';
    var activeChat = document.getElementById('admActiveChat');
    activeChat.style.display = 'flex';

    // Highlight selected conversation
    document.querySelectorAll('.adm-conv-item').forEach(function(item) {
        if (parseInt(item.dataset.id) === id) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });

    // Load message feed
    loadChatMessages(true);

    // Setup message polling (every 4 seconds)
    clearInterval(pollTimer);
    pollTimer = setInterval(function() { loadChatMessages(false); }, 4000);

    // Mobile layout toggle
    var layout = document.getElementById('admMsgLayout');
    if (layout) layout.classList.add('chat-open');
}

function clearActiveChat() {
    activeStudentId = null;
    clearInterval(pollTimer);
    document.getElementById('admChatEmpty').style.display = 'flex';
    document.getElementById('admActiveChat').style.display = 'none';
    var layout = document.getElementById('admMsgLayout');
    if (layout) layout.classList.remove('chat-open');
}

// ── Load chat messages ──
function loadChatMessages(scrollDown) {
    if (!activeStudentId) return;

    fetch('/api/admin/messages/' + activeStudentId, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(function(r) { return r.json(); })
    .then(function(msgs) {
        var latestId = msgs.length ? msgs[msgs.length - 1].id : 0;
        if (!scrollDown && latestId === lastMsgId) return;
        lastMsgId = latestId;
        renderChatFeed(msgs, scrollDown);
        loadConversations();
    })
    .catch(function(e) { console.error('Error fetching chat messages:', e); });
}

function renderChatFeed(msgs, scrollDown) {
    var feed = document.getElementById('admChatFeed');
    if (!feed) return;

    if (!msgs.length) {
        feed.innerHTML = '<div style="text-align:center;padding:4rem 1rem;color:#94a3b8;font-size:.85rem;display:flex;flex-direction:column;align-items:center;gap:.6rem;">'
            + '<iconify-icon icon="lucide:message-circle" width="36" height="36" style="color:#cbd5e1;"></iconify-icon>'
            + '<span>Belum ada riwayat pesan dengan siswa ini.</span></div>';
        return;
    }

    var groups = groupByDate(msgs);
    var html = '';
    groups.forEach(function(g) {
        html += '<div class="adm-date-separator"><span>' + escHtml(g.date) + '</span></div>';
        g.msgs.forEach(function(m) { html += buildAdminBubble(m); });
    });
    feed.innerHTML = html;
    if (scrollDown) {
        setTimeout(function() { feed.scrollTop = feed.scrollHeight; }, 50);
    }
}

function buildAdminBubble(msg) {
    var isMine = msg.is_mine;
    var nameChar = (document.getElementById('admChatName').textContent.charAt(0).toUpperCase() || 'S');

    return '<div style="display:flex;align-items:flex-end;gap:.55rem;margin-bottom:.35rem;justify-content:' + (isMine ? 'flex-end' : 'flex-start') + ';">'
        + (!isMine ? '<div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#1e40af,#3b82f6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;font-weight:800;flex-shrink:0;box-shadow:0 2px 6px rgba(30,64,175,0.15);">'
            + nameChar + '</div>' : '')
        + '<div style="max-width:68%;">'
        + '<div style="padding:.75rem .95rem;border-radius:1.1rem;line-height:1.55;font-size:.875rem;word-break:break-word;white-space:pre-wrap;'
        + (isMine ? 'background:linear-gradient(135deg,#0b192c,#1d4ed8);color:#ffffff;border-bottom-right-radius:.2rem;box-shadow:0 4px 12px rgba(29,78,216,0.18);'
                  : 'background:#ffffff;color:#0f172a;border-bottom-left-radius:.2rem;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.03);')
        + '">' + escHtml(msg.body) + '</div>'
        + '<div style="font-size:.625rem;color:#94a3b8;margin-top:.2rem;display:flex;align-items:center;gap:.3rem;justify-content:' + (isMine ? 'flex-end' : 'flex-start') + ';">'
        + msg.time
        + (isMine ? ' <iconify-icon icon="lucide:check-check" width="13" height="13" style="color:' + (msg.read_at ? '#22c55e' : '#94a3b8') + ';vertical-align:middle;"></iconify-icon>' : '')
        + '</div></div>'
        + (isMine ? '<div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#0b192c,#1d4ed8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;font-weight:800;flex-shrink:0;box-shadow:0 2px 6px rgba(15,23,42,0.2);">A</div>' : '')
        + '</div>';
}

function groupByDate(msgs) {
    var groups = [], currentDate = null, currentGroup = null;
    msgs.forEach(function(m) {
        if (m.date !== currentDate) {
            if (currentGroup) groups.push(currentGroup);
            currentDate = m.date;
            currentGroup = { date: m.date, msgs: [] };
        }
        currentGroup.msgs.push(m);
    });
    if (currentGroup) groups.push(currentGroup);
    return groups;
}

// ── Send Message ──
var admInput = document.getElementById('admInput');
var admSendBtn = document.getElementById('admSendBtn');

if (admInput && admSendBtn) {
    admInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 110) + 'px';
        admSendBtn.disabled = this.value.trim() === '' || !activeStudentId;
    });

    admInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (!admSendBtn.disabled) admSendBtn.click();
        }
    });

    admSendBtn.addEventListener('click', function() {
        var text = admInput.value.trim();
        if (!text || !activeStudentId) return;

        admSendBtn.disabled = true;

        fetch('/api/admin/messages/' + activeStudentId, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: JSON.stringify({ body: text })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                admInput.value = '';
                admInput.style.height = 'auto';
                loadChatMessages(true);
            }
        })
        .catch(function(e) { console.error('Error sending message:', e); })
        .finally(function() {
            admSendBtn.disabled = admInput.value.trim() === '' || !activeStudentId;
        });
    });
}

// ── Search Filter ──
var searchInput = document.getElementById('admSearchConv');
if (searchInput) {
    var searchDebounce;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchDebounce);
        var q = this.value.trim();
        searchDebounce = setTimeout(function() { loadConversations(q); }, 250);
    });
}

function escHtml(str) {
    return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/\n/g,'<br>');
}

// ── Init ──
loadConversations();
setInterval(function() { loadConversations(); }, 10000);
</script>
</body>
</html>
