@extends('front.layout.app')

@section('main')
    <section class="login-section d-flex align-items-center"
        style="min-height: 100vh; background: linear-gradient(135deg, #f0f4ff, #d9e4ff);">
        @include('front.message')
        <div class="container">
            <div class="row justify-content-center align-items-center">


                <!-- Login Form -->
                <div class="col-lg-5 col-md-8">
                    <div class="card login-card p-4 p-md-5 shadow-lg rounded-4">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Welcome Back</h2>
                            <p class="text-muted small">Login to continue your journey with <span
                                    class="fw-semibold">CareerVibe</span></p>
                        </div>


                        <!-- Login Form -->
                        <form action="{{ route('account.authenticate') }}" method="post">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address <span
                                        class="text-danger">*</span></label>
                                <div class="input-group custom-input">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input type="email" value="{{ old('email') }}" name="email" id="email"
                                        class="form-control shadow-sm @error('email') is-invalid @enderror"
                                        placeholder="example@example.com">
                                    @error('email')
                                        <p class="invalid-feedback d-block">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password <span
                                        class="text-danger">*</span></label>

                                <div class="input-group custom-input">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control shadow-sm"
                                        placeholder="Enter your password">
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                <button class="btn btn-login w-50 rounded-pill">Login</button>
                                <a href="{{route('account.forgotPassword')}}"
                                    class="small text-decoration-none text-danger fw-semibold">Forgot
                                    Password?</a>
                            </div>

                            <!-- Divider -->
                            <div class="text-center my-3 position-relative">
                                <hr>
                                <span
                                    class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">or
                                    continue with</span>
                            </div>

                            <!-- Social Login -->
                            <div class="d-flex justify-content-center gap-3 mt-3">

                                <!-- Google Button -->
                                <a href="{{route('auth.google')}}"
                                    class="btn btn-google shadow-sm rounded-pill px-4 d-flex align-items-center">
                                    <i class="fab fa-google me-2"></i> Google
                                </a>

                                <!-- Facebook Button -->
                                <a href="#" class="btn btn-facebook shadow-sm rounded-pill px-4 d-flex align-items-center">
                                    <i class="fab fa-facebook-f me-2"></i> Facebook
                                </a>

                            </div>

                            <!-- Register Redirect -->
                            <div class="text-center mt-4">
                                <p class="small mb-0">
                                    Don’t have an account?
                                    <a href="{{ route('account.registration') }}"
                                        class="register-link text-decoration-none">
                                        Register
                                    </a>
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

        .btn-outline-danger,
        .btn-outline-primary {
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover,
        .btn-outline-primary:hover {
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

        .btn-google {
            background: #fff;
            border: 1px solid blueviolet;
            color: #444;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-google:hover {
            background: #f8f9fa;
            box-shadow: 0 4px 12px rgba(66, 133, 244, 0.2);
        }

        .btn-google i {
            color: #4285F4;
            /* Google Blue for icon */
        }

        /* Facebook Button */
        .btn-facebook {
            background: #fff;
            border: 1px solid blueviolet;
            color: #444;
            font-weight: 500;
            transition: 0.3s;
        }


        .btn-facebook:hover {
            background: #f8f9fa;
            box-shadow: 0 4px 12px rgba(66, 133, 244, 0.2);
        }

        .btn-facebook i {
            color: #4285F4;
            /* Google Blue for icon */
        }

        /* Icons look cleaner */
        .btn i {
            font-size: 1rem;
        }

        .register-link {
            color: #198754
                /* Coral / Fresh Red-Orange */
                transition: all 0.3s ease-in-out;
        }

        .register-link:hover {
            color: #198754
                /* Slightly darker shade on hover */
                text-decoration: underline;
        }
    </style>
@endsection