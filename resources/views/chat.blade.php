@extends('layouts.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-0">Chat with {{$targetUser->name}}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('error-log.index') }}">Error Logs</a></li>
                        <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Error Log Details</a></li>
                        <li class="breadcrumb-item active">Chat</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="chat-container">
            <div class="chat-header">
                <div class="user-info">
                    <div class="avatar">{{ substr($targetUser->name, 0, 1) }}</div>
                    <div class="user-details">
                        <h3>{{ $targetUser->name }}</h3>
                        <span class="status-indicator online">Online</span>
                    </div>
                </div>
                <div class="chat-actions">
                    <button class="btn-icon" title="Video call"><i class="bi bi-camera-video"></i></button>
                    <button class="btn-icon" title="Voice call"><i class="bi bi-telephone"></i></button>
                    <button class="btn-icon" title="More options"><i class="bi bi-three-dots-vertical"></i></button>
                </div>
            </div>

            <div id="chat-box" class="chat-messages">
                <!-- Messages will be appended here -->
            </div>

            <div id="typing-indicator" class="typing-indicator">
                <!-- Typing indicator will show here -->
            </div>

            <form id="chat-form" class="message-input-form">
                <button type="button" class="btn-attachment" title="Add attachment">
                    <i class="bi bi-paperclip"></i>
                </button>
                <input type="text" id="message" class="message-input" placeholder="Type your message…"
                    autocomplete="off" />
                <button type="button" class="btn-emoji" title="Add emoji">
                    <i class="bi bi-emoji-smile"></i>
                </button>
                <button type="submit" class="btn-send">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Container styling */
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 80vh;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Header styling */
        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background-color: #fff;
            color: #a777e3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .user-details h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .status-indicator {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .status-indicator.online::before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #2ecc71;
            border-radius: 50%;
        }

        .chat-actions {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }

        .btn-icon:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Message container */
        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f5f7fb;
            display: flex;
            flex-direction: column;
        }

        /* Message bubbles */
        .message {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            margin-bottom: 8px;
            position: relative;
            animation: fadeIn 0.3s ease-out;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.sent {
            align-self: flex-end;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .message.received {
            align-self: flex-start;
            background-color: #fff;
            color: #333;
            border-bottom-left-radius: 4px;
        }

        .message strong {
            display: block;
            font-size: 0.85rem;
            margin-bottom: 4px;
            opacity: 0.7;
        }

        .message .time {
            font-size: 0.7rem;
            opacity: 0.7;
            position: absolute;
            bottom: 8px;
            right: 12px;
        }

        /* Read receipt */
        .message.sent .read-receipt {
            position: absolute;
            bottom: 4px;
            right: 8px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.7rem;
        }

        /* Typing indicator */
        .typing-indicator {
            padding: 0 20px;
            height: 24px;
            font-size: 0.85rem;
            color: #888;
            display: flex;
            align-items: center;
        }

        /* Message input form */
        .message-input-form {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background-color: #fff;
            border-top: 1px solid #eee;
        }

        .message-input {
            flex: 1;
            border: none;
            background-color: #f0f2f5;
            border-radius: 20px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .message-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(110, 142, 251, 0.3);
        }

        .btn-attachment,
        .btn-emoji {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #6e8efb;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: background-color 0.2s;
        }

        .btn-attachment:hover,
        .btn-emoji:hover {
            background-color: #f0f2f5;
        }

        .btn-send {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-send:hover {
            transform: scale(1.05);
        }

        .btn-send:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Responsiveness */
        @media (max-width: 576px) {
            .chat-container {
                height: 100vh;
                border-radius: 0;
            }

            .chat-actions button:not(:last-child) {
                display: none;
            }

            .message {
                max-width: 85%;
            }
        }
    </style>
@endpush

@push('streamchat')
    <script>
        (async function() {
            // 1️⃣ wait for initialization
            for (let i = 0; i < 20; i++) {
                if (window.streamClient && window.streamData) break;
                await new Promise(r => setTimeout(r, 200));
            }
            const client = window.streamClient;
            const data = window.streamData;
            if (!client) return alert('Chat not ready—refresh please.');

            // 2️⃣ open channel
            const otherUserId = "{{ $targetUser->id }}";
            const currentUserId = data.user_id;
            const channelId = [currentUserId, otherUserId].sort().join('-');
            const channel = client.channel('messaging', `chat-${channelId}`, {
                members: [currentUserId, otherUserId]
            });
            await channel.watch();
            await channel.markRead();

            const box = document.getElementById('chat-box');
            const form = document.getElementById('chat-form');
            const input = document.getElementById('message');
            const typing = document.getElementById('typing-indicator');
            const sendButton = form.querySelector('.btn-send');

            // Update send button state
            input.addEventListener('input', () => {
                sendButton.disabled = input.value.trim() === '';
                if (input.value.trim() !== '') {
                    // Using startTyping instead of sendTyping for Stream API compatibility
                    try {
                        channel.keystroke(); // Most common method in Stream Chat
                    } catch (e) {
                        try {
                            channel.startTyping(); // Try alternative method
                        } catch (err) {
                            console.log('Typing indicator not supported');
                        }
                    }
                }
            });

            // Initially disable send button
            sendButton.disabled = true;

            // 3️⃣ typing indicator with animation
            try {
                channel.on('typing.start', (event) => {
                    if (event && event.user && event.user.id !== currentUserId) {
                        const userName = event.user.name || 'Someone';
                        typing.innerHTML = `
                            <div class="typing-dots">
                                <span class="typing-name">${userName}</span> is typing
                                <span class="dot">.</span>
                                <span class="dot">.</span>
                                <span class="dot">.</span>
                            </div>
                        `;
                        animateTypingDots();
                    }
                });
            } catch (e) {
                console.log('Typing events not supported');
            }

            function animateTypingDots() {
                const dots = document.querySelectorAll('.typing-dots .dot');
                if (!dots.length) return;

                let i = 0;
                const interval = setInterval(() => {
                    dots.forEach(dot => dot.style.opacity = '0.3');
                    dots[i].style.opacity = '1';
                    i = (i + 1) % dots.length;

                    if (!document.querySelector('.typing-dots')) {
                        clearInterval(interval);
                    }
                }, 400);
            }

            try {
                channel.on('typing.stop', (event) => {
                    if (event && event.user && event.user.id !== currentUserId) {
                        typing.textContent = '';
                    }
                });
            } catch (e) {
                console.log('Typing stop events not supported');
            }

            // 4️⃣ render existing & realtime messages
            if (!channel.state.messages || channel.state.messages.length === 0) {
                // Show welcome message if no messages exist
                const welcomeDiv = document.createElement('div');
                welcomeDiv.className = 'welcome-message';

                // Safely determine target name
                let targetName = 'this user';
                try {
                    targetName = $targetUser && $targetUser.name ? $targetUser.name : 'this user';
                } catch (e) {
                    console.log('Using default target name');
                }

                welcomeDiv.innerHTML = `
                    <div class="welcome-icon">👋</div>
                    <h4>Start chatting with ${targetName}!</h4>
                    <p>Send your first message to begin the conversation.</p>
                `;
                box.appendChild(welcomeDiv);
            } else {
                try {
                    channel.state.messages
                        .sort((a, b) => new Date(a.created_at) - new Date(b.created_at))
                        .forEach(m => {
                            if (m) renderMessage(m);
                        });
                } catch (e) {
                    console.error('Error rendering messages:', e);
                }
            }

            channel.on('message.new', (event) => {
                try {
                    const message = event && event.message ? event.message : null;
                    if (!message) return;

                    // Remove welcome message if it exists
                    const welcomeMsg = box.querySelector('.welcome-message');
                    if (welcomeMsg) welcomeMsg.remove();

                    renderMessage(message);

                    // Play sound for received messages
                    if (message.user && message.user.id !== currentUserId) {
                        playMessageSound('received');
                    }

                    // Mark channel as read when receiving new messages
                    if (document.hasFocus()) {
                        try {
                            channel.markRead();
                        } catch (e) {
                            console.log('Error marking as read:', e);
                        }
                    }
                } catch (e) {
                    console.error('Error handling new message:', e);
                }
            });

            // 5️⃣ send message with improved handling
            form.addEventListener('submit', async e => {
                e.preventDefault();
                const text = input.value.trim();
                if (!text) return;

                // Optimistically add message
                const tempId = 'temp-' + Date.now();

                // Safely determine user name with fallbacks
                let userName = 'You';
                try {
                    if (data && data.current_user && data.current_user.name) {
                        userName = data.current_user.name;
                    }
                } catch (e) {
                    console.log('Using default name for message');
                }

                const tempMsg = {
                    id: tempId,
                    text: text,
                    user: {
                        id: currentUserId,
                        name: userName
                    },
                    created_at: new Date().toISOString(),
                    _isTemp: true
                };
                renderMessage(tempMsg);

                // Reset input
                input.value = '';
                sendButton.disabled = true;

                try {
                    // Send actual message
                    await channel.sendMessage({
                        text
                    });

                    // Remove temporary message once real one arrives
                    const tempEl = document.getElementById(`msg-${tempId}`);
                    if (tempEl) tempEl.remove();

                    // Mark as read
                    await channel.markRead();

                    // Play sent sound
                    playMessageSound('sent');
                } catch (err) {
                    console.error('Error sending message:', err);
                    alert('Failed to send message. Please try again.');

                    // Mark temp message as failed
                    const tempEl = document.getElementById(`msg-${tempId}`);
                    if (tempEl) {
                        tempEl.classList.add('failed');
                        tempEl.innerHTML += '<div class="error-badge">Failed to send</div>';
                    }
                }
            });

            // 6️⃣ enhanced message rendering
            function renderMessage(message) {
                if (!message || !message.user) {
                    console.error("Invalid message object:", message);
                    return;
                }

                const msgId = message.id || message._id || `fallback-${Date.now()}`;
                const div = document.createElement('div');
                div.id = `msg-${msgId}`;

                const isMe = message.user.id === currentUserId;
                div.className = `message ${isMe ? 'sent' : 'received'}`;

                // Format timestamp
                const timestamp = new Date(message.created_at);
                const timeStr = timestamp.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Create message content
                div.innerHTML = `
                    <div>
                        <strong>${message.user.name || (isMe ? 'You' : 'User')}</strong>
                        <div class="pb-2">
                        <span class="message-text">${escapeHtml(message.text)}</span>
                        <span class="time">${timeStr}</span>
                        </div>
                    </div>
                `;

                // Add read receipt if message is from current user
                if (isMe && !message._isTemp) {
                    const readInfo = channel.state.read[otherUserId];
                    if (readInfo && new Date(readInfo.last_read) >= new Date(message.created_at)) {
                        const tick = document.createElement('span');
                        tick.className = 'read-receipt';
                        tick.innerHTML = '<i class="bi bi-check2-all"></i>';
                        div.appendChild(tick);
                    } else {
                        const tick = document.createElement('span');
                        tick.className = 'read-receipt';
                        tick.innerHTML = '<i class="bi bi-check2"></i>';
                        div.appendChild(tick);
                    }
                }

                // Group messages by the same user
                const lastMsg = box.lastElementChild;
                if (lastMsg && lastMsg.classList.contains('message')) {
                    const lastMsgUserEl = lastMsg.querySelector('strong');
                    if (lastMsgUserEl) {
                        const lastMsgUser = lastMsgUserEl.textContent;
                        const currMsgUser = message.user.name || (isMe ? 'You' : 'User');

                        if (lastMsgUser === currMsgUser) {
                            const lastMsgDir = lastMsg.classList.contains('sent') ? 'sent' : 'received';
                            const currMsgDir = isMe ? 'sent' : 'received';

                            if (lastMsgDir === currMsgDir) {
                                lastMsg.classList.add('grouped');
                                div.classList.add('grouped-end');
                            }
                        }
                    }
                }

                box.appendChild(div);
                box.scrollTop = box.scrollHeight;

                // Update read receipts of previous messages
                if (!isMe) {
                    updateReadReceipts();
                }
            }

            // 7️⃣ Improved read receipt handling
            function updateReadReceipts() {
                if (document.hasFocus()) {
                    channel.markRead().then(() => {
                        // Update all sent messages with read receipts
                        document.querySelectorAll('.message.sent').forEach(msg => {
                            const existingReceipt = msg.querySelector('.read-receipt');
                            if (existingReceipt) {
                                existingReceipt.innerHTML = '<i class="bi bi-check2-all"></i>';
                            } else {
                                const tick = document.createElement('span');
                                tick.className = 'read-receipt';
                                tick.innerHTML = '<i class="bi bi-check2-all"></i>';
                                msg.appendChild(tick);
                            }
                        });
                    });
                }
            }

            // 8️⃣ Handle read receipts for window focus
            window.addEventListener('focus', updateReadReceipts);

            // 9️⃣ Play sound effects
            function playMessageSound(type) {
                // Skip sound playback if sounds directory isn't set up yet
                if (!window.CHAT_SOUNDS_ENABLED) {
                    return;
                }

                // Create audio element
                const audio = new Audio();
                audio.volume = 0.5;

                // Different sounds for sent/received messages
                if (type === 'sent') {
                    audio.src = '/sounds/message-sent.mp3';
                } else {
                    audio.src = '/sounds/message-received.mp3';
                }

                // Try to play (may fail due to browser autoplay policies or missing file)
                audio.play().catch(e => {
                    console.log('Sound not played:', e);

                    // If this is the first failure, disable sounds to prevent console spam
                    if (!window.SOUND_ERROR_LOGGED) {
                        window.SOUND_ERROR_LOGGED = true;
                        window.CHAT_SOUNDS_ENABLED = false;
                        console.log('Sound playback disabled - files might be missing');
                    }
                });
            }

            // Check if sounds directory exists by preloading a test
            (function checkSoundsAvailability() {
                window.CHAT_SOUNDS_ENABLED = true; // Default to enabled

                // Try to preload sound
                const testAudio = new Audio('/sounds/message-sent.mp3');
                testAudio.addEventListener('error', () => {
                    window.CHAT_SOUNDS_ENABLED = false;
                    console.log('Chat sounds disabled - files not found at /sounds/');
                });

                // If load doesn't fail quickly, assume it works
                setTimeout(() => {
                    if (testAudio.error) {
                        window.CHAT_SOUNDS_ENABLED = false;
                    }
                }, 500);
            })();

            // 🔟 Utilities
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Add these additional style rules
            const additionalStyles = document.createElement('style');
            additionalStyles.textContent = `
                .welcome-message {
                    text-align: center;
                    padding: 30px 20px;
                    margin: auto;
                }
                
                .welcome-icon {
                    font-size: 3rem;
                    margin-bottom: 10px;
                    animation: bounce 1s infinite alternate;
                }
                
                @keyframes bounce {
                    from { transform: translateY(0); }
                    to { transform: translateY(-10px); }
                }
                
                .welcome-message h4 {
                    margin: 10px 0;
                    color: #555;
                }
                
                .welcome-message p {
                    color: #888;
                    font-size: 0.9rem;
                }
                
                .message.grouped {
                    margin-bottom: 2px;
                    border-bottom-left-radius: 18px;
                    border-bottom-right-radius: 18px;
                }
                
                .message.grouped-end {
                    margin-top: 2px;
                    border-top-left-radius: 18px;
                    border-top-right-radius: 18px;
                }
                
                .message.grouped strong,
                .message.grouped .time {
                    display: none;
                }
                
                .message.failed {
                    opacity: 0.7;
                }
                
                .error-badge {
                    background: #ff5252;
                    color: white;
                    font-size: 0.7rem;
                    padding: 2px 6px;
                    border-radius: 10px;
                    margin-top: 5px;
                    display: inline-block;
                }
                
                .typing-dots .dot {
                    opacity: 0.3;
                    transition: opacity 0.2s;
                }
            `;
            document.head.appendChild(additionalStyles);
        })();
    </script>
@endpush
