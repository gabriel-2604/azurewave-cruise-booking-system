@extends('admin.layouts.app')

@section('title', 'Cruise Details')

@section('content')

<style>
    .cruise-details-hero {
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

    .cruise-details-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .cruise-details-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .cruise-details-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .hero-badge {
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

    .cruise-hero-image {
        width: 100%;
        max-width: 360px;
        height: 230px;
        object-fit: cover;
        border-radius: 28px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
    }

    .cruise-hero-placeholder {
        width: 100%;
        max-width: 360px;
        height: 230px;
        border-radius: 28px;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
        margin-left: auto;
    }

    .premium-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.09);
        height: 100%;
    }

    .premium-card .card-header {
        background: white;
        border-bottom: 1px solid #edf2f7;
        padding: 24px;
    }

    .premium-card .card-body {
        padding: 24px;
    }

    .stat-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
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

    .info-item {
        padding: 15px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid #edf2f7;
        margin-bottom: 14px;
    }

    .info-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 5px;
    }

    .info-value {
        color: #1f2937;
        font-weight: 800;
        word-break: break-word;
    }

    .status-pill {
        border-radius: 50px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .status-available {
        background: #e8fff3;
        color: #137a42;
    }

    .status-limited {
        background: #fff8e1;
        color: #9a6a00;
    }

    .status-full {
        background: #fff0f0;
        color: #b42318;
    }

    .status-cancelled {
        background: #f1f5f9;
        color: #475569;
    }

    .summary-card {
        border: none;
        border-radius: 26px;
        background:
            radial-gradient(circle at top right, rgba(255, 214, 10, 0.22), transparent 30%),
            linear-gradient(135deg, #023e8a, #0077b6);
        color: white;
        box-shadow: 0 18px 45px rgba(0, 119, 182, 0.25);
    }

    .summary-card .card-body {
        padding: 28px;
    }

    .summary-number {
        font-size: 42px;
        font-weight: 900;
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

    .booking-id {
        color: #023e8a;
        font-weight: 900;
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
        height: 46px;
        border-radius: 16px;
        padding: 10px 16px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .small-action-btn {
        width: 38px;
        height: 38px;
        border-radius: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid #edf2f7;
        color: #1f2937;
        text-decoration: none;
        font-weight: 800;
        transition: 0.22s ease;
        margin-bottom: 12px;
    }

    .quick-link:hover {
        background: #e7f1ff;
        color: #023e8a;
        transform: translateX(5px);
    }

    .quick-link i {
        width: 42px;
        height: 42px;
        border-radius: 15px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .description-box {
        padding: 20px;
        border-radius: 22px;
        background: #f8fbff;
        border: 1px solid #edf2f7;
        color: #475569;
        line-height: 1.7;
        font-weight: 500;
    }

    .empty-state {
        padding: 60px 20px;
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
        .cruise-hero-image,
        .cruise-hero-placeholder {
            margin-left: 0;
            margin-top: 20px;
            max-width: 100%;
        }

        .premium-card .card-header,
        .premium-card .card-body {
            padding: 20px;
        }

        .action-btn {
            width: 100%;
        }

        .table tbody td {
            padding: 14px;
        }
    }
</style>

@php
    $bookingCount = $cruise->bookings->count();
    $pendingBookings = $cruise->bookings->where('booking_status', 'Pending')->count();
    $approvedBookings = $cruise->bookings->where('booking_status', 'Approved')->count();

    $statusClass = match($cruise->status) {
        'Available' => 'status-available',
        'Limited Slots' => 'status-limited',
        'Fully Booked' => 'status-full',
        'Cancelled' => 'status-cancelled',
        default => 'status-cancelled',
    };

    $statusIcon = match($cruise->status) {
        'Available' => 'bi-check-circle',
        'Limited Slots' => 'bi-exclamation-triangle',
        'Fully Booked' => 'bi-x-circle',
        'Cancelled' => 'bi-slash-circle',
        default => 'bi-info-circle',
    };
@endphp

<div class="card cruise-details-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="hero-badge">
                    <i class="bi bi-ship"></i>
                    Admin Cruise Record
                </div>

                <h2 class="fw-bold mb-2">
                    {{ $cruise->cruise_name }}
                </h2>

                <p class="mb-4 opacity-75">
                    View cruise details, schedule, destination, capacity, available slots,
                    ticket price, status, and related booking records.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('cruises.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-arrow-left"></i>
                        Back to Cruises
                    </a>

                    <a href="{{ route('cruises.edit', $cruise) }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-pencil-square"></i>
                        Edit Cruise
                    </a>

                    <a href="{{ route('bookings.create') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-plus-circle"></i>
                        Add Booking
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                @if($cruise->image)

                    <img src="{{ asset('storage/' . $cruise->image) }}"
                         alt="{{ $cruise->cruise_name }}"
                         class="cruise-hero-image">

                @else

                    <div class="cruise-hero-placeholder">
                        🚢
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Capacity
                    </p>

                    <h2 class="fw-bold mb-0">
                        {{ $cruise->capacity }}
                    </h2>
                </div>

                <div class="stat-icon icon-blue">
                    <i class="bi bi-people"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Available Slots
                    </p>

                    <h2 class="text-success fw-bold mb-0">
                        {{ $cruise->available_slots }}
                    </h2>
                </div>

                <div class="stat-icon icon-green">
                    <i class="bi bi-person-check"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Bookings
                    </p>

                    <h2 class="text-warning fw-bold mb-0">
                        {{ $bookingCount }}
                    </h2>
                </div>

                <div class="stat-icon icon-yellow">
                    <i class="bi bi-calendar-check"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Status
                    </p>

                    <span class="status-pill {{ $statusClass }}">
                        <i class="bi {{ $statusIcon }}"></i>
                        {{ $cruise->status }}
                    </span>
                </div>

                <div class="stat-icon icon-red">
                    <i class="bi bi-activity"></i>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-lg-4">

        <div class="card summary-card h-100">

            <div class="card-body">

                <p class="mb-1 opacity-75 fw-semibold">
                    Ticket Price
                </p>

                <div class="summary-number">
                    ₱{{ number_format($cruise->ticket_price, 2) }}
                </div>

                <p class="mb-4 opacity-75">
                    Price per passenger for this cruise package.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                        <i class="bi bi-calendar-check"></i>
                        {{ $approvedBookings }} Approved
                    </span>

                    <span class="badge bg-light text-warning px-3 py-2 rounded-pill">
                        <i class="bi bi-clock-history"></i>
                        {{ $pendingBookings }} Pending
                    </span>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card premium-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Cruise Schedule
                </h5>

                <small class="text-muted">
                    Departure and arrival information.
                </small>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="info-item">
                            <div class="info-label">Departure Date</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($cruise->departure_date)->format('M d, Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-item">
                            <div class="info-label">Departure Time</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($cruise->departure_time)->format('h:i A') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-item">
                            <div class="info-label">Arrival Date</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($cruise->arrival_date)->format('M d, Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">Destination</div>
                            <div class="info-value">{{ $cruise->destination }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">Departure Port</div>
                            <div class="info-value">{{ $cruise->departure_port }}</div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-4">

        <div class="card premium-card mb-4">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Description
                </h5>

                <small class="text-muted">
                    Cruise package overview.
                </small>

            </div>

            <div class="card-body">

                <div class="description-box">
                    {{ $cruise->description ?? 'No description provided for this cruise.' }}
                </div>

            </div>

        </div>

        <div class="card premium-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Quick Actions
                </h5>

                <small class="text-muted">
                    Admin navigation.
                </small>

            </div>

            <div class="card-body">

                <a href="{{ route('cruises.edit', $cruise) }}" class="quick-link">
                    <i class="bi bi-pencil-square"></i>
                    <span>Edit Cruise</span>
                </a>

                <a href="{{ route('bookings.create') }}" class="quick-link">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add Booking</span>
                </a>

                <a href="{{ route('bookings.index') }}" class="quick-link">
                    <i class="bi bi-calendar-check"></i>
                    <span>Booking Management</span>
                </a>

                <a href="{{ route('calendar.index') }}" class="quick-link mb-0">
                    <i class="bi bi-calendar3"></i>
                    <span>Event Calendar</span>
                </a>

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card premium-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        Related Bookings
                    </h5>

                    <small class="text-muted">
                        Bookings connected to this cruise.
                    </small>
                </div>

                <a href="{{ route('bookings.create') }}" class="btn btn-primary fw-bold">
                    <i class="bi bi-plus-circle"></i>
                    Add Booking
                </a>

            </div>

            <div class="card-body p-0">

                @if($cruise->bookings->count() > 0)

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead>
                                <tr>
                                    <th>Booking</th>
                                    <th>Customer</th>
                                    <th>Schedule</th>
                                    <th>Passengers</th>
                                    <th>Status</th>
                                    <th width="90">View</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($cruise->bookings as $booking)

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
                                            @php
                                                $bookingStatusClass = match($booking->booking_status) {
                                                    'Pending' => 'status-limited',
                                                    'Approved' => 'status-available',
                                                    'Rejected' => 'status-full',
                                                    'Cancelled' => 'status-cancelled',
                                                    'Completed' => 'status-available',
                                                    default => 'status-cancelled',
                                                };
                                            @endphp

                                            <span class="status-pill {{ $bookingStatusClass }}">
                                                {{ $booking->booking_status }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('bookings.show', $booking) }}"
                                               class="btn btn-info btn-sm small-action-btn"
                                               title="View Booking">

                                                <i class="bi bi-eye"></i>

                                            </a>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="bi bi-calendar-x"></i>
                        </div>

                        <h4 class="fw-bold">
                            No bookings found
                        </h4>

                        <p class="text-muted mb-4">
                            This cruise has no booking records yet.
                        </p>

                        <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-lg fw-bold">
                            <i class="bi bi-plus-circle"></i>
                            Add Booking
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection