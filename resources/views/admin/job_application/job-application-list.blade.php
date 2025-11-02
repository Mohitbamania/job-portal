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
                        <li class="breadcrumb-item active"><i class="fa-solid fa-file-invoice me-2"></i>Job Application</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body card-form">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="page-title">
                                <i class="fa fa-file-alt me-2"></i> Jobs Apploications
                            </h3>
                            <a href="{{ route('admin.addJobApplication') }}"
                                class="btn btn-primary btn-lg rounded-pill shadow-sm px-4">
                                <i class="fa fa-plus me-1"></i> Add Job Application
                            </a>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="jobApplicationTable" class="table table-modern align-middle mb-0">
                                <thead class="bg-light text-secondary small text-uppercase">
                                    <tr>
                                        <th scope="col">#ID</th>
                                        <th scope="col">Job Title</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Employee</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jobApplications as $application)
                                        <tr>
                                            <td class="fw-medium text-primary">{{ $application->id }}</td>
                                            <td>{{ $application->jobDetail->title }}</td>
                                            <td>{{ $application->user?->name ?? 'N/A' }}</td>
                                            <td>{{ $application->employe->name }}</td>
                                            <td>{{ $application->status }}</td>
                                            <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">

                                                    <!-- Edit Application -->
                                                    <a href="{{ route('admin.jobApplicationEdit', $application->id) }}"
                                                        class="btn-action btn-edit" data-bs-toggle="tooltip"
                                                        title="Edit Application">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>

                                                    <!-- Delete Application -->
                                                    <button onclick="DeleteJobApplication({{ $application->id }})"
                                                        class="btn-action btn-delete" data-bs-toggle="tooltip"
                                                        title="Delete Application">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>

                                                    <!-- Notify Dropdown -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn-action btn-notify dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                            title="Send Notification">
                                                            <i class="fa-solid fa-bell"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                    onclick="approveCandidate({{ $application->id }})">
                                                                    <i class="fa-solid fa-circle-check text-success me-2"></i>
                                                                    Accept
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                    onclick="rejectCandidate({{ $application->id }})">
                                                                    <i class="fa-solid fa-circle-xmark text-danger me-2"></i>
                                                                    Reject
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fa fa-folder-open fa-2x mb-2"></i>
                                                <div>No job applications found</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $jobApplications->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJS')
    <script>
        function DeleteJobApplication(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the job application!",
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
                        url: '{{ route('admin.jobApplicationDelete') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            job_application_id: id
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'The job application has been deleted successfully.',
                                    confirmButtonColor: '#198754',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong while deleting the job application.',
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
            $('#jobApplicationTable').DataTable({
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
                order: [[0, 'asc']], // default sort on ID
                columnDefs: [
                    { orderable: false, targets: [2] } // disable sorting for Actions column
                ]
            });
        });

        function approveCandidate(id) {
            Swal.fire({
                title: 'Approve Candidate?',
                text: "This candidate will be approved for interview.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.approveCandidate') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            job_application_id: id
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Approved!',
                                    text: 'The candidate has been approved successfully.',
                                    confirmButtonColor: '#198754',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Something went wrong while approving the candidate.',
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

        function rejectCandidate(id) {
            Swal.fire({
                title: 'Reject Candidate?',
                text: "This candidate will be rejected for interview.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reject'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.rejectCandidate') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            job_application_id: id
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Rejected!',
                                    text: 'The candidate has been reejected successfully.',
                                    confirmButtonColor: '#198754',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Something went wrong while rejecting the candidate.',
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

    </script>
@endsection

<!-- Custom Styling -->
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

    /* Common Action Buttons */
    .btn-action {
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    /* Edit */
    .btn-action.btn-edit {
        background-color: #2563eb;
        color: #fff;
    }

    .btn-action.btn-edit:hover {
        background-color: #1e40af;
        transform: scale(1.1);
    }

    /* Delete */
    .btn-action.btn-delete {
        background-color: #dc2626;
        color: #fff;
    }

    .btn-action.btn-delete:hover {
        background-color: #b91c1c;
        transform: scale(1.1);
    }

    /* Notify / Dropdown */
    .btn-action.btn-notify {
        background-color: #f59e0b;
        color: #fff;
    }

    .btn-action.btn-notify:hover {
        background-color: #d97706;
        transform: scale(1.1);
    }
</style>