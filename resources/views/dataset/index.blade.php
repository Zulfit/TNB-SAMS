@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dataset</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Dataset</a></li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="container-fluid p-0">
                <!-- Upload Dataset Card -->
                @if (in_array('create', $global_permissions['dataset_access'] ?? []) ||
                        in_array('full', $global_permissions['dataset_access'] ?? []))
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0"><i class="bi bi-upload me-2"></i>Upload Dataset</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('dataset.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- File Input -->
                                <div class="mb-4">
                                    <label for="dataset_file" class="form-label fw-semibold">Dataset File</label>
                                    <input name="dataset_file" type="file" id="dataset_file"
                                        class="form-control @error('dataset_file') is-invalid @enderror"
                                        value="{{ old('dataset_file') }}">
                                    @if ($errors->has('dataset_file'))
                                        <div class="invalid-feedback">{{ $errors->first('dataset_file') }}</div>
                                    @endif
                                </div>

                                <!-- Type Selection -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold d-block">Dataset Type</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="dataset_measurement"
                                            id="type_temperature" value="Temperature" checked>
                                        <label class="form-check-label" for="type_temperature">Temperature</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="dataset_measurement"
                                            id="type_partial_discharge" value="Partial Discharge">
                                        <label class="form-check-label" for="type_partial_discharge">Partial
                                            Discharge</label>
                                    </div>
                                </div>

                                <!-- Sensor Selection -->
                                <div class="mb-4">
                                    <label for="dataset_sensor" class="form-label fw-semibold">Sensor</label>
                                    <select name="dataset_sensor" id="dataset_sensor"
                                        class="form-select @error('dataset_sensor') is-invalid @enderror"
                                        value="{{ old('dataset_sensor') }}">
                                        <option value="">Select Sensor</option>
                                        @foreach ($sensors as $sensor)
                                            <option value="{{ $sensor->id }}">{{ $sensor->sensor_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('dataset_sensor'))
                                        <div class="invalid-feedback">{{ $errors->first('dataset_sensor') }}</div>
                                    @endif
                                </div>

                                @if ($errors->has('custom_popup'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $errors->first('custom_popup') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-cloud-upload me-2"></i>Upload
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Dataset Table -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Dataset List</h5>
                        <span class="badge bg-secondary">
                            {{ isset($datasets) ? count($datasets) : 0 }}
                            {{ isset($datasets) ? Str::plural('dataset', count($datasets)) : 'datasets' }}
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th class="py-3">#</th>
                                    <th class="py-3">File</th>
                                    <th class="py-3">Measurement</th>
                                    <th class="py-3">Sensor</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Status</th>
                                    {{-- <th class="py-3">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if (isset($datasets) && count($datasets) > 0)
                                    @foreach ($datasets as $dataset)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dataset->dataset_file }}</td>
                                            <td>{{ $dataset->dataset_measurement }}</td>
                                            <td>{{ $dataset->sensor->sensor_name }}</td>
                                            <td>{{ $dataset->created_at }}</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                            {{-- <td>
                                                @if (in_array('delete', $global_permissions['dataset_access'] ?? []) ||
                                                        in_array('full', $global_permissions['dataset_access'] ?? []))
                                                    <form action="{{ route('dataset.destroy', $dataset->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this dataset?');"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="border-0 bg-transparent text-danger bi bi-trash"></button>
                                                    </form>
                                                @endif
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                                <h5 class="text-muted">No Dataset Found</h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
