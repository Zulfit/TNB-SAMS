@extends('layouts.layout')

@section('content')
    <main id="main" class="main">
        <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">New Task Assigned</h5>
                    </div>
                    <div class="modal-body" id="taskModalBody">
                        <!-- Message will be inserted here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="quiryModal" tabindex="-1" aria-labelledby="quiryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quiryModalLabel">New Task Assigned</h5>
                    </div>
                    <div class="modal-body" id="quiryModalBody">
                        <!-- Message will be inserted here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Dashboard</h1>
            <div class="d-flex align-items-center gap-2">
                <label for="yearFilter" class="form-label mb-0 fw-semibold">Year:</label>
                <select id="yearFilter" class="form-select form-select-sm" style="width: auto; min-width: 120px;">
                    <option value="2025" {{ $year == 2025 ? 'selected' : '' }}>2025</option>
                    <option value="2024" {{ $year == 2024 ? 'selected' : '' }}>2024</option>
                </select>
                <label for="monthFilter" class="form-label mb-0 fw-semibold">Month:</label>
                <select id="monthFilter" class="form-select form-select-sm" style="width: auto; min-width: 120px;">
                    <option value="">All Months</option>
                    <option value="1" {{ $month == 1 ? 'selected' : '' }}>January</option>
                    <option value="2" {{ $month == 2 ? 'selected' : '' }}>February</option>
                    <option value="3" {{ $month == 3 ? 'selected' : '' }}>March</option>
                    <option value="4" {{ $month == 4 ? 'selected' : '' }}>April</option>
                    <option value="5" {{ $month == 5 ? 'selected' : '' }}>May</option>
                    <option value="6" {{ $month == 6 ? 'selected' : '' }}>June</option>
                    <option value="7" {{ $month == 7 ? 'selected' : '' }}>July</option>
                    <option value="8" {{ $month == 8 ? 'selected' : '' }}>August</option>
                    <option value="9" {{ $month == 9 ? 'selected' : '' }}>September</option>
                    <option value="10" {{ $month == 10 ? 'selected' : '' }}>October</option>
                    <option value="11" {{ $month == 11 ? 'selected' : '' }}>November</option>
                    <option value="12" {{ $month == 12 ? 'selected' : '' }}>December</option>
                </select>
            </div>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">

                        <!-- First Row -->
                        <div class="row mb-2">
                            <!-- Total Substations Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <a href="{{ route('substation.index') }}" class="text-decoration-none text-dark">
                                    <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                        <div class="card-body text-center p-3">
                                            <div class="icon-wrapper mb-2">
                                                <div class="icon-circle bg-primary-subtle"
                                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                    <i class="bi bi-building text-primary fs-4"></i>
                                                </div>
                                            </div>
                                            <h5 class="card-title text-muted mb-1 small">Total Substations</h5>
                                            <h3 class="fw-bold text-primary mb-0" id="total-substations">
                                                {{ $total_substation }}</h3>
                                            <small class="text-success">
                                                <i class="bi bi-arrow-up"></i> Active
                                            </small>
                                            <!-- Arrow Icon -->
                                            <div class="position-absolute end-0 bottom-0 m-2">
                                                <i class="bi bi-arrow-right-circle-fill text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Total Sensors Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <a href="{{ route('sensor.index') }}" class="text-decoration-none text-dark">
                                    <div class="card info-card h-100 border-0 shadow-sm hover-card position-relative">
                                        <div class="card-body text-center p-3">
                                            <div class="icon-wrapper mb-2">
                                                <div class="icon-circle bg-info-subtle"
                                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                    <i class="bi bi-cpu text-info fs-4"></i>
                                                </div>
                                            </div>
                                            <h5 class="card-title text-muted mb-1 small">Total Sensors</h5>
                                            <h3 class="fw-bold text-info mb-0" id="total-sensors">{{ $total_sensor }}</h3>
                                            <small class="text-success">
                                                <i class="bi bi-check-circle"></i> Online
                                            </small>
                                            <!-- Arrow Icon -->
                                            <div class="position-absolute end-0 bottom-0 m-2">
                                                <i class="bi bi-arrow-right-circle-fill text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <!-- Total Alarms Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <a href="{{ route('error-log.index') }}" class="text-decoration-none text-dark">
                                    <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                        <div class="card-body text-center p-3">
                                            <div class="icon-wrapper mb-2">
                                                <div class="icon-circle bg-danger-subtle"
                                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                    <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                                                </div>
                                            </div>
                                            <h5 class="card-title text-muted mb-1 small">Total Alarms</h5>
                                            <h3 class="fw-bold text-danger mb-0" id="total-alarms">{{ $total_failure }}
                                            </h3>
                                            <small class="text-danger">
                                                <i class="bi bi-file-text"></i> All Error Logs
                                            </small>
                                            <!-- Arrow Icon -->
                                            <div class="position-absolute end-0 bottom-0 m-2">
                                                <i class="bi bi-arrow-right-circle-fill text-danger"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Issues Resolved Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <a href="{{ route('error-log.index') }}" class="text-decoration-none text-dark">
                                    <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                        <div class="card-body text-center p-3">
                                            <div class="icon-wrapper mb-2">
                                                <div class="icon-circle bg-success-subtle"
                                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                    <i class="bi bi-check-circle text-success fs-4"></i>
                                                </div>
                                            </div>
                                            <h5 class="card-title text-muted mb-1">Issues Resolved</h5>
                                            <h3 class="fw-bold text-success mb-0" id="total-resolved">
                                                {{ $total_resolved ?? 0 }}</h3>
                                            <small class="text-success">
                                                <i class="bi bi-check-all"></i> Solved Logs
                                            </small>
                                            <!-- Arrow Icon -->
                                            <div class="position-absolute end-0 bottom-0 m-2">
                                                <i class="bi bi-arrow-right-circle-fill text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            </a>
                        </div>

                        <!-- Second Row -->
                        <div class="row mb-2">
                            <!-- Critical State Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <a href="{{ route('error-log.index') }}" class="text-decoration-none text-dark">
                                    <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                        <div class="card-body text-center p-3">
                                            <div class="icon-wrapper mb-2">
                                                <div class="icon-circle bg-danger-subtle"
                                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                    <i class="bi bi-x-octagon text-danger fs-4"></i>
                                                </div>
                                            </div>
                                            <h5 class="card-title text-muted mb-1 small">Critical State</h5>
                                            <h3 class="fw-bold text-danger mb-0" id="total-critical">
                                                {{ $total_critical ?? 0 }}</h3>
                                            <small class="text-danger">
                                                <i class="bi bi-shield-x"></i> Critical Logs
                                            </small>
                                            <!-- Arrow Icon -->
                                            <div class="position-absolute end-0 bottom-0 m-2">
                                                <i class="bi bi-arrow-right-circle-fill text-danger"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Warning State Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <a href="{{ route('error-log.index') }}" class="text-decoration-none text-dark">
                                    <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                        <div class="card-body text-center p-3">
                                            <div class="icon-wrapper mb-2">
                                                <div class="icon-circle bg-warning-subtle"
                                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                    <i class="bi bi-exclamation-circle text-warning fs-4"></i>
                                                </div>
                                            </div>
                                            <h5 class="card-title text-muted mb-1 small">Warning State</h5>
                                            <h3 class="fw-bold text-warning mb-0" id="total-warnings">
                                                {{ $total_warning ?? 0 }}</h3>
                                            <small class="text-warning">
                                                <i class="bi bi-shield-exclamation"></i> Warning Logs
                                            </small>
                                            <!-- Arrow Icon -->
                                            <div class="position-absolute end-0 bottom-0 m-2">
                                                <i class="bi bi-arrow-right-circle-fill text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Total Review Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <a href="{{ route('error-log.index') }}" class="text-decoration-none text-dark">
                                    <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                        <div class="card-body text-center p-3">
                                            <div class="icon-wrapper mb-2">
                                                <div class="icon-circle bg-info-subtle"
                                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                    <i class="bi bi-clipboard-check text-info fs-4"></i>
                                                </div>
                                            </div>
                                            <h5 class="card-title text-muted mb-1 small">Total Review</h5>
                                            <h3 class="fw-bold text-info mb-0" id="total-review">{{ $total_review ?? 0 }}
                                            </h3>
                                            <small class="text-info">
                                                <i class="bi bi-hourglass-split"></i> Pending Review
                                            </small>
                                            <!-- Arrow Icon -->
                                            <div class="position-absolute end-0 bottom-0 m-2">
                                                <i class="bi bi-arrow-right-circle-fill text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Total Query Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <a href="{{ route('error-log.index') }}" class="text-decoration-none text-dark">
                                    <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                        <div class="card-body text-center p-3">
                                            <div class="icon-wrapper mb-2">
                                                <div class="icon-circle bg-warning-subtle"
                                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                    <i class="bi bi-arrow-counterclockwise text-warning fs-4"></i>
                                                </div>
                                            </div>
                                            <h5 class="card-title text-muted mb-1 small">Total Query</h5>
                                            <h3 class="fw-bold text-warning mb-0" id="total-query">
                                                {{ $total_query ?? 0 }}
                                            </h3>
                                            <small class="text-warning">
                                                <i class="bi bi-question-circle"></i> Manager Query
                                            </small>
                                            <!-- Arrow Icon -->
                                            <div class="position-absolute end-0 bottom-0 m-2">
                                                <i class="bi bi-arrow-right-circle-fill text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- Sensor Thermal Chart with its own filters --}}
                        <div class="card shadow-sm border-0 rounded-3 mb-4" id="thermalChartContainer"
                            style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0"><i class="bi bi-thermometer-half me-2"></i>Sensor Thermal °C</h5>
                            </div>
                            <div class="card-body p-4">
                                <!-- Thermal Chart Filters -->
                                <form method="GET" class="row g-3 mb-4">
                                    <!-- Substation Filter for Thermal -->
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Substation</label>
                                        <select class="form-select form-select-sm" name="thermal_substation"
                                            id="thermalSubstationFilter">
                                            @if (isset($substations) && count($substations) > 0)
                                                @foreach ($substations as $substation)
                                                    <option value="{{ $substation->id }}"
                                                        {{ request('thermal_substation') == $substation->id ? 'selected' : '' }}>
                                                        {{ $substation->substation_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Panel Filter for Thermal -->
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Panel</label>
                                        <select class="form-select form-select-sm" name="thermal_panel"
                                            id="thermalPanelFilter">
                                            @if (isset($panels) && count($panels) > 0)
                                                @foreach ($panels as $panel)
                                                    <option value="{{ $panel->id }}"
                                                        {{ request('thermal_panel') == $panel->id ? 'selected' : '' }}>
                                                        {{ $panel->panel_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Compartment Filter for Thermal -->
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Compartment</label>
                                        <select class="form-select form-select-sm" name="thermal_compartment"
                                            id="thermalCompartmentFilter">
                                            @if (isset($compartments) && count($compartments) > 0)
                                                @foreach ($compartments as $compartment)
                                                    <option value="{{ $compartment->id }}"
                                                        {{ request('thermal_compartment') == $compartment->id ? 'selected' : '' }}>
                                                        {{ $compartment->compartment_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Time Gap Filter for Thermal -->
                                    <div class="col-md-3">
                                        <label for="thermalTimeGapFilter" class="form-label small text-muted">Time
                                            Gap</label>
                                        <select id="thermalTimeGapFilter" class="form-select form-select-sm"
                                            name="thermal_time_gap">
                                            <option value="5min"
                                                {{ request('thermal_time_gap') == '5min' ? 'selected' : '' }}>
                                                Every 5 Minutes</option>
                                            <option value="10min"
                                                {{ request('thermal_time_gap') == '10min' ? 'selected' : '' }}>
                                                Every 10 Minutes</option>
                                            <option value="30min"
                                                {{ request('thermal_time_gap') == '30min' ? 'selected' : '' }}>
                                                Every 30 Minutes</option>
                                            <option value="hourly"
                                                {{ request('thermal_time_gap') == 'hourly' ? 'selected' : '' }}>
                                                Hourly</option>
                                        </select>
                                    </div>
                                </form>

                                <!-- Chart -->
                                <div class="position-relative">
                                    <canvas id="thermalChart" style="height: 400px;"></canvas>
                                    <div id="chartLoadingTemp" class="chart-loading d-none">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Legend & Info -->
                                <div class="container-fluid p-4">
                                    <div class="row g-3 mt-3">
                                        <!-- Phase Legend -->
                                        <div class="col-12 col-lg-4 order-1">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title mb-3">Phase Color</h6>
                                                    <div class="d-flex flex-column gap-2">
                                                        <div class="d-flex align-items-center">
                                                            <span class="rounded-circle bg-danger d-inline-block me-2"
                                                                style="width: 10px; height: 10px;"></span>
                                                            <span>Red Phase</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="rounded-circle bg-warning d-inline-block me-2"
                                                                style="width: 10px; height: 10px;"></span>
                                                            <span>Yellow Phase</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="rounded-circle bg-primary d-inline-block me-2"
                                                                style="width: 10px; height: 10px;"></span>
                                                            <span>Blue Phase</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Temperature Statistics -->
                                        <div class="col-12 col-md-4 order-2">
                                            <div class="card h-100 position-relative">
                                                <div class="card-body">
                                                    <!-- Title + Info Icon -->
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <h6 class="card-title mb-3">Temperature Stats</h6>
                                                        <!-- Info Icon with Tooltip -->
                                                        <span data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-bs-html="true"
                                                            title="Maximum = Highest temperature among 3-phase colors.<br>
                                                                    Minimum = Lowest temperature among 3-phase colors.<br>
                                                                    Difference = Maximum - Minimum.<br><br>
                                                                    <strong>Severity Levels:</strong><br>
                                                                    Normal: &lt; 0.8<br>
                                                                    Warn: ≥ 0.8 and &lt; 1.0<br>
                                                                    Critical: ≥ 1.0"
                                                            style="cursor: pointer;">
                                                            <i class="bi bi-info-circle-fill text-primary"></i>
                                                        </span>
                                                    </div>

                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-nowrap me-2">Maximum</span>
                                                                <input id="temp_max" class="form-control text-center"
                                                                    style="max-width: 100px;" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-nowrap me-2">Minimum</span>
                                                                <input id="temp_min" class="form-control text-center"
                                                                    style="max-width: 100px;" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-nowrap me-2">Difference</span>
                                                                <input id="temp_diff" class="form-control text-center"
                                                                    style="max-width: 100px;" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Variance Statistics -->
                                        <div class="col-12 col-md-4 order-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <h6 class="card-title mb-3">Variance Stats</h6>
                                                        <!-- Info Icon with Tooltip -->
                                                        <span data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-bs-html="true"
                                                            title="Variance stats is not in the current implementation and client wants to put it as future enhancement.<br><br><strong>Formula:</strong><br>Variance = (diff / max) × 100"
                                                            style="cursor: pointer;">
                                                            <i class="bi bi-info-circle-fill text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-nowrap me-2">Between Wires</span>
                                                                <input id="variance_avg" class="form-control text-center"
                                                                    style="max-width: 100px;" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-nowrap me-2">Maximum</span>
                                                                <input id="variance_max" class="form-control text-center"
                                                                    style="max-width: 100px;" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sensor Partial Discharge Chart with its own filters --}}
                        <div class="card shadow-sm border-0 rounded-3 mb-4" id="partialDischargeChart"
                            style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                            <div class="card-header bg-white py-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Sensor Partial Discharge</h5>
                                    <span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true"
                                        title="Sensor partial discharge must always be 0.<br>If it exceeds 0, it will hit the threshold."
                                        style="cursor: pointer;">
                                        <i class="bi bi-info-circle-fill text-primary"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <!-- Partial Discharge Chart Filters -->
                                <form method="GET" class="row g-3 mb-4">
                                    <!-- Substation Filter for PD -->
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Substation</label>
                                        <select class="form-select form-select-sm" name="pd_substation"
                                            id="pdSubstationFilter">
                                            @if (isset($substations) && count($substations) > 0)
                                                @foreach ($substations as $substation)
                                                    <option value="{{ $substation->id }}"
                                                        {{ request('pd_substation') == $substation->id ? 'selected' : '' }}>
                                                        {{ $substation->substation_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Panel Filter for PD -->
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Panel</label>
                                        <select class="form-select form-select-sm" name="pd_panel" id="pdPanelFilter">
                                            @if (isset($panels) && count($panels) > 0)
                                                @foreach ($panels as $panel)
                                                    <option value="{{ $panel->id }}"
                                                        {{ request('pd_panel') == $panel->id ? 'selected' : '' }}>
                                                        {{ $panel->panel_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Compartment Filter for PD -->
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Compartment</label>
                                        @php
                                            $defaultCompartmentId = 5; // Replace 5 with the ID you want to default-select
                                        @endphp

                                        <select class="form-select form-select-sm" name="pd_compartment"
                                            id="pdCompartmentFilter">
                                            @if (isset($compartments) && count($compartments) > 0)
                                                @foreach ($compartments as $compartment)
                                                    <option value="{{ $compartment->id }}"
                                                        {{ request('pd_compartment') == $compartment->id ? 'selected' : '' }}>
                                                        {{ $compartment->compartment_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Time Gap Filter for PD -->
                                    <div class="col-md-3">
                                        <label for="pdTimeGapFilter" class="form-label small text-muted">Time Gap</label>
                                        <select id="pdTimeGapFilter" class="form-select form-select-sm"
                                            name="pd_time_gap">
                                            <option value="5min"
                                                {{ request('pd_time_gap') == '5min' ? 'selected' : '' }}>
                                                Every 5 Minutes</option>
                                            <option value="10min"
                                                {{ request('pd_time_gap') == '10min' ? 'selected' : '' }}>
                                                Every 10 Minutes</option>
                                            <option value="30min"
                                                {{ request('pd_time_gap') == '30min' ? 'selected' : '' }}>
                                                Every 30 Minutes</option>
                                            <option value="hourly"
                                                {{ request('pd_time_gap') == 'hourly' ? 'selected' : '' }}>
                                                Hourly</option>
                                        </select>
                                    </div>
                                </form>

                                <!-- Chart -->
                                <div class="position-relative">
                                    <canvas id="pdChart" style="height: 400px;"></canvas>
                                    <div id="chartLoadingPD" class="chart-loading d-none">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart.js Script -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const totalTasks = @json($totalTasks);
                                const totalQuiry = @json($totalQuiry);

                                if (totalTasks > 0) {
                                    document.getElementById('taskModalBody').textContent =
                                        `You have ${totalTasks} new task(s) assigned to you.`;
                                    const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
                                    taskModal.show();
                                }
                                if (totalQuiry > 0) {
                                    document.getElementById('quiryModalBody').textContent =
                                        `You have ${totalQuiry} new quiry assigned to you.`;
                                    const quiryModal = new bootstrap.Modal(document.getElementById('quiryModal'));
                                    quiryModal.show();
                                }

                                if (typeof Chart === 'undefined') {
                                    console.error('Chart.js is not loaded!');
                                    return;
                                }

                                // Chart instances
                                const ctx = document.getElementById('thermalChart');
                                const pdCtx = document.getElementById('pdChart');
                                let chartInstance;
                                let pdChartInstance;

                                const RELOAD_INTERVAL_MS = 300000;

                                // Year and Month filters (ADDED)
                                const yearFilter = document.getElementById('yearFilter');
                                const monthFilter = document.getElementById('monthFilter');

                                // Separate filter elements for Thermal Chart
                                const thermalSubstationFilter = document.getElementById('thermalSubstationFilter');
                                const thermalPanelFilter = document.getElementById('thermalPanelFilter');
                                const thermalCompartmentFilter = document.getElementById('thermalCompartmentFilter');
                                const thermalTimeGapFilter = document.getElementById('thermalTimeGapFilter');

                                // Separate filter elements for PD Chart
                                const pdSubstationFilter = document.getElementById('pdSubstationFilter');
                                const pdPanelFilter = document.getElementById('pdPanelFilter');
                                const pdCompartmentFilter = document.getElementById('pdCompartmentFilter');
                                const pdTimeGapFilter = document.getElementById('pdTimeGapFilter');

                                // Add event listeners for Year and Month filters (ADDED)
                                if (yearFilter) {
                                    yearFilter.addEventListener('change', function() {
                                        console.log('Year filter changed:', this.value);
                                        // Refresh both charts and dashboard stats
                                        refreshDashboard();
                                    });
                                }

                                if (monthFilter) {
                                    monthFilter.addEventListener('change', function() {
                                        console.log('Month filter changed:', this.value);
                                        // Refresh both charts and dashboard stats
                                        refreshDashboard();
                                    });
                                }

                                // Add event listeners for Thermal Chart filters
                                [thermalSubstationFilter, thermalPanelFilter, thermalCompartmentFilter, thermalTimeGapFilter].forEach(
                                    filter => {
                                        if (filter) {
                                            filter.addEventListener('change', function() {
                                                console.log('Thermal filter changed:', {
                                                    substation: thermalSubstationFilter?.value,
                                                    panel: thermalPanelFilter?.value,
                                                    compartment: thermalCompartmentFilter?.value,
                                                    timeGap: thermalTimeGapFilter?.value,
                                                });
                                                renderChart();
                                            });
                                        }
                                    });

                                // Add event listeners for PD Chart filters
                                [pdSubstationFilter, pdPanelFilter, pdCompartmentFilter, pdTimeGapFilter].forEach(filter => {
                                    if (filter) {
                                        filter.addEventListener('change', function() {
                                            console.log('PD filter changed:', {
                                                substation: pdSubstationFilter?.value,
                                                panel: pdPanelFilter?.value,
                                                compartment: pdCompartmentFilter?.value,
                                                timeGap: pdTimeGapFilter?.value,
                                            });
                                            renderPDChart();
                                        });
                                    }
                                });

                                // NEW FUNCTION: Refresh entire dashboard (ADDED)
                                async function refreshDashboard() {
                                    try {
                                        const year = yearFilter?.value || new Date().getFullYear();
                                        const month = monthFilter?.value || '';

                                        // Show loading state
                                        showDashboardLoading();

                                        // Refresh dashboard stats
                                        const response = await fetch('/dashboard/stats-by-period', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                    ?.getAttribute('content')
                                            },
                                            body: JSON.stringify({
                                                year: year,
                                                month: month
                                            })
                                        });

                                        if (response.ok) {
                                            const data = await response.json();
                                            updateDashboardStats(data);
                                        }

                                        // Refresh both charts
                                        renderChart();
                                        renderPDChart();

                                    } catch (error) {
                                        console.error('Error refreshing dashboard:', error);
                                    } finally {
                                        hideDashboardLoading();
                                    }
                                }

                                // NEW FUNCTION: Update dashboard statistics (ADDED)
                                function updateDashboardStats(data) {
                                    // Update all the dashboard stat cards
                                    const statsMap = {
                                        'total-substations': data.total_substation,
                                        'total-sensors': data.total_sensor,
                                        'total-alarms': data.total_failure,
                                        'total-resolved': data.total_resolved,
                                        'total-critical': data.total_critical,
                                        'total-warnings': data.total_warning,
                                        'total-review': data.total_review,
                                        'total-query': data.total_query
                                    };

                                    Object.entries(statsMap).forEach(([elementId, value]) => {
                                        const element = document.getElementById(elementId);
                                        if (element) {
                                            element.textContent = value || 0;
                                        }
                                    });
                                }

                                // NEW FUNCTION: Show dashboard loading state (ADDED)
                                function showDashboardLoading() {
                                    // Add loading overlay or spinner to dashboard
                                    const dashboard = document.querySelector('.section.dashboard');
                                    if (dashboard && !dashboard.querySelector('.dashboard-loading')) {
                                        const loadingDiv = document.createElement('div');
                                        loadingDiv.className =
                                            'dashboard-loading position-absolute w-100 h-100 d-flex justify-content-center align-items-center';
                                        loadingDiv.style.cssText = 'top: 0; left: 0; background: rgba(255,255,255,0.8); z-index: 1000;';
                                        loadingDiv.innerHTML =
                                            '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
                                        dashboard.style.position = 'relative';
                                        dashboard.appendChild(loadingDiv);
                                    }
                                }

                                // NEW FUNCTION: Hide dashboard loading state (ADDED)
                                function hideDashboardLoading() {
                                    const loadingDiv = document.querySelector('.dashboard-loading');
                                    if (loadingDiv) {
                                        loadingDiv.remove();
                                    }
                                }

                                function showChartLoading(chartType) {
                                    const loadingElement = document.getElementById(`chartLoading${chartType}`);
                                    if (loadingElement) {
                                        loadingElement.classList.remove('d-none');
                                    }
                                }

                                function hideChartLoading(chartType) {
                                    const loadingElement = document.getElementById(`chartLoading${chartType}`);
                                    if (loadingElement) {
                                        loadingElement.classList.add('d-none');
                                    }
                                }

                                function formatDateLabel(dateString, timeGap) {
                                    const date = new Date(dateString);
                                    switch (timeGap) {
                                        case '5min':
                                        case '10min':
                                        case '30min':
                                        case 'hourly':
                                            return date.toLocaleString('en-US', {
                                                month: 'short',
                                                day: 'numeric',
                                                hour: '2-digit',
                                                minute: '2-digit'
                                            });
                                        default:
                                            return date.toLocaleDateString();
                                    }
                                }

                                // Temperature Chart Functions
                                async function fetchTemperatureData() {
                                    try {
                                        showChartLoading('Temp');

                                        const substationId = thermalSubstationFilter?.value || '';
                                        const panelId = thermalPanelFilter?.value || '';
                                        const compartmentId = thermalCompartmentFilter?.value || '';
                                        const timeGap = thermalTimeGapFilter?.value || '5min';

                                        // ADDED: Include year and month in request
                                        const year = yearFilter?.value || new Date().getFullYear();
                                        const month = monthFilter?.value || '';

                                        const res = await fetch('/dashboard/sensor-temperature', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                    ?.getAttribute('content')
                                            },
                                            body: JSON.stringify({
                                                substation: substationId,
                                                panel: panelId,
                                                compartment: compartmentId,
                                                timeGap: timeGap,
                                                year: year, // ADDED
                                                month: month // ADDED
                                            })
                                        });

                                        if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);

                                        const data = await res.json();

                                        if (!data || data.length === 0) {
                                            console.log("Data received:", data);
                                            return {
                                                labels: [],
                                                redPhase: [],
                                                yellowPhase: [],
                                                bluePhase: []
                                            };
                                        }

                                        const reversed = [...data].reverse();

                                        return {
                                            labels: reversed.map(d => formatDateLabel(d.created_at, timeGap)),
                                            redPhase: reversed.map(d => parseFloat(d.Red_Phase) || 0),
                                            yellowPhase: reversed.map(d => parseFloat(d.Yellow_Phase) || 0),
                                            bluePhase: reversed.map(d => parseFloat(d.Blue_Phase) || 0)
                                        };
                                    } catch (err) {
                                        console.error('Error loading temperature data:', err);
                                        showChartError('thermalChart', 'Failed to load temperature data');
                                        return {
                                            labels: [],
                                            redPhase: [],
                                            yellowPhase: [],
                                            bluePhase: []
                                        };
                                    } finally {
                                        hideChartLoading('Temp');
                                    }
                                }

                                function calculateTemperatureStats(latestRed, latestYellow, latestBlue) {
                                    const latestTemps = [latestRed, latestYellow, latestBlue];
                                    const maxTemp = Math.max(...latestTemps);
                                    const minTemp = Math.min(...latestTemps);
                                    const tempDiff = maxTemp - minTemp;
                                    const variance = maxTemp === 0 ? 0 : ((tempDiff / maxTemp) * 100);

                                    return {
                                        varianceAvg: variance.toFixed(2),
                                        varianceMax: 5.70.toFixed(2),
                                        tempDiff: tempDiff.toFixed(2),
                                        tempMax: maxTemp,
                                        tempMin: minTemp,
                                    };
                                }

                                function updateTemperatureStats(redPhase, yellowPhase, bluePhase) {
                                    const latestRed = redPhase[redPhase.length - 1];
                                    const latestYellow = yellowPhase[yellowPhase.length - 1];
                                    const latestBlue = bluePhase[bluePhase.length - 1];

                                    const stats = calculateTemperatureStats(latestRed, latestYellow, latestBlue);

                                    const varianceAvgElement = document.getElementById('variance_avg');
                                    const varianceMaxElement = document.getElementById('variance_max');
                                    const tempDiffElement = document.getElementById('temp_diff');
                                    const tempMaxElement = document.getElementById('temp_max');
                                    const tempMinElement = document.getElementById('temp_min');

                                    if (varianceAvgElement) varianceAvgElement.value = stats.varianceAvg + '°C';
                                    if (varianceMaxElement) varianceMaxElement.value = stats.varianceMax + '°C';
                                    if (tempDiffElement) tempDiffElement.value = stats.tempDiff + '°C';
                                    if (tempMaxElement) tempMaxElement.value = stats.tempMax + '°C';
                                    if (tempMinElement) tempMinElement.value = stats.tempMin + '°C';
                                }

                                async function renderChart() {
                                    try {
                                        console.log('Starting thermal chart render...');

                                        const tempData = await fetchTemperatureData();
                                        console.log('Temperature data received:', tempData);

                                        if (tempData.labels.length === 0) {
                                            showChartError('thermalChart', 'Failed to load thermal chart');
                                            setTimeout(function() {
                                                location.reload();
                                            }, 3000);
                                            return;
                                        }

                                        hideErrorMessages('thermalChart');

                                        if (chartInstance) {
                                            chartInstance.destroy();
                                        }

                                        updateTemperatureStats(tempData.redPhase, tempData.yellowPhase, tempData.bluePhase);

                                        chartInstance = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: tempData.labels,
                                                datasets: [{
                                                        label: 'Red Phase',
                                                        data: tempData.redPhase,
                                                        borderColor: '#dc3545',
                                                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                                                        borderWidth: 2,
                                                        fill: false,
                                                        tension: 0.3,
                                                        pointRadius: 3,
                                                        pointHoverRadius: 6
                                                    },
                                                    {
                                                        label: 'Yellow Phase',
                                                        data: tempData.yellowPhase,
                                                        borderColor: '#ffc107',
                                                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                                                        borderWidth: 2,
                                                        fill: false,
                                                        tension: 0.3,
                                                        pointRadius: 3,
                                                        pointHoverRadius: 6
                                                    },
                                                    {
                                                        label: 'Blue Phase',
                                                        data: tempData.bluePhase,
                                                        borderColor: '#0d6efd',
                                                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                                                        borderWidth: 2,
                                                        fill: false,
                                                        tension: 0.3,
                                                        pointRadius: 3,
                                                        pointHoverRadius: 6
                                                    }
                                                ]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                interaction: {
                                                    intersect: false,
                                                    mode: 'index'
                                                },
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        grid: {
                                                            color: '#ddd',
                                                            drawBorder: false,
                                                            borderDash: [5, 5]
                                                        },
                                                        ticks: {
                                                            stepSize: 5,
                                                            callback: function(value) {
                                                                return value + '°C';
                                                            }
                                                        },
                                                        title: {
                                                            display: true,
                                                            text: 'Temperature (°C)'
                                                        }
                                                    },
                                                    x: {
                                                        grid: {
                                                            display: false
                                                        },
                                                        ticks: {
                                                            maxRotation: 45,
                                                            minRotation: 0
                                                        }
                                                    }
                                                },
                                                plugins: {
                                                    legend: {
                                                        display: true,
                                                        position: 'top'
                                                    },
                                                    tooltip: {
                                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                                        titleColor: 'white',
                                                        bodyColor: 'white',
                                                        borderColor: 'rgba(255, 255, 255, 0.1)',
                                                        borderWidth: 1,
                                                        callbacks: {
                                                            label: function(context) {
                                                                return context.dataset.label + ': ' + context.parsed.y +
                                                                    '°C';
                                                            }
                                                        }
                                                    }
                                                },
                                                animation: {
                                                    duration: 750,
                                                    easing: 'easeInOutQuart'
                                                }
                                            }
                                        });

                                        console.log('Thermal chart rendered successfully');
                                    } catch (error) {
                                        console.error('Error rendering thermal chart:', error);
                                        showChartError('thermalChart', 'Failed to load temperature chart');
                                    }
                                }

                                // Partial Discharge Chart Functions
                                async function fetchPDData() {
                                    try {
                                        showChartLoading('PD');

                                        const substationId = pdSubstationFilter?.value || '';
                                        const panelId = pdPanelFilter?.value || '';
                                        const compartmentId = pdCompartmentFilter?.value || '';
                                        const timeGap = pdTimeGapFilter?.value || '5min';

                                        // ADDED: Include year and month in request
                                        const year = yearFilter?.value || new Date().getFullYear();
                                        const month = monthFilter?.value || '';

                                        const requestData = {
                                            substation: substationId,
                                            panel: panelId,
                                            compartment: compartmentId,
                                            timeGap: timeGap,
                                            year: year, // ADDED
                                            month: month // ADDED
                                        };

                                        console.log('PD Request Data:', requestData);

                                        const res = await fetch('/dashboard/sensor-partial-discharge', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                    ?.getAttribute('content')
                                            },
                                            body: JSON.stringify(requestData)
                                        });

                                        if (!res.ok) {
                                            const errorText = await res.text();
                                            console.error('Server Error Response:', errorText);
                                            throw new Error(`HTTP error! Status: ${res.status} - ${errorText}`);
                                        }

                                        const data = await res.json();
                                        console.log('PD Response Data:', data);

                                        if (!data || data.length === 0) {
                                            console.warn("No partial discharge data available for selected period");
                                            showChartError('pdChart', 'Failed to load partial discharge chart');

                                            showSensorNotAvailable('pdChart');
                                            return {
                                                labels: [],
                                                indicators: [],
                                                meanRatios: [],
                                                meanEPPCs: []
                                            };
                                        }

                                        const reversed = [...data].reverse();

                                        return {
                                            labels: reversed.map(d => formatDateLabel(d.created_at, timeGap)),
                                            indicators: reversed.map(d => parseFloat(d.Indicator) || 0),
                                            meanRatios: reversed.map(d => parseFloat(d.Mean_Ratio) || 0),
                                            meanEPPCs: reversed.map(d => parseFloat(d.Mean_EPPC) || 0)
                                        };
                                    } catch (err) {
                                        console.error('Detailed PD Error:', {
                                            message: err.message,
                                            stack: err.stack,
                                            timeGap: pdTimeGapFilter?.value
                                        });

                                        showChartError('pdChart', 'Failed to load partial discharge data');
                                        return {
                                            labels: [],
                                            indicators: [],
                                            meanRatios: [],
                                            meanEPPCs: []
                                        };
                                    } finally {
                                        hideChartLoading('PD');
                                    }
                                }

                                async function renderPDChart() {
                                    try {
                                        console.log('Starting PD chart render...');

                                        const pdData = await fetchPDData();
                                        console.log('PD data received:', pdData);

                                        if (pdData.labels.length === 0) {
                                            showChartError('pdChart', 'Failed to load partial discharge chart');
                                            return;
                                        }

                                        hideErrorMessages('pdChart');

                                        if (pdChartInstance) {
                                            pdChartInstance.destroy();
                                        }

                                        pdChartInstance = new Chart(pdCtx, {
                                            type: 'line',
                                            data: {
                                                labels: pdData.labels,
                                                datasets: [{
                                                        label: 'Indicator',
                                                        data: pdData.indicators,
                                                        borderColor: '#2563eb',
                                                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                                                        borderWidth: 2,
                                                        fill: false,
                                                        tension: 0.3,
                                                        pointRadius: 3,
                                                        pointHoverRadius: 6
                                                    },
                                                    // {
                                                    //     label: 'Mean Ratio (dB)',
                                                    //     data: pdData.meanRatios,
                                                    //     borderColor: '#f59e0b',
                                                    //     backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                                    //     borderWidth: 2,
                                                    //     fill: false,
                                                    //     tension: 0.3,
                                                    //     pointRadius: 3,
                                                    //     pointHoverRadius: 6
                                                    // },
                                                    // {
                                                    //     label: 'Mean EPPC',
                                                    //     data: pdData.meanEPPCs,
                                                    //     borderColor: '#ef4444',
                                                    //     backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                                    //     borderWidth: 2,
                                                    //     fill: false,
                                                    //     tension: 0.3,
                                                    //     pointRadius: 3,
                                                    //     pointHoverRadius: 6
                                                    // }
                                                ]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                interaction: {
                                                    intersect: false,
                                                    mode: 'index'
                                                },
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        grid: {
                                                            color: '#ddd',
                                                            drawBorder: false,
                                                            borderDash: [5, 5]
                                                        },
                                                        ticks: {
                                                            stepSize: 1
                                                        }
                                                    },
                                                    x: {
                                                        grid: {
                                                            display: false
                                                        },
                                                        ticks: {
                                                            maxRotation: 45,
                                                            minRotation: 0
                                                        }
                                                    }
                                                },
                                                plugins: {
                                                    legend: {
                                                        display: true,
                                                        position: 'top'
                                                    },
                                                    tooltip: {
                                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                                        titleColor: 'white',
                                                        bodyColor: 'white',
                                                        borderColor: 'rgba(255, 255, 255, 0.1)',
                                                        borderWidth: 1
                                                    }
                                                },
                                                animation: {
                                                    duration: 750,
                                                    easing: 'easeInOutQuart'
                                                }
                                            }
                                        });

                                        console.log('PD chart rendered successfully');
                                    } catch (error) {
                                        console.error('Error rendering PD chart:', error);
                                        showChartError('pdChart', 'Failed to load partial discharge chart');
                                    }
                                }

                                function showSensorNotAvailable(chartId) {
                                    const canvas = document.getElementById(chartId);
                                    if (!canvas) return;

                                    const container = canvas.closest('.card-body') || canvas.parentElement;

                                    canvas.style.display = 'none';
                                    if (chartId === 'thermalChart' && chartInstance) {
                                        chartInstance.destroy();
                                        chartInstance = null;
                                    } else if (chartId === 'pdChart' && pdChartInstance) {
                                        pdChartInstance.destroy();
                                        pdChartInstance = null;
                                    }

                                    const existingErrors = container.querySelectorAll('.sensor-error-message, .chart-error-message');
                                    existingErrors.forEach(error => error.remove());

                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'alert alert-info text-center p-4 chart-error-message';
                                    errorDiv.innerHTML = `
            <i class="bi bi-exclamation-circle fs-1 text-info"></i>
            <h6 class="mt-2">Sensor Not Available</h6>
            <small class="text-muted">Please select a different sensor combination.</small>
        `;
                                    container.appendChild(errorDiv);
                                }

                                function showChartError(chartId, message) {
                                    const canvas = document.getElementById(chartId);
                                    if (!canvas) return;

                                    const container = canvas.closest('.card-body') || canvas.parentElement;

                                    canvas.style.display = 'none';
                                    if (chartId === 'thermalChart' && chartInstance) {
                                        chartInstance.destroy();
                                        chartInstance = null;
                                    } else if (chartId === 'pdChart' && pdChartInstance) {
                                        pdChartInstance.destroy();
                                        pdChartInstance = null;
                                    }

                                    const existingErrors = container.querySelectorAll('.sensor-error-message, .chart-error-message');
                                    existingErrors.forEach(error => error.remove());

                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'alert alert-warning text-center p-4 chart-error-message';
                                    errorDiv.innerHTML = `
            <i class="bi bi-exclamation-triangle fs-1 text-warning"></i>
            <h6 class="mt-2">${message}</h6>
            <small class="text-muted">Please check console for details</small>
        `;
                                    setTimeout(function() {
                                        location.reload();
                                    }, 3000);
                                    container.appendChild(errorDiv);
                                }

                                function hideErrorMessages(chartId) {
                                    const canvas = document.getElementById(chartId);
                                    if (!canvas) return;

                                    const container = canvas.closest('.card-body') || canvas.parentElement;
                                    canvas.style.display = 'block';

                                    const existingErrors = container.querySelectorAll('.sensor-error-message, .chart-error-message');
                                    existingErrors.forEach(error => error.remove());
                                }

                                // Cascade filter functionality
                                function setupCascadeFilters() {
                                    // Thermal Chart Cascade Filters
                                    async function updateThermalPanelOptions(substationId) {
                                        try {
                                            thermalPanelFilter.innerHTML = '<option value="">Select Panel</option>';
                                            thermalCompartmentFilter.innerHTML = '<option value="">Select Compartment</option>';

                                            const response = await fetch('/dashboard/get-panels', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                        ?.getAttribute('content')
                                                },
                                                body: JSON.stringify({
                                                    substation_id: substationId
                                                })
                                            });

                                            if (response.ok) {
                                                const panels = await response.json();
                                                panels.forEach(panel => {
                                                    thermalPanelFilter.innerHTML +=
                                                        `<option value="${panel.id}">${panel.panel_name}</option>`;
                                                });
                                            }
                                        } catch (error) {
                                            console.error('Error updating thermal panel options:', error);
                                        }
                                    }

                                    async function updateThermalCompartmentOptions(panelId) {
                                        try {
                                            thermalCompartmentFilter.innerHTML = '<option value="">Select Compartment</option>';

                                            const response = await fetch('/dashboard/get-compartments', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                        ?.getAttribute('content')
                                                },
                                                body: JSON.stringify({
                                                    panel_id: panelId
                                                })
                                            });

                                            if (response.ok) {
                                                const compartments = await response.json();
                                                compartments.forEach(compartment => {
                                                    thermalCompartmentFilter.innerHTML +=
                                                        `<option value="${compartment.id}">${compartment.compartment_name}</option>`;
                                                });
                                            }
                                        } catch (error) {
                                            console.error('Error updating thermal compartment options:', error);
                                        }
                                    }

                                    // PD Chart Cascade Filters
                                    async function updatePDPanelOptions(substationId) {
                                        try {
                                            pdPanelFilter.innerHTML = '<option value="">Select Panel</option>';
                                            pdCompartmentFilter.innerHTML = '<option value="">Select Compartment</option>';

                                            const response = await fetch('/dashboard/get-panels', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                        ?.getAttribute('content')
                                                },
                                                body: JSON.stringify({
                                                    substation_id: substationId
                                                })
                                            });

                                            if (response.ok) {
                                                const panels = await response.json();
                                                panels.forEach(panel => {
                                                    pdPanelFilter.innerHTML +=
                                                        `<option value="${panel.id}">${panel.panel_name}</option>`;
                                                });
                                            }
                                        } catch (error) {
                                            console.error('Error updating PD panel options:', error);
                                        }
                                    }

                                    async function updatePDCompartmentOptions(panelId) {
                                        try {
                                            pdCompartmentFilter.innerHTML = '<option value="">Select Compartment</option>';

                                            const response = await fetch('/dashboard/get-compartments', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                        ?.getAttribute('content')
                                                },
                                                body: JSON.stringify({
                                                    panel_id: panelId
                                                })
                                            });

                                            if (response.ok) {
                                                const compartments = await response.json();
                                                compartments.forEach(compartment => {
                                                    pdCompartmentFilter.innerHTML +=
                                                        `<option value="${compartment.id}">${compartment.compartment_name}</option>`;
                                                });
                                            }
                                        } catch (error) {
                                            console.error('Error updating PD compartment options:', error);
                                        }
                                    }

                                    // Event listeners for cascade filters
                                    if (thermalSubstationFilter) {
                                        thermalSubstationFilter.addEventListener('change', function() {
                                            updateThermalPanelOptions(this.value);
                                        });
                                    }

                                    if (thermalPanelFilter) {
                                        thermalPanelFilter.addEventListener('change', function() {
                                            updateThermalCompartmentOptions(this.value);
                                        });
                                    }

                                    if (pdSubstationFilter) {
                                        pdSubstationFilter.addEventListener('change', function() {
                                            updatePDPanelOptions(this.value);
                                        });
                                    }

                                    if (pdPanelFilter) {
                                        pdPanelFilter.addEventListener('change', function() {
                                            updatePDCompartmentOptions(this.value);
                                        });
                                    }
                                }

                                // Auto-refresh functionality
                                function setupAutoRefresh() {
                                    setInterval(() => {
                                        console.log('Auto-refreshing charts...');
                                        renderChart();
                                        renderPDChart();
                                    }, RELOAD_INTERVAL_MS);
                                }

                                // Initialize everything
                                function init() {
                                    console.log('Initializing dashboard...');

                                    setupCascadeFilters();
                                    renderChart();
                                    renderPDChart();
                                    setupAutoRefresh();

                                    console.log('Dashboard initialization complete');
                                }

                                // Start the application
                                init();
                            });
                        </script>

                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
