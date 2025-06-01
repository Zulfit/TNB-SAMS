@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Sensor</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sensor.index') }}">Sensor</a></li>
                    <li class="breadcrumb-item active">Edit Sensor</a></li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="container-fluid p-0">
                <!-- Upload Dataset Card -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Sensor Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('sensor.update', $sensor->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                
                            <!-- Sensor Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sensor Name</label>
                                <input name="sensor_name" type="text" class="form-control"
                                    value="{{ old('sensor_name', $sensor->sensor_name) }}">
                            </div>
                
                            <!-- Substation -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Assigned Substation</label>
                                <select name="sensor_substation" class="form-select">
                                    @foreach ($substations as $substation)
                                        <option value="{{ $substation->id }}"
                                            {{ old('sensor_substation', $sensor->substation_id) == $substation->id ? 'selected' : '' }}>
                                            {{ $substation->substation_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                
                            <!-- Panel -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Panel</label>
                                <select name="sensor_panel" class="form-select">
                                    @foreach ($panels as $panel)
                                        <option value="{{ $panel->id }}"
                                            {{ old('sensor_panel', $sensor->panel_id) == $panel->id ? 'selected' : '' }}>
                                            {{ $panel->panel_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                
                            <!-- Compartment -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Compartment</label>
                                <select name="sensor_compartment" class="form-select">
                                    @foreach ($compartments as $compartment)
                                        <option value="{{ $compartment->id }}"
                                            {{ old('sensor_compartment', $sensor->compartment_id) == $compartment->id ? 'selected' : '' }}>
                                            {{ $compartment->compartment_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                
                            <!-- Measurement -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold d-block">Measurement</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sensor_measurement" id="Temperature"
                                        value="Temperature"
                                        {{ old('sensor_measurement', $sensor->sensor_measurement) == 'Temperature' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Temperature">Temperature</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sensor_measurement" id="PartialDischarge"
                                        value="Partial Discharge"
                                        {{ old('sensor_measurement', $sensor->sensor_measurement) == 'Partial Discharge' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PartialDischarge">Partial Discharge</label>
                                </div>
                            </div>
                
                            <!-- Installation Date -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Installation Date</label>
                                <input name="sensor_date" type="date" class="form-control"
                                    value="{{ old('sensor_date', $sensor->sensor_date) }}">
                            </div>
                
                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="sensor_status" class="form-select">
                                    <option value="Online" {{ old('sensor_status', $sensor->sensor_status) == 'Online' ? 'selected' : '' }}>Online</option>
                                    <option value="Offline" {{ old('sensor_status', $sensor->sensor_status) == 'Offline' ? 'selected' : '' }}>Offline</option>
                                </select>
                            </div>
                
                            <!-- Submit -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>                

                <!-- Dataset Table -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Sensor List</h5>
                        <span class="badge bg-secondary">
                            {{ isset($sensors) ? count($sensors) : 0 }}
                            {{ isset($sensors) ? Str::plural('sensor', count($sensors)) : 'sensors' }}
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
                                                
                                            <td>{{ $sensor->sensor_date }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ ($sensor->sensor_status ?? '') === 'Active' ? 'bg-success' : 'bg-secondary' }}"
                                                    style="padding: 8px 12px; font-size: 0.8rem;">
                                                    {{ $sensor->sensor_status ?? 'Unknown' }}
                                                </span>
                                            </td>                                            <td>
                                                @if (in_array('view', $global_permissions['sensor_access'] ?? []) ||
                                                        in_array('full', $global_permissions['sensor_access'] ?? []))
                                                    <a href="{{ route('sensor.show', $sensor->id) }}"
                                                        class="text-primary bi bi-eye"></a>
                                                @endif
                                                @if (in_array('edit', $global_permissions['sensor_access'] ?? []) ||
                                                        in_array('full', $global_permissions['sensor_access'] ?? []))
                                                    <a
                                                        href="{{ route('sensor.edit', $sensor->id) }}"class="text-success bi bi-pencil-square"></a>
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
                                        <td colspan="12" class="text-center py-5">
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
                    <div class="card-footer bg-white d-flex justify-content-center">
                        {{ $sensors->links() }}
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection
