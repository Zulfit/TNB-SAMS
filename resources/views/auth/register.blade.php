<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Register - TNB-SAMS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .register-container {
            display: flex;
            height: 100vh;
        }

        .left-section {
            flex: 2;
            background-image: url('{{ asset('assets/img/sams-backgorund.avif') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="300" cy="700" r="120" fill="url(%23a)"/></svg>') no-repeat center center;
            background-size: cover;
            opacity: 0.3;
        }

        .top-left-logo {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 3;
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            opacity: 0.9;
            transition: opacity 0.3s ease;
        }

        .hero-content {
            text-align: center;
            color: white;
            z-index: 2;
            max-width: 500px;
            padding: 2rem;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            margin: 0 auto 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-size: 2rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .hero-logo:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #ffffff, #f0f8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .hero-features {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .feature-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            opacity: 1;
            transform: translateY(-3px);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.404);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .feature-text {
            font-size: 0.9rem;
            font-weight: 500;
            text-align: center;
        }

        .hero-cta {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 400;
            font-style: italic;
        }

        .right-section {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .register-form-container {
            width: 100%;
            max-width: 400px;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 3rem;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: #1a202c;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo img {
            width: 40px;
            height: 40px;
            margin-right: 0.5rem;
            border-radius: 8px;
        }

        .page-title {
            color: #374151;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 1rem;
            margin-bottom: 0;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            flex: 1;
            margin-bottom: 1.5rem;
        }

        .form-group.full-width {
            flex: none;
            width: 100%;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
        }

        .form-input.with-icon {
            padding-left: 3rem;
        }

        .form-select {
            width: 100%;
            padding: 0.875rem 3rem 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            appearance: none;
        }

        .form-select.with-icon {
            padding-left: 3rem;
        }

        .form-select:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-select.error {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 0.25rem;
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .strength-bar {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            margin: 0.5rem 0;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            width: 25%;
            background: #ef4444;
        }

        .strength-fair {
            width: 50%;
            background: #f59e0b;
        }

        .strength-good {
            width: 75%;
            background: #10b981;
        }

        .strength-strong {
            width: 100%;
            background: #059669;
        }

        .register-btn {
            width: 100%;
            background: linear-gradient(135deg, #011567 0%, #0020f0 100%);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .register-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .login-link {
            text-align: center;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .success-message {
            background: #f0fdf4;
            border: 2px solid #bbf7d0;
            color: #166534;
            padding: 0.875rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .success-message i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .register-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
                border-radius: 20px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .logo {
                font-size: 1.5rem;
            }

            .logo-icon {
                width: 45px;
                height: 45px;
                font-size: 1.25rem;
            }

            .page-title {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 1rem 0.5rem;
            }

            .register-card {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="left-section">
            <a href="#" class="top-left-logo">
                <img src="assets/img/TNBLogo_white.png" alt="TNB Logo">
            </a>
            <div class="hero-content">
                <div class="hero-logo">T</div>
                <h1 class="hero-title">TNB-SAMS</h1>
                <p class="hero-subtitle">Substation Asset Monitoring System</p>
                
                <div class="hero-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <div class="feature-text">Real-time</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-bell"></i>
                        </div>
                        <div class="feature-text">24/7 Alerts</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="feature-text">Efficient</div>
                    </div>
                </div>
                
                <p class="hero-cta">Monitor TNB substation assets with precision</p>
            </div>
        </div>
        <div class="right-section">
            <div class="register-form-container">
                <div class="logo-section">
                    <a href="/" class="logo">
                        <div
                            style="width: 40px; height: 40px; background: linear-gradient(45deg, #667eea, #764ba2); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 0.5rem;">
                            T</div>
                        TNB-SAMS
                    </a>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group full-width">
                        <label for="name" class="form-label">Full Name</label>
                        <div class="input-group">
                            <i class="bi bi-person input-icon"></i>
                            <input type="text" name="name"
                                class="form-input with-icon @error('name') error @enderror" id="name"
                                placeholder="Enter your full name" value="{{ old('name') }}" required>
                        </div>
                        @error('name')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="id_staff" class="form-label">Staff ID</label>
                        <div class="input-group">
                            <i class="bi bi-card-text input-icon"></i>
                            <input type="text" name="id_staff"
                                class="form-input with-icon @error('id_staff') error @enderror" id="id_staff"
                                placeholder="Enter staff ID" value="{{ old('id_staff') }}" required>
                        </div>
                        @error('id_staff')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" name="email"
                                class="form-input with-icon @error('email') error @enderror" id="email"
                                placeholder="Enter your email address" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="position" class="form-label">Position</label>
                        <div class="input-group">
                            <i class="bi bi-briefcase input-icon"></i>
                            <select name="position" class="form-select with-icon @error('position') error @enderror"
                                id="position" required>
                                <option value="">Select your position</option>
                                <option value="Manager" {{ old('position') == 'Manager' ? 'selected' : '' }}>Manager
                                </option>
                                <option value="Staff" {{ old('position') == 'Staff' ? 'selected' : '' }}>Staff
                                </option>
                                {{-- <option value="Supervisor" {{ old('position') == 'Supervisor' ? 'selected' : '' }}>
                                    Supervisor</option>
                                <option value="Team Lead" {{ old('position') == 'Team Lead' ? 'selected' : '' }}>Team
                                    Lead</option>
                                <option value="Senior Staff"
                                    {{ old('position') == 'Senior Staff' ? 'selected' : '' }}>Senior Staff</option> --}}
                            </select>
                        </div>
                        @error('position')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" name="password"
                                    class="form-input with-icon @error('password') error @enderror" id="password"
                                    placeholder="Create password" required>
                            </div>
                            @error('password')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <i class="bi bi-lock-fill input-icon"></i>
                                <input type="password" name="password_confirmation" class="form-input with-icon"
                                    id="password_confirmation" placeholder="Confirm password" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="register-btn">
                        Create Account
                    </button>
                </form>

                <div class="login-link">
                    Already have an account? <a href="/login">Sign in here</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
