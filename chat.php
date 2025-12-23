<?php
/**
 * AI Chat Interface - MashouraX Virtual Advising Platform
 * Gemini-style chat interface with study plans and solutions
 */

require_once 'includes/auth.php';

// Check if user is logged in
requireLogin();
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Academic Advisor - MashouraX</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Google Sans', 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8f9fa;
            color: #202124;
            height: 100vh;
            overflow: hidden;
        }

        .chat-page-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f8f9fa;
        }

        .chat-header {
            background: #fff;
            border-bottom: 1px solid #e8eaed;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 2px rgba(60,64,67,.3), 0 1px 3px 1px rgba(60,64,67,.15);
            z-index: 10;
        }

        .chat-header-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4285f4, #34a853);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            font-weight: 500;
        }

        .chat-header-info h1 {
            font-size: 22px;
            font-weight: 400;
            color: #202124;
            margin: 0;
            line-height: 1.2;
        }

        .chat-header-info p {
            font-size: 14px;
            color: #5f6368;
            margin: 2px 0 0 0;
        }

        .chat-main-container {
            flex: 1;
            display: flex;
            overflow: hidden;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .chat-messages-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #f8f9fa;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            scroll-behavior: smooth;
        }

        .chat-messages::-webkit-scrollbar {
            width: 8px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #dadce0;
            border-radius: 4px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #bdc1c6;
        }

        .message-container {
            display: flex;
            gap: 16px;
            max-width: 100%;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message-container.user {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 500;
            flex-shrink: 0;
            margin-top: 4px;
        }

        .message-avatar.user {
            background: #1a73e8;
            color: white;
        }

        .message-avatar.bot {
            background: linear-gradient(135deg, #4285f4, #34a853);
            color: white;
        }

        .message-content-wrapper {
            flex: 1;
            max-width: 75%;
            min-width: 0;
        }

        .message-content {
            padding: 12px 16px;
            border-radius: 20px;
            line-height: 1.5;
            font-size: 15px;
            word-wrap: break-word;
            white-space: pre-wrap;
        }

        .message-container.user .message-content {
            background: #1a73e8;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message-container.bot .message-content {
            background: #fff;
            color: #202124;
            border: 1px solid #e8eaed;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 2px rgba(60,64,67,.3), 0 1px 3px 1px rgba(60,64,67,.15);
        }

        .message-content p {
            margin: 0 0 12px 0;
        }

        .message-content p:last-child {
            margin-bottom: 0;
        }

        .message-content ul, .message-content ol {
            margin: 8px 0;
            padding-left: 24px;
        }

        .message-content li {
            margin: 4px 0;
        }

        .message-content strong {
            font-weight: 500;
            color: #202124;
        }

        .message-container.user .message-content strong {
            color: white;
        }

        .message-time {
            font-size: 11px;
            color: #5f6368;
            margin-top: 4px;
            padding-left: 4px;
        }

        .message-container.user .message-time {
            text-align: right;
            padding-right: 4px;
            padding-left: 0;
        }

        .chat-input-container {
            background: #fff;
            border-top: 1px solid #e8eaed;
            padding: 12px 24px 24px;
            box-shadow: 0 -1px 2px rgba(60,64,67,.3), 0 -1px 3px 1px rgba(60,64,67,.15);
        }

        .chat-input-wrapper {
            max-width: 100%;
            margin: 0 auto;
            position: relative;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            background: #fff;
            border: 1px solid #dadce0;
            border-radius: 24px;
            padding: 8px 16px;
            transition: all 0.2s;
        }

        .chat-input-wrapper:focus-within {
            border-color: #1a73e8;
            box-shadow: 0 1px 6px rgba(32,33,36,.28);
        }

        .chat-input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            color: #202124;
            font-size: 15px;
            font-family: inherit;
            resize: none;
            min-height: 24px;
            max-height: 200px;
            padding: 8px 0;
            line-height: 1.5;
        }

        .chat-input::placeholder {
            color: #9aa0a6;
        }

        .send-button {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a73e8;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .send-button:hover:not(:disabled) {
            background: #f1f3f4;
        }

        .send-button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .send-button svg {
            width: 20px;
            height: 20px;
        }

        .typing-indicator {
            display: none;
            padding: 12px 16px;
            background: #fff;
            border: 1px solid #e8eaed;
            border-radius: 20px;
            border-bottom-left-radius: 4px;
            width: fit-content;
            box-shadow: 0 1px 2px rgba(60,64,67,.3), 0 1px 3px 1px rgba(60,64,67,.15);
        }

        .typing-indicator.active {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background: #5f6368;
            border-radius: 50%;
            animation: typing 1.4s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.7; }
            30% { transform: translateY(-8px); opacity: 1; }
        }

        .empty-state {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px;
            color: #5f6368;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h2 {
            font-size: 22px;
            font-weight: 400;
            color: #202124;
            margin: 0 0 8px 0;
        }

        .empty-state p {
            font-size: 14px;
            color: #5f6368;
            margin: 0;
        }

        .sidebar {
            width: 320px;
            background: #fff;
            border-left: 1px solid #e8eaed;
            padding: 24px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .sidebar-section h3 {
            font-size: 14px;
            font-weight: 500;
            color: #202124;
            margin: 0 0 12px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quick-question {
            padding: 12px 16px;
            background: #f8f9fa;
            border: 1px solid #e8eaed;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            color: #202124;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quick-question:hover {
            background: #f1f3f4;
            border-color: #dadce0;
        }

        .quick-question-icon {
            font-size: 18px;
        }

        .clear-chat-btn {
            width: 100%;
            padding: 12px;
            background: #f8f9fa;
            border: 1px solid #e8eaed;
            border-radius: 12px;
            color: #ea4335;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 14px;
        }

        .clear-chat-btn:hover {
            background: #fce8e6;
            border-color: #ea4335;
        }

        @media (max-width: 968px) {
            .sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <?php require_once 'includes/navigation.php'; ?>

    <div class="chat-page-container">
        <div class="chat-header">
            <div class="chat-header-icon">G</div>
            <div class="chat-header-info">
                <h1>Gemini Academic Advisor</h1>
                <p>Your AI assistant for study plans and academic solutions</p>
            </div>
        </div>

        <div class="chat-main-container">
            <div class="chat-messages-area">
                <div class="chat-messages" id="chatMessages">
                    <div class="empty-state">
                        <div class="empty-state-icon">💬</div>
                        <h2>Start a conversation</h2>
                        <p>Ask me anything about your studies, and I'll provide detailed plans and solutions!</p>
                    </div>
                </div>

                <div class="typing-indicator" id="typingIndicator">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>

                <div class="chat-input-container">
                    <div class="chat-input-wrapper">
                        <textarea 
                            id="chatInput" 
                            class="chat-input" 
                            placeholder="Message Gemini..."
                            rows="1"
                        ></textarea>
                        <button class="send-button" id="sendButton" onclick="sendMessage()" title="Send">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <div class="sidebar-section">
                    <h3>Quick Questions</h3>
                    <div class="quick-question" onclick="sendQuickQuestion('Create a study plan for my upcoming exams')">
                        <span class="quick-question-icon">📚</span>
                        <span>Study Plan</span>
                    </div>
                    <div class="quick-question" onclick="sendQuickQuestion('How can I improve my GPA?')">
                        <span class="quick-question-icon">📊</span>
                        <span>Improve GPA</span>
                    </div>
                    <div class="quick-question" onclick="sendQuickQuestion('Help me prepare for my final exams')">
                        <span class="quick-question-icon">🎯</span>
                        <span>Exam Prep</span>
                    </div>
                    <div class="quick-question" onclick="sendQuickQuestion('Create a time management schedule')">
                        <span class="quick-question-icon">⏰</span>
                        <span>Time Management</span>
                    </div>
                </div>

                <div class="sidebar-section">
                    <h3>Chat Actions</h3>
                    <button class="clear-chat-btn" onclick="clearChat()">
                        🗑️ Clear Chat History
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_BASE = 'backend/api/index.php';
        let isLoading = false;

        window.addEventListener('DOMContentLoaded', () => {
            loadChatHistory();
            
            const chatInput = document.getElementById('chatInput');
            chatInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 200) + 'px';
            });

            chatInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        });

        async function loadChatHistory() {
            try {
                const response = await fetch(`${API_BASE}/chat/history?limit=50`, {
                    method: 'GET',
                    credentials: 'include'
                });

                const data = await response.json();

                if (data.success && data.data.history && data.data.history.length > 0) {
                    const messagesContainer = document.getElementById('chatMessages');
                    messagesContainer.innerHTML = '';
                    
                    data.data.history.forEach(msg => {
                        addMessageToChat(msg.message, msg.type === 'bot' ? 'bot' : 'user', msg.created_at);
                    });
                    
                    scrollToBottom();
                }
            } catch (error) {
                console.error('Error loading chat history:', error);
            }
        }

        async function sendMessage() {
            const chatInput = document.getElementById('chatInput');
            const message = chatInput.value.trim();

            if (!message || isLoading) return;

            chatInput.value = '';
            chatInput.style.height = 'auto';

            const emptyState = document.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            addMessageToChat(message, 'user');
            showTypingIndicator();

            isLoading = true;
            document.getElementById('sendButton').disabled = true;

            try {
                const response = await fetch(`${API_BASE}/chat/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    credentials: 'include',
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();

                hideTypingIndicator();

                if (data.success) {
                    addMessageToChat(data.data.response, 'bot', data.data.time);
                } else {
                    addMessageToChat('⚠️ ' + (data.message || 'Sorry, I encountered an error. Please try again.'), 'bot');
                    console.error('API Error:', data);
                }
            } catch (error) {
                hideTypingIndicator();
                addMessageToChat('⚠️ Sorry, I couldn\'t connect to the server. Please check your connection and try again.', 'bot');
                console.error('Error sending message:', error);
            } finally {
                isLoading = false;
                document.getElementById('sendButton').disabled = false;
            }
        }

        function sendQuickQuestion(question) {
            document.getElementById('chatInput').value = question;
            sendMessage();
        }

        function addMessageToChat(message, type, time = null) {
            const messagesContainer = document.getElementById('chatMessages');
            
            const emptyState = messagesContainer.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            const messageDiv = document.createElement('div');
            messageDiv.className = `message-container ${type}`;

            const avatar = document.createElement('div');
            avatar.className = `message-avatar ${type}`;
            avatar.textContent = type === 'user' ? 
                '<?php echo strtoupper(substr($user["first_name"], 0, 1)); ?>' : 'G';

            const contentWrapper = document.createElement('div');
            contentWrapper.className = 'message-content-wrapper';

            const contentDiv = document.createElement('div');
            contentDiv.className = 'message-content';
            
            // Convert markdown-style formatting to HTML
            let formattedMessage = message
                .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.+?)\*/g, '<em>$1</em>')
                .replace(/\n\n/g, '</p><p>')
                .replace(/\n/g, '<br>');
            
            // Wrap in paragraph if not already wrapped
            if (!formattedMessage.startsWith('<')) {
                formattedMessage = '<p>' + formattedMessage + '</p>';
            } else if (!formattedMessage.includes('<p>')) {
                formattedMessage = '<p>' + formattedMessage + '</p>';
            }
            
            contentDiv.innerHTML = formattedMessage;

            if (time) {
                const timeDiv = document.createElement('div');
                timeDiv.className = 'message-time';
                timeDiv.textContent = formatTime(time);
                contentWrapper.appendChild(timeDiv);
            }

            messageDiv.appendChild(avatar);
            contentWrapper.appendChild(contentDiv);
            messageDiv.appendChild(contentWrapper);
            messagesContainer.appendChild(messageDiv);

            scrollToBottom();
        }

        function showTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            indicator.classList.add('active');
            scrollToBottom();
        }

        function hideTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            indicator.classList.remove('active');
        }

        function scrollToBottom() {
            const messagesContainer = document.getElementById('chatMessages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function formatTime(timeString) {
            if (!timeString) return '';
            
            try {
                if (/^\d{1,2}:\d{2}$/.test(timeString)) {
                    return timeString;
                }
                
                const date = new Date(timeString);
                if (isNaN(date.getTime())) {
                    const timeMatch = timeString.match(/(\d{1,2}):(\d{2})/);
                    if (timeMatch) {
                        return timeMatch[0];
                    }
                    return 'Just now';
                }
                
                const now = new Date();
                const diffMs = now - date;
                const diffMins = Math.floor(diffMs / 60000);

                if (diffMins < 1) return 'Just now';
                if (diffMins < 60) return `${diffMins}m ago`;
                if (diffMins < 1440) return `${Math.floor(diffMins / 60)}h ago`;
                
                return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            } catch (e) {
                const timeMatch = timeString.match(/(\d{1,2}):(\d{2})/);
                return timeMatch ? timeMatch[0] : 'Just now';
            }
        }

        async function clearChat() {
            if (!confirm('Are you sure you want to clear all chat history?')) {
                return;
            }

            try {
                const response = await fetch(`${API_BASE}/chat/clear`, {
                    method: 'POST',
                    credentials: 'include'
                });

                const data = await response.json();

                if (data.success) {
                    const messagesContainer = document.getElementById('chatMessages');
                    messagesContainer.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-state-icon">💬</div>
                            <h2>Chat cleared</h2>
                            <p>Start a new conversation!</p>
                        </div>
                    `;
                } else {
                    alert('Failed to clear chat history');
                }
            } catch (error) {
                console.error('Error clearing chat:', error);
                alert('Error clearing chat history');
            }
        }
    </script>
</body>
</html>
