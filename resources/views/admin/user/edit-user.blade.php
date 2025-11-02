@extends('admin.layout.app')

@section('main')
    <section class="section-5 bg-light">

        <!-- Breadcrumb -->

        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="breadcrumb-box mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#">
                                <i class="fa fa-home me-2"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.userList') }}"><i class="fa-solid fa-user-group me-2"></i>Users</a>
                        </li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-12">
                @include('front.message')

                <form method="POST" id="editForm">
                    @csrf
                    <input type="hidden" name="edit_user_id" value="{{ $user->id }}">

                    <div class="card glass-card shadow-lg border-0 overflow-hidden">
                        <!-- Card Header -->
                        <div class="card-header card-header-unique d-flex align-items-center gap-3"
                            style="background-color: #28a745;">
                            <i class="fa-solid fa-user-plus text-white fs-4"></i>
                            <h4 class="mb-0 text-white">Edit User Profile</h4>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ $user->name }}"
                                        placeholder="Enter Full Name" class="form-control shadow-sm border-0 rounded-3">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ $user->email }}"
                                        placeholder="Enter Email Address" class="form-control shadow-sm border-0 rounded-3">
                                </div>
                            </div>

                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <label for="designation" class="form-label fw-semibold">Designation <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="designation" id="designation" value="{{ $user->designation }}"
                                        placeholder="Enter Designation" class="form-control shadow-sm border-0 rounded-3">
                                </div>
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label fw-semibold">Mobile <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="mobile" id="mobile" value="{{ $user->mobile }}"
                                        placeholder="Enter Mobile Number" class="form-control shadow-sm border-0 rounded-3">
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-light p-3 text-start d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4 shadow-sm">
                                <i class="fa-solid fa-pen-to-square"></i> Update User
                            </button>
                            <a href="{{ route('admin.userList') }}" class="btn btn-secondary px-4 shadow-sm">
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

            let formData = new FormData(this); // ✅ handles file + text fields

            $.ajax({
                url: '{{ route('admin.userUpdate') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    // Clear old validation errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    if (response.success === false) {
                        let errors = response.errors;

                        // Loop through validation errors
                        $.each(errors, function (field, message) {
                            let input = $('#' + field);

                            // Add error style
                            input.addClass('is-invalid');

                            // Remove old error then show new one
                            input.next('.invalid-feedback').remove();
                            input.after('<p class="invalid-feedback d-block">' + message[0] + '</p>');
                        });

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'User Updated!',
                            text: 'The user details have been updated successfully.',
                            confirmButtonColor: '#198754',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('admin.userList') }}";
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Unable to process request. Please try again later.',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });

    </script>
@endsection

<style>
    /* Reuse glass-card, btn-gradient and page styles from your listing page */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transition: all 0.35s ease-in-out;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        color: #fff;
        font-weight: 500;
        border-radius: 25px;
        transition: all 0.3s ease-in-out;
    }

    .btn-gradient:hover {
        opacity: 0.95;
        transform: translateY(-2px);
        color: #fff;
    }

    /* Breadcrumb */
    .breadcrumb-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 14px 22px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
    }

    .breadcrumb-item a {
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-item a:hover {
        background: rgba(37, 99, 235, 0.1);
        color: #1e40af;
    }

    .breadcrumb-item.active {
        color: #374151;
        font-weight: 600;
    }

    /* Card Header Gradient */
    .card-header.bg-gradient {
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        color: #fff;
    }

    /* Input styling */
    .form-control.shadow-sm {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
    }

    /* Buttons */
    .btn-success,
    .btn-secondary {
        border: none;
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

    .card-header-unique {
        border-radius: 20px 20px 0 0;
        padding: 20px 24px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        color: #fff;
    }

    /* Icon Circle */
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #4e73df;
        /* simple solid color */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .icon-circle:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    /* Header Text */
    .header-text h4 {
        font-size: 1.6rem;
        font-weight: 700;
        margin: 0;
    }

    .header-text small {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .icon-circle i.icon-large {
        font-size: 1.5rem;
        /* adjust size */
    }
</style>