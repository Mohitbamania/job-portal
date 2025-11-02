@extends('admin.layout.app')

@section('main')

    <section class="section-5 bg-light">

        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="breadcrumb-box mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="fa fa-home me-1"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{route('admin.adminsRoles')}}" class="text-decoration-none"><i
                                    class="fa-solid fa-user-shield me-2"></i>Admins</a>
                        </li>
                        <li class="breadcrumb-item active">Add Admin</li>
                    </ol>
                </nav>
            </div>
        </div>


        <div class="row">

            <!-- Main Content -->
            <div class="col-12">
                @include('front.message')
                <form id="addAdmin" name="addAdmin" method="POST" enctype="multipart/form-data" class="needs-validation">
                    @csrf
                    <div class="card border-0 shadow-lg rounded-4">

                        <div
                            class="card-header bg-primary text-white py-3 px-4 rounded-top-4 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-shield fs-4"></i>
                            <h4 class="mb-0"> Add New Admin</h4>
                        </div>

                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control shadow-sm"
                                        placeholder="Enter Name">
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control shadow-sm"
                                        placeholder="Enter Email">
                                    <p></p>
                                </div>
                            </div>

                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control shadow-sm"
                                        placeholder="Enter Password">
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm_password" class="form-label fw-semibold">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="confirm_password"
                                        class="form-control shadow-sm" placeholder="Please Confirm Password">
                                    <p></p>
                                </div>
                            </div>

                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Designation*</label>
                                    <input type="text" name="designation" id="designation" placeholder="Designation"
                                        class="form-control shadow-sm">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Mobile*</label>
                                    <input type="text" name="mobile" id="mobile" placeholder="Mobile"
                                        class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="row g-4 mt-1">

                                <div class="col-md-6">
                                    <label for="role" class="form-label fw-semibold">Role <span
                                            class="text-danger">*</span></label>
                                    <select name="role" id="role" class="form-control shadow-sm">
                                        <option value="" disabled selected>-- Select Role --</option>
                                        <option value="super_admin">
                                            Super Admin</option>
                                        <option value="admin">Admin
                                        </option>
                                        <option value="sub_admin">Sub
                                            Admin</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="preview-container mb-3">
                                        <img id="previewImage" src="{{ asset('assets/images/avatar7.png') }}"
                                            class="rounded-circle shadow-sm border border-3 border-primary"
                                            style="width: 120px; height: 120px; object-fit: cover;">
                                    </div>
                                    <label class="form-label fw-semibold">Upload Profile Image</label>
                                    <input type="file" class="form-control shadow-sm" id="image" name="image"
                                        accept="image/*" onchange="previewFile(event)">
                                </div>
                            </div>

                            <div class="row g-4 mt-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Page Permissions</label>
                                    <div class="p-3 border rounded-3 shadow-sm bg-light">
                                        <div>
                                            <input type="checkbox" name="menu_permissions[]" value="users" id="perm_users">
                                            <label for="perm_users">Users</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="menu_permissions[]" value="job_categories"
                                                id="perm_job_categories">
                                            <label for="perm_job_categories">Job Categories</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="menu_permissions[]" value="job_types"
                                                id="perm_job_types">
                                            <label for="perm_job_types">Job Types</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="menu_permissions[]" value="jobs" id="perm_jobs">
                                            <label for="perm_jobs">Jobs</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="menu_permissions[]" value="job_applications"
                                                id="perm_job_applications">
                                            <label for="perm_job_applications">Job Applications</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="menu_permissions[]" value="admins_roles"
                                                id="perm_admins_roles">
                                            <label for="perm_admins_roles">Admins & Roles</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="menu_permissions[]" value="setting"
                                                id="perm_setting">
                                            <label for="perm_setting">Setting</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light p-4 text-start">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa-solid fa-plus"></i> Add Admin
                            </button>
                            <a href="{{ route('admin.adminsRoles') }}" class="btn btn-secondary px-4 shadow-sm">
                                <i class="fa-solid fa-arrow-left me-2 fs-5"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection

@section('customJS')
    <script>
        $("#addAdmin").submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.adminStore') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    // Clear previous errors
                    clearValidationErrors();

                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Admin Added!',
                            text: 'The new admin has been added successfully.',
                            confirmButtonColor: '#198754',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('admin.adminsRoles') }}";
                        });
                    } else {
                        // ❌ Laravel custom JSON error
                        showValidationErrors(response.errors);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        // ❌ Laravel default validation errors
                        showValidationErrors(xhr.responseJSON.errors);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Something went wrong, please try again later.',
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });
        });

        function clearValidationErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove(); // remove old error messages
        }

        function showValidationErrors(errors) {
            $.each(errors, function (field, messages) {
                let input = $('#' + field);

                if (input.length) {
                    input.addClass('is-invalid');
                    input.next('.invalid-feedback').remove(); // remove any old error
                    input.after('<p class="invalid-feedback d-block">' + messages[0] + '</p>');
                }
            });
        }

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
<style>
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