<header id="header" class="header d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-start">
        {{-- <a href="/dashboard" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" class="me-2" alt="">
            <span class="d-none d-lg-block me-2">TNB-SAMS</span>
        </a> --}}
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <!-- Date & Time -->
            <li class="nav-item d-flex align-items-center me-3" style="min-width: 140px;">
                <span id="current-date" class="small text-nowrap me-2"></span>
                <span id="current-time" class="small text-nowrap"></span>
            </li>

            <!-- Notification Icon -->
            <li class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        id="notification-count">0</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" id="notification-list" style="width: 320px;">
                    <li class="dropdown-header fw-semibold px-3 py-2 border-bottom">Notifications</li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <!-- Dynamic items inserted here -->
                    <li class="dropdown-footer text-center mt-2">
                        <a href="#" class="text-primary small">Show all notifications</a>
                    </li>
                </ul>
            </li>

            <!-- Message Icon -->
            <li class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-chat-left-text fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success"
                        id="message-count">0</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="width: 360px;">
                    <li class="dropdown-header fw-semibold px-3 py-2 border-bottom" id="dropdown-header">
                        You have 0 new messages
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <!-- Wrap the message list inside a <li> to fix structure -->
                    <li>
                        <ul id="message-list" class="list-unstyled px-2 mb-2"
                            style="max-height: 300px; overflow-y: auto;">
                            <!-- Dynamic messages go here -->
                        </ul>
                    </li>
                    <li class="dropdown-footer text-center mt-2">
                        <a href="#" class="text-primary small">Show all messages</a>
                    </li>
                </ul>
            </li>

            <!-- Profile -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <div class="avatar-preview" id="avatarPreview"
                        style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 3px solid #e9ecef; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                        @if (Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-fill text-white" style="font-size: 2.5rem;"></i>
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('profile') }}">
                            <i class="bi bi-person me-2"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            <span>Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>

        </ul>
B
    </nav>
</header>
<script>
    // Simple JS to update time every second
    function updateDateTime() {
        const dateElement = document.getElementById('current-date');
        const timeElement = document.getElementById('current-time');
        const now = new Date();

        // Format date: e.g. "Sun, 25 May 2025"
        const optionsDate = {
            weekday: 'short',
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        };
        const dateString = now.toLocaleDateString(undefined, optionsDate);

        // Format time: e.g. "14:35:09"
        const optionsTime = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        const timeString = now.toLocaleTimeString(undefined, optionsTime);

        dateElement.textContent = dateString;
        timeElement.textContent = timeString;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
