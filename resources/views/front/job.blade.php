@extends('front.layout.app')

@section('main')
    <section class="section-3 py-8" style="background: #f5f7fa;">
        <div class="container">
            <!-- Header -->
            <div
                class="row align-items-center mb-5 bg-white shadow-lg rounded-4 px-4 py-4 border-0 position-relative overflow-hidden">

                <!-- Decorative Gradient Circle -->
                <div class="position-absolute top-0 start-0 translate-middle opacity-10"
                    style="width: 150px; height: 150px; background: radial-gradient(circle, #667eea, #764ba2); border-radius: 50%;">
                </div>

                <!-- Left Side -->
                <div class="col-md-8 d-flex align-items-start gap-3">
                    <!-- Badge -->
                    <div>
                        <span class="badge rounded-pill px-3 py-8row shadow-sm"
                            style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-rocket me-1"></i> Career Vibe
                        </span>
                    </div>

                    <!-- Title & Subtitle -->
                    <div>
                        <h2 class="fw-bold mb-2"
                            style="background: linear-gradient(90deg, #667eea, #764ba2); -webkit-background-clip: text; color: transparent; font-size: 2rem;">
                            Find Your Dream Job 🚀
                        </h2>
                        <p class="text-muted mb-0 small">Explore opportunities, grow your career, and achieve your goals.
                        </p>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-md-4 mt-3 mt-md-0">
                    <form action="" id="sortJob">
                        <div class="d-flex align-items-center justify-content-md-end gap-3 bg-white shadow px-3 py-2 rounded-pill border border-2"
                            style="background: linear-gradient(135deg, #f9f9ff, #ffffff);">
                            <label for="sort" class="fw-semibold text-dark mb-0 d-flex align-items-center">
                                <i class="fas fa-sliders-h me-2 text-primary"></i>
                                <span>Sort</span>
                            </label>
                            <select name="sort" id="sort"
                                class="form-select border-0 bg-transparent shadow-none fw-semibold text-secondary rounded-pill"
                                style="max-width: 210px; font-size: 0.9rem;">
                                <option value="">✨ Select Option</option>
                                <option value="latest">📅 Latest Jobs</option>
                                <option value="oldest">🕒 Oldest First</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>



            <div class="row">
                <!-- Sidebar Filter -->
                <div class="col-lg-3 mb-4">
                    <form action="" id="searchForm">
                        <div class="card shadow border-0 rounded-10">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3 text-primary">Search Filters</h5>

                                <div class="mb-3">
                                    <input type="text" name="keywords" id="keywords"
                                        class="form-control shadow-sm rounded-pill" placeholder="Keywords">
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="location" id="location"
                                        class="form-control shadow-sm rounded-pill" placeholder="Location">
                                </div>

                                <div class="mb-3">

                                    <select name="category" id="category" class="form-select shadow-sm rounded-pill">
                                        <option value="">Select Category</option>
                                        @foreach ($jobCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Job Type</label>
                                    <div class="ps-2">
                                        @foreach ($jobTypes as $type)
                                            <div class="form-check mb-1">
                                                <input class="form-check-input" name="job_type" type="checkbox"
                                                    value="{{ $type->id }}" id="job-type-{{ $type->id }}">
                                                <label class="form-check-label"
                                                    for="job-type-{{ $type->id }}">{{ $type->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <select name="experience" id="experience" class="form-select shadow-sm rounded-pill">
                                        <option value="">Any Experience</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }} Year{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                        <option value="10+">10+ Years</option>
                                    </select>
                                </div>

                                <button class="btn btn-outline-success w-100 mt-3 shadow-sm" type="submit">
                                    <i class="fa fa-search me-2"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Job Listings -->
                <div class="col-lg-9">
                    <div class="row g-4">
                        @forelse ($jobs as $job)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden job-card">

                                    <!-- Card Header with Job Category -->
                                    <div class="card-header bg-light d-flex align-items-center border-0">
                                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                                            <i class="bi bi-briefcase-fill me-2"></i> {{ $job->category->name }}
                                        </span>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body d-flex flex-column p-4">
                                        <h5 class="fw-bold text-dark mb-2">{{ $job->title }}</h5>
                                        <p class="text-muted small mb-3">{{ Str::words($job->description, 14) }}</p>

                                        <!-- Job Info -->
                                        <ul class="list-unstyled small text-secondary flex-grow-1">
                                            <li class="mb-2"><i
                                                    class="fa fa-map-marker-alt text-danger me-2"></i>{{ $job->location }}</li>
                                            <li class="mb-2"><i class="fa fa-clock text-info me-2"></i>{{ $job->type->name }}
                                            </li>
                                            <li class="mb-2"><i class="fa fa-briefcase text-warning me-2"></i>Exp:
                                                {{ $job->experience }}
                                            </li>
                                            <li class="mb-2"><i
                                                    class="fa fa-rupee-sign text-success me-2"></i>{{ $job->salary }}</li>
                                        </ul>

                                        <!-- Action Button -->
                                        <a href="{{ route('account.jobOverview', $job->id) }}"
                                            class="btn btn-outline-warning w-100 mt-auto rounded-3 fw-semibold">
                                            <i class="fa fa-eye me-2"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center">No jobs found matching your criteria.</div>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
    </section>
@endsection

@section('customJS')
    <script>
        $("#searchForm").submit(function (e) {
            e.preventDefault();
            let url = '{{ route('job') }}?';
            let keywords = $('#keywords').val();
            let location = $('#location').val();
            let category = $('#category').val();
            let experience = $('#experience').val();

            let checkJobType = $("input:checkbox[name='job_type']:checked").map(function () {
                return $(this).val();
            }).get();

            if (keywords) url += '&keywords=' + encodeURIComponent(keywords);
            if (location) url += '&location=' + encodeURIComponent(location);
            if (category) url += '&category=' + category;
            if (experience) url += '&experience=' + experience;
            if (checkJobType.length > 0) url += '&jobType=' + checkJobType.join(',');

            window.location.href = url;
        });
    </script>
    <script>
        $('#sort').change(function () {

            let url = '{{ route('job') }}?';
            let sort = $('#sort').val();
            if (sort) url += '&sort=' + sort;
            window.location.href = url;
        });
    </script>

    <style>
        /* Gradient buttons */
        .btn-gradient {
            background: linear-gradient(90deg, #4e54c8, #8f94fb);
            color: white;
            border: none;
            transition: 0.3s;
        }

        .btn-gradient:hover {
            background: linear-gradient(90deg, #8f94fb, #4e54c8);
            color: white;
        }

        /* Job cards hover effect */
        .job-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* Rounded inputs */
        .form-control,
        .form-select {
            border-radius: 50px !important;
        }

        /* Text gradient header */
        .text-gradient {
            font-size: 2rem;
        }

        /* Subtle shadows for filter card */
        .card-body {
            background: #ffffff;
            border-radius: 1rem;
        }

        .section-3 {
            padding-top: 120px;
            /* Push down content to avoid header overlap */
            padding-bottom: 50px;
        }
    </style>
@endsection