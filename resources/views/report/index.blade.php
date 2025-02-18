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
                        <form>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Substation</label>
                                <input type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">Start Date</label>
                                <input type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">End Date</label>
                                <input type="text" class="form-control w-75">
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary px-4">Generate</button>
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
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Report</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Substation Putrajaya</td>
                                    <td>24/12/2024</td>
                                    <td>14/1/2025</td>
                                    <td>
                                        <a href="#" class="text-success bi bi-download"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Substation Putrajaya</td>
                                    <td>24/12/2024</td>
                                    <td>14/1/2025</td>
                                    <td>
                                        <a href="#" class="text-success bi bi-download"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Substation Putrajaya</td>
                                    <td>24/12/2024</td>
                                    <td>14/1/2025</td>
                                    <td>
                                        <a href="#" class="text-success bi bi-download"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Substation Putrajaya</td>
                                    <td>24/12/2024</td>
                                    <td>14/1/2025</td>
                                    <td>
                                        <a href="#" class="text-success bi bi-download"></a>
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
