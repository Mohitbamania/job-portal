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
                        <li class="breadcrumb-item"><a href="{{route('admin.jobList')}}" class="text-decoration-none"> <i
                                    class="fa-solid fa-briefcase me-2"></i>Job</a>
                        </li>
                        <li class="breadcrumb-item active">Add Job</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">

            <!-- Main Content -->
            <div class="col-12">
                @include('front.message')

                <form id="createJob" method="POST">
                    @csrf

                    <div class="card border-0 shadow-lg rounded-4">

                        <div
                            class="card-header bg-primary text-white py-3 px-4 rounded-top-4 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-briefcase fs-4"></i>
                            <h4 class="mb-0">Add New Job</h4>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-secondary mb-3">Job Details</h5>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" placeholder="Job Title"
                                        class="form-control shadow-sm">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">User <span class="text-danger">*</span></label>
                                    <select name="user" id="user" class="form-control shadow-sm">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Category <span
                                            class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-control shadow-sm">
                                        <option value="">Select Category</option>
                                        @foreach($jobCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Job Nature <span
                                            class="text-danger">*</span></label>
                                    <select name="jobType" id="jobType" class="form-control shadow-sm">
                                        <option value="">Select Job Type</option>
                                        @foreach($jobTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Vacancy <span class="text-danger">*</span></label>
                                    <input type="number" min="1" name="vacancy" id="vacancy" placeholder="Vacancy"
                                        class="form-control shadow-sm">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Salary</label>
                                    <input type="text" name="salary" id="salary" placeholder="Salary"
                                        class="form-control shadow-sm">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Location <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="location" id="location" placeholder="Location"
                                        class="form-control shadow-sm">
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="mt-4 d-flex align-items-center justify-content-between">
                                    <label class="form-label fw-semibold mb-0">Description <span
                                            class="text-danger">*</span></label>
                                    <button type="button" id="generateDescription"
                                        class="btn btn-sm btn-warning shadow-sm mb-2">
                                        <i class="fa-solid fa-robot me-1"></i> Generate via AI
                                    </button>
                                </div>
                                <textarea name="description" id="description" rows="4" class="form-control shadow-sm"
                                    placeholder="Job Description"></textarea>
                            </div>

                            <div class="mt-4">
                                <label class="form-label fw-semibold">Benefits</label>
                                <textarea name="benefits" id="benefits" rows="3" class="form-control shadow-sm"
                                    placeholder="Job Benefits"></textarea>
                            </div>

                            <div class="mt-4">
                                <label class="form-label fw-semibold">Responsibility</label>
                                <textarea name="responsibility" id="responsibility" rows="3" class="form-control shadow-sm"
                                    placeholder="Job Responsibility"></textarea>
                            </div>

                            <div class="mt-4">
                                <label class="form-label fw-semibold">Qualifications</label>
                                <textarea name="qualifications" id="qualifications" rows="3" class="form-control shadow-sm"
                                    placeholder="Required Qualifications"></textarea>
                            </div>

                            <div class="mt-4">
                                <label class="form-label fw-semibold">Keywords</label>
                                <input type="text" name="keywords" id="keywords" placeholder="Keywords"
                                    class="form-control shadow-sm">
                            </div>

                            <div class="mt-4">
                                <label class="form-label fw-semibold">Experience</label>
                                <select name="experience" id="experience" class="form-control shadow-sm">
                                    <option value="">Select Experience</option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }} Year{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                    <option value="10_plus">10+ Years</option>
                                </select>
                            </div>

                            <div class="form-check mt-3 d-flex align-items-center" style="
                                            padding-left: 0px;
                                        ">
                                <div class="checkbox-apple me-2">
                                    <input class="yep" id="is_featured" name="is_featured" type="checkbox">
                                    <label for="is_featured"></label>
                                </div>
                                <label class="form-check-label fw-semibold mb-0" for="is_featured">
                                    Is Featured Job?
                                </label>
                            </div>


                            <h5 class="fw-bold text-secondary mt-5 pt-4 border-top">Company Details</h5>

                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Company Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="company_name" id="company_name" placeholder="Company Name"
                                        class="form-control shadow-sm">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Company Location</label>
                                    <input type="text" name="company_location" id="company_location" placeholder="Location"
                                        class="form-control shadow-sm">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="form-label fw-semibold">Website</label>
                                <input type="text" name="website" id="website" placeholder="Company Website"
                                    class="form-control shadow-sm">
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-light p-3 text-start">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fa-solid fa-plus"></i> Add Job
                            </button>
                            <a href="{{ route('admin.jobList') }}" class="btn btn-secondary px-4 shadow-sm">
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
        $('#createJob').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route('admin.jobStore') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Job Created!',
                            text: 'The job has been added successfully.',
                            confirmButtonColor: '#198754',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('admin.jobList') }}";
                        });
                    } else if (response.errors) {
                        handleCreateValidationErrors(response.errors);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        handleCreateValidationErrors(xhr.responseJSON.errors);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Creation Failed',
                            text: 'Something went wrong while creating the job.',
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });
        });


        function handleCreateValidationErrors(errors) {
            // Clear previous errors first
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Loop through errors and append them below each input
            $.each(errors, function (field, messages) {
                let input = $('[name="' + field + '"]');
                input.addClass('is-invalid');

                // Remove old feedback if exists
                input.next('.invalid-feedback').remove();

                // Add new feedback
                input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
            });
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

        $('#generateDescription').click(function () {
            // Collect form data needed to generate description
            let title = $('#title').val();
            let category = $('#category option:selected').text();
            let jobType = $('#jobType option:selected').text();
            let vacancy = $('#vacancy').val();
            let salary = $('#salary').val();

            // Optional: check required fields
            if (!title || !category || !jobType) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Fields',
                    text: 'Please fill Title, Category, and Job Type first.',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            // Show loading indicator
            $('#generateDescription').prop('disabled', true).text('Generating...');

            // AJAX call to backend route
            $.ajax({
                url: '{{ route("admin.generateJobDescription") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    title: title,
                    category: category,
                    jobType: jobType,
                    vacancy: vacancy,
                    salary: salary
                },
                success: function (response) {
                    if (response.success) {
                        // Fill the textarea with AI-generated description
                        $('#description').summernote('code', response.description);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Could not generate description. Try again!',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong while generating description.',
                        confirmButtonColor: '#d33'
                    });
                },
                complete: function () {
                    $('#generateDescription').prop('disabled', false).html('<i class="fa-solid fa-robot me-1"></i> Generate via AI');
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

    .checkbox-apple {
        position: relative;
        width: 50px;
        height: 25px;
        margin-right: 8px;
        user-select: none;
        flex-shrink: 0;
    }

    .checkbox-apple input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 50px;
        height: 25px;
        margin: 0;
        z-index: 2;
        cursor: pointer;
    }

    .checkbox-apple label {
        position: absolute;
        top: 0;
        left: 0;
        width: 50px;
        height: 25px;
        border-radius: 50px;
        background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .checkbox-apple label:after {
        content: '';
        position: absolute;
        top: 1px;
        left: 1px;
        width: 23px;
        height: 23px;
        border-radius: 50%;
        background-color: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .checkbox-apple input[type="checkbox"]:checked+label {
        background: linear-gradient(to bottom, #4cd964, #5de24e);
    }

    .checkbox-apple input[type="checkbox"]:checked+label:after {
        transform: translateX(25px);
    }

    .checkbox-apple label:hover {
        background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
    }

    .checkbox-apple label:hover:after {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }
</style>