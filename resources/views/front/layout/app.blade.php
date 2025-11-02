<!DOCTYPE html>
<html class="no-js" lang="en_AU" />

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CareerVibe | Find Best Jobs</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="pinterest" content="nopin" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" />

    <!-- ✅ Font Awesome (for icons like edit/delete/view) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- ✅ Optional: Bootstrap (if not already included) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}" />
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo2.jpg') }}" type="image/png" />
</head>

<body data-instant-intensity="mousedown">

    <header>
        <nav class="navbar navbar-expand-lg custom-navbar fixed-top">
            <div class="container-fluid"> <!-- Changed from container to container-fluid -->

                <!-- Brand -->
                <a href="{{route('home')}}" class="navbar-brand d-flex align-items-center fw-bold fs-4">

                    <i class="bi bi-lightning-charge-fill me-2 text-gradient fs-2"></i>
                    Career <span class="text-success">&nbsp;Vibe</span>
                </a>

                <!-- Toggler -->
                <button class="navbar-toggler border-0 shadow-sm" type="button" data-bs-toggle="collapse"
                    data-bs-target="#uniqueNavbar" aria-controls="uniqueNavbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="bi bi-list fs-2 text-primary"></i>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="uniqueNavbar">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center">
                        <li class="nav-item mx-2">
                            <a class="nav-link fw-semibold {{ request()->routeIs('home') ? 'active' : '' }}"
                                href="{{route('home')}}">Home</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link fw-semibold {{ request()->routeIs('job') ? 'active' : '' }}"
                                href="{{route('job')}}">Find Jobs</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link fw-semibold" href="{{route('home')}}#popular-categories">Popular
                                Category</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link fw-semibold" href="{{route('home')}}#featured-jobs">Featured Job</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link fw-semibold" href="{{route('home')}}#latest-jobs">Latest Job</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link fw-semibold" href="{{route('home')}}#services">Services</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link fw-semibold" href="{{route('home')}}#contact">Contact</a>
                        </li>
                    </ul>

                    <!-- Right Buttons -->
                    <div class="d-flex align-items-center ms-lg-4 gap-2">
                        @if(!Auth::check())
                            {{-- ✅ Guest User --}}
                            <a class="btn btn-login rounded-pill px-4" href="{{route('account.login')}}">Login</a>
                            <a class="btn btn-register rounded-pill px-4"
                                href="{{route('account.registration')}}">Register</a>
                        @else
                            @php
                                $role = Auth::user()->role;
                            @endphp

                            @if($role == 'user')
                                {{-- ✅ Show Account button only for normal users --}}
                                <a class="btn btn-role rounded-pill px-4" href="{{route('account.profile')}}">Account</a>

                                {{-- ✅ Post a Job button (only visible if logged in) --}}
                                <a class="btn btn-outline-danger rounded-pill px-4" href="{{route('account.createJob')}}">
                                    Post a Job
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>


    @yield('main')
    <div class="modal fade" id="updateProfileImage" tabindex="-1" aria-labelledby="updateProfileImageLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Header -->
                <div class="modal-header bg-gradient text-white border-0 py-3"
                    style="background: linear-gradient(135deg, #4e73df, #224abe);">
                    <h5 class="modal-title fw-bold" id="updateProfileImageLabel">
                        <i class="fa-solid fa-camera me-2"></i> Change Profile Picture
                    </h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body bg-light p-4">
                    <form id="profileImage" name="image" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4 text-center">
                            <div class="preview-container mb-3">
                                <img id="previewImage" src="{{ asset('assets/images/avatar7.png') }}"
                                    class="rounded-circle shadow-sm border border-3 border-primary"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                            <label class="form-label fw-semibold">Upload New Profile Image</label>
                            <input type="file" class="form-control form-control-lg rounded-pill" id="image" name="image"
                                accept="image/*" onchange="previewFile(event)">
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-warning px-4 rounded-pill shadow-sm">
                                <i class="fa-solid fa-upload me-1"></i> Update
                            </button>
                            <button type="button" class="btn btn-danger px-4 rounded-pill shadow-sm"
                                data-bs-dismiss="modal">
                                <i class="fa-solid fa-xmark me-1"></i> Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-section text-white position-relative">
        <div class="container">
            <div class="row g-5">
                <!-- Brand & Description -->
                <div class="col-md-4 text-center text-md-start">
                    <h3 class="fw-bold mb-3 brand-logo">
                        <i class="bi bi-lightning-charge-fill text-primary me-2"></i>
                        Career<span class="text-success">&nbspVibe</span>
                    </h3>
                    <p class="text-white-50">
                        Empowering job seekers and employers by creating opportunities that spark growth.
                        Discover your vibe, build your career.
                    </p>
                    <!-- Social Icons -->
                    <ul class="example-2 mt-4 d-flex justify-content-center justify-content-md-start gap-3">
                        <li class="icon-content">
                            <a data-social="instagram" aria-label="Instagram"
                                href="https://www.instagram.com/bamania_mohit/" target="_blank">
                                <div class="filled"></div>
                                <svg xml:space="preserve" viewBox="0 0 16 16" class="bi bi-instagram"
                                    fill="currentColor" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor"
                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334">
                                    </path>
                                </svg>
                            </a>
                        </li>

                        <li class="icon-content">
                            <a data-social="facebook" aria-label="Facebook"
                                href="https://www.facebook.com/mohit.bamania.90/" target="_blank">
                                <div class="filled"></div>
                                <svg viewBox="0 0 16 16" class="bi bi-facebook" fill="currentColor" height="20"
                                    width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.94 6.49H10.5V4.1H8.94c-1.4 0-2.26.86-2.26 2.2v1.21H5V9.9h1.68v4.05H8.4V9.9h1.6l.25-2.2H8.4V6.69c0-.15.04-.2.2-.2z" />
                                </svg>
                            </a>
                        </li>

                        <li class="icon-content">
                            <a data-social="linkedin" aria-label="LinkedIn"
                                href="https://www.linkedin.com/in/mohit-bamania-222a2b261/" target="_blank">
                                <div class="filled"></div>
                                <svg xml:space="preserve" viewBox="0 0 16 16" class="bi bi-linkedin" fill="currentColor"
                                    height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor"
                                        d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z">
                                    </path>
                                </svg>
                            </a>
                        </li>
                    </ul>

                </div>

                <!-- Quick Links -->
                <div class="col-md-4 text-center text-md-start">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="footer-link"><i class="bi bi-chevron-right"></i>
                                Home</a></li>
                        <li><a href="{{ route('job') }}" class="footer-link"><i class="bi bi-chevron-right"></i> Find
                                Jobs</a></li>
                        <li><a href="{{ route('account.createJob') }}" class="footer-link"><i
                                    class="bi bi-chevron-right"></i> Post a Job</a></li>
                        <li><a href="{{ route('privacy.policy') }}" class="footer-link"><i
                                    class="bi bi-chevron-right"></i> Privacy & Policy</a></li>
                        <li><a href="{{ route('terms.conditions') }}" class="footer-link"><i
                                    class="bi bi-chevron-right"></i> Terms & Condition</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4 text-center text-md-start">
                    <h5 class="fw-bold mb-3">Contact Us</h5>
                    <p class="location mb-2"><i class="fa fa-map-marker-alt me-2 text-warning"></i>
                        <a href="https://www.google.com/maps/place/Charan+Mata+Mandir+.Gandhi+Park/@21.65069,69.6327919,3a,90y,53.6h,95.35t/data=!3m7!1e1!3m5!1swKz_0ul-0slo6wU3wqqLSg!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D-5.352206932533917%26panoid%3DwKz_0ul-0slo6wU3wqqLSg%26yaw%3D53.59922952101595!7i13312!8i6656!4m7!3m6!1s0x395634fcc7eb7dd7:0x1c5c8348c7df9fd1!8m2!3d21.650845!4d69.6325443!10e5!16s%2Fg%2F11gd67ky7h!5m1!1e4?entry=ttu&g_ep=EgoyMDI1MDgyNS4wIKXMDSoASAFQAw%3D%3D"
                            target="_blank" class="text-decoration-none text-warning fw-semibold">
                            "Shree Kankai Krupa" Rokadiya Hanuman Road Prashant
                            Pan Gali opp. Charan Aie
                            Mandir Khapat Porbandar, India"
                        </a>
                    </p>
                    <p class="text-white-50 mb-2"><i class="fa fa-envelope me-2 text-warning"></i>
                        <a href="mailto:bamaniamohit2@gmail.com" class="mail"> bamaniamohit2@gmail.com </a>
                    </p>
                    <p class="text-white-50 mb-0"><i class="fa fa-phone me-2 text-warning"></i><a href="tel:9408488791"
                            class="phone">
                            +91 9408488791</a> </p>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <!-- Copyright -->
            <div class="text-center small text-white-50">
                &copy; <span id="year"></span> Career Vibe. All Rights Reserved.
            </div>
        </div>
    </footer>
    <style>
        .navbar-brand {
            color: #0d6efd !important;
            transform: scale(1.05);
            transition: 0.3s ease;
        }

        /* Active link style */
        .nav-link.active {
            color: #0d6efd !important;
            position: relative;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #0d6efd;
            border-radius: 2px;
        }

        /* Navbar link hover */
        .nav-link {
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #0d6efd !important;
        }

        /* Buttons */
        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }


        footer {
            border-top: 2px solid #198754;
            /* subtle green accent */
        }

        footer h4 {
            letter-spacing: 1px;
        }

        footer p {
            margin: 0;
        }

        .modal-content {
            backdrop-filter: blur(10px);
        }

        .preview-container {
            position: relative;
            display: inline-block;
        }

        .preview-container::after {
            content: "\f030";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #4e73df;
            color: white;
            border-radius: 50%;
            padding: 6px;
            font-size: 14px;
        }


        .btn-close {
            filter: invert(1) grayscale(100%) brightness(40%);
        }

        .text-gradient {
            background: linear-gradient(90deg, #4e54c8, #8f94fb);
            -webkit-background-clip: text;
            color: transparent;
        }

        /* Footer links hover effect */
        .footer-link {
            color: #ffffffb0;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: #8f94fb;
            text-decoration: underline;
        }

        /* Social icons */
        .social-icon {
            font-size: 1.2rem;
            display: inline-block;
            transition: transform 0.3s, color 0.3s;
        }

        .social-icon:hover {
            color: #8f94fb;
            transform: translateY(-3px);
        }

        /* Footer background effect */
        footer {
            background: linear-gradient(to right, #1b1b1b, #222222);
        }

        .navbar-transparent {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            transition: all 0.4s ease;
        }

        /* Shrink navbar on scroll */
        .navbar-transparent.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Menu link hover */
        .navbar-nav .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            left: 0;
            bottom: -5px;
            background-color: #007bff;
            transition: width 0.3s;
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        /* Button hover effect */
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .toast-container {
            z-index: 2000;
        }

        .custom-toast {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            animation: slideInRight 0.5s ease forwards;
            min-width: 280px;
            font-size: 0.95rem;
        }

        .custom-toast .toast-body {
            font-weight: 500;
        }

        /* ✅ Color Variants */
        .success-toast {
            background: linear-gradient(135deg, #28a745, #218838);
            color: #fff;
        }

        .error-toast {
            background: linear-gradient(135deg, #dc3545, #b52d3a);
            color: #fff;
        }

        .info-toast {
            background: linear-gradient(135deg, #0dcaf0, #0a9cbf);
            color: #fff;
        }

        .warning-toast {
            background: linear-gradient(135deg, #ffc107, #d39e00);
            color: #212529;
        }

        .custom-toast .btn-close {
            filter: brightness(0) invert(1);
            /* makes close button white */
        }

        /* for warning, keep dark close */
        .warning-toast .btn-close {
            filter: none;
        }

        .text {
            text-decoration: none;
        }

        /* Animation */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .custom-navbar {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        /* Brand Gradient Icon */
        .text-gradient {
            background: linear-gradient(45deg, #ff6a00, #ee0979);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Nav links */
        .nav-link {
            color: #333 !important;
            transition: 0.3s ease;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #0d6efd !important;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            left: 0;
            bottom: -3px;
            background: #0d6efd;
            transition: 0.3s;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        /* Buttons */
        /* Login Button */
        .btn-login {
            border: 2px solid #0d6efd;
            color: #0d6efd;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #0d6efd;
            color: #fff;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        /* Register Button */
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

        .btn-role {
            border: 2px solid #0d6efd;
            color: #0d6efd;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-role:hover {
            background: #0d6efd;
            color: #fff;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .btn-post {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-post:hover {
            background: linear-gradient(135deg, #5a0eb2, #1f5cd1);
            box-shadow: 0 4px 15px rgba(101, 72, 255, 0.4);
            transform: translateY(-2px);
        }

        .footer-section {
            background: linear-gradient(135deg, #0d1117, #161b22);
            padding: 60px 0 20px;
            border-top: 3px solid #2575fc;
        }

        .brand-logo {
            font-size: 1.6rem;
        }

        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: #fff;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .social-icon:hover {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            transform: translateY(-3px);
            color: #fff;
            box-shadow: 0 0 10px rgba(101, 72, 255, 0.6);
        }

        .footer-link {
            display: inline-block;
            color: #bbb;
            text-decoration: none;
            margin-bottom: 8px;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .footer-link:hover {
            color: #fff;
            transform: translateX(5px);
        }

        .mail {
            color: greenyellow;
        }

        .mail:hover {

            color: greenyellow
        }

        .phone {
            color: greenyellow;
        }

        .phone:hover {

            color: greenyellow
        }

        .location {
            color: greenyellow
        }

        .custom-navbar .navbar-nav .nav-link {
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
        }

        /* Apply Poppins font to navbar */
        .custom-navbar {
            font-family: 'Poppins', sans-serif;
        }

        /* Nav link style */
        .custom-navbar .navbar-nav .nav-link {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 15px;
            color: #333;
            position: relative;
            transition: all 0.3s ease;
            padding: 0.5rem 0.8rem;
        }

        /* HTML: <div class="loader"></div> */
        .loader {
            --d: 22px;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            color: #25b09b;
            box-shadow:
                calc(1*var(--d)) calc(0*var(--d)) 0 0,
                calc(0.707*var(--d)) calc(0.707*var(--d)) 0 1px,
                calc(0*var(--d)) calc(1*var(--d)) 0 2px,
                calc(-0.707*var(--d)) calc(0.707*var(--d)) 0 3px,
                calc(-1*var(--d)) calc(0*var(--d)) 0 4px,
                calc(-0.707*var(--d)) calc(-0.707*var(--d))0 5px,
                calc(0*var(--d)) calc(-1*var(--d)) 0 6px;
            animation: l27 1s infinite steps(8);

            /* initially hidden */
            display: none;
            position: fixed;
            inset: 0;
            margin: auto;
            z-index: 9999;
        }

        /* From Uiverse.io by Zameerahmad01 */
        ul {
            list-style: none;
        }

        .example-2 {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            row-gap: 0.5rem;
        }

        .example-2 .icon-content {
            margin: 0 10px;
            position: relative;
        }

        .example-2 .icon-content .tooltip {
            position: absolute;
            top: 20px;
            left: 40%;
            transform: translateX(50%);
            color: #fff;
            padding: 6px 10px;
            border-radius: 5px;
            opacity: 0;
            visibility: hidden;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .example-2 .icon-content:hover .tooltip {
            opacity: 1;
            visibility: visible;
            top: 5px;
        }

        .example-2 .icon-content a {
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            color: #4d4d4d;
            background-color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .example-2 .icon-content a:hover {
            box-shadow: 3px 2px 45px 0px rgb(0 0 0 / 12%);
        }

        .example-2 .icon-content a svg {
            position: relative;
            z-index: 1;
            width: 30px;
            height: 30px;
        }

        .example-2 .icon-content a:hover {
            color: white;
        }

        .example-2 .icon-content a .filled {
            position: absolute;
            top: auto;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0;
            background-color: #000;
            transition: all 0.3s ease-in-out;
        }

        .example-2 .icon-content a:hover .filled {
            height: 100%;
        }

        .example-2 .icon-content a[data-social="linkedin"] .filled,
        .example-2 .icon-content a[data-social="linkedin"]~.tooltip {
            background-color: #0274b3;
        }

        .example-2 .icon-content a[data-social="github"] .filled,
        .example-2 .icon-content a[data-social="github"]~.tooltip {
            background-color: #24262a;
        }

        .example-2 .icon-content a[data-social="instagram"] .filled,
        .example-2 .icon-content a[data-social="instagram"]~.tooltip {
            background: linear-gradient(45deg,
                    #405de6,
                    #5b51db,
                    #b33ab4,
                    #c135b4,
                    #e1306c,
                    #fd1f1f);
        }

        .example-2 .icon-content a[data-social="youtube"] .filled,
        .example-2 .icon-content a[data-social="youtube"]~.tooltip {
            background-color: #ff0000;
        }
    </style>
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src=" {{asset('assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
    <script src="{{asset('assets/js/instantpages.5.1.0.min.js')}}"></script>
    <script src="{{asset('assets/js/lazyload.17.6.0.min.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ✅ Bootstrap Bundle JS (if not already loaded) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();


        document.addEventListener("DOMContentLoaded", function () {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl, { delay: 4000 }) // 4s auto-hide
            });
            toastList.forEach(toast => toast.show());
        });

        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-transparent');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        function previewFile(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('previewImage');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#profileImage').submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('account.updateProfileImage') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false, // prevent jQuery from overriding Content-Type
                processData: false, // prevent jQuery from processing the data
                success: function (response) {
                    if (response.success === true) {
                        // ✅ SweetAlert Success
                        Swal.fire({
                            icon: 'success',
                            title: 'Profile Updated',
                            text: 'Your profile image has been updated successfully!',
                            timer: 2000, // auto close after 2 seconds
                            showConfirmButton: false,
                            confirmButtonColor: '#6f42c1'
                        }).then(() => {
                            window.location.href = "{{ route('account.profile') }}";
                        });
                    } else {
                        // ❌ Validation Error
                        if (response.error && response.error.image) {
                            $('#image').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback').html(response.error.image);

                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                html: Object.values(response.errors).join('<br>'),
                                confirmButtonColor: '#dc3545',
                                timer: 3000, // auto close after 2 seconds
                                showConfirmButton: false
                            });
                        } else {
                            $('#image').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong. Please try again later!',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });


    </script>
    @yield('customJS')
</body>

</html>