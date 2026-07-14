@extends('admin.layouts.app')

@section('title', 'Add Booking')

@section('content')

<style>
    .form-hero {
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

    .form-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .form-badge {
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

    .guide-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
    }

    .guide-card .card-body {
        padding: 24px;
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
    }

    .upload-box {
        border: 2px dashed #cfe2ff;
        border-radius: 24px;
        padding: 28px;
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

    .action-btn {
        height: 48px;
        border-radius: 16px;
        padding: 10px 18px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
</style>

<div class="card form-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="form-badge">
                    <i class="bi bi-plus-circle"></i>
                    Admin Booking Entry
                </div>

                <h2 class="fw-bold mb-3">
                    Create New Booking
                </h2>

                <p class="mb-4 opacity-75">
                    Add a booking manually for a customer, assign a cruise schedule,
                    upload confirmation proof, and set the booking status.
                </p>

                <a href="{{ route('bookings.index') }}" class="btn btn-light fw-bold">
                    <i class="bi bi-arrow-left"></i>
                    Back to Booking Management
                </a>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🧾
                </div>

                <h5 class="fw-bold mb-0">
                    New Reservation
                </h5>

                <p class="mb-0 opacity-75">
                    Add customer booking.
                </p>

            </div>

        </div>

    </div>

</div>

<form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data">

    @csrf

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card premium-form-card">

                <div class="card-header">

                    <h5 class="fw-bold mb-1">
                        Booking Information
                    </h5>

                    <small class="text-muted">
                        Complete the customer reservation details.
                    </small>

                </div>

                <div class="card-body">

                    <h6 class="form-section-title">
                        <i class="bi bi-person"></i>
                        Customer Details
                    </h6>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="form-label">Customer</label>

                            <select name="user_id" class="form-select" required>
                                <option value="">Select Customer</option>

                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} — {{ $customer->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>

                            <input type="text"
                                   name="contact_number"
                                   class="form-control"
                                   value="{{ old('contact_number') }}"
                                   placeholder="09XXXXXXXXX"
                                   required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Email Address</label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email') }}"
                                   placeholder="customer@email.com"
                                   required>
                        </div>

                    </div>

                    <h6 class="form-section-title">
                        <i class="bi bi-ship"></i>
                        Cruise and Schedule
                    </h6>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="form-label">Cruise</label>

                            <select name="cruise_id" class="form-select" required>
                                <option value="">Select Cruise</option>

                                @foreach($cruises as $cruise)
                                    <option value="{{ $cruise->id }}" {{ old('cruise_id') == $cruise->id ? 'selected' : '' }}>
                                        {{ $cruise->cruise_name }} — {{ $cruise->destination }} — Slots: {{ $cruise->available_slots }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Passenger Count</label>

                            <input type="number"
                                   name="passenger_count"
                                   class="form-control"
                                   value="{{ old('passenger_count', 1) }}"
                                   min="1"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Booking Date</label>

                            <input type="date"
                                   name="booking_date"
                                   class="form-control"
                                   value="{{ old('booking_date') }}"
                                   min="{{ now()->format('Y-m-d') }}"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Booking Time</label>

                            <input type="time"
                                   name="booking_time"
                                   class="form-control"
                                   value="{{ old('booking_time') }}"
                                   required>
                        </div>

                    </div>

                    <h6 class="form-section-title">
                        <i class="bi bi-shield-check"></i>
                        Status
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Booking Status</label>

                            <select name="booking_status" class="form-select" required>
                                <option value="Pending" {{ old('booking_status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ old('booking_status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Rejected" {{ old('booking_status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="Cancelled" {{ old('booking_status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="Completed" {{ old('booking_status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card guide-card mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Confirmation File
                    </h5>

                    <div class="upload-box">

                        <div class="upload-icon">
                            <i class="bi bi-file-earmark-arrow-up"></i>
                        </div>

                        <p class="fw-bold mb-1">
                            Upload Proof
                        </p>

                        <small class="text-muted d-block mb-3">
                            PDF, JPG, JPEG, PNG up to 2MB
                        </small>

                        <input type="file"
                               name="confirmation_file"
                               class="form-control"
                               accept=".pdf,.jpg,.jpeg,.png">

                    </div>

                </div>

            </div>

            <div class="card guide-card mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Admin Booking Guide
                    </h5>

                    <div class="guide-item">
                        <i class="bi bi-shield-check"></i>
                        <small>The system blocks duplicate cruise date and time schedules.</small>
                    </div>

                    <div class="guide-item">
                        <i class="bi bi-people"></i>
                        <small>Passenger count should not exceed the available cruise slots.</small>
                    </div>

                    <div class="guide-item mb-0">
                        <i class="bi bi-calendar-check"></i>
                        <small>Approved and pending bookings consume cruise slots.</small>
                    </div>

                </div>

            </div>

            <div class="d-flex gap-2 flex-wrap">

                <button type="submit" class="btn btn-primary action-btn">
                    <i class="bi bi-save"></i>
                    Save Booking
                </button>

                <a href="{{ route('bookings.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-x-circle"></i>
                    Cancel
                </a>

            </div>

        </div>

    </div>

</form>

@endsection