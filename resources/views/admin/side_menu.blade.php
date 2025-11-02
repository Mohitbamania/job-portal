@php
    $permissions = json_decode(auth()->user()->page_permission ?? '[]', true);
@endphp

<div class="admin-sidebar" id="adminSidebar">
    <!-- Toggle Button -->
    <div class="sidebar-toggle" id="sidebarToggle">
        <i class="fa-solid fa-bars"></i>
    </div>

    <!-- Scrollable Menu Wrapper -->
    <div class="sidebar-scroll">
        <div class="sidebar-menu">

            {{-- ===================== Dashboard ===================== --}}
            <div class="sidebar-section">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-tachometer-alt-fast"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            {{-- ===================== User Management ===================== --}}
            @if(in_array('users', $permissions))
                <div class="sidebar-section">
                    <div class="sidebar-title title-user">User Management</div>
                    <a href="{{ route('admin.userList') }}"
                        class="sidebar-link {{ request()->routeIs('admin.userList') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-group"></i>
                        <span>Users</span>
                    </a>
                </div>
            @endif

            {{-- ===================== Job Management ===================== --}}
            @if(in_array('job_categories', $permissions) || in_array('job_types', $permissions) || in_array('jobs', $permissions) || in_array('job_applications', $permissions))
                <div class="sidebar-section">
                    <div class="sidebar-section">
                        <div class="sidebar-title title-job">Job Management</div>
                        <!-- Job links -->
                    </div>

                    @if(in_array('job_categories', $permissions))
                        <a href="{{ route('admin.jobCategoryList') }}"
                            class="sidebar-link {{ request()->routeIs('admin.jobCategoryList') ? 'active' : '' }}">
                            <i class="fa-solid fa-layer-group"></i> <span>Job Categories</span>
                        </a>
                    @endif

                    @if(in_array('job_types', $permissions))
                        <a href="{{ route('admin.jobTypeList') }}"
                            class="sidebar-link {{ request()->routeIs('admin.jobTypeList') ? 'active' : '' }}">
                            <i class="fa-solid fa-tags"></i> <span>Job Types</span>
                        </a>
                    @endif

                    @if(in_array('jobs', $permissions))
                        <a href="{{ route('admin.jobList') }}"
                            class="sidebar-link {{ request()->routeIs('admin.jobList') ? 'active' : '' }}">
                            <i class="fa-solid fa-briefcase"></i> <span>Jobs</span>
                        </a>
                    @endif

                    @if(in_array('job_applications', $permissions))
                        <a href="{{ route('admin.jobApplicationList') }}"
                            class="sidebar-link {{ request()->routeIs('admin.jobApplicationList') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-invoice"></i> <span>Job Applications</span>
                        </a>
                    @endif
                </div>
            @endif

            {{-- ===================== Admin & Roles ===================== --}}
            @if(in_array('admins_roles', $permissions))
                <div class="sidebar-section">
                    <div class="sidebar-section">
                        <div class="sidebar-title title-admin">Admin Management</div>
                    </div>
                    <a href="{{ route('admin.adminsRoles') }}"
                        class="sidebar-link {{ request()->routeIs('admin.adminsRoles') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-shield"></i> <span>Admins & Roles</span>
                    </a>
                </div>
            @endif

            {{-- ===================== Settings ===================== --}}
            @if(in_array('setting', $permissions))
                <div class="sidebar-section">
                    <div class="sidebar-section">
                        <div class="sidebar-title title-settings">Settings</div>
                    </div>
                    <a href="{{ route('admin.settings') }}"
                        class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear"></i> <span>General Settings</span>
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>


<style>
    .admin-sidebar {
        position: fixed;
        top: 70px;
        left: 0;
        width: 250px;
        height: calc(100vh - 70px);
        background: #111827;
        color: #94a3b8;
        padding: 15px 0;
        display: flex;
        flex-direction: column;
        z-index: 1100;
        transition: all 0.3s ease-in-out;
        box-shadow: 4px 0 12px rgba(0, 0, 0, 0.2);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Collapsed */
    .admin-sidebar.collapsed {
        width: 70px;
    }

    .admin-sidebar.collapsed .sidebar-link span {
        display: none;
    }

    .admin-sidebar.collapsed .sidebar-link {
        justify-content: center;
        padding: 12px;
    }

    .admin-sidebar.collapsed .sidebar-title {
        display: none;
    }

    .sidebar-toggle {
        text-align: right;
        padding: 8px 15px;
        cursor: pointer;
        color: #fff;
    }

    .sidebar-menu {
        display: flex;
        flex-direction: column;
        padding: 10px 0;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #94a3b8;
        border-radius: 10px;
        padding: 12px 18px;
        margin: 6px 12px;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
    }

    .sidebar-link i {
        font-size: 16px;
        width: 22px;
        text-align: center;
        color: #64748b;
        transition: color 0.3s ease;
    }

    .sidebar-link:hover {
        background: #1e293b;
        color: #fff;
        transform: translateX(6px);
        box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.15);
    }

    .sidebar-link:hover i {
        color: #22c55e;
    }

    .sidebar-link.active {
        background: linear-gradient(90deg, #2563eb, #1e3a8a);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(37, 99, 235, 0.3);
    }

    .sidebar-link.active i {
        color: #fff;
    }

    body {
        padding-left: 250px;
        padding-top: 70px;
        background: #f8fafc;
        transition: padding-left 0.3s ease;
    }

    body.sidebar-collapsed {
        padding-left: 70px;
    }

    .sidebar-section {
        margin-top: 15px;
    }

    .sidebar-title {
        font-size: 13px;
        text-transform: uppercase;
        font-weight: 600;
        color: #64748b;
        padding: 6px 20px;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
        opacity: 0.7;
        border-left: 3px solid #334155;
    }

    /* Scrollable area for menu */
    .sidebar-scroll {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding-bottom: 20px;
    }

    /* Smooth scrollbar styling */
    .sidebar-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    .sidebar-scroll:hover::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
    }

    .sidebar-title.title-main {
        color: #3b82f6;
        /* Blue */
        border-left-color: #2563eb;
    }

    .sidebar-title.title-user {
        color: #10b981;
        /* Green */
        border-left-color: #059669;
    }

    .sidebar-title.title-job {
        color: #f59e0b;
        /* Amber */
        border-left-color: #d97706;
    }

    .sidebar-title.title-admin {
        color: #8b5cf6;
        /* Purple */
        border-left-color: #7c3aed;
    }

    .sidebar-title.title-settings {
        color: #ef4444;
        /* Red */
        border-left-color: #dc2626;
    }
</style>

<script>
    const sidebar = document.getElementById("adminSidebar");
    const toggleBtn = document.getElementById("sidebarToggle");
    const body = document.body;

    toggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("collapsed");
        body.classList.toggle("sidebar-collapsed");
    });
</script>