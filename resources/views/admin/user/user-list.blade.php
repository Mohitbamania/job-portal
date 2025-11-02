@extends('admin.layout.app')

@section('main')

    <section class="section-5 bg-light">
        <!-- Breadcrumb -->
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="breadcrumb-box mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#">
                                <i class="fa fa-home me-2"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa-solid fa-user-group me-2"></i>Users</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-12">
                @include('front.message')

                <div class="card glass-card shadow-sm border-0 mb-4">
                    <div class="card-body card-form">

                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="page-title pl-10">
                                <i class="fa-solid fa-users"></i> User Management
                            </h3>
                            <a href="{{ route('admin.addUser') }}"
                                class="btn btn-primary btn-lg rounded-pill shadow-sm px-4">
                                <i class="fa fa-plus me-1"></i> Add User
                            </a>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-modern align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Mobile</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="text-center fw-semibold">{{ $user->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('profile_image/' . $user->image) }}"
                                                        class="rounded-circle border border-2 shadow-sm me-2"
                                                        style="width:50px; height:50px; object-fit:cover;">
                                                </div>
                                            </td>
                                            <td>{{$user->name}}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td class="text-center">
                                                <div class="action-buttons d-flex justify-content-center gap-1">
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.userEdit', $user->id) }}"
                                                        class="btn-action btn-edit" data-bs-toggle="tooltip" title="Edit User">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <button onclick="DeleteUser({{ $user->id }})" class="btn-action btn-delete"
                                                        data-bs-toggle="tooltip" title="Delete User">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('customJS')
    <script>
        function DeleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will permanently delete the user!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash"></i> Yes, Delete',
                cancelButtonText: '<i class="bi bi-x-circle"></i> Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.userDelete') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            user_id: id
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'The user has been deleted successfully.',
                                    confirmButtonColor: '#198754',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => location.reload());
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong while deleting the user.',
                                    confirmButtonColor: '#d33'
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'An unexpected error occurred. Please try again later.',
                                confirmButtonColor: '#d33'
                            });
                        }
                    });
                }
            });
        }

        $(document).ready(function () {
            $('#usersTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fa fa-copy"></i> Copy',
                        className: 'btn btn-sm btn-primary me-1'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa fa-file-csv"></i> CSV',
                        className: 'btn btn-sm btn-success me-1'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        className: 'btn btn-sm btn-success me-1'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-danger me-1'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        className: 'btn btn-sm btn-warning'
                    }
                ],
                paging: true,
                searching: true,
                ordering: true,
                order: [[0, 'asc']], // Default sorting on ID
                columnDefs: [
                    { orderable: false, targets: [1, 5] } // Disable sorting for Profile & Actions columns
                ]
            });
        });

    </script>
@endsection

<!-- Custom Styling -->
<style>
    /* Card Glassmorphism */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transition: all 0.35s ease-in-out;
    }

    .hover-card:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    }

    /* Gradient Button */
    .btn-gradient {
        background: linear-gradient(90deg, #2563eb, #1e3a8a);
        color: #fff;
        font-weight: 500;
        border-radius: 25px;
        transition: all 0.3s ease-in-out;
    }

    .btn-gradient:hover {
        opacity: 0.95;
        transform: translateY(-2px);
        color: #fff;
    }

    /* Table */
    .table thead th {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr:hover {
        background-color: #f9fbff;
    }

    .table-modern {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-modern thead tr {
        background: #f8f9fc;
        border-radius: 12px;
        overflow: hidden;
    }

    .table-modern thead th {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d;
        border: none !important;
        padding: 14px;
    }

    .table-modern tbody tr {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease-in-out;
    }

    .table-modern tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
    }

    .table-modern tbody td {
        padding: 16px;
        border-top: none !important;
        vertical-align: middle;
    }

    .data-table-card {
        max-width: 900px;
        /* match breadcrumb width */
        margin: 0 auto;
        /* center it */
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

    .add {
        color: blueviolet;
        background: whitesmoke;
        border: 2px solid blueviolet;
        transition: 0.2s ease-in-out;
        height: 40px;
    }

    .add:hover {

        transform: scale(1.05);
    }

    .btn-primary:hover {
        background-color: #3751ff;
        /* Darker shade on hover */
        transform: translateY(-3px);
        /* Slight lift effect */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        /* Bigger shadow on hover */
        transition: all 0.3s ease;
        /* Smooth transition */
    }

    .btn-primary:active,
    .btn-primary:focus {
        outline: none;
        transform: translateY(-1px);
        /* Slight press effect */
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .page-title {
        display: flex;
        align-items: center;
        font-family: 'Poppins', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #212529;
        position: relative;
        margin-bottom: 20px;
    }

    .page-title i {
        font-size: 2rem;
        color: #4e73df;
        /* Accent color */
        margin-right: 12px;
        transition: transform 0.3s ease;
    }

    /* Underline decoration */
    .page-title::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #4e73df, #1cc88a);
        border-radius: 2px;
    }

    /* DataTable Wrapper */
    div.dataTables_wrapper {
        font-family: 'Poppins', sans-serif;
        padding: 20px 10px;
    }

    /* Table Header */
    .table-modern thead th {
        background: linear-gradient(90deg, #2563eb, #1e40af);
        color: #fff !important;
        font-weight: 600;
        text-transform: uppercase;
        border: none !important;
        padding: 14px 18px;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
    }

    /* Table Rows */
    .table-modern tbody tr {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        margin-bottom: 8px;
        transition: all 0.2s ease-in-out;
    }

    .table-modern tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(37, 99, 235, 0.15);
    }

    /* Table Cells */
    .table-modern tbody td {
        padding: 14px 18px;
        vertical-align: middle;
        border-top: none !important;
    }

    /* Table Hover Highlight */
    .table-modern tbody tr:hover td {
        background: #f9fbff;
    }

    /* DataTables Search Box */
    .dataTables_filter input {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 6px 14px;
        font-size: 14px;
        margin-left: 8px;
        outline: none;
        transition: all 0.3s ease;
    }

    .dataTables_filter input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 6px rgba(37, 99, 235, 0.2);
    }

    /* DataTables Length Dropdown */
    .dataTables_length select {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 6px 10px;
        font-size: 14px;
        outline: none;
        margin: 0 6px;
        transition: all 0.3s ease;
    }

    .dataTables_length select:focus {
        border-color: #1e40af;
        box-shadow: 0 0 6px rgba(37, 99, 235, 0.2);
    }

    /* Pagination */
    .dataTables_paginate .paginate_button {
        background: #fff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 8px !important;
        margin: 0 4px !important;
        padding: 6px 12px !important;
        color: #374151 !important;
        transition: all 0.3s ease;
    }

    .dataTables_paginate .paginate_button:hover {
        background: #2563eb !important;
        color: #fff !important;
        border-color: #2563eb !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: #1e40af !important;
        color: #fff !important;
        font-weight: 600;
    }

    /* Export Buttons */
    .dt-buttons .btn {
        border-radius: 8px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        padding: 6px 14px !important;
        border: none !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, opacity 0.3s ease;
    }

    .dt-buttons .btn:hover {
        transform: translateY(-2px);
        opacity: 0.9;
    }

    /* Different Colors for Export Buttons */
    .dt-buttons .btn-primary {
        background: #2563eb !important;
        color: #fff !important;
    }

    .dt-buttons .btn-success {
        background: #16a34a !important;
        color: #fff !important;
    }

    .dt-buttons .btn-danger {
        background: #dc2626 !important;
        color: #fff !important;
    }

    .dt-buttons .btn-warning {
        background: #f59e0b !important;
        color: #fff !important;
    }

    /* Common styles for action buttons */
    .action-buttons .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 16px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    /* Edit button style */
    .btn-edit {
        background: #2563eb;
        /* blue */
    }

    .btn-edit:hover {
        background: #1e40af;
        /* darker blue */
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Delete button style */
    .btn-delete {
        background: #dc2626;
        /* red */
    }

    .btn-delete:hover {
        background: #b91c1c;
        /* darker red */
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>