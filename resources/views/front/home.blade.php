@extends('front.layout.app')

@section('main')
    @include('front.message')
    <!-- Hero Section -->
    <section class="section-hero d-flex align-items-center position-relative text-white"
        style="padding-top:120px; background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('{{ asset('assets/images/banner5.jpg') }}') center/cover no-repeat; min-height: 90vh;">
        <div class="container text-center">

            <!-- Heading -->
            <h1 class="display-3 fw-bold mb-3"
                style="background: linear-gradient(90deg, #4e54c8, #8f94fb); -webkit-background-clip: text; color: transparent;">
                Find Your Dream Job
            </h1>

            <!-- Subtitle -->
            <p class="lead text-light mb-4">Discover thousands of opportunities tailored just for you</p>

            <!-- Explore Button -->
            <a href="#search-section" class="btn btn-lg btn-outline-light mt-4 px-5 shadow rounded-pill">
                <i class="fas fa-briefcase me-2"></i> Explore Now
            </a>
        </div>
    </section>


    <!-- Search Section -->
    <section id="search-section" class="py-5 bg-light">
        <div class="container">
            <!-- Header -->
            <div class="text-center mt-5">
                <h2 class="fw-bold display-6">🔍 Find Your Dream Job</h2>
                <p class="text-muted">Search by keywords, location, or category to get started</p>
            </div>

            <!-- Search Box -->
            <div class="card border-0 shadow-lg rounded-4 p-4 bg-white search-box">
                <form action="{{ route('job') }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control" name="keywords" placeholder="Keywords">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control" name="location" placeholder="Location">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-select">
                                <option value="">Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" class="btn btn-outline-danger btn-lg">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>


    <!-- Popular Categories -->
    <section class="py-5 category-section bg-light" id="popular-categories">
        <div class="container">

            <!-- Section Title -->
            <div class="text-center mt-5">
                <h2 class="fw-bold display-6">🌟 Explore Popular Categories</h2>
                <p class="text-muted">Find jobs that suit your passion and career goals</p>
            </div>

            <!-- Category Cards -->
            <div class="row g-4">

                <!-- AI / Machine Learning Engineers -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="{{ route('job', ['category' => 1]) }}" class="text-decoration-none text-dark">

                        <div class="category-card text-center p-4 h-100">
                            <div class="icon-wrapper mb-3">
                                <i class="fa fa-robot"></i>

                            </div>
                            <h5 class="fw-bold">AI / Machine Learning Engineers</h5>
                            <p class="text-muted mb-0">{{ $aiJobCount ?? 0 }} Jobs</p>
                    </a>
                </div>
            </div>

            <!-- Data Scientists & Analysts -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="category-card text-center p-4 h-100">
                    <a href="{{ route('job', ['category' => 2]) }}" class="text-decoration-none text-dark">

                        <div class="icon-wrapper mb-3">
                            <i class="fa fa-database"></i>
                        </div>
                        <h5 class="fw-bold">Data Scientists & Analysts</h5>
                        <p class="text-muted mb-0">{{ $dataScienceJobCount ?? 0 }} Jobs</p>
                    </a>
                </div>
            </div>

            <!-- Cybersecurity Specialists -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="category-card text-center p-4 h-100">
                    <a href="{{ route('job', ['category' => 3]) }}" class="text-decoration-none text-dark">

                        <div class="icon-wrapper mb-3">
                            <i class="fa fa-shield-alt"></i>
                        </div>
                        <h5 class="fw-bold">Cybersecurity Specialists</h5>
                        <p class="text-muted mb-0">{{ $cyberSecurityJobCount ?? 0 }} Jobs</p>
                    </a>
                </div>
            </div>

            <!-- Cloud / IoT / Blockchain Architects -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="category-card text-center p-4 h-100">
                    <a href="{{ route('job', ['category' => 4]) }}" class="text-decoration-none text-dark">

                        <div class="icon-wrapper mb-3">
                            <i class="fa fa-cloud"></i>
                        </div>
                        <h5 class="fw-bold">Cloud / IoT / Blockchain Architects</h5>
                        <p class="text-muted mb-0">{{ $cloudJobCount ?? 0 }} Jobs</p>
                    </a>
                </div>
            </div>

            <!-- Healthcare & Medical Specialists -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="category-card text-center p-4 h-100">
                    <a href="{{ route('job', ['category' => 5]) }}" class="text-decoration-none text-dark">

                        <div class="icon-wrapper mb-3">
                            <i class="fa fa-stethoscope"></i>
                        </div>
                        <h5 class="fw-bold">Healthcare & Medical Specialists</h5>
                        <p class="text-muted mb-0">{{ $healthcareJobCount ?? 0 }} Jobs</p>
                    </a>
                </div>
            </div>

            <!-- Digital Marketing Professionals -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="category-card text-center p-4 h-100">
                    <a href="{{ route('job', ['category' => 6]) }}" class="text-decoration-none text-dark">

                        <div class="icon-wrapper mb-3">
                            <i class="fa fa-bullhorn"></i>
                        </div>
                        <h5 class="fw-bold">Digital Marketing Professionals</h5>
                        <p class="text-muted mb-0">{{ $DMJobCount ?? 0 }} Jobs</p>
                    </a>
                </div>
            </div>

            <!-- Construction & Infrastructure Engineers -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="category-card text-center p-4 h-100">
                    <a href="{{ route('job', ['category' => 7]) }}" class="text-decoration-none text-dark">

                        <div class="icon-wrapper mb-3">
                            <i class="fa fa-hard-hat"></i>
                        </div>
                        <h5 class="fw-bold">Construction & Infrastructure Engineers</h5>
                        <p class="text-muted mb-0">{{ $constructionJobCount ?? 0 }} Jobs</p>
                    </a>
                </div>
            </div>

            <!-- Financial Services & Investment Banking -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="category-card text-center p-4 h-100">
                    <a href="{{ route('job', ['category' => 8]) }}" class="text-decoration-none text-dark">

                        <div class="icon-wrapper mb-3">
                            <i class="fa fa-university"></i>
                        </div>
                        <h5 class="fw-bold">Financial Services & Investment Banking</h5>
                        <p class="text-muted mb-0">{{ $financeJobCount ?? 0 }} Jobs</p>
                    </a>
                </div>
            </div>

        </div>
        </div>

    </section>

    <!-- Featured Jobs -->
    <section class="py-5 bg-gradient text-white" id="featured-jobs"
        style="background: linear-gradient(135deg, #4e73df, #1cc88a);">
        <div class="container">
            <h2 class="fw-bold mt-5 text-center text-black">
                <i class="fa fa-fire text-warning me-2"></i> Featured <span class="text-success"> Jobs
            </h2>
            <div class="row g-4">
                @foreach ($featuredJob as $featured)
                    <div class="col-md-4">
                        <div class="job-glass-card h-100 p-4 rounded-4 shadow-sm d-flex flex-column justify-content-between">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-dark">{{$featured->title}}</h5>
                                <p class="text-muted small">{{ Str::words($featured->description, 12) }}</p>
                                <ul class="list-unstyled small text-secondary mt-3">
                                    <li class="mb-2"><i class="fa fa-map-marker text-danger me-2"></i>{{$featured->location}}
                                    </li>
                                    <li class="mb-2"><i class="fa fa-clock text-info me-2"></i>{{$featured->type->name}}</li>
                                    <li><i class="fa fa-usd text-success me-2"></i>{{$featured->salary}}</li>
                                </ul>
                                <a href="{{ route('account.jobOverview', $featured->id) }}"
                                    class="btn btn-outline-warning w-100 mt-3">View Details</a>
                            </div>
                            <div class="job-ribbon position-absolute top-0 end-0 bg-warning text-dark px-3 py-1 fw-bold">
                                Featured
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Latest Jobs -->
    <section class="py-5" id="latest-jobs" style="background:#eef3f8;">
        <div class="container">
            <h2 class="fw-bold mt-5 text-center text-dark">
                <i class="fa fa-rocket text-success me-2"></i> Latest <span class="text-success">Jobs</span>
            </h2>
            <div class="row g-4">
                @foreach ($latestJob as $latest)
                    <div class="col-md-4">
                        <div class="job-glass-card h-100 p-4 rounded-4 shadow-sm d-flex flex-column justify-content-between">

                            <!-- Job Header -->
                            <div>
                                <h5 class="fw-bold mb-2">{{$latest->title}}</h5>
                                <p class="text-muted small">{{ Str::words($latest->description, 15) }}</p>
                            </div>

                            <!-- Job Meta -->
                            <div class="mt-3 small text-secondary">
                                <p class="mb-1"><i class="fa fa-map-marker-alt text-danger me-2"></i>{{$latest->location}}</p>
                                <p class="mb-1"><i class="fa fa-clock text-info me-2"></i>{{$latest->type->name}}</p>
                                <p><i class="fa fa-rupee text-success me-2"></i>{{$latest->salary}}</p>
                            </div>

                            <!-- Action -->
                            <div class="mt-3">
                                <a href="{{ route('account.jobOverview', $latest->id) }}" class="btn btn-outline-warning w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 position-relative" style="background: linear-gradient(135deg, #f8faff, #e9f2ff);">
        <div class="container">
            <!-- Section Title -->
            <div class="text-center mt-5">
                <h2 class="fw-bold text-primary">
                    <i class="fa fa-globe me-2 text-info"></i> Our <span class="text-success">Services</span>
                </h2>
                <p class="text-muted">Connecting employers and job seekers with seamless solutions.</p>
            </div>
            <!-- Services Grid -->
            <div class="row g-4">
                <!-- Service 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-box p-4 text-center h-100">
                        <div class="icon-circle bg-success text-white mb-3 mx-auto">
                            <i class="bi bi-briefcase-fill fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Post a Job</h5>
                        <p class="text-muted">Easily publish job openings and connect with thousands of candidates
                            instantly.</p>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-box p-4 text-center h-100">
                        <div class="icon-circle bg-success text-white mb-3 mx-auto">
                            <i class="bi bi-person-check-fill fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Apply for Jobs</h5>
                        <p class="text-muted">Browse tailored opportunities and apply with ease, tracking your applications
                            anytime.</p>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-box p-4 text-center h-100">
                        <div class="icon-circle bg-warning text-white mb-3 mx-auto">
                            <i class="bi bi-star-fill fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Featured Jobs</h5>
                        <p class="text-muted">Highlight vacancies with our featured option for greater visibility and reach.
                        </p>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-box p-4 text-center h-100">
                        <div class="icon-circle bg-danger text-white mb-3 mx-auto">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Latest Jobs</h5>
                        <p class="text-muted">Stay updated with the freshest job opportunities available on our platform
                            daily.</p>
                    </div>
                </div>

                <!-- Service 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-box p-4 text-center h-100">
                        <div class="icon-circle bg-info text-white mb-3 mx-auto">
                            <i class="bi bi-bar-chart-fill fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Job Insights</h5>
                        <p class="text-muted">Get data-driven insights into market trends and candidate preferences.</p>
                    </div>
                </div>

                <!-- Service 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-box p-4 text-center h-100">
                        <div class="icon-circle bg-secondary text-white mb-3 mx-auto">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Networking</h5>
                        <p class="text-muted">Foster strong, lasting connections between employers and candidates.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5" style="background: linear-gradient(135deg, #e3f2fd, #ffffff);">
        <div class="container">
            <!-- Section Title -->

            <div class="text-center mt-5">
                <h2 class="fw-bold text-dark">
                    <i class="fa fa-paper-plane text-info me-2"></i> Let’s <span class="text-success">Connect
                </h2>
                <p class="text-muted">Have a question or idea? Reach out and we’ll respond quickly.</p>
            </div>

            <div class="row g-4">
                <!-- Contact Info -->
                <div class="col-lg-4">
                    <div class="p-4 shadow-lg rounded-4 h-100"
                        style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); border:1px solid #e0e0e0;">
                        <h5 class="fw-bold mb-4 text-primary">📍 Get in Touch</h5>

                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-box me-3 bg-danger text-white d-flex align-items-center justify-content-center rounded-circle"
                                style="width:125px;height:45px;">
                                <i class="fa fa-map-marker-alt"></i>
                            </div>
                            <p class="mb-0">
                                "Shree Kankai Krupa" Rokadiya Hanuman Road Prashant Pan Gali OPP. Charan Aie
                                Mandir Khapat Porbandar, India
                            </p>
                        </div>


                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box me-3 bg-success text-white d-flex align-items-center justify-content-center rounded-circle"
                                style="width:45px;height:45px;">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <p class="mb-0">bamaniamohit2@gmail.com</p>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3 bg-info text-white d-flex align-items-center justify-content-center rounded-circle"
                                style="width:45px;height:45px;">
                                <i class="fa fa-phone"></i>
                            </div>
                            <p class="mb-0">+91 9408488791</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="p-4 shadow-lg rounded-4 h-100"
                        style="background: linear-gradient(145deg, #ffffff, #f1f8ff); border:1px solid #e0e0e0;">
                        <h5 class="fw-bold mb-4 text-primary">📬 Send Us a Message</h5>
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="mb-1">Your Name</label>
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control rounded-3" id="name"
                                            placeholder="Your Name" required>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="mb-1">Your Email</label>
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control rounded-3" id="email"
                                            placeholder="Your Email" required>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="subject" class="mb-1">Subject</label>
                                    <div class="form-floating">
                                        <input type="text" name="subject" class="form-control rounded-3" id="subject"
                                            placeholder="Subject" required>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="message" class="mb-1">Your Message</label>
                                    <div class="form-floating">
                                        <textarea name="message" class="form-control rounded-3" placeholder="Your Message"
                                            id="message" style="height: 150px;" required></textarea>

                                    </div>
                                </div>
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                                        <i class="fa fa-paper-plane me-2"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<style>
    .card.job-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .service-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .service-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .section-hero {
        padding-top: 120px;
        /* Adjust this based on your header height */
    }

    /* Optional: make hero text vertically centered better */
    @media (min-width: 992px) {
        .section-hero .container {
            transform: translateY(20px);
            /* Adjust down if needed */
        }
    }

    #contact .form-control {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
    }

    #contact button {
        border-radius: 0.5rem;
        transition: 0.3s ease-in-out;
    }

    #contact button:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        transform: translateY(-2px);
    }

    .text-gradient {
        background: linear-gradient(90deg, #4f46e5, #9333ea);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Category Card */
    .category-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.2);
    }

    /* Icon Wrapper */
    .icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #9333ea);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: #fff;
        box-shadow: 0 4px 12px rgba(147, 51, 234, 0.3);
    }

    .job-card {
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .job-ribbon {
        border-bottom-left-radius: 10px;
        font-size: 0.85rem;
    }

    .hover-shadow:hover {
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
    }

    .service-box {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .service-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .service-box h5 {
        font-size: 1.2rem;
    }

    .btn-gradient {
        background: linear-gradient(90deg, #007bff, #00c6ff);
        color: #fff;
        border: none;
        transition: 0.3s;
    }

    .btn-gradient:hover {
        background: linear-gradient(90deg, #0056d2, #0096c7);
        color: #fff;
    }

    .category-card {
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        background: #fff;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .category-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        border-color: #2563eb;
    }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        line-height: 70px;
        background: #f1f5f9;
        border-radius: 50%;
        font-size: 28px;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        transition: background 0.3s, color 0.3s;
    }

    .category-card:hover .icon-wrapper {
        background: #2563eb;
        color: #fff;
    }

    .category-section h2 {
        font-size: 2.2rem;
        font-weight: 700;
    }

    .job-glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(200, 200, 200, 0.3);
        transition: all 0.3s ease;
    }

    .job-glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: #f0f5ff;
    }
</style>