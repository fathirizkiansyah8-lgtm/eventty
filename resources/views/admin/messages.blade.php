<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages — Admin Eventty</title>
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

    <div class="adm-msg-page">
        <div class="adm-msg-layout" id="admMsgLayout">

            {{-- ════ CONVERSATION LIST ════ --}}
            <aside class="adm-msg-left">
                <div class="adm-msg-left-hd">
                    <h1 class="adm-msg-title">Messages</h1>
                    <span class="adm-msg-count" id="totalUnreadLabel">3 belum dibaca</span>
                </div>

                <div class="adm-msg-search">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Cari percakapan..." id="admMsgSearch" oninput="filterConvs(this.value)">
                </div>

                <div class="adm-conv-list" id="admConvList">
                    {{-- Rendered by JS --}}
                </div>
            </aside>

            {{-- ════ CHAT AREA ════ --}}
            <section class="adm-chat-area">

                <div class="adm-chat-hd" id="admChatHd">
                    <button class="adm-back-btn" onclick="closeAdmChat()" aria-label="Kembali">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <div class="adm-chat-av" id="admChatAv" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">F</div>
                    <div class="adm-chat-hd-info">
                        <span class="adm-chat-hd-name" id="admChatName">Fathi Rizkiansyah</span>
                        <span class="adm-chat-hd-sub"  id="admChatSub">XI RPL 1 · NIS 12345</span>
                    </div>
                    <div class="adm-chat-hd-actions">
                        <button class="adm-hd-btn" title="Profil siswa">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </button>
                    </div>
                </div>

                <div class="adm-chat-feed" id="admChatFeed">
                    {{-- Rendered by JS --}}
                </div>

                <div class="adm-quick-replies" id="quickReplies">
                    <button class="adm-qr-btn" onclick="insertReply('Format PNG, JPG, PDF. Maks 10MB ya.')">Format file</button>
                    <button class="adm-qr-btn" onclick="insertReply('Terima kasih sudah menghubungi kami! 😊')">Terima kasih</button>
                    <button class="adm-qr-btn" onclick="insertReply('Deadline pengumpulan 30 September 2026 pukul 23:59 WIB.')">Info deadline</button>
                    <button class="adm-qr-btn" onclick="insertReply('Boleh, tidak ada masalah dengan itu.')">Boleh</button>
                </div>

                <div class="adm-input-area">
                    <div class="adm-input-wrap">
                        <textarea class="adm-input" id="admInput" placeholder="Tulis balasan..." rows="1" aria-label="Tulis balasan"></textarea>
                        <button class="adm-send-btn" id="admSendBtn" aria-label="Kirim">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                            </svg>
                        </button>
                    </div>
                    <p class="adm-input-hint">Enter kirim · Shift+Enter baris baru</p>
                </div>

            </section>

        </div>
    </div>
</div>

@include('admin.partials.logout-modal')
@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])

<script>
/* =========================================================
   ADMIN MESSAGES — Full frontend state management
   Menggunakan localStorage sebagai "jembatan" dengan user
   ========================================================= */

