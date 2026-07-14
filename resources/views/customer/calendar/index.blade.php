@extends('customer.layouts.app')

@section('title', 'My Event Calendar')

@section('content')

<style>
    .calendar-hero {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 28px;
        color: white;
        background:
            linear-gradient(135deg, rgba(2, 62, 138, 0.93), rgba(0, 180, 216, 0.72)),
            url("{{ asset('images/hero.jpg') }}");
        background-size: cover;
        background-position: center;
        box-shadow: 0 22px 55px rgba(0, 119, 182, 0.22);
    }

    .calendar-hero::after {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.13);
        right: -70px;
        top: -80px;
    }

    .calendar-hero::before {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 214, 10, 0.18);
        right: 130px;
        bottom: -70px;
    }

    .calendar-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .calendar-badge {
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

    .calendar-stat-card {
        border: none;
        border-radius: 22px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        height: 100%;
    }

    .calendar-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.13);
    }

    .calendar-stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 19px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
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

    .calendar-main-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.09);
    }

    .calendar-main-card .card-header {
        background: white;
        border-bottom: 1px solid #edf2f7;
        padding: 24px;
    }

    .calendar-main-card .card-body {
        padding: 24px;
    }

    .legend-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        font-weight: 600;
    }

    .legend-dot {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        flex-shrink: 0;
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

    .instruction-box {
        border-radius: 20px;
        background: #f8fdff;
        border: 1px solid #e5f7ff;
        padding: 18px;
    }

    .instruction-box i {
        color: #0077b6;
    }

    #calendar {
        min-height: 650px;
    }

    .fc {
        font-family: 'Poppins', sans-serif;
    }

    .fc .fc-toolbar-title {
        font-weight: 800;
        color: #023e8a;
    }

    .fc .fc-button-primary {
        background: #0077b6;
        border-color: #0077b6;
        border-radius: 12px;
        font-weight: 600;
        text-transform: capitalize;
        box-shadow: none;
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
        font-weight: 600;
        text-decoration: none;
    }

    .fc .fc-col-header-cell-cushion {
        color: #023e8a;
        font-weight: 700;
        text-decoration: none;
    }

    .fc-event {
        border-radius: 10px !important;
        padding: 4px 6px !important;
        border: none !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        cursor: pointer;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.12);
    }

    .fc-day-today {
        background: #fff8e1 !important;
    }

    @media (max-width: 768px) {
        #calendar {
            min-height: 540px;
        }

        .fc .fc-toolbar {
            flex-direction: column;
            gap: 12px;
        }

        .fc .fc-toolbar-title {
            font-size: 20px;
        }
    }
</style>

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
@endphp

<div class="card calendar-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="calendar-badge">
                    <i class="bi bi-calendar3"></i>
                    Customer Event Calendar
                </div>

                <h2 class="fw-bold mb-3">
                    My Cruise Booking Calendar
                </h2>

                <p class="mb-4 opacity-75">
                    View your cruise reservations by date, check your booking status,
                    and open booking details directly from the calendar.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('customer.bookings.create') }}" class="btn btn-warning fw-bold">
                        <i class="bi bi-plus-circle"></i>
                        Create Booking
                    </a>

                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-list-check"></i>
                        My Bookings
                    </a>

                    <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🗓️
                </div>

                <h5 class="fw-bold mb-0">
                    Track Your Trip
                </h5>

                <p class="mb-0 opacity-75">
                    Booked dates in one place.
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

                    <h3 class="fw-bold mb-0">
                        {{ $totalBookings }}
                    </h3>
                </div>

                <div class="calendar-stat-icon icon-blue">
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
                        Active
                    </p>

                    <h3 class="text-info fw-bold mb-0">
                        {{ $activeBookings }}
                    </h3>
                </div>

                <div class="calendar-stat-icon icon-blue">
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
                        Pending
                    </p>

                    <h3 class="text-warning fw-bold mb-0">
                        {{ $pendingBookings }}
                    </h3>
                </div>

                <div class="calendar-stat-icon icon-yellow">
                    <i class="bi bi-clock-history"></i>
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

                    <h3 class="text-success fw-bold mb-0">
                        {{ $approvedBookings }}
                    </h3>
                </div>

                <div class="calendar-stat-icon icon-green">
                    <i class="bi bi-check-circle"></i>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-9">

        <div class="card calendar-main-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        Booking Calendar
                    </h5>

                    <small class="text-muted">
                        Click a calendar event to view full booking details.
                    </small>
                </div>

                <a href="{{ route('customer.bookings.create') }}" class="btn btn-primary">
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

            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">
                    Status Legend
                </h5>

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

        <div class="card legend-card">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">
                    Calendar Guide
                </h5>

                <div class="instruction-box mb-3">
                    <div class="d-flex gap-2">
                        <i class="bi bi-mouse"></i>
                        <small>
                            Click any booking event to open its booking details page.
                        </small>
                    </div>
                </div>

                <div class="instruction-box mb-3">
                    <div class="d-flex gap-2">
                        <i class="bi bi-calendar-plus"></i>
                        <small>
                            Use the New Booking button to reserve another cruise schedule.
                        </small>
                    </div>
                </div>

                <div class="instruction-box">
                    <div class="d-flex gap-2">
                        <i class="bi bi-info-circle"></i>
                        <small>
                            Pending and approved bookings are counted as active bookings.
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

                events: "{{ route('customer.calendar.events') }}",

                eventClick: function(info) {
                    if (info.event.id) {
                        window.location.href = "{{ url('/customer/bookings') }}/" + info.event.id;
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