@extends('front.layout.app')

@section('main')
    <section class="section-5 bg-light">
        <div class="container py-5 mt-5">

            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="breadcrumb-box mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fa fa-home me-1"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Candidate</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    @include('front.account.side_menu')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    @include('front.message')
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                        <!-- Header -->
                        <div class="card-header border-0 bg-white py-4 px-4 shadow-sm">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fs-4 mb-0 text-primary fw-bold d-flex align-items-center">
                                    <i class="fa-solid fa-user-tie"></i>
                                    Candidate List
                                </h3>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table id="candidatesTable" class="table table-modern align-middle mb-0">
                                    <thead class="bg-light text-secondary small text-uppercase">
                                        <tr>
                                            <th>Job Title</th>
                                            <th>Candidate Name</th>
                                            <th>Applied On</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($candidates as $candidate)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold text-dark">{{ $candidate->jobDetail->title }}</div>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold text-dark">{{ $candidate->user->name }}</div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($candidate->created_at)->format('d M, Y') }}</td>
                                                <td>
                                                    <div class="fw-semibold text-dark">{{ ucfirst($candidate->status) }}</div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-buttons d-flex justify-content-center gap-1">
                                                        <!-- Approve -->
                                                        <button onclick="approveCandidate({{ $candidate->id }})"
                                                            class="btn-action btn-approve" data-bs-toggle="tooltip"
                                                            title="Approve Candidate">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>

                                                        <!-- Reject -->
                                                        <button onclick="rejectCandidate({{ $candidate->id }})"
                                                            class="btn-action btn-reject" data-bs-toggle="tooltip"
                                                            title="Reject Candidate">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="bi bi-folder2-open fs-3 mb-2"></i>
                                                    <div>No candidates applied yet</div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Optional Pagination -->
                            {{-- <div class="d-flex justify-content-center mt-4">
                                {{ $candidates->links('pagination::bootstrap-5') }}
                            </div> --}}
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- Custom Styling -->
<style>
    .btn-gradient {
        background: linear-gradient(90deg, #667eea, #764ba2);
        color: #fff !important;
        font-weight: 600;
        transition: all 0.3s ease-in-out;
    }

    .btn-gradient:hover {
        background: linear-gradient(90deg, #764ba2, #667eea);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .text-gradient {
        background: linear-gradient(90deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .table tbody tr:hover {
        background-color: #f9fbff;
    }

    .table th {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

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

    /* ===== Modern Table Styling ===== */
    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.6rem;
    }

    .table-modern thead {
        background-color: #f9fafb;
        font-weight: 600;
        letter-spacing: 0.03em;
    }

    .table-modern tbody tr {
        background: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* ===== Action Buttons ===== */
    .btn-action {
        width: 38px;
        height: 38px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    /* Approve Button */
    .btn-action.btn-approve {
        background-color: #16a34a;
        color: #fff;
    }

    .btn-action.btn-approve:hover {
        background-color: #15803d;
        transform: scale(1.1);
    }

    /* Reject Button */
    .btn-action.btn-reject {
        background-color: #f59e0b;
        color: #fff;
    }

    .btn-action.btn-reject:hover {
        background-color: #b45309;
        transform: scale(1.1);
    }
</style>

@section('customJS')
    <script>
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
                        url: '{{ route('job.approveCandidate') }}',
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
                        url: '{{ route('job.rejectCandidate') }}',
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

        $(document).ready(function () {
            $('#candidatesTable').DataTable({
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

    </script>
@endsection