/* ── Base conversation data (dummy static) ── */
var BASE_CONVS = [
    {
        key: 'fathi', name: 'Fathi Rizkiansyah', initial: 'F',
        sub: 'XI RPL 1 · NIS 12345',
        color: 'linear-gradient(135deg,#3b82f6,#2563eb)',
        messages: [
            { dir:'stu', text:'Halo Admin, saya mau bertanya tentang hal di luar informasi event.', time:'10:23' },
            { dir:'adm', text:'Halo Fathi! Boleh pakai Canva, asalkan desainnya original dan belum pernah dipublikasikan. 👍', time:'10:25', read:true },
            { dir:'stu', text:'Mohon dibantu ya, kalau pertanyaannya di luar topik apakah bisa tetap ditanyakan?', time:'10:26' },
            { dir:'adm', text:'Tentu, kami siap membantu pertanyaan apapun yang berkaitan dengan event sekolah.', time:'10:28', read:true },
        ],
        unread: 1,
        lastMsg: 'Saya mau bertanya tentang hal di luar topik...',
        lastTime: '2 mnt'
    },
    {
        key: 'siti', name: 'Siti Nurhaliza', initial: 'S',
        sub: 'XI AK 1 · NIS 12346',
        color: 'linear-gradient(135deg,#7c3aed,#5b21b6)',
        messages: [
            { dir:'stu', text:'Halo Admin, untuk seminar besok apakah ada dress code khusus?', time:'09:15' },
            { dir:'adm', text:'Halo Siti! Untuk seminar cukup pakai seragam sekolah lengkap ya.', time:'09:17', read:true },
            { dir:'stu', text:'Untuk seminar besok apakah...', time:'10 mnt' },
        ],
        unread: 1,
        lastMsg: 'Untuk seminar besok apakah...',
        lastTime: '10 mnt'
    },
    {
        key: 'budi', name: 'Budi Santoso', initial: 'B',
        sub: 'XII RPL 1 · NIS 11234',
        color: 'linear-gradient(135deg,#059669,#047857)',
        messages: [
            { dir:'stu', text:'Kak admin, saya sudah daftar Career Day. Kapan konfirmasinya?', time:'08:30' },
            { dir:'adm', text:'Halo Budi! Konfirmasi akan dikirim ke WhatsApp kamu dalam 1x24 jam.', time:'08:35', read:true },
            { dir:'stu', text:'Terima kasih Admin 🙏', time:'08:36' },
        ],
        unread: 0,
        lastMsg: 'Terima kasih Admin 🙏',
        lastTime: '1 jam'
    },
    {
        key: 'rizky', name: 'Rizky Pratama', initial: 'R',
        sub: 'X BD 1 · NIS 10345',
        color: 'linear-gradient(135deg,#d97706,#b45309)',
        messages: [
            { dir:'stu', text:'Sudah daftar Career Day kak', time:'07:10' },
        ],
        unread: 0,
        lastMsg: 'Sudah daftar Career Day kak',
        lastTime: '3 jam'
    },
    {
        key: 'dewi', name: 'Dewi Anggraini', initial: 'D',
        sub: 'XI MP 1 · NIS 12567',
        color: 'linear-gradient(135deg,#db2777,#be185d)',
        messages: [
            { dir:'stu', text:'Sertifikat saya belum muncul di Certificates kak...', time:'05:01' },
        ],
        unread: 1,
        lastMsg: 'Sertifikat saya belum muncul...',
        lastTime: '5 jam'
    },
];

/* ── State ── */
var convs = JSON.parse(JSON.stringify(BASE_CONVS)); // deep copy
var activeKey = 'fathi';

/* ── Load pending messages from localStorage (sent by user) ── */
function loadPendingMessages() {
    var pending = JSON.parse(localStorage.getItem('eventty_pending_msgs') || '[]');
    if (!pending.length) return;

    pending.forEach(function(msg) {
        // Find existing conv or create
        var conv = convs.find(function(c){ return c.key === msg.senderKey; });
        if (!conv) {
            conv = {
                key: msg.senderKey,
                name: msg.sender,
                initial: msg.initial || msg.sender.charAt(0),
                sub: 'Pesan baru',
                color: msg.color || 'linear-gradient(135deg,#3b82f6,#2563eb)',
                messages: [],
                unread: 0,
                lastMsg: '',
                lastTime: 'baru'
            };
            convs.push(conv);
        }
        // Add message if not already there (check by timestamp)
        var exists = conv.messages.some(function(m){ return m._id === msg.id; });
        if (!exists) {
            conv.messages.push({
                dir: 'stu',
                text: msg.text,
                time: msg.time,
                _id: msg.id
            });
            // Only mark unread if not currently active
            if (conv.key !== activeKey) {
                conv.unread++;
            }
            conv.lastMsg = msg.text;
            conv.lastTime = msg.time || 'baru';
        }
    });

    // Sort: conversations with pending messages go to top
    convs.sort(function(a, b) {
        var aHasPending = pending.some(function(m){ return m.senderKey === a.key; });
        var bHasPending = pending.some(function(m){ return m.senderKey === b.key; });
        if (aHasPending && !bHasPending) return -1;
        if (!aHasPending && bHasPending) return 1;
        return 0;
    });
}

/* ── Get total unread count ── */
function getTotalUnread() {
    return convs.reduce(function(sum, c){ return sum + (c.unread || 0); }, 0);
}

/* ── Update total unread label + sidebar badge ── */
function updateUnreadLabel() {
    var total = getTotalUnread();
    var label = document.getElementById('totalUnreadLabel');
    if (label) label.textContent = total > 0 ? total + ' belum dibaca' : 'Semua dibaca';

    // Update sidebar Messages badge
    var sidebarBadge = document.querySelector('.sidebar-link.active .sidebar-badge');
    if (!sidebarBadge) {
        var msgLink = document.querySelector('a[href*="/admin/messages"]');
        if (msgLink) {
            var badge = msgLink.querySelector('.sidebar-badge');
            if (badge) badge.textContent = total > 0 ? total : '';
            if (badge) badge.style.display = total > 0 ? '' : 'none';
        }
    }
}

