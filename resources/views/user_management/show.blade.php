@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>User Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('user_management.index') }}">User Management</a></li>
                    <li class="breadcrumb-item active">User Details</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="container mt-4">
                <!-- Upload Dataset Card -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>User Access Control</h5>
                    </div>
                
                    <div class="card-body p-4">
                        <form>
                            @csrf
                
                            <!-- Name Field (Full Width) -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">User’s Name</label>
                                <input type="text" class="form-control readonly-field" value="{{ $user->name }}" readonly>
                            </div>
                
                            <!-- Email, ID, Role in One Row -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">User’s Email</label>
                                    <input type="text" class="form-control readonly-field" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">User’s ID</label>
                                    <input type="text" class="form-control readonly-field" value="{{ $user->id_staff }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">User’s Role</label>
                                    <input type="text" class="form-control readonly-field" value="{{ $user->position }}" readonly>
                                </div>
                            </div>
                
                            <!-- Permissions Table -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered text-center align-middle">
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
                                                <td class="text-start text-capitalize">
                                                    {{ ucwords(str_replace(['_', 'access'], [' ', ''], $screen)) }}
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
                
                            <!-- Footer Buttons -->
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('user_management.edit', $user->id) }}" class="btn btn-primary px-4">
                                    <i class="bi bi-pencil-square me-2"></i>Edit
                                </a>
                            </div>
                        </form>
                    </div>
                </div>                              

                <!-- Dataset Table -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>User List</h5>
                        <span class="badge bg-secondary">
                            {{ isset($users) ? count($users) : 0 }}
                            {{ isset($users) ? Str::plural('user', count($users)) : 'users' }}
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th class="py-3">#</th>
                                    <th class="py-3">User's Name</th>
                                    <th class="py-3">User's Position</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if (isset($users) && count($users) > 0)
                                    @foreach ($users as $user)
                                        <tr>
                                            <td> {{ $loop->iteration }} </td>
                                            <td> {{ $user->user->name }} </td>
                                            <td> {{ $user->user->position }} </td>
                                            <td><span class="badge bg-success">Success</span></td>
                                            <td>
                                                @if (in_array('view', $global_permissions['user_management_access'] ?? []) ||
                                                        in_array('full', $global_permissions['user_management_access'] ?? []))
                                                    <a href="{{ route('user_management.show', $user->id) }}"
                                                        class="text-primary bi bi-eye me-2"></a>
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
                                @else
                                    <tr>
                                        <td colspan="12" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                                <h5 class="text-muted">No User Found</h5>
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
