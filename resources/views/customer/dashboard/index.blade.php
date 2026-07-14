@extends('customer.layouts.app')

@section('title', 'Customer Dashboard')

@section('content')

@php
    $totalBookings = \App\Models\Booking::where('user_id', auth()->id())->count();

    $pendingBookings = \App\Models\Booking::where('user_id', auth()->id())
        ->where('booking_status', 'Pending')
        ->count();

    $approvedBookings = \App\Models\Booking::where('user_id', auth()->id())
        ->where('booking_status', 'Approved')
        ->count();

    $activeBookings = \App\Models\Booking::where('user_id', auth()->id())
        ->whereIn('booking_status', ['Pending', 'Approved'])
        ->count();

    $myBookedDates = \App\Models\Booking::where('user_id', auth()->id())
        ->whereIn('booking_status', ['Pending', 'Approved', 'Completed'])
        ->distinct('booking_date')
        ->count('booking_date');

    $nextBooking = \App\Models\Booking::with('cruise')
        ->where('user_id', auth()->id())
        ->whereIn('booking_status', ['Pending', 'Approved'])
        ->whereDate('booking_date', '>=', today())
        ->orderBy('booking_date')
        ->orderBy('booking_time')
        ->first();

    $recentBookings = \App\Models\Booking::with('cruise')
        ->where('user_id', auth()->id())
        ->latest()
        ->take(5)
        ->get();

    $availableCruises = \App\Models\Cruise::where('status', '!=', 'Cancelled')
        ->where('available_slots', '>', 0)
        ->orderBy('departure_date')
        ->take(4)
        ->get();
@endphp

