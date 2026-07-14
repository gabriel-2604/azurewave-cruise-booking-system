@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<style>
    .admin-hero {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 30px;
        color: white;
        background:
            radial-gradient(circle at top right, rgba(255, 214, 10, 0.25), transparent 28%),
            linear-gradient(135deg, rgba(3, 4, 94, 0.96), rgba(2, 62, 138, 0.93), rgba(0, 119, 182, 0.82)),
            url("{{ asset('images/hero.jpg') }}");
        background-size: cover;
        background-position: center;
        box-shadow: 0 24px 65px rgba(3, 4, 94, 0.28);
    }

    .admin-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .admin-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .admin-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .admin-badge {
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

    .admin-metric-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .admin-metric-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
    }

    .admin-metric-card::after {
        content: "";
        position: absolute;
        width: 95px;
        height: 95px;
        right: -30px;
        top: -30px;
        border-radius: 50%;
        background: rgba(0, 119, 182, 0.08);
    }

    .metric-icon {
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

    .icon-cyan {
        background: #e6fbff;
        color: #0dcaf0;
    }

    .icon-dark {
        background: #edf2f7;
        color: #1e293b;
    }

    .admin-section-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.09);
        height: 100%;
    }

    .admin-section-card .card-header {
        background: white;
        border-bottom: 1px solid #edf2f7;
        padding: 24px;
    }

    .admin-section-card .card-body {
        padding: 24px;
    }

    .quick-admin-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        height: 100%;
        text-decoration: none;
        color: #1f2937;
    }

    .quick-admin-card:hover {
        color: #1f2937;
        transform: translateY(-5px);
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.13);
    }

    .quick-admin-icon {
        width: 60px;
        height: 60px;
        border-radius: 21px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 29px;
        margin-bottom: 14px;
    }

    .status-pill {
        border-radius: 50px;
        padding: 7px 13px;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
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

    .table thead th {
        background: #f8fbff;
        color: #64748b;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-weight: 800;
        border-bottom: 1px solid #e5e7eb;
        padding: 15px;
    }

    .table tbody td {
        padding: 16px 15px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8fdff;
    }

    .timeline {
        position: relative;
        padding-left: 28px;
    }

    .timeline::before {
        content: "";
        position: absolute;
        left: 9px;
        top: 5px;
        bottom: 5px;
        width: 2px;
        background: #e5e7eb;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-dot {
        position: absolute;
        left: -25px;
        top: 2px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #0077b6;
        border: 4px solid white;
        box-shadow: 0 0 0 2px #d8f3ff;
    }

    .top-cruise-card {
        border-radius: 24px;
        background:
            linear-gradient(135deg, rgba(3, 4, 94, 0.94), rgba(0, 119, 182, 0.88)),
            url("{{ asset('images/hero.jpg') }}");
        background-size: cover;
        background-position: center;
        color: white;
        padding: 26px;
        overflow: hidden;
        position: relative;
    }

    .top-cruise-card::after {
        content: "🚢";
        position: absolute;
        right: 20px;
        bottom: -25px;
        font-size: 7rem;
        opacity: 0.16;
    }

    .progress {
        height: 12px;
        border-radius: 50px;
        background: #edf2f7;
    }

    .progress-bar {
        border-radius: 50px;
    }

    .mini-event {
        border: 1px solid #eef2f7;
        border-radius: 18px;
        padding: 14px;
        margin-bottom: 12px;
        transition: 0.2s ease;
    }

    .mini-event:hover {
        background: #f8fdff;
        border-color: #d8f3ff;
    }
</style>

<div class="card admin-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="admin-badge">
                    <i class="bi bi-shield-lock"></i>
                    Administrator Command Center
                </div>

                <h2 class="fw-bold mb-3">
                    Welcome back, {{ auth()->user()->name }}!
                </h2>

                <p class="mb-4 opacity-75">
                    Monitor cruise operations, manage customer reservations, track booking activity,
                    review reports, and control cruise schedules from one premium admin dashboard.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('bookings.index') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-calendar-check"></i>
                        Manage Bookings
                    </a>

                    <a href="{{ route('calendar.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-calendar3"></i>
                        Event Calendar
                    </a>

                    <a href="{{ route('reports.index') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        Reports
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🛳️
                </div>

                <h5 class="fw-bold mb-0">
                    Admin Control Panel
                </h5>

                <p class="mb-0 opacity-75">
                    Manage. Approve. Monitor.
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card admin-metric-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Total Users
                    </p>

                    <h2 class="fw-bold mb-0">
                        {{ $totalUsers }}
                    </h2>
                </div>

                <div class="metric-icon icon-blue">
                    <i class="bi bi-people"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card admin-metric-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Total Bookings
                    </p>

                    <h2 class="text-warning fw-bold mb-0">
                        {{ $totalBookings }}
                    </h2>
                </div>

                <div class="metric-icon icon-yellow">
                    <i class="bi bi-calendar-check"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card admin-metric-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Booked Dates
                    </p>

                    <h2 class="text-danger fw-bold mb-0">
                        {{ $bookedDates }}
                    </h2>
                </div>

                <div class="metric-icon icon-red">
                    <i class="bi bi-calendar-event"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card admin-metric-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Estimated Revenue
                    </p>

                    <h2 class="text-success fw-bold mb-0">
                        ₱{{ number_format($estimatedRevenue, 2) }}
                    </h2>
                </div>

                <div class="metric-icon icon-green">
                    <i class="bi bi-cash-stack"></i>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('cruises.index') }}" class="card quick-admin-card">
            <div class="card-body p-4">
                <div class="quick-admin-icon icon-blue">
                    <i class="bi bi-water"></i>
                </div>
                <h5 class="fw-bold mb-1">Cruise Management</h5>
                <p class="text-muted mb-0">Add, update, and monitor cruise schedules.</p>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('bookings.index') }}" class="card quick-admin-card">
            <div class="card-body p-4">
                <div class="quick-admin-icon icon-yellow">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h5 class="fw-bold mb-1">Booking Management</h5>
                <p class="text-muted mb-0">Approve, reject, edit, and cancel bookings.</p>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('customers.index') }}" class="card quick-admin-card">
            <div class="card-body p-4">
                <div class="quick-admin-icon icon-green">
                    <i class="bi bi-person-check"></i>
                </div>
                <h5 class="fw-bold mb-1">Customer Management</h5>
                <p class="text-muted mb-0">View customers and booking history.</p>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('booking_logs.index') }}" class="card quick-admin-card">
            <div class="card-body p-4">
                <div class="quick-admin-icon icon-cyan">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h5 class="fw-bold mb-1">Booking Logs</h5>
                <p class="text-muted mb-0">Track every booking activity record.</p>
            </div>
        </a>
    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-lg-8">

        <div class="card admin-section-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        Recent Booking Activity
                    </h5>

                    <small class="text-muted">
                        Latest customer booking records.
                    </small>
                </div>

                <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-outline-primary fw-bold">
                    View All
                </a>

            </div>

            <div class="card-body p-0">

                @if($recentBookings->count() > 0)

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Cruise</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                    <th width="90">View</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($recentBookings as $booking)

                                    <tr>
                                        <td>
                                            <strong>
                                                {{ $booking->user->name ?? 'Deleted User' }}
                                            </strong>

                                            <br>

                                            <small class="text-muted">
                                                {{ $booking->email }}
                                            </small>
                                        </td>

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
                                            <strong>
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                            </strong>

                                            <br>

                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                                            </small>
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
                                            <a href="{{ route('bookings.show', $booking) }}"
                                               class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x display-5 text-muted"></i>
                        <h5 class="text-muted mt-3">No recent bookings yet.</h5>
                    </div>

                @endif

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card admin-section-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Booking Status Overview
                </h5>

                <small class="text-muted">
                    Current booking distribution.
                </small>

            </div>

            <div class="card-body">

                @php
                    $statusTotal = max($totalBookings, 1);

                    $pendingPercent = ($pendingBookings / $statusTotal) * 100;
                    $approvedPercent = ($approvedBookings / $statusTotal) * 100;
                    $cancelledPercent = ($cancelledBookings / $statusTotal) * 100;
                    $completedPercent = ($completedBookings / $statusTotal) * 100;
                @endphp

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Pending</span>
                        <span>{{ $pendingBookings }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: {{ $pendingPercent }}%"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Approved</span>
                        <span>{{ $approvedBookings }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ $approvedPercent }}%"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Cancelled</span>
                        <span>{{ $cancelledBookings }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-secondary" style="width: {{ $cancelledPercent }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Completed</span>
                        <span>{{ $completedBookings }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: {{ $completedPercent }}%"></div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-4">

        <div class="card admin-section-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Top Cruise Spotlight
                </h5>

                <small class="text-muted">
                    Most booked cruise schedule.
                </small>

            </div>

            <div class="card-body">

                @if($topCruise)

                    <div class="top-cruise-card">

                        <h4 class="fw-bold mb-2">
                            {{ $topCruise->cruise_name }}
                        </h4>

                        <p class="mb-3 opacity-75">
                            <i class="bi bi-geo-alt"></i>
                            {{ $topCruise->destination }}
                        </p>

                        <div class="row g-3">

                            <div class="col-6">
                                <small class="opacity-75">Bookings</small>
                                <h3 class="fw-bold mb-0">
                                    {{ $topCruise->bookings_count }}
                                </h3>
                            </div>

                            <div class="col-6">
                                <small class="opacity-75">Slots Left</small>
                                <h3 class="fw-bold mb-0">
                                    {{ $topCruise->available_slots }}
                                </h3>
                            </div>

                        </div>

                    </div>

                @else

                    <div class="text-center py-5">
                        <i class="bi bi-ship display-5 text-muted"></i>
                        <h5 class="text-muted mt-3">
                            No cruise data yet.
                        </h5>
                    </div>

                @endif

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card admin-section-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Upcoming Bookings
                </h5>

                <small class="text-muted">
                    Nearest active schedules.
                </small>

            </div>

            <div class="card-body">

                @if($upcomingBookings->count() > 0)

                    @foreach($upcomingBookings as $booking)

                        <div class="mini-event">

                            <strong>
                                {{ $booking->cruise->cruise_name ?? 'Deleted Cruise' }}
                            </strong>

                            <br>

                            <small class="text-muted">
                                {{ $booking->user->name ?? 'Deleted User' }}
                            </small>

                            <div class="d-flex justify-content-between align-items-center mt-2">

                                <small>
                                    <i class="bi bi-calendar-event"></i>
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                </small>

                                @if($booking->booking_status === 'Pending')
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Approved
                                    </span>
                                @endif

                            </div>

                        </div>

                    @endforeach

                @else

                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x display-5 text-muted"></i>
                        <h5 class="text-muted mt-3">
                            No upcoming bookings.
                        </h5>
                    </div>

                @endif

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card admin-section-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Booking Logs Timeline
                </h5>

                <small class="text-muted">
                    Latest system activity.
                </small>

            </div>

            <div class="card-body">

                @if($recentLogs->count() > 0)

                    <div class="timeline">

                        @foreach($recentLogs as $log)

                            <div class="timeline-item">

                                <div class="timeline-dot"></div>

                                <h6 class="fw-bold mb-1">
                                    {{ $log->action }}
                                </h6>

                                <small class="text-muted d-block">
                                    {{ $log->customer_name }} — {{ $log->cruise_name }}
                                </small>

                                <small class="text-muted">
                                    {{ $log->created_at->diffForHumans() }}
                                </small>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="text-center py-5">
                        <i class="bi bi-clock-history display-5 text-muted"></i>
                        <h5 class="text-muted mt-3">
                            No logs yet.
                        </h5>
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection