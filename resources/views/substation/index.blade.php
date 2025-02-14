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
                        <h4 class="card-title fw-bold">Create New Substation</h4>

                        <!-- Upload Form -->
                        <form>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Substation Name</label>
                                <input type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Substation Location</label>
                                <input type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Commisioning Date</label>
                                <input type="text" class="form-control w-75">
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary px-4">Create New</button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Dataset Table -->
                <div class="card mt-4 shadow-lg border-0 rounded-4 p-3">
                    <div class="card-body">
                        <table class="table table-bordered align-middle">
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
                                <tr>
                                    <td>1</td>
                                    <td>Substation Ampang</td>
                                    <td>234 Industrial Road, Kuala Lumpur</td>
                                    <td>24/12/2024</td>
                                    <td>
                                        <button class="btn btn-info bi bi-eye"></button>
                                        <button class="btn btn-warning bi bi-pencil-square"></button>
                                        <button class="btn btn-danger bi bi-trash"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Substation Ampang</td>
                                    <td>234 Industrial Road, Kuala Lumpur</td>
                                    <td>24/12/2024</td>
                                    <td>
                                        <button class="btn btn-info bi bi-eye"></button>
                                        <button class="btn btn-warning bi bi-pencil-square"></button>
                                        <button class="btn btn-danger bi bi-trash"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Substation Ampang</td>
                                    <td>234 Industrial Road, Kuala Lumpur</td>
                                    <td>24/12/2024</td>
                                    <td>
                                        <button class="btn btn-info bi bi-eye"></button>
                                        <button class="btn btn-warning bi bi-pencil-square"></button>
                                        <button class="btn btn-danger bi bi-trash"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Substation Ampang</td>
                                    <td>234 Industrial Road, Kuala Lumpur</td>
                                    <td>24/12/2024</td>
                                    <td>
                                        <button class="btn btn-info bi bi-eye"></button>
                                        <button class="btn btn-warning bi bi-pencil-square"></button>
                                        <button class="btn btn-danger bi bi-trash"></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection
