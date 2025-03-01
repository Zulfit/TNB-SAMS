@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Substation</h1>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <!-- Upload Dataset Card -->
                <div class="card shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Create New Substation</h5>

                        <!-- Upload Form -->
                        <form action="{{ route('substation.store') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Substation Name</label>
                                <input name="substation_name" type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Substation Location</label>
                                <input name="substation_location" type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Commisioning Date</label>
                                <input name="substation_date" type="date" class="form-control w-75">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button name="submit" type="submit" class="btn btn-primary px-4">Create New</button>
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
                                    <th>Substation Name</th>
                                    <th>Substation Location</th>
                                    <th>Commissioning Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($substations as $substation)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $substation->substation_name }}</td>
                                        <td>{{ $substation->substation_location }}</td>
                                        <td>{{ $substation->substation_date }}</td>
                                        <td>
                                            <a href="#" class="text-primary bi bi-eye"></a>
                                            <a href="#" class="text-success bi bi-pencil-square"></a>
                                            <form action="{{ route(  'substation.destroy', $substation->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this milestone?');"
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
