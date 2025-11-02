@extends('front.layout.app')

@section('main')
    <section class="login-section d-flex align-items-center"
        style="min-height: 100vh; background: linear-gradient(135deg, #f0f4ff, #d9e4ff);">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <!-- Login Form -->
                <div class="col-lg-5 col-md-8">
                    <div class="card login-card p-4 p-md-5 shadow-lg rounded-4">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Forgot Password</h2>
                        </div>

                        <!-- Login Form -->
                        <form action="{{ route('account.processForgotPassword') }}" method="post">
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

                            <!-- Actions -->
                            <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                <button class="btn btn-outline-danger w-25 rounded-pill">Submit</button>

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
    </style>
@endsection