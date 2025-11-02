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
                        <li class="breadcrumb-item"><a href="{{route('admin.jobTypeList')}}" class="text-decoration-none"><i
                                    class="fa-solid fa-tags me-2"></i>Job
                                Type</a></li>
                        <li class="breadcrumb-item active">Edit Job Type</li>
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
                    <input type="hidden" name="edit_job_type_id" value="{{ $jobType->id }}">

                    <div class="card border-0 shadow-lg rounded-4">

                        <div class="card-header card-header-unique d-flex align-items-center gap-3"
                            style="background-color: #28a745;">
                            <i class="fa-solid fa-clipboard-list text-white fs-4"></i>
                            <h4 class="mb-0 text-white">Edit Job Type</h4>
                        </div>

                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">Job Type Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" value="{{ $jobType->name }}"
                                    placeholder="Enter Job Type Name" class="form-control shadow-sm">
                                <p></p>
                            </div>
                        </div>

                        <div class="card-footer bg-light p-3 text-start">
                            <button type="submit" class="btn btn-success px-4 shadow-sm">
                                <i class="fa-solid fa-pen-to-square"></i> Update Type
                            </button>
                            <a href="{{ route('admin.jobTypeList') }}" class="btn btn-secondary px-4 shadow-sm">
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

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route('admin.jobTypeUpdate') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    // Clear old errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Job Type Updated!',
                            text: 'The job type has been updated successfully.',
                            confirmButtonColor: '#198754',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('admin.jobTypeList') }}";
                        });
                    } else {
                        // Inline validation errors
                        let errors = response.errors;
                        if (errors) {
                            $.each(errors, function (field, message) {
                                let input = $('#' + field);
                                input.addClass('is-invalid');
                                input.next('.invalid-feedback').remove();
                                input.after('<p class="invalid-feedback d-block">' + message[0] + '</p>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                text: response.message || 'Unable to update job type.',
                                confirmButtonColor: '#d33'
                            });
                        }
                    }
                },
                error: function (xhr) {
                    // Clear old errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, message) {
                            let input = $('#' + field);
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').remove();
                            input.after('<p class="invalid-feedback d-block">' + message[0] + '</p>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Something went wrong while updating job type.',
                            confirmButtonColor: '#d33'
                        });
                    }
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