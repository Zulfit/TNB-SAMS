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
                        <div class="card-body p-4 rounded-4">
                            <form id="sensorFilterForm" class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label>Sensor</label>
                                    <select name="sensor" id="sensorSelect" class="form-select">
                                        <option value="">Select</option>
                                        @foreach ($sensors as $sensor)
                                            <option value="{{ $sensor->id }}">{{ $sensor->sensor_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="startDate">
                                </div>

                                <div class="col-md-2">
                                    <label>End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="endDate">
                                </div>

                                <div class="col-md-2">
                                    <label>Time Range</label>
                                    <select name="time_range" class="form-select" id="timeRange">
                                        <option value="1">1 Hour</option>
                                        <option value="24">24 Hours</option>
                                        <option value="168">1 Week</option>
                                    </select>
                                </div>

                                <div class="col-md-3 d-flex gap-2">
                                    <button type="button" id="generateChart" class="btn btn-primary w-100">Graph</button>
                                    <button type="button" id="generateTable" class="btn btn-success w-100">Table</button>
                                    <button type="button" id="downloadReport"
                                        class="btn btn-outline-secondary w-100">Download</button>
                                </div>
                            </form>

                            <div id="reportContent">
                                <!-- Sensor details -->
                                <div id="sensorDetails" class="mt-3 p-3 bg-light rounded border">
                                    <p><strong>Sensor:</strong> <span id="detailSensor"></span></p>
                                    <p><strong>Substation:</strong> <span id="detailSubstation"></span></p>
                                    <p><strong>Panel:</strong> <span id="detailPanel"></span></p>
                                    <p><strong>Compartment:</strong> <span id="detailCompartment"></span></p>
                                    <p><strong>Parameter:</strong> <span id="detailParameter"></span></p>
                                    <p><strong>Date:</strong> <span id="rangeDate"></span></p>
                                </div>

                                <!-- Chart -->
                                <div id="sensorChartContainer" class="mt-5 sensor-container d-none">
                                    <canvas class="chart" id="sensorChart"></canvas>
                                </div>

                                <!-- Table -->
                                <div id="sensorTableContainer" class="mt-5 sensor-container d-none">
                                    <table class="table table-bordered" id="tableOutput">
                                        <thead></thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- <div id="sensorDetails" class="mt-3 p-3 bg-light rounded border">
                                <strong>Substation:</strong> <span id="detailSubstation">-</span><br>
                                <strong>Panel:</strong> <span id="detailPanel">-</span><br>
                                <strong>Compartment:</strong> <span id="detailCompartment">-</span><br>
                                <strong>Parameter:</strong> <span id="detailParameter">-</span>
                            </div> --}}

                            {{-- <div id="sensorTableContainer" class="mt-5 sensor-container d-none">
                                <table class="table table-bordered" id="tableOutput">
                                    <thead></thead>
                                    <tbody></tbody>
                                </table>
                            </div> --}}

                            {{-- <div id="sensorChartContainer" class="mt-5 sensor-container d-none">
                                <canvas class="chart" id="sensorChart"></canvas>
                            </div> --}}

                            <div id="loadingSpinner" class="text-center my-3 d-none">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter & Table Section -->
                    <div class="col-lg-12 mt-4">
                        <div class="card shadow-lg border-0 rounded-4 p-3"
                            style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                            <div class="card-body">
                                <!-- Filters -->
                                <form method="GET" class="d-flex gap-2 flex-wrap align-items-center mb-3">
                                    <select class="form-select w-auto" name="substation">
                                        <option value="">All Substations</option>
                                        @foreach ($substations as $substation)
                                            <option value="{{ $substation->id }}"
                                                {{ request('substation') == $substation->id ? 'selected' : '' }}>
                                                {{ $substation->substation_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select class="form-select w-auto" name="panel">
                                        <option value="">All Panels</option>
                                        @foreach ($panels as $panel)
                                            <option value="{{ $panel->id }}"
                                                {{ request('panel') == $panel->id ? 'selected' : '' }}>
                                                {{ $panel->panel_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select class="form-select w-auto" name="compartment">
                                        <option value="">All Compartments</option>
                                        @foreach ($compartments as $compartment)
                                            <option value="{{ $compartment->id }}"
                                                {{ request('compartment') == $compartment->id ? 'selected' : '' }}>
                                                {{ $compartment->compartment_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select class="form-select w-auto" name="measurement">
                                        <option value="">All Measurements</option>
                                        <option value="Temperature"
                                            {{ request('measurement') == 'Temperature' ? 'selected' : '' }}>Temperature
                                        </option>
                                        <option value="Partial Discharge"
                                            {{ request('measurement') == 'Partial Discharge' ? 'selected' : '' }}>Partial
                                            Discharge</option>
                                    </select>

                                    <select class="form-select w-auto" name="status">
                                        <option value="">All Statuses</option>
                                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>

                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                        Apply</button>
                                </form>

                                <!-- Sensor Table -->
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sensor Name</th>
                                            <th>Assigned Substation</th>
                                            <th>Panel</th>
                                            <th>Compartment</th>
                                            <th>Measurement</th>
                                            <th>Status</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sensors as $sensor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sensor->sensor_name }}</td>
                                                <td>{{ $sensor->substation->substation_name }}</td>
                                                <td>{{ $sensor->panel->panel_name }}</td>
                                                <td>{{ $sensor->compartment->compartment_name }}</td>
                                                <td>{{ $sensor->sensor_measurement }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $sensor->sensor_status === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $sensor->sensor_status }}
                                                    </span>
                                                </td>
                                                <td>{{ $sensor->updated_at }}</td>
                                            </tr>
                                        @endforeach
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

    <script>
        const form = document.getElementById('sensorFilterForm');
        const generateTableBtn = document.getElementById('generateTable');
        const generateChartBtn = document.getElementById('generateChart');
        const spinner = document.getElementById('loadingSpinner');

        document.getElementById('sensorSelect').addEventListener('change', function() {
            const sensorId = this.value;
            document.getElementById('sensorChartContainer').classList.add('d-none');
            document.getElementById('sensorTableContainer').classList.add('d-none');

            if (sensorId) {
                fetch(`/analytics/${sensorId}`)
                    .then(res => res.json())
                    .then(sensor => {
                        document.getElementById('detailSensor').textContent = sensor.sensor_name;
                        document.getElementById('detailSubstation').textContent = sensor.substation_name;
                        document.getElementById('detailPanel').textContent = sensor.panel_name;
                        document.getElementById('detailCompartment').textContent = sensor.compartment_name;
                        document.getElementById('detailParameter').textContent = sensor.sensor_measurement;
                    })
                    .catch(err => console.error('Failed to fetch sensor details:', err));
            } else {
                ['Substation', 'Panel', 'Compartment', 'Parameter'].forEach(field =>
                    document.getElementById(`detail${field}`).textContent = '-'
                );
            }
        });

        function interpretAlertLevelTemp(avg) {
            if (avg < 0.5) return 'Normal';
            else if (avg < 1.5) return 'Warn';
            else return 'Critical';
        }

        function interpretAlertLevelPD(avg) {
            if (avg < 0.5) return 'Normal';
            else return 'Critical';
        }

        function renderTable(data, parameterType) {
            const tableHead = document.querySelector('#tableOutput thead');
            const tableBody = document.querySelector('#tableOutput tbody');
            tableBody.innerHTML = '';

            if (parameterType === 'Temperature') {
                tableHead.innerHTML = `
                    <tr>
                        <th>#</th>
                        <th>Time</th>
                        <th>Red Temp</th>
                        <th>Yellow Temp</th>
                        <th>Blue Temp</th>
                        <th>Max Temp</th>
                        <th>Min Temp</th>
                        <th>Variance%</th>
                        <th>Status</th>
                    </tr>
                `;
                data.forEach((row, i) => {
                    const alertLevelTemp = interpretAlertLevelTemp(row.avg_alert_level);
                    tableBody.innerHTML += `
                        <tr>
                            <td>${i+1}</td>
                            <td>${row.interval_time}</td>
                            <td>${row.avg_red.toFixed(2)}</td>
                            <td>${row.avg_yellow.toFixed(2)}</td>
                            <td>${row.avg_blue.toFixed(2)}</td>
                            <td>${row.avg_max.toFixed(2)}</td>
                            <td>${row.avg_min.toFixed(2)}</td>
                            <td>${row.avg_variance.toFixed(2)}%</td>
                            <td>${alertLevelTemp}</td>
                        </tr>
                    `;
                });
            } else {
                tableHead.innerHTML = `
                    <tr>
                        <th>#</th>
                        <th>Time</th>
                        <th>LFB Ratio</th>
                        <th>MFB Ratio</th>
                        <th>HFB Ratio</th>
                        <th>Mean Ratio</th>
                        <th>Mean EPPC</th>
                        <th>Indicator</th>
                        <th>Status</th>
                    </tr>
                `;
                data.forEach((row, i) => {
                    const alertLevelPD = interpretAlertLevelPD(row.avg_alert_level);
                    tableBody.innerHTML += `
                        <tr>
                            <td>${i+1}</td>
                            <td>${row.interval_time}</td>
                            <td>${row.avg_lfb.toFixed(2)}</td>
                            <td>${row.avg_mfb.toFixed(2)}</td>
                            <td>${row.avg_hfb.toFixed(2)}</td>
                            <td>${row.avg_mean_ratio.toFixed(2)}</td>
                            <td>${row.avg_mean_eppc.toFixed(2)}</td>
                            <td>${row.avg_indicator.toFixed(2)}</td>
                            <td>${alertLevelPD}</td>
                        </tr>
                    `;
                });
            }
        }

        document.getElementById('generateTable').addEventListener('click', function() {
            const tableContainer = document.getElementById('sensorTableContainer');
            const chartContainer = document.getElementById('sensorChartContainer');

            tableContainer.classList.add('d-none');
            chartContainer.classList.add('d-none');
            spinner.classList.remove('d-none');
            generateTableBtn.disabled = true;
            generateChartBtn.disabled = true;

            const formData = new FormData(form);
            const sensorTableUrl = "{{ route('sensorTable') }}";

            const startDate = formData.get('start_date');
            const endDate = formData.get('end_date');

            if (!formData.get('sensor') || !startDate || !endDate) {
                alert('Please select a sensor and valid date range.');
                spinner.classList.add('d-none');
                generateTableBtn.disabled = false;
                generateChartBtn.disabled = false;
                return;
            }

            document.getElementById('rangeDate').textContent = `${startDate} to ${endDate}`;

            const parameterType = document.getElementById('detailParameter').textContent.trim();
            if (!parameterType || parameterType === '-') {
                alert('Please select a valid sensor to get parameter type.');
                spinner.classList.add('d-none');
                generateTableBtn.disabled = false;
                generateChartBtn.disabled = false;
                return;
            }

            formData.append('parameter', parameterType);
            const params = new URLSearchParams(formData).toString();

            fetch(`${sensorTableUrl}?${params}`)
                .then(response => response.json())
                .then(data => {
                    renderTable(data, parameterType);
                    tableContainer.classList.remove('d-none');
                })
                .catch(error => {
                    console.error('Error fetching table data:', error);
                    alert('Failed to load data. Please try again.');
                })
                .finally(() => {
                    spinner.classList.add('d-none');
                    generateTableBtn.disabled = false;
                    generateChartBtn.disabled = false;
                });
        });

        let sensorChartInstance = null;

        function renderChart(data, parameterType) {
            const labels = data.map(item => item.interval_time);
            const values = parameterType === 'Temperature' ?
                data.map(item => parseFloat(item.avg_variance)) :
                data.map(item => parseFloat(item.avg_indicator));

            const timeRange = parseInt(form.querySelector('select[name="time_range"]').value);

            // Adjust font size & point radius for dense data
            const isDense = timeRange > 1;
            const fontSize = isDense ? 9 : 12;
            const pointRadius = isDense ? 1 : 3;
            const xTickMaxRotation = isDense ? 0 : 45;

            const ctx = document.getElementById('sensorChart').getContext('2d');
            if (sensorChartInstance) sensorChartInstance.destroy();

            sensorChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: parameterType === 'Temperature' ? 'Variance (%)' : 'Indicator',
                        data: values,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: pointRadius
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Allow flexible sizing
                    plugins: {
                        legend: {
                            display: true
                        },
                        title: {
                            display: true,
                            text: parameterType === 'Temperature' ? 'Variance Over Time' : 'Indicator Over Time',
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
                                text: parameterType === 'Temperature' ? 'Variance (%)' : 'Indicator',
                                font: {
                                    size: fontSize
                                }
                            }
                        }
                    }
                }
            });

            document.getElementById('sensorChartContainer').classList.remove('d-none');
        }



        document.getElementById('generateChart').addEventListener('click', function() {
            const chartContainer = document.getElementById('sensorChartContainer');
            const tableContainer = document.getElementById('sensorTableContainer');
            const sensorTableUrl = "{{ route('sensorTable') }}";
            const sensorChartUrl = "{{ route('sensorChart') }}";

            chartContainer.classList.add('d-none');
            tableContainer.classList.add('d-none');
            spinner.classList.remove('d-none');
            generateTableBtn.disabled = true;
            generateChartBtn.disabled = true;

            const formData = new FormData(form);
            const startDate = formData.get('start_date');
            const endDate = formData.get('end_date');

            document.getElementById('rangeDate').textContent = `${startDate} to ${endDate}`;

            if (!formData.get('sensor') || !startDate || !endDate) {
                alert('Please select a sensor and valid date range.');
                spinner.classList.add('d-none');
                generateTableBtn.disabled = false;
                generateChartBtn.disabled = false;
                return;
            }

            if (new Date(startDate) > new Date(endDate)) {
                alert('Start date must be before end date.');
                spinner.classList.add('d-none');
                generateTableBtn.disabled = false;
                generateChartBtn.disabled = false;
                return;
            }

            const parameterType = document.getElementById('detailParameter').textContent.trim();
            formData.append('parameter', parameterType);
            const params = new URLSearchParams(formData).toString(); // MOVE THIS HERE

            // First fetch and render updated table
            fetch(`${sensorTableUrl}?${params}`)
                .then(response => response.json())
                .then(tableData => {
                    renderTable(tableData, parameterType);
                    tableContainer.classList.remove('d-none');
                })
                .catch(error => {
                    console.error('Error fetching table data for chart:', error);
                });

            // Then fetch and render the chart
            fetch(`${sensorChartUrl}?${params}`)
                .then(res => res.json())
                .then(chartData => {
                    renderChart(chartData, parameterType);
                    chartContainer.classList.remove('d-none');
                })
                .catch(err => {
                    console.error('Chart fetch error:', err);
                    alert('Failed to load data. Please try again.');
                })
                .finally(() => {
                    spinner.classList.add('d-none');
                    generateTableBtn.disabled = false;
                    generateChartBtn.disabled = false;
                });
        });


        document.getElementById('downloadReport').addEventListener('click', async () => {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');

            const chartContainer = document.getElementById('sensorChartContainer');
            const table = document.getElementById('tableOutput');
            const detailsContainer = document.getElementById('sensorDetails');

            if (!table || table.rows.length <= 1) {
                alert('Please generate a table before downloading.');
                return;
            }
            if (chartContainer.classList.contains('d-none')) {
                alert('Please generate a chart before downloading.');
                return;
            }

            // Clone chart and details
            const chartClone = chartContainer.cloneNode(true);
            const canvasOriginal = chartContainer.querySelector('canvas');
            const canvasClone = chartClone.querySelector('canvas');

            // Copy chart to cloned canvas
            const ctx = canvasClone.getContext('2d');
            ctx.drawImage(canvasOriginal, 0, 0);

            const tempWrapper = document.createElement('div');
            tempWrapper.style.backgroundColor = 'white';
            tempWrapper.style.padding = '10px';
            tempWrapper.appendChild(detailsContainer.cloneNode(true));
            tempWrapper.appendChild(chartClone);
            document.body.appendChild(tempWrapper);

            await new Promise(resolve => setTimeout(resolve, 500)); // Let rendering finish

            const canvas = await html2canvas(tempWrapper, {
                scale: 2
            });
            const imgData = canvas.toDataURL('image/png');
            const imgWidth = 180;
            const imgHeight = canvas.height * imgWidth / canvas.width;

            doc.addImage(imgData, 'PNG', 15, 10, imgWidth, imgHeight);
            document.body.removeChild(tempWrapper);

            // Move to next page if needed
            let tableStartY = imgHeight + 20;
            if (tableStartY > 250) {
                doc.addPage();
                tableStartY = 10;
            }

            // Export HTML table as text
            doc.autoTable({
                html: '#tableOutput',
                startY: tableStartY,
                styles: {
                    fontSize: 8,
                    cellPadding: 2
                },
                headStyles: {
                    fillColor: [22, 160, 133]
                },
                theme: 'grid'
            });

            doc.save(`Sensor_Report_${new Date().toISOString().split('T')[0]}.pdf`);
        });
    </script>
@endsection
