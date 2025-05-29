@extends('layouts.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-0">Profile Settings</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile Settings</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section dashboard">
            <div class="container-fluid p-0">
                <div class="row g-4">
                    <!-- Profile Information Card -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0"><i class="bi bi-person-circle me-2 text-primary"></i>Profile Information
                                </h5>
                                <small class="text-muted">Update your account profile information and email address</small>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <!-- Profile Picture Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark">Profile Picture</label>
                                            <div class="d-flex align-items-center gap-4">
                                                <div class="position-relative">
                                                    <div class="avatar-preview" id="avatarPreview"
                                                        style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 3px solid #e9ecef; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;" data-profile-image>
                                                        @if (Auth::user()->profile_picture)
                                                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                                                alt="Profile"
                                                                style="width: 100%; height: 100%; object-fit: cover;">
                                                        @else
                                                            <i class="bi bi-person-fill text-white"
                                                                style="font-size: 2.5rem;"></i>
                                                        @endif
                                                    </div>
                                                    <button type="button" id="cameraBtn"
                                                        class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle p-2"
                                                        style="width: 32px; height: 32px;">
                                                        <i class="bi bi-camera-fill" style="font-size: 0.75rem;"></i>
                                                    </button>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="file" id="profilePicture" name="profile_picture"
                                                        accept="image/*" class="d-none">
                                                    <div class="d-flex flex-column gap-2">
                                                        <button type="button" id="uploadBtn"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-upload me-2"></i>Upload New Photo
                                                        </button>
                                                        @if (Auth::user()->profile_picture)
                                                            <button type="button" id="removePhotoBtn"
                                                                class="btn btn-outline-danger btn-sm">
                                                                <i class="bi bi-trash me-2"></i>Remove Photo
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted">Recommended: Square image, at least 200x200px.
                                                        Max size: 2MB</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Personal Information -->
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label fw-semibold text-dark">Full Name <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-person text-muted"></i>
                                                </span>
                                                <input type="text" id="name" name="name"
                                                    class="form-control border-start-0 ps-0"
                                                    value="{{ old('name', Auth::user()->name) }}" required
                                                    placeholder="Enter your full name">
                                                <div class="invalid-feedback">Please provide your full name.</div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-semibold text-dark">Email Address
                                                <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-envelope text-muted"></i>
                                                </span>
                                                <input type="email" id="email" name="email"
                                                    class="form-control border-start-0 ps-0"
                                                    value="{{ old('email', Auth::user()->email) }}" required
                                                    placeholder="Enter your email address">
                                                <div class="invalid-feedback">Please provide a valid email address.</div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label fw-semibold text-dark">Phone
                                                Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-telephone text-muted"></i>
                                                </span>
                                                <input type="tel" id="phone" name="phone"
                                                    class="form-control border-start-0 ps-0"
                                                    value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                                    placeholder="Enter your phone number">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="department"
                                                class="form-label fw-semibold text-dark">Department</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-building text-muted"></i>
                                                </span>
                                                <input type="text" id="department" name="department"
                                                    class="form-control border-start-0 ps-0"
                                                    value="{{ old('department', Auth::user()->department ?? '') }}"
                                                    placeholder="Enter your department">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                        <small class="text-muted"><span class="text-danger">*</span> Required
                                            fields</small>
                                        <div class="d-flex gap-2">
                                            <button type="button" id="resetBtn" class="btn btn-outline-secondary">
                                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle me-2"></i>Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card shadow-sm border-0 rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0"><i class="bi bi-gear me-2 text-primary"></i>Account Management</h5>
                                <small class="text-muted">Manage your password and account security</small>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-warning bg-opacity-10 p-2 rounded-circle">
                                                    <i class="bi bi-lock text-warning fs-5"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Change Password</h6>
                                                <small class="text-muted">Update your account password</small>
                                            </div>
                                            <button type="button" id="togglePasswordBtn"
                                                class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-chevron-down" id="passwordChevron"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="d-flex align-items-center p-3 border rounded-3 bg-light border-danger bg-danger bg-opacity-10">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-danger bg-opacity-10 p-2 rounded-circle">
                                                    <i class="bi bi-exclamation-triangle text-danger fs-5"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Delete Account</h6>
                                                <small class="text-muted">Permanently delete your account</small>
                                            </div>
                                            <button type="button" id="toggleDeleteBtn"
                                                class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-chevron-down" id="deleteChevron"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Form (Hidden by default) -->
                        <div class="card shadow-sm border-0 rounded-3 mb-4 d-none" id="passwordCard">
                            <div class="card-header bg-warning bg-opacity-10 py-3 border-bottom border-warning">
                                <h5 class="mb-0 text-warning"><i class="bi bi-lock me-2"></i>Change Password</h5>
                                <small class="text-muted">Ensure your account is using a long, random password to stay
                                    secure</small>
                            </div>
                            <div class="card-body p-4">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>

                        <!-- Delete Account Form (Hidden by default) -->
                        <div class="card shadow-sm border-0 rounded-3 border-danger d-none" id="deleteCard">
                            <div class="card-header bg-danger bg-opacity-10 py-3 border-bottom border-danger">
                                <h5 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Delete Account
                                </h5>
                                <small class="text-muted">Once your account is deleted, all of its resources and data will
                                    be permanently deleted</small>
                            </div>
                            <div class="card-body p-4">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>

                    <!-- Profile Summary Sidebar -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Account Overview
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <div class="avatar-circle mx-auto mb-3"
                                        style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 3px solid #e9ecef;">
                                        @if (Auth::user()->profile_picture)
                                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                                alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-person-fill text-white" style="font-size: 2rem;"></i>
                                        @endif
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ Auth::user()->name }}</h6>
                                    <span
                                        class="badge bg-primary rounded-pill px-3 py-2">{{ Auth::user()->position ?? 'User' }}</span>
                                </div>

                                <div class="row g-3 text-center mb-4">
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <i class="bi bi-calendar-check text-primary fs-4"></i>
                                            <div class="mt-2">
                                                <small class="text-muted d-block">Member Since</small>
                                                <strong>{{ Auth::user()->created_at->format('M Y') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <i class="bi bi-clock-history text-success fs-4"></i>
                                            <div class="mt-2">
                                                <small class="text-muted d-block">Last Active</small>
                                                <strong>{{ Auth::user()->updated_at->diffForHumans() }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span class="text-muted small">Email Verified</span>
                                        @if (Auth::user()->email_verified_at)
                                            <span class="badge bg-success rounded-pill">
                                                <i class="bi bi-check-circle me-1"></i>Verified
                                            </span>
                                        @else
                                            <span class="badge bg-warning rounded-pill">
                                                <i class="bi bi-exclamation-circle me-1"></i>Pending
                                            </span>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span class="text-muted small">Account Status</span>
                                        <span class="badge bg-success rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i>Active
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span class="text-muted small">Profile Completion</span>
                                        <span class="badge bg-info rounded-pill">85%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Card -->
                        <div class="card shadow-sm border-0 rounded-3 mt-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0"><i class="bi bi-lightning me-2 text-primary"></i>Quick Actions</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-house me-2"></i>Back to Dashboard
                                    </a>
                                    @if (Auth::user()->position != 'Staff')
                                        <a href="{{ route('error-log.index') }}"
                                            class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-exclamation-triangle me-2"></i>View Error Logs
                                        </a>
                                    @endif
                                    <button type="button" id="printBtn" class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-printer me-2"></i>Print Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .form-control.border-start-0:focus {
            border-left: 1px solid #86b7fe;
        }

        .card {
            transition: all 0.3s ease;
        }

        .avatar-preview {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .avatar-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .btn {
            transition: all 0.2s ease;
        }

        .form-control,
        .form-select {
            transition: all 0.2s ease;
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #adb5bd;
        }

        @media print {
            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }

            .btn,
            .d-grid,
            #passwordCard,
            #deleteCard {
                display: none !important;
            }
        }

        .is-valid {
            border-color: #198754 !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .was-validated .form-control:valid {
            border-color: #198754;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.8-.77-.8-.77-.8.77.8.77zm1.48-4.97L6.06 4.02 5.28 4.8l-2.3-2.3-.8.78 3.1 3.1L8 3.67l-.77-.77-2.31 2.31-1.14-1.14z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profile picture upload functionality
            const profilePictureInput = document.getElementById('profilePicture');
            const cameraBtn = document.getElementById('cameraBtn');
            const uploadBtn = document.getElementById('uploadBtn');
            const removePhotoBtn = document.getElementById('removePhotoBtn');
            const avatarPreview = document.getElementById('avatarPreview');

            // Trigger file input when camera button or upload button is clicked
            if (cameraBtn) {
                cameraBtn.addEventListener('click', function() {
                    profilePictureInput.click();
                });
            }

            if (uploadBtn) {
                uploadBtn.addEventListener('click', function() {
                    profilePictureInput.click();
                });
            }

            // Handle file selection and preview
            if (profilePictureInput) {
                profilePictureInput.addEventListener('change', function() {
                    previewImage(this);
                });
            }

            // Remove profile picture
            if (removePhotoBtn) {
                removePhotoBtn.addEventListener('click', function() {
                    removeProfilePicture();
                });
            }

            // Form reset functionality
            const resetBtn = document.getElementById('resetBtn');
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    resetForm();
                });
            }

            // Toggle password form
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            if (togglePasswordBtn) {
                togglePasswordBtn.addEventListener('click', function() {
                    togglePasswordForm();
                });
            }

            // Toggle delete form
            const toggleDeleteBtn = document.getElementById('toggleDeleteBtn');
            if (toggleDeleteBtn) {
                toggleDeleteBtn.addEventListener('click', function() {
                    toggleDeleteForm();
                });
            }

            // Print functionality
            const printBtn = document.getElementById('printBtn');
            if (printBtn) {
                printBtn.addEventListener('click', function() {
                    window.print();
                });
            }
        });

        // Image preview function
        // Updated image preview function
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update the form's avatar preview
                    const avatarPreview = document.getElementById('avatarPreview');
                    if (avatarPreview) {
                        avatarPreview.innerHTML = '<img src="' + e.target.result +
                            '" alt="Profile Preview" style="width: 100%; height: 100%; object-fit: cover;">';
                    }

                    // Update the sidebar avatar preview
                    const sidebarAvatar = document.querySelector('.avatar-circle');
                    if (sidebarAvatar) {
                        sidebarAvatar.innerHTML = '<img src="' + e.target.result +
                            '" alt="Profile Preview" style="width: 100%; height: 100%; object-fit: cover;">';
                    }

                    // Update header profile image (you'll need to adjust the selector based on your header structure)
                    const headerProfileImg = document.querySelector('.header-profile-img'); // Adjust this selector
                    if (headerProfileImg) {
                        if (headerProfileImg.tagName === 'IMG') {
                            headerProfileImg.src = e.target.result;
                        } else {
                            headerProfileImg.innerHTML = '<img src="' + e.target.result +
                                '" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">';
                        }
                    }

                    // Alternative: Update all profile images on the page
                    const allProfileImages = document.querySelectorAll('[data-profile-image]');
                    allProfileImages.forEach(img => {
                        if (img.tagName === 'IMG') {
                            img.src = e.target.result;
                        } else {
                            img.innerHTML = '<img src="' + e.target.result +
                                '" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">';
                        }
                    });
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Remove profile picture function
        function removeProfilePicture() {
            if (confirm('Are you sure you want to remove your profile picture?')) {
                const avatarPreview = document.getElementById('avatarPreview');
                avatarPreview.innerHTML = '<i class="bi bi-person-fill text-white" style="font-size: 2.5rem;"></i>';

                // Reset file input
                const profilePictureInput = document.getElementById('profilePicture');
                profilePictureInput.value = '';

                // You might want to add a hidden input to track picture removal
                // or make an AJAX call to remove the picture from server
            }
        }

        // Reset form function
        function resetForm() {
            if (confirm('Are you sure you want to reset all changes?')) {
                document.querySelector('form').reset();
                // Reset avatar preview to original state
                location.reload();
            }
        }

        // Toggle password form
        function togglePasswordForm() {
            const passwordCard = document.getElementById('passwordCard');
            const passwordChevron = document.getElementById('passwordChevron');

            if (passwordCard.classList.contains('d-none')) {
                passwordCard.classList.remove('d-none');
                passwordChevron.classList.remove('bi-chevron-down');
                passwordChevron.classList.add('bi-chevron-up');
            } else {
                passwordCard.classList.add('d-none');
                passwordChevron.classList.remove('bi-chevron-up');
                passwordChevron.classList.add('bi-chevron-down');
            }
        }

        // Toggle delete form
        function toggleDeleteForm() {
            const deleteCard = document.getElementById('deleteCard');
            const deleteChevron = document.getElementById('deleteChevron');

            if (deleteCard.classList.contains('d-none')) {
                deleteCard.classList.remove('d-none');
                deleteChevron.classList.remove('bi-chevron-down');
                deleteChevron.classList.add('bi-chevron-up');
            } else {
                deleteCard.classList.add('d-none');
                deleteChevron.classList.remove('bi-chevron-up');
                deleteChevron.classList.add('bi-chevron-down');
            }
        }
    </script>
@endsection
