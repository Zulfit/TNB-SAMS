@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Sensor</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sensor</a></li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="container-fluid p-0">
                <!-- Upload Dataset Card -->
                @if (in_array('create', $global_permissions['sensor_access'] ?? []) ||
                        in_array('full', $global_permissions['sensor_access'] ?? []))
                    <div class="card shadow-sm border-0 rounded-4">
                        <div
                            class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cpu me-2 text-primary fs-5"></i>
                                <h5 class="mb-0">Create New Sensor</h5>
                            </div>
                            <a href="{{ route('sensor.bulk-create') }}"
                                class="btn btn-outline-primary d-flex align-items-center">
                                <i class="bi bi-plus-circle me-1"></i> Bulk Create
                            </a>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('sensor.store') }}" method="POST">
                                @csrf

                                @if ($errors->has('custom_popup'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $errors->first('custom_popup') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                
                                <!-- Assigned Substation -->
                                <div class="mb-4">
                                    <label for="sensor_substation" class="form-label fw-semibold">Assigned
                                        Substation</label>
                                    <select id="sensor_substation" name="sensor_substation"
                                        class="form-select @error('sensor_substation') is-invalid @enderror"
                                        value="{{ old('sensor_substation') }}">
                                        <option value="">Select a substation</option>
                                        @foreach ($substations as $substation)
                                            <option value="{{ $substation->id }}">{{ $substation->substation_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('sensor_substation'))
                                        <div class="invalid-feedback">{{ $errors->first('sensor_substation') }}</div>
                                    @endif
                                </div>

                                <!-- Sensor Name -->
                                <div class="mb-4">
                                    <label for="sensor_name" class="form-label fw-semibold">Sensor Name</label>
                                    <input type="text" id="sensor_name" name="sensor_name"
                                        class="form-control @error('sensor_name') is-invalid @enderror"
                                        placeholder="Enter sensor name" value="{{ old('sensor_name') }}">
                                    @if ($errors->has('sensor_name'))
                                        <div class="invalid-feedback">{{ $errors->first('sensor_name') }}</div>
                                    @endif
                                </div>

                                <!-- Panels -->
                                <div class="mb-4">
                                    <label for="sensor_panel" class="form-label fw-semibold">Panel</label>
                                    <select id="sensor_panel" name="sensor_panel"
                                        class="form-select @error('sensor_panel') is-invalid @enderror"
                                        value="{{ old('sensor_panel') }}">
                                        <option value="">Select a panel</option>
                                        @foreach ($panels as $panel)
                                            <option value="{{ $panel->id }}">{{ $panel->panel_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('sensor_panel'))
                                        <div class="invalid-feedback">{{ $errors->first('sensor_panel') }}</div>
                                    @endif
                                </div>

                                <!-- Compartments -->
                                <div class="mb-4">
                                    <label for="sensor_compartment" class="form-label fw-semibold">Compartment</label>
                                    <select id="sensor_compartment" name="sensor_compartment"
                                        class="form-select @error('sensor_compartment') is-invalid @enderror"
                                        value="{{ old('sensor_compartment') }}">
                                        <option value="">Select a compartment</option>
                                        @foreach ($compartments as $compartment)
                                            <option value="{{ $compartment->id }}">{{ $compartment->compartment_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('sensor_compartment'))
                                        <div class="invalid-feedback">{{ $errors->first('sensor_compartment') }}</div>
                                    @endif
                                </div>

                                <!-- Measurement -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold d-block">Measurement</label>
                                    <div class="form-check form-check-inline @error('sensor_measurement') is-invalid @enderror"
                                        value="{{ old('sensor_measurement') }}">
                                        <input class="form-check-input" type="radio" id="temperature"
                                            name="sensor_measurement" value="Temperature" checked>
                                        <label class="form-check-label" for="temperature">Temperature</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="partial_discharge"
                                            name="sensor_measurement" value="Partial Discharge">
                                        <label class="form-check-label" for="partial_discharge">Partial Discharge</label>
                                    </div>
                                    @if ($errors->has('report_substation'))
                                        <div class="invalid-feedback">{{ $errors->first('report_substation') }}</div>
                                    @endif
                                </div>

                                <!-- Installation Date -->
                                <div class="mb-4">
                                    <label for="sensor_date" class="form-label fw-semibold">Installation Date</label>
                                    <input type="date" id="sensor_date" name="sensor_date"
                                        class="form-control @error('sensor_date') is-invalid @enderror"
                                        value="{{ old('sensor_date') }}">
                                    @if ($errors->has('sensor_date'))
                                        <div class="invalid-feedback">{{ $errors->first('sensor_date') }}</div>
                                    @endif
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label for="sensor_status" class="form-label fw-semibold">Status</label>
                                    <select id="sensor_status" name="sensor_status"
                                        class="form-select @error('sensor_status') is-invalid @enderror"
                                        value="{{ old('sensor_status') }}">
                                        <option value="">Select status</option>
                                        <option value="Online">Online</option>
                                        <option value="Offline">Offline</option>
                                    </select>
                                    @if ($errors->has('sensor_status'))
                                        <div class="invalid-feedback">{{ $errors->first('sensor_status') }}</div>
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-plus-circle me-2"></i>Create New
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Dataset Table -->

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Sensor List</h5>
                        <span class="badge bg-secondary">
                            {{ $sensors->total() }} {{ Str::plural('sensor', $sensors->total()) }}
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th class="py-3">#</th>
                                    <th class="py-3">Sensor Name</th>
                                    <th class="py-3">Location</th>
                                    <th class="py-3">Measurement</th>
                                    <th class="py-3">Installation Date</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if ($sensors->count() > 0)
                                    @foreach ($sensors as $sensor)
                                        <tr>
                                            <td>{{ $sensors->firstItem() + $loop->index }}</td>
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
                                            <td>{{ $sensor->sensor_date }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ ($sensor->sensor_status ?? '') === 'Online' ? 'bg-success' : 'bg-secondary' }}"
                                                    style="padding: 8px 12px; font-size: 0.8rem;">
                                                    {{ $sensor->sensor_status ?? 'Unknown' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (in_array('view', $global_permissions['sensor_access'] ?? []) ||
                                                        in_array('full', $global_permissions['sensor_access'] ?? []))
                                                    <a href="{{ route('sensor.show', $sensor->id) }}"
                                                        class="text-primary bi bi-eye"></a>
                                                @endif
                                                @if (in_array('edit', $global_permissions['sensor_access'] ?? []) ||
                                                        in_array('full', $global_permissions['sensor_access'] ?? []))
                                                    <a href="{{ route('sensor.edit', $sensor->id) }}"
                                                        class="text-success bi bi-pencil-square"></a>
                                                @endif
                                                @if (in_array('delete', $global_permissions['sensor_access'] ?? []) ||
                                                        in_array('full', $global_permissions['sensor_access'] ?? []))
                                                    <form action="{{ route('sensor.destroy', $sensor->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this sensor?');"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="border-0 bg-transparent text-danger bi bi-trash"></button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                                <h5 class="text-muted">No Sensor Found</h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Simple Pagination --}}
                    <div class="card-footer bg-white d-flex justify-content-center">
                        {{ $sensors->links() }}
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection
