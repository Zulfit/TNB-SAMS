@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dataset</h1>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <!-- Upload Dataset Card -->
                <div class="card shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Upload Dataset</h5>

                        <!-- Upload Form -->
                        <form action="{{ route('dataset.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">File</label>
                                <input name="dataset_file" type="file" class="form-control w-75">
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dataset_measurement"
                                        id="Temperature" value="Temperature" checked>
                                    <label class="form-check-label" for="Temperature">Temperature</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dataset_measurement"
                                        id="Partial Discharge" value="Partial Discharge">
                                    <label class="form-check-label" for="Partial Discharge">Partial Discharge</label>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Sensor</label>
                                <select name="dataset_sensor" class="form-select w-25">
                                    <option value="">Select Sensor</option>
                                    @foreach ($sensors as $sensor)
                                        <option value="{{ $sensor->id }}">{{ $sensor->sensor_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">Upload</button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Dataset Table -->
                @if ($datasets->count() > 0)
                    <div class="card mt-4 shadow-lg border-0 rounded-4 p-3">
                        <div class="card-body">
                            <table class="table table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>File</th>
                                        <th>Measurement</th>
                                        <th>Sensor</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datasets as $dataset)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dataset->dataset_file }}</td>
                                            <td>{{ $dataset->dataset_measurement }}</td>
                                            <td>{{ $dataset->sensor->sensor_name }}</td>
                                            <td>{{ $dataset->created_at }}</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                            {{-- <td><span class="badge bg-warning text-dark">Loading</span></td> --}}
                                            <td><a href="#" class="bi bi-trash text-danger"></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

        </section>
    </main>
@endsection
