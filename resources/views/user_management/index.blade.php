@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>User Management</h1>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <!-- Upload Dataset Card -->
                <div class="card shadow-lg border-0 rounded-4 p-4">
                    <div class="card-body">
                        <h5 class="card-title">User Access Control</h5>
                
                        <!-- User Form -->
                        <form>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s Name</label>
                                <select name="email" class="form-control w-75">
                                    <option value=""></option>
                                    @foreach ($unverified_users as $unverified_user)
                                        <option value="{{ $unverified_user->id }}">{{ $unverified_user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s Email</label>
                                <select name="email" class="form-control w-75">
                                    <option value=""></option>
                                    @foreach ($unverified_users as $unverified_user)
                                        <option value="{{ $unverified_user->email }}">{{ $unverified_user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s ID</label>
                                <input type="text" class="form-control w-75">
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s Role</label>
                                <input type="text" class="form-control w-75">
                            </div>
                
                            <!-- Permission Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-start fw-bold">List Screen</th>
                                            <th>Full Access</th>
                                            <th>Read Only</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-start">Dashboard Admin</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Analytics</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Dataset</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Substation</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Asset</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Sensor</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Report Log</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">User Management</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                
                            <!-- Generate Button -->
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-info px-4">Generate</button>
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
                                    <th>User's Email</th>
                                    <th>User's Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>zulfitrih@gmail.com</td>
                                    <td>Staff Maintenance</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                    <td>
                                        <a href="#" class="bi bi-pencil-square text-primary"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>zulfitrih@gmail.com</td>
                                    <td>Staff Maintenance</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                    <td>
                                        <a href="#" class="bi bi-pencil-square text-primary"></a>
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
