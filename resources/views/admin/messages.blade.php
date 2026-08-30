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
    
    <!-- ── Messages Content ── -->
    <div class="adm-msg-page">

        <div class="adm-msg-layout" id="admMsgLayout">

            {{-- ── Conversation List ── --}}
            <aside class="adm-msg-left">
                <div class="adm-msg-left-hd">
                    <h1 class="adm-msg-title">Messages</h1>
                    <span class="adm-msg-count">3 belum dibaca</span>
                </div>

                <div class="adm-msg-search">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Cari percakapan..." id="admMsgSearch" oninput="filterConvs(this.value)">
                </div>

                <div class="adm-conv-list" id="admConvList">

                    <div class="adm-conv-item active" data-name="Fathi Rizkiansyah" onclick="selectAdmConv('fathi',this)">
                        <div class="adm-conv-av" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">F</div>
                        <div class="adm-conv-info">
                            <div class="adm-conv-row1">
                                <span class="adm-conv-name">Fathi Rizkiansyah</span>
                                <span class="adm-conv-time">2 mnt</span>
                            </div>
                            <div class="adm-conv-row2">
                                <span class="adm-conv-preview">Min, mau tanya tentang lomba...</span>
                                <span class="adm-unread">2</span>
                            </div>
                        </div>
                    </div>

                    <div class="adm-conv-item unread" data-name="Siti Nurhaliza" onclick="selectAdmConv('siti',this)">
                        <div class="adm-conv-av" style="background:linear-gradient(135deg,#7c3aed,#5b21b6)">S</div>
                        <div class="adm-conv-info">
                            <div class="adm-conv-row1">
                                <span class="adm-conv-name">Siti Nurhaliza</span>
                                <span class="adm-conv-time">10 mnt</span>
                            </div>
                            <div class="adm-conv-row2">
                                <span class="adm-conv-preview">Untuk seminar besok apakah...</span>
                                <span class="adm-unread">1</span>
                            </div>
                        </div>
                    </div>

                    <div class="adm-conv-item" data-name="Budi Santoso" onclick="selectAdmConv('budi',this)">
                        <div class="adm-conv-av" style="background:linear-gradient(135deg,#059669,#047857)">B</div>
                        <div class="adm-conv-info">
                            <div class="adm-conv-row1">
                                <span class="adm-conv-name">Budi Santoso</span>
                                <span class="adm-conv-time">1 jam</span>
                            </div>
                            <div class="adm-conv-row2">
                                <span class="adm-conv-preview">Terima kasih Admin 🙏</span>
                            </div>
                        </div>
                    </div>

                    <div class="adm-conv-item" data-name="Rizky Pratama" onclick="selectAdmConv('rizky',this)">
                        <div class="adm-conv-av" style="background:linear-gradient(135deg,#d97706,#b45309)">R</div>
                        <div class="adm-conv-info">
                            <div class="adm-conv-row1">
                                <span class="adm-conv-name">Rizky Pratama</span>
                                <span class="adm-conv-time">3 jam</span>
                            </div>
                            <div class="adm-conv-row2">
                                <span class="adm-conv-preview">Sudah daftar Career Day kak</span>
                            </div>
                        </div>
                    </div>

                    <div class="adm-conv-item unread" data-name="Dewi Anggraini" onclick="selectAdmConv('dewi',this)">
                        <div class="adm-conv-av" style="background:linear-gradient(135deg,#db2777,#be185d)">D</div>
                        <div class="adm-conv-info">
                            <div class="adm-conv-row1">
                                <span class="adm-conv-name">Dewi Anggraini</span>
                                <span class="adm-conv-time">5 jam</span>
                            </div>
                            <div class="adm-conv-row2">
                                <span class="adm-conv-preview">Sertifikat saya belum muncul...</span>
                                <span class="adm-unread">1</span>
                            </div>
                        </div>
                    </div>

                </div>
            </aside>

            {{-- ── Chat Area ── --}}
            <section class="adm-chat-area">

                <div class="adm-chat-hd" id="admChatHd">
                    <button class="adm-back-btn" onclick="closeAdmChat()" aria-label="Kembali">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <div class="adm-chat-av" id="admChatAv" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">F</div>
                    <div class="adm-chat-hd-info">
                        <span class="adm-chat-hd-name" id="admChatName">Fathi Rizkiansyah</span>
                        <span class="adm-chat-hd-sub" id="admChatSub">XI RPL 1 · NIS 12345</span>
                    </div>
                    <div class="adm-chat-hd-actions">
                        <button class="adm-hd-btn" title="Lihat profil siswa">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </button>
                    </div>
                </div>

                <div class="adm-chat-feed" id="admChatFeed">
                    <div class="adm-date-div"><span>Hari ini</span></div>

                    <div class="adm-row stu">
                        <div class="adm-row-av" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">F</div>
                        <div class="adm-row-col">
                            <span class="adm-row-sender">Fathi Rizkiansyah</span>
                            <div class="adm-bubble stu">Halo Admin, mau tanya tentang lomba desain. Apakah boleh pakai Canva?</div>
                            <span class="adm-bbl-time">10:23</span>
                        </div>
                    </div>

                    <div class="adm-row adm">
                        <div class="adm-row-col adm">
                            <div class="adm-bubble adm">Halo Fathi! Boleh pakai Canva, asalkan desainnya original dan belum pernah dipublikasikan. 👍</div>
                            <div class="adm-bbl-meta"><span class="adm-bbl-time">10:25</span><span class="adm-tick read"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span></div>
                        </div>
                    </div>

                    <div class="adm-row stu">
                        <div class="adm-row-av" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">F</div>
                        <div class="adm-row-col">
                            <div class="adm-bubble stu">Format file apa yang diterima?</div>
                            <span class="adm-bbl-time">10:26</span>
                        </div>
                    </div>

                    <div class="adm-unread-div"><span>2 pesan belum dibaca</span></div>

                    <div class="adm-row stu unread-msg">
                        <div class="adm-row-av" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">F</div>
                        <div class="adm-row-col">
                            <div class="adm-bubble stu">Halo min, sudah saya baca syaratnya tapi mau konfirmasi lagi soal ukuran file maksimal</div>
                            <span class="adm-bbl-time">10:40</span>
                        </div>
                    </div>

                    <div class="adm-row stu unread-msg">
                        <div class="adm-row-av" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">F</div>
                        <div class="adm-row-col">
                            <div class="adm-bubble stu">Apakah 15MB boleh?</div>
                            <span class="adm-bbl-time">10:40</span>
                        </div>
                    </div>

                    <div class="adm-typing" id="admTyping" style="display:none;">
                        <div class="adm-typing-bbl"><span></span><span></span><span></span></div>
                        <span style="font-size:.65rem;color:var(--text-muted);margin-left:6px;">Admin sedang mengetik...</span>
                    </div>
                </div>

                <div class="adm-quick-replies">
                    <button class="adm-qr-btn" onclick="insertReply('Format PNG, JPG, PDF. Maks 10MB ya.')">Format PNG/JPG/PDF, maks 10MB</button>
                    <button class="adm-qr-btn" onclick="insertReply('Terima kasih sudah menghubungi kami! 😊')">Terima kasih</button>
                    <button class="adm-qr-btn" onclick="insertReply('Deadline pengumpulan 30 September 2026 pukul 23:59 WIB.')">Info deadline</button>
                </div>

                <div class="adm-input-area">
                    <div class="adm-input-wrap">
                        <textarea class="adm-input" id="admInput" placeholder="Tulis balasan..." rows="1" aria-label="Tulis balasan"></textarea>
                        <button class="adm-send-btn" id="admSendBtn" aria-label="Kirim">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
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
@vite(['resources/js/admin/messages.js'])

<script>
// ── Conversation data (dummy)
var convData = {
    fathi: { name:'Fathi Rizkiansyah', sub:'XI RPL 1 · NIS 12345', av:'F', color:'linear-gradient(135deg,#3b82f6,#2563eb)' },
    siti:  { name:'Siti Nurhaliza',    sub:'XI AK 1 · NIS 12346',  av:'S', color:'linear-gradient(135deg,#7c3aed,#5b21b6)' },
    budi:  { name:'Budi Santoso',      sub:'XII RPL 1 · NIS 11234', av:'B', color:'linear-gradient(135deg,#059669,#047857)' },
    rizky: { name:'Rizky Pratama',     sub:'X BD 1 · NIS 10345',   av:'R', color:'linear-gradient(135deg,#d97706,#b45309)' },
    dewi:  { name:'Dewi Anggraini',    sub:'XI MP 1 · NIS 12567',  av:'D', color:'linear-gradient(135deg,#db2777,#be185d)' },
};

var convMessages = {
    siti: [
        { dir:'stu', text:'Halo Admin, untuk seminar besok apakah ada dress code khusus?', time:'09:15' },
        { dir:'adm', text:'Halo Siti! Untuk seminar cukup pakai seragam sekolah lengkap ya.', time:'09:17', read:true },
        { dir:'stu', text:'Oke siap, terima kasih! Boleh bawa tas atau harus titip?', time:'09:18' },
    ],
    budi: [
        { dir:'stu', text:'Kak admin, saya sudah daftar Career Day. Kapan konfirmasinya?', time:'08:30' },
        { dir:'adm', text:'Halo Budi! Konfirmasi akan dikirim ke WhatsApp kamu dalam 1x24 jam.', time:'08:35', read:true },
        { dir:'stu', text:'Terima kasih Admin 🙏', time:'08:36' },
    ],
    rizky: [
        { dir:'stu', text:'Min, udah daftar Career Day. Dapat nomor urut berapa?', time:'07:00' },
        { dir:'adm', text:'Halo Rizky! Nomor urut dan detail akan dikirim H-1 acara ya.', time:'07:05', read:true },
        { dir:'stu', text:'Sudah daftar Career Day kak, ditunggu konfirmasinya 😊', time:'07:10' },
    ],
    dewi: [
        { dir:'stu', text:'Admin, sertifikat Workshop Design saya belum muncul padahal sudah hadir', time:'05:00' },
        { dir:'stu', text:'Sertifikat saya belum muncul di Certificates kak...', time:'05:01' },
    ],
};

