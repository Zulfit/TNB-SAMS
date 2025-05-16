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
                            @csrf
                            <!-- User's Name Dropdown -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s Name</label>
                                <input value="{{ $user->name }}" type="text" class="form-control w-75 readonly-field"
                                    readonly>
                            </div>

                            <!-- User’s Email (Auto-filled) -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s Email</label>
                                <input value="{{ $user->email }}" type="text" class="form-control w-75 readonly-field"
                                    readonly>
                            </div>

                            <!-- User’s ID (Auto-filled) -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s ID</label>
                                <input value="{{ $user->id_staff }}" type="text" class="form-control w-75 readonly-field"
                                    readonly>
                            </div>

                            <!-- User’s Role (Auto-filled) -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <label class="form-label w-25">User’s Role</label>
                                <input value="{{ $user->position }}" type="text" class="form-control w-75 readonly-field"
                                    readonly>
                            </div>


                            <!-- Permission Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-start">List Screen</th>
                                            <th>Full</th>
                                            <th>View</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $actions = ['full', 'view', 'create', 'edit', 'delete'];
                                            $screens = [
                                                'dashboard_access',
                                                'analytics_access',
                                                'error_log_access',
                                                'dataset_access',
                                                'substation_access',
                                                'sensor_access',
                                                'report_access',
                                                'user_management_access',
                                            ];
                                        @endphp

                                        @foreach ($screens as $screen)
                                            <tr>
                                                <td class="text-start text-capitalize">{{ str_replace('_', ' ', $screen) }}
                                                </td>
                                                @foreach ($actions as $action)
                                                    @php
                                                        $checked = in_array($action, $permissions[$screen] ?? []);
                                                        $name = "permissions[{$screen}][]";
                                                    @endphp
                                                    <td>
                                                        <input type="checkbox" name="{{ $name }}"
                                                            value="{{ $action }}" {{ $checked ? 'checked' : '' }}
                                                            disabled>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Generate Button -->
                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ route('user_management.index') }}" class="btn btn-secondary me-2">Back</a>
                                <a href="{{ route('user_management.edit', $user->id) }}" class="btn btn-primary px-4">Edit</a>
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
                                        <td> {{ $i++ }} </td>
                                        <td> {{ $user->user->name }} </td>
                                        <td> {{ $user->user->position }} </td>
                                        <td><span class="badge bg-success">Success</span></td>
                                        <td>
                                            @if (in_array('view', $global_permissions['user_management_access'] ?? []) ||
                                                    in_array('full', $global_permissions['user_management_access'] ?? []))
                                                <a href="{{ route('user_management.show', $user->id) }}"
                                                    class="text-primary bi bi-eye"></a>
                                            @endif

                                            @if (in_array('edit', $global_permissions['user_management_access'] ?? []) ||
                                                    in_array('full', $global_permissions['user_management_access'] ?? []))
                                                <a
                                                    href="{{ route('user_management.edit', $user->id) }}"class="text-success bi bi-pencil-square"></a>
                                            @endif

                                            @if (in_array('delete', $global_permissions['user_management_access'] ?? []) ||
                                                    in_array('full', $global_permissions['user_management_access'] ?? []))
                                                <form action="{{ route('user_management.destroy', $user->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');"
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection
