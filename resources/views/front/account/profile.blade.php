@extends('front.layout.app')

@section('main')
    <section class="section-5 bg-light py-5">
        <div class="container mt-5">

            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="breadcrumb-box mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fa fa-home me-1"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    @include('front.account.side_menu')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    @include('front.message')

                    <!-- Profile Card -->
                    <div class="card border-0 shadow-lg rounded-4 mb-4">
                        <form method="POST" id="userForm">
                            <div class="card-header text-black py-3 rounded-top-4">
                                <h4 class="mb-0">
                                    <i class="bi bi-person-circle me-2 fs-3"></i> My Profile
                                </h4>
                            </div>

                            <div class="card-body p-4">
                                <input type="hidden" name="user_id" value="{{$user->id}}">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Name*</label>
                                    <input type="text" name="name" id="name" value="{{$user->name}}"
                                        placeholder="Enter Name" class="form-control rounded-pill shadow-sm">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email*</label>
                                    <input type="text" name="email" id="email" value="{{$user->email}}"
                                        placeholder="Enter Email" class="form-control rounded-pill shadow-sm">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Designation*</label>
                                    <input type="text" name="designation" id="designation" value="{{$user->designation}}"
                                        placeholder="Designation" class="form-control rounded-pill shadow-sm">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Mobile*</label>
                                    <input type="text" name="mobile" id="mobile" value="{{$user->mobile}}"
                                        placeholder="Mobile" class="form-control rounded-pill shadow-sm">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Upload Resume</label>
                                    <input type="file" name="resume" id="resume" class="form-control shadow-sm rounded-pill"
                                        accept=".pdf,.doc,.docx">
                                    <small class="text-muted">Allowed formats: PDF, DOC, DOCX</small>

                                    <!-- Button for selected file -->
                                    <div class="mt-3" id="newFileSection" style="display: none;">
                                        <button type="button" id="viewSelectedBtn"
                                            class="btn btn-sm btn-outline-danger rounded-pill">
                                            <i class="bi bi-eye"></i> View Selected File
                                        </button>
                                    </div>

                                    @if($user->resume)
                                        <div class="mt-2">
                                            <a href="{{ asset($user->resume) }}" target="_blank"
                                                class="btn btn-sm btn-outline-danger rounded-pill">
                                                <i class="bi bi-file-earmark-text"></i> View Current Resume
                                            </a>
                                        </div>
                                    @endif

                                </div>
                                <div id="resumeScoreBox" class="mt-4" style="display:none;">
                                    <label class="form-label fw-semibold">Resume Strength</label>
                                    <div class="progress rounded-pill" style="height: 20px;">
                                        <div id="scoreBar" class="progress-bar bg-success" role="progressbar"
                                            style="width: 0%;"></div>
                                    </div>
                                    <p class="mt-2 text-muted small">Your resume score: <span id="scoreValue">0/100</span>
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-start p-3 rounded-bottom-4">
                                <button type="submit" class="btn btn-outline-primary me-2 px-4 rounded-pill"
                                    style="border-color:blueviolet;color:white;background:blueviolet">
                                    <i class="bi bi-save me-1"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Password Card -->
                    <div class="card border-0 shadow-lg rounded-4">
                        <form method="POST" id="changePasswordForm" name="changePasswordForm">
                            <div class="card-header text-black py-3 rounded-top-4">
                                <h5 class="mb-0"><i class="bi bi-lock-fill me-2"></i> Change Password</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Old Password*</label>
                                    <input type="password" name="old_password" id="old_password" placeholder="Old Password"
                                        class="form-control rounded-pill shadow-sm">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">New Password*</label>
                                    <input type="password" name="new_password" id="new_password" placeholder="New Password"
                                        class="form-control rounded-pill shadow-sm">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Confirm Password*</label>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        placeholder="Confirm Password" class="form-control rounded-pill shadow-sm">
                                </div>
                            </div>
                            <div class="card-footer bg-light text-start p-3 rounded-bottom-4">
                                <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm"
                                    style="border-color:blueviolet;color:white;background:blueviolet">
                                    <i class="bi bi-check-circle me-1"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJS')
    <script type="text/javascript">
        $('#userForm').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this); // ✅ handles text + file data

            $.ajax({
                url: '{{ route('account.updateProfile') }}',
                type: 'POST',
                data: formData,
                contentType: false, // ✅ required for FormData
                processData: false, // ✅ required for FormData
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Profile Updated!',
                            text: 'Your profile has been updated successfully.',
                            timer: 2000, // auto close after 2 seconds
                            showConfirmButton: false,
                            confirmButtonColor: '#6f42c1' // purple shade
                        }).then(() => {
                            window.location.href = "{{ route('account.profile') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            html: Object.values(response.errors).join('<br>'),
                            confirmButtonColor: '#dc3545',
                            timer: 4000, // auto close after 2 seconds
                            showConfirmButton: false
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong. Please try again later.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });


        $('#changePasswordForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{route('account.changePassword')}}',
                type: 'POST',
                dataType: 'json',
                data: $('#changePasswordForm').serializeArray(),
                success: function (response) {
                    if (response.success == true) {
                        window.location.href = "{{route('account.profile')}}"
                    }
                }
            });
        });

        document.getElementById('resume').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const newFileSection = document.getElementById('newFileSection');
            const viewBtn = document.getElementById('viewSelectedBtn');
            const scoreBox = document.getElementById('resumeScoreBox');

            if (file) {
                newFileSection.style.display = 'block';
                viewBtn.onclick = function () {
                    const fileURL = URL.createObjectURL(file);
                    window.open(fileURL, '_blank');
                };

                // Create form data for AJAX
                let formData = new FormData();
                formData.append('resume', file);

                // Call backend to analyze resume
                fetch('{{ route("account.analyzeResume") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            scoreBox.style.display = 'block';
                            document.getElementById('scoreValue').innerText = data.score + "/100";
                            document.getElementById('scoreBar').style.width = data.score + "%";
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to analyze resume.'
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong.'
                        });
                    });

            } else {
                newFileSection.style.display = 'none';
                scoreBox.style.display = 'none';
            }
        });

    </script>
@endsection
<style>
    .btn-gradient {
        background: linear-gradient(90deg, #007bff, #0056d2);
        color: #fff;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.3s ease-in-out;
    }

    .btn-gradient:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        color: #fff;
    }

    .table thead th {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr:hover {
        background-color: #f9fbff;
    }

    .breadcrumb-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 14px 22px;
        border: 1px solid #e5e7eb;
        /* subtle border */
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
    }

    .breadcrumb {
        background: transparent;
        margin: 0;
        font-size: 15px;
        font-weight: 500;
    }

    .breadcrumb-item a {
        color: #2563eb;
        /* primary blue */
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .breadcrumb-item a:hover {
        background: rgba(37, 99, 235, 0.1);
        color: #1e40af;
    }

    .breadcrumb-item.active {
        color: #374151;
        /* dark gray */
        font-weight: 600;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: #9ca3af;
        font-weight: bold;
        margin: 0 6px;
    }

    .breadcrumb {
        background: transparent;
        margin: 0;
        font-size: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        /* ensures vertical centering */
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
        /* centers text & icons */
    }

    .breadcrumb-item a {
        display: flex;
        align-items: center;
        gap: 6px;
        /* spacing between icon & text */
        color: #2563eb;
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
</style>