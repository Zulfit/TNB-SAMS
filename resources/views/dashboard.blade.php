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
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
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
                        <h1 class="fw-bold display-4">10</h1>
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
                            <h1 class="fw-bold display-4">50</h1>
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
                        <h1 class="fw-bold display-4">20</h1>
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
                <div class="card shadow-lg border-0 rounded-4 p-3" style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                    <div class="card-body">
                        <!-- Title & Filters -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Sensor Temperature °C</h5>
                            <div>
                                <span>Substation</span>
                                <select class="form-select d-inline-block w-auto mx-2">
                                    <option>Substation Cheras</option>
                                    <option>Substation Ampang</option>
                                </select>
                                <span>Switchgear</span>
                                <select class="form-select d-inline-block w-auto">
                                    <option>SG-01</option>
                                    <option>SG-02</option>
                                </select>
                            </div>
                        </div>
            
                        <!-- Chart -->
                        <canvas id="tempChart" style="max-height: 400px;"></canvas>
            
                        <!-- Legend & Info -->
                        <div class="d-flex justify-content-between align-items-center mt-3">

                            
                            <!-- Legend -->
                            <div>
                                <span class="d-flex align-items-center"><span class="rounded-circle bg-danger d-inline-block me-2" style="width: 10px; height: 10px;"></span> Wire Red</span>
                                <span class="d-flex align-items-center"><span class="rounded-circle bg-warning d-inline-block me-2" style="width: 10px; height: 10px;"></span> Wire Yellow</span>
                                <span class="d-flex align-items-center"><span class="rounded-circle bg-primary d-inline-block me-2" style="width: 10px; height: 10px;"></span> Wire Blue</span>
                            </div>
            
                            <!-- Metrics -->
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span>Variance between wires</span>
                                    <input type="text" class="form-control text-center w-25" value="10.56 %" readonly>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span>Maximum variances</span>
                                    <input type="text" class="form-control text-center w-25" value="12 %" readonly>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Maximum temperature</span>
                                    <input type="text" class="form-control text-center w-25" value="50°C" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        {{-- Sensor Partial Discharge --}}
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-4 p-3" style="background: white; box-shadow: 0px 4px 20px rgba(120, 100, 200, 0.3);">
                <div class="card-body">
                    <!-- Title & Filters -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">Sensor Partial Discharge</h5>
                        <div>
                            <span>Substation</span>
                            <select class="form-select d-inline-block w-auto mx-2">
                                <option>Substation Cheras</option>
                                <option>Substation Ampang</option>
                            </select>
                            <span>Switchgear</span>
                            <select class="form-select d-inline-block w-auto">
                                <option>SG-01</option>
                                <option>SG-02</option>
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

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'],
                        datasets: [
                            {
                                label: 'Wire Red',
                                data: [22, 24, 23, 26, 25, 23, 22],
                                borderColor: 'red',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.3
                            },
                            {
                                label: 'Wire Yellow',
                                data: [28, 30, 29, 32, 31, 30, 28],
                                borderColor: 'yellow',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.3
                            },
                            {
                                label: 'Wire Blue',
                                data: [18, 20, 19, 22, 21, 20, 18],
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
                                display: false // Hide the default legend (we use a custom one above)
                            }
                        }
                    }
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('pdChart').getContext('2d');
        
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'],
                        datasets: [{
                            label: '',
                            data: [0, 15, 14, 13, 12, 20, 18, 25, 22, 30],
                            borderColor: '#2563eb',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.2
                        }]
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
            });
        </script>
        

          </div>
        </div>

        

      </div>
    </section>

  </main><!-- End #main -->
@endsection
  

