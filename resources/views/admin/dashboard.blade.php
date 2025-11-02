@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('main')
    @include('front.message')
    <!-- Breadcrumb -->
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-box mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="fa fa-home me-2"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active"><i class="fa-solid fa-tachometer-alt-fast me-2"></i>Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Users -->
        <div class="col-xl-4 col-md-6">
            <a href="{{route('admin.userList')}}" style="text-decoration: none">
                <div class="stat-card">
                    <div class="stat-icon bg-gradient-blue">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <div class="stat-info">
                        <h6>Total Users</h6>
                        <h2>{{ $usersCount ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>


        <!-- Active Jobs -->
        <div class="col-xl-4 col-md-6">
            <a href="{{route('admin.jobList')}}" style="text-decoration: none">
                <div class="stat-card">
                    <div class="stat-icon bg-gradient-green">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div class="stat-info">
                        <h6>Active Jobs</h6>
                        <h2>{{ $jobsCount ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>


        <!-- Applications -->
        <div class="col-xl-4 col-md-6">
            <a href="{{route('admin.jobApplicationList')}}" style="text-decoration: none">
                <div class="stat-card">
                    <div class="stat-icon bg-gradient-yellow">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div class="stat-info">
                        <h6>Applications</h6>
                        <h2>{{ $jobApplicationsCount ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="fa-solid fa-users me-2 text-primary"></i>Recent Users
                    </h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-striped table-bordered mb-0">
                            <thead class="table-light">
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Designation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr style="text-align: center;">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile ?? '—' }}</td>
                                        <td>{{ $user->designation ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Applications Table -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="fa-solid fa-briefcase me-2 text-success"></i>Recent Job Applications
                    </h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-striped table-bordered mb-0">
                            <thead class="table-light">
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Employer</th>
                                    <th>Applied Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobApplication as $index => $app)
                                    <tr style="text-align: center;">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $app->user->name ?? '—' }}</td>
                                        <td>{{ $app->employe->name ?? '—' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($app->applied_date)->format('d M Y, h:i A') }}</td>
                                        <td>
                                            @php
                                                $status = trim(strtolower($app->status));
                                                $statusColor = match ($status) {
                                                    'pending' => 'warning',
                                                    'rejected' => 'danger',
                                                    'approved' => 'primary',
                                                    default => 'secondary',
                                                };
                                            @endphp

                                            <span class="badge bg-{{ $statusColor }} text-uppercase">
                                                {{ ucfirst($status) }}
                                            </span>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No job applications found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')



@endsection

<style>
    /* Stats Cards */
    .stats-card {
        transition: transform 0.3s ease;
    }

    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        font-size: 22px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Brand Themed Gradients */
    .bg-brand-blue {
        background: linear-gradient(135deg, #2563eb, #1e3a8a);
    }

    .bg-brand-green {
        background: linear-gradient(135deg, #22c55e, #15803d);
    }

    .bg-brand-yellow {
        background: linear-gradient(135deg, #facc15, #eab308);
        color: #111;
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

    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border-radius: 50px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transition: all 0.35s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    /* Hover Lift & Glow */
    .hover-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
    }

    .hover-card::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at top left, rgba(0, 123, 255, 0.1), transparent 70%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .hover-card:hover::before {
        opacity: 1;
    }

    /* Icon Box */
    .icon-box {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        font-size: 28px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.4s ease, box-shadow 0.3s ease;
    }

    .icon-box:hover {
        transform: rotate(8deg) scale(1.1);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Brand Colors */
    .bg-brand-blue {
        background: linear-gradient(135deg, #2563eb, #1e3a8a);
    }

    .bg-brand-green {
        background: linear-gradient(135deg, #10b981, #047857);
    }

    .bg-brand-yellow {
        background: linear-gradient(135deg, #f59e0b, #b45309);
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 18px;
        background: #ffffff;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 8px 8px 18px rgba(0, 0, 0, 0.08),
            -6px -6px 14px rgba(255, 255, 255, 0.9);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        transition: transform 0.4s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1);
    }

    .stat-info h6 {
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
        /* Gray */
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-info h2 {
        font-size: 30px;
        font-weight: 800;
        color: #111827;
        /* Dark Gray */
        margin: 0;
    }

    /* Gradients */
    .bg-gradient-blue {
        background: linear-gradient(135deg, #2563eb, #1e3a8a);
    }

    .bg-gradient-green {
        background: linear-gradient(135deg, #22c55e, #15803d);
    }

    .bg-gradient-yellow {
        background: linear-gradient(135deg, #facc15, #eab308);
        color: #111;
    }

    .card-body {
        min-height: 350px;
    }
</style>