/**
 * NAS Chatbot — The Seatiger
 * Local AI chat widget with AJAX backend
 */

(function () {
    'use strict';

    const toggle      = document.getElementById('nasChatbotToggle');
    const window_el   = document.getElementById('nasChatbotWindow');
    const closeBtn    = document.getElementById('nasChatbotClose');
    const messages    = document.getElementById('nasChatMessages');
    const input       = document.getElementById('nasChatInput');
    const sendBtn     = document.getElementById('nasChatSend');
    const quickBtns   = document.getElementById('nasQuickBtns');
    const iconOpen    = document.querySelector('.nas-chatbot-icon-open');
    const iconClose   = document.querySelector('.nas-chatbot-icon-close');

    if (!toggle || !window_el) return;

    let isOpen = false;
    let history = [];
    let isTyping = false;

    // ============================================================
    // OPEN / CLOSE
    // ============================================================
    function openChat() {
        isOpen = true;
        window_el.style.display = 'flex';
        window_el.style.flexDirection = 'column';
        toggle.setAttribute('aria-expanded', 'true');
        if (iconOpen)  iconOpen.style.display  = 'none';
        if (iconClose) iconClose.style.display = 'flex';
        input?.focus();
        scrollToBottom();
    }

    function closeChat() {
        isOpen = false;
        window_el.style.display = 'none';
        toggle.setAttribute('aria-expanded', 'false');
        if (iconOpen)  iconOpen.style.display  = 'flex';
        if (iconClose) iconClose.style.display = 'none';
    }

    toggle.addEventListener('click', () => isOpen ? closeChat() : openChat());
    closeBtn?.addEventListener('click', closeChat);

    // Close on outside click
    document.addEventListener('click', (e) => {
        if (isOpen && !document.getElementById('nasChatbot').contains(e.target)) {
            closeChat();
        }
    });

    // ============================================================
    // QUICK BUTTONS
    // ============================================================
    document.querySelectorAll('.nas-quick-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const msg = btn.dataset.msg;
            if (msg) sendMessage(msg);
            if (quickBtns) quickBtns.style.display = 'none';
        });
    });

    // ============================================================
    // SEND MESSAGE
    // ============================================================
    function sendMessage(text) {
        text = (text || input?.value || '').trim();
        if (!text || isTyping) return;
        if (input) input.value = '';

        appendMessage(text, 'user');
        history.push({ role: 'user', content: text });

        showTyping();
        fetchReply(text);
    }

    sendBtn?.addEventListener('click', () => sendMessage());
    input?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // ============================================================
    // FETCH REPLY VIA AJAX
    // ============================================================
    async function fetchReply(userMsg) {
        isTyping = true;

        const formData = new FormData();
        formData.append('action',  'nas_chatbot');
        formData.append('nonce',   NAS.nonce);
        formData.append('message', userMsg);
        formData.append('history', JSON.stringify(history.slice(-10)));

        try {
            const res  = await fetch(NAS.ajaxUrl, { method: 'POST', body: formData });
            const json = await res.json();

            removeTyping();

            if (json.success && json.data.reply) {
                const reply = json.data.reply;
                history.push({ role: 'assistant', content: reply });
                appendMessage(reply, 'bot');
            } else {
                appendMessage("I'm having a moment of reflection. Please try again.", 'bot');
            }
        } catch (err) {
            removeTyping();
            appendMessage("The high seas are rough right now. Please check your connection and try again.", 'bot');
        } finally {
            isTyping = false;
        }
    }

    // ============================================================
    // DOM HELPERS
    // ============================================================
    function appendMessage(text, sender) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `nas-chatbot-msg nas-msg-${sender}`;

        const avatarDiv = document.createElement('div');
        avatarDiv.className = 'nas-chatbot-msg-avatar';

        if (sender === 'bot') {
            avatarDiv.innerHTML = `<img src="${NAS.themeUri}/assets/images/NAS_Skull_Crossed.png" width="18" height="18" alt="NAS icon" loading="lazy" decoding="async" style="width:18px;height:18px;object-fit:contain;vertical-align:middle;" />`;
        } else {
            avatarDiv.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#96050D" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>`;
        }

        const bubble = document.createElement('div');
        bubble.className = 'nas-chatbot-bubble';
        bubble.innerHTML = text; // Allow HTML in bot responses (links, bold, etc.)

        msgDiv.appendChild(avatarDiv);
        msgDiv.appendChild(bubble);

        // Animate in
        msgDiv.style.opacity = '0';
        msgDiv.style.transform = 'translateY(10px)';
        messages.appendChild(msgDiv);

        requestAnimationFrame(() => {
            msgDiv.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            msgDiv.style.opacity = '1';
            msgDiv.style.transform = 'translateY(0)';
        });

        scrollToBottom();
    }

    function showTyping() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'nas-chatbot-msg nas-msg-bot';
        typingDiv.id = 'nasTypingIndicator';

        const avatarDiv = document.createElement('div');
        avatarDiv.className = 'nas-chatbot-msg-avatar';
        avatarDiv.innerHTML = `<img src="${NAS.themeUri}/assets/images/NAS_Skull_Crossed.png" width="18" height="18" alt="NAS icon" loading="lazy" decoding="async" style="width:18px;height:18px;object-fit:contain;vertical-align:middle;" />`;

        const bubble = document.createElement('div');
        bubble.className = 'nas-chatbot-bubble nas-chatbot-typing';
        bubble.innerHTML = '<span></span><span></span><span></span>';

        typingDiv.appendChild(avatarDiv);
        typingDiv.appendChild(bubble);
        messages.appendChild(typingDiv);
        scrollToBottom();
    }

    function removeTyping() {
        document.getElementById('nasTypingIndicator')?.remove();
    }

    function scrollToBottom() {
        if (messages) {
            setTimeout(() => {
                messages.scrollTop = messages.scrollHeight;
            }, 50);
        }
    }

    // ============================================================
    // PULSATING RING — stop after user interaction
    // ============================================================
    let hasInteracted = false;
    toggle.addEventListener('click', () => {
        if (!hasInteracted) {
            hasInteracted = true;
            const pulse = toggle.querySelector('.nas-chatbot-pulse');
            if (pulse) pulse.style.animationIterationCount = '1';
        }
    });

})();
