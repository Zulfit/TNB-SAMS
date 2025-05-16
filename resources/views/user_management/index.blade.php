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
                        <form action= "{{ route('user_management.store') }}" method="POST">
                            @csrf
                            <!-- User's Name Dropdown -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s Name</label>
                                <select name="user_id" id="user-select" class="form-control w-75">
                                    <option value="" selected disabled>Select a user</option>
                                    @foreach ($unverified_users as $unverified_user)
                                        <option value="{{ $unverified_user->id }}"
                                            data-email="{{ $unverified_user->email }}"
                                            data-id="{{ $unverified_user->id_staff }}"
                                            data-role="{{ $unverified_user->position }}">
                                            {{ $unverified_user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- User’s Email (Auto-filled) -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s Email</label>
                                <input type="text" id="user-email" class="form-control w-75 readonly-field" readonly>
                            </div>

                            <!-- User’s ID (Auto-filled) -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s ID</label>
                                <input type="text" id="user-id" class="form-control w-75 readonly-field" readonly>
                            </div>

                            <!-- User’s Role (Auto-filled) -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s Role</label>
                                <input type="text" id="user-role" class="form-control w-75 readonly-field" readonly>
                            </div>


                            <!-- Permission Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-start fw-bold">List Screen</th>
                                            <th>Full Access</th>
                                            <th>View</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-start">Dashboard</td>
                                            <td><input name="dashboard_access[]" type="checkbox" value="full"></td>
                                            <td><input name="dashboard_access[]" type="checkbox" value="view"></td>
                                            <td><input name="dashboard_access[]" type="checkbox" value="create"></td>
                                            <td><input name="dashboard_access[]" type="checkbox" value="edit"></td>
                                            <td><input name="dashboard_access[]" type="checkbox" value="delete"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Analytics</td>
                                            <td><input name="analytics_access[]" type="checkbox" value="full"></td>
                                            <td><input name="analytics_access[]" type="checkbox" value="view"></td>
                                            <td><input name="analytics_access[]" type="checkbox" value="create"></td>
                                            <td><input name="analytics_access[]" type="checkbox" value="edit"></td>
                                            <td><input name="analytics_access[]" type="checkbox" value="delete"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Dataset</td>
                                            <td><input name="dataset_access[]" type="checkbox" value="full"></td>
                                            <td><input name="dataset_access[]" type="checkbox" value="view"></td>
                                            <td><input name="dataset_access[]" type="checkbox" value="create"></td>
                                            <td><input name="dataset_access[]" type="checkbox" value="edit"></td>
                                            <td><input name="dataset_access[]" type="checkbox" value="delete"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Substation</td>
                                            <td><input name="substation_access[]" type="checkbox" value="full"></td>
                                            <td><input name="substation_access[]" type="checkbox" value="view"></td>
                                            <td><input name="substation_access[]" type="checkbox" value="create"></td>
                                            <td><input name="substation_access[]" type="checkbox" value="edit"></td>
                                            <td><input name="substation_access[]" type="checkbox" value="delete"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Sensor</td>
                                            <td><input name="sensor_access[]" type="checkbox" value="full"></td>
                                            <td><input name="sensor_access[]" type="checkbox" value="view"></td>
                                            <td><input name="sensor_access[]" type="checkbox" value="create"></td>
                                            <td><input name="sensor_access[]" type="checkbox" value="edit"></td>
                                            <td><input name="sensor_access[]" type="checkbox" value="delete"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Report Log</td>
                                            <td><input name="report_access[]" type="checkbox" value="full"></td>
                                            <td><input name="report_access[]" type="checkbox" value="view"></td>
                                            <td><input name="report_access[]" type="checkbox" value="create"></td>
                                            <td><input name="report_access[]" type="checkbox" value="edit"></td>
                                            <td><input name="report_access[]" type="checkbox" value="delete"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">User Management</td>
                                            <td><input name="user_management_access[]" type="checkbox" value="full"></td>
                                            <td><input name="user_management_access[]" type="checkbox" value="view"></td>
                                            <td><input name="user_management_access[]" type="checkbox" value="create"></td>
                                            <td><input name="user_management_access[]" type="checkbox" value="edit"></td>
                                            <td><input name="user_management_access[]" type="checkbox" value="delete"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Generate Button -->
                            <div class="d-flex justify-content-end mt-3">
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
                                    <th>User's Name</th>
                                    <th>User's Position</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td> {{ $i++}} </td>
                                        <td> {{ $user->user->name }} </td>
                                        <td> {{ $user->user->position }} </td>
                                        <td><span class="badge bg-success">Success</span></td>
                                        <td>
                                            <a href="{{ route('user_management.show',$user->id) }}" class="text-primary bi bi-eye"></a>
                                            <a href="{{ route('user_management.edit',$user->id) }}"class="text-success bi bi-pencil-square"></a>
                                            <form action="{{ route(  'user_management.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');"
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // auto fill form
        $(document).ready(function() {
            $('#user-select').change(function() {
                // Get selected option
                var selectedUser = $(this).find(':selected');

                // Autofill fields
                $('#user-email').val(selectedUser.data('email'));
                $('#user-id').val(selectedUser.data('id'));
                $('#user-role').val(selectedUser.data('role'));
            });
        });

        </script>
        
@endsection
