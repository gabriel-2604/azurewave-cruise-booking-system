@extends('admin.layouts.app')

@section('title', 'Booking Logs')

@section('content')

<style>
    .logs-hero {
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

    .logs-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .logs-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .logs-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .logs-badge {
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

    .logs-stat-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .logs-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
    }

    .logs-stat-card::after {
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

    .log-avatar {
        width: 50px;
        height: 50px;
        border-radius: 18px;
        background: linear-gradient(135deg, #023e8a, #0077b6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
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

    .log-id {
        color: #023e8a;
        font-weight: 900;
    }

    .action-pill {
        border-radius: 50px;
        padding: 7px 13px;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .action-created {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .action-updated {
        background: #fff8e1;
        color: #9a6a00;
    }

    .action-approved {
        background: #e8fff3;
        color: #137a42;
    }

    .action-rejected {
        background: #fff0f0;
        color: #b42318;
    }

    .action-cancelled {
        background: #f1f5f9;
        color: #475569;
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

    .performed-pill {
        border-radius: 50px;
        padding: 7px 13px;
        background: #eef2ff;
        color: #3730a3;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .date-box {
        border-radius: 16px;
        background: #f8fbff;
        border: 1px solid #edf2f7;
        padding: 10px 12px;
        display: inline-block;
        min-width: 120px;
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
    $totalLogs = \App\Models\BookingLog::count();

    $createdLogs = \App\Models\BookingLog::where('action', 'like', '%Created%')->count();

    $updatedLogs = \App\Models\BookingLog::where('action', 'like', '%Updated%')->count();

    $cancelledLogs = \App\Models\BookingLog::where('action', 'like', '%Cancelled%')->count();
@endphp

<div class="card logs-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="logs-badge">
                    <i class="bi bi-clock-history"></i>
                    Admin Activity Audit Trail
                </div>

                <h2 class="fw-bold mb-3">
                    Booking Logs Center
                </h2>

                <p class="mb-4 opacity-75">
                    Review all booking activities, track customer actions, monitor admin changes,
                    and keep a complete history of booking records.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('bookings.index') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-calendar-check"></i>
                        Booking Management
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
                    📜
                </div>

                <h5 class="fw-bold mb-0">
                    Audit Trail
                </h5>

                <p class="mb-0 opacity-75">
                    Track every booking action.
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card logs-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Total Logs
                    </p>

                    <h2 class="fw-bold mb-0">
                        {{ $totalLogs }}
                    </h2>
                </div>

                <div class="stat-icon icon-blue">
                    <i class="bi bi-journal-text"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card logs-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Created
                    </p>

                    <h2 class="text-primary fw-bold mb-0">
                        {{ $createdLogs }}
                    </h2>
                </div>

                <div class="stat-icon icon-blue">
                    <i class="bi bi-plus-circle"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card logs-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Updated
                    </p>

                    <h2 class="text-warning fw-bold mb-0">
                        {{ $updatedLogs }}
                    </h2>
                </div>

                <div class="stat-icon icon-yellow">
                    <i class="bi bi-pencil-square"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card logs-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Cancelled
                    </p>

                    <h2 class="text-danger fw-bold mb-0">
                        {{ $cancelledLogs }}
                    </h2>
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
                Booking Activity Logs
            </h5>

            <small class="text-muted">
                Complete record of customer and admin booking actions.
            </small>
        </div>

        <a href="{{ route('bookings.index') }}" class="btn btn-primary fw-bold">
            <i class="bi bi-calendar-check"></i>
            Manage Bookings
        </a>

    </div>

    <div class="card-body">

        @if($logs->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Log</th>
                            <th>Action</th>
                            <th>Customer</th>
                            <th>Cruise</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th>Performed By</th>
                            <th>Date Logged</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($logs as $log)

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">

                                        <div class="log-avatar">
                                            <i class="bi bi-clock-history"></i>
                                        </div>

                                        <div>
                                            <span class="log-id">
                                                #{{ str_pad($log->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>

                                            <br>

                                            <small class="text-muted">
                                                Booking ID:
                                                {{ $log->booking_id ?? 'Deleted' }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    @php
                                        $actionClass = 'action-created';
                                        $actionIcon = 'bi-info-circle';

                                        if (str_contains($log->action, 'Created')) {
                                            $actionClass = 'action-created';
                                            $actionIcon = 'bi-plus-circle';
                                        } elseif (str_contains($log->action, 'Updated')) {
                                            $actionClass = 'action-updated';
                                            $actionIcon = 'bi-pencil-square';
                                        } elseif (str_contains($log->action, 'Approved')) {
                                            $actionClass = 'action-approved';
                                            $actionIcon = 'bi-check-circle';
                                        } elseif (str_contains($log->action, 'Rejected')) {
                                            $actionClass = 'action-rejected';
                                            $actionIcon = 'bi-x-circle';
                                        } elseif (str_contains($log->action, 'Cancelled')) {
                                            $actionClass = 'action-cancelled';
                                            $actionIcon = 'bi-slash-circle';
                                        } elseif (str_contains($log->action, 'Deleted')) {
                                            $actionClass = 'action-rejected';
                                            $actionIcon = 'bi-trash';
                                        }
                                    @endphp

                                    <span class="action-pill {{ $actionClass }}">
                                        <i class="bi {{ $actionIcon }}"></i>
                                        {{ $log->action }}
                                    </span>
                                </td>

                                <td>
                                    <strong>
                                        {{ $log->customer_name }}
                                    </strong>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">

                                        <div class="cruise-avatar">
                                            <i class="bi bi-ship"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $log->cruise_name }}
                                            </strong>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <div class="date-box">

                                        <strong>
                                            {{ \Carbon\Carbon::parse($log->booking_date)->format('M d, Y') }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i>
                                            {{ \Carbon\Carbon::parse($log->booking_time)->format('h:i A') }}
                                        </small>

                                    </div>
                                </td>

                                <td>
                                    @switch($log->booking_status)

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
                                    <span class="performed-pill">
                                        <i class="bi bi-person-check"></i>
                                        {{ $log->performed_by }}
                                    </span>
                                </td>

                                <td>
                                    <strong>
                                        {{ $log->created_at->format('M d, Y') }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        {{ $log->created_at->format('h:i A') }}
                                    </small>

                                    <br>

                                    <small class="text-muted">
                                        {{ $log->created_at->diffForHumans() }}
                                    </small>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="p-4 border-top">
                {{ $logs->links() }}
            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <h4 class="fw-bold">
                    No booking logs yet
                </h4>

                <p class="text-muted mb-4">
                    Booking activity records will appear here after customers or admins create, update, approve, reject, cancel, or delete bookings.
                </p>

                <a href="{{ route('bookings.index') }}" class="btn btn-primary btn-lg fw-bold">
                    <i class="bi bi-calendar-check"></i>
                    Go to Booking Management
                </a>

            </div>

        @endif

    </div>

</div>

@endsection