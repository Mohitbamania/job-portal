<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CareerVibe Admin')</title>

    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --bg-light: #f8f9fa;
            --text-dark: #2d3748;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
        }

        /* HEADER */
        .admin-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: #1e3a8a;
            /* Blue-Purple combo */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            color: #fff;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
        }

        /* Logo / Brand text */
        .admin-header .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
        }

        /* Icon inside header */
        .admin-header .navbar-brand i {
            font-size: 1.8rem;
            margin-right: 10px;
            color: #ffd369;
            /* Highlight color (gold/yellow) */
        }

        /* Navigation items or right section */
        .admin-header .nav-items a {
            color: #f1f1f1;
            margin-left: 20px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .admin-header .nav-items a:hover {
            color: #ffd369;
            /* Matches brand accent */
        }

        .brand-logo {
            font-weight: 700;
            font-size: 1.4rem;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-logo i {
            font-size: 1.8rem;
            color: #ffeb3b;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 15px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: 0.3s ease;
        }

        .profile-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.02);
        }

        .profile-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .dropdown-menu {
            position: absolute;
            top: 110%;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            min-width: 180px;
            display: none;
            overflow: hidden;
        }

        .dropdown-menu.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: var(--text-dark);
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        /* MAIN LAYOUT */
        .layout {
            display: flex;
            /* push below header */
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            padding: 30px;
            /* global padding for all pages */
            min-height: calc(100vh - 70px);
            transition: all 0.3s ease;
            top: 30px
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.6rem;
            color: white;
        }

        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
            }

            .mobile-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                top: 70px;
                left: 0;
                width: 250px;
                height: calc(100vh - 70px);
                background: white;
                box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
                z-index: 999;
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                padding: 20px;
            }
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        /* Button Style */
        .profile-btn {
            background: #3749a6;
            /* dark slate */
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .profile-btn:hover {
            background: #374151;
        }

        /* Avatar */
        .profile-avatar {
            border-radius: 50%;
            margin-right: 8px;
            width: 32px;
            height: 32px;
            object-fit: cover;
            border: 2px solid #fff;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            position: absolute;
            top: 110%;
            right: 0;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            min-width: 180px;
            overflow: hidden;
            display: none;
            flex-direction: column;
            padding: 6px 0;
            animation: fadeIn 0.2s ease;
            z-index: 999;
        }

        /* Dropdown Items */
        .dropdown-item {
            padding: 10px 16px;
            color: #374151;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background 0.2s, color 0.2s;
            font-size: 15px;
        }

        .dropdown-item i {
            margin-right: 8px;
            font-size: 14px;
        }

        /* Hover Effect */
        .dropdown-item:hover {
            background: #f3f4f6;
            color: #1e3a8a; 
        }

        /* Divider */
        .dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 6px 0;
        }

        /* Logout Special Style */
        .dropdown-item.logout {
            color: #e53e3e;
            font-weight: 500;
        }

        .dropdown-item.logout:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Fade In Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .show {
            display: flex !important;
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

        .toast-container {
            z-index: 2000;
        }

        /* Core Toast */
        .custom-toast {
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
            animation: slideInUp 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
            min-width: 300px;
            font-size: 0.95rem;
            overflow: hidden;
            transform-origin: bottom right;
        }

        /* Toast Body */
        .custom-toast .toast-body {
            font-weight: 500;
            padding: 0.9rem 1rem;
        }

        /* ✅ Variants */
        .success-toast {
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: #fff;
        }

        .error-toast {
            background: linear-gradient(135deg, #dc3545, #a71d2a);
            color: #fff;
        }

        .info-toast {
            background: linear-gradient(135deg, #0dcaf0, #0a95b5);
            color: #fff;
        }

        .warning-toast {
            background: linear-gradient(135deg, #ffc107, #d39e00);
            color: #212529;
        }

        /* Close Button */
        .custom-toast .btn-close {
            filter: brightness(0) invert(1);
        }

        .warning-toast .btn-close {
            filter: none;
        }

        /* Animations */
        @keyframes slideInUp {
            0% {
                opacity: 0;
                transform: translateY(100%) scale(0.95);
            }
            60% {
                opacity: 1;
                transform: translateY(-10px) scale(1.02);
            }
            100% {
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slideOutDown {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateY(100%) scale(0.95);
            }
        }

        /* Add "closing" class dynamically when dismissing */
        .custom-toast.closing {
            animation: slideOutDown 0.5s ease forwards;
        }

        /* ====== GLOBAL PAGE LOADER ====== */
        #globalLoader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 3000;
        }

        .dots-loader {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .dots-loader div {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background:red;
            animation: pulse 1.2s infinite ease-in-out;
        }

        .dots-loader div:nth-child(1) { animation-delay: 0s; }
        .dots-loader div:nth-child(2) { animation-delay: 0.2s; }
        .dots-loader div:nth-child(3) { animation-delay: 0.4s; }

        @keyframes pulse {
            0%, 80%, 100% { transform: scale(0); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }

        .loading-text {
            font-weight: 600;
            color:red;
            font-size: 2.1rem;
            letter-spacing: 0.5px;
        }

        .dropdown-item:hover {
            background-color: #f1f5ff; /* Light blue background */
            color: #0d6efd !important; /* Bootstrap primary blue text */
            transition: 0.2s ease;
        }

        .dropdown-item i {
            transition: color 0.2s ease;
        }

        .dropdown-item:hover i {
            color: #0d6efd !important;
        }
    </style>

    @yield('styles')
</head>

<body>
    <!-- HEADER -->
    <header class="admin-header">
        <div class="d-flex align-items-center">
            <button class="mobile-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center fw-bold fs-4">
                <i class="fas fa-bolt me-2 text-danger fs-2"></i>
                Career <span class="text-success">&nbsp;Vibe</span>
            </a>
        </div>

        <div class="profile-dropdown">
            <button class="profile-btn" onclick="toggleDropdown()">
                <img src="{{ asset('profile_image/' . Auth::user()->image) }}" alt="Admin" class="profile-avatar">
                <span class="profile-name">Admin</span>
                <i class="fas fa-chevron-down"></i>
            </button>

            <div class="dropdown-menu" id="profileDropdown">
                <a href="#" class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#adminProfileModal">
                    <i class="fas fa-user me-2 text-primary"></i> Profile
                </a>

                <a href="#" class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="fas fa-key me-2 text-warning"></i> Change Password
                </a>

                <a href="{{ route('admin.settings') }}" class="dropdown-item text-dark">
                    <i class="fas fa-cog me-2 text-info"></i> Settings
                </a>

                <div class="dropdown-divider"></div>

                <a href="{{ route('account.logout') }}" class="dropdown-item text-danger fw-semibold logout">
                    <i class="fas fa-sign-out-alt me-2 text-danger"></i> Logout
                </a>

                    
            </div>

        </div>
    </header>

    <!-- Admin Profile Modal -->
    <div class="modal fade" id="adminProfileModal" tabindex="-1" aria-labelledby="adminProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="adminProfileModalLabel"><i class="fas fa-user me-2"></i> Admin Profile
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="adminProfileForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="admin_id" value="{{ Auth::user()->id }}">

                        <div class="row g-4"> <!-- g-4 adds spacing between columns -->
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="adminName" class="form-label fw-semibold">Name</label>
                                    <input type="text" class="form-control" id="adminName" name="name"
                                        value="{{ Auth::user()->name }}">
                                </div>
                                <div class="mb-3">
                                    <label for="adminEmail" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" id="adminEmail" name="email"
                                        value="{{ Auth::user()->email }}">
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="adminMobile" class="form-label fw-semibold">Mobile</label>
                                    <input type="text" class="form-control" id="adminMobile" name="mobile"
                                        value="{{ Auth::user()->mobile }}">
                                </div>
                                <div class="preview-container mb-3">
                                    <img id="previewImage" src="{{ asset('profile_image/' . Auth::user()->image) }}"
                                        class="rounded-circle shadow-sm border border-3 border-primary"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                                <label class="form-label fw-semibold">Upload Profile Image</label>
                                <input type="file" class="form-control shadow-sm" id="image" name="image" value="{{Auth::user()->image}}"
                                    accept="image/*" onchange="previewFile(event)">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"> <i class="fa-solid fa-pen-to-square"></i> Update
                            Profile</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left me-2 fs-5"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="fas fa-key me-2"></i> Change Password
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="changePasswordForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="admin_id" value="{{ Auth::user()->id }}">

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                placeholder="Enter your current password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-semibold">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Enter new password" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="Re-enter new password" required>
                        </div>

                        <div id="passwordError" class="text-danger small d-none">
                            ⚠️ New password and confirm password do not match.
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-pen-to-square"></i> Update Password
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left me-2 fs-5"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- MAIN LAYOUT -->
    <div class="layout">
        @include('admin.side_menu') <!-- Sidebar File -->
        <main class="main-content">
            @yield('main')
        </main>
    </div>

    <!-- Global Page Loader -->
    <div id="globalLoader">
    <div class="loader-overlay">
        <div class="dots-loader">
        <div></div><div></div><div></div>
        </div>
        <p class="loading-text">Loading...</p>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

    {{-- <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/js/sweetalert2.all.min.js"></script>
    <script src="/assets/admin/js/jquery-3.6.4.min.js"></script>
    <script src="/assets/admin/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/js/buttons.print.min.js"></script>
    <script src="/assets/admin/js/chart.min.js"></script> --}}
    <script>
        function toggleDropdown() {
            document.getElementById('profileDropdown').classList.toggle('show');
        }

        window.onclick = function (e) {
            if (!e.target.closest('.profile-dropdown')) {
                document.getElementById('profileDropdown').classList.remove('show');
            }
        }

        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }
        function toggleDropdown() {
            document.getElementById("profileDropdown").classList.toggle("show");
        }

        // Close dropdown when clicking outside
        window.addEventListener("click", function (e) {
            if (!e.target.closest(".profile-dropdown")) {
                document.getElementById("profileDropdown").classList.remove("show");
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

        $(document).ready(function () {
            $('#adminProfileForm').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("admin.profileUpdate") }}', // make this route
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Profile Updated!',
                                text: 'Your profile has been updated successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#adminProfileModal').modal('hide');
                            // Optionally, refresh page or update dropdown name
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Please try again later.'
                        });
                    }
                });
            });
        });
        $(document).ready(function () {
            $('#adminProfileForm').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("admin.profileUpdate") }}', // make this route
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Profile Updated!',
                                text: 'Your profile has been updated successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#adminProfileModal').modal('hide');
                            // Optionally, refresh page or update dropdown name
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Please try again later.'
                        });
                    }
                });
            });
        });

        $(document).ready(function () {
            $('#changePasswordForm').submit(function (e) {
                e.preventDefault();

                const newPass = $('#new_password').val();
                const confirmPass = $('#confirm_password').val();
                const errorDiv = $('#passwordError');

                // Check password match
                if (newPass !== confirmPass) {
                    errorDiv.removeClass('d-none');
                    return;
                } else {
                    errorDiv.addClass('d-none');
                }

                $.ajax({
                    url: '{{ route("admin.changePassword") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        admin_id: $('[name="admin_id"]').val(),
                        current_password: $('#current_password').val(),
                        new_password: newPass,
                        confirm_password: confirmPass
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Please wait...',
                            text: 'Updating your password.',
                            didOpen: () => Swal.showLoading(),
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    },
                    success: function (response) {
                        Swal.close(); // close loading popup

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Password Changed!',
                                text: response.message || 'Your password has been updated successfully.',
                                timer: 2000,
                            });

                            // Hide modal and reset form
                            setTimeout(() => {
                                $('#changePasswordModal').modal('hide');
                                $('#changePasswordForm')[0].reset();
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 
                                    (response.errors ? Object.values(response.errors).join(', ') : 'Something went wrong.')
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.close();

                        let msg = 'Please try again later.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            msg = Object.values(xhr.responseJSON.errors).join(', ');
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: msg
                        });
                    }
                });
            });
        });




        $(document).ready(function () {
            const loader = $('#globalLoader');

            // Show loader on link clicks (except anchors with #)
            $(document).on('click', 'a', function (e) {
                const href = $(this).attr('href');
                if (href && href !== '#' && !href.startsWith('javascript')) {
                    loader.fadeIn(200);
                }
            });

            // Show loader on form submit
            $(document).on('submit', 'form', function () {
                loader.fadeIn(200);
            });

            // Show loader on any AJAX start
            $(document).ajaxStart(function () {
                loader.fadeIn(200);
            });

            // Hide loader on any AJAX complete
            $(document).ajaxStop(function () {
                loader.fadeOut(300);
            });

            // Hide loader after page load complete
            $(window).on('load', function () {
                loader.fadeOut(300);
            });
        });
    </script>
    @yield('customJS')
</body>

</html>