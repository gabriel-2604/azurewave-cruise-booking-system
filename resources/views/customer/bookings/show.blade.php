@extends('customer.layouts.app')

@section('title', 'Booking Details')

@section('content')

<style>
    .details-hero {
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

    .details-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .details-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .details-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .details-badge {
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

    .summary-card {
        border: none;
        border-radius: 28px;
        background:
            radial-gradient(circle at top right, rgba(255, 214, 10, 0.22), transparent 30%),
            linear-gradient(135deg, #023e8a, #0077b6);
        color: white;
        box-shadow: 0 18px 45px rgba(0, 119, 182, 0.25);
        overflow: hidden;
    }

    .summary-card .card-body {
        padding: 28px;
    }

    .summary-number {
        font-size: 42px;
        font-weight: 900;
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

    .big-icon-box {
        width: 82px;
        height: 82px;
        border-radius: 28px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        flex-shrink: 0;
    }

    .file-box {
        border: 2px dashed #cfe2ff;
        border-radius: 24px;
        padding: 26px;
        background: #f8fbff;
        text-align: center;
    }

    .file-icon {
        width: 78px;
        height: 78px;
        border-radius: 26px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin: 0 auto 15px;
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

    .cruise-image {
        width: 100%;
        height: 230px;
        object-fit: cover;
        border-radius: 24px;
        box-shadow: 0 16px 38px rgba(15, 23, 42, 0.12);
        margin-bottom: 18px;
    }

    .cruise-placeholder {
        width: 100%;
        height: 230px;
        border-radius: 24px;
        background: linear-gradient(135deg, #0077b6, #00b4d8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 76px;
        margin-bottom: 18px;
    }

    @media (max-width: 768px) {
        .premium-card .card-header,
        .premium-card .card-body {
            padding: 20px;
        }

        .action-btn {
            width: 100%;
        }
    }
</style>

@php
    $statusClass = match($booking->booking_status) {
        'Pending' => 'status-pending',
        'Approved' => 'status-approved',
        'Rejected' => 'status-rejected',
        'Cancelled' => 'status-cancelled',
        'Completed' => 'status-completed',
        default => 'status-cancelled',
    };

    $statusIcon = match($booking->booking_status) {
        'Pending' => 'bi-clock-history',
        'Approved' => 'bi-check-circle',
        'Rejected' => 'bi-x-circle',
        'Cancelled' => 'bi-slash-circle',
        'Completed' => 'bi-flag',
        default => 'bi-info-circle',
    };

    $ticketPrice = $booking->cruise->ticket_price ?? 0;
    $estimatedTotal = $ticketPrice * $booking->passenger_count;
@endphp

<div class="card details-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="details-badge">
                    <i class="bi bi-receipt"></i>
                    Customer Booking Details
                </div>

                <h2 class="fw-bold mb-2">
                    Booking #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                </h2>

                <p class="mb-4 opacity-75">
                    View your cruise booking details, selected schedule, passenger count,
                    confirmation file, and current reservation status.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-arrow-left"></i>
                        Back to My Bookings
                    </a>

                    @if($booking->booking_status === 'Pending')
                        <a href="{{ route('customer.bookings.edit', $booking) }}" class="btn btn-warning fw-bold">
                            <i class="bi bi-pencil-square"></i>
                            Edit Booking
                        </a>
                    @endif

                    <a href="{{ route('customer.calendar.index') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-calendar3"></i>
                        My Calendar
                    </a>

                    <a href="{{ route('customer.bookings.receipt', $booking) }}" class="btn btn-success fw-bold">
                     <i class="bi bi-receipt"></i>
                          Receipt
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🧾
                </div>

                <h5 class="fw-bold mb-2">
                    Current Status
                </h5>

                <span class="status-pill {{ $statusClass }}">
                    <i class="bi {{ $statusIcon }}"></i>
                    {{ $booking->booking_status }}
                </span>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-lg-4">

        <div class="card summary-card h-100">

            <div class="card-body">

                <p class="mb-1 opacity-75 fw-semibold">
                    Estimated Total
                </p>

                <div class="summary-number">
                    ₱{{ number_format($estimatedTotal, 2) }}
                </div>

                <p class="mb-4 opacity-75">
                    Based on ticket price and passenger count.
                </p>

                <div class="d-flex flex-wrap gap-2">

                    <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                        <i class="bi bi-people"></i>
                        {{ $booking->passenger_count }} Passenger(s)
                    </span>

                    <span class="badge bg-light text-success px-3 py-2 rounded-pill">
                        ₱{{ number_format($ticketPrice, 2) }} / ticket
                    </span>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card premium-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        Booking Summary
                    </h5>

                    <small class="text-muted">
                        Main reservation information.
                    </small>
                </div>

                <span class="status-pill {{ $statusClass }}">
                    <i class="bi {{ $statusIcon }}"></i>
                    {{ $booking->booking_status }}
                </span>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">Booking Date</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">Booking Time</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">Passenger Count</div>
                            <div class="info-value">
                                {{ $booking->passenger_count }} passenger(s)
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">Created At</div>
                            <div class="info-value">
                                {{ $booking->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-5">

        <div class="card premium-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Cruise Details
                </h5>

                <small class="text-muted">
                    Your selected cruise package.
                </small>

            </div>

            <div class="card-body">

                @if($booking->cruise && $booking->cruise->image)

                    <img src="{{ asset('storage/' . $booking->cruise->image) }}"
                         alt="{{ $booking->cruise->cruise_name }}"
                         class="cruise-image">

                @else

                    <div class="cruise-placeholder">
                        🚢
                    </div>

                @endif

                <div class="d-flex align-items-center gap-3 mb-4">

                    <div class="big-icon-box">
                        <i class="bi bi-ship"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">
                            {{ $booking->cruise->cruise_name ?? 'Deleted Cruise' }}
                        </h5>

                        <small class="text-muted">
                            {{ $booking->cruise->destination ?? 'N/A' }}
                        </small>
                    </div>

                </div>

                <div class="info-item">
                    <div class="info-label">Destination</div>
                    <div class="info-value">{{ $booking->cruise->destination ?? 'N/A' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Departure Port</div>
                    <div class="info-value">{{ $booking->cruise->departure_port ?? 'N/A' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Ticket Price</div>
                    <div class="info-value">
                        ₱{{ number_format($booking->cruise->ticket_price ?? 0, 2) }}
                    </div>
                </div>

                <div class="info-item mb-0">
                    <div class="info-label">Cruise Status</div>
                    <div class="info-value">
                        {{ $booking->cruise->status ?? 'N/A' }}
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card premium-card mb-4">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Contact Details
                </h5>

                <small class="text-muted">
                    Contact information used for this booking.
                </small>

            </div>

            <div class="card-body">

                <div class="d-flex align-items-center gap-3 mb-4">

                    <div class="big-icon-box">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">
                            {{ auth()->user()->name }}
                        </h5>

                        <small class="text-muted">
                            Customer Account
                        </small>
                    </div>

                </div>

                <div class="info-item">
                    <div class="info-label">Email Address</div>
                    <div class="info-value">{{ $booking->email }}</div>
                </div>

                <div class="info-item mb-0">
                    <div class="info-label">Contact Number</div>
                    <div class="info-value">{{ $booking->contact_number }}</div>
                </div>

            </div>

        </div>

        <div class="card premium-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Confirmation File
                </h5>

                <small class="text-muted">
                    Uploaded proof or document.
                </small>

            </div>

            <div class="card-body">

                <div class="file-box">

                    <div class="file-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                    @if($booking->confirmation_file)

                        <h6 class="fw-bold mb-3">
                            Confirmation file uploaded
                        </h6>

                        <a href="{{ asset('storage/' . $booking->confirmation_file) }}"
                           target="_blank"
                           class="btn btn-outline-primary fw-bold rounded-pill">

                            <i class="bi bi-eye"></i>
                            View File

                        </a>

                    @else

                        <h6 class="fw-bold mb-2">
                            No file uploaded
                        </h6>

                        <p class="text-muted mb-0">
                            This booking has no confirmation file.
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="card premium-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Booking Actions
                </h5>

                <small class="text-muted">
                    Available customer actions.
                </small>

            </div>

            <div class="card-body">

                @if($booking->booking_status === 'Pending')

                    <a href="{{ route('customer.bookings.edit', $booking) }}" class="btn btn-warning action-btn w-100 mb-2">
                        <i class="bi bi-pencil-square"></i>
                        Edit Booking
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

                        <button type="submit" class="btn btn-danger action-btn w-100 mb-2">
                            <i class="bi bi-slash-circle"></i>
                            Cancel Booking
                        </button>

                    </form>

                @endif

                <a href="{{ route('customer.bookings.index') }}" class="btn btn-light action-btn w-100 mb-2">
                    <i class="bi bi-list-ul"></i>
                    My Bookings
                </a>

                <a href="{{ route('customer.calendar.index') }}" class="btn btn-primary action-btn w-100">
                    <i class="bi bi-calendar3"></i>
                    My Calendar
                </a>

            </div>

        </div>

        <div class="card premium-card mt-4">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Reminder
                </h5>

                <small class="text-muted">
                    Booking rules.
                </small>

            </div>

            <div class="card-body">

                <div class="quick-link">
                    <i class="bi bi-info-circle"></i>
                    <span>Only pending bookings can be edited.</span>
                </div>

                <div class="quick-link">
                    <i class="bi bi-calendar-x"></i>
                    <span>Booked date and time cannot be duplicated.</span>
                </div>

                <div class="quick-link mb-0">
                    <i class="bi bi-shield-check"></i>
                    <span>Admin approval is required.</span>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection