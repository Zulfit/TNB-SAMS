<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('analytics') }}">
                <i class="bi bi-bar-chart"></i><span>Analytics</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dataset') }}">
                <i class="bi bi-database"></i><span>Dataset</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('substation') }}">
                <i class="bi bi-lightning-charge"></i><span>Substation</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('asset') }}">
                <i class="bi bi-box-seam"></i><span>Asset</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('sensor') }}">
                <i class="bi bi-cpu"></i><span>Sensor</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('report') }}">
                <i class="bi bi-clipboard-data"></i><span>Report Log</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('user_management') }}">
                <i class="bi bi-people"></i><span>User Management</span>
            </a>
        </li>

    </ul>

    <div class="d-flex align-items-center">
        <img src="assets/img/logo_tnb.jpeg" alt="" style="width: 90%">
    </div>

</aside><!-- End Sidebar-->
