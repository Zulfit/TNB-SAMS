@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Asset</h1>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <!-- Upload Dataset Card -->
                <div class="card shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Create New Asset</h5>

                        <!-- Upload Form -->
                        <form action="{{ route('asset.store') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Asset Name</label>
                                <input name="asset_name" type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Asset Type</label>
                                <select name="asset_type" class="form-control w-75">
                                    <option value=""></option>
                                    <option value="Switchgear">Switchgear</option>
                                    <option value="Transformer">Transformer</option>
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Assigned Substation</label>
                                <select name="asset_substation" class="form-control w-75">
                                    <option value=""></option>
                                    @foreach ($substations as $substation)
                                        <option value="{{ $substation->id }}">{{ $substation->substation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Installation Date</label>
                                <input name="asset_date" type="date" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Status</label>
                                <select name="asset_status" class="form-control w-75">
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
                                    <th>Asset Name</th>
                                    <th>Asset Type</th>
                                    <th>Assigned Substation</th>
                                    <th>Installation Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($assets as $asset)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $asset->asset_name }}</td>
                                        <td>{{ $asset->asset_type }}</td>
                                        <td>{{ $asset->substation->substation_name}}</td>
                                        <td>{{ $asset->asset_date }}</td>
                                        <td><span class="badge bg-success">{{ $asset->asset_status }}</span></td>
                                        <td>
                                            <a href="#" class="text-primary bi bi-eye"></a>
                                            <a href="#" class="text-success bi bi-pencil-square"></a>
                                            <form action="{{ route('asset.destroy', $asset->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this milestone?');"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-transparent text-danger bi bi-trash"></button>
                                            </form>
                                        </td>
                                    </tr>
                                    {{ $i++ }}
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection
