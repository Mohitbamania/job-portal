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
                            <li class="breadcrumb-item active">Add Job</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    @include('front.account.side_menu')
                </div>

                <!-- Main Form -->
                <div class="col-lg-9">
                    @include('front.message')
                    <form id="createJob" name="createJob" method="POST" class="needs-validation">
                        <div class="card border-0 shadow-lg rounded-4">
                            <div class="card-header bg-primary text-black py-3 px-4 rounded-top-4">
                                <h4 class="mb-0"><i class="bi bi-briefcase me-2"></i>Post a New Job</h4>
                            </div>

                            <div class="card-body p-4">
                                <!-- Job Details -->
                                <h5 class="border-start border-3 border-primary ps-3 mb-4">Job Details</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Job Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="title" name="title" class="form-control shadow-sm"
                                            placeholder="e.g. Software Engineer">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Category <span
                                                class="text-danger">*</span></label>
                                        <select name="category" id="category" class="form-select shadow-sm">
                                            <option value="">Select a Category</option>
                                            @foreach($jobCategories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Job Nature <span
                                                class="text-danger">*</span></label>
                                        <select name="jobType" id="jobType" class="form-select shadow-sm">
                                            <option value="">Select Job Nature</option>
                                            @foreach($jobTypes as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Vacancy <span
                                                class="text-danger">*</span></label>
                                        <input type="number" min="1" id="vacancy" name="vacancy"
                                            class="form-control shadow-sm" placeholder="e.g. 5">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Salary</label>
                                        <input type="text" id="salary" name="salary" class="form-control shadow-sm"
                                            placeholder="e.g. ₹40,000 / month">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Location <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="location" name="location" class="form-control shadow-sm"
                                            placeholder="e.g. Mumbai, India">
                                    </div>
                                </div>

                                <!-- Textareas -->
                                <div class="mt-4">
                                    <label class="form-label fw-semibold">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control shadow-sm" name="description" id="description" rows="4"
                                        placeholder="Job description..."></textarea>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-semibold">Benefits</label>
                                    <textarea class="form-control shadow-sm" name="benefits" id="benefits" rows="3"
                                        placeholder="e.g. Health Insurance, Paid Leaves"></textarea>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-semibold">Responsibilities</label>
                                    <textarea class="form-control shadow-sm" name="responsibility" id="responsibility"
                                        rows="3" placeholder="Main job responsibilities"></textarea>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-semibold">Qualifications</label>
                                    <textarea class="form-control shadow-sm" name="qualifications" id="qualifications"
                                        rows="3" placeholder="Required qualifications"></textarea>
                                </div>

                                <!-- Keywords & Experience -->
                                <div class="row g-4 mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Keywords</label>
                                        <input type="text" id="keywords" name="keywords" class="form-control shadow-sm"
                                            placeholder="e.g. PHP, Laravel, MySQL">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Experience <span
                                                class="text-danger">*</span></label>
                                        <select name="experience" id="experience" class="form-select shadow-sm">
                                            <option value="">Select Experience</option>
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{$i}}">{{$i}} Year</option>
                                            @endfor
                                            <option value="10_plus">10+ Years</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Company Details -->
                                <h5 class="border-start border-3 border-primary ps-3 mt-5 mb-4">Company Details</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Company Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="company_name" name="company_name"
                                            class="form-control shadow-sm" placeholder="Company Name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Company Location</label>
                                        <input type="text" id="company_location" name="company_location"
                                            class="form-control shadow-sm" placeholder="e.g. Delhi, India">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Website</label>
                                        <input type="text" id="website" name="website" class="form-control shadow-sm"
                                            placeholder="https://company.com">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-light p-4 text-start">
                                <button type="submit" class="btn btn-primary px-4"
                                    style="border-color:blueviolet;color:white;background:blueviolet"><i
                                        class="bi bi-save me-2"></i>Create
                                    Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('customJS')
    <script type="text/javascript">
        $('#createJob').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('account.saveJob') }}',
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function (response) {
                    clearValidationErrors(); // reset old errors

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Job Created!',
                            text: 'Your job has been posted successfully.',
                            confirmButtonColor: '#198754',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('account.myJob') }}";
                        });
                    } else {
                        showValidationErrors(response.errors || {});
                    }
                },
                error: function (xhr) {
                    clearValidationErrors();

                    if (xhr.status === 422) {
                        // Laravel default validation
                        let errors = xhr.responseJSON.errors;
                        showValidationErrors(errors);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'An unexpected error occurred. Please try again later.',
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });
        });

        /* === Helpers === */
        function clearValidationErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove(); // remove old error messages
        }

        function showValidationErrors(errors) {
            $.each(errors, function (field, messages) {
                let input = $('[name="' + field + '"]'); // match by name instead of ID
                if (input.length) {
                    input.addClass('is-invalid');
                    input.next('.invalid-feedback').remove();
                    input.after('<p class="invalid-feedback d-block">' + messages[0] + '</p>');
                }
            });

            // Summary popup
            let errorMessages = Object.values(errors).map(err => err[0]).join('<br>');
        }
        $(document).ready(function () {
            // Initialize Summernote for job description
            $('#description').summernote({
                placeholder: 'Write a detailed job description...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['fontsize', 'color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
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