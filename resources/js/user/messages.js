document.addEventListener('DOMContentLoaded', function () {
    const feed = document.getElementById('msgFeed');
    const list = document.getElementById('conversationList');
    const input = document.getElementById('msgInput');
    const sendBtn = document.getElementById('msgSendBtn');
    const statusBox = document.getElementById('sendStatus');
    const quickActions = document.getElementById('quickActions');
    const systemNotification = document.getElementById('systemNotification');
    const chatName = document.getElementById('chatName');
    const chatAvatar = document.getElementById('chatAvatar');
    const chatStatus = document.getElementById('chatStatus');
    const layout = document.getElementById('msgLayout');

    if (!feed || !list || !input || !sendBtn || !statusBox) {
        return;
    }

    const now = () => new Date();
    const formatTime = (date = new Date()) => {
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
    };

    const conversationData = [
        {
            id: 'bot',
            type: 'bot',
            name: 'EVENTTY Bot',
            status: 'Online',
            avatar: 'B',
            color: 'linear-gradient(135deg, #0f172a, #1d4ed8)',
            lastMessage: 'Saya bisa bantu cek event, pendaftaran, dan sertifikat.',
            lastTime: '2 menit lalu',
            unread: 2,
            messages: [
                { sender: 'bot', text: 'Halo! Saya EVENTTY Bot. Ada yang bisa saya bantu seputar event, pendaftaran, atau sertifikat?', time: '08:10' },
                { sender: 'user', text: 'Saya ingin cek jadwal event workshop besok.', time: '08:12' },
                { sender: 'bot', text: 'Untuk jadwal workshop, cek menu Events. Bila Anda mau, saya juga bisa membantu memilih event yang paling cocok.', time: '08:12' },
            ],
            suggestions: ['Cek event hari ini', 'Bagaimana cara mendaftar?', 'Dimana sertifikat saya?'],
        },
        {
            id: 'admin',
            type: 'admin',
            name: 'Admin EVENTTY',
            status: 'Online',
            avatar: 'A',
            color: 'linear-gradient(135deg, #f59e0b, #ea580c)',
            lastMessage: 'Format file yang diterima adalah PNG, JPG, atau PDF.',
            lastTime: '12 menit lalu',
            unread: 1,
            messages: [
                { sender: 'admin', text: 'Halo Fathi, ada yang bisa kami bantu?', time: '09:00' },
                { sender: 'user', text: 'Saya ingin memastikan format file desain yang diterima.', time: '09:03' },
                { sender: 'admin', text: 'Format file yang diterima adalah PNG, JPG, atau PDF dengan maksimal ukuran 10MB.', time: '09:04' },
            ],
            suggestions: ['Format file yang diterima?', 'Batas deadline?', 'Apakah boleh pakai Canva?'],
        }
    ];

    let activeConversationId = 'bot';
    let isTyping = false;

    function getConversationById(id) {
        return conversationData.find((item) => item.id === id) || conversationData[0];
    }

    function renderConversationList() {
        list.innerHTML = '';

        const sorted = [...conversationData].sort((a, b) => {
            const aTime = a.messages[a.messages.length - 1]?.time || '00:00';
            const bTime = b.messages[b.messages.length - 1]?.time || '00:00';
            return bTime.localeCompare(aTime);
        });

        if (!sorted.length) {
            list.innerHTML = `
                <div class="msg-empty-state">
                    <div class="msg-empty-icon">💬</div>
                    <div class="msg-empty-title">Belum ada percakapan</div>
                    <div class="msg-empty-description">Mulai chat dengan EVENTTY Bot atau Admin untuk mendapatkan bantuan cepat.</div>
                </div>
            `;
            return;
        }

        sorted.forEach((conversation) => {
            const lastMessage = conversation.messages[conversation.messages.length - 1];
            const item = document.createElement('div');
            item.className = `msg-conv-item ${activeConversationId === conversation.id ? 'active' : ''}`;
            item.dataset.id = conversation.id;
            item.innerHTML = `
                <div class="msg-av" style="background: ${conversation.color};">
                    ${conversation.avatar}
                    <span class="msg-av-dot"></span>
                </div>
                <div class="msg-conv-info">
                    <div class="msg-conv-row1">
                        <span class="msg-conv-name">${conversation.name}</span>
                        <span class="msg-conv-time">${conversation.lastTime}</span>
                    </div>
                    <div class="msg-conv-row2">
                        <span class="msg-conv-preview">${lastMessage ? lastMessage.text : 'Belum ada pesan'}</span>
                        ${conversation.unread > 0 ? `<span class="msg-unread-pill">${conversation.unread}</span>` : ''}
                    </div>
                </div>
            `;

            item.addEventListener('click', function () {
                openConversation(conversation.id, true);
            });

            list.appendChild(item);
        });
    }

    function setSystemNotification(message) {
        if (!systemNotification) return;
        systemNotification.textContent = message;
        systemNotification.classList.add('visible');
        clearTimeout(setSystemNotification.timeoutId);
        setSystemNotification.timeoutId = setTimeout(() => {
            systemNotification.classList.remove('visible');
        }, 2600);
    }

    function renderSuggestions(conversation) {
        if (!quickActions) return;
        quickActions.innerHTML = '';
        const suggestions = conversation.suggestions || [];
        suggestions.forEach((question) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'msg-quick-btn';
            btn.textContent = question;
            btn.addEventListener('click', function () {
                input.value = question;
                input.focus();
                updateSendButton();
            });
            quickActions.appendChild(btn);
        });
    }

    function renderMessages(conversation) {
        feed.innerHTML = '';

        const today = new Date();
        const dateLabel = today.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        const dateDivider = document.createElement('div');
        dateDivider.className = 'msg-date-div';
        dateDivider.innerHTML = `<span>${dateLabel}</span>`;
        feed.appendChild(dateDivider);

        conversation.messages.forEach((message) => {
            const row = document.createElement('div');
            row.className = `msg-row ${message.sender === 'user' ? 'out' : 'in'}`;

            if (message.sender !== 'user') {
                const avatar = document.createElement('div');
                avatar.className = 'msg-row-av';
                avatar.textContent = conversation.avatar;
                row.appendChild(avatar);
            }

            const col = document.createElement('div');
            col.className = 'msg-col';

            const bubble = document.createElement('div');
            bubble.className = `msg-bubble ${message.sender === 'user' ? 'out' : 'in'}`;
            bubble.textContent = message.text;
            col.appendChild(bubble);

            const time = document.createElement('span');
            time.className = 'msg-bbl-time';
            time.textContent = message.time;

            if (message.sender === 'user') {
                const meta = document.createElement('div');
                meta.className = 'msg-bbl-meta';
                meta.appendChild(time);
                const tick = document.createElement('span');
                tick.className = 'msg-tick read';
                tick.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                meta.appendChild(tick);
                col.appendChild(meta);
            } else {
                col.appendChild(time);
            }

            row.appendChild(col);
            feed.appendChild(row);
        });

        const typing = document.createElement('div');
        typing.className = 'msg-typing';
        typing.id = 'botTypingIndicator';
        typing.innerHTML = `
            <div class="msg-row-av">${conversation.avatar}</div>
            <div class="msg-typing-bbl"><span></span><span></span><span></span></div>
        `;
        feed.appendChild(typing);

        scrollToBottom();
    }

    function openConversation(id, notify = false) {
        const conversation = getConversationById(id);
        activeConversationId = id;

        chatName.textContent = conversation.name;
        chatAvatar.textContent = conversation.avatar;
        chatAvatar.style.background = conversation.color;
        chatStatus.textContent = conversation.status;

        renderSuggestions(conversation);
        renderMessages(conversation);
        renderConversationList();

        if (notify) {
            const message = id === 'bot' ? 'Connected to EVENTTY Bot' : 'You are now chatting with Admin';
            setSystemNotification(message);
        }
    }

    function updateSendButton() {
        sendBtn.disabled = input.value.trim().length === 0 || isTyping;
    }

    function scrollToBottom() {
        feed.scrollTo({ top: feed.scrollHeight, behavior: 'smooth' });
    }

    function showStatus(type, message) {
        statusBox.className = `msg-send-status ${type}`;
        statusBox.textContent = message;
    }

    function hideStatus() {
        statusBox.className = 'msg-send-status';
        statusBox.textContent = '';
    }

    function addLocalUserMessage(text) {
        const conversation = getConversationById(activeConversationId);
        conversation.messages.push({
            sender: 'user',
            text,
            time: formatTime(now()),
        });
        conversation.lastMessage = text;
        conversation.lastTime = 'baru saja';
        conversation.unread = 0;
        renderConversationList();
        renderMessages(conversation);
    }

    function simulateBotReply() {
        const conversation = getConversationById(activeConversationId);
        const typingIndicator = document.getElementById('botTypingIndicator');
        if (typingIndicator) {
            typingIndicator.style.display = 'flex';
        }
        isTyping = true;
        updateSendButton();

        const replies = [
            'Terima kasih, saya sudah mencatat pertanyaan Anda. Silakan cek menu Events untuk detail lengkap.',
            'Untuk informasi lebih lanjut, Anda juga bisa mengakses halaman My Events dan Certificates.',
            'Tentu, kami akan membantu Anda. Jika perlu, Anda bisa menghubungi admin untuk konfirmasi lebih lanjut.',
            'Informasi terbaru akan muncul di halaman News dan Events. Pantau terus ya!',
        ];

        window.setTimeout(() => {
            const replyText = replies[Math.floor(Math.random() * replies.length)];
            conversation.messages.push({
                sender: activeConversationId === 'bot' ? 'bot' : 'admin',
                text: replyText,
                time: formatTime(now()),
            });
            conversation.lastMessage = replyText;
            conversation.lastTime = 'baru saja';
            if (typingIndicator) {
                typingIndicator.style.display = 'none';
            }
            isTyping = false;
            updateSendButton();
            renderConversationList();
            renderMessages(conversation);
        }, 1400);
    }

    function sendMessage() {
        const text = input.value.trim();
        if (!text || isTyping) return;

        isTyping = true;
        hideStatus();
        showStatus('loading', 'Mengirim pesan...');

        window.setTimeout(() => {
            const conversation = getConversationById(activeConversationId);
            const shouldFail = Math.random() < 0.12;

            if (shouldFail) {
                isTyping = false;
                showStatus('error', 'Pesan gagal dikirim. Silakan coba lagi.');
                updateSendButton();
                return;
            }

            addLocalUserMessage(text);
            input.value = '';
            input.style.height = 'auto';
            hideStatus();
            isTyping = false;
            updateSendButton();
            simulateBotReply();
        }, 550);
    }

    input.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        updateSendButton();
    });

    input.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
    });

    sendBtn.addEventListener('click', sendMessage);

    if (window.innerWidth <= 768) {
        window.openChat = function (element) {
            const conversationId = element.dataset.id || activeConversationId;
            openConversation(conversationId, true);
            layout.classList.add('chat-open');
        };
        window.closeChat = function () {
            layout.classList.remove('chat-open');
        };
    }

    renderConversationList();
    openConversation(activeConversationId, false);
    updateSendButton();
    setSystemNotification('Connected to EVENTTY Bot');
});
