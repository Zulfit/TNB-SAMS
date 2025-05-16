@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Error Log</h1>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">

                <div class="card shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Error Summary</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th>Timestamp:</th>
                                <td>{{ $error->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Sensor Name:</th>
                                <td>{{ $error->sensor->sensor_name }}</td>
                            </tr>
                            <tr>
                                <th>Substation Location:</th>
                                <td>{{ $error->sensor->substation->substation_location }}</td>
                            </tr>
                            <tr>
                                <th>Panel:</th>
                                <td>{{ $error->sensor->panel->panel_name }}</td>
                            </tr>
                            <tr>
                                <th>Compartment:</th>
                                <td>{{ $error->sensor->compartment->compartment_name }}</td>
                            </tr>
                            <tr>
                                <th>Measurement:</th>
                                <td>{{ $error->sensor->sensor_measurement }}</td>
                            </tr>
                            <tr>
                                <th>Threshold:</th>
                                <td>{{ $error->threshold }}</td>
                            </tr>
                            <tr>
                                <th>State:</th>
                                <td>
                                    <span class="badge {{ $error->getStateBadgeClass() }}">
                                        {{ $error->state }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Severity:</th>
                                <td>
                                    <span class="badge {{ $error->getSeverityBadgeClass() }}">
                                        {{ $error->severity }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Upload Dataset Card -->
                <div class="card shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Assign Staff</h5>

                        <!-- Upload Form -->
                        <form action="{{ route('error-log.update', $error->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Staff Name</label>
                                <select name="pic" type="text" class="form-control w-75">
                                    <option value=""></option>
                                    @foreach ($staff as $one_staff)
                                        <option value="{{ $one_staff->id }}"
                                            {{ $error->pic == $one_staff->id ? 'selected' : '' }}>
                                            {{ $one_staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Description</label>
                                <textarea name="desc" type="text" class="form-control w-75">{{ old('desc', $error->desc) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                @if (auth()->id() == $error->pic && $error->assigned_by)
                                    {{-- PIC wants to chat with assigner --}}
                                    <a href="{{ route('chat.with.user', ['userId' => $error->assigned_by]) }}"
                                        class="btn btn-secondary" title="Message Admin">
                                        <i class="fas fa-comment-dots"></i>
                                    </a>
                                @elseif (auth()->id() == $error->assigned_by && $error->pic)
                                    {{-- Assigner wants to chat with PIC --}}
                                    <a href="{{ route('chat.with.user', ['userId' => $error->pic]) }}"
                                        class="btn btn-secondary" title="Message Staff">
                                        <i class="fas fa-comment-dots"></i>
                                    </a>
                                @endif

                                @if (Auth::user()->position == 'Staff')
                                    <form action="{{ route('error-log.update', $error->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="complete">
                                        <button type="submit" class="btn btn-primary px-4">
                                            Complete
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('error-log.update', $error->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="assign">
                                        <button type="submit" class="btn btn-primary px-4">
                                            {{ $error->pic && $error->pic != 1 ? 'Update' : 'Assign' }}
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </section>
    </main>
@endsection
