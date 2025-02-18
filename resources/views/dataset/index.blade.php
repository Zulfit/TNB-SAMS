@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Analytics Sensor</h1>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <!-- Upload Dataset Card -->
                <div class="card shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Upload Dataset</h5>

                        <!-- Upload Form -->
                        <form>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">File</label>
                                <input type="file" class="form-control w-75">
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sensorType" id="ais" checked>
                                    <label class="form-check-label" for="ais">AIS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sensorType" id="gis">
                                    <label class="form-check-label" for="gis">GIS</label>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Substation</label>
                                <select class="form-select w-25">
                                    <option>Select Substation</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary px-4">Upload</button>
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
                                    <th>File</th>
                                    <th>Type</th>
                                    <th>Substation</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Sensor v1</td>
                                    <td>AIS</td>
                                    <td>Substation Ampang</td>
                                    <td>24/12/2024</td>
                                    <td><span class="badge bg-warning text-dark">Loading</span></td>
                                    <td><a href="#" class="bi bi-trash text-danger"></a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Sensor v1</td>
                                    <td>GIS</td>
                                    <td>Substation Cheras</td>
                                    <td>20/11/2024</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                    <td><a href="#" class="bi bi-trash text-danger"></a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Sensor v1</td>
                                    <td>AIS</td>
                                    <td>Substation Keramat</td>
                                    <td>20/11/2024</td>
                                    <td><span class="badge bg-danger">Failed</span></td>
                                    <td><a href="#" class="bi bi-trash text-danger"></a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Sensor v1</td>
                                    <td>GIS</td>
                                    <td>Substation Bangi</td>
                                    <td>4/10/2024</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                    <td><a href="#" class="bi bi-trash text-danger"></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection
