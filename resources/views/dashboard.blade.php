{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            @if (session('success'))
                <div id="alert-success" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div id="alert-error" class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-20">
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="col-lg-3">
                            <div class="card info-card sales-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Substations</h5>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h1 class="fw-bold display-4">{{ $total_substation }}</h1>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Sales Card -->
                        <div class="col-lg-3">
                            <div class="card info-card sales-card">

                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Sensors</h5>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h1 class="fw-bold display-4">{{ $total_sensor }}</h1>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-lg-3">
                            <div class="card info-card revenue-card">

                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Failure</h5>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h1 class="fw-bold display-4">{{ $total_failure }}</h1>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Customers Card -->
                        <div class="col-lg-3">
                            <div class="card info-card customers-card">

                                <div class="card-body text-center">
                                    <h5 class="card-title">Overall Performance</h5>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h1 class="fw-bold display-4">89%</h1>
                                    </div>
                                </div>
                            </div>

                        </div><!-- End Customers Card -->

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
                                                    <option value="{{ $substation->id }}">{{ $substation->substation_name }}
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
                                    <canvas id="tempChart" style="max-height: 400px;"></canvas>

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
                                    <canvas id="pdChart" style="max-height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Chart.js Script -->

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const ctx = document.getElementById('tempChart').getContext('2d');
                                let chartInstance;

                                const TOAST_DISPLAY_TIME = 7000; // 5 seconds
                                const RELOAD_INTERVAL_MS = 300000; // 5 minutes

                                let lastAlertState = null;
                                let lastSensorId = null;

                                async function fetchData() {
                                    try {
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
                                                compartment: compartmentId
                                            })
                                        });

                                        if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);

                                        const data = await res.json();
                                        if (!data.readings || data.readings.length === 0) throw new Error("No data available");

                                        const chartData = [...data.readings].reverse();

                                        const latest = chartData[chartData.length - 1] || {};

                                        return {
                                            sensorId: data.sensor_id,
                                            sensorName: data.sensor_name,
                                            labels: chartData.map(d => d.created_at),
                                            red: chartData.map(d => parseFloat(d.red_phase_temp)),
                                            yellow: chartData.map(d => parseFloat(d.yellow_phase_temp)),
                                            blue: chartData.map(d => parseFloat(d.blue_phase_temp)),
                                            avgVariance: parseFloat(latest.variance_percent || 0).toFixed(2),
                                            maxVariance: 12,
                                            maxTemp: parseFloat(latest.max_temp || 0).toFixed(2),
                                            minTemp: parseFloat(latest.min_temp || 0).toFixed(2),
                                            diffTemp: (parseFloat(latest.max_temp || 0) - parseFloat(latest.min_temp || 0)).toFixed(
                                                2),
                                            alertTriggered: latest.alert_triggered
                                        };
                                    } catch (err) {
                                        console.error('Error fetching data:', err);
                                        return {
                                            sensorId: "N/A",
                                            sensorName: "N/A",
                                            labels: [],
                                            red: [],
                                            yellow: [],
                                            blue: [],
                                            avgVariance: "0.00",
                                            maxVariance: "0.00",
                                            maxTemp: "0.00",
                                            diffTemp: "0.00"
                                        };
                                    }
                                }

                                async function renderChart() {
                                    const chartData = await fetchData();

                                    if (chartInstance) {
                                        chartInstance.destroy();
                                    }

                                    chartInstance = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: chartData.labels,
                                            datasets: [{
                                                    label: 'Wire Red',
                                                    data: chartData.red,
                                                    borderColor: 'red',
                                                    borderWidth: 2,
                                                    fill: false,
                                                    tension: 0.3
                                                },
                                                {
                                                    label: 'Wire Yellow',
                                                    data: chartData.yellow,
                                                    borderColor: 'yellow',
                                                    borderWidth: 2,
                                                    fill: false,
                                                    tension: 0.3
                                                },
                                                {
                                                    label: 'Wire Blue',
                                                    data: chartData.blue,
                                                    borderColor: 'blue',
                                                    borderWidth: 2,
                                                    fill: false,
                                                    tension: 0.3
                                                }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            scales: {
                                                y: {
                                                    beginAtZero: false,
                                                    grid: {
                                                        color: '#ddd',
                                                        drawBorder: false,
                                                        borderDash: [5, 5]
                                                    },
                                                    ticks: {
                                                        stepSize: 10
                                                    }
                                                },
                                                x: {
                                                    grid: {
                                                        display: false
                                                    }
                                                }
                                            },
                                            plugins: {
                                                legend: {
                                                    display: false
                                                }
                                            }
                                        }
                                    });

                                    document.getElementById("variance_avg").value = `${chartData.avgVariance} %`;
                                    document.getElementById("variance_max").value = `${chartData.maxVariance} %`;
                                    document.getElementById("temp_diff").value = `${chartData.diffTemp} °C`;
                                    document.getElementById("temp_max").value = `${chartData.maxTemp} °C`;
                                }

                                // Initialize chart and setup event listeners
                                renderChart();
                                setInterval(renderChart, RELOAD_INTERVAL_MS);

                                document.querySelectorAll('select').forEach(select => {
                                    select.addEventListener('change', renderChart);
                                });
                            });

                            function handleTakeAction() {
                                alert("Redirecting to incident response page...");
                                dismissToast();
                            }
                        </script>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const pdCtx = document.getElementById('pdChart').getContext('2d');
                                let pdChartInstance;

                                async function fetchPDData() {
                                    try {
                                        const substationId = document.querySelector('select[name=substation_pd]').value;
                                        const panelId = document.querySelector('select[name=panel_pd]').value;
                                        const compartmentId = document.querySelector('select[name=compartment_pd]').value;

                                        const res = await fetch('/dashboard/sensor-partial-discharge', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                    .getAttribute('content')
                                            },
                                            body: JSON.stringify({
                                                substation: substationId,
                                                panel: panelId,
                                                compartment: compartmentId
                                            })
                                        });

                                        const data = await res.json();
                                        const reversed = [...data].reverse();

                                        return {
                                            labels: reversed.map(d => d.created_at),
                                            indicators: reversed.map(d => parseFloat(d.Indicator)),
                                            meanRatios: reversed.map(d => parseFloat(d.Mean_Ratio)),
                                            meanEPPCs: reversed.map(d => parseFloat(d.Mean_EPPC))
                                        };
                                    } catch (err) {
                                        console.error('Error loading PD data:', err);
                                        return {
                                            labels: [],
                                            indicators: [],
                                            meanRatios: [],
                                            meanEPPCs: []
                                        };
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
                                                    borderWidth: 2,
                                                    fill: false,
                                                    tension: 0.3
                                                },
                                                {
                                                    label: 'Mean Ratio (dB)',
                                                    data: pdData.meanRatios,
                                                    borderColor: '#f59e0b',
                                                    borderWidth: 2,
                                                    fill: false,
                                                    tension: 0.3
                                                },
                                                {
                                                    label: 'Mean EPPC',
                                                    data: pdData.meanEPPCs,
                                                    borderColor: '#ef4444',
                                                    borderWidth: 2,
                                                    fill: false,
                                                    tension: 0.3
                                                }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
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
                                                    }
                                                }
                                            },
                                            plugins: {
                                                legend: {
                                                    display: true
                                                }
                                            }
                                        }
                                    });
                                }

                                renderPDChart();
                                setInterval(renderPDChart, 300000);
                                document.querySelectorAll('select').forEach(select => {
                                    select.addEventListener('change', renderPDChart);
                                });
                            });
                        </script>

                    </div>
                </div>



            </div>
        </section>

    </main><!-- End #main -->
@endsection
