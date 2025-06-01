@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Sensor</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sensor</a></li>
                    {{-- <li class="breadcrumb-item active"><a href="{{ route('sub.index') }}">Substation</a></li>
                    <li class="breadcrumb-item active">Error Details</li> --}}
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="container-fluid p-0">
                <!-- Upload Dataset Card -->
                @if (in_array('create', $global_permissions['sensor_access'] ?? []) ||
                        in_array('full', $global_permissions['sensor_access'] ?? []))
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cpu me-2 text-primary fs-5"></i>
                                <h5 class="mb-0">Create New Sensor</h5>
                            </div>
                            <a href="{{ route('sensor.index') }}" class="btn btn-outline-primary d-flex align-items-center">
                                <i class="bi bi-plus-circle me-1"></i> Single Create
                            </a>
                        </div>
                        
                        <div class="card-body p-4">
                            <form id="bulk-sensor-form" action="{{ route('sensor.bulk-store') }}" method="POST">
                                @csrf
                        
                                <!-- Assigned Substation -->
                                <div class="mb-4">
                                    <label for="sensor_substation" class="form-label fw-semibold">Assigned Substation</label>
                                    <select id="sensor_substation" name="substation_id" class="form-select" required>
                                        <option value="">Select a substation</option>
                                        @foreach ($substations as $substation)
                                            <option value="{{ $substation->id }}">{{ $substation->substation_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <!-- Dynamic Sensor Inputs -->
                                <div id="sensors-container">
                                    <div class="sensor-block border p-3 mb-3 rounded">
                                        <!-- Sensor Name -->
                                        <div class="mb-2">
                                            <label class="form-label fw-semibold">Sensor Name</label>
                                            <input type="text" name="sensors[0][name]" class="form-control" placeholder="Enter sensor name" required>
                                        </div>
                        
                                        <!-- Panel -->
                                        <div class="mb-2">
                                            <label class="form-label fw-semibold">Panel</label>
                                            <select name="sensors[0][panel_id]" class="form-select" required>
                                                <option value="">Select a panel</option>
                                                @foreach ($panels as $panel)
                                                    <option value="{{ $panel->id }}">{{ $panel->panel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                        
                                        <!-- Compartment Checkboxes -->
                                        <div class="mb-2">
                                            <label class="form-label fw-semibold d-block">Compartments</label>
                                            @foreach ($compartments as $compartment)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="sensors[0][compartments][]" value="{{ $compartment->id }}">
                                                    <label class="form-check-label">{{ $compartment->compartment_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                        
                                        <!-- Measurement -->
                                        <div class="mb-2">
                                            <label class="form-label fw-semibold d-block">Measurement</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sensors[0][measurement]" value="Temperature" checked>
                                                <label class="form-check-label">Temperature</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sensors[0][measurement]" value="Partial Discharge">
                                                <label class="form-check-label">Partial Discharge</label>
                                            </div>
                                        </div>
                        
                                        <!-- Status -->
                                        <div class="mb-2">
                                            <label class="form-label fw-semibold">Status</label>
                                            <select name="sensors[0][status]" class="form-select" required>
                                                <option value="">Select status</option>
                                                <option value="Online">Online</option>
                                                <option value="Offline">Offline</option>
                                            </select>
                                        </div>
                        
                                        <!-- Remove button -->
                                        <button type="button" class="btn btn-danger btn-sm remove-sensor-btn mt-2">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                        
                                <!-- Add More Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary" id="add-sensor-btn">
                                        <i class="bi bi-plus-circle"></i> Add More
                                    </button>
                                </div>
                        
                                <!-- Installation Date -->
                                <div class="mb-4">
                                    <label for="installation_date" class="form-label fw-semibold">Installation Date</label>
                                    <input type="date" id="installation_date" name="installation_date" class="form-control" required>
                                </div>
                        
                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-plus-circle me-2"></i>Create Bulk Sensors
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

            <script>
                let sensorIndex = 1;
            
                document.getElementById('add-sensor-btn').addEventListener('click', function () {
                    const container = document.getElementById('sensors-container');
                    const firstBlock = container.querySelector('.sensor-block');
                    const newBlock = firstBlock.cloneNode(true);
            
                    // Clear inputs
                    newBlock.querySelectorAll('input, select').forEach(el => {
                        if (el.type === 'text') el.value = '';
                        if (el.type === 'checkbox' || el.type === 'radio') el.checked = false;
                        if (el.tagName === 'SELECT') el.selectedIndex = 0;
                    });
            
                    // Update name attributes with new index
                    newBlock.querySelectorAll('input, select').forEach(el => {
                        if (el.name) {
                            el.name = el.name.replace(/\d+/, sensorIndex);
                        }
                    });
            
                    container.appendChild(newBlock);
                    sensorIndex++;
                });
            
                document.getElementById('sensors-container').addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-sensor-btn')) {
                        const block = e.target.closest('.sensor-block');
                        if (document.querySelectorAll('.sensor-block').length > 1) {
                            block.remove();
                        } else {
                            alert('At least one sensor input is required.');
                        }
                    }
                });
            </script>

        </section>
    </main>
@endsection
