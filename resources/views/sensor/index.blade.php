@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Sensor</h1>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <!-- Upload Dataset Card -->
                <div class="card shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Create New Sensor</h5>

                        <!-- Upload Form -->
                        <form action="{{ route('sensor.store') }}" method="POST">
                            @csrf

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Sensor Name</label>
                                <input name="sensor_name" type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Assigned Substation</label>
                                <select name="sensor_substation" class="form-control w-75">
                                    <option value=""></option>

                                    @foreach ($substations as $substation)
                                        <option value="{{ $substation->id }}">{{ $substation->substation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Panels</label>
                                <select name="sensor_panel" class="form-control w-75">
                                    <option value=""></option>

                                    @foreach ($panels as $panel)
                                        <option value="{{ $panel->id }}">{{ $panel->panel_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Compartments</label>
                                <select name="sensor_compartment" class="form-control w-75">
                                    <option value=""></option>
                                    @foreach ($compartments as $compartment)
                                        <option value="{{ $compartment->id }}">{{ $compartment->compartment_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Measurement</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sensor_measurement" id="ais" checked>
                                    <label class="form-check-label" for="Temperature">Temperature</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sensor_measurement" id="gis">
                                    <label class="form-check-label" for="Partial Discharge">Partial Discharge</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Installation Date</label>
                                <input name="sensor_date" type="date" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Status</label>
                                <select name="sensor_status" class="form-control w-75">
                                    <option value=""></option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">Create New</button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Dataset Table -->
                <div class="card mt-4 shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Sensor Name</th>
                                    <th>Assigned Substation</th>
                                    <th>Panel</th>
                                    <th>Compartment</th>
                                    <th>Measurement</th>
                                    <th>Installation Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                                        <td>{{ $sensor->sensor_measurement}}</td>
                                        <td>{{ $sensor->sensor_date }}</td>
                                        <td><span class="badge bg-success">{{ $sensor->sensor_status }}</span></td>
                                        <td>
                                            <a href="{{ route('sensor.show',$sensor->id) }}" class="text-primary bi bi-eye"></a>
                                            <a href="{{ route('sensor.edit',$sensor->id) }}"class="text-success bi bi-pencil-square"></a>
                                            <form action="{{ route(  'sensor.destroy', $sensor->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this sensor?');"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-transparent text-danger bi bi-trash"></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection
