document.addEventListener('DOMContentLoaded', function () {
    const chatInput = document.getElementById('admInput');
    const sendBtn = document.getElementById('admSendBtn');

    if (chatInput && sendBtn) {
        const adjustHeight = function () {
            chatInput.style.height = 'auto';
            chatInput.style.height = Math.min(chatInput.scrollHeight, 132) + 'px';
        };

        chatInput.addEventListener('input', adjustHeight);
        chatInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendBtn.click();
            }
        });

        sendBtn.addEventListener('click', function () {
            const text = chatInput.value.trim();
            if (!text) {
                return;
            }

            if (typeof window.insertReply === 'function') {
                window.insertReply(text);
            }

            chatInput.value = '';
            adjustHeight();
        });
    }
});
