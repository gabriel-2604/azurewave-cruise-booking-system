@extends('customer.layouts.app')

@section('title', 'Create Booking')

@section('content')

<style>
    .booking-hero {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 28px;
        color: white;
        background:
            linear-gradient(135deg, rgba(2, 62, 138, 0.94), rgba(0, 180, 216, 0.72)),
            url("{{ asset('images/hero.jpg') }}");
        background-size: cover;
        background-position: center;
        box-shadow: 0 22px 55px rgba(0, 119, 182, 0.22);
    }

    .booking-hero::after {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.13);
        right: -70px;
        top: -80px;
    }

    .booking-hero::before {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 214, 10, 0.18);
        right: 130px;
        bottom: -70px;
    }

    .booking-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .booking-badge {
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

    .premium-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.09);
        overflow: hidden;
    }

    .premium-card .card-header {
        background: white;
        border-bottom: 1px solid #edf2f7;
        padding: 24px;
    }

    .premium-card .card-body {
        padding: 24px;
    }

    .form-label {
        font-weight: 700;
        color: #344767;
    }

    .form-control,
    .form-select {
        border-radius: 15px;
        padding: 13px 15px;
        border: 1px solid #dbe4ef;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #00b4d8;
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 216, 0.15);
    }

    .input-icon-box {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .section-title h5 {
        margin: 0;
        font-weight: 800;
        color: #023e8a;
    }

    .calendar-wrapper {
        border: 1px solid #edf2f7;
        border-radius: 24px;
        padding: 18px;
        background: #ffffff;
    }

    #bookingCalendar {
        min-height: 520px;
    }

    .selected-date-box {
        border-radius: 20px;
        background: #f8fdff;
        border: 1px solid #d8f3ff;
        padding: 18px;
        margin-top: 18px;
    }

    .upload-box {
        border: 2px dashed #b6e6f5;
        border-radius: 22px;
        padding: 22px;
        background: #f8fdff;
        transition: 0.2s ease;
    }

    .upload-box:hover {
        background: #effbff;
        border-color: #00b4d8;
    }

    .guide-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    }

    .guide-item {
        display: flex;
        gap: 12px;
        margin-bottom: 18px;
    }

    .guide-icon {
        width: 38px;
        height: 38px;
        border-radius: 14px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cruise-info-card {
        border: 1px solid #edf2f7;
        border-radius: 22px;
        background: #f8fdff;
        padding: 18px;
    }

    .fc {
        font-family: 'Poppins', sans-serif;
    }

    .fc .fc-toolbar-title {
        font-weight: 800;
        color: #023e8a;
        font-size: 22px;
    }

    .fc .fc-button-primary {
        background: #0077b6;
        border-color: #0077b6;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: none;
        text-transform: capitalize;
    }

    .fc .fc-button-primary:hover {
        background: #023e8a;
        border-color: #023e8a;
    }

    .fc .fc-daygrid-day-number {
        color: #344767;
        text-decoration: none;
        font-weight: 600;
    }

    .fc .fc-col-header-cell-cushion {
        color: #023e8a;
        text-decoration: none;
        font-weight: 700;
    }

    .fc-day-today {
        background: #fff8e1 !important;
    }

    .fc-daygrid-day:hover {
        background: #f4fbff;
        cursor: pointer;
    }

    .fc-event {
        border-radius: 10px !important;
        padding: 4px 6px !important;
        border: none !important;
        font-size: 12px !important;
        font-weight: 700 !important;
    }

    @media (max-width: 768px) {
        #bookingCalendar {
            min-height: 480px;
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

<div class="card booking-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="booking-badge">
                    <i class="bi bi-calendar-plus"></i>
                    Create Cruise Reservation
                </div>

                <h2 class="fw-bold mb-3">
                    Book Your Next Cruise Adventure
                </h2>

                <p class="mb-4 opacity-75">
                    Select a cruise, choose an available booking date, upload your confirmation file,
                    and submit your reservation for admin approval.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-list-check"></i>
                        My Bookings
                    </a>

                    <a href="{{ route('customer.calendar.index') }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-calendar3"></i>
                        My Calendar
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
                    Reserve. Sail. Enjoy.
                </p>

            </div>

        </div>

    </div>

</div>

<form method="POST"
      action="{{ route('customer.bookings.store') }}"
      enctype="multipart/form-data">

    @csrf

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card premium-card mb-4">

                <div class="card-header">

                    <div class="section-title mb-0">

                        <div class="input-icon-box">
                            <i class="bi bi-ship"></i>
                        </div>

                        <div>
                            <h5>
                                Cruise Details
                            </h5>

                            <small class="text-muted">
                                Choose your cruise schedule and passenger information.
                            </small>
                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <label class="form-label">
                            Select Cruise
                        </label>

                        <select name="cruise_id"
                                id="cruise_id"
                                class="form-select @error('cruise_id') is-invalid @enderror"
                                required>

                            <option value="">
                                Choose a cruise
                            </option>

                            @foreach($cruises as $cruise)

                                <option value="{{ $cruise->id }}"
                                        data-name="{{ $cruise->cruise_name }}"
                                        data-destination="{{ $cruise->destination }}"
                                        data-port="{{ $cruise->departure_port }}"
                                        data-date="{{ \Carbon\Carbon::parse($cruise->departure_date)->format('M d, Y') }}"
                                        data-time="{{ \Carbon\Carbon::parse($cruise->departure_time)->format('h:i A') }}"
                                        data-price="₱{{ number_format($cruise->ticket_price, 2) }}"
                                        data-slots="{{ $cruise->available_slots }}"
                                        {{ old('cruise_id') == $cruise->id ? 'selected' : '' }}>

                                    {{ $cruise->cruise_name }} — {{ $cruise->destination }} 
                                    ({{ $cruise->available_slots }} slots)

                                </option>

                            @endforeach

                        </select>

                        @error('cruise_id')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    <div id="selectedCruiseInfo" class="cruise-info-card mb-4 d-none">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <small class="text-muted fw-semibold">Cruise</small>
                                <div class="fw-bold" id="infoCruiseName">-</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted fw-semibold">Destination</small>
                                <div class="fw-bold" id="infoDestination">-</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted fw-semibold">Departure Port</small>
                                <div class="fw-bold" id="infoPort">-</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted fw-semibold">Ticket Price</small>
                                <div class="fw-bold text-success" id="infoPrice">-</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted fw-semibold">Departure Schedule</small>
                                <div class="fw-bold" id="infoSchedule">-</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted fw-semibold">Available Slots</small>
                                <div class="fw-bold text-primary" id="infoSlots">-</div>
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Number of Passengers
                            </label>

                            <input type="number"
                                   name="passenger_count"
                                   value="{{ old('passenger_count', 1) }}"
                                   min="1"
                                   class="form-control @error('passenger_count') is-invalid @enderror"
                                   placeholder="Enter passenger count"
                                   required>

                            @error('passenger_count')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Booking Time
                            </label>

                            <input type="time"
                                   name="booking_time"
                                   value="{{ old('booking_time') }}"
                                   class="form-control @error('booking_time') is-invalid @enderror"
                                   required>

                            @error('booking_time')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Contact Number
                            </label>

                            <input type="text"
                                   name="contact_number"
                                   value="{{ old('contact_number', auth()->user()->phone) }}"
                                   class="form-control @error('contact_number') is-invalid @enderror"
                                   placeholder="Enter contact number"
                                   required>

                            @error('contact_number')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter email address"
                                   required>

                            @error('email')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>

                    <div class="upload-box mt-3">

                        <label class="form-label">
                            Upload Confirmation File
                        </label>

                        <p class="text-muted small mb-3">
                            Upload payment proof, valid ID, or booking confirmation file.
                            Accepted formats: PDF, JPG, JPEG, PNG. Maximum size: 2MB.
                        </p>

                        <input type="file"
                               name="confirmation_file"
                               class="form-control @error('confirmation_file') is-invalid @enderror"
                               accept=".pdf,.jpg,.jpeg,.png">

                        @error('confirmation_file')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </div>

            <div class="card premium-card">

                <div class="card-header">

                    <div class="section-title mb-0">

                        <div class="input-icon-box">
                            <i class="bi bi-calendar3"></i>
                        </div>

                        <div>
                            <h5>
                                Select Booking Date
                            </h5>

                            <small class="text-muted">
                                Pick your desired booking date from the calendar.
                            </small>
                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <input type="hidden"
                           name="booking_date"
                           id="booking_date"
                           value="{{ old('booking_date') }}">

                    <div class="calendar-wrapper">

                        <div id="bookingCalendar"></div>

                    </div>

                    <div class="selected-date-box">

                        <small class="text-muted fw-semibold">
                            Selected Booking Date
                        </small>

                        <h5 class="fw-bold mb-0" id="selectedDateText">
                            {{ old('booking_date') ? \Carbon\Carbon::parse(old('booking_date'))->format('M d, Y') : 'No date selected yet' }}
                        </h5>

                    </div>

                    @error('booking_date')
                        <small class="text-danger d-block mt-2">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card guide-card mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Booking Guide
                    </h5>

                    <div class="guide-item">

                        <div class="guide-icon">
                            <i class="bi bi-1-circle"></i>
                        </div>

                        <div>
                            <h6 class="fw-bold mb-1">
                                Choose Cruise
                            </h6>

                            <small class="text-muted">
                                Select your preferred cruise destination and schedule.
                            </small>
                        </div>

                    </div>

                    <div class="guide-item">

                        <div class="guide-icon">
                            <i class="bi bi-2-circle"></i>
                        </div>

                        <div>
                            <h6 class="fw-bold mb-1">
                                Pick Date
                            </h6>

                            <small class="text-muted">
                                Select an available booking date from the calendar.
                            </small>
                        </div>

                    </div>

                    <div class="guide-item">

                        <div class="guide-icon">
                            <i class="bi bi-3-circle"></i>
                        </div>

                        <div>
                            <h6 class="fw-bold mb-1">
                                Submit Request
                            </h6>

                            <small class="text-muted">
                                Your booking will be marked as Pending until approved by admin.
                            </small>
                        </div>

                    </div>

                    <div class="alert alert-info mb-0">
                        <strong>Reminder:</strong>
                        Same cruise, date, and time cannot be booked twice.
                    </div>

                </div>

            </div>

            <div class="card guide-card">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Booking Summary
                    </h5>

                    <div class="mb-3">
                        <small class="text-muted fw-semibold">
                            Status After Submission
                        </small>

                        <div>
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted fw-semibold">
                            Account
                        </small>

                        <div class="fw-bold">
                            {{ auth()->user()->name }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted fw-semibold">
                            Email
                        </small>

                        <div class="fw-bold">
                            {{ auth()->user()->email }}
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">

                        <i class="bi bi-send-check"></i>

                        Submit Booking

                    </button>

                    <a href="{{ route('customer.bookings.index') }}"
                       class="btn btn-light w-100 mt-2 fw-bold">

                        Cancel

                    </a>

                </div>

            </div>

        </div>

    </div>

</form>

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cruiseSelect = document.getElementById('cruise_id');
            const selectedCruiseInfo = document.getElementById('selectedCruiseInfo');

            const infoCruiseName = document.getElementById('infoCruiseName');
            const infoDestination = document.getElementById('infoDestination');
            const infoPort = document.getElementById('infoPort');
            const infoPrice = document.getElementById('infoPrice');
            const infoSchedule = document.getElementById('infoSchedule');
            const infoSlots = document.getElementById('infoSlots');

            const bookingDateInput = document.getElementById('booking_date');
            const selectedDateText = document.getElementById('selectedDateText');
            const calendarElement = document.getElementById('bookingCalendar');

            function updateCruiseInfo() {
                const selectedOption = cruiseSelect.options[cruiseSelect.selectedIndex];

                if (!selectedOption || !selectedOption.value) {
                    selectedCruiseInfo.classList.add('d-none');
                    return;
                }

                infoCruiseName.textContent = selectedOption.dataset.name || '-';
                infoDestination.textContent = selectedOption.dataset.destination || '-';
                infoPort.textContent = selectedOption.dataset.port || '-';
                infoPrice.textContent = selectedOption.dataset.price || '-';
                infoSchedule.textContent = (selectedOption.dataset.date || '-') + ' at ' + (selectedOption.dataset.time || '-');
                infoSlots.textContent = (selectedOption.dataset.slots || '0') + ' slots available';

                selectedCruiseInfo.classList.remove('d-none');
            }

            updateCruiseInfo();

            const calendar = new FullCalendar.Calendar(calendarElement, {
                initialView: 'dayGridMonth',
                height: 'auto',
                selectable: true,
                editable: false,
                dayMaxEvents: 3,

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },

                buttonText: {
                    today: 'Today',
                    month: 'Month'
                },

                events: function(fetchInfo, successCallback, failureCallback) {
                    const cruiseId = cruiseSelect.value;

                    if (!cruiseId) {
                        successCallback([]);
                        return;
                    }

                    fetch("{{ route('customer.bookings.unavailable_dates') }}?cruise_id=" + cruiseId)
                        .then(response => response.json())
                        .then(events => successCallback(events))
                        .catch(error => failureCallback(error));
                },

                dateClick: function(info) {
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    const selectedDate = new Date(info.dateStr);
                    selectedDate.setHours(0, 0, 0, 0);

                    if (selectedDate < today) {
                        alert('You cannot select a past date.');
                        return;
                    }

                    bookingDateInput.value = info.dateStr;

                    const formattedDate = new Date(info.dateStr + 'T00:00:00').toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });

                    selectedDateText.textContent = formattedDate;

                    document.querySelectorAll('.fc-daygrid-day').forEach(day => {
                        day.style.outline = '';
                        day.style.backgroundColor = '';
                    });

                    info.dayEl.style.outline = '3px solid #00b4d8';
                    info.dayEl.style.backgroundColor = '#e6fbff';
                },

                eventClick: function(info) {
                    alert('This date already has a booking for the selected cruise schedule.');
                },

                eventDidMount: function(info) {
                    info.el.setAttribute('title', 'Unavailable schedule');
                }
            });

            calendar.render();

            cruiseSelect.addEventListener('change', function () {
                updateCruiseInfo();
                calendar.refetchEvents();
            });
        });
    </script>
@endpush