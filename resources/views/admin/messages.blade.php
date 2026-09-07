<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Eventty Admin</title>
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

@include('admin.partials.sidebar', ['activePage' => 'messages'])

<div class="admin-main">
    @include('admin.partials.header')

    <div class="adm-msg-page">
        <div class="adm-msg-layout" id="admMsgLayout">

            {{-- ════ CONVERSATION LIST ════ --}}
            <aside class="adm-msg-left">
                <div class="adm-msg-left-hd">
                    <span style="font-size:1rem;font-weight:800;color:#0f172a;">Messages</span>
                    <span id="admUnreadTotal" style="display:none;background:#ef4444;color:#fff;font-size:.65rem;font-weight:700;padding:.15rem .5rem;border-radius:999px;"></span>
                </div>
                <div style="padding:.5rem;">
                    <div style="display:flex;align-items:center;gap:.5rem;background:#f8fafc;border:1.5px solid #e8edf5;border-radius:.625rem;padding:.45rem .75rem;">
                        <iconify-icon icon="lucide:search" width="14" height="14" style="color:#94a3b8;flex-shrink:0;"></iconify-icon>
                        <input type="text" id="admSearchConv" placeholder="Cari siswa..."
                               style="flex:1;border:none;background:transparent;font-size:.82rem;outline:none;color:#0f172a;">
                    </div>
                </div>
                <div id="admConvList" style="flex:1;overflow-y:auto;padding:.25rem .5rem;">
                    <div style="text-align:center;padding:2rem;color:#94a3b8;font-size:.82rem;">Memuat percakapan...</div>
                </div>
            </aside>

            {{-- ════ CHAT PANEL ════ --}}
            <section class="adm-msg-right" id="admChatPanel">

                {{-- Empty state --}}
                <div id="admChatEmpty" style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;color:#94a3b8;gap:.75rem;text-align:center;padding:2rem;">
                    <iconify-icon icon="lucide:message-circle-more" width="56" height="56" style="opacity:.2;"></iconify-icon>
                    <div style="font-size:1rem;font-weight:700;color:#64748b;">Pilih percakapan</div>
                    <div style="font-size:.82rem;">Klik nama siswa di kiri untuk membuka percakapan.</div>
                </div>

                {{-- Active chat --}}
                <div id="admActiveChat" style="display:none;flex-direction:column;height:100%;">

                    {{-- Chat header --}}
                    <div class="adm-chat-hd">
                        <div class="adm-chat-av" id="admChatAv"
                             style="background:linear-gradient(135deg,#1e40af,#3b82f6);">S</div>
                        <div style="flex:1;">
                            <div style="font-size:.9rem;font-weight:800;color:#0f172a;" id="admChatName">Siswa</div>
                            <div style="font-size:.7rem;color:#94a3b8;" id="admChatSub">NIS · Kelas</div>
                        </div>
                        <button onclick="clearActiveChat()"
                                style="width:32px;height:32px;border-radius:50%;border:1.5px solid #e8edf5;background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748b;">
                            <iconify-icon icon="lucide:x" width="14" height="14"></iconify-icon>
                        </button>
                    </div>

                    {{-- Feed --}}
                    <div id="admChatFeed" style="flex:1;overflow-y:auto;padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:.25rem;">
                        <div style="text-align:center;color:#94a3b8;font-size:.82rem;">Memuat pesan...</div>
                    </div>

                    {{-- Input area --}}
                    <div style="background:#fff;border-top:1.5px solid #e8edf5;padding:.875rem 1.25rem;">
                        <div style="display:flex;align-items:flex-end;gap:.625rem;background:#f8fafc;border:1.5px solid #e8edf5;border-radius:1rem;padding:.5rem .5rem .5rem .875rem;transition:border-color .2s;"
                             id="admInputWrap">
                            <textarea id="admInput" rows="1"
                                      placeholder="Balas pesan siswa..."
                                      style="flex:1;border:none;background:transparent;resize:none;font-size:.875rem;color:#0f172a;line-height:1.5;outline:none;max-height:110px;min-height:24px;font-family:inherit;"></textarea>
                            <button id="admSendBtn" disabled
                                    style="width:38px;height:38px;border-radius:50%;border:none;background:linear-gradient(135deg,#0f172a,#1d4ed8);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;opacity:.5;transition:opacity .2s;flex-shrink:0;">
                                <iconify-icon icon="lucide:send" width="16" height="16"></iconify-icon>
                            </button>
                        </div>
                        <p style="font-size:.64rem;color:#94a3b8;text-align:center;margin-top:.4rem;">Enter kirim · Shift+Enter baris baru</p>
                    </div>

                </div>
            </section>

        </div>
    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

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
    .catch(function(e) { console.error('conv error', e); });
}

