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
                <label for="timeGapFilter" class="form-label mb-0 fw-semibold">Time Gap:</label>
                <select id="timeGapFilter" class="form-select form-select-sm" style="width: auto; min-width: 120px;">
                    <option value="5min">Every 5 Minutes</option>
                    <option value="10min">Every 10 Minutes</option>
                    <option value="30min">Every 30 Minutes</option>
                    <option value="hourly">Hourly</option>
                </select>
            </div>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-20">
                    <div class="row">

                        <!-- Total Substations Card -->
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="icon-wrapper mb-3">
                                        <div class="icon-circle bg-primary-subtle">
                                            <i class="bi bi-building text-primary fs-2"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title text-muted mb-2">Total Substations</h5>
                                    <h2 class="fw-bold text-primary mb-0" id="total-substations">{{ $total_substation }}
                                    </h2>
                                    <small class="text-success">
                                        <i class="bi bi-arrow-up"></i> Active
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Total Sensors Card -->
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="icon-wrapper mb-3">
                                        <div class="icon-circle bg-info-subtle">
                                            <i class="bi bi-cpu text-info fs-2"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title text-muted mb-2">Total Sensors</h5>
                                    <h2 class="fw-bold text-info mb-0" id="total-sensors">{{ $total_sensor }}</h2>
                                    <small class="text-success">
                                        <i class="bi bi-check-circle"></i> Online
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Total Alarms Card -->
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="icon-wrapper mb-3">
                                        <div class="icon-circle bg-danger-subtle">
                                            <i class="bi bi-exclamation-triangle text-danger fs-2"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title text-muted mb-2">Total Alarms</h5>
                                    <h2 class="fw-bold text-danger mb-0" id="total-alarms">{{ $total_failure }}</h2>
                                    <small class="text-danger">
                                        <i class="bi bi-arrow-up"></i> Active
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Warning State Card -->
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="icon-wrapper mb-3">
                                        <div class="icon-circle bg-warning-subtle">
                                            <i class="bi bi-exclamation-circle text-warning fs-2"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title text-muted mb-2">Warning State</h5>
                                    <h2 class="fw-bold text-warning mb-0" id="total-warnings">{{ $total_warning ?? 0 }}
                                    </h2>
                                    <small class="text-warning">
                                        <i class="bi bi-clock"></i> Pending
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Critical State Card -->
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="icon-wrapper mb-3">
                                        <div class="icon-circle bg-danger-subtle">
                                            <i class="bi bi-x-octagon text-danger fs-2"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title text-muted mb-2">Critical State</h5>
                                    <h2 class="fw-bold text-danger mb-0" id="total-critical">{{ $total_critical ?? 0 }}
                                    </h2>
                                    <small class="text-danger">
                                        <i class="bi bi-arrow-up"></i> High Priority
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Resolved Issues Card -->
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card info-card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="icon-wrapper mb-3">
                                        <div class="icon-circle bg-success-subtle">
                                            <i class="bi bi-check-circle text-success fs-2"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title text-muted mb-2">Issues Resolved</h5>
                                    <h2 class="fw-bold text-success mb-0" id="total-resolved">{{ $total_resolved ?? 0 }}
                                    </h2>
                                    <small class="text-success">
                                        <i class="bi bi-arrow-up"></i> This Period
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Sensor Temperature --}}
                        <div class="col-lg-12">
                            <div class="card shadow-lg border-0 rounded-4 p-3"
                                style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                                <div class="card-body">
                                    <!-- Title & Filters -->
                                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                        <h5 class="card-title mb-0">Sensor Temperature °C</h5>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span>Substation</span>
                                            <select name="substation" class="form-select form-select-sm w-auto">
                                                @foreach ($substations as $substation)
                                                    <option value="{{ $substation->id }}">
                                                        {{ $substation->substation_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span>Panels</span>
                                            <select name="panel" class="form-select form-select-sm w-auto">
                                                @foreach ($panels as $panel)
                                                    <option value="{{ $panel->id }}">{{ $panel->panel_name }}</option>
                                                @endforeach
                                            </select>
                                            <span>Compartments</span>
                                            <select name="compartment" class="form-select form-select-sm w-auto">
                                                @foreach ($compartments as $compartment)
                                                    <option value="{{ $compartment->id }}">
                                                        {{ $compartment->compartment_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Chart -->
                                    <div class="position-relative">
                                        <canvas id="tempChart" style="height: 400px;"></canvas>
                                        <div id="chartLoadingTemp" class="chart-loading d-none">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Legend & Info -->
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span class="d-flex align-items-center"><span
                                                    class="rounded-circle bg-danger d-inline-block me-2"
                                                    style="width: 10px; height: 10px;"></span> Red Phase</span>
                                            <span class="d-flex align-items-center"><span
                                                    class="rounded-circle bg-warning d-inline-block me-2"
                                                    style="width: 10px; height: 10px;"></span> Yellow Phase</span>
                                            <span class="d-flex align-items-center"><span
                                                    class="rounded-circle bg-primary d-inline-block me-2"
                                                    style="width: 10px; height: 10px;"></span> Blue Phase</span>
                                        </div>

                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span>Variance between wires</span>
                                                <input id="variance_avg" class="form-control text-center w-25" readonly>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span>Maximum variances</span>
                                                <input id="variance_max" class="form-control text-center w-25" readonly>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span>Difference max & min temperature</span>
                                                <input id="temp_diff" class="form-control text-center w-25" readonly>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Maximum temperature</span>
                                                <input id="temp_max" class="form-control text-center w-25" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sensor Partial Discharge --}}
                        <div class="col-lg-12">
                            <div class="card shadow-lg border-0 rounded-4 p-3"
                                style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                                <div class="card-body">
                                    <!-- Title & Filters -->
                                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                        <h5 class="card-title mb-0">Sensor Partial Discharge</h5>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span>Substation</span>
                                            <select name="substation_pd" class="form-select form-select-sm w-auto">
                                                @foreach ($substations as $substation)
                                                    <option value="{{ $substation->id }}">
                                                        {{ $substation->substation_name }}</option>
                                                @endforeach
                                            </select>
                                            <span>Panels</span>
                                            <select name="panel_pd" class="form-select form-select-sm w-auto">
                                                @foreach ($panels as $panel)
                                                    <option value="{{ $panel->id }}">{{ $panel->panel_name }}</option>
                                                @endforeach
                                            </select>
                                            <span>Compartments</span>
                                            <select name="compartment_pd" class="form-select form-select-sm w-auto">
                                                @foreach ($compartments as $compartment)
                                                    <option value="{{ $compartment->id }}">
                                                        {{ $compartment->compartment_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                        </div>

                        <!-- Chart.js Script -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const ctx = document.getElementById('tempChart').getContext('2d');
                                const pdCtx = document.getElementById('pdChart').getContext('2d');
                                let chartInstance;
                                let pdChartInstance;

                                const RELOAD_INTERVAL_MS = 300000;

                                // let lastAlertState = null;
                                // let lastSensorId = null;

                                // Filter elements
                                const yearFilter = document.getElementById('yearFilter');
                                const monthFilter = document.getElementById('monthFilter');
                                const timeGapFilter = document.getElementById('timeGapFilter');

                                // Add event listeners for all filters
                                [yearFilter, monthFilter, timeGapFilter].forEach(filter => {
                                    filter.addEventListener('change', function() {
                                        console.log('Filter changed:', {
                                            year: yearFilter.value,
                                            month: monthFilter.value,
                                            timeGap: timeGapFilter.value
                                        });
                                        renderChart();
                                        renderPDChart();
                                        refreshDashboardStats();
                                    });
                                });

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
                                                year: yearFilter.value,
                                                month: monthFilter.value || null,
                                                timeGap: timeGapFilter.value
                                            })
                                        });

                                        if (!response.ok) {
                                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                                        }

                                        const data = await response.json();

                                        // Validate data structure
                                        if (!data || typeof data !== 'object') {
                                            throw new Error('Invalid data format received');
                                        }

                                        // Update the cards with new data
                                        updateDashboardCards(data);

                                    } catch (error) {
                                        console.error('Error refreshing dashboard stats:', error);

                                        // Optional: Show fallback data or disable related features
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
                                    // Show user-friendly error message
                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'alert alert-warning alert-dismissible fade show';
                                    errorDiv.innerHTML = `
        <strong>Connection Issue:</strong> Unable to refresh dashboard data. Please check your connection and try again.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
                                    document.querySelector('.main').prepend(errorDiv);
                                }

                                function formatDateLabel(dateString, timeGap) {
                                    const date = new Date(dateString);

                                    switch (timeGap) {
                                        case '5min':
                                            return date.toLocaleString('en-US', {
                                                month: 'short',
                                                day: 'numeric',
                                                hour: '2-digit',
                                                minute: '2-digit'
                                            });
                                        case '10min':
                                            return date.toLocaleString('en-US', {
                                                month: 'short',
                                                day: 'numeric',
                                                hour: '2-digit',
                                                minute: '2-digit'
                                            });
                                        case '30min':
                                            return date.toLocaleString('en-US', {
                                                month: 'short',
                                                day: 'numeric',
                                                hour: '2-digit',
                                                minute: '2-digit'
                                            });
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

                                        const substationId = document.querySelector('select[name=substation]').value;
                                        const panelId = document.querySelector('select[name=panel]').value;
                                        const compartmentId = document.querySelector('select[name=compartment]').value;

                                        const res = await fetch('/dashboard/sensor-temperature', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                    .getAttribute('content')
                                            },
                                            body: JSON.stringify({
                                                substation: substationId,
                                                panel: panelId,
                                                compartment: compartmentId,
                                                year: yearFilter.value,
                                                month: monthFilter.value || null,
                                                timeGap: timeGapFilter.value
                                            })
                                        });

                                        if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);

                                        const data = await res.json();
                                        if (!data || data.length === 0) {
                                            throw new Error("No temperature data available for selected period");
                                        }

                                        const reversed = [...data].reverse();

                                        return {
                                            labels: reversed.map(d => formatDateLabel(d.created_at, timeGapFilter.value)),
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

                                    // Avoid division by zero
                                    const variance = maxTemp === 0 ? 0 : ((tempDiff / maxTemp) * 100);

                                    return {
                                        varianceAvg: variance.toFixed(2), // Actual variance from 3-phase temps
                                        varianceMax: 10.00.toFixed(2), // Static threshold for limit
                                        tempDiff: tempDiff.toFixed(2), // Max - Min difference
                                        tempMax: 30.00.toFixed(2) // Static maximum allowed temperature
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

                                    if (varianceAvgElement) varianceAvgElement.value = stats.varianceAvg + '°C';
                                    if (varianceMaxElement) varianceMaxElement.value = stats.varianceMax + '°C';
                                    if (tempDiffElement) tempDiffElement.value = stats.tempDiff + '°C';
                                    if (tempMaxElement) tempMaxElement.value = stats.tempMax + '°C';
                                }

                                async function renderChart() {
                                    const tempData = await fetchTemperatureData();

                                    if (chartInstance) {
                                        chartInstance.destroy();
                                    }

                                    // Update temperature statistics
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
                                }

                                // Partial Discharge Chart Functions
                                async function fetchPDData() {
                                    try {
                                        showChartLoading('PD');

                                        const substationId = document.querySelector('select[name=substation_pd]').value;
                                        const panelId = document.querySelector('select[name=panel_pd]').value;
                                        const compartmentId = document.querySelector('select[name=compartment_pd]').value;

                                        const requestData = {
                                            substation: substationId,
                                            panel: panelId,
                                            compartment: compartmentId,
                                            year: yearFilter.value,
                                            month: monthFilter.value || null,
                                            timeGap: timeGapFilter.value
                                        };

                                        console.log('PD Request Data:', requestData); // Debug log

                                        const res = await fetch('/dashboard/sensor-partial-discharge', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                    .getAttribute('content')
                                            },
                                            body: JSON.stringify(requestData)
                                        });

                                        // Enhanced error handling
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
                                            labels: reversed.map(d => formatDateLabel(d.created_at, timeGapFilter.value)),
                                            indicators: reversed.map(d => parseFloat(d.Indicator) || 0),
                                            meanRatios: reversed.map(d => parseFloat(d.Mean_Ratio) || 0),
                                            meanEPPCs: reversed.map(d => parseFloat(d.Mean_EPPC) || 0)
                                        };
                                    } catch (err) {
                                        console.error('Detailed PD Error:', {
                                            message: err.message,
                                            stack: err.stack,
                                            timeGap: timeGapFilter.value,
                                            year: yearFilter.value,
                                            month: monthFilter.value
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

                                // Cascade filter functionality
                                function setupCascadeFilters() {
                                    const substationSelect = document.querySelector('select[name="substation"]');
                                    const panelSelect = document.querySelector('select[name="panel"]');
                                    const compartmentSelect = document.querySelector('select[name="compartment"]');

                                    const substationPDSelect = document.querySelector('select[name="substation_pd"]');
                                    const panelPDSelect = document.querySelector('select[name="panel_pd"]');
                                    const compartmentPDSelect = document.querySelector('select[name="compartment_pd"]');

                                    async function updatePanels(substationId, targetPanelSelect) {
                                        if (!substationId) return;

                                        try {
                                            const response = await fetch(`/dashboard/panels/${substationId}`);
                                            if (response.ok) {
                                                const panels = await response.json();
                                                targetPanelSelect.innerHTML = '<option value="">Select Panel</option>';
                                                panels.forEach(panel => {
                                                    targetPanelSelect.innerHTML +=
                                                        `<option value="${panel.id}">${panel.panel_name}</option>`;
                                                });
                                            }
                                        } catch (error) {
                                            console.error('Error fetching panels:', error);
                                        }
                                    }

                                    async function updateCompartments(panelId, targetCompartmentSelect) {
                                        if (!panelId) return;

                                        try {
                                            const response = await fetch(`/dashboard/compartments/${panelId}`);
                                            if (response.ok) {
                                                const compartments = await response.json();
                                                targetCompartmentSelect.innerHTML = '<option value="">Select Compartment</option>';
                                                compartments.forEach(compartment => {
                                                    targetCompartmentSelect.innerHTML +=
                                                        `<option value="${compartment.id}">${compartment.compartment_name}</option>`;
                                                });
                                            }
                                        } catch (error) {
                                            console.error('Error fetching compartments:', error);
                                        }
                                    }

                                    // Temperature chart filters
                                    if (substationSelect) {
                                        substationSelect.addEventListener('change', function() {
                                            updatePanels(this.value, panelSelect);
                                            renderChart();
                                        });
                                    }

                                    if (panelSelect) {
                                        panelSelect.addEventListener('change', function() {
                                            updateCompartments(this.value, compartmentSelect);
                                            renderChart();
                                        });
                                    }

                                    if (compartmentSelect) {
                                        compartmentSelect.addEventListener('change', renderChart);
                                    }

                                    // PD chart filters
                                    if (substationPDSelect) {
                                        substationPDSelect.addEventListener('change', function() {
                                            updatePanels(this.value, panelPDSelect);
                                            renderPDChart();
                                        });
                                    }

                                    if (panelPDSelect) {
                                        panelPDSelect.addEventListener('change', function() {
                                            updateCompartments(this.value, compartmentPDSelect);
                                            renderPDChart();
                                        });
                                    }

                                    if (compartmentPDSelect) {
                                        compartmentPDSelect.addEventListener('change', renderPDChart);
                                    }
                                }

                                // Initialize everything
                                function initialize() {
                                    renderChart();
                                    renderPDChart();
                                    setupCascadeFilters();

                                    // Set up periodic updates
                                    setInterval(() => {
                                        renderChart();
                                        renderPDChart();
                                        refreshDashboardStats();
                                        // checkForAlerts();
                                    }, RELOAD_INTERVAL_MS);

                                }

                                // Start the application
                                initialize();

                                // Make functions globally accessible if needed
                                window.renderChart = renderChart;
                                window.renderPDChart = renderPDChart;
                                window.refreshDashboardStats = refreshDashboardStats;
                            });
                        </script>

                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
