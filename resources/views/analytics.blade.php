@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Analytics Sensor</h1>
        </div>

        <section class="section dashboard">
            <div class="row">

                <!-- Analytics Sensor -->
                <div class="col-lg-12">
                    <div class="card shadow-lg border-0 rounded-4 p-3"
                        style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                        <div class="card-body">
                            <!-- Sensor Type Selection -->
                            <div class="d-flex align-items-center mb-3">
                                <label class="me-2">Sensor Type</label>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" id="tempCheckbox" checked>
                                    <label class="form-check-label" for="tempCheckbox">Temperature</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pdCheckbox" checked>
                                    <label class="form-check-label" for="pdCheckbox">Partial Discharge</label>
                                </div>
                            </div>

                            <!-- Chart -->
                            <canvas id="sensorChart" style="max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Filter & Table Section -->
                <div class="col-lg-12 mt-4">
                    <div class="card shadow-lg border-0 rounded-4 p-3"
                        style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                        <div class="card-body">

                            <!-- Filters -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <button class="btn btn-light">
                                    <i class="fas fa-filter"></i> Filter by
                                </button>
                                <select class="form-select w-auto">
                                    <option>Substation</option>
                                    <option>Substation Cheras</option>
                                    <option>Substation Bangi</option>
                                </select>
                                <select class="form-select w-auto">
                                    <option>Type</option>
                                    <option>Temperature</option>
                                    <option>Partial Discharge</option>
                                </select>
                                <select class="form-select w-auto">
                                    <option>Status</option>
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                            </div>

                            <!-- Sensor Table -->
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Substation</th>
                                        <th>Sensor Type</th>
                                        <th>Assigned Asset</th>
                                        <th>Status</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Temp-Sensor-01</td>
                                        <td>Substation Cheras</td>
                                        <td>Temperature</td>
                                        <td>SG-01</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2024-12-27 14:35:00</td>
                                    </tr>
                                    <tr>
                                        <td>Temp-Sensor-02</td>
                                        <td>Substation Ampang</td>
                                        <td>Temperature</td>
                                        <td>SG-01</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2024-12-27 14:35:00</td>
                                    </tr>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('sensorChart').getContext('2d');

            const chartData = {
                labels: [
                    "Substation Cheras", "Substation Ampang", "Substation Putrajaya",
                    "Substation Shah Alam",
                    "Substation Puchong", "Substation Setia Alam", "Substation Puncak Alam",
                    "Substation Keramat",
                    "Substation Pudulua", "Substation Klang", "Substation Bangi", "Substation Kajang"
                ],
                datasets: [{
                        label: "Sensor Temperature",
                        data: [10, 14, 12, 15, 18, 10, 14, 12, 15, 18, 10, 12],
                        backgroundColor: "#007bff", // Blue
                    },
                    {
                        label: "Sensor Partial Discharge (PD)",
                        data: [12, 10, 15, 18, 12, 14, 10, 15, 12, 14, 18, 10],
                        backgroundColor: "#ff7f50", // Orange
                    }
                ]
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        barPercentage: 0.3, // Makes bars thinner (default is 0.9)
                        categoryPercentage: 0.5, // Adjusts spacing between bars (default is 0.8)
                        ticks: {
                            font:{
                                size: 10
                            },
                            autoSkip: false,
                        }
                    },
                    y: {
                        ticks: {
                            size: 10
                        },
                    }
                }
            };

            let sensorChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: chartOptions
            });

            // Checkbox Filters
            document.getElementById("tempCheckbox").addEventListener("change", function() {
                sensorChart.data.datasets[0].hidden = !this.checked;
                sensorChart.update();
            });

            document.getElementById("pdCheckbox").addEventListener("change", function() {
                sensorChart.data.datasets[1].hidden = !this.checked;
                sensorChart.update();
            });
        });
    </script>
@endsection
