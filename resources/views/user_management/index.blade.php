@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>User Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">User Management</a></li>
                    {{-- <li class="breadcrumb-item active"><a href="{{ route('sub.index') }}">Substation</a></li>
                    <li class="breadcrumb-item active">Error Details</li> --}}
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="container-fluid p-0">
                <!-- Upload Dataset Card -->
                @if (in_array('create', $global_permissions['user_management_access'] ?? []) ||
                        in_array('full', $global_permissions['user_management_access'] ?? []))
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>User Access Control</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('user_management.store') }}" method="POST">
                                @csrf

                                <!-- User Selection -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold">User's Name</label>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter user name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">User's Email</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Enter user email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="id_staff" class="form-label fw-semibold">User's ID</label>
                                        <input type="text" id="id_staff" name="id_staff"
                                            class="form-control @error('id_staff') is-invalid @enderror"
                                            placeholder="Enter user ID" value="{{ old('id_staff') }}">
                                        @if ($errors->has('id_staff'))
                                            <div class="invalid-feedback">{{ $errors->first('id_staff') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="department" class="form-label fw-semibold">User's Department</label>
                                        @php
                                            $dep_list = ['Distribution Network Division', 'Transmission Division'];
                                        @endphp
                                        <select id="department" name="department"
                                            class="form-control @error('department') is-invalid @enderror">
                                            <option value="">-- Select Department --</option>
                                            @foreach ($dep_list as $dep)
                                                <option value="{{ $dep }}"
                                                    {{ old('department') == $dep ? 'selected' : '' }}>
                                                    {{ $dep }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department'))
                                            <div class="invalid-feedback">{{ $errors->first('department') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        @php
                                            $positions = ['Manager', 'Staff'];
                                        @endphp
                                        <label for="position" class="form-label fw-semibold">User's Position</label>
                                        <select id="position" name="position"
                                            class="form-control @error('position') is-invalid @enderror">
                                            <option value="">-- Select Role --</option>
                                            @foreach ($positions as $position)
                                                <option value="{{ $position }}"
                                                    {{ old('position') == $position ? 'selected' : '' }}>
                                                    {{ $position }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('position'))
                                            <div class="invalid-feedback">{{ $errors->first('position') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Permission Table -->
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-start fw-bold">List Screen</th>
                                                <th>Full</th>
                                                <th>View</th>
                                                <th>Create</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $modules = [
                                                    'Dashboard',
                                                    'Analytics',
                                                    'Error Log',
                                                    'Dataset',
                                                    'Substation',
                                                    'Sensor',
                                                    'Report Log',
                                                    'User Management',
                                                ];
                                            @endphp

                                            @foreach ($modules as $module)
                                                @php $key = strtolower(str_replace(' ', '_', $module)) . '_access'; @endphp
                                                <tr>
                                                    <td class="text-start">{{ $module }}</td>
                                                    <td><input name="{{ $key }}[]" type="checkbox" value="full">
                                                    </td>
                                                    <td><input name="{{ $key }}[]" type="checkbox" value="view">
                                                    </td>
                                                    <td><input name="{{ $key }}[]" type="checkbox" value="create">
                                                    </td>
                                                    <td><input name="{{ $key }}[]" type="checkbox" value="edit">
                                                    </td>
                                                    <td><input name="{{ $key }}[]" type="checkbox" value="delete">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-shield-check me-2"></i>Assign Access
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

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
                                        @if ($user->user->position !== 'Admin')
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
                                        @endif
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
