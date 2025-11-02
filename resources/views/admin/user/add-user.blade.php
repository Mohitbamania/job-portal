@extends('admin.layout.app')

@section('main')

    <section class="section-5 bg-light">

        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="breadcrumb-box mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#">
                                <i class="fa fa-home me-2"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{route('admin.userList')}}" class="text-decoration-none"><i
                                    class="fa-solid fa-user-group me-2"></i>Users</a>
                        </li>
                        <li class="breadcrumb-item active">Add User</li>
                    </ol>
                </nav>
            </div>
        </div>


        <div class="row">
            <!-- Main Content -->
            <div class="col-12">
                @include('front.message')
                <form id="addUser" name="addUser" method="POST" class="needs-validation">
                    @csrf
                    <div class="card border-0 shadow-lg rounded-4">
                        <div
                            class="card-header bg-primary text-black py-3 px-4 rounded-top-4 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-plus text-white fs-4"></i>
                            <h4 class="mb-0 text-white">Add New User</h4>
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
                        </div>

                        <div class="card-footer bg-light p-4 text-start">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fa-solid fa-plus"></i> Add User
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
    <script>
        $("#addUser").submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this); // ✅ allows file uploads too

            $.ajax({
                url: "{{ route('admin.userStore') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    // Clear old validation errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    if (response.status === false) {
                        let errors = response.errors;

                        // Loop through validation errors
                        $.each(errors, function (field, message) {
                            let input = $('#' + field);

                            // Add error style
                            input.addClass('is-invalid');

                            // Remove old error if exists, then add new one
                            input.next('.invalid-feedback').remove();
                            input.after('<p class="invalid-feedback d-block">' + message[0] + '</p>');
                        });


                    } else {
                        // Success popup
                        Swal.fire({
                            icon: 'success',
                            title: 'User Added!',
                            text: 'The new user has been added successfully.',
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
                        text: 'Something went wrong, please try again later.',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });


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