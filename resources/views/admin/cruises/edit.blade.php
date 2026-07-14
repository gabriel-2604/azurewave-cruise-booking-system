@extends('admin.layouts.app')

@section('title', 'Edit Cruise')

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
        padding: 22px;
        background: #f8fbff;
        text-align: center;
    }

    .current-image {
        width: 100%;
        height: 210px;
        object-fit: cover;
        border-radius: 22px;
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.12);
        margin-bottom: 16px;
    }

    .image-placeholder {
        width: 100%;
        height: 210px;
        border-radius: 22px;
        background: linear-gradient(135deg, #0077b6, #00b4d8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 62px;
        margin-bottom: 16px;
    }

    .guide-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
        height: 100%;
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
                    <i class="bi bi-pencil-square"></i>
                    Edit Cruise
                </div>

                <h2 class="fw-bold mb-3">
                    Update Cruise Schedule
                </h2>

                <p class="mb-4 opacity-75">
                    Modify cruise details, destination, departure schedule, passenger slots,
                    ticket price, image, and cruise status.
                </p>

                <a href="{{ route('cruises.index') }}" class="btn btn-light fw-bold">
                    <i class="bi bi-arrow-left"></i>
                    Back to Cruise Management
                </a>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🛳️
                </div>

                <h5 class="fw-bold mb-0">
                    Cruise Update
                </h5>

                <p class="mb-0 opacity-75">
                    Edit voyage details.
                </p>

            </div>

        </div>

    </div>

</div>

<form method="POST" action="{{ route('cruises.update', $cruise) }}" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card premium-form-card mb-4">

                <div class="card-header">

                    <h5 class="fw-bold mb-1">
                        Cruise Information
                    </h5>

                    <small class="text-muted">
                        Update the selected cruise record.
                    </small>

                </div>

                <div class="card-body">

                    <h6 class="form-section-title">
                        <i class="bi bi-ship"></i>
                        Basic Details
                    </h6>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="form-label">Cruise Name</label>
                            <input type="text" name="cruise_name" class="form-control" value="{{ old('cruise_name', $cruise->cruise_name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Destination</label>
                            <input type="text" name="destination" class="form-control" value="{{ old('destination', $cruise->destination) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Departure Port</label>
                            <input type="text" name="departure_port" class="form-control" value="{{ old('departure_port', $cruise->departure_port) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ticket Price</label>
                            <input type="number" step="0.01" min="0" name="ticket_price" class="form-control" value="{{ old('ticket_price', $cruise->ticket_price) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control">{{ old('description', $cruise->description) }}</textarea>
                        </div>

                    </div>

                    <h6 class="form-section-title">
                        <i class="bi bi-calendar-event"></i>
                        Schedule Details
                    </h6>

                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label class="form-label">Departure Date</label>
                            <input type="date" name="departure_date" class="form-control" value="{{ old('departure_date', $cruise->departure_date) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Departure Time</label>
                            <input type="time" name="departure_time" class="form-control" value="{{ old('departure_time', \Carbon\Carbon::parse($cruise->departure_time)->format('H:i')) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Arrival Date</label>
                            <input type="date" name="arrival_date" class="form-control" value="{{ old('arrival_date', $cruise->arrival_date) }}" required>
                        </div>

                    </div>

                    <h6 class="form-section-title">
                        <i class="bi bi-people"></i>
                        Capacity and Status
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Capacity</label>
                            <input type="number" min="1" name="capacity" class="form-control" value="{{ old('capacity', $cruise->capacity) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Available Slots</label>
                            <input type="number" min="0" name="available_slots" class="form-control" value="{{ old('available_slots', $cruise->available_slots) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Available" {{ old('status', $cruise->status) === 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Limited Slots" {{ old('status', $cruise->status) === 'Limited Slots' ? 'selected' : '' }}>Limited Slots</option>
                                <option value="Fully Booked" {{ old('status', $cruise->status) === 'Fully Booked' ? 'selected' : '' }}>Fully Booked</option>
                                <option value="Cancelled" {{ old('status', $cruise->status) === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card guide-card mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Cruise Image
                    </h5>

                    <div class="upload-box">

                        @if($cruise->image)

                            <img src="{{ asset('storage/' . $cruise->image) }}"
                                 alt="{{ $cruise->cruise_name }}"
                                 class="current-image">

                        @else

                            <div class="image-placeholder">
                                <i class="bi bi-ship"></i>
                            </div>

                        @endif

                        <p class="fw-bold mb-1">
                            Replace Cruise Image
                        </p>

                        <small class="text-muted d-block mb-3">
                            Leave empty to keep current image.
                        </small>

                        <input type="file" name="image" class="form-control" accept="image/*">

                    </div>

                </div>

            </div>

            <div class="card guide-card mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Admin Reminder
                    </h5>

                    <div class="guide-item">
                        <i class="bi bi-exclamation-triangle"></i>
                        <small>Changing available slots affects future customer booking availability.</small>
                    </div>

                    <div class="guide-item">
                        <i class="bi bi-slash-circle"></i>
                        <small>Cancelled cruises should not be used for new customer bookings.</small>
                    </div>

                    <div class="guide-item mb-0">
                        <i class="bi bi-check-circle"></i>
                        <small>Always check booking records before changing capacity.</small>
                    </div>

                </div>

            </div>

            <div class="d-flex gap-2 flex-wrap">

                <button type="submit" class="btn btn-primary action-btn">
                    <i class="bi bi-save"></i>
                    Update Cruise
                </button>

                <a href="{{ route('cruises.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-x-circle"></i>
                    Cancel
                </a>

            </div>

        </div>

    </div>

</form>

@endsection