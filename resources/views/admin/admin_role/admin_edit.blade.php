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
                                 <li class="breadcrumb-item"><a href="{{route('admin.adminsRoles')}}"
                            class="text-decoration-none"><i class="fa-solid fa-user-shield me-2"></i>Admins</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Admin</li>
                            </ol>
                        </nav>
                    </div>
              </div>

            <div class="row">

                <!-- Main Content -->
                <div class="col-12">
                    @include('front.message')

                    <form method="POST" id="editForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="edit_admin_id" value="{{ $admins->id }}">

                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                            <!-- Card Header -->

                            <div class="card-header card-header-unique d-flex align-items-center gap-3"
                                style="background-color: #28a745;">
                                <i class="fa-solid fa-user-shield text-white fs-4"></i>
                                <h4 class="mb-0 text-white"> Edit Admin</h4>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-semibold">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ $admins->name }}"
                                            placeholder="Enter Full Name" class="form-control shadow-sm border-0 rounded-3">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ $admins->email }}"
                                            placeholder="Enter Email Address"
                                            class="form-control shadow-sm border-0 rounded-3">
                                    </div>
                                </div>

                                <div class="row g-4 mt-1">

                                    <div class="col-md-6">
                                        <label for="mobile" class="form-label fw-semibold">Mobile <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="mobile" id="mobile" value="{{ $admins->mobile }}"
                                            placeholder="Enter Mobile Number"
                                            class="form-control shadow-sm border-0 rounded-3">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Designation*</label>
                                        <input type="text" name="designation" id="designation"
                                            value="{{$admins->designation}}" placeholder="Designation"
                                            class="form-control shadow-sm">
                                    </div>
                                </div>

                                <div class="row g-4 mt-1">
                                    <div class="col-md-6">
                                        <label for="role" class="form-label fw-semibold">Role <span
                                                class="text-danger">*</span></label>
                                        <select name="role" id="role" class="form-control shadow-sm">
                                            <option value="" disabled selected>-- Select Role --</option>
                                            <option value="super_admin" {{ $admins->role == 'super_admin' ? 'selected' : '' }}>
                                                Super Admin</option>
                                            <option value="admin" {{ $admins->role == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="sub_admin" {{ $admins->role == 'sub_admin' ? 'selected' : '' }}>Sub
                                                Admin</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="preview-container mb-3">
                                            <img id="previewImage" 
                                                src="{{ asset('profile_image/' . $admins->image) }}"
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

                                            @php
                                                $allPages = [
                                                    'users' => 'Users',
                                                    'job_categories' => 'Job Categories',
                                                    'job_types' => 'Job Types',
                                                    'jobs' => 'Jobs',
                                                    'job_applications' => 'Job Applications',
                                                    'admins_roles' => 'Admins & Roles',
                                                    'setting' => 'Setting'
                                                ];
                                                $selectedPermissions = json_decode($admins->page_permission ?? '[]', true);
                                            @endphp

                                            @foreach ($allPages as $key => $label)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="page_permission[]"
                                                        value="{{ $key }}" id="page_{{ $key }}"
                                                        {{ in_array($key, $selectedPermissions ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="page_{{ $key }}">
                                                        {{ $label }}
                                                    </label>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer bg-light p-3 text-start">
                                <button type="submit" class="btn btn-success px-4 shadow-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Update Admin
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
    <script type="text/javascript">
        $('#editForm').submit(function (e) {
    e.preventDefault();

    let formData = new FormData(this); // use FormData for image upload also

    $.ajax({
        url: '{{ route('admin.adminUpdate') }}',
        type: 'POST',
        dataType: 'json',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            // Clear previous errors
            clearValidationErrors();

            if (response.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Admin Updated!',
                    text: 'The admin details have been updated successfully.',
                    confirmButtonColor: '#198754',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('admin.adminsRoles') }}";
                });
            } else {
                // ❌ Custom JSON validation response
                showValidationErrors(response.errors || {});
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                // ❌ Laravel default validation response
                let errors = xhr.responseJSON.errors;
                showValidationErrors(errors);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Unable to process request. Please try again later.',
                    confirmButtonColor: '#d33'
                });
            }
        }
    });
});

/* === Helper Functions === */
function clearValidationErrors() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove(); // remove old error messages
}

function showValidationErrors(errors) {
    $.each(errors, function (field, messages) {
        let input = $('#' + field);

        if (input.length) {
            input.addClass('is-invalid');
            input.next('.invalid-feedback').remove(); // remove old error
            input.after('<p class="invalid-feedback d-block">' + messages[0] + '</p>');
        }
    });

    // SweetAlert summary
    let errorMessages = Object.values(errors).map(err => err[0]).join('<br>');  
}



// ✅ Image preview before upload
function previewFile(event) {
    const file = event.target.files[0];
    if (!file) return; // no file selected

    const reader = new FileReader();
    reader.onload = function (e) {
        const output = document.getElementById('previewImage');
        output.src = e.target.result;
    };
    reader.readAsDataURL(file);
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