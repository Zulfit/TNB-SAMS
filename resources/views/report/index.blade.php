@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Report Log</h1>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <!-- Upload Dataset Card -->
                <div class="card shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Generate New Report</h5>

                        <!-- Upload Form -->
                        <form action="{{ route('report.store') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Substation</label>
                                <select name="report_substation" class="form-control w-75">
                                    <option value=""></option>
                                    @foreach ($substations as $substation)
                                        <option value="{{ $substation->id }}">{{ $substation->substation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Panel</label>
                                <select name="report_panel" class="form-control w-75">
                                    <option value=""></option>
                                    @foreach ($panels as $panel)
                                        <option value="{{ $panel->id }}">{{ $panel->panel_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Compartment</label>
                                <select name="report_compartment" class="form-control w-75">
                                    <option value=""></option>
                                    @foreach ($compartments as $compartment)
                                        <option value="{{ $compartment->id }}">{{ $compartment->compartment_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Start Date</label>
                                <input name="start_date" type="date" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">End Date</label>
                                <input name="end_date" type="date" class="form-control w-75">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">Generate</button>
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
                                    <th>Substation</th>
                                    <th>Panel</th>
                                    <th>Compartment</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Report</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $report->substation->substation_name }}</td>
                                        <td>{{ $report->panel->panel_name }}</td>
                                        <td>{{ $report->compartment->compartment_name }}</td>
                                        <td>{{ $report->start_date }}</td>
                                        <td>{{ $report->end_date }}</td>
                                        <td>
                                            <a href="#" class="text-success bi bi-download"></a>
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
