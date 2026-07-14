@extends('customer.layouts.app')

@section('title', 'My Profile')

@section('content')

<style>
    .profile-hero {
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

    .profile-hero::after {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.13);
        right: -70px;
        top: -80px;
    }

    .profile-hero::before {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 214, 10, 0.18);
        right: 130px;
        bottom: -70px;
    }

    .profile-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .profile-badge {
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

    .profile-avatar {
        width: 110px;
        height: 110px;
        border-radius: 32px;
        background: linear-gradient(135deg, #0077b6, #00b4d8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        box-shadow: 0 18px 40px rgba(0, 119, 182, 0.28);
        margin: 0 auto 18px;
    }

    .account-info-item {
        border-radius: 18px;
        padding: 16px;
        background: #f8fdff;
        border: 1px solid #e5f7ff;
        margin-bottom: 14px;
    }

    .account-info-item small {
        color: #64748b;
        font-weight: 700;
        display: block;
        margin-bottom: 4px;
    }

    .account-info-item strong {
        color: #023e8a;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-icon {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        flex-shrink: 0;
    }

    .section-icon-green {
        background: #e8fff3;
        color: #198754;
    }

    .section-icon-red {
        background: #fff0f0;
        color: #dc3545;
    }

    .form-label {
        font-weight: 700;
        color: #344767;
    }

    .form-control {
        border-radius: 15px;
        padding: 13px 15px;
        border: 1px solid #dbe4ef;
    }

    .form-control:focus {
        border-color: #00b4d8;
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 216, 0.15);
    }

    .input-group-text {
        border-radius: 15px 0 0 15px;
        background: #f4fbff;
        border: 1px solid #dbe4ef;
        color: #0077b6;
    }

    .input-group .form-control {
        border-radius: 0 15px 15px 0;
    }

    .security-tip {
        border-radius: 20px;
        background: #fff8e1;
        border: 1px solid #ffe9a6;
        padding: 18px;
    }

    .security-tip i {
        color: #d89b00;
    }

    .quick-link-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        transition: 0.25s ease;
        height: 100%;
    }

    .quick-link-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.13);
    }

    .quick-icon {
        width: 58px;
        height: 58px;
        border-radius: 20px;
        background: #e7f1ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        margin-bottom: 14px;
    }
</style>

@php
    $user = auth()->user();

    $totalBookings = \App\Models\Booking::where('user_id', $user->id)->count();

    $activeBookings = \App\Models\Booking::where('user_id', $user->id)
        ->whereIn('booking_status', ['Pending', 'Approved'])
        ->count();

    $approvedBookings = \App\Models\Booking::where('user_id', $user->id)
        ->where('booking_status', 'Approved')
        ->count();

    $memberSince = $user->created_at ? $user->created_at->format('M d, Y') : 'N/A';
@endphp

<div class="card profile-hero mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="profile-badge">
                    <i class="bi bi-person-circle"></i>
                    Customer Profile
                </div>

                <h2 class="fw-bold mb-3">
                    Manage Your Account
                </h2>

                <p class="mb-4 opacity-75">
                    Update your personal information, keep your contact details accurate,
                    and secure your AzureWave Cruises account.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('customer.dashboard') }}" class="btn btn-light fw-bold">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-warning fw-bold">
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
                    👤
                </div>

                <h5 class="fw-bold mb-0">
                    Account Center
                </h5>

                <p class="mb-0 opacity-75">
                    Keep your profile updated.
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-4">

        <div class="card premium-card mb-4">

            <div class="card-body text-center">

                <div class="profile-avatar">
                    <i class="bi bi-person"></i>
                </div>

                <h4 class="fw-bold mb-1">
                    {{ $user->name }}
                </h4>

                <p class="text-muted mb-3">
                    Customer Account
                </p>

                <span class="badge bg-success px-3 py-2 rounded-pill">
                    <i class="bi bi-check-circle"></i>
                    Active
                </span>

            </div>

        </div>

        <div class="card premium-card mb-4">

            <div class="card-header">

                <h5 class="fw-bold mb-0">
                    Account Information
                </h5>

            </div>

            <div class="card-body">

                <div class="account-info-item">
                    <small>Full Name</small>
                    <strong>{{ $user->name }}</strong>
                </div>

                <div class="account-info-item">
                    <small>Email Address</small>
                    <strong>{{ $user->email }}</strong>
                </div>

                <div class="account-info-item">
                    <small>Phone Number</small>
                    <strong>{{ $user->phone ?? 'Not provided' }}</strong>
                </div>

                <div class="account-info-item">
                    <small>Member Since</small>
                    <strong>{{ $memberSince }}</strong>
                </div>

            </div>

        </div>

        <div class="row g-3">

            <div class="col-4">

                <div class="card quick-link-card">

                    <div class="card-body text-center p-3">

                        <h4 class="fw-bold text-primary mb-0">
                            {{ $totalBookings }}
                        </h4>

                        <small class="text-muted fw-semibold">
                            Total
                        </small>

                    </div>

                </div>

            </div>

            <div class="col-4">

                <div class="card quick-link-card">

                    <div class="card-body text-center p-3">

                        <h4 class="fw-bold text-info mb-0">
                            {{ $activeBookings }}
                        </h4>

                        <small class="text-muted fw-semibold">
                            Active
                        </small>

                    </div>

                </div>

            </div>

            <div class="col-4">

                <div class="card quick-link-card">

                    <div class="card-body text-center p-3">

                        <h4 class="fw-bold text-success mb-0">
                            {{ $approvedBookings }}
                        </h4>

                        <small class="text-muted fw-semibold">
                            Approved
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card premium-card mb-4">

            <div class="card-header">

                <div class="section-title">

                    <div class="section-icon section-icon-green">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">
                            Update Profile Information
                        </h5>

                        <small class="text-muted">
                            Update your name, phone number, and email address.
                        </small>
                    </div>

                </div>

            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('customer.profile.update') }}">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>

                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter full name"
                                       required>
                            </div>

                            @error('name')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Phone Number
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-telephone"></i>
                                </span>

                                <input type="text"
                                       name="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Enter phone number">
                            </div>

                            @error('phone')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Email Address
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter email address"
                                   required>
                        </div>

                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="bi bi-save"></i>
                        Save Profile Changes
                    </button>

                </form>

            </div>

        </div>

        <div class="card premium-card">

            <div class="card-header">

                <div class="section-title">

                    <div class="section-icon section-icon-red">
                        <i class="bi bi-shield-lock"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">
                            Change Password
                        </h5>

                        <small class="text-muted">
                            Keep your account safe by updating your password regularly.
                        </small>
                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="security-tip mb-4">

                    <div class="d-flex gap-2">

                        <i class="bi bi-info-circle"></i>

                        <small>
                            Use a strong password with letters, numbers, and symbols.
                            You must enter your current password before setting a new one.
                        </small>

                    </div>

                </div>

                <form method="POST" action="{{ route('customer.profile.password') }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">

                        <label class="form-label">
                            Current Password
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>

                            <input type="password"
                                   name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="Enter current password"
                                   required>
                        </div>

                        @error('current_password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                New Password
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-key"></i>
                                </span>

                                <input type="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Enter new password"
                                       required>
                            </div>

                            @error('password')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Confirm New Password
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-shield-check"></i>
                                </span>

                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       placeholder="Confirm new password"
                                       required>
                            </div>

                        </div>

                    </div>

                    <button type="submit" class="btn btn-danger fw-bold">
                        <i class="bi bi-shield-check"></i>
                        Update Password
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection