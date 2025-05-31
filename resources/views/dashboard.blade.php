@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

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
                                    </div>
                                </div>
                            </div>

                            <!-- Total Sensors Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <div class="card info-card h-100 border-0 shadow-sm hover-card">
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
                                    </div>
                                </div>
                            </div>

                            <!-- Total Alarms Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper mb-2">
                                            <div class="icon-circle bg-danger-subtle"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                                            </div>
                                        </div>
                                        <h5 class="card-title text-muted mb-1 small">Total Alarms</h5>
                                        <h3 class="fw-bold text-danger mb-0" id="total-alarms">{{ $total_failure }}</h3>
                                        <small class="text-danger">
                                            <i class="bi bi-file-text"></i> All Error Logs
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Issues Resolved Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="row mb-2">
                            <!-- Critical State Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
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
                                    </div>
                                </div>
                            </div>

                            <!-- Warning State Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
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
                                    </div>
                                </div>
                            </div>

                            <!-- Total Review Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper mb-2">
                                            <div class="icon-circle bg-info-subtle"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                <i class="bi bi-clipboard-check text-info fs-4"></i>
                                            </div>
                                        </div>
                                        <h5 class="card-title text-muted mb-1 small">Total Review</h5>
                                        <h3 class="fw-bold text-info mb-0" id="total_review">{{ $total_review ?? 0 }}
                                        </h3>
                                        <small class="text-info">
                                            <i class="bi bi-hourglass-split"></i> Pending Review
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Query Card -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper mb-2">
                                            <div class="icon-circle bg-warning-subtle"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto;">
                                                <i class="bi bi-arrow-counterclockwise text-warning fs-4"></i>
                                            </div>
                                        </div>
                                        <h5 class="card-title text-muted mb-1 small">Total Query</h5>
                                        <h3 class="fw-bold text-warning mb-0" id="total-query">{{ $total_query ?? 0 }}
                                        </h3>
                                        <small class="text-warning">
                                            <i class="bi bi-question-circle"></i> Manager Query
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sensor Chart Filter --}}
                        <div class="card shadow-sm border-0 rounded-3 mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Sensor Chart Filters</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="GET" class="row g-3">

                                    <!-- Substation Filter -->
                                    <div class="col-md-4 col-lg-3">
                                        <label class="form-label small text-muted">Substation</label>
                                        <select class="form-select form-select-sm" name="substation"
                                            id="substationFilter">
                                            @if (isset($substations) && count($substations) > 0)
                                                @foreach ($substations as $substation)
                                                    <option value="{{ $substation->id }}"
                                                        {{ request('substation') == $substation->id ? 'selected' : '' }}>
                                                        {{ $substation->substation_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Panel Filter -->
                                    <div class="col-md-4 col-lg-3">
                                        <label class="form-label small text-muted">Panel</label>
                                        <select class="form-select form-select-sm" name="panel" id="panelFilter">
                                            @if (isset($panels) && count($panels) > 0)
                                                @foreach ($panels as $panel)
                                                    <option value="{{ $panel->id }}"
                                                        {{ request('panel') == $panel->id ? 'selected' : '' }}>
                                                        {{ $panel->panel_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Compartment Filter -->
                                    <div class="col-md-4 col-lg-3">
                                        <label class="form-label small text-muted">Compartment</label>
                                        <select class="form-select form-select-sm" name="compartment"
                                            id="compartmentFilter">
                                            @if (isset($compartments) && count($compartments) > 0)
                                                @foreach ($compartments as $compartment)
                                                    <option value="{{ $compartment->id }}"
                                                        {{ request('compartment') == $compartment->id ? 'selected' : '' }}>
                                                        {{ $compartment->compartment_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Time Gap Filter -->
                                    <div class="col-md-4 col-lg-3">
                                        <label for="timeGapFilter" class="form-label small text-muted">Time Gap</label>
                                        <select id="timeGapFilter" class="form-select form-select-sm" name="time_gap">
                                            <option value="5min" {{ request('time_gap') == '5min' ? 'selected' : '' }}>
                                                Every 5 Minutes</option>
                                            <option value="10min" {{ request('time_gap') == '10min' ? 'selected' : '' }}>
                                                Every 10 Minutes</option>
                                            <option value="30min" {{ request('time_gap') == '30min' ? 'selected' : '' }}>
                                                Every 30 Minutes</option>
                                            <option value="hourly"
                                                {{ request('time_gap') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Sensor Temperature --}}
                        <div class="card shadow-sm border-0 rounded-3 mb-4" id="thermalChartContainer"
                            style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                            <div class="card-body">
                                <!-- Title -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Sensor Thermal °C</h5>
                                </div>

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
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title mb-3">Temperature Stats</h6>
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
                                                    <h6 class="card-title mb-3">Variance Stats</h6>
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

                        {{-- Sensor Partial Discharge --}}
                        <div class="card shadow-sm border-0 rounded-3 mb-4" id="partialDischargeChart"
                            style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                            <div class="card-body">
                                <!-- Title -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Sensor Partial Discharge</h5>
                                </div>

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
                                if (typeof Chart === 'undefined') {
                                    console.error('Chart.js is not loaded!');
                                    return;
                                }

                                // Updated chart initialization
                                const ctx = document.getElementById('thermalChart');
                                if (!ctx) {
                                    console.error('Canvas element with ID "thermalChart" not found!');
                                    return;
                                }

                                const chartContext = ctx.getContext('2d');
                                const pdCtx = document.getElementById('pdChart');
                                let chartInstance;
                                let pdChartInstance;

                                const RELOAD_INTERVAL_MS = 300000;

                                // Updated filter elements - now using unified filters
                                const yearFilter = document.getElementById('yearFilter');
                                const monthFilter = document.getElementById('monthFilter');
                                const timeGapFilter = document.getElementById('timeGapFilter');
                                const substationFilter = document.getElementById('substationFilter');
                                const panelFilter = document.getElementById('panelFilter');
                                const compartmentFilter = document.getElementById('compartmentFilter');

                                // Add event listeners for all unified filters
                                [yearFilter, monthFilter, timeGapFilter, substationFilter, panelFilter, compartmentFilter].forEach(
                                    filter => {
                                        if (filter) {
                                            filter.addEventListener('change', function() {
                                                console.log('Filter changed:', {
                                                    year: yearFilter?.value,
                                                    month: monthFilter?.value,
                                                    timeGap: timeGapFilter?.value,
                                                    substation: substationFilter?.value,
                                                    panel: panelFilter?.value,
                                                    compartment: compartmentFilter?.value,
                                                });

                                                renderChart();
                                                renderPDChart();
                                                refreshDashboardStats();
                                                toggleCharts();
                                            });
                                        }
                                    });

                                // Chart visibility toggle function
                                function toggleCharts() {
                                    const thermalChart = document.getElementById('thermalChartContainer');
                                    const partialDischargeChart = document.getElementById('partialDischargeChart');

                                    thermalChart.style.display = 'block';
                                    partialDischargeChart.style.display = 'block';

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

                                async function refreshDashboardStats() {
                                    try {
                                        const csrfToken = document.querySelector('meta[name="csrf-token"]');
                                        if (!csrfToken) {
                                            throw new Error('CSRF token not found');
                                        }

                                        const response = await fetch('/dashboard/stats-by-period', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                                            },
                                            body: JSON.stringify({
                                                year: yearFilter?.value,
                                                month: monthFilter?.value || null,
                                                timeGap: timeGapFilter?.value,
                                                substation: substationFilter?.value || null,
                                                panel: panelFilter?.value || null,
                                                compartment: compartmentFilter?.value || null
                                            })
                                        });

                                        if (!response.ok) {
                                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                                        }

                                        const data = await response.json();

                                        if (!data || typeof data !== 'object') {
                                            throw new Error('Invalid data format received');
                                        }

                                        updateDashboardCards(data);

                                    } catch (error) {
                                        console.error('Error refreshing dashboard stats:', error);
                                        showErrorState();
                                    }
                                }

                                function updateDashboardCards(data) {
                                    const updates = [{
                                            id: 'total-substations',
                                            value: data.total_substation || 0
                                        },
                                        {
                                            id: 'total-sensors',
                                            value: data.total_sensor || 0
                                        },
                                        {
                                            id: 'total-alarms',
                                            value: data.total_failure || 0
                                        },
                                        {
                                            id: 'total-warnings',
                                            value: data.total_warning || 0
                                        },
                                        {
                                            id: 'total-critical',
                                            value: data.total_critical || 0
                                        },
                                        {
                                            id: 'total-resolved',
                                            value: data.total_resolved || 0
                                        }
                                    ];

                                    updates.forEach(({
                                        id,
                                        value
                                    }) => {
                                        const element = document.getElementById(id);
                                        if (element) {
                                            element.textContent = value;
                                        } else {
                                            console.warn(`Element with ID '${id}' not found`);
                                        }
                                    });
                                }

                                function showErrorState() {
                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'alert alert-warning alert-dismissible fade show';
                                    errorDiv.innerHTML = `
                                        <strong>Connection Issue:</strong> Unable to refresh dashboard data. Please check your connection and try again.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    `;
                                    document.querySelector('.main')?.prepend(errorDiv);
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

                                // Temperature Chart Functions - Updated to use unified filters
                                async function fetchTemperatureData() {
                                    try {
                                        showChartLoading('Temp');

                                        // Use unified filter values
                                        const substationId = substationFilter?.value || '';
                                        const panelId = panelFilter?.value || '';
                                        const compartmentId = compartmentFilter?.value || '';

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
                                                year: yearFilter?.value,
                                                month: monthFilter?.value || null,
                                                timeGap: timeGapFilter?.value
                                            })
                                        });

                                        if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);

                                        const data = await res.json();
                                        if (!data || data.length === 0) {
                                            throw new Error("No temperature data available for selected period");
                                        }

                                        const reversed = [...data].reverse();

                                        return {
                                            labels: reversed.map(d => formatDateLabel(d.created_at, timeGapFilter?.value)),
                                            redPhase: reversed.map(d => parseFloat(d.Red_Phase) || 0),
                                            yellowPhase: reversed.map(d => parseFloat(d.Yellow_Phase) || 0),
                                            bluePhase: reversed.map(d => parseFloat(d.Blue_Phase) || 0)
                                        };
                                    } catch (err) {
                                        console.error('Error loading temperature data:', err);
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
                                        varianceMax: 10.00.toFixed(2),
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
                                        console.log('Starting chart render...');

                                        const tempData = await fetchTemperatureData();
                                        console.log('Temperature data received:', tempData);

                                        if (chartInstance) {
                                            chartInstance.destroy();
                                        }

                                        updateTemperatureStats(tempData.redPhase, tempData.yellowPhase, tempData.bluePhase);

                                        chartInstance = new Chart(chartContext, {
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

                                        console.log('Chart rendered successfully');
                                    } catch (error) {
                                        console.error('Error rendering chart:', error);
                                        showChartError('thermalChart', 'Failed to load temperature chart');
                                    }
                                }

                                function showChartError(chartId, message) {
                                    const canvas = document.getElementById(chartId);
                                    if (canvas) {
                                        const parent = canvas.parentElement;
                                        parent.innerHTML = `
                                            <div class="alert alert-warning text-center p-4">
                                                <i class="bi bi-exclamation-triangle fs-1 text-warning"></i>
                                                <h6 class="mt-2">${message}</h6>
                                                <small class="text-muted">Please check console for details</small>
                                            </div>
                                        `;
                                    }
                                }

                                // Partial Discharge Chart Functions - Updated to use unified filters
                                async function fetchPDData() {
                                    try {
                                        showChartLoading('PD');

                                        // Use unified filter values
                                        const substationId = substationFilter?.value || '';
                                        const panelId = panelFilter?.value || '';
                                        const compartmentId = compartmentFilter?.value || '';

                                        const requestData = {
                                            substation: substationId,
                                            panel: panelId,
                                            compartment: compartmentId,
                                            year: yearFilter?.value,
                                            month: monthFilter?.value || null,
                                            timeGap: timeGapFilter?.value
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
                                            return {
                                                labels: [],
                                                indicators: [],
                                                meanRatios: [],
                                                meanEPPCs: []
                                            };
                                        }

                                        const reversed = [...data].reverse();

                                        return {
                                            labels: reversed.map(d => formatDateLabel(d.created_at, timeGapFilter?.value)),
                                            indicators: reversed.map(d => parseFloat(d.Indicator) || 0),
                                            meanRatios: reversed.map(d => parseFloat(d.Mean_Ratio) || 0),
                                            meanEPPCs: reversed.map(d => parseFloat(d.Mean_EPPC) || 0)
                                        };
                                    } catch (err) {
                                        console.error('Detailed PD Error:', {
                                            message: err.message,
                                            stack: err.stack,
                                            timeGap: timeGapFilter?.value,
                                            year: yearFilter?.value,
                                            month: monthFilter?.value
                                        });

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
                                    const pdData = await fetchPDData();

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
                                                {
                                                    label: 'Mean Ratio (dB)',
                                                    data: pdData.meanRatios,
                                                    borderColor: '#f59e0b',
                                                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                                    borderWidth: 2,
                                                    fill: false,
                                                    tension: 0.3,
                                                    pointRadius: 3,
                                                    pointHoverRadius: 6
                                                },
                                                {
                                                    label: 'Mean EPPC',
                                                    data: pdData.meanEPPCs,
                                                    borderColor: '#ef4444',
                                                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
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
                                }

                                // Updated cascade filter functionality for unified filters
                                function setupCascadeFilters() {
                                    async function updatePanels(substationId) {
                                        if (!substationId || !panelFilter) return;

                                        try {
                                            const response = await fetch(`/dashboard/panels/${substationId}`);
                                            if (response.ok) {
                                                const panels = await response.json();
                                                panelFilter.innerHTML = '<option value="">All Panels</option>';
                                                panels.forEach(panel => {
                                                    panelFilter.innerHTML +=
                                                        `<option value="${panel.id}">${panel.panel_name}</option>`;
                                                });

                                                // Clear compartment filter when panels change
                                                if (compartmentFilter) {
                                                    compartmentFilter.innerHTML = '<option value="">All Compartments</option>';
                                                }
                                            }
                                        } catch (error) {
                                            console.error('Error fetching panels:', error);
                                        }
                                    }

                                    async function updateCompartments(panelId) {
                                        if (!panelId || !compartmentFilter) return;

                                        try {
                                            const response = await fetch(`/dashboard/compartments/${panelId}`);
                                            if (response.ok) {
                                                const compartments = await response.json();
                                                compartmentFilter.innerHTML = '<option value="">All Compartments</option>';
                                                compartments.forEach(compartment => {
                                                    compartmentFilter.innerHTML +=
                                                        `<option value="${compartment.id}">${compartment.compartment_name}</option>`;
                                                });
                                            }
                                        } catch (error) {
                                            console.error('Error fetching compartments:', error);
                                        }
                                    }

                                    // Set up cascade filter listeners
                                    if (substationFilter) {
                                        substationFilter.addEventListener('change', function() {
                                            updatePanels(this.value);
                                        });
                                    }

                                    if (panelFilter) {
                                        panelFilter.addEventListener('change', function() {
                                            updateCompartments(this.value);
                                        });
                                    }
                                }

                                function initialize() {
                                    try {
                                        console.log('Initializing dashboard...');

                                        // Set initial chart visibility BEFORE rendering charts
                                        toggleCharts();
                                        renderChart();
                                        renderPDChart();

                                        setupCascadeFilters();

                                        // Set up periodic updates
                                        setInterval(() => {
                                            renderChart();
                                            renderPDChart();
                                            refreshDashboardStats();
                                        }, RELOAD_INTERVAL_MS);

                                        console.log('Dashboard initialized successfully');
                                    } catch (error) {
                                        console.error('Error during initialization:', error);
                                    }
                                }
                        
                                window.renderChart = renderChart; 
                                window.renderPDChart = renderPDChart; 
                                window.refreshDashboardStats =
                                refreshDashboardStats;
                                window.toggleCharts = toggleCharts;
                                initialize();
                            });
                        </script>

                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
