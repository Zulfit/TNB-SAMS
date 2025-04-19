@extends('layouts.layout')

@section('content')
    <main id="main" class="main">
        <h3 class="card-title">Chat with {{ $targetUser->name }}</h3>

        <div id="chat-box"
            style="border:1px solid #ccc; padding:10px; height:400px; overflow-y:auto; display:flex; flex-direction:column;">
            {{-- messages get appended here --}}
        </div>

        <div id="typing-indicator" class="text-muted small ps-2" style="height:1.5em;"></div>

        <form id="chat-form" class="mt-3 d-flex">
            <input type="text" id="message" class="form-control me-2" placeholder="Type your message…"
                autocomplete="off" />
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </main>
@endsection

@push('styles')
    <style>
        /* Message bubbles */
        .message.sent {
            align-self: flex-end;
            background: #007bff;
            color: #fff;
        }

        .message.received {
            align-self: flex-start;
            background: #e1e1e1;
            color: #000;
        }

        .message {
            max-width: 70%;
            padding: 8px;
            border-radius: 10px;
            margin-bottom: 5px;
            position: relative;
        }

        /* Read receipt tick */
        .message.sent .read-receipt {
            font-size: 0.8em;
            position: absolute;
            bottom: 2px;
            right: 4px;
            color: #aaf;
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

            // 3️⃣ typing indicator
            channel.on('typing.start', ({
                user
            }) => {
                if (user.id !== currentUserId) {
                    typing.textContent = `${user.name} is typing…`;
                }
            });
            channel.on('typing.stop', ({
                user
            }) => {
                if (user.id !== currentUserId) {
                    typing.textContent = '';
                }
            });
            input.addEventListener('input', () => channel.sendTyping());

            // 4️⃣ render existing & realtime
            channel.state.messages
                .sort((a, b) => new Date(a.created_at) - new Date(b.created_at))
                .forEach(m => renderMessage(m));

            channel.on('message.new', ({
                message
            }) => {
                renderMessage(message);
            });

            // 5️⃣ send message
            form.addEventListener('submit', async e => {
                e.preventDefault();
                const text = input.value.trim();
                if (!text) return;
                await channel.sendMessage({
                    text
                });
                input.value = '';
                await channel.markRead(); // mark our own sends as read
            });

            // 6️⃣ render + read receipt
            function renderMessage(message) {
                const div = document.createElement('div');
                const isMe = message.user.id === currentUserId;
                div.className = `message ${isMe?'sent':'received'}`;
                div.innerHTML = `<strong>${message.user.name}</strong><br>${message.text}`;

                if (isMe) {
                    // check if other user has read this message
                    const readInfo = channel.state.read[otherUserId];
                    if (readInfo && new Date(readInfo.last_read) >= new Date(message.created_at)) {
                        const tick = document.createElement('span');
                        tick.className = 'read-receipt';
                        tick.textContent = '✓';
                        div.appendChild(tick);
                    }
                }

                box.appendChild(div);
                box.scrollTop = box.scrollHeight;
            }
        })();
    </script>
@endpush
