@extends('front.layout.app')

@section('main')
    <section class="login-section d-flex align-items-center"
        style="min-height: 100vh; background: linear-gradient(135deg, #f0f4ff, #d9e4ff);">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <!-- Registration Form -->
                <div class="col-lg-5 col-md-8">
                    <div class="card login-card p-4 p-md-5 shadow-lg rounded-4">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Create Your Account</h2>
                            <p class="text-muted small">Join CareerVibe and take your next step</p>
                        </div>

                        <!-- Registration Form -->
                        <form id="registrationForm" name="registrationForm" enctype="multipart/form-data"
                            class="needs-validation">
                            @csrf
                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name <span
                                        class="text-danger">*</span></label>
                                <div class="input-group custom-input">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Enter your full name">
                                </div>
                                <p></p>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address <span
                                        class="text-danger">*</span></label>
                                <div class="input-group custom-input">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input type="text" name="email" id="email" class="form-control"
                                        placeholder="example@example.com">
                                </div>
                                <p></p>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group custom-input">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Enter password">
                                </div>
                                <p></p>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label fw-semibold">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group custom-input">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password_confirmation" id="confirm_password"
                                        class="form-control" placeholder="Re-enter password">
                                </div>
                                <p></p>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label fw-semibold">Phone Number <span
                                        class="text-danger">*</span></label>
                                <div class="input-group custom-input">
                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    <input type="number" name="contact" id="contact" class="form-control"
                                        placeholder="Enter Contact Number">
                                </div>
                                <p></p>
                            </div>

                            <div class="mb-3">
                                <div class="preview-container mb-3">
                                    <img id="previewImage" src="{{ asset('assets/images/avatar7.png') }}"
                                        class="rounded-circle shadow-sm border border-3 border-primary"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                                <label class="form-label fw-semibold">Upload Profile Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                    onchange="previewFile(event)">
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                <button class="btn btn-register w-100 rounded-pill">Register</button>
                            </div>

                            <!-- Login Redirect -->
                            <div class="text-center mt-4">
                                <p class="small">Already have an account?
                                    <a href="{{ route('account.login') }}" class="login-link text-decoration-none">Login</a>
                                </p>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        /* Card */
        .login-card {
            background: #ffffff;
            border-radius: 1rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* Inputs */
        .form-control {
            border-radius: 50px;
            padding: 0.65rem 1rem;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4e54c8;
            box-shadow: 0 0 8px rgba(78, 84, 200, 0.3);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            border: none;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3b3fc0, #6f73ff);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(78, 84, 200, 0.3);
        }

        .btn-outline-danger {
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Divider text */
        .position-relative hr {
            height: 1px;
            border: none;
            background: #dee2e6;
        }

        .position-relative span {
            font-size: 0.8rem;
        }

        /* Social buttons icons */
        .btn i {
            font-size: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .login-section {
                padding-top: 50px;
                padding-bottom: 50px;
            }
        }

        .login-card {
            margin-top: 150px;
            margin-bottom: 100px;
            /* adjust as needed */
        }

        .btn-register {
            border: 2px solid #198754;
            color: #198754;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: #198754;
            color: #fff;
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
        }

        .login-link {
            color: #0d6efd;

        }

        .login-link:hover {
            color: #0d6efd;

        }
    </style>
@endsection

@section('customJS')
    <script>
        $("#registrationForm").submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this); // Use FormData to handle files

            $.ajax({
                url: "{{ route('account.register') }}",
                type: 'POST',
                data: formData,
                contentType: false,   // Important for file upload
                processData: false,   // Important for file upload
                dataType: 'json',
                success: function (response) {
                    var error = response.errors;

                    if (response.status == false) {
                        if (error.name) {
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.name);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (error.email) {
                            $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.email);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (error.password) {
                            $('#password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.password);
                        } else {
                            $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (error.password_confirmation) {
                            $('#confirm_password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.password_confirmation);
                        } else {
                            $('#confirm_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (error.image) {
                            $('#image').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.image);
                        } else {
                            $('#image').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (error.contact) {
                            $('#contact').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.contact);
                        } else {
                            $('#contact').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    } else {
                        $('#name, #email, #password, #confirm_password, #image,#contact')
                            .removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        window.location.href = "{{ route('account.login') }}";
                    }
                }
            });
        });


        function previewFile(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('previewImage');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection