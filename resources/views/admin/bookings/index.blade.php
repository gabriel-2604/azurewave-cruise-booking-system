@extends('admin.layouts.app')

@section('title', 'Booking Management')

@section('content')

<style>
    .booking-hero {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 30px;
        color: white;
        background:
            radial-gradient(circle at top right, rgba(255, 214, 10, 0.22), transparent 28%),
            linear-gradient(135deg, rgba(3, 4, 94, 0.96), rgba(2, 62, 138, 0.93), rgba(0, 119, 182, 0.82)),
            url("{{ asset('images/hero.jpg') }}");
        background-size: cover;
        background-position: center;
        box-shadow: 0 24px 65px rgba(3, 4, 94, 0.28);
    }

    .booking-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .booking-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .booking-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .booking-badge {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 9px 16px;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(8px);
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .booking-stat-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .booking-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
    }

    .booking-stat-card::after {
        content: "";
        position: absolute;
        width: 95px;
        height: 95px;
        right: -30px;
        top: -30px;
        border-radius: 50%;
        background: rgba(0, 119, 182, 0.08);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 21px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 29px;
        flex-shrink: 0;
    }

    .icon-blue {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .icon-green {
        background: #e8fff3;
        color: #198754;
    }

    .icon-yellow {
        background: #fff8e1;
        color: #ffc107;
    }

    .icon-red {
        background: #fff0f0;
        color: #dc3545;
    }

    .premium-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.09);
    }

    .premium-card .card-header {
        background: white;
        border-bottom: 1px solid #edf2f7;
        padding: 24px;
    }

    .premium-card .card-body {
        padding: 0;
    }

    .booking-filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .search-box {
        position: relative;
        width: 320px;
    }

    .search-box i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
    }

    .search-box input {
        height: 46px;
        border-radius: 16px;
        padding: 12px 16px 12px 43px;
        border: 1px solid #dbe4ef;
    }

    .search-box input:focus {
        border-color: #00b4d8;
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 216, 0.15);
    }

    .filter-box {
        width: 190px;
        height: 46px;
        border-radius: 16px;
        padding: 10px 14px;
        border: 1px solid #dbe4ef;
    }

    .filter-btn,
    .add-booking-btn {
        height: 46px;
        border-radius: 16px;
        padding: 10px 16px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .table thead th {
        background: #f8fbff;
        color: #64748b;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-weight: 800;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 18px 16px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8fdff;
    }

    .customer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 17px;
        background: linear-gradient(135deg, #023e8a, #0077b6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .cruise-avatar {
        width: 48px;
        height: 48px;
        border-radius: 17px;
        background: linear-gradient(135deg, #0077b6, #00b4d8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .booking-id {
        color: #023e8a;
        font-weight: 900;
    }

    .status-pill {
        border-radius: 50px;
        padding: 7px 13px;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .status-pending {
        background: #fff8e1;
        color: #9a6a00;
    }

    .status-approved {
        background: #e8fff3;
        color: #137a42;
    }

    .status-rejected {
        background: #fff0f0;
        color: #b42318;
    }

    .status-cancelled {
        background: #f1f5f9;
        color: #475569;
    }

    .status-completed {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .passenger-pill {
        border-radius: 50px;
        padding: 7px 13px;
        background: #e7f1ff;
        color: #0d6efd;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
    }

    .file-btn {
        border-radius: 50px;
        font-weight: 700;
    }

    .action-btn,
    .status-action-btn {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state {
        padding: 70px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 90px;
        height: 90px;
        border-radius: 30px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        margin: 0 auto 20px;
    }

    @media (max-width: 768px) {
        .booking-filter-form {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box,
        .filter-box,
        .filter-btn,
        .add-booking-btn {
            width: 100%;
        }

        .premium-card .card-header {
            padding: 20px;
        }

        .table tbody td {
            padding: 14px;
        }
    }
</style>

@php
    $totalBookings = \App\Models\Booking::count();
    $pendingBookings = \App\Models\Booking::where('booking_status', 'Pending')->count();
    $approvedBookings = \App\Models\Booking::where('booking_status', 'Approved')->count();
    $cancelledBookings = \App\Models\Booking::where('booking_status', 'Cancelled')->count();
@endphp

<div class="card booking-hero mb-4">
    <div class="card-body p-4 p-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="booking-badge">
                    <i class="bi bi-calendar-check"></i>
                    Admin Booking Operations
                </div>

                <h2 class="fw-bold mb-3">
                    Booking Management Center
                </h2>

                <p class="mb-4 opacity-75">
                    Review customer cruise reservations, approve or reject requests,
                    manage booking schedules, prevent double bookings, and monitor active reservations.
                </p>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('bookings.create') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-plus-circle"></i>
                        Add Booking
                    </a>

                    <a href="{{ route('booking_logs.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-clock-history"></i>
                        Booking Logs
                    </a>

                    <a href="{{ route('calendar.index') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-calendar3"></i>
                        Event Calendar
                    </a>
                </div>
            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <div class="display-1">
                    🧾
                </div>

                <h5 class="fw-bold mb-0">
                    Reservation Control
                </h5>

                <p class="mb-0 opacity-75">
                    Approve. Track. Manage.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card booking-stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Total Bookings
                    </p>

                    <h2 class="fw-bold mb-0">
                        {{ $totalBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-blue">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card booking-stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Pending
                    </p>

                    <h2 class="text-warning fw-bold mb-0">
                        {{ $pendingBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-yellow">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card booking-stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Approved
                    </p>

                    <h2 class="text-success fw-bold mb-0">
                        {{ $approvedBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-green">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card booking-stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Cancelled
                    </p>

                    <h2 class="text-danger fw-bold mb-0">
                        {{ $cancelledBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-red">
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card premium-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h5 class="fw-bold mb-1">
                    Booking Records
                </h5>

                <small class="text-muted">
                    Search, filter, approve, reject, edit, or cancel customer bookings.
                </small>
            </div>

            <a href="{{ route('bookings.create') }}" class="btn btn-success add-booking-btn">
                <i class="bi bi-plus-circle"></i>
                Add Booking
            </a>
        </div>

        <form method="GET" action="{{ route('bookings.index') }}" class="booking-filter-form">
            <div class="search-box">
                <i class="bi bi-search"></i>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Search customer, email, cruise...">
            </div>

            <select name="status" class="form-select filter-box">
                <option value="">All Status</option>
                <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="Cancelled" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>

            <button class="btn btn-primary filter-btn">
                <i class="bi bi-funnel"></i>
                Filter
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('bookings.index') }}" class="btn btn-light filter-btn">
                    <i class="bi bi-x-circle"></i>
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div class="card-body">
        @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Booking</th>
                            <th>Customer</th>
                            <th>Cruise</th>
                            <th>Schedule</th>
                            <th>Passengers</th>
                            <th>Status</th>
                            <th>File</th>
                            <th width="230">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>
                                    <span class="booking-id">
                                        #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <br>

                                    <small class="text-muted">
                                        {{ $booking->created_at->format('M d, Y') }}
                                    </small>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="customer-avatar">
                                            <i class="bi bi-person"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $booking->user->name ?? 'Deleted User' }}
                                            </strong>

                                            <br>

                                            <small class="text-muted">
                                                {{ $booking->email }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="cruise-avatar">
                                            <i class="bi bi-ship"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $booking->cruise->cruise_name ?? 'Deleted Cruise' }}
                                            </strong>

                                            <br>

                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt"></i>
                                                {{ $booking->cruise->destination ?? 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <strong>
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i>
                                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                                    </small>
                                </td>

                                <td>
                                    <span class="passenger-pill">
                                        <i class="bi bi-people"></i>
                                        {{ $booking->passenger_count }}
                                    </span>
                                </td>

                                <td>
                                    @switch($booking->booking_status)
                                        @case('Pending')
                                            <span class="status-pill status-pending">
                                                <i class="bi bi-clock-history"></i>
                                                Pending
                                            </span>
                                            @break

                                        @case('Approved')
                                            <span class="status-pill status-approved">
                                                <i class="bi bi-check-circle"></i>
                                                Approved
                                            </span>
                                            @break

                                        @case('Rejected')
                                            <span class="status-pill status-rejected">
                                                <i class="bi bi-x-circle"></i>
                                                Rejected
                                            </span>
                                            @break

                                        @case('Cancelled')
                                            <span class="status-pill status-cancelled">
                                                <i class="bi bi-slash-circle"></i>
                                                Cancelled
                                            </span>
                                            @break

                                        @case('Completed')
                                            <span class="status-pill status-completed">
                                                <i class="bi bi-flag"></i>
                                                Completed
                                            </span>
                                            @break

                                        @default
                                            <span class="status-pill status-cancelled">
                                                Unknown
                                            </span>
                                    @endswitch
                                </td>

                                <td>
                                    @if($booking->confirmation_file)
                                        <a href="{{ asset('storage/' . $booking->confirmation_file) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary file-btn">

                                            <i class="bi bi-file-earmark-text"></i>
                                            View
                                        </a>
                                    @else
                                        <span class="text-muted small">
                                            No file
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('bookings.show', $booking) }}"
                                           class="btn btn-info btn-sm action-btn"
                                           title="View Booking">

                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('bookings.edit', $booking) }}"
                                           class="btn btn-warning btn-sm action-btn"
                                           title="Edit Booking">

                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        @if($booking->booking_status === 'Pending')
                                            <form method="POST"
                                                  action="{{ route('bookings.approve', $booking) }}"
                                                  class="confirm-action"
                                                  data-title="Approve Booking?"
                                                  data-text="This customer booking will be approved."
                                                  data-icon="question"
                                                  data-confirm-text="Yes, Approve"
                                                  data-confirm-color="#198754">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn btn-success btn-sm status-action-btn"
                                                        title="Approve Booking">

                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>

                                            <form method="POST"
                                                  action="{{ route('bookings.reject', $booking) }}"
                                                  class="confirm-action"
                                                  data-title="Reject Booking?"
                                                  data-text="This booking request will be rejected."
                                                  data-icon="warning"
                                                  data-confirm-text="Yes, Reject"
                                                  data-confirm-color="#6c757d">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn btn-secondary btn-sm status-action-btn"
                                                        title="Reject Booking">

                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($booking->booking_status, ['Pending', 'Approved']))
                                            <form method="POST"
                                                  action="{{ route('bookings.cancel', $booking) }}"
                                                  class="confirm-action"
                                                  data-title="Cancel Booking?"
                                                  data-text="This booking will be marked as cancelled and passenger slots will be restored."
                                                  data-icon="warning"
                                                  data-confirm-text="Yes, Cancel Booking"
                                                  data-confirm-color="#dc3545">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm action-btn"
                                                        title="Cancel Booking">

                                                    <i class="bi bi-slash-circle"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST"
                                              action="{{ route('bookings.destroy', $booking) }}"
                                              class="confirm-action"
                                              data-title="Delete Booking?"
                                              data-text="This booking record will be permanently deleted."
                                              data-icon="warning"
                                              data-confirm-text="Yes, Delete"
                                              data-confirm-color="#dc3545">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-dark btn-sm action-btn"
                                                    title="Delete Booking">

                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-top">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-calendar-x"></i>
                </div>

                <h4 class="fw-bold">
                    No booking records found
                </h4>

                <p class="text-muted mb-4">
                    There are no bookings matching your current search or filter.
                </p>

                <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-lg fw-bold">
                    <i class="bi bi-plus-circle"></i>
                    Add Booking
                </a>
            </div>
        @endif
    </div>
</div>

@endsection