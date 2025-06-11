@extends('layouts.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-0">Error Log</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Error Log</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section dashboard">
            <div class="container-fluid p-0">
                <div class="card shadow-sm border-0 rounded-3 mb-4 pb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Options</h5>
                    </div>
                    <div class="card-body pt-4">
                        <form method="GET" id="filterForm" class="row g-3">
                            <!-- ID Search Field -->
                            <div class="col-md-4 col-lg-3">
                                <label for="error_id" class="form-label small text-muted">Error ID</label>
                                <input type="text" id="error_id" name="error_id"
                                    class="form-control form-control-sm auto-filter" placeholder="Search ID..."
                                    value="{{ request('error_id') }}">
                            </div>

                            <div class="col-md-4 col-lg-3">
                                <label for="substation" class="form-label small text-muted">Substation</label>
                                <select id="substation" name="substation" class="form-select form-select-sm auto-filter">
                                    <option value="">All Substations</option>
                                    @foreach ($substations as $substation)
                                        <option value="{{ $substation->id }}"
                                            {{ request('substation') == $substation->id ? 'selected' : '' }}>
                                            {{ $substation->substation_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-3">
                                <label for="panel" class="form-label small text-muted">Panel</label>
                                <select id="panel" name="panel" class="form-select form-select-sm auto-filter">
                                    <option value="">All Panels</option>
                                    @foreach ($panels as $panel)
                                        <option value="{{ $panel->id }}"
                                            {{ request('panel') == $panel->id ? 'selected' : '' }}>
                                            {{ $panel->panel_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-3">
                                <label for="compartment" class="form-label small text-muted">Compartment</label>
                                <select id="compartment" name="compartment" class="form-select form-select-sm auto-filter">
                                    <option value="">All Compartments</option>
                                    @foreach ($compartments as $compartment)
                                        <option value="{{ $compartment->id }}"
                                            {{ request('compartment') == $compartment->id ? 'selected' : '' }}>
                                            {{ $compartment->compartment_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-3">
                                <label for="measurement" class="form-label small text-muted">Measurement</label>
                                <select id="measurement" name="measurement" class="form-select form-select-sm auto-filter">
                                    <option value="">All Measurements</option>
                                    @foreach ($measurements as $measurement)
                                        <option value="{{ $measurement }}"
                                            {{ request('measurement') == $measurement ? 'selected' : '' }}>
                                            {{ $measurement }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-3">
                                <label for="state" class="form-label small text-muted">State</label>
                                <select id="state" name="state" class="form-select form-select-sm auto-filter">
                                    <option value="">All States</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state }}"
                                            {{ request('state') == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-4 col-lg-3">
                                <label for="status" class="form-label small text-muted">Status</label>
                                <select id="status" name="status" class="form-select form-select-sm auto-filter">
                                    <option value="">All Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Error Logs</h5>
                        <span class="badge bg-secondary">{{ $errors->count() }}
                            {{ Str::plural('record', $errors->count()) }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th class="py-3">ID</th>
                                        <th class="py-3">Timestamp</th>
                                        <th class="py-3">Sensor Name</th>
                                        <th class="py-3">Location</th>
                                        <th class="py-3">Measurement</th>
                                        <th class="py-3">State</th>
                                        <th class="py-3">Threshold</th>
                                        <th class="py-3">Severity</th>
                                        {{-- @if (Auth::user()->position == 'Staff') --}}
                                        <th class="py-3">Status</th>
                                        {{-- @endif --}}
                                        @if (Auth::user()->position != 'Staff')
                                            <th class="py-3">PIC</th>
                                        @endif
                                        <th class="py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($errors as $error)
                                        <tr
                                            class="{{ $error->severity == 'Critical' ? 'table-danger' : ($error->severity == 'Warning' ? 'table-warning' : '') }}">
                                            <td>{{ $error->id }}</td>
                                            <td>{{ $error->updated_at->format('M d, Y H:i') }}</td>
                                            <td>{{ $error->sensor->sensor->sensor_name }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="fw-bold">{{ $error->sensor->sensor->substation->substation_name }}</span>
                                                    <small class="text-muted">
                                                        {{ $error->sensor->sensor->panel->panel_name }} /
                                                        {{ $error->sensor->sensor->compartment->compartment_name }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>{{ $error->sensor->sensor->sensor_measurement }}</td>
                                            <td>
                                                <span class="badge rounded-pill {{ $error->getStateBadgeClass() }}"
                                                    style="padding: 8px 12px; font-size: 0.8rem;">
                                                    {{ $error->state }}
                                                </span>
                                            </td>
                                            <td>{{ $error->threshold }}</td>
                                            <td>
                                                <span class="badge rounded-pill {{ $error->getSeverityBadgeClass() }}"
                                                    style="padding: 8px 12px; font-size: 0.8rem;">
                                                    {{ $error->severity }}
                                                </span>
                                            </td>
                                            {{-- @if (Auth::user()->position == 'Staff') --}}
                                            <td>
                                                @php
                                                    $statusColor = 'primary';
                                                    if ($error->status == 'New') {
                                                        $statusColor = 'info';
                                                    } elseif ($error->status == 'Quiry') {
                                                        $statusColor = 'danger';
                                                    } elseif ($error->status == 'Acknowledge') {
                                                        $statusColor = 'warning';
                                                    } elseif ($error->status == 'Completed') {
                                                        $statusColor = 'success';
                                                    }
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $statusColor }} text-white rounded-pill px-3 py-2">
                                                    {{ $error->status }}
                                                </span>
                                            </td>
                                            {{-- @endif --}}
                                            @if (Auth::user()->position != 'Staff')
                                                <td>
                                                    @if ($error->pic === 1)
                                                        <span class="badge bg-secondary text-white rounded-pill"
                                                            style="padding: 8px 12px; font-size: 0.8rem;">
                                                            Unassigned
                                                        </span>
                                                    @else
                                                        <span class="badge bg-primary text-white rounded-pill"
                                                            style="padding: 8px 12px; font-size: 0.8rem;">
                                                            {{ $error->user->name }}
                                                        </span>
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ route('error-log.assign', $error->id) }}"
                                                                class="dropdown-item">
                                                                <i class="bi bi-person-check me-2"></i>
                                                                @if (Auth::user()->position == 'Staff')
                                                                    Update Status
                                                                @else
                                                                    {{ $error->pic != 1 ? 'View Task' : 'Assign PIC' }}
                                                                @endif
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ Auth::user()->position == 'Staff' ? '10' : '11' }}"
                                                class="text-center py-5">
                                                <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                                <h5 class="text-muted">No Error Logs Found</h5>
                                                <p class="text-muted">
                                                    @if (Auth::user()->position == 'Staff')
                                                        No error logs have been assigned to you.
                                                    @else
                                                        There are no error logs matching your criteria.
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Error Details Modal -->
    <div class="modal fade" id="errorDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="errorDetailsContent">
                    <!-- Content will be loaded dynamically -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Add JavaScript to handle the View Details functionality
            document.addEventListener('DOMContentLoaded', function() {
                // Handle view details click
                const viewDetailButtons = document.querySelectorAll('.view-details');
                const filterSelects = document.querySelectorAll('.auto-filter');
                const formFilter = document.getElementById('filterForm');

                filterSelects.forEach(function(select) {
                    select.addEventListener('change', function() {
                        // Submit the form automatically when any filter changes
                        formFilter.submit();
                    });
                });

                viewDetailButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const errorId = this.getAttribute('data-id');
                        // Here you would fetch the details and populate the modal
                        // For now, we'll just show the modal
                        const modal = new bootstrap.Modal(document.getElementById('errorDetailsModal'));
                        modal.show();
                    });
                });

                // Add hover effect to rows
                const tableRows = document.querySelectorAll('tbody tr');
                tableRows.forEach(row => {
                    row.addEventListener('mouseenter', function() {
                        if (!this.classList.contains('no-hover')) {
                            this.style.cursor = 'pointer';
                            this.style.backgroundColor = '#f8f9fa';
                        }
                    });

                    row.addEventListener('mouseleave', function() {
                        if (!this.classList.contains('no-hover')) {
                            this.style.backgroundColor = '';
                        }
                    });
                });

                // Auto-submit form on Enter key for ID search
                const errorIdInput = document.getElementById('error_id');
                if (errorIdInput) {
                    errorIdInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            this.closest('form').submit();
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
