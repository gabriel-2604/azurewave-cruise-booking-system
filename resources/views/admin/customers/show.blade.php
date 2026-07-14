@extends('admin.layouts.app')

@section('title', 'Customer Details')

@section('content')

<style>
    .customer-hero {
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

    .customer-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .customer-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .customer-hero .card-body {
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

    .customer-big-avatar {
        width: 110px;
        height: 110px;
        border-radius: 34px;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 58px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.22);
        margin-left: auto;
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

    .booking-id {
        color: #023e8a;
        font-weight: 900;
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

    @media (max-width: 768px) {
        .customer-big-avatar {
            margin-left: 0;
            margin-top: 20px;
        }

        .premium-card .card-header,
        .premium-card .card-body {
            padding: 20px;
        }

        .table tbody td {
            padding: 14px;
        }
    }
</style>

<div class="card customer-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="hero-badge">
                    <i class="bi bi-person-lines-fill"></i>
                    Customer Profile Details
                </div>

                <h2 class="fw-bold mb-2">
                    {{ $customer->name }}
                </h2>

                <p class="mb-4 opacity-75">
                    View this customer account details, booking history, reservation status,
                    and cruise activity records.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('customers.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-arrow-left"></i>
                        Back to Customers
                    </a>

                    <a href="{{ route('bookings.index') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-calendar-check"></i>
                        Booking Management
                    </a>

                    <a href="{{ route('reports.index') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        Reports
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end">

                <div class="customer-big-avatar">
                    <i class="bi bi-person"></i>
                </div>

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

        <div class="card stat-card">

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

        <div class="card stat-card">

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

        <div class="card stat-card">

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
                    <i class="bi bi-slash-circle"></i>
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
                    Customer Information
                </h5>

                <small class="text-muted">
                    Account and contact details.
                </small>

            </div>

            <div class="card-body">

                <div class="info-item">
                    <div class="info-label">
                        Customer ID
                    </div>

                    <div class="info-value">
                        #{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        Full Name
                    </div>

                    <div class="info-value">
                        {{ $customer->name }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        Email Address
                    </div>

                    <div class="info-value">
                        {{ $customer->email }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        Phone Number
                    </div>

                    <div class="info-value">
                        {{ $customer->phone ?? 'No phone number provided' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        Account Role
                    </div>

                    <div class="info-value">
                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            {{ ucfirst($customer->role) }}
                        </span>
                    </div>
                </div>

                <div class="info-item mb-0">
                    <div class="info-label">
                        Joined Date
                    </div>

                    <div class="info-value">
                        {{ $customer->created_at->format('M d, Y') }}
                    </div>
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

                <a href="{{ route('bookings.index') }}" class="quick-link">
                    <i class="bi bi-calendar-check"></i>
                    <span>Manage Bookings</span>
                </a>

                <a href="{{ route('booking_logs.index') }}" class="quick-link">
                    <i class="bi bi-clock-history"></i>
                    <span>Booking Logs</span>
                </a>

                <a href="{{ route('calendar.index') }}" class="quick-link">
                    <i class="bi bi-calendar3"></i>
                    <span>Event Calendar</span>
                </a>

                <a href="{{ route('customers.index') }}" class="quick-link mb-0">
                    <i class="bi bi-people"></i>
                    <span>Customer List</span>
                </a>

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card premium-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        Customer Booking History
                    </h5>

                    <small class="text-muted">
                        All bookings created by this customer.
                    </small>
                </div>

                <a href="{{ route('bookings.create') }}" class="btn btn-primary fw-bold">
                    <i class="bi bi-plus-circle"></i>
                    Add Booking
                </a>

            </div>

            <div class="card-body p-0">

                @if($customer->bookings->count() > 0)

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead>
                                <tr>
                                    <th>Booking</th>
                                    <th>Cruise</th>
                                    <th>Schedule</th>
                                    <th>Passengers</th>
                                    <th>Status</th>
                                    <th width="90">View</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($customer->bookings as $booking)

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
                                            <a href="{{ route('bookings.show', $booking) }}"
                                               class="btn btn-info btn-sm action-btn"
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
                            This customer has not created any booking yet.
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