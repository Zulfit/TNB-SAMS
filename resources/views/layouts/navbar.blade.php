<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <div class="sidebar-header d-flex align-items-center justify-content-between">
        <a href="/dashboard" class="logo d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" class="me-2" alt="Logo">
            <span class="d-none d-lg-block logo-text">TNB-SAMS</span>
        </a>
        <i class="toggle-sidebar-btn bi bi-chevron-left"></i>
    </div><!-- End Logo -->

    <ul class="sidebar-nav" id="sidebar-nav">
        @php
            $actions = ['full', 'view', 'create', 'edit', 'delete'];
        @endphp

        @if (array_intersect($actions, $global_permissions['dashboard_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['analytics_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('analytics') }}">
                    <i class="bi bi-bar-chart"></i>
                    <span>Analytics</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['error_log_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('error-log.index') }}">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Error Log</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['dataset_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dataset.index') }}">
                    <i class="bi bi-database"></i>
                    <span>Dataset</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['substation_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('substation.index') }}">
                    <i class="bi bi-lightning-charge"></i>
                    <span>Substation</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['sensor_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sensor.index') }}">
                    <i class="bi bi-cpu"></i>
                    <span>Sensor</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['report_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('report.index') }}">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Report Log</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['user_management_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user_management.index') }}">
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

<!-- Add this JavaScript to toggle the sidebar -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set active menu item based on current URL
        let links = document.querySelectorAll(".nav-link");
        links.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add("active");
            }
        });

        // Toggle sidebar functionality
        const toggleBtn = document.querySelector(".toggle-sidebar-btn");
        const body = document.querySelector("body");

        // Check for saved state in localStorage
        const sidebarState = localStorage.getItem("sidebar-state");
        if (sidebarState === "collapsed") {
            body.classList.add("sidebar-collapsed");
            toggleBtn.classList.remove("bi-chevron-left");
            toggleBtn.classList.add("bi-chevron-right");
        }

        toggleBtn.addEventListener("click", function() {
            body.classList.toggle("sidebar-collapsed");

            // Toggle chevron icon direction
            if (body.classList.contains("sidebar-collapsed")) {
                toggleBtn.classList.remove("bi-chevron-left");
                toggleBtn.classList.add("bi-chevron-right");
                localStorage.setItem("sidebar-state", "collapsed");
            } else {
                toggleBtn.classList.remove("bi-chevron-right");
                toggleBtn.classList.add("bi-chevron-left");
                localStorage.setItem("sidebar-state", "expanded");
            }
        });
    });
</script>
