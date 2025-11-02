@extends('front.layout.app')

@section('main')

    <section class="section-4 bg-2 mt-5">
        <div class="container pt-5 pb-3 py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3 bg-white shadow-sm">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('account.myJob')}}">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="container job_details_area">
            <div class="row pb-5">
                <!-- Job Details -->
                <div class="col-md-8">
                    @include('front.message')
                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        @if(Auth::check())
                            <!-- Job Details Header -->
                            <div class="job_details_header p-4 position-relative">
                                <div class="overlay"></div>
                                <form id="addToFav" name="favForm" action="{{route('job.addToFav')}}" method="POST">
                                    <input type="hidden" name="job_id" value="{{$job->id}}">
                                    @csrf
                                    <div class="d-flex justify-content-between align-items-start position-relative">
                                        <div>
                                            <h2 class="fw-bold text-white mb-2">{{$job->title}}</h2>
                                            <div class="d-flex flex-wrap small text-light">
                                                <span class="me-3"><i class="fa fa-map-marker"></i> {{$job->location}}</span>
                                                <span><i class="fa fa-clock-o"></i> {{$job->type->name}}</span>
                                            </div>
                                        </div>

                                        <!-- Heart/Favorite Button -->
                                        <button type="submit"
                                            class="btn-fav {{ auth()->user()->favourites->contains('job_id', $job->id) ? 'active' : '' }}">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <!-- Job Details Header -->
                            <div class="job_details_header p-4 position-relative">
                                <div class="overlay"></div>
                                <div class="d-flex justify-content-between align-items-start position-relative">
                                    <div>
                                        <h2 class="fw-bold text-white mb-2">{{$job->title}}</h2>
                                        <div class="d-flex flex-wrap small text-light">
                                            <span class="me-3"><i class="fa fa-map-marker"></i> {{$job->location}}</span>
                                            <span><i class="fa fa-clock-o"></i> {{$job->type->name}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Description -->
                        <div class="descript_wrap p-4 bg-white">
                            <div class="single_wrap">
                                <h4>Job description</h4>
                                <p>{{$job->description}}</p>
                            </div>

                            @if(!empty($job->responsibility))
                                <div class="single_wrap">
                                    <h4>Responsibility</h4>
                                    <p>{{$job->responsibility}}</p>
                                </div>
                            @endif

                            @if(!empty($job->qualification))
                                <div class="single_wrap">
                                    <h4>Qualifications</h4>
                                    <p>{{$job->qualification}}</p>
                                </div>
                            @endif

                            @if(!empty($job->benefits))
                                <div class="single_wrap">
                                    <h4>Benefits</h4>
                                    <p>{{$job->benefits}}</p>
                                </div>
                            @endif

                            <div class="border-bottom my-3"></div>

                            <!-- Buttons -->
                            <div class="pt-2 text-end">
                                @if(Auth::check())
                                    {{-- Save / Unsave --}}
                                    @if($isSaved)
                                        <a href="#" onclick="unSavedJob({{ $job->id }})"
                                            class="btn btn-outline rounded-pill px-4 me-2 shadow-sm"
                                            style="border-color:#dc3545;color:#dc3545;border:2px solid">
                                            Unsave
                                        </a>
                                    @else
                                        <a href="#" onclick="savedJob({{ $job->id }})"
                                            class="btn btn-outline rounded-pill px-4 me-2 shadow-sm"
                                            style="border-color:#0d6efd;color:#0d6efd;border:2px solid">
                                            Save
                                        </a>
                                    @endif

                                    {{-- Apply Button --}}
                                    @if($isApplied)
                                        <button class="btn btn-secondary rounded-pill px-4 me-2 shadow-sm" disabled>
                                            Already Applied
                                        </button>
                                    @else
                                        <a href="#" onclick="jobApply({{ $job->id }})"
                                            class="btn btn-outline rounded-pill px-4 me-2 shadow-sm"
                                            style="border-color:#0d6efd;color:#0d6efd;border:2px solid">
                                            Apply
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('account.login') }}"
                                        class="btn btn-outline rounded-pill px-4 me-2 shadow-sm"
                                        style="border-color:#0d6efd;color:#0d6efd;border:2px solid">
                                        Login to Apply
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Job Summary -->
                    <div class="glass_card mb-4">
                        <div class="p-4">
                            <h4 class="sidebar_title"><i class="fa fa-briefcase me-2"></i> Job Summary</h4>
                            <ul class="list-unstyled mt-3">
                                <li><strong>Published:</strong>
                                    {{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</li>
                                <li><strong>Vacancy:</strong> {{$job->vacancy}} Position</li>
                                <li><strong>Salary:</strong> {{$job->salary}}</li>
                                <li><strong>Location:</strong> {{$job->location}}</li>
                                <li><strong>Nature:</strong> {{$job->type->name}}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Company Details -->
                    <div class="glass_card">
                        <div class="p-4">
                            <h4 class="sidebar_title"><i class="fa fa-building me-2"></i> Company</h4>
                            <ul class="list-unstyled mt-3">
                                <li><strong>Name:</strong> {{$job->company_name}}</li>
                                <li><strong>Location:</strong> {{$job->company_location}}</li>
                                <li><strong>Website:</strong>
                                    <a href="{{$job->company_website}}" class="link"
                                        target="_blank">{{$job->company_website}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Sidebar -->
            </div>
        </div>
    </section>
@endsection

<!-- Custom Styles -->
<style>
    body {
        background: #f5f7fa;
        font-family: 'Inter', sans-serif;
    }

    /* Breadcrumb */
    .breadcrumb a {
        text-decoration: none;
        font-weight: 500;
        color: #0d6efd;
        transition: 0.3s;
    }

    .breadcrumb a:hover {
        color: #0a58ca;
    }

    /* Job Header */
    .job_details_header {
        background: linear-gradient(135deg, #4f46e5, #9333ea);
    }

    .job_details_header h4 {
        font-size: 1.6rem;
    }

    /* Sections */
    .descript_wrap {
        border-radius: 0 0 12px 12px;
    }

    .single_wrap h4 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        border-left: 4px solid #4f46e5;
        padding-left: 10px;
        margin-bottom: 8px;
    }

    .single_wrap p {
        color: #555;
        line-height: 1.6;
    }

    /* Sidebar */
    .job_sumary {
        background: #fff;
        border-radius: 12px;
    }

    .summery_header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #4f46e5;
        display: inline-block;
        padding-bottom: 5px;
    }

    .job_content ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    .job_content li {
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .job_content span {
        font-weight: 600;
        color: #4f46e5;
    }

    /* Buttons */
    .btn {
        font-weight: 500;
        padding: 8px 18px;
    }

    .btn-outline-primary {
        border: 2px solid #4f46e5;
        text-color: #4f46e5;
    }

    .btn-outline-primary:hover {
        background: #4f46e5;
        color: #fff;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4f46e5, #9333ea);
        color: #fff;
        border: none;
        transition: 0.3s;
    }

    .btn-gradient:hover {
        background: linear-gradient(135deg, #4338ca, #7e22ce);
    }

    /* Save Icon */
    .heart_mark i {
        font-size: 1.3rem;
        color: #fff;
        transition: 0.3s;
    }

    .heart_mark i:hover {
        color: #ff4d6d;
    }

    /* Job Header */
    .job_details_header {
        background: linear-gradient(135deg, #4f46e5, #9333ea);
        border-radius: 16px 16px 0 0;
        position: relative;
        overflow: hidden;
    }

    .job_details_header .overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(4px);
    }

    .job_details_header h2 {
        font-size: 1.8rem;
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.4);
    }

    .heart_mark i {
        font-size: 1.5rem;
        color: #fff;
        transition: 0.3s;
    }

    .heart_mark i:hover {
        color: #ff4d6d;
    }

    /* Glassmorphism Sidebar Cards */
    .glass_card {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 16px;
        backdrop-filter: blur(8px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .glass_card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
    }

    .sidebar_title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #4f46e5;
        border-left: 4px solid #9333ea;
        padding-left: 10px;
    }

    .glass_card ul li {
        margin-bottom: 8px;
        font-size: 0.95rem;
        color: #333;
    }

    .glass_card ul li strong {
        color: #111;
    }

    .link {

        color: black;
        transition: 0.2s ease-in-out
    }

    .link:hover {

        color: #0d6efd;
    }

    .btn-fav {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        border-radius: 50%;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #fff;
        font-size: 18px;
    }

    .btn-fav:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    /* Active (Favorited) State */
    .btn-fav.active {
        background: #fff;
        color: #e63946;
        /* Red heart */
        box-shadow: 0 4px 10px rgba(230, 57, 70, 0.4);
    }
</style>

@section('customJS')
    <script>
        function jobApply(id) {
            Swal.fire({
                title: 'Apply for this job?',
                text: "Are you sure you want to apply for this job?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e54c8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, apply!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('job.applyJob') }}',
                        type: "POST",
                        data: { id: id, _token: '{{ csrf_token() }}' },
                        datatype: "json",
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Applied!',
                                    text: 'You have successfully applied for the job.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Oops!',
                                    text: response.errors,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Server error occurred.', 'error');
                        }
                    });
                }
            });
        }

        function savedJob(id) {
            Swal.fire({
                title: 'Save this job?',
                text: "Are you sure you want to save this job?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e54c8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('job.savedJob') }}',
                        type: "POST",
                        data: { id: id, _token: '{{ csrf_token() }}' },
                        datatype: "json",
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Saved!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } Swal.fire({
                                title: 'Oops!',
                                text: response.errors,  // ✅ show backend error message here
                                icon: 'error'
                            });
                        },
                        error: function () {
                            Swal.fire('Error!', 'Server error occurred.', 'error');
                        }
                    });
                }
            });
        }

        function unSavedJob(id) {
            Swal.fire({
                title: 'Unsave this job?',
                text: "Are you sure you want to Unsave this job?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e54c8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Unsave it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('job.unSavedJob') }}',
                        type: "POST",
                        data: { id: id, _token: '{{ csrf_token() }}' },
                        datatype: "json",
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Unsaved!',
                                    text: 'Job has been Unsaved successfully.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Server error occurred.', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endsection