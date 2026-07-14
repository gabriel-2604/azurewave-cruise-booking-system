@extends('admin.layouts.app')

@section('title', 'Event Calendar')

@section('content')

<style>
    .calendar-hero {
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

    .calendar-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .calendar-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .calendar-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .calendar-badge {
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

    .calendar-stat-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .calendar-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
    }

    .calendar-stat-card::after {
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
        padding: 24px;
    }

    .legend-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .legend-card .card-header {
        background: white;
        border-bottom: 1px solid #edf2f7;
        padding: 20px 22px;
    }

    .legend-card .card-body {
        padding: 22px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        font-weight: 700;
    }

    .legend-dot {
        width: 17px;
        height: 17px;
        border-radius: 50%;
        flex-shrink: 0;
        box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.05);
    }

    .dot-pending {
        background: #ffc107;
    }

    .dot-approved {
        background: #198754;
    }

    .dot-completed {
        background: #0d6efd;
    }

    .dot-cancelled {
        background: #6c757d;
    }

    .guide-box {
        border-radius: 20px;
        background: #f8fdff;
        border: 1px solid #e5f7ff;
        padding: 16px;
        margin-bottom: 14px;
    }

    .guide-box i {
        color: #0077b6;
    }

    .quick-action-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid #edf2f7;
        color: #1f2937;
        text-decoration: none;
        font-weight: 700;
        transition: 0.22s ease;
        margin-bottom: 12px;
    }

    .quick-action-link:hover {
        background: #e7f1ff;
        border-color: #cfe2ff;
        color: #023e8a;
        transform: translateX(5px);
    }

    .quick-action-link i {
        width: 40px;
        height: 40px;
        border-radius: 15px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    #calendar {
        min-height: 720px;
    }

    .fc {
        font-family: 'Poppins', sans-serif;
    }

    .fc .fc-toolbar-title {
        font-weight: 900;
        color: #023e8a;
    }

    .fc .fc-button-primary {
        background: #0077b6;
        border-color: #0077b6;
        border-radius: 13px;
        font-weight: 700;
        text-transform: capitalize;
        box-shadow: none;
        padding: 8px 14px;
    }

    .fc .fc-button-primary:hover {
        background: #023e8a;
        border-color: #023e8a;
    }

    .fc .fc-button-primary:disabled {
        background: #90caf9;
        border-color: #90caf9;
    }

    .fc .fc-daygrid-day {
        transition: 0.2s ease;
    }

    .fc .fc-daygrid-day:hover {
        background: #f4fbff;
    }

    .fc .fc-daygrid-day-number {
        color: #344767;
        font-weight: 700;
        text-decoration: none;
    }

    .fc .fc-col-header-cell-cushion {
        color: #023e8a;
        font-weight: 800;
        text-decoration: none;
    }

    .fc-event {
        border-radius: 10px !important;
        padding: 4px 7px !important;
        border: none !important;
        font-size: 12px !important;
        font-weight: 800 !important;
        cursor: pointer;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.14);
    }

    .fc-day-today {
        background: #fff8e1 !important;
    }

    .calendar-note {
        border-radius: 20px;
        background: #fff8e1;
        border: 1px solid #ffe9a6;
        padding: 16px;
    }

    .calendar-note i {
        color: #d89b00;
    }

    @media (max-width: 768px) {
        #calendar {
            min-height: 560px;
        }

        .fc .fc-toolbar {
            flex-direction: column;
            gap: 12px;
        }

        .fc .fc-toolbar-title {
            font-size: 20px;
        }

        .premium-card .card-header {
            padding: 20px;
        }

        .premium-card .card-body {
            padding: 18px;
        }
    }
</style>

@php
    $totalBookings = \App\Models\Booking::count();

    $activeBookings = \App\Models\Booking::whereIn('booking_status', ['Pending', 'Approved'])
        ->count();

    $pendingBookings = \App\Models\Booking::where('booking_status', 'Pending')
        ->count();

    $approvedBookings = \App\Models\Booking::where('booking_status', 'Approved')
        ->count();

    $bookedDates = \App\Models\Booking::whereIn('booking_status', ['Pending', 'Approved', 'Completed'])
        ->distinct('booking_date')
        ->count('booking_date');
@endphp