function renderConvList(convs, search) {
    var list = document.getElementById('admConvList');
    if (!list) return;
    var filtered = search ? convs.filter(function(c) {
        return c.name.toLowerCase().includes(search.toLowerCase())
            || (c.nis || '').includes(search);
    }) : convs;

    if (!filtered.length) {
        list.innerHTML = '<div style="text-align:center;padding:2rem;color:#94a3b8;font-size:.82rem;">'
            + (convs.length ? 'Tidak ditemukan.' : 'Belum ada percakapan.') + '</div>';
        return;
    }

    list.innerHTML = filtered.map(function(c) {
        var isActive = c.id === activeStudentId;
        return '<div class="adm-conv-item' + (isActive ? ' active' : '') + '" data-id="' + c.id + '" data-name="' + escHtml(c.name) + '" data-nis="' + escHtml(c.nis) + '" data-class="' + escHtml(c.class) + '" onclick="openConv(this)"'
            + ' style="display:flex;align-items:center;gap:.75rem;padding:.75rem;border-radius:.75rem;cursor:pointer;transition:background .15s;' + (isActive ? 'background:#eff6ff;' : '') + '">'
            + '<div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#1e40af,#3b82f6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem;font-weight:800;flex-shrink:0;position:relative;">'
            + c.name.charAt(0).toUpperCase()
            + (c.unread > 0 ? '<span style="position:absolute;top:-2px;right:-2px;width:16px;height:16px;border-radius:50%;background:#ef4444;border:2px solid #fff;font-size:.55rem;font-weight:700;color:#fff;display:flex;align-items:center;justify-content:center;">' + c.unread + '</span>' : '')
            + '</div>'
            + '<div style="flex:1;min-width:0;">'
            + '<div style="display:flex;justify-content:space-between;margin-bottom:2px;">'
            + '<span style="font-size:.82rem;font-weight:700;color:#0f172a;">' + escHtml(c.name) + '</span>'
            + '<span style="font-size:.66rem;color:#94a3b8;">' + escHtml(c.last_time) + '</span>'
            + '</div>'
            + '<div style="font-size:.75rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + escHtml(c.last_message) + '</div>'
            + '</div></div>';
    }).join('');
}

function updateUnreadTotal(convs) {
    var total = convs.reduce(function(s, c) { return s + (c.unread || 0); }, 0);
    var badge = document.getElementById('admUnreadTotal');
    if (badge) {
        badge.textContent = total > 9 ? '9+' : total;
        badge.style.display = total > 0 ? '' : 'none';
    }
}

// ── Open conversation ──
function openConv(el) {
    var id    = parseInt(el.dataset.id);
    var name  = el.dataset.name;
    var nis   = el.dataset.nis;
    var cls   = el.dataset.class;
    activeStudentId = id;

    // Update header
    document.getElementById('admChatAv').textContent   = name.charAt(0).toUpperCase();
    document.getElementById('admChatName').textContent  = name;
    document.getElementById('admChatSub').textContent   = 'NIS ' + nis + ' · ' + cls;

    // Show chat panel
    document.getElementById('admChatEmpty').style.display  = 'none';
    var activeChat = document.getElementById('admActiveChat');
    activeChat.style.display = 'flex';

    // Mark active in list
    document.querySelectorAll('.adm-conv-item').forEach(function(item) {
        item.style.background = item.dataset.id == id ? '#eff6ff' : '';
    });

    // Load messages
    loadChatMessages(true);

    // Start polling
    clearInterval(pollTimer);
    pollTimer = setInterval(function() { loadChatMessages(false); }, 4000);

    // Mobile: show chat
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

// ── Load messages for active conversation ──
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
        loadConversations(); // refresh unread counts
    });
}

