@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Error Log</h1>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <div class="card mt-4 shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Timestamp</th>
                                        <th>Sensor Name</th>
                                        <th>Substation</th>
                                        <th>Panel</th>
                                        <th>Compartment</th>
                                        <th>Measurement</th>
                                        <th>State</th>
                                        <th>Threshold</th>
                                        <th>Severity</th>
                                        <th>PIC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($errors as $error)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $error->updated_at }}</td>
                                            <td>{{ $error->sensor->sensor_name }}</td>
                                            <td>{{ $error->sensor->substation->substation_name }}</td>
                                            <td>{{ $error->sensor->panel->panel_name }}</td>
                                            <td>{{ $error->sensor->compartment->compartment_name }}</td>
                                            <td>{{ $error->sensor->sensor_measurement }}</td>
                                            <td>
                                                <span class="badge {{ $error->getStateBadgeClass() }}">
                                                    {{ $error->state }}
                                                </span>
                                            </td>
                                            <td>{{ $error->threshold }}</td>
                                            <td>
                                                <span class="badge {{ $error->getSeverityBadgeClass() }}">
                                                    {{ $error->severity }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($error->pic === 1)
                                                    <a href="{{ route('error-log.assign', $error->id) }}"
                                                        class="badge bg-secondary text-decoration-none">
                                                        Unassigned
                                                    </a>
                                                @else
                                                    <a href="{{ route('error-log.assign', $error->id) }}"
                                                        class="badge bg-primary text-decoration-none">
                                                        {{ $error->user->name }}
                                                    </a>
                                                @endif
                                            </td>
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
@endsection
