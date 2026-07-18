@extends('customer.layouts.app')

@section('title', 'Edit Booking')

@section('content')

<style>
    .edit-hero {
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

    .edit-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .edit-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
    }

    .edit-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .edit-badge {
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

    .premium-form-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.09);
    }

    .premium-form-card .card-header {
        background: white;
        border-bottom: 1px solid #edf2f7;
        padding: 24px;
    }

    .premium-form-card .card-body {
        padding: 28px;
    }

    .form-section-title {
        font-weight: 900;
        color: #023e8a;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section-title i {
        width: 42px;
        height: 42px;
        border-radius: 15px;
        background: #e7f1ff;
        color: #0d6efd;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .form-label {
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        height: 48px;
        border-radius: 16px;
        border: 1px solid #dbe4ef;
        font-weight: 600;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #00b4d8;
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 216, 0.15);
    }

    .premium-time-input {
        position: relative;
    }

    .premium-time-icon {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: #0077b6;
        font-size: 20px;
        z-index: 2;
    }

    .premium-time-input input {
        padding-left: 48px;
        font-weight: 800;
        color: #023e8a;
        background: #f8fdff;
        border: 1px solid #d8f3ff;
    }

    .premium-time-input input:focus {
        background: #ffffff;
        border-color: #00b4d8;
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 216, 0.15);
    }

    .time-helper-box {
        border-radius: 18px;
        background: #f8fdff;
        border: 1px solid #d8f3ff;
        padding: 14px 16px;
        margin-top: 12px;
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
    }

    .side-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .side-card .card-body {
        padding: 24px;
    }

    .current-booking-card {
        background:
            radial-gradient(circle at top right, rgba(255, 214, 10, 0.20), transparent 32%),
            linear-gradient(135deg, #023e8a, #0077b6);
        color: white;
        border: none;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(0, 119, 182, 0.22);
    }

    .info-item {
        padding: 14px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid #edf2f7;
        margin-bottom: 12px;
    }

    .info-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .info-value {
        color: #1f2937;
        font-weight: 800;
    }

    .upload-box {
        border: 2px dashed #cfe2ff;
        border-radius: 24px;
        padding: 24px;
        background: #f8fbff;
        text-align: center;
    }

    .upload-icon {
        width: 75px;
        height: 75px;
        border-radius: 25px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        margin: 0 auto 14px;
    }

    .guide-item {
        display: flex;
        gap: 12px;
        padding: 14px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid #edf2f7;
        margin-bottom: 12px;
    }

    .guide-item i {
        color: #0077b6;
        font-size: 20px;
        flex-shrink: 0;
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

    .action-btn {
        height: 48px;
        border-radius: 16px;
        padding: 10px 18px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .sticky-submit-bar {
        position: sticky;
        bottom: 20px;
        z-index: 50;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px;
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid #edf2f7;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
        backdrop-filter: blur(10px);
    }

    .current-file-btn {
        border-radius: 50px;
        font-weight: 800;
    }

    @media (max-width: 768px) {
        .premium-form-card .card-header,
        .premium-form-card .card-body {
            padding: 20px;
        }

        .sticky-submit-bar {
            flex-direction: column-reverse;
        }

        .sticky-submit-bar .action-btn {
            width: 100%;
        }
    }
</style>

<div class="card edit-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="edit-badge">
                    <i class="bi bi-pencil-square"></i>
                    Pending Booking Edit
                </div>

                <h2 class="fw-bold mb-3">
                    Edit Your Booking
                </h2>

                <p class="mb-4 opacity-75">
                    You can update this booking while it is still pending. Change the cruise,
                    schedule, passenger count, contact details, or confirmation file.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-arrow-left"></i>
                        Back to My Bookings
                    </a>

                    <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-outline-light fw-bold">
                        <i class="bi bi-eye"></i>
                        View Booking
                    </a>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    ✏️
                </div>

                <h5 class="fw-bold mb-0">
                    Booking #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                </h5>

                <p class="mb-0 opacity-75">
                    Update pending reservation.
                </p>

            </div>

        </div>

    </div>

</div>

<form method="POST"
      action="{{ route('customer.bookings.update', $booking) }}"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card premium-form-card mb-4">

                <div class="card-header">

                    <h5 class="fw-bold mb-1">
                        Booking Information
                    </h5>

                    <small class="text-muted">
                        Update your cruise reservation details.
                    </small>

                </div>

                <div class="card-body">

                    <h6 class="form-section-title">
                        <i class="bi bi-ship"></i>
                        Cruise and Schedule
                    </h6>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="form-label">
                                Cruise
                            </label>

                            <select name="cruise_id"
                                    id="cruise_id"
                                    class="form-select @error('cruise_id') is-invalid @enderror"
                                    required>

                                <option value="">
                                    Select Cruise
                                </option>

                                @foreach($cruises as $cruise)

                                    <option value="{{ $cruise->id }}"
                                            data-departure-raw="{{ \Carbon\Carbon::parse($cruise->departure_date)->format('Y-m-d') }}"
                                            {{ old('cruise_id', $booking->cruise_id) == $cruise->id ? 'selected' : '' }}>

                                        {{ $cruise->cruise_name }} — {{ $cruise->destination }} — Slots: {{ $cruise->available_slots }}

                                    </option>

                                @endforeach

                            </select>

                            @error('cruise_id')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Passenger Count
                            </label>

                            <input type="number"
                                   name="passenger_count"
                                   class="form-control @error('passenger_count') is-invalid @enderror"
                                   value="{{ old('passenger_count', $booking->passenger_count) }}"
                                   min="1"
                                   required>

                            @error('passenger_count')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Booking Date
                            </label>

                            <input type="date"
                                   name="booking_date"
                                   id="booking_date"
                                   class="form-control @error('booking_date') is-invalid @enderror"
                                   value="{{ old('booking_date', \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d')) }}"
                                   min="{{ now()->format('Y-m-d') }}"
                                   required>

                            @error('booking_date')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Booking Time
                            </label>

                            <div class="premium-time-input">
                                <i class="bi bi-clock premium-time-icon"></i>

                                <input type="time"
                                       name="booking_time"
                                       class="form-control @error('booking_time') is-invalid @enderror"
                                       value="{{ old('booking_time', \Carbon\Carbon::parse($booking->booking_time)->format('H:i')) }}"
                                       required>
                            </div>

                            <div class="time-helper-box">
                                <i class="bi bi-info-circle"></i>
                                Choose any booking time within 24 hours. Same cruise, date, and time cannot be booked twice.
                            </div>

                            @error('booking_time')
                                <small class="text-danger d-block mt-2">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                    </div>

                    <h6 class="form-section-title">
                        <i class="bi bi-person-lines-fill"></i>
                        Contact Details
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">
                                Contact Number
                            </label>

                            <input type="text"
                                   name="contact_number"
                                   class="form-control @error('contact_number') is-invalid @enderror"
                                   value="{{ old('contact_number', $booking->contact_number) }}"
                                   placeholder="09XXXXXXXXX"
                                   required>

                            @error('contact_number')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Email Address
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $booking->email) }}"
                                   required>

                            @error('email')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                    </div>

                </div>

            </div>

            <div class="card premium-form-card mb-4">

                <div class="card-header">

                    <h5 class="fw-bold mb-1">
                        Confirmation File
                    </h5>

                    <small class="text-muted">
                        Upload a new file only if you want to replace your current confirmation file.
                    </small>

                </div>

                <div class="card-body">

                    <div class="upload-box">

                        <div class="upload-icon">
                            <i class="bi bi-file-earmark-arrow-up"></i>
                        </div>

                        @if($booking->confirmation_file)

                            <a href="{{ asset('storage/' . $booking->confirmation_file) }}"
                               target="_blank"
                               class="btn btn-outline-primary current-file-btn mb-3">

                                <i class="bi bi-eye"></i>
                                View Current File

                            </a>

                            <p class="text-muted mb-3">
                                Choose another file below if you want to replace it.
                            </p>

                        @else

                            <p class="fw-bold mb-1">
                                Upload Confirmation File
                            </p>

                            <small class="text-muted d-block mb-3">
                                PDF, JPG, JPEG, PNG up to 2MB
                            </small>

                        @endif

                        <input type="file"
                               name="confirmation_file"
                               class="form-control @error('confirmation_file') is-invalid @enderror"
                               accept=".pdf,.jpg,.jpeg,.png">

                        @error('confirmation_file')
                            <small class="text-danger d-block mt-2">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card current-booking-card mb-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-3">

                        <div class="display-6">
                            🧾
                        </div>

                        <div>
                            <h5 class="fw-bold mb-0">
                                Current Booking
                            </h5>

                            <small class="opacity-75">
                                #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                            </small>
                        </div>

                    </div>

                    <p class="mb-2 opacity-75">
                        Current Status
                    </p>

                    <span class="status-pill status-pending">
                        <i class="bi bi-clock-history"></i>
                        {{ $booking->booking_status }}
                    </span>

                    <hr class="border-light opacity-25">

                    <p class="mb-1 opacity-75">
                        Current Cruise
                    </p>

                    <h6 class="fw-bold mb-3">
                        {{ $booking->cruise->cruise_name ?? 'Deleted Cruise' }}
                    </h6>

                    <p class="mb-1 opacity-75">
                        Current Schedule
                    </p>

                    <h6 class="fw-bold mb-0">
                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                        •
                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                    </h6>

                </div>

            </div>

            <div class="card side-card mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Customer Guide
                    </h5>

                    <div class="guide-item">
                        <i class="bi bi-info-circle"></i>

                        <small>
                            Only pending bookings can be edited.
                        </small>
                    </div>

                    <div class="guide-item">
                        <i class="bi bi-calendar-x"></i>

                        <small>
                            A cruise date and time cannot be booked twice.
                        </small>
                    </div>

                    <div class="guide-item">
                        <i class="bi bi-calendar-check"></i>

                        <small>
                            Booking date must be on or before the selected cruise departure date.
                        </small>
                    </div>

                    <div class="guide-item mb-0">
                        <i class="bi bi-people"></i>

                        <small>
                            Passenger count must not exceed available cruise slots.
                        </small>
                    </div>

                </div>

            </div>

            <div class="card side-card mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Selected Details
                    </h5>

                    <div class="info-item">
                        <div class="info-label">
                            Editable Status
                        </div>

                        <div class="info-value">
                            Pending Only
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            File Types
                        </div>

                        <div class="info-value">
                            PDF, JPG, JPEG, PNG
                        </div>
                    </div>

                    <div class="info-item mb-0">
                        <div class="info-label">
                            Max File Size
                        </div>

                        <div class="info-value">
                            2 MB
                        </div>
                    </div>

                </div>

            </div>

            <div class="sticky-submit-bar">

                <a href="{{ route('customer.bookings.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-x-circle"></i>
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary action-btn">
                    <i class="bi bi-save"></i>
                    Update Booking
                </button>

            </div>

        </div>

    </div>

</form>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cruiseSelect = document.getElementById('cruise_id');
            const bookingDateInput = document.getElementById('booking_date');

            function showWarning(title, text) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: title,
                        text: text,
                        confirmButtonText: 'Choose Another Date',
                        confirmButtonColor: '#0d6efd',
                        background: '#ffffff',
                        color: '#1f2937'
                    });
                } else {
                    alert(text);
                }
            }

            function getSelectedCruiseDepartureDate() {
                const selectedOption = cruiseSelect.options[cruiseSelect.selectedIndex];

                if (!selectedOption || !selectedOption.value || !selectedOption.dataset.departureRaw) {
                    return null;
                }

                const departureDate = new Date(selectedOption.dataset.departureRaw + 'T00:00:00');
                departureDate.setHours(0, 0, 0, 0);

                return departureDate;
            }

            function validateBookingDate() {
                if (!bookingDateInput || !bookingDateInput.value) {
                    return;
                }

                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const selectedDate = new Date(bookingDateInput.value + 'T00:00:00');
                selectedDate.setHours(0, 0, 0, 0);

                const cruiseDepartureDate = getSelectedCruiseDepartureDate();

                if (selectedDate < today) {
                    bookingDateInput.value = '';

                    showWarning(
                        'Past Date Not Allowed',
                        'You cannot select a past date. Please choose today or a future date.'
                    );

                    return;
                }

                if (cruiseDepartureDate && selectedDate > cruiseDepartureDate) {
                    bookingDateInput.value = '';

                    showWarning(
                        'Date After Departure Not Allowed',
                        'You cannot book after the cruise departure date. Please select a date on or before the selected cruise departure date.'
                    );
                }
            }

            if (bookingDateInput) {
                bookingDateInput.addEventListener('change', validateBookingDate);
            }

            if (cruiseSelect) {
                cruiseSelect.addEventListener('change', validateBookingDate);
            }
        });
    </script>
@endpush