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
                            <li class="breadcrumb-item active">Saved Job</li>
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
                                    <i class="bi bi-bookmark me-2"></i>
                                    Saved Jobs
                                </h3>
                                <a href="{{ route('account.createJob') }}"
                                    class="btn btn-outline-primary me-2 px-4 rounded-pill"
                                    style="border-color:blueviolet;color:blueviolet;">
                                    <i class="bi bi-plus-circle me-2"></i> Post a Job
                                </a>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table align-middle table-hover">
                                    <thead class="table-light text-muted small text-uppercase">
                                        <tr>
                                            <th>Title</th>
                                            <th>Saved On</th>
                                            <th>Applicants</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($saveJob as $save)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold text-dark">{{ $save->job->title }}</div>
                                                    <small class="text-muted">
                                                        {{ $save->job->type->name ?? '' }} • {{ $save->location }}
                                                    </small>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($save->created_at)->format('d M, Y') }}</td>
                                                <td>
                                                    <span class="badge bg-info-subtle text-info fw-semibold">
                                                        {{ $save->job->applications_count ?? 0 }} Applications
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($save->job->status == 1)
                                                        <span class="badge bg-success-subtle text-success px-3 py-2">Active</span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger px-3 py-2">Blocked</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <!-- View Button -->
                                                        <a href="{{ route('account.jobOverview', $save->job->id) }}"
                                                            class="btn btn-sm btn-outline-info me-2" data-bs-toggle="tooltip"
                                                            title="View Job">
                                                            <i class="bi bi-eye"></i>
                                                        </a>

                                                        <!-- Remove Button -->
                                                        <button onclick="deleteSavesJob({{ $save->id }})"
                                                            class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                                            title="Remove Job">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="bi bi-folder2-open fs-3 mb-2"></i>
                                                    <div>No saved jobs yet</div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{-- {{ $saveJob->links('pagination::bootstrap-5') }} --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJS')
    <script type="text/javascript">
        function deleteSavesJob(jobId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will remove the saved job from your list!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash"></i> Yes, Remove',
                cancelButtonText: '<i class="bi bi-x-circle"></i> Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('job.deleteSavedJob') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: jobId
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed!',
                                    text: 'The saved job has been deleted successfully.',
                                    confirmButtonColor: '#198754',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "{{ route('job.saveJob') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong while deleting the saved job.',
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
    .btn-outline-primary {
        border: 2px solid #667eea;
        font-weight: 600;
        transition: all 0.3s ease-in-out;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(90deg, #667eea, #764ba2);
        color: black !important;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
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
</style>