<div class="card calendar-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="calendar-badge">
                    <i class="bi bi-calendar3"></i>
                    Admin Schedule Monitoring
                </div>

                <h2 class="fw-bold mb-3">
                    Admin Event Calendar
                </h2>

                <p class="mb-4 opacity-75">
                    View all customer cruise bookings in one calendar, monitor active schedules,
                    check booked dates, and prevent duplicate cruise reservations.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('bookings.index') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-calendar-check"></i>
                        Booking Management
                    </a>

                    <a href="{{ route('bookings.create') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-plus-circle"></i>
                        Add Booking
                    </a>

                    <a href="{{ route('reports.index') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        Reports
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🗓️
                </div>

                <h5 class="fw-bold mb-0">
                    Schedule Control
                </h5>

                <p class="mb-0 opacity-75">
                    Monitor booked cruise dates.
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card calendar-stat-card">

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

        <div class="card calendar-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Active Bookings
                    </p>

                    <h2 class="text-info fw-bold mb-0">
                        {{ $activeBookings }}
                    </h2>
                </div>

                <div class="stat-icon icon-blue">
                    <i class="bi bi-hourglass-split"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card calendar-stat-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <p class="text-muted fw-semibold mb-1">
                        Booked Dates
                    </p>

                    <h2 class="text-danger fw-bold mb-0">
                        {{ $bookedDates }}
                    </h2>
                </div>

                <div class="stat-icon icon-red">
                    <i class="bi bi-calendar-event"></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card calendar-stat-card">

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

</div>

<div class="row g-4">

    <div class="col-lg-9">

        <div class="card premium-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        Cruise Booking Calendar
                    </h5>

                    <small class="text-muted">
                        Click any booking event to open full booking details.
                    </small>
                </div>

                <a href="{{ route('bookings.create') }}" class="btn btn-primary fw-bold">
                    <i class="bi bi-calendar-plus"></i>
                    New Booking
                </a>

            </div>

            <div class="card-body">

                <div id="calendar"></div>

            </div>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="card legend-card mb-4">

            <div class="card-header">

                <h5 class="fw-bold mb-0">
                    Status Legend
                </h5>

            </div>

            <div class="card-body">

                <div class="legend-item">
                    <span class="legend-dot dot-pending"></span>
                    Pending
                </div>

                <div class="legend-item">
                    <span class="legend-dot dot-approved"></span>
                    Approved
                </div>

                <div class="legend-item">
                    <span class="legend-dot dot-completed"></span>
                    Completed
                </div>

                <div class="legend-item mb-0">
                    <span class="legend-dot dot-cancelled"></span>
                    Cancelled / Other
                </div>

            </div>

        </div>

        <div class="card legend-card mb-4">

            <div class="card-header">

                <h5 class="fw-bold mb-0">
                    Quick Actions
                </h5>

            </div>

            <div class="card-body">

                <a href="{{ route('bookings.index') }}" class="quick-action-link">
                    <i class="bi bi-calendar-check"></i>
                    <span>Booking Management</span>
                </a>

                <a href="{{ route('bookings.create') }}" class="quick-action-link">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add Booking</span>
                </a>

                <a href="{{ route('booking_logs.index') }}" class="quick-action-link">
                    <i class="bi bi-clock-history"></i>
                    <span>Booking Logs</span>
                </a>

                <a href="{{ route('reports.index') }}" class="quick-action-link mb-0">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Reports</span>
                </a>

            </div>

        </div>

        <div class="card legend-card">

            <div class="card-header">

                <h5 class="fw-bold mb-0">
                    Calendar Guide
                </h5>

            </div>

            <div class="card-body">

                <div class="guide-box">
                    <div class="d-flex gap-2">
                        <i class="bi bi-mouse"></i>
                        <small>
                            Click a calendar event to view full booking information.
                        </small>
                    </div>
                </div>

                <div class="guide-box">
                    <div class="d-flex gap-2">
                        <i class="bi bi-shield-check"></i>
                        <small>
                            Active bookings are Pending and Approved records.
                        </small>
                    </div>
                </div>

                <div class="calendar-note mb-0">
                    <div class="d-flex gap-2">
                        <i class="bi bi-info-circle"></i>
                        <small>
                            Booked schedules are used to prevent duplicate booking dates and times.
                        </small>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarElement = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarElement, {
                initialView: 'dayGridMonth',
                height: 'auto',
                nowIndicator: true,
                selectable: false,
                editable: false,
                eventDisplay: 'block',
                dayMaxEvents: 3,

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },

                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    list: 'List'
                },

                events: "{{ route('calendar.events') }}",

                eventClick: function(info) {
                    if (info.event.id) {
                        window.location.href = "{{ url('/bookings') }}/" + info.event.id;
                    }
                },

                eventDidMount: function(info) {
                    const title = info.event.title || 'Booking';

                    info.el.setAttribute('title', title);
                }
            });

            calendar.render();
        });
    </script>
@endpush