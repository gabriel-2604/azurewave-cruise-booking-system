@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')

<style>
    .reports-hero {
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

    .reports-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .reports-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .reports-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .reports-badge {
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

    .report-stat-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .report-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
    }

    .report-stat-card::after {
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

    .icon-cyan {
        background: #e6fbff;
        color: #0dcaf0;
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

    .revenue-card {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 28px;
        color: white;
        background:
            radial-gradient(circle at top right, rgba(255, 214, 10, 0.28), transparent 30%),
            linear-gradient(135deg, #064e3b, #198754);
        box-shadow: 0 18px 45px rgba(25, 135, 84, 0.25);
    }

    .revenue-card::after {
        content: "₱";
        position: absolute;
        right: 25px;
        bottom: -45px;
        font-size: 10rem;
        font-weight: 900;
        opacity: 0.13;
    }

    .revenue-card .card-body {
        position: relative;
        z-index: 2;
        padding: 30px;
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

    .progress {
        height: 12px;
        border-radius: 50px;
        background: #edf2f7;
    }

    .progress-bar {
        border-radius: 50px;
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

    .count-pill {
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

    .quick-report-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid #edf2f7;
        color: #1f2937;
        text-decoration: none;
        font-weight: 700;
        transition: 0.22s ease;
        margin-bottom: 12px;
    }

    .quick-report-link:hover {
        background: #e7f1ff;
        border-color: #cfe2ff;
        color: #023e8a;
        transform: translateX(5px);
    }

    .quick-report-link i {
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

    .empty-state {
        padding: 55px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 85px;
        height: 85px;
        border-radius: 28px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 20px;
    }

    @media (max-width: 768px) {
        .premium-card .card-header {
            padding: 20px;
        }

        .premium-card .card-body {
            padding: 18px;
        }

        .table tbody td {
            padding: 14px;
        }
    }
</style>

@php
    $statusTotal = max($totalBookings, 1);

    $pendingPercent = ($pendingBookings / $statusTotal) * 100;
    $approvedPercent = ($approvedBookings / $statusTotal) * 100;
    $rejectedPercent = ($rejectedBookings / $statusTotal) * 100;
    $cancelledPercent = ($cancelledBookings / $statusTotal) * 100;
    $completedPercent = ($completedBookings / $statusTotal) * 100;
@endphp

<div class="card reports-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="reports-badge">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    Admin Analytics and Reports
                </div>

                <h2 class="fw-bold mb-3">
                    Reports Dashboard
                </h2>

                <p class="mb-4 opacity-75">
                    Review booking statistics, customer activity, cruise performance,
                    and estimated revenue generated from approved and completed bookings.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('bookings.index') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-calendar-check"></i>
                        Booking Management
                    </a>

                    <a href="{{ route('cruises.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-water"></i>
                        Cruise Management
                    </a>

                    <a href="{{ route('calendar.index') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-calendar3"></i>
                        Event Calendar
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    📊
                </div>

                <h5 class="fw-bold mb-0">
                    Analytics Center
                </h5>

                <p class="mb-0 opacity-75">
                    Monitor system performance.
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card report-stat-card">

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

        <div class="card report-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Total Customers
                    </p>

                    <h2 class="text-success fw-bold mb-0">
                        {{ $totalCustomers }}
                    </h2>
                </div>

                <div class="stat-icon icon-green">
                    <i class="bi bi-people"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card report-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Total Cruises
                    </p>

                    <h2 class="text-info fw-bold mb-0">
                        {{ $totalCruises }}
                    </h2>
                </div>

                <div class="stat-icon icon-cyan">
                    <i class="bi bi-ship"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card report-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Active Bookings
                    </p>

                    <h2 class="text-warning fw-bold mb-0">
                        {{ $pendingBookings + $approvedBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-yellow">
                    <i class="bi bi-hourglass-split"></i>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-lg-4">

        <div class="card revenue-card h-100">

            <div class="card-body">

                <p class="mb-2 opacity-75 fw-semibold">
                    Estimated Revenue
                </p>

                <h1 class="fw-bold mb-3">
                    ₱{{ number_format($estimatedRevenue, 2) }}
                </h1>

                <p class="mb-4 opacity-75">
                    Revenue is calculated from approved and completed bookings only.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <span class="badge bg-light text-success px-3 py-2 rounded-pill">
                        <i class="bi bi-check-circle"></i>
                        Approved
                    </span>

                    <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                        <i class="bi bi-flag"></i>
                        Completed
                    </span>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-5">

        <div class="card premium-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Booking Status Report
                </h5>

                <small class="text-muted">
                    Current distribution of booking statuses.
                </small>

            </div>

            <div class="card-body">

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Pending</span>
                        <span>{{ $pendingBookings }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: {{ $pendingPercent }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Approved</span>
                        <span>{{ $approvedBookings }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ $approvedPercent }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Rejected</span>
                        <span>{{ $rejectedBookings }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: {{ $rejectedPercent }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
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

    <div class="col-lg-3">

        <div class="card premium-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Quick Actions
                </h5>

                <small class="text-muted">
                    Report navigation.
                </small>

            </div>

            <div class="card-body">

                <a href="{{ route('bookings.index') }}" class="quick-report-link">
                    <i class="bi bi-calendar-check"></i>
                    Bookings
                </a>

                <a href="{{ route('cruises.index') }}" class="quick-report-link">
                    <i class="bi bi-water"></i>
                    Cruises
                </a>

                <a href="{{ route('customers.index') }}" class="quick-report-link">
                    <i class="bi bi-people"></i>
                    Customers
                </a>

                <a href="{{ route('booking_logs.index') }}" class="quick-report-link mb-0">
                    <i class="bi bi-clock-history"></i>
                    Logs
                </a>

            </div>

        </div>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-5">

        <div class="card premium-card">

            <div class="card-header">

                <h5 class="fw-bold mb-1">
                    Top Booked Cruises
                </h5>

                <small class="text-muted">
                    Cruise schedules ranked by booking count.
                </small>

            </div>

            <div class="card-body p-0">

                @if($topCruises->count() > 0)

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead>
                                <tr>
                                    <th>Cruise</th>
                                    <th>Destination</th>
                                    <th>Bookings</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($topCruises as $cruise)

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">

                                                <div class="cruise-avatar">
                                                    <i class="bi bi-ship"></i>
                                                </div>

                                                <div>
                                                    <strong>
                                                        {{ $cruise->cruise_name }}
                                                    </strong>

                                                    <br>

                                                    <small class="text-muted">
                                                        ₱{{ number_format($cruise->ticket_price, 2) }}
                                                    </small>
                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            {{ $cruise->destination }}
                                        </td>

                                        <td>
                                            <span class="count-pill">
                                                <i class="bi bi-calendar-check"></i>
                                                {{ $cruise->bookings_count }}
                                            </span>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-ship"></i>
                        </div>

                        <h5 class="fw-bold">
                            No cruise report yet
                        </h5>

                        <p class="text-muted mb-0">
                            Cruise ranking will appear after bookings are created.
                        </p>
                    </div>

                @endif

            </div>

        </div>

    </div>

    <div class="col-lg-7">

        <div class="card premium-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        Recent Booking Activity
                    </h5>

                    <small class="text-muted">
                        Latest reservations included in system reports.
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
                                    <th width="80">View</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($recentBookings as $booking)

                                    <tr>
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

                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-calendar-x"></i>
                        </div>

                        <h5 class="fw-bold">
                            No recent bookings yet
                        </h5>

                        <p class="text-muted mb-0">
                            Recent activity will appear after customers create bookings.
                        </p>
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection