/**
 * User Messages — real CS chat dengan Admin via database.
 * Tidak ada dummy data. Semua pesan dari /api/user/messages.
 */
document.addEventListener('DOMContentLoaded', function () {

    var feed       = document.getElementById('msgFeed');
    var input      = document.getElementById('msgInput');
    var sendBtn    = document.getElementById('msgSendBtn');
    var statusBox  = document.getElementById('sendStatus');
    var backBtn    = document.getElementById('msgBackBtn');
    var layout     = document.getElementById('msgLayout');
    var quickArea  = document.getElementById('quickActions');

    if (!feed) return;

    var CSRF = window.CSRF_TOKEN || '';
    var isSending = false;
    var pollInterval = null;
    var lastMessageId = 0;

    // ── Auto-resize textarea ──
    if (input) {
        input.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            sendBtn && (sendBtn.disabled = this.value.trim() === '');
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (!sendBtn.disabled) sendMessage();
            }
        });
    }

    // ── Send button ──
    if (sendBtn) sendBtn.addEventListener('click', sendMessage);

    // ── Back button (mobile) ──
    if (backBtn) {
        backBtn.addEventListener('click', function () {
            layout && layout.classList.remove('chat-open');
        });
    }

    // ── Quick replies ──
    if (quickArea) {
        quickArea.querySelectorAll('.msg-quick-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var text = this.dataset.text;
                if (input && text) {
                    input.value = text;
                    input.dispatchEvent(new Event('input'));
                    input.focus();
                }
            });
        });
    }

    // ── Load messages on boot ──
    loadMessages(true);

    // ── Poll setiap 5 detik untuk pesan baru ──
    pollInterval = setInterval(function () { loadMessages(false); }, 5000);

    // ── Cleanup on page leave ──
    window.addEventListener('beforeunload', function () {
        clearInterval(pollInterval);
    });


    // =========================================
    // LOAD MESSAGES
    // =========================================
    function loadMessages(initialLoad) {
        fetch('/api/user/messages', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF
            }
        })
        .then(function (r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(function (messages) {
            renderFeed(messages, initialLoad);
            updateConversationPreview(messages);
        })
        .catch(function (err) {
            console.error('Load messages error:', err);
            if (initialLoad) {
                feed.innerHTML = '<div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:.82rem;">'
                    + '<iconify-icon icon="lucide:wifi-off" width="28" height="28" style="display:block;margin:0 auto .5rem;"></iconify-icon>'
                    + 'Gagal memuat percakapan. Coba refresh halaman.'
                    + '</div>';
            }
        });
    }


    // =========================================
    // RENDER FEED
    // =========================================
    function renderFeed(messages, scrollToBottom) {
        if (!messages || messages.length === 0) {
            feed.innerHTML = '<div style="text-align:center;padding:3rem;color:var(--text-muted);">'
                + '<iconify-icon icon="lucide:message-circle" width="40" height="40" style="display:block;margin:0 auto 1rem;opacity:.3;"></iconify-icon>'
                + '<p style="font-size:.875rem;font-weight:600;">Belum ada pesan</p>'
                + '<p style="font-size:.78rem;margin-top:.25rem;">Mulai percakapan dengan Admin CS Eventty.</p>'
                + '</div>';
            lastMessageId = 0;
            return;
        }

        // Cek apakah ada pesan baru sejak render terakhir
        var latestId = messages[messages.length - 1].id;
        if (!scrollToBottom && latestId === lastMessageId) return; // tidak ada yang baru

        // Group pesan by date
        var grouped = groupByDate(messages);
        var html = '';

        grouped.forEach(function (group) {
            html += '<div class="msg-date-div"><span>' + group.date + '</span></div>';
            group.msgs.forEach(function (msg) {
                html += buildBubble(msg);
            });
        });

        // Preserve scroll jika user sedang scroll ke atas
        var atBottom = feed.scrollHeight - feed.scrollTop - feed.clientHeight < 80;

        feed.innerHTML = html;
        lastMessageId = latestId;

        if (scrollToBottom || atBottom) {
            feed.scrollTo({ top: feed.scrollHeight, behavior: scrollToBottom ? 'instant' : 'smooth' });
        }

        // Sembunyikan quick replies jika sudah ada percakapan
        if (messages.length > 0 && quickArea) {
            quickArea.style.display = 'none';
        }
    }


    // =========================================
    // BUILD BUBBLE HTML
    // =========================================
    function buildBubble(msg) {
        var isMine = msg.is_mine;
        var avatar = isMine
            ? '<div class="msg-row-av" style="background:linear-gradient(135deg,#1e40af,#3b82f6);">'
              + (window.MSG_USER_INIT || 'U') + '</div>'
            : '<div class="msg-row-av" style="background:linear-gradient(135deg,#f59e0b,#ea580c);">'
              + (window.MSG_ADMIN_INIT || 'A') + '</div>';

        var readTick = isMine
            ? '<span class="msg-tick' + (msg.read_at ? ' read' : '') + '">'
              + '<iconify-icon icon="lucide:check-check" width="12" height="12"></iconify-icon>'
              + '</span>'
            : '';

        return '<div class="msg-row ' + (isMine ? 'out' : 'in') + '">'
            + (!isMine ? avatar : '')
            + '<div class="msg-col">'
            + '<div class="msg-bubble ' + (isMine ? 'out' : 'in') + '">' + escHtml(msg.body) + '</div>'
            + '<div class="msg-bbl-meta">'
            + '<span class="msg-bbl-time">' + msg.time + '</span>'
            + readTick
            + '</div>'
            + '</div>'
            + (isMine ? avatar : '')
            + '</div>';
    }


    // =========================================
    // GROUP MESSAGES BY DATE
    // =========================================
    function groupByDate(messages) {
        var groups = [];
        var currentDate = null;
        var currentGroup = null;

        messages.forEach(function (msg) {
            var date = msg.date;
            if (date !== currentDate) {
                if (currentGroup) groups.push(currentGroup);
                currentDate  = date;
                currentGroup = { date: date, msgs: [] };
            }
            currentGroup.msgs.push(msg);
        });
        if (currentGroup) groups.push(currentGroup);

        return groups;
    }


    // =========================================
    // UPDATE CONVERSATION LIST PREVIEW
    // =========================================
    function updateConversationPreview(messages) {
        if (!messages || messages.length === 0) return;

        var last = messages[messages.length - 1];
        var prevEl = document.getElementById('convLastMsg');
        var timeEl = document.getElementById('convLastTime');

        if (prevEl) {
            var preview = (last.is_mine ? 'Anda: ' : '') + last.body;
            prevEl.textContent = preview.length > 40 ? preview.substring(0, 40) + '...' : preview;
        }
        if (timeEl) timeEl.textContent = last.time;
    }


    // =========================================
    // SEND MESSAGE
    // =========================================
    function sendMessage() {
        if (!input || isSending) return;

        var text = input.value.trim();
        if (!text) return;

        isSending = true;
        sendBtn && (sendBtn.disabled = true);
        setStatus('loading', 'Mengirim...');

        fetch('/api/user/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body: text })
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.success) {
                input.value = '';
                input.style.height = 'auto';
                setStatus('', '');
                loadMessages(false); // reload feed
            } else {
                setStatus('error', data.message || 'Gagal mengirim pesan.');
            }
        })
        .catch(function () {
            setStatus('error', 'Tidak dapat terhubung ke server.');
        })
        .finally(function () {
            isSending = false;
            if (input) sendBtn && (sendBtn.disabled = input.value.trim() === '');
        });
    }


    // =========================================
    // STATUS BOX
    // =========================================
    function setStatus(type, msg) {
        if (!statusBox) return;
        statusBox.className = 'msg-send-status' + (type ? ' ' + type : '');
        statusBox.textContent = msg;
    }


    // =========================================
    // HTML ESCAPE
    // =========================================
    function escHtml(str) {
        return String(str || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/\n/g, '<br>');
    }

});
