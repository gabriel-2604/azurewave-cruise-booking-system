@extends('customer.layouts.app')

@section('title', 'My Bookings')

@section('content')

<style>
    .bookings-hero {
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

    .bookings-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .bookings-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .bookings-hero .card-body {
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

    .stat-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        height: 100%;
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.13);
    }

    .stat-card::after {
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
        width: 58px;
        height: 58px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        flex-shrink: 0;
    }

    .icon-blue {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .icon-yellow {
        background: #fff8e1;
        color: #ffc107;
    }

    .icon-green {
        background: #e8fff3;
        color: #198754;
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

    .table tbody tr {
        transition: 0.2s ease;
    }

    .table tbody tr:hover {
        background: #f8fdff;
    }

    .cruise-avatar {
        width: 54px;
        height: 54px;
        border-radius: 19px;
        background: linear-gradient(135deg, #0077b6, #00b4d8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        flex-shrink: 0;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
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
        white-space: nowrap;
    }

    .action-btn {
        width: 38px;
        height: 38px;
        border-radius: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .file-btn {
        border-radius: 50px;
        font-weight: 800;
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
        .premium-card .card-header {
            padding: 20px;
        }

        .table tbody td {
            padding: 14px;
        }
    }
</style>

@php
    $totalBookings = \App\Models\Booking::where('user_id', auth()->id())->count();

    $pendingBookings = \App\Models\Booking::where('user_id', auth()->id())
        ->where('booking_status', 'Pending')
        ->count();

    $approvedBookings = \App\Models\Booking::where('user_id', auth()->id())
        ->where('booking_status', 'Approved')
        ->count();

    $cancelledBookings = \App\Models\Booking::where('user_id', auth()->id())
        ->where('booking_status', 'Cancelled')
        ->count();
@endphp

<div class="card bookings-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="booking-badge">
                    <i class="bi bi-calendar-check"></i>
                    Customer Booking Center
                </div>

                <h2 class="fw-bold mb-3">
                    My Bookings
                </h2>

                <p class="mb-4 opacity-75">
                    View your cruise reservations, check booking status, edit pending bookings,
                    print receipts, and cancel active reservations when needed.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('customer.bookings.create') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-plus-circle"></i>
                        Create Booking
                    </a>

                    <a href="{{ route('customer.calendar.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-calendar3"></i>
                        My Calendar
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🧾
                </div>

                <h5 class="fw-bold mb-0">
                    Reservation History
                </h5>

                <p class="mb-0 opacity-75">
                    Track your cruise bookings.
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">Total Bookings</p>
                    <h2 class="fw-bold mb-0">{{ $totalBookings }}</h2>
                </div>

                <div class="stat-icon icon-blue">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">Pending</p>
                    <h2 class="text-warning fw-bold mb-0">{{ $pendingBookings }}</h2>
                </div>

                <div class="stat-icon icon-yellow">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">Approved</p>
                    <h2 class="text-success fw-bold mb-0">{{ $approvedBookings }}</h2>
                </div>

                <div class="stat-icon icon-green">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">Cancelled</p>
                    <h2 class="text-danger fw-bold mb-0">{{ $cancelledBookings }}</h2>
                </div>

                <div class="stat-icon icon-red">
                    <i class="bi bi-slash-circle"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card premium-card">

    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h5 class="fw-bold mb-1">
                Booking Records
            </h5>

            <small class="text-muted">
                Manage your cruise booking requests.
            </small>
        </div>

        <a href="{{ route('customer.bookings.create') }}" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-circle"></i>
            New Booking
        </a>

    </div>

    <div class="card-body">

        @if($bookings->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Booking</th>
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

                                        <a href="{{ route('customer.bookings.show', $booking) }}"
                                           class="btn btn-info btn-sm action-btn"
                                           title="View Booking">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        <a href="{{ route('customer.bookings.receipt', $booking) }}"
                                           class="btn btn-success btn-sm action-btn"
                                           title="Receipt">

                                            <i class="bi bi-receipt"></i>

                                        </a>

                                        @if($booking->booking_status === 'Pending')

                                            <a href="{{ route('customer.bookings.edit', $booking) }}"
                                               class="btn btn-warning btn-sm action-btn"
                                               title="Edit Pending Booking">

                                                <i class="bi bi-pencil-square"></i>

                                            </a>

                                        @endif

                                        @if(in_array($booking->booking_status, ['Pending', 'Approved']))

                                            <form method="POST"
                                                  action="{{ route('customer.bookings.cancel', $booking) }}"
                                                  class="confirm-action"
                                                  data-title="Cancel Booking?"
                                                  data-text="This booking will be cancelled and your reservation slot will be released."
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
                    No bookings yet
                </h4>

                <p class="text-muted mb-4">
                    Start your cruise journey by creating your first booking.
                </p>

                <a href="{{ route('customer.bookings.create') }}" class="btn btn-primary btn-lg fw-bold">
                    <i class="bi bi-plus-circle"></i>
                    Create First Booking
                </a>

            </div>

        @endif

    </div>

</div>

@endsection