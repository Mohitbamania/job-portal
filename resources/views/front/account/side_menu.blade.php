<div class="card profile-card border-0 text-center p-4 mb-4">
    <!-- Profile Image -->
    <div class="profile-image mb-3 position-relative d-inline-block">
        @if(Auth::user()->image)
            <img src="{{ asset('profile_image/' . Auth::user()->image) }}" class="rounded-circle profile-img shadow">
        @else
            <img src="{{ asset('assets/images/avatar7.png') }}" class="rounded-circle profile-img shadow">
        @endif
        <!-- Small camera icon overlay -->
        <button data-bs-toggle="modal" data-bs-target="#updateProfileImage" class="camera-btn">
            <i class="fa-solid fa-camera"></i>
        </button>
    </div>

    <!-- User Info -->
    <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
    <p class="text-muted small mb-2">{{ Auth::user()->designation ?? 'No Designation' }}</p>

    <!-- Change Picture Button -->
    <button data-bs-toggle="modal" data-bs-target="#updateProfileImage"
        class="btn btn-gradient btn-sm rounded-pill px-3">
        <i class="fa-solid fa-pen me-1"></i> Edit Profile
    </button>
</div>


<!-- Navigation Menu -->
<div class="sidebar glass-nav">
    <div class="list-group list-group-flush">
        <a href="{{ route('account.profile') }}" class="list-group-item">
            <span class="icon"><i class="fa fa-user"></i></span>
            <span class="text">Account Settings</span>
        </a>
        <a href="{{ route('account.createJob') }}" class="list-group-item">
            <span class="icon"><i class="fa-solid fa-briefcase"></i></span>
            <span class="text">Post a Job</span>
        </a>
        <a href="{{ route('account.myJob') }}" class="list-group-item">
            <span class="icon"><i class="fa-solid fa-list"></i></span>
            <span class="text">My Jobs</span>
        </a>
        <a href="{{ route('job.appliedJob') }}" class="list-group-item">
            <span class="icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="text">Jobs Applied</span>
        </a>
        <a href="{{ route('job.candidate') }}" class="list-group-item">
            <span class="icon"><i class="fa-solid fa-user-tie"></i></span>
            <span class="text">Applicants</span>
        </a>
        <a href="{{ route('job.saveJob') }}" class="list-group-item">
            <span class="icon"><i class="fa-solid fa-heart"></i></span>
            <span class="text">Saved Jobs</span>
        </a>
        <a href="{{ route('account.logout') }}" class="list-group-item logout">
            <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
            <span class="text">Logout</span>
        </a>
    </div>
</div>

<style>
    /* Profile Card */
    .profile-card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .profile-card img {
        border-color: #6f42c1 !important;
    }

    .custom-btn {
        border-color: #6f42c1 !important;
        color: #6f42c1 !important;
    }

    .custom-btn:hover {
        background: #6f42c1;
        color: #fff !important;
    }

    /* Sidebar Glass Style */
    .glass-nav {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(14px);
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    .list-group-item {
        border: none;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        color: #333;
        background: transparent;
        transition: all 0.3s ease;
    }

    .list-group-item .icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: #6f42c1;
        border-radius: 10px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    /* Hover effect */
    .list-group-item:hover {
        background: linear-gradient(90deg, #f0e9ff, #f5f2ff);
        color: #6f42c1;
        transform: translateX(6px);
    }

    .list-group-item:hover .icon {
        background: #6f42c1;
        color: #fff;
    }

    /* Active State */
    .list-group-item.active {
        background: linear-gradient(90deg, #6f42c1, #5a32a3);
        color: #fff !important;
        font-weight: 600;
    }

    .list-group-item.active .icon {
        background: #fff;
        color: #5a32a3;
    }

    /* Logout Special */
    .list-group-item.logout {
        color: #d9534f;
    }

    .list-group-item.logout .icon {
        background: #fdecea;
        color: #d9534f;
    }

    .list-group-item.logout:hover {
        background: #fdecea;
        color: #c9302c;
    }

    .profile-card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(14px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    }

    /* Profile Image */
    .profile-img {
        width: 140px;
        height: 140px;
        border: 4px solid #6f42c1;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .profile-img:hover {
        border-color: #5a32a3;
    }

    /* Small floating camera button */
    .camera-btn {
        position: absolute;
        bottom: 6px;
        right: 6px;
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 50%;
        background: linear-gradient(135deg, #6f42c1, #5a32a3);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .camera-btn:hover {
        transform: scale(1.1);
        background: linear-gradient(135deg, #5a32a3, #6f42c1);
    }

    /* Gradient Button */
    .btn-gradient {
        background: linear-gradient(135deg, #6f42c1, #5a32a3);
        border: none;
        color: #fff;
        transition: all 0.3s ease;
    }
</style>