function renderChatFeed(msgs, scrollDown) {
    var feed = document.getElementById('admChatFeed');
    if (!feed) return;

    if (!msgs.length) {
        feed.innerHTML = '<div style="text-align:center;padding:3rem;color:#94a3b8;font-size:.82rem;">Belum ada pesan dari siswa ini.</div>';
        return;
    }

    var groups = groupByDate(msgs);
    var html = '';
    groups.forEach(function(g) {
        html += '<div style="text-align:center;font-size:.68rem;color:#94a3b8;margin:.75rem 0;font-weight:700;">'
            + '<span style="background:#f1f5f9;padding:.2rem .75rem;border-radius:999px;">' + escHtml(g.date) + '</span></div>';
        g.msgs.forEach(function(m) { html += buildAdminBubble(m); });
    });
    feed.innerHTML = html;
    if (scrollDown) feed.scrollTop = feed.scrollHeight;
}

function buildAdminBubble(msg) {
    var isMine = msg.is_mine;
    return '<div style="display:flex;align-items:flex-end;gap:.5rem;margin-bottom:.25rem;justify-content:' + (isMine ? 'flex-end' : 'flex-start') + ';">'
        + (!isMine ? '<div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#1e40af,#3b82f6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;font-weight:800;flex-shrink:0;">'
            + (document.getElementById('admChatName').textContent.charAt(0).toUpperCase() || 'S') + '</div>' : '')
        + '<div style="max-width:68%;">'
        + '<div style="padding:.75rem .9rem;border-radius:1rem;line-height:1.55;font-size:.875rem;word-break:break-word;white-space:pre-wrap;'
        + (isMine ? 'background:linear-gradient(135deg,#0f172a,#1d4ed8);color:#fff;border-bottom-right-radius:.25rem;'
                  : 'background:#f1f5f9;color:#0f172a;border-bottom-left-radius:.25rem;border:1px solid #e8edf5;')
        + '">' + escHtml(msg.body) + '</div>'
        + '<div style="font-size:.62rem;color:#94a3b8;margin-top:.15rem;text-align:' + (isMine ? 'right' : 'left') + ';">'
        + msg.time
        + (isMine ? ' <iconify-icon icon="lucide:check-check" width="12" height="12" style="color:' + (msg.read_at ? '#22c55e' : '#94a3b8') + ';vertical-align:middle;"></iconify-icon>' : '')
        + '</div></div>'
        + (isMine ? '<div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#f59e0b,#ea580c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;font-weight:800;flex-shrink:0;">A</div>' : '')
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

// ── Send (admin) ──
var admInput = document.getElementById('admInput');
var admSendBtn = document.getElementById('admSendBtn');

if (admInput && admSendBtn) {
    admInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 110) + 'px';
        admSendBtn.disabled = this.value.trim() === '' || !activeStudentId;
        admSendBtn.style.opacity = admSendBtn.disabled ? '.5' : '1';
    });

    admInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); admSendBtn.click(); }
    });

    admSendBtn.addEventListener('click', function() {
        var text = admInput.value.trim();
        if (!text || !activeStudentId) return;

        admSendBtn.disabled = true;
        admSendBtn.style.opacity = '.5';

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
        .finally(function() {
            admSendBtn.disabled = admInput.value.trim() === '' || !activeStudentId;
            admSendBtn.style.opacity = admSendBtn.disabled ? '.5' : '1';
        });
    });
}

// ── Search conversations ──
var searchInput = document.getElementById('admSearchConv');
if (searchInput) {
    var searchDebounce;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchDebounce);
        var q = this.value.trim();
        searchDebounce = setTimeout(function() { loadConversations(q); }, 300);
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
