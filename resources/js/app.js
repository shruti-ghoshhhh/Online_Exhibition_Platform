import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    initChatBot();
});

function initChatBot() {
    const container = document.getElementById('ai-chat-widget');
    if (!container) return;

    container.innerHTML = `
        <div id="chat-toggle" class="chat-toggle">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
        </div>
        <div id="chat-window" class="chat-window hidden">
            <div class="chat-header">
                <h4>Lumina AI Assistant</h4>
                <button id="chat-close">&times;</button>
            </div>
            <div id="chat-messages" class="chat-messages">
                <div class="message bot">Hello! I'm your exhibition assistant. Ask me about art history, navigation, or current exhibitions!</div>
            </div>
            <div class="chat-input-area">
                <input type="text" id="chat-input" placeholder="Type a message..." autocomplete="off">
                <button id="chat-send">Send</button>
            </div>
        </div>
    `;

    const toggle = document.getElementById('chat-toggle');
    const chatWindow = document.getElementById('chat-window');
    const close = document.getElementById('chat-close');
    const send = document.getElementById('chat-send');
    const input = document.getElementById('chat-input');
    const messages = document.getElementById('chat-messages');

    toggle.addEventListener('click', () => {
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            input.focus();
        }
    });

    close.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
    });

    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        // Add user message
        addMessage(text, 'user');
        input.value = '';

        // Add loading state
        const loadingId = 'loading-' + Date.now();
        addMessage('...', 'bot', loadingId);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/api/chatbot/ask', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message: text })
            });
            
            const data = await response.json();
            document.getElementById(loadingId).remove();
            
            if (response.ok && data.choices && data.choices.length > 0) {
                addMessage(data.choices[0].message.content, 'bot');
            } else {
                addMessage('Sorry, I am having trouble connecting to my servers right now.', 'bot');
            }
        } catch (error) {
            document.getElementById(loadingId).remove();
            addMessage('Error connecting to the AI assistant.', 'bot');
        }
    }

    send.addEventListener('click', sendMessage);
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    function addMessage(text, sender, id = null) {
        const msgDiv = document.createElement('div');
        msgDiv.className = 'message ' + sender;
        if (id) msgDiv.id = id;
        msgDiv.textContent = text;
        messages.appendChild(msgDiv);
        messages.scrollTop = messages.scrollHeight;
    }
}