<style>
    .premium-hero {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 28px;
        color: white;
        background:
            linear-gradient(135deg, rgba(2, 62, 138, 0.92), rgba(0, 180, 216, 0.76)),
            url("{{ asset('images/hero.jpg') }}");
        background-size: cover;
        background-position: center;
        box-shadow: 0 22px 55px rgba(0, 119, 182, 0.22);
    }

    .premium-hero::after {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.13);
        right: -70px;
        top: -80px;
    }

    .premium-hero::before {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 214, 10, 0.18);
        right: 130px;
        bottom: -70px;
    }

    .premium-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .premium-stat {
        border: none;
        border-radius: 24px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
    }

    .premium-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.13);
    }

    .premium-stat::after {
        content: "";
        position: absolute;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        right: -28px;
        top: -28px;
        background: rgba(0, 119, 182, 0.08);
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .icon-blue {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .icon-cyan {
        background: #e6fbff;
        color: #0dcaf0;
    }

    .icon-green {
        background: #e8fff3;
        color: #198754;
    }

    .icon-red {
        background: #fff0f0;
        color: #dc3545;
    }

    .next-trip-card {
        border: none;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.09);
    }

    .next-trip-top {
        background: linear-gradient(135deg, #023e8a, #0077b6);
        color: white;
        padding: 24px;
    }

    .quick-card {
        border: none;
        border-radius: 24px;
        height: 100%;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
    }

    .quick-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.13);
    }

    .quick-icon {
        width: 64px;
        height: 64px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 18px;
    }

    .section-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .cruise-mini-card {
        border: 1px solid #eef2f7;
        border-radius: 20px;
        padding: 18px;
        transition: 0.2s ease;
    }

    .cruise-mini-card:hover {
        border-color: #00b4d8;
        background: #f8fdff;
    }

    .status-pill {
        border-radius: 50px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
    }

    .table thead th {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6b7280;
    }

    .cruise-premium-card {
        border: 1px solid #eef2f7;
        border-radius: 24px;
        overflow: hidden;
        background: white;
        transition: 0.25s ease;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
    }

    .cruise-premium-card:hover {
        transform: translateY(-5px);
        border-color: #00b4d8;
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.13);
    }

    .cruise-premium-image {
        width: 100%;
        height: 145px;
        object-fit: cover;
    }

    .cruise-premium-placeholder {
        width: 100%;
        height: 145px;
        background: linear-gradient(135deg, #023e8a, #00b4d8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 56px;
    }

    .cruise-premium-body {
        padding: 18px;
    }

    .cruise-premium-title {
        font-weight: 900;
        color: #023e8a;
        margin-bottom: 6px;
    }

    .cruise-premium-meta {
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 7px;
    }

    .cruise-price-pill {
        border-radius: 50px;
        padding: 7px 12px;
        background: #e8fff3;
        color: #137a42;
        font-size: 12px;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .cruise-slots-pill {
        border-radius: 50px;
        padding: 7px 12px;
        background: #e7f1ff;
        color: #0d6efd;
        font-size: 12px;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .cruise-status-available {
        border-radius: 50px;
        padding: 7px 12px;
        background: #e8fff3;
        color: #137a42;
        font-size: 12px;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .cruise-status-limited {
        border-radius: 50px;
        padding: 7px 12px;
        background: #fff8e1;
        color: #9a6a00;
        font-size: 12px;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .cruise-book-btn {
        height: 42px;
        border-radius: 15px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }
</style>

<div class="card premium-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="hero-badge">
                    <i class="bi bi-stars"></i>
                    Customer Travel Dashboard
                </div>

                <h2 class="fw-bold mb-3">
                    Welcome aboard, {{ auth()->user()->name }}!
                </h2>

                <p class="mb-4 opacity-75">
                    Book your next cruise adventure, manage your reservations, check your event calendar,
                    and track your booking status in one beautiful dashboard.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('customer.bookings.create') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-plus-circle"></i>
                        Book a Cruise
                    </a>

                    <a href="{{ route('customer.calendar.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-calendar3"></i>
                        View Calendar
                    </a>

                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-list-check"></i>
                        My Bookings
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🚢
                </div>

                <h5 class="fw-bold mb-0">
                    AzureWave Cruises
                </h5>

                <p class="mb-0 opacity-75">
                    Sail. Book. Relax.
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card premium-stat h-100">

            <div class="card-body d-flex align-items-center justify-content-between">

                <div>
                    <p class="text-muted mb-1 fw-semibold">
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

        <div class="card premium-stat h-100">

            <div class="card-body d-flex align-items-center justify-content-between">

                <div>
                    <p class="text-muted mb-1 fw-semibold">
                        Active Bookings
                    </p>

                    <h2 class="text-info fw-bold mb-0">
                        {{ $activeBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-cyan">
                    <i class="bi bi-hourglass-split"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card premium-stat h-100">

            <div class="card-body d-flex align-items-center justify-content-between">

                <div>
                    <p class="text-muted mb-1 fw-semibold">
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

        <div class="card premium-stat h-100">

            <div class="card-body d-flex align-items-center justify-content-between">

                <div>
                    <p class="text-muted mb-1 fw-semibold">
                        My Booked Dates
                    </p>

                    <h2 class="text-danger fw-bold mb-0">
                        {{ $myBookedDates }}
                    </h2>
                </div>

                <div class="stat-icon icon-red">
                    <i class="bi bi-calendar-event"></i>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-lg-5">

        <div class="card next-trip-card h-100">

            <div class="next-trip-top">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="mb-1 opacity-75">
                            Your Next Cruise
                        </p>

                        <h4 class="fw-bold mb-0">
                            @if($nextBooking)
                                {{ $nextBooking->cruise->cruise_name ?? 'Deleted Cruise' }}
                            @else
                                No Upcoming Cruise
                            @endif
                        </h4>
                    </div>

                    <div class="fs-1">
                        <i class="bi bi-compass"></i>
                    </div>

                </div>

            </div>

            <div class="card-body p-4">

                @if($nextBooking)

                    <div class="mb-3">

                        <small class="text-muted fw-semibold">
                            Destination
                        </small>

                        <h6 class="fw-bold mb-0">
                            {{ $nextBooking->cruise->destination ?? 'N/A' }}
                        </h6>

                    </div>

                    <div class="row g-3 mb-3">

                        <div class="col-6">
                            <small class="text-muted fw-semibold">
                                Date
                            </small>

                            <div class="fw-bold">
                                {{ \Carbon\Carbon::parse($nextBooking->booking_date)->format('M d, Y') }}
                            </div>
                        </div>

                        <div class="col-6">
                            <small class="text-muted fw-semibold">
                                Time
                            </small>

                            <div class="fw-bold">
                                {{ \Carbon\Carbon::parse($nextBooking->booking_time)->format('h:i A') }}
                            </div>
                        </div>

                        <div class="col-6">
                            <small class="text-muted fw-semibold">
                                Passengers
                            </small>

                            <div class="fw-bold">
                                {{ $nextBooking->passenger_count }}
                            </div>
                        </div>

                        <div class="col-6">
                            <small class="text-muted fw-semibold">
                                Status
                            </small>

                            <div>
                                @if($nextBooking->booking_status === 'Pending')
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                @elseif($nextBooking->booking_status === 'Approved')
                                    <span class="badge bg-success">
                                        Approved
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ $nextBooking->booking_status }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <a href="{{ route('customer.bookings.show', $nextBooking) }}" class="btn btn-primary w-100">
                        <i class="bi bi-eye"></i>
                        View Next Cruise
                    </a>

                @else

                    <div class="text-center py-4">

                        <i class="bi bi-calendar-plus display-5 text-muted"></i>

                        <h5 class="fw-bold mt-3">
                            No upcoming cruise yet
                        </h5>

                        <p class="text-muted">
                            Start your next travel adventure by booking a cruise.
                        </p>

                        <a href="{{ route('customer.bookings.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Book Now
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

    <div class="col-lg-7">

        <div class="row g-4 h-100">

            <div class="col-md-4">

                <a href="{{ route('customer.calendar.index') }}" class="text-decoration-none text-dark">

                    <div class="card quick-card">

                        <div class="card-body text-center p-4">

                            <div class="quick-icon icon-blue">
                                <i class="bi bi-calendar3"></i>
                            </div>

                            <h6 class="fw-bold">
                                My Calendar
                            </h6>

                            <p class="text-muted small mb-0">
                                View all booked cruise dates.
                            </p>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-md-4">

                <a href="{{ route('customer.bookings.create') }}" class="text-decoration-none text-dark">

                    <div class="card quick-card">

                        <div class="card-body text-center p-4">

                            <div class="quick-icon icon-green">
                                <i class="bi bi-plus-circle"></i>
                            </div>

                            <h6 class="fw-bold">
                                Create Booking
                            </h6>

                            <p class="text-muted small mb-0">
                                Submit a new reservation.
                            </p>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-md-4">

                <a href="{{ route('customer.bookings.index') }}" class="text-decoration-none text-dark">

                    <div class="card quick-card">

                        <div class="card-body text-center p-4">

                            <div class="quick-icon icon-cyan">
                                <i class="bi bi-list-check"></i>
                            </div>

                            <h6 class="fw-bold">
                                My Bookings
                            </h6>

                            <p class="text-muted small mb-0">
                                Manage your reservations.
                            </p>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-12">

                <div class="card quick-card">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                            <div>
                                <h5 class="fw-bold mb-1">
                                    Booking Summary
                                </h5>

                                <p class="text-muted mb-0">
                                    You currently have {{ $pendingBookings }} pending booking(s) and {{ $approvedBookings }} approved booking(s).
                                </p>
                            </div>

                            <a href="{{ route('customer.bookings.index') }}" class="btn btn-outline-primary">
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-5">

        <div class="card section-card h-100">

            <div class="card-header bg-white d-flex justify-content-between align-items-center p-4">

                <div>
                    <h5 class="fw-bold mb-1">
                        Available Cruises
                    </h5>

                    <small class="text-muted">
                        Choose from upcoming cruise schedules.
                    </small>
                </div>

                <a href="{{ route('customer.bookings.create') }}" class="btn btn-sm btn-primary fw-bold">
                    <i class="bi bi-plus-circle"></i>
                    Book
                </a>

            </div>

            <div class="card-body p-4">

                @if($availableCruises->count() > 0)

                    <div class="row g-3">

                        @foreach($availableCruises as $cruise)

                            @php
                                $cruiseStatusClass = $cruise->status === 'Limited Slots'
                                    ? 'cruise-status-limited'
                                    : 'cruise-status-available';

                                $cruiseStatusIcon = $cruise->status === 'Limited Slots'
                                    ? 'bi-exclamation-triangle'
                                    : 'bi-check-circle';
                            @endphp

                            <div class="col-12">

                                <div class="cruise-premium-card">

                                    @if($cruise->image)

                                        <img src="{{ asset('storage/' . $cruise->image) }}"
                                             alt="{{ $cruise->cruise_name }}"
                                             class="cruise-premium-image">

                                    @else

                                        <div class="cruise-premium-placeholder">
                                            🚢
                                        </div>

                                    @endif

                                    <div class="cruise-premium-body">

                                        <div class="d-flex justify-content-between align-items-start gap-2 mb-3">

                                            <div>
                                                <h6 class="cruise-premium-title">
                                                    {{ $cruise->cruise_name }}
                                                </h6>

                                                <div class="cruise-premium-meta">
                                                    <i class="bi bi-geo-alt"></i>
                                                    {{ $cruise->destination }}
                                                </div>
                                            </div>

                                            <span class="{{ $cruiseStatusClass }}">
                                                <i class="bi {{ $cruiseStatusIcon }}"></i>
                                                {{ $cruise->status }}
                                            </span>

                                        </div>

                                        <div class="cruise-premium-meta">
                                            <i class="bi bi-signpost"></i>
                                            {{ $cruise->departure_port }}
                                        </div>

                                        <div class="cruise-premium-meta">
                                            <i class="bi bi-calendar-event"></i>
                                            {{ \Carbon\Carbon::parse($cruise->departure_date)->format('M d, Y') }}
                                        </div>

                                        <div class="cruise-premium-meta mb-3">
                                            <i class="bi bi-clock"></i>
                                            {{ \Carbon\Carbon::parse($cruise->departure_time)->format('h:i A') }}
                                        </div>

                                        <div class="d-flex flex-wrap gap-2 mb-3">

                                            <span class="cruise-price-pill">
                                                <i class="bi bi-cash-stack"></i>
                                                ₱{{ number_format($cruise->ticket_price, 2) }}
                                            </span>

                                            <span class="cruise-slots-pill">
                                                <i class="bi bi-people"></i>
                                                {{ $cruise->available_slots }} slots
                                            </span>

                                        </div>

                                        <a href="{{ route('customer.bookings.create', ['cruise_id' => $cruise->id]) }}"
                                           class="btn btn-primary cruise-book-btn w-100">

                                            <i class="bi bi-calendar-plus"></i>
                                            Book This Cruise

                                        </a>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="text-center py-5">

                        <i class="bi bi-ship display-5 text-muted"></i>

                        <h5 class="fw-bold mt-3">
                            No available cruises
                        </h5>

                        <p class="text-muted">
                            Please check again later.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

    <div class="col-lg-7">

        <div class="card section-card h-100">

            <div class="card-header bg-white d-flex justify-content-between align-items-center p-4">

                <div>
                    <h5 class="fw-bold mb-1">
                        Recent Bookings
                    </h5>

                    <small class="text-muted">
                        Your latest cruise reservation activity.
                    </small>
                </div>

                <a href="{{ route('customer.bookings.index') }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>

            </div>

            <div class="card-body p-4">

                @if($recentBookings->count() > 0)

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead>
                                <tr>
                                    <th>Cruise</th>
                                    <th>Schedule</th>
                                    <th>Passengers</th>
                                    <th>Status</th>
                                    <th width="130">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($recentBookings as $booking)

                                    <tr>
                                        <td>
                                            <strong>
                                                {{ $booking->cruise->cruise_name ?? 'Deleted Cruise' }}
                                            </strong>

                                            <br>

                                            <small class="text-muted">
                                                {{ $booking->cruise->destination ?? 'N/A' }}
                                            </small>
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}

                                            <br>

                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                                            </small>
                                        </td>

                                        <td>
                                            {{ $booking->passenger_count }}
                                        </td>

                                        <td>
                                            @switch($booking->booking_status)

                                                @case('Pending')
                                                    <span class="badge bg-warning text-dark">
                                                        Pending
                                                    </span>
                                                    @break

                                                @case('Approved')
                                                    <span class="badge bg-success">
                                                        Approved
                                                    </span>
                                                    @break

                                                @case('Rejected')
                                                    <span class="badge bg-danger">
                                                        Rejected
                                                    </span>
                                                    @break

                                                @case('Cancelled')
                                                    <span class="badge bg-secondary">
                                                        Cancelled
                                                    </span>
                                                    @break

                                                @case('Completed')
                                                    <span class="badge bg-primary">
                                                        Completed
                                                    </span>
                                                    @break

                                                @default
                                                    <span class="badge bg-dark">
                                                        Unknown
                                                    </span>

                                            @endswitch
                                        </td>

                                        <td>
                                            <a href="{{ route('customer.bookings.show', $booking) }}"
                                               class="btn btn-info btn-sm"
                                               title="View Booking">

                                                <i class="bi bi-eye"></i>

                                            </a>

                                            @if($booking->booking_status === 'Pending')

                                                <a href="{{ route('customer.bookings.edit', $booking) }}"
                                                   class="btn btn-warning btn-sm"
                                                   title="Edit Booking">

                                                    <i class="bi bi-pencil-square"></i>

                                                </a>

                                            @endif
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-5">

                        <i class="bi bi-calendar-x display-5 text-muted"></i>

                        <h5 class="text-muted mt-3">
                            No bookings yet.
                        </h5>

                        <p class="text-muted">
                            Start your first cruise reservation today.
                        </p>

                        <a href="{{ route('customer.bookings.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Create Booking
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection