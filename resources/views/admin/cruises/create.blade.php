@extends('admin.layouts.app')

@section('title', 'Add Cruise')

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

    .form-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.10);
    }

    .form-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 150px;
        bottom: -70px;
        background: rgba(255, 214, 10, 0.16);
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

    textarea.form-control {
        height: auto;
        min-height: 130px;
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
        flex-shrink: 0;
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

<div class="card form-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="form-badge">
                    <i class="bi bi-plus-circle"></i>
                    Add New Cruise
                </div>

                <h2 class="fw-bold mb-3">
                    Create Cruise Schedule
                </h2>

                <p class="mb-4 opacity-75">
                    Add a new cruise package with destination, capacity, available slots,
                    ticket price, departure schedule, and status.
                </p>

                <a href="{{ route('cruises.index') }}" class="btn btn-light fw-bold">
                    <i class="bi bi-arrow-left"></i>
                    Back to Cruise Management
                </a>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🚢
                </div>

                <h5 class="fw-bold mb-0">
                    New Voyage
                </h5>

                <p class="mb-0 opacity-75">
                    Prepare a cruise schedule.
                </p>

            </div>

        </div>

    </div>

</div>

<form method="POST" action="{{ route('cruises.store') }}" enctype="multipart/form-data">

    @csrf

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card premium-form-card mb-4">

                <div class="card-header">

                    <h5 class="fw-bold mb-1">
                        Cruise Information
                    </h5>

                    <small class="text-muted">
                        Enter the basic cruise details.
                    </small>

                </div>

                <div class="card-body">

                    <h6 class="form-section-title">
                        <i class="bi bi-ship"></i>
                        Basic Details
                    </h6>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="form-label">
                                Cruise Name
                            </label>

                            <input type="text"
                                   name="cruise_name"
                                   class="form-control"
                                   value="{{ old('cruise_name') }}"
                                   placeholder="AzureWave Paradise Cruise"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Destination
                            </label>

                            <input type="text"
                                   name="destination"
                                   class="form-control"
                                   value="{{ old('destination') }}"
                                   placeholder="Boracay, Palawan, Cebu..."
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Departure Port
                            </label>

                            <input type="text"
                                   name="departure_port"
                                   class="form-control"
                                   value="{{ old('departure_port') }}"
                                   placeholder="Manila Port"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Ticket Price
                            </label>

                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="ticket_price"
                                   class="form-control"
                                   value="{{ old('ticket_price') }}"
                                   placeholder="2500.00"
                                   required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description"
                                      class="form-control"
                                      placeholder="Write a short cruise description...">{{ old('description') }}</textarea>
                        </div>

                    </div>

                    <h6 class="form-section-title">
                        <i class="bi bi-calendar-event"></i>
                        Schedule Details
                    </h6>

                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label class="form-label">
                                Departure Date
                            </label>

                            <input type="date"
                                   name="departure_date"
                                   class="form-control"
                                   value="{{ old('departure_date') }}"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Departure Time
                            </label>

                            <input type="time"
                                   name="departure_time"
                                   class="form-control"
                                   value="{{ old('departure_time') }}"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Arrival Date
                            </label>

                            <input type="date"
                                   name="arrival_date"
                                   class="form-control"
                                   value="{{ old('arrival_date') }}"
                                   required>
                        </div>

                    </div>

                    <h6 class="form-section-title">
                        <i class="bi bi-people"></i>
                        Capacity and Status
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">
                                Capacity
                            </label>

                            <input type="number"
                                   min="1"
                                   name="capacity"
                                   class="form-control"
                                   value="{{ old('capacity') }}"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Available Slots
                            </label>

                            <input type="number"
                                   min="0"
                                   name="available_slots"
                                   class="form-control"
                                   value="{{ old('available_slots') }}"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Status
                            </label>

                            <select name="status" class="form-select" required>
                                <option value="Available" {{ old('status') === 'Available' ? 'selected' : '' }}>
                                    Available
                                </option>

                                <option value="Limited Slots" {{ old('status') === 'Limited Slots' ? 'selected' : '' }}>
                                    Limited Slots
                                </option>

                                <option value="Fully Booked" {{ old('status') === 'Fully Booked' ? 'selected' : '' }}>
                                    Fully Booked
                                </option>

                                <option value="Cancelled" {{ old('status') === 'Cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
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
                        Cruise Image
                    </h5>

                    <div class="upload-box">

                        <div class="upload-icon">
                            <i class="bi bi-image"></i>
                        </div>

                        <p class="fw-bold mb-1">
                            Upload Cruise Image
                        </p>

                        <small class="text-muted d-block mb-3">
                            JPG, JPEG, PNG up to 2MB
                        </small>

                        <input type="file"
                               name="image"
                               class="form-control"
                               accept="image/*">

                    </div>

                </div>

            </div>

            <div class="card guide-card mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Admin Guide
                    </h5>

                    <div class="guide-item">
                        <i class="bi bi-check-circle"></i>

                        <small>
                            Capacity should be the total passenger limit of the cruise.
                        </small>
                    </div>

                    <div class="guide-item">
                        <i class="bi bi-info-circle"></i>

                        <small>
                            Available slots should not be greater than capacity.
                        </small>
                    </div>

                    <div class="guide-item mb-0">
                        <i class="bi bi-calendar-check"></i>

                        <small>
                            Cancelled cruises will not appear as available for customers.
                        </small>
                    </div>

                </div>

            </div>

            <div class="sticky-submit-bar">

                <a href="{{ route('cruises.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-x-circle"></i>
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary action-btn">
                    <i class="bi bi-save"></i>
                    Save Cruise
                </button>

            </div>

        </div>

    </div>

</form>

@endsection