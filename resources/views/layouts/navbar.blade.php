<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <div class="d-flex align-items-center justify-content-start pb-3">
        <a href="/dashboard" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" class="me-2" alt="">
            <span class="d-none d-lg-block me-2">TNB-SAMS</span>
        </a>
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
                    <i class="bi bi-bar-chart"></i><span>Analytics</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['error_log_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('error-log.index') }}">
                    <i class="bi bi-exclamation-triangle"></i><span>Error Log</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['dataset_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dataset.index') }}">
                    <i class="bi bi-database"></i><span>Dataset</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['substation_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('substation.index') }}">
                    <i class="bi bi-lightning-charge"></i><span>Substation</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['sensor_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sensor.index') }}">
                    <i class="bi bi-cpu"></i><span>Sensor</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['report_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('report.index') }}">
                    <i class="bi bi-clipboard-data"></i><span>Report Log</span>
                </a>
            </li>
        @endif

        @if (array_intersect($actions, $global_permissions['user_management_access'] ?? []))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user_management.index') }}">
                    <i class="bi bi-people"></i><span>User Management</span>
                </a>
            </li>
        @endif

    </ul>

    <div class="d-flex align-items-center">
        <img src="assets/img/logo_tnb.jpeg" alt="" style="width: 90%">
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let links = document.querySelectorAll(".nav-link");

            links.forEach(link => {
                if (link.href === window.location.href) {
                    link.classList.add("active");
                }
            });
        });
    </script>



</aside><!-- End Sidebar-->
