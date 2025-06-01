@extends('layouts.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-0">Analytics Sensor</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Analytics Sensor</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section dashboard">
            <div class="container-fluid p-0">
                <!-- Generate Analytics Card -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Generate Analytics</h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="sensorFilterForm" class="row g-3">
                            @csrf
                            <div class="col-md-4 col-lg-2">
                                <label for="sensorSelect" class="form-label small text-muted">Sensor</label>
                                <select name="sensor" id="sensorSelect" class="form-select form-select-sm">
                                    <option value="">Select Sensor</option>
                                    @if (isset($sensors) && count($sensors) > 0)
                                        @foreach ($sensors as $sensor)
                                            <option value="{{ $sensor->id }}">{{ $sensor->sensor_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-2">
                                <label for="startDate" class="form-label small text-muted">Start Date</label>
                                <input type="date" name="start_date" class="form-control form-control-sm" id="startDate">
                            </div>

                            <div class="col-md-4 col-lg-2">
                                <label for="endDate" class="form-label small text-muted">End Date</label>
                                <input type="date" name="end_date" class="form-control form-control-sm" id="endDate">
                            </div>

                            <div class="col-md-4 col-lg-2">
                                <label for="timeRange" class="form-label small text-muted">Time Range</label>
                                <select name="time_range" class="form-select form-select-sm" id="timeRange">
                                    <option value="1">1 Hour</option>
                                    <option value="24">24 Hours</option>
                                    <option value="168">1 Week</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-3 d-flex align-items-end">
                                <div class="w-100 d-flex flex-column flex-md-row gap-2">
                                    <!-- Generate Chart Button -->
                                    <button type="button" id="generateChart" class="btn btn-primary btn-sm w-100"
                                        title="Generate Chart">
                                        <i class="bi bi-bar-chart-fill me-1"></i>Generate
                                    </button>

                                    <!-- Generate Table Button (initially hidden) -->
                                    <button type="button" id="generateTable" class="btn btn-success btn-sm w-100 d-none"
                                        title="Generate Table">
                                        <i class="bi bi-table me-1"></i>Table
                                    </button>

                                    <!-- Download Dropdown -->
                                    <div class="btn-group w-100">
                                        <button type="button"
                                            class="btn btn-outline-secondary btn-sm dropdown-toggle w-100"
                                            data-bs-toggle="dropdown" aria-expanded="false" title="Download Options">
                                            <i class="bi bi-download me-1"></i>Download
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#"
                                                    id="downloadPDF">
                                                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>PDF
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="#"
                                                    id="downloadExcel">
                                                    <i class="bi bi-file-earmark-excel text-success me-2"></i>Excel
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sensor Details Card -->
                <div id="sensorDetails" class="card shadow border-0 rounded-4 mb-4 d-none">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 d-flex align-items-center">
                            <i class="bi bi-info-circle me-2 text-primary"></i>
                            Sensor Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="p-3 bg-light rounded-3 text-center shadow-sm h-100">
                                    <small class="text-muted d-block">Sensor</small>
                                    <strong id="detailSensor" class="text-dark">-</strong>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="p-3 bg-light rounded-3 text-center shadow-sm h-100">
                                    <small class="text-muted d-block">Substation</small>
                                    <strong id="detailSubstation" class="text-dark">-</strong>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="p-3 bg-light rounded-3 text-center shadow-sm h-100">
                                    <small class="text-muted d-block">Panel</small>
                                    <strong id="detailPanel" class="text-dark">-</strong>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="p-3 bg-light rounded-3 text-center shadow-sm h-100">
                                    <small class="text-muted d-block">Compartment</small>
                                    <strong id="detailCompartment" class="text-dark">-</strong>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="p-3 bg-light rounded-3 text-center shadow-sm h-100">
                                    <small class="text-muted d-block">Parameter</small>
                                    <strong id="detailParameter" class="text-dark">-</strong>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="p-3 bg-light rounded-3 text-center shadow-sm h-100">
                                    <small class="text-muted d-block">Date Range</small>
                                    <strong id="rangeDate" class="text-dark">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Loading Spinner -->
                <div id="loadingSpinner" class="text-center my-5 d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-2">Generating analytics...</p>
                </div>

                <!-- Chart Container -->
                <div id="sensorChartContainer" class="card shadow-sm border-0 rounded-3 mb-4 d-none">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Analytics Chart</h5>
                    </div>
                    <div class="card-body p-4">
                        <div style="position: relative; height: 400px;">
                            <canvas id="sensorChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div id="sensorTableContainer" class="card shadow-sm border-0 rounded-3 mb-4 d-none">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="bi bi-table me-2"></i>Analytics Data</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0" id="tableOutput">
                                <thead class="table-light text-center">
                                    <!-- Table Headings -->
                                </thead>
                                <tbody class="text-center">
                                    <!-- Table Body -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sensor List Filter Card -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Sensor List Filters</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4 col-lg-2">
                                <label class="form-label small text-muted">Substation</label>
                                <select class="form-select form-select-sm" name="substation">
                                    <option value="">All Substations</option>
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

                            <div class="col-md-4 col-lg-2">
                                <label class="form-label small text-muted">Panel</label>
                                <select class="form-select form-select-sm" name="panel">
                                    <option value="">All Panels</option>
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

                            <div class="col-md-4 col-lg-2">
                                <label class="form-label small text-muted">Compartment</label>
                                <select class="form-select form-select-sm" name="compartment">
                                    <option value="">All Compartments</option>
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

                            <div class="col-md-4 col-lg-2">
                                <label class="form-label small text-muted">Measurement</label>
                                <select class="form-select form-select-sm" name="measurement">
                                    <option value="">All Measurements</option>
                                    <option value="Temperature"
                                        {{ request('measurement') == 'Temperature' ? 'selected' : '' }}>Temperature
                                    </option>
                                    <option value="Partial Discharge"
                                        {{ request('measurement') == 'Partial Discharge' ? 'selected' : '' }}>Partial
                                        Discharge</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-2">
                                <label class="form-label small text-muted">Status</label>
                                <select class="form-select form-select-sm" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-2 d-flex align-items-end">
                                <div class="d-flex gap-2 w-100">
                                    <button type="submit" class="btn btn-primary btn-sm" title="Apply Filters">
                                        <i class="bi bi-funnel-fill"></i>
                                    </button>
                                    <a href="{{ route('analytics') }}" class="btn btn-outline-secondary btn-sm"
                                        title="Clear Filters">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sensor List Table -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Sensor List</h5>
                        <span class="badge bg-secondary">
                            {{ isset($sensors) ? count($sensors) : 0 }}
                            {{ isset($sensors) ? Str::plural('sensor', count($sensors)) : 'sensors' }}
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th class="py-3">#</th>
                                        <th class="py-3">Sensor Name</th>
                                        <th class="py-3">Location</th>
                                        <th class="py-3">Measurement</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if (isset($sensors) && count($sensors) > 0)
                                        @foreach ($sensors as $sensor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="fw-bold">{{ $sensor->sensor_name ?? 'N/A' }}</div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="fw-bold">{{ $sensor->substation->substation_name ?? 'N/A' }}</span>
                                                        <small class="text-muted">
                                                            {{ $sensor->panel->panel_name ?? 'N/A' }} /
                                                            {{ $sensor->compartment->compartment_name ?? 'N/A' }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>{{ $sensor->sensor_measurement ?? 'N/A' }}</td>
                                                <td>
                                                    <span
                                                        class="badge rounded-pill {{ ($sensor->sensor_status ?? '') === 'Active' ? 'bg-success' : 'bg-secondary' }}"
                                                        style="padding: 8px 12px; font-size: 0.8rem;">
                                                        {{ $sensor->sensor_status ?? 'Unknown' }}
                                                    </span>
                                                </td>
                                                <td>{{ $sensor->updated_at ? $sensor->updated_at->format('M d, Y H:i') : 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="12" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                                    <h5 class="text-muted">No Sensors Found</h5>
                                                    <p class="text-muted">There are no sensors matching your criteria.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('sensorFilterForm');
            const generateTableBtn = document.getElementById('generateTable');
            const generateChartBtn = document.getElementById('generateChart');
            const spinner = document.getElementById('loadingSpinner');
            let sensorChartInstance = null;
            let chartData = null;
            let parameterType = null;

            // Set default dates (last 7 days)
            function setDefaultDates() {
                const today = new Date();
                const lastWeek = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);

                document.getElementById('startDate').value = lastWeek.toISOString().split('T')[0];
                document.getElementById('endDate').value = today.toISOString().split('T')[0];
            }

            // Initialize default dates
            setDefaultDates();

            // Sensor selection handler
            document.getElementById('sensorSelect').addEventListener('change', function() {
                const sensorId = this.value;
                document.getElementById('sensorChartContainer').classList.add('d-none');
                document.getElementById('sensorTableContainer').classList.add('d-none');
                generateTableBtn.classList.add('d-none');

                if (sensorId) {
                    // Check if route exists before making request
                    if (typeof window.routes !== 'undefined' && window.routes.analytics) {
                        fetch(`${window.routes.analytics}/${sensorId}`)
                            .then(res => {
                                if (!res.ok) throw new Error('Network response was not ok');
                                return res.json();
                            })
                            .then(sensor => {
                                document.getElementById('detailSensor').textContent = sensor
                                    .sensor_name || 'N/A';
                                document.getElementById('detailSubstation').textContent = sensor
                                    .substation_name || 'N/A';
                                document.getElementById('detailPanel').textContent = sensor
                                    .panel_name || 'N/A';
                                document.getElementById('detailCompartment').textContent = sensor
                                    .compartment_name || 'N/A';
                                document.getElementById('detailParameter').textContent = sensor
                                    .sensor_measurement || 'N/A';
                                document.getElementById('sensorDetails').classList.remove('d-none');
                            })
                            .catch(err => {
                                console.error('Failed to fetch sensor details:', err);
                                // Set default values on error
                                ['Sensor', 'Substation', 'Panel', 'Compartment', 'Parameter'].forEach(
                                    field =>
                                    document.getElementById(`detail${field}`).textContent = 'N/A'
                                );
                            });
                    }
                } else {
                    document.getElementById('sensorDetails').classList.add('d-none');
                    ['Sensor', 'Substation', 'Panel', 'Compartment', 'Parameter'].forEach(field =>
                        document.getElementById(`detail${field}`).textContent = '-'
                    );
                }
            });

            // Form validation
            function validateForm() {
                const sensor = document.getElementById('sensorSelect').value;
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;

                if (!sensor) {
                    alert('Please select a sensor.');
                    return false;
                }

                if (!startDate || !endDate) {
                    alert('Please select both start and end dates.');
                    return false;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    alert('Start date must be before end date.');
                    return false;
                }

                const daysDiff = (new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24);
                if (daysDiff > 365) {
                    alert('Date range cannot exceed 365 days.');
                    return false;
                }

                return true;
            }

            // Alert level interpretation functions
            function interpretAlertLevelTemp(avg) {
                if (avg < 0.5) return 'Normal';
                else if (avg < 1.5) return 'Warn';
                else return 'Critical';
            }

            function interpretAlertLevelPD(avg) {
                if (avg < 0.5) return 'Normal';
                else return 'Critical';
            }

            // Render table function
            function renderTable(data, parameterType) {
                const tableHead = document.querySelector('#tableOutput thead');
                const tableBody = document.querySelector('#tableOutput tbody');
                tableBody.innerHTML = '';

                if (parameterType === 'Temperature') {
                    tableHead.innerHTML = `
                <tr>
                    <th class="py-3">#</th>
                    <th class="py-3">Time</th>
                    <th class="py-3">Red Temp°C</th>
                    <th class="py-3">Yellow Temp°C</th>
                    <th class="py-3">Blue Temp°C</th>
                    <th class="py-3">Max Temp°C</th>
                    <th class="py-3">Min Temp°C</th>
                    <th class="py-3">Difference Temp°C</th>
                    <th class="py-3">Variance%</th>
                    <th class="py-3">Status</th>
                </tr>
            `;
                    data.forEach((row, i) => {
                        const alertLevelTemp = interpretAlertLevelTemp(row.avg_alert_level || 0);
                        const statusClass = alertLevelTemp === 'Critical' ? 'table-danger' :
                            alertLevelTemp === 'Warn' ? 'table-warning' : '';
                        tableBody.innerHTML += `
                    <tr class="${statusClass}">
                        <td>${i+1}</td>
                        <td>${row.interval_time || 'N/A'}</td>
                        <td>${(row.avg_red || 0).toFixed(2)}</td>
                        <td>${(row.avg_yellow || 0).toFixed(2)}</td>
                        <td>${(row.avg_blue || 0).toFixed(2)}</td>
                        <td>${(row.avg_max || 0).toFixed(2)}</td>
                        <td>${(row.avg_min || 0).toFixed(2)}</td>
                        <td>${(row.avg_max - row.avg_min || 0).toFixed(2)}</td>
                        <td>${(row.avg_variance || 0).toFixed(2)}</td>
                        <td>
                            <span class="badge rounded-pill ${alertLevelTemp === 'Critical' ? 'bg-danger' : 
                                                            alertLevelTemp === 'Warn' ? 'bg-warning' : 'bg-success'}" 
                                  style="padding: 6px 10px; font-size: 0.75rem;">
                                ${alertLevelTemp}
                            </span>
                        </td>
                    </tr>
                `;
                    });
                } else {
                    tableHead.innerHTML = `
                <tr>
                    <th class="py-3">#</th>
                    <th class="py-3">Time</th>
                    <th class="py-3">LFB Ratio</th>
                    <th class="py-3">MFB Ratio</th>
                    <th class="py-3">HFB Ratio</th>
                    <th class="py-3">Mean Ratio</th>
                    <th class="py-3">Mean EPPC</th>
                    <th class="py-3">Indicator</th>
                    <th class="py-3">Status</th>
                </tr>
            `;
                    data.forEach((row, i) => {
                        const alertLevelPD = interpretAlertLevelPD(row.avg_alert_level || 0);
                        const statusClass = alertLevelPD === 'Critical' ? 'table-danger' : '';
                        tableBody.innerHTML += `
                    <tr class="${statusClass}">
                        <td>${i+1}</td>
                        <td>${row.interval_time || 'N/A'}</td>
                        <td>${(row.avg_lfb || 0).toFixed(2)}</td>
                        <td>${(row.avg_mfb || 0).toFixed(2)}</td>
                        <td>${(row.avg_hfb || 0).toFixed(2)}</td>
                        <td>${(row.avg_mean_ratio || 0).toFixed(2)}</td>
                        <td>${(row.avg_mean_eppc || 0).toFixed(2)}</td>
                        <td>${(row.avg_indicator || 0).toFixed(2)}</td>
                        <td>
                            <span class="badge rounded-pill ${alertLevelPD === 'Critical' ? 'bg-danger' : 'bg-success'}" 
                                  style="padding: 6px 10px; font-size: 0.75rem;">
                                ${alertLevelPD}
                            </span>
                        </td>
                    </tr>
                `;
                    });
                }
            }

            // Render chart function
            function renderChart(data, parameterType) {
                const labels = data.map(item => item.interval_time || 'N/A');

                const varianceValues = parameterType === 'Temperature' ?
                    data.map(item => parseFloat(item.avg_variance || 0)) :
                    data.map(item => parseFloat(item.avg_indicator || 0));

                const differenceValues = data.map(item => parseFloat((item.avg_max || 0) - (item.avg_min || 0)));

                const timeRange = parseInt(form.querySelector('select[name="time_range"]').value);
                const isDense = timeRange > 1;
                const fontSize = isDense ? 9 : 12;
                const pointRadius = isDense ? 1 : 3;
                const xTickMaxRotation = isDense ? 0 : 45;

                const ctx = document.getElementById('sensorChart').getContext('2d');
                if (sensorChartInstance) sensorChartInstance.destroy();

                const datasets = [{
                    label: parameterType === 'Temperature' ? 'Variance (%)' : 'Indicator',
                    data: varianceValues,
                    borderColor: 'rgba(75, 192, 192, 1)', // Teal
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: pointRadius
                }];

                // Only add the difference line if we’re in Temperature mode
                if (parameterType === 'Temperature') {
                    datasets.push({
                        label: 'Difference (Max - Min)',
                        data: differenceValues,
                        borderColor: 'rgba(255, 99, 132, 1)', // Red
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.3,
                        fill: false,
                        pointRadius: pointRadius
                    });
                }

                sensorChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true
                            },
                            title: {
                                display: true,
                                text: parameterType === 'Temperature' ? 'Sensor Thermal Analytics' :
                                    'Sensor Partial Discharge Analytics',
                                font: {
                                    size: fontSize + 2
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    font: {
                                        size: fontSize
                                    },
                                    maxRotation: xTickMaxRotation,
                                    minRotation: xTickMaxRotation
                                },
                                title: {
                                    display: true,
                                    text: 'Time',
                                    font: {
                                        size: fontSize
                                    }
                                }
                            },
                            y: {
                                ticks: {
                                    font: {
                                        size: fontSize
                                    }
                                },
                                title: {
                                    display: true,
                                    text: parameterType === 'Temperature' ? 'Variance / Difference' :
                                        'Indicator',
                                    font: {
                                        size: fontSize
                                    }
                                }
                            }
                        }
                    }
                });
            }


            // Generate chart button handler
            if (generateChartBtn) {
                generateChartBtn.addEventListener('click', function() {
                    if (!validateForm()) return;

                    const chartContainer = document.getElementById('sensorChartContainer');
                    const tableContainer = document.getElementById('sensorTableContainer');

                    chartContainer.classList.add('d-none');
                    tableContainer.classList.add('d-none');
                    generateTableBtn.classList.add('d-none');
                    spinner.classList.remove('d-none');
                    generateChartBtn.disabled = true;
                    if (generateTableBtn) generateTableBtn.disabled = true;

                    const formData = new FormData(form);
                    const startDate = formData.get('start_date');
                    const endDate = formData.get('end_date');
                    parameterType = document.getElementById('detailParameter').textContent.trim();

                    document.getElementById('rangeDate').textContent = `${startDate} to ${endDate}`;
                    formData.append('parameter', parameterType);

                    // Check if route exists
                    const sensorChartUrl = window.routes?.sensorChart || '/sensor-chart';
                    const params = new URLSearchParams(formData).toString();

                    fetch(`${sensorChartUrl}?${params}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            if (data && data.length > 0) {
                                chartData = data;
                                renderChart(data, parameterType);
                                chartContainer.classList.remove('d-none');
                                generateTableBtn.classList.remove('d-none');
                            } else {
                                alert('No data found for the selected criteria.');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching chart data:', error);
                            alert('Failed to generate chart. Please try again.');
                        })
                        .finally(() => {
                            spinner.classList.add('d-none');
                            generateChartBtn.disabled = false;
                            if (generateTableBtn) generateTableBtn.disabled = false;
                        });
                });
            }

            // Generate table button handler
            if (generateTableBtn) {
                generateTableBtn.addEventListener('click', function() {
                    if (chartData && parameterType) {
                        renderTable(chartData, parameterType);
                        document.getElementById('sensorTableContainer').classList.remove('d-none');
                    } else {
                        alert('Please generate a chart first.');
                    }
                });
            }

            // Download PDF functionality
            document.getElementById('downloadPDF').addEventListener('click', function(e) {
                e.preventDefault();

                if (!chartData) {
                    alert('Please generate analytics first.');
                    return;
                }

                // Get jsPDF from window object
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF();

                // Title
                doc.setFontSize(20);
                doc.text('Sensor Analytics Report', 20, 20);

                // Sensor Details
                doc.setFontSize(14);
                doc.text('Sensor Information:', 20, 40);

                doc.setFontSize(10);
                const sensorName = document.getElementById('detailSensor').textContent;
                const substation = document.getElementById('detailSubstation').textContent;
                const panel = document.getElementById('detailPanel').textContent;
                const compartment = document.getElementById('detailCompartment').textContent;
                const parameter = document.getElementById('detailParameter').textContent;
                const dateRange = document.getElementById('rangeDate').textContent;

                doc.text(`Sensor: ${sensorName}`, 20, 50);
                doc.text(`Substation: ${substation}`, 20, 55);
                doc.text(`Panel: ${panel}`, 20, 60);
                doc.text(`Compartment: ${compartment}`, 20, 65);
                doc.text(`Parameter: ${parameter}`, 20, 70);
                doc.text(`Date Range: ${dateRange}`, 20, 75);

                // Chart
                if (sensorChartInstance) {
                    const chartCanvas = document.getElementById('sensorChart');
                    const chartImage = chartCanvas.toDataURL('image/png');
                    doc.addImage(chartImage, 'PNG', 20, 85, 170, 85);
                }

                // Table data
                let tableData = [];
                let tableHeaders = [];

                if (parameterType === 'Temperature') {
                    tableHeaders = ['#', 'Time', 'Max Temperature °C',
                        'Min Temperature °C', 'Difference °C', 'Variance%', 'Status'
                    ];
                    chartData.forEach((row, i) => {
                        const alertLevel = interpretAlertLevelTemp(row.avg_alert_level || 0);
                        tableData.push([
                            i + 1,
                            row.interval_time || 'N/A',
                            (row.avg_max || 0).toFixed(2) + '°C',
                            (row.avg_min || 0).toFixed(2) + '°C',
                            (row.avg_max - row.avg_min || 0).toFixed(2) + '°C',
                            (row.avg_variance || 0).toFixed(2) + '%',
                            alertLevel
                        ]);
                    });
                } else {
                    tableHeaders = ['#', 'Time', 'LFB Ratio', 'MFB Ratio', 'HFB Ratio', 'Mean Ratio',
                        'Mean EPPC', 'Indicator', 'Status'
                    ];
                    chartData.forEach((row, i) => {
                        const alertLevel = interpretAlertLevelPD(row.avg_alert_level || 0);
                        tableData.push([
                            i + 1,
                            row.interval_time || 'N/A',
                            (row.avg_lfb || 0).toFixed(2),
                            (row.avg_mfb || 0).toFixed(2),
                            (row.avg_hfb || 0).toFixed(2),
                            (row.avg_mean_ratio || 0).toFixed(2),
                            (row.avg_mean_eppc || 0).toFixed(2),
                            (row.avg_indicator || 0).toFixed(2),
                            alertLevel
                        ]);
                    });
                }

                // Add table to PDF
                doc.autoTable({
                    head: [tableHeaders],
                    body: tableData,
                    startY: 180,
                    styles: {
                        fontSize: 8
                    },
                    headStyles: {
                        fillColor: [52, 152, 219]
                    },
                    margin: {
                        top: 180
                    }
                });

                // Save PDF
                const fileName =
                    `sensor_analytics_${sensorName}_${new Date().toISOString().split('T')[0]}.pdf`;
                doc.save(fileName);
            });

            // Download Excel functionality
            document.getElementById('downloadExcel').addEventListener('click', function(e) {
                e.preventDefault();

                if (!chartData) {
                    alert('Please generate analytics first.');
                    return;
                }

                // Prepare data for Excel
                let excelData = [];

                if (parameterType === 'Temperature') {
                    excelData = chartData.map((row, i) => ({
                        '#': i + 1,
                        'Time': row.interval_time || 'N/A',
                        'Red Temp': (row.avg_red || 0).toFixed(2),
                        'Yellow Temp': (row.avg_yellow || 0).toFixed(2),
                        'Blue Temp': (row.avg_blue || 0).toFixed(2),
                        'Max Temp': (row.avg_max || 0).toFixed(2),
                        'Min Temp': (row.avg_min || 0).toFixed(2),
                        'Difference Temp': (row.avg_max - row.avg_min || 0).toFixed(2),
                        'Variance%': (row.avg_variance || 0).toFixed(2),
                        'Status': interpretAlertLevelTemp(row.avg_alert_level || 0)
                    }));
                } else {
                    excelData = chartData.map((row, i) => ({
                        '#': i + 1,
                        'Time': row.interval_time || 'N/A',
                        'LFB Ratio': (row.avg_lfb || 0).toFixed(2),
                        'MFB Ratio': (row.avg_mfb || 0).toFixed(2),
                        'HFB Ratio': (row.avg_hfb || 0).toFixed(2),
                        'Mean Ratio': (row.avg_mean_ratio || 0).toFixed(2),
                        'Mean EPPC': (row.avg_mean_eppc || 0).toFixed(2),
                        'Indicator': (row.avg_indicator || 0).toFixed(2),
                        'Status': interpretAlertLevelPD(row.avg_alert_level || 0)
                    }));
                }

                // Create workbook
                const wb = XLSX.utils.book_new();

                // Add sensor info sheet
                const sensorInfo = [
                    ['Sensor Information', ''],
                    ['Sensor', document.getElementById('detailSensor').textContent],
                    ['Substation', document.getElementById('detailSubstation').textContent],
                    ['Panel', document.getElementById('detailPanel').textContent],
                    ['Compartment', document.getElementById('detailCompartment').textContent],
                    ['Parameter', document.getElementById('detailParameter').textContent],
                    ['Date Range', document.getElementById('rangeDate').textContent],
                    ['', ''],
                    ['Analytics Data', '']
                ];

                const ws1 = XLSX.utils.aoa_to_sheet(sensorInfo);
                XLSX.utils.book_append_sheet(wb, ws1, 'Sensor Info');

                // Add data sheet
                const ws2 = XLSX.utils.json_to_sheet(excelData);
                XLSX.utils.book_append_sheet(wb, ws2, 'Analytics Data');

                // Save Excel file
                const sensorName = document.getElementById('detailSensor').textContent;
                const fileName =
                    `sensor_analytics_${sensorName}_${new Date().toISOString().split('T')[0]}.xlsx`;
                XLSX.writeFile(wb, fileName);
            });

            // Error handling for missing routes
            if (typeof window.routes === 'undefined') {
                console.warn('Routes not defined. Some functionality may not work properly.');
                window.routes = {
                    analytics: '/analytics',
                    sensorChart: '/sensor-chart'
                };
            }

            // Responsive chart handling
            window.addEventListener('resize', function() {
                if (sensorChartInstance) {
                    sensorChartInstance.resize();
                }
            });

            // Form reset functionality
            function resetForm() {
                form.reset();
                setDefaultDates();
                document.getElementById('sensorDetails').classList.add('d-none');
                document.getElementById('sensorChartContainer').classList.add('d-none');
                document.getElementById('sensorTableContainer').classList.add('d-none');
                generateTableBtn.classList.add('d-none');
                chartData = null;
                parameterType = null;
                if (sensorChartInstance) {
                    sensorChartInstance.destroy();
                    sensorChartInstance = null;
                }
            }

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl + Enter to generate chart
                if (e.ctrlKey && e.key === 'Enter') {
                    e.preventDefault();
                    generateChartBtn.click();
                }

                // Escape to reset form
                if (e.key === 'Escape') {
                    resetForm();
                }
            });

            // Auto-refresh functionality (optional)
            let autoRefreshInterval = null;

            function startAutoRefresh(minutes = 5) {
                if (autoRefreshInterval) {
                    clearInterval(autoRefreshInterval);
                }

                autoRefreshInterval = setInterval(() => {
                    if (chartData && document.getElementById('sensorSelect').value) {
                        console.log('Auto-refreshing data...');
                        generateChartBtn.click();
                    }
                }, minutes * 60 * 1000);
            }

            function stopAutoRefresh() {
                if (autoRefreshInterval) {
                    clearInterval(autoRefreshInterval);
                    autoRefreshInterval = null;
                }
            }

            // Initialize tooltips for better UX
            function initializeTooltips() {
                const tooltipElements = document.querySelectorAll('[title]');
                tooltipElements.forEach(element => {
                    element.addEventListener('mouseenter', function() {
                        const tooltip = document.createElement('div');
                        tooltip.className = 'custom-tooltip';
                        tooltip.textContent = this.getAttribute('title');
                        tooltip.style.cssText = `
                    position: absolute;
                    background: rgba(0,0,0,0.8);
                    color: white;
                    padding: 5px 10px;
                    border-radius: 4px;
                    font-size: 12px;
                    z-index: 1000;
                    pointer-events: none;
                `;
                        document.body.appendChild(tooltip);

                        const rect = this.getBoundingClientRect();
                        tooltip.style.left = rect.left + 'px';
                        tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';

                        this.tooltipElement = tooltip;
                    });

                    element.addEventListener('mouseleave', function() {
                        if (this.tooltipElement) {
                            document.body.removeChild(this.tooltipElement);
                            this.tooltipElement = null;
                        }
                    });
                });
            }

            // Initialize tooltips
            initializeTooltips();
        });
    </script>
@endpush
