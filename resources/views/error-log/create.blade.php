@extends('layouts.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1>Error Log</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('error-log.index') }}">Error Logs</a></li>
                        <li class="breadcrumb-item active">Error Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Current Status Banner -->
        <div class="alert alert-{{ $error->status == null ? 'secondary' : 
            ($error->status == 'New' ? 'primary' : 
            ($error->status == 'Acknowledged' ? 'warning' : 
            ($error->status == 'Reviewed' ? 'info' :
            ($error->status == 'Quiry' ? 'danger' : 'success')))) }} d-flex align-items-center mb-4">
            <div class="d-flex align-items-center flex-grow-1">
                <i class="bi bi-{{ $error->status == null ? 'person-plus' : 
                    ($error->status == 'New' ? 'exclamation-circle' : 
                    ($error->status == 'Acknowledged' ? 'clock-history' : 
                    ($error->status == 'Reviewed' ? 'eye' :
                    ($error->status == 'Quiry' ? 'question-circle' : 'check-circle')))) }} fs-4 me-2"></i>
                <div>
                    <strong>Current Status: {{ $error->status ?? 'Unassigned' }}</strong>
                    <div class="small">
                        @if (is_null($error->status))
                            This error requires assignment to a staff member.
                        @elseif($error->status == 'New')
                            A staff member has been assigned. Waiting for acknowledgment.
                        @elseif($error->status == 'Acknowledged')
                            This error has been acknowledged and is being worked on.
                        @elseif($error->status == 'Reviewed')
                            Resolution report submitted and under admin review.
                        @elseif($error->status == 'Quiry')
                            Resolution requires revision. Sent back to staff for additional work.
                        @elseif($error->status == 'Completed')
                            This error has been resolved and completed.
                        @endif
                    </div>
                </div>
            </div>

            {{-- Action Badges --}}
            @if (is_null($error->status) && Auth::user()->position != 'Staff')
                <div class="ms-auto">
                    <span class="badge bg-danger">Action Required: Assign Staff</span>
                </div>
            @elseif($error->status == 'New' && Auth::user()->position == 'Staff' && auth()->id() == $error->pic)
                <div class="ms-auto">
                    <span class="badge bg-info">Action Required: Acknowledge Task</span>
                </div>
            @elseif($error->status == 'Acknowledged' && Auth::user()->position == 'Staff' && auth()->id() == $error->pic)
                <div class="ms-auto">
                    <span class="badge bg-warning">Action Required: Submit Resolution</span>
                </div>
            @elseif($error->status == 'Reviewed' && Auth::user()->position != 'Staff')
                <div class="ms-auto">
                    <span class="badge bg-info">Action Required: Review Report</span>
                </div>
            @elseif($error->status == 'Quiry' && Auth::user()->position == 'Staff' && auth()->id() == $error->pic)
                <div class="ms-auto">
                    <span class="badge bg-danger">Action Required: Revise Resolution</span>
                </div>
            @endif
        </div>

        <section class="section dashboard">
            <div class="container-fluid p-0">
                <div class="row">
                    <!-- Error Summary Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                            <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title fw-bold">
                                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>Error Summary
                                    </h5>
                                    <span class="badge rounded-pill {{ $error->getStateBadgeClass() }} px-3 py-2">
                                        {{ $error->state }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div class="d-flex align-items-center mb-4">
                                    <i class="bi bi-info-circle fs-5 me-2"></i>
                                    <div>
                                        <strong>{{ ucfirst($error->severity) }} Severity Error</strong> detected on
                                        {{ $error->created_at->format('M d, Y \a\t h:i A') }}
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <label class="text-muted small text-uppercase">Sensor Name</label>
                                            <p class="mb-3 fw-semibold">{{ $error->sensor->sensor_name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <label class="text-muted small text-uppercase">Location</label>
                                            <p class="mb-3 fw-semibold">{{ $error->sensor->substation->substation_location }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <label class="text-muted small text-uppercase">Panel</label>
                                            <p class="mb-3 fw-semibold">{{ $error->sensor->panel->panel_name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <label class="text-muted small text-uppercase">Compartment</label>
                                            <p class="mb-3 fw-semibold">{{ $error->sensor->compartment->compartment_name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <label class="text-muted small text-uppercase">Measurement</label>
                                            <p class="mb-3 fw-semibold">{{ $error->sensor->sensor_measurement }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <label class="text-muted small text-uppercase">Threshold</label>
                                            <p class="mb-3 fw-semibold">{{ $error->threshold }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Assignment Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                            <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                <h5 class="card-title fw-bold">
                                    <i class="bi bi-person-check text-primary me-2"></i>Error Assignment
                                </h5>
                            </div>
                            <div class="card-body pt-2">
                                <!-- Enhanced Status Timeline -->
                                <div class="status-timeline mb-4">
                                    <div class="d-flex align-items-center">
                                        <!-- New -->
                                        <div class="timeline-step {{ in_array($error->status, ['New', 'Acknowledged', 'Reviewed', 'Quiry', 'Completed']) ? 'active' : '' }}">
                                            <div class="timeline-point"></div>
                                            <div class="timeline-label">New</div>
                                        </div>
                                        <div class="timeline-line {{ in_array($error->status, ['Acknowledged', 'Reviewed', 'Quiry', 'Completed']) ? 'active' : '' }}"></div>
                                        
                                        <!-- Acknowledged -->
                                        <div class="timeline-step {{ in_array($error->status, ['Acknowledged', 'Reviewed', 'Quiry', 'Completed']) ? 'active' : '' }}">
                                            <div class="timeline-point"></div>
                                            <div class="timeline-label">Acknowledged</div>
                                        </div>
                                        <div class="timeline-line {{ in_array($error->status, ['Reviewed', 'Quiry', 'Completed']) ? 'active' : '' }}"></div>
                                        
                                        <!-- Reviewed -->
                                        <div class="timeline-step {{ in_array($error->status, ['Reviewed', 'Quiry', 'Completed']) ? 'active' : '' }}">
                                            <div class="timeline-point"></div>
                                            <div class="timeline-label">Reviewed</div>
                                        </div>
                                        
                                        <!-- Quiry Branch (if applicable) -->
                                        @if($error->status == 'Quiry')
                                            <div class="timeline-line active quiry-branch"></div>
                                            <div class="timeline-step active quiry">
                                                <div class="timeline-point bg-danger"></div>
                                                <div class="timeline-label text-danger">Quiry</div>
                                            </div>
                                        @else
                                            <div class="timeline-line {{ $error->status == 'Completed' ? 'active' : '' }}"></div>
                                            <!-- Completed -->
                                            <div class="timeline-step {{ $error->status == 'Completed' ? 'active' : '' }}">
                                                <div class="timeline-point"></div>
                                                <div class="timeline-label">Completed</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Assignment Form -->
                                <form action="{{ route('error-log.update', $error->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3">
                                        <label class="form-label">Assigned Staff</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <select name="pic" class="form-select @if ($error->pic) border-success @endif"
                                                {{ in_array($error->status, ['Completed']) || Auth::user()->position == 'Staff' ? 'disabled' : '' }}>
                                                <option value="">-- Select Staff --</option>
                                                @foreach ($staff as $one_staff)
                                                    <option value="{{ $one_staff->id }}" {{ $error->pic == $one_staff->id ? 'selected' : '' }}>
                                                        {{ $one_staff->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($error->pic && $error->assigned_at)
                                            <div class="text-muted small mt-1">
                                                Assigned on {{ \Carbon\Carbon::parse($error->assigned_at)->format('M d, Y \a\t h:i A') }}
                                                @if ($error->assigned_by)
                                                    by
                                                    @foreach ($staff as $admin)
                                                        @if ($admin->id == $error->assigned_by)
                                                            {{ $admin->name }}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Description / Notes</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-sticky"></i></span>
                                            <textarea name="desc" class="form-control" rows="4"
                                                {{ in_array($error->status, ['Completed']) || (Auth::user()->position == 'Staff' && auth()->id() != $error->pic) ? 'disabled' : '' }}>{{ old('desc', $error->desc) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <div>
                                            @if ($error->status && $error->status !== 'New')
                                                <span class="badge bg-{{ $error->status == 'Acknowledged' ? 'warning' : 
                                                    ($error->status == 'Reviewed' ? 'info' :
                                                    ($error->status == 'Quiry' ? 'danger' : 'success')) }} fs-6 py-2 px-3">
                                                    <i class="bi bi-{{ $error->status == 'Acknowledged' ? 'clock-history' : 
                                                        ($error->status == 'Reviewed' ? 'eye' :
                                                        ($error->status == 'Quiry' ? 'question-circle' : 'check-circle')) }} me-1"></i>
                                                    {{ $error->status }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="d-flex gap-2">
                                            <!-- Staff acknowledge when status is New -->
                                            @if (Auth::user()->position == 'Staff' && $error->status === 'New' && auth()->id() == $error->pic)
                                                <button type="submit" name="action" value="acknowledge" class="btn btn-warning">
                                                    <i class="bi bi-check2-all me-1"></i> Acknowledge
                                                </button>
                                            @endif

                                            <!-- Admin/Supervisor assign/update PIC when not Completed -->
                                            @if (Auth::user()->position != 'Staff' && !in_array($error->status, ['Completed']))
                                                @if (in_array('full', $global_permissions['error_log_access'] ?? []) ||
                                                        in_array('edit', $global_permissions['error_log_access'] ?? []) ||
                                                        in_array('create', $global_permissions['error_log_access'] ?? []))
                                                    <button type="submit" name="action" value="assign" class="btn btn-primary">
                                                        <i class="bi bi-person-plus me-1"></i>
                                                        {{ $error->pic && $error->pic != 1 ? 'Update Assignment' : 'Assign PIC' }}
                                                    </button>
                                                @endif
                                            @endif

                                            <!-- Chat buttons -->
                                            @if (auth()->id() == $error->pic && $error->assigned_by)
                                                <a href="{{ route('chat.with.user', ['userId' => $error->assigned_by]) }}" class="btn btn-outline-primary">
                                                    <i class="bi bi-chat-dots me-1"></i> Message Admin
                                                </a>
                                            @elseif (auth()->id() == $error->assigned_by && $error->pic)
                                                <a href="{{ route('chat.with.user', ['userId' => $error->pic]) }}" class="btn btn-outline-primary">
                                                    <i class="bi bi-chat-dots me-1"></i> Message Staff
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status: Acknowledged - Staff submits resolution report --}}
                @if ($error->status === 'Acknowledged' && Auth::user()->position == 'Staff' && auth()->id() == $error->pic)
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm border-0 rounded-3 border-start border-warning border-4">
                                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                    <h5 class="card-title fw-bold">
                                        <i class="bi bi-clipboard-check text-warning me-2"></i>Resolution Report
                                    </h5>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="alert alert-info d-flex">
                                        <i class="bi bi-info-circle fs-5 me-2"></i>
                                        <div>Submit your resolution report once you have completed the assigned task.</div>
                                    </div>

                                    <form action="{{ route('error-log.update', $error->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">Resolution Details</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                                                <textarea name="report" class="form-control" rows="5" placeholder="Describe how the issue was resolved..." required></textarea>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end pb-2">
                                            <button type="submit" name="action" value="review" class="btn btn-primary">
                                                <i class="bi bi-check-circle me-1"></i> Submit Report
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Status: Quiry - Staff revises resolution --}}
                @if ($error->status === 'Quiry' && Auth::user()->position == 'Staff' && auth()->id() == $error->pic)
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm border-0 rounded-3 border-start border-danger border-4">
                                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                    <h5 class="card-title fw-bold">
                                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Resolution Revision Required
                                    </h5>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="alert alert-danger d-flex mb-4">
                                        <i class="bi bi-exclamation-triangle fs-5 me-2"></i>
                                        <div>
                                            <strong>Admin Feedback:</strong> Your resolution report requires revision. Please review the admin comments below and resubmit.
                                        </div>
                                    </div>

                                    {{-- Display Previous Report and Admin Feedback --}}
                                    @if($error->report)
                                        <div class="card bg-light border mb-3">
                                            <div class="card-header bg-transparent border-0 pb-2">
                                                <h6 class="fw-bold mb-0"><i class="bi bi-file-text me-2"></i>Previous Resolution Report</h6>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="mb-0">{{ $error->report }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($error->admin_review)
                                        <div class="card bg-danger bg-opacity-10 border-danger mb-4">
                                            <div class="card-header bg-transparent border-0 pb-2">
                                                <h6 class="fw-bold mb-0 text-danger"><i class="bi bi-chat-square-text me-2"></i>Admin Feedback</h6>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="mb-0">{{ $error->admin_review }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <form action="{{ route('error-log.update', $error->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">Revised Resolution Details</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                                                <textarea name="report" class="form-control" rows="5" placeholder="Please provide revised resolution details addressing the admin feedback..." required></textarea>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end pb-2">
                                            <button type="submit" name="action" value="review" class="btn btn-danger">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Resubmit Report
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Status: Reviewed - Admin reviews and can complete or send back to quiry --}}
                @if ($error->status === 'Reviewed' && Auth::user()->position != 'Staff')
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm border-0 rounded-3 border-start border-info border-4">
                                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title fw-bold">
                                            <i class="bi bi-clipboard-data text-info me-2"></i>Admin Review
                                        </h5>
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="bi bi-clock-history me-1"></i>Pending Review
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    {{-- Display Staff Resolution Report --}}
                                    <div class="card bg-light border mb-4">
                                        <div class="card-header bg-transparent border-0 pb-2">
                                            <h6 class="fw-bold mb-0">
                                                <i class="bi bi-person-check me-2"></i>Staff Resolution Report
                                            </h6>
                                            <small class="text-muted">
                                                Submitted by:
                                                @foreach ($staff as $one_staff)
                                                    @if ($error->pic == $one_staff->id)
                                                        {{ $one_staff->name }}
                                                    @endif
                                                @endforeach
                                                on {{ \Carbon\Carbon::parse($error->reviewed_at)->format('M d, Y \a\t h:i A') }}
                                            </small>
                                        </div>
                                        <div class="card-body pt-0">
                                            <p class="mb-0">{{ $error->report }}</p>
                                        </div>
                                    </div>

                                    {{-- Admin Review Form --}}
                                    <form action="{{ route('error-log.update', $error->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">Admin Review Comments</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-chat-square-text"></i></span>
                                                <textarea name="admin_review" class="form-control" rows="3" placeholder="Add comments or feedback..."></textarea>
                                            </div>
                                            <div class="form-text">Required when sending back for revision (Quiry)</div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">Sensor Status</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                                <select name="sensor_status" class="form-select">
                                                    <option value="Active" {{ $error->sensor->sensor_status == 'Active' ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="Inactive" {{ $error->sensor->sensor_status == 'Inactive' ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-2 pb-2">
                                            <button type="submit" name="action" value="quiry" class="btn btn-outline-danger">
                                                <i class="bi bi-arrow-left-circle me-1"></i> Send Back (Quiry)
                                            </button>
                                            <button type="submit" name="action" value="complete" class="btn btn-success">
                                                <i class="bi bi-check-all me-1"></i> Complete Task
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Status: Reviewed - Staff can only view (read-only) --}}
                @if ($error->status === 'Reviewed' && Auth::user()->position == 'Staff')
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm border-0 rounded-3 border-start border-info border-4">
                                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title fw-bold">
                                            <i class="bi bi-clipboard-check text-info me-2"></i>Resolution Report
                                        </h5>
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="bi bi-hourglass-split me-1"></i>Under Admin Review
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="alert alert-info d-flex mb-3">
                                        <i class="bi bi-info-circle fs-5 me-2"></i>
                                        <div>Your resolution report has been submitted and is currently under admin review.</div>
                                    </div>

                                    <div class="card-text bg-light rounded p-4 border">
                                        <div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="bi bi-person-check-fill fs-5 text-info"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="fw-bold mb-0">Your Resolution Report</h6>
                                                <p class="text-muted small">Submitted on {{ \Carbon\Carbon::parse($error->reviewed_at)->format('M d, Y \a\t h:i A') }}</p>
                                            </div>
                                        </div>
                                        <p class="mb-0">{{ $error->report }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Status: Completed - Both Admin and Staff can view final report --}}
                @if ($error->status === 'Completed')
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm border-0 rounded-3 border-start border-success border-4">
                                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title fw-bold">
                                            <i class="bi bi-clipboard-check text-success me-2"></i>Task Completed
                                        </h5>
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="bi bi-calendar-check me-1"></i>
                                            Completed on
                                            {{ \Carbon\Carbon::parse($error->completed_at)->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    {{-- Staff Resolution Report --}}
                                    <div class="card bg-light border mb-4">
                                        <div class="card-header bg-transparent border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="bi bi-person-check-fill fs-5 text-success"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="fw-bold mb-0">Resolution Report</h6>
                                                    <small class="text-muted">
                                                        By:
                                                        @foreach ($staff as $one_staff)
                                                            @if ($error->pic == $one_staff->id)
                                                                {{ $one_staff->name }}
                                                            @endif
                                                        @endforeach
                                                        |
                                                        {{ \Carbon\Carbon::parse($error->reviewed_at)->format('M d, Y \a\t h:i A') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <p class="mb-0">{{ $error->report }}</p>
                                        </div>
                                    </div>

                                    {{-- Admin Review Section --}}
                                    @if ($error->admin_review || $error->sensor_status)
                                        <div class="card bg-success bg-opacity-10 border-success">
                                            <div class="card-header bg-transparent border-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="bi bi-shield-check fs-5 text-success"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h6 class="fw-bold mb-0">Admin Review</h6>
                                                        <small class="text-muted">
                                                            Completed on
                                                            {{ \Carbon\Carbon::parse($error->completed_at)->format('M d, Y \a\t h:i A') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                @if ($error->admin_review)
                                                    <div class="mb-3">
                                                        <strong class="d-block mb-2">Admin Comments:</strong>
                                                        <p class="mb-0">{{ $error->admin_review }}</p>
                                                    </div>
                                                @endif

                                                @if ($error->sensor_status)
                                                    <div class="d-flex align-items-center">
                                                        <strong class="me-3">Sensor Status:</strong>
                                                        @if ($error->sensor_status === 'active')
                                                            <span class="badge bg-success">
                                                                <i class="bi bi-check-circle me-1"></i>Active
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">
                                                                <i class="bi bi-x-circle me-1"></i>Inactive
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