/* ── Render conversation list ── */
function renderConvList() {
    var list = document.getElementById('admConvList');
    list.innerHTML = '';

    convs.forEach(function(conv) {
        var item = document.createElement('div');
        item.className = 'adm-conv-item' + (conv.key === activeKey ? ' active' : '') + (conv.unread > 0 ? ' unread' : '');
        item.setAttribute('data-name', conv.name.toLowerCase());
        item.setAttribute('data-key', conv.key);

        item.innerHTML =
            '<div class="adm-conv-av" style="background:' + conv.color + '">' + conv.initial + '</div>' +
            '<div class="adm-conv-info">' +
                '<div class="adm-conv-row1">' +
                    '<span class="adm-conv-name">' + conv.name + '</span>' +
                    '<span class="adm-conv-time">' + conv.lastTime + '</span>' +
                '</div>' +
                '<div class="adm-conv-row2">' +
                    '<span class="adm-conv-preview">' + escapeHtml(conv.lastMsg.substring(0, 40)) + (conv.lastMsg.length > 40 ? '...' : '') + '</span>' +
                    (conv.unread > 0 ? '<span class="adm-unread" id="badge-' + conv.key + '">' + conv.unread + '</span>' : '<span class="adm-unread" id="badge-' + conv.key + '" style="display:none">0</span>') +
                '</div>' +
            '</div>';

        item.addEventListener('click', function(){
            selectConv(conv.key, item);
        });

        list.appendChild(item);
    });

    updateUnreadLabel();
}

/* ── Build a bubble element ── */
function buildBubble(msg, conv) {
    var row = document.createElement('div');
    row.className = 'adm-row ' + msg.dir;

    if (msg.dir === 'stu') {
        var av = document.createElement('div');
        av.className = 'adm-row-av';
        av.style.background = conv.color;
        av.textContent = conv.initial;
        row.appendChild(av);
    }

    var col = document.createElement('div');
    col.className = 'adm-row-col' + (msg.dir === 'adm' ? ' adm' : '');

    var bbl = document.createElement('div');
    bbl.className = 'adm-bubble ' + msg.dir;
    bbl.textContent = msg.text;
    col.appendChild(bbl);

    if (msg.dir === 'adm') {
        var meta = document.createElement('div');
        meta.className = 'adm-bbl-meta';
        meta.innerHTML = '<span class="adm-bbl-time">' + msg.time + '</span>' +
            '<span class="adm-tick' + (msg.read ? ' read' : '') + '"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span>';
        col.appendChild(meta);
    } else {
        var tm = document.createElement('span');
        tm.className = 'adm-bbl-time';
        tm.textContent = msg.time;
        col.appendChild(tm);
    }

    row.appendChild(col);
    return row;
}

/* ── Select conversation ── */
function selectConv(key, el) {
    activeKey = key;
    var conv = convs.find(function(c){ return c.key === key; });
    if (!conv) return;

    // Mark all messages as read for this conv
    conv.unread = 0;

    // Update badge in list
    var badge = document.getElementById('badge-' + key);
    if (badge) { badge.textContent = '0'; badge.style.display = 'none'; }

    // Remove unread class from item
    document.querySelectorAll('.adm-conv-item').forEach(function(i){ i.classList.remove('active'); });
    if (el) el.classList.remove('unread');
    if (el) el.classList.add('active');

    // Update header
    document.getElementById('admChatName').textContent = conv.name;
    document.getElementById('admChatSub').textContent  = conv.sub;
    document.getElementById('admChatAv').textContent   = conv.initial;
    document.getElementById('admChatAv').style.background = conv.color;

    // Render feed
    var feed = document.getElementById('admChatFeed');
    feed.innerHTML = '<div class="adm-date-div"><span>Hari ini</span></div>';

    conv.messages.forEach(function(msg) {
        feed.appendChild(buildBubble(msg, conv));
    });

    // Mobile
    document.getElementById('admMsgLayout').classList.add('chat-open');
    feed.scrollTo({ top: feed.scrollHeight, behavior: 'instant' });

    // Update total unread
    updateUnreadLabel();

    // Mark localStorage messages as read for this conv
    markLocalStorageRead(key);
}

/* ── Mark localStorage messages read ── */
function markLocalStorageRead(key) {
    var pending = JSON.parse(localStorage.getItem('eventty_pending_msgs') || '[]');
    var updated = pending.map(function(m){
        if (m.senderKey === key) m.read = true;
        return m;
    });
    localStorage.setItem('eventty_pending_msgs', JSON.stringify(updated));
}

