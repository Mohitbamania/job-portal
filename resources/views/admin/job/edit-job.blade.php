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
                                 <li class="breadcrumb-item"><a href="{{route('admin.jobList')}}" class="text-decoration-none"> <i class="fa-solid fa-briefcase me-2"></i>Job</a>
                    </li>
                            <li class="breadcrumb-item active">Edit Job</li>
                            </ol>
                        </nav>
                    </div>
              </div>

            

            <div class="row">

                <!-- Main Content -->
                <div class="col-12">
                    @include('front.message')

                    <form id="editJob" name="editJob" method="POST">
                        @csrf
                        <input type="hidden" name="edit_job_id" value="{{$job->id}}">

                        <div class="card border-0 shadow-lg rounded-4">

                            <div class="card-header card-header-unique d-flex align-items-center gap-3"
                                style="background-color: #28a745;">
                                <i class="fa-solid fa-briefcase text-white fs-4"></i>
                                <h4 class="mb-0 text-white"> Edit Job Details</h4>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body card-form p-4">
                                <div class="row">
                                     <h5 class="fw-bold text-secondary mb-3">Job Details</h5>
                                    <div class="col-md-6 mb-4">
                                        <label for="title" class="mb-2 fw-semibold">Title <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                               value="{{$job->title}}" class="form-control shadow-sm">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="user" class="mb-2 fw-semibold">User <span class="text-danger">*</span></label>
                                        <select name="user" id="user" class="form-select shadow-sm">
                                            <option value="">Select a user</option>
                                            @foreach($users as $user)
                                                <option {{($user->id == $job->user_id) ? 'selected' : ''}}
                                                    value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="category" class="mb-2 fw-semibold">Category <span class="text-danger">*</span></label>
                                        <select name="category" id="category" class="form-select shadow-sm">
                                            <option value="">Select a Category</option>
                                            @foreach($jobCategories as $category)
                                                <option {{($category->id == $job->job_category_id) ? 'selected' : ''}}
                                                    value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="jobType" class="mb-2 fw-semibold">Job Nature <span class="text-danger">*</span></label>
                                        <select name="jobType" id="jobType" class="form-select shadow-sm">
                                            <option value="">Select Job Nature</option>
                                            @foreach($jobTypes as $type)
                                                <option {{($job->job_type_id == $type->id) ? 'selected' : ''}}
                                                    value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="vacancy" class="mb-2 fw-semibold">Vacancy <span class="text-danger">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy"
                                               value="{{$job->vacancy}}" class="form-control shadow-sm">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="salary" class="mb-2 fw-semibold">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                               value="{{$job->salary}}" class="form-control shadow-sm">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="location" class="mb-2 fw-semibold">Location <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Location" id="location" name="location"
                                           value="{{$job->location}}" class="form-control shadow-sm">
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="mb-2 fw-semibold">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control shadow-sm" name="description" id="description" rows="4"
                                              placeholder="Description">{!! $job->description !!}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="benefits" class="mb-2 fw-semibold">Benefits</label>
                                    <textarea class="form-control shadow-sm" name="benefits" id="benefits" rows="3"
                                              placeholder="Benefits">{{$job->benefits}}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="responsibility" class="mb-2 fw-semibold">Responsibility</label>
                                    <textarea class="form-control shadow-sm" name="responsibility" id="responsibility" rows="3"
                                              placeholder="Responsibility">{{$job->responsibility}}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="qualifications" class="mb-2 fw-semibold">Qualifications</label>
                                    <textarea class="form-control shadow-sm" name="qualifications" id="qualifications" rows="3"
                                              placeholder="Qualifications">{{$job->qualification}}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="keywords" class="mb-2 fw-semibold">Keywords</label>
                                    <input type="text" placeholder="Keywords" id="keywords" name="keywords"
                                           value="{{$job->keywords}}" class="form-control shadow-sm">
                                </div>

                                <div class="mb-4">
                                    <label for="experience" class="mb-2 fw-semibold">Experience</label>
                                    <select name="experience" id="experience" class="form-select shadow-sm">
                                        <option value="">Select Experience</option>
                                        @for($i=1; $i<=10; $i++)
                                            <option value="{{$i}}" {{($job->experience == $i) ? 'selected' : ''}}>{{$i}} Year</option>
                                        @endfor
                                        <option value="10_plus" {{($job->experience == '10_plus') ? 'selected' : ''}}>10+ Years</option>
                                    </select>
                                </div>

                               <div class="mb-4 d-flex align-items-center" style="
    padding-left: 0px;
">
                                    <div class="checkbox-apple me-2">
                                        <input type="checkbox" id="is_featured" name="is_featured"
                                            class="yep" {{ $job->isFeatured == 1 ? 'checked' : '' }}>
                                        <label for="is_featured"></label>
                                    </div>
                                    <label for="is_featured" class="form-check-label fw-semibold mb-0">Is Featured</label>
                                </div>


                                <h5 class="fw-bold text-secondary mt-5 pt-4 border-top">Company Details</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="company_name" class="mb-2 fw-semibold">Company Name <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name" name="company_name"
                                               value="{{$job->company_name}}" class="form-control shadow-sm">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="company_location" class="mb-2 fw-semibold">Company Location</label>
                                        <input type="text" placeholder="Location" id="company_location" name="company_location"
                                               value="{{$job->company_location}}" class="form-control shadow-sm">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="website" class="mb-2 fw-semibold">Website</label>
                                    <input type="text" placeholder="Website" id="website" name="website"
                                           value="{{$job->company_website}}" class="form-control shadow-sm">
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer bg-light p-4 text-start">
                                <button type="submit" class="btn btn-success px-4 shadow-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Update Job
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
    <script type="text/javascript">
       $('#editJob').submit(function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: '{{ route('admin.jobUpdate') }}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Job Updated!',
                    text: 'The job has been updated successfully.',
                    confirmButtonColor: '#198754',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('admin.jobList') }}";
                });
            } else if (response.errors) {
                handleEditValidationErrors(response.errors);
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                handleEditValidationErrors(xhr.responseJSON.errors);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: 'Something went wrong while updating the job.',
                    confirmButtonColor: '#d33'
                });
            }
        }
    });
});

// ✅ Show inline validation errors for Edit
function handleEditValidationErrors(errors) {
    // Clear old errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    // Loop through validation errors
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

.checkbox-apple input[type="checkbox"]:checked + label {
  background: linear-gradient(to bottom, #4cd964, #5de24e);
}

.checkbox-apple input[type="checkbox"]:checked + label:after {
  transform: translateX(25px);
}

.checkbox-apple label:hover {
  background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
}

.checkbox-apple label:hover:after {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

</style>
