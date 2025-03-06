{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- ID Staff -->
        <div class="mt-4">
            <x-input-label for="id_staff" :value="__('ID Staff')" />
            <x-text-input id="id_staff" class="block mt-1 w-full" type="text" name="id_staff" :value="old('id_staff')" required autocomplete="id_taff" />
            <x-input-error :messages="$errors->get('id_staff')" class="mt-2" />
        </div>

        <!-- Position -->
        <div class="mt-4">
            <x-input-label for="position" :value="__('Position')" />
            <select id="position" name="position" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value=""></option>
                <option value="Manager" {{ old('position') == 'Manager' ? 'selected' : '' }}>Manager</option>
                <option value="Staff" {{ old('position') == 'Staff' ? 'selected' : '' }}>Staff</option>
            </select>
            <x-input-error :messages="$errors->get('position')" class="mt-2" />
        </div>
        

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - TNB-SAMS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-7 d-flex flex-column align-items-center justify-content-center">
                            
                            <div class="card shadow-lg border-0 rounded-4 p-4">
                                <div class="card-body">
    
                                    <!-- Company Logo -->
                                    <div class="d-flex justify-content-center py-3">
                                        <a href="/" class="logo d-flex align-items-center w-auto">
                                            <img src="{{ asset('assets/img/logo.png') }}" alt="TNB-SAMS" style="height: 50px;">
                                            <span class="fw-bold text-dark ms-2 fs-5">TNB-SAMS</span>
                                        </a>
                                    </div>
    
                                    <!-- Laravel Form -->
                                    <form class="row g-3 needs-validation" method="POST" action="{{ route('register') }}" novalidate>
                                        @csrf
    
                                        <div class="col-12">
                                            <label for="name" class="form-label">Full Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                                                <div class="invalid-feedback">Please enter your full name.</div>
                                            </div>
                                        </div>
    
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                                <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                                                <div class="invalid-feedback">Enter a valid email.</div>
                                            </div>
                                        </div>
    
                                        <div class="col-12">
                                            <label for="staff_id" class="form-label">Staff ID</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-card-checklist"></i></span>
                                                <input type="text" name="staff_id" class="form-control" id="staff_id" value="{{ old('staff_id') }}" required>
                                                <div class="invalid-feedback">Please enter your Staff ID.</div>
                                            </div>
                                        </div>
    
                                        <div class="col-12">
                                            <label for="position" class="form-label">Position</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                                <input type="text" name="position" class="form-control" id="position" value="{{ old('position') }}" required>
                                                <div class="invalid-feedback">Enter your position in the company.</div>
                                            </div>
                                        </div>
    
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                                <input type="password" name="password" class="form-control" id="password" required>
                                                <div class="invalid-feedback">Password is required.</div>
                                            </div>
                                        </div>
    
                                        <div class="col-12">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                                                <div class="invalid-feedback">Passwords must match.</div>
                                            </div>
                                        </div>
    
                                        <div class="col-12 mt-3">
                                            <button class="btn btn-primary w-100 fw-bold" type="submit">Register</button>
                                        </div>
    
                                        <div class="col-12 text-center">
                                            <p class="mt-2 small">
                                                Already have an account? 
                                                <a href="{{ route('login') }}" class="text-decoration-none text-primary">Login here</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
    
                            <div class="text-center mt-3">
                                <small class="text-muted">Designed by <a href="https://bootstrapmade.com/" class="text-primary">Zulfitri Hakeem</a></small>
                            </div>
    
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    
    <!-- Optional: Custom CSS for Better Spacing & Look -->
    <style>
        .card {
            max-width: 450px;
            border-radius: 12px;
        }
    
        .input-group-text {
            background-color: #f8f9fa;
        }
    
        .btn-primary {
            background-color: #004aad;
            border: none;
        }
    
        .btn-primary:hover {
            background-color: #003080;
        }
    </style>
    

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
