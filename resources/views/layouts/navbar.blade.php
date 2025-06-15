<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <div class="sams-logo" id="toggleLogo" style="display: flex; align-items: center;">
            <div class="logo-icon"
                style="width: 40px; height: 40px; background: linear-gradient(135deg, #011567 0%, #0020f0 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 0.5rem;">
                <i class="fas fa-bolt"></i>
            </div>
            <a href="/dashboard" class="logo-text" style="text-decoration: none; color: inherit;">
                <span>TNB-SAMS</span>
            </a>
        </div>
        
        <div class="toggle-container">
            <i id="toggleSidebar" class="toggle-sidebar-btn bi bi-chevron-left"></i>
        </div>
    </div><!-- End Logo -->

    <ul class="sidebar-nav" id="sidebar-nav">
        @php
            $actions = ['full', 'view', 'create', 'edit', 'delete'];
            $currentRoute = request()->route()->getName();
        @endphp

        @if (array_intersect($actions, $global_permissions['dashboard_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['analytics_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link {{ $currentRoute == 'analytics' ? 'active' : '' }}" href="{{ route('analytics') }}">
                    <i class="bi bi-bar-chart"></i>
                    <span>Analytics</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['error_log_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link {{ str_starts_with($currentRoute, 'error-log') ? 'active' : '' }}" href="{{ route('error-log.index') }}">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Error Log</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['dataset_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link {{ str_starts_with($currentRoute, 'dataset') ? 'active' : '' }}" href="{{ route('dataset.index') }}">
                    <i class="bi bi-database"></i>
                    <span>Dataset</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['substation_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link {{ str_starts_with($currentRoute, 'substation') ? 'active' : '' }}" href="{{ route('substation.index') }}">
                    <i class="bi bi-building"></i>
                    <span>Substation</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['sensor_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link {{ str_starts_with($currentRoute, 'sensor') ? 'active' : '' }}" href="{{ route('sensor.index') }}">
                    <i class="bi bi-cpu"></i>
                    <span>Sensor</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['report_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link {{ str_starts_with($currentRoute, 'report') ? 'active' : '' }}" href="{{ route('report.index') }}">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Report Log</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['user_management_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link {{ str_starts_with($currentRoute, 'user_management') ? 'active' : '' }}" href="{{ route('user_management.index') }}">
                    <i class="bi bi-people"></i>
                    <span>User Management</span>
                </a>
            </li>
        @endif
    </ul>

    <div class="sidebar-footer">
        <img src="{{ asset('images/logo_tnb.jpeg') }}" alt="Logo TNB" class="tnb-logo">
    </div>
</aside><!-- End Sidebar-->

<script>
    const toggleBtn = document.getElementById("toggleSidebar");
    const toggleLogo = document.getElementById("toggleLogo");

    function toggleSidebar() {
        const body = document.querySelector("body");
        const isCollapsed = body.classList.toggle("sidebar-collapsed");

        // Toggle chevron direction
        toggleBtn.classList.toggle("bi-chevron-left", !isCollapsed);
        toggleBtn.classList.toggle("bi-chevron-right", isCollapsed);

        // Toggle visibility
        toggleBtn.classList.toggle("d-none", isCollapsed);

        // Save state
        const state = isCollapsed ? "collapsed" : "expanded";
        localStorage.setItem("sidebar-state", state);
    }

    toggleBtn.addEventListener("click", toggleSidebar);
    toggleLogo.addEventListener("click", function() {
        if (document.body.classList.contains("sidebar-collapsed")) {
            toggleSidebar(); // Only expand on click when collapsed
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const savedState = localStorage.getItem("sidebar-state");
        if (savedState === "collapsed") {
            document.body.classList.add("sidebar-collapsed");
            toggleBtn.classList.remove("bi-chevron-left");
            toggleBtn.classList.add("bi-chevron-right");
            toggleBtn.classList.add("d-none");
        }
    });
</script>
