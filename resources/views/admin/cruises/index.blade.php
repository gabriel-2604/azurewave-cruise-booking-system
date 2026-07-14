@extends('admin.layouts.app')

@section('title', 'Cruise Management')

@section('content')

<style>
    .cruise-hero {
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

    .cruise-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .cruise-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .cruise-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .cruise-badge {
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

    .cruise-stat-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .cruise-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
    }

    .cruise-stat-card::after {
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
        min-width: 280px;
    }

    .search-box i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
    }

    .search-box input {
        border-radius: 16px;
        padding: 12px 16px 12px 43px;
        border: 1px solid #dbe4ef;
        height: 46px;
    }

    .search-box input:focus {
        border-color: #00b4d8;
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 216, 0.15);
    }

    .search-btn,
    .add-cruise-btn {
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

    .cruise-image {
        width: 76px;
        height: 58px;
        border-radius: 18px;
        object-fit: cover;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
    }

    .cruise-image-placeholder {
        width: 76px;
        height: 58px;
        border-radius: 18px;
        background: linear-gradient(135deg, #0077b6, #00b4d8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
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

    .slot-pill {
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

    .price-text {
        color: #198754;
        font-weight: 900;
    }

    .action-btn {
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
        .search-box,
        .search-btn,
        .add-cruise-btn {
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
    $totalCruises = \App\Models\Cruise::count();
    $availableCruises = \App\Models\Cruise::where('status', 'Available')->count();
    $limitedCruises = \App\Models\Cruise::where('status', 'Limited Slots')->count();
    $fullyBookedCruises = \App\Models\Cruise::where('status', 'Fully Booked')->count();
@endphp

<div class="card cruise-hero mb-4">
    <div class="card-body p-4 p-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="cruise-badge">
                    <i class="bi bi-water"></i>
                    Admin Cruise Operations
                </div>

                <h2 class="fw-bold mb-3">
                    Cruise Management Center
                </h2>

                <p class="mb-4 opacity-75">
                    Add new cruise schedules, update destination details, monitor available slots,
                    manage ticket prices, and control cruise status from one admin panel.
                </p>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('cruises.create') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-plus-circle"></i>
                        Add New Cruise
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
                    🚢
                </div>

                <h5 class="fw-bold mb-0">
                    Fleet Control
                </h5>

                <p class="mb-0 opacity-75">
                    Manage cruise schedules.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card cruise-stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Total Cruises
                    </p>

                    <h2 class="fw-bold mb-0">
                        {{ $totalCruises }}
                    </h2>
                </div>

                <div class="stat-icon icon-blue">
                    <i class="bi bi-ship"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card cruise-stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Available
                    </p>

                    <h2 class="text-success fw-bold mb-0">
                        {{ $availableCruises }}
                    </h2>
                </div>

                <div class="stat-icon icon-green">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card cruise-stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Limited Slots
                    </p>

                    <h2 class="text-warning fw-bold mb-0">
                        {{ $limitedCruises }}
                    </h2>
                </div>

                <div class="stat-icon icon-yellow">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card cruise-stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Fully Booked
                    </p>

                    <h2 class="text-danger fw-bold mb-0">
                        {{ $fullyBookedCruises }}
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
                    Cruise Records
                </h5>

                <small class="text-muted">
                    Search, view, edit, or remove cruise schedules.
                </small>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <form method="GET" action="{{ route('cruises.index') }}" class="d-flex gap-2 flex-wrap">
                    <div class="search-box">
                        <i class="bi bi-search"></i>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="Search cruise or destination...">
                    </div>

                    <button class="btn btn-primary search-btn">
                        <i class="bi bi-search"></i>
                        Search
                    </button>

                    @if(request('search'))
                        <a href="{{ route('cruises.index') }}" class="btn btn-light search-btn">
                            <i class="bi bi-x-circle"></i>
                            Clear
                        </a>
                    @endif
                </form>

                <a href="{{ route('cruises.create') }}" class="btn btn-success add-cruise-btn">
                    <i class="bi bi-plus-circle"></i>
                    Add Cruise
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if($cruises->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Cruise</th>
                            <th>Destination</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Capacity</th>
                            <th>Slots</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th width="170">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cruises as $cruise)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($cruise->image)
                                            <img src="{{ asset('storage/' . $cruise->image) }}"
                                                 alt="{{ $cruise->cruise_name }}"
                                                 class="cruise-image">
                                        @else
                                            <div class="cruise-image-placeholder">
                                                <i class="bi bi-ship"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <strong>
                                                {{ $cruise->cruise_name }}
                                            </strong>

                                            <br>

                                            <small class="text-muted">
                                                <i class="bi bi-pin-map"></i>
                                                {{ $cruise->departure_port }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <strong>
                                        {{ $cruise->destination }}
                                    </strong>
                                </td>

                                <td>
                                    <strong>
                                        {{ \Carbon\Carbon::parse($cruise->departure_date)->format('M d, Y') }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i>
                                        {{ \Carbon\Carbon::parse($cruise->departure_time)->format('h:i A') }}
                                    </small>
                                </td>

                                <td>
                                    <strong>
                                        {{ \Carbon\Carbon::parse($cruise->arrival_date)->format('M d, Y') }}
                                    </strong>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-people"></i>
                                        {{ $cruise->capacity }}
                                    </span>
                                </td>

                                <td>
                                    <span class="slot-pill">
                                        <i class="bi bi-person-check"></i>
                                        {{ $cruise->available_slots }}
                                    </span>
                                </td>

                                <td>
                                    <span class="price-text">
                                        ₱{{ number_format($cruise->ticket_price, 2) }}
                                    </span>
                                </td>

                                <td>
                                    @switch($cruise->status)
                                        @case('Available')
                                            <span class="status-pill status-available">
                                                <i class="bi bi-check-circle"></i>
                                                Available
                                            </span>
                                            @break

                                        @case('Limited Slots')
                                            <span class="status-pill status-limited">
                                                <i class="bi bi-exclamation-triangle"></i>
                                                Limited
                                            </span>
                                            @break

                                        @case('Fully Booked')
                                            <span class="status-pill status-full">
                                                <i class="bi bi-x-circle"></i>
                                                Fully Booked
                                            </span>
                                            @break

                                        @case('Cancelled')
                                            <span class="status-pill status-cancelled">
                                                <i class="bi bi-slash-circle"></i>
                                                Cancelled
                                            </span>
                                            @break

                                        @default
                                            <span class="status-pill status-cancelled">
                                                Unknown
                                            </span>
                                    @endswitch
                                </td>

                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('cruises.show', $cruise) }}"
                                           class="btn btn-info btn-sm action-btn"
                                           title="View Cruise">

                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('cruises.edit', $cruise) }}"
                                           class="btn btn-warning btn-sm action-btn"
                                           title="Edit Cruise">

                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form method="POST"
                                              action="{{ route('cruises.destroy', $cruise) }}"
                                              class="confirm-action"
                                              data-title="Delete Cruise?"
                                              data-text="This cruise record will be permanently deleted. Existing related bookings may also be affected."
                                              data-icon="warning"
                                              data-confirm-text="Yes, Delete"
                                              data-confirm-color="#dc3545">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm action-btn"
                                                    title="Delete Cruise">

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
                {{ $cruises->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-ship"></i>
                </div>

                <h4 class="fw-bold">
                    No cruise records found
                </h4>

                <p class="text-muted mb-4">
                    Start by adding your first cruise schedule to the system.
                </p>

                <a href="{{ route('cruises.create') }}" class="btn btn-primary btn-lg fw-bold">
                    <i class="bi bi-plus-circle"></i>
                    Add First Cruise
                </a>
            </div>
        @endif
    </div>
</div>

@endsection