function selectAdmConv(id, el) {
    document.querySelectorAll('.adm-conv-item').forEach(function(i){ i.classList.remove('active'); });
    el.classList.add('active');
    el.classList.remove('unread');
    var badge = el.querySelector('.adm-unread');
    if(badge) badge.remove();

    var d = convData[id];
    document.getElementById('admChatName').textContent = d.name;
    document.getElementById('admChatSub').textContent  = d.sub;
    document.getElementById('admChatAv').textContent   = d.av;
    document.getElementById('admChatAv').style.background = d.color;

    var feed = document.getElementById('admChatFeed');
    if(convMessages[id]){
        feed.innerHTML = '<div class="adm-date-div"><span>Hari ini</span></div>';
        convMessages[id].forEach(function(m){
            feed.insertBefore(buildAdmBubble(m.dir, m.text, m.time, d.av, d.color, m.read), document.getElementById('admTyping') || null);
        });
    }

    document.getElementById('admMsgLayout').classList.add('chat-open');
    feed.scrollTo({ top: feed.scrollHeight, behavior: 'instant' });
}

function buildAdmBubble(dir, text, time, av, color, read){
    var row = document.createElement('div');
    row.className = 'adm-row ' + dir;
    if(dir === 'stu'){
        var avEl = document.createElement('div');
        avEl.className = 'adm-row-av'; avEl.textContent = av; avEl.style.background = color;
        row.appendChild(avEl);
    }
    var col = document.createElement('div');
    col.className = 'adm-row-col' + (dir==='adm'?' adm':'');
    var bbl = document.createElement('div');
    bbl.className = 'adm-bubble ' + dir;
    bbl.textContent = text;
    col.appendChild(bbl);
    if(dir === 'adm'){
        col.innerHTML += '<div class="adm-bbl-meta"><span class="adm-bbl-time">' + time + '</span><span class="adm-tick' + (read?' read':'') + '"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span></div>';
    } else {
        col.innerHTML += '<span class="adm-bbl-time">' + time + '</span>';
    }
    row.appendChild(col);
    return row;
}

function closeAdmChat(){ document.getElementById('admMsgLayout').classList.remove('chat-open'); }

function filterConvs(q){
    document.querySelectorAll('.adm-conv-item').forEach(function(item){
        var name = item.getAttribute('data-name').toLowerCase();
        item.style.display = name.includes(q.toLowerCase()) ? '' : 'none';
    });
}

function insertReply(text){ var i = document.getElementById('admInput'); i.value = text; i.focus(); }

(function(){
    var input = document.getElementById('admInput');
    var sendBtn = document.getElementById('admSendBtn');
    var feed  = document.getElementById('admChatFeed');
    var typing = document.getElementById('admTyping');
    if(!input || !sendBtn) return;

    input.addEventListener('input', function(){ this.style.height='auto'; this.style.height=Math.min(this.scrollHeight,110)+'px'; });

    function sendAdm(){
        var text = input.value.trim();
        if(!text) return;
        var now = new Date();
        var t = String(now.getHours()).padStart(2,'0')+':'+String(now.getMinutes()).padStart(2,'0');
        feed.insertBefore(buildAdmBubble('adm', text, t, 'A', '', false), typing || null);
        input.value=''; input.style.height='auto';
        feed.scrollTo({top:feed.scrollHeight,behavior:'smooth'});
        setTimeout(function(){ var tick = feed.lastElementChild && feed.lastElementChild.querySelector('.adm-tick'); if(tick) tick.classList.add('read'); }, 800);
    }

    sendBtn.addEventListener('click', sendAdm);
    input.addEventListener('keydown', function(e){ if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();sendAdm();} });

    feed.scrollTo({top:feed.scrollHeight,behavior:'instant'});
})();
</script>
</body>
</html>
