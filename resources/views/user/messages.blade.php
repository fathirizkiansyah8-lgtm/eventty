@extends('user.layout')

@section('title', 'Messages')

@push('css')
<style>
/* ══ Messages Page ══ */
.msg-page {
    display: flex;
    flex-direction: column;
    overflow: hidden;
    font-family: 'Plus Jakarta Sans','Inter',sans-serif;
    /* header is sticky ~73px */
    height: calc(100vh - 73px);
    position: relative;
    z-index: 1; /* below the sticky header z-index:50 so dropdown shows above */
}

.msg-layout { display: grid; grid-template-columns: 290px 1fr; overflow: hidden; height: 100%; }

/* ── Sidebar ── */
.msg-sidebar { display: flex; flex-direction: column; border-right: 1.5px solid var(--border-color); background: var(--bg-secondary); overflow: hidden; }

.msg-sidebar-hd { display: flex; align-items: center; justify-content: space-between; padding: 1.125rem 1.125rem .875rem; border-bottom: 1px solid var(--border-color); flex-shrink: 0; }
.msg-sidebar-hd h2 { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); }
.msg-online-pill { display: flex; align-items: center; gap: 5px; font-size: .68rem; font-weight: 600; color: #16a34a; background: #dcfce7; border-radius: 999px; padding: 3px 9px; }
.msg-online-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #16a34a; }

.msg-conv-list { flex: 1; overflow-y: auto; padding: .5rem; }

.msg-conv-item { display: flex; align-items: center; gap: .75rem; padding: .75rem .875rem; border-radius: .875rem; cursor: pointer; transition: background .15s; margin-bottom: 2px; }
.msg-conv-item:hover { background: var(--bg-tertiary); }
.msg-conv-item.active { background: var(--primary-light); }

/* avatars */
.msg-av { display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: 700; color: #fff; flex-shrink: 0; position: relative; background: linear-gradient(135deg,#0f1f4e,#1a3a7c); }
.msg-av-lg { width: 42px; height: 42px; font-size: .9rem; }
.msg-av-md { width: 34px; height: 34px; font-size: .8rem; }
.msg-av-sm { width: 30px; height: 30px; font-size: .72rem; }
.msg-av-dot { position: absolute; bottom: 1px; right: 1px; width: 9px; height: 9px; background: #22c55e; border-radius: 50%; border: 2px solid var(--bg-secondary); }

.msg-conv-info { flex: 1; min-width: 0; }
.msg-conv-row1 { display: flex; align-items: center; justify-content: space-between; margin-bottom: 3px; }
.msg-conv-name { font-size: .85rem; font-weight: 700; color: var(--text-primary); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.msg-conv-time { font-size: .68rem; color: var(--text-muted); font-weight: 500; flex-shrink: 0; margin-left: 5px; }
.msg-conv-row2 { display: flex; align-items: center; justify-content: space-between; gap: 5px; }
.msg-conv-preview { font-size: .75rem; color: var(--text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1; }
.msg-unread-dot { min-width: 17px; height: 17px; padding: 0 5px; border-radius: 999px; background: var(--primary); color: #fff; font-size: .62rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }

.msg-sidebar-ft { padding: .625rem 1rem; border-top: 1px solid var(--border-color); flex-shrink: 0; }
.msg-sidebar-ft p { font-size: .68rem; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }

/* ── Chat ── */
.msg-chat { display: flex; flex-direction: column; background: var(--bg-primary); overflow: hidden; }

.msg-chat-hd { display: flex; align-items: center; gap: .875rem; padding: .875rem 1.25rem; background: var(--bg-secondary); border-bottom: 1.5px solid var(--border-color); flex-shrink: 0; }
.msg-back-btn { display: none; width: 32px; height: 32px; border-radius: 50%; border: 1.5px solid var(--border-color); background: transparent; color: var(--text-secondary); align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; transition: all .15s; }
.msg-back-btn:hover { background: var(--bg-tertiary); }
.msg-chat-hd-info { flex: 1; display: flex; flex-direction: column; gap: 2px; }
.msg-chat-hd-name { font-size: .9rem; font-weight: 700; color: var(--text-primary); }
.msg-chat-hd-status { display: flex; align-items: center; gap: 5px; font-size: .7rem; color: var(--text-muted); font-weight: 500; }
.msg-status-dot { width: 7px; height: 7px; border-radius: 50%; background: #22c55e; flex-shrink: 0; }

/* Feed */
.msg-feed { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; display: flex; flex-direction: column; gap: 3px; scroll-behavior: smooth; }

.msg-date-div { display: flex; align-items: center; gap: 9px; margin: 10px 0; color: var(--text-muted); font-size: .68rem; font-weight: 600; }
.msg-date-div::before, .msg-date-div::after { content: ''; flex: 1; height: 1px; background: var(--border-color); }
.msg-date-div span { white-space: nowrap; padding: 2px 8px; background: var(--bg-tertiary); border-radius: 999px; border: 1px solid var(--border-color); }

.msg-unread-div { display: flex; align-items: center; gap: 9px; margin: 10px 0 6px; color: var(--primary); font-size: .68rem; font-weight: 700; }
.msg-unread-div::before, .msg-unread-div::after { content: ''; flex: 1; height: 1px; background: var(--primary-light); }
.msg-unread-div span { white-space: nowrap; padding: 2px 8px; background: var(--primary-light); border-radius: 999px; border: 1px solid #bfdbfe; }

.msg-row { display: flex; align-items: flex-end; gap: 7px; margin-bottom: 2px; }
.msg-row.out { justify-content: flex-end; }
.msg-row.in  { justify-content: flex-start; }
.msg-row.in + .msg-row.in .msg-av { visibility: hidden; }

.msg-col { display: flex; flex-direction: column; gap: 3px; max-width: 66%; }
.msg-row.out .msg-col { align-items: flex-end; }

.msg-bubble { padding: 9px 13px; border-radius: 17px; font-size: .865rem; line-height: 1.6; word-break: break-word; }
.msg-bubble.in  { background: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--border-color); border-bottom-left-radius: 4px; }
.msg-bubble.out { background: #0f1f4e; color: #fff; border-bottom-right-radius: 4px; }
.msg-bubble strong { font-weight: 700; }

.msg-bubble-time { font-size: .63rem; color: var(--text-muted); font-weight: 500; }
.msg-bubble-meta { display: flex; align-items: center; gap: 4px; justify-content: flex-end; }
.msg-tick { color: var(--text-muted); display: flex; }
.msg-tick.read { color: #22c55e; }

/* Typing */
.msg-typing { display: none; align-items: flex-end; gap: 7px; margin-top: 3px; }
.msg-typing-bbl { display: flex; align-items: center; gap: 4px; padding: 11px 15px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 17px; border-bottom-left-radius: 4px; }
.msg-typing-bbl span { width: 6px; height: 6px; background: var(--text-muted); border-radius: 50%; animation: msgDot 1.2s ease-in-out infinite; }
.msg-typing-bbl span:nth-child(2) { animation-delay: .2s; }
.msg-typing-bbl span:nth-child(3) { animation-delay: .4s; }
@keyframes msgDot { 0%,60%,100%{transform:translateY(0);opacity:.4} 30%{transform:translateY(-5px);opacity:1} }

/* Input */
.msg-input-area { padding: .875rem 1.25rem .875rem; background: var(--bg-secondary); border-top: 1.5px solid var(--border-color); flex-shrink: 0; }
.msg-input-wrap { display: flex; align-items: flex-end; gap: 9px; background: var(--bg-primary); border: 1.5px solid var(--border-color); border-radius: 15px; padding: 7px 7px 7px 13px; transition: border-color .2s; }
.msg-input-wrap:focus-within { border-color: var(--primary); }
.msg-input { flex: 1; border: none; background: transparent; resize: none; font-size: .865rem; color: var(--text-primary); font-family: inherit; line-height: 1.5; max-height: 110px; min-height: 22px; outline: none; }
.msg-input::placeholder { color: var(--text-muted); }
.msg-send-btn { width: 36px; height: 36px; border-radius: 50%; border: none; background: #0f1f4e; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; transition: all .15s; }
.msg-send-btn:hover { background: #1a3a7c; transform: scale(1.05); }
.msg-send-btn:disabled { background: var(--bg-tertiary); color: var(--text-muted); cursor: not-allowed; transform: none; }
.msg-input-hint { font-size: .65rem; color: var(--text-muted); text-align: center; margin-top: 5px; }

/* Dark mode */
body[data-theme="dark"] .msg-bubble.out { background: #1a3a7c; }
body[data-theme="dark"] .msg-send-btn   { background: #1a3a7c; }
body[data-theme="dark"] .msg-send-btn:hover { background: #2952a3; }

/* Mobile */
@media (max-width: 768px) {
    .msg-layout { grid-template-columns: 1fr; position: relative; }
    .msg-sidebar { width: 100%; }
    .msg-chat { position: absolute; inset: 0; transform: translateX(100%); transition: transform .28s ease; z-index: 10; }
    .msg-layout.chat-open .msg-chat { transform: translateX(0); }
    .msg-back-btn { display: flex; }
    .msg-col { max-width: 82%; }
    .msg-feed { padding: 1rem; }
}
</style>
@endpush

@section('content')
<div class="msg-page">
<div class="msg-layout" id="msgLayout">

    {{-- ── SIDEBAR ── --}}
    <aside class="msg-sidebar">
        <div class="msg-sidebar-hd">
            <h2>Messages</h2>
            <span class="msg-online-pill">Online</span>
        </div>
        <div class="msg-conv-list">
            <div class="msg-conv-item active" onclick="openChat(this)">
                <div class="msg-av msg-av-lg">E<span class="msg-av-dot"></span></div>
                <div class="msg-conv-info">
                    <div class="msg-conv-row1">
                        <span class="msg-conv-name">Admin Eventty</span>
                        <span class="msg-conv-time">2 mnt</span>
                    </div>
                    <div class="msg-conv-row2">
                        <span class="msg-conv-preview">Halo, ada yang bisa kami bantu?</span>
                        <span class="msg-unread-dot" id="convBadge">2</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="msg-sidebar-ft">
            <p><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Pesan hanya dengan Admin Eventty</p>
        </div>
    </aside>

    {{-- ── CHAT ── --}}
    <section class="msg-chat">

        <div class="msg-chat-hd">
            <button class="msg-back-btn" onclick="closeChat()" aria-label="Kembali">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="msg-av msg-av-md">E</div>
            <div class="msg-chat-hd-info">
                <span class="msg-chat-hd-name">Admin Eventty</span>
                <span class="msg-chat-hd-status"><span class="msg-status-dot"></span>Online</span>
            </div>
        </div>

        <div class="msg-feed" id="msgFeed">

            <div class="msg-date-div"><span>Hari ini</span></div>

            <div class="msg-row in">
                <div class="msg-av msg-av-sm">E</div>
                <div class="msg-col">
                    <div class="msg-bubble in">Halo! Selamat datang di Eventty. Ada yang bisa kami bantu? 😊</div>
                    <span class="msg-bubble-time">08:01</span>
                </div>
            </div>
            <div class="msg-row in">
                <div class="msg-av msg-av-sm">E</div>
                <div class="msg-col">
                    <div class="msg-bubble in">Silakan tanyakan apapun mengenai event, pendaftaran, sertifikat, atau kegiatan sekolah lainnya.</div>
                    <span class="msg-bubble-time">08:01</span>
                </div>
            </div>

            <div class="msg-row out">
                <div class="msg-col">
                    <div class="msg-bubble out">Halo Admin, saya ingin bertanya mengenai lomba desain. Apakah boleh menggunakan Canva?</div>
                    <div class="msg-bubble-meta">
                        <span class="msg-bubble-time">10:23</span>
                        <span class="msg-tick read"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span>
                    </div>
                </div>
            </div>

            <div class="msg-row in">
                <div class="msg-av msg-av-sm">E</div>
                <div class="msg-col">
                    <div class="msg-bubble in">Halo Fathi! Boleh menggunakan Canva. Asalkan hasil desainnya original dan belum pernah dipublikasikan. 👍</div>
                    <span class="msg-bubble-time">10:25</span>
                </div>
            </div>

            <div class="msg-row out">
                <div class="msg-col">
                    <div class="msg-bubble out">Baik, terima kasih! Satu lagi, format file apa yang diterima?</div>
                    <div class="msg-bubble-meta">
                        <span class="msg-bubble-time">10:26</span>
                        <span class="msg-tick read"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span>
                    </div>
                </div>
            </div>

            <div class="msg-unread-div"><span>2 pesan belum dibaca</span></div>

            <div class="msg-row in">
                <div class="msg-av msg-av-sm">E</div>
                <div class="msg-col">
                    <div class="msg-bubble in">Format yang diterima: PNG, JPG, atau PDF. Ukuran maksimal 10MB.</div>
                    <span class="msg-bubble-time">10:27</span>
                </div>
            </div>
            <div class="msg-row in">
                <div class="msg-av msg-av-sm">E</div>
                <div class="msg-col">
                    <div class="msg-bubble in">Jangan lupa deadline pengumpulan karya adalah <strong>30 September 2026 pukul 23:59 WIB</strong>. Semangat! 🎨</div>
                    <span class="msg-bubble-time">10:27</span>
                </div>
            </div>

            <div class="msg-typing" id="msgTyping">
                <div class="msg-av msg-av-sm">E</div>
                <div class="msg-typing-bbl"><span></span><span></span><span></span></div>
            </div>

        </div>

        <div class="msg-input-area">
            <div class="msg-input-wrap">
                <textarea class="msg-input" id="msgInput" placeholder="Tulis pesan..." rows="1" aria-label="Tulis pesan"></textarea>
                <button class="msg-send-btn" id="msgSendBtn" aria-label="Kirim">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
            <p class="msg-input-hint">Enter untuk kirim · Shift+Enter baris baru</p>
        </div>

    </section>

</div>
</div>
@endsection

@push('js')
<script>
(function(){
    var feed    = document.getElementById('msgFeed');
    var input   = document.getElementById('msgInput');
    var sendBtn = document.getElementById('msgSendBtn');
    var layout  = document.getElementById('msgLayout');
    var badge   = document.getElementById('convBadge');
    var sbarBadge = document.getElementById('sidebarMsgBadge');
    var typing  = document.getElementById('msgTyping');
    if (!feed || !input) return;

    function scrollBottom(smooth){ feed.scrollTo({ top: feed.scrollHeight, behavior: smooth?'smooth':'instant' }); }

    // Auto-resize textarea
    input.addEventListener('input', function(){
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 110) + 'px';
    });

    // Clear unread on scroll to bottom
    function clearUnread(){
        if(badge) badge.style.display = 'none';
        if(sbarBadge) sbarBadge.style.display = 'none';
        var div = feed.querySelector('.msg-unread-div');
        if(div) div.style.opacity = '.4';
    }
    feed.addEventListener('scroll', function(){
        if(feed.scrollTop + feed.clientHeight >= feed.scrollHeight - 50) clearUnread();
    });
    setTimeout(clearUnread, 2200);

    var replies = [
        'Terima kasih atas pertanyaannya! Kami akan segera menindaklanjuti. 😊',
        'Baik, sudah kami catat. Ada yang ingin ditanyakan lagi?',
        'Untuk info lebih lanjut silakan hubungi OSIS di ruang OSIS ya.',
        'Akan kami sampaikan ke panitia terkait. Ditunggu ya!',
        'Pertanyaan bagus! Kami akan update info terbaru di platform ini.',
    ];
    var replyIdx = 0;

    function createBubble(text, dir){
        var row = document.createElement('div');
        row.className = 'msg-row ' + dir;
        if(dir === 'in'){
            var av = document.createElement('div');
            av.className = 'msg-av msg-av-sm';
            av.textContent = 'E';
            row.appendChild(av);
        }
        var col = document.createElement('div');
        col.className = 'msg-col';
        var bbl = document.createElement('div');
        bbl.className = 'msg-bubble ' + dir;
        bbl.textContent = text;
        var now = new Date();
        var t = String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0');
        if(dir === 'out'){
            var meta = document.createElement('div');
            meta.className = 'msg-bubble-meta';
            meta.innerHTML = '<span class="msg-bubble-time">' + t + '</span><span class="msg-tick"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span>';
            col.appendChild(bbl); col.appendChild(meta);
            setTimeout(function(){ meta.querySelector('.msg-tick').classList.add('read'); }, 900);
        } else {
            var tm = document.createElement('span');
            tm.className = 'msg-bubble-time'; tm.textContent = t;
            col.appendChild(bbl); col.appendChild(tm);
        }
        row.appendChild(col);
        return row;
    }

    function sendMessage(){
        var text = input.value.trim();
        if(!text) return;
        feed.insertBefore(createBubble(text,'out'), typing);
        scrollBottom(true);
        input.value = ''; input.style.height = 'auto';
        // Typing then reply
        typing.style.display = 'flex';
        scrollBottom(true);
        setTimeout(function(){
            typing.style.display = 'none';
            var reply = replies[replyIdx++ % replies.length];
            feed.insertBefore(createBubble(reply,'in'), typing);
            scrollBottom(true);
        }, 1500);
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', function(e){
        if(e.key==='Enter' && !e.shiftKey){ e.preventDefault(); sendMessage(); }
    });

    window.openChat = function(el){
        document.querySelectorAll('.msg-conv-item').forEach(function(i){ i.classList.remove('active'); });
        el.classList.add('active');
        layout.classList.add('chat-open');
        scrollBottom(false);
    };
    window.closeChat = function(){ layout.classList.remove('chat-open'); };

    scrollBottom(false);
})();
</script>
@endpush
