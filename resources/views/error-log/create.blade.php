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
        <div class="d-flex gap-2">
            <a href="{{ route('error-log.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Logs
            </a>
        </div>
    </div>
    
    <!-- Current Status Banner -->
    <div class="alert alert-{{ $error->status == 'New' ? 'primary' : ($error->status == 'Acknowledged' ? 'warning' : 'success') }} d-flex align-items-center mb-4">
        <div class="d-flex align-items-center flex-grow-1">
            <i class="bi bi-{{ $error->status == 'New' ? 'exclamation-circle' : ($error->status == 'Acknowledged' ? 'clock-history' : 'check-circle') }} fs-4 me-2"></i>
            <div>
                <strong>Current Status: {{ $error->status }}</strong>
                <div class="small">
                    @if($error->status == 'New')
                        This error requires assignment to a staff member.
                    @elseif($error->status == 'Acknowledged')
                        This error has been acknowledged and is being worked on.
                    @else
                        This error has been resolved.
                    @endif
                </div>
            </div>
        </div>
        @if($error->status == 'New' && Auth::user()->position != 'Staff')
            <div class="ms-auto">
                <span class="badge bg-danger">Action Required: Assign Staff</span>
            </div>
        @elseif($error->status == 'Acknowledged' && Auth::user()->position == 'Staff' && auth()->id() == $error->pic)
            <div class="ms-auto">
                <span class="badge bg-warning">Action Required: Complete Task</span>
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
                                    <strong>{{ ucfirst($error->severity) }} Severity Error</strong> detected on {{ $error->created_at->format('M d, Y \a\t h:i A') }}
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
                            <div class="status-timeline mb-4">
                                <div class="d-flex">
                                    <div class="timeline-step {{ $error->status == 'New' || $error->status == 'Acknowledged' || $error->status == 'Completed' ? 'active' : '' }}">
                                        <div class="timeline-point"></div>
                                        <div class="timeline-label">New</div>
                                    </div>
                                    <div class="timeline-line {{ $error->status == 'Acknowledged' || $error->status == 'Completed' ? 'active' : '' }}"></div>
                                    <div class="timeline-step {{ $error->status == 'Acknowledged' || $error->status == 'Completed' ? 'active' : '' }}">
                                        <div class="timeline-point"></div>
                                        <div class="timeline-label">Acknowledged</div>
                                    </div>
                                    <div class="timeline-line {{ $error->status == 'Completed' ? 'active' : '' }}"></div>
                                    <div class="timeline-step {{ $error->status == 'Completed' ? 'active' : '' }}">
                                        <div class="timeline-point"></div>
                                        <div class="timeline-label">Completed</div>
                                    </div>
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
                                        <select name="pic" class="form-select @if($error->pic) border-success @endif" 
                                            {{ $error->status == 'Completed' || (Auth::user()->position == 'Staff') ? 'disabled' : '' }}>
                                            <option value="">-- Select Staff --</option>
                                            @foreach ($staff as $one_staff)
                                                <option value="{{ $one_staff->id }}" {{ $error->pic == $one_staff->id ? 'selected' : '' }}>
                                                    {{ $one_staff->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if($error->pic && $error->assigned_at)
                                        <div class="text-muted small mt-1">
                                            Assigned on {{ \Carbon\Carbon::parse($error->assigned_at)->format('M d, Y \a\t h:i A') }}
                                            @if($error->assigned_by)
                                                by 
                                                @foreach($staff as $admin)
                                                    @if($admin->id == $error->assigned_by)
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
                                            {{ $error->status == 'Completed' || (Auth::user()->position == 'Staff' && auth()->id() != $error->pic) ? 'disabled' : '' }}>{{ old('desc', $error->desc) }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                    <div>
                                        @if($error->status !== 'New')
                                            <span class="badge bg-{{ $error->status == 'Acknowledged' ? 'warning' : 'success' }} fs-6 py-2 px-3">
                                                <i class="bi bi-{{ $error->status == 'Acknowledged' ? 'clock-history' : 'check-circle' }} me-1"></i>
                                                {{ $error->status }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <!-- Only Staff can acknowledge when status is New -->
                                        @if (Auth::user()->position == 'Staff' && $error->status === 'New')
                                            <form action="{{ route('error-log.update', $error->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="acknowledge">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="bi bi-check2-all me-1"></i> Acknowledge
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <!-- Only non-Staff users can assign/update PIC when status is not Completed -->
                                        @if (Auth::user()->position != 'Staff' && $error->status !== 'Completed')
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
                                            <a href="{{ route('chat.with.user', ['userId' => $error->assigned_by]) }}"
                                                class="btn btn-outline-primary">
                                                <i class="bi bi-chat-dots me-1"></i> Message Admin
                                            </a>
                                        @elseif (auth()->id() == $error->assigned_by && $error->pic)
                                            <a href="{{ route('chat.with.user', ['userId' => $error->pic]) }}"
                                                class="btn btn-outline-primary">
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

            <!-- Resolution Card (Only visible to the assigned staff when status is Acknowledged) -->
            @if ($error->status === 'Acknowledged' && Auth::user()->position == 'Staff' && auth()->id() == $error->pic)
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 border-start border-warning border-4">
                            <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                <h5 class="card-title fw-bold">
                                    <i class="bi bi-clipboard-check text-success me-2"></i>Resolution Report
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
                                        <label class="form-label">Resolution Details</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                                            <textarea name="report" class="form-control" rows="5" placeholder="Describe how the issue was resolved..." required></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end pb-2">
                                        <button type="submit" name="action" value="complete" class="btn btn-success">
                                            <i class="bi bi-check-circle me-1"></i> Mark as Completed
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Completed Report (Only visible when completed) -->
            @if ($error->status === 'Completed')
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 border-start border-success border-4">
                            <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title fw-bold">
                                        <i class="bi bi-clipboard-check text-success me-2"></i>Resolution Report
                                    </h5>
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="bi bi-calendar-check me-1"></i>
                                        Completed on {{ \Carbon\Carbon::parse($error->completed_at)->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div class="card-text bg-light rounded p-4 border">
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-person-check-fill fs-5 text-success"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="fw-bold mb-0">Resolution by: 
                                                @foreach ($staff as $one_staff)
                                                    @if($error->pic == $one_staff->id)
                                                        {{ $one_staff->name }}
                                                    @endif
                                                @endforeach
                                            </h6>
                                            <p class="text-muted small">{{ \Carbon\Carbon::parse($error->completed_at)->format('M d, Y \a\t h:i A') }}</p>
                                        </div>
                                    </div>
                                    <p class="mb-0">{{ $error->report }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
