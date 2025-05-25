@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Substation</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('substation.index') }}">Substation</a></li>
                    <li class="breadcrumb-item active">Edit Substation</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <!-- Upload Dataset Card -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0"><i class="bi bi-building me-2"></i>Substation Details</h5>
                    </div>
                    <div class="card-body p-4">

                        <!-- Upload Form -->
                        <form action="{{ route('substation.update', $substation->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Substation Name</label>
                                <input value="{{ $substation->substation_name }}" name="substation_name" type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Substation Location</label>
                                <input value="{{ $substation->substation_location }}" name="substation_location" type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Commisioning Date</label>
                                <input value="{{ $substation->substation_date }}" name="substation_date" type="date" class="form-control w-75">
                            </div>

                            <div class="text-end mt-3">
                                <button name="submit" type="submit" class="btn btn-primary px-4">Update</button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Dataset Table -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Substation List</h5>
                        <span class="badge bg-secondary">
                            {{ isset($substations) ? count($substations) : 0 }}
                            {{ isset($substations) ? Str::plural('substation', count($substations)) : 'substations' }}
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th class="py-3">#</th>
                                    <th class="py-3">Substation Name</th>
                                    <th class="py-3">Functional Location No</th>
                                    <th class="py-3">Commissioning Date</th>
                                    <th class="py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if (isset($substations) && count($substations) > 0)
                                    @foreach ($substations as $substation)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $substation->substation_name }}</td>
                                            <td>{{ $substation->substation_location }}</td>
                                            <td>{{ $substation->substation_date }}</td>
                                            <td>
                                                @if (in_array('view', $global_permissions['substation_access'] ?? []) ||
                                                        in_array('full', $global_permissions['substation_access'] ?? []))
                                                    <a href="{{ route('substation.show', $substation->id) }}"
                                                        class="text-primary bi bi-eye"></a>
                                                @endif
                                                @if (in_array('edit', $global_permissions['substation_access'] ?? []) ||
                                                        in_array('full', $global_permissions['substation_access'] ?? []))
                                                    <a
                                                        href="{{ route('substation.edit', $substation->id) }}"class="text-success bi bi-pencil-square"></a>
                                                @endif
                                                @if (in_array('delete', $global_permissions['substation_access'] ?? []) ||
                                                        in_array('full', $global_permissions['substation_access'] ?? []))
                                                    <form action="{{ route('substation.destroy', $substation->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this substation?');"
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
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                                <h5 class="text-muted">No Substation Found</h5>
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
