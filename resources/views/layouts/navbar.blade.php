<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
        <a class="nav-link " href="/dashboard">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#staff-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Staff</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="staff-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                {{-- <a href="{{route('staff.index')}}"> --}}
                    <i class="bi bi-circle"></i><span>Staff List</span>
                </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#academicican-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-person-lines-fill"></i><span>Academicians</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="academicican-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
            {{-- <a href="{{route('academicians.index')}}"> --}}
                <i class="bi bi-circle"></i><span>Academicians List</span>
            </a>
            </li>
        </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-clipboard-data"></i><span>Project</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
            {{-- <a href="{{route('projects.index')}}"> --}}
                <i class="bi bi-circle"></i><span>Project List</span>
            </a>
            </li>
            <li>
            {{-- <a href="{{route('projects.create')}}"> --}}
                <i class="bi bi-circle"></i><span>Project Create</span>
            </a>
            </li>
        </ul>
        </li><!-- End Forms Nav -->

        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-check2-circle"></i><span>Milestone</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
            {{-- <a href="{{route('milestones.index')}}"> --}}
                <i class="bi bi-circle"></i><span>Milestone List</span>
            </a>
            </li>
        </ul>
        </li><!-- End Tables Nav -->

    </ul>

    </aside><!-- End Sidebar-->