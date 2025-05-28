<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>TNB-SAMS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="/assets/img/sams-logo.png" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            margin-left: 85px;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body>

    <script type="module">
        import {
            StreamChat
        } from 'https://cdn.skypack.dev/stream-chat';
        window.StreamChat = StreamChat;
    </script>

    @include('layouts.header')

    <!-- Navbar -->
    @include('layouts.navbar')

    @if (session('success'))
        <div id="flashMessage" class="alert alert-success slide-in-top-right shadow" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="container mt-4">
        @yield('content')
    </div> <!-- Close container properly -->

    <!-- Single Toast Notification Block -->
    <div id="alert-toast" class="toast" style="display: none;">
        <div class="toast-card">
            <div id="toast-icon">⚠️</div>
            <div id="toast-message"></div>
            <div class="toast-buttons">
                <button class="toast-btn primary" onclick="handleTakeAction()">Take Action</button>
                <button class="toast-btn secondary" onclick="dismissToast()">Close</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    @vite(['resources/js/app.js'])

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', async function() {
                const StreamChat = window.StreamChat;
                if (!StreamChat) {
                    return console.error('❌ StreamChat was never registered');
                }

                // Fetch a token & user data
                let data;
                try {
                    const res = await fetch('/chat/token/header');
                    data = await res.json();
                    if (data.error) throw new Error(data.error);
                } catch (err) {
                    return console.error('❌ Failed to load Stream token:', err);
                }

                // Connect the client
                let client;
                try {
                    client = StreamChat.getInstance(data.api_key);
                    if (!client.userID) {
                        await client.connectUser({
                            id: data.user_id,
                            name: data.user_name
                        }, data.token);
                    }
                } catch (err) {
                    return console.error('❌ StreamChat.connectUser failed:', err);
                }

                // Expose globally
                window.streamClient = client;
                window.streamData = data;
                console.log('✅ Stream client initialized');

                // Populate header dropdown
                try {
                    const channels = await client.queryChannels({
                        members: {
                            $in: [data.user_id]
                        }
                    });

                    let unreadCount = 0;
                    const list = document.getElementById('message-list');
                    const badge = document.getElementById('message-count');
                    const header = document.getElementById('dropdown-header');

                    channels.forEach(ch => {
                        const c = ch.countUnread();
                        unreadCount += c;
                        if (c > 0) {
                            const lm = ch.state.messages.at(-1);
                            const other = Object.keys(ch.state.members).find(id => id !== data.user_id);
                            const li = document.createElement('li');
                            li.className = 'message-item';
                            li.innerHTML = `
                        <a href="/chat/user/${other}" class="d-flex align-items-start text-dark px-2 py-2" title="${lm.text}">
                            <img src="/assets/img/default-avatar.png" class="rounded-circle me-2" width="40" height="40" />
                            <div>
                                <h6 class="mb-0">${lm.user.name}</h6>
                                <small class="text-muted">${lm.text.slice(0, 40)}…</small><br>
                                <small class="text-muted">Unread</small>
                            </div>
                        </a>`;
                            list.insertBefore(li, list.querySelector('.dropdown-footer'));
                        }
                    });

                    badge.textContent = unreadCount;
                    header.innerHTML = `You have ${unreadCount} new message${unreadCount === 1 ? '' : 's'} 
                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>`;
                } catch (err) {
                    console.error('❌ Error querying channels:', err);
                }

                // Auto reload if new messages arrive every 10 seconds
                setInterval(async function() {
                    try {
                        const channels = await client.queryChannels({
                            members: {
                                $in: [data.user_id]
                            }
                        });

                        let unread = 0;
                        channels.forEach(ch => {
                            unread += ch.countUnread();
                        });

                        if (unread > 0) {
                            console.log("🔄 New messages detected! Reloading...");
                            location.reload();
                        } else {
                            console.log("✅ No new messages.");
                        }
                    } catch (err) {
                        console.error('🔴 Error checking for new messages:', err);
                    }
                }, 10000); // every 10s
            });
        </script>
    @endauth

    <!-- Session Alert Toast -->
    @if (session('alert'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const alertData = @json(session('alert'));
                showToast(alertData.type, alertData.sensorName, alertData.sensorId);
                fetch('/clear-toast', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
            });
        </script>
    @endif

    <!-- Toast Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.showToast = function(type, sensorName, sensorId) {
                const toastEl = document.getElementById('alert-toast');
                const toastCard = toastEl.querySelector('.toast-card');
                const toastIcon = document.getElementById('toast-icon');
                const toastMessage = document.getElementById('toast-message');
                const primaryButton = toastEl.querySelector('.toast-btn.primary');

                let levelText = '',
                    color = '';
                if (type === 'warn') {
                    levelText = 'Warning';
                    color = 'orange';
                    toastCard.classList.remove('toast-critical');
                    primaryButton.classList.remove('critical');
                } else if (type === 'critical') {
                    levelText = 'Critical';
                    color = 'red';
                    toastCard.classList.add('toast-critical');
                    primaryButton.classList.add('critical');
                } else {
                    levelText = 'Notice';
                    color = 'gray';
                    toastCard.classList.remove('toast-critical');
                    primaryButton.classList.remove('critical');
                }

                toastIcon.textContent = '⚠️';
                toastMessage.innerHTML = `
                    <strong style="color: ${color};">${levelText}:</strong> 
                    Temperature variance in <strong>${sensorName}</strong> 
                    (Sensor ID: <strong>${sensorId}</strong>) is at <strong>${levelText.toLowerCase()}</strong> level.
                `;
                toastEl.style.display = 'block';
                setTimeout(() => dismissToast(), 7000);
            };

            function dismissToast() {
                document.getElementById('alert-toast').style.display = 'none';
            }
        });
    </script>


    @stack('scripts')
    @stack('styles')

    <!-- Footer (optional) -->
    @include('layouts.footer')

    <!-- Include scripts -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="/assets/vendor/echarts/echarts.min.js"></script>
    <script src="/assets/vendor/quill/quill.js"></script>
    <script src="/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="/assets/js/main.js"></script>
    <script>
        setTimeout(function() {
            const flash = document.getElementById('flashMessage');
            if (flash) {
                flash.classList.add('d-none');
            }
        }, 5000);
    </script>

    @stack('streamchat')

</body>

</html>