/* ── Filter conversations ── */
window.filterConvs = function(q) {
    document.querySelectorAll('.adm-conv-item').forEach(function(item){
        var name = item.getAttribute('data-name') || '';
        item.style.display = name.includes(q.toLowerCase()) ? '' : 'none';
    });
};

/* ── Insert quick reply ── */
window.insertReply = function(text) {
    var input = document.getElementById('admInput');
    input.value = text;
    input.focus();
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 110) + 'px';
};

/* ── Send admin reply ── */
(function(){
    var input   = document.getElementById('admInput');
    var sendBtn = document.getElementById('admSendBtn');
    var feed    = document.getElementById('admChatFeed');
    if (!input || !sendBtn) return;

    input.addEventListener('input', function(){
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 110) + 'px';
    });

    function sendAdm() {
        var text = input.value.trim();
        if (!text) return;

        var conv = convs.find(function(c){ return c.key === activeKey; });
        if (!conv) return;

        var now = new Date();
        var t = String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0');

        var msg = { dir:'adm', text:text, time:t, read:false };
        conv.messages.push(msg);
        conv.lastMsg  = text;
        conv.lastTime = t;

        feed.appendChild(buildBubble(msg, conv));
        feed.scrollTo({ top: feed.scrollHeight, behavior: 'smooth' });

        // Tick → read after delay
        setTimeout(function(){
            var ticks = feed.querySelectorAll('.adm-tick:not(.read)');
            ticks.forEach(function(tk){ tk.classList.add('read'); });
        }, 800);

        input.value = ''; input.style.height = 'auto';

        // Re-render conv list to update lastMsg
        renderConvList();
        // Re-select to keep active state
        var el = document.querySelector('[data-key="' + activeKey + '"]');
        if (el) el.classList.add('active');
    }

    sendBtn.addEventListener('click', sendAdm);
    input.addEventListener('keydown', function(e){
        if (e.key === 'Enter' && !e.shiftKey){ e.preventDefault(); sendAdm(); }
    });
})();

/* ── Close chat (mobile) ── */
window.closeAdmChat = function(){
    document.getElementById('admMsgLayout').classList.remove('chat-open');
};

/* ── Escape HTML ── */
function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

/* ── Poll for new messages from localStorage every 3 seconds ── */
function pollNewMessages() {
    var pending = JSON.parse(localStorage.getItem('eventty_pending_msgs') || '[]');
    var newMsgs = pending.filter(function(m){ return !m.read; });

    newMsgs.forEach(function(msg) {
        var conv = convs.find(function(c){ return c.key === msg.senderKey; });
        var alreadyIn = conv && conv.messages.some(function(m){ return m._id === msg.id; });
        if (alreadyIn) return;

        if (!conv) {
            conv = {
                key: msg.senderKey, name: msg.sender,
                initial: msg.initial || msg.sender.charAt(0),
                sub: 'Pesan baru', color: msg.color || 'linear-gradient(135deg,#3b82f6,#2563eb)',
                messages: [], unread: 0, lastMsg: '', lastTime: 'baru'
            };
            convs.push(conv);
        }

        conv.messages.push({ dir:'stu', text:msg.text, time:msg.time, _id:msg.id });
        conv.lastMsg  = msg.text;
        conv.lastTime = 'baru';

        if (conv.key !== activeKey) {
            conv.unread++;
        } else {
            // Active conv — show message live and mark read
            var feed = document.getElementById('admChatFeed');
            feed.appendChild(buildBubble({ dir:'stu', text:msg.text, time:msg.time }, conv));
            feed.scrollTo({ top: feed.scrollHeight, behavior: 'smooth' });
            markLocalStorageRead(msg.senderKey);
        }

        // Move this conv to top
        convs = [conv].concat(convs.filter(function(c){ return c.key !== conv.key; }));
    });

    renderConvList();
    // Re-apply active state
    var activeEl = document.querySelector('[data-key="' + activeKey + '"]');
    if (activeEl) activeEl.classList.add('active');
}

/* ── Init ── */
loadPendingMessages();
renderConvList();

// Select first conv by default
(function(){
    var firstEl = document.querySelector('.adm-conv-item');
    if (firstEl) selectConv(firstEl.getAttribute('data-key'), firstEl);
})();

// Poll every 3 seconds
setInterval(pollNewMessages, 3000);

</script>
</body>
</html>
