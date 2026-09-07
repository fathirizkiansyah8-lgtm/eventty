/**
 * User Messages — real CS chat, support multiple admins.
 */
document.addEventListener('DOMContentLoaded', function () {

    var feed       = document.getElementById('msgFeed');
    var input      = document.getElementById('msgInput');
    var sendBtn    = document.getElementById('msgSendBtn');
    var statusBox  = document.getElementById('sendStatus');
    var backBtn    = document.getElementById('msgBackBtn');
    var layout     = document.getElementById('msgLayout');
    var quickArea  = document.getElementById('quickActions');
    var chatName   = document.getElementById('chatName');
    var chatAvatar = document.getElementById('chatAvatar');

    if (!feed) return;

    var CSRF         = window.CSRF_TOKEN || '';
    var activeAdminId = window.DEFAULT_ADMIN_ID || null;
    var isSending    = false;
    var pollTimer    = null;
    var lastMsgId    = 0;

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
                if (input) {
                    input.value = this.dataset.text;
                    input.dispatchEvent(new Event('input'));
                    input.focus();
                }
            });
        });
    }

    // ── Klik conversation item ──
    document.querySelectorAll('.msg-conv-item[data-admin-id]').forEach(function (item) {
        item.addEventListener('click', function () {
            var adminId   = parseInt(this.dataset.adminId);
            var adminName = this.dataset.adminName;
            var adminInit = this.dataset.adminInit;
            openAdminChat(adminId, adminName, adminInit, this);
        });
    });

    // ── Buka chat admin tertentu ──
    function openAdminChat(adminId, adminName, adminInit, convEl) {
        activeAdminId = adminId;
        lastMsgId = 0;

        // Update header
        if (chatName)   chatName.textContent   = adminName;
        if (chatAvatar) chatAvatar.textContent  = adminInit;

        // Update active state di list
        document.querySelectorAll('.msg-conv-item').forEach(function (el) {
            el.classList.remove('active');
        });
        if (convEl) convEl.classList.add('active');

        // Mobile: show chat panel
        layout && layout.classList.add('chat-open');

        // Clear poll lama, load messages baru
        clearInterval(pollTimer);
        loadMessages(true);
        pollTimer = setInterval(function () { loadMessages(false); }, 5000);
    }

    // ── Load messages dari active admin ──
    function loadMessages(initialLoad) {
        if (!activeAdminId) return;

        fetch('/api/user/messages/' + activeAdminId, {
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
            updateConvPreview(activeAdminId, messages);
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

    // ── Render feed ──
    function renderFeed(messages, scrollToBottom) {
        if (!messages || messages.length === 0) {
            feed.innerHTML = '<div style="text-align:center;padding:3rem;color:var(--text-muted);">'
                + '<iconify-icon icon="lucide:message-circle" width="40" height="40" style="display:block;margin:0 auto 1rem;opacity:.3;"></iconify-icon>'
                + '<p style="font-size:.875rem;font-weight:600;">Belum ada pesan</p>'
                + '<p style="font-size:.78rem;margin-top:.25rem;">Mulai percakapan dengan Admin CS Eventty.</p>'
                + '</div>';
            lastMsgId = 0;
            return;
        }

        var latestId = messages[messages.length - 1].id;
        if (!scrollToBottom && latestId === lastMsgId) return;

        var grouped = groupByDate(messages);
        var html = '';
        grouped.forEach(function (group) {
            html += '<div class="msg-date-div"><span>' + group.date + '</span></div>';
            group.msgs.forEach(function (msg) { html += buildBubble(msg); });
        });

        var atBottom = feed.scrollHeight - feed.scrollTop - feed.clientHeight < 80;
        feed.innerHTML = html;
        lastMsgId = latestId;

        if (scrollToBottom || atBottom) {
            feed.scrollTo({ top: feed.scrollHeight, behavior: scrollToBottom ? 'instant' : 'smooth' });
        }

        // Sembunyikan quick replies setelah ada pesan
        if (messages.length > 0 && quickArea) {
            quickArea.style.display = 'none';
        }
    }

    // ── Build bubble ──
    function buildBubble(msg) {
        var isMine  = msg.is_mine;
        var adminInit = chatAvatar ? chatAvatar.textContent.trim() : 'A';
        var userInit  = window.MSG_USER_INIT || 'U';

        var avHtml = isMine
            ? '<div class="msg-row-av" style="background:linear-gradient(135deg,#1e40af,#3b82f6);">' + userInit + '</div>'
            : '<div class="msg-row-av" style="background:linear-gradient(135deg,#f59e0b,#ea580c);">' + adminInit + '</div>';

        var tick = isMine
            ? '<span class="msg-tick' + (msg.read_at ? ' read' : '') + '">'
              + '<iconify-icon icon="lucide:check-check" width="12" height="12"></iconify-icon></span>'
            : '';

        return '<div class="msg-row ' + (isMine ? 'out' : 'in') + '">'
            + (!isMine ? avHtml : '')
            + '<div class="msg-col">'
            + '<div class="msg-bubble ' + (isMine ? 'out' : 'in') + '">' + escHtml(msg.body) + '</div>'
            + '<div class="msg-bbl-meta"><span class="msg-bbl-time">' + msg.time + '</span>' + tick + '</div>'
            + '</div>'
            + (isMine ? avHtml : '')
            + '</div>';
    }

    // ── Group by date ──
    function groupByDate(messages) {
        var groups = [], curDate = null, curGroup = null;
        messages.forEach(function (m) {
            if (m.date !== curDate) {
                if (curGroup) groups.push(curGroup);
                curDate = m.date;
                curGroup = { date: m.date, msgs: [] };
            }
            curGroup.msgs.push(m);
        });
        if (curGroup) groups.push(curGroup);
        return groups;
    }

    // ── Update preview di conversation list ──
    function updateConvPreview(adminId, messages) {
        if (!messages || messages.length === 0) return;
        var last = messages[messages.length - 1];

        var previewEl = document.querySelector('.conv-last-msg-' + adminId);
        var timeEl    = document.querySelector('.conv-last-time-' + adminId);

        if (previewEl) {
            var preview = (last.is_mine ? 'Anda: ' : '') + last.body;
            previewEl.textContent = preview.length > 40 ? preview.substring(0, 40) + '...' : preview;
        }
        if (timeEl) timeEl.textContent = last.time;
    }

    // ── Load semua preview percakapan ──
    function loadAllPreviews() {
        fetch('/api/user/messages/admins', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF
            }
        })
        .then(function (r) { return r.json(); })
        .then(function (admins) {
            admins.forEach(function (admin) {
                var previewEl = document.querySelector('.conv-last-msg-' + admin.id);
                var timeEl    = document.querySelector('.conv-last-time-' + admin.id);
                var unreadEl  = document.querySelector('.conv-unread-' + admin.id);

                if (previewEl && admin.last_message) previewEl.textContent = admin.last_message;
                if (timeEl    && admin.last_time)    timeEl.textContent    = admin.last_time;
                if (unreadEl) {
                    if (admin.unread > 0) {
                        unreadEl.textContent   = admin.unread;
                        unreadEl.style.display = '';
                    } else {
                        unreadEl.style.display = 'none';
                    }
                }
            });
        })
        .catch(function (e) { console.error('Load previews error:', e); });
    }

    // ── Send message ──
    function sendMessage() {
        if (!input || !activeAdminId || isSending) return;
        var text = input.value.trim();
        if (!text) return;

        isSending = true;
        sendBtn && (sendBtn.disabled = true);
        setStatus('loading', 'Mengirim...');

        fetch('/api/user/messages/' + activeAdminId, {
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
                loadMessages(false);
            } else {
                setStatus('error', data.message || 'Gagal mengirim.');
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

    function setStatus(type, msg) {
        if (!statusBox) return;
        statusBox.className = 'msg-send-status' + (type ? ' ' + type : '');
        statusBox.textContent = msg;
    }

    function escHtml(str) {
        return String(str || '')
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
            .replace(/\n/g, '<br>');
    }

    // ── Init: load preview semua admin, lalu buka chat admin pertama ──
    loadAllPreviews();
    setInterval(loadAllPreviews, 10000);

    if (activeAdminId) {
        var firstConv = document.querySelector('.msg-conv-item[data-admin-id="' + activeAdminId + '"]');
        if (firstConv) {
            openAdminChat(
                activeAdminId,
                firstConv.dataset.adminName,
                firstConv.dataset.adminInit,
                firstConv
            );
        }
    }
});
