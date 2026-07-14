@extends('admin.layouts.app')

@section('title', 'Customer Management')

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

    .customer-badge-hero {
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

    .customer-stat-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .customer-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
    }

    .customer-stat-card::after {
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

    .search-box {
        position: relative;
        width: 340px;
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

    .filter-btn {
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

    .table tbody tr {
        transition: 0.2s ease;
    }

    .table tbody tr:hover {
        background: #f8fdff;
    }

    .customer-avatar {
        width: 54px;
        height: 54px;
        border-radius: 19px;
        background: linear-gradient(135deg, #023e8a, #0077b6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
    }

    .customer-id {
        color: #023e8a;
        font-weight: 900;
    }

    .account-pill {
        border-radius: 50px;
        padding: 7px 13px;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #e8fff3;
        color: #137a42;
        white-space: nowrap;
    }

    .count-pill {
        border-radius: 50px;
        padding: 7px 13px;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .count-total {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .count-pending {
        background: #fff8e1;
        color: #9a6a00;
    }

    .count-approved {
        background: #e8fff3;
        color: #137a42;
    }

    .count-cancelled {
        background: #f1f5f9;
        color: #475569;
    }

    .action-btn {
        width: 38px;
        height: 38px;
        border-radius: 13px;
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
        .search-box,
        .filter-btn {
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

<div class="card customer-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="customer-badge-hero">
                    <i class="bi bi-people"></i>
                    Admin Customer Operations
                </div>

                <h2 class="fw-bold mb-3">
                    Customer Management Center
                </h2>

                <p class="mb-4 opacity-75">
                    View customer accounts, monitor booking activity, check customer reservation history,
                    and manage user-related booking records from one admin panel.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('bookings.index') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-calendar-check"></i>
                        Booking Management
                    </a>

                    <a href="{{ route('reports.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        Reports
                    </a>

                    <a href="{{ route('calendar.index') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-calendar3"></i>
                        Event Calendar
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    👥
                </div>

                <h5 class="fw-bold mb-0">
                    Customer Control
                </h5>

                <p class="mb-0 opacity-75">
                    Track accounts and bookings.
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card customer-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Total Customers
                    </p>

                    <h2 class="fw-bold mb-0">
                        {{ $totalCustomers }}
                    </h2>
                </div>

                <div class="stat-icon icon-blue">
                    <i class="bi bi-people"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card customer-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        With Bookings
                    </p>

                    <h2 class="text-success fw-bold mb-0">
                        {{ $customersWithBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-green">
                    <i class="bi bi-person-check"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card customer-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Customer Bookings
                    </p>

                    <h2 class="text-warning fw-bold mb-0">
                        {{ $totalCustomerBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-yellow">
                    <i class="bi bi-calendar-check"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card customer-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Pending Bookings
                    </p>

                    <h2 class="text-danger fw-bold mb-0">
                        {{ $pendingCustomerBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-red">
                    <i class="bi bi-clock-history"></i>
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
                    Customer Records
                </h5>

                <small class="text-muted">
                    Search customers and view their cruise booking history.
                </small>
            </div>

            <form method="GET" action="{{ route('customers.index') }}" class="d-flex gap-2 flex-wrap">

                <div class="search-box">

                    <i class="bi bi-search"></i>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search name, email, or phone...">

                </div>

                <button class="btn btn-primary filter-btn">
                    <i class="bi bi-search"></i>
                    Search
                </button>

                @if(request('search'))
                    <a href="{{ route('customers.index') }}" class="btn btn-light filter-btn">
                        <i class="bi bi-x-circle"></i>
                        Clear
                    </a>
                @endif

            </form>

        </div>

    </div>

    <div class="card-body">

        @if($customers->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Account</th>
                            <th>Total</th>
                            <th>Pending</th>
                            <th>Approved</th>
                            <th>Cancelled</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($customers as $customer)

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">

                                        <div class="customer-avatar">
                                            <i class="bi bi-person"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $customer->name }}
                                            </strong>

                                            <br>

                                            <small class="customer-id">
                                                #{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <strong>
                                        {{ $customer->email }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        <i class="bi bi-telephone"></i>
                                        {{ $customer->phone ?? 'No phone number' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="account-pill">
                                        <i class="bi bi-check-circle"></i>
                                        Active Customer
                                    </span>

                                    <br>

                                    <small class="text-muted">
                                        Joined {{ $customer->created_at->format('M d, Y') }}
                                    </small>
                                </td>

                                <td>
                                    <span class="count-pill count-total">
                                        <i class="bi bi-calendar-check"></i>
                                        {{ $customer->bookings_count }}
                                    </span>
                                </td>

                                <td>
                                    <span class="count-pill count-pending">
                                        <i class="bi bi-clock-history"></i>
                                        {{ $customer->pending_bookings_count }}
                                    </span>
                                </td>

                                <td>
                                    <span class="count-pill count-approved">
                                        <i class="bi bi-check-circle"></i>
                                        {{ $customer->approved_bookings_count }}
                                    </span>
                                </td>

                                <td>
                                    <span class="count-pill count-cancelled">
                                        <i class="bi bi-slash-circle"></i>
                                        {{ $customer->cancelled_bookings_count }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('customers.show', $customer) }}"
                                       class="btn btn-info btn-sm action-btn"
                                       title="View Customer">

                                        <i class="bi bi-eye"></i>

                                    </a>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="p-4 border-top">
                {{ $customers->links() }}
            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-people"></i>
                </div>

                <h4 class="fw-bold">
                    No customer records found
                </h4>

                <p class="text-muted mb-4">
                    No customers matched your current search.
                </p>

                <a href="{{ route('customers.index') }}" class="btn btn-primary btn-lg fw-bold">
                    <i class="bi bi-arrow-clockwise"></i>
                    Reset Search
                </a>

            </div>

        @endif

    </div>

</div>

@endsection