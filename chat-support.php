<?php
session_start();

// Initialize chat history
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [
        ['type' => 'bot', 'message' => 'Hello! Welcome to MashouraX support. How can I help you today?', 'time' => date('H:i')]
    ];
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'send_message') {
        $userMessage = trim($_POST['message'] ?? '');
        
        if (!empty($userMessage)) {
            $_SESSION['chat_history'][] = ['type' => 'user', 'message' => htmlspecialchars($userMessage), 'time' => date('H:i')];
            
            $botResponse = getBotResponse($userMessage);
            $_SESSION['chat_history'][] = ['type' => 'bot', 'message' => $botResponse, 'time' => date('H:i')];
            
            echo json_encode(['success' => true, 'response' => $botResponse, 'time' => date('H:i')]);
        }
        exit;
    }
    
    if ($_POST['action'] === 'clear_history') {
        $_SESSION['chat_history'] = [['type' => 'bot', 'message' => 'Chat cleared. How can I help you?', 'time' => date('H:i')]];
        echo json_encode(['success' => true]);
        exit;
    }
}

function getBotResponse($message) {
    $lowerMsg = strtolower($message);
    
    if (strpos($lowerMsg, 'account') !== false || strpos($lowerMsg, 'login') !== false) {
        return "I can help you with account issues! Could you please specify what problem you're experiencing? For immediate assistance, you can reset your password using the 'Forgot Password' link.";
    }
    
    if (strpos($lowerMsg, 'pricing') !== false || strpos($lowerMsg, 'plan') !== false || strpos($lowerMsg, 'cost') !== false) {
        return "We offer three plans:<br><br><strong>Basic:</strong> EGP 2,999/month - Up to 500 students<br><strong>Professional:</strong> EGP 5,999/month - Up to 2,000 students<br><strong>Enterprise:</strong> EGP 12,999/month - Unlimited students<br><br>All include a 30-day free trial!";
    }
    
    if (strpos($lowerMsg, 'integrate') !== false || strpos($lowerMsg, 'setup') !== false || strpos($lowerMsg, 'technical') !== false) {
        return "Our technical team can help with integration! We support SIS, LMS, and various administrative systems. Would you like me to connect you with a technical specialist?";
    }
    
    if (strpos($lowerMsg, 'demo') !== false) {
        return "Great! I'd be happy to schedule a demo. You can book a time slot at our demo page, or have our sales team contact you directly. Which would you prefer?";
    }
    
    if (strpos($lowerMsg, 'ai') !== false || strpos($lowerMsg, 'features') !== false) {
        return "MashouraX uses advanced AI with:<br><br>✓ 850+ Vetted Questions<br>✓ Instant Chat Support<br>✓ Smart Analytics<br>✓ Degree Planning<br>✓ 24/7 Availability<br><br>Would you like details on any specific feature?";
    }
    
    if (strpos($lowerMsg, 'contact') !== false || strpos($lowerMsg, 'email') !== false || strpos($lowerMsg, 'phone') !== false) {
        return "You can reach us at:<br><br>📧 support@mashourax.com<br>📞 +20 (012) 707 23373<br>💬 Chat: Right here!<br><br>Our support team is available 24/7.";
    }
    
    if (strpos($lowerMsg, 'hello') !== false || strpos($lowerMsg, 'hi') !== false || strpos($lowerMsg, 'hey') !== false) {
        return "Hello! 👋 Welcome to MashouraX. I'm here to help answer your questions about our AI-powered virtual advising platform. What would you like to know?";
    }
    
    if (strpos($lowerMsg, 'thank') !== false) {
        return "You're welcome! 😊 Is there anything else I can help you with today?";
    }
    
    return "Thank you for your message! I'm here to help. You can ask me about pricing, features, technical support, or schedule a demo. What would you like to know?";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MashouraX - 24/7 Chat Support</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .chat-section {
            position: relative;
            padding: 180px 5% 8rem;
            z-index: 1;
            min-height: 100vh;
        }

        .chat-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
            height: 700px;
        }

        .chat-sidebar {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 20px;
            padding: 1.5rem;
            overflow-y: auto;
        }

        .sidebar-header {
            font-size: 1.2rem;
            font-weight: 700;
            color: #DAA520;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(218, 165, 32, 0.2);
        }

        .quick-action {
            padding: 1rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(218, 165, 32, 0.1);
            border-radius: 10px;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quick-action:hover {
            background: rgba(218, 165, 32, 0.1);
            border-color: #DAA520;
            transform: translateX(5px);
        }

        .quick-action h4 {
            font-size: 0.95rem;
            color: #fff;
            margin-bottom: 0.3rem;
        }

        .quick-action p {
            font-size: 0.8rem;
            color: #999;
        }

        .chat-main {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 165, 32, 0.15);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(218, 165, 32, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .agent-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .agent-info h3 {
            font-size: 1.1rem;
            color: #fff;
            margin-bottom: 0.2rem;
        }

        .agent-info p {
            font-size: 0.85rem;
            color: #DAA520;
        }

        .clear-chat-btn {
            padding: 0.5rem 1rem;
            background: rgba(255, 0, 0, 0.1);
            color: #ff6b6b;
            border: 1px solid rgba(255, 0, 0, 0.3);
            border-radius: 8px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .clear-chat-btn:hover {
            background: rgba(255, 0, 0, 0.2);
            border-color: #ff6b6b;
        }

        .chat-messages {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .message {
            display: flex;
            gap: 1rem;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .message.user .message-avatar {
            background: rgba(255, 255, 255, 0.1);
        }

        .message-content {
            max-width: 70%;
        }

        .message-bubble {
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 15px;
            color: #fff;
            line-height: 1.6;
        }

        .message.user .message-bubble {
            background: linear-gradient(135deg, rgba(218, 165, 32, 0.2), rgba(218, 165, 32, 0.1));
            border-color: #DAA520;
        }

        .message-time {
            font-size: 0.75rem;
            color: #666;
            margin-top: 0.5rem;
            padding: 0 0.5rem;
        }

        .typing-indicator {
            display: none;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 15px;
            width: fit-content;
        }

        .typing-indicator.active {
            display: flex;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background: #DAA520;
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
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-10px);
            }
        }

        .chat-input-container {
            padding: 1.5rem;
            border-top: 1px solid rgba(218, 165, 32, 0.2);
            display: flex;
            gap: 1rem;
        }

        .chat-input {
            flex: 1;
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(218, 165, 32, 0.2);
            border-radius: 50px;
            color: #fff;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .chat-input:focus {
            border-color: #DAA520;
            background: rgba(255, 255, 255, 0.08);
        }

        .send-btn {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #DAA520, #FFD700);
            border: none;
            border-radius: 50%;
            color: #000;
            font-size: 1.3rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .send-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(218, 165, 32, 0.4);
        }

        .send-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        @media (max-width: 1024px) {
            .chat-container {
                grid-template-columns: 1fr;
                height: auto;
            }

            .chat-sidebar {
                height: auto;
            }

            .chat-main {
                height: 600px;
            }
        }

        @media (max-width: 768px) {
            .message-content {
                max-width: 85%;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>
    
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-left">
            <div class="top-bar-item">
                <span>📧</span> support@mashourax.com
            </div>
            <div class="top-bar-item">
                <span>📞</span> +20 (012) 707 23373
            </div>
        </div>
        <div class="top-bar-right">
            <a href="about.html" class="top-bar-link">About</a>
            <a href="#" class="top-bar-link">Blog</a>
            <a href="#" class="top-bar-link">Careers</a>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav>
        <div class="logo"><a href="index.html">MashouraX</a></div>
        <ul class="nav-center">
            <li class="nav-item">
                <a href="#solutions">Solutions ▾</a>
                <div class="dropdown">
                    <a href="solutions-virtual-advising.html">Virtual Advising</a>
                    <a href="solutions-student-success.html">Student Success</a>
                    <a href="solutions-academic-planning.html">Academic Planning</a>
                    <a href="solutions-career-services.html">Career Services</a>
                </div>
            </li>
           
            <li class="nav-item">
                <a href="#features">Features ▾</a>
                <div class="dropdown">
                    <a href="ai-features.html">AI-Powered Support</a>
                    <a href="analytics-dashboard.html">Analytics Dashboard</a>
                    <a href="chat-support.php">24/7 Chat Support</a>
                    <a href="mobile.html">Mobile App</a>
                </div>
           
            </li> 
            <li class="nav-item">
                <a href="#resources">Resources ▾</a>
                <div class="dropdown">
                    <a href="case-studies.html">Case Studies</a>
                    <a href="documentation.html">Documentation</a>
                    <a href="webinars.html">Webinars</a>
                    <a href="help-center.html">Help Center</a>
                </div>
            </li>
            
           
            <li class="nav-item">
                <a href="#pricing">Pricing</a>
            </li>
            <li class="nav-item">
                <a href="#security">Security</a>
            </li>
        </ul>
        <div class="nav-right">
            <button class="search-btn">🔍 Search</button>
            <button class="login-btn" onclick="window.location.href='login.html'">Login</button>
            <button class="demo-btn" onclick="window.location.href='demo.html'">Request Demo</button>
        </div>
    </nav>

    <!-- Chat Section -->
    <section class="chat-section">
        <div style="text-align: center; margin-bottom: 3rem;">
            <div class="hero-badge" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.5rem; background: rgba(218, 165, 32, 0.1); border: 1px solid rgba(218, 165, 32, 0.3); border-radius: 50px; color: #DAA520; font-size: 0.85rem; margin-bottom: 1.5rem; font-weight: 600;">
                <span>💬</span> PHP-Powered AI Support
            </div>
            <h1 style="font-size: 3.5rem; font-weight: 900; margin-bottom: 1rem; color: #fff;">How Can We Help You?</h1>
            <p style="font-size: 1.15rem; color: #aaa; max-width: 700px; margin: 0 auto;">Chat with our AI-powered support system. Your conversation is saved and processed server-side with PHP.</p>
        </div>

        <div class="chat-container">
            <div class="chat-sidebar">
                <div class="sidebar-header">Quick Actions</div>
                <div class="quick-action" onclick="sendQuickMessage('I need help with my account')">
                    <h4>👤 Account Help</h4>
                    <p>Issues with login or settings</p>
                </div>
                <div class="quick-action" onclick="sendQuickMessage('Tell me about pricing plans')">
                    <h4>💰 Pricing Info</h4>
                    <p>Plans and billing questions</p>
                </div>
                <div class="quick-action" onclick="sendQuickMessage('How do I integrate MashouraX?')">
                    <h4>🔧 Technical Support</h4>
                    <p>Integration and setup help</p>
                </div>
                <div class="quick-action" onclick="sendQuickMessage('I want to schedule a demo')">
                    <h4>📅 Schedule Demo</h4>
                    <p>Book a live demonstration</p>
                </div>
                <div class="quick-action" onclick="sendQuickMessage('Tell me about AI features')">
                    <h4>🤖 AI Features</h4>
                    <p>Learn about our AI capabilities</p>
                </div>
            </div>

            <div class="chat-main">
                <div class="chat-header">
                    <div class="chat-header-left">
                        <div class="agent-avatar">🤖</div>
                        <div class="agent-info">
                            <h3>PHP AI Assistant</h3>
                            <p>● Online - Powered by PHP Backend</p>
                        </div>
                    </div>
                    <button class="clear-chat-btn" onclick="clearChat()">🗑️ Clear Chat</button>
                </div>

                <div class="chat-messages" id="chatMessages">
                    <?php foreach ($_SESSION['chat_history'] as $msg): ?>
                        <div class="message <?php echo $msg['type'] === 'user' ? 'user' : ''; ?>">
                            <div class="message-avatar"><?php echo $msg['type'] === 'user' ? '👤' : '🤖'; ?></div>
                            <div class="message-content">
                                <div class="message-bubble"><?php echo $msg['message']; ?></div>
                                <div class="message-time"><?php echo $msg['time']; ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="chat-input-container">
                    <input 
                        type="text" 
                        class="chat-input" 
                        id="chatInput"
                        placeholder="Type your message..."
                        onkeypress="handleKeyPress(event)"
                    >
                    <button class="send-btn" id="sendBtn" onclick="sendMessage()">➤</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <h3>MashouraX</h3>
                <p>Empowering institutions with AI-powered virtual advising to transform student success and drive better outcomes.</p>
                <div class="social-links">
                    <a href="#" class="social-link">𝕏</a>
                    <a href="#" class="social-link">in</a>
                    <a href="#" class="social-link">f</a>
                    <a href="#" class="social-link">▶</a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Solutions</h4>
                <ul class="footer-links">
                    <li><a href="solutions-virtual-advising.php">Virtual Advising</a></li>
                    <li><a href="solutions-student-success.php">Student Success</a></li>
                    <li><a href="solutions-academic-planning.php">Academic Planning</a></li>
                    <li><a href="solutions-career-services.php">Career Services</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <ul class="footer-links">
                    <li><a href="documentation.php">Documentation</a></li>
                    <li><a href="case-studies.php">Case Studies</a></li>
                    <li><a href="webinars.php">Webinars</a></li>
                    <li><a href="help-center.php">Help Center</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul class="footer-links">
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="solutions-career-services.php">Careers</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 MashouraX. All rights reserved. Built with excellence for student success.</p>
        </div>
    </footer>

    <script>
        function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            
            if (message) {
                input.value = '';
                document.getElementById('sendBtn').disabled = true;
                
                fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=send_message&message=' + encodeURIComponent(message)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    document.getElementById('sendBtn').disabled = false;
                });
            }
        }

        function sendQuickMessage(message) {
            document.getElementById('chatInput').value = message;
            sendMessage();
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function clearChat() {
            if (confirm('Are you sure you want to clear the chat history?')) {
                fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=clear_history'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }

        // Auto scroll to bottom
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    </script>
</body>
</html>